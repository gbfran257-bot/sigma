<div class="modal-dialog modal-lg" role="document" id="contenido_ficha_consulta">
    <div class="modal-content animated flipInY">
      <div class="modal-header">
        <button type="button" class="close hidden" data-dismiss="modal" aria-label="Close">
        	<span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title"><strong><span id="titulo_modal">VISUALIZAR EL ESTUDIO</span></strong></h4>
      </div>
      <div class="modal-body">
      
      <div class="panel panel-info">
          <!-- Default panel contents -->
          <div class="panel-heading">SELECCIONA EL VISIALIZADOR QUE DESEAS UTILIZAR</div>
          <div class="panel-body">
        <table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0" class="table table-condensed">
          <tr>
            <td width="1px" nowrap class="titulosTabla">PACIENTE</td>
            <td align="left" colspan="3">
             <input class="campoDatosTabla" name="paciente_est" id="paciente_est" type="text" readonly style="text-align:left; width:99%;">
            </td> 
          </tr>
          <tr> 
            <td class="titulosTabla">ESTUDIO</td> 
            <td align="left" colspan="3"> 
                <input class="campoDatosTabla" name="folio_est" id="folio_est" type="text" readonly style="text-align:left; width:99%;"> 
            </td> 
          </tr>
          <tr> 
            <td class="titulosTabla">REFERENCIA</td> 
            <td align="left" colspan="3"> 
            <input class="campoDatosTabla" name="referencia_est"id="referencia_est"type="text" style="text-align:left;width:99%;" readonly>
            </td> 
          </tr>
          
        <tr>
            <td class="titulosTabla" nowrap>STUDY_IUID</td>
            <td align="left" colspan="3">
                <input
                    class="campoDatosTabla"
                    id="studyUID"
                    type="text"
                    style="text-align:left;width:99%;"
                    readonly>
            </td>
        </tr>

        <tr>
            <td class="titulosTabla" nowrap>ENLACE</td>
            <td align="left" colspan="3">
                <input
                    class="campoDatosTabla"
                    id="enlaceGenerado"
                    type="text"
                    style="text-align:left;width:99%;"
                    readonly>
            </td>
        </tr>
          <tr>
            <td class="titulosTabla" nowrap>WhatsApp</td>
            <td align="left" colspan="3">
                <input
                    class="campoDatosTabla"
                    id="telefonoWhatsapp"
                    type="text"
                    placeholder="52"
                    style="text-align:left;width:99%;">
            </td>
        </tr>
        </table>
        <input name="idEstudioPacs" type="hidden" value="" id="idEstudioPacs">
</div>
      </div>
<div class="modal-footer">
    <div class="form-group">
    <div class="col-sm-offset-0 col-sm-12">
        <button type='submit' id="btn_gen_enla" class="btn btn-primary btn-sm">Generar enlace</button>    
        <button type='submit' id="btn_comp_enlace" class="btn btn-primary btn-sm">Compartir url</button>
        <button type='submit' id="btn_v_avanzado" class="btn btn-primary btn-sm">Visualizador html</button>
        <button type='submit' id="btn_reasignar_id" class="btn btn-primary btn-sm">Reasignar IDPACS</button>
        <button type='button' class="btn btn-danger btn-sm" data-dismiss="modal">Cerrar</button>     
    </div>
    </div>
  </div>
</div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->