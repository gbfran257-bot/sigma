<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Documento sin título</title>
<script src="../../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<link href="../../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css">
</head>

<body>

<div id="fichaMedicamento" style="font-size:14px;">

<div>
  <ul id="pestanas" style="float:left;">
    <li><a class="tabs" id="tabs-1-1" href="#tabs-1" style="color:; background-color:;">GENERALES</a></li>
    <li><a class="tabs" id="tabs-2-1" href="#tabs-2" style="color:; background-color:;">GENÉRICOS</a></li>
    <li><a class="tabs" id="tabs-3-1" href="#tabs-3" style="color:; background-color:;">VÍA ADMINISTRACIÓN Y DOSIS</a></li>
    <li><a class="tabs" id="tabs-5-1" href="#tabs-5" style="color:; background-color:;">BENEFICIOS</a></li>
    <li><a class="tabs" id="tabs-4-1" href="#tabs-4" style="color:; background-color:;">EXPEDIENTE</a></li>
  </ul>
  <table id="botonesPac" style="float:right;" height="40px" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td class="botonesSaveP"><button id="savePac" class="botonP">Guardar</button></td>
    <td class="botonesSaveP"><button id="cancelSavePac" class="botonP">Cancelar</button></td>
    <td class="botonesUpdateP"><button id="editarPac" class="botonP">Editar</button></td>
    <td class="botonesUpdateP"><button id="cancelEditPac" class="botonP">Cancelar</button></td>
    <td class="botonesUpdateP"><button id="updatePac" class="botonP">Actualizar</button></td>
  </tr>
