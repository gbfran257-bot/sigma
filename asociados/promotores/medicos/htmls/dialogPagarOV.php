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
    <td align="right" class="titulosTabs" style="color:black;">forma de pago</td>
    <td width="320px" align="left"><select name="formaPagoP" id="formaPagoP" class="required"></select></td>
  </tr>
  <tr id="numeroCheque" style="display:none;">
    <td align="right" class="titulosTabs" style="color:black;">número de cheque</td>
    <td align="left">
    <input name="noChequeP" type="text" id="noChequeP" class="required"onKeyUp="conMayusculas(this);nick(this.value, this.name);">
    </td>
  </tr>
  <tr>
    <td align="right" class="titulosTabs" style="color:black;">total de la orden $</td>
    <td align="left">
    	<input name="totalOVP" type="text" id="totalOVP" readonly style="text-align:right; padding-right:10px; width:95%;">
    </td>
  </tr>
  <tr>
    <td align="right" class="titulosTabs" style="color:black;">total abonado $</td>
    <td align="left">
    	<input name="abonadoOVP" type="text" id="abonadoOVP" readonly style="text-align:right; padding-right:10px; width:95%;">
    </td>
  </tr>
  <tr>
    <td align="right" class="titulosTabs" style="color:black;">saldo $</td>
    <td align="left">
    	<input name="saldoP" type="text" id="saldoP" readonly style="text-align:right; padding-right:10px; width:95%;">
    </td>
  </tr>
  <tr>
    <td align="right" class="titulosTabs" style="color:black;">monto a pagar $</td>
    <td align="left">
    <input name="montoPagarP"type="text"id="montoPagarP"class="required"onKeyUp="numeros_decimales(this.value, this.name);" readonly style="text-align:right; padding-right:10px; width:95%;">
    </td>
  </tr>
  <tr>
    <td align="right" class="titulosTabs" style="color:black;">paga con $</td>
    <td align="left"><input name="pagaConP" type="text" id="pagaConP" readonly onKeyUp="numeros_decimales(this.value, this.name);" style="text-align:right; padding-right:10px; width:95%;"></td>
  </tr>
  <tr>
    <td align="right" class="titulosTabs" style="color:black;">cambio $</td>
    <td align="left"><input name="cambioP" type="text" id="cambioP" readonly style="text-align:right; padding-right:10px; width:95%;"></td>
  </tr>
</table>
</form>
</div>

</body>
</html>
