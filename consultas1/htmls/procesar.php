<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Documento sin título</title>
</head>

<body>

<div id="fichaProcesar" style="height:100%;">

<form action="" method="post" name="form-procesar" id="form-procesar" target="_self" style="height:100%;">
<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="2" bgcolor="#FF6600">
  <tr>
    <td>
    <table width="100%" border="0" cellspacing="0" cellpadding="1"> <tr> <td class="titulosTabs" align="left" width="1px">Paciente</td> <td><input class="campoITtab" name="pacientePro" id="pacientePro" type="text" readonly></td> </tr> </table>
    </td>
  </tr>
  <tr>
    <td>
    	<table width="100%" border="0"cellspacing="0" cellpadding="1">
    	<tr><td class="titulosTabs" align="left" width="">#Referencia</td><td class="titulosTabs" align="left" width="">Estudio</td><td class="titulosTabs" align="left" width="">Área</td></tr>
        <tr><td class="titulosTabs" align="left"><input class="campoITtab" name="refPro" id="refPro" type="text" readonly></td><td class="titulosTabs" align="left"><input class="campoITtab" name="estPro" id="estPro" type="text" readonly></td>
        	<td class="titulosTabs" align="left"><input class="campoITtab" name="areaPro" id="areaPro" type="text" readonly></td></tr>
        </table>
    </td>
  </tr>
  <tr>
    <td>
    <table width="100%" border="0" cellspacing="0" cellpadding="1"> 
    	<tr> <td class="titulosTabs" align="left" width="115px" nowrap>Observaciones de recepción</td> <td><textarea class="campoITtab" name="observacionPro" id="observacionPro" cols="1" rows="2" readonly style="resize:none; height:100%"></textarea></td> </tr> 
    </table>
    </td>
  </tr>
  <tr>
    <td>
    <table width="100%" border="0" cellspacing="0" cellpadding="1"> 
    	<tr> <td class="titulosTabs" align="left" width="115px" nowrap>Nota para el médico</td> <td><textarea class="campoITtab" name="notaPro" id="notaPro" cols="1" rows="2" style="resize:none; height:100%" onKeyUp="conMayusculas(this);"></textarea></td> </tr> 
    </table>
    </td>
  </tr>
  <tr class="variosEstu">
    <td>
    <table width="100%" border="0" cellspacing="0" cellpadding="3"> 
        <tr> 
            <td class="" align="left" width="200px"><input type="checkbox" id="individualPro" name="individualPro"><label for="individualPro"><span class="miProcesar">Procesar</span> éste estudio</label></td> 
            <td class="titulosTabs" align="left" width="" style="font-style:oblique;">
            Escoja ésta opción si sólo quiere <span class="miprocesar">procesar</span> éste estudio.
            </td>
        </tr>
        <tr> 
            <td class="" align="left" width="200px"><input type="checkbox" id="variosPro" name="variosPro"><label for="variosPro"><span class="miProcesar">Procesar</span> varios estudios</label></td> 
            <td class="titulosTabs" align="left" width="" style="font-style:oblique;">
            Escoja ésta opción si requiere <span class="miprocesar">procesar</span> al mismo tiempo los <span id="estudiosPro" style="text-decoration:underline;"></span> estudios de la orden de venta <span id="ordenPro" style="text-decoration:underline;"></span> del área <span id="areaPro1" style="text-decoration:underline;">rayos x</span> que no están aún <span class="miProcesados">procesados</span>.
            </td>
        </tr> 
    </table>
    </td>
  </tr>
  <tr class="variosEstu">
    <td id="" style="font-size:0.8em;color:gold;display:block; text-align:left;" valign="top"><span id="notificacionPro" style="display:none;">¡Debe seleccionar una de las dos opciones mostradas!</span>&nbsp;</td>
  </tr>
</table><input name="checaPro" id="checaPro" type="hidden" value="0"> <input name="idEstudioPro" id="idEstudioPro" type="hidden" value=""> <input name="idPacientePro" id="idPacientePro" type="hidden" value=""> 
<input name="idUserPro" id="idUserPro" type="hidden" value="<?php echo $row_usuario['id_u']; ?>">
</form>
</div>

</body>
</html>
