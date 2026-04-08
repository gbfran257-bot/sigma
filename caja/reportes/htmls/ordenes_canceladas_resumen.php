<div class="modal-dialog modal-lg" role="document" id="contenido_ficha_consulta">
    <div class="modal-content animated flipInY">
      <div class="modal-header">
        <button type="button" class="close hidden" data-dismiss="modal" aria-label="Close">
        	<span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title"><strong><span id="titulo_modal2"></span></strong></h4>
      </div>
      <div class="modal-body">
          <table width="100%" height="100%" border="0" class="table-condensed table-striped table-bordered table-hover" style="overflow: hidden;"">
            <thead>
                <tr class="bg-primary" style="font-size: 1.1em;">
                    <th>#</th>
                    <th>REFERENCIA</th>
                    <th>PACIENTE</th>
                    <th>FECHA CANCELADA</th>
                    <th>MOTIVO</th>
                </tr>
            </thead>
            <tbody id="tbodyContentMS">
                
            </tbody>
            <tfoot>
                <tr>
                    <th></th>
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
            <button class="btn btn-primary" onclick="imprimirModalCanceladas()">Imprimir</button>
            <button type='button' class="btn btn-warning btn-sm" data-dismiss="modal">Salir</button>
        </div>
        </div>
      </div>
    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->