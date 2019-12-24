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
  <div class="modal-header">
  	<button type="button" class="close hidden" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  	<table width="100%" border="0" cellpadding="0" cellspacing="0">
    	<tr>
        	<td><h4 class="modal-title text-dark" id="registroModalLabel">FICHA DE DATOS DE LA SUCURSAL</h4></td>
            <td align="right">
            	<button type="submit" class="btn btn-sm btn-success no_document" form="form-registro" id="btn_registro_u">Guardar</button>
                <button type="submit" class="btn btn-sm btn-success hidden" form="form-registro" id="btn_update_u">Actualizar</button>
                <button type="button" class="btn btn-sm btn-warning no_document" data-dismiss="modal" id="btn_cancel_registro">Cancelar</button>
                <button type="button" class="btn btn-sm btn-info hidden" onClick="cerrar_();" id="btn_salir_">Regresar</button>
                <button type="button" class="btn btn-sm btn-info privacidad_hide si_document hidden" onClick="cerrar_ver_doc();" id="btn_salir_document">Regresar</button>
            </td>
        </tr>
    </table>
  </div>
  <div class="modal-body" id="body_modal_reg">
  	<div id="alerta_form" class="alert alert-danger">
    	<i class="fa fa-exclamation-circle" aria-hidden="true"></i> Favor de revisar el formulario, hay algunos errores.
    </div>
    
