<?php
require("../../Connections/horizonte.php"); 

	$obligatorio = 0;
	$aColumns = array('p.id_p', 'p.curp_p', 'nombre_completo_p', 'p.fNac_p', 'SUBSTRING(sx.cat_sexo, 1, 1)', 'p.tCelular_p', 's.clave_su', 'p.amaterno_p', 'p.id_p', 'p.id_p', 's.nombre_su', 'p.id_p', 'p.id_p', 'p.id_p');
     
    // DB tables to use 
    $aTables = array( 'pacientes p');
     
    // Indexed column (used for fast and accurate table cardinality) 
    $sIndexColumn = "p.id_p";
     
	 // Joins   hasta aqui
	$sJoin = 'left join sucursales s on s.id_su = p.idSucursal_p left join catalogo_sexos sx on sx.id_sexo = p.sexo_p';
	 
    // CONDITIONS
	if(isset($_GET['nombre'])){
		if(isset($_GET['convenio']) and $_GET['convenio']!=''){
			$lista = '0';
			mysql_select_db($database_horizonte, $horizonte);
			$consulta = "SELECT distinct(id_paciente_cvp) from convenios_paciente where id_convenio_cvp = $_GET[convenio] ";
			$query = mysql_query($consulta) or die (mysql_error());
			while ($fila = mysql_fetch_array($query)) {
				$lista = $lista.','.$fila['id_paciente_cvp'];
			};
			$sWhere = "where p.nombre_p like '$_GET[nombre]' and p.id_p in ($lista)" ;
		}else{
			$sWhere = "where p.nombre_p like '$_GET[nombre]' " ;	
		}
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
        if ( $sOrder == "ORDER BY" ) { $sOrder = ""; }
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
            else if ( $aColumns[$i] != ' ' ) { $row[] = $aRow[$i]; }			
			//para la edad
			if ($i==3){
				$fecha1 = new DateTime($row[3]); $fecha2 = new DateTime(date("Y-m-d H:i:s")); $fecha = $fecha1->diff($fecha2);
				//printf('%d AÑOS %d MESES %d DÍAS %d HORAS %d MINUTOS', $fecha->y, $fecha->m, $fecha->d, $fecha->h, $fecha->i);
				$anos=$fecha->y; $meses=$fecha->m; $dias=$fecha->d; $horas=$fecha->h; $minutos=$fecha->i; $segundos=$fecha->s;
				if($anos>0){$row[3]=$anos." AÑOS";}
				if($anos<1){
					if($meses<=2 and $meses>=1){$row[3]=$meses." MES(ES) ".$dias." DÍA(S)";}
					if($meses>=3){$row[3]=$meses." MES(ES) ";}
					if($meses==0){$row[3]=$dias." DÍA(S)";}
					if($meses==0 and $dias<=1){$row[3]=$dias." DÍA(S) ".$horas." HORA(S)";}
					if($meses==0 and $dias<1){$row[3]=$horas." HORA(S) ".$minutos." MINUTO(S)";}
				} 
				if($anos>150 or $anos<0){$row[3]="DESCONOCIDA";$obligatorio=1;}else{$obligatorio=$obligatorio;}
			}

        }
		$row1 = array();
        for ( $j=0 ; $j<count($aColumns) ; $j++ )
        {
            if ( $aColumns[$j] == "version" ) { $row1[] = ($aRow[ $aColumns[$j] ]=="0") ? '-' : $aRow[ $aColumns[$j] ]; }
            else if ( $aColumns[$j] != ' ' ) { $row1[] = $aRow[$j]; }
        }
				
		mysql_select_db($database_horizonte, $horizonte);
		 $resultRu = mysql_query("SELECT count(id_ov) from orden_venta where id_paciente_ov = $row[8]", $horizonte) or die(mysql_error());
		 $rowRu = mysql_fetch_row($resultRu);
		
		//para contar el número de convenios
		mysql_select_db($database_horizonte, $horizonte);
		$resultC = mysql_query("SELECT count(id_cvp) from convenios_paciente where id_paciente_cvp = $row[8]", $horizonte) or die(mysql_error());
		$rowC = mysql_fetch_row($resultC);
		
		$vars1 = $row[8].";]{".$row[2]." (".$rowRu[0].")";
 		
		$row[0] = "<div style='text-align:center; text-decoration:underline;'><span lang='$vars1' onClick='historialPaciente(this.lang);' style='cursor:pointer;' >$rowRu[0]</span></div>";
		
		if($rowC[0]<1){
			$row[7] = "<div style='text-align:center;'><span id='$row[8]' lang='$row[2]' onClick='verConvenios(this.id, this.lang);' style='cursor:pointer; text-decoration:underline;' title='El paciente no cuenta con beneficios'>$rowC[0]</span></div>";
		}else{
			$lista = ''; $cont = 0;
			mysql_select_db($database_horizonte, $horizonte);
			$consulta = "SELECT c.id_convenio_cvp, c1.convenio_cv from convenios_paciente c left join convenios c1 on c1.id_cv = c.id_convenio_cvp where c.id_paciente_cvp = $row[9] ";
			$query = mysql_query($consulta) or die (mysql_error());
			while ($fila = mysql_fetch_array($query)) {
				if($cont==0){$lista = $fila['convenio_cv'];}
				else{$lista = $lista.','.$fila['convenio_cv'];}
				$cont++;
			};//echo $lista;
			$row[7] = "<div style='text-align:center;'><span id='$row[8]' lang='$row[2]' onClick='verConvenios(this.id, this.lang);' style='cursor:pointer; text-decoration:underline;' title='$lista'>$rowC[0]</span></div>";
		}
		
		$nombreP = '"'.$row[2].'"';
		
		$row[2] = "<span id='$row[11]' onClick='verPaciente(this.id);' style='cursor:pointer; text-decoration:underline;' >$row[2]</span>";
		
		$row[4] = "<div style='text-align:center;'>$row[4]</div>";
		
		$tituloSu = $row[10];
		$row[6] = "<span title='$tituloSu'>$row[6]</span>";
		
		$row[8] = "<button onClick='nuevaVisita(this.id);' id='$row[9]' class='ui-button ui-widget ui-corner-all ui-button-icon-only' title=''><span class='ui-icon ui-icon-cart'></span> Nueva visita</button>";
		
		$row[9] = "<button onClick='formatos(this.id, $nombreP)' id='$row[11]' class='ui-button ui-widget ui-corner-all ui-button-icon-only' title=''><span class='ui-icon ui-icon-document'></span> Formatos</button>";
		
		$row[10] = "<button onClick='documentos(this.id, $nombreP)' id='$row[11]' class='ui-button ui-widget ui-corner-all ui-button-icon-only' title=''><span class='ui-icon ui-icon-folder-collapsed'></span> Documentos</button>";
		
		$row[11] = "<button onClick='eventos(this.id, $nombreP)' id='$row[11]' class='ui-button ui-widget ui-corner-all ui-button-icon-only' title=''><span class='ui-icon ui-icon-heart'></span> Eventos</button>";
		
		$row[12] = "<div align='center'><button class='ui-button ui-widget ui-corner-all ui-button-icon-only botonaso' onClick='ubicacion(this.name, $nombreP)' name='$row[12]' lang='$row[3]' title=''><span class='ui-icon ui-icon-pin-s'></span>B</button></div>";
		$row[13] = "<div align='center'><button class='ui-button ui-widget ui-corner-all ui-button-icon-only botonaso' onClick='expediente(this.name, $nombreP)' name='' lang='' title=''><span class='ui-icon ui-icon-note'></span>B</button></div>";
		
		$output['aaData'][] = $row;
		
    }
    echo json_encode( $output );
?>