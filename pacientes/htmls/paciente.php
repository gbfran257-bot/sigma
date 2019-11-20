<div id="fichaPaciente" style="font-size:14px;">

<div>
  <ul id="pestanas" style="float:left;">
    <li><a class="tabs" id="tabs-1-1" href="#tabs-1">PERSONALES</a></li>
    <li><a class="tabs" id="tabs-2-1" href="#tabs-2">DOMICILIO</a></li>
    <li><a class="tabs" id="tabs-3-1" href="#tabs-3">FISCALES</a></li>
    <li style="display:none;"><a class="tabs" id="tabs-4-1" href="#tabs-4">EXPEDIENTE</a></li>
    <li style="display:none;"><a class="tabs" id="tabs-8-1" href="#tabs-8">FOTOS</a></li>
  </ul>
  <table id="botonesPac" style="float:right;" height="40px" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td class="botonesSaveP"><button id="savePac" class="botonP">Guardar</button></td>
    <td class="botonesSaveP"><button id="cancelSavePac" class="botonP">Cancelar</button></td>
    <td class="botonesUpdateP"><button id="editarPac" class="botonP">Editar</button></td>
    <!--<td class="botonesTerapiaP"><button id="aTerapia" class="botonP">Plan de rehabilitación</button></td> -->
    <td class="botonesUpdateP"><button id="cancelEditPac" class="botonP">Cancelar</button></td>
    <td class="botonesUpdateP"><button id="updatePac" class="botonP">Actualizar</button></td>
  </tr>
