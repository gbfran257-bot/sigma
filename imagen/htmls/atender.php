<div class="modal-dialog modal-lg" role="document" id="contenido_ficha_consulta">
    <div class="modal-content animated flipInY">
      <div class="modal-header">
        <button type="button" class="close hidden" data-dismiss="modal" aria-label="Close">
        	<span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title"><strong><span id="titulo_modal"> </span></strong></h4>
      </div>
      <div class="modal-body">
      
      <div class="panel panel-info">
          <!-- Default panel contents -->
          <div class="panel-heading">PARA ATENDER EL ESTUDIO DE ENDOSCOPÍA, INDIQUE LO SIGUIENTE</div>
          <div class="panel-body">

            <form action="" method="post" name="form-endo" id="form-endo" target="_self" style="height:100%">
            <input name="idEstX" id="idEstX" value="" type="hidden"> 
            <table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0" class="table table-condensed">
              <tr>
                <td align="left" width="1px" nowrap>PACIENTE</td>
                <td id="pacienteX1" class="text-info"></td>
              </tr>
              <tr>
                <td align="left" nowrap>ESTUDIO</td>
                <td id="estudioX1" class="text-info"></td>
              </tr>
              <tr style="display:none;">
                <td align="left" nowrap>REFERENCIA</td>
                <td id="referenciaX1" class="text-info"></td>
              </tr>
              <tr>
                <td nowrap style="white-space:nowrap" class="text-danger">* DX DE ENVÍO</td>
                <td><input class="form-control input-sm" name="dxEnvio" id="dxEnvio" type="text" required></td>
              </tr>
              <tr>
                <td style="white-space:nowrap" class="">ANESTESIÓLOGO</td>
                <td><select class="form-control input-sm" name="anestesiologoE" id="anestesiologoE"></select></td>
              </tr>
            </table>
            </form>

		</div>
      </div>
  <div class="modal-footer">
    <div class="form-group">
    <div class="col-sm-offset-0 col-sm-12">
        <button type='submit' id="btn_atender_e" class="btn btn-success btn-sm" form="form-endo">Aceptar</button>
        <button type='button' class="btn btn-danger btn-sm" data-dismiss="modal">Cancelar</button>     
    </div>
    </div>
  </div>
</div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->