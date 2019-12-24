<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Documento sin título</title>
</head>

<body>

<div id="tabs_hc" style="width:100%; height:99%;">
<form action="" method="post" name="formHistoriaClinica" id="formHistoriaClinica" target="_self" style="height:100%">
<input name="idUsuario_hc" id="idUsuario_hc" type="hidden" value=""> <input name="idPaciente_hc" id="idPaciente_hc" type="hidden" value="">
<table width="100%" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td>
    <ul>
        <li><a id="tabs-1-1" href="#tabs-1" style="color:white; background-color:;">AHF</a></li>
        <li><a id="tabs-2-1" href="#tabs-2" style="color:white; background-color:;">APNP</a></li>
        <li><a id="tabs-3-1" href="#tabs-3" style="color:white; background-color:;">APP</a></li>
        <li><a id="tabs-4-1" href="#tabs-4" style="color:white; background-color:;">AGO</a></li>
        <li><a id="tabs-5-1" href="#tabs-5" style="color:white; background-color:;">HISTORIAL</a></li>
    </ul>
    </td>
    <td align="right" style="padding-right:20px;">
    <button id="updateHC">Actualizar</button>
    </td>
  </tr>
</table>
  
  <div id="tabs-1" style="width:97.5%; height:90%; color:white;">
  <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="2">
    <tr>
      <td width="80px" align="left"><h2>Padre</h2></td>
      <td> <select class="estatusVive selectHC" name="estatus_padre" id="estatus_padre"> </select> </td>
      <td> <select class="enfermedad selectHC" name="ahf_padre_1" id="ahf_padre_1"> </select></td>
      <td> <select class="enfermedad selectHC" name="ahf_padre_2" id="ahf_padre_2"> </select></td>
      <td> <select class="enfermedad selectHC" name="ahf_padre_3" id="ahf_padre_3"> </select></td>
      <td> <select class="enfermedad selectHC" name="ahf_padre_4" id="ahf_padre_4"> </select> </td>
      </tr>
    <tr>
      <td align="left"><h2>Madre</h2></td>
      <td> <select class="estatusVive selectHC" name="estatus_madre" id="estatus_madre"> </select> </td>
      <td> <select class="enfermedad selectHC" name="ahf_madre_1" id="ahf_madre_1"> </select></td> 
      <td> <select class="enfermedad selectHC" name="ahf_madre_2" id="ahf_madre_2"> </select></td>
      <td> <select class="enfermedad selectHC" name="ahf_madre_3" id="ahf_madre_3"> </select></td>
      <td> <select class="enfermedad selectHC" name="ahf_madre_4" id="ahf_madre_4"> </select></td>
    </tr>
    <tr>
      <td align="left"><h2>Hermanos</h2></td>
      <td> 
      	<select name="noHnos" id="noHnos" class="selectHC"> <option value="">-NÚMERO-</option> <option value="0">0</option> <option value="1">1</option> <option value="2">2</option> <option value="3">3</option> <option value="4">4</option> <option value="5">5</option>
        <option value="6">6</option> <option value="7">7</option> <option value="8">8</option> <option value="9">9</option> <option value="10">10+</option> </select>
      </td>
      <td> <select class="enfermedad selectHC" name="ahf_hnos_1" id="ahf_hnos_1"> </select></td>
      <td> <select class="enfermedad selectHC" name="ahf_hnos_2" id="ahf_hnos_2"> </select></td>
      <td> <select class="enfermedad selectHC" name="ahf_hnos_3" id="ahf_hnos_3"> </select></td>
      <td> <select class="enfermedad selectHC" name="ahf_hnos_4" id="ahf_hnos_4"> </select></td>
    </tr>
    <tr>
      <td align="left"><h2>Conyugue</h2></td>
      <td> <select class="estatusVive selectHC" name="estatus_conyugue" id="estatus_conyugue"> </select> </td>
      <td> <select class="enfermedad selectHC" name="ahf_conyugue_1" id="ahf_conyugue_1"> </select></td>
      <td> <select class="enfermedad selectHC" name="ahf_conyugue_2" id="ahf_conyugue_2"> </select></td>
      <td> <select class="enfermedad selectHC" name="ahf_conyugue_3" id="ahf_conyugue_3"> </select></td>
      <td> <select class="enfermedad selectHC" name="ahf_conyugue_4" id="ahf_conyugue_4"> </select></td>
    </tr>
    <tr>
      <td align="left"><h2>Hijos</h2></td>
      <td> 
      	<select name="noHijos" id="noHijos" class="selectHC"> <option value="">-NÚMERO-</option> <option value="0">0</option> <option value="1">1</option> <option value="2">2</option> <option value="3">3</option> <option value="4">4</option> <option value="5">5</option>
        <option value="6">6</option> <option value="7">7</option> <option value="8">8</option> <option value="9">9</option> </select>
      </td>
      <td> <select class="enfermedad selectHC" name="ahf_hijos_1" id="ahf_hijos_1"> </select></td>
      <td> <select class="enfermedad selectHC" name="ahf_hijos_2" id="ahf_hijos_2"> </select></td>
      <td> <select class="enfermedad selectHC" name="ahf_hijos_3" id="ahf_hijos_3"> </select></td>
      <td> <select class="enfermedad selectHC" name="ahf_hijos_4" id="ahf_hijos_4"> </select></td>
    </tr>
    <tr>
      <td align="left"><h2>Notas</h2></td>
      <td colspan="5"> <input class="textHC" name="ahf_notas" type="text" id="ahf_notas" value="" onKeyUp="conMayusculas(this); solo_letras_numeros(this.value, this.name);"> </td>
    </tr>
  </table>
  </div>
  
  <div id="tabs-2" style="width:97.5%; height:90%; color:white;">
  <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="2">
    <tr>
      <td width="80px" align="left"><h2>Adicciones</h2></td>
      <td> <select class="adiccion selectHC" name="adiccion1" id="adiccion1"> </select> </td>
      <td> <select class="adiccion selectHC" name="adiccion2" id="adiccion2"> </select> </td>
      <td> <select class="adiccion selectHC" name="adiccion3" id="adiccion3"> </select> </td>
      <td align="right"><h2>Deportes</h2></td>
      <td> <select class="deporte selectHC" name="deporte1" id="deporte1"> </select> </td>
      <td> <select class="deporte selectHC" name="deporte2" id="deporte2"> </select> </td>
    </tr>
    <tr>
      <td align="left"><h2>Inicio</h2></td>
      <td> <select class="inicio selectHC" name="inicio_adiccion1" id="inicio_adiccion1"> </select> </td>
      <td> <select class="inicio selectHC" name="inicio_adiccion2" id="inicio_adiccion2"> </select> </td>
      <td> <select class="inicio selectHC" name="inicio_adiccion3" id="inicio_adiccion3"> </select> </td>
      <td align="right"><h2>Frecuencia</h2></td>
      <td> <select class="frecuencia selectHC" name="frecuencia_deporte1" id="frecuencia_deporte1"> </select> </td>
      <td> <select class="frecuencia selectHC" name="frecuencia_deporte2" id="frecuencia_deporte2"> </select> </td>
    </tr>
    <tr>
      <td align="left"><h2>Frecuencia</h2></td>
      <td> <select class="frecuencia selectHC" name="frecuencia_adiccion1" id="frecuencia_adiccion1"> </select> </td>
      <td> <select class="frecuencia selectHC" name="frecuencia_adiccion2" id="frecuencia_adiccion2"> </select> </td>
      <td> <select class="frecuencia selectHC" name="frecuencia_adiccion3" id="frecuencia_adiccion3"> </select> </td>
      <td align="right"><h2>Notas</h2></td>
      <td colspan="2"> <input class="textHC" name="apnp_notas" type="text" id="apnp_notas" value="" size="30" onKeyUp="conMayusculas(this); solo_letras_numeros(this.value, this.name);"> </td>
    </tr>
    <tr>
      <td align="left"><h2>Recreación</h2></td>
      <td> <select class="recreacion selectHC" name="recreacion1" id="recreacion1"> </select> </td>
      <td> <select class="recreacion selectHC" name="recreacion2" id="recreacion2"> </select> </td>
      <td> <select class="recreacion selectHC" name="recreacion3" id="recreacion3"> </select> </td>
      <td> <select class="recreacion selectHC" name="recreacion4" id="recreacion4"> </select> </td>
      <td> <select class="recreacion selectHC" name="recreacion5" id="recreacion5"> </select> </td>
      <td> <select class="recreacion selectHC" name="recreacion6" id="recreacion6"> </select></td>
    </tr>
    <tr>
      <td align="left"><h2>Vivienda</h2></td>
      <td> <select name="vivienda_hc" id="vivienda_hc" class="selectHC"> </select> </td>
      <td align="right"><h2>Habitantes</h2></td>
      <td> 
      	<select name="habitantes" id="habitantes" class="selectHC"> 
        	<option value="">-NÚMERO-</option> 
            <option value="0">0</option> 
            <option value="1">1</option> 
            <option value="2">2</option> 
            <option value="3">3</option> 
            <option value="4">4</option> 
            <option value="5">5</option>
        	<option value="6">6</option> 
            <option value="7">7</option> 
            <option value="8">8</option> 
            <option value="9">9</option> 
            <option value="10">10+</option> 
        </select> 
      </td>
      <td nowrap align="right"><h2>Material Vivienda</h2></td>
      <td colspan="2"><table width="100%" height="100%" border="0" cellspacing="2" cellpadding="2"> 
      	<tr> <td><select class="matV selectHC" name="mat_vivienda1" id="mat_vivienda1"> </select></td> <td> <select class="matV selectHC" name="mat_vivienda2" id="mat_vivienda2"> </select></td> 
        </tr> </table> </td>
      </tr>
    <tr>
      <td align="left"><h2>Servicios</h2></td>
      <td> <select class="servicio_hc selectHC" name="servicios1_hc" id="servicios1_hc"> </select> </td>
      <td> <select class="servicio_hc selectHC" name="servicios2_hc" id="servicios2_hc"> </select> </td>
      <td> <select class="servicio_hc selectHC" name="servicios3_hc" id="servicios3_hc"> </select> </td>
      <td> <select class="servicio_hc selectHC" name="servicios4_hc" id="servicios4_hc"> </select> </td>
      <td align="right"><h2>Aseo Personal</h2></td>
      <td align="left"> <select class="selectHC" name="aseo_personal" id="aseo_personal"> </select> </td>
    </tr>
    <tr>
      <td align="left"><h2>Vacunas</h2></td>
      <td> <select class="vacuna" name="vacunas1" id="vacunas1"> </select> </td>
      <td> <select class="vacuna" name="vacunas2" id="vacunas2"> </select> </td>
      <td> <select class="vacuna" name="vacunas3" id="vacunas3"> </select> </td>
      <td align="right"><h2>Observaciones</h2></td>
      <td colspan="2"> <input name="observacionesVacunas" type="text" id="observacionesVacunas" value="" size="30" onKeyUp="conMayusculas(this); solo_letras_numeros(this.value, this.name);"> </td>
    </tr>
    <tr>
      <td align="left"><h2>hrs/Dormir</h2></td>
      <td> 
      	<select name="hrs_dormir" id="hrs_dormir"> <option value="">-NÚMERO-</option> <option value="0">0</option> <option value="1">1</option> <option value="2">2</option> <option value="3">3</option> <option value="4">4</option> <option value="5">5</option>
        <option value="6">6</option> <option value="7">7</option> <option value="8">8</option> <option value="9">9</option> <option value="10">10+</option> </select> 
      </td>
      <td align="right"><h2>Alimentación</h2></td>
      <td> <select name="alimentacion_hc" id="alimentacion_hc"> </select> </td>
      <td align="right"><h2>Mascotas</h2></td>
      <td> <select class="mascota" name="mascota1" id="mascota1"> </select> </td>
      <td> <select class="mascota" name="mascota2" id="mascota2"> </select> </td>
      </tr>
  </table>
  </div>
  
  <div id="tabs-3" style="width:97.5%; height:90%; color:white;">
  <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="2">
    <tr>
      <td width="80px" align="left"><h2>Enfermedad</h2></td>
      <td> <select class="enfermedad" name="enfermedad1" id="enfermedad1"> </select></td>
      <td> <select class="enfermedad" name="enfermedad2" id="enfermedad2"> </select></td>
      <td> <select class="enfermedad" name="enfermedad3" id="enfermedad3"> </select></td>
      <td> <select class="enfermedad" name="enfermedad4" id="enfermedad4"> </select></td>
      <td> </td>
      </tr>
    <tr>
      <td align="left"><h2>Cirugías</h2></td>
      <td> <input name="cirugia1" type="text" id="cirugia1" value="" size="15" onKeyUp="conMayusculas(this); solo_letras_numeros(this.value, this.name);"></td>
      <td> <input name="cirugia2" type="text" id="cirugia2" value="" size="15" onKeyUp="conMayusculas(this); solo_letras_numeros(this.value, this.name);"></td>
      <td> <input name="cirugia3" type="text" id="cirugia3" value="" size="15" onKeyUp="conMayusculas(this); solo_letras_numeros(this.value, this.name);"></td>
      <td align="right"><h2>Transfusiones</h2></td>
      <td>
      	<select name="transfusiones" id="transfusiones"> <option value="">-NÚMERO-</option> <option value="0">0</option> <option value="1">1</option> <option value="2">2</option> <option value="3">3</option> <option value="4">4</option> <option value="5">5</option>
        <option value="6">6</option> <option value="7">7</option> <option value="8">8</option> <option value="9">9</option> <option value="10">10+</option> </select>
      </td>
      </tr>
    <tr>
      <td align="left"><h2>Notas</h2></td>
      <td colspan="5"> <input name="app_notas" type="text" id="app_notas" value="" size="80" onKeyUp="conMayusculas(this); solo_letras_numeros(this.value, this.name);"> </td>
    </tr>
  </table>
  </div>

  <div id="tabs-4" style="width:97.5%; height:90%; color:white;">
  <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="2">
    <tr>
      <td width="80px" align="left"><h2>Menarca</h2></td>
      <td> 
      	<select name="menarca" id="menarca"> <option value="">-EDAD-</option> <option value="8">8 AÑOS</option> <option value="9">9 AÑOS</option> <option value="10">10 AÑOS</option> <option value="11">11 AÑOS</option> <option value="12">12 AÑOS</option> 
        <option value="13">13 AÑOS</option> <option value="14">14 AÑOS</option> <option value="15">15 AÑOS</option> <option value="16">16 AÑOS</option> <option value="17">17 AÑOS</option> </select> 
      </td>
      <td align="right"><h2>Ritmo</h2></td>
      <td> <select name="ritmo" id="ritmo"> <option value="">-SELECCIONAR-</option> <option value="1">REGULAR</option> <option value="2">IRREGULAR</option> </select> </td>
      <td align="right"><h2>Duración</h2></td>
      <td> 
      	<select name="duracionR" id="duracionR"> <option value="">-DÍAS-</option> <option value="1">1 DÍA</option> <option value="2">2 DÍAS</option> <option value="3">3 DÍAS</option> <option value="4">4 DÍAS</option> <option value="5">5 DÍAS</option>
        <option value="6">6 DÍAS</option> <option value="7">7 DÍAS</option> <option value="8">8 DÍAS</option> </select> 
      </td>
    </tr>
    <tr>
      <td align="left"><h2>F.U.R.</h2></td>
      <td> <input name="fur" type="text" id="fur" value="" onKeyUp="conMayusculas(this); solo_letras_numeros(this.value, this.name);"></td>
      <td align="right"><h2>I.V.S.A.</h2></td>
      <td> 
      	<select name="ivsa" id="ivsa"> <option value="">-EDAD-</option> <option value="8">8 AÑOS</option> <option value="9">9 AÑOS</option> <option value="10">10 AÑOS</option> <option value="11">11 AÑOS</option> <option value="12">12 AÑOS</option> 
        <option value="13">13 AÑOS</option> <option value="14">14 AÑOS</option> <option value="15">15 AÑOS</option> <option value="16">16 AÑOS</option> <option value="17">17 AÑOS</option> <option value="18">18+ AÑOS</option> </select> 
      </td>
      <td align="right"><h2>Gestas</h2></td>
      <td> 
      	<select name="gestas" id="gestas"> <option value="">-NÚMERO-</option> <option value="0">0</option> <option value="1">1</option> <option value="2">2</option> <option value="3">3</option> <option value="4">4</option> <option value="5">5</option>
        <option value="6">6</option> <option value="7">7</option> <option value="8">8</option> <option value="9">9</option> <option value="10">10+</option> </select> 
      </td>
    </tr>
    <tr>
      <td align="left"><h2>Partos</h2></td>
      <td> 
      	<select name="partos" id="partos"> <option value="">-NÚMERO-</option> <option value="0">0</option> <option value="1">1</option> <option value="2">2</option> <option value="3">3</option> <option value="4">4</option> <option value="5">5</option>
        <option value="6">6</option> <option value="7">7</option> <option value="8">8</option> <option value="9">9</option> <option value="10">10+</option> </select> 
      </td>
      <td align="right"><h2>Cesareas</h2></td>
      <td> 
      	<select name="cesareas" id="cesareas"> <option value="">-NÚMERO-</option> <option value="0">0</option> <option value="1">1</option> <option value="2">2</option> <option value="3">3</option> <option value="4">4</option> <option value="5">5</option>
        <option value="6">6</option> <option value="7">7</option> <option value="8">8</option> <option value="9">9</option> <option value="10">10+</option> </select> 
      </td>
      <td align="right"><h2>Abortos</h2></td>
      <td> 
      	<select name="abortos" id="abortos"> <option value="">-NÚMERO-</option> <option value="0">0</option> <option value="1">1</option> <option value="2">2</option> <option value="3">3</option> <option value="4">4</option> <option value="5">5</option>
        <option value="6">6</option> <option value="7">7</option> <option value="8">8</option> <option value="9">9</option> <option value="10">10+</option> </select> 
      </td>
    </tr>
    <tr>
      <td align="left"><h2>Anticon.</h2></td>
      <td> <select name="anticonceptivo" id="anticonceptivo"> <option value="">-SELECCIONAR-</option> <option value="1">SI</option> <option value="0">NO</option> </select> </td>
      <td align="right"><h2>Tipo</h2></td>
      <td> <select name="tipo_anticon" id="tipo_anticon"> </select> </td>
      <td nowrap="nowrap" align="right"><h2>Tiempo uso</h2></td>
      <td><select name="tiempo_uso" id="tiempo_uso"> <option value="">-AÑOS-</option> <option value="1">1 AÑO</option> <option value="2">2 AÑOS</option> <option value="3">3 AÑOS</option> <option value="4">4 AÑOS</option> <option value="5">5+ AÑOS</option> </select> </td>
    </tr>
    <tr>
      <td align="left"><h2>D.O.C.</h2></td>
      <td> <input name="doc" type="text" id="doc" value="" onKeyUp="conMayusculas(this); solo_letras_numeros(this.value, this.name);"></td>
      <td align="right"><h2>Colposcopia</h2></td>
      <td> <input name="colposcopiaHC" type="text" id="colposcopiaHC" value="" onKeyUp="conMayusculas(this); solo_letras_numeros(this.value, this.name);"></td>
      <td align="right"><h2>Mastografía</h2></td>
      <td> <input name="mastografiaHC" type="text" id="mastografiaHC" value="" onKeyUp="conMayusculas(this); solo_letras_numeros(this.value, this.name);"></td>
    </tr>
    <tr>
      <td align="left"><h2>Notas</h2></td>
      <td colspan="5"> <textarea name="ago_notas" id="ago_notas" cols="60" rows="2" style="resize:none" onKeyUp="conMayusculas(this); solo_letras_numeros(this.value, this.name);"></textarea> </td>
    </tr>
    </table>
  </div>
  
  <div id="tabs-5" style="width:97.5%; height:90%;">
  
  </div>
  
</form>
</div>

</body>
</html>
