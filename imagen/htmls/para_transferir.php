<div class="modal-dialog modal-lg" role="document" id="contenido_ficha_consulta">
    <div class="modal-content animated flipInY">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        	<span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title"><strong><span id="titulo_modal"></span></strong></h4>
      </div>
      <div class="modal-body">
      
<div class="panel panel-default">
  <!-- Default panel contents -->
  <div class="panel-heading">TRANSFERIR LA INTERPRETACIÓN DEL ESTUDIO <span id="estudioTr"></span></div>
  <div class="panel-body">
    <p>SELECCIONA UN MÉDICO RADIÓLOGO</p>
  </div>

  <input name="idTmedicoR" type="hidden" value="" id="idTmedicoR">
<table class="table table-condensed table-hover" id="dataTableTransfer" width="100%" height="100%"> 
<thead id="cabecera_tBusquedaPrincipal">
  <tr class="bg-info">
    <th id="clickmeTr" align="center" nowrap width="10px">#</th>
    <th align="center" width="">NOMBRE</th>
    <th align="center">APATERNO</th>
    <th align="center" width="" nowrap>AMATERNO</th>
  </tr>
</thead> <tbody> <tr> <td class="dataTables_empty">Cargando datos del servidor</td> </tr> </tbody> 
	<tfoot class="cuerpo_datatable">
        <tr>
            <th></th>
            <th><input name="tNombre" id="tNombre" type="text" class="form-control sea1 input-sm" placeholder="-Buscar-"/></th>
            <th><input name="tApaterno" id="tApaterno" type="text" class="form-control sea1 input-sm" placeholder="-Buscar-"/></th>
            <th><input name="tAmaterno" id="tAmaterno" type="text" class="form-control sea1 input-sm" placeholder="-Buscar-"/></th>
        </tr>
    </tfoot>
</table>
</div>

<div id="errorSeleccionMédicoT" style="display:none;"><span class="alerta_no_seleccion">Debe de seleccionar un médico, dé clic sobre uno de ellos.</span></div>

</div>
      
      <div class="modal-footer">
      	<div class="form-group">
        <div class="col-sm-offset-0 col-sm-12">
            <button type='submit' id="btn_transfer_e" class="btn btn-success btn-sm disabled">Transferir</button>
            <button type='button' class="btn btn-danger btn-sm" data-dismiss="modal">Cancelar</button>     
        </div>
        </div>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->