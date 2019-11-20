<?php
require("../../Connections/horizonte.php"); 
require("../../funciones/php/values.php");

include_once '../../recursos/session.php';
include_once '../../Connections/database.php';
include_once '../../recursos/utilities.php';

	$id_user = $_SESSION['id']; $acceso_user = $_SESSION['MM_UserGroup'];

	$aColumns = array('s.id_su','s.clave_su','s.nombre_su','concat(s.ciudad_su,", ",s.estado_su)','s.id_su','s.id_su','s.id_su','s.id_su','s.id_su','s.id_su');
     
    // DB tables to use 
    $aTables = array( 'sucursales s');
     
    // Indexed column (used for fast and accurate table cardinality) 
    $sIndexColumn = "s.id_su";
     
	 // Joins hasta aqui
	$sJoin = ' ';
	
	mysql_select_db($database_horizonte, $horizonte); 
	$resultAU = mysql_query("SELECT multisucursal_u, idSucursal_u from usuarios where id_u = '$_GET[idU]'",$horizonte) or die (mysql_error());
	$rowAU = mysql_fetch_row($resultAU); //echo $rowAU[1];
	
	
	if($acceso_user==1){//Si es administrador
		$sWhere = "WHERE 1=1 ";
	}else{
		$sWhere = "WHERE 1=0 ";
	}
	/*switch($rowAU[0]){
		case 0://Solo vé la suya
			  $sWhere = "WHERE s.id_su = $rowAU[1] ";
		break;
		case 2://Ve todo lo de su sucursal
			  $sWhere = "WHERE s.id_su = $rowAU[1] ";
		break;
		case 1://Ve todo de todas las sucursales
			  $sWhere = "WHERE 1=1 " ;
		break;
		default:
			echo 'Ha ocurrido un error';
	}*/
	 	
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
            if ( $aColumns[$i] == "version" )
            { $row[] = ($aRow[ $aColumns[$i] ]=="0") ? '-' : $aRow[ $aColumns[$i] ]; }
            else if ( $aColumns[$i] != ' ' ) { $row[] = $aRow[$i]; }
        }
		$row1 = array();
        for ( $j=0 ; $j<count($aColumns) ; $j++ )
        {
            if ( $aColumns[$j] == "version" )
            { $row1[] = ($aRow[ $aColumns[$j] ]=="0") ? '-' : $aRow[ $aColumns[$j] ]; }
            else if ( $aColumns[$j] != ' ' ) { $row1[] = $aRow[$j]; }
        }
		$x = md5(time()); $x = '"'.$x.'"';
		
		$row[0]="<span>$hh</span>";
		$clave_s = '"'.$row[1].'"';
		$name_s = '"'.$row[2].'"';
		
		$row[1]="<button type='button' class='btn btn-link btn-sm' id='$row[4]' onClick='verSucursal(this.id, $name_s);'>$row[1]</button>";
		
		$name_s = '"'.$row[2].'"';
		
		$row[3]="<span onClick='ubicacion($row[9], $name_s)' name='$row[9]' class='celdas_accion'>$row[3]</span>";
		
		mysql_select_db($database_horizonte, $horizonte);
		$resulP = mysql_query("SELECT count(id_p) from pacientes where idSucursal_p = $row[5] ",$horizonte) or die (mysql_error());
		$rowP = mysql_fetch_row($resulP);
		
		$row[5]="<span class='celdas_accion'>$rowP[0]</span>";
		
		mysql_select_db($database_horizonte, $horizonte);
		$resulU = mysql_query("SELECT count(id_u) from usuarios where idSucursal_u = $row[4] ",$horizonte) or die (mysql_error());
		$rowU = mysql_fetch_row($resulU);
		
		$row[4]="<span class='celdas_accion'>$rowU[0]</span>";
		
		//Para saber si hay logo o no
		mysql_select_db($database_horizonte, $horizonte);
		$resulL = mysql_query("SELECT count(id_do), ext_do, id_do from documentos where id_quien_do = $row[6] and tipo_quien_do = 2 and que_es_do = 'LOGOTIPO' limit 1 ",$horizonte) or die (mysql_error());
		$rowL = mysql_fetch_row($resulL); $ext_ls = '"'.$rowL[1].'"'; // > a 0 es que ya tiene logo
		if($rowL[0]>0){ $que_es1 = '"'."logotipos".'"'; $format = '"'."LOGOTIPO".'"';
			$row[6]="<div align='center'><button onClick='ver_logo(this.name, $name_s,$ext_ls,$x,$format,$que_es1,this.lang,$format)' name='$row[6]' lang='$rowL[2]' class='ui-button ui-widget ui-corner-all ui-button-icon-only' title=''><span class='ui-icon ui-icon-image'></span>B</button></div>";	
		}else{
			$row[6]="<div align='center'><button onClick='subir_logo(this.name, $name_s)' name='$row[6]' class='ui-button ui-widget ui-corner-all ui-button-icon-only' title=''><span class='ui-icon ui-icon-search'></span>B</button></div>";
		}
		
		$row[7]="<div align='center'><button onClick='fotos(this.name, $clave_s)' name='$row[7]' lang='$row[7]' class='ui-button ui-widget ui-corner-all ui-button-icon-only' title=''><span class='ui-icon ui-icon-image'></span>B</button></div>";
		
		$row[8]="<div align='center'><button onClick='membretes(this.name, $clave_s)' name='$row[8]' lang='$row[8]' class='ui-button ui-widget ui-corner-all ui-button-icon-only' title=''><span class='ui-icon ui-icon-document'></span>B</button></div>";
		
		$row[9]="<div align='center'><button onClick='documentos(this.name, $clave_s)' name='$row[9]' lang='$row[9]' class='ui-button ui-widget ui-corner-all ui-button-icon-only' title=''><span class='ui-icon ui-icon-folder-collapsed'></span>B</button></div>";
										
		$output['aaData'][] = $row;
    }
    echo json_encode( $output );
?>