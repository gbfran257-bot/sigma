<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0" class="table table-condensed table-bordered">
  <tr>
    <td class="ocultarX" align="right" width="1px">PACIENTE</td> 
    <td class="ocultarX text-info" align="left" id="pacientePro"></td> 
    <td width="1%" nowrap class="cargaPDF">
    <span id="cargaPDF" class="mipdf" style="cursor:pointer; text-decoration:underline" title="Opcionalmente, puede cargar un archivo PDF">* PDF</span>
    </td>
  </tr>
  <tr class="notas_tm" style="border-bottom:1px dashed white;">
    <td class="" align="left" width="1px" nowrap style="white-space:nowrap;">NOTAS DE LA TOMA DE MUESTRA</td>
    <td align="left" colspan="2" id="observacionPro" class="text-info"></td>
  </tr>
  <tr height="90%">
    <td id="misResultados" style="overflow:scroll;" valign="top" colspan="3"> </td>
  </tr>
  <tr class="tr_observaciones">
    <td align="right" width="1px" nowrap valign="top"><strong>OBSERVACIONES: </strong></td>
    <td class="notaPro" colspan="2"><textarea class="form-control" name="notaPro" id="notaPro" cols="1" rows="1" style="resize:none; height:100%;" onKeyUp="conMayusculas(this);"></textarea></td>
  </tr>
</table>