</table>
</div>

 <form action="" method="post" name="formGenerales" id="formGenerales" target="_self">
 <input name="nombreFotoT" id="nombreFotoT" type="hidden" value=""> <input name="hayFoto" id="hayFoto" type="hidden" value="0">
 <input name="idPacienteN" type="hidden" id="idPacienteN"> <input name="fotoU" type="hidden" id="fotoU">
 <input name="idUsuarioP" id="idUsuarioP" class="idUsuarioP" type="hidden" value="">
 <input name="temporal_s" type="hidden" id="temporal_s">
 <input name="p_latitud_s" type="hidden" id="p_latitud_s"> <input name="p_longitud_s" type="hidden" id="p_longitud_s">
 <input name="nuevo_o_viejo_u" type="hidden" id="nuevo_o_viejo_u" value="x"> <input name="ext_foto" type="hidden" id="ext_foto">
 
  <div class="miTab" id="tabs-1">
    <table class="t_uno fondo_tab" width="100%" height="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td>
        <table width="100%" border="0" cellspacing="4" cellpadding="2">
          <tr align="left">
            <td width="33.3%">Nombre(s) *</td>
            <td width="33.3%">A. Paterno *</td>
            <td >A. Materno</td>
          </tr>
          <tr>
            <td width="33.3%">
            <input name="nombreP" id="nombreP" type="text" onKeyUp="conMayusculas(this); solo_letras(this.value, this.name);" class="required" value="" placeholder="Nombre">
            </td>
            <td width="33.3%">
            <input name="apaternoP" id="apaternoP" type="text" onKeyUp="conMayusculas(this); solo_letras(this.value, this.name);" class="required" value="" placeholder="Apellido Paterno">
            </td>
            <td>
            <input name="amaternoP" id="amaternoP" type="text" onKeyUp="conMayusculas(this); solo_letras(this.value, this.name);" value="" placeholder="Apellido Materno">
            </td>
          </tr>
        </table>
        </td>
        <td rowspan="4" width="200" valign="top" align="center"><br>
        <button name="b_subir_foto" id="b_subir_foto" class="ui-button ui-widget ui-corner-all">FOTOGRAFÍA</button>
        <br><br>
        <div style="border:1px none red; height:180px; border-radius:4px;" id="foto_usuario"></div><br>
        <div id="progress2"> <div class="bar" style="width: 0%;"></div> </div>
        </td>
      </tr>
      <tr>
        <td>
        <table width="100%" border="0" cellspacing="4" cellpadding="2">
          <tr align="left">
          	<td nowrap>Fecha nacimiento *</td>
            <td nowrap>Edad</td>
            <td nowrap>Sexo *</td>
            <td nowrap>Nacionalidad *</td>
          </tr>
          <tr>
          	<td width="190px"><input name="fnacP" id="fnacP" type="text" placeholder="DÍA/MES/AÑO" class="required"></td>
            <td><input name="edadP" id="edadP" type="text" onKeyUp="conMayusculas(this); solo_numeros(this.value, this.name);" readonly class="" placeholder="EN AÑOS"></td>
            <td><select name="sexoP" id="sexoP" class="required"></select></td>
            <td><input name="nacionalidadP" id="nacionalidadP" type="text" value="MEXICANO" onKeyUp="conMayusculas(this); solo_letras(this.value, this.name);" class="required" placeholder="Nacionalidad"></td>
          </tr>
        </table>
        </td>
      </tr>
      <tr>
        <td>
        <table width="100%" border="0" cellspacing="4" cellpadding="2">
          <tr align="left">
          	<td nowrap>Entidad de nacimiento *</td>
            <td nowrap>CURP</td>
            <td nowrap align="center">RFC</td>
          </tr>
          <tr>
          	<td><select name="entidadNacimientoP" id="entidadNacimientoP" class="required"></select></td>
            <td width="33.3%">
            <span id="sprytextfield4">
            <input name="curpP" type="text" class="" id="curpP" onKeyUp="conMayusculas(this); solo_letras_numeros(this.value, this.name);" size="18" maxlength="18" placeholder="CLAVE ÚNICA REGISTRO POBLACIÓN">
            <span class="textfieldRequiredMsg">Se necesita un valor.</span><span class="textfieldMinCharsMsg">No se cumple el mínimo de caracteres requerido.</span><span class="textfieldMaxCharsMsg">Se ha superado el número máximo de caracteres.</span></span>
            </td>
            <td width="115px" width="17%"><input name="rfcP" type="text" id="rfcP" onKeyUp="conMayusculas(this); solo_letras_numeros(this.value, this.name);" maxlength="13" placeholder="R F C"></td>
          </tr>
        </table>
        </td>
      </tr>
      <tr>
        <td>
        <table width="100%" border="0" cellspacing="4" cellpadding="2">
          <tr align="left">
          	<td nowrap>Teléfono principal</td>
            <td nowrap>SUCURSAL</td>
            <td nowrap>TIPO SANGUÍNEO</td>
          </tr>
          <tr>
            <td width="160">
            <span id="sprytextfield1">
            <input name="telmovilP" id="telmovilP" type="text" maxlength="15" placeholder="Teléfono localizable">
            <span class="textfieldInvalidFormatMsg">Formato no válido.</span></span>
            </td>
            <td><select name="sucursalP" id="sucursalP"></select></td>
            <td class="rnacido"><input id="spinner1" name="spinner1" value="0:00 AM" readonly disabled></td>
            <td width="140"><select name="tSangreP" id="tSangreP" class=""></select></td>
          </tr>
        </table>
        </td>
      </tr>
      <tr>
        <td colspan="2">
        <table width="100%" border="0" cellspacing="4" cellpadding="2">
          <tr align="left">
          	<td nowrap width="30%">UNIDAD MÉDICA</td>
            <td nowrap width="">DERECHOHABIENCIA</td>
            <td nowrap width="25%">NÚMERO DE SEGURIDAD SOCIAL</td>
          </tr>
          <tr>
            <td><select name="centroSaludP" id="centroSaludP" class=""></select></td>
            <td><select name="derechohabienciaP" id="derechohabienciaP" class=""></select></td>
            <td><input name="nssP" type="text" id="nssP" onKeyUp="conMayusculas(this); solo_letras_numeros(this.value, this.name);" maxlength="60" placeholder="NÚMERO DE SEGURIDAD SOCIAL"></td>
          </tr>
        </table>
        </td>
      </tr>
    </table>
  </div>
  
  <div class="miTab" id="tabs-2">
  	<table class="t_uno fondo_tab" width="100%" height="100%" border="0" cellspacing="2" cellpadding="4">
      <tr align="left">
        <td width="50%"> Estado </td>
        <td colspan="3">
            Municipio
            <button class="ui-button ui-widget ui-corner-all ui-button-icon-only" title="Si no encuentras el municipio, puedes dar uno de alta." id="agregarMunicipio">
                <span class="ui-icon ui-icon-plusthick"></span>B
            </button>
        </td> 
      </tr>
      <tr>
        <td valign="top"><select name="estadoP" id="estadoP" class="required mi_dir"></select></td>
        <td valign="top" colspan="3"><select name="municipioP" id="municipioP" class="required mi_dir"></select></td>
      </tr>
      <tr align="left"> 
      	<td width="49%">
        	Colonia
            <button class="ui-button ui-widget ui-corner-all ui-button-icon-only" title="Si no encuentras la colonia, puedes dar una de alta." id="agregarColonia">
                <span class="ui-icon ui-icon-plusthick"></span>B
            </button>
        </td>
        <td width="49%">Calle y número</td><td style="min-width:80px !important;">C.p.</td>
        <td width="140" nowrap>Tel. particular</td>
      </tr>
      <tr>
        <td valign="top"><select name="coloniaP" id="coloniaP" class="mi_dir"></select></td>
        <td valign="top"><input name="calleP" id="calleP" type="text" onKeyUp="conMayusculas(this);" class="mi_dir"></td>
        <td valign="top"><select name="cpP" id="cpP"></select></td>
        <td valign="top">
        <span id="sprytextfield2">
        <input name="telparticularP" id="telparticularP" type="text" maxlength="15" placeholder="Teléfono particular">
        <span class="textfieldInvalidFormatMsg">Formato no válido.</span></span>
        </td>
      </tr>
      <tr align="center">
        <td nowrap width="50%">* LATITUD <span id="p_latitud"></span></td>
        <td nowrap width="50%" colspan="3">* LONGITUD <span id="p_longitud"></span></td>
      </tr>
      <tr align="center" height="95%">
        <td nowrap colspan="4">
        <div id="map" style="width:100%; height:100%; border:1px solid white;"></div>
        </td>
      </tr>
    </table>
  </div>
  
  <div class="miTab" id="tabs-3">
  	<table class="t_uno fondo_tab" width="100%" height="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="">
    	<tr align="left">
        <td>
        <table width="100%" height="100%" border="0" cellspacing="2" cellpadding="4">
          <tr>
            <td nowrap>Nombre o razón social</td>
            <td width="115px">RFC</td>
          </tr>
          <tr>
            <td valign="top">
            	<input name="razonPF" id="razonPF" type="text" onKeyUp="conMayusculas(this);" placeholder="Nombre o razón social">
            </td>
            
            <td valign="top">
            	<input name="rfcPF" type="text" id="rfcPF" onKeyUp="conMayusculas(this); solo_letras_numeros(this.value, this.name);" maxlength="13" placeholder="R F C">
            </td>
          </tr>
        </table>
        </td>
      </tr>
      <tr align="left">
        <td>
        <table width="100%" height="100%" border="0" cellspacing="2" cellpadding="4">
          <tr>
            <td>Email</td>
            <td width="40%">Banco</td>
            <td class="4d" width="90px" nowrap>4U-Dígitos</td>
          </tr>
          <tr>
            <td valign="top">
            	<input name="emailPF" id="emailPF" class="email" type="text" onKeyUp="conMinusculas(this);" title="Correo al que se enviarán las facturas" placeholder="Email">
            </td>
            <td valign="top"><select name="bancoPF" id="bancoPF"></select></td>
            <td class="4d" valign="top">
            	<input name="digitos4B" type="text" id="digitos4B" onKeyUp="solo_numeros(this.value, this.name);" maxlength="4" placeholder="4U-Dígitos">
            </td>
          </tr>
        </table>
        </td>
      </tr>
      <tr align="left">
        <td>
        <table width="100%" height="100%" border="0" cellspacing="2" cellpadding="2">
          <tr>
            <td width="50%" nowrap> Estado </td>
            <td nowrap>
            	Municipio
                <button class="ui-button ui-widget ui-corner-all ui-button-icon-only" title="Si no encuentras el municipio, puedes dar uno de alta." id="agregarMunicipioF">
                    <span class="ui-icon ui-icon-plusthick"></span>B
                </button>
            </td>
          </tr>
          <tr>
            <td> <select name="estadoPF" id="estadoPF" class=""></select> </td>
            <td> <select name="municipioPF" id="municipioPF" class=""></select> </td>
          </tr>
        </table>
        </td>
      </tr>
      <tr align="left">
        <td>
        <table width="100%" height="100%" border="0" cellspacing="2" cellpadding="2">
          <tr>
            <td width="40%" nowrap>
                Colonia
                <button class="ui-button ui-widget ui-corner-all ui-button-icon-only" title="Si no encuentras la colonia, puedes dar una de alta." id="agregarColoniaF">
                    <span class="ui-icon ui-icon-plusthick"></span>B
                </button>
            </td>
            <td nowrap>Calle</td>
            <td width="75" nowrap>C.P.</td>
          </tr>
          <tr>
            <td> <select name="coloniaPF" id="coloniaPF"></select> </td>
            <td> <input name="callePF" id="callePF" type="text" onKeyUp="conMayusculas(this);" placeholder="Calle"> </td>
            <td> <select name="cpPF" id="cpPF"></select> </td>
          </tr>
        </table>
        </td>
      </tr>
      <tr align="left">
        <td width="25%">
            <table width="100%" height="100%" border="0" cellspacing="2" cellpadding="2">
              <tr>
                <td width="90px" nowrap>Número ext</td>
                <td width="1%" nowrap>Número int</td>
                <td width="25%" nowrap>Teléfono de trabajo</td>
                <td>Extensión</td>
              </tr>
              <tr>
                <td>
                <input name="noExtPF" type="text" id="noExtPF" onKeyUp="conMayusculas(this); solo_letras_numeros(this.value, this.name);" maxlength="6" placeholder="Número ext">
                </td>
                <td>
                <input name="noIntPF" type="text" id="noIntPF" onKeyUp="conMayusculas(this); solo_letras_numeros(this.value, this.name);" maxlength="6" placeholder="Número int">
                </td>
                <td>
                <span id="sprytextfield3">
                <input name="telefonoTrabajoP"type="text"id="telefonoTrabajoP" maxlength="15"placeholder="Teléfono de trabajo">
                <span class="textfieldInvalidFormatMsg">Formato no válido.</span></span>
                </td>
                <td>
                <input name="extensionTelTraP"type="text" id="extensionTelTraP" onKeyUp="telefono(this.value, this.name);" maxlength="5" placeholder="Extensión">
                </td>
              </tr>
            </table>
        </td>
      </tr>
    </table>
  </div>

