<div class="modal-dialog modal-lg" role="document" id="contenido_ficha_consulta">
    <div class="modal-content animated fadeIn">
      <div class="modal-header">
        <button type="button" class="close hidden" data-dismiss="modal" aria-label="Close">
        	<span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title"><strong><span id="titulo_modal2"></span></strong></h4>
      </div>
      <div class="modal-body">
          <div style="margin-bottom: 15px;">
              <div class="row">
                  <div class="col-md-4">
                      <input type="text" id="filtro_referencia" class="form-control" placeholder="Filtrar por referencia">
                  </div>
                  <div class="col-md-4">
                      <input type="text" id="filtro_paciente" class="form-control" placeholder="Filtrar por paciente">
                  </div>
                  <div class="col-md-4">
                      <input type="text" id="filtro_sucursal" class="form-control" placeholder="Filtrar por sucursal">
                  </div>
              </div>
          </div>
          <table width="100%" height="100%" border="0" class="table-condensed table-striped table-bordered table-hover" style="overflow: hidden;"">
            <thead>
                <tr class="bg-primary" style="font-size: 1.1em;">
                    <th>#</th>
                    <th>REFERENCIA</th>
                    <th>PACIENTE</th>
                    <th>TOTAL</th>
                    <th>ABONADO</th>
                    <th>SALDO</th>
                    <th>SUCURSAL</th>
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
                    <th></th>
                    <th></th>
                </tr>
            </tfoot>
          </table>

          <div style="margin-top:30px;" class="hidden" id="aclaraciones2" name="aclaraciones2">
            <strong>Aclaraciones:</strong>
            <div style="border:1px solid #000; height:120px; margin-top:10px; width:100%;"></div>
          </div>
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