<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Documento sin título</title>
</head>

<body>

<div id="miNotaE" style="font-size:0.75em;">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr height="1%">
    <td align="left" height="1px">
    <table width="100%" border="0" cellspacing="0" cellpadding="2" style="border-bottom:1px dashed black;">
      <tr>
        <td width="1%" nowrap>PACIENTE:</td>
        <td>
        	<span id="nombrePNE" class="cursi"></span>&nbsp;&nbsp;
            EDAD: <span id="edadPNE" class="cursi"></span>&nbsp;&nbsp;
            <!--SEXO:  --><span id="sexoPNE" class="cursi"></span></td>
      </tr>
      <tr style="display:none;">
        <td>DOMICILIO:</td><td><span id="domicilioPNE" class="cursi"></span></td>
      </tr>
      <tr>
        <td>REFERENCIA:</td><td>
        	<span id="folioPNE" class="cursi"></span>&nbsp;&nbsp;
            FECHA: <span id="fechaNE" class="cursi"></span></td>
      </tr>
      <tr>
        <td>CONCEPTO:</td><td class="negritas"> <span id="conceptoPNE" class="cursi"></span></td>
      </tr>
      <tr>
        <td class="negritas" colspan="2"> <span id="aquienPNE" class="cursi"></span></td>
      </tr>
    </table>
    </td>
  </tr>
  <tr>
    <td valign="top" height="1px">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="5cm" align="left" id="trSignosV">
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
        </td>
        <td valign="top" align="justify" style="border-left:0px dashed black; padding-left:3px;border-bottom:0px dashed black; font-size:1em;"><span id="notaNE"></span></td>
      </tr>
    </table>
    </td>
  </tr>
  <tr id="trAlergias">
  <td height="1px">
    <table width="100%" border="0" cellspacing="0" cellpadding="4" style="border-bottom:1px dashed black;">
      <tr align="left">
        <td width="80">ALÉRGIAS:</td>
        <td align="left"><span id="alergiasNE"></span></td>
      </tr>
    </table>
  </td>
  </tr>
  <tr id="trDX">
    <td valign="top" height="1px">
    <table width="100%" border="0" cellspacing="0" cellpadding="0" style="border-bottom:1px dashed black;">
      <tr>
        <td id="dxNE">
        <table width="100%" height="100%" border="0" cellpadding="4" cellspacing="0" id="dataTableDNE" class="">
        <thead id="cabecera_tBusquedaDNE">
          <tr>
            <th id="clickmeDNE" width="1px">#</th>
            <th>DIAGNÓSTICO(S)</th>
          </tr>
        </thead>
        <tbody> <tr> <td class="dataTables_empty">Cargando datos del servidor</td> </tr> </tbody>
      </table>
        </td>
      </tr>
    </table>
    </td>
  </tr>
  <tr>
    <td height="1px"><br><br>
    <table width="100%" border="0" cellspacing="0" cellpadding="4">
      <tr>
        <td align="center" width="50%"></td>
        <td align="center" nowrap><span id="firmaNE" style="text-decoration:;"></span></td>
      </tr>
      <tr>
        <td align="center" width="50%"></td>
        <td align="center" nowrap><span id="doctorNE" style="text-decoration:;"></span></td>
      </tr>
      <tr>
        <td align="center"><span id="especialidadesDRne"></span></td>
      </tr>
      <!--<tr>
        <td align="center"><span id="cedularDRne"></span></td>
      </tr> -->
    </table>
    </td>
  </tr>
</table>
</div>

</body>
</html>
