<form action="" method="post" name="formHospi" id="formHospi" target="_self" style="height:100%;">
<input name="id_paciente_hp" id="id_paciente_hp" type="hidden" class="required">
<input name="id_user_hp" id="id_user_hp" type="hidden" class="required">
<input name="id_consulta" id="id_consulta" type="hidden" class="required">
<table width="100%" height="100%" border="0" cellspacing="3" cellpadding="4" class="fondo_tab">
  <tr> <td align="left" valign="bottom">
    
    <table width="100%" height="1%" border="0" cellspacing="4" cellpadding="4">
      <tr>
        <td width="60%" nowrap>
        Médico tratante
  	<button id="asigna_mtratante" lang="" class="ui-button ui-widget ui-corner-all ui-button-icon-only" title=""><span class="ui-icon ui-icon-search"></span></button>
        </td>
        <td>Especialidad</td>
      </tr>
      <tr>
        <td>
        <input name="id_medico_tratante" id="id_medico_tratante" type="hidden" class="required">
  		<input name="nombre_medico_tratante" type="text" id="nombre_medico_tratante" class="campoITtab" readonly>
        </td>
        <td><input name="esp_medico_tratante" type="text" id="esp_medico_tratante" class="campoITtab" readonly></td>
      </tr>
    </table>
    
  </td> </tr>
  <tr> <td align="left" valign="bottom">
  	Cama
  	<button id="asigna_cama" lang="" class="ui-button ui-widget ui-corner-all ui-button-icon-only" title=""><span class="ui-icon ui-icon-search"></span></button>
    <input name="id_cama" id="id_cama" type="hidden" class="required">
  </td> </tr>
  <tr> <td align="left" valign="top">
  	<table width="100%" height="1%" border="0" cellspacing="4" cellpadding="4">
      <tr>
        <td width="1%" nowrap>Número de Cama</td>
        <td>Ubicación de la cama</td>
        <td>Área de la cama</td>
      </tr>
      <tr>
        <td> <input name="no_cama" type="text" id="no_cama" class="campoITtab" readonly> </td>
        <td> <input name="ubicacion_cama" type="text" id="ubicacion_cama" class="campoITtab" readonly> </td>
        <td><input name="area_cama" type="text" id="area_cama" class="campoITtab" readonly></td>
      </tr>
    </table>
  </td> </tr>
  <tr> <td align="left" valign="bottom">MOTIVO DE LA HOSPITALIZACIÓN</td> </tr>
  <tr> <td align="left" valign="top">
  <textarea name="motivo_h" id="motivo_h" style="width:99.5%; min-height:70px; resize:none; max-height:270px; height:100px;" class="required campoITtab" onKeyUp="conMayusculas(this); solo_letras_numeros(this.value, this.name);"></textarea>
  </td> </tr>
</table>
</form>