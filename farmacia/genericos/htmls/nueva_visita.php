<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Documento sin título</title>
<script src="../../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<link href="../../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css">
</head>

<body>

<div id="tabs_nv" style=" font-size:14px;">
<form action="" method="post" name="formNVisita" id="formNVisita" target="_self" style="height:100%">
<input name="idUsuario_nv" id="idUsuario_nv" type="hidden" value=""> 
<input name="idPaciente_nv" id="idPaciente_nv" type="hidden" value="">
<input name="numeroTemporalNV" id="numeroTemporalNV" type="hidden" value="">
<div>
  <ul id="pestanasV" style="float:left;">
    <li><a class="tabs" id="tabs-1-1" href="#tabs-1" style="color:; background-color:;">GENERALES</a></li>
    <li><a class="tabs" id="tabs-2-1" href="#tabs-2" style="color:; background-color:;">CONSULTA</a></li>
    <li><a class="tabs" id="tabs-3-1" href="#tabs-3" style="color:; background-color:;">IMG</a></li>
    <li><a class="tabs" id="tabs-4-1" href="#tabs-4" style="color:; background-color:;">LAB</a></li>
    <li style="display:none;"><a class="tabs" id="tabs-8-1" href="#tabs-8" style="color:; background-color:;">ENDO</a></li>
    <li><a class="tabs" id="tabs-5-1" href="#tabs-5" style="color:; background-color:;">SERVICIOS</a></li>
    <li><a class="tabs" id="tabs-6-1" href="#tabs-6" style="color:; background-color:;">TOTAL</a></li>
    <li><a class="tabs" id="tabs-7-1" href="#tabs-7" style="color:; background-color:; display:none;">PAGOS</a></li>
  </ul>
  <table id="botonesPac" style="float:right;" height="40px" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td class="botonesSaveOV" style="display:none;"><button id="saveOV" class="botonP">Guardar</button></td>
    <td class="botonesSaveOV"><button id="cancelSaveOV" class="botonP">Cancelar</button></td>
  </tr>
