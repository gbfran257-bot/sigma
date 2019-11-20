<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Documento sin título</title>
</head>

<body>

<div id="historialVisitasPaciente">
<table width="99%" cellspacing="0" id="dataTableHistorial" height="100%" border="0" cellpadding="4" class="tablilla" style="font-size:12px;">
	<input name="claveMBC" id="claveMBC" type="hidden" value="">
    <thead id="my_head">
      <tr style="font-size:1.2em;" bgcolor="#FF6633">
        <th class="titulosTabs" align="center" id="clickme_hv" width="10px" style="color:white;" bgcolor="">#</th>
        <th class="titulosTabs" align="center" style="color:white;" width="100">REFERENCIA</th>
        <th class="titulosTabs" align="center" width="10px" style="color:white;">ATENDIÓ</th>
        <th class="titulosTabs" align="center" nowrap width="10px" style="color:white;">CONCEPTOS</th>
        <th class="titulosTabs" align="center" style="color:white;">TOTAL($)</th>
        <th class="titulosTabs" align="center" style="color:white;">ABONADO($)</th>
        <th class="titulosTabs" align="center" style="color:white;">
        	<div style="white-space:nowrap; vertical-align:central; height:100%;">
            	<label for="saldazos">SALDO($)</label>&nbsp;<input id="saldazos" name="saldazos" type="checkbox" value="1">
            </div>
        </th>
        <th class="titulosTabs" align="center" nowrap width="30px" style="color:white;">#PAGOS</th>
        <th class="titulosTabs" align="center" nowrap width="130px" valign="middle" style="color:white;">
        	<div style="white-space:nowrap; vertical-align:central; height:100%;">
            	<label for="facturados">FACTURA</label>&nbsp;<input id="facturados" name="facturados" type="checkbox" value="1">
            </div>
        </th>
      </tr>
    </thead>
    <tbody align="left"> 
    	<tr> 
        	<td class="dataTables_empty">Cargando datos del servidor</td> 
        </tr> 
    </tbody>
  </table>
  
</div>

</body>
</html>
