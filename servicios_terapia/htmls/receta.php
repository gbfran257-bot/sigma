<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Documento sin título</title>
</head>

<body>

<div id="miRecetaF" style="font-size:0.75em;">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr height="1%">
    <td align="left" height="1px">
    <table width="100%" border="0" cellspacing="0" cellpadding="4" style="border-bottom:1px dashed black;">
      <tr>
        <td width="1%" nowrap>PACIENTE:</td>
        <td>
        	<span id="nombrePRF" class="cursi"></span>&nbsp;&nbsp;
            EDAD: <span id="edadPRF" class="cursi"></span>&nbsp;&nbsp;
            <!--SEXO:  --><span id="sexoPRF" class="cursi"></span></td>
      </tr>
      <tr style="display:none;">
        <td>DOMICILIO:</td><td><span id="domicilioPRF" class="cursi"></span></td>
      </tr>
      <tr>
        <td>REFERENCIA:</td><td>
        	<span id="folioPRF" class="cursi"></span>&nbsp;&nbsp;
            FECHA: <span id="fechaRF" class="cursi"></span></td>
      </tr>
    </table>
    </td>
  </tr>
  <tr>
    <td valign="top" height="1px">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <!--<td width="5cm" align="left">
        <table width="100%" border="0" cellspacing="0" cellpadding="4">
          <tr>
            <td width="100px">FC</td>
            <td><span id="fcNE"></span></td>
          </tr>
          <tr>
            <td>FR</td>
            <td><span id="frNE"></span></td>
          </tr>
          <tr>
            <td>T/A</td>
            <td><span id="taNE"></span></td>
          </tr>
          <tr>
            <td>TEMP</td>
            <td><span id="tempNE"></span></td>
          </tr>
          <tr>
            <td>PESO</td>
            <td><span id="pesoNE"></span></td>
          </tr>
          <tr>
            <td>TALLA</td>
            <td><span id="tallaNE"></span></td>
          </tr>
          <tr>
            <td>IMC</td>
            <td><span id="imcNE"></span></td>
          </tr>
        </table>
        </td> -->
        <td valign="top" align="justify" style="border-left:1px none black; padding-left:3px;border-bottom:1px dashed black;"><span id="notaRF"></span></td>
      </tr>
    </table>
    </td>
  </tr>
<tr id="trAlergias">
  <td height="1px">
    <table width="100%" border="0" cellspacing="0" cellpadding="4" style="border-bottom:1px dashed black;">
      <tr align="left">
        <td width="80" valign="top">INDICACIONES:</td>
        <td align="left"><span id="indicacionesNE"></span></td>
      </tr>
    </table>
  </td>
  </tr>
<tr>
    <td height="1px"><br><br>
    <table width="100%" border="0" cellspacing="0" cellpadding="4">
      <tr>
      	<td align="center" width="50%"></td>
        <td align="center"><span id="doctorRF"></span></td>
      </tr>
      <tr>
        <td align="center"><span id="especialidadesDRrf"></span></td>
      </tr>
      <!--<tr>
        <td align="center"><span id="cedularDRne"></span></td>
      </tr> -->
    </table>
    </td>
  </tr>
</table>
</div>

<div id="miRecetaT">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td valign="top" align="justify" style="border-left:1px none black; padding-left:3px;border-bottom:1px none black;"><span id="notaRT"></span></td>
      </tr>
    </table>
</div>

</body>
</html>