<div class="miTab" id="tabs-8">
  <form action="" method="post" name="form-foto" id="form-foto" target="_self" style="height:100%;">
  <input name="titulo_foto" type="hidden" class="required" id="titulo_foto" value="FOTO">
  <span class="btn btn-success fileinput-button">
    <i class="glyphicon glyphicon-plus"></i> <span></span>
    <input id="fileupload_foto" type="file" name="files[]" style="color:transparent;"accept="image/jpg, image/jpeg, image/png">
  </span>
  </form>
</div>

<div class="miTab" id="tabs-4" style="overflow:; border:1px none red;">

<div id="miTabsH" style="float:left; display:block; border:1px none red; width:100%; height:100%;">
<table width="100%" border="0" cellspacing="0" cellpadding="2" bgcolor="">
  <tr>
    <td id="">
    <ul id="pestanas1" style="float:left;">
        <li><a class="tabs" id="tabs-1-1h" href="#tabs-1h">S-V</a></li>
        <li><a class="tabs" id="tabs-2-1h" href="#tabs-2h">H-C</a></li>
        <li><a class="tabs" id="tabs-3-1h" href="#tabs-3h">CONSULTAS</a></li>
        <li><a class="tabs" id="tabs-4-1h" href="#tabs-4h">IMAGEN</a></li>
        <li><a class="tabs" id="tabs-5-1h" href="#tabs-5h">LABORATORIO</a></li>
        <li style="display:none;"><a class="tabs" id="tabs-6-1h" href="#tabs-6h"style="color:;background-color:;">ENDOSCOPÍA</a></li>
        <li><a class="tabs" id="tabs-7-1h" href="#tabs-7h">SERVICIOS</a></li>
    </ul>
    </td>
  </tr>
