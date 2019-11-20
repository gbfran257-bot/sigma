<form action="" method="post" name="form-muni" id="form-muni" target="_self" style="width:100%; height:100%;"> <input name="id_u_nmuni" type="hidden" value="" id="id_u_nmuni">
<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td align="left">Para dar de alta un nuevo municipio en el sistema, indique los siguientes datos:</td>
  </tr>
  <tr>
    <td>
    <table width="100%" border="0" cellspacing="0" cellpadding="4">
      <tr>
        <td class="" align="left" width="190px" nowrap>Entidad federativa</td> 
        <td align="left"><select class="required" name="estadoNM" id="estadoNM"></select></td>
      </tr>
    </table>
    </td>
  </tr>
  <tr>
    <td>
    <table width="100%" border="0" cellspacing="0" cellpadding="4">
      <tr>
        <td align="left" width="190px" class="" nowrap>Nombre del municipio</td>
        <td align="left"><input name="nombre_nm" type="text" class="required" id="nombre_nm" onKeyUp="conMayusculas(this); solo_letras_numeros(this.value, this.name);" maxlength=""></td>
      </tr>
    </table>
</td>
  </tr>
</table>
</form>

<form action="" method="post" name="form-col" id="form-col" target="_self" style="width:100%; height:100%;"> <input name="id_u_nmuni" type="hidden" value="" id="id_u_nmuni"> 
<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td align="left">Para dar de alta una nueva colonia y código postal en el sistema, indique los siguientes datos:</td>
  </tr>
  <tr>
    <td>
    <table width="100%" border="0" cellspacing="0" cellpadding="4">
      <tr>
        <td class="" align="left" width="190px" nowrap>Entidad federativa</td> 
        <td align="left"><select class="required" name="estadoNM" id="estadoNM"></select></td>
      </tr>
    </table>
    </td>
  </tr>
  <tr>
    <td>
    <table width="100%" border="0" cellspacing="0" cellpadding="4">
      <tr>
        <td align="left" width="190px" class="" nowrap>Municipio</td>
        <td align="left"><select class="required" name="municipioNM" id="municipioNM"></select></td>
      </tr>
    </table>
	</td>
  </tr>
  <tr>
    <td>
    <table width="100%" border="0" cellspacing="0" cellpadding="4">
      <tr>
        <td align="left" width="190px" class="" nowrap>Nombre de la colonia</td>
        <td align="left"><input name="nombre_nc" type="text" class="required" id="nombre_nc" onKeyUp="conMayusculas(this); solo_letras_numeros(this.value, this.name);" maxlength=""></td>
      </tr>
    </table>
	</td>
  </tr>
  <tr>
    <td>
    <table width="100%" border="0" cellspacing="0" cellpadding="4">
      <tr>
        <td align="left" width="190px" class="" nowrap>Código postal</td>
        <td align="left"><input name="cp_n" type="text" class="required" id="cp_n" onKeyUp="conMayusculas(this); solo_numeros(this.value, this.name);" maxlength="5"></td>
      </tr>
    </table>
	</td>
  </tr>
</table>
</form>