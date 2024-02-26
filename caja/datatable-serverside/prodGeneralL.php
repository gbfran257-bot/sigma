<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

	$aColumns = array(
        'v.id_vc',
        'e.id_to',  //Fecha de pago  de la tabla PAGOS_OV 
		'v.referencia_vc',
        'd.nombre_d',
		'e.concepto_to',
		'e.linea_c',
        'v.id_vc', //Tipo de Pago
		'v.precio_original',     
        'v.id_vc', //descuentos de las consultas las otras areas se agregan abajo
        'v.id_vc', //cargos extras 
        'v.id_vc', //precio Final
    );
     
    // DB tables to use 
    $aTables = array( 'venta_conceptos v');
    
    $sIndexColumn = "v.id_vc";
     
	 // Joins   
	$sJoin = '  left join orden_venta o on o.referencia_ov = v.referencia_vc 
                left JOIN pacientes p ON p.id_p = v.id_paciente_vc 
                left join usuarios m on m.id_u = v.id_personal_medico_vc 
                left join conceptos e on e.id_to = v.id_concepto_es
                left join departamentos d on d.id_d = e.id_departamento_to';
		
    $sWhere = "";

     /* Individual column filtering */
     for ( $i=0 ; $i<count($aColumns) ; $i++ )
     {
         if ( isset($_GET['bSearchable_'.$i]) && $_GET['bSearchable_'.$i] == "true" && $_GET['sSearch_'.$i] != '' ){
             if ( $sWhere == "" ) { $sWhere = "WHERE "; } else { $sWhere .= " AND "; }
             $sWhere .= $aColumns[$i]." LIKE '%".mysql_real_escape_string($_GET['sSearch_'.$i])."%' ";
         }
     }

     if ( isset($_GET['sSearch']) && $_GET['sSearch'] != "" )
     {
         $sWhere .= "AND (";
         for ( $i=0 ; $i<count($aColumns) ; $i++ ) { $sWhere .= $aColumns[$i]." LIKE '%".mysql_real_escape_string( $_GET['sSearch'] )."%' OR "; }
         $sWhere = substr_replace( $sWhere, "", -3 );
         $sWhere .= ')';
     }
      

     if ( $sWhere == "" ) { $sWhere = "WHERE "; } else { $sWhere .= " AND "; }
	$sWhere.=" v.fecha_venta_vc BETWEEN '$_GET[min]' AND '$_GET[max]' and v.temporal_vc=0 ";
	
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
    $sOrder = "";
    if ( isset( $_GET['iSortCol_0'] ) )
    {
        $sOrder = "";
        for ( $i=0 ; $i<intval( $_GET['iSortingCols'] ) ; $i++ ) { if ( $_GET[ 'bSortable_'.intval($_GET['iSortCol_'.$i]) ] == "true" ) { $sOrder .= $aColumns[ intval( $_GET['iSortCol_'.$i] ) ]." ".mysql_real_escape_string( $_GET['sSortDir_'.$i] ) .", "; } }
         
        $sOrder = substr_replace( $sOrder, "", -2 );
        if ( $sOrder == "ORDER BY" ) { $sOrder = ""; }
    }
     
    /*  * Filtering * NOTE this does not match the built-in DataTables filtering which does it * word by word on any field. It's possible to do here, but concerned about efficiency * on very large tables, and MySQL's regex functionality is very limited */
     
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
        for ( $i=0 ; $i<count($aColumns) ; $i++ ){ 
            if ( $aColumns[$i] == "version" ) {
                 /* Special output formatting for 'version' column */ 
                 $row[] = ($aRow[ $aColumns[$i] ]=="0") ? '-' : $aRow[ $aColumns[$i] ]; 
            } else if ( $aColumns[$i] != ' ' ) { 
                /* General output */ $row[] = $aRow[$i]; 
            }
        }
		$row1 = array();
        for ( $j=0 ; $j<count($aColumns) ; $j++ ) {
            if ( $aColumns[$j] == "version" ) { 
                $row1[] = ($aRow[ $aColumns[$j] ]=="0") ? '-' : $aRow[ $aColumns[$j] ];
            } else if ( $aColumns[$j] != ' ' ) { 
                $row1[] = $aRow[$j]; 
            }
        }
		

         //obtener datos de la tabla de orden de Pagos 
		mysql_select_db($database_horizonte, $horizonte);
		$FechaPag = mysql_query("SELECT DATE_FORMAT(fecha_pag,'%d/%c/%Y %H:%m'), departamento_pa, pago_pag, cfp.forma_pago_fp from pagos_ov po join conceptos c on po.departamento_pa = c.id_departamento_to join catalogo_forma_pago cfp on po.forma_pago_pag = cfp.id_fp where referencia_pag = '$row[2]' and c.id_to = $row[1]", $horizonte) or die(mysql_error());
		$FP = mysql_fetch_row($FechaPag);
        
        //obtener datos de la tabla de Orden Venta 
		mysql_select_db($database_horizonte, $horizonte);
		$ordenVenta = mysql_query("SELECT t_desc_cta, t_desc_img, t_desc_lab, t_desc_serv, t_desc_pro, vc.precio_original, c.id_tipo_concepto_to, adicionales_c_ov,adicionales_p_ov,adicionales_ei_ov, adicionales_el_ov,adicionales_s_ov from orden_venta ov join venta_conceptos vc on vc.referencia_vc = ov.referencia_ov join conceptos c on c.id_to = vc.id_concepto_es where referencia_ov = '$row[2]' and c.id_to = $row[1]" , $horizonte) or die(mysql_error());
		$OB = mysql_fetch_row($ordenVenta);
        
        //CONSULTA
        if($OB[6] == 1){
            mysql_select_db($database_horizonte, $horizonte);
            $desc = mysql_query("SELECT descuento from venta_conceptos where id_vc = '$row[0]'", $horizonte) or die(mysql_error());
            $DesConsulta = mysql_fetch_row($desc);

            mysql_select_db($database_horizonte, $horizonte);
            $ordenVenta1 = mysql_query("SELECT COUNT(c.id_to) from orden_venta ov join venta_conceptos vc on vc.referencia_vc = ov.referencia_ov join conceptos c on c.id_to = vc.id_concepto_es where referencia_ov = '$row[2]' and c.id_tipo_concepto_to = 1" , $horizonte) or die(mysql_error());
            $OB1 = mysql_fetch_row($ordenVenta1);
            
            $descuento = $DesConsulta[0];
            $cargoExtra = $OB[7] / $OB1[0];
            $precioMod = $OB[5] - $descuento;
            //SERVICIOS
        }elseif ($OB[6] == 2) {
            mysql_select_db($database_horizonte, $horizonte);
            $ordenVenta1 = mysql_query("SELECT COUNT(c.id_to) from orden_venta ov join venta_conceptos vc on vc.referencia_vc = ov.referencia_ov join conceptos c on c.id_to = vc.id_concepto_es where referencia_ov = '$row[2]' and c.id_tipo_concepto_to = 2" , $horizonte) or die(mysql_error());
            $OB1 = mysql_fetch_row($ordenVenta1);
            $descuento = ($OB[3]) / $OB1[0];
            $cargoExtra = $OB[11] / $OB1[0];
            $precioMod = $OB[5] - $descuento;
            //lABORATORIO
        }elseif ($OB[6] == 3) {
            mysql_select_db($database_horizonte, $horizonte);
            $ordenVenta1 = mysql_query("SELECT COUNT(c.id_to) from orden_venta ov join venta_conceptos vc on vc.referencia_vc = ov.referencia_ov join conceptos c on c.id_to = vc.id_concepto_es where referencia_ov = '$row[2]' and c.id_tipo_concepto_to = 3" , $horizonte) or die(mysql_error());
            $OB1 = mysql_fetch_row($ordenVenta1);
            $descuento = (($OB[2]) /$OB1[0]);
            $cargoExtra = $OB[10] / $OB1[0];
            $precioMod = $OB[5] - $descuento;
            //IMAGEN
        }elseif ($OB[6] == 4) {
            mysql_select_db($database_horizonte, $horizonte);
            $ordenVenta1 = mysql_query("SELECT COUNT(c.id_to) from orden_venta ov join venta_conceptos vc on vc.referencia_vc = ov.referencia_ov join conceptos c on c.id_to = vc.id_concepto_es where referencia_ov = '$row[2]' and c.id_tipo_concepto_to = 4" , $horizonte) or die(mysql_error());
            $OB1 = mysql_fetch_row($ordenVenta1);
            $descuento = (($OB[1]) / $OB1[0]);
            $cargoExtra = $OB[9] / $OB1[0];
            $precioMod = $OB[5] - $descuento;
            //FARMACIA
        }elseif ($OB[6] == 5) {
            mysql_select_db($database_horizonte, $horizonte);
            $ordenVenta1 = mysql_query("SELECT COUNT(c.id_to) from orden_venta ov join venta_conceptos vc on vc.referencia_vc = ov.referencia_ov join conceptos c on c.id_to = vc.id_concepto_es where referencia_ov = '$row[2]' and c.id_tipo_concepto_to = 5" , $horizonte) or die(mysql_error());
            $OB1 = mysql_fetch_row($ordenVenta1);
            $descuento = (($OB[4]) / $OB1[0]);
            $cargoExtra = $OB[8] / $OB1[0];
            $precioMod = $OB[5] - $descuento;
        }
        
        $precioFinal = $precioMod + $cargoExtra;
        $row[0] = "<span>$hh</span>";
        $row[1] = $FP[0];
        $row[6] = $FP[3];
        $row[8] = $descuento;
        $row[9] = $cargoExtra;
        $row[10] = $precioFinal;

		$output['aaData'][] = $row;
    }
    echo json_encode( $output );
?>
