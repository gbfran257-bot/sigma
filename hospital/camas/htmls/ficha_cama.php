<div id="ficha_estudio">
 <form action="" method="post" name="formEstudio" id="formEstudio" target="_self" style="height:100%;">
 <input name="idEstudioE" type="hidden" id="idEstudioE"> <input name="idusuarioNM" type="hidden" id="idusuarioNM">
  <div class="miTab" id="tabs-2">
  	<table width="100%" height="100%" border="0" cellspacing="2" cellpadding="4" class="grisecito">
      <tr align="left"> <td height="1px" nowrap>
      	<table width="100%" border="0" cellspacing="1" cellpadding="3">
          <tr>
            <td width="1%" nowrap>NÚMERO DE CAMA</td>
            <td width="30px" nowrap><input name="numeroCama"type="text" class="required"id="numeroCama"onKeyUp="solo_numeros(this.value, this.name);" maxlength="5"></td>
            <td width="1%">UBICACIÓN</td>
            <td width="100px"><input name="ubicacionCama"type="text" class="required"id="ubicacionCama"onKeyUp="conMayusculas(this); solo_letras_numeros(this.value, this.name);"></td>
            <td width="1%">ÁREA</td>
            <td width="100px"><select name="area_cama" id="area_cama" class="required"> </select></td>
            <td align="right" width="1%" nowrap>DESCRIPCIÓN:</td>
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