<form class="small" method="post" name="form-registro" id="form-registro" data-toggle="validator" role="form">
    <input name="idSucursal" type="hidden" id="idSucursal"> <input name="temporal_s" type="hidden" id="temporal_s">
    <input name="p_latitud_s" type="hidden" id="p_latitud_s"> <input name="p_longitud_s" type="hidden" id="p_longitud_s">
    <input name="nuevo_o_viejo_u" type="hidden" id="nuevo_o_viejo_u" value="x">
    <input name="idUsuarioP" id="idUsuarioP" class="idUsuarioP" type="hidden" value="">
    <input name="input_a" id="input_a" type="hidden" value=""> <input name="input_b" id="input_b" type="hidden" value="">
    <input name="input_c" id="input_c" type="hidden" value=""> <input name="input_d" id="input_d" type="hidden" value="">
    <input name="input_e" id="input_e" type="hidden" value=""> <input name="input_f" id="input_f" type="hidden" value="">
    <input name="input_g" id="input_g" type="hidden" value=""> <input name="input_h" id="input_h" type="hidden" value="">
	<ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item active no_document" id="tab_mi_grales">
            <a class="nav-link" id="generales-tab" data-toggle="tab" href="#t_generales" role="tab" aria-controls="generales" aria-expanded="true">GENERALES</a>
        </li>
        <li class="nav-item no_document" id="tab_mi_dir">
            <a class="nav-link" id="direccion-tab" data-toggle="tab" href="#t_direccion" role="tab" aria-controls="direccion">DIRECCIÓN</a>
        </li>
        <li class="nav-item no_document" id="tab_mi_hor">
            <a class="nav-link" id="horario-tab" data-toggle="tab" href="#t_horario" role="tab" aria-controls="horario">HORARIO</a>
        </li>
        <li class="nav-item" id="tab_mi_arc">
            <a class="nav-link" id="archivos-tab" data-toggle="tab" href="#t_archivos" role="tab" aria-controls="archivos">ARCHIVOS</a>
        </li>
        <li class="nav-item hidden" id="tab_mi_fir">
            <a class="nav-link" id="firmas-tab" data-toggle="tab" href="#t_firmas" role="tab" aria-controls="firmas">FIRMAS</a>
        </li>
        <li class="nav-item hidden" id="tab_mi_fot">
            <a class="nav-link" id="fotos-tab" data-toggle="tab" href="#t_fotos" role="tab" aria-controls="fotos">FOTOS</a>
        </li>
        <li class="nav-item hidden" id="tab_mi_mone">
        	<a class="nav-link" id="mone-tab" data-toggle="tab" href="#t_mone" role="tab" aria-controls="mone">MONEDERO</a>
        </li>
        <li class="dropdown no_document">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">MEMBRETES <span class="caret"></span></a>
            <ul class="dropdown-menu">
           	  <li class="nav-item" id="tab_m_consultas">
                <a class="nav-link" id="m-consultas-tab" data-toggle="tab" href="#t_m_consultas" role="tab" aria-controls="m_consultas">NOTAS MÉDICAS</a>
              </li>
              <li class="nav-item" id="tab_m_recetas">
            	<a class="nav-link" id="m-recetas-tab" data-toggle="tab" href="#t_m_recetas" role="tab" aria-controls="m_recetas">RECETAS</a>
              </li>
              <li class="nav-item" id="tab_m_labo">
            	<a class="nav-link" id="m-labo-tab" data-toggle="tab" href="#t_m_labo" role="tab" aria-controls="m_labo">ESTUDIOS DE LABORATORIO</a>
              </li>
              <li class="nav-item" id="tab_m_imagen">
            	<a class="nav-link" id="m-imagen-tab" data-toggle="tab" href="#t_m_imagen" role="tab" aria-controls="m_imagen">ESTUDIOS DE IMAGEN</a>
              </li>
              <li class="nav-item" id="tab_m_endo">
            	<a class="nav-link" id="m-endo-tab" data-toggle="tab" href="#t_m_endo" role="tab" aria-controls="m_endo">ESTUDIOS DE ENDOSCOPÍA</a>
              </li>
              <li class="nav-item" id="tab_m_ultra">
            	<a class="nav-link" id="m-ultra-tab" data-toggle="tab" href="#t_m_ultra" role="tab" aria-controls="m_ultra">ESTUDIOS DE ULTRASONIDO</a>
              </li>
              <li class="nav-item" id="tab_m_colpo">
            	<a class="nav-link" id="m-colpo-tab" data-toggle="tab" href="#t_m_colpo" role="tab" aria-controls="m_colpo">ESTUDIOS DE COLPOSCOPÍA</a>
              </li>
              <li class="nav-item" id="tab_m_servi">
            	<a class="nav-link" id="m-servi-tab" data-toggle="tab" href="#t_m_servi" role="tab" aria-controls="m_servi">SERVICIOS MÉDICOS</a>
              </li>
            </ul>
        </li>
        <li class="dropdown no_document">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">FORMATOS <span class="caret"></span></a>
            <ul class="dropdown-menu">
           	  <li class="nav-item" id="tab_f_notas">
                <a class="nav-link" id="f-notas-tab" data-toggle="tab" href="#t_f_notas" role="tab" aria-controls="f_notas">NOTAS MÉDICAS</a>
              </li>
              <li class="nav-item" id="tab_f_recetas">
            	<a class="nav-link" id="f-recetas-tab" data-toggle="tab" href="#t_f_recetas" role="tab" aria-controls="f_recetas">RECETAS MÉDICAS</a>
              </li>
              <li class="nav-item" id="tab_f_labo">
            	<a class="nav-link" id="f-labo-tab" data-toggle="tab" href="#t_f_labo" role="tab" aria-controls="f_labo">ESTUDIOS DE LABORATORIO</a>
              </li>
              <li class="nav-item" id="tab_f_imagen">
            	<a class="nav-link" id="f-imagen-tab" data-toggle="tab" href="#t_f_imagen" role="tab" aria-controls="f_imagen">ESTUDIOS DE IMAGEN</a>
              </li>
              <!--<li class="nav-item" id="tab_f_endo">
            	<a class="nav-link" id="f-endo-tab" data-toggle="tab" href="#t_f_endo" role="tab" aria-controls="f_endo">ESTUDIOS DE ENDOSCOPÍA</a>
              </li>
              <li class="nav-item" id="tab_f_ultra">
            	<a class="nav-link" id="f-ultra-tab" data-toggle="tab" href="#t_f_ultra" role="tab" aria-controls="f_ultra">ESTUDIOS DE ULTRASONIDO</a>
              </li>
              <li class="nav-item" id="tab_m_colpo">
            	<a class="nav-link" id="f-colpo-tab" data-toggle="tab" href="#t_f_colpo" role="tab" aria-controls="f_colpo">ESTUDIOS DE COLPOSCOPÍA</a>
              </li>-->
              <li class="nav-item" id="tab_f_servi">
            	<a class="nav-link" id="f-servi-tab" data-toggle="tab" href="#t_f_servi" role="tab" aria-controls="f_servi">SERVICIOS MÉDICOS</a>
              </li>
            </ul>
        </li>
    </ul>
    <div class="tab-content" id="myTabContent">
    	<div class="tab-pane active tap-pane-primary" id="t_generales" role="tabpanel" aria-labelledby="generales-tab"><br>
        	<div class="row">
                <div class="form-group col-md-6 col-sm-6 text-primary">
                	<label for="nombreS" class="col-form-label">* NOMBRE</label>
                    <input name="nombreS" id="nombreS" type="text" class="form-control form-control-sm" required placeholder="Nombre de la sucursal">
                	<div class="help-block with-errors"></div>
                </div>
                <div class="form-group col-md-3 col-sm-3 text-primary">
                	<label for="claveS" class="col-form-label">* CLAVE</label>
                    <input name="claveS" id="claveS" type="text" class="form-control form-control-sm" required placeholder="Clave de la sucursal" maxlength="6">
                	<div class="help-block with-errors"></div>
                </div>
                <div class="form-group col-md-3 col-sm-3 text-primary">
                	<label for="cluesS" class="col-form-label">* CLUES</label>
                    <input name="cluesS" id="cluesS" type="text" class="form-control form-control-sm" placeholder="CLUES de la sucursal" required maxlength="50">
                	<div class="help-block with-errors"></div>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-8 col-sm-8 text-primary">
                	<label for="ionrange_tabu_img" class="col-form-label">* % DE TABULADOR PARA IMAGEN</label>
                    <input name="p_tabu_img" id="p_tabu_img" type="hidden" value="100">
                    <div id="ionrange_tabu_img"></div>
                </div>
                <div class="form-group col-md-4 col-sm-4 text-primary">
                	<label for="t_base_img" class="col-form-label">* TABULADOR BASE DE IMAGEN</label>
                    <select name="t_base_img" id="t_base_img" class="form-control form-control-sm" required>
                    	<option value="1">MAQUILA</option>
                        <option value="2" selected>SUCURSAL</option>
                    </select>
                	<div class="help-block with-errors"></div>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-8 col-sm-8 text-primary">
                	<label for="ionrange_tabu_lab" class="col-form-label">* % DE TABULADOR PARA LABORATORIO</label>
                    <input name="p_tabu_lab" id="p_tabu_lab" type="hidden" value="100">
                    <div id="ionrange_tabu_lab"></div>
                </div>
                <div class="form-group col-md-4 col-sm-4 text-primary">
                	<label for="t_base_lab" class="col-form-label">* TABULADOR BASE DE LABORATORIO</label>
                    <select name="t_base_lab" id="t_base_lab" class="form-control form-control-sm" required>
                    	<option value="1">MAQUILA</option>
                        <option value="2" selected>SUCURSAL</option>
                    </select>
                	<div class="help-block with-errors"></div>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-8 col-sm-8 text-primary">
                	<label for="ionrange_tabu_serv" class="col-form-label">* % DE TABULADOR PARA SERVICIOS</label>
                    <input name="p_tabu_serv" id="p_tabu_serv" type="hidden" value="100">
                    <div id="ionrange_tabu_serv"></div>
                </div>
                <div class="form-group col-md-4 col-sm-4 text-primary">
                	
                </div>
            </div>
            <div class="row">
            	<div class="form-group col-md-6 col-sm-6 text-primary">
                	<label for="telefonos_s" class="col-form-label">* TELÉFONO(S)</label>
                    <input name="telefonos_s" id="telefonos_s" type="text" class="form-control form-control-sm" placeholder="Numeros telefónicos de la sucursal" required>
                	<div class="help-block with-errors"></div>
                </div>
                <div class="form-group col-md-6 col-sm-6 text-primary">
                	<label for="email_s" class="col-form-label">EMAIL</label>
                    <input name="email_s" id="email_s" type="email" class="form-control form-control-sm" placeholder="Dirección de correo electrónico">
                	<div class="help-block with-errors"></div>
                </div>
            </div>
        </div>
        <div class="tab-pane tap-pane-primary" id="t_direccion" role="tabpanel" aria-labelledby="direccion-tab"><br>
        	<div class="row">
            	<div class="form-group col-md-6 col-sm-6 text-primary">
                	<label for="estadoP" class="col-form-label">* ESTADO</label>
                    <!--<select name="estadoP" id="estadoP" class="form-control form-control-sm mi_dir"></select> -->
                    <input name="estadoP" id="estadoP" class="form-control form-control-sm mi_dir" placeholder="Entidad federativa" required>
                	<div class="help-block with-errors"></div>
                </div>
                <div class="form-group col-md-6 col-sm-6 text-primary">
                	<label for="municipioP" class="col-form-label">* MUNICIPIO</label>
                    <!--<select name="municipioP" id="municipioP" class="form-control form-control-sm mi_dir"></select> -->
                    <input name="municipioP" id="municipioP" class="form-control form-control-sm mi_dir" placeholder="Municipio" required>
                  	<div class="help-block with-errors"></div>
                </div>
            </div>
            <div class="row">
            	<div class="form-group col-md-6 col-sm-6 text-primary">
                	<label for="ciudadP" class="col-form-label">* CIUDAD</label>
                    <!--<select name="coloniaP" id="coloniaP" class="form-control form-control-sm mi_dir"></select> -->
                    <input name="ciudadP" id="ciudadP" class="form-control form-control-sm mi_dir" placeholder="Ciudad" required>
                	<div class="help-block with-errors"></div>
                </div>
            	<div class="form-group col-md-6 col-sm-6 text-primary">
                	<label for="coloniaP" class="col-form-label">* COLONIA</label>
                    <!--<select name="coloniaP" id="coloniaP" class="form-control form-control-sm mi_dir"></select> -->
                    <input name="coloniaP" id="coloniaP" class="form-control form-control-sm mi_dir" placeholder="Colonia" required>
                	<div class="help-block with-errors"></div>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-9 col-sm-9 text-primary">
                	<label for="calleS" class="col-form-label">* CALLE Y NÚMERO</label>
                    <input name="calleS" id="calleS" type="text" class="form-control form-control-sm mi_dir" placeholder="Calle y número" required>
                  	<div class="help-block with-errors"></div>
                </div>
                <div class="form-group col-md-3 col-sm-3 text-primary">
                	<label for="cpP" class="col-form-label">C.P.</label>
                    <!--<select name="cpP" id="cpP" class="form-control form-control-sm"></select> -->
                    <input name="cpP" id="cpP" type="text" class="form-control form-control-sm" placeholder="Código postal" required maxlength="5">
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
        <div class="tab-pane tap-pane-primary" id="t_horario" role="tabpanel" aria-labelledby="horario-tab"><br>
        	<div class="panel panel-primary">
              <!-- Default panel contents -->
              <div class="panel-heading">INDIQUE EL HORARIO LABORAL PARA CADA DÍA DE LA SEMANA</div>
              <!-- Table -->
              <table width="100%" height="" border="0" cellspacing="0" cellpadding="0" class="table-condensed table-striped">
                <tr align="left">
                  	<td width="50%"></td>
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
                    <td width="50%"></td>
                </tr>
                <tr align="left">
                  	<td width="50%"></td>
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
                    <td width="50%"></td>
                </tr>
                <tr align="left">
                  	<td width="50%"></td>
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
                    <td width="50%"></td>
                </tr>
                <tr align="left">
                  	<td width="50%"></td>
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
                    <td width="50%"></td>
                </tr>
                <tr align="left">
                  	<td width="50%"></td>
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
                    <td width="50%"></td>
                </tr>
                <tr align="left">
                  	<td width="50%"></td>
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
                    <td width="50%"></td>
                </tr>
                <tr align="left">
                  	<td width="50%"></td>
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
                    <td width="50%"></td>
                </tr>
                </table>
            </div>
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
                <th align="center" nowrap data-priority="4" style="white-space:nowrap;">LOGOTIPO</th>
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
        <div class="tab-pane tap-pane-primary" id="t_mone" role="tabpanel" aria-labelledby="sucursales-tab"><br>
			
        </div>
        <div class="tab-pane tap-pane-primary" id="t_m_consultas" role="tabpanel" aria-labelledby="m_consultas-tab"><br>
			<div class="panel panel-primary">
              <div class="panel-heading"><h3 class="panel-title">MEMBRETE PARA CONSULTAS MÉDICAS</h3></div>
              <div class="panel-body">
              	<p class="text-info" align="center">
                	El membrete se compone de dos archivos de imagen, uno para el encabezado y otro para el pié de página.
                </p>
                <input name="quees_membretes" type="hidden" class="required" id="quees_membretes" value="">
                <form action="" method="post" name="form-membretes0" id="form-membretes0" target="_self" style="height:100%;">
                <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table table-condensed">
                  <tr>
                    <td width="44%" nowrap valign="bottom" align="left">
                    <button type="button" class="btn btn-default btn-sm btn_encabezado" id="btn_encabezado1">ENCABEZADO <i class="fa fa-file-image-o" aria-hidden="true"></i></button>
                    <!-- The file input field used as target for the file upload widget -->
                    <input id="fileupload_membreteE1" type="file" name="files[]" class="fileupload_membrete hidden" style="color:transparent;"accept="image/jpg, image/jpeg, image/png">
                    <input name="nombre_membrete" type="hidden" class="required" id="nombre_membrete" value="">
                    <input name="tipo_membrete" type="hidden" class="required" id="tipo_membrete" value="">
                    <input name="aleat_membrete" type="hidden" class="required" id="aleat_membrete" value="">
                    </td>
                    <td width="44%">
                        <div class="input-group">
                          <span class="input-group-addon" id="basic-addon1">Margen</span>
                          <input type="number" class="form-control" placeholder="Margen de encabezado" id="margen_en1" name="margen_en1" aria-describedby="basic-addon1" step="0.01" min="0" max="6" value="2.8" style="text-align:right">
                          <span class="input-group-addon" id="basic-addon1">cm</span>
                        </div>
                    </td>
                    <td align="center" rowspan="3" valign="top">
                    	<select name="tam_mem1" id="tam_mem1" class="form-control form-control-sm" required>
                            <option value="1" selected>CARTA</option> <option value="2">MEDIA CARTA</option>
                        </select>
                        <div align="center" class="text-info">VISTA PREVIA</div>
                        <div style="width:210px; height:297px; border:1px none black;" id="hoja_membret">
                        <table height="100%" width="100%" border="1" cellspacing="2" cellpadding="2" id="table_membre1" bgcolor="#FFFFFF">
                          <tr height="10%" id="membrete_en1"> <td id="membrete_en">&nbsp;</td> </tr>
                          <tr height=""> <td>&nbsp;</td> </tr>
                          <tr height="8%" id="membrete_pi1"> <td id="membrete_pi">&nbsp;</td> </tr>
                        </table>
                        </div>
                        <div id="progressM"><div class="bar" style="width: 0%;"></div></div>
                    </td>
                  </tr>
                  <tr>
                    <td colspan="1" nowrap valign="top" align="left">
                    <button type="button" class="btn btn-default btn-sm btn_pie" id="btn_pie1">PIÉ DE PÁGINA <i class="fa fa-file-image-o" aria-hidden="true"></i></button>
                    <!-- The file input field used as target for the file upload widget -->
                    <input id="fileupload_membreteP1" type="file" name="files[]" class="fileupload_membrete hidden" style="color:transparent;"accept="image/jpg, image/jpeg, image/png">
                    </td>
                    <td width="44%">
                        <div class="input-group">
                          <span class="input-group-addon" id="basic-addon1">Margen</span>
                          <input type="number" class="form-control" placeholder="Margen de pié de página" id="margen_pi1" name="margen_pi1" aria-describedby="basic-addon1" step="0.01" min="0" max="6" value="2.3" style="text-align:right">
                          <span class="input-group-addon" id="basic-addon1">cm</span>
                        </div>
                    </td>
                  </tr>
                </table>
                </form>
              </div>
              <div class="panel-footer" align="right"><button type="button" class="btn btn-success btn-sm" id="btn_imprimir_mem1">IMPRIMIR HOJA <i class="fa fa-print" aria-hidden="true"></i></button></div>
            </div>
        </div>
        <div class="tab-pane tap-pane-primary membre" id="t_m_recetas" role="tabpanel" aria-labelledby="m_recetas-tab"><br>
			<div class="panel panel-primary">
              <div class="panel-heading"><h3 class="panel-title">MEMBRETE PARA RECETAS MÉDICAS</h3></div>
              <div class="panel-body">
              	<p class="text-info" align="center">
                	El membrete se compone de dos archivos de imagen, uno para el encabezado y otro para el pié de página.
                </p>
                <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table table-condensed">
                  <tr>
                    <td width="44%" nowrap valign="bottom" align="left">
                    <button type="button" class="btn btn-default btn-sm btn_encabezado" id="btn_encabezado2">ENCABEZADO <i class="fa fa-file-image-o" aria-hidden="true"></i></button>
                    <!-- The file input field used as target for the file upload widget -->
                    <input id="fileupload_membreteE2" type="file" name="files[]" class="fileupload_membrete hidden" style="color:transparent;"accept="image/jpg, image/jpeg, image/png">
                    </td>
                    <td width="44%">
                        <div class="input-group">
                          <span class="input-group-addon" id="basic-addon1">Margen</span>
                          <input type="number" class="form-control" placeholder="Margen de encabezado" id="margen_en2" name="margen_en2" aria-describedby="basic-addon2" step="0.01" min="0" max="6" value="2.8" style="text-align:right">
                          <span class="input-group-addon" id="basic-addon2">cm</span>
                        </div>
                    </td>
                    <td align="center" rowspan="3" valign="top">
                    	<select name="tam_mem2" id="tam_mem2" class="form-control form-control-sm" required>
                            <option value="1">CARTA</option> <option value="2" selected>MEDIA CARTA</option>
                        </select>
                        <div align="center" class="text-info">VISTA PREVIA</div>
                        <div style="width:210px; height:148px; border:1px none black;" id="hoja_membret2">
                        <table height="100%" width="100%" border="1" cellspacing="2" cellpadding="2" id="table_membre2" bgcolor="#FFFFFF">
                          <tr height="10%" id="membrete_en2"> <td id="membrete_en2">&nbsp;</td> </tr>
                          <tr height=""> <td>&nbsp;</td> </tr>
                          <tr height="8%" id="membrete_pi2"> <td id="membrete_pi2">&nbsp;</td> </tr>
                        </table>
                        </div>
                        <div id="progressM"><div class="bar" style="width: 0%;"></div></div>
                    </td>
                  </tr>
                  <tr>
                    <td colspan="1" nowrap valign="top" align="left">
                    <button type="button" class="btn btn-default btn-sm btn_pie" id="btn_pie2">PIÉ DE PÁGINA <i class="fa fa-file-image-o" aria-hidden="true"></i></button>
                    <!-- The file input field used as target for the file upload widget -->
                    <input id="fileupload_membreteP2" type="file" name="files[]" class="fileupload_membrete hidden" style="color:transparent;"accept="image/jpg, image/jpeg, image/png">
                    </td>
                    <td width="44%">
                        <div class="input-group">
                          <span class="input-group-addon" id="basic-addon2">Margen</span>
                          <input type="number" class="form-control" placeholder="Margen de pié de página" id="margen_pi2" name="margen_pi2" aria-describedby="basic-addon2" step="0.01" min="0" max="6" value="2.3" style="text-align:right">
                          <span class="input-group-addon" id="basic-addon2">cm</span>
                        </div>
                    </td>
                  </tr>
                </table>
              </div>
              <div class="panel-footer" align="right"><button type="button" class="btn btn-success btn-sm" id="btn_imprimir_mem2">IMPRIMIR HOJA <i class="fa fa-print" aria-hidden="true"></i></button></div>
            </div>
        </div>
        <div class="tab-pane tap-pane-primary membre" id="t_m_labo" role="tabpanel" aria-labelledby="m_labo-tab"><br>
			<div class="panel panel-primary">
              <div class="panel-heading"><h3 class="panel-title">MEMBRETE PARA ESTUDIOS DE LABORATORIO</h3></div>
              <div class="panel-body">
              	<p class="text-info" align="center">
                	El membrete se compone de dos archivos de imagen, uno para el encabezado y otro para el pié de página.
                </p>
                <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table table-condensed">
                  <tr>
                    <td width="44%" nowrap valign="bottom" align="left">
                    <button type="button" class="btn btn-default btn-sm btn_encabezado" id="btn_encabezado3">ENCABEZADO <i class="fa fa-file-image-o" aria-hidden="true"></i></button>
                    <!-- The file input field used as target for the file upload widget -->
                    <input id="fileupload_membreteE3" type="file" name="files[]" class="fileupload_membrete hidden" style="color:transparent;"accept="image/jpg, image/jpeg, image/png">
                    </td>
                    <td width="44%">
                        <div class="input-group">
                          <span class="input-group-addon" id="basic-addon1">Margen</span>
                          <input type="number" class="form-control" placeholder="Margen de encabezado" id="margen_en3" name="margen_en3" aria-describedby="basic-addon3" step="0.01" min="0" max="6" value="2.8" style="text-align:right">
                          <span class="input-group-addon" id="basic-addon3">cm</span>
                        </div>
                    </td>
                    <td align="center" rowspan="3" valign="top">
                    	<select name="tam_mem3" id="tam_mem3" class="form-control form-control-sm" required>
                            <option value="1" selected>CARTA</option> <option value="2">MEDIA CARTA</option>
                        </select>
                        <div align="center" class="text-info">VISTA PREVIA</div>
                        <div style="width:210px; height:297px; border:1px none black;" id="hoja_membret3">
                        <table height="100%" width="100%" border="1" cellspacing="2" cellpadding="2" id="table_membre3" bgcolor="#FFFFFF">
                          <tr height="10%" id="membrete_en3"> <td id="membrete_en3">&nbsp;</td> </tr>
                          <tr height=""> <td>&nbsp;</td> </tr>
                          <tr height="8%" id="membrete_pi3"> <td id="membrete_pi3">&nbsp;</td> </tr>
                        </table>
                        </div>
                        <div id="progressM"><div class="bar" style="width: 0%;"></div></div>
                    </td>
                  </tr>
                  <tr>
                    <td colspan="1" nowrap valign="top" align="left">
                    <button type="button" class="btn btn-default btn-sm btn_pie" id="btn_pie3">PIÉ DE PÁGINA <i class="fa fa-file-image-o" aria-hidden="true"></i></button>
                    <!-- The file input field used as target for the file upload widget -->
                    <input id="fileupload_membreteP3" type="file" name="files[]" class="fileupload_membrete hidden" style="color:transparent;"accept="image/jpg, image/jpeg, image/png">
                    </td>
                    <td width="44%">
                        <div class="input-group">
                          <span class="input-group-addon" id="basic-addon3">Margen</span>
                          <input type="number" class="form-control" placeholder="Margen de pié de página" id="margen_pi3" name="margen_pi3" aria-describedby="basic-addon3" step="0.01" min="0" max="6" value="2.3" style="text-align:right">
                          <span class="input-group-addon" id="basic-addon3">cm</span>
                        </div>
                    </td>
                  </tr>
                </table>
              </div>
              <div class="panel-footer" align="right"><button type="button" class="btn btn-success btn-sm" id="btn_imprimir_mem3">IMPRIMIR HOJA <i class="fa fa-print" aria-hidden="true"></i></button></div>
            </div>
        </div>
        <div class="tab-pane tap-pane-primary membre" id="t_m_imagen" role="tabpanel" aria-labelledby="m_imagen-tab"><br>
			<div class="panel panel-primary">
              <div class="panel-heading"><h3 class="panel-title">MEMBRETE PARA ESTUDIOS DE IMAGEN</h3></div>
              <div class="panel-body">
              	<p class="text-info" align="center">
                	El membrete se compone de dos archivos de imagen, uno para el encabezado y otro para el pié de página.
                </p>
                <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table table-condensed">
                  <tr>
                    <td width="44%" nowrap valign="bottom" align="left">
                    <button type="button" class="btn btn-default btn-sm btn_encabezado" id="btn_encabezado4">ENCABEZADO <i class="fa fa-file-image-o" aria-hidden="true"></i></button>
                    <!-- The file input field used as target for the file upload widget -->
                    <input id="fileupload_membreteE4" type="file" name="files[]" class="fileupload_membrete hidden" style="color:transparent;"accept="image/jpg, image/jpeg, image/png">
                    </td>
                    <td width="44%">
                        <div class="input-group">
                          <span class="input-group-addon" id="basic-addon4">Margen</span>
                          <input type="number" class="form-control" placeholder="Margen de encabezado" id="margen_en4" name="margen_en4" aria-describedby="basic-addon4" step="0.01" min="0" max="6" value="2.8" style="text-align:right">
                          <span class="input-group-addon" id="basic-addon4">cm</span>
                        </div>
                    </td>
                    <td align="center" rowspan="3" valign="top">
                    	<select name="tam_mem4" id="tam_mem4" class="form-control form-control-sm" required>
                            <option value="1" selected>CARTA</option> <option value="2">MEDIA CARTA</option>
                        </select>
                        <div align="center" class="text-info">VISTA PREVIA</div>
                        <div style="width:210px; height:297px; border:1px none black;" id="hoja_membret4">
                        <table height="100%" width="100%" border="1" cellspacing="2" cellpadding="2" id="table_membre4" bgcolor="#FFFFFF">
                          <tr height="10%" id="membrete_en4"> <td id="membrete_en4">&nbsp;</td> </tr>
                          <tr height=""> <td>&nbsp;</td> </tr>
                          <tr height="8%" id="membrete_pi4"> <td id="membrete_pi4">&nbsp;</td> </tr>
                        </table>
                        </div>
                        <div id="progressM"><div class="bar" style="width: 0%;"></div></div>
                    </td>
                  </tr>
                  <tr>
                    <td colspan="1" nowrap valign="top" align="left">
                    <button type="button" class="btn btn-default btn-sm btn_pie" id="btn_pie4">PIÉ DE PÁGINA <i class="fa fa-file-image-o" aria-hidden="true"></i></button>
                    <!-- The file input field used as target for the file upload widget -->
                    <input id="fileupload_membreteP4" type="file" name="files[]" class="fileupload_membrete hidden" style="color:transparent;"accept="image/jpg, image/jpeg, image/png">
                    </td>
                    <td width="44%">
                        <div class="input-group">
                          <span class="input-group-addon" id="basic-addon4">Margen</span>
                          <input type="number" class="form-control" placeholder="Margen de pié de página" id="margen_pi4" name="margen_pi4" aria-describedby="basic-addon4" step="0.01" min="0" max="6" value="2.3" style="text-align:right">
                          <span class="input-group-addon" id="basic-addon4">cm</span>
                        </div>
                    </td>
                  </tr>
                </table>
              </div>
              <div class="panel-footer" align="right"><button type="button" class="btn btn-success btn-sm" id="btn_imprimir_mem4">IMPRIMIR HOJA <i class="fa fa-print" aria-hidden="true"></i></button></div>
            </div>
        </div>
        <div class="tab-pane tap-pane-primary membre" id="t_m_endo" role="tabpanel" aria-labelledby="m_endo-tab"><br>
			<div class="panel panel-primary">
              <div class="panel-heading"><h3 class="panel-title">MEMBRETE PARA ESTUDIOS DE ENDOSCOPÍA</h3></div>
              <div class="panel-body">
              	<p class="text-info" align="center">
                	El membrete se compone de dos archivos de imagen, uno para el encabezado y otro para el pié de página.
                </p>
                <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table table-condensed">
                  <tr>
                    <td width="44%" nowrap valign="bottom" align="left">
                    <button type="button" class="btn btn-default btn-sm btn_encabezado" id="btn_encabezado5">ENCABEZADO <i class="fa fa-file-image-o" aria-hidden="true"></i></button>
                    <!-- The file input field used as target for the file upload widget -->
                    <input id="fileupload_membreteE5" type="file" name="files[]" class="fileupload_membrete hidden" style="color:transparent;"accept="image/jpg, image/jpeg, image/png">
                    </td>
                    <td width="44%">
                        <div class="input-group">
                          <span class="input-group-addon" id="basic-addon5">Margen</span>
                          <input type="number" class="form-control" placeholder="Margen de encabezado" id="margen_en5" name="margen_en5" aria-describedby="basic-addon5" step="0.01" min="0" max="6" value="2.8" style="text-align:right">
                          <span class="input-group-addon" id="basic-addon5">cm</span>
                        </div>
                    </td>
                    <td align="center" rowspan="3" valign="top">
                    	<select name="tam_mem5" id="tam_mem5" class="form-control form-control-sm" required>
                            <option value="1" selected>CARTA</option> <option value="2">MEDIA CARTA</option>
                        </select>
                        <div align="center" class="text-info">VISTA PREVIA</div>
                        <div style="width:210px; height:297px; border:1px none black;" id="hoja_membret5">
                        <table height="100%" width="100%" border="1" cellspacing="2" cellpadding="2" id="table_membre5" bgcolor="#FFFFFF">
                          <tr height="10%" id="membrete_en5"> <td id="membrete_en5">&nbsp;</td> </tr>
                          <tr height=""> <td>&nbsp;</td> </tr>
                          <tr height="8%" id="membrete_pi5"> <td id="membrete_pi5">&nbsp;</td> </tr>
                        </table>
                        </div>
                        <div id="progressM"><div class="bar" style="width: 0%;"></div></div>
                    </td>
                  </tr>
                  <tr>
                    <td colspan="1" nowrap valign="top" align="left">
                    <button type="button" class="btn btn-default btn-sm btn_pie" id="btn_pie5">PIÉ DE PÁGINA <i class="fa fa-file-image-o" aria-hidden="true"></i></button>
                    <!-- The file input field used as target for the file upload widget -->
                    <input id="fileupload_membreteP5" type="file" name="files[]" class="fileupload_membrete hidden" style="color:transparent;"accept="image/jpg, image/jpeg, image/png">
                    </td>
                    <td width="44%">
                        <div class="input-group">
                          <span class="input-group-addon" id="basic-addon5">Margen</span>
                          <input type="number" class="form-control" placeholder="Margen de pié de página" id="margen_pi5" name="margen_pi5" aria-describedby="basic-addon5" step="0.01" min="0" max="6" value="2.3" style="text-align:right">
                          <span class="input-group-addon" id="basic-addon5">cm</span>
                        </div>
                    </td>
                  </tr>
                </table>
              </div>
              <div class="panel-footer" align="right"><button type="button" class="btn btn-success btn-sm" id="btn_imprimir_mem5">IMPRIMIR HOJA <i class="fa fa-print" aria-hidden="true"></i></button></div>
            </div>
        </div>
        <div class="tab-pane tap-pane-primary membre" id="t_m_ultra" role="tabpanel" aria-labelledby="m_ultra-tab"><br>
			<div class="panel panel-primary">
              <div class="panel-heading"><h3 class="panel-title">MEMBRETE PARA ESTUDIOS DE ULTRASONIDO</h3></div>
              <div class="panel-body">
              	<p class="text-info" align="center">
                	El membrete se compone de dos archivos de imagen, uno para el encabezado y otro para el pié de página.
                </p>
                <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table table-condensed">
                  <tr>
                    <td width="44%" nowrap valign="bottom" align="left">
                    <button type="button" class="btn btn-default btn-sm btn_encabezado" id="btn_encabezado6">ENCABEZADO <i class="fa fa-file-image-o" aria-hidden="true"></i></button>
                    <!-- The file input field used as target for the file upload widget -->
                    <input id="fileupload_membreteE6" type="file" name="files[]" class="fileupload_membrete hidden" style="color:transparent;"accept="image/jpg, image/jpeg, image/png">
                    </td>
                    <td width="44%">
                        <div class="input-group">
                          <span class="input-group-addon" id="basic-addon6">Margen</span>
                          <input type="number" class="form-control" placeholder="Margen de encabezado" id="margen_en6" name="margen_en6" aria-describedby="basic-addon6" step="0.01" min="0" max="6" value="2.8" style="text-align:right">
                          <span class="input-group-addon" id="basic-addon6">cm</span>
                        </div>
                    </td>
                    <td align="center" rowspan="3" valign="top">
                    	<select name="tam_mem6" id="tam_mem6" class="form-control form-control-sm" required>
                            <option value="1" selected>CARTA</option> <option value="2">MEDIA CARTA</option>
                        </select>
                        <div align="center" class="text-info">VISTA PREVIA</div>
                        <div style="width:210px; height:297px; border:1px none black;" id="hoja_membret6">
                        <table height="100%" width="100%" border="1" cellspacing="2" cellpadding="2" id="table_membre6" bgcolor="#FFFFFF">
                          <tr height="10%" id="membrete_en6"> <td id="membrete_en6">&nbsp;</td> </tr>
                          <tr height=""> <td>&nbsp;</td> </tr>
                          <tr height="8%" id="membrete_pi6"> <td id="membrete_pi6">&nbsp;</td> </tr>
                        </table>
                        </div>
                        <div id="progressM"><div class="bar" style="width: 0%;"></div></div>
                    </td>
                  </tr>
                  <tr>
                    <td colspan="1" nowrap valign="top" align="left">
                    <button type="button" class="btn btn-default btn-sm btn_pie" id="btn_pie6">PIÉ DE PÁGINA <i class="fa fa-file-image-o" aria-hidden="true"></i></button>
                    <!-- The file input field used as target for the file upload widget -->
                    <input id="fileupload_membreteP6" type="file" name="files[]" class="fileupload_membrete hidden" style="color:transparent;"accept="image/jpg, image/jpeg, image/png">
                    </td>
                    <td width="44%">
                        <div class="input-group">
                          <span class="input-group-addon" id="basic-addon6">Margen</span>
                          <input type="number" class="form-control" placeholder="Margen de pié de página" id="margen_pi6" name="margen_pi6" aria-describedby="basic-addon6" step="0.01" min="0" max="6" value="2.3" style="text-align:right">
                          <span class="input-group-addon" id="basic-addon6">cm</span>
                        </div>
                    </td>
                  </tr>
                </table>
              </div>
              <div class="panel-footer" align="right"><button type="button" class="btn btn-success btn-sm" id="btn_imprimir_mem6">IMPRIMIR HOJA <i class="fa fa-print" aria-hidden="true"></i></button></div>
            </div>
        </div>
        <div class="tab-pane tap-pane-primary membre" id="t_m_colpo" role="tabpanel" aria-labelledby="m_colpo-tab"><br>
			<div class="panel panel-primary">
              <div class="panel-heading"><h3 class="panel-title">MEMBRETE PARA ESTUDIOS DE COLPOSCOPÍA</h3></div>
              <div class="panel-body">
              	<p class="text-info" align="center">
                	El membrete se compone de dos archivos de imagen, uno para el encabezado y otro para el pié de página.
                </p>
                <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table table-condensed">
                  <tr>
                    <td width="44%" nowrap valign="bottom" align="left">
                    <button type="button" class="btn btn-default btn-sm btn_encabezado" id="btn_encabezado7">ENCABEZADO <i class="fa fa-file-image-o" aria-hidden="true"></i></button>
                    <!-- The file input field used as target for the file upload widget -->
                    <input id="fileupload_membreteE7" type="file" name="files[]" class="fileupload_membrete hidden" style="color:transparent;"accept="image/jpg, image/jpeg, image/png">
                    </td>
                    <td width="44%">
                        <div class="input-group">
                          <span class="input-group-addon" id="basic-addon7">Margen</span>
                          <input type="number" class="form-control" placeholder="Margen de encabezado" id="margen_en7" name="margen_en7" aria-describedby="basic-addon7" step="0.01" min="0" max="6" value="2.8" style="text-align:right">
                          <span class="input-group-addon" id="basic-addon7">cm</span>
                        </div>
                    </td>
                    <td align="center" rowspan="3" valign="top">
                    	<select name="tam_mem7" id="tam_mem7" class="form-control form-control-sm" required>
                            <option value="1" selected>CARTA</option> <option value="2">MEDIA CARTA</option>
                        </select>
                        <div align="center" class="text-info">VISTA PREVIA</div>
                        <div style="width:210px; height:297px; border:1px none black;" id="hoja_membret7">
                        <table height="100%" width="100%" border="1" cellspacing="2" cellpadding="2" id="table_membre7" bgcolor="#FFFFFF">
                          <tr height="10%" id="membrete_en7"> <td id="membrete_en7">&nbsp;</td> </tr>
                          <tr height=""> <td>&nbsp;</td> </tr>
                          <tr height="8%" id="membrete_pi7"> <td id="membrete_pi7">&nbsp;</td> </tr>
                        </table>
                        </div>
                        <div id="progressM"><div class="bar" style="width: 0%;"></div></div>
                    </td>
                  </tr>
                  <tr>
                    <td colspan="1" nowrap valign="top" align="left">
                    <button type="button" class="btn btn-default btn-sm btn_pie" id="btn_pie7">PIÉ DE PÁGINA <i class="fa fa-file-image-o" aria-hidden="true"></i></button>
                    <!-- The file input field used as target for the file upload widget -->
                    <input id="fileupload_membreteP7" type="file" name="files[]" class="fileupload_membrete hidden" style="color:transparent;"accept="image/jpg, image/jpeg, image/png">
                    </td>
                    <td width="44%">
                        <div class="input-group">
                          <span class="input-group-addon" id="basic-addon7">Margen</span>
                          <input type="number" class="form-control" placeholder="Margen de pié de página" id="margen_pi7" name="margen_pi7" aria-describedby="basic-addon7" step="0.01" min="0" max="6" value="2.3" style="text-align:right">
                          <span class="input-group-addon" id="basic-addon7">cm</span>
                        </div>
                    </td>
                  </tr>
                </table>
              </div>
              <div class="panel-footer" align="right"><button type="button" class="btn btn-success btn-sm" id="btn_imprimir_mem7">IMPRIMIR HOJA <i class="fa fa-print" aria-hidden="true"></i></button></div>
            </div>
        </div>
        <div class="tab-pane tap-pane-primary membre" id="t_m_servi" role="tabpanel" aria-labelledby="m_servi-tab"><br>
			<div class="panel panel-primary">
              <div class="panel-heading"><h3 class="panel-title">MEMBRETE PARA SERVICIOS MÉDICOS</h3></div>
              <div class="panel-body">
              	<p class="text-info" align="center">
                	El membrete se compone de dos archivos de imagen, uno para el encabezado y otro para el pié de página.
                </p>
                <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table table-condensed">
                  <tr>
                    <td width="44%" nowrap valign="bottom" align="left">
                    <button type="button" class="btn btn-default btn-sm btn_encabezado" id="btn_encabezado8">ENCABEZADO <i class="fa fa-file-image-o" aria-hidden="true"></i></button>
                    <!-- The file input field used as target for the file upload widget -->
                    <input id="fileupload_membreteE8" type="file" name="files[]" class="fileupload_membrete hidden" style="color:transparent;"accept="image/jpg, image/jpeg, image/png">
                    </td>
                    <td width="44%">
                        <div class="input-group">
                          <span class="input-group-addon" id="basic-addon8">Margen</span>
                          <input type="number" class="form-control" placeholder="Margen de encabezado" id="margen_en8" name="margen_en8" aria-describedby="basic-addon8" step="0.01" min="0" max="6" value="2.8" style="text-align:right">
                          <span class="input-group-addon" id="basic-addon8">cm</span>
                        </div>
                    </td>
                    <td align="center" rowspan="3" valign="top">
                    	<select name="tam_mem8" id="tam_mem8" class="form-control form-control-sm" required>
                            <option value="1" selected>CARTA</option> <option value="2">MEDIA CARTA</option>
                        </select>
                        <div align="center" class="text-info">VISTA PREVIA</div>
                        <div style="width:210px; height:297px; border:1px none black;" id="hoja_membret8">
                        <table height="100%" width="100%" border="1" cellspacing="2" cellpadding="2" id="table_membre8" bgcolor="#FFFFFF">
                          <tr height="10%" id="membrete_en8"> <td id="membrete_en8">&nbsp;</td> </tr>
                          <tr height=""> <td>&nbsp;</td> </tr>
                          <tr height="8%" id="membrete_pi8"> <td id="membrete_pi8">&nbsp;</td> </tr>
                        </table>
                        </div>
                        <div id="progressM"><div class="bar" style="width: 0%;"></div></div>
                    </td>
                  </tr>
                  <tr>
                    <td colspan="1" nowrap valign="top" align="left">
                    <button type="button" class="btn btn-default btn-sm btn_pie" id="btn_pie8">PIÉ DE PÁGINA <i class="fa fa-file-image-o" aria-hidden="true"></i></button>
                    <!-- The file input field used as target for the file upload widget -->
                    <input id="fileupload_membreteP8" type="file" name="files[]" class="fileupload_membrete hidden" style="color:transparent;"accept="image/jpg, image/jpeg, image/png">
                    </td>
                    <td width="44%">
                        <div class="input-group">
                          <span class="input-group-addon" id="basic-addon8">Margen</span>
                          <input type="number" class="form-control" placeholder="Margen de pié de página" id="margen_pi8" name="margen_pi8" aria-describedby="basic-addon8" step="0.01" min="0" max="6" value="2.3" style="text-align:right">
                          <span class="input-group-addon" id="basic-addon8">cm</span>
                        </div>
                    </td>
                  </tr>
                </table>
              </div>
              <div class="panel-footer" align="right"><button type="button" class="btn btn-success btn-sm" id="btn_imprimir_mem8">IMPRIMIR HOJA <i class="fa fa-print" aria-hidden="true"></i></button></div>
            </div>
        </div>
        <div class="tab-pane tap-pane-primary" id="t_f_notas" role="tabpanel" aria-labelledby="f_notas-tab"><br>
			<div class="panel panel-primary">
              <div class="panel-heading"><h3 class="panel-title">FORMATO BASE PARA IMPRESIÓN DE NOTAS MÉDICAS</h3></div>
              <div class="panel-body">
              	<table width="100%" height="100%" border="1" class="table-condensed table-bordered">
                      <tr>
                        <td>
                        	<select name="inserta_algo" id="inserta_algo" onChange="insertAtCaret(this.value);return false;" class="form-control input-sm insers">
                        	</select>
                        </td>
                      </tr>
                      <tr id="contieneET1" align="left">
                      	<td colspan="1">
                            <input type="text" placeholder="Diseña el formato" id="input" name="input" style="height:90%; resize:none; vertical-align:top;" >
                    	</td>
                   	  </tr>
                </table>
              </div>
            </div>
        </div>
        <div class="tab-pane tap-pane-primary" id="t_f_recetas" role="tabpanel" aria-labelledby="f_recetas-tab"><br>
			<div class="panel panel-primary">
              <div class="panel-heading"><h3 class="panel-title">FORMATO BASE PARA IMPRESIÓN DE RECETAS MÉDICAS</h3></div>
              <div class="panel-body">
              	<table width="100%" height="100%" border="1" class="table-condensed table-bordered">
                      <tr>
                        <td>
                        	<select name="inserta_algo2" id="inserta_algo2" onChange="insertAtCaret2(this.value);return false;" class="form-control input-sm insers">
                        	</select>
                        </td>
                      </tr>
                      <tr id="contieneET2" align="left">
                      	<td colspan="1">
                            <input type="text" placeholder="Diseña el formato" id="input1" name="input1" style="height:90%; resize:none; vertical-align:top;" >
                    	</td>
                   	  </tr>
                </table>
              </div>
            </div>
        </div>
        <div class="tab-pane tap-pane-primary" id="t_f_labo" role="tabpanel" aria-labelledby="f_labo-tab"><br>
			<div class="panel panel-primary">
              <div class="panel-heading"><h3 class="panel-title">FORMATO BASE PARA IMPRESIÓN DE ESTUDIOS DE LABORATORIO</h3></div>
              <div class="panel-body">
              	<table width="100%" height="100%" border="1" class="table-condensed table-bordered">
                      <tr>
                        <td>
                        	<select name="inserta_algo4" id="inserta_algo4" onChange="insertAtCaret4(this.value);return false;" class="form-control input-sm insers">
                        	</select>
                        </td>
                      </tr>
                      <tr id="contieneET3" align="left">
                      	<td colspan="1">
                        	<input type="text" placeholder="Diseña el formato" id="input2" name="input2" style="height:90%; resize:none; vertical-align:top;" >
                    	</td>
                   	  </tr>
                </table>
              </div>
            </div>
        </div>
        <div class="tab-pane tap-pane-primary" id="t_f_imagen" role="tabpanel" aria-labelledby="f_imagen-tab"><br>
			<div class="panel panel-primary">
              <div class="panel-heading"><h3 class="panel-title">FORMATO BASE PARA IMPRESIÓN DE ESTUDIOS DE IMAGENOLOGÍA</h3></div>
              <div class="panel-body">
              	<table width="100%" height="100%" border="1" class="table-condensed table-bordered">
                      <tr>
                        <td>
                        	<select name="inserta_algo6" id="inserta_algo6" onChange="insertAtCaret6(this.value);return false;" class="form-control input-sm insers">
                        	</select>
                        </td>
                      </tr>
                      <tr id="contieneET4" align="left">
                      	<td colspan="1">
                        	<input type="text" placeholder="Diseña el formato" id="input3" name="input3" style="height:90%; resize:none; vertical-align:top;" >
                    	</td>
                   	  </tr>
                </table>
              </div>
            </div>
        </div>
        <div class="tab-pane tap-pane-primary" id="t_f_endo" role="tabpanel" aria-labelledby="f_endo-tab"><br>
			<div class="panel panel-primary">
              <div class="panel-heading"><h3 class="panel-title">FORMATO BASE PARA IMPRESIÓN DE ESTUDIOS DE ENDOSCOPÍA</h3></div>
              <div class="panel-body">
              	<table width="100%" height="100%" border="1" class="table-condensed table-bordered">
                      <tr>
                        <td>
                        	<select name="inserta_algo8" id="inserta_algo8" onChange="insertAtCaret8(this.value);return false;" class="form-control input-sm insers">
                        	</select>
                        </td>
                      </tr>
                      <tr id="contieneET5" align="left">
                      	<td colspan="1">
                            <input type="text" placeholder="Diseña el formato" id="input4" name="input4" style="resize:none; vertical-align:top;" >
                    	</td>
                   	  </tr>
                </table>
              </div>
            </div>
        </div>
        <div class="tab-pane tap-pane-primary" id="t_f_ultra" role="tabpanel" aria-labelledby="f_ultra-tab"><br>
			<div class="panel panel-primary">
              <div class="panel-heading"><h3 class="panel-title">FORMATO BASE PARA IMPRESIÓN DE ESTUDIOS DE ULTRASONIDO</h3></div>
              <div class="panel-body">
              	<table width="100%" height="100%" border="1" class="table-condensed table-bordered">
                      <tr>
                        <td>
                        	<select name="inserta_algo10" id="inserta_algo10" onChange="insertAtCaret10(this.value);return false;" class="form-control input-sm insers">
                        	</select>
                        </td>
                      </tr>
                      <tr id="contieneET6" align="left">
                      	<td colspan="1">
                            <input type="text" placeholder="Diseña el formato" id="input5" name="input5" style="resize:none; vertical-align:top;" >
                    	</td>
                   	  </tr>
                </table>
              </div>
            </div>
        </div>
        <div class="tab-pane tap-pane-primary" id="t_f_colpo" role="tabpanel" aria-labelledby="f_colpo-tab"><br>
			<div class="panel panel-primary">
              <div class="panel-heading"><h3 class="panel-title">FORMATO BASE PARA IMPRESIÓN DE ESTUDIOS DE COLPOSCOPÍA</h3></div>
              <div class="panel-body">
              	<table width="100%" height="100%" border="1" class="table-condensed table-bordered">
                      <tr>
                        <td>
                        	<select name="inserta_algo12" id="inserta_algo12" onChange="insertAtCaret12(this.value);return false;" class="form-control input-sm insers">
                        	</select>
                        </td>
                      </tr>
                      <tr id="contieneET7" align="left">
                      	<td colspan="1">
                            <input type="text" placeholder="Diseña el formato" id="input6" name="input6" style="resize:none; vertical-align:top;" >
                    	</td>
                   	  </tr>
                </table>
              </div>
            </div>
        </div>
        <div class="tab-pane tap-pane-primary" id="t_f_servi" role="tabpanel" aria-labelledby="f_servi-tab"><br>
			<div class="panel panel-primary">
              <div class="panel-heading"><h3 class="panel-title">FORMATO BASE PARA IMPRESIÓN DE SERVICIOS MÉDICOS</h3></div>
              <div class="panel-body">
              	<table width="100%" height="100%" border="1" class="table-condensed table-bordered">
                      <tr>
                        <td>
                        	<select name="inserta_algo14" id="inserta_algo14" onChange="insertAtCaret14(this.value);return false;" class="form-control input-sm insers">
                        	</select>
                        </td>
                      </tr>
                      <tr id="contieneET8" align="left">
                      	<td colspan="1">
                            <input type="text" placeholder="Diseña el formato" id="input7" name="input7" style="resize:none; vertical-align:top;" >
                    	</td>
                   	  </tr>
                </table>
              </div>
            </div>
        </div>
    </div>  
</form>
  </div>
</div>
</div>