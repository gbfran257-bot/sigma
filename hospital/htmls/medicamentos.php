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
				<li role="presentation" class="active"><a href="#t-asignados" aria-controls="t-asignados" role="tab" data-toggle="tab" id="tap-asignados">MEDICAMENTOS INDICADOS</a></li>
				<li role="presentation"><a href="#t-aplicados" aria-controls="profile" role="tab" data-toggle="tab" id="tap-aplicados">MEDICAMENTOS APLICADOS</a></li>
				<li role="presentation"><a href="#t-aplicados-r" aria-controls="profile" role="tab" data-toggle="tab" id="tap-aplicados-r">MEDICAMENTOS APLICADOS REACCIONES</a></li>
			  </ul>

			  <!-- Tab panes -->
			  <div class="tab-content">
				<div role="tabpanel" class="tab-pane active" id="t-asignados">
				
					<table width="100%" height="100%" border="0" id="dataTableMedicamentos" class="table-condensed table-striped table-bordered table-hover" style="overflow: hidden;">
						<thead id="cabecera_tBusquedaMedicamentos" class="">
						  <tr class="bg-primary" style="font-size: 1.1em;">
							<th id="clickmeMdtos1"class="titulosTabs"align="center" nowrap width="1px">#</th>
							<th id="clickmeMdtos" class="titulosTabs" align="center" width="">FECHA/HORA</th>
							<th class="titulosTabs" align="center" width="" id="title_medicamento" nowrap>
								<button type="button" class="btn btn-info btn-xs" id="btn_add_medicamento">MEDICAMENTO <i class='fa fa-plus' aria-hidden='true'></i></button>
							</th>
							<th class="titulosTabs" align="center" width="" nowrap>CANTIDAD</th>
							<th class="titulosTabs" align="center" width="" nowrap>PERSONAL MÉDICO</th>
							<th class="titulosTabs" align="center" width="" nowrap>INDICACIÓN</th>
							<th class="titulosTabs" align="center" width="" nowrap>SUSPENDER</th>
							<th class="titulosTabs" align="center" width="" nowrap>APLICAR</th>
							<th class="titulosTabs" align="center" width="" nowrap>PRECIO</th>
							<th class="titulosTabs" align="center" width="" nowrap>ORIGEN</th>
						  </tr>
						</thead> <tbody> <tr> <td class="dataTables_empty">Cargando datos del servidor</td> </tr> </tbody> 
						<tfoot style="display:;">
							<tr>
								<th></th>
								<th><input type="text" class="form-control input-sm" placeholder="-FECHA-" style="width: 99%"/></th>
								<th><input type="text" class="form-control input-sm" placeholder="-MEDICAMENTO-" style="width: 99%"/></th>
								<th></th>
								<th><input type="text" class="form-control input-sm" placeholder="-PERSONAL MÉDICO-" style="width: 99%"/></th>
								<th></th>
								<th></th>
								<th></th>
								<th></th>
								<th><input type="text" class="form-control input-sm" placeholder="-ORIGEN-" style="width: 99%"/></th>
							</tr>
						</tfoot>
					</table>
					<div class="col-md-12">
						<div class="form-group col-md-2">
							<a href="#"type="button" class="btn btn-info " id="btn_printMI">IMPRIMIR</a>
						</div>
						<div class="form-group col-md-10">
							<select name="select-sucursal-u" id="select-sucursal-u" class="form-control form-control-sm" style="width: 50%"> </select>
						</div>
					</div>
				</div>
				<div role="tabpanel" class="tab-pane" id="t-aplicados">
					<div id="printt">
						<table width="100%" height="100%" border="0" id="dataTableMedicamentosA" class="table-condensed table-striped table-bordered table-hover" style="overflow: hidden;">
							<thead id="cabecera_tBusquedaMedicamentosA" class="">
							<tr class="bg-primary" style="font-size: 1.1em;">
								<th id="clickmeMdtosA"class="titulosTabs"align="center" nowrap width="1px">#</th>
								<th class="" align="center" width="">MEDICAMENTO</th>
								<th class="" align="center" width="" nowrap>PRESENTACIÓN</th>
								<th class="" align="center" width="" nowrap>INDICACIÓN</th>
								<th class="" align="center" width="" nowrap>APLICÓ</th>
								<th class="" align="center" width="" nowrap>FECHA/HORA</th>
								<th class="" align="center" width="" nowrap>PRECIO</th>
								<th class="" align="center" width="" nowrap>*</th>
								<th class="" align="center" width="" nowrap>ADICIONALES</th>
							</tr>
							</thead> <tbody id="conten" > <tr> <td class="dataTables_empty">Cargando datos del servidor</td> </tr> </tbody> 
							<tfoot>
								<tr>
									<th></th>
									<th><input type="text" class="form-control input-sm" placeholder="-MEDICAMENTO-" style="width: 99%"/></th>
									<th><input type="text" class="form-control input-sm" placeholder="-PRESENTACIÓN-" style="width: 99%"/></th>
									<th></th>
									<th><input type="text" class="form-control input-sm" placeholder="-APLICÓ-" style="width: 99%"/></th>
									<th><input type="text" class="form-control input-sm" placeholder="-FECHA/HORA-" style="width: 99%"/></th>
									<th><input type="hidden" class="sCalculo" /></th>
									<th><input type="hidden" class="" /></th>
									<th><input type="hidden" class="sCalculo" /></th>
								</tr>
							</tfoot>
						</table>
					</div>
					<a href="#"type="button" class="btn btn-info " id="btn_printMA">IMPRIMIR</a>
				</div>
				<!-- Medicamentos aplicados reacciones -->
				<div role="tabpanel" class="tab-pane" id="t-aplicados-r">
					<div id="printt1">
						<table width="100%" height="100%" border="0" id="dataTableMedicamentosAR" class="table-condensed table-striped table-bordered table-hover" style="overflow: hidden;">
							<thead id="cabecera_tBusquedaMedicamentosAR" class="">
							<tr class="bg-primary" style="font-size: 1.1em;">
								<th id="clickmeMdtosAR"class="titulosTabs"align="center" nowrap width="1px">#</th>
								<th class="" align="center" width="">MEDICAMENTO</th>
								<th class="" align="center" width="" nowrap>PRESENTACIÓN</th>
								<th class="" align="center" width="" nowrap>INDICACIÓN</th>
								<th class="" align="center" width="" nowrap>APLICÓ</th>
								<th class="" align="center" width="" nowrap>FECHA/HORA</th>
								<th class="" align="center" width="" nowrap>PRECIO</th>
								<th class="" align="center" width="" nowrap>*</th>
								<th class="" align="center" width="" nowrap>REACCIONES</th>
							</tr>
							</thead> <tbody id="conten" > <tr> <td class="dataTables_empty">Cargando datos del servidor</td> </tr> </tbody> 
							<tfoot>
								<tr>
									<th></th>
									<th><input type="text" class="form-control input-sm" placeholder="-MEDICAMENTO-" style="width: 99%"/></th>
									<th><input type="text" class="form-control input-sm" placeholder="-PRESENTACIÓN-" style="width: 99%"/></th>
									<th></th>
									<th><input type="text" class="form-control input-sm" placeholder="-APLICÓ-" style="width: 99%"/></th>
									<th><input type="text" class="form-control input-sm" placeholder="-FECHA/HORA-" style="width: 99%"/></th>
									<th><input type="hidden" class="sCalculo" /></th>
									<th><input type="hidden" class="" /></th>
									<th><input type="hidden" class="sCalculo" /></th>
								</tr>
							</tfoot>
						</table>
					</div>
					<a href="#"type="button" class="btn btn-info " id="btn_printMAR">IMPRIMIR</a>
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
