<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Documento sin título</title>
</head>

<body>

<div id="fichaProcesar" style="height:100%;">

<form action="" method="post" name="form-procesar" id="form-procesar" target="_self" style="height:100%; background-color:#DCDDDE;">

<input name="idEstudioPro" id="idEstudioPro" type="hidden" value=""> <input name="idPacientePro" id="idPacientePro" type="hidden" value=""> 
<input name="idUserPro" id="idUserPro" type="hidden" value="<?php echo $row_usuario['id_u']; ?>">

<table width="100%" height="" border="0" cellspacing="1" cellpadding="3" style=" background-color:#DCDDDE;">
  <tr>
    <td>
    <table width="100%" border="0" cellspacing="0" cellpadding="3" style="font-size:"> 
        <tr> 
        <td class="titulosTabs" align="left" width="1%">Paciente</td> 
        <td align="left"><span name="pacientePro" id="pacientePro"> </span></td> 
        <td width="1%" nowrap>
        <span id="cargaPDF" class="mipdf" style="cursor:pointer; text-decoration:underline" title="Opcionalmente, puede cargar un archivo PDF">
        	* PDF
        </span>
        </td>
    </tr> 
    </table>
    </td>
  </tr>
  <tr>
    <td style="border-bottom:1px dashed black;">
    <table width="100%" border="0" cellspacing="0" cellpadding="3"> 
    	<tr> 
        	<td class="titulosTabs" align="left" width="1%" nowrap>Notas de toma de muestra</td>
            <td align="left">
            	<span name="observacionPro" id="observacionPro"></span>
            </td> 
        </tr> 
    </table>
    </td>
  </tr>
  <tr height="90%">
  <td>
  	<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="2" style=" background-color:#DCDDDE;">
      <tr>
        <td id="misResultados" style="overflow:scroll;">

        </td>
      </tr>
    </table>
  </td>
  </tr>
  <tr>
    <td>
    <table width="100%" border="0" cellspacing="0" cellpadding="3"> 
    	<tr> <td class="titulosTabs" align="left" width="1%" nowrap valign="top"><em><strong>Observaciones</strong></em></td> <td><textarea class="campoITtab" name="notaPro" id="notaPro" cols="1" rows="1" style="resize:none; height:100%; color:red;" onKeyUp="conMayusculas(this);"></textarea></td> </tr> 
    </table>
    </td>
  </tr>
</table>
</form>
</div>

</body>
</html>
