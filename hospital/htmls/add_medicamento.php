<div class="modal-dialog modal-lg" role="document" id="contenido_ficha_usuario">
    <div class="modal-content animated flipInY">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><strong><span id="titulo_modal">NOTAS DE HOSPITAL</span></strong></h4>
      </div>
      <div class="modal-body" id="contenido_tabi">
		  <div class="text-info"><strong>Selecciona un medicamento y si es necesario edita las indicaciones.</strong></div>
		  <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
		  	<tr class="si_impre hidden"> <td> <input style="resize:none; text-align:left" name="mi_formato" id="mi_formato" type="text" value="" class=""> </td> </tr>
			<tr class="no_impre">
				<td>
					<table width="100%" height="100%" border="0" id="dataTableMeds" class="table-condensed table-striped table-bordered table-hover" style="overflow: hidden;">
						<thead id="cabecera_tBusquedaMeds" class="">
						  <tr class="bg-primary" style="font-size: 1.1em;">
							<th id="clickmeMeds"class="titulosTabs"align="center" nowrap width="1px">#</th>
							<th class="titulosTabs" align="center" width="">GENÉRICO</th>
							<th class="titulosTabs" align="center" width="" nowrap>COMERCIAL</th>
							<th class="titulosTabs" align="center" width="" nowrap>CANTIDAD</th>
							<th class="titulosTabs" align="center" width="" nowrap>VÍA</th>
							<th class="titulosTabs" align="center" width="" nowrap>NIVEL</th>
							<th class="titulosTabs" align="center" width="" nowrap>GRUPO</th>
						  </tr>
						</thead> <tbody> <tr> <td class="dataTables_empty">Cargando datos del servidor</td> </tr> </tbody> 
						<tfoot style="display:;">
							<tr>
								<th></th>
								<th><input type="text" class="form-control input-sm" placeholder="-GENÉRICO-" style="width: 99%"/></th>
								<th><input type="text" class="form-control input-sm" placeholder="-COMERCIAL-" style="width: 99%"/></th>
								<th><input type="text" class="form-control input-sm" placeholder="-CANTIDAD-" style="width: 99%"/></th>
								<th><input type="text" class="form-control input-sm" placeholder="-VÍA-" style="width: 99%"/></th>
								<th><input type="text" class="form-control input-sm" placeholder="-NIVEL-" style="width: 99%"/></th>
								<th><input type="text" class="form-control input-sm" placeholder="-GRUPO-" style="width: 99%"/></th>
							</tr>
						</tfoot>
					</table>
				</td>
			</tr>
			<tr id="mis_indis" class="hidden">
				<td>
					<br><div class="text-info">INDICACIONES:</div>
					<textarea style="resize: none;" class="form-control" id="indicacion_m" name="indicacion_m" rows="4"></textarea>
					<input type="hidden" id="id_medi" name="id_medi"/>
		  		</td>
		    </tr>
		  </table>
	</div>
      <div class="modal-footer">
      	<div class="form-group">
        <div class="col-sm-offset-0 col-sm-12">
          <div class="checkbox">
            <button type="button" class="btn btn-success btn-sm disabled" id="btn_save_medi">GUARDAR</button>
			<button type="button" class="btn btn-danger btn-sm" data-dismiss="modal" id="btn_cancel">CANCELAR</button>
          </div>
        </div>
        </div>
      </div>
    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->