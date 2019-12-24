<div class="modal-dialog modal-lg" role="document" id="contenido_ficha_usuario">
    <div class="modal-content animated flipInY">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><strong><span id="titulo_modal">CREAR UN FORMATO</span></strong></h4>
      </div>
      <div class="modal-body">
		  <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
		  	<tr class="si_impre hidden"> <td> <input style="resize:none; text-align:left" name="mi_formato" id="mi_formato" type="text" value="" class=""> </td> </tr>
			<tr class="no_impre">
				<td>
					<table width="100%" height="100%" border="0" id="dataTableFormatos" class="table-condensed table-striped table-bordered table-hover" style="overflow: hidden;">
						<thead id="cabecera_tBusquedaFormatos" class="">
						  <tr class="bg-primary" style="font-size: 1.1em;">
							<th id="clickmeFmts"class="titulosTabs"align="center" nowrap width="1px">#</th>
							<th class="titulosTabs" align="center" width="">FORMATO</th>
							<th class="titulosTabs" align="center" width="" nowrap>CREAR</th>
						  </tr>
						</thead> <tbody> <tr> <td class="dataTables_empty">Cargando datos del servidor</td> </tr> </tbody> 
						<tfoot style="display:;">
							<tr>
								<th><input type="hidden" value=""></th>
								<th><input type="text" class="form-control input-sm" placeholder="-FORMATO-" style="width: 99%"/></th>
								<th></th>
							</tr>
						</tfoot>
					</table>
				</td>
			</tr>
		  </table>
	</div>
      <div class="modal-footer">
      	<div class="form-group">
        <div class="col-sm-offset-0 col-sm-12">
          <div class="checkbox">
			<!--<button type="button" class="btn btn-success hidden si_impre" id="btn_imprimir">IMPRIMIR</button>-->
			<button type="button" class="btn btn-warning hidden si_impre" id="btn_regresar" onClick="regresar();">REGRESAR</button>
            <button type="button" class="btn btn-danger" data-dismiss="modal" id="btn_cancel">SALIR</button>
          </div>
        </div>
        </div>
      </div>
    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->