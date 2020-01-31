<div class="modal-dialog modal-lg" role="document" id="contenido_ficha_usuario">
    <div class="modal-content animated flipInY">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><strong><span id="titulo_modal">NOTAS DE HOSPITAL</span></strong></h4>
      </div>
        <div class="modal-body" id="contenido_tabi">
			
			<div>

			  <!-- Nav tabs -->
			  <ul class="nav nav-tabs" role="tablist">
				<li role="presentation" class="active"><a href="#t-asignados" aria-controls="t-asignados" role="tab" data-toggle="tab" id="tap-asignados">MEDICAMENTOS ASIGNADOS</a></li>
				<li role="presentation"><a href="#t-aplicados" aria-controls="profile" role="tab" data-toggle="tab" id="tap-aplicados">MEDICAMENTOS APLICADOS</a></li>
			  </ul>

			  <!-- Tab panes -->
			  <div class="tab-content">
				<div role="tabpanel" class="tab-pane active" id="t-asignados">
					<table width="100%" height="100%" border="0" id="dataTableMedicamentos" class="table-condensed table-striped table-bordered table-hover" style="overflow: hidden;">
						<thead id="cabecera_tBusquedaMedicamentos" class="">
						  <tr class="bg-primary" style="font-size: 1.1em;">
							<th id="clickmeMdtos"class="titulosTabs"align="center" nowrap width="1px">#</th>
							<th class="titulosTabs" align="center" width="">FECHA/HORA</th>
							<th class="titulosTabs" align="center" width="" nowrap>
								<button type="button" class="btn btn-info btn-xs" id="btn_add_medicamento">MEDICAMENTO <i class='fa fa-plus' aria-hidden='true'></i></button>
							</th>
							<th class="titulosTabs" align="center" width="" nowrap>PERSONAL MÉDICO</th>
							<th class="titulosTabs" align="center" width="" nowrap>INDICACIÓN</th>
							<th class="titulosTabs" align="center" width="" nowrap>APLICAR</th>
						  </tr>
						</thead> <tbody> <tr> <td class="dataTables_empty">Cargando datos del servidor</td> </tr> </tbody> 
						<tfoot style="display:;">
							<tr>
								<th></th>
								<th><input type="text" class="form-control input-sm" placeholder="-FECHA-" style="width: 99%"/></th>
								<th><input type="text" class="form-control input-sm" placeholder="-MEDICAMENTO-" style="width: 99%"/></th>
								<th><input type="text" class="form-control input-sm" placeholder="-PERSONAL MÉDICO-" style="width: 99%"/></th>
								<th></th>
								<th></th>
							</tr>
						</tfoot>
					</table>
				</div>
				<div role="tabpanel" class="tab-pane" id="t-aplicados">
					<table width="100%" height="100%" border="0" id="dataTableMedicamentosA" class="table-condensed table-striped table-bordered table-hover" style="overflow: hidden;">
						<thead id="cabecera_tBusquedaMedicamentosA" class="">
						  <tr class="bg-primary" style="font-size: 1.1em;">
							<th id="clickmeMdtosA"class="titulosTabs"align="center" nowrap width="1px">#</th>
							<th class="titulosTabs" align="center" width="">MEDICAMENTO</th>
							<th class="titulosTabs" align="center" width="" nowrap>PRESENTACIÓN</th>
							<th class="titulosTabs" align="center" width="" nowrap>INDICACIÓN</th>
							<th class="titulosTabs" align="center" width="" nowrap>APLICÓ</th>
							<th class="titulosTabs" align="center" width="" nowrap>FECHA/HORA</th>
						  </tr>
						</thead> <tbody> <tr> <td class="dataTables_empty">Cargando datos del servidor</td> </tr> </tbody> 
						<tfoot style="display:;">
							<tr>
								<th></th>
								<th><input type="text" class="form-control input-sm" placeholder="-MEDICAMENTO-" style="width: 99%"/></th>
								<th><input type="text" class="form-control input-sm" placeholder="-PRESENTACIÓN-" style="width: 99%"/></th>
								<th></th>
								<th><input type="text" class="form-control input-sm" placeholder="-APLICÓ-" style="width: 99%"/></th>
								<th><input type="text" class="form-control input-sm" placeholder="-FECHA/HORA-" style="width: 99%"/></th>
							</tr>
						</tfoot>
					</table>
				</div>
				  
			  </div>

			</div>
			
			<div>
			
		</div>
      <div class="modal-footer">
      	<div class="form-group">
        <div class="col-sm-offset-0 col-sm-12">
          <div class="checkbox">
			<!--<button type="button" class="btn btn-success hidden si_impre" id="btn_imprimir">IMPRIMIR</button>-->
			<button type="button" class="btn btn-warning hidden si_impre" id="btn_regresar" onClick="regresar();">REGRESAR</button>
            <button type="button" class="btn btn-info hidden" id="btn_print">IMPRIMIR</button>
			<button type="button" class="btn btn-danger" data-dismiss="modal" id="btn_cancel">SALIR</button>
          </div>
        </div>
        </div>
      </div>
    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->