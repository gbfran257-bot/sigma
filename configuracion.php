<?php
	include_once 'recursos/session.php';
	include_once 'Connections/database.php';
	include_once 'recursos/utilities.php';
	include_once 'recursos/datauser.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="SISTEMA DE EXPEDIENTE CLÍNICO ELECTRÓNICO">
    <meta name="author" content="ING EMMANUEL ANZURES BAUTISTA">
    
    <title>SISTEMA - CONFIGURACIÓN</title>
    
    <link rel="shortcut icon" href="imagenes/favicon.ico" type="image/x-icon">
	<link rel="icon" href="imagenes/favicon.ico" type="image/x-icon">
    
    <!-- Mainly scripts -->
	<script src="js/jquery-3.2.1.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <script src="bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
    <script src="bootstrap-datepicker/locales/bootstrap-datepicker.es.min.js"></script>
    <script src="js/plugins/metisMenu/jquery.metisMenu.js"></script>
    <script src="js/plugins/slimscroll/jquery.slimscroll.min.js"></script>
    <!-- Custom and plugin javascript -->
    <script src="js/inspinia.js"></script>
    <script src="js/plugins/pace/pace.min.js"></script>
    <script src="DataTables-1.10.13/media/js/jquery.dataTables.min.js"></script>
    <script src="DataTables-1.10.13/media/js/dataTables.bootstrap.min.js"></script>
    <script src="DataTables-1.10.13/extensions/Select/js/dataTables.select.min.js"></script>
    <script src="bootstrap-validator/js/validator.js"></script>
    <script src="sweetalert/dist/sweetalert.min.js"></script>
    <script src="chosen/chosen.jquery.js" type="text/javascript"></script>
    <script src="funciones/js/jquery.media.js" type="text/javascript"></script>
    <script src="funciones/js/jquery.printElement.min.js" type="text/javascript"></script>
    <script src="funciones/js/jquery.sparkline.min.js" type="text/javascript"></script>
    <script src='tinymce/tinymce.min.js'></script>
    <!-- Input Mask-->
    <script src="jasny-bootstrap/js/jasny-bootstrap.min.js"></script> 
    <!-- Mis funciones -->
    <script src="funciones/js/inicio.js"></script>
    <script src="funciones/js/caracteres.js"></script>
    <script src="funciones/js/calcula_edad.js"></script>
    <script src="funciones/js/stdlib.js"></script>
    <script src="funciones/js/bs-modal-fullscreen.js"></script>
    
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="bootstrap/css/bootstrap-theme.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <link href="DataTables-1.10.13/media/css/dataTables.bootstrap.min.css" rel="stylesheet">
    <link href="DataTables-1.10.13/extensions/Scroller/css/scroller.bootstrap.min.css" rel="stylesheet">
    <link href="DataTables-1.10.13/extensions/Select/css/select.bootstrap.min.css" rel="stylesheet">
    <link href="bootstrap-datepicker/css/bootstrap-datepicker.css" rel="stylesheet">
    <link href="sweetalert/dist/sweetalert.css" rel="stylesheet">
    <link rel="stylesheet" href="chosen/chosen.css">
    <link rel="stylesheet" href="chosen/chosen-bootstrap.css">
    <link href="jasny-bootstrap/css/jasny-bootstrap.min.css" rel="stylesheet">
</head>
<?php include_once 'partes/header.php'; ?>
<!-- Contenido -->
<div class="hidden" id="dpa_imprimir"></div><div class="hidden" id="dpa_imprimir1"></div>
<div class="hidden" id="dpa_imprimir2"></div><div class="hidden" id="dpa_imprimir3"></div>
<div class="hidden" id="dpa_imprimir4"></div><div class="hidden" id="dpa_imprimir5"></div>
<div class="hidden" id="dpa_imprimir6"></div><div class="hidden" id="dpa_imprimir7"></div>