</table>
</div>

 <form action="" method="post" name="formGenerales" id="formGenerales" target="_self">
 <input name="nombreFotoT" id="nombreFotoT" type="hidden" value=""> <input name="hayFoto" id="hayFoto" type="hidden" value="0">
 <input name="idPacienteN" type="hidden" id="idPacienteN">  <input name="idUsuarioP" id="idUsuarioP" class="idUsuarioP" type="hidden" value="">
  <div class="miTab" id="tabs-1">
    <table class="t_uno" width="100%" height="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="">
      <tr>
        <td>
        <table width="100%" border="0" cellspacing="0" cellpadding="4">
          <tr>
          	<td width="1%" nowrap>Nombre comercial</td>
            <td width="">
            <input name="nombreP" id="nombreP" type="text" onKeyUp="conMayusculas(this); solo_letras(this.value, this.name);" class="required" value="" placeholder="">
            </td>
          </tr>
        </table>
        </td>
        <td style="border:1px none red;" width="25%" rowspan="5">

        <table width="100%" height="100%" border="0" cellspacing="2" cellpadding="2">
          <tr height="40px">
            <td><button id="upload">Agregar imagen</button></td>
          </tr>
          <tr valign="top">
            <td style="border:1px none gold;" id="miFotito"><ul id="gallery" style="border:1px none red; text-align:center;"> <!-- Cargar Fotos --> </ul></td>
          </tr>
          <!--<tr height="40px"> <td>&nbsp;</td> </tr>-->
        </table>
        
        </td>
      </tr>
      <tr>
        <td>
        <table width="100%" border="0" cellspacing="0" cellpadding="4">
          <tr>
          	<td width="1%" nowrap>Medicamento genérico <button class="botona" id="bMedicamentoG">&nbsp;</button></td>
            <td>
            	<input name="medicamentoGen" id="medicamentoGen" type="text"readonly class="required" placeholder="">
                
                <input name="idMedicamentoGt" type="hidden" value="" id="idMedicamentoGt">
                <input name="medicamentoGt" type="hidden" value="" id="medicamentoGt">
                <input name="idMedicamentoG" type="hidden" value="" id="idMedicamentoG">
            </td>
          </tr>
        </table>
        </td>
        <!--<td></td> -->
      </tr>
      <tr>
        <td>
        <table width="100%" border="0" cellspacing="2" cellpadding="2">
          <tr>
          	<td width="1%" nowrap>Código de barras</td>
            <td>
            <input name="codigo_barras" type="text" class="" id="codigo_barras" onKeyUp="conMayusculas(this); solo_letras_numeros(this.value, this.name);" size="" maxlength="" placeholder="">
          </tr>
        </table>
        </td>
        <!--<td></td> -->
      </tr>
      <tr>
        <td>
        <table width="100%" border="0" cellspacing="0" cellpadding="4">
          <tr>
            <td width="1%" nowrap>
            Costo ($)
            </td>
            <td>
            <input name="costoMedi" type="text" id="costoMedi" onKeyUp="numeros_decimales(this.value, this.name);" maxlength="8" placeholder="">
            </td>
            <td width="1%" nowrap>
            Precio de membresía ($)
            </td>
            <td>
            <input name="precioMembresia" type="text" id="precioMembresia" onKeyUp="numeros_decimales(this.value, this.name);" maxlength="8" placeholder="">
            </td>
            <td width="1%" nowrap>
            	Precio público ($)
            </td>
            <td>
            <input name="precioPublico" type="text" id="precioPublico" onKeyUp="numeros_decimales(this.value, this.name);" maxlength="8" placeholder="">
            </td>
          </tr>
        </table>
        </td>
        <!--<td></td> -->
      </tr>
      <tr>
        <td>
        <table width="100%" border="0" cellspacing="0" cellpadding="4">
          <tr>
            <td width="1%" nowrap>
            	Precio de hospital ($)
            </td>
            <td>
            <input name="precioHospi" type="text" id="precioHospi" onKeyUp="numeros_decimales(this.value, this.name);" maxlength="8" placeholder="">
            </td>
            <td width="1%">
            Nivel
            </td>
            <td>
            <select name="nivelMedi" id="nivelMedi" class="">
              <option value="">-SELECCIONAR-</option>
              <option value="1">NIVEL 1</option>
              <option value="2">NIVEL 2</option>
              <option value="3">NIVEL 3</option>
            </select>
            </td>
          </tr>
        </table>
        </td>
        <!--<td></td> -->
      </tr>
    </table>
  </div>
  
  <div class="miTab" id="tabs-2">
  	<table class="t_uno" width="100%" height="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="">
      <tr align="left">
        <td>
        <table width="100%" height="100%" border="0" cellspacing="2" cellpadding="2">
          <tr>
            <td class="titulosTabs" width="1%" nowrap>Descripción</td>
            <td>
            <input name="descripcionM" type="text" id="descripcionM" onKeyUp="" maxlength="" readonly placeholder="">
            </td>
            <td class="titulosTabs" width="1%" nowrap>Cantidad</td>
            <td>
            <input name="cantidadM" type="text" id="cantidadM" onKeyUp="" maxlength="" readonly placeholder="">
            </td>
            <td class="titulosTabs" width="1%" nowrap>Grupo</td>
            <td>
            <input name="grupoM" type="text" id="grupoM" onKeyUp="" maxlength="" readonly placeholder="">
            </td>
          </tr>
        </table>
        </td>
      </tr>
      <tr align="left">
        <td>
        <table width="100%" height="100%" border="0" cellspacing="2" cellpadding="2">
          <tr>
            <td class="titulosTabs" width="1%" nowrap>Presentación</td>
            <td>
            <input name="presentacionM" type="text" id="presentacionM" onKeyUp="" maxlength="" readonly placeholder="">
            </td>
            <td class="titulosTabs" width="1%" nowrap>Nivel</td>
            <td>
            <input name="nivelM" type="text" id="nivelM" onKeyUp="" maxlength="" readonly placeholder="">
            </td>
          </tr>
        </table>
        </td>
      </tr>
    </table>
  </div>
  
  <div class="miTab" id="tabs-3">
  	<table class="t_uno" width="100%" height="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="">
    	<tr align="left">
        <td>
        <table width="100%" height="100%" border="0" cellspacing="2" cellpadding="2">
          <tr>
            <td class="titulosTabs" width="1%" nowrap valign="top">Vía de administración</td>
            <td width=""> 
            <textarea name="viaAdmin" cols="" rows="4" id="viaAdmin" style="resize:none; height:80%"></textarea>
            </td>
          </tr>
        </table>
        </td>
      </tr>
    </table>
  </div>
  
  <div class="miTab" id="tabs-5">
  <table class="t_uno" width="100%" height="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="">
      <tr align="left" id="contenedorTablaC">
        <td>
        <table width="100%" cellspacing="0" id="dataTableC" height="100%" border="0" cellpadding="5" class="tablilla">
            <thead>
              <tr style="color:white; background-color:#; font-size:0.9em;" bgcolor="#FF6633">
                <th class="titulosTabs" align="center" id="miClick1" style="color:white;">
                	BENEFICIO&nbsp;<button id="addConvenio">AGREGAR BENEFICIO AL PACIENTE</button>
                </th>
                <th class="titulosTabs" align="center" nowrap style="color:white;">FECHA EXPEDICIÓN</th>
                <th class="titulosTabs" align="center" nowrap style="color:white;">FECHA EXPIRACIÓN</th>
                <th class="titulosTabs" align="center" nowrap style="color:white;">ESTATUS</th>
                <th class="titulosTabs" align="center" nowrap style="color:white;">DÍAS(-)</th>
                <th class="titulosTabs" align="center" style="color:white;">ELIMINAR</th>
              </tr>
            </thead>
            <tbody align="left" style="color:black; font-size:0.9em;">
                <tr>
                    <td class="dataTables_empty">Cargando datos del servidor</td>
                </tr>
            </tbody>
          </table>
        </td>
      </tr>
    </table>
  </div>

