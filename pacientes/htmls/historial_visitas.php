<div class="modal-dialog modal-lg small" role="document" id="contenido_ficha_usuario">
    <div class="modal-content animated flipInY">
      <div class="modal-header">
        <button type="button" class="close hidden" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><strong><span id="titulo_modal">HISTORIAL DE VISITAS</span></strong></h4>
      </div>
      <div class="modal-body">
<input name="miFacturados" id="miFacturados" type="hidden" value="0,1">
<input name="miSaldazos" id="miSaldazos" type="hidden" value="0">
<table width="100%%" id="dataTableHistorial" class="table-condensed table-bordered">
	<input name="claveMBC" id="claveMBC" type="hidden" value="">
    <thead id="my_headHV">
      <tr class="bg-primary">
        <th></th>
        <th align="center" id="clickme_hv" width="10px">#</th>
        <th align="center" width="100" nowrap>REF</th>
        <th align="center" width="10px">ATENDIÓ</th>
        <th align="center" nowrap width="10px">CONCEPTOS</th>
        <th align="center">TOTAL($)</th>
        <th align="center">ABONADO($)</th>
        <th align="center" nowrap>
            <label for="saldazos">SALDO($)</label>&nbsp;<input id="saldazos" name="saldazos" type="checkbox" value="1">
        </th>
        <th align="center" nowrap width="30px">#PAGOS</th>
        <th align="center" nowrap width="100px" valign="middle">
            <label for="facturados">FACTURA</label>&nbsp;<input id="facturados" name="facturados" type="checkbox" value="1">
        </th>
        <th align="center" width="1px">CANCELAR</th>
      </tr>
    </thead>
    <tbody align="left"> 
    	<tr> 
        	<td class="dataTables_empty">Cargando datos del servidor</td> 
        </tr> 
    </tbody>
</table>

	</div>
    <div class="modal-footer">
      	<div class="form-group">
        <div class="col-sm-offset-0 col-sm-12">
          <div class="checkbox">
            <button type="button" class="btn btn-warning" data-dismiss="modal">Cerrar</button>
          </div>
        </div>
        </div>
    </div>
      
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->