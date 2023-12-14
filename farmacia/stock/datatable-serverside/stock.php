<?php
require("../../../Connections/horizonte.php");
require("../../../funciones/php/values.php");

include_once '../../../recursos/session.php';
include_once '../../../Connections/database.php';
include_once '../../../recursos/utilities.php';


$tipo_user = $_SESSION['MM_UserGroup'];
$sucu_user = $_SESSION['MM_Usersucu'];
     
    $aColumns = array('s.id', 'c.concepto_to', 's.Lote','su.nombre_su', 's.fecha_expiracion', 'u.usuario_u','DATE_FORMAT(s.fecha_update,"%d/%c/%Y %H:%i")','s.id_Producto','s.id_Producto','s.existencias','s.costo_unitario', 'c.precio_to', 's.id', 's.id', 's.id', 's.id','su.id_su','s.referencia_compra');
    // DB tables to use 
    $aTables = array( 'stock_has_bach s');
     
    // Indexed column (used for fast and accurate table cardinality) 
    $sIndexColumn = "s.id";
     
	 // Joins   
	$sJoin = 'left join conceptos c on c.id_to = s.id_Producto left join stock s1 on s1.id = s.id_stock left join usuarios u on u.id_u = s.usuario_registro left join sucursales su on su.id_su = s1.id_su left join medicamentos g on g.id_med = c.id_medicamento_g';

    mysql_select_db($database_horizonte, $horizonte); 
	$resultAU = mysql_query("SELECT multisucursal_u, idSucursal_u from usuarios where id_u = '$_GET[idU]'",$horizonte) or die (mysql_error());
	$rowAU = mysql_fetch_row($resultAU); $id_suc = sqlValue($rowAU[1], "int");
	
    switch($rowAU[0]){
		case 0://Solo vé lo suyo
            if(isset($_GET['cad']) && $_GET['cad'] == 'SI'){
                mysql_select_db($database_horizonte, $horizonte); 
                $resultAll = mysql_query("SELECT id, fecha_expiracion, existencias from stock_has_bach where existencias > 0 and usuario_registro = '$_GET[idU]' ",$horizonte) or die (mysql_error());
                $listaID = array();
                $cont = 0 ;

                //OBTENER LOS ID DE LOS REGISTROS CADUCADOS
                while ($fila = mysql_fetch_assoc($resultAll)) {
                    //fecha  de caducidad que viene de BD
                    $fechaCadu1 = substr($fila['fecha_expiracion'],0,10);
                    //le restamos una mes a la fecha de caducidad para poder compararla
                    $Alertafecha1 = date('Y-m-d', strtotime($fechaCadu1.'-1 month'));
                    //sacar la fecha actual
                    $now1 = date('Y-m-d');

                    if($now1 > $Alertafecha1){
                        $listaID[$cont]['id'] = $fila['id'];
                        $listaID[$cont]['fecha_expiracion'] = $fila['fecha_expiracion'];
                    }
                    $cont++;
                }
                $sWhere = "";
                if(count($listaID) > 0){
                    //RECORRE EL ARREGLO PARA FORMAR EL WHERE 
                    for ($i=0; $i < count($listaID); $i++) { 
                        if ( $sWhere == "" ) { $sWhere = "WHERE s.usuario_registro = ".$_GET['idU']; } else { $sWhere .= " OR "; }
                        $sWhere .= " s.id = ".$listaID[$i]['id'];
                    }
                }else{
                    $sWhere="WHERE s.id = 0 ";
                }
            //         echo count($listaID);
            //    print_r($listaID);
            }else{
                if(isset($_GET['exi']) && $_GET['exi'] == 'SI'){
                    if(isset($_GET['min']) && isset($_GET['max']) && $_GET['min'] != '' && $_GET['max'] != ''){
                        $sWhere="WHERE s.fecha_update BETWEEN '$_GET[min]' AND '$_GET[max]' and s.usuario_registro = '$_GET[idU]' AND s.existencias > 0";
                    }else{
                        $sWhere = "where s.usuario_registro = '$_GET[idU]' AND s.existencias > 0";
                    }
                }else{
                    if(isset($_GET['min']) && isset($_GET['max']) && $_GET['min'] != '' && $_GET['max'] != ''){
                        $sWhere="WHERE s.fecha_update BETWEEN '$_GET[min]' AND '$_GET[max]' and s.usuario_registro = '$_GET[idU]'";
                    }else{
                        $sWhere = "where s.usuario_registro = '$_GET[idU]'";
                    }
                }
            }
		break;
		case 2://Ve todo lo de su sucursal y lo suyo
            if(isset($_GET['cad']) && $_GET['cad'] == 'SI'){
                mysql_select_db($database_horizonte, $horizonte); 
                $resultAll = mysql_query("SELECT id, fecha_expiracion, existencias from stock_has_bach where existencias > 0 ",$horizonte) or die (mysql_error());
                $listaID = array();
                $cont = 0 ;

                //OBTENER LOS ID DE LOS REGISTROS CADUCADOS
                while ($fila = mysql_fetch_assoc($resultAll)) {
                    //fecha  de caducidad que viene de BD
                    $fechaCadu1 = substr($fila['fecha_expiracion'],0,10);
                    //le restamos una mes a la fecha de caducidad para poder compararla
                    $Alertafecha1 = date('Y-m-d', strtotime($fechaCadu1.'-1 month'));
                    //sacar la fecha actual
                    $now1 = date('Y-m-d');

                    if($now1 > $Alertafecha1){
                        $listaID[$cont]['id'] = $fila['id'];
                        $listaID[$cont]['fecha_expiracion'] = $fila['fecha_expiracion'];
                    }
                    $cont++;
                }
                // print_r($listaID);
                $sWhere = "";
                if(count($listaID) > 0){
                    //RECORRE EL ARREGLO PARA FORMAR EL WHERE 
                    while ($i < count($listaID)) {
                        if(isset($listaID[$i])){
                            if ( $sWhere == "" ) { $sWhere = "WHERE "; } else { $sWhere .= " OR "; }
                            $sWhere .= "(s.id = ".$listaID[$i]['id']." AND (s1.id_su = $id_suc or s.usuario_registro = ".$_GET[idU]."))";
                        }
                       $i++;
                    }
                }else{
                    $sWhere="WHERE s.id = 0 ";
                }
                // $sWhere .= " AND s.usuario_registro = '$_GET[idU]' ";
            }else{
                if(isset($_GET['exi']) && $_GET['exi'] == 'SI'){
                    if(isset($_GET['min']) && isset($_GET['max']) && $_GET['min'] != '' && $_GET['max'] != ''){
                        $sWhere="WHERE s.fecha_update BETWEEN '$_GET[min]' AND '$_GET[max]' and (s1.id_su = $id_suc or s.usuario_registro = '$_GET[idU]') AND s.existencias > 0";
                    }else{
                        $sWhere = "WHERE (s1.id_su = $id_suc or s.usuario_registro = $_GET[idU]) AND s.existencias > 0";
                    }
                }else{
                    if(isset($_GET['min']) && isset($_GET['max']) && $_GET['min'] != '' && $_GET['max'] != ''){
                        $sWhere="WHERE s.fecha_update BETWEEN '$_GET[min]' AND '$_GET[max]' and (s1.id_su = $id_suc or s.usuario_registro = '$_GET[idU]') ";
                    }else{
                        $sWhere = "WHERE s1.id_su = $id_suc or s.usuario_registro = $_GET[idU]";
                    }
                }
            }
		break;
		case 1://Ve todo de todas las sucursales
            if(isset($_GET['cad']) && $_GET['cad'] == 'SI'){
                mysql_select_db($database_horizonte, $horizonte); 
                $resultAll = mysql_query("SELECT id, fecha_expiracion, existencias from stock_has_bach where existencias > 0 ",$horizonte) or die (mysql_error());
                $listaID = array();
                $cont = 0 ;

                //OBTENER LOS ID DE LOS REGISTROS CADUCADOS
                while ($fila = mysql_fetch_assoc($resultAll)) {
                    //fecha  de caducidad que viene de BD
                    $fechaCadu1 = substr($fila['fecha_expiracion'],0,10);
                    //le restamos una mes a la fecha de caducidad para poder compararla
                    $Alertafecha1 = date('Y-m-d', strtotime($fechaCadu1.'-1 month'));
                    //sacar la fecha actual
                    $now1 = date('Y-m-d');

                    if($now1 > $Alertafecha1){
                        $listaID[$cont]['id'] = $fila['id'];
                        $listaID[$cont]['fecha_expiracion'] = $fila['fecha_expiracion'];
                        $cont++;
                    }
                    
                }
                $sWhere = "";
                if(count($listaID) > 0){
                    //RECORRE EL ARREGLO PARA FORMAR EL WHERE 
                    for ($i=0; $i < count($listaID); $i++) { 
                        if ( $sWhere == "" ) { $sWhere = "WHERE "; } else { $sWhere .= " OR "; }
                        $sWhere .= "s.id = ".$listaID[$i]['id'];
                    }   
                }
                else{
                    $sWhere="WHERE s.id = 0 ";
                }
            //     echo count($listaID);
            //    print_r($listaID);
            }else{
                if(isset($_GET['exi']) && $_GET['exi'] == 'SI'){
                    if(isset($_GET['min']) && isset($_GET['max']) && $_GET['min'] != '' && $_GET['max'] != ''){
                        $sWhere="WHERE s.fecha_update BETWEEN '$_GET[min]' AND '$_GET[max]' AND s.existencias > 0";
                    }else{
                    $sWhere = "WHERE s.existencias > 0 ";
                    }
                }else{
                    if(isset($_GET['min']) && isset($_GET['max']) && $_GET['min'] != '' && $_GET['max'] != ''){
                        $sWhere="WHERE s.fecha_update BETWEEN '$_GET[min]' AND '$_GET[max]'";
                    }else{
                    $sWhere = "WHERE 1 = 1 ";
                    }
                }
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
        // echo $sQuery;

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


        //fecha  de caducidad que viene de BD
        $fechaCadu = substr($row[4],0,10);
        //le restamos una mes a la fecha de caducidad para poder compararla
        $Alertafecha = date('Y-m-d', strtotime($fechaCadu.'-1 month'));
         //sacar la fecha actual
        $now = date('Y-m-d');
        $feCad = $row[4];
        //verificamos si la fecha actual supera a la fecha de caducidad que tiene un mes restado
        if($now > $Alertafecha){
            $row[4]= "<span class='btn btn-danger disabled' >".$fechaCadu."</span>";
        }else{
            $row[4]= $fechaCadu;
        }

        //OBTENEMOS EL MAXIMO Y MINIMO
        mysql_select_db($database_horizonte, $horizonte); 
        $min_max = mysql_query("SELECT max_mm, min_mm from max_min_stock where id_producto = $row[7] and id_suc = $row[16]",$horizonte) or die (mysql_error());
        $rowMM = mysql_fetch_row($min_max); 

        $row[5] ="<span>$row[5] <br> $row[6]</span>";
        if(!empty($rowMM[0])){
            $row[7] = $rowMM[0];
            $row[8] = $rowMM[1];
        }else{
            $row[7] = "<span>-</span>";
            $row[8] = "<span>-</span>";
        }
        

        $row[12] = $row[9] * $row[10];
        $row[13] = $row[9] * $row[11];
        $existencias =$row[9];
        if($row[9] > 0){
            $row[14] ="<span class='btn btn-primary' onclick='transferencias($row[15], $existencias,$row[16],\"$row[1]\");' ><i class='fa fa-exchange'></i></span>"; 
        }else{
            $row[14] ="<span class='btn btn-primary disabled'><i class='fa fa-exchange'></i></span>"; 
        }
       
        if($row[9] <= $rowMM[1] && $rowMM[1] != '' && $tipo_user != 15){
            $row[9] ="<span class='btn btn-danger' disabled='true'>$row[9]</span>";
        }else if($row[9] >= $rowMM[0] && $rowMM[0] != '' && $tipo_user != 15){
            $row[9] ="<span class='btn btn-success' disabled='true'>$row[9]</span>";
        }else if($tipo_user == 15){
            $row[9] = "<span class='btn btn-primary' onclick='cambiarExistencias($row[15],$row[9],\"$row[3]\",\"$feCad\")'>$row[9]</span>"; 
        }
       $row[15] =  $existencias;

        
       $row[0]= $hh;
		
		$output['aaData'][] = $row;
    }
	
    echo json_encode( $output );
?>
