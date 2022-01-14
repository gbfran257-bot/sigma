<?php
date_default_timezone_set('Mexico/General');
$now = date('His');
require("../../../Connections/horizonte.php");
require("../../../funciones/php/values.php");

	//primero tenemos que saber si existe su tabulador, sino entnces escogemos el tabulador base
	$tabu = $_GET['idSucursal'].'_precio'; $resultT = mysql_query("SHOW COLUMNS FROM conceptos LIKE '$tabu' ");
	$existsT = (mysql_num_rows($resultT))?TRUE:FALSE;
	if($existsT) {
		$precio_nor = $_GET['idSucursal'].'_precio'; $precio_ur = $_GET['idSucursal'].'_precio_u';
		$precio_nor_me = $_GET['idSucursal'].'_precio_mem'; $precio_ur_me = $_GET['idSucursal'].'_precio_mem_u';
	}else{
		$precio_nor = 'e.precio_to'; $precio_ur = 'e.precio_urgencia_to';
		$precio_nor_me = 'e.precio_membrecia_to'; $precio_ur_me = 'e.precio_membrecia1';
	}
	//Luego sacamos el día actual, y la hora actual
	$dia_actual = sqlValue(date('N'), "int"); $hora_actual = sqlValue(date('G:i'), "date"); $urgencia = '';
		
	switch($dia_actual){
		case 1://Lunes
			mysql_select_db($database_horizonte, $horizonte);
			$resultHl = mysql_query("SELECT count(id_su), no_temp_su from sucursales where horario_e_lu <= $hora_actual and horario_s_lu >= $hora_actual and id_su = '$_GET[idSucursal]' ",$horizonte) or die (mysql_error()); $rowHl = mysql_fetch_row($resultHl);
			if($rowHl[0]>0){$urgencia=0;}else{$urgencia=1;}
		break;
		case 2:
			mysql_select_db($database_horizonte, $horizonte);
			$resultHl = mysql_query("SELECT count(id_su), no_temp_su from sucursales where horario_e_ma <= $hora_actual and horario_s_ma >= $hora_actual and id_su = '$_GET[idSucursal]' ", $horizonte) or die (mysql_error()); $rowHl = mysql_fetch_row($resultHl); if($rowHl[0]>0){$urgencia=0;}else{$urgencia=1;}
		break;
		case 3:
			mysql_select_db($database_horizonte, $horizonte);
			$resultHl = mysql_query("SELECT count(id_su), no_temp_su from sucursales where horario_e_mi <= $hora_actual and horario_s_mi >= $hora_actual and id_su = '$_GET[idSucursal]' ", $horizonte) or die (mysql_error()); $rowHl = mysql_fetch_row($resultHl); if($rowHl[0]>0){$urgencia=0;}else{$urgencia=1;}
		break;
		case 4:
			mysql_select_db($database_horizonte, $horizonte);
			$resultHl = mysql_query("SELECT count(id_su), no_temp_su from sucursales where horario_e_ju <= $hora_actual and horario_s_ju >= $hora_actual and id_su = '$_GET[idSucursal]' ", $horizonte) or die (mysql_error()); $rowHl = mysql_fetch_row($resultHl); if($rowHl[0]>0){$urgencia=0;}else{$urgencia=1;}
		break;
		case 5:
			mysql_select_db($database_horizonte, $horizonte);
			$resultHl = mysql_query("SELECT count(id_su), no_temp_su from sucursales where horario_e_vi <= $hora_actual and horario_s_vi >= $hora_actual and id_su = '$_GET[idSucursal]' ", $horizonte) or die (mysql_error()); $rowHl = mysql_fetch_row($resultHl); if($rowHl[0]>0){$urgencia=0;}else{$urgencia=1;}
		break;
		case 6:
			mysql_select_db($database_horizonte, $horizonte);
			$resultHl = mysql_query("SELECT count(id_su), no_temp_su from sucursales where horario_e_sa <= $hora_actual and horario_s_sa >= $hora_actual and id_su = '$_GET[idSucursal]' ", $horizonte) or die (mysql_error()); $rowHl = mysql_fetch_row($resultHl); if($rowHl[0]>0){$urgencia=0;}else{$urgencia=1;}
		break;
		case 7://Domingo
			mysql_select_db($database_horizonte, $horizonte);
			$resultHl = mysql_query("SELECT count(id_su), no_temp_su from sucursales where horario_e_do <= $hora_actual and horario_s_do >= $hora_actual and id_su = '$_GET[idSucursal]' ", $horizonte) or die (mysql_error()); $rowHl = mysql_fetch_row($resultHl); if($rowHl[0]>0){$urgencia=0;}else{$urgencia=1;}
		break;
		default: $urgencia=0; $rowHl[1] = '000000000';
	}
	
	if(isset($_GET['idSucursal']) && !empty($_GET['idSucursal'])){
		$idSucu = $_GET['idSucursal'];
	}else{
		$idSucu = 0;
	}
	//Checamos si tiene membresía el paciente y si está vigente
	mysql_select_db($database_horizonte, $horizonte);
	$resultMeV = mysql_query("SELECT count(id_me) from membresias where id_paciente_me = '$_GET[idP]'", $horizonte) or die (mysql_error());
	$rowMeV = mysql_fetch_row($resultMeV); $con_membresia = 0;

	if($rowMeV[0]>0){//Tiene membresía
		mysql_select_db($database_horizonte, $horizonte);
		$resultMe = mysql_query("SELECT DATEDIFF(fecha_f_me, fecha_i_me) from membresias where id_paciente_me = '$_GET[idP]' order by id_me desc limit 1 ", $horizonte) or die (mysql_error()); $rowMe = mysql_fetch_row($resultMe); //echo $_GET['idP'];

		if($rowMe[0]>0){//Está Vigente
			$con_membresia++;
		}else{}
	}else{}

	if($con_membresia>0){//Tiene membresía vigente
		if($urgencia==1){//Nocturno
			$aColumns = array('e.concepto_to', 'a.nombre_a', 'e.precio_mu', 'c.convenio_cv', 'e.id_to', 'c.id_cv' );
		}else{
			$aColumns = array('e.concepto_to', 'a.nombre_a', 'e.precio_m', 'c.convenio_cv', 'e.id_to', 'c.id_cv' );
		}
		// DB tables to use 
		$aTables = array( 'conceptos e');
		// Indexed column (used for fast and accurate table cardinality) 
		$sIndexColumn = "e.id_to";
		 // Joins   
		$sJoin = 'left join areas a on a.id_a = e.id_area_to left join convenios c on c.id_cv = e.id_convenio_to left join stock_has_bach s on s.id_Producto = e.id_to left join stock s1 on s.id_stock = s1.id';
		// CONDITIONS
		$lista = '0';
		mysql_select_db($database_horizonte, $horizonte);
		$consulta = "SELECT v.id_concepto_es from venta_conceptos v left join conceptos c on c.id_to = v.id_concepto_es where v.no_temp_vc = '$_GET[aleatorio]' and c.id_tipo_concepto_to = 5 ";
		$query = mysql_query($consulta) or die (mysql_error());
		while ($fila = mysql_fetch_array($query)) {
			$lista = $lista.','.$fila['id_concepto_es'];
		};//echo $lista;
		$sWhere = "WHERE e.id_tipo_concepto_to = 5 and s.existencias > 0 and s1.id_su = $idSucu GROUP by e.concepto_to asc";
	}else{
		if($_GET['idConvenio']==0){//Sin convenios
			if($urgencia==1){//Nocturno
				$aColumns = array('e.concepto_to', 'a.nombre_a', $precio_ur, 'c.convenio_cv', 'e.id_to', 'c.id_cv' );
			}else{
				$aColumns = array('e.concepto_to', 'a.nombre_a', $precio_nor, 'c.convenio_cv', 'e.id_to', 'c.id_cv' );
			}
			// DB tables to use 
			$aTables = array( 'conceptos e');
			// Indexed column (used for fast and accurate table cardinality) 
			$sIndexColumn = "e.id_to";
			 // Joins   
			$sJoin = 'left join areas a on a.id_a = e.id_area_to left join convenios c on c.id_cv = e.id_convenio_to left join stock_has_bach s on s.id_Producto = e.id_to left join stock s1 on s.id_stock = s1.id';
			// CONDITIONS
			$lista = '0';
			mysql_select_db($database_horizonte, $horizonte);
			$consulta = "SELECT v.id_concepto_es from venta_conceptos v left join conceptos c on c.id_to = v.id_concepto_es where v.no_temp_vc = '$_GET[aleatorio]' and c.id_tipo_concepto_to = 5 ";
			$query = mysql_query($consulta) or die (mysql_error());
			while ($fila = mysql_fetch_array($query)) {
				$lista = $lista.','.$fila['id_concepto_es'];
			};//echo $lista;
			$sWhere = "WHERE e.id_tipo_concepto_to = 5 and s.existencias > 0 and s1.id_su = $idSucu";
		}
		else{//Con algún convenio
			if($urgencia==1){
				$aColumns = array('c.concepto_to', 'a.nombre_a', 'acc.precio_urgencia_ac','cv.convenio_cv', 'c.id_to', 'cv.id_cv', 'cv.id_cv', 'c.id_to', 'cb.id_cb', 'cb.usado_cb');
			}else{
				$aColumns = array('c.concepto_to', 'a.nombre_a', 'acc.precio_ac','cv.convenio_cv', 'c.id_to', 'cv.id_cv', 'cv.id_cv', 'c.id_to', 'cb.id_cb', 'cb.usado_cb');
			}
			// DB tables to use 
			$aTables = array( 'conceptos_beneficios cb');
			// Indexed column (used for fast and accurate table cardinality) 
			$sIndexColumn = "cb.id_cb";
			 // Joins   
			$sJoin = 'left join convenios_paciente cp on cp.id_cvp = cb.id_convenio_paciente_cb left join convenios cv on cv.id_cv = cp.id_convenio_cvp left join asigna_conceptos_convenios acc on acc.id_ac = cb.id_concepto_convenio_cb left join conceptos c on c.id_to = acc.id_concepto_ac left join areas a on a.id_a = c.id_area_to left join stock_has_bach s on s.id_Producto = e.id_to left join stock s1 on s.id_stock = s1.id';
			// CONDITIONS
			$lista = '0';
			mysql_select_db($database_horizonte, $horizonte);
			$consulta="SELECT v.id_conceptos_beneficios from venta_conceptos v left join conceptos c on c.id_to = v.id_concepto_es where v.no_temp_vc = '$_GET[aleatorio]' and c.id_tipo_concepto_to = 5 ";
			$query = mysql_query($consulta) or die (mysql_error());
			while ($fila = mysql_fetch_array($query)) {
				$lista = $lista.','.$fila['id_conceptos_beneficios'];
			};//echo $lista;
			$sWhere = "WHERE cb.id_cb not in ($lista) and c.id_tipo_concepto_to = 5 and cv.id_cv = '$_GET[idConvenio]' and cb.id_paciente_cb = '$_GET[idP]' and s.existencias > 0 and s1.id_su = $idSucu";
		}
	}

    /* Database connection information */
    $gaSql['user']       = $username_horizonte;
    $gaSql['password']   = $password_horizonte;
    $gaSql['db']         = $database_horizonte;
    $gaSql['server']     = $hostname_horizonte;
     
    $gaSql['link'] =  mysql_pconnect( $gaSql['server'], $gaSql['user'], $gaSql['password']  ) or
        die( 'Could not open connection to server' );
     
    mysql_select_db( $gaSql['db'], $gaSql['link'] ) or 
        die( 'Could not select database '. $gaSql['db'] );
     
    /*  * Paging */
    $sLimit = "";
    if ( isset( $_GET['iDisplayStart'] ) && $_GET['iDisplayLength'] != '-1' )
    {
        $sLimit = "LIMIT ".mysql_real_escape_string( $_GET['iDisplayStart'] ).", ".
            mysql_real_escape_string( $_GET['iDisplayLength'] );
    }
     
    /* * Ordering */
    $sOrder = "GROUP by e.concepto_to asc";
    if ( isset( $_GET['iSortCol_0'] ) )
    {
        $sOrder = "ORDER BY  ";
        for ( $i=0 ; $i<intval( $_GET['iSortingCols'] ) ; $i++ )
        {
            if ( $_GET[ 'bSortable_'.intval($_GET['iSortCol_'.$i]) ] == "true" )
            {
                $sOrder .= $aColumns[ intval( $_GET['iSortCol_'.$i] ) ]."
                    ".mysql_real_escape_string( $_GET['sSortDir_'.$i] ) .", ";
            }
        }
         
        $sOrder = substr_replace( $sOrder, "", -2 );
        if ( $sOrder == "ORDER BY" ) { $sOrder = ""; }
    }
     
    /* 
     * Filtering
     * NOTE this does not match the built-in DataTables filtering which does it
     * word by word on any field. It's possible to do here, but concerned about efficiency
     * on very large tables, and MySQL's regex functionality is very limited
    */
 
    if ( isset($_GET['sSearch']) && $_GET['sSearch'] != "" )
    {
        $sWhere .= "AND (";
        for ( $i=0 ; $i<count($aColumns) ; $i++ )
        {
            $sWhere .= $aColumns[$i]." LIKE '%".mysql_real_escape_string( $_GET['sSearch'] )."%' OR ";
        }
        $sWhere = substr_replace( $sWhere, "", -3 );
        $sWhere .= ')';
    }
     
    /* Individual column filtering */
    for ( $i=0 ; $i<count($aColumns) ; $i++ )
    {
        if ( isset($_GET['bSearchable_'.$i]) && $_GET['bSearchable_'.$i] == "true" && $_GET['sSearch_'.$i] != '' )
        {
            if ( $sWhere == "" ) { $sWhere = "WHERE "; }
            else { $sWhere .= " AND "; }
            $sWhere .= $aColumns[$i]." LIKE '%".mysql_real_escape_string($_GET['sSearch_'.$i])."%' ";
        }
    }
     
    /* * SQL queries * Get data to display */
    $sQuery = "
        SELECT SQL_CALC_FOUND_ROWS ".str_replace(" , ", " ", implode(", ", $aColumns))."
        FROM   ".str_replace(" , ", " ", implode(", ", $aTables))."
		$sJoin
        $sWhere
        $sOrder
        $sLimit";
		// echo $sQuery ;
     
    $rResult = mysql_query( $sQuery, $gaSql['link'] ) or die(mysql_error());
     
    /* Data set length after filtering */
    $sQuery = "
        SELECT FOUND_ROWS()
    ";
    $rResultFilterTotal = mysql_query( $sQuery, $gaSql['link'] ) or die(mysql_error());
    $aResultFilterTotal = mysql_fetch_array($rResultFilterTotal);
    $iFilteredTotal = $aResultFilterTotal[0];
     
    /* Total data set length */
    $sQuery = "
        SELECT COUNT(".$sIndexColumn.")
        FROM   ".$aTables[0];
     
    $rResultTotal = mysql_query( $sQuery, $gaSql['link'] ) or die(mysql_error());
    $aResultTotal = mysql_fetch_array($rResultTotal);
    $iTotal = $aResultTotal[0];
     
    /* * Output */
    $output = array(
        "sEcho" => intval($_GET['sEcho']),
        "iTotalRecords" => $iTotal,
        "iTotalDisplayRecords" => $iFilteredTotal,
        "aaData" => array()
    );
	$hh=0;
     
    while ( $aRow = mysql_fetch_array( $rResult ) )
    {
		$hh++;
        $row = array();
        for ( $i=0 ; $i<count($aColumns) ; $i++ )
        {
            if ( $aColumns[$i] == "version" ) { $row[] = ($aRow[ $aColumns[$i] ]=="0") ? '-' : $aRow[ $aColumns[$i] ]; }
            else if ( $aColumns[$i] != ' ' ) { $row[] = $aRow[$i]; }
        }
		
		$id_concepti = sqlValue($row[4], "int");
		
		mysql_select_db($database_horizonte, $horizonte); 
		$resultC = mysql_query("SELECT c.id_tipo_concepto_to, m.presentacion_med, m.cantidad_med from conceptos c left join medicamentos m on m.id_med = c.id_medicamento_g where c.id_to = $id_concepti limit 1", $horizonte) or die (mysql_error());
		$rowC = mysql_fetch_row($resultC);
		
		if($rowC[0]==5){
			$row[0]="<span>$row[0] ($rowC[1], $rowC[2])</span>";
		}
		
		if($_GET['idConvenio']==0 or $_GET['idConvenio']==1){
			$row[1]="<span lang='$row[2]'>$row[1]</span>";
			//$row[2]="<span lang='0'>$row[2]</span>";
			$row[0]="<span lang='$row[4]'>$row[0]</span>";

			if($_GET['idConvenio']==0){ $row[3]="PARTICULAR"; }//else{ $row[3] = "<div lang='1'>$row[3]</div>"; }
		}
		else{
			if($row[9]==1){
				$row[1] = "<div lang='$row[2]' style='text-decoration:line-through; color:red;'>$row[1]</div>";
				//$row[2] = "<div lang='$row[8]' style='text-decoration:line-through; color:red;'>$row[2]</div>";
				$row[0] = "<div lang='$row[4]' class='1' style='text-decoration:line-through; color:red;'>$row[0]</div>";
				//$row[3] = "<div lang='$row[5]' style='text-decoration:line-through; color:red;'>$row[3]</div>";
			}else{
				$row[1] = "<div lang='$row[2]'>$row[1]</div>";
				//$row[2] = "<div lang='$row[8]'>$row[2]</div>";
				$row[0] = "<div lang='$row[4]'>$row[0]</div>";
				//$row[3] = "<div lang='$row[5]'>$row[3]</div>";
			}
		}
		$output['aaData'][] = $row;	
    }     
    echo json_encode( $output );
?>
