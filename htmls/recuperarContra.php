<div class="modal-dialog" role="document">
    <div class="modal-content">
    	<form class="form-horizontal" style="height:100%;" name="formRecuperaC" id="formRecuperaC" target="_self" method="POST" data-toggle="validator">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Recuperar Contraseña</h4>
      </div>
      <div class="modal-body">
        <p class="text-primary mi_hide"><strong><i class="fa fa-info-circle fa-lg" aria-hidden="true"></i> Para poder recuperar tu contraseña es necesario que indiques tu correo electrónico registrado en éste sistema y el nombre de usuario con el que inicias sesión.</strong></p>
            <input name="usuarioN" id="usuarioN" type="hidden" value="">
            <table id="mi_tabla_rc" width="100%" height="100%" border="0" cellspacing="0" cellpadding="2" class="">
              <tr>
                <td>
                <table class="mi_hide" width="100%" border="0" cellspacing="0" cellpadding="5" style="color:;">
                  <tr>
                    <td align="left">
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-9">
                                <div class="input-group margin-bottom-sm">
                                  <span class="input-group-addon"><i class="fa fa-user-md fa-fw fa-lg"></i></span>
                                  <input onKeyUp="conMayusculas(this); nick(this.value, this.name);" name="usuarioRC" id="usuarioRC" type="text" class="form-control input-lg" data-minlength="4" onKeyUp="conMayusculas(this); nick(this.value, this.name);" maxlength="20" placeholder="Usuario" required data-error="El nombre de usuario es obligatorio (mínimo 4 caracteres)">
                                </div>
                                <div class="help-block with-errors"></div>
                            </div>
                          </div>
                    </td>
                  </tr>
                  <tr>
                    <td align="left">
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-9">
                                <div class="input-group margin-bottom-sm">
                                  <span class="input-group-addon"><i class="fa fa-envelope fa-fw fa-lg"></i></span>
                                  <input onKeyUp="conMinusculas(this);" name="emailRC" id="emailRC" type="email" class="form-control input-lg" onKeyUp="conMayusculas(this); nick(this.value, this.name);" maxlength="80" placeholder="Correo Electrónico" required data-error="Ingrese una dirección de correo electrónico válida">
                                </div>
                                <div class="help-block with-errors"></div>
                            </div>
                          </div>
                    </td>
                  </tr>
                </table>
                </td>
              </tr>
              <tr id="ucDesconocidos"> 
              	<td id="miTextoUC" align="justify" valign="top">
                <div id="mi_alert_rp" class="alert alert-danger alert-dismissible" role="alert"></div>
                </td> 
              </tr>
            </table>
      </div>
      <div class="modal-footer">
      	<div class="form-group">
        <div class="col-sm-offset-0 col-sm-12">
          <div class="checkbox">
            <button type="button" class="btn btn-default" data-dismiss="modal" id="btn_cancel_recupera_psw">Cancelar</button>
        	<button type="button" class="btn btn-primary" id="btn_recupera_psw"> Continuar</button>
          </div>
        </div>
      </div>
      </div>
      </form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->