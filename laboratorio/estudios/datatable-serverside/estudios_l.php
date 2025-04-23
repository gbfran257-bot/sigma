<?php
require("../../../Connections/horizonte.php");

include_once '../../../recursos/session.php';
include_once '../../../Connections/database.php';
include_once '../../../recursos/utilities.php';

	$id_user = $_SESSION['id']; $acceso_user = $_SESSION['MM_UserGroup'];
	
	if(isset($_GET['idSu'])){
		//primero tenemos que saber si existe su tabulador, sino entnces escogemos el tabulador base
		$tabu = $_GET['idSu'].'_precio'; $resultT = mysql_query("SHOW COLUMNS FROM conceptos LIKE '$tabu' ");
		$existsT = (mysql_num_rows($resultT))?TRUE:FALSE;
		if($existsT) { $precio_nor = $_GET['idSu'].'_precio'; $precio_ur = $_GET['idSu'].'_precio_u';}
		else{ $precio_nor = 'c.precio_to'; $precio_ur = 'c.precio_urgencia_to'; }
		/// 'c.precio_to','c.precio_urgencia_to' deberia ser costo_maquila y costomaquilau
        /// 'c.precio1_to','c.precio_urgencia1_to' deberia ser precio_to y precio_urgen_to
		$aColumns = array('c.id_to','c.concepto_to', 'a.nombre_a', 'c.dias_entrega_to', $precio_nor,$precio_ur,
            'c.costo_maquila_to','c.costo_maquila_u_to', 'c.precio_to','c.precio_urgencia_to', 'u.usuario_u','c.linea_c','c.sat_c','c.id_to', 'c.aleatorio_c', 'DATE_FORMAT(c.fecha_to,"%d/%m/%Y %H:%i")');
	}else{
		$aColumns = array('c.id_to', 'c.concepto_to', 'a.nombre_a', 'c.dias_entrega_to', 'c.precio_to','c.precio_urgencia_to',
            'c.costo_maquila_to','c.costo_maquila_u_to', 'c.precio_to','c.precio_urgencia_to', 'u.usuario_u','c.linea_c','c.sat_c','c.id_to', 'c.aleatorio_c', 'DATE_FORMAT(c.fecha_to,"%d/%m/%Y %H:%i")');
	}
	    
    // DB tables to use 
    $aTables = array( 'conceptos c');
     
    // Indexed column (used for fast and accurate table cardinality) 
    $sIndexColumn = "c.id_to";
     
	 // Joins hasta aqui
	$sJoin = 'left join areas a on a.id_a = c.id_area_to left join usuarios u on u.id_u = c.usuario_to';
	 
    // CONDITIONS
    $sWhere = "where c.id_tipo_concepto_to = 3 and c.concepto_to not like '%BIOMETRIA HEMATICA EN%' " ;
	
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
        if ( $sOrder == "ORDER BY" ){ $sOrder = ""; }
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
            if ( $sWhere == "" ) { $sWhere = "WHERE "; }else { $sWhere .= " AND "; }
            $sWhere .= $aColumns[$i]." LIKE '%".mysql_real_escape_string($_GET['sSearch_'.$i])."%' ";
        }
    }
     
    /*
     * SQL queries
     * Get data to display
    */
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
		
		$row[0]="<span>$hh</span>";
		
		if($_GET['accesoU']==1 && $_GET['enExcel'] == 0){//globalisima
			$row[1]= "<span class='text-info' style='cursor:pointer; text-decoration:underline;' lang='$row[14]' id='$row[13]' onClick='fichaEstudio(this.id, this.lang);'>$row[1]</span>";
			
            $row[6]="<input type='text' class='form-control input-sm precio_m_i' value='$row[6]' style='width:75px; text-align:right;' lang='$row[13]'>";
            $row[7]="<input type='text' class='form-control input-sm precio_m_u_i' value='$row[7]' style='width:75px; text-align:right;' lang='$row[13]'>";
            $r8 = $row[8];
            $row[8]="<input type='text' class='form-control input-sm tabu_m_i' value='$row[4]' style='width:75px; text-align:right;' lang='$row[13]' id='e_precio_$row[13]'>";
            $r9 = $row[9];
            $row[9]="<input type='text' class='form-control input-sm tabu_m_u_i' value='$row[5]' style='width:75px; text-align:right;' lang='$row[13]' id='e_precio_u_$row[13]'> <button onclick='updatePrecioSucursal($row[13]);' id='' class='btn btn-info btn-xs' title=''><i class='fa fa-pencil' aria-hidden='true'></i></button>";
			$row[3]="<input type='text' class='form-control input-sm dias_i' value='$row[3]' style='width:40px; text-align:right;' lang='$row[13]'>";
			$row[4]="<input type='text' class='form-control input-sm precio_p_i' value='$r8' style='width:75px; text-align:right;' lang='$row[13]'>";
			$row[5]="<input type='text' class='form-control input-sm precio_p_u_i' value='$r9' style='width:75px; text-align:right;' lang='$row[13]'>";
            //hacemos la suma de la productividad
            mysql_select_db($database_horizonte, $horizonte);
            $getProductividad = mysql_query("SELECT COALESCE(SUM(b.precio_maquila_b), 0)+COALESCE(c.c_costo, 0) FROM asignar_bases ab LEFT JOIN bases b ON b.id_b = ab.id_base_ab LEFT JOIN conceptos c ON c.aleatorio_c = ab.aleatorio_ab WHERE c.id_to = ".$row[13], $horizonte) or die (mysql_error());
            $runGetProd = mysql_fetch_row($getProductividad);
            $row[13] = $runGetProd[0];
			
		}else{ 
            $row[1]="<span id='$row[6]'>$row[1]</span>"; 
            $r8 = $row[8];
            $row[8]=$row[4];
            $r9 = $row[9];
            $row[9]=$row[5];
            $row[4]=$r8;
            $row[5]=$r9;
            $row[13] = "";
        }
		
		$row[10]="<div align='center'>$row[10]<br>$row[15]</div>";
										
		$output['aaData'][] = $row;
    }
    echo json_encode( $output );
?>
