<div class="modal-dialog modal-lg" role="document" id="contenido_ficha_consulta">
    <div class="modal-content animated flipInY">
      <div class="modal-header">
        <button type="button" class="close hidden" data-dismiss="modal" aria-label="Close">
        	<span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title"><strong><span id="titulo_modal"></span></strong></h4>
      </div>
      <div class="modal-body">

        <table width="100%" cellspacing="0" id="dataTableUsuariosQx" height="100%" border="0" cellpadding="0" class="table table-striped table-hover table-bordered table-responsive">
            <thead id="my_head">
            <tr class="bg-info">
                <th align="center" id="clickmeA" style="vertical-align: middle; width: 100px;">ID</th>
                <th align="center">LOTE</th>
                <th align="center">EXISTENCIA ACTUAL</th>
                <th align="center">EXISTENCIA NUEVA</th>
            </tr>
            </thead>
            <tbody align="left">
                <tr>
                    <td class="dataTables_empty">Cargando datos del servidor</td>
                </tr>
            </tbody>
            <tfoot align="center">
                <tr>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                </tr>
            </tfoot>
        </table>
    

	</div>

      <div class="modal-footer">
      	<div class="form-group">
        <div class="col-sm-offset-0 col-sm-12">
            <button type='submit' id="btn_agrupar" class="btn btn-success btn-sm" form="form-est">Agrupar</button>
            <button type='button' class="btn btn-warning btn-sm" data-dismiss="modal">Cancelar</button>
        </div>
        </div>
      </div>
    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
