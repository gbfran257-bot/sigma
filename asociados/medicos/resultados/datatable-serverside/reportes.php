<?php require_once('../../../../Connections/horizonte.php'); ?>
<?php
// consulta para horizonte
	$obligatorio = 0;
	$aColumns = array('vc.id_vc','vc.referencia_vc' , 'concat(p.nombre_p," ", p.apaterno_p)', 'tp.tipo_concepto_tc', 'c.concepto_to', 'e.estatus_est', '(vc.precio_normal_vc)-(vc.precio_normal_vc)*0.16', '(vc.precio_normal_vc)*1', 'vc.id_vc', 'vc.tipo_concepto_vc', 'vc.estatus_vc', 'p.id_p', 'vc.area_vc', 'vc.contador_vc', 'DATE_FORMAT(vc.fecha_venta_vc,"%Y%c%d")' );
     
    // DB tables to use 
    $aTables = array( 'venta_conceptos vc');
     
    // Indexed column (used for fast and accurate table cardinality) 
    $sIndexColumn = "vc.id_vc";
     
	 // Joins   hasta aqui
	$sJoin = 'left join pacientes p ON p.id_p = vc.id_paciente_vc left join conceptos c on c.id_to = vc.id_concepto_es left join catalogo_tipo_conceptos tp on tp.id_tc = vc.tipo_concepto_vc left join estatus e on e.id_est = vc.estatus_vc ';
	 
    // CONDITIONS 
	if(isset($_GET['depto']) && $_GET['depto'] != 'x' && $_GET['depto'] != ''){//para las solicitudes con departamento
		if(isset($_GET['min']) && isset($_GET['max']) && $_GET['min'] != '' && $_GET['max'] != ''){
    		$sWhere = "WHERE vc.fecha_venta_vc BETWEEN '$_GET[min]' AND '$_GET[max]' and vc.id_personal_medico_vc = '$_GET[depto]' and tp.id_tc in (2,3,4) and vc.referencia_vc != '' ";
		}else{$sWhere = "WHERE tp.id_tc in (2,3,4) and vc.referencia_vc != '' " ;}
	}else{
		if(isset($_GET['min']) && isset($_GET['max']) && $_GET['min'] != '' && $_GET['max'] != ''){
    		$sWhere = "WHERE vc.fecha_venta_vc BETWEEN '$_GET[min]' AND '$_GET[max]' and tp.id_tc in (2,3,4) and vc.referencia_vc != ''";
		}else{$sWhere = "WHERE tp.id_tc in (2,3,4) and vc.referencia_vc != '' " ;}
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
		$sOrder = "ORDER BY vc.fecha_venta_vc desc";
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
		$row[0] = $hh;
		
		$nombreEstu = '"'.$row[4].'"';
		
	//para imagen
	if($row[9]==4){
		if($row[10]==5){//Para los estudios en estatus interpretado
			//Si el area es RAYOS X entonces la referencia del pacs será la referencia de la orden de venta
			$miRef = substr($row[1], 2); $miRef = str_replace("-","",$miRef);
			
			$now1 = $row[14];
			if($now1<20151008){
				if($row[12]!=55){
					$row[5] = "<span name='$miRef' id='$miRef' lang='$row[8]' onClick='est(this.lang, this.lang, this.id)' style='cursor:pointer; text-decoration:underline; font-style:italic;'>$row[5]</span>";
				}else{
					$row[5] = "<span name='$miRef' id='$miRef$row[14]' lang='$row[8]' onClick='est(this.lang, this.lang, this.id)' style='cursor:pointer; text-decoration:underline; font-style:italic;'>$row[5]</span>";
				}
			}else{
				if($row[12]==55){
					$row[5] = "<span name='$miRef' id='$miRef' lang='$row[8]' onClick='est(this.lang, this.lang, this.id)' style='cursor:pointer; text-decoration:underline; font-style:italic;'>$row[5]</span>";
				}else{
					$row[5] = "<span name='$miRef' id='$miRef$row[14]' lang='$row[8]' onClick='est(this.lang, this.lang, this.id)' style='cursor:pointer; text-decoration:underline; font-style:italic;'>$row[5]</span>";
				}
			}
		}
	}
	//fin imagen
	
	//para laboratorio
	if($row[9]==3){
		if($row[10]==7){//Para los estudios en estatus autorizado name='$row[8]' id='$row[8]' lang='$row[9]'
			$row[5] = "<span name='$row[11]' id='$row[11]' lang='$row[8]' onClick='imprimir(this.id, this.lang, $nombreEstu)' style='cursor:pointer; text-decoration:underline; font-style:italic;'>$row[5]</span>";
		}	
		if($row[10]==8){//Para los estudios en estatus cargado
			$row[5] = "<span name='' id='$row[8]' lang='$row[8]' onClick='visualizar(this.id, this.lang)' style='cursor:pointer; text-decoration:underline; font-style:italic;'>$row[5]</span>";
		}		
	}
	//fin laboratorio
		$output['aaData'][] = $row;
    }
    echo json_encode( $output );
?>