<div id="div_tabla_pr" style="border:1px none red; vertical-align:top; margin-top:0px; padding:10px 10px 0px 10px;" class=" white-bg" align="">
	
    <table border="0" cellpadding="0" cellspacing="0">
    	<tr>
        	<td width="99%">
            	<ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item active" id="tab_mi_grales">
                        <a class="nav-link" id="generales-tab" data-toggle="tab" href="#t_generales" role="tab" aria-controls="generales" aria-expanded="true">GENERALES</a>
                    </li>
                    <li class="nav-item" id="tab_mi_mem">
                        <a class="nav-link" id="membresia-tab" data-toggle="tab" href="#t_membresia" role="tab" aria-controls="membresia">MEMBRESÍA</a>
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
					<li class="nav-item" id="tab_mi_mem">
                        <a class="nav-link" id="fiscales-tab" data-toggle="tab" href="#t_fiscales" role="tab" aria-controls="fiscales">FISCALES</a>
                    </li>
                </ul>
            </td>
            <td>
            	<button type="submit" class="btn btn-success" form="form-registro">Guardar</button>
            </td>
        </tr>
    </table>
   
    <form class="" method="post" name="form-registro" id="form-registro" data-toggle="validator" role="form">
    <input name="id_u_cf" id="id_u_cf" type="hidden" value="<?php echo $_SESSION['id']; ?>">
    <div class="tab-content" id="myTabContent">
    	<div class="tab-pane active tap-pane-primary" id="t_generales" role="tabpanel" aria-labelledby="generales-tab"><br>
        	<div class="row">
                <div class="form-group col-md-6 col-sm-6 text-primary">
                	<label for="nombreS" class="col-form-label">* NOMBRE DE LA CARPETA DEL SISTEMA</label>
                    <input name="nombreS" id="nombreS" type="text" class="form-control form-control-sm" required placeholder="">
                	<div class="help-block with-errors"></div>
                </div>
                <div class="form-group col-md-6 col-sm-6 text-primary">
                	<label for="nombreDB" class="col-form-label">* NOMBRE DE LA BASE DE DATOS</label>
                    <input name="nombreDB" id="nombreDB" type="text" class="form-control form-control-sm" required placeholder="">
                	<div class="help-block with-errors"></div>
                </div>
            </div>
            <div class="row">
            	<div class="form-group col-md-6 col-sm-6 text-primary">
                	<label for="link_local_s" class="col-form-label">* DIRECCIÓN LOCAL DEL SISTEMA</label>
                    <input name="link_local_s" id="link_local_s" type="text" class="form-control form-control-sm" placeholder="Link para accesar al sistema de forma local" value="http://ip_local:8888/" required>
                	<div class="help-block with-errors"></div>
                </div>
                <div class="form-group col-md-6 col-sm-6 text-primary">
                	<label for="link_local_p" class="col-form-label">* DIRECCIÓN LOCAL DEL PACS</label>
                    <input name="link_local_p" id="link_local_p" class="form-control form-control-sm" placeholder="Link para accesar al PACS de forma local" value="http://ip_local:8080/" required>
                	<div class="help-block with-errors"></div>
                </div>
            </div>
            <div class="row">
            	<div class="form-group col-md-6 col-sm-6 text-primary">
                	<label for="link_externo_s" class="col-form-label">* DIRECCIÓN EXTERNA DEL SISTEMA</label>
                    <input name="link_externo_s" id="link_externo_s" type="text" class="form-control form-control-sm" placeholder="Link para accesar al sistema de forma externa" value="http://link_externo:8888/" required>
                	<div class="help-block with-errors"></div>
                </div>
                <div class="form-group col-md-6 col-sm-6 text-primary">
                	<label for="link_externo_p" class="col-form-label">* DIRECCIÓN EXTERNA DEL PACS</label>
                    <input name="link_externo_p" id="link_externo_p" class="form-control form-control-sm" placeholder="Link para accesar al PACS de forma externa" value="http://link_externo:8080/" required>
                	<div class="help-block with-errors"></div>
                </div>
            </div>
            <div class="row">
            	<div class="form-group col-md-6 col-sm-6 text-primary">
                	<label for="sitio_web" class="col-form-label">SITIO WEB</label>
                    <input name="sitio_web" id="sitio_web" type="text" class="form-control form-control-sm" placeholder="Dirección del sitio web" value="">
                	<div class="help-block with-errors"></div>
                </div>
                <div class="form-group col-md-6 col-sm-6 text-primary">
                	<label for="teclaP" class="col-form-label">TECLA DEL PEDAL</label>
                    <input name="teclaP" id="teclaP" type="text" class="form-control form-control-sm" placeholder="" size="1">
                	<div class="help-block with-errors"></div>
                </div>
            </div>
        </div>
        <div class="tab-pane tap-pane-primary" id="t_membresia" role="tabpanel" aria-labelledby="membresia-tab"><br>
        	<div class="row">
                <div class="form-group col-md-6 col-sm-6 text-primary">
                	<label for="nombreM" class="col-form-label">* NOMBRE DE LA MEMBRESÍA</label>
                    <input name="nombreM" id="nombreM" type="text" class="form-control form-control-sm" required placeholder="">
                	<div class="help-block with-errors"></div>
                </div>
                <div class="form-group col-md-6 col-sm-6 text-primary">
                	<label for="precioM" class="col-form-label">* PRECIO</label>
                    <input name="precioM" id="precioM" type="text" class="form-control form-control-sm" required placeholder="">
                	<div class="help-block with-errors"></div>
                </div>
            </div>
        	<div class="row">
                <div class="form-group col-md-6 col-sm-6 text-primary">
                	<label for="periodoM" class="col-form-label">* PERIODO</label>
                    <select name="periodoM" id="periodoM" class="form-control form-control-sm" required>
                    	<option value="MENSUAL">MENSUAL</option>
                        <option value="SEMESTRAL">SEMESTRAL</option>
                        <option selected value="ANUAL">ANUAL</option>
                    </select>
                	<div class="help-block with-errors"></div>
                </div>
                <div class="form-group col-md-6 col-sm-6 text-primary">
                	<label for="diasMV" class="col-form-label">* NÚMERO DE DÍAS PARA LA LISTA DE MEMBRESÍAS A VENCER</label>
                    <select name="diasMV" id="diasMV" class="form-control form-control-sm" required>
                    	<option value="5">5</option>
                        <option value="10">10</option>
                        <option selected value="20">20</option>
                        <option value="30">30</option>
                    </select>
                	<div class="help-block with-errors"></div>
                </div>
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
		<div class="tab-pane tap-pane-primary" id="t_fiscales" role="tabpanel" aria-labelledby="fiscales-tab"><br>
          <div class="row">
            <div class="form-group col-md-6 col-sm-6 text-primary">
              <label for="rSocial" class="col-form-label"> NOMBNRE O RAZÓN SOCIAL</label>
              <input name="rSocial" id="rSocial" class="form-control form-control-sm mi_dir" placeholder="Nombre o Razón social" >
              <div class="help-block with-errors"></div>
            </div>
            <div class="form-group col-md-6 col-sm-6 text-primary">
              <label for="rfc_cf" class="col-form-label"> RFC</label>
                <input name="rfc_cf" id="rfc_cf" class="form-control form-control-sm mi_dir" placeholder="RFC con homoclave" >
                <div class="help-block with-errors"></div>
            </div>
          </div>	
          <div class="row">
            <div class="form-group col-md-6 col-sm-6 text-primary">
              <label for="email_cf" class="col-form-label"> EMAIL</label>
              <input  type="email" name="email_cf" id="email_cf" class="form-control form-control-sm mi_dir" placeholder="Email" >
              <div class="help-block with-errors"></div>
            </div>
            <div class="form-group col-md-6 col-sm-6 text-primary">
              <label for="telefono_cf" class="col-form-label"> TELEFONO</label>
                <input name="telefono_cf" id="telefono_cf" class="form-control form-control-sm mi_dir" placeholder="Teléfono" >
                <div class="help-block with-errors"></div>
            </div>
          </div>	
          <div class="row">
            <div class="form-group col-md-6 col-sm-6 text-primary">
              <label for="entidadFederativa_cf" class="col-form-label"> ESTADO</label>
                  <select name="entidadFederativa_cf" id="entidadFederativa_cf" class="form-control form-control-sm mi_dir"></select>
              <div class="help-block with-errors"></div>
            </div>
            <div class="form-group col-md-6 col-sm-6 text-primary">
              <label for="municipio_cf" class="col-form-label">MUNICIPIO</label>
                <select name="municipio_cf" id="municipio_cf" class="form-control form-control-sm mi_dir"></select>
                <div class="help-block with-errors"></div>
            </div>
          </div>
          <div class="row">
            <div class="form-group col-md-6 col-sm-6 text-primary">
              <label for="ciudad_cf" class="col-form-label"> CIUDAD</label>
                <!--<select name="coloniaP" id="coloniaP" class="form-control form-control-sm mi_dir"></select> -->
              <input name="ciudad_cf" id="ciudad_cf" class="form-control form-control-sm mi_dir" placeholder="Ciudad" >
              <div class="help-block with-errors"></div>
            </div>
            <div class="form-group col-md-6 col-sm-6 text-primary">
              <label for="colonia_cf" class="col-form-label"> COLONIA</label>
                <!--<select name="coloniaP" id="coloniaP" class="form-control form-control-sm mi_dir"></select> -->
                <input name="colonia_cf" id="colonia_cf" class="form-control form-control-sm mi_dir" placeholder="Colonia" >
              <div class="help-block with-errors"></div>
            </div>
          </div>
          <div class="row">
            <div class="form-group col-md-9 col-sm-9 text-primary">
              <label for="calle_cf" class="col-form-label"> CALLE Y NÚMERO</label>
                <input name="calle_cf" id="calle_cf" type="text" class="form-control form-control-sm mi_dir" placeholder="Calle y número" >
                <div class="help-block with-errors"></div>
            </div>
            <div class="form-group col-md-3 col-sm-3 text-primary">
              <label for="cp_cf" class="col-form-label">C.P.</label>
                <!--<select name="cpP" id="cpP" class="form-control form-control-sm"></select> -->
                <input name="cp_cf" id="cp_cf" type="text" class="form-control form-control-sm" placeholder="Código postal"  maxlength="5">
                <div class="help-block with-errors"></div>
            </div>
          </div>
        </div>
    </div>
    
    <input name="input_a" id="input_a" type="hidden" value=""> <input name="input_b" id="input_b" type="hidden" value="">
    <input name="input_c" id="input_c" type="hidden" value=""> <input name="input_d" id="input_d" type="hidden" value="">
    <input name="input_e" id="input_e" type="hidden" value=""> <input name="input_f" id="input_f" type="hidden" value="">
    <input name="input_g" id="input_g" type="hidden" value=""> <input name="input_h" id="input_h" type="hidden" value="">
    </form>
