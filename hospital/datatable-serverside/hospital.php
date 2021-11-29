<?php
require("../../Connections/horizonte.php"); 
    /* Array of database columns which should be read and sent back to DataTables. Use a space where * you want to insert a non-database field (for example a counter or static image) */
	
	$aColumns = array('h.id_h', 'p.nombre_completo_p', 'DATE_FORMAT(h.fecha_inicio_h,"%d/%m/%Y %H:%i:%s")', 'concat(c.no_ca," ",c.ubicacion_ca)', 'm.usuario_u', 'h.id_h', 'h.id_h', 'h.id_h', 'h.id_h', 'h.id_h', 'h.id_h', 'es.estatus_est', 'DATE_FORMAT(h.fecha_fin_h,"%d/%m/%Y %H:%i:%s")', 'h.id_h', 'h.id_h', 'h.id_h', 'h.id_h', 'es.id_est', 'h.id_h', 'h.id_h', 'p.id_p', 'o.sucursal_ov', 'h.id_cama_h', 'h.id_consulta_vc_h', 'u1.usuario_u', 'u.usuario_u');
     
    // DB tables to use 
    $aTables = array( 'hospitalizacion h');
     
    // Indexed column (used for fast and accurate table cardinality) 
    $sIndexColumn = "h.id_h";
     
	 // Joins   
	$sJoin = 'left JOIN pacientes p ON p.id_p = h.id_paciente_h left join estatus es on es.id_est = h.estatus_h left join camas c on c.id_ca = h.id_cama_h left join usuarios m on m.id_u = h.id_medicoh_h left join venta_conceptos v on v.id_vc = h.id_consulta_vc_h left join orden_venta o on o.referencia_ov = v.referencia_vc left join usuarios u1 on u1.id_u = h.id_usuario_egreso_h left join usuarios u on u.id_u = h.id_usuario_h';
	 
	if(isset($_GET['min']) && isset($_GET['max']) && $_GET['min'] != '' && $_GET['max'] != ''){
        // el campo  __11 hace referencia a la columna es.estatus_est si se cambia de posicion dentro del arreglo $aColumns modificarlo tambien  en este if para la funcionalidad del  filtro individual de estatus
        if ( isset($_GET['bSearchable_11']) && $_GET['bSearchable_11'] == "true" && $_GET['sSearch_11'] != '' ){
            $sWhere="WHERE h.estatus_h in (13,15,16) AND h.fecha_inicio_h BETWEEN '$_GET[min]' AND '$_GET[max]'";
        }else{
            $sWhere="WHERE (h.estatus_h = 13) OR (h.estatus_h in (15,16) AND h.fecha_inicio_h BETWEEN '$_GET[min]' AND '$_GET[max]')";
        }
	}else{
	 $sWhere="WHERE h.estatus_h in (13,15,16)";
	}
	
    /* Database connection information */
    $gaSql['user']       = $username_horizonte; $gaSql['password']   = $password_horizonte; $gaSql['db']         = $database_horizonte; $gaSql['server']     = $hostname_horizonte;
     
    $gaSql['link'] =  mysql_pconnect( $gaSql['server'], $gaSql['user'], $gaSql['password']  ) or die( 'Could not open connection to server' );
     
    mysql_select_db( $gaSql['db'], $gaSql['link'] ) or die( 'Could not select database '. $gaSql['db'] );
     
     
    /*  * Paging */
    $sLimit = "";
    if ( isset( $_GET['iDisplayStart'] ) && $_GET['iDisplayLength'] != '-1' )
    {
        $sLimit = "LIMIT ".mysql_real_escape_string( $_GET['iDisplayStart'] ).", ".
            mysql_real_escape_string( $_GET['iDisplayLength'] );
    }
     
     
    /* * Ordering */
    $sOrder = "ORDER BY h.estatus_h, h.fecha_inicio_h desc"; //ORDENA estatus_h de forma acendente  y  fecha_inicio_h de forma decendente
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
        // echo  $sQuery;
      
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
		$nombreP = '"'.$row[1].'"';
		
		$row[0]=$hh;
        $row[2] = '<div align="center">'. $row[2]."<br>".$row[25].'</div>';
		
		if($row[3]==''){ $row[3] = '<div align="center">-No asignado-</div>'; }
		$estatus = $row[11]; //rescatamos el estatus antes de que se tranforme
		$row[11] = "<span title='$row[19] $row[20]'>".($row[12]==''?$row[11]:'EGRESADO')."</span>";
		
		mysql_select_db($database_horizonte, $horizonte);
		$result1 = mysql_query("SELECT count(h.id_nh) from notas_de_hospital h where h.id_hospitalizacion_nh = $row[5] and h.tipo_nota_nh = 1 ", $horizonte) or die (mysql_error());
		$row1 = mysql_fetch_row($result1);
		
		mysql_select_db($database_horizonte, $horizonte);
		$result1a = mysql_query("SELECT h.aleatorio_nh from notas_de_hospital h where h.id_hospitalizacion_nh = $row[5] limit 1", $horizonte) or die (mysql_error());
		$row1a = mysql_fetch_row($result1a);
		
		$row[5] ="<div align='center'><button type='button' class='btn btn-primary btn-sm' onClick='notasMedicas($row[19],$row[20],$nombreP,$row[21],\"$estatus\");'>$row1[0]</button></div>";
		
		mysql_select_db($database_horizonte, $horizonte);
		$result2 = mysql_query("SELECT count(h.id_nh) from notas_de_hospital h where h.id_hospitalizacion_nh = $row[6] and h.tipo_nota_nh = 2 ", $horizonte) or die (mysql_error());
		$row2 = mysql_fetch_row($result2);
		
		mysql_select_db($database_horizonte, $horizonte);
		$result3 = mysql_query("SELECT count(DISTINCT h.id_medicamento_mh) from medicamentos_hospital h where h.id_hospitalizacion_mh = $row[6]", $horizonte) or die (mysql_error());
		$row3 = mysql_fetch_row($result3);
		
		$row[6] = "<div align='center'><button type='button' class='btn btn-primary btn-sm' onClick=''><i class='fa fa-book' aria-hidden='true'></i></button></div>";
		
		$row[7] = "<div align='center'><button type='button' class='btn btn-primary btn-sm' onClick='medicamentos($row[19],$row[20],$nombreP,$row[21],\"$estatus\");'><i class='fa fa-medkit' aria-hidden='true'></i></button></div>";
		
		$row[8] = "<div align='center'><button type='button' class='btn btn-primary btn-sm' onClick='verSignosV($row[20], $row[23],0,$row[21],$row[21],0)'><i class='fa fa-eye' aria-hidden='true'></i></button></div>";
		        
        // Se envia el id de venta concepto y el id del paciente y el estatus del hospitalizado
        $row[9] = "<div align='center'><button type='button' class='btn btn-primary btn-sm' onClick='diagnosticos($row[23],$row[20],\"$estatus\")'><i class='fa fa-list' aria-hidden='true'></i></button></div>";

		$row[10] = "<div align='center'><button type='button' class='btn btn-primary btn-sm' onClick=''><i class='fa fa-camera' aria-hidden='true'></i></button></div>";
		
        // Se envia el id de la hospitalización y el id de la cama
		if($row[12]==''){ $row[12] = '<div align="center"><button type="button" class="btn btn-primary btn-sm" onClick="egresar('.$aRow[0].', '.$aRow[22].');">Egresar</button></div>'; }else{
            $row[12] = '<div align="center">'.$row[12].'<br>'.$row[24].'</div>';
        }

        // $row[13] = $aRow;
							
		$output['aaData'][] = $row;
    }
     
    echo json_encode( $output );
?>
