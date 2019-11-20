<form class="form-horizontal" style="height:100%;" name="formNuevoU" id="formNuevoU" target="_self" method="POST" data-toggle="validator">
<div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Configuración de mi cuenta</h4>
      </div>
      <div class="modal-body">
        <p class="text-primary mi_hide"><strong><i class="fa fa-info-circle  fa-lg" aria-hidden="true"></i> Hola <span class="miUsuarioNU"></span>, ésta es la primera vez que iniciarás sesión en el sistema, para ello es necesario que configures tu cuenta:</strong></p>
            <input name="usuarioN" id="usuarioN" type="hidden" value="">
            <table id="mi_tabla_rc" width="100%" height="100%" border="0" cellspacing="0" cellpadding="2" class="">
              <tr>
                <td>
                <table class="mi_hide" width="100%" border="0" cellspacing="0" cellpadding="5">
                  <tr>
                    <td align="left">
                        <div class="form-group">
                            <div class="col-sm-offset-1 col-sm-10">
                                <div class="input-group margin-bottom-sm">
                                  <span class="input-group-addon"><i class="fa fa-key fa-fw fa-lg"></i></span>
                                  <input name="contrasenaNU" id="contrasenaNU" type="password" class="form-control input-lg" data-minlength="4" maxlength="20" placeholder="Nueva contraseña" required data-error="La contraseña es obligatoria (de 4 a 20 caracteres)">
                                </div>
                                <div class="help-block with-errors"></div>
                            </div>
                          </div>
                    </td>
                  </tr>
                  <tr>
                    <td align="left">
                        <div class="form-group">
                            <div class="col-sm-offset-1 col-sm-10">
                                <div class="input-group margin-bottom-sm">
                                  <span class="input-group-addon"><i class="fa fa-repeat fa-fw fa-lg"></i></span>
                                  <input name="contrasenaNU1" id="contrasenaNU1" type="password" class="form-control input-lg" data-minlength="4" maxlength="20" placeholder="Confirmar contraseña" required data-error="Las contraseñas no coinciden" data-match="#contrasenaNU">
                                  <span class="input-group-addon"><i class="fa fa-key fa-fw fa-lg"></i></span>
                                </div>
                                <div class="help-block with-errors"></div>
                            </div>
                          </div>
                    </td>
                  </tr>
                  <tr>
                    <td align="left">
                        <div class="form-group">
                            <div class="col-sm-offset-1 col-sm-10">
                                <div class="input-group margin-bottom-sm">
                                  <span class="input-group-addon"><i class="fa fa-envelope fa-lg"></i></span>
                                  <input onKeyUp="conMinusculas(this);" name="emailNU" id="emailNU" type="email" class="form-control input-lg" maxlength="80" placeholder="Correo Electrónico" required data-error="Ingrese una dirección de correo electrónico válida">
                                </div>
                                <div class="help-block with-errors"></div>
                            </div>
                          </div>
                    </td>
                  </tr>
                  <tr>
                    <td align="left">
                        <div class="form-group">
                            <div class="col-sm-offset-1 col-sm-10">
                                <div class="input-group margin-bottom-sm">
                                  <span class="input-group-addon"><i class="fa fa-repeat fa-fw fa-lg"></i></span>
                                  <input onKeyUp="conMinusculas(this);" name="emailNU1" id="emailNU1" type="email" class="form-control input-lg" maxlength="80" placeholder="Confirmar correo electrónico" required data-error="Los emails no coinciden" data-match="#emailNU">
                                  <span class="input-group-addon"><i class="fa fa-envelope fa-fw fa-lg"></i></span>
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
                <div id="mi_alert_rp" class="alert alert-success alert-dismissible hidden" role="alert">
                <p><i class="fa fa-thumbs-up fa-lg"></i> <strong>Muy bien</strong> Ahora que se ha configurado la nueva contraseña se ha enviado un email de verificación a tu correo electrónico, ingresa a la bandeja de entrada del correo electrónico que has configurado en el sistema y dá click en el link que viene para validar tu cuenta, una vez validada la cuenta podrás iniciar sesión en el sistema.</p>
                <p><i class="fa fa-exclamation-circle fa-lg"></i> Si es necesario revisa la bandeja de correo no deseado</p>
                </div>
                </td> 
              </tr>
            </table>
      </div>
      <div class="modal-footer">
      	<div class="form-group">
        <div class="col-sm-offset-0 col-sm-12">
          <div class="checkbox">
            <button type="button" class="btn btn-default" data-dismiss="modal" id="btn_cancel_config_c">Cancelar</button>
        	<button type="button" class="btn btn-primary" id="btn_config_c"> Continuar</button>
          </div>
        </div>
      </div>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
  </form>