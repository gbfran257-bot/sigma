<div class="modal-dialog modal-lg" role="document" id="contenido_ficha_consulta">
    <div class="modal-content animated flipInY">
      <div class="modal-header">
        <button type="button" class="close hidden" data-dismiss="modal" aria-label="Close">
        	<span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title"><strong><span id="titulo_modal"></span></strong></h4>
      </div>
      <div class="modal-body">
        <form action="" method="post" name="form-asig" id="form-asig" target="_self" style="height:100%;">
          <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0" id="dataTableAsignacion" class="table table-striped table-bordered" role="grid"> 
            <thead id="cabecera_tBusquedaPrincipal">
              <tr role="row" class="bg-primary">
                <th id="clickmeAS" style="vertical-align:middle;">#</th>
                <th style="vertical-align:middle;" Class="text-center">
                BASE ASIGNADA
                  <button type="button" class="btn btn-sm btn-primary idMetodo " id="" lang='' onClick="nuevo_asig_est(this.lang,'BASE');">
                   BASE <i class="fa fa-plus"></i>
                    </button>
                </th>
                <th style="vertical-align:middle; width:150px;" Class="text-center">
                ESTUDIOS ASIGNADO
                  <div class="col-sm-12">
                    <button type="button" class="btn btn-sm btn-primary idMetodo" id="" lang='' onClick="nuevo_asig_est(this.lang,'LABORATORIO');">
                      LAB <i class="fa fa-plus"></i>
                    </button>
                  </div>
                </th>
                <!-- <th style="vertical-align:middle;">BASE ASIGNADA</th> -->
                <th style="vertical-align:middle;" Class="text-center">USUARIO</th>
                <th style="vertical-align:middle;" Class="text-center" nowrap>FECHA DE ASIGNACION</th>
                <th style="vertical-align:middle;" Class="text-center">ELIMINAR</th>
              </tr>
              </thead><tbody> <tr> <td class="dataTables_empty">Cargando datos del servidor</td> </tr> </tbody>
              <tfoot>
                    <tr class="bg-primary">
                        <th></th>
                        <th></th>
                        <th><input type="text" class="form-control input-sm" placeholder="-Estudio-"/></th>
                        <th><input type="text" class="form-control input-sm" placeholder="-Usuario-"/></th> 
                        <th></th> 
                        <th></th> 
                    </tr>
                </tfoot> 
          </table>
          <br class="asignar hide"><br class="asignar hide">
          <div id="asignar_metodo" class="hide asignar">
            <hr>
            <div class="col-sm-12 text-center laboratorio_est hide">
              <label for="estudios_l" class="ol-form-label">SELECCIONAR ESTUDIO DE LABORATORIO</label> 
              <br>
              <select name="estudios_l" id="estudios_l"></select>
            </div>
            <div class="col-sm-12 text-center est_base hide">
              <label for="base_est" class="ol-form-label">SELECCIONAR UNA BASE</label> 
              <br>
              <select name="base_est" id="base_est"></select>
            </div>
          </div>
        </form>
	    </div>
      <br class="asignar hide"><br class="asignar hide" ><br class="asignar hide">
      <div class="modal-footer">
      	<div class="form-group">
        <div class="col-sm-offset-0 col-sm-12">
            <button type='submit' id="btn_save_carrera" class="btn btn-success btn-sm asignar hide" form="form-asig">Asignar</button>
            <button type='button' class="btn btn-warning btn-sm" data-dismiss="modal">Cancelar</button>
        </div>
        </div>
      </div>
    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
