<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

include_once '../../recursos/session.php';
include_once '../../Connections/database.php';
include_once '../../recursos/utilities.php';

	$id_user = $_SESSION['id']; $acceso_user = $_SESSION['MM_UserGroup'];
	
	mysql_select_db($database_horizonte, $horizonte);
 	$resultF = mysql_query("SELECT temporal_u, multisucursal_u, idSucursal_u from usuarios where id_u = $id_user limit 1 ", $horizonte) or die (mysql_error());
 	$rowF = mysql_fetch_row($resultF); $aleatorio_u = sqlValue($rowF[0], "text"); $sucursal_us = sqlValue($rowF[2], "int");

	$aColumns = array('u.id_u','t.abreviacion_ti','concat(u.nombre_u," ", u.apaterno_u)','u.usuario_u', 's.clave_su', 'c.nombre_tu', 'd.nombre_d', 'u.tCelular_u', 'u1.usuario_u', 'u.id_u', 'u.amaterno_u', 's.nombre_su', 'u.id_u','concat(u1.nombre_u," ", u1.apaterno_u)', 'u.promotor_u', 'u.id_u', 'u.activo_u','u.usuario_u','u.validado_u','u.usuarioNuevo_u');
     
    // DB tables to use 
    $aTables = array( 'usuarios u');
     
    // Indexed column (used for fast and accurate table cardinality) 
    $sIndexColumn = "u.id_u";
     
	 // Joins   hasta aqui
	$sJoin = 'left join sucursales s on s.id_su = u.idSucursal_u left join tipo_usuario c on c.id_tu = u.acceso_u left join departamentos d on d.id_d = u.idDepartamento_u left join usuarios u1 on u1.id_u = u.promotor_u left join titulos t on t.id_ti = u.id_titulo_u';
	 
    // CONDITIONS
	if($acceso_user==1){//Si es administrador
		if(isset($_GET['nombre']) and $_GET['nombre']!=''){ $sWhere = "where u.nombre_u like '$_GET[nombre]' " ; }else{$sWhere = "where 1=1 " ;}
	}else{
		/*if($rowF[1]==0){//Usuario simple, solo vé su propio usuario
			$sWhere = "where u.id_u = $id_user";
		}
		if($rowF[1]==1){//Multisucursal
			$sWhere = "where 1=1";
		}
		if($rowF[1]==2){//Multisucursal
			$sWhere = "where u.idSucursal_u = $sucursal_us";
		}*/
        $sWhere = "where 1=0 " ;
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
    $sOrder = "ORDER BY u.nombre_u asc";
    if ( isset( $_GET['iSortCol_0'] ) )
    {
        $sOrder = "ORDER BY u.nombre_u asc ";
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
     
    /* * SQL queries  * Get data to display */
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
		$row1 = array();
        for ( $j=0 ; $j<count($aColumns) ; $j++ )
        {
            if ( $aColumns[$j] == "version" ) { $row1[] = ($aRow[ $aColumns[$j] ]=="0") ? '-' : $aRow[ $aColumns[$j] ]; }
            else if ( $aColumns[$j] != ' ' ) { $row1[] = $aRow[$j]; }
        }
		$row[0]=$hh;
		$nombre_u = '"'.$row[2].'"';
		$quien = $row[2];
		$row[2] = $row[2]." ".$row[10];
		
		mysql_select_db($database_horizonte, $horizonte);
 		$resultF1 = mysql_query("SELECT temporal_u from usuarios where id_u = $row[9] limit 1 ", $horizonte) or die (mysql_error());
 		$rowF1 = mysql_fetch_row($resultF1);
		
		$mi_temp_u = '"'.$rowF1[0].'"';
		
		if($acceso_user<2 or $row[9] = $id_user){//Es admin o es él mismo
			$row[3] = "<button type='button' class='btn btn-link btn-xs' id='$row[9]' onClick='verUsuario(this.id, $nombre_u, $mi_temp_u);'>$row[3]</button>";
		}else{$row[3] = "$row[3]";}
		
		$row[4] = "<span title='$row[11]'>$row[4]</span>";
		
		/*if($row[14]!=NULL){
			$row[8] = "<button type='button' class='btn btn-link btn-xs' id='$row[15]' lang='$quien' title='$row[13]' onClick='promotor(this.id,this.lang);'>$row[8]</button>";
		}else{
			$row[8]="<div align='center'><button type='button' class='btn btn-primary btn-xs' id='$row[15]' lang='$quien' onClick='promotor(this.id,this.lang);'><i class='fa fa-search' aria-hidden='true'></i></button></div>";
		}*/
		
		if($acceso_user<2){
			$row[8] = "<div align='center'><button type='button' class='btn btn-primary btn-xs' lang='$row[12]' id='$row[17]' onClick='resetPass(this.lang, this.id);'><i class='fa fa-refresh' aria-hidden='true'></i></button></div>";
			
			if($row[16]==1){
				$row[9] = "<div align='center'><button type='button' class='btn btn-primary btn-xs' lang='$row[12]' id='$row[17]' onClick='resetP(this.lang, this.id, 1);'><i class='fa fa-check' aria-hidden='true'></i></button></div>";
			}else{
				$row[9] = "<div align='center'><button type='button' class='btn btn-danger btn-xs' lang='$row[12]' id='$row[17]' onClick='resetP(this.lang, this.id, 0);'><i class='fa fa-ban' aria-hidden='true'></i></button></div>";
			}
		}else{$row[9] = "-"; $row[8] = "-";}
		
		if($acceso_user<2){//Si es administrador
			if($row[18]==1 and $row[19]==0){
				$row[13] = "<div align='center'>SI</div>";
			}else{
				$row[13] = "<div align='center'><button type='button' class='btn btn-link btn-xs' lang='$row[12]' id='$row[17]' onClick='validar_cuenta(this.lang, $nombre_u);'>NO</button></div>";
			}
		}else{$row[13] = "<div align='center'>-</div>";}
		
		$row[10] = "<div align='center'><button type='button' class='btn btn-primary btn-xs' onClick='documentos(this.name, $nombre_u)' name='$row[15]' lang='$row[17]'><i class='fa fa-file-text' aria-hidden='true'></i></button></div>";
		
		$row[11] = "<div align='center'><button type='button' class='btn btn-primary btn-xs' onClick='permisos(this.name, $nombre_u)' name='$row[15]' lang='$row[17]'><i class='fa fa-lock' aria-hidden='true'></i></button></div>";
		
		$row[12] = "<div align='center'><button type='button' class='btn btn-primary btn-xs' onClick='ubicacion(this.name, $nombre_u)' name='$row[15]' lang='$row[17]'><i class='fa fa-map-marker' aria-hidden='true'></i></button></div>";
				
		$output['aaData'][] = $row;
		
    }
    echo json_encode( $output );
?>