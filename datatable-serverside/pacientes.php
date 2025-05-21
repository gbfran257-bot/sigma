<?php
require("../Connections/horizonte.php"); 
require_once("../funciones/php/values.php");

	$obligatorio = 0;
	$aColumns = array('p.id_p', 'p.curp_p', 'nombre_completo_p', 'p.fNac_p', 'SUBSTRING(sx.cat_sexo, 1, 1)', 'p.tCelular_p', 's.clave_su', 'p.id_p', 'p.id_p', 'p.id_p', 's.nombre_su', 'p.id_p', 'p.id_p', 'p.id_p', 'p.id_p','p.nombre_p','p.apaterno_p','p.amaterno_p','p.vigente');
     
    // DB tables to use 
    $aTables = array( 'pacientes p');
     
    // Indexed column (used for fast and accurate table cardinality) 
    $sIndexColumn = "p.id_p";
     
	 // Joins   hasta aqui
	$sJoin = 'left join sucursales s on s.id_su = p.idSucursal_p left join catalogo_sexos sx on sx.id_sexo = p.sexo_p';
	 
    // CONDITIONS
	if(isset($_GET['nombre'])){
		if(isset($_GET['convenio']) and $_GET['convenio']!=''){
			$lista = '0';
			mysql_select_db($database_horizonte, $horizonte);
			$consulta = "SELECT distinct(id_paciente_cvp) from convenios_paciente where id_convenio_cvp = $_GET[convenio] ";
			$query = mysql_query($consulta) or die (mysql_error());
			while ($fila = mysql_fetch_array($query)) {
				$lista = $lista.','.$fila['id_paciente_cvp'];
			};
			$sWhere = "where p.nombre_p like '$_GET[nombre]' and p.id_p in ($lista)" ;
		}else{
			$sWhere = "where p.nombre_completo_p like '%$_GET[nombre]%' " ;	
		}
	}
	//$sWhere = "where 1=1 " ;	
	
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
    $sOrder = "ORDER BY p.id_p desc";
    if ( isset( $_GET['iSortCol_0'] ) )
    {
        $sOrder = "ORDER BY p.id_p desc ";
        for ( $i=0 ; $i<intval( $_GET['iSortingCols'] ) ; $i++ )
        {
            if ( $_GET[ 'bSortable_'.intval($_GET['iSortCol_'.$i]) ] == "true" )
            {
                $sOrder .= $aColumns[ intval( $_GET['iSortCol_'.$i] ) ]."
                    ".mysql_real_escape_string( $_GET['sSortDir_'.$i] ) .", ";
            }
        }
         
        $sOrder = substr_replace( $sOrder, "", -2 );
        if ( $sOrder == "ORDER BY" ) { $sOrder = "ORDER BY p.id_p desc"; }
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
        { $sWhere .= $aColumns[$i]." LIKE '%".mysql_real_escape_string( $_GET['sSearch'] )."%' OR "; }
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
            //busqueda por edad
            if($i==3){

                $busqueda_años = $_GET['sSearch_'.$i];
                if(strpos($busqueda_años, "A")==true){//si es A es busqueda por años
                    $busqueda_años = preg_replace('([^0-9])', '', $busqueda_años);
                    $sWhere .= " YEAR(NOW()) - YEAR(fNac_p) = $busqueda_años ";
                }else if(strpos($busqueda_años, "M")==true){//si es M es busqueda por meses
                    $busqueda_años = preg_replace('([^0-9])', '', $busqueda_años);
                    $sWhere .= " PERIOD_DIFF(EXTRACT(YEAR_MONTH FROM NOW()), EXTRACT(YEAR_MONTH FROM fNac_p)) = $busqueda_años ";
                }else{//si no encuentra letra aplica busqueda por años
                    $busqueda_años = preg_replace('([^0-9])', '', $busqueda_años);
                    $sWhere .= " YEAR(NOW()) - YEAR(fNac_p) = $busqueda_años ";
                }

            }else{
                $sWhere .= $aColumns[$i]." LIKE '%".mysql_real_escape_string($_GET['sSearch_'.$i])."%' ";
            }
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
     
    while ( $aRow = mysql_fetch_array( $rResult ) )
    {
        $row = array();
        for ( $i=0 ; $i<count($aColumns) ; $i++ )
        {
            if ( $aColumns[$i] == "version" ) { $row[] = ($aRow[ $aColumns[$i] ]=="0") ? '-' : $aRow[ $aColumns[$i] ]; }
            else if ( $aColumns[$i] != ' ' ) { $row[] = $aRow[$i]; }			
			//para la edad
			if ($i==3){
				$fecha1 = new DateTime($row[3]); $fecha2 = new DateTime(date("Y-m-d H:i:s")); $fecha = $fecha1->diff($fecha2);
				//printf('%d AÑOS %d MESES %d DÍAS %d HORAS %d MINUTOS', $fecha->y, $fecha->m, $fecha->d, $fecha->h, $fecha->i);
				$anos=$fecha->y; $meses=$fecha->m; $dias=$fecha->d; $horas=$fecha->h; $minutos=$fecha->i; $segundos=$fecha->s;
				if($anos>0){$row[3]=$anos." AÑOS";}
				if($anos<1){
					if($meses<=2 and $meses>=1){$row[3]=$meses." MES(ES) ".$dias." DÍA(S)";}
					if($meses>=3){$row[3]=$meses." MES(ES) ";}
					if($meses==0){$row[3]=$dias." DÍA(S)";}
					if($meses==0 and $dias<=1){$row[3]=$dias." DÍA(S) ".$horas." HORA(S)";}
					if($meses==0 and $dias<1){$row[3]=$horas." HORA(S) ".$minutos." MINUTO(S)";}
				} 
				if($anos>150 or $anos<0){$row[3]="DESCONOCIDA";$obligatorio=1;}else{$obligatorio=$obligatorio;}
			}

        }
		$row1 = array();
        for ( $j=0 ; $j<count($aColumns) ; $j++ )
        {
            if ( $aColumns[$j] == "version" ) { $row1[] = ($aRow[ $aColumns[$j] ]=="0") ? '-' : $aRow[ $aColumns[$j] ]; }
            else if ( $aColumns[$j] != ' ' ) { $row1[] = $aRow[$j]; }
        }
				
		mysql_select_db($database_horizonte, $horizonte);
		$resultRu = mysql_query("SELECT count(id_ov) from orden_venta where id_paciente_ov = $row[8]", $horizonte) or die(mysql_error());
		$rowRu = mysql_fetch_row($resultRu);
		
		//Para las membresías
		mysql_select_db($database_horizonte, $horizonte);
		$resultMe = mysql_query("SELECT fecha_i_me, fecha_f_me, DATE_FORMAT(fecha_i_me, '%d/%m/%Y'), DATE_FORMAT(fecha_f_me, '%d/%m/%Y'), DATE_FORMAT(DATE_ADD(fecha_f_me, INTERVAL 1 DAY), '%d/%m/%Y'), DATE_FORMAT(DATE_ADD(DATE_ADD(fecha_f_me, INTERVAL 1 DAY), INTERVAL 1 YEAR), '%d/%m/%Y'), DATE_ADD(fecha_f_me, INTERVAL 1 DAY), DATE_ADD(DATE_ADD(fecha_f_me, INTERVAL 1 DAY), INTERVAL 1 YEAR) from membresias where id_paciente_me = $row[8] order by id_me desc limit 1", $horizonte) or die(mysql_error());
		$rowMe = mysql_fetch_row($resultMe);
		
		//Costo membresía y periodo
		mysql_select_db($database_horizonte, $horizonte);
		$resultCf = mysql_query("SELECT precio_membresia_cf, periodo_membresia_cf, dias_avisar_membresia_cf from configuracion order by id_cf desc limit 1", $horizonte) or die(mysql_error());
		$rowCf = mysql_fetch_row($resultCf); $costo_m = sqlValue($rowCf[0], "int"); $periodo_m = '"'.$rowCf[1].'"';
		
		//para contar el número de convenios
		mysql_select_db($database_horizonte, $horizonte);
		$resultC = mysql_query("SELECT count(id_cvp) from convenios_paciente where id_paciente_cvp = $row[8]", $horizonte) or die(mysql_error());
		$rowC = mysql_fetch_row($resultC);
		
		$vars1 = $row[8].";]{".$row[2]." (".$rowRu[0].")";
 		
		$id_pa = $row[0];

        //datos necesarios para activar/desactivar pacientes
		$vigente = $row[18];
        $disabled = "";
        if($row[18]==0){
            $disabled = " disabled ";
        }
		
		$row[0] = "<div style='text-align:center; text-decoration:underline;'><span lang='$vars1' onClick='historialPaciente(this.lang);' style='cursor:pointer;' >$rowRu[0]</span></div>";
		
		if($rowC[0]<1){
			$row[7] = "<div style='text-align:center;'><span id='$row[8]' lang='$row[2]' onClick='verConvenios(this.id, this.lang);' style='cursor:pointer; text-decoration:underline;' title='El paciente no cuenta con beneficios'>$rowC[0]</span></div>";
		}else{
			$lista = ''; $cont = 0;
			mysql_select_db($database_horizonte, $horizonte);
			$consulta = "SELECT c.id_convenio_cvp, c1.convenio_cv from convenios_paciente c left join convenios c1 on c1.id_cv = c.id_convenio_cvp where c.id_paciente_cvp = $row[9] ";
			$query = mysql_query($consulta) or die (mysql_error());
			while ($fila = mysql_fetch_array($query)) {
				if($cont==0){$lista = $fila['convenio_cv'];}
				else{$lista = $lista.','.$fila['convenio_cv'];}
				$cont++;
			};//echo $lista;
			$row[7] = "<div style='text-align:center;'><span id='$row[8]' lang='$row[2]' onClick='verConvenios(this.id, this.lang);' style='cursor:pointer; text-decoration:underline;' title='$lista'>$rowC[0]</span></div>";
		}
		
		if($row[4]=='M'){$se = 'HOMBRE';}else{$se = 'MUJER';}
		$nombreP = '"'.$row[2].'"'; $mi_fecha_i = '"'.$rowMe[2].'"'; $mi_fecha_f = '"'.$rowMe[3].'"'; 
		
		$mi_fecha_r_i = $rowMe[4];
		$mi_fecha_r_f = $rowMe[5];
		$mi_fecha_r_i1 = $rowMe[6];
		$mi_fecha_r_f1 = $rowMe[7];
		$mi_fecha_r_i = '"'.$mi_fecha_r_i.'"'; $mi_fecha_r_f = '"'.$mi_fecha_r_f.'"';
		$mi_fecha_r_i1 = '"'.$mi_fecha_r_i1.'"'; $mi_fecha_r_f1 = '"'.$mi_fecha_r_f1.'"';
		
		$visitaP = '"'.$row[2].' - '.$row[3].' '.$se.'"';
		
        //creamos el elemento del checkbox
        $chbox = "<input type='checkbox' class='chkbox' value='$id_pa'>";

        //si el paciente no esta vigente no se muestra su informacion
        if($row[18]==0){
            $row[2] = "$chbox <span style='cursor:not-allowed; text-decoration:underline;' >$row[2]</span>";
        }else{
            $row[2] = "$chbox <span id='$row[11]' onClick='verPaciente(this.id);' style='cursor:pointer; text-decoration:underline;' >$row[2]</span>";
        }
		
		$row[4] = "<div style='text-align:center;'>$row[4]</div>";
		
		$tituloSu = $row[10];
		$row[6] = "<span title='$tituloSu'>$row[6]</span>";
		
        $row[8] = "<button onClick='nuevaVisita(this.id, $visitaP);' id='$row[9]' class='btn btn-info btn-sm' title='' $disabled><i class='fa fa-cart-plus' aria-hidden='true'></i> </button>";
		
		$row[9] = "<button onClick='formatos(this.id, $nombreP)' id='$row[11]' class='btn btn-primary btn-sm' title=''><i class='fa fa-file-text-o' aria-hidden='true'></i> </button>";
		
		$row[10] = "<button onClick='documentos(this.id, $nombreP)' id='$row[11]' class='btn btn-default btn-sm' title=''><i class='fa fa-files-o' aria-hidden='true'></i> </button>";
		
		$row[11] = "<button onClick='eventos(this.id, $nombreP)' id='$row[11]' class='btn btn-default btn-sm' title=''><i class='fa fa-calendar-o' aria-hidden='true'></i> </button>";
		
		$row[12] = "<div align='center'><button class='btn btn-default btn-sm' onClick='ubicacion(this.name, $nombreP)' name='$row[12]' lang='$row[3]' title=''><i class='fa fa-street-view' aria-hidden='true'></i> </button></div>";
		
		$row[13] = "<div align='center'><button class='btn btn-default btn-sm' onClick='expediente(this.name, $nombreP)' name='' lang='' title=''><i class='fa fa-address-book' aria-hidden='true'></i> </button></div>";
		
		if($rowMe){
			//Tiene membresía, checar si está normal, si está en periodo de renovación o si ya está vencida: verde, naranja y rojo
			mysql_select_db($database_horizonte, $horizonte);
			$resultMe1 = mysql_query("SELECT DATEDIFF(fecha_f_me, fecha_i_me) from membresias where id_paciente_me = $id_pa order by id_me desc limit 1", $horizonte) or die(mysql_error());
			$rowMe1 = mysql_fetch_row($resultMe1);
			
			if($rowMe1[0] > $rowCf[2]){//Normal 1
				$row[14] = "<div align='center'><button class='btn btn-success btn-sm' onClick='membresia($id_pa, $nombreP, 1, $mi_fecha_i, $mi_fecha_f)' $disabled><i class='fa fa-address-card' aria-hidden='true'></i> </button></div>";
			}else if($rowMe1[0] > 0 and $rowMe1[0]<= $rowCf[2]){//Renovación 2
				$row[14] = "<div align='center'><button class='btn btn-warning btn-sm' onClick='membresia($id_pa, $nombreP, 2, $costo_m, $periodo_m, $mi_fecha_r_i, $mi_fecha_r_f, $mi_fecha_r_i1, $mi_fecha_r_f1)' $disabled><i class='fa fa-address-card' aria-hidden='true'></i> </button></div>";
			}else{//Vencida 3
				$row[14] = "<div align='center'><button class='btn btn-danger btn-sm' onClick='membresia($id_pa, $nombreP, 3, $costo_m, $periodo_m, $mi_fecha_f)' $disabled><i class='fa fa-address-card' aria-hidden='true'></i> </button></div>";
			}
		}else{//Nunca ha tenido membresía 0
			$row[14] = "<div align='center'><button class='btn btn-default btn-sm' onClick='membresia($id_pa, $nombreP, 0, $costo_m, $periodo_m)' $disabled><i class='fa fa-address-card' aria-hidden='true'></i> </button></div>";
		}

        if($row[18]==1){
            $row[15] = "<div align='center'><button class='btn btn-default btn-sm' style=' border: none;   padding: 0;' onClick='vigente_activ_desac($id_pa,$vigente)'><i class='fa fa-check-square-o' aria-hidden='true'></i> </button></div>";
        }else if($row[18]==0){
            $row[15] = "<div align='center'><button class='btn btn-default btn-sm' style=' border: none;   padding: 0;' onClick='vigente_activ_desac($id_pa,$vigente)'><i class='fa fa-square-o' aria-hidden='true'></i> </button></div>";
        }
        
		$output['aaData'][] = $row;
		
    }
    echo json_encode( $output );
?>
