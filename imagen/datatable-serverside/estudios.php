<?php
ini_set('max_execution_time', 6000);
if($_GET['min'] == 'undefined 00:00:00' || $_GET['max'] == 'undefined 23:59:59'){
	$_GET['max'] = $_GET['min'] = date("Y-m-d");
	$_GET['max'] .= " 23:59:59";
	$_GET['min'] .= " 00:00:00";
}
require("../../Connections/horizonte.php");
require("../../Connections/ipacs.php");
require("../../funciones/php/values.php");

include_once '../../recursos/session.php';
include_once '../../Connections/database.php';
include_once '../../recursos/utilities.php';
include_once '../../recursos/datauser.php';

	$id_user = $_SESSION['id']; $acceso_user = $_SESSION['MM_UserGroup'];
	
	$aColumns = array('v.id_vc', 'p.nombre_completo_p', 'v.referencia_vc', 'e.concepto_to', 'es.estatus_est', 'v.id_vc', 'v.id_vc', 'p.amaterno_p','a.nombre_a', 'su.clave_su', 'v.id_vc', 'x.procedencia_pr', 'v.referencia_vc', 'v.contador_vc', 'e.id_area_to', 'a.nombre_a', 'DATE_FORMAT(v.fecha_venta_vc,"%Y%m%d")', 'DATE_FORMAT(v.fecha_venta_vc,"%Y%n%d")', 'v.id_radiologo_externo', 'DATE_FORMAT(v.fecha_venta_vc,"%Y-%m-%d")', 'v.id_pacs', 'v.id_vc', 'p.id_p', 'su.nombre_su', 'v.id_concepto_es', 'usuario_transfiere_vc', 'DATE_FORMAT(v.fecha_transfiere_vc,"%Y-%m-%d %H:%i:%s")', 'su.id_su', 'DATE_FORMAT(v.fecha_venta_vc,"%d/%m/%Y %H:%i")', 'au.usuario_u', 'DATE_FORMAT(v.fechaEdo4_e,"%d/%m/%Y %H:%i")', 'auc.usuario_u', 'DATE_FORMAT(v.fechaEdo5_e,"%d/%m/%Y %H:%i")', 'v.estatus_vc' );
     
    // DB tables to use 
    $aTables = array( 'venta_conceptos v');
     
    // Indexed column (used for fast and accurate table cardinality) 
    $sIndexColumn = "v.id_vc";
     
	 // Joins   
	$sJoin = 'left join orden_venta o on o.referencia_ov = v.referencia_vc left JOIN pacientes p on p.id_p = v.id_paciente_vc left join conceptos e on e.id_to = v.id_concepto_es left join estatus es on es.id_est = v.estatus_vc left join areas a on a.id_a = e.id_area_to left join sucursales su on su.id_su = o.sucursal_ov left join procedencia x on x.id_pr = o.procedencia_ov left join usuarios au on au.id_u = v.usuarioEdo4_e left join usuarios auc on auc.id_u = v.usuarioEdo5_e';
	
	//Si es administrador ve todo
	if($acceso_user == 1){
		if(isset($_GET['min']) && isset($_GET['max']) && $_GET['min'] != '' && $_GET['max'] != ''){
		  $sWhere="WHERE v.fecha_venta_vc BETWEEN '$_GET[min]' AND '$_GET[max]' and e.id_tipo_concepto_to = 4 and o.sucursal_ov != '' and e.dicom = 1 ";
		}else{
		  $sWhere = "WHERE e.id_tipo_concepto_to = 4 and v.temporal_vc = 0 and o.sucursal_ov != '' and e.dicom = 1 ";
		}
	}else{
		//si es multisucursal o sucursal ve todo
		if($multisucu_u != 0){
			if(isset($_GET['min']) && isset($_GET['max']) && $_GET['min'] != '' && $_GET['max'] != ''){
			  $sWhere="WHERE v.fecha_venta_vc BETWEEN '$_GET[min]' AND '$_GET[max]' and  e.id_tipo_concepto_to = 4 and o.sucursal_ov != '' and e.dicom = 1 ";
			}else{
			  $sWhere = "WHERE e.id_tipo_concepto_to = 4 and v.temporal_vc = 0 and o.sucursal_ov != '' and e.dicom = 1 ";
			}
		}else{//Si es simple solo ve lo que tiene asignado $sWhere = "WHERE 1=2";
			if(isset($_GET['min']) && isset($_GET['max']) && $_GET['min'] != '' && $_GET['max'] != ''){
			  $sWhere="WHERE v.fecha_venta_vc BETWEEN '$_GET[min]' AND '$_GET[max]' and e.id_tipo_concepto_to = 4 and e.dicom = 1 and o.sucursal_ov != '' and v.id_vc in(select id_vc_as from acceso_simple where id_u_as = $id_user) ";
			}else{
			  $sWhere = "WHERE e.id_tipo_concepto_to = 4 and e.dicom = 1 and v.temporal_vc = 0 and o.sucursal_ov != '' and v.id_vc in(select id_vc_as from acceso_simple where id_u_as = $id_user) ";
			}
		}
	}
	//Vemos si el usuario es multisucursal
	mysql_select_db($database_horizonte, $horizonte); 
	$resultSu = mysql_query("SELECT multisucursal_u, idSucursal_u from usuarios where id_u = '$_GET[idU]'",$horizonte) or die (mysql_error());
	$rowAU = mysql_fetch_row($resultSu); $id_suc = sqlValue($rowAU[1], "int");
	 
	/*switch($rowAU[0]){
		case 0://Solo vé lo suyo
			if(isset($_GET['min']) && isset($_GET['max']) && $_GET['min'] != '' && $_GET['max'] != ''){
			  $sWhere="WHERE v.fecha_venta_vc BETWEEN '$_GET[min]' AND '$_GET[max]' and  e.id_tipo_concepto_to = 4 and v.temporal_vc=0 and a.clave_a not in ('COL', 'EDP', 'UTS') and v.id_radiologo_externo in ('$_GET[idU]') and o.sucursal_ov != '' ";
			}else{
			  $sWhere = "WHERE v.tipo_concepto_vc = 4 and v.temporal_vc = 0 and a.clave_a not in ('COL', 'EDP', 'UTS') and v.id_radiologo_externo in ('$_GET[idU]') ";
			}
		break;
		case 2://Ve todo lo de su sucursal y lo suyo pero no lo que no es suyo
			if(isset($_GET['min']) && isset($_GET['max']) && $_GET['min'] != '' && $_GET['max'] != ''){
			  $sWhere="WHERE v.fecha_venta_vc BETWEEN '$_GET[min]' AND '$_GET[max]' and  e.id_tipo_concepto_to = 4 and v.temporal_vc=0 and a.clave_a not in ('COL', 'EDP', 'UTS') and (o.sucursal_ov = $id_suc or v.id_radiologo_externo = '$_GET[idU]') and o.sucursal_ov != '' ";
			}else{
			  $sWhere = "WHERE e.id_tipo_concepto_to = 4 and v.temporal_vc = 0 and a.clave_a not in ('COL', 'EDP', 'UTS') and (o.sucursal_ov = $id_suc or v.id_radiologo_externo = '$_GET[idU]') ";
			}
		break;
		case 1://Ve todo de todas las sucursales
			if(isset($_GET['min']) && isset($_GET['max']) && $_GET['min'] != '' && $_GET['max'] != ''){
			  $sWhere="WHERE v.fecha_venta_vc BETWEEN '$_GET[min]' AND '$_GET[max]' and  e.id_tipo_concepto_to = 4 and a.clave_a not in ('COL', 'EDP', 'UTS') and o.sucursal_ov != '' ";
			}else{
			  $sWhere = "WHERE e.id_tipo_concepto_to = 4 and v.temporal_vc = 0 and a.clave_a not in ('COL', 'EDP', 'UTS') and o.sucursal_ov != '' ";
			}
		break;
		default:
			echo 'Ha ocurrido un error';
	}*/
	
    /* Database connection information */
    $gaSql['user']       = $username_horizonte;
    $gaSql['password']   = $password_horizonte;
    $gaSql['db']         = $database_horizonte;
    $gaSql['server']     = $hostname_horizonte;
    $soloCinco = 10;
    $soloCincuenta = 50;
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
    $sOrder = "ORDER BY v.id_vc asc";
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
     //echo $sQuery;
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
		$row1 = array();
        for ( $j=0 ; $j<count($aColumns) ; $j++ )
        {
            if ( $aColumns[$j] == "version" ) { $row1[] = ($aRow[ $aColumns[$j] ]=="0") ? '-' : $aRow[ $aColumns[$j] ]; }
            else if ( $aColumns[$j] != ' ' ) { $row1[] = $aRow[$j]; }
        }
		$row[0]="<span>$hh</span>";
		
		$nombreEstud = '"'.$row[3].'"';
		$referenciaE = '"'.$row[2].'"';
		$nombreP = '"'.$row[1].'"';
		$fechaEst = '"'.$row[19].'"';
		
		//checamos si el estudio es una masto
		mysql_select_db($database_horizonte, $horizonte);
		$resultMa = mysql_query("SELECT count(id_to) from conceptos where concepto_to like '%MASTOGRAFIA%' and id_to = '$row[24]' ", $horizonte) or die (mysql_error());
		$rowMa = mysql_fetch_row($resultMa);
		
		$row[5] = "<div align='center'><button type='button' class='btn btn-xs btn-primary disabled' name='$row[22]' id='$row[10]' lang='$row[10]' value='$row[10]'><i class='fa fa-lock' aria-hidden='true'></i></button></div>";

		$row[6] = "<div align='center'><button type='button' class='btn btn-xs btn-primary disabled' name='$row[22]' id='$row[10]' lang='$row[10]' value='$row[10]'><i class='fa fa-pencil' aria-hidden='true'></i></button></div>";
		
		if($row[33] > 2 and $multisucu_u > 0){
			if($acceso_user==1 or $acceso_user==2 or $acceso_user==3 or $acceso_user==11){
				$row[5] = "<div align='center'><button type='button' class='btn btn-xs btn-primary' name='$row[22]' id='$row[22]' lang='$row[10]' value='$row[10]' onClick='acceso(this.lang, $nombreEstud, $referenciaE, $nombreP)'><i class='fa fa-unlock' aria-hidden='true'></i></button></div>";
			}else{ $row[5] = "-"; }
		}
		
		if ($row[4] == "PENDIENTE"){
			$row[4] = "<button type='button' class='btn btn-xs btn-link' name='$row[22]' id='$row[22]' lang='$row[10]' value='$row[10]' onClick='procesar(this.id, this.lang)'>PENDIENTE</button>";
		}
		if ($row[4] == "PROCESO"){
			$row[4] = "<button type='button' class='btn btn-xs btn-link' name='$row[22]' id='$row[22]' lang='$row[10]' value='$row[10]' onClick='realizar(this.id, this.lang,$row[18], $rowMa[0])'>PROCESO</button>";
		}
		if ($row[4] == "REALIZADO"){
			$row[4] = "<button type='button' class='btn btn-xs btn-link' name='$row[22]' id='$row[22]' lang='$row[10]' value='$row[10]' onClick='capturar(this.id, this.lang, $row[18], $rowMa[0],1,$row[27])'>REALIZADO</button>";
			/*if($row[25]==NULL or $row[25]==''){
				$row[5] = "<div align='center'><button type='button' class='btn btn-xs btn-primary' name='$row[22]' id='$row[22]' lang='$row[10]' value='$row[10]' onClick='transferir(this.lang, $nombreEstud, $referenciaE, $nombreP,0)'><i class='fa fa-paper-plane' aria-hidden='true'></i></button></div>";
			}else{
				mysql_select_db($database_horizonte, $horizonte);
				$resultUT = mysql_query("SELECT usuario_u, concat(nombre_u, ' ', apaterno_u), amaterno_u from usuarios where id_u = $row[18] ", $horizonte) or die (mysql_error()); 
				$rowUT = mysql_fetch_row($resultUT);
				mysql_select_db($database_horizonte, $horizonte);
				$resultUT1 = mysql_query("SELECT concat(nombre_u, ' ', apaterno_u) from usuarios where id_u = $row[25] ", $horizonte) or die (mysql_error()); 
				$rowUT1 = mysql_fetch_row($resultUT1);
				$nombreUa = '"'.$rowUT1[0].'"'; $fechaUa = '"'.$row[26].'"'; $medicoUa = '"'.$rowUT[1].' '.$rowUT[2].'"';
				$medicoUaX = $rowUT[1].' '.$rowUT[2];
				$row[5] = "<div align='center'><button type='button' class='btn btn-xs btn-link' name='$row[22]' id='$row[22]' lang='$row[10]'  title='$medicoUaX' onClick='transferir(this.lang, $nombreEstud, $referenciaE, $nombreP,1,$nombreUa,$fechaUa,$medicoUa)'>$rowUT[0]</button></div>";
			}*/
		}
		if ($row[4] == "CAPTURADO"){
			$row[4] = "<button type='button' class='btn btn-xs btn-link' name='$row[22]' id='$row[22]' lang='$row[10]' value='$row[18]' onClick='capturar(this.id, this.lang, $row[18], $rowMa[0],2,$row[27])'>CAPTURADO</button>";
		}
		if ($row[4] == "INTERPRETADO"){
			$row[4] = "<button type='button' class='btn btn-xs btn-link' name='$row[22]' id='$row[22]' lang='$row[10]' value='$row[18]' onClick='capturar(this.id, this.lang, $row[18], $rowMa[0],3,$row[27])'>INTERPRETADO</button><br>$row[29] $row[30]";
						
			$row[6] = "<div align='center'><button type='button' class='btn btn-xs btn-primary' name='$row[22]' id='$row[22]' lang='$row[10]' value='' onClick='editar(this.lang, $nombreEstud, $referenciaE, $nombreP)'><i class='fa fa-pencil' aria-hidden='true'></i></button></div>";
		}
		if ($row[4] == "CARGADO"){ 
			$row[4] = "<button type='button' class='btn btn-xs btn-link' lang='$row[10]' onClick='visualizar(this.lang, this.lang)'>CARGADO</button><br>$row[31] $row[32]"; 
		}
		
		$now1 = $row[16];
		
		if($row[20]=='' or $row[20]=='0k' or $row[20]=='0'){//Si no hay id de pacs
			$miRef = substr($row[12], 2); $miRef = str_replace("-","",$miRef);
			if($row[14]==55){//Si es rx
				$miRef = dechex($miRef).'k';
			}else{//Si no es rx
				$miRef = dechex($miRef.$row[13]);
			}
		}else{//Si hay id de pacs
			$miRef = $row[20];
		}
		
		if($miRef=='0k' or $miRef=='0'){
			$miRef = substr($row[12], 2); $miRef = str_replace("-","",$miRef);
			if($row[14]==55){//Si es rx
				$miRef = dechex($miRef).'k';
			}else{//Si no es rx
				$miRef = dechex($miRef.$row[13]);
			}
		}
		$miRef = strtoupper($miRef);
		$su_id_pacs = '"'.strtoupper($miRef).'"';
		
		if($row[14]==55){//Si es un RX
			//Checamos que $miRef exista en la lista de pacientes de la db del pacs
			///mysql_select_db($database_ipacs, $ipacs);
			$resultPc2 = pg_query($ipacs, "SELECT count(pk) from patient where pat_id = '$miRef' ");
			$rowPc2 = pg_fetch_row($resultPc2); 
			if($rowPc2[0]==0 && $soloCinco > 0){
				$pr_r = pg_query($ipacs, "SELECT pk from patient_id where pat_id='$miRef'");
				$pr_row = pg_fetch_row($pr_r)[0];

				if(!empty($pr_row)){
					$ppr_r = pg_query($ipacs, "SELECT pk from patient where pat_id is null and pk=".$pr_row);
					$ppr_row = pg_fetch_row($ppr_r)[0];
					if(!empty($ppr_row)){
						$pr_r = pg_query($ipacs, "update patient set pat_id='$miRef' where pk=".$pr_row." and pat_id is null");
						$resultPc1=pg_query($ipacs, "SELECT count(pk) from patient where pat_id = '$miRef' ");
						$rowPc2 = pg_fetch_row($resultPc1);
					}
				}
				$soloCinco--;
			}
			if($rowPc2[0]>0){//Hay por lo menos un estudio de la db del pacs ligado a uno de sigma
				$row[7] = "<span name='$row[22]' id='$row[22]' lang='$row[10]' onClick='est(this.lang, this.lang, $su_id_pacs)' style='cursor:pointer;' class='text-success'><h3><u>$miRef</u></h3></span>";
			}else{//No hay estudios ligados
				$row[7] = "<span name='$row[22]' id='$row[22]' lang='$row[10]' onClick='noest(this.lang, $nombreEstud, $nombreP, $referenciaE, $fechaEst, $su_id_pacs)' style='cursor:pointer;' title='Estudio no ligado al pacs!' class='text-danger'><h3><u>$miRef</u></h3></span>";
			}
			if($row[20]=='' or $row[20]=='0k' or $row[20]=='0'){//Si no tiene id de pacs venta_conceptos entonces se le guarda
				mysql_select_db($database_horizonte, $horizonte);
				$sqlX = "UPDATE venta_conceptos SET id_pacs = $su_id_pacs where id_vc = $row[21] limit 1";
				$updateX = mysql_query($sqlX, $horizonte) or die (mysql_error());//if (!$updateX) { echo $sqlX; }else{ echo 1;}
			}
		}else{ //Preguntar si los rayos se van a agrupar en el pacs
			//Checamos que $miRef exista en la lista de pacientes de la db del pacs
			///mysql_select_db($database_ipacs, $ipacs);
			$resultPc1=pg_query($ipacs, "SELECT count(pk) from patient where pat_id = '$miRef' ");
			$rowPc1 = pg_fetch_row($resultPc1); 

			if($rowPc1[0]==0 && $soloCinco > 0){
				$pr_r = pg_query($ipacs, "SELECT pk from patient_id where pat_id='$miRef'");
				$pr_row = pg_fetch_row($pr_r)[0];

				if(!empty($pr_row)){
					$ppr_r = pg_query($ipacs, "SELECT pk from patient where pat_id is null and pk=".$pr_row);
					$ppr_row = pg_fetch_row($ppr_r)[0];
					if(!empty($ppr_row)){
						$pr_r = pg_query($ipacs, "update patient set pat_id='$miRef' where pk=".$pr_row." and pat_id is null");
						$resultPc1=pg_query($ipacs, "SELECT count(pk) from patient where pat_id = '$miRef' ");
						$rowPc1 = pg_fetch_row($resultPc1);
					}
				}
				$soloCinco--;
			}
			if($rowPc1[0]>0){//Hay por lo menos un estudio de la db del pacs ligado a uno de sigma
				$row[7] = "<span name='$row[22]' id='$row[22]' lang='$row[10]' onClick='est(this.lang, this.lang, $su_id_pacs)' style='cursor:pointer;' class='text-success'><h3><u>$miRef</u></h3></span>";
			}else{//No hay estudios ligados
				$row[7] = "<span name='$row[22]' id='$row[22]' lang='$row[10]' onClick='noest(this.lang, $nombreEstud, $nombreP, $referenciaE, $fechaEst, $su_id_pacs)' style='cursor:pointer;' title='Estudio no ligado al pacs!' class='text-danger'><h3><u>$miRef</u></h3></span>";
			}
			if($row[20]=='' or $row[20]=='0k' or $row[20]=='0'){//Si no tiene id de pacs venta_conceptos entonces se le guarda
				mysql_select_db($database_horizonte, $horizonte);
				$sqlX = "UPDATE venta_conceptos SET id_pacs = $su_id_pacs where id_vc = $row[21] limit 1";
				$updateX = mysql_query($sqlX, $horizonte) or die (mysql_error());//if (!$updateX) { echo $sqlX; }else{ echo 1;}
			}
		}
		
		$row[8] = "<div style=' text-align:;'>$row[15]</div>";
		
		$row[9] = "<div title='$row[23]'>$row[9]</div>";
		
		$clave_s = '"'.$row[3].' DEL PACIENTE '.$row[1].'"';
		
		$row[10]="<div align='center'><button type='button' class='btn btn-xs btn-primary' name='$row[10]' lang='$row[10]' value='$row[10]' onClick='fotos(this.name, $clave_s)'><i class='fa fa-camera' aria-hidden='true'></i></button></div>";
		
		$row[2] = "$row[2]<br>$row[28]";
		
		$output['aaData'][] = $row;
    }
     
    echo json_encode( $output );
    pg_close($ipacs);
    mysql_close($horizonte);
?>