</div>
<div id="auxiliar" class="hidden"></div> <div id="auxiliar1" class="hidden"></div>
<!-- FIN Contenido -->  
<?php include_once 'partes/footer.php'; ?>

<script>
$(document).ready(function(e) {
	//breadcrumb
	$('#breadc').html('<li><a href="index.php">HOME</a></li><li>ADMINISTRACIÓN</li><li class="active"><strong>CONFIGURACIÓN</strong></li>');
	
	$(".insers").load('genera/inserciones.php', function( response, status, xhr ) { if ( status == "success" ) { } });
	
	tinymce.remove("#input"); tinymce.remove("#input1"); tinymce.remove("#input2"); tinymce.remove("#input3"); tinymce.remove("#input4");
	tinymce.remove("#input5"); tinymce.remove("#input6"); tinymce.remove("#input7");
	
	$.fn.datepicker.defaults.autoclose = true;
	var h = $('#referencia').height() - $('#my_footer').height() - $('#my_nav').height()-40-$('#breadc').height();
	$('#div_tabla_pr').height(h);
	var dat = {x:1}
	$.post('remote_files/datosConfiguracion.php',dat).done(function(data){ var datos = data.split('};['); //alert(data);
		$('#nombreS').val(datos[0]); $('#nombreDB').val(datos[1]); $('#nombreM').val(datos[2]); $('#precioM').val(datos[3]);
		$('#periodoM').val(datos[4]); $('#diasMV').val(datos[5]); $('#teclaP').val(datos[6]); $('#sitio_web').val(datos[19]); 
		
		if(datos[15]==''){$('#link_local_s').val('http://ip_local:8888/');}else{$('#link_local_s').val(datos[15]);}
		if(datos[16]==''){$('#link_local_p').val('http://ip_local:8080/');}else{$('#link_local_p').val(datos[16]);}
		if(datos[17]==''){$('#link_externo_s').val('http://link_externo:8888/');}else{$('#link_externo_s').val(datos[17]);}
		if(datos[18]==''){$('#link_externo_p').val('http://link_externo:8080/');}else{$('#link_externo_p').val(datos[18]);}
		
		//Formato Nota Médica
		if(datos[7]==''){
			var text_x = '<table width="100%" border="0" cellpadding="0" cellspacing="0"><tr><td>PACIENTE: {et_nombre_paciente}</td><td>{et_sex} DE {et_edad}</td></tr><tr><td>NOTA MÉDICA</td><td>MÉDICO: {et_nombre_personal_atiende}</td></tr><tr><td colspan="2" align="right" style="font-size:10px;">MUNICIPIO, EDO. A {et_fecha_dia} DE {et_fecha_mes} DE {et_fecha_anio}</td></tr><tr><td valign="top" height="650px" colspan="2" align="" style="" id="espacio_notam"><br><br></td></tr><tr><td colspan="2" align="" style="" id=""><br><br><br><br></td></tr><tr><td colspan="2" align="center" style="" id="">{et_nombre_personal_atiende}</td></tr><tr><td colspan="2" align="center" style="" id="">CÉDULA PROFESIONAL {et_cedulap}</td></tr></table>';
			$('#input').val(text_x);
		}else{ $('#input').val(datos[7]); }
		//Fin Formato Nota Médica
		
		//Formato Receta Médica
		if(datos[8]==''){
			var text_x1 = '<table width="100%" border="0" cellpadding="0" cellspacing="0"><tr><td>PACIENTE: {et_nombre_paciente}</td><td>{et_sex} DE {et_edad}</td></tr><tr><td>RECETA MÉDICA</td><td>MÉDICO: {et_nombre_personal_atiende}</td></tr><tr><td colspan="2" align="right" style="font-size:10px;">MUNICIPIO, EDO. A {et_fecha_dia} DE {et_fecha_mes} DE {et_fecha_anio}</td></tr><tr><td valign="top" height="650px" colspan="2" align="" style="" id="espacio_notam1"><br><br></td></tr><tr><td colspan="2" align="" style="" id=""><br><br><br><br></td></tr><tr><td colspan="2" align="center" style="" id="">{et_nombre_personal_atiende}</td></tr><tr><td colspan="2" align="center" style="" id="">CÉDULA PROFESIONAL {et_cedulap}</td></tr></table>';
			$('#input1').val(text_x1);
		}else{ $('#input1').val(datos[8]); }
		//Fin Formato Receta Médica
		
		//Formato Estudios Laboratorio
		if(datos[9]==''){
			var text_x2 = '<table width="100%" border="0" cellpadding="0" cellspacing="0"><tr><td>PACIENTE: {et_nombre_paciente}</td><td>{et_sex} DE {et_edad}</td></tr><tr><td>{et_nombre_procedimiento}</td><td>REFIERE: {et_nombre_personal_atiende}</td></tr><tr><td colspan="2" align="right" style="font-size:10px;">MUNICIPIO, EDO. A {et_fecha_dia} DE {et_fecha_mes} DE {et_fecha_anio}</td></tr><tr><td valign="top" height="650px" colspan="2" align="" style="" id="espacio_notam2"><br><br></td></tr><tr><td colspan="2" align="" style="" id=""><br><br><br><br></td></tr><tr><td colspan="2" align="center" style="" id="">{et_nombre_personal_atiende}</td></tr><tr><td colspan="2" align="center" style="" id="">CÉDULA PROFESIONAL {et_cedulap}</td></tr></table>';
			 $('#input2').val(text_x2);
		}else{ $('#input2').val(datos[9]); }
		//Fin Formato Estudios Laboratorio
		
		//Formato Estudios Imagen
		if(datos[10]==''){
			//var text_x3 = '<table width="100%" border="0" cellpadding="0" cellspacing="0"><tr><td>PACIENTE: {et_nombre_paciente}</td><td>{et_sex} DE {et_edad}</td></tr><tr><td>{et_nombre_procedimiento}</td><td>REFIERE: {et_nombre_medico_refiere}</td></tr><tr><td colspan="2" align="right" style="font-size:10px;">MUNICIPIO, EDO. A {et_fecha_dia} DE {et_fecha_mes} DE {et_fecha_anio}</td></tr><tr><td valign="top" height="650px" colspan="2" align="" style="" id="espacio_notam3"><br><br></td></tr><tr><td colspan="2" align="" style="" id=""><br><br><br><br></td></tr><tr><td colspan="2" align="center" style="" id="">{et_nombre_personal_atiende}</td></tr><tr><td colspan="2" align="center" style="" id="">CÉDULA PROFESIONAL {et_cedulap}</td></tr></table>';
			var text_x3 = '<table id="p_contenido" width="100%" border="0" cellspacing="3" cellpadding="0" style="width:100%;"><tr class="mceNonEditable1" style="font-size:12pt;"><td width="20%" nowrap height="" valign="bottom"> <span style="text-decoration:underline;">PACIENTE:</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </td> <td class="encaH" width="" align="left" valign="bottom">{et_nombre_paciente}</td> </tr> <tr class="mceNonEditable1" style="font-size:12pt;"> <td style="text-decoration:underline;">MED/TRAT.:</td> <td class="myMedicoP" align="left">{et_nombre_medico_refiere}</td> </tr> <tr class="mceNonEditable1" style="font-size:12pt;"><td style="text-decoration:underline;" nowrap>DX. ENVÍO:</td> <td align="left" nowrap>EN ESTUDIO</td> </tr> <tr class="mceNonEditable1" style="font-size:12pt;"> <td style="text-decoration:underline;" nowrap>F E C H A:</td> <td class="" colspan="2" align="left">{et_fecha_dia}/{et_fecha_mes_numero}/{et_fecha_anio}</td> </tr> <tr> <td id="misDXEI" valign="top" height="670" colspan="2" style="padding-top:3pt; padding-bottom:5pt; font-size:13pt;" align="justyfi"></td> </tr> <tr> <td id="firmaDR" align="center" height="80" colspan="2" style=""><br><br> {et_firma_medico_atiende} </td> </tr> <tr> <td nowrap align="center" colspan="2" style="font-size:12pt;">{et_nombre_medico_atiende}</td> </tr> <tr> <td nowrap align="center" colspan="2" style="font-size:12pt;">MEDICO RADIÓLOGO</td> </tr> </table>';
			
			 $('#input3').val(text_x3);
		}else{ $('#input3').val(datos[10]); }
		//Fin Formato Estudios Imagen
		
		//Formato Estudios Endoscopía
		if(datos[11]==''){
			var text_x4 = '<table width="100%" border="0" cellpadding="0" cellspacing="0"><tr><td>PACIENTE: {et_nombre_paciente}</td><td>{et_sex} DE {et_edad}</td></tr><tr><td>{et_nombre_procedimiento}</td><td>REFIERE: {et_nombre_personal_atiende}</td></tr><tr><td colspan="2" align="right" style="font-size:10px;">MUNICIPIO, EDO. A {et_fecha_dia} DE {et_fecha_mes} DE {et_fecha_anio}</td></tr><tr><td valign="top" height="650px" colspan="2" align="" style="" id="espacio_notam4"><br><br></td></tr><tr><td colspan="2" align="" style="" id=""><br><br><br><br></td></tr><tr><td colspan="2" align="center" style="" id="">{et_nombre_personal_atiende}</td></tr><tr><td colspan="2" align="center" style="" id="">CÉDULA PROFESIONAL {et_cedulap}</td></tr></table>';
			 $('#input4').val(text_x4);
		}else{ $('#input4').val(datos[11]); }
		//Fin Formato Estudios Endoscopía
		
		//Formato Estudios Ultrasonido
		if(datos[12]==''){
			var text_x5 = '<table width="100%" border="0" cellpadding="0" cellspacing="0"><tr><td>PACIENTE: {et_nombre_paciente}</td><td>{et_sex} DE {et_edad}</td></tr><tr><td>{et_nombre_procedimiento}</td><td>REFIERE: {et_nombre_personal_atiende}</td></tr><tr><td colspan="2" align="right" style="font-size:10px;">MUNICIPIO, EDO. A {et_fecha_dia} DE {et_fecha_mes} DE {et_fecha_anio}</td></tr><tr><td valign="top" height="650px" colspan="2" align="" style="" id="espacio_notam5"><br><br></td></tr><tr><td colspan="2" align="" style="" id=""><br><br><br><br></td></tr><tr><td colspan="2" align="center" style="" id="">{et_nombre_personal_atiende}</td></tr><tr><td colspan="2" align="center" style="" id="">CÉDULA PROFESIONAL {et_cedulap}</td></tr></table>';
			 $('#input5').val(text_x5);
		}else{ $('#input5').val(datos[12]); }
		//Fin Formato Estudios Ultrasonido
		
		//Formato Estudios Colposcopía
		if(datos[13]==''){
			var text_x6 = '<table width="100%" border="0" cellpadding="0" cellspacing="0"><tr><td>PACIENTE: {et_nombre_paciente}</td><td>{et_sex} DE {et_edad}</td></tr><tr><td>{et_nombre_procedimiento}</td><td>REFIERE: {et_nombre_personal_atiende}</td></tr><tr><td colspan="2" align="right" style="font-size:10px;">MUNICIPIO, EDO. A {et_fecha_dia} DE {et_fecha_mes} DE {et_fecha_anio}</td></tr><tr><td valign="top" height="650px" colspan="2" align="" style="" id="espacio_notam6"><br><br></td></tr><tr><td colspan="2" align="" style="" id=""><br><br><br><br></td></tr><tr><td colspan="2" align="center" style="" id="">{et_nombre_personal_atiende}</td></tr><tr><td colspan="2" align="center" style="" id="">CÉDULA PROFESIONAL {et_cedulap}</td></tr></table>';
			 $('#input6').val(text_x6);
		}else{ $('#input6').val(datos[13]); }
		//Fin Formato Estudios Colposcopía
		
		//Formato Servicios Médicos
		if(datos[14]==''){
			var text_x7 = '<table width="100%" border="0" cellpadding="0" cellspacing="0"><tr><td>PACIENTE: {et_nombre_paciente}</td><td>{et_sex} DE {et_edad}</td></tr><tr><td>{et_nombre_procedimiento}</td><td>REFIERE: {et_nombre_personal_atiende}</td></tr><tr><td colspan="2" align="right" style="font-size:10px;">MUNICIPIO, EDO. A {et_fecha_dia} DE {et_fecha_mes} DE {et_fecha_anio}</td></tr><tr><td valign="top" height="650px" colspan="2" align="" style="" id="espacio_notam7"><br><br></td></tr><tr><td colspan="2" align="" style="" id=""><br><br><br><br></td></tr><tr><td colspan="2" align="center" style="" id="">{et_nombre_personal_atiende}</td></tr><tr><td colspan="2" align="center" style="" id="">CÉDULA PROFESIONAL {et_cedulap}</td></tr></table>';
			 $('#input7').val(text_x7);
		}else{ $('#input7').val(datos[14]); }
		//Fin Formato Servicios Médicos

		cargar_editores();

		$('#rSocial').val(datos[20]);
		$('#rfc_cf').val(datos[21]);
		$('#email_cf').val(datos[22]);
		$('#telefono_cf').val(datos[23]);

		$('#ciudad_cf').val(datos[27]);
		$('#colonia_cf').val(datos[28]);
		$('#calle_cf').val(datos[29]);
		$('#cp_cf').val(datos[30]);
		// DATOS FISCALES 
		$("#entidadFederativa_cf").load('pacientes/files-serverside/genera_estados.php',function(response,status,xhr){if(status=="success"){
			$('#entidadFederativa_cf').val(datos[25]);
			var id = $("#entidadFederativa_cf").find(':selected').text();
			$("#municipio_cf").load('pacientes/files-serverside/genera_municipios.php?id='+escape(id),function(response,status,xhr){
				if(status=="success"){
					$('#municipio_cf').val(datos[26]);
				}});
			$("#entidadFederativa_cf").change(function(event){
				$('#municipio_cf').val(''); var id = $("#entidadFederativa_cf").find(':selected').text();
				$("#municipio_cf").load('pacientes/files-serverside/genera_municipios.php?id='+escape(id),function(response,status,xhr){if(status=="success"){
					
				}});
			});
		}});
		
		$('#form-registro').validator().on('submit', function (e) {
			$('#input_a').val(tinyMCE.get("input").getContent()); $('#input_b').val(tinyMCE.get("input1").getContent());
			$('#input_c').val(tinyMCE.get("input2").getContent()); $('#input_d').val(tinyMCE.get("input3").getContent());
			$('#input_e').val(tinyMCE.get("input4").getContent()); $('#input_f').val(tinyMCE.get("input5").getContent());
			$('#input_g').val(tinyMCE.get("input6").getContent()); $('#input_h').val(tinyMCE.get("input7").getContent());
		  if (e.isDefaultPrevented()) { // handle the invalid form...
			//$("#alerta_form").fadeTo(2000,500).slideUp(500,function(){ $("#alerta_form").slideUp(600); });
		  } else { // everything looks good!
			e.preventDefault(); 
			//var $btn = $('#btn_registro').button('loading'); $('#btn_cancel_registro').hide();
			var datosP = $('#form-registro').serialize();
			$.post('remote_files/guardarConfiguracion.php',datosP).done(function(data){
				if (data==1){//si el paciente se Actualizó //$('#btn_cancel_registro').show(); //$btn.button('reset');
					swal({ title: "", type: "success", text: "Los datos se han guardado.", timer: 1800, showConfirmButton: false }); return;
				} else{alert(data);}
			});
		  }
		});
	});
});

