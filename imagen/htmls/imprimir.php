<div class="modal-dialog modal-lg" role="document" id="contenido_ficha_consulta">
    <div class="modal-content animated flipInY">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        	<span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title"><strong><span id="titulo_modal">IMPRESIÓN DE LA INTERPRETACIÓN</span></strong></h4>
      </div>
      
      <!-- Pestañas: INTERPRETACIÓN / INTERPRETACIÓN EN IMAGEN (la barra se oculta al imprimir solo las imágenes) -->
      <ul class="nav nav-tabs" id="tabs_imp_nav" style="padding:6px 15px 0 15px;">
        <li role="presentation" class="active"><a href="#impPaneInter" aria-controls="impPaneInter" role="tab" data-toggle="tab">INTERPRETACIÓN</a></li>
        <li role="presentation"><a href="#impPaneImg" aria-controls="impPaneImg" role="tab" data-toggle="tab" id="st-imp-img">INTERPRETACIÓN EN IMAGEN</a></li>
      </ul>
      <div class="tab-content">
        <div role="tabpanel" class="tab-pane active" id="impPaneInter">
          <div class="modal-body" id="impresion_inter"></div>
        </div>
        <div role="tabpanel" class="tab-pane" id="impPaneImg">
          <div class="modal-body" id="impresion_inter_img"></div>
        </div>
      </div>
      
      <div class="modal-footer">
      	<div class="form-group">
        <div class="col-sm-offset-0 col-sm-12">
			<button type='button' class="btn btn-info btn-sm" id="btn_compartir_i"><i class="fa fa-whatsapp" aria-hidden="true"></i> COMPARTIR</button>
			<button type='button' class="btn btn-primary btn-sm" id="btn_imprimir_i">IMPRIMIR</button>
            <button type='button' class="btn btn-danger btn-sm" data-dismiss="modal">CERRAR</button>   
        </div>
        </div>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->