<div class="miTab" id="tabs-4" style="overflow:; border:1px none red;">

<div id="miTabsH" style="float:left; display:block; border:1px none red; width:100%; height:100%;">
<table width="100%" border="0" cellspacing="0" cellpadding="2" bgcolor="">
  <tr>
    <td id="">
    <ul id="pestanas1" style="float:left;">
        <li><a class="tabs" id="tabs-1-1h" href="#tabs-1h" style="color:; background-color:;">S-V</a></li>
        <li><a class="tabs" id="tabs-2-1h" href="#tabs-2h" style="color:; background-color:;">H-C</a></li>
        <li><a class="tabs" id="tabs-3-1h" href="#tabs-3h" style="color:; background-color:;">CONSULTAS</a></li>
        <li><a class="tabs" id="tabs-4-1h" href="#tabs-4h" style="color:; background-color:;">IMAGEN</a></li>
        <li><a class="tabs" id="tabs-5-1h" href="#tabs-5h" style="color:; background-color:;">LABORATORIO</a></li>
        <li style="display:none;"><a class="tabs" id="tabs-6-1h" href="#tabs-6h"style="color:;background-color:;">ENDOSCOPÍA</a></li>
        <li><a class="tabs" id="tabs-7-1h" href="#tabs-7h" style="color:; background-color:;">SERVICIOS</a></li>
    </ul>
    </td>
  </tr>
</table>

<div class="miTab" id="tabs-1h">

</div>
<div class="miTab" id="tabs-2h">

</div>
<div class="miTab" id="tabs-3h">
<table width="100%" height="93%" border="0" cellpadding="4" cellspacing="0" id="dataTableHCo" class="tablilla">
    <thead id="cabecera_tBusquedaHco" class="miCabeceraDT">
      <tr bgcolor="#FF6633">
        <th id="clickmeHCo" style="color:white;" width="1px">#</th>
        <th style="color:white;" width="10px">FECHA</th>
        <th style="color:white;" width="">CONSULTA</th>
        <th style="color:white;">MÉDICO ATENDIÓ</th>
      </tr>
    </thead>
    <tbody style="text-shadow:1px 1px 1px white;"> <tr> <td class="dataTables_empty">Cargando datos del servidor</td> </tr> </tbody>
  </table>
</div>
<div class="miTab" id="tabs-4h">
<table width="100%" height="93%" border="0" cellpadding="4" cellspacing="0" id="dataTableHIm" class="tablilla">
    <thead id="cabecera_tBusquedaHco" class="miCabeceraDT">
      <tr bgcolor="#FF6633">
        <th id="clickmeHIm" style="color:white;" width="1px">#</th>
        <th style="color:white;" width="10px">FECHA</th>
        <th style="color:white;" width="">ESTUDIO</th>
        <th style="color:white;">MÉDICO INTERPRETÓ</th>
      </tr>
    </thead>
    <tbody style="text-shadow:1px 1px 1px white;"> <tr> <td class="dataTables_empty">Cargando datos del servidor</td> </tr> </tbody>
  </table>
