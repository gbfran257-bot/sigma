<div class="modal-dialog modal-lg" role="document" id="contenido_ficha_consulta">
    <div class="modal-content animated flipInY">
      <div class="modal-header">
        <button type="button" class="close hidden" data-dismiss="modal" aria-label="Close">
        	<span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title"><strong><span id="titulo_modal"></span>PROCESAR ESTUDIO(S)</strong></h4>
      </div>
      <div class="modal-body">
      
<form action="" method="post" name="form-procesar" id="form-procesar" target="_self" style="height:100%;">
<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0" class="table table-condensed">
  <tr>
    <td colspan="1" class="" align="left" width="1px">PACIENTE</td> 
    <td colspan="2" id="pacientePro" class="text-info"></td>
  </tr>
  <tr>
    <td class="" align="left" width="">REFERENCIA</td>
    <td class="" align="left" width="">ÁREA</td>
    <td class="" align="left" width="">ESTUDIO</td>
  </tr>
  <tr>
    <td class="text-info" align="left" id="refPro"></td>
    <td class="text-info" align="left" id="areaPro"></td>
    <td class="text-info" align="left" id="estPro"></td>
  </tr>
  <tr>
    <td class="" align="left" width="1px" nowrap style="white-space:nowrap;">NOTAS DE LA TOMA DE MUESTRA</td>
    <td colspan="2" id="observacionPro" class="text-info"></td>
  </tr>
  <tr>
    <td class="text-primary" align="left" width="1px" nowrap valign="top">OBSERVACIONES</td> 
    <td colspan="2"><textarea class="form-control" name="notaPro" id="notaPro" cols="1" rows="2" style="resize:none; height:100%; color:red;"></textarea></td>
  </tr>
  <tr class="variosEstu">
    <td align="left" width="1px" nowrap class="text-primary">
        <label for="individualPro"><span class="miProcesar">Procesar</span> éste estudio</label>    
        <input class="cheki" type="radio" id="individualPro" name="individualPro">
    </td> 
    <td colspan="2" class="" align="left" width="" style="font-style:oblique;">
    <span class="miprocesar">Procesar</span> únicamente éste estudio.
    </td>
  </tr>
  <tr class="variosEstu"> 
    <td align="left" width="1px" nowrap class="text-primary">
        <label for="variosPro"><span class="miProcesar">Procesar</span> varios estudios</label>
        <input class="cheki" type="radio" id="variosPro" name="individualPro">
    </td> 
    <td colspan="2" class="" align="left" width="" style="font-style:oblique;">
    <span class="miprocesar">Procesar</span> al mismo tiempo los <span id="estudiosPro" style="text-decoration:underline;"></span> estudios pendientes de la orden de venta <span id="ordenPro" style="text-decoration:underline;"></span>.
    </td>
  </tr> 
  <tr class="variosEstu">
    <td colspan="3" id="" style="color:gold;display:block; text-align:left;" valign="top">
    	<span id="notificacionPro" style="display:none;">¡Debe seleccionar una de las dos opciones mostradas!</span>
    </td>
  </tr>
</table>
	<input name="checaPro" id="checaPro" type="hidden" value="0"> 
    <input name="idEstudioPro" id="idEstudioPro" type="hidden" value=""> 			
    <input name="idPacientePro" id="idPacientePro" type="hidden" value=""> 
	<input name="idUserPro" id="idUserPro" type="hidden" value="">
    <input name="refPro1" id="refPro1" type="hidden" value="">
</form>

</div>
      
      <div class="modal-footer">
      	<div class="form-group">
        <div class="col-sm-offset-0 col-sm-12">
            <button type='submit' id="btn_procesar_e" class="btn btn-success btn-sm">Procesar</button>
            <button type='button' class="btn btn-danger btn-sm" data-dismiss="modal">Cancelar</button>     
        </div>
        </div>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->