<div class="modal-dialog modal-lg" role="document" id="contenido_ficha_consulta">
    <div class="modal-content animated flipInY">
      <div class="modal-header">
        <button type="button" class="close hidden" data-dismiss="modal" aria-label="Close">
        	<span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title"><strong><span id="titulo_modal"></span></strong></h4>
      </div>
      <div class="modal-body">
        <div class="contairner">
            <div class="row">
                <h3 class="text-center"># REF DE VENTA</h3>
                <h3 class="text-center" id="num_ref_t"></h3>
                <table class="table">
                  <thead class="bg-primary">
                    <tr>
                      <th scope="col">#</th>
                      <th scope="col">CONCEPTO</th>
                      <th scope="col">LABORATORIO</th>
                      <th scope="col">IMAGEN</th>
                      <th scope="col">FARMACIA</th>
                      <th scope="col">ASOCIACION MEDICA</th>
                      <th scope="col">ING CLIENTE</th>
                    </tr>
                  </thead>
                    <tbody id="con_table"></tbody>
                </table>
                <hr>
                <label class="bg-primary">TOTAL A PAGAR SUCURSAL: <span id="total_ref"></span></label>

            </div>
        </div>
        
	</div>
      
      <div class="modal-footer">
      	<div class="form-group">
        <div class="col-sm-offset-0 col-sm-12">
            <button type='button' class="btn btn-warning btn-sm" data-dismiss="modal">Cancelar</button>     
        </div>
        </div>
      </div>
    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->