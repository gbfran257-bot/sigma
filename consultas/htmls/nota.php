<div id="ficha_estudio">
 <form action="" method="post" name="formEstudio" id="formEstudio" target="_self" style="height:100%;">
 <input name="idEstudioE" type="hidden" id="idEstudioE"> <input name="idusuarioNM" type="hidden" id="idusuarioNM">
  <div class="miTab" id="tabs-2">
  	<table width="100%" height="100%" border="0" cellspacing="2" cellpadding="4" class="grisecito">
      <tr align="left"> <td height="1px" nowrap>
      	<table width="100%" border="0" cellspacing="1" cellpadding="3">
          <tr>
            <td width="1%" nowrap>TÍTULO</td>
            <td width=""><input name="nombreNM"type="text"id="nombreNM"onKeyUp="conMayusculas(this); solo_letras_numeros(this.value, this.name);" class="required"></td>
            <td width="300px"><select name="area_nota" id="area_nota" class="required"> </select></td>
            <td width="150px"><select name="inserta_algo" id="inserta_algo" onChange="insertAtCaret(this.value);return false;">
              <option value="">-INSERTA-</option>
              <option value="{et_abitus}">ABITUS EXTERIOR</option>
              <option value="{et_adicciones}">ADICCIONES</option>
              <option value="{et_alergias}">ALERGIAS</option>
              <option value="{et_dx_ingreso}">DIAGNÓSTICO DE INGRESO</option>
              <option value="{et_edad}">EDAD</option>
              <option value="{et_fechaingreso}">FECHA DE INGRESO</option>
              <option value="{et_fechaegreso}">FECHA DE EGRESO</option>
              <option value="{et_fechahora}">FECHA Y HORA DE ELEBORACIÓN</option>
              <option value="{et_nombre_medico_atiende}">NOMBRE DEL MEDICO QUE ATIENDE</option>
              <option value="{et_nombre_paciente}">NOMBRE DEL PACIENTE</option>
              <option value="{et_pesotalla_g}">PESO Y TALLA</option>
              <option value="{et_puntuacion_g}">PUNTUACIÓN DE GLASGLOW</option>
              <option value="{et_sex}">SEXO</option>
              <option value="{et_sv}">SIGNOS VITALES</option>
            </select></td>
            <td align="right" width="1%" nowrap>FORMATO DE LA NOTA:</td>
          </tr>
        </table>
      </td> </tr>
      <tr id="contieneET" align="left"><td colspan="4">
    	<textarea style="height:90%; resize:none; vertical-align:top;" name="input" id="input" type="text" value="" class="jqte-test"></textarea>
        <input name="miDiagnostico" id="miDiagnostico" type="hidden">
    </td></tr>
    </table>
  </div>
  
</form>
</div>