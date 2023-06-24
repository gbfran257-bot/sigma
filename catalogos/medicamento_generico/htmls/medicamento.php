<div class="modal-dialog modal-lg" role="document" id="contenido_ficha_consulta">
    <div class="modal-content animated flipInY">
      <div class="modal-header">
        <button type="button" class="close hidden" data-dismiss="modal" aria-label="Close">
        	<span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title"><strong><span id="titulo_modal"></span></strong></h4>
      </div>
      <div class="modal-body">
        <form action=""id="med_generico">
            <div class="col-md-12">
              <div class="col-md-12">
                <div class="form-group col-md-3">
                  <label class="control-label" for="inputWarning1">*Nombre generico </label>
                  <input type="text" class="form-control" style="margin-top:10px;" name="nombre_generico_m" id="nombre_generico_m" required>
                </div>
                <div class="form-group col-md-3">
                  <label class="control-label" for="via_administracion_m">*Via administración <button type='button' class='btn btn-sm btn-primary' onClick='new_via()'><i class='fa fa-plus'></i></button> </label>
                  <!-- <p style="height:0.5px;"></p> -->
                  <select name="via_administracion_m" id="via_administracion_m" class="form-control" style="margin-top:10px;" required></select>
                </div>
                <div class="form-group col-md-3">
                  <label class="control-label" for="desc_m" >*Descripción </label>
                  <input type="text" class="form-control" style="margin-top:10px;" name="desc_m" id="desc_m" required>
                </div>
                <div class="form-group col-md-3">
                  <label class="control-label" for="inputWarning1">*Presentación </label>
                  <input type="text" class="form-control" style="margin-top:10px;" name="present_m" id="present_m" required>
                </div>
                
                
                
                
              </div>
              <div class="col-md-12">
                <div class="form-group col-md-3">
                  <label class="control-label" for="inputSuccess1" >Clave del medicamento</label>
                  <input type="text" class="form-control" style="margin-top:10px;" name="clv_m" id="clv_m">
                </div>
                <div class="form-group col-md-3">
                  <label class="control-label" for="inputSuccess1" >Cantidad</label>
                  <input type="text" class="form-control" style="margin-top:10px;" name="cant_m" id="cant_m">
                </div>
                <div class="form-group col-md-3">
                  <label class="control-label" for="Rembarazo_m" >R.Embarazo </label>
                  <select name="Rembarazo_m" id="Rembarazo_m" class="form-control" style="margin-top:10px;">
                    <option value="A">A</option>
                    <option value="B">B</option>
                    <option value="C">C</option>
                    <option value="D">D</option>
                    <option value="X">X</option>
                  </select>
                </div>
                <div class="form-group col-md-3">
                  <label class="control-label" for="nivel_m" >Nivel del medicamento</label>
                  <input type="text" class="form-control" style="margin-top:10px;" name="nivel_m" id="nivel_m">
                </div>
              </div>
              <div class="col-md-3">
                
              </div>
              <div class="col-md-12">
                <div class="form-group col-md-6">
                  <label class="control-label" for="grupoMedico_m">Grupo médico</label>
                  <input type="text" class="form-control" style="margin-top:10px;" name="grupoMedico_m" id="grupoMedico_m">
                </div>
                <div class="form-group col-md-6">
                  <label class="control-label" for="contenido_m">Contenido </label>
                  <input type="text" class="form-control" style="margin-top:10px;" name="contenido_m" id="contenido_m">
                </div>
              </div>
            </div>
            <div class="col-md-12">
              <div class="col-md-4">
                <div class="form-group">
                  <label class="control-label" for="inputWarning1">Generalidades</label>
                  <textarea name="generalidades_m" rows="2" class="form-control" cols="100" id="generalidades_m" ></textarea>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label class="control-label" for="inputError1" >Efectos adversos  </label>
                  <textarea name="efectos_m" rows="2" class="form-control" cols="100" id="efectos_m"></textarea>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label class="control-label" for="inputError1" >Contraindicaciones Precauciones  </label>
                  <textarea name="contradicciones_m" id="contradicciones_m" rows="2" class="form-control" cols="100" ></textarea>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label class="control-label" for="inputError1" >Interacciones medicas  </label>
                  <textarea name="interacciones_m" id="interacciones_m" rows="2" class="form-control" cols="100" ></textarea>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label class="control-label" for="inputError1" >Indicaciones medicas  </label>
                  <textarea name="indicaciones_m" id="indicaciones_m" rows="2" class="form-control" cols="100" ></textarea>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label class="control-label" for="inputError1" >via de Administración dosís</label>
                  <textarea name="via_admin_dosis_m" id="via_admin_dosis_m" rows="2" class="form-control" cols="100"></textarea>
                </div>
              </div>
              <div class="col-md-12">
                <div class="form-group">
                  <label class="control-label" for="inputError1" >Presentaciones</label>
                  <textarea name="presentaciones_m" id="presentaciones_m" rows="1" class="form-control" cols="100"></textarea>
                </div>
              </div>
            </div>
          </form>
	    </div>
      <div class="modal-footer">
      	<div class="form-group">
        <div class="col-sm-offset-0 col-sm-12">
            <button type='submit' id="btn_update_carrera" class="btn btn-success btn-sm hidden" form="med_generico">Actualizar</button>
            <button type='submit' id="btn_save_mg" class="btn btn-success btn-sm" form="med_generico">Guardar</button>
            <button type='button' class="btn btn-warning btn-sm" data-dismiss="modal">Cancelar</button>
        </div>
        </div>
      </div>
    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