</table>

<div class="miTab" id="tabs-1h">

</div>
<div class="miTab" id="tabs-2h">

</div>
<div class="miTab" id="tabs-3h">
<table width="100%" height="93%" border="0" cellpadding="4" cellspacing="0" id="dataTableHCo" class="tablilla">
    <thead id="cabecera_tBusquedaHco" class="miCabeceraDT">
      <tr bgcolor="#FF6633">
        <th id="clickmeHCo" style="color:white;" width="1px">#</th>
        <th style="color:white;" width="10px">FECHA</th>
        <th style="color:white;" width="">CONSULTA</th>
        <th style="color:white;">MÉDICO ATENDIÓ</th>
      </tr>
    </thead>
    <tbody style="text-shadow:1px 1px 1px white;"> <tr> <td class="dataTables_empty">Cargando datos del servidor</td> </tr> </tbody>
  </table>
</div>
<div class="miTab" id="tabs-4h">
<table width="100%" height="93%" border="0" cellpadding="4" cellspacing="0" id="dataTableHIm" class="tablilla">
    <thead id="cabecera_tBusquedaHco" class="miCabeceraDT">
      <tr bgcolor="#FF6633">
        <th id="clickmeHIm" style="color:white;" width="1px">#</th>
        <th style="color:white;" width="10px">FECHA</th>
        <th style="color:white;" width="">ESTUDIO</th>
        <th style="color:white;">MÉDICO INTERPRETÓ</th>
      </tr>
    </thead>
    <tbody style="text-shadow:1px 1px 1px white;"> <tr> <td class="dataTables_empty">Cargando datos del servidor</td> </tr> </tbody>
  </table>
