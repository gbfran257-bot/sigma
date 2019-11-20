<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Documento sin título</title>
</head>

<body>

<div id="pagarOV" style="border:1px none red; background-color:#EEE; height:385px; font-size:0.9em;">
<form action="" method="post" name="form-pagar" id="form-pagar" target="_self" style="height:100%">
<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="4">
  <tr>
    <td align="right" class="titulosTabs">forma de pago</td>
    <td width="320px" align="left"><select name="formaPagoP" id="formaPagoP" class="required"></select></td>
  </tr>
  <tr id="numeroCheque" style="display:none;">
    <td align="right" class="titulosTabs">número de cheque</td>
    <td align="left">
    <input name="noChequeP" type="text" id="noChequeP" class="required"onKeyUp="conMayusculas(this);nick(this.value, this.name);">
    </td>
  </tr>
  <tr>
    <td align="right" class="titulosTabs">¿se factura el pago?</td>
    <td align="left">
    	<select name="facturarP" id="facturarP" class="required" style="height:100%;" disabled>
      	<option value="">-SELECCIONAR-</option> <option value="1">SI</option> <option value="0">NO</option>
    	</select>
    </td>
  </tr>
  <tr>
    <td align="right" class="titulosTabs" style="color:; font-size:;">subtotal $</td>
    <td align="left">
    	<input name="adeudoTotalP" type="text" id="adeudoTotalP" readonly style="text-align:right; padding-right:10px;">
    </td>
  </tr>
  <tr>
    <td align="right" class="titulosTabs" style="color:; font-size:;">iva $</td>
    <td align="left">
    	<input name="ivaP" type="text" id="ivaP" readonly style="text-align:right; padding-right:10px;" value="0">
    </td>
  </tr>
  <tr>
    <td align="right" class="titulosTabs" style="color:; font-size:;">total $</td>
    <td align="left">
    	<input name="granTotalP" type="text" id="granTotalP" readonly style="text-align:right; padding-right:10px;">
    </td>
  </tr>
  <tr>
    <td align="right" class="titulosTabs" style="color:; font-size:;">monto a pagar $</td>
    <td align="left">
    <input name="montoPagarP"type="text"id="montoPagarP"class="required"onKeyUp="numeros_decimales(this.value, this.name);" readonly style="text-align:right; padding-right:10px;">
    </td>
  </tr>
  <tr>
    <td align="right" class="titulosTabs">paga con $</td>
    <td align="left"><input name="pagaConP" type="text" id="pagaConP" readonly onKeyUp="numeros_decimales(this.value, this.name);" style="text-align:right; padding-right:10px;"></td>
  </tr>
  <tr>
    <td align="right" class="titulosTabs" style="color:; font-size:;">cambio $</td>
    <td align="left"><input name="cambioP" type="text" id="cambioP" readonly style="text-align:right; padding-right:10px;"></td>
  </tr>
</table>
</form>
</div>

</body>
</html>
