<?php
require("../../../Connections/horizonte.php");
require("../../../funciones/php/values.php");
     
    $aColumns = array('s.id', 's.referencia_compra','g.nombre_generico_med', 'c.concepto_to', 's.Lote','su.nombre_su',  's.cantidad', 's.fecha_expiracion', 's.costo_unitario','CONCAT_WS("<br>", u.usuario_u, DATE_FORMAT(s.fecha_update,"%H:%i:%s"))', 'pr.nombre_pr', 'pr.nombre_pr', 's.folio');
    // DB tables to use 
    $aTables = array( 'stock_has_bach s');
     
    // Indexed column (used for fast and accurate table cardinality) 
    $sIndexColumn = "s.id";
     
	 // Joins   
	$sJoin = 'left join conceptos c on c.id_to = s.id_Producto left join stock s1 on s1.id = s.id_stock left join usuarios u on u.id_u = s.usuario_registro left join sucursales su on su.id_su = s1.id_su left join medicamentos g on g.id_med = c.id_medicamento_g left join estatus es on es.id_est = s.estatus left join proveedores pr on pr.clave_pr = s.id_proveedor';

    mysql_select_db($database_horizonte, $horizonte); 
	$resultAU = mysql_query("SELECT multisucursal_u, idSucursal_u from usuarios where id_u = '$_GET[idU]'",$horizonte) or die (mysql_error());
	$rowAU = mysql_fetch_row($resultAU); $id_suc = sqlValue($rowAU[1], "int");

    $todos = "";
    $verde = " AND fecha_expiracion >= CURDATE() + INTERVAL 12 MONTH ";
    $amarillo = " AND fecha_expiracion > CURDATE() + INTERVAL 6 MONTH AND fecha_expiracion <= CURDATE() + INTERVAL 11 MONTH ";
    $rojo = " AND fecha_expiracion > CURDATE() + INTERVAL 15 DAY AND fecha_expiracion <= CURDATE() + INTERVAL 6 MONTH ";
    $negro = " AND fecha_expiracion <= CURDATE() + INTERVAL 15 DAY ";

    if(isset($_GET['s_colores']) && $_GET['s_colores'] == 0){
        $condicion_fecha = $todos;
    }else if(isset($_GET['s_colores']) && $_GET['s_colores'] == 1){
        $condicion_fecha = $verde;
    }else if(isset($_GET['s_colores']) && $_GET['s_colores'] == 2){
        $condicion_fecha = $amarillo;
    }else if(isset($_GET['s_colores']) && $_GET['s_colores'] == 3){
        $condicion_fecha = $rojo;
    }else if(isset($_GET['s_colores']) && $_GET['s_colores'] == 4){
        $condicion_fecha = $negro;
    }
	
    switch($rowAU[0]){
		case 0://Solo vé lo suyo
			if(isset($_GET['min']) && isset($_GET['max']) && $_GET['min'] != '' && $_GET['max'] != ''){
			  $sWhere="WHERE (s.fecha_update BETWEEN '$_GET[min]' AND '$_GET[max]' and s.usuario_registro = '$_GET[idU]') AND s.es_traspaso = 0 $condicion_fecha ";
			}else{
			  $sWhere = "where s.usuario_registro = '$_GET[idU]' AND s.es_traspaso = 0 $condicion_fecha ";
			}
		break;
		case 2://Ve todo lo de su sucursal y lo suyo
			if(isset($_GET['min']) && isset($_GET['max']) && $_GET['min'] != '' && $_GET['max'] != ''){
			  $sWhere="WHERE (s.fecha_update BETWEEN '$_GET[min]' AND '$_GET[max]' and (s1.id_su = $id_suc or s.usuario_registro = '$_GET[idU]')) AND s.es_traspaso = 0 $condicion_fecha ";
			}else{
			  $sWhere = "WHERE (s1.id_su = $id_suc or s.usuario_registro = '$_GET[idU]') AND s.es_traspaso = 0 $condicion_fecha ";
			}
		break;
		case 1://Ve todo de todas las sucursales
			if(isset($_GET['min']) && isset($_GET['max']) && $_GET['min'] != '' && $_GET['max'] != ''){
			  $sWhere="WHERE (s.fecha_update BETWEEN '$_GET[min]' AND '$_GET[max]') AND s.es_traspaso = 0 $condicion_fecha";
			}else{
			  $sWhere = "WHERE 1 = 1 AND s.es_traspaso = 0 $condicion_fecha ";
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
    $sOrder = "GROUP BY s.id order by s.id DESC";
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

            $busqueda = "%" . htmlentities($_GET['sSearch_' . $i]) . "%";
            if($i == 9){
                $sWhere .= $aColumns[11]." LIKE '".$busqueda."' ";
            }else if($i == 11){
                $sWhere .= $aColumns[12]." LIKE '".$busqueda."' ";
            } else {
                $sWhere .= $aColumns[$i]." LIKE '".$busqueda."' ";
            }
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

        $id_stock = $row[0];
        $folio = $row[1];
        $row[0]="<span id='{$id_stock}' onClick='resumenCompra(this.id, \"$folio\");'class='btn btn-primary' ><i class='fa fa-eye' ></i></span>";

       //fecha  de caducidad que viene de BD
        $fechaCadu = substr($row[7],0,10);
        //le restamos una mes a la fecha de caducidad para poder compararla
        /* $Alertafecha = date('Y-m-d', strtotime($fechaCadu.'-1 month'));
         //sacar la fecha actual
        $now = date('Y-m-d');

        //verificamos si la fecha actual supera a la fecha de caducidad que tiene un mes restado
        if($now > $Alertafecha){
            $row[7]= "<span class='btn btn-danger disabled' >".$fechaCadu."</span>";
        }else{
            $row[7]= $fechaCadu;
        } */

        $Alertafecha0 = date('Y-m-d', strtotime($fechaCadu.'-15 day'));
        $Alertafecha = date('Y-m-d', strtotime($fechaCadu.'-6 month'));
        $Alertafecha2 = date('Y-m-d', strtotime($fechaCadu.'-11 month'));
        $Alertafecha3 = date('Y-m-d', strtotime($fechaCadu.'-12 month'));
        $now = date('Y-m-d');

        if($Alertafecha3 >= $now){
            $row[4]= "<span class='btn btn-success disabled' style='color:black;'>".$fechaCadu."</span>";
        }else if($Alertafecha >= $now && $Alertafecha2 <= $now){
            $row[4]= "<span class='btn btn-warning disabled' style='color:black;'>".$fechaCadu."</span>";
        }else if($Alertafecha0 > $now && $Alertafecha <= $now){
            $row[4]= "<span class='btn btn-danger disabled' style='color:black;'>".$fechaCadu."</span>";
        }else if($Alertafecha0 <= $now){
            $row[4]= "<span class='btn disabled' style='color:white; background-color:black'>".$fechaCadu."</span>";
        }else{
            $row[4]= "<span>".$fechaCadu."</span>";
        }

       $query_factura_compra = "SELECT nombre_factura FROM compra_factura WHERE referencia_compra = '{$folio}'";
       $resultado_query_factura_compra = mysql_query($query_factura_compra, $horizonte) or die (mysql_error());
       $class_factura = mysql_num_rows($resultado_query_factura_compra) == 0 ? "btn-danger" : "btn-success";
       $nombre_factura = mysql_fetch_object($resultado_query_factura_compra)->nombre_factura;
       $facturado = $class_factura == "btn-danger" ? 0 : 1;

       $query_usuario_subio_factura = "SELECT u.usuario_u AS usuario, fecha_hora FROM usuarios u LEFT JOIN compra_factura cf ON cf.id_usuario = u.id_u WHERE cf.referencia_compra = '{$folio}'";
       $resultado_query_usuario_subio_factura = mysql_query($query_usuario_subio_factura, $horizonte);
       $info_usuario = mysql_fetch_object($resultado_query_usuario_subio_factura);
       $usuario_responsable = $info_usuario->usuario == "" ? $_GET['idU'] : $info_usuario->usuario;
       $fecha_hora = $info_usuario->fecha_hora;
       $row[10] = "<button type='button' onclick='verFacturaCompra({$id_stock}, \"{$folio}\", this, {$facturado}, \"{$nombre_factura}\", \"{$usuario_responsable}\", \"{$fecha_hora}\");' class='btn {$class_factura} btn-sm'><i class='fa fa-file-pdf-o' aria-hidden='true'></i></button>";
       
       $row[1] = "<span>{$folio}<br>{$row[9]}</span>";
       
       $row[9] = $row[11];
       $row[11] = $row[12];

		$output['aaData'][] = $row;
    }
	
    echo json_encode( $output );
?>