</div>
<div class="miTab" id="tabs-5h">
<table width="100%" height="93%" border="0" cellpadding="4" cellspacing="0" id="dataTableHLa" class="tablilla">
    <thead id="cabecera_tBusquedaHco" class="miCabeceraDT">
      <tr bgcolor="#FF6633">
        <th id="clickmeHLa" style="color:white;" width="1px">#</th>
        <th style="color:white;" width="10px">FECHA</th>
        <th style="color:white;" width="">ESTUDIO</th>
        <th style="color:white;">QUÍMICO RESPONSABLE</th>
      </tr>
    </thead>
    <tbody style="text-shadow:1px 1px 1px white;"> <tr> <td class="dataTables_empty">Cargando datos del servidor</td> </tr> </tbody>
  </table>
</div>
<div class="miTab" id="tabs-6h">
<table width="100%" height="93%" border="0" cellpadding="4" cellspacing="0" id="dataTableHEn" class="tablilla">
    <thead id="cabecera_tBusquedaHco" class="miCabeceraDT">
      <tr bgcolor="#FF6633">
        <th id="clickmeHEn" style="color:white;" width="1px">#</th>
        <th style="color:white;" width="10px">FECHA</th>
        <th style="color:white;" width="130px">ESTUDIO</th>
        <th style="color:white;">MÉDICO REALIZÓ</th>
      </tr>
    </thead>
    <tbody style="text-shadow:1px 1px 1px white;"> <tr> <td class="dataTables_empty">Cargando datos del servidor</td> </tr> </tbody>
  </table>
