<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

	$idP = sqlValue($_GET["id_p"], "int");

	$aColumns = array('n.id_nh', 'DATE_FORMAT(n.fecha_nh,"%d/%m/%Y")', 'nm.nombre_nm', 'concat(t.abreviacion_ti," ",u.nombre_u," ",apaterno_u)', 'n.id_nh', 'n.id_hospitalizacion_nh', 'p.id_p', 'p.nombre_completo_p', 'o.sucursal_ov','usuario_nh');
     
    // DB tables to use 
    $aTables = array( 'notas_de_hospital n');
     
    // Indexed column (used for fast and accurate table cardinality) 
    $sIndexColumn = "n.id_nh";
     
	 // Joins   hasta aqui
	$sJoin = 'left join notas_medicas nm on nm.id_nm = n.id_nota_nh left join usuarios u on u.id_u = n.usuario_nh left join titulos t on t.id_ti = u.id_titulo_u left join hospitalizacion h on h.id_h = n.id_hospitalizacion_nh left join pacientes p on p.id_p = h.id_paciente_h left join venta_conceptos v on v.id_vc = h.id_consulta_vc_h left join orden_venta o on o.referencia_ov = v.referencia_vc';
	 
    // CONDITIONS
	$sWhere = "where id_hospitalizacion_nh = '$_GET[id_h]' AND roll_nh IS NULL";	
	
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
    $sOrder = "ORDER BY n.id_nh desc";
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
        $idNota = $row[0];
		$row[0] = "<div align='center'>$hh</div>";
		
		$nombre_p = '"'.$row[7].'"';
        $tUser ="MEDICAS";
        $estatus = $_GET['estatus'];
										
		$row[4] = "<div align='center'><button onClick='ver_nota($row[5], $row[6], $nombre_p, $row[8], $row[4], \"$tUser\",\"$estatus\")' lang='$row[4]' class='btn btn-primary btn-xs ver_nota'><i class='fa fa-eye' aria-hidden='true'></i> </button></div>";
        $id_h = $row[5];

        if(($_GET['estatus'] == 'EGRESADO') || $_GET['idU'] != $row[9]){
            $row[5] = "<div align='center'><button onClick='editar_nota($id_h,$row[6],$nombre_p, $row[8], $idNota,\"$tUser\",\"$estatus\")' lang='' class='btn btn-primary btn-xs ver_nota' disabled ='true'><i class='fa fa-pencil' aria-hidden='true'></i> </button></div>";

        }else{
            $row[5] = "<div align='center'><button onClick='editar_nota($id_h,$row[6],$nombre_p, $row[8], $idNota, \"$tUser\",\"$estatus\")' lang='' class='btn btn-primary btn-xs ver_nota'><i class='fa fa-pencil' aria-hidden='true'></i> </button></div>";
        }
		$output['aaData'][] = $row;
		
    }
    echo json_encode( $output );
?>
