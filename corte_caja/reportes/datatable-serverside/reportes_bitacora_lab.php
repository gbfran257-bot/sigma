<?php require_once('../../../Connections/horizonte.php'); ?>
<?php require_once("../../../funciones/php/values.php"); ?>
<?php
	// consulta para horizonte
	$obligatorio = 0; 
	$aColumns = array('pa.referencia_pag','pa.referencia_pag' , 'p.nombre_completo_p', 'DATE_FORMAT(ov.fecha_venta_ov,GET_FORMAT(DATE,"ISO"))', 's.clave_su', 'u.usuario_u','concat(v.contador_vc," ",c.concepto_to)','ov.muestras_ov', 'ov.gran_total_ov', 'ov.id_ov', 'ov.gran_total_ov', 'ov.id_ov', 'ov.id_ov', 'tipo_tabulador_su', 's.id_su', 'p_tabulador_l_su');
     
    // DB tables to use 
    $aTables = array( 'orden_venta ov');
     
    // Indexed column (used for fast and accurate table cardinality) 
    $sIndexColumn = "ov.referencia_ov";
     
	 // Joins   hasta aqui
	$sJoin = 'left join pacientes p ON ov.id_paciente_ov = p.id_p left join pagos_ov pa on ov.referencia_ov = pa.referencia_pag left join usuarios u on u.id_u = ov.usuario_ov left join sucursales s on s.id_su = ov.sucursal_ov 
    left join venta_conceptos v on v.referencia_vc = ov.referencia_ov 
    left join conceptos c on c.id_to = v.id_concepto_es';
	// left join conceptos to on to. =  left join departamentos d on d.id_d = pa.id_departamento_pag
    // CONDITIONS 
	if(isset($_GET['depto']) && $_GET['depto'] != 'x' && $_GET['depto'] != ''){//para las solicitudes con departamento
		if(isset($_GET['saldos']) && $_GET['saldos'] == 'SI'){//para las solicitudes con saldos
			if(isset($_GET['min']) && isset($_GET['max']) && $_GET['min'] != '' && $_GET['max'] != ''){
				$sWhere = "WHERE ov.gran_total_ov > pa.pago_pag and ov.fecha_venta_ov BETWEEN '$_GET[min]' AND '$_GET[max]' and pa.id_departamento_pag = '$_GET[depto]'";
			}else{$sWhere = "WHERE ov.gran_total_ov > pa.pago_pag" ;}
		}else{//si no se solicitan los registros con saldo (que deben dinero)
			if(isset($_GET['min']) && isset($_GET['max']) && $_GET['min'] != '' && $_GET['max'] != ''){
				$sWhere = "WHERE ov.fecha_venta_ov BETWEEN '$_GET[min]' AND '$_GET[max]' and pa.id_departamento_pag = '$_GET[depto]'";
			}else{$sWhere = "WHERE 1=1" ;}
		}
	}else{
		if(isset($_GET['saldos']) && $_GET['saldos'] == 'SI'){//para las solicitudes con saldos
			if(isset($_GET['min']) && isset($_GET['max']) && $_GET['min'] != '' && $_GET['max'] != ''){
				$sWhere = "WHERE ov.gran_total_ov > pa.pago_pag and ov.fecha_venta_ov BETWEEN '$_GET[min]' AND '$_GET[max]'";
			}else{$sWhere = "WHERE ov.gran_total_ov > pa.pago_pag" ;}
			}else{//si no se solicitan los registros con saldo (que deben dinero)
			if(isset($_GET['min']) && isset($_GET['max']) && $_GET['min'] != '' && $_GET['max'] != ''){
				$sWhere = "WHERE ov.fecha_venta_ov BETWEEN '$_GET[min]' AND '$_GET[max]'";
			}else{$sWhere = "WHERE 1=1 " ;}
		}
	}
	//Vemos si el usuario es multisucursal
    mysql_select_db($database_horizonte, $horizonte); 
    $resultSu = mysql_query("SELECT multisucursal_u, idSucursal_u from usuarios where id_u = '$_GET[usuario]'",$horizonte) or die (mysql_error());
    $rowAU = mysql_fetch_row($resultSu); $id_suc = sqlValue($rowAU[1], "int");
    
    switch($rowAU[0]){
        case 0:
            $sWhere .= " and ov.sucursal_ov = $id_suc ";
            break;
        case 2:
            $sWhere .= " and ov.sucursal_ov = $id_suc ";
            break;
        default:
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
    if ( isset( $_GET['iSortCol_0'] ) )
    {
        $sOrder = "GROUP BY pa.referencia_pag ORDER BY ";
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
		$sOrder = "GROUP BY pa.referencia_pag ORDER BY pa.fecha_pag desc";
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
		$row[0] = $hh;
		
		$refi = sqlValue($row[1], "text");
		
		$contX = 0; $koka = '';
		
		mysql_select_db($database_horizonte, $horizonte);
		$result = mysql_query("SELECT c.concepto_to, v.contador_vc, c.".$row[14]."_precio, v.precio_original from orden_venta o left join venta_conceptos v on v.referencia_vc = o.referencia_ov left join conceptos c on c.id_to = v.id_concepto_es where o.referencia_ov = $refi order by v.contador_vc asc", $horizonte) or die (mysql_error());
		while ( $rowX = mysql_fetch_row($result) ){ $contX++;
			$koka=$koka.'<strong>'.$rowX[1].'.</strong>&nbsp;&nbsp;'.$rowX[0].'<br>';
		}
        $totalActual = $row[8];
		
		$koka = $koka."<button class='btn btn-link formatoresultados' lang='$row[4]' id='$row[12]' onClick='imprimirFormatoR(this.lang, this.id);'>FORMATO RESULTADOS</button>";
		
		$row[6] = $koka;
		
		if($row[7]==''){
			$row[7]="<span lang='$row[1]' id='$row[9]' onDblClick='muestras(this.lang, this.id);'>Doble click para editar</span>";
		}else{
			$row[7]="<span lang='$row[1]' id='$row[9]' onDblClick='muestras(this.lang, this.id);'>$row[7]</span>";
		}
        if($row[13] == 1)
            $row[15] = 100;
        $row[9] = intval(($totalActual*(1-($row[15]*0.01)))*100)/100;
        $row[10] = $row[8]-$row[9];
        $row[11] = $row[8]-$row[9];
        $idov = $row[12];
        $result = mysql_query("SELECT ps.id, ps.tiempo, u.usuario_u from pagos_sucursal ps left join usuarios u on u.id_u = ps.usuario where id_ov=".$idov, $horizonte) or die (mysql_error());
        // echo $result;
        $rowX = mysql_fetch_row($result);
        $row[13] = $row[12];
        if(!empty($rowX[0])){
            $row[11]  = 0;
            $row[12] = "<span class='ticket_pagado'>P</span>";
            $row[13] = $rowX[1];
            $row[14] = $rowX[2];
        }else{
		    $row[12] = "<input type='checkbox' name='apagarbitacora' amount='".$row[11]."' idov='".$idov."'>";
            $row[13] = "-";
            $row[14] = "-";
        }
        $row[15] = "<button class='btn btn-primary' lang='$row[1]' id='$row[4]' onClick='ver_depto(this.lang, this.id, $nombreP);'><i class='fa fa-eye'></i></button>";
		$output['aaData'][] = $row;
    }
    echo json_encode( $output );
?>
