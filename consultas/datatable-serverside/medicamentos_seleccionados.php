<?php
require("../../Connections/horizonte.php");
	$aColumns = array('mr.id_mr', 'c.concepto_to', 'm.nombre_generico_med','m.descripcion_med','m.cantidad_med','m.via_administracion_med', 'mr.id_mr', 'mr.id_mr', 'mr.id_mr', 'mr.id_co_mr' );
     
    // DB tables to use 
    $aTables = array( 'medicamentos_receta mr');
     
    // Indexed column (used for fast and accurate table cardinality) 
    $sIndexColumn = "mr.id_mr";
     
	 // Joins   
	$sJoin = ' left join conceptos c on c.id_to = mr.id_med_mr left join medicamentos m on m.id_med = c.id_medicamento_g ';
	 
    // CONDITIONS 
    $sWhere = "WHERE mr.id_co_mr = '$_GET[idC]' and c.id_area_to = 61 and c.id_departamento_to = 3 and c.id_tipo_concepto_to = 5 ";

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
        if ( $sOrder == "ORDER BY" )  { $sOrder = ""; }
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
     
    /*  * Output */
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
        $id_medicamento_receta = intval($row[8]);
		$row[0]=$hh;
        $row[1] = "<div><span onclick='visualizarAntagonismos({$row[8]});' style='cursor: pointer'>{$row[1]}</span></div>";
		$row[8] = "<div align='center'><button onClick='borrarMed(this.id,this.lang);' id='$row[8]' lang='$row[9]' type='button' class='btn btn-danger btn-xs'><i class='fa fa-trash' aria-hidden='true' alt='Eliminar medicamento'></i></button></div>";

        // Creamos una nueva conexión a mysql por medio de mysqli
        $conexion = mysqli_connect($hostname_horizonte, $username_horizonte, $password_horizonte, $database_horizonte);
        
        // Para obtener y devolver las sinergias y antagonismos de un medicamento primero debemos obtener el id del medicamento comercial
        $select = $conexion->prepare("SELECT c.id_to AS id_medicamento_comercial FROM medicamentos_receta mr LEFT JOIN conceptos c ON c.id_to = mr.id_med_mr WHERE mr.id_mr = ? LIMIT 1");
        $select->bind_param('i', $id_medicamento_receta);
        if (!$select->execute()) {
            die(mysqli_error($conexion));
        }
        $id_medicamento_comercial = intval($select->get_result()->fetch_object()->id_medicamento_comercial);

        // Obtenemos las sinergias del medicamento
        $selectIdS = $conexion->prepare("SELECT s.id_medicamento FROM sinergia s LEFT JOIN medicamento_sinergia ms ON s.id = ms.id_sinergia WHERE ms.id_medicamento = ?");
        $selectIdS->bind_param("i", $id_medicamento_comercial);
        if (!$selectIdS->execute()) {
            die(mysqli_error($conexion));
        }
        $sinergias = [];
        $ids_sinergias = $selectIdS->get_result()->fetch_all(MYSQLI_ASSOC);
        foreach ($ids_sinergias as $id_sinergia) {
            $selectS = $conexion->prepare("SELECT c.concepto_to as medicamento FROM conceptos c LEFT JOIN medicamento_sinergia ms ON c.id_to = ms.id_medicamento WHERE c.id_to = ?");
            $selectS->bind_param("i", $id_sinergia['id_medicamento']);
            $selectS->execute();
            array_push($sinergias, $selectS->get_result()->fetch_object()->medicamento);
        }

        // Obtenemos los antagonismos del medicamento
        $selectIdA = $conexion->prepare("SELECT a.id_medicamento FROM antagonismo a LEFT JOIN medicamento_antagonismo ma ON a.id = ma.id_antagonismo WHERE ma.id_medicamento = ?");
        $selectIdA->bind_param("i", $id_medicamento_comercial);
        if (!$selectIdA->execute()) {
            die(mysqli_error($conexion));
        }

        $antagonismos = [];
        $ids_antagonismos = $selectIdA->get_result()->fetch_all(MYSQLI_ASSOC);
        foreach ($ids_antagonismos as $id_antagonismo) {
            $selectA = $conexion->prepare("SELECT c.concepto_to as medicamento FROM conceptos c LEFT JOIN medicamento_antagonismo ma ON c.id_to = ma.id_medicamento WHERE c.id_to = ?");
            $selectA->bind_param("i", $id_antagonismo['id_medicamento']);
            $selectA->execute();
            array_push($antagonismos, $selectA->get_result()->fetch_object()->medicamento);
        }

        // Cerramos las conexión a mysql
        mysqli_close($conexion);

        $temp2 = $row[2];
        $temp3 = $row[3];
        $temp4 = $row[4];
        $temp5 = $row[5];
        $temp6 = $row[6];
        $row[4] = $temp2;
        $row[5] = $temp3;
        $row[6] = $temp4;
        $row[6] = $temp5;

        // Asignamos las sinergias y los antagonismos al elemento html que los mostrará en la tabla de medicamentos seleccionados
        $htmlSinergias = "";
        foreach ($sinergias as $sinergia) {
            $htmlSinergias .= "<p>{$sinergia}</p>";
        }

        $htmlAntagonismos = "";
        foreach ($antagonismos as $antagonismo) {
            $htmlAntagonismos .= "<p>{$antagonismo}</p>";
        }

        $row[2] = $htmlSinergias;
        $row[3] = $htmlAntagonismos;

		$output['aaData'][] = $row;
    }
    echo json_encode( $output );
?>