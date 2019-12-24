<div class="modal-dialog modal-lg" role="document" id="contenido_ficha_consulta">
    <div class="modal-content animated flipInY">
      <div class="modal-header">
        <button type="button" class="close hidden" data-dismiss="modal" aria-label="Close">
        	<span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title"><strong><span id="titulo_modal">CREAR UN NUEVO MEDICAMENTO COMERCIAL</span></strong></h4>
      </div>
      <div class="modal-body">

    <ul class="nav nav-tabs">
      <li role="presentation" class="active" id="t-generales">
      	<a href="#tGenerales" aria-controls="tGenerales" role="tab" data-toggle="tab">GENERALES</a>
      </li>
      <li role="presentation" class="hidden ocul" id="t-adicionales">
      	<a href="#tAdicionales" aria-controls="tAdicionales" role="tab" data-toggle="tab">ADICIONALES</a>
      </li>
    </ul>
    <!-- Tab panes -->
    <div class="tab-content">
        <div role="tabpanel" class="tab-pane active" id="tGenerales">
        	<div class="panel panel-success">
              <!-- Default panel contents-->
              <!--<div class="panel-heading"><p>Selecciona un medicamento de la lista de medicamentos genéricos</p></div>-->
              <div class="panel-body"> Selecciona un medicamento de la lista de medicamentos genéricos </div>
                <table width="100%" border="0" cellpadding="0" cellspacing="0" id="dataTableM" class="table table-hover table-striped dataTable table-condensed"> 
                <thead id="cabecera_tBusquedaM">
                  <tr role="row" class="bg-success">
                    <th id="clickmeM" style="vertical-align:middle;">MEDICAMENTO GENÉRICO</th>
                    <th style="vertical-align:middle;">DESCRIPCIÓN</th>
                    <th style="vertical-align:middle;">CANTIDAD</th>
                    <th style="vertical-align:middle;">GRUPO</th>
                    <th style="vertical-align:middle;">NIVEL</th>
                  </tr>
                </thead> <tbody> <tr> <td class="dataTables_empty">Cargando datos del servidor</td> </tr> </tbody> 
                    <tfoot>
                        <tr class="bg-success">
                            <th><input name="sgen" id="sgen" type="text" class="form-control input-sm" placeholder="Genérico"/></th>
                            <th><input name="sdes" id="sdes" type="text" class="form-control input-sm" placeholder="Descripción"/></th>
                            <th><input name="scan" id="scan" type="text" class="form-control input-sm" placeholder="Cantidad"/></th>
                            <th><input name="sgru" id="sgru" type="text" class="form-control input-sm" placeholder="Grupo"/></th>
                            <th><input name="sniv" id="sniv" type="text" class="form-control input-sm" placeholder="Nivel"/></th>
                        </tr>
                    </tfoot>
                </table>
            <!-- Table -->
            	<form class="form-horizontal ocul hidden" id="form-medicamento"> <input name="id_med_up" id="id_med_up" type="hidden" value="">
                  <div class="form-group" id="medicamento_base">
                    <div class="col-md-2 col-sm-2 col-xs-2 col-lg-2 text-primary" align="right">MEDICAMENTO BASE: </div>
                    <div class="col-md-10 col-sm-10 col-xs-10 col-lg-10" id="tex_base"></div>
                  </div>
                  <div class="form-group">
                    <div class="col-md-2 col-sm-2 col-xs-2 col-lg-2 text-primary" align="right">PRESENTACIÓN: </div>
                    <div class="col-md-10 col-sm-10 col-xs-10 col-lg-10" id="tex_presentacion"></div>
                  </div>
                  <div class="form-group">
                    <div class="col-md-2 col-sm-2 col-xs-2 col-lg-2 text-primary" align="right">VÍA DE ADMINISTRACIÓN: </div>
                    <div class="col-md-10 col-sm-10 col-xs-10 col-lg-10" id="tex_via"></div>
                  </div>
                  <div class="form-group">
                    <div class="col-md-2 col-sm-2 col-xs-2 col-lg-2 text-primary" align="right">* NOMBRE COMERCIAL: </div>
                    <div class="col-md-10 col-sm-10 col-xs-10 col-lg-10">
                    <input type="text" class="form-control input-sm" placeholder="Ingrese el nombre comercial del medicamento" id="nombre_c_m" name="nombre_c_m" required>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="col-md-2 col-sm-2 col-xs-2 col-lg-2 text-primary" align="right">* DOSIS: </div>
                    <div class="col-md-10 col-sm-10 col-xs-10 col-lg-10">
                    <textarea class="form-control" rows="3" style="resize:none;" id="tex_dosis" name="tex_dosis" required></textarea>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="col-md-2 col-sm-2 col-xs-2 col-lg-2 text-primary" align="right">* PRECIO PÚBLICO</div>
                    <div class="col-md-2 col-sm-2 col-xs-2 col-lg-2">
                    	<input type="text" class="form-control input-sm" placeholder="Ingrese el precio público" id="precio_p_m" name="precio_p_m" required>
                    </div>
                    <div class="col-md-2 col-sm-2 col-xs-2 col-lg-2 text-primary" align="right">* PRECIO HOSPITAL</div>
                    <div class="col-md-2 col-sm-2 col-xs-2 col-lg-2">
                    	<input type="text" class="form-control input-sm" placeholder="Ingrese el precio de hospital" id="precio_h_m" name="precio_h_m" required>
                    </div>
                    <div class="col-md-2 col-sm-2 col-xs-2 col-lg-2 text-primary" align="right">* PRECIO MEMBRESÍA</div>
                    <div class="col-md-2 col-sm-2 col-xs-2 col-lg-2">
                    	<input type="text" class="form-control input-sm" placeholder="Ingrese el precio de membresía" id="precio_m_m" name="precio_m_m" required>
                    </div>
                  </div>
                  <div class="form-group">
                  	<div class="col-md-2 col-sm-2 col-xs-2 col-lg-2 text-primary" align="right">* COSTO</div>
                    <div class="col-md-2 col-sm-2 col-xs-2 col-lg-2">
                    	<input type="text" class="form-control input-sm" placeholder="Ingrese el costo del medicamento" id="costo_m" name="costo_m" required>
                    </div>
                    <div class="col-md-2 col-sm-2 col-xs-2 col-lg-2 text-primary" align="right">CÓDIGO DE BARRAS: </div>
                    <div class="col-md-6 col-sm-6 col-xs-6 col-lg-6">
                    <input type="text" class="form-control input-sm" placeholder="Ingrese el código de barras" id="codigo_b_m" name="codigo_b_m">
                    </div>
                  </div>
                  <div class="form-group">
                  	<div class="col-md-2 col-sm-2 col-xs-2 col-lg-2 text-primary" align="right">* SUCURSAL</div>
                  	<div class="col-sm-10 col-xs-10 col-md-10 col-lg-10">
                         <select name='miSucursalNS' class="form-control input-sm" id='miSucursalNS' required></select>
                    </div>
                  </div>
                <br> 
                <input name="tamHcanvas" id="tamHcanvas" type="hidden" value="">
                <input name="id_mg" id="id_mg" type="hidden" value="">
                <input name="id_user_reg_m" id="id_user_reg_m" type="hidden" value="">
                </form>
            </div>
        </div>
        <div role="tabpanel" class="tab-pane" id="tAdicionales"><br>
			<table class="table table-condensed">
                <tr> <td class="text-primary" valign="top">GENERALIDADES</td><td id="tex_generalidades"></td> </tr>
                <tr> <td class="text-primary">INTERACCIONES</td><td id="tex_interacciones"></td> </tr>
                <tr> <td class="text-primary">EFECTOS ADVERSOS</td><td id="tex_adversos"></td> </tr>
                <tr> <td class="text-primary">CONTRAINDICACIONES</td><td id="tex_contrain"></td> </tr>
                <tr> <td class="text-primary">RIESGO DE EMBARAZO</td><td id="tex_cat_re"></td> </tr>
                <tr> <td></td> <td colspan="1" id="tex_re"></td> </tr>
            </table>
        </div>
    </div>
      
  </div>
  <div class="modal-footer">
    <div class="form-group">
    <div class="col-sm-offset-0 col-sm-12">
    	<button type='submit' class="btn btn-success btn-sm" id="guardarM" form="form-medicamento">Guardar</button> 
        <button type='button' class="btn btn-danger btn-sm" data-dismiss="modal">Cancelar</button>
    </div>
    </div>
  </div>
</div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->