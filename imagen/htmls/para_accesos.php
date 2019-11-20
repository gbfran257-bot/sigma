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
  <div class="panel-heading"><span id="estudioTr"></span></div>
  <div class="panel-body">
  	<table class="table-condensed" width="100%" height="1%">
    	<tr>
        	<td nowrap width="70%"><select data-placeholder="Selecciona un médico" id="medico_c" name="medico_c" class="form-control chosen-select"> </select></td>
            <td nowrap align="left"><button type="button" class="btn btn-sm btn-primary" id="btn_dar_a">Dar Acceso</button></td>
        </tr>
        <tr><td colspan="2" class="text-danger" align="center" style="font-weight:bold;">LISTA DE USUARIOS CON ACCESO AL ESTUDIO</td></tr>
    </table>
  </div>

  <input name="idTmedicoR" type="hidden" value="" id="idTmedicoR">
<table class="table table-condensed table-hover" id="dataTableAc" width="100%" height="100%"> 
<thead id="cabecera_tBusquedaPrincipal">
  <tr class="bg-info">
    <th id="clickmeAc" align="center" nowrap width="10px">#</th>
    <th align="center" width="">MÉDICO</th>
    <th align="center">ASIGNÓ</th>
    <th align="center" width="" nowrap>FECHA</th>
    <th align="center" width="" nowrap>ELIMINAR</th>
  </tr>
</thead> <tbody> <tr> <td class="dataTables_empty">Cargando datos del servidor</td> </tr> </tbody> 
</table>
</div>

<div id="errorSeleccionMédicoT" style="display:none;"><span class="alerta_no_seleccion">Debe de seleccionar un médico, dé clic sobre uno de ellos.</span></div>

</div>
      
      <div class="modal-footer">
      	<div class="form-group">
        <div class="col-sm-offset-0 col-sm-12">
            <button type='button' class="btn btn-warning btn-sm" data-dismiss="modal">Cerrar</button>     
        </div>
        </div>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->