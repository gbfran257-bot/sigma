<?php
require("../../../Connections/horizonte.php");
require("../../../funciones/php/values.php");
     
    $aColumns = array('s.id', 's.id','s.referencia_compra','g.nombre_generico_med', 'c.concepto_to', 's.Lote','su.nombre_su',  's.cantidad', 's.fecha_expiracion', 's.costo_unitario','CONCAT_WS("<br>", u.usuario_u, DATE_FORMAT(s.fecha_update,"%d/%c/%Y"), DATE_FORMAT(s.fecha_update,"%H:%i:%s"))');
    // DB tables to use 
    $aTables = array( 'stock_has_bach s');
     
    // Indexed column (used for fast and accurate table cardinality) 
    $sIndexColumn = "s.id";
     
	 // Joins   
	$sJoin = 'left join conceptos c on c.id_to = s.id_Producto left join stock s1 on s1.id = s.id_stock left join usuarios u on u.id_u = s.usuario_registro left join sucursales su on su.id_su = s1.id_su left join medicamentos g on g.id_med = c.id_medicamento_g left join estatus es on es.id_est = s.estatus';

    mysql_select_db($database_horizonte, $horizonte); 
	$resultAU = mysql_query("SELECT multisucursal_u, idSucursal_u from usuarios where id_u = '$_GET[idU]'",$horizonte) or die (mysql_error());
	$rowAU = mysql_fetch_row($resultAU); $id_suc = sqlValue($rowAU[1], "int");
	
    switch($rowAU[0]){
		case 0://Solo vé lo suyo
			if(isset($_GET['min']) && isset($_GET['max']) && $_GET['min'] != '' && $_GET['max'] != ''){
			  $sWhere="WHERE (s.fecha_update BETWEEN '$_GET[min]' AND '$_GET[max]' and s.usuario_registro = '$_GET[idU]') AND s.es_traspaso = 0";
			}else{
			  $sWhere = "where s.usuario_registro = '$_GET[idU]' AND s.es_traspaso = 0";
			}
		break;
		case 2://Ve todo lo de su sucursal y lo suyo
			if(isset($_GET['min']) && isset($_GET['max']) && $_GET['min'] != '' && $_GET['max'] != ''){
			  $sWhere="WHERE (s.fecha_update BETWEEN '$_GET[min]' AND '$_GET[max]' and (s1.id_su = $id_suc or s.usuario_registro = '$_GET[idU]')) AND s.es_traspaso = 0";
			}else{
			  $sWhere = "WHERE (s1.id_su = $id_suc or s.usuario_registro = '$_GET[idU]') AND s.es_traspaso = 0";
			}
		break;
		case 1://Ve todo de todas las sucursales
			if(isset($_GET['min']) && isset($_GET['max']) && $_GET['min'] != '' && $_GET['max'] != ''){
			  $sWhere="WHERE (s.fecha_update BETWEEN '$_GET[min]' AND '$_GET[max]') AND s.es_traspaso = 0";
			}else{
			  $sWhere = "WHERE 1 = 1 AND s.es_traspaso = 0";
			}
		break;
		default:
			echo 'Ha ocurrido un error';
	}
	
    /* Database connection information */
    $gaSql['user']       = $username_horizonte;
    $gaSql['password']   = $password_horizonte;
    $gaSql['db']         = $database_horizonte;
    $gaSql['server']     = $hostname_horizonte;
 
    $gaSql['link'] =  mysql_pconnect( $gaSql['server'], $gaSql['user'], $gaSql['password']  ) or die( 'Could not open connection to server' );
     
    mysql_select_db( $gaSql['db'], $gaSql['link'] ) or die( 'Could not select database '. $gaSql['db'] );
     
    /*  * Paging */
    $sLimit = "";
    if ( isset( $_GET['iDisplayStart'] ) && $_GET['iDisplayLength'] != '-1' ) { $sLimit = "LIMIT ".mysql_real_escape_string( $_GET['iDisplayStart'] ).", ". mysql_real_escape_string( $_GET['iDisplayLength'] ); }
     
    /* * Ordering */
    $sOrder = "order by s.id desc";
    if ( isset( $_GET['iSortCol_0'] ) )
    {
        $sOrder = "ORDER BY v.id_vc desc  ";
        for ( $i=0 ; $i<intval( $_GET['iSortingCols'] ) ; $i++ ) { if ( $_GET[ 'bSortable_'.intval($_GET['iSortCol_'.$i]) ] == "true" ) { $sOrder .= $aColumns[ intval( $_GET['iSortCol_'.$i] ) ]." ".mysql_real_escape_string( $_GET['sSortDir_'.$i] ) .", "; } }
         
        $sOrder = substr_replace( $sOrder, "", -2 );
        if ( $sOrder == "ORDER BY" ) { $sOrder = ""; }
    }
     
    /*  * Filtering * NOTE this does not match the built-in DataTables filtering which does it * word by word on any field. It's possible to do here, but concerned about efficiency * on very large tables, and MySQL's regex functionality is very limited */
 
    if ( isset($_GET['sSearch']) && $_GET['sSearch'] != "" )
    {
        $sWhere .= "AND (";
        for ( $i=0 ; $i<count($aColumns) ; $i++ ) { $sWhere .= $aColumns[$i]." LIKE '%".mysql_real_escape_string( $_GET['sSearch'] )."%' OR "; }
        $sWhere = substr_replace( $sWhere, "", -3 );
        $sWhere .= ')';
    }
     
    /* Individual column filtering */
    for ( $i=0 ; $i<count($aColumns) ; $i++ )
    {
        if ( isset($_GET['bSearchable_'.$i]) && $_GET['bSearchable_'.$i] == "true" && $_GET['sSearch_'.$i] != '' )
        {
            if ( $sWhere == "" ) { $sWhere = "WHERE "; } else { $sWhere .= " AND "; }
            $sWhere .= $aColumns[$i]." LIKE '%".mysql_real_escape_string($_GET['sSearch_'.$i])."%' ";
        }
    }
     
    /*  * SQL queries  * Get data to display */
    $sQuery = "
        SELECT SQL_CALC_FOUND_ROWS ".str_replace(" , ", " ", implode(", ", $aColumns))."
        FROM   ".str_replace(" , ", " ", implode(", ", $aTables))."
		$sJoin
        $sWhere
        $sOrder
        $sLimit";

    $rResult = mysql_query( $sQuery, $gaSql['link'] ) or die(mysql_error());
     
    /* Data set length after filtering */
    $sQuery = " SELECT FOUND_ROWS() ";
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
        { if ( $aColumns[$i] == "version" ) { /* Special output formatting for 'version' column */ $row[] = ($aRow[ $aColumns[$i] ]=="0") ? '-' : $aRow[ $aColumns[$i] ]; } else if ( $aColumns[$i] != ' ' ) { /* General output */ $row[] = $aRow[$i]; } }
		$row1 = array();
        for ( $j=0 ; $j<count($aColumns) ; $j++ ) { if ( $aColumns[$j] == "version" ) { $row1[] = ($aRow[ $aColumns[$j] ]=="0") ? '-' : $aRow[ $aColumns[$j] ]; } else if ( $aColumns[$j] != ' ' ) { $row1[] = $aRow[$j]; } }

        $row[0]="<span id='$row[1]' onClick='resumenCompra(this.id, \"$row[2]\");'class='btn btn-primary' ><i class='fa fa-eye' ></i></span>";

        if($row[8] == "PENDIENTE"){
            $row[8] ="<span id='$row[0]' onClick='estatus(this.id)' style='cursor:pointer; text-decoration:underline;'>PENDIENTE</span>";
        }

       //fecha  de caducidad que viene de BD
        $fechaCadu = substr($row[9],0,10);
        //le restamos una mes a la fecha de caducidad para poder compararla
        $Alertafecha = date('Y-m-d', strtotime($fechaCadu.'-1 month'));
         //sacar la fecha actual
        $now = date('Y-m-d');

        //verificamos si la fecha actual supera a la fecha de caducidad que tiene un mes restado
        if($now > $Alertafecha){
            $row[9]= "<span class='btn btn-danger disabled' >".$fechaCadu."</span>";
        }else{
            $row[9]= $fechaCadu;
        }

        $id_stock = $row[1];
       /* $row[0]= $hh; */

       // Consultamos el proveedor del producto
       $query_proveedor_producto = "SELECT nombre_p AS proveedor FROM pacientes p LEFT JOIN stock_has_bach shb ON MD5(p.id_p) = shb.id_proveedor WHERE shb.id = {$id_stock}";
       $resultado_query_proovedor_producto = mysql_query($query_proveedor_producto, $horizonte) or die (mysql_error());
       $proveedor = mysql_fetch_object($resultado_query_proovedor_producto)->proveedor;
       $row[11] = $proveedor == "" || $proveedor == null ? "Sin proveedor" : $proveedor;
       $row[12] = "<button type='button' onclick='verFacturaCompra(this);' class='btn btn-success btn-sm'><i class='fa fa-file-pdf-o' aria-hidden='true'></i></button>";
		
		$output['aaData'][] = $row;
    }
	
    echo json_encode( $output );
?>
