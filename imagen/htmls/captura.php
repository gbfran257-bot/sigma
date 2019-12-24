<div class="modal-dialog modal-lg" role="document" id="contenido_ficha_consulta">
    <div class="modal-content animated flipInY">
      <div class="modal-header">
        <button type="button" class="close hidden" data-dismiss="modal" aria-label="Close">
        	<span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title"><strong><span id="titulo_modal"></span></strong></h4>
      </div>
      <div class="modal-body">
        <form style="height:100%; width:100%;" action="" method="get" name="form-captura" id="form-captura" target="_self">
        <input name="myIDestudio" id="myIDestudio" class="myIDestudio" type="hidden">
        <input name="myIDusuario" type="hidden" class="myIDusuario" id="myIDusuario" value="<?php echo $row_usuario['id_u']; ?>">
        <table id="tCaptura" class="" width="100%" height="100%" border="0" cellspacing="0" cellpadding="0" style="text-align:left;">
          <tr id="nota_birads_1"> 
            <td width="50%" class="myNotaTR"></td>
            <td> <div id="mi_birad"> </div> </td>
          </tr>
		  <tr id="tr_machotes"> 
              <td colspan="2">
				<select data-placeholder="Selecciona un formato para el estudio" id="formato_se" name="formato_se" class="form-control input-sm"> </select>
			  </td>
          </tr>
          <tr id="contieneET">
            <td colspan="2"> <input style="resize:none;" name="input" id="input" type="text" class="jqte-test required" autofocus> </td>
          </tr>
        </table>
        </form>
      </div>
      
      <div class="modal-footer">
      	<div class="form-group">
        <div class="col-sm-offset-0 col-sm-12">
            <button type='button' id="myPDF" class="btn btn-info btn-sm mipdf"><i class="fa fa-file" aria-hidden="true"></i> CARGAR PDF</button>
            <button type='submit' id="saveInterI" class="btn btn-success btn-sm"><i class="fa fa-floppy-o" aria-hidden="true"></i> GUARDAR</button>
            <button type='button' id="imprimirInt" class="btn btn-primary btn-sm"><i class='fa fa-print' aria-hidden='true'></i> IMPRIMIR</button>
            <button type='button' id="cancInterI"class="btn btn-danger btn-sm" data-dismiss="modal"><i class='fa fa-ban' aria-hidden='true'></i> CANCELAR</button>     
        </div>
        </div>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->