<?php
require("../../Connections/horizonte.php"); 
    /* Array of database columns which should be read and sent back to DataTables. Use a space where * you want to insert a non-database field (for example a counter or static image) */
	
	$aColumns = array('concat(p.nombre_p," ", p.apaterno_p)', 'v.referencia_vc', 'e.concepto_to', 'es.estatus_est', 'v.id_vc', 'v.id_vc', 'v.id_vc', 'v.id_vc', 'v.id_vc', 'a.nombre_a','p.amaterno_p', 'p.id_p', 'v.id_vc', 'v.referencia_vc', 'v.contador_vc', 'v.area_vc', 'a.nombre_a' );
     
    // DB tables to use 
    $aTables = array( 'venta_conceptos v');
     
    // Indexed column (used for fast and accurate table cardinality) 
    $sIndexColumn = "v.id_vc";
     
	 // Joins   
	$sJoin = 'left JOIN pacientes p ON p.id_p = v.id_paciente_vc left join conceptos e on e.id_to = v.id_concepto_es left join estatus es on es.id_est = v.estatus_vc left join areas a on a.id_a = v.area_vc';
	 
	if(isset($_GET['min']) && isset($_GET['max']) && $_GET['min'] != '' && $_GET['max'] != ''){
	 $sWhere="WHERE v.fecha_venta_vc BETWEEN '$_GET[min]' AND '$_GET[max]' and p.id_p = v.id_paciente_vc and v.tipo_concepto_vc = 3 and v.temporal_vc = 0 ";
	}else{
	 $sWhere = "WHERE p.id_p = v.id_paciente_vc and v.tipo_concepto_vc = 3 and v.temporal_vc = 0";
	}
	
    /* Database connection information */
    $gaSql['user']       = $username_horizonte; $gaSql['password']   = $password_horizonte; $gaSql['db']         = $database_horizonte; $gaSql['server']     = $hostname_horizonte;
 
     
    $gaSql['link'] =  mysql_pconnect( $gaSql['server'], $gaSql['user'], $gaSql['password']  ) or die( 'Could not open connection to server' );
     
    mysql_select_db( $gaSql['db'], $gaSql['link'] ) or die( 'Could not select database '. $gaSql['db'] );
     
     
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
        if ( $sOrder == "ORDER BY" )
        {
            $sOrder = "";
        }
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
            if ( $sWhere == "" )
            {
                $sWhere = "WHERE ";
            }
            else
            {
                $sWhere .= " AND ";
            }
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
            if ( $aColumns[$i] == "version" )
            {
                /* Special output formatting for 'version' column */
                $row[] = ($aRow[ $aColumns[$i] ]=="0") ? '-' : $aRow[ $aColumns[$i] ];
            }
            else if ( $aColumns[$i] != ' ' )
            {
                /* General output */
				$row[] = $aRow[$i];
            }
			
		}
		$row1 = array();
        for ( $j=0 ; $j<count($aColumns) ; $j++ )
        {
			//if (!($j == 6 or $j==7)){continue;}
            if ( $aColumns[$j] == "version" )
            {
                /* Special output formatting for 'version' column */
                $row1[] = ($aRow[ $aColumns[$j] ]=="0") ? '-' : $aRow[ $aColumns[$j] ];
            }
            else if ( $aColumns[$j] != ' ' )
            {
                /* General output */
				$row1[] = $aRow[$j];
            }
        }
		//calculando el valor de los íconos dependiendo del estatus del estudio
		
		$row[0] = $row[0]." ".$row[10];
		
		$row[4] = "<button name='$row[11]' id='$row[12]' lang='$row[12]' class='icono_proceso botonaso' value='$row[12]' onClick='procesar(this.id, this.lang)' style='height:25px;width:25px;cursor:pointer;' disabled> </button>";
		$row[5] = "<button name='$row[11]' id='$row[12]' lang='$row[12]' class='icono_realizado botonaso' value='$row[12]' onClick='realizar(this.id, this.lang)' style='height:25px;width:25px;cursor:pointer;' disabled> </button>";
		$row[6] = "<button name='$row[11]' id='$row[12]' lang='$row[12]' class='icono_capturado botonaso' value='$row[12]' onClick='capturar(this.id, this.lang)' style='height:25px;width:25px;cursor:pointer;' disabled> </button>";
		$row[7] = "<button name='$row[11]' id='$row[12]' lang='$row[12]' class='icono_interpretado botonaso' value='$row[12]' onClick='interpretar(this.id, this.lang)' style='height:25px;width:25px;cursor:pointer;' disabled> </button>";
		$row[8] = "<button name='$row[11]' id='$row[12]' lang='$row[12]' class='icono_entregar botonaso' value='$row[12]' onClick='imprimir(this.id, this.lang)' style='height:25px;width:25px;cursor:pointer;' disabled> </button>";
		
		if ($row[3] == "PENDIENTE"){    $row[4] = "<button name='$row[11]' id='$row[11]' lang='$row[12]' class='icono_proceso botonaso' value='$row[12]' onClick='procesar(this.id, this.lang)' style='height:25px;width:25px;cursor:pointer;'> </button>"; }
		if ($row[3] == "PROCESO"){      $row[5] = "<button name='$row[11]' id='$row[11]' lang='$row[12]' class='icono_realizado botonaso' value='$row[12]' onClick='realizar(this.id, this.lang)' style='height:25px;width:25px;cursor:pointer;'> </button>"; }
		if ($row[3] == "CAPTURADO"){    $row[6] = "<button name='$row[11]' id='$row[11]' lang='$row[12]' class='icono_capturado botonaso' value='$row[12]' onClick='capturar(this.id, this.lang)' style='height:25px;width:25px;cursor:pointer;'> </button>"; }
		if ($row[3] == "AUTORIZADO"){    $row[7] = "<button name='$row[11]' id='$row[12]' lang='$row[12]' class='icono_interpretado botonaso mipdf' value='$row[12]' onClick='interpretar(this.id, this.lang)' style='height:25px;width:25px;cursor:pointer;'> </button>"; }
		if ($row[3] == "CARGADO"){ 
			$row[8] = "<button name='$row[11]' id='$row[11]' lang='$row[12]' class='icono_entregar botonaso' value='$row[12]' onClick='entregaE(this.lang)' style='height:25px;width:25px;cursor:pointer;'> </button>";
			$row[7] = "<button name='$row[11]' id='$row[12]' lang='$row[12]' class='icono_cargado botonaso' value='$row[12]' onClick='visualizar(this.id, this.lang)' style='height:25px;width:25px;cursor:pointer;'> </button>";
		}
		if ($row[3] == "ENTREGADO"){    $row[7] = "<button name='$row[11]' id='$row[12]' lang='$row[12]' class='icono_cargado botonaso' value='$row[12]' onClick='visualizar(this.id, this.lang)' style='height:25px;width:25px;cursor:pointer;'> </button>"; }
			
		$row[9] = "<div style=' text-align:;'>$row[16]</div>";
		
		$output['aaData'][] = $row;
    }
     
    echo json_encode( $output );
?>