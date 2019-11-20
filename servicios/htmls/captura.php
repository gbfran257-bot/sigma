<div class="modal-dialog modal-lg" role="document" id="contenido_ficha_consulta">
    <div class="modal-content animated flipInY">
      <div class="modal-header">
        <button type="button" class="close hidden" data-dismiss="modal" aria-label="Close">
        	<span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title"><strong><span id="titulo_modal"></span></strong></h4>
      </div>
      <div class="modal-body" id="interpretation">
        <form style="height:100%; width:100%;" action="" method="get" name="form-captura" id="form-captura" target="_self">
        <input name="myIDestudio" id="myIDestudio" class="myIDestudio" type="hidden">
        <input name="myIDusuario" type="hidden" class="myIDusuario" id="myIDusuario" value="<?php echo $row_usuario['id_u']; ?>">
        <table id="tCaptura" class="" width="100%" height="100%" border="0" cellspacing="0" cellpadding="0" style="text-align:left;">
          <tr id="contieneET">
            <td> <input style="resize:none;" name="input" id="input" type="text" class="jqte-test required" autofocus> </td>
          </tr>
        </table>
        </form>
      </div>
      
      <div class="modal-footer">
      	<div class="form-group">
        <div class="col-sm-offset-0 col-sm-12">
            <button type='submit' id="saveInterI" class="btn btn-success btn-sm"><i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar y finalizar</button>
            <button type='button' id="imprimirInt" class="btn btn-primary btn-sm"><i class='fa fa-print' aria-hidden='true'></i> Imprimir</button>
            <button type='button' id="cancInterI"class="btn btn-danger btn-sm" data-dismiss="modal"><i class='fa fa-ban' aria-hidden='true'></i> Salir</button>     
        </div>
        </div>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->