</div>
<div class="miTab" id="tabs-5h">
<table width="100%" height="93%" border="0" cellpadding="4" cellspacing="0" id="dataTableHLa" class="tablilla">
    <thead id="cabecera_tBusquedaHco" class="miCabeceraDT">
      <tr bgcolor="#FF6633">
        <th id="clickmeHLa" style="color:white;" width="1px">#</th>
        <th style="color:white;" width="10px">FECHA</th>
        <th style="color:white;" width="">ESTUDIO</th>
        <th style="color:white;">QUÍMICO RESPONSABLE</th>
      </tr>
    </thead>
    <tbody style="text-shadow:1px 1px 1px white;"> <tr> <td class="dataTables_empty">Cargando datos del servidor</td> </tr> </tbody>
  </table>
</div>
<div class="miTab" id="tabs-6h">
<table width="100%" height="93%" border="0" cellpadding="4" cellspacing="0" id="dataTableHEn" class="tablilla">
    <thead id="cabecera_tBusquedaHco" class="miCabeceraDT">
      <tr bgcolor="#FF6633">
        <th id="clickmeHEn" style="color:white;" width="1px">#</th>
        <th style="color:white;" width="10px">FECHA</th>
        <th style="color:white;" width="130px">ESTUDIO</th>
        <th style="color:white;">MÉDICO REALIZÓ</th>
      </tr>
    </thead>
    <tbody style="text-shadow:1px 1px 1px white;"> <tr> <td class="dataTables_empty">Cargando datos del servidor</td> </tr> </tbody>
  </table>
</div>
<div class="miTab" id="tabs-7h">
<table width="100%" height="93%" border="0" cellpadding="4" cellspacing="0" id="dataTableHSe" class="tablilla">
    <thead id="cabecera_tBusquedaHco" class="miCabeceraDT">
      <tr bgcolor="#FF6633">
        <th id="clickmeHSe" style="color:white;" width="1px">#</th>
        <th style="color:white;" width="10px">FECHA</th>
        <th style="color:white;" width="">SERVICIO</th>
        <th style="color:white;">PERSONAL ATENDIÓ</th>
      </tr>
    </thead>
    <tbody style="text-shadow:1px 1px 1px white;"> <tr> <td class="dataTables_empty">Cargando datos del servidor</td> </tr> </tbody>
  </table>
</div>

</div>
</div>
  
</form>

</div>

<div id="conveniosP">
<table width="100%" cellspacing="0" id="dataTableC1" height="100%" border="0" cellpadding="5" class="tablilla">
<thead>
  <tr style="color:; background-color:; font-size:0.9em;" bgcolor="#FF6633">
    <th class="titulosTabs" align="center" id="miClick1" style="color:white;">BENEFICIO</th>
    <th class="titulosTabs" align="center" style="color:white;" nowrap>FECHA EXPEDICIÓN</th>
    <th class="titulosTabs" align="center" style="color:white;" nowrap>FECHA EXPIRACIÓN</th>
    <th class="titulosTabs" align="center" style="color:white;">ESTATUS</th>
    <th class="titulosTabs" align="center" style="color:white;" nowrap>DÍAS(-)</th>
  </tr>
</thead>
<tbody align="left" bgcolor="#FF6600">
    <tr>
        <td class="dataTables_empty">Cargando datos del servidor</td>
    </tr>
</tbody>
</table>
</div>

<div id="detallesConvenioP">
<table width="100%" cellspacing="0" id="dataTableDCP" height="100%" border="0" cellpadding="4" class="tablilla">
<thead>
  <tr style="color:; background-color:; font-size:1em;" bgcolor="#FF6633">
    <th class="titulosTabs" align="center" id="miClickDCP" style="color:white;">#</th>
    <th class="titulosTabs" align="center" style="color:white;">CONCEPTO</th>
    <th class="titulosTabs" align="center" style="color:white;">TIPO</th>
    <th class="titulosTabs" align="center" style="color:white;">DISPONIBILIDAD</th>
  </tr>
</thead>
<tbody align="left" bgcolor="#FF6600">
    <tr>
        <td class="dataTables_empty">Cargando datos del servidor</td>
    </tr>
</tbody>
</table>
</div>

</body>
</html>
