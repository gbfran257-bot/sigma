<div id="interpretation">
    <table width="100%" border="0" cellspacing="0" cellpadding="2">
      <tr>
        <td width="99%"> <ul id="pestanas"> <li><a class="tabs" href="#tabs-1">FICHA DE INTERPRETACIÓN DEL ESTUDIO</a></li> </ul> </td>
        <td nowrap>
        <button id="dictado" onclick="procesarV()"class="ui-button ui-widget ui-corner-all"><span class="ui-icon ui-icon-pencil"></span> INICIAR DICTADO</button>
        <button id="saveInterI"class="ui-button ui-widget ui-corner-all"><span class="ui-icon ui-icon-disk"></span>GUARDAR</button>
        <button id="imprimirInt" class="ui-button ui-widget ui-corner-all"><span class="ui-icon ui-icon-print"></span> IMPRIMIR</button>
        <button id="cancInterI"class="ui-button ui-widget ui-corner-all"><span class="ui-icon ui-icon-cancel"></span>CANCELAR</button>
        </td>
      </tr>
    </table>

    <form style="height:100%; width:100%;" action="" method="get" name="form-captura" id="form-captura" target="_self">
    <input name="myIDestudio" id="myIDestudio" class="myIDestudio" type="hidden">
    <input name="myIDusuario" type="hidden" class="myIDusuario" id="myIDusuario" value="<?php echo $row_usuario['id_u']; ?>">
    <div class="miTab" id="tabs-1" style="height:100%;">
    <table id="tCaptura" width="100%" height="100%" border="0" cellspacing="4" cellpadding="0" style="text-align:left;">
      <tr id="nota_birads_1"> <td colspan="1" width="50%"><span class="myNotaTR"></span></td> <td colspan="1"> <div id="mi_birad"> </div> </td> </tr>
        <tr id="contieneET"><td colspan="2">
            <input style="resize:none;" name="input" id="input" type="text" class="jqte-test required" autofocus>
        </td></tr>
    </table>
    </div>
    </form>
</div>

<table id="tablaUsuariosEstados" width="100%" border="0" cellspacing="0" cellpadding="2" style="color:black; font-size:0.8em;">
  <tr>
    <td>
    <table width="100%" border="0" cellspacing="0" cellpadding="3">
      <tr>
        <td nowrap width="1%">USUARIO ASIGNÓ ESTUDIO</td>
        <td> <input class="campoCaptura" name="usuarioAsignaE" id="usuarioAsignaE" type="text" readonly> </td>
        <td nowrap width="1%">FECHA ASIGNÓ ESTUDIO</td>
        <td> <input class="campoCaptura" name="fechaAsignaE" id="fechaAsignaE" type="text" readonly> </td>
      </tr>
    </table>
    </td>
  </tr>
  <tr>
    <td>
    <table width="100%" border="0" cellspacing="1" cellpadding="3">
      <tr>
        <td nowrap width="12.5%">USUARIO PROCESÓ</td>
        <td width="12.5%"> <input class="campoCaptura" name="usuarioProcesoE" id="usuarioProcesoE" type="text" readonly> </td>
        <td nowrap width="1%">FECHA</td>
        <td width="12.5%"> <input class="campoCaptura" name="horaProcesoE" id="horaProcesoE" type="text" readonly> </td>
        <td nowrap width="12.5%">USUARIO REALIZA</td>
        <td width="12.5%"> <input class="campoCaptura" name="usuarioRealizaE" id="usuarioRealizaE" type="text" readonly> </td>
        <td nowrap width="1%">FECHA</td>
        <td width="12.5%"> <input class="campoCaptura" name="horaRealizaE" id="horaRealizaE" type="text" readonly> </td>
      </tr>
      <tr>
        <td nowrap width="12.5%">USUARIO CAPTURA</td>
        <td width="12.5%"> <input class="campoCaptura" name="usuarioCapturaE" id="usuarioCapturaE" type="text" readonly> </td>
        <td nowrap width="1%">FECHA</td>
        <td width="12.5%"> <input class="campoCaptura" name="horaCapturaE" id="horaCapturaE" type="text" readonly> </td>
        <td nowrap width="12.5%">USUARIO INTERPRETA</td>
        <td width="12.5%"> <input class="campoCaptura" name="usuarioInterpretaE" id="usuarioInterpretaE" type="text" readonly></td>
        <td nowrap width="1%">FECHA</td>
        <td width="12.5%"> <input class="campoCaptura" name="horaInterpretaE" id="horaInterpretaE" type="text" readonly> </td>
      </tr>
    </table>
    </td>
  </tr>
</table>