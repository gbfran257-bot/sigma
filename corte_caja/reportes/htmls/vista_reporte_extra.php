<div class="modal-dialog modal-lg" role="document" id="contenido_ficha_consulta">
    <div class="modal-content animated flipInY">
      <div class="modal-header">
        <button type="button" class="close hidden" data-dismiss="modal" aria-label="Close">
        	<span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title"><strong><span id="titulo_modal"></span></strong></h4>
      </div>
      <div class="modal-body">

  <!-- INICIO -->
  <input name="idTablaEliminados" id="idTablaEliminados" type="hidden" value="">
  <div id="div_tabla_pacientes" class="table-responsive" style="border:1px none red; vertical-align:top; margin-top:-9px;">
    <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0" id="dataTableEliminados" class="table table-hover table-striped dataTables-example dataTable table-condensed" role="grid">
    <thead id="cabecera_tBusquedaPrincipal">
      <tr role="row" class="bg-primary">
        <th id="clickme" style="vertical-align:middle; width:15%;">
            FECHA
        </th>
        <th  data-priority="1" style="vertical-align:middle; width:20%;">
            FOLIO
        </th>
        <th data-priority="3" style="vertical-align:middle; width:15%;">
            RECEPCIONISTA
        </th>
        <th  data-priority="2" style="vertical-align:middle; width:20%;">
            FORMA DE PAGO
        </th>
        <th data-priority="4" style="vertical-align:middle; width:15%;">
            AREA ORIGEN DEL INGRESO
        </th>
        <th data-priority="5" style="vertical-align:middle; ">
            IMPORTE
        </th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td class="dataTables_empty">Cargando datos del servidor</td>
    </tr>
    </tbody>
        <tfoot>
            <tr class="bg-primary">
                <th></th>
                <th><input type="text" class="form-control input-sm hidden" placeholder=""/></th>
                <th><input type="text" class="form-control input-sm hidden" placeholder=""/></th>
                <th></th>
                <th></th>
                <th></th>
            </tr>
        </tfoot>
    </table>
    <!-- fechas -->

    <!-- fin fechas -->
    </div>
    <div id="auxiliar" class="hidden"></div> <div id="auxiliar1" class="hidden"></div>
  <!-- FIN -->

	</div>

      <div class="modal-footer">
      	<div class="form-group">
        <div class="col-sm-offset-0 col-sm-12">
            <button type='submit' id="btn_update_unidad" class="btn btn-success btn-sm hidden" form="form-ficha_modifiaciones">Actualizar</button>
            <button type='submit' id="btn_save_unidad" class="btn btn-success btn-sm hidden" form="form-ficha_modifiaciones">Guardar</button>
            <button type='button' class="btn btn-warning btn-sm" data-dismiss="modal">Cerrar</button>
        </div>
        </div>
      </div>
    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->