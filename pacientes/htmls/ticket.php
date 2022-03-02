<div class="modal-dialog" role="document" id="contenido_ficha_consulta" style="font-size:11px;">
    <div class="modal-content animated flipInY">
      <div class="modal-header">
        <button type="button" class="close hidden" data-dismiss="modal" aria-label="Close">
        	<span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title"><strong><span id="titulo_modal">IMPRIMIR TICKET DE LA ORDEN DE VENTA</span></strong></h4>
      </div>
      <div class="modal-body" align="center">
      
<table id="tablaTicket" width="280px" border="0" cellspacing="0" cellpadding="0" class="table-condensed small" style="margin-left:-25px;">
  <tr>
    <td>
    	<table width="100%" border="0" cellspacing="3" cellpadding="2" style="text-align:center;">
          <tr> <td align="center" id="myLogoS"> </td> </tr>
          <tr> <td align="center"><span id="municipioS" style="font-weight:bold;"> </span></td> </tr>
          <tr> <td><span id="calleSucursal"> </span></td> </tr>
          <tr> <td>COLONIA <span id="coloniaSucursal"> </span> <span id="cpSucursal"> </span></td> </tr>
          <tr> <td>TEL: <span id="telefonoSucursal"> </span></td> </tr>
          <tr> <td style="border-bottom:1px dotted black;">
          	<span id="municipioSucursal"> </span>, <span id="estadoSucursal"> </span>
          </td> </tr>
        </table>
    </td>
  </tr>
  <tr>
    <td> 
    	<table width="100%"border="0"cellspacing="0"cellpadding="4">
        	<tr style="display:none">
            	<td width="" nowrap>FECHA:</td>
                <td id="fechaT" align="left"></td>
            </tr>
            <tr>
            	<td width="100%" nowrap align="center" style="font-size:1.3em; font-weight:bold;" colspan="2">VENTA</td>
            </tr>
            <tr style="display:">
            	<td width="" nowrap id="" align="left" valign="top"> CLIENTE: </td>
                <td id="pacienteT" align="left">&nbsp;</td>
            </tr>
            <tr style="display:">
            	<td width="" nowrap align="left" valign="top">ATENDIÓ:</td>
                <td id="usuarioIT" align="left"></td>
            </tr>
            <tr style="display:">
            	<td width="1%" nowrap id="" align="left">REF:</td>
                <td id="referenciaT" align="left">&nbsp;</td>
            </tr>
        </table> 
    </td>
  </tr>
  <tr>
    <td id="contenedorDTticket" height="" style="min-height:50; max-height:10000;" >
    <table width="100%" height="100%" border="0" cellpadding="2" cellspacing="2" id="dataTableResumenT" class=""> <thead id="cabecera_tBusquedaTotalesTi">
          <tr>
            <th id="clickmeTiC" class="titulosTabs" align="center"><strong>#</strong></th>
            <th class="" align="center">&nbsp;</th>
            <th class="" align="center">&nbsp;</th>
            <th class="" align="center" width="200"><strong>CONCEPTO</strong></th>
            <th class="" align="center" nowrap style="white-space:nowrap;">&nbsp;</th>
            <th class="" align="right" nowrap width="" style="white-space:nowrap;"><strong>PRECIO</strong></th>
          </tr>
        </thead> <tbody> <tr valign="top"> <td class="dataTables_empty">Cargando datos del servidor</td> </tr> </tbody> 
    </table>
    </td>
  </tr>
  <tr>
    <td id="contenedorAdicionales">
    <table width="100%" border="0" cellspacing="0" cellpadding="2">
    	<tr>
        	<td align="right">SUBTOTAL</td>
            <td align="right">$&nbsp;<span id="subTotalT"></span></td>
        </tr>
        <!-- <tr>
        	<td align="right">CARGOS ADICIONALES</td>
          <td align="right">$&nbsp;<span id="adicionalesT"></span></td>
        </tr> -->
    	<tr>
        	<td align="right">DESCUENTO</td>
            <td align="right">$&nbsp;<span id="descuentoT"></span></td>
        </tr>
        <tr id="myIva" class="hidden">
        	<td align="right">IVA</td>
            <td align="right">$&nbsp;<span id="ivaT"></span></td>
        </tr>
    	<tr>
        	<td align="right"><strong>TOTAL</strong></td>
            <td align="right"><strong>$&nbsp;<span id="totalT"></span></strong></td>
        </tr>
    </table>
    </td>
  </tr>
  <tr>
    <td>
    <table width="100%"border="0"cellspacing="2"cellpadding="2">
    	<tr>
            <td align="center">**<span id="cantidadLetraT"></span>**</td>
        </tr>
    </table>
    </td>
  </tr>
  <tr id="contenedorAnteriores" class="hidden">
    <td>
    <table width="100%" border="0" cellspacing="0" cellpadding="2">
        <tr id="myAbonos">
        	<td align="right">ABONOS ANTERIORES</td>
            <td align="right">$&nbsp;<span id="abonosT"></span></td>
        </tr>
    	<tr id="mySaldos">
        	<td align="right">SALDO ANTERIOR</td>
            <td align="right">$&nbsp;<span id="saldosT"></span></td>
        </tr>
    </table>
    </td>
  </tr>
  <tr>
    <td>
    <table width="100%"border="0"cellspacing="2"cellpadding="3">
    	<tr>
        	<td align="right">FORMA DE PAGO:</td>
            <td align="right" id="formaPagoT"></td>
        </tr>
    	<tr>
        	<td align="right"><strong>SU PAGO:</strong></td>
            <td align="right" width="70"><strong>$&nbsp;<span id="pagoT"></span></strong></td>
        </tr>
    	<tr>
        	<td align="right">SALDO ACTUAL:</td>
            <td align="right" width="70">$&nbsp;<span id="saldoT"></span></td>
        </tr>
        <tr id="myAbonadoA" class="hidden">
        	<td align="right">ABONADO ACTUAL:</td>
            <td align="right" width="70">$&nbsp;<span id="abonadoAT"></span></td>
        </tr>
    </table>
    </td>
  </tr>
  <tr> <td><div style="text-align:center;"><strong>¡GRACIAS POR SU PREFERENCIA!</strong></div></td> </tr>
  <tr>
    <td style="border-bottom:1px dotted black;">
    	<table width="100%"border="0"cellspacing="0"cellpadding="4">
        	<tr>
            <td align="right" id="fechaIT" width="50%"></td>
            <td align="left" id="horaIT"></td>
         	</tr>
        </table>
    </td>
  </tr>
  <tr>
    <td>
    	<table width="100%"border="0"cellspacing="2"cellpadding="2">
        	<tr> <td id="sitioS" width="100%" align="center"> </td> </tr>
            <tr> <td id="" width="100%" align="center"><span id="emailSucursal"> </span></td> </tr>
        </table>
    </td>
  </tr>
</table>

</div>
      <div class="modal-footer">
      	<div class="form-group">
        <div class="col-sm-offset-0 col-sm-12">
            <button type='button' id="imprimirTic" class="btn btn-primary btn-sm" onClick="">Imprimir</button>
            <button type='button' id="cancTic"class="btn btn-danger btn-sm" data-dismiss="modal">Salir</button>     
        </div>
        </div>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
