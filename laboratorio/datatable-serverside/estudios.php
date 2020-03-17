<?php
ini_set('max_execution_time', 300);
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

include_once '../../recursos/session.php';
include_once '../../Connections/database.php';
include_once '../../recursos/utilities.php';
if($_GET['min'] == 'undefined 00:00:00' || $_GET['max'] == 'undefined 23:59:59'){
	$_GET['max'] = $_GET['min'] = date("Y-m-d");
	$_GET['max'] .= " 23:59:59";
	$_GET['min'] .= " 00:00:00";
}
$tipo_user = $_SESSION['MM_UserGroup'];
$sucu_user = $_SESSION['MM_Usersucu'];
    /* Array of database columns which should be read and sent back to DataTables. Use a space where * you want to insert a non-database field (for example a counter or static image) */
	
	$aColumns = array('v.id_vc', 'p.nombre_completo_p', 'v.referencia_vc', 'e.concepto_to', 'es.estatus_est', 'a.nombre_a','s.clave_su', 'p.amaterno_p', 'p.id_p', 'v.id_vc', 'v.contador_vc', 'e.id_area_to', 'a.nombre_a','s.nombre_su','s.id_su', 'DATE_FORMAT(v.fecha_venta_vc,"%d/%m/%Y %H:%i")', 'au.usuario_u', 'DATE_FORMAT(v.fechaEdo4_e,"%d/%m/%Y %H:%i")' );
     
    // DB tables to use 
    $aTables = array( 'venta_conceptos v');
     
    // Indexed column (used for fast and accurate table cardinality) 
    $sIndexColumn = "v.id_vc";
     
	 // Joins   
	$sJoin = 'left JOIN pacientes p ON p.id_p = v.id_paciente_vc left join conceptos e on e.id_to = v.id_concepto_es left join estatus es on es.id_est = v.estatus_vc left join areas a on a.id_a = e.id_area_to left join orden_venta o on o.referencia_ov = v.referencia_vc left join sucursales s on s.id_su = o.sucursal_ov left join usuarios au on au.id_u = v.usuarioEdo4_e';
	//Vemos si el usuario es multisucursal
	mysql_select_db($database_horizonte, $horizonte); 
	$resultSu = mysql_query("SELECT multisucursal_u, idSucursal_u from usuarios where id_u = '$_GET[idU]'",$horizonte) or die (mysql_error());
	$rowAU = mysql_fetch_row($resultSu); $id_suc = sqlValue($rowAU[1], "int");
	
	switch($rowAU[0]){
		case 0://Solo vé lo suyo
			if(isset($_GET['min']) && isset($_GET['max']) && $_GET['min'] != '' && $_GET['max'] != ''){
				$sWhere="WHERE v.fecha_venta_vc BETWEEN '$_GET[min]' AND '$_GET[max]' and  e.id_tipo_concepto_to = 3 and v.temporal_vc=0 and o.sucursal_ov = $id_suc ";
			}else{
			  	$sWhere = "WHERE e.id_tipo_concepto_to = 3 and v.temporal_vc = 0 and o.sucursal_ov = $id_suc ";
			}
		break;
		case 2://Ve todo lo de su sucursal y lo suyo pero no lo que no es suyo
			if(isset($_GET['min']) && isset($_GET['max']) && $_GET['min'] != '' && $_GET['max'] != ''){
			  	$sWhere="WHERE v.fecha_venta_vc BETWEEN '$_GET[min]' AND '$_GET[max]' and  e.id_tipo_concepto_to = 3 and v.temporal_vc=0 and o.sucursal_ov = $id_suc ";
			}else{
			  	$sWhere = "WHERE e.id_tipo_concepto_to = 3 and v.temporal_vc = 0 and o.sucursal_ov = $id_suc ";
			}
		break;
		case 1://Ve todo de todas las sucursales
			if(isset($_GET['min']) && isset($_GET['max']) && $_GET['min'] != '' && $_GET['max'] != ''){
				if($_GET['acceso']==14){
			  		$sWhere="WHERE v.fecha_venta_vc BETWEEN '$_GET[min]' AND '$_GET[max]' and  e.id_tipo_concepto_to = 3 and v.temporal_vc = 0 and o.sucursal_ov = $id_suc ";
				}else{$sWhere="WHERE v.fecha_venta_vc BETWEEN '$_GET[min]' AND '$_GET[max]' and  e.id_tipo_concepto_to = 3 and v.temporal_vc = 0 ";}
			}else{
				if($_GET['acceso']==14){
			  		$sWhere = "WHERE e.id_tipo_concepto_to = 3 and v.temporal_vc = 0 and o.sucursal_ov = $id_suc ";
				}else{
					$sWhere = "WHERE e.id_tipo_concepto_to = 3 and v.temporal_vc = 0 ";
				}
			}
		break;
		default:
			echo 'Ha ocurrido un error';
	}
	
    /* Database connection information */
    $gaSql['user']       = $username_horizonte; $gaSql['password']   = $password_horizonte; $gaSql['db']         = $database_horizonte; $gaSql['server']     = $hostname_horizonte;
 
     
    $gaSql['link'] =  $horizonte;//mysql_pconnect( $gaSql['server'], $gaSql['user'], $gaSql['password']  ) or die( 'Could not open connection to server' );
     
    mysql_select_db( $gaSql['db'], $gaSql['link'] ) or die( 'Could not select database '. $gaSql['db'] );
     
    /*  * Paging */
    $sLimit = "";
    if ( isset( $_GET['iDisplayStart'] ) && $_GET['iDisplayLength'] != '-1' )
    {
        $sLimit = "LIMIT ".mysql_real_escape_string( $_GET['iDisplayStart'] ).", ".
            mysql_real_escape_string( $_GET['iDisplayLength'] );
    }
     
     
    /* * Ordering */
    $sOrder = "ORDER BY v.id_vc desc";
    if ( isset( $_GET['iSortCol_0'] ) )
    {
        $sOrder = "ORDER BY ";
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
		//calculando el valor de los íconos dependiendo del estatus del estudio
		
		$row[0]=$hh; $nombreP = '"'.$row[1].'"';
		$nombreEstu = '"'.$row[3].'"'; $referenciaE = '"'.$row[2].'"';
		
		$row[7] = "<div align='center'><button type='button' class='btn btn-xs btn-primary disabled' name='$row[8]' id='$row[9]' lang='$row[9]' value='$row[9]'><i class='fa fa-pencil' aria-hidden='true'></i></button></div>";
		
		if ($row[4] == "PENDIENTE"){
			if($tipo_user!=14){
				$row[4] = "<span name='$row[8]' id='$row[8]' lang='$row[9]' value='$row[9]' ".(empty($_GET['_essucur'])?"onClick='procesar(this.id, this.lang)'":'')." style='cursor:pointer; text-decoration:underline;'> $row[4] </span>"; 
			}else{
				$row[4] = "$row[4]"; 
			}
		}
		if ($row[4] == "PROCESO"){
			if($tipo_user!=14){
				$row[4] = "<span name='$row[8]' id='$row[8]' lang='$row[9]' value='$row[9]' ".(empty($_GET['_essucur'])?"onClick='realizar(this.id, this.lang, $nombreEstu,$row[14])'":'')." style='cursor:pointer; text-decoration:underline;'> $row[4] </span>"; 
			}else{
				$row[4] = "$row[4]"; 
			}
		}
		if ($row[4] == "CAPTURADO"){ 
			if($tipo_user!=14){
				$row[4] = "<span name='$row[8]' id='$row[8]' lang='$row[9]' value='$row[9]' ".(empty($_GET['_essucur'])?"onClick='interpretar(this.id, this.lang, $nombreEstu,$row[14])'":'')." style='cursor:pointer; text-decoration:underline;'> $row[4] </span>"; 
			}else{
				$row[4] = "$row[4]"; 
			}
		}
		if ($row[4] == "AUTORIZADO"){ 
			$row[4] = "<span name='$row[8]' id='$row[8]' lang='$row[9]' value='$row[3]' onClick='autorizado(this.id, this.lang, $nombreEstu,$row[14],this.value)' style='cursor:pointer; text-decoration:underline;'> $row[4] </span><br>$row[16] $row[17]";
			if($tipo_user!=14){
				$row[7] = "<div align='center'><button type='button' class='btn btn-xs btn-primary' name='$row[8]' id='$row[8]' lang='$row[9]' value='' onClick='editar(this.lang, $nombreEstu, $referenciaE, $nombreP)'><i class='fa fa-pencil' aria-hidden='true'></i></button></div>";
			}else{
				$row[7] = "-"; 
			}
		}
		if ($row[4] == "CARGADO"){ 
			$row[4] = "<span name='$row[8]' id='$row[8]' lang='$row[9]' value='$row[9]' ".(empty($_GET['_essucur'])?"onClick='visualizar(this.lang, this.lang)'":'')." style='cursor:pointer; text-decoration:underline;'> $row[4] </span>"; 
		}
		
		$row[6] = "<span name='a-$row[0]' id='a-$row[0]' style='text-align:;' title='$row[13]'>$row[6]</span>";
		
		$row[2] = "<span lang='$row[2]' style='text-decoration:underline; cursor:pointer;' onClick='ver_ov(this.lang)'>$row[2]</span><br>$row[15]";
		
		$output['aaData'][] = $row;
    }
     
    echo json_encode( $output );
?>
