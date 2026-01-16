<?php require_once('../../../Connections/horizonte.php'); ?>
<?php require_once("../../../funciones/php/values.php"); ?>
<?php
	include_once '../../../recursos/session.php';
	include_once '../../../Connections/database.php';
	include_once '../../../recursos/utilities.php';
	include_once '../../../recursos/datauser.php';

	$id_user = $_SESSION['id']; $acceso_user = $_SESSION['MM_UserGroup']; $sucursal_user = $_SESSION['MM_Usersucu'];

	// consulta para horizonte
	$obligatorio = 0;
	$aColumns = array('pa.referencia_pag','pa.referencia_pag' , 'p.nombre_completo_p', 'DATE_FORMAT(ov.fecha_venta_ov,GET_FORMAT(DATE,"ISO"))', 's.clave_su', 'u.usuario_u', 'fp.forma_pago_fp', 'ov.subtotal_ov', 'SUM(ov.adicionales_c_ov + ov.adicionales_ei_ov + ov.adicionales_el_ov + ov.adicionales_s_ov + ov.adicionales_p_ov)', 'ov.t_desc_cta+ov.t_desc_img+ov.t_desc_lab+ov.t_desc_serv+ov.t_desc_pro', 'ov.gran_total_ov', 'SUM(pa.pago_pag)', 'SUM(pa.pago_pag)', 'SUM(pa.pago_pag)', 'ov.gran_total_ov-SUM(pa.pago_pag)', 'p.amaterno_p', 'ov.no_temp_ov', 'ov.no_temp_ov','pa.referencia_pag','DATE_FORMAT(ov.fecha_venta_ov,"%d/%c/%Y %H:%m")', 'ov.encuesta_zapata', 'p.id_p');
     
    // DB tables to use 
    $aTables = array( 'orden_venta ov');
     
    // Indexed column (used for fast and accurate table cardinality) 
    $sIndexColumn = "ov.referencia_ov";
     
	 // Joins   hasta aqui
	$sJoin = 'left join pacientes p ON ov.id_paciente_ov = p.id_p left join pagos_ov pa on ov.referencia_ov = pa.referencia_pag left join usuarios u on u.id_u = ov.usuario_ov left join sucursales s on s.id_su = ov.sucursal_ov left join catalogo_forma_pago fp on fp.id_fp = pa.forma_pago_pag';
	// left join conceptos to on to. =  left join departamentos d on d.id_d = pa.id_departamento_pag
	 
    // CONDITIONS 
	if(isset($_GET['depto']) && $_GET['depto'] != 'x' && $_GET['depto'] != ''){//para las solicitudes con departamento
		if(isset($_GET['saldos']) && $_GET['saldos'] == 'SI'){//para las solicitudes con saldos
			if(isset($_GET['min']) && isset($_GET['max']) && $_GET['min'] != '' && $_GET['max'] != ''){
				//$sWhere = "WHERE ov.usuario_ov = $id_user and  ov.gran_total_ov > pa.pago_pag and ov.fecha_venta_ov BETWEEN '$_GET[min]' AND '$_GET[max]' and pa.id_departamento_pag = '$_GET[depto]'";
				$sWhere = "WHERE ov.gran_total_ov > pa.pago_pag and ov.fecha_venta_ov BETWEEN '$_GET[min]' AND '$_GET[max]' and pa.id_departamento_pag = '$_GET[depto]'";
			}else{$sWhere = "WHERE ov.usuario_ov = $id_user and ov.gran_total_ov > pa.pago_pag" ;}
		}else{//si no se solicitan los registros con saldo (que deben dinero)
			if(isset($_GET['min']) && isset($_GET['max']) && $_GET['min'] != '' && $_GET['max'] != ''){
				$sWhere = "WHERE ov.usuario_ov = $id_user and ov.fecha_venta_ov BETWEEN '$_GET[min]' AND '$_GET[max]' and pa.id_departamento_pag = '$_GET[depto]'";
			}else{$sWhere = "WHERE ov.usuario_ov = $id_user " ;}
		}
	}else{
		if(isset($_GET['saldos']) && $_GET['saldos'] == 'SI'){//para las solicitudes con saldos
			if(isset($_GET['min']) && isset($_GET['max']) && $_GET['min'] != '' && $_GET['max'] != ''){
				//$sWhere = "WHERE ov.usuario_ov = $id_user and ov.gran_total_ov > pa.pago_pag and ov.fecha_venta_ov BETWEEN '$_GET[min]' AND '$_GET[max]'";
				//comentada para pruebas //$sWhere = "WHERE ov.gran_total_ov > pa.pago_pag and ov.fecha_venta_ov BETWEEN '$_GET[min]' AND '$_GET[max]'";
				$sWhere = "WHERE ov.fecha_venta_ov BETWEEN '$_GET[min]' AND '$_GET[max]'";
			}else{$sWhere = "WHERE ov.usuario_ov = $id_user and  ov.gran_total_ov > pa.pago_pag" ;}
		}else{//si no se solicitan los registros con saldo (que deben dinero)
			if(isset($_GET['min']) && isset($_GET['max']) && $_GET['min'] != '' && $_GET['max'] != ''){
				$sWhere = "WHERE ov.usuario_ov = $id_user and ov.fecha_venta_ov BETWEEN '$_GET[min]' AND '$_GET[max]'";
			}else{$sWhere = "WHERE ov.usuario_ov = $id_user  " ;}
		}
	}

    if(isset($_GET['filtro_pago']) && $_GET['filtro_pago'] > 0){
        $sWhere .= " AND pa.forma_pago_pag = " . $_GET['filtro_pago'];
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
        //$sOrder = "GROUP BY pa.referencia_pag ORDER BY "; //$sOrder = "GROUP BY ";
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
		$sOrder = "GROUP BY pa.referencia_pag ORDER BY pa.fecha_pag desc"; //$sOrder = "GROUP BY ";
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

    if(isset($_GET['saldos']) && $_GET['saldos'] == 'SI'){
        $sOrder = " GROUP BY pa.referencia_pag  HAVING SUM(pa.pago_pag) < ov.gran_total_ov ORDER BY pa.fecha_pag DESC ";
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
     
    while ( $aRow = mysql_fetch_array( $rResult ) )
    {
        $row = array();
        for ( $i=0 ; $i<count($aColumns) ; $i++ )
        {
            if ( $aColumns[$i] == "version" ) { $row[] = ($aRow[ $aColumns[$i] ]=="0") ? '-' : $aRow[ $aColumns[$i] ]; }
            else if ( $aColumns[$i] != ' ' )
            {
               $row[] = $aRow[$i];
            }
        }
		$row1 = array();
        for ( $j=0 ; $j<count($aColumns) ; $j++ )
        {
            if ( $aColumns[$j] == "version" ) { $row1[] = ($aRow[ $aColumns[$j] ]=="0") ? '-' : $aRow[ $aColumns[$j] ]; }
            else if ( $aColumns[$j] != ' ' ) { $row1[] = $aRow[$j]; }
        }
		$nombreP = '"'.$row[2].'"';
		$row[0] = "<img src='imagenes/generales/details_open.png' title='¡Información Adicional' border = '0' />";
		
		$refi = sqlValue($row[1], "text");
		//
		mysql_select_db($database_horizonte, $horizonte);
		$resultS = mysql_query("SELECT ov.gran_total_ov, sum(pa.pago_pag) from orden_venta ov left join pagos_ov pa on ov.referencia_ov = pa.referencia_pag WHERE ov.referencia_ov = $refi ", $horizonte) or die (mysql_error());
		$rowS = mysql_fetch_row($resultS); $saldo = $rowS[0]-$rowS[1];
		//
		
		if ($rowS[1]<$rowS[0]){
			mysql_select_db($database_horizonte, $horizonte);
			$resultTC = mysql_query("SELECT ov.gran_total_ov, ov.gran_total_ov - pa.pago_pag, sum(pa.pago_pag) from orden_venta ov left join pagos_ov pa on ov.referencia_ov = pa.referencia_pag WHERE ov.referencia_ov = $refi ", $horizonte) or die (mysql_error());
			$rowTC = mysql_fetch_row($resultTC);
			
			$aleatory = '"'.$row[17].'"';
			
			//checamos si la OV tiene por lo menos un pago o no
			
				mysql_select_db($database_horizonte, $horizonte);
				$resultV = mysql_query("SELECT sum(pago_pag) from pagos_ov WHERE referencia_pag = $refi ", $horizonte) or die (mysql_error());
				$rowV = mysql_fetch_row($resultV);
			
				if($rowV[0]>0){
					//Si tiene ya por lo menos un pago, entonces revisamos si los pagos fueron hechos por DEPARTAMERNTO
					
					mysql_select_db($database_horizonte, $horizonte);
					$resultV1 = mysql_query("SELECT sum(pago_pag) from pagos_ov WHERE referencia_pag = $refi and departamento_pa is not NULL ", $horizonte) or die (mysql_error());
					$rowV1 = mysql_fetch_row($resultV1);
					
					if($rowV1[0]>0){
						//Si el pago fue por departamento, entonces sólo calculamos el resto de los departamentos
						mysql_select_db($database_horizonte, $horizonte);
						$result2 = mysql_query("SELECT ov.total_c + ov.total_s, ov.total_ei, ov.total_el, ov.total_p from orden_venta ov WHERE ov.referencia_ov = $refi ", $horizonte) or die (mysql_error());
						$row2 = mysql_fetch_row($result2);

						mysql_select_db($database_horizonte, $horizonte);
						$result2am = mysql_query("SELECT sum(pago_pag) from pagos_ov WHERE referencia_pag = $refi and departamento_pa = 4", $horizonte) or die (mysql_error());
						$row2am = mysql_fetch_row($result2am); $t_con = $row2[0]-$row2am[0];

						mysql_select_db($database_horizonte, $horizonte);
						$result2im = mysql_query("SELECT sum(pago_pag) from pagos_ov WHERE referencia_pag = $refi and departamento_pa = 2", $horizonte) or die (mysql_error());
						$row2im = mysql_fetch_row($result2im); $t_ima = $row2[1]-$row2im[0];

						mysql_select_db($database_horizonte, $horizonte);
						$result2lb = mysql_query("SELECT sum(pago_pag) from pagos_ov WHERE referencia_pag = $refi and departamento_pa = 1", $horizonte) or die (mysql_error());
						$row2lb = mysql_fetch_row($result2lb); $t_lab = $row2[2]-$row2lb[0];

						mysql_select_db($database_horizonte, $horizonte);
						$result2fa = mysql_query("SELECT sum(pago_pag) from pagos_ov WHERE referencia_pag = $refi and departamento_pa = 3", $horizonte) or die (mysql_error());
						$row2fa = mysql_fetch_row($result2fa); $t_far = $row2[3]-$row2fa[0];

						$row[15] = "<div style='color:red; text-align:center;' onClick='pagar(this.id, $rowS[0], $saldo, $rowS[1], $nombreP, $aleatory,1,$t_con,$t_ima,$t_lab,$t_far);' id='$row[1]' class='hacerPago' href='#' title1='Realizar Pago a la Orden de Venta' target='_self'><span style='cursor:pointer; text-decoration:underline;font-style:italic;'>PAGAR</span></div>";
					}else{
						//Si los pagos no fueron por departamento, entonces con una alerta poner que por favor redistribuya el total de los pagos anteriores y entonces los totales serían recalculados como si no hubiera pago pero la suma de los pagos por departamentos debe ser por lo menos igual a la suma de los pagos anteriores
						mysql_select_db($database_horizonte, $horizonte);
						$result1 = mysql_query("SELECT ov.total_c + ov.total_s, ov.total_ei, ov.total_el, ov.total_p from orden_venta ov WHERE ov.referencia_ov = $refi ", $horizonte) or die (mysql_error());
						$row1 = mysql_fetch_row($result1);

						$row[15] = "<div style='color:red; text-align:center;' onClick='pagar(this.id, $rowS[0], $saldo, $rowS[1], $nombreP, $aleatory,2,$row1[0],$row1[1],$row1[2],$row1[3]);' id='$row[1]' class='hacerPago' href='#' title1='Realizar Pago a la Orden de Venta' target='_self'><span style='cursor:pointer; text-decoration:underline;font-style:italic;'>PAGAR</span></div>";
					}
				}else{
					//Si no tiene algún pago, entonces sacamos los pagos por departamento
					mysql_select_db($database_horizonte, $horizonte);
					$result1 = mysql_query("SELECT ov.total_c + ov.total_s, ov.total_ei, ov.total_el, ov.total_p from orden_venta ov WHERE ov.referencia_ov = $refi ", $horizonte) or die (mysql_error());
					$row1 = mysql_fetch_row($result1);
					
					$row[15] = "<div style='color:red; text-align:center;' onClick='pagar(this.id, $rowS[0], $saldo, $rowS[1], $nombreP, $aleatory,0,$row1[0],$row1[1],$row1[2],$row1[3]);' id='$row[1]' class='hacerPago' href='#' title1='Realizar Pago a la Orden de Venta' target='_self'><span style='cursor:pointer; text-decoration:underline;font-style:italic;'>PAGAR</span></div>";
				}
			/*mysql_select_db($database_horizonte, $horizonte);
			$resultTC = mysql_query("SELECT ov.gran_total_ov, ov.gran_total_ov - pa.pago_pag, sum(pa.pago_pag) from orden_venta ov left join pagos_ov pa on ov.referencia_ov = pa.referencia_pag WHERE ov.referencia_ov = $refi ", $horizonte) or die (mysql_error());
			$rowTC = mysql_fetch_row($resultTC);
			
			$aleatory = '"'.$row[16].'"';
			$row[14] = "<div style='color:red; text-align:center;' onClick='pagar(this.id, $rowS[0], $rowS[0]-$rowS[1], $rowS[1], $nombreP, $aleatory);' id='$row[1]' class='hacerPago' href='#' title1='Realizar Pago a la Orden de Venta' target='_self'><span style='cursor:pointer; text-decoration:underline;font-style:italic;'>PAGAR</span></div>";*/
		}else{$row[15]="<div style='text-align:center;'>SI</div>";} //if($row[6] == 0){$row[1]="<span class='erase1'>$row[1]</span>";}
		
		if(isset($_GET['saldos']) && $_GET['saldos'] == 'SI'){ if($row[14] == 0){ $row[1]="<span class='erase1'>$row[1]</span>"; } }

        if($row[20] == 1){
            $datosEncuesta = "<a href='pacientes/files-serverside/encuesta_paciente.php?ref=".$row[18]."' target='_blank'> <i class='fa fa-comments-o' aria-hidden='true'></i> </a>";
        }else{
            $datosEncuesta = "";
        }

        //bloque para verificar si la orden de venta ligada a la referencia ya tiene una firma registrada
        mysql_select_db($database_horizonte, $horizonte);
        $qryCountFirma = mysql_query("SELECT COUNT(*) FROM documentos WHERE nombre_do = 'firma_" . $row[18]."'", $horizonte) or die (mysql_error());
        $countFirma = mysql_fetch_row($qryCountFirma);

        if($countFirma[0] == 0){
            $iconFirma = "<a href='firmas.php?id=".$row[21]."&ref=".$row[18]."' target='_blank'> <i class='fa fa-pencil' aria-hidden='true'></i> </a>";
        }else{
            $iconFirma = "";
        }
        //esta bloque sirve unicamente para el sistema de zapata

        $row[2] = $row[2] . " $datosEncuesta $iconFirma";

        $row[1] ="<span lang='$row[1]' style='text-decoration:underline; cursor:pointer;' onClick='ver_ov(this.lang)'>$row[1]</span><br><span style='font-size:12px;'>$row[19]</span>";	
				
		$output['aaData'][] = $row;
    }
    echo json_encode( $output );
?>