</div>
<div class="miTab" id="tabs-7h">
<table width="100%" height="93%" border="0" cellpadding="4" cellspacing="0" id="dataTableHSe" class="tablilla">
    <thead id="cabecera_tBusquedaHco" class="miCabeceraDT">
      <tr bgcolor="#FF6633">
        <th id="clickmeHSe" style="color:white;" width="1px">#</th>
        <th style="color:white;" width="10px">FECHA</th>
        <th style="color:white;" width="">SERVICIO</th>
        <th style="color:white;">PERSONAL ATENDIÓ</th>
      </tr>
    </thead>
    <tbody style="text-shadow:1px 1px 1px white;"> <tr> <td class="dataTables_empty">Cargando datos del servidor</td> </tr> </tbody>
  </table>
</div>

</div>
</div>
  
</form>

</div>

<div id="conveniosP">
<table width="100%" cellspacing="0" id="dataTableC1" height="100%" border="0" cellpadding="5" class="tablilla">
<thead>
  <tr class="encabezadoTable">
    <th align="center" id="miClick1c">
    	BENEFICIO
        <button id="addConvenio" class="ui-button ui-widget ui-corner-all ui-button-icon-only" title="AGREGAR BENEFICIO AL PACIENTE">
            <span class="ui-icon ui-icon-plusthick"></span> AGREGAR BENEFICIO AL PACIENTE
        </button>
    </th>
    <th align="center"nowrap>FECHA EXPEDICIÓN</th>
    <th align="center" nowrap>FECHA EXPIRACIÓN</th>
    <th align="center">ESTATUS</th>
    <th align="center" nowrap>DÍAS(-)</th>
    <th align="center" nowrap>ELIMINAR</th>
  </tr>
</thead>
<tbody align="left" class="color_cuerpo_tabla"> <tr> <td class="dataTables_empty">Cargando datos del servidor</td> </tr> </tbody>
</table>
</div>

<div id="detallesConvenioP">
<table width="100%" cellspacing="0" id="dataTableDCP" height="100%" border="0" cellpadding="4" class="tablilla">
<thead>
  <tr style="color:; background-color:; font-size:1em;" bgcolor="#FF6633">
    <th align="center" id="miClickDCP" style="color:white;">#</th>
    <th align="center" style="color:white;">CONCEPTO</th>
    <th align="center" style="color:white;">TIPO</th>
    <th align="center" style="color:white;">DISPONIBILIDAD</th>
  </tr>
</thead>
<tbody align="left" bgcolor="#FF6600">
    <tr>
        <td class="dataTables_empty">Cargando datos del servidor</td>
    </tr>
</tbody>
</table>
</div>

<div id="ubicacion" style="width:100%; height:100%;">
<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="2" id="tablaMU">
  <tr>
    <td width="100%">
    <div id="floating-panel">
    <select id="mode">
      <option value="DRIVING">Manejando</option>
      <option value="WALKING">Caminando</option>
      <option value="BICYCLING">Bicicleta</option>
      <option value="TRANSIT">Transporte</option>
    </select>
    </div>
    <div id="map1" style="width:100%; height:100%; border:1px solid white;"></div>
    </td>
    <td id="indicaciones_map" width="0%" valign="top" bgcolor="#999999" style="overflow:scroll;"> <div id="right-panel"></div> </td>
  </tr>
</table>
</div>

<script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "phone_number", {validateOn:["blur"], isRequired:false, useCharacterMasking:true});
var sprytextfield4 = new Spry.Widget.ValidationTextField("sprytextfield4", "none", {validateOn:["blur", "change"], minChars:18, maxChars:18});
</script>