<div class="panel panel-primary">
  <div class="panel-heading">
    <h3 class="panel-title">
    EL MEMBRETE SE COMPONE DE DOS ARCHIVOS DE IMAGEN, UNO PARA EL ENCABEZADO Y OTRO PARA EL PIÉ DE PÁGINA.
    </h3>
  </div>
  <div class="panel-body">
    <input name="quees_membretes" type="hidden" class="required" id="quees_membretes" value="">
    <form action="" method="post" name="form-membretes0" id="form-membretes0" target="_self" style="height:100%;">
    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table table-condensed">
      <tr>
        <td width="44%" nowrap valign="bottom" align="left">
        <button type="button" class="btn btn-default btn-sm" id="btn_encabezado">ENCABEZADO <i class="fa fa-file-image-o" aria-hidden="true"></i></button>
        <!-- The file input field used as target for the file upload widget -->
        <input id="fileupload_membreteE" type="file" name="files[]" class="fileupload_membrete hidden" style="color:transparent;"accept="image/jpg, image/jpeg, image/png">
        <input name="nombre_membrete" type="hidden" class="required" id="nombre_membrete" value="">
        </td>
        <td width="44%">
        	<div class="input-group">
              <span class="input-group-addon" id="basic-addon1">Margen</span>
              <input type="number" class="form-control" placeholder="Margen de encabezado" id="margen_en" name="margen_en" aria-describedby="basic-addon1" step="0.01" min="0" max="10" value="2.8" style="text-align:right">
              <span class="input-group-addon" id="basic-addon1">cm</span>
            </div>
        </td>
        <td align="center" rowspan="3" valign="top">
            <div align="center" class="text-info">VISTA PREVIA</div>
            <div style="width:200px; height:270px; border:1px none black;">
            <table height="100%" width="100%" border="1" cellspacing="2" cellpadding="2" id="table_membre" bgcolor="#FFFFFF">
              <tr height="10%" id="membrete_en1"> <td id="membrete_en">&nbsp;</td> </tr>
              <tr height=""> <td>&nbsp;</td> </tr>
              <tr height="8%" id="membrete_pi1"> <td id="membrete_pi">&nbsp;</td> </tr>
            </table>
            </div>
            <div id="progressM"><div class="bar" style="width: 0%;"></div></div>
        </td>
      </tr>
      <tr>
        <td colspan="1" nowrap valign="top" align="left">
        <button type="button" class="btn btn-default btn-sm" id="btn_pie">PIÉ DE PÁGINA <i class="fa fa-file-image-o" aria-hidden="true"></i></button>
        <!-- The file input field used as target for the file upload widget -->
        <input id="fileupload_membreteP" type="file" name="files[]" class="fileupload_membrete hidden" style="color:transparent;"accept="image/jpg, image/jpeg, image/png">
        </td>
        <td width="44%">
        	<div class="input-group">
              <span class="input-group-addon" id="basic-addon1">Margen</span>
              <input type="number" class="form-control" placeholder="Margen de pié de página" id="margen_pi" name="margen_pi" aria-describedby="basic-addon1" step="0.01" min="0" max="10" value="2.3" style="text-align:right">
              <span class="input-group-addon" id="basic-addon1">cm</span>
            </div>
        </td>
      </tr>
    </table>
    </form>
  </div>
  <div class="panel-footer" align="right"><button type="button" class="btn btn-success btn-sm" id="btn_imprimir_mem">IMPRIMIR MEMBRETE <i class="fa fa-print" aria-hidden="true"></i></button></div>
</div>