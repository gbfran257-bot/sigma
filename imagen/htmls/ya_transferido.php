<div class="modal-dialog modal-lg" role="document" id="contenido_ficha_consulta">
    <div class="modal-content animated flipInY">
      <div class="modal-header">
        <button type="button" class="close hidden" data-dismiss="modal" aria-label="Close">
        	<span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title"><strong><span id="titulo_modal"></span></strong></h4>
      </div>
      <div class="modal-body">
      
      <div class="panel panel-info">
          <!-- Default panel contents -->
          <div class="panel-heading">INFORMACIÓN DEL ESTUDIO TRANSFERIDO</div>
          <div class="panel-body">
          	<p>EL ESTUDIO <span id="estudioYa"></span> CON REFERENCIA <span id="referenciaYa"></span> SE ASIGNÓ CON LOS SIGUENTES DATOS:</p>
          </div>

        <table width="100%" height="100%" border="0" cellspacing="0" cellpadding="4" class="table table-condensed">
          <tr class="ui-widget-header">
            <td>USUARIO QUE ASIGNÓ</td>
            <td>FECHA Y HORA DE ASIGNACIÓN</td>
            <td>MÉDICO ASIGNADO</td>
          </tr>
          <tr>
            <td id="uAsignaT"></td>
            <td id="fAsignaT"></td>
            <td id="mAsignaT"></td>
          </tr>
        </table>
      </div>
      </div>
<div class="modal-footer">
    <div class="form-group">
    <div class="col-sm-offset-0 col-sm-12">
        <button type='submit' id="btn_desasigna_e" class="btn btn-warning btn-sm">Desasignar</button>
        <button type='button' class="btn btn-danger btn-sm" data-dismiss="modal">Cerrar</button>     
    </div>
    </div>
  </div>
</div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->