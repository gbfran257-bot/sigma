<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

include_once '../../recursos/session.php';
include_once '../../Connections/database.php';
include_once '../../recursos/utilities.php';

$id_del_user = $_SESSION['id'];
?>

<div class="modal-dialog modal-lg" role="document">
<div class="modal-content">
  <div class="modal-header"> <h4 class="modal-title text-dark" id="registroModalLabel">FICHA DE DATOS DEL USUARIO</h4> </div>
  <div class="modal-body" id="body_modal_reg">
<form class="small" method="post" name="form-registro" id="form-registro" data-toggle="validator" role="form">
    <input name="idUsuarioN" type="hidden" id="idUsuarioN"> <input name="temporal_s" type="hidden" id="temporal_s">
    <input name="p_latitud_s" type="hidden" id="p_latitud_s"> <input name="p_longitud_s" type="hidden" id="p_longitud_s">
    <input name="nuevo_o_viejo_u" type="hidden" id="nuevo_o_viejo_u" value="x">
    <input name="idUsuarioP" id="idUsuarioP" class="idUsuarioP" type="hidden" value="">
	<ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item active no_document no_nota no_receta no_forma_i" id="tab_mi_grales">
            <a class="nav-link" id="generales-tab" data-toggle="tab" href="#t_generales" role="tab" aria-controls="generales" aria-expanded="true">PERSONALES</a>
        </li>
        <li class="nav-item no_document no_nota no_receta no_forma_i" id="tab_mi_dir">
            <a class="nav-link" id="direccion-tab" data-toggle="tab" href="#t_direccion" role="tab" aria-controls="direccion">DIRECCIÓN</a>
        </li>
        <li class="nav-item no_document no_nota no_receta no_forma_i" id="tab_mi_con">
            <a class="nav-link" id="contacto-tab" data-toggle="tab" href="#t_contacto" role="tab" aria-controls="contacto">CONTACTO</a>
        </li>
        <li class="nav-item no_document no_nota no_receta no_forma_i" id="tab_mi_hor">
            <a class="nav-link" id="horario-tab" data-toggle="tab" href="#t_horario" role="tab" aria-controls="horario">HORARIO</a>
        </li>
        <li class="nav-item no_nota no_receta no_forma_i" id="tab_mi_arc">
            <a class="nav-link" id="archivos-tab" data-toggle="tab" href="#t_archivos" role="tab" aria-controls="archivos">ARCHIVOS</a>
        </li>
        <li class="nav-item hidden" id="tab_mi_fir">
            <a class="nav-link" id="firmas-tab" data-toggle="tab" href="#t_firmas" role="tab" aria-controls="firmas">FIRMAS</a>
        </li>
        <li class="nav-item hidden" id="tab_mi_fot">
            <a class="nav-link" id="fotos-tab" data-toggle="tab" href="#t_fotos" role="tab" aria-controls="fotos">FOTOS</a>
        </li>
        <li class="dropdown no_document no_nota no_receta no_forma_i">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">CONFIGURACIÓN <span class="caret"></span></a>
            <ul class="dropdown-menu" style="z-index:10000">
              <li class="nav-item" id="tab_mi_esc">
                <a class="nav-link" id="escolaridad-tab" data-toggle="tab" href="#t_escolaridad" role="tab" aria-controls="escolaridad">ESCOLARIDAD</a>
              </li>
           	  <li class="nav-item" id="tab_mi_not">
                <a class="nav-link" id="notas-tab" data-toggle="tab" href="#t_notas" role="tab" aria-controls="notas">NOTAS MÉDICAS</a>
              </li>
              <li class="nav-item" id="tab_mi_rec">
                <a class="nav-link" id="recetas-tab" data-toggle="tab" href="#t_recetas" role="tab" aria-controls="recetas">RECETAS MÉDICAS</a>
              </li>
			  <li class="nav-item" id="tab_mi_format_im">
                <a class="nav-link" id="formati-tab" data-toggle="tab" href="#t_format_i" role="tab" aria-controls="notas">FORMATOS ESTUDIOS DE IMAGEN</a>
              </li>
              <li class="nav-item" id="tab_mi_conc">
                  <a class="nav-link" id="conceptos-tab" data-toggle="tab" href="#t_conceptos" role="tab" aria-controls="conceptos">CONCEPTOS</a>
              </li>
              <?php if($id_del_user==$_GET['id_uu']){?>
              <li class="nav-item" id="tab_mi_cont">
                  <a class="nav-link" id="contrasena-tab" data-toggle="tab" href="#t_contra" role="tab" aria-controls="contrasena">CONTRASEÑA</a>
              </li>
              <?php }else{ ?> <?php } ?>
            </ul>
        </li>
        <li class="dropdown no_document no_nota no_receta no_forma_i" id="tab-seguridad">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">SEGURIDAD <span class="caret"></span></a>
            <ul class="dropdown-menu" style="z-index:10000">
           	  <li class="nav-item" id="tab_mi_suc">
                <a class="nav-link" id="sucur-tab" data-toggle="tab" href="#t_sucur" role="tab" aria-controls="sucur">SUCURSALES</a>
              </li>
              <li class="nav-item" id="tab_per">
            	<a class="nav-link" id="permisos-tab" data-toggle="tab" href="#t_permisos" role="tab" aria-controls="permisos">PERMISOS</a>
              </li>
            </ul>
        </li>
        <li class="nav-item si_nota no_receta no_forma_i hidden" id="tab_mi_nota">
            <a class="nav-link" id="mi_nota-tab" data-toggle="tab" href="#t_mi_nota" role="tab" aria-controls="mi_nota">NOTA MÉDICA</a>
        </li>
        <li class="nav-item si_receta no_nota no_forma_i hidden" id="tab_mi_receta">
            <a class="nav-link" id="mi_receta-tab" data-toggle="tab" href="#t_mi_receta" role="tab" aria-controls="mi_receta">RECETA MÉDICA</a>
        </li>
		<li class="nav-item si_forma_i no_nota no_receta hidden" id="tab_mi_format_i">
            <a class="nav-link" id="mi_format_i-tab" data-toggle="tab" href="#t_mi_format_i" role="tab" aria-controls="mi_format_i">FORMATO DE IMAGEN</a>
        </li>
    </ul>
    <div class="tab-content" id="myTabContent">
    	<div class="tab-pane active tap-pane-primary" id="t_generales" role="tabpanel" aria-labelledby="generales-tab"><br>
        	<div class="row">
                <div class="form-group col-md-4 col-sm-4 text-primary">
                	<label for="nombreP" class="col-form-label">* NOMBRE(S)</label>
                    <input name="nombreP" id="nombreP" type="text" class="form-control form-control-sm" required placeholder="Nombre del usuario">
                	<div class="help-block with-errors"></div>
                </div>
                <div class="form-group col-md-4 col-sm-4 text-primary">
                	<label for="apaternoP" class="col-form-label">* APELLIDO PATERNO</label>
                    <input name="apaternoP" id="apaternoP" type="text" class="form-control form-control-sm" required placeholder="Apellido paterno">
                	<div class="help-block with-errors"></div>
                </div>
                <div class="form-group col-md-4 col-sm-4 text-primary">
                	<label for="amaternoP" class="col-form-label">APELLIDO MATERNO</label>
                    <input name="amaternoP" id="amaternoP" type="text" class="form-control form-control-sm" placeholder="Apellido materno">
                	<div class="help-block with-errors"></div>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-2 col-sm-2 text-primary">
                	<label for="sexoP" class="col-form-label">* SEXO</label>
                    <select name="sexoP" id="sexoP" class="form-control form-control-sm" required> </select>
                  	<div class="help-block with-errors"></div>
                </div>
                <div class="form-group col-md-4 col-sm-4 text-primary">
                	<label for="nacionalidadP" class="col-form-label">* NACIONALIDAD</label>
                    <input name="nacionalidadP" id="nacionalidadP" type="text" class="form-control form-control-sm" required placeholder="Nacionalidad" value="MEXICANO">
                	<div class="help-block with-errors"></div>
                </div>
                <div class="form-group col-md-3 col-sm-3 text-primary">
                	<label for="fnacP" class="col-form-label">* FECHA DE NACIMIENTO</label>
                    <div class="input-group date" data-provide="datepicker" id="fecha_nacimiento_p1">
                       <input name="fnacP" id="fnacP" type="text" class="form-control form-control-sm datepi" required placeholder="DD/MM/AAAA">
                       <div class="input-group-addon"> <i class="fa fa-calendar" aria-hidden="true"></i> </div>
                    </div>
                	<div class="help-block with-errors"></div>
                </div>
                <div class="form-group col-md-3 col-sm-3 text-primary">
                	<label for="telmovilP" class="col-form-label">TELÉFONO CELULAR</label>
                    <input name="telmovilP" id="telmovilP" type="text" class="form-control form-control-sm" placeholder="Teléfono móvil" data-mask="(999) 999-9999" data-error="Ingresar un número válido.">
                	<div class="help-block with-errors"></div>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-3 col-sm-3 text-primary">
                	<label for="departamentoU" class="col-form-label">* ÁREA DE TRABAJO</label>
                    <select name="departamentoU" id="departamentoU" class="form-control form-control-sm" required> </select>
                	<div class="help-block with-errors"></div>
                </div>
                <div class="form-group col-md-4 col-sm-4 text-primary">
                	<label for="puestoU" class="col-form-label">* FUNCIÓN REAL</label>
                    <select name="puestoU" id="puestoU" class="form-control form-control-sm" required></select>
                	<div class="help-block with-errors"></div>
                </div>
                <div class="form-group col-md-5 col-sm-5 text-primary">
                	<label for="sucursalP" class="col-form-label">* SUCURSAL</label>
                    <select name="sucursalP" id="sucursalP" class="form-control form-control-sm" required> </select>
                  	<div class="help-block with-errors"></div>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-3 col-sm-3 text-primary">
                	<label for="tipoUsuario" class="col-form-label">* <span title="El tipo de acceso que tendrá el usuario en el sistema">TIPO DE USUARIO</span></label>
                    <select name="tipoUsuario" id="tipoUsuario" class="form-control form-control-sm" required> </select>
                  	<div class="help-block with-errors"></div>
                </div>
                <div class="form-group col-md-3 col-sm-3 text-primary">
                	<label for="username" class="col-form-label">* <span title="El nombre de usuario que se utilizará para firmarse y entrar al sistema. Por defaul al crear un usuario su contraseña será la misma que el nommbre de usuario.">NOMBRE DE USUARIO</span></label>                    
                    <input name="username" id="username" type="text" class="form-control form-control-sm" required placeholder="Nombre de usuario" maxlength="20" data-remote="usuarios/files-serverside/disponible_username.php" data-remote-error="Este nombre de usuario ya está en uso." data-minlength="4" data-minlength-error="El nombre de usuario debe ser desde 4 hasta 20 digitos" onKeyUp="conMayusculas(this); nick(this.value, this.name);">
                	<div class="help-block with-errors"></div>
                </div>
                <div class="form-group col-md-3 col-sm-3 text-primary">
                	<label for="tipo_acceso" class="col-form-label">* TIPO DE ACCESO</label>
                    <select name="tipo_acceso" id="tipo_acceso" class="form-control form-control-sm" required>
                    	<option value="0">SIMPLE</option>
                        <option value="2" selected>SUCURSAL</option>
                        <option value="1">MULTISUCURSAL</option>
                    </select>
                	<div class="help-block with-errors"></div>
                </div>
                <div class="form-group col-md-3 col-sm-3 text-primary">
                	<label for="estatusU" class="col-form-label">ESTATUS LABORAL</label>
                    <select name="estatusU" id="estatusU" class="form-control form-control-sm"> </select>
                	<div class="help-block with-errors"></div>
                </div>
            </div>
            <div class="row">
            	<div class="form-group col-md-4 col-sm-4 text-primary">
                	<label for="rfcP" class="col-form-label">RFC</label>
                    <input name="rfcP" id="rfcP" type="text" class="form-control form-control-sm" placeholder="RFC" maxlength="13" data-mask="aaaa999999***">
                	<div class="help-block with-errors"></div>
                </div>
                <div class="form-group col-md-4 col-sm-4 text-primary">
                	<label for="curpP" class="col-form-label">CURP</label>
                    <input name="curpP" id="curpP" type="text" class="form-control form-control-sm" placeholder="CURP" maxlength="18"  data-mask="aaaa999999wwwwwwww">
                	<div class="help-block with-errors"></div>
                </div>
                <div class="form-group col-md-4 col-sm-4 text-primary">
                	<label for="tsanguineoP" class="col-form-label">TIPO SANGUÍNEO</label>
                    <select name="tsanguineoP" id="tsanguineoP" class="form-control form-control-sm"> </select>
                  	<div class="help-block with-errors"></div>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-12 col-sm-12 text-primary">
                	<label for="notasP" class="col-form-label">NOTAS</label>
                    <textarea name="notasP" id="notasP" cols="" rows="1" style="resize:none;" class="form-control form-control-sm" placeholder="Observaciones"></textarea>
                	<div class="help-block with-errors"></div>
                </div>
            </div>
        </div>
        <div class="tab-pane tap-pane-primary" id="t_direccion" role="tabpanel" aria-labelledby="direccion-tab"><br>
        	<div class="row">
            	<div class="form-group col-md-6 col-sm-6 text-primary">
                	<label for="estadoP" class="col-form-label">ESTADO</label>
                    <select name="estadoP" id="estadoP" class="form-control form-control-sm mi_dir"></select>
                	<div class="help-block with-errors"></div>
                </div>
                <div class="form-group col-md-6 col-sm-6 text-primary">
                	<label for="municipioP" class="col-form-label">MUNICIPIO</label>
                    <select name="municipioP" id="municipioP" class="form-control form-control-sm mi_dir"></select>
                  	<div class="help-block with-errors"></div>
                </div>
            </div>
            <div class="row">
            	<div class="form-group col-md-5 col-sm-5 text-primary">
                	<label for="coloniaP" class="col-form-label">COLONIA</label>
                    <select name="coloniaP" id="coloniaP" class="form-control form-control-sm mi_dir"></select>
                	<div class="help-block with-errors"></div>
                </div>
                <div class="form-group col-md-5 col-sm-5 text-primary">
                	<label for="calleP" class="col-form-label">CALLE Y NÚMERO</label>
                    <input name="calleP" id="calleP" type="text" class="form-control form-control-sm mi_dir" placeholder="Calle y número">
                  	<div class="help-block with-errors"></div>
                </div>
                <div class="form-group col-md-2 col-sm-2 text-primary">
                	<label for="cpP" class="col-form-label">C.P.</label>
                    <select name="cpP" id="cpP" class="form-control form-control-sm"></select>
                  	<div class="help-block with-errors"></div>
                </div>
            </div>
            <table width="100%" height="" border="0" cellspacing="0" cellpadding="0" class="table-condensed">
              <tr align="center">
                <td nowrap width="50%">LATITUD <span id="p_latitud"></span></td>
                <td nowrap width="50%">LONGITUD <span id="p_longitud"></span></td>
              </tr>
              <tr align="center" height="270">
                <td nowrap colspan="2">
                <div id="map" style="width:100%; height:270px; border:1px solid white;"></div>
                </td>
              </tr>
            </table>
        </div>
        <div class="tab-pane tap-pane-primary" id="t_contacto" role="tabpanel" aria-labelledby="contacto-tab"><br>
        	<div class="row">
            	<div class="form-group col-md-5 col-sm-5 text-primary">
                	<label for="telparticularP" class="col-form-label">TELÉFONO PARTICULAR</label>
                    <input name="telparticularP" id="telparticularP" type="text" maxlength="15" class="form-control form-control-sm" data-mask="(999) 999-9999" placeholder="Teléfono particular">
                	<div class="help-block with-errors"></div>
                </div>
                <div class="form-group col-md-5 col-sm-5 text-primary">
                	<label for="telefonoTrabajoP" class="col-form-label">TELÉFONO DEL TRABAJO</label>
                    <input name="telefonoTrabajoP" id="telefonoTrabajoP" type="text" maxlength="15" class="form-control form-control-sm" data-mask="(999) 999-9999" placeholder="Teléfono del trabajo">
                  	<div class="help-block with-errors"></div>
                </div>
                <div class="form-group col-md-2 col-sm-2 text-primary">
                	<label for="extensionTelTraP" class="col-form-label">EXTENSIÓN</label>
                    <input name="extensionTelTraP" id="extensionTelTraP" type="text" maxlength="5" class="form-control form-control-sm" placeholder="Extensión">
                  	<div class="help-block with-errors"></div>
                </div>
            </div>
            <div class="row">
            	<div class="form-group col-md-4 col-sm-4 text-primary">
                	<label for="avisarP" class="col-form-label">CONTACTO DE EMERGENCIA</label>
                    <input name="avisarP" id="avisarP" type="text" class="form-control form-control-sm" placeholder="Contacto de emergencia">
                	<div class="help-block with-errors"></div>
                </div>
                <div class="form-group col-md-4 col-sm-4 text-primary">
                	<label for="telefonoEmergenciaP" class="col-form-label">TELÉFONO DE EMERGENCIA</label>
                    <input name="telefonoEmergenciaP" id="telefonoEmergenciaP" type="text" maxlength="15" class="form-control form-control-sm" data-mask="(999) 999-9999" placeholder="Teléfono del contacto de emergencia">
                  	<div class="help-block with-errors"></div>
                </div>
                <div class="form-group col-md-4 col-sm-4 text-primary">
                	<label for="emailP" class="col-form-label">CORREO ELECTRÓNICO</label>
                    <input name="emailP" id="emailP" type="email" class="form-control form-control-sm" placeholder="Correo electrónico">
                  	<div class="help-block with-errors"></div>
                </div>
            </div>
        </div>
        <div class="tab-pane tap-pane-primary" id="t_horario" role="tabpanel" aria-labelledby="horario-tab"><br>
        	<div class="panel panel-primary">
              <!-- Default panel contents -->
              <div class="panel-heading">INDIQUE EL HORARIO LABORAL PARA CADA DÍA DE LA SEMANA</div>
              <!-- Table -->
              <table width="100%" height="" border="0" cellspacing="0" cellpadding="0" class="table-condensed table-striped">
                <tr align="left">
                  	<td width="30%"></td>
                    <td width="1%" nowrap>
                    	<div class="i-checks">
                        <label><input type="checkbox" value="" checked="" name="checkbox-lu" id="checkbox-lu" class="checki" onClick=""> <i></i> LUNES </label>
                        <input name="t_lunes" type="hidden" id="t_lunes" value="1">
                        </div>
                    </td>
                    <td align="right" valign="middle" width="150px" nowrap class="texto_lu">
                    	<div class="input-group clockpicker" data-placement="left" data-align="top" data-autoclose="true">
                            <input type="text" class="form-control" value="08:00" id="lunes_de1" name="lunes_de1">
                            <span class="input-group-addon"><span class="glyphicon glyphicon-time"></span></span>
                        </div>
                    </td>
                    <td align="right" valign="middle" width="150px" nowrap class="texto_lu">
                        <div class="input-group clockpicker" data-placement="left" data-align="top" data-autoclose="true">
                            <input type="text" class="form-control" value="18:00" id="lunes_a1" name="lunes_a1">
                            <span class="input-group-addon"><span class="glyphicon glyphicon-time"></span></span>
                        </div>
                    </td>
                    <td width="30%"></td>
                </tr>
                <tr align="left">
                  	<td width="30%"></td>
                    <td width="1%" nowrap>
                    	<div class="i-checks">
                        <label><input type="checkbox" value="" checked="" name="checkbox-ma" id="checkbox-ma" class="checki"> <i></i> MARTES </label>
                        <input name="t_martes" type="hidden" id="t_martes" value="1">
                        </div>
                    </td>
                    <td align="right" valign="middle" width="150px" nowrap class="texto_ma">
                    	<div class="input-group clockpicker" data-placement="left" data-align="top" data-autoclose="true">
                            <input type="text" class="form-control" value="08:00" id="martes_de1" name="martes_de1">
                            <span class="input-group-addon"><span class="glyphicon glyphicon-time"></span></span>
                        </div>
                    </td>
                    <td align="right" valign="middle" width="150px" nowrap class="texto_ma">
                        <div class="input-group clockpicker" data-placement="left" data-align="top" data-autoclose="true">
                            <input type="text" class="form-control" value="18:00" id="martes_a1" name="martes_a1">
                            <span class="input-group-addon"><span class="glyphicon glyphicon-time"></span></span>
                        </div>
                    </td>
                    <td width="30%"></td>
                </tr>
                <tr align="left">
                  	<td width="30%"></td>
                    <td width="1%" nowrap>
                    	<div class="i-checks">
                        <label><input type="checkbox" value="" checked="" name="checkbox-mi" id="checkbox-mi" class="checki"> <i></i> MIÉRCOLES </label>
                        <input name="t_miercoles" type="hidden" id="t_miercoles" value="1">
                        </div>
                    </td>
                    <td align="right" valign="middle" width="150px" nowrap class="texto_mi">
                    	<div class="input-group clockpicker" data-placement="left" data-align="top" data-autoclose="true">
                            <input type="text" class="form-control" value="08:00" id="miercoles_de1" name="miercoles_de1">
                            <span class="input-group-addon"><span class="glyphicon glyphicon-time"></span></span>
                        </div>
                    </td>
                    <td align="right" valign="middle" width="150px" nowrap class="texto_mi">
                        <div class="input-group clockpicker" data-placement="left" data-align="top" data-autoclose="true">
                            <input type="text" class="form-control" value="18:00" id="miercoles_a1" name="miercoles_a1">
                            <span class="input-group-addon"><span class="glyphicon glyphicon-time"></span></span>
                        </div>
                    </td>
                    <td width="30%"></td>
                </tr>
                <tr align="left">
                  	<td width="30%"></td>
                    <td width="1%" nowrap>
                    	<div class="i-checks">
                        <label><input type="checkbox" value="" checked="" name="checkbox-ju" id="checkbox-ju" class="checki"> <i></i> JUEVES </label>
                        <input name="t_jueves" type="hidden" id="t_jueves" value="1">
                        </div>
                    </td>
                    <td align="right" valign="middle" width="150px" nowrap class="texto_ju">
                    	<div class="input-group clockpicker" data-placement="left" data-align="top" data-autoclose="true">
                            <input type="text" class="form-control" value="08:00" id="jueves_de1" name="jueves_de1">
                            <span class="input-group-addon"><span class="glyphicon glyphicon-time"></span></span>
                        </div>
                    </td>
                    <td align="right" valign="middle" width="150px" nowrap class="texto_ju">
                        <div class="input-group clockpicker" data-placement="left" data-align="top" data-autoclose="true">
                            <input type="text" class="form-control" value="18:00" id="jueves_a1" name="jueves_a1">
                            <span class="input-group-addon"><span class="glyphicon glyphicon-time"></span></span>
                        </div>
                    </td>
                    <td width="30%"></td>
                </tr>
                <tr align="left">
                  	<td width="30%"></td>
                    <td width="1%" nowrap>
                    	<div class="i-checks">
                        <label><input type="checkbox" value="" checked="" name="checkbox-vi" id="checkbox-vi" class="checki"> <i></i> VIERNES </label>
                        <input name="t_viernes" type="hidden" id="t_viernes" value="1">
                        </div>
                    </td>
                    <td align="right" valign="middle" width="150px" nowrap class="texto_vi">
                    	<div class="input-group clockpicker" data-placement="left" data-align="top" data-autoclose="true">
                            <input type="text" class="form-control" value="08:00" id="viernes_de1" name="viernes_de1">
                            <span class="input-group-addon"><span class="glyphicon glyphicon-time"></span></span>
                        </div>
                    </td>
                    <td align="right" valign="middle" width="150px" nowrap class="texto_vi">
                        <div class="input-group clockpicker" data-placement="left" data-align="top" data-autoclose="true">
                            <input type="text" class="form-control" value="18:00" id="viernes_a1" name="viernes_a1">
                            <span class="input-group-addon"><span class="glyphicon glyphicon-time"></span></span>
                        </div>
                    </td>
                    <td width="30%"></td>
                </tr>
                <tr align="left">
                  	<td width="30%"></td>
                    <td width="1%" nowrap>
                    	<div class="i-checks">
                        <label><input type="checkbox" value="" checked="" name="checkbox-sa" id="checkbox-sa" class="checki"> <i></i> SÁBADO </label>
                        <input name="t_sabado" type="hidden" id="t_sabado" value="1">
                        </div>
                    </td>
                    <td align="right" valign="middle" width="150px" nowrap class="texto_sa">
                    	<div class="input-group clockpicker" data-placement="left" data-align="top" data-autoclose="true">
                            <input type="text" class="form-control" value="08:00" id="sabado_de1" name="sabado_de1">
                            <span class="input-group-addon"><span class="glyphicon glyphicon-time"></span></span>
                        </div>
                    </td>
                    <td align="right" valign="middle" width="150px" nowrap class="texto_sa">
                        <div class="input-group clockpicker" data-placement="left" data-align="top" data-autoclose="true">
                            <input type="text" class="form-control" value="14:00" id="sabado_a1" name="sabado_a1">
                            <span class="input-group-addon"><span class="glyphicon glyphicon-time"></span></span>
                        </div>
                    </td>
                    <td width="30%"></td>
                </tr>
                <tr align="left">
                  	<td width="30%"></td>
                    <td width="1%" nowrap>
                    	<div class="i-checks">
                        <label><input type="checkbox" value="" checked="" name="checkbox-do" id="checkbox-do" class="checki"> <i></i> DOMINGO </label>
                        <input name="t_domingo" type="hidden" id="t_domingo" value="1">
                        </div>
                    </td>
                    <td align="right" valign="middle" width="150px" nowrap class="texto_do">
                    	<div class="input-group clockpicker" data-placement="left" data-align="top" data-autoclose="true">
                            <input type="text" class="form-control" value="08:00" id="domingo_de1" name="domingo_de1">
                            <span class="input-group-addon"><span class="glyphicon glyphicon-time"></span></span>
                        </div>
                    </td>
                    <td align="right" valign="middle" width="150px" nowrap class="texto_do">
                        <div class="input-group clockpicker" data-placement="left" data-align="top" data-autoclose="true">
                            <input type="text" class="form-control" value="14:00" id="domingo_a1" name="domingo_a1">
                            <span class="input-group-addon"><span class="glyphicon glyphicon-time"></span></span>
                        </div>
                    </td>
                    <td width="30%"></td>
                </tr>
                </table>
            </div>
        </div>
        <div class="tab-pane tap-pane-primary" id="t_conceptos" role="tabpanel" aria-labelledby="conceptos-tab"><br>
        	<div class="panel panel-default small hidden" id="panel_concepto">
              <div class="panel-heading">
                <h3 class="panel-title">DAR DE ALTA UN CONCEPTO PARA EL USUARIO</h3>
              </div>
              <div class="panel-body">
                <div class="row">
                    <div class="form-group col-md-6 col-sm-6 col-lg-6 text-primary">
                    	<input name="mi_id_to" id="mi_id_to" type="hidden">
                        <label for="nombre_to" class="col-form-label">* NOMBRE DEL CONCEPTO</label>
                        <input name="nombre_to" id="nombre_to" type="text" class="form-control form-control-sm" placeholder="Nombre del concepto">
                    </div>
                    <div class="form-group col-md-6 col-sm-6 col-lg-6 text-primary">
                    	<input name="mi_id_to" id="mi_id_to" type="hidden">
                        <label for="sat" class="col-form-label">* CLAVE SAT </label> <br>
                        <select name="sat" id="sat" class="form-control form-control-sm" ></select>
                    </div>
                </div>
                <div class="row">
                  <div class="form-group col-md-6 col-sm-6 col-lg-6 text-primary">
                      <label for="area_to" class="col-form-label">* ÁREA</label>
                      <select name="area_to" id="area_to" class="form-control form-control-sm"></select>
                  </div>
                  <div class="form-group col-md-6 col-sm-6 col-lg-6 text-primary">
                      <label for="linea_to" class="col-form-label">* LÍNEA</label>
                      <select name="linea_to" id="linea_to" class="form-control form-control-sm"></select>
                  </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-3 col-sm-3 col-lg-3 text-primary">
                        <label for="precio_n" class="col-form-label">* PRECIO NORMAL</label>
                        <div class="input-group">
                          <span class="input-group-addon">$</span>
                          <input name="precio_n" id="precio_n" type="number" class="form-control form-control-sm" placeholder="Precio normal" step="0.01">
                        </div>
                    </div>
                    <div class="form-group col-md-3 col-sm-3 col-lg-3 text-primary">
                        <label for="precio_u" class="col-form-label">* PRECIO DE URGENCIA</label>
                        <div class="input-group">
                          <span class="input-group-addon">$</span>
                          <input name="precio_u" id="precio_u" type="number" class="form-control form-control-sm" placeholder="Precio de urgencia" step="0.01">
                        </div>
                    </div>
                    <div class="form-group col-md-3 col-sm-3 col-lg-3 text-primary">
                        <label for="precio_m" class="col-form-label">* PRECIO DE MEMBRESÍA</label>
                        <div class="input-group">
                          <span class="input-group-addon">$</span>
                          <input name="precio_m" id="precio_m" type="number" class="form-control form-control-sm" placeholder="Precio de membresía" step="0.01">
                        </div>
                    </div>
                    <div class="form-group col-md-3 col-sm-3 col-lg-3 text-primary">
                        <label for="precio_mu" class="col-form-label">* PRECIO MEMBRESÍA URGENCIA</label>
                        <div class="input-group">
                          <span class="input-group-addon">$</span>
                          <input name="precio_mu" id="precio_mu" type="number" class="form-control form-control-sm" placeholder="Precio de membresía con urgencia" step="0.01">
                        </div>
                    </div>
                    <div class="form-group col-md-3 col-sm-3 col-lg-3 text-primary">
                        <label for="honorario_c" class="col-form-label">* HONORARIOS NORMAL</label>
                        <div class="input-group">
                          <span class="input-group-addon">$</span>
                          <input name="honorario_c" id="honorario_c" type="number" class="form-control form-control-sm" placeholder="Honorarios normal" step="0.01">
                        </div>
                    </div>
                    <div class="form-group col-md-3 col-sm-3 col-lg-3 text-primary">
                        <label for="honorario_cu" class="col-form-label">* HONORARIOS URGENCIA</label>
                        <div class="input-group">
                          <span class="input-group-addon">$</span>
                          <input name="honorario_cu" id="honorario_cu" type="number" class="form-control form-control-sm" placeholder="Honorarios urgencia" step="0.01">
                        </div>
                    </div>
					<div class="form-group col-md-3 col-sm-3 col-lg-3 text-primary">
                        <label for="precio_h" class="col-form-label">PRECIO HOSPITAL</label>
                        <div class="input-group">
                          <span class="input-group-addon">$</span>
                          <input name="precio_h" id="precio_h" type="number" class="form-control form-control-sm" placeholder="Precio hospital" step="0.01">
                        </div>
                    </div>
					<div class="form-group col-md-3 col-sm-3 col-lg-3 text-primary">
                        <label for="precio_costoproduccion" class="col-form-label">COSTO DE PRODUCCION</label>
                        <div class="input-group">
                          <span class="input-group-addon">$</span>
                          <input name="precio_costoproduccion" id="precio_costoproduccion" type="number" class="form-control form-control-sm" placeholder="Costo de producción" step="0.01">
                        </div>
                    </div>
                    <div class="col-md-12 text-right">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" value="1" id="cambioGlobal_cg">
                                Aplicar honorarios normal al historial
                            </label>
                        </div>
                    </div>
                </div>
              </div>
              <div class="panel-footer" align="right">
              	<button type="button" class="btn btn-success btn-sm disabled" id="btn_add_concepto">Guardar</button>
                <button type="button" class="btn btn-success btn-sm disabled hidden" id="btn_update_concepto">Actualizar</button>
                <button type="button" class="btn btn-danger btn-sm disabled hidden" id="btn_del_concepto">Eliminar</button>
              	<button type="button" class="btn btn-warning btn-sm" id="btn_cancel_add_concepto">Cancelar</button>
              </div>
            </div>
        	
        	<table width="100%" height="" border="0" cellpadding="0" cellspacing="0" id="dataTableTos" class="table table-hover table-striped table-condensed" role="grid"> 
            <thead>
              <tr role="row" class="bg-info">
                <th id="clickmeTos" align="center" data-priority="1">#</th>
                <th align="center" nowrap data-priority="2">
                <button type="button" class="btn btn-default btn-xs" id="nvo_cto" onClick=""><i class="fa fa-plus" aria-hidden="true"></i> CONCEPTO</button>
                </th>
                <th align="center" nowrap data-priority="4" width="">ÁREA</th>
                <th title="Precio" align="center" data-priority="3" width="90px" nowrap>$ P.</th>
                <th title="Precio urgencia" align="center" nowrap data-priority="4" width="90px">$ P. U.</th>
                <th title="Membresia" align="center" data-priority="3" width="90px" nowrap>$ Mem.</th>
                <th title="Membresia urgencia" align="center" nowrap data-priority="4" width="90px">$ Mem. U.</th>
                <th title="Honorarios" align="center" nowrap data-priority="4" width="90px">$ Hon.</th>
                <th title="Honorarios urgencia" align="center" nowrap data-priority="4" width="90px">$ Hon. U.</th>
                <th title="Costo de produccion" align="center" nowrap data-priority="4" width="90px">$ C.</th>
              </tr>
            </thead> <tbody> <tr> <td class="dataTables_empty">Cargando datos del servidor</td> </tr> </tbody> 
            </table>
        </div>
        <div class="tab-pane tap-pane-primary" id="t_archivos" role="tabpanel" aria-labelledby="archivos-tab">
        	<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0" class="table-condensed no_document">
              <tr>
              	<td colspan="3" class="text-primary" align="">
                	PARA CARGAR UN NUEVO DOCUMENTO O IMAGEN, INGRESE EL TÍTULO Y SELECCIONE EL ARCHIVO A CARGAR.
                </td>
              </tr>
              <tr>
                <td width="1%" nowrap valign="middle">Título del documento</td>
                <td align="left">
                    <input name="titulo_foto" type="text" class="form-control" id="titulo_foto" maxlength="50">
                </td>
                <td width="1px" nowrap><button type="button" class="btn btn-default btn-sm disabled" id="btn_add_doc"><i class="fa fa-file-text" aria-hidden="true"></i></button></td>
              </tr>
              <tr class="hidden">
                <td colspan="3" align="left">
                    <input id="fileupload_foto" type="file" name="files[]" class="" accept="image/jpg, image/jpeg, image/png, application/pdf">
                </td>
              </tr>
            </table>
            <div id="progress"> <div class="bar" style="width: 0%;"></div> </div>
          	<table width="100%" height="96%" border="0" cellpadding="0" cellspacing="0" id="dataTableDocs" class="table table-hover table-striped table-condensed no_document" role="grid"> 
            <thead>
              <tr role="row" class="bg-info">
                <th id="clickmeDocs" align="center" nowrap data-priority="1">#</th>
                <th align="center" data-priority="2" nowrap style="white-space:nowrap;">NOMBRE ARCHIVO</th>
                <th align="center" data-priority="3" style="white-space:nowrap;">USUARIO CARGÓ</th>
                <th align="center" nowrap data-priority="4" style="white-space:nowrap;">FECHA</th>
                <th align="center" nowrap data-priority="4" style="white-space:nowrap;">VER</th>
                <th align="center" nowrap data-priority="4" style="white-space:nowrap;">PERFIL</th>
                <th align="center" nowrap data-priority="4" style="white-space:nowrap;">FIRMA</th>
                <th align="center" nowrap data-priority="5" style="white-space:nowrap;">ELIMINAR</th>
              </tr>
            </thead> <tbody> <tr> <td class="dataTables_empty">Cargando datos del servidor</td> </tr> </tbody> 
            </table>
            <table id="tablaMiPDF" width="100%" border="0" cellspacing="0" cellpadding="0" class="table-condensed si_document"> <tr> 
            <td id="mi_documento" style="vertical-align:middle;"> <a class="media" href=""> </a> </td>
            </tr></table>
        </div>
        <div class="tab-pane tap-pane-primary" id="t_firmas" role="tabpanel" aria-labelledby="firmas-tab"><br>

        </div>
        <div class="tab-pane tap-pane-primary" id="t_fotos" role="tabpanel" aria-labelledby="fotos-tab"><br>

        </div>
        <div class="tab-pane tap-pane-primary" id="t_sucur" role="tabpanel" aria-labelledby="sucursales-tab"><br>
			<div class="row">
            	<div class="col-sm-12 col-xs-12 text-primary">
                	Para asignar una sucursal al usuario selecciónala y dale click en el botón de 'Asignar'
                </div>
                <div class="col-sm-10 col-xs-10">
                <select data-placeholder="Selecciona la sucursal a asignar" id="sucursal_as" name="sucursal_as" class="chosen-select form-control"> </select>
                </div>
                <div class="col-sm-2 col-xs-2" align="left">
					<button type="button" class="btn btn-success disabled" form="form-registro" id="btn_asigna_sucu">Asignar</button>
                </div>
                <div class="col-sm-12 col-xs-12"><br>
                    <div class="panel panel-primary">
                      <!-- Default panel contents -->
                      <div class="panel-heading">
                        SUCURSALES ASIGNADAS AL USUARIO
                      </div>
                      <table width="100%" cellspacing="0" id="dataTableSucus" height="100%" border="0" cellpadding="0" class="table table-striped table-hover table-condensed table-responsive">
                        <thead id="my_head">
                          <tr class="bg-info">
                            <th align="center" id="clickmeSu">#</th>
                            <th align="center">SUCURSAL</th>
                            <th align="center" nowrap>DATOS DE SAIGNACIÓN</th>
                            <th align="center">PRIMARIA</th>
                            <th align="center">ACCESO</th>
                            <th align="center">ELIMINAR</th>
                          </tr>
                        </thead>
                        <tbody align="left"> <tr> <td class="dataTables_empty">Cargando datos del servidor</td> </tr> </tbody>
                      </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-pane tap-pane-primary" id="t_permisos" role="tabpanel" aria-labelledby="permisos-tab"><br>
		  <div class="panel panel-info">
              <div class="panel-heading">RECEPCIÓN</div>
              <!--<div class="panel-body text-primary">El usuario tiene acceso a</div> -->
              <table class="table-condensed">
              	<tr>
                	<td>
                      <label><input type="checkbox" name="p_0" class="chekito"> PACIENTES</label>
                      <input name="h_permisos[]" type="hidden" value="0">
                    </td>
                    <td>
                      <label><input type="checkbox" name="p_1" class="chekito"> ÓRDENES DE VENTA</label>
                      <input name="h_permisos[]" type="hidden" value="0">
                    </td>
                    <td>
                      <label><input type="checkbox" name="p_2" class="chekito"> ÓRDENES AGENDADAS</label>
                      <input name="h_permisos[]" type="hidden" value="0">
                    </td>
                    <td>
                      <label><input type="checkbox" name="p_3" class="chekito"> PAGOS</label>
                      <input name="h_permisos[]" type="hidden" value="0">
                    </td>
                    <td>
                      <label><input type="checkbox" name="p_4" class="chekito"> RESUMEN</label>
                      <input name="h_permisos[]" type="hidden" value="0">
                    </td>
                    <td>
                      <label><input type="checkbox" name="p_5" class="chekito"> AGENDA</label>
                      <input name="h_permisos[]" type="hidden" value="0">
                    </td>
                    <td>
                      <label><input type="checkbox" name="p_6" class="chekito"> MEMBRESÍAS</label>
                      <input name="h_permisos[]" type="hidden" value="0">
                    </td>
                </tr>
              </table>
          </div>
          <div class="panel panel-info">
              <div class="panel-heading">CONSULTAS</div>
              <table class="table-condensed">
              	<tr>
                	<td>
                      <label><input type="checkbox" name="p_8" class="chekito"> CONSULTAS MÉDICAS</label>
                      <input name="h_permisos[]" type="hidden" value="0">
                    </td>
                    <td>
                      <label><input type="checkbox" name="p_9" class="chekito"> AGENDA CONSULTAS</label>
                      <input name="h_permisos[]" type="hidden" value="0">
                    </td>
                    <td>
                      <label><input type="checkbox" name="p_10" class="chekito"> CATÁLOGO</label>
                      <input name="h_permisos[]" type="hidden" value="0">
                    </td>
                </tr>
              </table>
          </div>
          <div class="panel panel-info">
              <div class="panel-heading">HOSPITAL</div>
              <table class="table-condensed">
              	<tr>
                    <td>
                      <label><input type="checkbox" name="p_12" class="chekito"> ENFERMERÍA</label>
                      <input name="h_permisos[]" type="hidden" value="0">
                    </td>
                	<td>
                      <label><input type="checkbox" name="p_13" class="chekito"> HOSPITALIZACIÓN</label>
                      <input name="h_permisos[]" type="hidden" value="0">
                    </td>
                    <td>
                      <label><input type="checkbox" name="p_14" class="chekito"> CAMAS</label>
                      <input name="h_permisos[]" type="hidden" value="0">
                    </td>
                </tr>
              </table>
          </div>
          <div class="panel panel-info">
              <div class="panel-heading">IMAGEN</div>
              <table class="table-condensed">
              	<tr>
                	<td>
                      <label><input type="checkbox" name="p_15" class="chekito"> IMAGENOLOGÍA</label>
                      <input name="h_permisos[]" type="hidden" value="0">
                    </td>
                    <td>
                      <label><input type="checkbox" name="p_16" class="chekito"> AGENDA IMGEN</label>
                      <input name="h_permisos[]" type="hidden" value="0">
                    </td>
                    <td>
                      <label><input type="checkbox" name="p_17" class="chekito"> ENDOSCOPÍA</label>
                      <input name="h_permisos[]" type="hidden" value="0">
                    </td>
                    <td>
                      <label><input type="checkbox" name="p_18" class="chekito"> ULTRASONIDO</label>
                      <input name="h_permisos[]" type="hidden" value="0">
                    </td>
                    <td>
                      <label><input type="checkbox" name="p_19" class="chekito"> COLPOSCOPÍA</label>
                      <input name="h_permisos[]" type="hidden" value="0">
                    </td>
                    <td>
                      <label><input type="checkbox" name="p_20" class="chekito"> CATÁLOGO</label>
                      <input name="h_permisos[]" type="hidden" value="0">
                    </td>
                </tr>
              </table>
          </div>
          <div class="panel panel-info">
              <div class="panel-heading">LABORATORIO</div>
              <table class="table-condensed">
              	<tr>
                	<td>
                      <label><input type="checkbox" name="p_22" class="chekito"> ESTUDIOS</label>
                      <input name="h_permisos[]" type="hidden" value="0">
                    </td>
                    <td>
                      <label><input type="checkbox" name="p_23" class="chekito"> AGENDA LABORATORIO</label>
                      <input name="h_permisos[]" type="hidden" value="0">
                    </td>
                    <td>
                      <label><input type="checkbox" name="p_24" class="chekito"> BASES</label>
                      <input name="h_permisos[]" type="hidden" value="0">
                    </td>
                    <td>
                      <label><input type="checkbox" name="p_25" class="chekito"> BITÁCORAS</label>
                      <input name="h_permisos[]" type="hidden" value="0">
                    </td>
                    <td>
                      <label><input type="checkbox" name="p_26" class="chekito"> CATÁLOGO</label>
                      <input name="h_permisos[]" type="hidden" value="0">
                    </td>
                </tr>
              </table>
          </div>
          <div class="panel panel-info">
              <div class="panel-heading">SERVICIOS</div>
              <table class="table-condensed">
              	<tr>
                	<td>
                      <label><input type="checkbox" name="p_28" class="chekito"> SERVICIOS MÉDICOS</label>
                      <input name="h_permisos[]" type="hidden" value="0">
                    </td>
                    <td>
                      <label><input type="checkbox" name="p_29" class="chekito"> AGENDA LABORATORIO</label>
                      <input name="h_permisos[]" type="hidden" value="0">
                    </td>
                    <td>
                      <label><input type="checkbox" name="p_30" class="chekito"> CATÁLOGO</label>
                      <input name="h_permisos[]" type="hidden" value="0">
                    </td>
                </tr>
              </table>
          </div>
          <div class="panel panel-info">
              <div class="panel-heading">FARMACIA</div>
              <table class="table-condensed">
              	<tr>
                    <td>
                      <label><input type="checkbox" name="p_32" class="chekito"> PUNTO DE VENTA</label>
                      <input name="h_permisos[]" type="hidden" value="0">
                    </td>
                    <td>
                      <label><input type="checkbox" name="p_33" class="chekito"> MEDICAMENTOS</label>
                      <input name="h_permisos[]" type="hidden" value="0">
                    </td>
                    <td>
                      <label><input type="checkbox" name="p_34" class="chekito"> PRODUCTOS</label>
                      <input name="h_permisos[]" type="hidden" value="0">
                    </td>
                    <td>
                      <label><input type="checkbox" name="p_35" class="chekito"> CORTE DE CAJA</label>
                      <input name="h_permisos[]" type="hidden" value="0">
                    </td>
                    <td>
                      <label><input type="checkbox" name="p_36" class="chekito"> INVENTARIO</label>
                      <input name="h_permisos[]" type="hidden" value="0">
                    </td>
                    

                </tr>
              </table>
          </div>
          <div class="panel panel-info">
              <div class="panel-heading">ADMINISTRACIÓN</div>
              <table class="table-condensed">
              	<tr>
                	<td>
                      <label><input type="checkbox" name="p_38" class="chekito"> USUARIOS</label>
                      <input name="h_permisos[]" type="hidden" value="0">
                    </td>
                    <td>
                      <label><input type="checkbox" name="p_39" class="chekito"> SUCURSALES</label>
                      <input name="h_permisos[]" type="hidden" value="0">
                    </td>
                    <td>
                      <label><input type="checkbox" name="p_40" class="chekito"> ESCUELAS </label>
                      <input name="h_permisos[]" type="hidden" value="0">
                    </td>
                    <td>
                      <label><input type="checkbox" name="p_41" class="chekito"> ÓRDENES DE VENTA</label>
                      <input name="h_permisos[]" type="hidden" value="0">
                    </td>
                    <td>
                      <label><input type="checkbox" name="p_42" class="chekito"> PAGOS</label>
                      <input name="h_permisos[]" type="hidden" value="0">
                    </td>
                    <td>
                      <label><input type="checkbox" name="p_43" class="chekito"> CORTE DE CAJA</label>
                      <input name="h_permisos[]" type="hidden" value="0">
                    </td>
                    <td>
                      <label><input type="checkbox" name="p_44" class="chekito"> BENEFICIOS</label>
                      <input name="h_permisos[]" type="hidden" value="0">
                    </td>
                    <td>
                      <label><input type="checkbox" name="p_45" class="chekito"> FORMATOS </label>
                      <input name="h_permisos[]" type="hidden" value="0">
                    </td>
                    <td class="hidden">
                      <label><input type="checkbox" name="p_46" class="chekito"> UNIDADES DE MEDIDA </label>
                      <input name="h_permisos[]" type="hidden" value="0">
                    </td>
                    <td class="hidden">
                      <label><input type="checkbox" name="p_47" class="chekito"> CONFIGURACIÓN</label>
                      <input name="h_permisos[]" type="hidden" value="0">
                    </td>
                </tr>
                <tr>
                  <td>
                    <label><input type="checkbox" name="p_7" class="chekito"> P. RECEPCIÓN</label>
                    <!-- <input name="h_permisos[]" type="hidden" value="0"> -->
                  </td>
                  <td>
                    <label><input type="checkbox" name="p_11" class="chekito"> P. CONSULTAS</label>
                    <!-- <input name="h_permisos[]" type="hidden" value="0"> -->
                  </td>
                  <td>
                    <label><input type="checkbox" name="p_21" class="chekito"> P. IMAGEN</label>
                    <!-- <input name="h_permisos[]" type="hidden" value="0"> -->
                  </td>
                  <td>
                    <label><input type="checkbox" name="p_27" class="chekito"> P. LABORATORIO</label>
                    <!-- <input name="h_permisos[]" type="hidden" value="0"> -->
                  </td>
                  <td>
                    <label><input type="checkbox" name="p_31" class="chekito"> P. SERVICIOS</label>
                    <!-- <input name="h_permisos[]" type="hidden" value="0"> -->
                  </td>
                  <td>
                    <label><input type="checkbox" name="p_37" class="chekito"> P. FARMACIA</label>
                    <!-- <input name="h_permisos[]" type="hidden" value="0"> -->
                  </td>
                </tr>
              </table>
          </div>
        </div>
        
        <div class="tab-pane tap-pane-primary" id="t_mi_nota" role="tabpanel" aria-labelledby="mi_nota-tab"><br>
        	<table width="100%" height="100%" border="1" class="table-condensed table-bordered">
              <tr align="left"> <td height="1px" nowrap>
                <table width="100%" border="0" cellspacing="1" class="table-condensed">
                  <tr>
                    <td width="1%" nowrap class="text-primary">TÍTULO</td>
                    <td><input name="nombreNM"type="text"id="nombreNM"placeholder="Título de la nota médica" class="form-control input-sm"></td>
                    <td width="150px">
                      <select name="inserta_algo" id="inserta_algo" onChange="insertAtCaret(this.value);return false;" class="form-control input-sm insers"></select>
                    </td>
                    <td align="right" width="1%" nowrap class="text-primary">FORMATO DE LA NOTA:</td>
                  </tr>
                </table>
              </td> </tr>
              <tr id="contieneET" align="left"><td colspan="4">
                <textarea style="height:90%; resize:none; vertical-align:top;" name="input" id="input" type="text" value="" class="jqte-test"></textarea>
                <input name="miDiagnostico" id="miDiagnostico" type="hidden"> <input name="id_nmed" id="id_nmed" type="hidden">
                <input name="aleatorio_nmed" id="aleatorio_nmed" type="hidden">
            </td></tr>
            </table>
        </div>
        
        <div class="tab-pane tap-pane-primary" id="t_escolaridad" role="tabpanel" aria-labelledby="escolaridad-tab"><br>
        	<div class="row">
            	<div class="form-group col-md-4 col-sm-4 text-primary">
                	<label for="cTituloU" class="col-form-label">* TÍTULO</label>
                    <select name="cTituloU" id="cTituloU" class="form-control form-control-sm" required> </select>
                  	<div class="help-block with-errors"></div>
                </div>
                <div class="form-group col-md-4 col-sm-4 text-primary">
                    <label for="escolaridadP" class="col-form-label">GRADO DE ESTUDIOS</label>
                    <select name="escolaridadP" id="escolaridadP" class="form-control form-control-sm"></select>
                	<div class="help-block with-errors"></div>
                </div>
                <div class="form-group col-md-4 col-sm-4 text-primary">
                	<label for="estatus_ge" class="col-form-label">ESTATUS</label>
                    <select name="estatus_ge" id="estatus_ge" class="form-control form-control-sm">
                    	<option value="">-SELECCIONAR-</option> <option value="1">TRUNCO</option>
                      	<option value="2">EGRESADO</option> <option value="3">TITULADO</option>
                    </select>
                	<div class="help-block with-errors"></div>
                </div>
            </div>
            <div class="row"><!-- superior hidden -->
                <div class="form-group col-md-12 col-sm-12 text-primary">
                	<label for="universidadU" class="col-form-label">ESCUELA DE EGRESO</label>
                    <select name="universidadU" id="universidadU" class="form-control form-control-sm"></select>
                  	<div class="help-block with-errors"></div>
                </div>
            </div>
            <div class="row"><!-- superior hidden -->
            	<div class="form-group col-md-9 col-sm-9 text-primary">
                	<label for="profesionUsuario" class="col-form-label">CARRERA</label>
                    <select name="profesionUsuario" id="profesionUsuario" class="form-control form-control-sm"></select>
                	<div class="help-block with-errors"></div>
                </div>
                <div class="form-group col-md-3 col-sm-3 text-primary">
                	<label for="cedulaU" class="col-form-label">CÉDULA PROFESIONAL</label>
                    <input name="cedulaU" id="cedulaU" type="text" class="form-control form-control-sm">
                  	<div class="help-block with-errors"></div>
                </div>
            </div>
            <div class="row"><!-- superior hidden -->
                <div class="form-group col-md-12 col-sm-12 text-primary">
                	<label for="universidadEU" class="col-form-label">ESCUELA DE ESPECIALIDAD</label>
                    <select name="universidadEU" id="universidadEU" class="form-control form-control-sm"></select>
                  	<div class="help-block with-errors"></div>
                </div>
            </div>
            <div class="row"><!-- superior hidden -->
                <div class="form-group col-md-9 col-sm-9 text-primary">
                	<label for="especialidadU" class="col-form-label">ESPECIALIDAD</label>
                    <select name="especialidadU" id="especialidadU" class="form-control form-control-sm"></select>
                  	<div class="help-block with-errors"></div>
                </div>
                <div class="form-group col-md-3 col-sm-3 text-primary">
                	<label for="cedulaU1" class="col-form-label">CÉDULA DE ESPECIALIDAD</label>
                    <input name="cedulaU1" id="cedulaU1" type="text" class="form-control form-control-sm">
                  	<div class="help-block with-errors"></div>
                </div>
            </div>
        </div>
        
        <div class="tab-pane tap-pane-primary" id="t_notas" role="tabpanel" aria-labelledby="notas-tab"><br>
        	<table width="100%" border="0" id="dataTableNotaM" class="table-condensed table-bordered">
                <thead id="cabecera_tBusquedaNotaM">
                  <tr class="bg-primary">
                    <th id="clickmeNM" align="center" width="1px" nowrap>#</th>
                    <th align="center">NOTA MÉDICA
                    <button type="button" class="btn btn-default btn-xs" id="addNotaM"><i class="fa fa-plus"></i> Nueva nota</button>
                    </th>
                  </tr>
                </thead>
                <tbody> <tr> <td class="dataTables_empty">Cargando datos del servidor</td> </tr> </tbody>
                <tfoot> <tr class="bg-primary">
                    <td></td>
                    <td><input type="text" placeholder="-Nombre de la nota-" class="form-control input-sm" style="width:100%;" /></td>
                </tr> </tfoot>
            </table>
        </div>
        
        <div class="tab-pane tap-pane-primary" id="t_mi_receta" role="tabpanel" aria-labelledby="mi_receta-tab"><br>
        	<table width="100%" height="100%" border="1" class="table-condensed table-bordered">
              <tr align="left"> <td height="1px" nowrap>
                <table width="100%" border="0" cellspacing="1" class="table-condensed">
                  <tr>
                    <td width="1%" nowrap class="text-primary">TÍTULO</td>
                    <td><input name="nombreRM"type="text"id="nombreRM"placeholder="Título de la receta médica" class="form-control input-sm"></td>
                    <td width="150px">
						<select name="inserta_algo1" id="inserta_algo1" onChange="insertAtCaret1(this.value);return false;" class="form-control input-sm insers">
                    	</select>
					</td>
                    <td align="right" width="1%" nowrap class="text-primary">FORMATO DE LA RECETA:</td>
                  </tr>
                </table>
              </td> </tr>
              <tr id="contieneET1" align="left"><td colspan="4">
                <textarea style="height:90%; resize:none; vertical-align:top;" name="input1" id="input1" type="text" value="" class="jqte-test"></textarea>
                <input name="miDiagnostico1" id="miDiagnostico1" type="hidden"> <input name="id_rmed" id="id_rmed" type="hidden">
                <input name="aleatorio_rmed" id="aleatorio_rmed" type="hidden">
            </td></tr>
            </table>
        </div>
		
		<div class="tab-pane tap-pane-primary" id="t_format_i" role="tabpanel" aria-labelledby="formati-tab"><br>
        	<table width="100%" border="0" id="dataTableFormatI" class="table-condensed table-bordered">
                <thead id="cabecera_tBusquedaFormatI">
                  <tr class="bg-primary">
                    <th id="clickmeFI" align="center" width="1px" nowrap>#</th>
                    <th align="center">FORMATO
                    <button type="button" class="btn btn-default btn-xs" id="addFormatI"><i class="fa fa-plus"></i> Nuevo formato</button>
                    </th>
					<th align="center">ESTUDIO</th>
                  </tr>
                </thead>
                <tbody> <tr> <td class="dataTables_empty">Cargando datos del servidor</td> </tr> </tbody>
                <tfoot> <tr class="bg-primary">
                    <td></td>
                    <td><input type="text" placeholder="-Nombre del formato-" class="form-control input-sm" style="width:100%;" /></td>
					<td><input type="text" placeholder="-Nombre del estudio-" class="form-control input-sm" style="width:100%;" /></td>
                </tr> </tfoot>
            </table>
        </div>
		
		<div class="tab-pane tap-pane-primary" id="t_mi_format_i" role="tabpanel" aria-labelledby="mi_format_i-tab"><br>
        	<table width="100%" height="100%" border="1" class="table-condensed table-bordered">
              <tr align="left"> <td height="1px" nowrap>
                <table width="100%" border="0" cellspacing="1" class="table-condensed">
                  <tr>
                    <td width="1%" nowrap class="text-primary">TÍTULO</td>
                    <td><input name="nombreFI"type="text"id="nombreFI"placeholder="Título del formato" class="form-control input-sm"></td>
                    <td width="150px">
						<select name="inserta_algoFI"id="inserta_algoFI"onChange="insertAtCaret2(this.value);return false;" class="form-control input-sm insers">
                    	</select>
					</td>
                    <td align="right" width="1%" nowrap class="text-primary">FORMATO:</td>
                  </tr>
				  <tr>
					<td colspan="4">
						<select data-placeholder="Selecciona el estudio para el formato" id="formato_si" name="formato_si" class="chosen-select form-control"> </select>
					</td>
				  </tr>
                </table>
              </td> </tr>
              <tr id="contieneET2" align="left"><td colspan="4">
                <textarea style="height:90%; resize:none; vertical-align:top;" name="inputFI" id="inputFI" type="text" value="" class="jqte-test"></textarea>
                <input name="miDiagnosticoFI" id="miDiagnosticoFI" type="hidden"> <input name="id_formai" id="id_formai" type="hidden">
                <input name="aleatorio_formai" id="aleatorio_formai" type="hidden">
            </td></tr>
            </table>
        </div>
        
        <div class="tab-pane tap-pane-primary" id="t_recetas" role="tabpanel" aria-labelledby="notas-tab"><br>
        	<table width="100%" border="0" id="dataTableRecetaM" class="table-condensed table-bordered">
                <thead id="cabecera_tBusquedaRecetaM">
                  <tr class="bg-primary">
                    <th id="clickmeRM" align="center" width="1px" nowrap>#</th>
                    <th align="center">RECETA MÉDICA
                    <button type="button" class="btn btn-default btn-xs" id="addRecetaM"><i class="fa fa-plus"></i> Nueva receta</button>
                    </th>
                  </tr>
                </thead>
                <tbody> <tr> <td class="dataTables_empty">Cargando datos del servidor</td> </tr> </tbody>
                <tfoot> <tr class="bg-primary">
                    <td></td>
                    <td><input type="text" placeholder="-Nombre de la receta-" class="form-control input-sm" style="width:100%;" /></td>
                </tr> </tfoot>
            </table>
        </div>
        <div class="tab-pane tap-pane-primary" id="t_contra" role="tabpanel" aria-labelledby="contra-tab"><br>
          <div class="row">
            <div class="col-sm-3">
              <img src="imagenes/user_profile_male.png" width="150px" height="150px" style="border-radius:50%; margin-bottom:20px; margin-left:10px" alt="" id=fotP>
              <div class="row">
                <input type="file" id="foto_p" class="form-control form-control-sm hidden">
                <span class="btn btn-primary" style="margin-left:20px;margin-bottom:20px" onclick="	$('#foto_p').click();"><i class="fa fa-file-text compu fa-1x" aria-hidden="true"></i></span>
                <span class="btn btn-primary" style="margin-left:10px;margin-bottom:20px" onclick="cambiarFotoPerfil(<?php echo $id_del_user; ?>)" id="actualizar_foto_p">Actualizar Foto</span>
              </div>
            </div>
            <div class="col-sm-9">
              <div class="panel panel-primary">
                <div class="panel-heading">
                  <h3 class="panel-title">CONFIGURAR UNA NUEVA CONTRASEÑA</h3>
                </div>
                <div class="panel-body">
                  <div class="row">
                      <div class="form-group col-md-12 col-sm-12 text-primary">
                        <label for="contra_actual" class="col-form-label">* CONTRASEÑA ACTUAL</label>
                        <input type="password" class="form-control form-control-sm" id="contra_actual" name="contra_actual" placeholder="Introduzca su contraseña actual" maxlength="20">
                      </div>
                      <div class="form-group col-md-12 col-sm-12 text-primary">
                        <label for="contra_new" class="col-form-label">* NUEVA CONTRASEÑA</label>
                        <input type="password" class="form-control form-control-sm" id="contra_new" name="contra_new" placeholder="Introduzca su nueva contraseña" maxlength="20">
                      </div>
                      <div class="form-group col-md-12 col-sm-12 text-primary">
                        <label for="re_contra_new" class="col-form-label">* CONFIRME SU NUEVA CONTRASEÑA</label>
                        <input type="password" class="form-control form-control-sm" id="re_contra_new" name="re_contra_new" placeholder="Confirme su nueva contraseña" maxlength="20">
                      </div>
                      <p class="text-danger">* La nueva contraseña debe ser de por lo menos 6 dígitos</p>
                  </div>
                </div>
                <div class="panel-footer">
                  <button type="button" class="btn btn-warning btn-sm" id="btn_update_contra_u">Actualizar contraseña</button>
                </div>
              </div>
            </div>
          </div>
        
        </div>
    </div>          
