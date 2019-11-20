<?php
$now = date('His');
require("../../../Connections/horizonte.php"); //idMedico
require("../../../funciones/php/values.php");

	//Primero sacamos el día actual, y la hora actual
	$dia_actual = sqlValue(date('N'), "int"); $hora_actual = sqlValue(date('G:i'), "date"); $urgencia = '';
	
	mysql_select_db($database_horizonte, $horizonte);
	$resultNA = mysql_query("SELECT temporal_u from usuarios where id_u = '$_GET[idMedico]' ", $horizonte) or die (mysql_error());
	$rowNA = mysql_fetch_row($resultNA);
	
	switch($dia_actual){
		case 1://Lunes
			mysql_select_db($database_horizonte, $horizonte);
			$resultHl = mysql_query("SELECT count(id_u), temporal_u from usuarios where horario_e_lu <= $hora_actual and horario_s_lu >= $hora_actual and id_u = '$_GET[idMedico]' ", $horizonte) or die (mysql_error()); $rowHl = mysql_fetch_row($resultHl);
			if($rowHl[0]>0){$urgencia=0;}else{$urgencia=1;}
		break;
		case 2:
			mysql_select_db($database_horizonte, $horizonte);
			$resultHl = mysql_query("SELECT count(id_u), temporal_u from usuarios where horario_e_ma <= $hora_actual and horario_s_ma >= $hora_actual and id_u = '$_GET[idMedico]' ", $horizonte) or die (mysql_error()); $rowHl = mysql_fetch_row($resultHl);
			if($rowHl[0]>0){$urgencia=0;}else{$urgencia=1;}
		break;
		case 3:
			mysql_select_db($database_horizonte, $horizonte);
			$resultHl = mysql_query("SELECT count(id_u), temporal_u from usuarios where horario_e_mi <= $hora_actual and horario_s_mi >= $hora_actual and id_u = '$_GET[idMedico]' ", $horizonte) or die (mysql_error()); $rowHl = mysql_fetch_row($resultHl);
			if($rowHl[0]>0){$urgencia=0;}else{$urgencia=1;}
		break;
		case 4:
			mysql_select_db($database_horizonte, $horizonte);
			$resultHl = mysql_query("SELECT count(id_u), temporal_u from usuarios where horario_e_ju <= $hora_actual and horario_s_ju >= $hora_actual and id_u = '$_GET[idMedico]' ", $horizonte) or die (mysql_error()); $rowHl = mysql_fetch_row($resultHl);
			if($rowHl[0]>0){$urgencia=0;}else{$urgencia=1;}
		break;
		case 5:
			mysql_select_db($database_horizonte, $horizonte);
			$resultHl = mysql_query("SELECT count(id_u), temporal_u from usuarios where horario_e_vi <= $hora_actual and horario_s_vi >= $hora_actual and id_u = '$_GET[idMedico]' ", $horizonte) or die (mysql_error()); $rowHl = mysql_fetch_row($resultHl);
			if($rowHl[0]>0){$urgencia=0;}else{$urgencia=1;}
		break;
		case 6:
			mysql_select_db($database_horizonte, $horizonte);
			$resultHl = mysql_query("SELECT count(id_u), temporal_u from usuarios where horario_e_sa <= $hora_actual and horario_s_sa >= $hora_actual and id_u = '$_GET[idMedico]' ", $horizonte) or die (mysql_error()); $rowHl = mysql_fetch_row($resultHl);
			if($rowHl[0]>0){$urgencia=0;}else{$urgencia=1;}
		break;
		case 7://Domingo
			mysql_select_db($database_horizonte, $horizonte);
			$resultHl = mysql_query("SELECT count(id_u), temporal_u from usuarios where horario_e_do <= $hora_actual and horario_s_do >= $hora_actual and id_u = '$_GET[idMedico]' ", $horizonte) or die (mysql_error()); $rowHl = mysql_fetch_row($resultHl);
			if($rowHl[0]>0){$urgencia=0;}else{$urgencia=1;}
		break;
		default:
			$urgencia=0; $rowHl[1] = '000000000';
	}
	
	$aleatorioX = sqlValue($rowNA[0], "text");
	
	//Checamos si tiene membresía el paciente y si está vigente
	mysql_select_db($database_horizonte, $horizonte);
	$resultMe = mysql_query("SELECT DATEDIFF(fecha_f_me, fecha_i_me) from membresias where id_paciente_me = '$_GET[idP]' order by id_me desc limit 1 ", $horizonte) or die (mysql_error()); $rowMe = mysql_fetch_row($resultMe); //echo $_GET['idP'];
	
	if($rowMe[0]>0){
		if($urgencia == 1){//Nocturno
			$aColumns=array('c.id_to','c.concepto_to','a.nombre_a','c.precio_urgencia1_to','co.convenio_cv','c.precio_urgencia1_to','c.id_to','co.id_cv', 'c.id_to', 'c.id_area_to', 'c.id_to');
		}else{
			$aColumns=array('c.id_to','c.concepto_to','a.nombre_a','c.precio1_to','co.convenio_cv','c.precio_urgencia1_to','c.id_to','co.id_cv', 'c.id_to', 'c.id_area_to', 'c.id_to');
		}
			
		// DB tables to use 
		$aTables = array( 'conceptos c');
		// Indexed column (used for fast and accurate table cardinality) 
		$sIndexColumn = "c.id_to";
		 // Joins   
		$sJoin = 'left join areas a on a.id_a = c.id_area_to left join convenios co on co.id_cv = c.id_convenio_to ';
		// CONDITIONS 
		$lista = '0';
		mysql_select_db($database_horizonte, $horizonte);
		$consulta = "SELECT vc.id_concepto_es from venta_conceptos vc left join conceptos c on c.id_to = vc.id_concepto_es where vc.no_temp_vc = '$_GET[aleatorio]' and c.id_tipo_concepto_to = 1 ";
		$query = mysql_query($consulta) or die (mysql_error());
		while ($fila = mysql_fetch_array($query)) {
			$lista = $lista.','.$fila['id_concepto_es'];
		};//echo $lista;
		$sWhere = "WHERE c.id_to not in ($lista) and c.id_tipo_concepto_to = 1 and c.aleatorio_c = $aleatorioX ";
	}else{
		if($_GET['idConvenio']==0){//Sin convenio
			if($urgencia == 1){//Nocturno
				$aColumns=array('c.id_to','c.concepto_to','a.nombre_a','c.precio_urgencia_to','co.convenio_cv','c.precio_urgencia_to','c.id_to','co.id_cv', 'c.id_to', 'c.id_area_to', 'c.id_to');
			}else{
				$aColumns=array('c.id_to','c.concepto_to','a.nombre_a','c.precio_to','co.convenio_cv','c.precio_urgencia_to','c.id_to','co.id_cv', 'c.id_to', 'c.id_area_to', 'c.id_to');
			}
				
			// DB tables to use 
			$aTables = array( 'conceptos c');
			// Indexed column (used for fast and accurate table cardinality) 
			$sIndexColumn = "c.id_to";
			 // Joins   
			$sJoin = 'left join areas a on a.id_a = c.id_area_to left join convenios co on co.id_cv = c.id_convenio_to ';
			// CONDITIONS 
			$lista = '0';
			mysql_select_db($database_horizonte, $horizonte);
			$consulta = "SELECT vc.id_concepto_es from venta_conceptos vc left join conceptos c on c.id_to = vc.id_concepto_es where vc.no_temp_vc = '$_GET[aleatorio]' and c.id_tipo_concepto_to = 1 ";
			$query = mysql_query($consulta) or die (mysql_error());
			while ($fila = mysql_fetch_array($query)) {
				$lista = $lista.','.$fila['id_concepto_es'];
			};//echo $lista;
			$sWhere = "WHERE c.id_to not in ($lista) and c.id_tipo_concepto_to = 1 and c.aleatorio_c = $aleatorioX ";
		}/*else if($_GET['idConvenio']==1){//Con Membresía 
			if($urgencia == 1){//Urgente
				$aColumns=array('cb.concepto_to','a.nombre_a','cb.precio_membrecia1','cv.convenio_cv','cb.precio_membrecia1','cb.id_to','cv.id_cv', 'cb.id_to', 'cb.id_area_to', 'cb.id_to');
			}else{
				$aColumns=array('cb.concepto_to','a.nombre_a','cb.precio_membrecia_to','cv.convenio_cv','cb.precio_membrecia_to', 'cb.id_to', 'cv.id_cv', 'cb.id_to', 'cb.id_area_to', 'cb.id_to');
			}
			// DB tables to use 
			$aTables = array( 'conceptos cb');
			// Indexed column (used for fast and accurate table cardinality) 
			$sIndexColumn = "cb.id_to";
			 // Joins   
			$sJoin = 'left join convenios_paciente cp on cp.id_cvp = cb.id_beneficio_to left join convenios cv on cv.id_cv = 1 left join areas a on a.id_a = cb.id_area_to';
			// CONDITIONS 
			$lista = '0';
			mysql_select_db($database_horizonte, $horizonte);
			$consulta = "SELECT id_concepto_es from venta_conceptos where no_temp_vc = '$_GET[aleatorio]' and tipo_concepto_vc = 1 ";
			$query = mysql_query($consulta) or die (mysql_error());
			while ($fila = mysql_fetch_array($query)) {
				$lista = $lista.','.$fila['id_concepto_es'];
			};//echo $lista;	
			$sWhere = "WHERE cb.id_to not in ($lista) and cb.id_tipo_concepto_to = 1 and cb.aleatorio_c = $aleatorioX ";
		}*/
		else{
			if($urgencia==1){
				$aColumns = array('c.id_to','c.concepto_to' , 'a.nombre_a', 'acc.precio_urgencia_ac','cv.convenio_cv', 'acc.precio_urgencia_ac', 'c.id_to', 'cv.id_cv', 'c.id_to', 'c.id_area_to', 'cb.id_cb', 'cb.usado_cb', 'cv.id_cv');
			}else{
				$aColumns = array('c.id_to','c.concepto_to' , 'a.nombre_a', 'acc.precio_ac','cv.convenio_cv', 'acc.precio_urgencia_ac', 'c.id_to', 'cv.id_cv', 'c.id_to', 'c.id_area_to', 'cb.id_cb', 'cb.usado_cb', 'cv.id_cv');
			}
			// DB tables to use 
			$aTables = array( 'conceptos_beneficios cb');
			// Indexed column (used for fast and accurate table cardinality) 
			$sIndexColumn = "cb.id_cb";
			 // Joins   
			$sJoin = 'left join convenios_paciente cp on cp.id_cvp = cb.id_convenio_paciente_cb left join convenios cv on cv.id_cv = cp.id_convenio_cvp left join asigna_conceptos_convenios acc on acc.id_ac = cb.id_concepto_convenio_cb left join conceptos c on c.id_to = acc.id_concepto_ac left join areas a on a.id_a = c.id_area_to';
			// CONDITIONS
			$lista = '0';
			mysql_select_db($database_horizonte, $horizonte);
		$consulta="SELECT vc.id_conceptos_beneficios from venta_conceptos vc left join conceptos c on c.id_to = vc.id_concepto_es where vc.no_temp_vc = '$_GET[aleatorio]' and c.id_tipo_concepto_to = 1 ";
			$query = mysql_query($consulta) or die (mysql_error());
			while ($fila = mysql_fetch_array($query)) {
				$lista = $lista.','.$fila['id_conceptos_beneficios'];
			};//echo $lista;
			$sWhere = "WHERE cb.id_cb not in ($lista) and c.id_tipo_concepto_to = 1 and cv.id_cv = '$_GET[idConvenio]' and cb.id_paciente_cb = '$_GET[idP]' ";
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
    $sOrder = "";
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
     
    /*  * SQL queries * Get data to display */
    $sQuery = "
        SELECT SQL_CALC_FOUND_ROWS ".str_replace(" , ", " ", implode(", ", $aColumns))."
        FROM   ".str_replace(" , ", " ", implode(", ", $aTables))."
		$sJoin
        $sWhere
        $sOrder
        $sLimit";
     
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
    
	$k=0;
    while ( $aRow = mysql_fetch_array( $rResult ) )
    {
		$k++;
        $row = array();
        for ( $i=0 ; $i<count($aColumns) ; $i++ )
        {
            if ( $aColumns[$i] == "version" ) { $row[] = ($aRow[ $aColumns[$i] ]=="0") ? '-' : $aRow[ $aColumns[$i] ]; }
            else if ( $aColumns[$i] != ' ' ) { $row[] = $aRow[$i]; }
        }
		
		$row[0] = "<div>$k</div>";
		
		if($_GET['idConvenio']==0){
			//$row[3] = "<div lang='0'>$row[3]</div>";
			$row[1] = "<div lang='$row[8]'>$row[1]</div>";
			$row[2] = "<div lang='$row[9]'>$row[2]</div>";
			$row[4] = "<div lang='$row[7]'>PARTICULAR</div>";
		}
		else{
			if($row[11]==1){
				//$row[3] = "<div lang='$row[10]' style='text-decoration:line-through; color:red;'>$row[3]</div>";
				$row[1] = "<div lang='$row[8]' class='1' style='text-decoration:line-through; color:red;'>$row[1]</div>";
				$row[2] = "<div lang='$row[9]' style='text-decoration:line-through; color:red;'>$row[2]</div>";
				$row[4] = "<div lang='$row[7]' style='text-decoration:line-through; color:red;'>$row[4]</div>";
			}else{
				//$row[3] = "<div lang='$row[10]'>$row[3]</div>";
				$row[1] = "<div lang='$row[8]'>$row[1]</div>";
				$row[2] = "<div lang='$row[9]'>$row[2]</div>";
				$row[4] = "<div lang='$row[7]'>$row[4]</div>";
			}
		}
		$output['aaData'][] = $row;
    }
    echo json_encode( $output );
?>