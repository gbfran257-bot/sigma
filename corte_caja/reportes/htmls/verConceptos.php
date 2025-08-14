<div class="modal-dialog modal-lg modal-xl-custom" role="document" id="contenido_ficha_consulta">
    <div class="modal-content animated flipInY">
      <div class="modal-header">
        <button type="button" class="close hidden" data-dismiss="modal" aria-label="Close">
        	<span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title"><strong><span id="titulo_modal_medico"></span></strong></h4>
      </div>
      <div class="modal-body">

        <div id="div_tabla_pacientes" class="table-responsive" style="border:1px none red; vertical-align:top; margin-top:-9px;">
            <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0" id="dataTablePrincipal2" class="table table-hover table-striped dataTables-example dataTable table-condensed" role="grid"> 
            <thead id="cabecera_tBusquedaPrincipal">
                <tr role="row" class="bg-primary">
                <th id="clickme" style="vertical-align:middle;">#</th>
                <th style="vertical-align:middle;">
                    REFERENCIA
                </th>
                <th style="vertical-align:middle;">PACIENTE</th>
                <th style="vertical-align:middle;">CONCEPTO</th>
                <th style="vertical-align:middle;">DEPARTAMENTO</th>
                <th style="vertical-align:middle;">PRECIO CONCEPTO</th>
                <th style="vertical-align:middle;">PAGO DEP.</th>
                <th style="vertical-align:middle;">DESCUENTO</th>
                <th style="vertical-align:middle;">EXTRA</th>
                </tr>
            </thead> <tbody> <tr> <td class="dataTables_empty">Cargando datos del servidor</td> </tr> </tbody> 
            <tfoot>
                <tr class="bg-primary">
                    <th></th>
                    <th><input type="text" class="form-control input-sm" placeholder="REFERENCIA"/></th>
                    <th><input type="text" class="form-control input-sm" placeholder="PACIENTE"/></th>
                    <th></th>
                    <th><input type="text" class="form-control input-sm" placeholder="DEPARTAMENTO"/></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                </tr>
            </tfoot>
            </table>
        </div>
        <div id="auxiliar" class="hidden"></div> <div id="auxiliar1" class="hidden"></div>

	</div>

      <div class="modal-footer">
      	<div class="form-group">
        <div class="col-sm-offset-0 col-sm-12">
            <!-- <button type='submit' id="btn_update_colonia" class="btn btn-success btn-sm hidden" form="form-est">Actualizar</button>
            <button type='submit' id="btn_save_colonia" class="btn btn-success btn-sm" form="form-est">Guardar</button> -->
            <button type='button' class="btn btn-warning btn-sm" data-dismiss="modal">Cerrar</button>
        </div>
        </div>
      </div>
    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->

<style>
    .modal-xl-custom {
        width: 65% !important;
        max-width: 65% !important;
    }
</style>
