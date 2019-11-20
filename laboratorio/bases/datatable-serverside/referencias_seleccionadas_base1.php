<?php
require("../../../Connections/horizonte.php");
	$aColumns = array('vc.id_avr', 'c.tipo_cvr', 'c.tipo_cvr', 'vc.para_sexo', 'vc.para_edades', 'vc.id_avr', 'vc.rango_edad1', 'vc.rango_edad2', 'vc.numero1_rango_avr', 'vc.numero2_rango_avr', 'vc.valor_maximo', 'vc.valor_minimo', 'vc.valor_estable_rmn', 'vc.valor_variable_rmn', 'vc.valor_texto', 'vc.rango_alto2', 'vc.booleano', 'vc.tipo_edad', 'vc.valor_normal_nma', 'vc.valor_r1_moderado', 'vc.valor_r2_moderado', 'vc.valor_alto_nma', 'vc.valor_normal_nma_i', 'vc.valor_r1_moderado_i', 'vc.valor_r2_moderado_i', 'vc.valor_alto_nma_i', 'vc.id_avr' );
     
    // DB tables to use 
    $aTables = array( 'asignar_valor_referencia vc');
     
    // Indexed column (used for fast and accurate table cardinality) 
    $sIndexColumn = "vc.id_avr";
     
	 // Joins   
	$sJoin = 'left join catalogo_valores_referencia c on c.id_cvr = vc.id_valor_referencia_avr ';
	 
    // CONDITIONS 
    $sWhere = "WHERE vc.aleatorio_avr = '$_GET[aleatorio]' ";

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
            else if ( $aColumns[$i] != ' ' ) { $row[] = $aRow[$i]; }
        }
		$row[0]=$hh;
		
		if($row[3]==''){ $row[3] = '-';}
		if($row[4]==''){ $row[4] = '-';}
		
		if($row[8]!='' and $row[9]!=''){
			$misRangos = '['.$row[8].' - '.$row[9].']';
			if($row[2]=='RANGO'){ 
				$row[2] = "<span style='text-decoration:; :;' lang='$row[5]' onClick='editRangoNumerico(this.lang,$row[8],$row[9])' title=''>$row[2]".$misRangos."</span>";
			}
		}else{
			if($row[2]=='RANGO'){
				$row[2] = "<span style='text-decoration:; :;' lang='$row[5]' onClick='editRangoNumerico(this.lang)'>$row[2]</span>";
			}
		}
		
		if($row[16]!=''){
			if($row[16]==1){$misRangos = 'POSITIVO';}if($row[16]==0){$misRangos = 'NEGATIVO';}
			if($row[2]=='POSITIVO-NEGATIVO'){ $row[2] = "<span style='text-decoration:; cursor:;' lang='$row[5]' onClick='editBooleano(this.lang,$row[16])' title=''>$row[2] ($misRangos)</span>";}
		}else{
			if($row[2]=='POSITIVO-NEGATIVO'){ $row[2] = "<span style='text-decoration:; cursor:;' lang='$row[5]' onClick='editBooleano(this.lang)'>$row[2]</span>";}
		}
		
		if($row[10]!=''){
			$miValorM = '['.$row[10].']';
			if($row[2]=='VALOR MAXIMO'){ 
				$row[2] = "<span style='text-decoration:; cursor:;' lang='$row[5]' onClick='editValorMaximo(this.lang,$row[10])' title=''>$row[2]".$miValorM."</span>";
			}
		}else{
			if($row[2]=='VALOR MAXIMO'){
				$row[2] = "<span style='text-decoration:; cursor:;' lang='$row[5]' onClick='editValorMaximo(this.lang)'>$row[2]</span>";
			}
		}
		
		if($row[11]!=''){
			$miValorMi = '['.$row[11].']';
			if($row[2]=='VALOR MINIMO'){ 
				$row[2] = "<span style='text-decoration:; cursor:;' lang='$row[5]' onClick='editValorMinimo(this.lang,$row[11])' title=''>$row[2]".$miValorMi."</span>";
			}
		}else{
			if($row[2]=='VALOR MINIMO'){
				$row[2]="<span style='text-decoration:; cursor:;' lang='$row[5]' onClick='editValorMinimo(this.lang)'>$row[2]</span>";
			}
		}
		
		if($row[12]!='' and $row[13]!=''){
			$miValorMi = ' ['.$row[12].'+-'.$row[13].']';
			if($row[2]=='RANGO +-'){ 
				$row[2] = "<span style='text-decoration:; cursor:;' lang='$row[5]' onClick='editRangoMM(this.lang,$row[12],$row[13])' title=''>$row[2]".$miValorMi."</span>";
			}
		}else{
			if($row[2]=='RANGO +-'){
				$row[2] = "<span style='text-decoration:; cursor:;' lang='$row[5]' onClick='editRangoMM(this.lang)'>$row[2]</span>";
			}
		}
		
		if($row[14]!=''){
			$miValorTe = ' ('.$row[14].')';
			if($row[2]=='TEXTO'){ 
				$xk = '"'.$row[14].'"';
				$row[2] = "<span style='text-decoration:; cursor:;' lang='$row[5]' onClick='editValorTexto(this.lang,$xk)' title=''>$row[2]".$miValorTe."</span>";
			}
		}else{ if($row[2]=='TEXTO'){ $row[2] = "<span>$row[2]</span>"; } }
		
		//Para valores normal, moderados y alto
		if($row[18]!='' and $row[19]!='' and $row[20]!='' and $row[21]!=''){
			$misRangos = 'NORMAL<'.$row[18].' MODERADO('.$row[19].'-'.$row[20].') ALTO>'.$row[21];
			if($row[2]=='NORMAL,MODERADO,ALTO'){ 
				$row[2] = "<span style='text-decoration:; cursor:;' lang='$row[5]' onClick='editValoresNMA(this.lang,$row[18],$row[19],$row[20],$row[21])' title=''>".$misRangos."</span>";
			}
		}else{
			if($row[2]=='NORMAL,MODERADO,ALTO'){
				$row[2] = "<span style='text-decoration:; cursor:;' lang='$row[5]' onClick='editValoresNMA(this.lang)'>$row[2]</span>";
			}
		}
		
		//Para valores normal, moderados y alto (inverso)
		if($row[22]!='' and $row[23]!='' and $row[24]!='' and $row[25]!=''){
			$misRangos = 'NORMAL>'.$row[22].' MODERADO('.$row[23].'-'.$row[24].') ALTO<'.$row[25];
			if($row[2]=='NORMAL,MODERADO,ALTO (INVERSO)'){ 
				$row[2] = "<span style='text-decoration:; cursor:;' lang='$row[5]' onClick='editValoresNMAi(this.lang,$row[22],$row[23],$row[24],$row[25])' title=''>".$misRangos."</span>";
			}
		}else{
			if($row[2]=='NORMAL,MODERADO,ALTO (INVERSO)'){
				$row[2] = "<span style='text-decoration:; cursor:;' lang='$row[5]' onClick='editValoresNMAi(this.lang)'>$row[2]</span>";
			}
		}
				
		$paraS = '"'.$row[3].'"';
		
		$row[3]="<span style='text-decoration:; cursor:;' lang='$row[5]' onClick='editPara(this.lang, $paraS)'>$row[3]</span>";
		
		$tipoE = '"'.$row[4].'"';
		$tipoEdad = '"'.$row[17].'"';
		
		if($row[17]=='a'){
			$miTipoE = 'AÑOS';
		}else if($row[17]=='m'){
			$miTipoE = 'MESES';
		}else if($row[17]=='d'){
			$miTipoE = 'DÍAS';
		}
		
		if($row[4]=='RANGO DE EDAD'){
			$miRango = '(DE '.$row[6].' A '.$row[7].' '.$miTipoE.')';
			$row[4]="<span style='text-decoration:; cursor:;' lang='$row[5]' onClick='editEdades(this.lang,$tipoE,$row[6],$row[7],$tipoEdad)' title=''>$row[4] $miRango</span>";
		}else{
			$row[4]="<span style='text-decoration:; cursor:;' lang='$row[5]' onClick='editEdades(this.lang,$tipoE);'>$row[4]</span>";
		}
		
		$row[5] = "<div style='text-align:center;'><button type='button' class='btn btn-xs btn-warning' id='$row[26]' onclick='borrarReferenciaNB(this.id);'> <i class='fa fa-trash'></i></button></div>";
		
		$output['aaData'][] = $row;
    }
    echo json_encode( $output );
?>