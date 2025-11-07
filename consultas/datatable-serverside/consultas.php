<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");
    /* Array of database columns which should be read and sent back to DataTables. Use a space where  * you want to insert a non-database field (for example a counter or static image) */
	
	$aColumns = array('v.id_vc','v.referencia_vc', 'concat_ws(" ", p.nombre_p, p.apaterno_p, p.amaterno_p)', 'concat(m.nombre_u," ", m.apaterno_u)', 'replace(e.concepto_to,"CONSULTA DE ","")', 'v.fecha_venta_vc', 's.clave_su', 'es.estatus_est', 'v.urgente_vc', 'p.id_p', 'm.id_u', 'v.fecha_venta_vc','p.amaterno_p', 'm.amaterno_u', 'v.id_vc', 'DATE_FORMAT(v.fecha_venta_vc,"%d/%c/%Y %H:%i")', 'v.fechaEdo3_e', 'v.fecha_venta_vc', 'v.nota_interpretacion', 'es.estatus_est', 's.nombre_su', 's.id_su','o.motivo_c_ov','p.fNac_p','SUBSTRING(sx.cat_sexo, 1, 1)','concat(m.nombre_u," ", m.apaterno_u, " ", m.amaterno_u)', 'replace(e.concepto_to,"CONSULTA DE ","")','s.clave_su','v.urgente_vc','concat(nu.nombre_u, " ", nu.apaterno_u, " ", nu.amaterno_u)', 'e.concepto_to', 'archivo_consultas' );
     
    // DB tables to use 
    $aTables = array( 'venta_conceptos v');
     
    // Indexed column (used for fast and accurate table cardinality) 
    $sIndexColumn = "v.id_vc";
     
	 // Joins   
	$sJoin = 'left JOIN pacientes p ON p.id_p = v.id_paciente_vc left join usuarios m on m.id_u = v.id_personal_medico_vc left join estatus es on es.id_est = v.estatus_vc left join conceptos e on e.id_to = v.id_concepto_es left join orden_venta o on o.referencia_ov = v.referencia_vc left join sucursales s on s.id_su = o.sucursal_ov left join catalogo_sexos sx on sx.id_sexo = p.sexo_p left join usuarios nu on nu.id_u = o.usuario_ov';
	
	mysql_select_db($database_horizonte, $horizonte); 
	$resultAU = mysql_query("SELECT multisucursal_u, idSucursal_u from usuarios where id_u = '$_GET[idU]'",$horizonte) or die (mysql_error());
	$rowAU = mysql_fetch_row($resultAU); $id_suc = sqlValue($rowAU[1], "int");
	
	switch($rowAU[0]){
		case 0://Solo vé lo suyo
			if(isset($_GET['min']) && isset($_GET['max']) && $_GET['min'] != '' && $_GET['max'] != ''){
			  $sWhere="WHERE v.fecha_venta_vc BETWEEN '$_GET[min]' AND '$_GET[max]' and  e.id_tipo_concepto_to = 1 and v.temporal_vc=0 and v.id_radiologo_externo = '$_GET[idU]' ";
			}else{
			  $sWhere = "WHERE e.id_tipo_concepto_to = 1 and v.temporal_vc = 0 and v.id_radiologo_externo = '$_GET[idU]' ";
			}
		break;
		case 2://Ve todo lo de su sucursal y lo suyo
			if(isset($_GET['min']) && isset($_GET['max']) && $_GET['min'] != '' && $_GET['max'] != ''){
			  $sWhere="WHERE v.fecha_venta_vc BETWEEN '$_GET[min]' AND '$_GET[max]' and  e.id_tipo_concepto_to = 1 and v.temporal_vc=0 and (o.sucursal_ov = $id_suc or v.id_radiologo_externo = '$_GET[idU]') ";
			}else{
			  $sWhere = "WHERE e.id_tipo_concepto_to = 1 and v.temporal_vc = 0 and (o.sucursal_ov = $id_suc or v.id_radiologo_externo = '$_GET[idU]') ";
			}
		break;
		case 1://Ve todo de todas las sucursales
			if(isset($_GET['min']) && isset($_GET['max']) && $_GET['min'] != '' && $_GET['max'] != ''){
			  $sWhere="WHERE v.fecha_venta_vc BETWEEN '$_GET[min]' AND '$_GET[max]' and  e.id_tipo_concepto_to = 1 and v.temporal_vc=0 ";
			}else{
			  $sWhere = "WHERE e.id_tipo_concepto_to = 1 and v.temporal_vc = 0 ";
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
    $sOrder = "";
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

			//si es la columna de edad realiza la consulta correspondiente al caso(año o mes)	
			if($i==23){

                $busqueda_años = $_GET['sSearch_'.$i];
                if(strpos($busqueda_años, "A")==true){//si es A es busqueda por años
                    $busqueda_años = preg_replace('([^0-9])', '', $busqueda_años);
                    $sWhere .= " YEAR(NOW()) - YEAR(fNac_p) = $busqueda_años ";
                }else if(strpos($busqueda_años, "M")==true){//si es M es busqueda por meses
                    $busqueda_años = preg_replace('([^0-9])', '', $busqueda_años);
                    $sWhere .= " PERIOD_DIFF(EXTRACT(YEAR_MONTH FROM NOW()), EXTRACT(YEAR_MONTH FROM fNac_p)) = $busqueda_años ";
                }else{//si no encuentra letra aplica busqueda por años
                    $busqueda_años = preg_replace('([^0-9])', '', $busqueda_años);
                    $sWhere .= " YEAR(NOW()) - YEAR(fNac_p) = $busqueda_años ";
                }

            }else{
				$sWhere .= $aColumns[$i]." LIKE '%".mysql_real_escape_string($_GET['sSearch_'.$i])."%' ";
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
		
		//PARA LA EDAD
		
			$fecha1 = new DateTime($row[23]); $fecha2 = new DateTime(date("Y-m-d H:i:s")); $fecha = $fecha1->diff($fecha2);
			//printf('%d AÑOS %d MESES %d DÍAS %d HORAS %d MINUTOS', $fecha->y, $fecha->m, $fecha->d, $fecha->h, $fecha->i);
			$anos=$fecha->y; $meses=$fecha->m; $dias=$fecha->d; $horas=$fecha->h; $minutos=$fecha->i; $segundos=$fecha->s;
			if($anos>0){$row[4]=$anos." AÑOS";}
			if($anos<1){
				if($meses<=2 and $meses>=1){$row[4]=$meses." MES(ES) ".$dias." DÍA(S)";}
				if($meses>=3){$row[4]=$meses." MES(ES) ";}
				if($meses==0){$row[4]=$dias." DÍA(S)";}
				if($meses==0 and $dias<=1){$row[4]=$dias." DÍA(S) ".$horas." HORA(S)";}
				if($meses==0 and $dias<1){$row[4]=$horas." HORA(S) ".$minutos." MINUTO(S)";}
			} 
			if($anos>150 or $anos<0){$row[4]="DESCONOCIDA";$obligatorio=1;}else{$obligatorio=$obligatorio;}
		
		//

		//para el contador de tiempo
		$fecha1 = new DateTime($row[5]); $fecha2 = new DateTime(date("Y-m-d H:i:s")); $fecha = $fecha1->diff($fecha2);
		$anos=$fecha->y; $meses=$fecha->m; $dias=$fecha->d; $horas=$fecha->h; $minutos=$fecha->i; $segundos=$fecha->s;
		// $row[5] = sprintf("%02d", $dias)."D/".sprintf("%02d", $horas).":".sprintf("%02d", $minutos).":".sprintf("%02d", $segundos); 
		// $row[5] = "<div align='center'><span id='$row[14]' lang='$row[11]' class='miConta'>$row[5]</span></div>";
		$row[8] = sprintf("%02d", $dias)."D/".sprintf("%02d", $horas).":".sprintf("%02d", $minutos).":".sprintf("%02d", $segundos); 
		$row[8] = "<div align='center'><span id='$row[14]' lang='$row[11]' class='miConta'>$row[8]</span></div>";
		
		$row[2] = $row[2];//Nombre completo del paciente
		//$row[3] = $row[3]." ".$row[13];//Nombre completo del médico $row[1] = "$row[1]</span>";
		$row[1] = "<span lang='$row[1]' style='text-decoration:underline; cursor:pointer; color:blue;' onClick='ver_ov(this.lang)'>$row[1]</span><br>$row[29] <br>$row[15]";
		$row[3] = $row[22];//Nombre completo del médico $row[1] = "$row[1]</span>";
		$row[5] = "<div align='center'>$row[24]</div>";
		$row[6] = $row[25];
		$row[7] = $row[26];
		

		//$row[5] = "<div align='left'><button lang='$row[12]' class='icono_vacio botonaso' onClick='signosVvacios(this.lang)' style='height:25px;width:25px;cursor:pointer;'></button></div>";
		//$row[6] = "<div align='center'><button lang='$row[12]' class='icono_vacio botonaso' onClick='historiaCvacia(this.lang)' style='height:25px;width:25px;cursor:pointer;'></button></div>";
		
		//Si el paciente no tiene signos vitales enconces el ícono de SV sera un ? en caso de que si tenga el ícono será un info o alerta si tiene signos anormales
		mysql_select_db($database_horizonte, $horizonte); $resultS = mysql_query("SELECT count(id_sv) from signos_vitales where id_paciente_sv = $row[9] ", $horizonte) or die (mysql_error()); $rowS = mysql_fetch_row($resultS);
		mysql_select_db($database_horizonte, $horizonte); $resultS1 = mysql_query("SELECT DATE_FORMAT(fecha_sv,'%d/%c/%Y') from signos_vitales where id_paciente_sv = $row[9] order by id_sv desc", $horizonte) or die (mysql_error()); $rowS1 = mysql_fetch_row($resultS1);
		// if($rowS[0]>0){$row[5] = "<div align=''><span lang='$row[12]' onClick='verSignosV(this.lang)' style='cursor:pointer;'>$rowS1[0]</span></div>";}
		
		mysql_select_db($database_horizonte, $horizonte); $resultH1 = mysql_query("SELECT count(id_hc) from historia_clinica where id_paciente_hc = $row[9] ", $horizonte) or die (mysql_error()); $rowH1 = mysql_fetch_row($resultH1);
		if($rowH1[0]<1){
			mysql_select_db($database_horizonte, $horizonte);
		    $sqlH2="INSERT INTO historia_clinica(id_paciente_hc,id_usuario_hc,fecha_registro_hc) VALUES ($row[9],'$_GET[idU]',now())";
			$insertH2 = mysql_query($sqlH2, $horizonte) or die (mysql_error());
		}
		
		mysql_select_db($database_horizonte, $horizonte); 
		$resultH = mysql_query("SELECT temporal_hc from historia_clinica where id_paciente_hc = $row[9] ", $horizonte) or die (mysql_error()); $rowH = mysql_fetch_row($resultH);
		//if($rowH[0]==0){$row[6] = "<div align='center'><button lang='$row[12]' class='icono_verInfo botonaso' onClick='historiaCvacia(this.lang)' style='height:25px;width:25px;cursor:pointer;'></button></div>";}
		
		if ($row[19] == "PENDIENTE"){ 
			mysql_select_db($database_horizonte, $horizonte); 
			$qryPendiente = mysql_query("SELECT CONCAT_WS(' ', u.nombre_u, u.apaterno_u, u.amaterno_u), DATE_FORMAT(vc.fechaEdo1_e,'%d/%m/%Y %H:%i:%s') FROM venta_conceptos vc LEFT JOIN usuarios u ON u.id_u = vc.usuarioEdo1_e WHERE id_vc = " . $row[0],$horizonte) or die (mysql_error());
			$pendiente = mysql_fetch_row($qryPendiente);

			// $row[7] = "<span id='$row[14]' lang='$row[9]' onClick='atenderC(this.lang, this.id,1,$row[21],$row[21])' style='cursor:pointer; text-decoration:underline;'>$row[7]</span>";
			$row[10] = "<span id='$row[14]' lang='$row[9]' onClick='atenderC(this.lang, this.id,1,$row[21],$row[21])' style='cursor:pointer; text-decoration:underline;'>$row[19]</span><br>$pendiente[0]<br>$pendiente[1]";
			/* $row[8] = "<div align='center'>-</div>"; */ 
			$row[11] = "<div align='center'>-</div>"; 
			// $row[9] = "<div align='center'>-</div>";
			$row[12] = "<div align='center'>-</div>";
		}
		else if($row[19] == "PROCESO"){
			mysql_select_db($database_horizonte, $horizonte); 
			$qryProceso = mysql_query("SELECT CONCAT_WS(' ', u.nombre_u, u.apaterno_u, u.amaterno_u), DATE_FORMAT(vc.fechaEdo2_e,'%d/%m/%Y %H:%i:%s') FROM venta_conceptos vc LEFT JOIN usuarios u ON u.id_u = vc.usuarioEdo2_e WHERE id_vc = " . $row[0],$horizonte) or die (mysql_error());
			$proceso = mysql_fetch_row($qryProceso);

			// $row[7] = "<span id='$row[14]' lang='$row[9]' onClick='atenderC(this.lang, this.id,2,$row[21],$row[21])' style='cursor:pointer; text-decoration:underline;'>$row[7]</span>";
			$row[10] = "<span id='$row[14]' lang='$row[9]' onClick='atenderC(this.lang, this.id,2,$row[21],$row[21])' style='cursor:pointer; text-decoration:underline;'>$row[19]</span><br>$proceso[0]<br>$proceso[1]";

			mysql_select_db($database_horizonte, $horizonte); 
			$qryZapataC = mysql_query("SELECT COUNT(*) FROM modificaciones_sigma WHERE nombre = 'zapata' AND habilitado = 1 ", $horizonte) or die(mysql_error()); 
			$zapataC = mysql_fetch_row($qryZapataC);
			$permiso = $zapataC[0];

			if($permiso > 0){
				$row[11] = "<button id='$row[14]' lang='$row[9]' class='btn btn-xs btn-primary' onClick='imprimirNM(this.lang,this.id, {$row[21]})'><svg style='fill: #FFF;' xmlns='http://www.w3.org/2000/svg' height='1em' viewBox='0 0 512 512'><path d='M128 0C92.7 0 64 28.7 64 64v96h64V64H354.7L384 93.3V160h64V93.3c0-17-6.7-33.3-18.7-45.3L400 18.7C388 6.7 371.7 0 354.7 0H128zM384 352v32 64H128V384 368 352H384zm64 32h32c17.7 0 32-14.3 32-32V256c0-35.3-28.7-64-64-64H64c-35.3 0-64 28.7-64 64v96c0 17.7 14.3 32 32 32H64v64c0 35.3 28.7 64 64 64H384c35.3 0 64-28.7 64-64V384zM432 248a24 24 0 1 1 0 48 24 24 0 1 1 0-48z' /></svg></button> <button onClick='verArchivos($row[14],\"$row[31]\")' class='btn $estilo_boton btn-xs' id='btnCargarArch' name='btnCargarArch' type='button'> <i class='fa fa-file-pdf-o' aria-hidden='true'></i> </button>";
				
				$row[12] = "<button id='$row[14]' lang='$row[9]' class='btn btn-xs btn-primary' onClick='imprimirRM(this.lang,this.id, {$row[21]})'><svg style='fill: #FFF;' xmlns='http://www.w3.org/2000/svg' height='1em' viewBox='0 0 512 512'><path d='M128 0C92.7 0 64 28.7 64 64v96h64V64H354.7L384 93.3V160h64V93.3c0-17-6.7-33.3-18.7-45.3L400 18.7C388 6.7 371.7 0 354.7 0H128zM384 352v32 64H128V384 368 352H384zm64 32h32c17.7 0 32-14.3 32-32V256c0-35.3-28.7-64-64-64H64c-35.3 0-64 28.7-64 64v96c0 17.7 14.3 32 32 32H64v64c0 35.3 28.7 64 64 64H384c35.3 0 64-28.7 64-64V384zM432 248a24 24 0 1 1 0 48 24 24 0 1 1 0-48z' /></svg></button>";
			}else{
				/* $row[8] = "<div align='center'>-</div>"; */ 
				$row[11] = "<div align='center'>-</div>"; 
				// $row[9] = "<div align='center'>-</div>";
				$row[12] = "<div align='center'>-</div>";
			}

		}
		else if($row[19] == "FINALIZADA"){
			$qryFinalizada = mysql_query("SELECT CONCAT_WS(' ', u.nombre_u, u.apaterno_u, u.amaterno_u), DATE_FORMAT(vc.fechaEdo3_e,'%d/%m/%Y %H:%i:%s') FROM venta_conceptos vc LEFT JOIN usuarios u ON u.id_u = vc.usuarioEdo3_e WHERE id_vc = " . $row[0],$horizonte) or die (mysql_error());
			$finalizada = mysql_fetch_row($qryFinalizada);

			//para el contador de tiempo
			$fecha1 = new DateTime($row[17]); $fecha2 = new DateTime($row[16]); $fecha = $fecha1->diff($fecha2);
			$anos=$fecha->y; $meses=$fecha->m; $dias=$fecha->d; $horas=$fecha->h; $minutos=$fecha->i; $segundos=$fecha->s;
			// $row[5]=sprintf("%02d",$dias)."D/".sprintf("%02d",$horas).":".sprintf("%02d", $minutos).":".sprintf("%02d", $segundos);
			$row[8]=sprintf("%02d",$dias)."D/".sprintf("%02d",$horas).":".sprintf("%02d", $minutos).":".sprintf("%02d", $segundos);
		
			//$row[7] = "<span id='$row[17]' lang='$row[12]' onClick='preImprimir($row[9], $row[12])' style='cursor:pointer; text-decoration:underline;'>$row[7]</span>";ya estaba comentado
			// $row[7] = "<span id='$row[14]' lang='$row[9]' onClick='atenderC(this.lang,this.id,3,$row[21],$row[21])' style='cursor:pointer; text-decoration:underline;'>$row[7]</span>";
			$row[10] = "<span id='$row[14]' lang='$row[9]' onClick='atenderC(this.lang,this.id,3,$row[21],$row[21])' style='cursor:pointer; text-decoration:underline;'>$row[19]</span><br>$finalizada[0]<br>$finalizada[1]";
						
			// $row[5] = "<div align='center'><span id='$row[14]' lang='$row[11]' class='miContaX'>$row[5]</span></div>";
			$row[8] = "<div align='center'><span id='$row[14]' lang='$row[11]' class='miContaX'>$row[8]</span></div>";
			
			//Checamos si tiene nota de evo
			if($row[18]==''){ 
				/* $row[7] = "*$row[7]"; */ 
				$row[10] = "*$row[19]"; 
			}else{ }

			if($row[31]!=='0'){
				$estilo_boton = "btn-info";
			}else{
				$estilo_boton = "btn-danger";
			}
			
			// $row[8] = "<button id='$row[14]' lang='$row[9]' class='btn btn-xs btn-primary' onClick='imprimirNM(this.lang,this.id)'>Imprimir</button>";
			$row[11] = "<button id='$row[14]' lang='$row[9]' class='btn btn-xs btn-primary' onClick='imprimirNM(this.lang,this.id, {$row[21]})'><svg style='fill: #FFF;' xmlns='http://www.w3.org/2000/svg' height='1em' viewBox='0 0 512 512'><path d='M128 0C92.7 0 64 28.7 64 64v96h64V64H354.7L384 93.3V160h64V93.3c0-17-6.7-33.3-18.7-45.3L400 18.7C388 6.7 371.7 0 354.7 0H128zM384 352v32 64H128V384 368 352H384zm64 32h32c17.7 0 32-14.3 32-32V256c0-35.3-28.7-64-64-64H64c-35.3 0-64 28.7-64 64v96c0 17.7 14.3 32 32 32H64v64c0 35.3 28.7 64 64 64H384c35.3 0 64-28.7 64-64V384zM432 248a24 24 0 1 1 0 48 24 24 0 1 1 0-48z' /></svg></button> <button onClick='verArchivos($row[14],\"$row[31]\")' class='btn $estilo_boton btn-xs' id='btnCargarArch' name='btnCargarArch' type='button'> <i class='fa fa-file-pdf-o' aria-hidden='true'></i> </button>";
			// $row[9] = "<button id='$row[14]' lang='$row[9]' class='btn btn-xs btn-primary' onClick='imprimirRM(this.lang,this.id)'>Imprimir</button>";
			$row[12] = "<button id='$row[14]' lang='$row[9]' class='btn btn-xs btn-primary' onClick='imprimirRM(this.lang,this.id, {$row[21]})'><svg style='fill: #FFF;' xmlns='http://www.w3.org/2000/svg' height='1em' viewBox='0 0 512 512'><path d='M128 0C92.7 0 64 28.7 64 64v96h64V64H354.7L384 93.3V160h64V93.3c0-17-6.7-33.3-18.7-45.3L400 18.7C388 6.7 371.7 0 354.7 0H128zM384 352v32 64H128V384 368 352H384zm64 32h32c17.7 0 32-14.3 32-32V256c0-35.3-28.7-64-64-64H64c-35.3 0-64 28.7-64 64v96c0 17.7 14.3 32 32 32H64v64c0 35.3 28.7 64 64 64H384c35.3 0 64-28.7 64-64V384zM432 248a24 24 0 1 1 0 48 24 24 0 1 1 0-48z' /></svg></button>";
			
		}else{
			/* $row[8] = "<div align='center'>-</div>"; */ 
			$row[11] = "<div align='center'>-</div>"; 
			// $row[9] = "<div align='center'>-</div>";
			$row[12] = "<div align='center'>-</div>";
		}
		
		// if ($row[8] == 1){ 
		if ($row[28] == 1){ 
			/* $row[7] = "<span style='color:red;'>$row[7]</span>"; */ 
			$row[10] = "<span style='color:red;'>$row[19]</span>"; 
		}//Para las consultas urgentes
		
		// $row[6] = "<span title='$row[20]'>$row[6]</span>";
		
		$row[9] = "<div align='center'><span title='$row[20]'>$row[27]</span></div>";
		$row[0] = "<span>$hh</span>";

		$row[13] = $row[30];
		
		
		$output['aaData'][] = $row;
    }
    echo json_encode( $output );
?>