</form>
	<div id="alerta_form" class="alert alert-warning">
    <i class="fa fa-exclamation-circle" aria-hidden="true"></i> Favor de revisar el formulario, hay algunos errores.
    </div>
  </div>
  <div class="modal-footer">
  	<button type="button" class="btn btn-success si_nota no_receta no_forma_i hidden" id="btn_registro_nota" onClick="guardarNota();">Guardar nota</button>
    <button type="button" class="btn btn-success si_receta no_nota no_forma_i hidden" id="btn_registro_receta" onClick="guardarReceta();">Guardar receta</button>
	<button type="button" class="btn btn-success no_receta no_nota si_forma_i hidden" id="btn_registro_formato_i" onClick="guardarFormatoI();">Guardar formato</button>
    <button type="button" class="btn btn-success" id="btn_update_nota" onClick="updateNota();">Actualizar nota</button>
    <button type="button" class="btn btn-success" id="btn_update_receta" onClick="updateReceta();">Actualizar receta</button>
	<button type="button" class="btn btn-success" id="btn_update_formato_i" onClick="updateFormaI();">Actualizar formato</button>
    <button type="submit" class="btn btn-success no_document no_nota no_receta no_forma_i" form="form-registro" id="btn_registro_u">Guardar</button>
    <button type="submit" class="btn btn-success hidden" form="form-registro" id="btn_update_u">Actualizar</button>
    <button type="button" class="btn btn-warning no_document no_nota no_receta no_forma_i" data-dismiss="modal" id="btn_cancel_registro">Cancelar</button>
    <button type="button" class="btn btn-info hidden" onClick="cerrar_();" id="btn_salir_">Regresar</button>
    <button type="button" class="btn btn-info privacidad_hide si_document hidden" onClick="cerrar_ver_doc();" id="btn_salir_document">Regresar</button>
    <button type="button" class="btn btn-info si_nota no_receta no_forma_i hidden" onClick="cerrar_nota();" id="btn_salir_nota">Regresar</button>
    <button type="button" class="btn btn-info si_receta no_nota no_forma_i hidden" onClick="cerrar_receta();" id="btn_salir_receta">Regresar</button>
	<button type="button" class="btn btn-info si_forma_i no_nota no_receta hidden" onClick="cerrar_forma_i();" id="btn_salir_forma_i">Regresar</button>
  </div>
</div>
</div>
