<div class="modal-dialog modal-lg" role="document" id="contenido_ficha_consulta">
    <div class="modal-content animated flipInY">
      <div class="modal-header">
        <button type="button" class="close hidden" data-dismiss="modal" aria-label="Close">
        	<span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title"><strong><span id="titulo_modal">ASIGNAR ID DE PACS AL ESTUDIO</span></strong></h4>
      </div>
      <div class="modal-body">
      
      <div class="panel panel-info">
          <!-- Default panel contents -->
          <div class="panel-heading">SELECCIONE UN ESTUDIO PARA ASIGNAR AL PACS</div>
          <div class="panel-body">
          	<p>El estudio <span id="estudioEpacs"></span> del paciente <span id="pacienteEpacs"></span> con referencia <span id="referenciaEpacs"></span> no está asignado a ningún estudio en la base de datos del PACS, para corregir ésto se debe seleccionar y asignar el estudio correspondiente del pacs de la lista</p>
          <input name="pkPacs" type="hidden" value="" id="pkPacs"> <input name="idPacsVC" type="hidden" value="" id="idPacsVC">
  	<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0" id="dataTablePc" class="table table-condensed">
        <thead class="bg-success">
          <tr>
            <th id="clickmePc">FECHA</th>
            <th>PACIENTE</th>
            <th>MODALIDAD</th>
            <th nowrap style="white-space:nowrap;">ID-PACS</th>
          </tr>
        </thead>
        <tbody> <tr> <td class="dataTables_empty">Cargando datos del servidor</td> </tr> </tbody>
        <tfoot>
            <tr>
            <td>
            <input name="sFecha" id="sFecha" type="text" placeholder="Fecha" class="form-control sea"/>
            </td>
            <td>
            <input name="sPaciente" id="sPaciente" type="text" placeholder="Paciente" class="form-control sea" onKeyUp="conMayusculas(this);"/>
            </td>
            <td>
            <input name="sEstudio" id="sEstudio" type="text" placeholder="Modalidad" class="form-control" style="max-width:100px;" onKeyUp="conMayusculas(this);"/>
            </td>
            <td>
            <input name="sIdPc" id="sIdPc" type="text" placeholder="ID-PACS" class="form-control sea" onKeyUp="conMayusculas(this);"/>
            </td>
            </tr>
        </tfoot>
      </table>
</div>
      </div>
<div class="modal-footer">
    <div class="form-group">
    <div class="col-sm-offset-0 col-sm-12">
        <button type='submit' id="btn_asignar_ep" class="btn btn-success btn-sm disabled">Asignar</button>
        <button type='button' class="btn btn-danger btn-sm" data-dismiss="modal">Cancelar</button>     
    </div>
    </div>
  </div>
</div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->