function insertAtCaret(text) { tinymce.get("input").execCommand('mceInsertContent', false, text); $('#inserta_algo').val(''); }
function insertAtCaret1(text) { tinymce.get("input").execCommand('mceInsertContent', false, text); $('#inserta_algo1').val(''); }
function insertAtCaret2(text) { tinymce.get("input1").execCommand('mceInsertContent', false, text); $('#inserta_algo2').val(''); }
function insertAtCaret3(text) { tinymce.get("input1").execCommand('mceInsertContent', false, text); $('#inserta_algo3').val(''); }
function insertAtCaret4(text) { tinymce.get("input2").execCommand('mceInsertContent', false, text); $('#inserta_algo4').val(''); }
function insertAtCaret5(text) { tinymce.get("input2").execCommand('mceInsertContent', false, text); $('#inserta_algo5').val(''); }
function insertAtCaret6(text) { tinymce.get("input3").execCommand('mceInsertContent', false, text); $('#inserta_algo6').val(''); }
function insertAtCaret7(text) { tinymce.get("input3").execCommand('mceInsertContent', false, text); $('#inserta_algo7').val(''); }
function insertAtCaret8(text) { tinymce.get("input4").execCommand('mceInsertContent', false, text); $('#inserta_algo8').val(''); }
function insertAtCaret9(text) { tinymce.get("input4").execCommand('mceInsertContent', false, text); $('#inserta_algo9').val(''); }
function insertAtCaret10(text) { tinymce.get("input5").execCommand('mceInsertContent', false, text); $('#inserta_algo10').val(''); }
function insertAtCaret11(text) { tinymce.get("input5").execCommand('mceInsertContent', false, text); $('#inserta_algo11').val(''); }
function insertAtCaret12(text) { tinymce.get("input6").execCommand('mceInsertContent', false, text); $('#inserta_algo12').val(''); }
function insertAtCaret13(text) { tinymce.get("input6").execCommand('mceInsertContent', false, text); $('#inserta_algo13').val(''); }
function insertAtCaret14(text) { tinymce.get("input7").execCommand('mceInsertContent', false, text); $('#inserta_algo14').val(''); }
function insertAtCaret15(text) { tinymce.get("input7").execCommand('mceInsertContent', false, text); $('#inserta_algo15').val(''); }

