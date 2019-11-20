<div class="modal-dialog modal-lg" role="document" id="contenido_ficha_consulta">
    <div class="modal-content animated flipInY">
      <div class="modal-header">
        <button type="button" class="close hidden" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><strong><span id="titulo_modal"> </span></strong></h4>
      </div>
      <div class="modal-body">
      
    <form action="" method="post" name="form-procesar" id="form-procesar" target="_self" style="height:100%;">
    <table width="100%" height="100%" border="0" cellspacing="0" cellpadding="2" class="fondo_tab">
      <tr>
        <td><input name="refPro1" id="refPro1" type="hidden" value="">
            <table width="100%" border="0"cellspacing="0" cellpadding="0" class="table-condensed">
            <tr>
                <td align="left">REFERENCIA</td>
                <td align="left">ESTUDIO</td>
                <td align="left">ÁREA</td>
            </tr>
            <tr>
                <td class="text-info" align="left" id="refPro"></td>
                <td class="text-info" align="left" id="estPro"></td>
                <td class="text-info" align="left" id="areaPro"></td>
            </tr>
            <tr class="observacionPro"> 
            	<td class="" align="left" width="1%" nowrap valign="top">OBSERVACIONES DE RECEPCIÓN:</td>
                <td id="observacionPro" colspan="2"></td>
            </tr>
            <tr> 
            	<td class="" align="left" width="1%" nowrap valign="top">NOTA PARA EL MÉDICO</td>
                <td colspan="2"><textarea class="form-control" name="notaPro" id="notaPro" cols="1" rows="2" style="resize:none; height:100%"></textarea></td>
            </tr> 
            </table>
        </td>
      </tr>
      <tr class="variosEstu">
        <td>
        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table table-condensed"> 
            <tr> 
                <td align="left" width="1%" nowrap>                
                    <label for="individualPro"><span class="miProcesar">Procesar</span> éste estudio</label>    
                    <input class="cheki" type="radio" id="individualPro" name="individualPro">
                </td> 
                <td class="" align="left" width="" style="font-style:oblique;">
                <span class="miprocesar">Procesar</span> únicamente éste estudio.
                </td>
            </tr>
            <tr> 
                <td align="left" width="" nowrap>
                    <label for="variosPro"><span class="miProcesar">Procesar</span> varios estudios</label>
                    <input class="cheki" type="radio" id="variosPro" name="individualPro">
                </td> 
                <td class="" align="left" width="" style="font-style:oblique;">
                <span class="miprocesar">Procesar</span> al mismo tiempo los <span id="estudiosPro" style="text-decoration:underline;"></span> estudios pendientes de la orden de venta <span id="ordenPro" style="text-decoration:underline;"></span> del área <span id="areaPro1" style="text-decoration:underline;">rayos x</span>.
                </td>
            </tr> 
        </table>
        </td>
      </tr>
      <tr class="variosEstu">
        <td class="text-danger" valign="top" align="center">
        	<span id="notificacionPro" style="display:none;">¡Debe seleccionar una de las dos opciones mostradas!</span>
        </td>
      </tr>
    </table>
    <input name="checaPro" id="checaPro" type="hidden" value="0">
    <input name="idEstudioPro" id="idEstudioPro" type="hidden" value="">
    <input name="idPacientePro" id="idPacientePro" type="hidden" value=""> 
    <input name="idUserPro" id="idUserPro" type="hidden" value="">
    </form>
    </div>
    
    <div class="modal-footer">
      	<div class="form-group">
        <div class="col-sm-offset-0 col-sm-12">
          <div class="checkbox">
            <button type="button" class="btn btn-primary" id="btn_procesar">Procesar</button>
            <button type="button" class="btn btn-danger" id="btn_cancelar_procesar" data-dismiss="modal">Cancelar</button>
          </div>
        </div>
        </div>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->