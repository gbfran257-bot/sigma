<div class="modal-dialog modal-lg" role="document" id="contenido_ficha_consulta">
    <div class="modal-content animated flipInY">
      <div class="modal-header">
        <button type="button" class="close hidden" data-dismiss="modal" aria-label="Close">
        	<span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title"><strong><span id="titulo_modal"></span></strong></h4>
      </div>
      <div class="modal-body">

<form action="" method="post" name="form-procesar" id="form-procesar" target="_self" style="height:100%;">
<input name="idEstudioPro" id="idEstudioPro" type="hidden" value=""> 
<input name="idPacientePro" id="idPacientePro" type="hidden" value=""> 
<input name="idUserPro" id="idUserPro" type="hidden" value="<?php echo $row_usuario['id_u']; ?>">
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
  <tr class="hidden" id="tr_sucursalex">
    <td align="right" width="1px" nowrap valign="top"><strong>SUCURSAL MEMBRETE: </strong></td>
    <td class="sucursal_ocu" colspan="2"><select name="sucursal_ocu" id="sucursal_ocu" class="form-control input-sm"> </select></td>
  </tr>
</table>
</form>

</div>
      
      <div class="modal-footer">
      	<div class="form-group">
        <div class="col-sm-offset-0 col-sm-12">
            <button type='submit' id="btn_capturar_e" class="btn btn-success btn-sm" form="form-procesar">Guardar</button>
            <button type='submit' id="btn_autorizar_e" class="btn btn-success btn-sm hidden" form="form-procesar">Autorizar</button>
            <button type='button' id="btn_imprimir_e" class="btn btn-success btn-sm hidden" form="">Imprimir</button>
            <button type='submit' id="btn_reiniciar_e" class="btn btn-warning btn-sm">Reiniciar</button>
            <button type='button' class="btn btn-danger btn-sm" data-dismiss="modal">Cancelar</button>     
        </div>
        </div>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->