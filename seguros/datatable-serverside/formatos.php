<?php
require("../../Connections/horizonte.php"); 

	$aColumns = array('f.id_fs', 'f.formato_fs', 'f.id_fs','f.id_fs', 'f.id_fs');
     
    // DB tables to use 
    $aTables = array( 'formatos_sucursales f');
     
    // Indexed column (used for fast and accurate table cardinality) 
    $sIndexColumn = "f.id_fs";
     
	 // Joins hasta aqui
	$sJoin = ' ';
	 
    // CONDITIONS
    $sWhere = "where 1=1 " ;
	
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
		
		mysql_select_db($database_horizonte, $horizonte);
		$resulS = mysql_query("SELECT clave_su from seguros where id_su = '$_GET[id_s]' limit 1 ",$horizonte) or die (mysql_error());
		$rowS = mysql_fetch_row($resulS);
		
		$name_s = '"'.$rowS[0].'"';
		
		$row[2]="<div align='center'><button lang='$row[0]' onClick='verInfoFm(this.lang);' class='ui-button ui-widget ui-corner-all ui-button-icon-only boton_mem' title=''> <span class='ui-icon ui-icon-info'></span> Button </button></div>";
		
	if($row[0]==1){ //Para saber si hay membrete de receta de consulta médica
		mysql_select_db($database_horizonte, $horizonte);
		$resulMR = mysql_query("SELECT count(id_do), ext_do, id_do from documentos where id_quien_do = '$_GET[id_s]' and tipo_quien_do = 2 and que_es_do = 'MEMBRETE RECETA MEDICA' limit 1 ",$horizonte) or die (mysql_error());
		$rowMR = mysql_fetch_row($resulMR); $ext_mr = '"'.$rowMR[1].'"'; // > a 0 es que ya tiene membrete
		$format = '"'."MEMBRETE RECETA MEDICA".'"'; $que_es1 = '"'."membretes".'"'; $id_img=$rowMR[2];
		$row[3]="<div align='center'><button onClick='ver_membretes($_GET[id_s],$name_s,$ext_mr,$x,$format,$que_es1,0,$format)' name='$row[3]' class='ui-button ui-widget ui-corner-all ui-button-icon-only' title=''><span class='ui-icon ui-icon-image'></span>B</button></div>";
	}
	else if($row[0]==2){ //Para saber si hay membrete de notas médicas
		mysql_select_db($database_horizonte, $horizonte);
		$resulMR = mysql_query("SELECT count(id_do), ext_do, id_do from documentos where id_quien_do = '$_GET[id_s]' and tipo_quien_do = 2 and que_es_do = 'MEMBRETE NOTA MEDICA' limit 1 ",$horizonte) or die (mysql_error());
		$rowMR = mysql_fetch_row($resulMR); $ext_mr = '"'.$rowMR[1].'"'; // > a 0 es que ya tiene membrete
		$format = '"'."MEMBRETE NOTA MEDICA".'"'; $que_es1 = '"'."membretes".'"'; $id_img=$rowMR[2];
		$row[3]="<div align='center'><button onClick='ver_membretes($_GET[id_s],$name_s,$ext_mr,$x,$format,$que_es1,0,$format)' name='$row[3]' class='ui-button ui-widget ui-corner-all ui-button-icon-only' title=''><span class='ui-icon ui-icon-image'></span>B</button></div>";
	}
	else if($row[0]==3){ //Para saber si hay membrete de servicios médicos
		mysql_select_db($database_horizonte, $horizonte);
		$resulMR = mysql_query("SELECT count(id_do), ext_do, id_do from documentos where id_quien_do = '$_GET[id_s]' and tipo_quien_do = 2 and que_es_do = 'MEMBRETE SERVICIOS MEDICOS' limit 1 ",$horizonte) or die (mysql_error());
		$rowMR = mysql_fetch_row($resulMR); $ext_mr = '"'.$rowMR[1].'"'; // > a 0 es que ya tiene membrete
		$format = '"'."MEMBRETE SERVICIOS MEDICOS".'"'; $que_es1 = '"'."membretes".'"'; $id_img=$rowMR[2];
		$row[3]="<div align='center'><button onClick='ver_membretes($_GET[id_s],$name_s,$ext_mr,$x,$format,$que_es1,0,$format)' name='$row[3]' class='ui-button ui-widget ui-corner-all ui-button-icon-only' title=''><span class='ui-icon ui-icon-image'></span>B</button></div>";
	}
	else if($row[0]==4){ //Para saber si hay membrete de servicios médicos
		mysql_select_db($database_horizonte, $horizonte);
		$resulMR = mysql_query("SELECT count(id_do), ext_do, id_do from documentos where id_quien_do = '$_GET[id_s]' and tipo_quien_do = 2 and que_es_do = 'MEMBRETE RESULTADOS IMAGENOLOGIA' limit 1 ",$horizonte) or die (mysql_error());
		$rowMR = mysql_fetch_row($resulMR); $ext_mr = '"'.$rowMR[1].'"'; // > a 0 es que ya tiene membrete
		$format = '"'."MEMBRETE RESULTADOS IMAGENOLOGIA".'"'; $que_es1 = '"'."membretes".'"'; $id_img=$rowMR[2];
		$row[3]="<div align='center'><button onClick='ver_membretes($_GET[id_s],$name_s,$ext_mr,$x,$format,$que_es1,0,$format)' name='$row[3]' class='ui-button ui-widget ui-corner-all ui-button-icon-only' title=''><span class='ui-icon ui-icon-image'></span>B</button></div>";
	}
	else if($row[0]==5){ //Para saber si hay membrete de servicios médicos
		mysql_select_db($database_horizonte, $horizonte);
		$resulMR = mysql_query("SELECT count(id_do), ext_do, id_do from documentos where id_quien_do = '$_GET[id_s]' and tipo_quien_do = 2 and que_es_do = 'MEMBRETE RESULTADOS ENDOSCOPIA' limit 1 ",$horizonte) or die (mysql_error());
		$rowMR = mysql_fetch_row($resulMR); $ext_mr = '"'.$rowMR[1].'"'; // > a 0 es que ya tiene membrete
		$format = '"'."MEMBRETE RESULTADOS ENDOSCOPIA".'"'; $que_es1 = '"'."membretes".'"'; $id_img=$rowMR[2];
		$row[3]="<div align='center'><button onClick='ver_membretes($_GET[id_s],$name_s,$ext_mr,$x,$format,$que_es1,0,$format)' name='$row[3]' class='ui-button ui-widget ui-corner-all ui-button-icon-only' title=''><span class='ui-icon ui-icon-image'></span>B</button></div>";
	}
	else if($row[0]==6){ //Para saber si hay membrete de servicios médicos
		mysql_select_db($database_horizonte, $horizonte);
		$resulMR = mysql_query("SELECT count(id_do), ext_do, id_do from documentos where id_quien_do = '$_GET[id_s]' and tipo_quien_do = 2 and que_es_do = 'MEMBRETE RESULTADOS ULTRASONIDO' limit 1 ",$horizonte) or die (mysql_error());
		$rowMR = mysql_fetch_row($resulMR); $ext_mr = '"'.$rowMR[1].'"'; // > a 0 es que ya tiene membrete
		$format = '"'."MEMBRETE RESULTADOS ULTRASONIDO".'"'; $que_es1 = '"'."membretes".'"'; $id_img=$rowMR[2];
		$row[3]="<div align='center'><button onClick='ver_membretes($_GET[id_s],$name_s,$ext_mr,$x,$format,$que_es1,0,$format)' name='$row[3]' class='ui-button ui-widget ui-corner-all ui-button-icon-only' title=''><span class='ui-icon ui-icon-image'></span>B</button></div>";
	}
	else if($row[0]==7){ //Para saber si hay membrete de servicios médicos
		mysql_select_db($database_horizonte, $horizonte);
		$resulMR = mysql_query("SELECT count(id_do), ext_do, id_do from documentos where id_quien_do = '$_GET[id_s]' and tipo_quien_do = 2 and que_es_do = 'MEMBRETE RESULTADOS LABORATORIO' limit 1 ",$horizonte) or die (mysql_error());
		$rowMR = mysql_fetch_row($resulMR); $ext_mr = '"'.$rowMR[1].'"'; // > a 0 es que ya tiene membrete
		$format = '"'."MEMBRETE RESULTADOS LABORATORIO".'"'; $que_es1 = '"'."membretes".'"'; $id_img=$rowMR[2];
		$row[3]="<div align='center'><button onClick='ver_membretes($_GET[id_s],$name_s,$ext_mr,$x,$format,$que_es1,0,$format)' name='$row[3]' class='ui-button ui-widget ui-corner-all ui-button-icon-only' title=''><span class='ui-icon ui-icon-image'></span>B</button></div>";
	}
	else if($row[0]==8){ //Para saber si hay membrete de servicios médicos
		mysql_select_db($database_horizonte, $horizonte);
		$resulMR = mysql_query("SELECT count(id_do), ext_do, id_do from documentos where id_quien_do = '$_GET[id_s]' and tipo_quien_do = 2 and que_es_do = 'MEMBRETE RESULTADOS COLPOSCOPIA' limit 1 ",$horizonte) or die (mysql_error());
		$rowMR = mysql_fetch_row($resulMR); $ext_mr = '"'.$rowMR[1].'"'; // > a 0 es que ya tiene membrete
		$format = '"'."MEMBRETE RESULTADOS COLPOSCOPIA".'"'; $que_es1 = '"'."membretes".'"'; $id_img=$rowMR[2];
		$row[3]="<div align='center'><button onClick='ver_membretes($_GET[id_s],$name_s,$ext_mr,$x,$format,$que_es1,0,$format)' name='$row[3]' class='ui-button ui-widget ui-corner-all ui-button-icon-only' title=''><span class='ui-icon ui-icon-image'></span>B</button></div>";
	}
	
		$output['aaData'][] = $row;
    }
    echo json_encode( $output );
?>