</table>
</div>
  
  <div class="miTab" id="tabs-1" align="left">
  <table class="tTabs" width="100%" height="100%" border="0" align="center" cellpadding="0" cellspacing="0"  bgcolor="#EEE">
    <tbody align="left">
      <tr>
        <td> 
        <table width="100%" border="0" cellspacing="2" cellpadding="2">
          <tr> 
          	<td class="titulosTabs">Paciente</td> 
            <td class="titulosTabs" width="90px">Edad</td> 
            <td class="titulosTabs" width="90px">Sexo</td> 
          </tr>
          <tr valign="top"> 
          	<td><input name="pacienteNV" id="pacienteNV" type="text" readonly></td> 
            <td><input name="edadNV" id="edadNV" type="text" readonly></td> 
            <td><input name="sexoNV" id="sexoNV" type="text" readonly></td> 
          </tr>
        </table>
        </td>
        <td width="20%" style="max-width:100px;border:1px none gold;" rowspan="4" valign="top" id="miFotito"><ul id="gallery" style="border:1px none red; text-align:center;"> <!-- Cargar Fotos --> </ul></td>
      </tr>
      <tr>
        <td>
        <table width="100%" border="0" cellspacing="2" cellpadding="2">
          <tr> <td class="titulosTabs">Sucursal</td> </tr>
          <tr> <td><select name="sucursalNV" id="sucursalNV" class="required"> </select></td> </tr>
        </table>
        </td>
        </tr>
      <!--<tr>
        <td> 
        <table width="100%" border="0" cellspacing="2" cellpadding="2">
          <tr> <td class="titulosTabs">Convenio</td> </tr>
          <tr> <td><select name="convenioNV" id="convenioNV"> </select></td> </tr>
        </table>
        </td>
      </tr> -->
    </tbody>
  </table>
  </div>
  
  <div class="miTab" id="tabs-2">
  <input name="id_medicoCo" id="id_medicoCo" type="hidden" value="">
  <input name="idMedicoConsultaT" type="hidden" value="" id="idMedicoConsultaT">
  <input name="idUsadaConsulta" type="hidden" value="" id="idUsadaConsulta">
  <table class="tTabs" width="100%" height="100%" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#EEE">
    <tbody align="left">
      <tr>
        <td>
        <table width="100%" border="0" cellspacing="2" cellpadding="2">
          <tr> 
          	<td width="1%" align="right" class="titulosTabs">
            	Médico
            </td> 
            <td align="left" width="1%">
            	<button class="botonNV busqueda" name="b_medicoConsultaNV" id="b_medicoConsultaNV"> </button>
            </td> 
          	<td align="left" width="1%">
            	<button class="botonNV eliminacion" name="b_eliminarCoNV" id="b_eliminarCoNV" style="display:none;"> </button>
            </td>
            <td>
            	<input name="medicoMC_NV" id="medicoMC_NV" type="text" readonly> 
                <input name="nombreMedicoConsultaT" type="hidden" value="" id="nombreMedicoConsultaT">
            </td>
            <!--<td class="titulosTabs" width="1%">Especialidad</td>  -->
          	<td width="30%" colspan="2">
            	<input name="especialidadMC_V" id="especialidadMC_V" type="text" readonly>
                <input name="especialidadMedicoConsultaT" type="hidden" value="" id="especialidadMedicoConsultaT">
            </td>  
          </tr>
        </table>
        </td>
      </tr>
      <tr>
        <td>
        <table width="100%" border="0" cellspacing="2" cellpadding="2">
          <tr> 
              <td class="titulosTabs">
              	Consulta&nbsp;<button class="botonNV busqueda" id="bBuscarConsulta" style="display:none;"></button>
                <input name="idConcepto" id="idConcepto" type="hidden" value="">
  				<input name="idConceptoT" type="hidden" value="" id="idConceptoT">
                <input name="idAreaConsulta" id="idAreaConsulta" type="hidden" value="">
                <input name="idAreaConsultaT" id="idAreaConsultaT" type="hidden" value="">
                <input name="idConBene" id="idConBene" type="hidden" value="">
                <input name="idConBeneT" id="idConBeneT" type="hidden" value="">
              </td> 
              <td class="titulosTabs">Costo($)</td> <td class="titulosTabs" nowrap>Beneficio</td> 
          </tr>
          <tr> 
          	<td>
            	<input name="especialidadMC_NV" id="especialidadMC_NV" type="text" readonly>
                <input name="especialidadCT" type="hidden" value="" id="especialidadCT">
            </td>
            <td>
            	<input name="costoMC_NV" id="costoMC_NV" type="text" readonly>
                <input name="costoCT" type="hidden" value="" id="costoCT">
            </td>
            <td>
            	<input class="" name="beneficio_NV" type="text" id="beneficio_NV" value="" readonly>
                <input name="beneficioCT" type="hidden" value="" id="beneficioCT">
                <input name="idBeneficioC" type="hidden" value="" id="idBeneficioC">
                <input name="idBeneficioCT" type="hidden" value="" id="idBeneficioCT">
                
            </td>
          </tr>
        </table>
        </td>
      </tr>
      <tr>
        <td> 
        <table width="100%" border="0" cellspacing="2" cellpadding="2">
          <tr> 
          	<td class="titulosTabs" nowrap>Subtotal($)</td> 
            <td class="titulosTabs" nowrap>Cargo adicional($)</td> 
            <td class="titulosTabs" nowrap>Total($)</td> </tr>
          <tr> 
          	<td><input name="subtotalC_NV" type="text" id="subtotalC_NV" value="0" readonly class="cero"></td> 
            <td><input name="cargoAdC_NV" type="text" id="cargoAdC_NV" value="" class="cero" readonly placeholder="0" onKeyUp="numeros_decimales(this.value, this.name);"></td> 
          	<td><input name="totalC_NV" type="text" id="totalC_NV" value="0" readonly class="cero"></td> 
          </tr>
        </table>
        </td>
      </tr>
      <tr>
        <td>
        <table width="100%" border="0" cellspacing="2" cellpadding="2">
          <tr>
          	<td width="200px" class="titulosTabs" nowrap>
            	Motivo de la consulta <input name="urgenteCo" id="urgenteCo" type="hidden" value="0">
            </td>
          </tr>
          <tr> <td colspan="5"><textarea name="motivoC_NV" id="motivoC_NV" cols="1" rows="2" style="resize:none;" onKeyUp="conMayusculas(this); solo_letras_numeros(this.value, this.name);"></textarea></td> </tr>
        </table>
        </td>
      </tr>
    </tbody>
  </table>
  </div>
  
  <div class="miTab" id="tabs-3">
  <input name="id_medicoIm" id="id_medicoIm" type="hidden" value="">
  <input name="id_medicoImT" id="id_medicoImT" type="hidden" value="">
  <input name="idConBeneI" id="idConBeneI" type="hidden" value="">
  <input name="idConBeneIT" id="idConBeneIT" type="hidden" value="">
  
  <input name="id_DepartamentoIm" id="id_DepartamentoIm" type="hidden" value="2">
  <table class="tTabs" width="100%" height="100%" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#EEE">
    <tbody align="left">
      <tr>
        <td height="1px"> 
        <table width="100%" border="0" cellspacing="0" cellpadding="2">
          <tr> 
          	<td width="1%" align="right" class="titulosTabs">Médico</td> <td align="left" width="1%">
            	<button class="botonNV busqueda" name="b_medicoImagenNV" id="b_medicoImagenNV"> </button>
            </td> 
          	<td align="left" width="1%">
            	<button class="botonNV eliminacion" name="b_eliminarImNV" id="b_eliminarImNV" style="display:none;"> </button>
            </td>
            <td>
            	<input name="medicoMI_NV" id="medicoMI_NV" type="text" readonly style="padding-left:5px;">
                <input name="medicoMI_NVT" id="medicoMI_NVT" type="hidden" value="">
            </td>
           </tr>
        </table>
        </td>
      </tr>
      <tr>
        <td id="contenedorENV">
        <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="4" id="dataTableEstudiosI" class="tablilla">
         <thead id="cabecera_tBusquedaEstudiosI">
          <tr style="font-size:0.9em; color:;" bgcolor="#FF6633">
            <th id="clickmeI" class="titulosTabs" align="center" style="color:white;" width="15px">#</th>
            <th class="titulosTabs" align="center" style="color:white;">
            	ESTUDIO&nbsp;
                <button class="botonNV busqueda" name="b_estudiosImagenNV" id="b_estudiosImagenNV" style="display:none;"> </button>
            </th>
            <th class="titulosTabs" align="center" style="color:white;">ÁREA</th>
            <th class="titulosTabs" align="center" style="color:white;" width="60px">PRECIO</th>
            <th class="titulosTabs" align="center" style="color:white;" width="">BENEFICIO</th>
          </tr>
        </thead> <tbody style="font-size:11px;"> <tr> <td class="dataTables_empty">Cargando datos del servidor</td> </tr> </tbody> 
       	</table>
        </td>
      </tr>
      <tr>
        <td> 
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
        	<tr>
                <td width="33.3%">
                	<table width="100%"border="0"cellspacing="2"cellpadding="2"><tr>
                    <td class="titulosTabs" width="90px" nowrap>Subtotal($)</td>
                    <td><input name="subtotalI_NV" type="text" id="subtotalI_NV" value="0" readonly class="cero"></td>
                    </tr></table>
                </td>
                <td width="33.3%">
                    <table width="100%"border="0"cellspacing="2"cellpadding="2"><tr>
                    <td class="titulosTabs"width="1%"nowrap>Cargo adicional($)</td>
                    <td>
                    	<input name="cargoAdI_NV" type="text" id="cargoAdI_NV" value="" readonly class="cero" placeholder="0" onKeyUp="numeros_decimales(this.value, this.name);">
                    </td>
                    </tr></table>
                </td>
                <td width="">
                    <table width="100%"border="0"cellspacing="2"cellpadding="2"><tr>
                    <td class="titulosTabs" width="1%" nowrap>Total($)</td>
                    <td><input name="totalI_NV" type="text" id="totalI_NV" value="0" readonly class="cero"></td>
                    </tr></table>
                </td>
            </tr>
        </table>
        </td>
      </tr>
      <tr>
        <td>
        <table width="100%" border="0" cellspacing="2" cellpadding="2">
          <tr><td class="titulosTabs"width="160px">Observaciones</td></tr>
          <tr> <td colspan="3"><input name="observacionesI_NV" id="observacionesI_NV" type="text" onKeyUp="conMayusculas(this); solo_letras_numeros(this.value, this.name);"></td> </tr>
        </table>
        </td>
      </tr>
    </tbody>
  </table>
  </div>

  <div class="miTab" id="tabs-4"> 
  <input name="id_medicoLab" id="id_medicoLab" type="hidden" value="">
  <input name="id_medicoLabT" id="id_medicoLabT" type="hidden" value="">
  <input name="idConBeneL" id="idConBeneL" type="hidden" value="">
  <input name="idConBeneLT" id="idConBeneLT" type="hidden" value="">
  
  <input name="id_DepartamentoLab" id="id_DepartamentoLab" type="hidden" value="1">
  <table class="tTabs" width="100%" height="100%" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#EEE">
  <tbody align="left">
    <tr>
        <td height="1px"> 
        <table width="100%" border="0" cellspacing="2" cellpadding="2">
          <tr> 
            <td width="1%" align="right" class="titulosTabs">Médico</td> 
            <td align="left" width="1%"><button class="botonNV busqueda" name="b_medicoLabNV" id="b_medicoLabNV"> </button></td> 
            <td align="left" width="1%">
            	<button class="botonNV eliminacion" name="b_eliminarLaNV" id="b_eliminarLaNV" style="display:none;"> </button>
            </td>
            <td>
            	<input name="medicoML_NV" id="medicoML_NV" type="text" readonly style=" padding-left:5px;">
                <input name="medicoML_NVT" id="medicoML_NVT" type="hidden" value="">
            </td>
           </tr>
        </table>
        </td>
    </tr>
    <tr>
        <td id="contenedorELNV">
        <table width="100%" height="100%" border="0" cellpadding="4" cellspacing="0" id="dataTableEstudiosL" class="tablilla">
         <thead id="cabecera_tBusquedaEstudiosL">
          <tr style="font-size:0.9em;" bgcolor="#FF6633">
            <th id="clickmeL" class="titulosTabs" align="center" style="color:white;" width="15px">#</th>
            <th class="titulosTabs" align="center" style="color:white;">
            	ESTUDIO&nbsp;
                <button class="botonNV busqueda" name="b_estudiosLabNV" id="b_estudiosLabNV" style="display:none;"> </button>
            </th>
            <th class="titulosTabs" align="center" style="color:white;">ÁREA</th>
            <th class="titulosTabs" align="center" style="color:white;" width="60px">PRECIO</th>
            <th class="titulosTabs" align="center" style="color:white;" width="">BENEFICIO</th>
          </tr>
        </thead> <tbody style="font-size:11px;"> <tr> <td class="dataTables_empty">Cargando datos del servidor</td> </tr> </tbody> 
        </table>
        </td>
    </tr>
    <tr>
        <td> <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
            	<td width="25%">
                <table width="100%"border="0"cellspacing="2"cellpadding="2">
                	<tr>
                    	<td class="titulosTabs" width="1%" nowrap>Subtotal($)</td>
                        <td><input name="subtotalL_NV" type="text" id="subtotalL_NV" value="0" readonly class="cero"></td>
                    </tr>
                </table>
                </td>
                <td width="25%">
                <table width="100%"border="0"cellspacing="2"cellpadding="2">
                	<tr>
                    	<td class="titulosTabs"width="1%"nowrap>Cargo adicional($)</td>
                        <td>
                        <input name="cargoAdL_NV" type="text" id="cargoAdL_NV" value="" readonly class="cero" placeholder="0" onKeyUp="numeros_decimales(this.value, this.name);">
                        </td>
                    </tr>
                </table>
                </td>
                <td width="25%">
                	<table width="100%"border="0"cellspacing="2"cellpadding="2">
                    	<tr>
                        	<td class="titulosTabs" width="1%" nowrap>Total($)</td>
                            <td><input name="totalL_NV" type="text" id="totalL_NV" value="0" readonly class="cero"></td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table> </td>
    </tr>
    <tr>
        <td>
        <table width="100%" border="0" cellspacing="2" cellpadding="2">
          <tr><td class="titulosTabs"width="160px">Observaciones</td></tr>
          <tr> <td colspan="3"><input name="observacionesL_NV" id="observacionesL_NV" type="text" onKeyUp="conMayusculas(this); solo_letras_numeros(this.value, this.name);"></td> </tr>
        </table>
        </td>
    </tr>
    </tbody>
  </table>
  </div>
  
  <div class="miTab" id="tabs-5"> 
  <input name="id_pMedico" id="id_pMedico" type="hidden" value="">
  <input name="id_pMedicoT" id="id_pMedicoT" type="hidden" value="">
  <input name="idConBeneS" id="idConBeneS" type="hidden" value="">
  <input name="idConBeneST" id="idConBeneST" type="hidden" value="">
  
  <table class="tTabs" width="100%" height="100%" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#EEE">
    <tbody align="left">
      <tr>
        <td height="1px">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
            	<td>
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                	<tr>
                		<td width="120px"> 
                        <table width="100%" border="0" cellspacing="2" cellpadding="2"> 
                        <tr> 
                        	<td width="50%" align="right" class="titulosTabs" nowrap>Personal médico</td> 
                            <td align="left" width="1%">
                            	<button class="botonNV busqueda" name="b_personalMedicoLabNV" id="b_personalMedicoLabNV"> </button>
                            </td>
                            <td align="left">
                            <button class="botonNV eliminacion"name="b_eliminarSeNV"id="b_eliminarSeNV"style="display:none;"></button>
                            </td> 
                        </tr> 
                        </table>
                		</td>
                		<td width="">
                        <table width="100%" border="0" cellspacing="2" cellpadding="2">
                        <tr>
                        	<td>
                            <input name="medicoPMS_NV" id="medicoPMS_NV" type="text" readonly style="padding-left:5px;">
                            <input name="medicoPMS_NVT" id="medicoPMS_NVT" type="hidden" value="">
                            </td>
                        </tr>
                        </table>
                        </td> 
                		<td width="200px">
                        	<table width="100%" border="0" cellspacing="2" cellpadding="2">
                            <tr>
                            	<td class="titulosTabs" width="1%" nowrap>Cargo</td>
                                <td>
                                <input name="puestoPMS_NV_NV" id="puestoPMS_NV_NV" type="text" readonly style="padding-left:5px;">
                                <input name="puestoPMS_NV_NVT" id="puestoPMS_NV_NVT" type="hidden" value="">
                                </td>
                            </tr>
                            </table>
                        </td>
                </tr></table>
            </td></tr>
        </table>
    	</td>
    </tr>
      <tr>
        <td id="contenedorSNV">
        <table width="100%" height="100%" border="0" cellpadding="4" cellspacing="0" id="dataTableServiciosS" class="tablilla"> <thead id="cabecera_tBusquedaServiciosS">
          <tr style="font-size:0.9em;" bgcolor="#FF6633">
            <th id="clickmeS" class="titulosTabs" align="center" style="color:white;" width="10px">#</th>
            <th class="titulosTabs" align="center" style="color:white;">
            	SERVICIO&nbsp;
                <button class="botonNV busqueda" name="b_serviciosSNV" id="b_serviciosSNV" style="display:none;"> </button>
            </th>
            <th class="titulosTabs" align="center" style="color:white;">DEPARTAMENTO</th>
            <th class="titulosTabs" align="center" style="color:white;" width="60px">PRECIO</th>
            <th class="titulosTabs" align="center" nowrap style="color:white;">BENEFICIO</th>
          </tr>
        </thead> <tbody> <tr> <td class="dataTables_empty">Cargando datos del servidor</td> </tr> </tbody> </table>
        </td>
      </tr>
    <tr>
        <td> <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
                <td width="25%">
                <table width="100%"border="0"cellspacing="2"cellpadding="2">
                <tr>
                	<td class="titulosTabs" width="1%" nowrap>Subtotal($)</td>
                	<td><input name="subtotalS_NV" type="text" id="subtotalS_NV" value="0" readonly class="cero"></td>
                </tr>
                </table>
                </td>
                <td width="25%">
                <table width="100%"border="0"cellspacing="2"cellpadding="2">
                <tr>
                	<td class="titulosTabs"width="1%"nowrap>Cargo adicional($)</td>
                    <td>
                    <input name="cargoAdS_NV" type="text" id="cargoAdS_NV" value="" readonly class="cero" placeholder="0" onKeyUp="numeros_decimales(this.value, this.name);">
                    </td>
                </tr>
                </table>
                </td>
                <td width="25%">
                <table width="100%"border="0"cellspacing="2"cellpadding="2">
                <tr>
                	<td class="titulosTabs" width="1%" nowrap>Total($)</td>
                    <td><input name="totalS_NV" type="text" id="totalS_NV" value="0" readonly class="cero"></td>
                </tr>
                </table>
                </td>
            </tr>
        </table> </td>
    </tr>
      <tr>
        <td>
            <table width="100%" border="0" cellspacing="2" cellpadding="2">
            <tr> <td class="titulosTabs"width="1%">Observaciones</td> <td><input name="observacionesS_NV" id="observacionesS_NV" type="text" onKeyUp="conMayusculas(this); solo_letras_numeros(this.value, this.name);"></td> </tr>
            </table>
        </td>
    </tr>
    </tbody>
  </table>
  </div>
  
  <div class="miTab" id="tabs-6">
  <table class="tTabs" width="100%" height="100%" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#EEE">
    <tbody align="left">
      <tr>
        <td id="contenedorTNV">
        <table width="100%" height="100%" border="0" cellpadding="4" cellspacing="0" id="dataTableTotalesNV" class="tablilla"> <thead id="cabecera_tBusquedaTotalesNV">
          <tr style="font-size:0.9em;" bgcolor="#FF6633">
            <th id="clickmeT" class="titulosTabs" align="center" style="color:white;">#</th>
            <th class="titulosTabs" align="center" style="color:white;">CONCEPTO</th>
            <th class="titulosTabs" align="center" style="color:white;">TIPO</th>
            <th class="titulosTabs" align="center" style="color:white;">ÁREA</th>
            <th class="titulosTabs" align="center" nowrap style="color:white;">PRECIO</th>
            <th class="titulosTabs" align="center" nowrap style="color:white;">BENEFICIO</th>
          </tr>
        </thead> <tbody> <tr> <td class="dataTables_empty">Cargando datos del servidor</td> </tr> </tbody> </table>
        </td>
      </tr>
      <tr>
        <td>
        <table width="100%" border="0" cellspacing="2" cellpadding="2">
          <tr>
          	<td class="titulosTabs">Total consulta($)</td> 
            <td class="titulosTabs">Total imagen($)</td> 
            <td class="titulosTabs">Total laboratorio($)</td> 
            <td class="titulosTabs">Total endoscopía($)</td> 
            <td class="titulosTabs">Total servicios($)</td> </tr>
          <tr>
          	<td><input name="totalC_T_NV" type="text" id="totalC_T_NV" value="0" readonly class="cero"></td>
            <td><input name="totalI_T_NV" type="text" id="totalI_T_NV" value="0" readonly class="cero"></td> 
          	<td><input name="totalL_T_NV" type="text" id="totalL_T_NV" value="0" readonly class="cero"></td> 
            <td><input name="totalE_T_NV" type="text" id="totalE_T_NV" value="0" readonly class="cero"></td> 
            <td><input name="totalS_T_NV" type="text" id="totalS_T_NV" value="0" readonly class="cero"></td>
          </tr>
        </table>
        </td>
      </tr>
      <tr>
        <td>
        <table width="100%" border="0" cellspacing="2" cellpadding="2">
          <tr>
            <td class="titulosTabs" align="center">&nbsp;</td>
            <td class="titulosTabs" align="center"><!--Saldo($) --></td>
            <td class="titulosTabs" align="center" width="20%">Total a pagar($)</td>
          </tr>
          <tr>
            <td><!--<input name="pagoT_NV"id="pagoT_NV"type="text"onKeyUp="numeros_decimales(this.value, this.name);"onBlur="campos(this.value, this.id);" class="required"> -->
            </td>
            <td align="right" style="padding-right:15px;">
            <button id="pagarOV" style="display:none;">PAGAR</button>
            <!--<input name="saldoT_NV" type="text" id="saldoT_NV" value="0" readonly class="cero"> -->
            </td>
            <td><input name="totalPagarT_NV" type="text" id="totalPagarT_NV"value="0" readonly class="cero"></td>
          </tr>
        </table>
        </td>
      </tr>
    </tbody>
  </table>
  </div>
  
  <div class="miTab" id="tabs-7">
  <table class="tTabs" width="100%" height="100%" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#EEE">
    <tbody align="left">
      <tr>
        <td height="1%"> 
        <table width="100%" height="100%" border="0" cellspacing="2" cellpadding="2">
          <tr valign="top"> <td class="titulosTabs" width="1%" nowrap>Realizar un pago a la orden de venta</td> <td align="left"><button class="botonNV agregar" name="b_pagosOVNV" id="b_pagosOVNV"> </button></td> </tr>
        </table>
        </td>
      </tr>
      <tr>
        <td>
        <table width="100%" height="100%" border="0" cellpadding="4" cellspacing="0" id="dataTablePagosNV" class="tablilla"> <thead id="cabecera_tBusquedaPagosNV">
          <tr style="font-size:1.2em;" bgcolor="#FF6633">
            <th id="clickmePa" class="titulosTabs" align="center">#</th>
            <th class="titulosTabs" align="center">FECHA</th>
            <th class="titulosTabs" align="center">USUARIO</th>
            <th class="titulosTabs" align="center">TOTAL</th>
            <th class="titulosTabs" align="center" nowrap>SALDO ANTERIOR</th>
            <th class="titulosTabs" align="center" nowrap>PAGO</th>
            <th class="titulosTabs" align="center" nowrap>SALDO</th>
            <th class="titulosTabs" align="center" nowrap>ELIMINAR</th>
            <th class="titulosTabs" align="center" nowrap>TICKET</th>
          </tr>
        </thead> <tbody> <tr> <td class="dataTables_empty">Cargando datos del servidor</td> </tr> </tbody> </table>
        </td>
        </tr>
    </tbody>
  </table>
  </div>
  
  <div class="miTab" id="tabs-8">
  <input name="id_medicoEn" id="id_medicoEn" type="hidden" value="">
  <input name="id_medicoEnT" id="id_medicoEnT" type="hidden" value="">
  <input name="idConBeneE" id="idConBeneE" type="hidden" value="">
  <input name="idConBeneET" id="idConBeneET" type="hidden" value="">
  
  <input name="id_DepartamentoEn" id="id_DepartamentoEn" type="hidden" value="15">
  <table class="tTabs" width="100%" height="100%" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#EEE">
    <tbody align="left">
      <tr>
        <td height="1px"> 
        <table width="100%" border="0" cellspacing="0" cellpadding="2">
          <tr> 
          	<td width="1%" align="right" class="titulosTabs">Médico</td> <td align="left" width="1%">
            	<button class="botonNV busqueda" name="b_medicoEndoscopiaNV" id="b_medicoEndoscopiaNV"> </button>
            </td> 
          	<td align="left" width="1%">
            	<button class="botonNV eliminacion" name="b_eliminarEnNV" id="b_eliminarEnNV" style="display:none;"> </button>
            </td>
            <td>
            	<input name="medicoEn_NV" id="medicoEn_NV" type="text" readonly style="padding-left:5px;">
                <input name="medicoEn_NVT" id="medicoEn_NVT" type="hidden" value="">
            </td>
           </tr>
        </table>
        </td>
      </tr>
      <tr>
        <td id="contenedorENDV">
        <table width="100%" height="100%" border="0" cellpadding="4" cellspacing="0" id="dataTableEstudiosE" class="tablilla"> <thead id="cabecera_tBusquedaEstudiosE">
          <tr style="font-size:0.9em;" bgcolor="#FF6633">
            <th id="clickmeE" class="titulosTabs" align="center" style="color:white;" width="15px">#</th>
            <th class="titulosTabs" align="center" style="color:white;">
            	ESTUDIO&nbsp;
                <button class="botonNV busqueda" name="b_estudiosEndoNV" id="b_estudiosEndoNV" style="display:none;"> </button>
            </th>
            <th class="titulosTabs" align="center" style="color:white;">ÁREA</th>
            <th class="titulosTabs" align="center" style="color:white;" width="60px">PRECIO</th>
            <th class="titulosTabs" align="center" style="color:white;" width="">BENEFICIO</th>
          </tr>
        </thead> <tbody style="font-size:11px;"> <tr> <td class="dataTables_empty">Cargando datos del servidor</td> </tr> </tbody> 
       	</table>
        </td>
      </tr>
      <tr>
        <td> 
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
        	<tr>
                <td width="33.3%">
                	<table width="100%"border="0"cellspacing="2"cellpadding="2"><tr>
                    <td class="titulosTabs" width="90px" nowrap>Subtotal($)</td>
                    <td><input name="subtotalE_NV" type="text" id="subtotalE_NV" value="0" readonly class="cero"></td>
                    </tr></table>
                </td>
                <td width="33.3%">
                    <table width="100%"border="0"cellspacing="2"cellpadding="2"><tr>
                    <td class="titulosTabs"width="1%"nowrap>Cargo adicional($)</td>
                    <td>
                    	<input name="cargoAdE_NV" type="text" id="cargoAdE_NV" value="" readonly class="cero" placeholder="0" onKeyUp="numeros_decimales(this.value, this.name);">
                    </td>
                    </tr></table>
                </td>
                <td width="">
                    <table width="100%"border="0"cellspacing="2"cellpadding="2"><tr>
                    <td class="titulosTabs" width="1%" nowrap>Total($)</td>
                    <td><input name="totalE_NV" type="text" id="totalE_NV" value="0" readonly class="cero"></td>
                    </tr></table>
                </td>
            </tr>
        </table>
        </td>
      </tr>
      <tr>
        <td>
        <table width="100%" border="0" cellspacing="2" cellpadding="2">
          <tr><td class="titulosTabs"width="160px">Observaciones</td></tr>
          <tr> <td colspan="3"><input name="observacionesE_NV" id="observacionesE_NV" type="text" onKeyUp="conMayusculas(this); solo_letras_numeros(this.value, this.name);"></td> </tr>
        </table>
        </td>
      </tr>
    </tbody>
  </table>
  </div>
  
</form>
</div>
</body>
</html>
