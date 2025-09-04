<?php require_once('../../../Connections/horizonte.php'); ?>
<?php require_once("../../../funciones/php/values.php"); ?>
<?php
	// consulta para horizonte
	$obligatorio = 0;
	$aColumns = array('pa.referencia_pag','pa.referencia_pag', 'p.nombre_completo_p', 'DATE_FORMAT(ov.fecha_venta_ov,GET_FORMAT(DATE,"ISO"))', 's.clave_su', 'u.usuario_u', 'fp.forma_pago_fp','ov.subtotal_ov', 'SUM(ov.adicionales_c_ov + ov.adicionales_ei_ov + ov.adicionales_el_ov + ov.adicionales_s_ov + ov.adicionales_p_ov)', 'ov.t_desc_cta+ov.t_desc_img+ov.t_desc_lab+ov.t_desc_serv+ov.t_desc_pro', 'ov.gran_total_ov', 'SUM(pa.pago_pag)', 'SUM(pa.pago_pag)', 'SUM(pa.pago_pag)', 'ov.gran_total_ov-SUM(pa.pago_pag)', 'p.amaterno_p', 'ov.no_temp_ov', 'ov.no_temp_ov', 'ov.sucursal_ov','DATE_FORMAT(ov.fecha_venta_ov,"%d/%m/%Y %H:%i")','pa.referencia_pag','fp.id_fp', 'ov.encuesta_zapata');
     
    // DB tables to use 
    $aTables = array( 'orden_venta ov');
     
    // Indexed column (used for fast and accurate table cardinality) 
    $sIndexColumn = "ov.referencia_ov";
     
    $group2 = "";
	 // Joins   hasta aqui
	$sJoin = 'left join pacientes p ON ov.id_paciente_ov = p.id_p left join pagos_ov pa on ov.referencia_ov = pa.referencia_pag left join usuarios u on u.id_u = ov.usuario_ov left join sucursales s on s.id_su = ov.sucursal_ov left join catalogo_forma_pago fp on fp.id_fp = pa.forma_pago_pag';
	// left join conceptos to on to. =  left join departamentos d on d.id_d = pa.id_departamento_pag
    // CONDITIONS 
	if(isset($_GET['depto']) && $_GET['depto'] != 'x' && $_GET['depto'] != ''){//para las solicitudes con departamento
		if(isset($_GET['saldos']) && $_GET['saldos'] == 'SI'){//para las solicitudes con saldos
			if(isset($_GET['min']) && isset($_GET['max']) && $_GET['min'] != '' && $_GET['max'] != ''){
				$sWhere = "WHERE ov.fecha_venta_ov BETWEEN '$_GET[min]' AND '$_GET[max]' and pa.id_departamento_pag = '$_GET[depto]'";
                $group2 = "HAVING SUM(pa.pago_pag) < ov.gran_total_ov";
			}else{$sWhere = "WHERE 1=1"; $group2 = "HAVING SUM(pa.pago_pag) < ov.gran_total_ov"; }
		}else{//si no se solicitan los registros con saldo (que deben dinero)
			if(isset($_GET['min']) && isset($_GET['max']) && $_GET['min'] != '' && $_GET['max'] != ''){
				$sWhere = "WHERE ov.fecha_venta_ov BETWEEN '$_GET[min]' AND '$_GET[max]' and pa.id_departamento_pag = '$_GET[depto]'";
			}else{$sWhere = "WHERE 1=1" ;}
		}
	}else{
		if(isset($_GET['saldos']) && $_GET['saldos'] == 'SI'){//para las solicitudes con saldos
			if(isset($_GET['min']) && isset($_GET['max']) && $_GET['min'] != '' && $_GET['max'] != ''){
				$sWhere = "WHERE ov.fecha_venta_ov BETWEEN '$_GET[min]' AND '$_GET[max]'";
                $group2 = "HAVING SUM(pa.pago_pag) < ov.gran_total_ov";
			}else{$sWhere = "WHERE 1=1"; $group2 = "HAVING SUM(pa.pago_pag) < ov.gran_total_ov";}
		}else{//si no se solicitan los registros con saldo (que deben dinero)
			if(isset($_GET['min']) && isset($_GET['max']) && $_GET['min'] != '' && $_GET['max'] != ''){
				$sWhere = "WHERE ov.fecha_venta_ov BETWEEN '$_GET[min]' AND '$_GET[max]'";
			}else{$sWhere = "WHERE 1=1 " ;}
		}
	}
    mysql_select_db($database_horizonte, $horizonte);
    $resultSu = mysql_query("SELECT multisucursal_u, idSucursal_u from usuarios where id_u = '$_GET[usuario]'",$horizonte) or die (mysql_error());
	$rowAU = mysql_fetch_row($resultSu); $id_suc = sqlValue($rowAU[1], "int");
	
	switch($rowAU[0]){
        case 2:
            $sWhere .= "and ov.sucursal_ov = $id_suc ";
            break;
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
    /* if ( isset( $_GET['iSortCol_0'] ) )
    { */
        $sOrder = "GROUP BY pa.referencia_pag $group2 ORDER BY ";
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
		$sOrder = "GROUP BY pa.referencia_pag $group2 ORDER BY pa.fecha_pag desc";
    // }
     
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
		
		mysql_select_db($database_horizonte, $horizonte);
		$consultaS = "SELECT id_su as id, nombre_su as nombre from sucursales order by nombre asc ";
		$queryS = mysql_query($consultaS) or die (mysql_error()); //echo '<option value="">'.'-SELECCIONAR-'.'</option>';
		$sucs = '';
		while ($fila = mysql_fetch_array($queryS)){
			if($row[18]==$fila['id']){
				$sucs = $sucs.'<option selected value="'.$fila['id'].'">'.$fila['nombre'].'</option>';
			}else{$sucs = $sucs.'<option value="'.$fila['id'].'">'.$fila['nombre'].'</option>';}
		};
        mysql_select_db($database_horizonte, $horizonte);
        $consulta = "SELECT IF(COUNT(*) > 0, 'Si', 'No') AS resultado
                        FROM ordenes_facturadas
                        WHERE referencia_ov = '" . $row[20] . "'" ;
        // Obtiene el resultado
        $query = mysql_query($consulta);
        if (!$query) {
            die("Error en el query: " . mysql_error());
        }
        $valor = "No";
        while ($fila = mysql_fetch_array($query)){
            $valor = $fila['resultado'];
        }
        $row[16] = $valor;

        //obtenemos lista de metodos de pago
        mysql_select_db($database_horizonte, $horizonte);
        $consultaS2 = "SELECT id_fp as id, forma_pago_fp as nombre from catalogo_forma_pago order by nombre asc ";
        $queryS2 = mysql_query($consultaS2) or die (mysql_error()); //echo '<option value="">'.'-SELECCIONAR-'.'</option>';
        $sucs2 = '';
        while ($fila2 = mysql_fetch_array($queryS2)){
            if($row[21]==$fila2['id']){
                $sucs2 = $sucs2.'<option selected value="'.$fila2['id'].'">'.$fila2['nombre'].'</option>';
            }else{$sucs2 = $sucs2.'<option value="'.$fila2['id'].'">'.$fila2['nombre'].'</option>';}
        };

        $row[6]="<select lang='$row[20]' class='form-control input-sm cambiar_suc' style='width:100%;' onChange='cambiar_forma_pago(this.value, this.lang)'>$sucs2</select>";
		
        $row[4]="<select lang='$row[17]' class='form-control input-sm cambiar_suc' style='width:100%;' onChange='cambiar_suc(this.value, this.lang)'>$sucs</select>";
		$row[1] ="<span lang='$row[1]' style='text-decoration:underline; cursor:pointer;' onClick='ver_ov(this.lang)'>$row[1]</span><br><span style='font-size:12px'>$row[19]</span>";

        if($row[22] == 1){
            $datosEncuesta = "<a href='pacientes/files-serverside/encuesta_paciente.php?ref=".$row[20]."' target='_blank'> <i class='fa fa-comments-o' aria-hidden='true'></i> </a>";
        }else{
            $datosEncuesta = "";
        }

        $row[2] = $row[2] . " $datosEncuesta";

        //otenememos los cargos extra por separado debido a que los cargos aumentaban por error de la query y el uso de los joins.
        mysql_select_db($database_horizonte, $horizonte);
        $getCargosE = mysql_query("SELECT SUM(ov.adicionales_c_ov + ov.adicionales_ei_ov + ov.adicionales_el_ov + ov.adicionales_s_ov + ov.adicionales_p_ov) from orden_venta ov WHERE ov.referencia_ov = $refi ", $horizonte) or die (mysql_error());
        $cargosE = mysql_fetch_row($getCargosE);
        $row[8] = $cargosE[0];		
			
        $output['aaData'][] = $row;
    }
    echo json_encode( $output );
?>