function cargar_editores(){
	tinymce.init({ 
		selector:'#input',resize:false,height:$('#referencia').height()*0.45,theme: "modern",
		plugins: 
			"table, charmap, emoticons, textcolor colorpicker, hr, image imagetools, image, insertdatetime, lists, noneditable, pagebreak, paste, preview, print, visualblocks, wordcount, code, importcss",
		relative_urls: true, image_advtab: true, menubar: false, plugin_preview_width: $('#referencia').width()*0.8,
		toolbar: 
			"undo redo | insert | bold italic fontsizeselect | alignleft aligncenter alignright alignjustify | bullist numlist outdent1 indent1 | link unlink anchor | forecolor backcolor  | print_ preview_ code_ | emoticons_ | table | responsivefilemanager_ | mybuttonVP |",
		insert_button_items: 'charmap | cut copy | hr | insertdatetime | pagebreak1',
		paste_data_images: true, paste_as_text: true, browser_spellcheck: true, image_advtab: true,
		setup: function(editor){
			editor.addButton( 'mybuttonVP', {
				text: 'VPI', icon: false, tooltip: 'Vista previa de impresión',
				onclick:function(){
					var res = tinyMCE.get("input").getContent().replace(/<p/g, "<div"); res = res.replace(/<\/p>/g, "</div>"); //alert(res);
					$('#dpa_imprimir').html(res).css('background-image','url(imagenes/vista_previa.png)').css('background-size','65%');
					$('#dpa_imprimir').html(res); $('#dpa_imprimir').printElement();
				}
			});
		}
	});
	
	tinymce.init({ 
		selector:'#input1',resize:false,height:$('#referencia').height()*0.45,theme: "modern",
		plugins: 
			"table, charmap, emoticons, textcolor colorpicker, hr, image imagetools, image, insertdatetime, lists, noneditable, pagebreak, paste, preview, print, visualblocks, wordcount, code, importcss",
		relative_urls: true, image_advtab: true, menubar: false, plugin_preview_width: $('#referencia').width()*0.8,
		toolbar: 
			"undo redo | insert | bold italic fontsizeselect | alignleft aligncenter alignright alignjustify | bullist numlist outdent1 indent1 | link unlink anchor | forecolor backcolor  | print_ preview_ code_ | emoticons_ | table | responsivefilemanager_ | mybuttonVP |",
		insert_button_items: 'charmap | cut copy | hr | insertdatetime | pagebreak1',
		paste_data_images: true, paste_as_text: true, browser_spellcheck: true, image_advtab: true,
		setup: function(editor){
			editor.addButton( 'mybuttonVP', {
				text: 'VPI', icon: false, tooltip: 'Vista previa de impresión',
				onclick:function(){
					var res = tinyMCE.get("input1").getContent().replace(/<p/g, "<div"); res = res.replace(/<\/p>/g, "</div>"); //alert(res);
					$('#dpa_imprimir1').html(res).css('background-image','url(imagenes/vista_previa.png)').css('background-size','65%');
					$('#dpa_imprimir1').html(res); $('#dpa_imprimir1').printElement();
				}
			});
		}
	});
	
	tinymce.init({ 
		selector:'#input2',resize:false,height:$('#referencia').height()*0.45,theme: "modern",
		plugins: 
			"table, charmap, emoticons, textcolor colorpicker, hr, image imagetools, image, insertdatetime, lists, noneditable, pagebreak, paste, preview, print, visualblocks, wordcount, code, importcss",
		relative_urls: true, image_advtab: true, menubar: false, plugin_preview_width: $('#referencia').width()*0.8,
		toolbar: 
			"undo redo | insert | bold italic fontsizeselect | alignleft aligncenter alignright alignjustify | bullist numlist outdent1 indent1 | link unlink anchor | forecolor backcolor  | print_ preview_ code_ | emoticons_ | table | responsivefilemanager_ | mybuttonVP |",
		insert_button_items: 'charmap | cut copy | hr | insertdatetime | pagebreak1',
		paste_data_images: true, paste_as_text: true, browser_spellcheck: true, image_advtab: true,
		setup: function(editor){
			editor.addButton( 'mybuttonVP', {
				text: 'VPI', icon: false, tooltip: 'Vista previa de impresión',
				onclick:function(){
					var res = tinyMCE.get("input2").getContent().replace(/<p/g, "<div"); res = res.replace(/<\/p>/g, "</div>"); //alert(res);
					$('#dpa_imprimir2').html(res).css('background-image','url(imagenes/vista_previa.png)').css('background-size','65%');
					$('#dpa_imprimir2').html(res); $('#dpa_imprimir2').printElement();
				}
			});
		}
	});
	
	tinymce.init({ 
		selector:'#input3',resize:false,height:$('#referencia').height()*0.45,theme: "modern",
		plugins: 
			"table, charmap, emoticons, textcolor colorpicker, hr, image imagetools, image, insertdatetime, lists, noneditable, pagebreak, paste, preview, print, visualblocks, wordcount, code, importcss",
		relative_urls: true, image_advtab: true, menubar: false, plugin_preview_width: $('#referencia').width()*0.8,
		toolbar: 
			"undo redo | insert | bold italic fontsizeselect | alignleft aligncenter alignright alignjustify | bullist numlist outdent1 indent1 | link unlink anchor | forecolor backcolor  | print_ preview_ code_ | emoticons_ | table | responsivefilemanager_ | mybuttonVP |",
		insert_button_items: 'charmap | cut copy | hr | insertdatetime | pagebreak1',
		paste_data_images: true, paste_as_text: true, browser_spellcheck: true, image_advtab: true,
		setup: function(editor){
			editor.addButton( 'mybuttonVP', {
				text: 'VPI', icon: false, tooltip: 'Vista previa de impresión',
				onclick:function(){
					var res = tinyMCE.get("input3").getContent().replace(/<p/g, "<div"); res = res.replace(/<\/p>/g, "</div>"); //alert(res);
					$('#dpa_imprimir3').html(res).css('background-image','url(imagenes/vista_previa.png)').css('background-size','65%');
					$('#dpa_imprimir3').html(res); $('#dpa_imprimir3').printElement();
				}
			});
		}
	});
	
	tinymce.init({ 
		selector:'#input4',resize:false,height:$('#referencia').height()*0.45,theme: "modern",
		plugins: 
			"table, charmap, emoticons, textcolor colorpicker, hr, image imagetools, image, insertdatetime, lists, noneditable, pagebreak, paste, preview, print, visualblocks, wordcount, code, importcss",
		relative_urls: true, image_advtab: true, menubar: false, plugin_preview_width: $('#referencia').width()*0.8,
		toolbar: 
			"undo redo | insert | bold italic fontsizeselect | alignleft aligncenter alignright alignjustify | bullist numlist outdent1 indent1 | link unlink anchor | forecolor backcolor  | print_ preview_ code_ | emoticons_ | table | responsivefilemanager_ | mybuttonVP |",
		insert_button_items: 'charmap | cut copy | hr | insertdatetime | pagebreak1',
		paste_data_images: true, paste_as_text: true, browser_spellcheck: true, image_advtab: true,
		setup: function(editor){
			editor.addButton( 'mybuttonVP', {
				text: 'VPI', icon: false, tooltip: 'Vista previa de impresión',
				onclick:function(){
					var res = tinyMCE.get("input4").getContent().replace(/<p/g, "<div"); res = res.replace(/<\/p>/g, "</div>"); //alert(res);
					$('#dpa_imprimir4').html(res).css('background-image','url(imagenes/vista_previa.png)').css('background-size','65%');
					$('#dpa_imprimir4').html(res); $('#dpa_imprimir4').printElement();
				}
			});
		}
	});
	
	tinymce.init({ 
		selector:'#input5',resize:false,height:$('#referencia').height()*0.45,theme: "modern",
		plugins: 
			"table, charmap, emoticons, textcolor colorpicker, hr, image imagetools, image, insertdatetime, lists, noneditable, pagebreak, paste, preview, print, visualblocks, wordcount, code, importcss",
		relative_urls: true, image_advtab: true, menubar: false, plugin_preview_width: $('#referencia').width()*0.8,
		toolbar: 
			"undo redo | insert | bold italic fontsizeselect | alignleft aligncenter alignright alignjustify | bullist numlist outdent1 indent1 | link unlink anchor | forecolor backcolor  | print_ preview_ code_ | emoticons_ | table | responsivefilemanager_ | mybuttonVP |",
		insert_button_items: 'charmap | cut copy | hr | insertdatetime | pagebreak1',
		paste_data_images: true, paste_as_text: true, browser_spellcheck: true, image_advtab: true,
		setup: function(editor){
			editor.addButton( 'mybuttonVP', {
				text: 'VPI', icon: false, tooltip: 'Vista previa de impresión',
				onclick:function(){
					var res = tinyMCE.get("input5").getContent().replace(/<p/g, "<div"); res = res.replace(/<\/p>/g, "</div>"); //alert(res);
					$('#dpa_imprimir5').html(res).css('background-image','url(imagenes/vista_previa.png)').css('background-size','65%');
					$('#dpa_imprimir5').html(res); $('#dpa_imprimir5').printElement();
				}
			});
		}
	});
	
	tinymce.init({ 
		selector:'#input6',resize:false,height:$('#referencia').height()*0.45,theme: "modern",
		plugins: 
			"table, charmap, emoticons, textcolor colorpicker, hr, image imagetools, image, insertdatetime, lists, noneditable, pagebreak, paste, preview, print, visualblocks, wordcount, code, importcss",
		relative_urls: true, image_advtab: true, menubar: false, plugin_preview_width: $('#referencia').width()*0.8,
		toolbar: 
			"undo redo | insert | bold italic fontsizeselect | alignleft aligncenter alignright alignjustify | bullist numlist outdent1 indent1 | link unlink anchor | forecolor backcolor  | print_ preview_ code_ | emoticons_ | table | responsivefilemanager_ | mybuttonVP |",
		insert_button_items: 'charmap | cut copy | hr | insertdatetime | pagebreak1',
		paste_data_images: true, paste_as_text: true, browser_spellcheck: true, image_advtab: true,
		setup: function(editor){
			editor.addButton( 'mybuttonVP', {
				text: 'VPI', icon: false, tooltip: 'Vista previa de impresión',
				onclick:function(){
					var res = tinyMCE.get("input6").getContent().replace(/<p/g, "<div"); res = res.replace(/<\/p>/g, "</div>"); //alert(res);
					$('#dpa_imprimir6').html(res).css('background-image','url(imagenes/vista_previa.png)').css('background-size','65%');
					$('#dpa_imprimir6').html(res); $('#dpa_imprimir6').printElement();
				}
			});
		}
	});
	
	tinymce.init({ 
		selector:'#input7',resize:false,height:$('#referencia').height()*0.45,theme: "modern",
		plugins: 
			"table, charmap, emoticons, textcolor colorpicker, hr, image imagetools, image, insertdatetime, lists, noneditable, pagebreak, paste, preview, print, visualblocks, wordcount, code, importcss",
		relative_urls: true, image_advtab: true, menubar: false, plugin_preview_width: $('#referencia').width()*0.8,
		toolbar: 
			"undo redo | insert | bold italic fontsizeselect | alignleft aligncenter alignright alignjustify | bullist numlist outdent1 indent1 | link unlink anchor | forecolor backcolor  | print_ preview_ code_ | emoticons_ | table | responsivefilemanager_ | mybuttonVP |",
		insert_button_items: 'charmap | cut copy | hr | insertdatetime | pagebreak1',
		paste_data_images: true, paste_as_text: true, browser_spellcheck: true, image_advtab: true,
		setup: function(editor){
			editor.addButton( 'mybuttonVP', {
				text: 'VPI', icon: false, tooltip: 'Vista previa de impresión',
				onclick:function(){
					var res = tinyMCE.get("input7").getContent().replace(/<p/g, "<div"); res = res.replace(/<\/p>/g, "</div>"); //alert(res);
					$('#dpa_imprimir7').html(res).css('background-image','url(imagenes/vista_previa.png)').css('background-size','65%');
					$('#dpa_imprimir7').html(res); $('#dpa_imprimir7').printElement();
				}
			});
		}
	});
}
</script>
