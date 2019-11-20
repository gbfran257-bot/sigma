<div id="fichaUsuario">

<table width="100%" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td>
    <ul id="pestanas" style="font-size:0.8em;">
        <li><a class="tabs" id="tabs-1-1" href="#tabs-1">GENERALES</a></li>
        <li><a class="tabs" id="tabs-2-1" href="#tabs-2">DIRECCIÓN</a></li>
        <li><a class="tabs" id="tabs-3-1" href="#tabs-3">CONTACTO</a></li>
        <li><a class="tabs" id="tabs-4-1" href="#tabs-4">PROFESIONALES</a></li>
        <li><a class="tabs" id="tabs-5-1" href="#tabs-5">HORARIO</a></li>
        <li><a class="tabs" id="tabs-6-1" href="#tabs-6">CONCEPTOS</a></li>
        <li style="display:none;"><a class="tabs" id="tabs-7-1" href="#tabs-7">FIRMAS</a></li>
        <li style="display:none;"><a class="tabs" id="tabs-8-1" href="#tabs-8">FOTOS</a></li>
      </ul>
    </td>
    <td> <button id="updateUser">Actualizar</button> <button id="guardarUser">Guardar</button> </td>
  </tr>
</table>

 <form action="" method="post" name="formGenerales" id="formGenerales" target="_self">
 <input name="nombreFotoT" id="nombreFotoT" type="hidden" value=""> <input name="hayFoto" id="hayFoto" type="hidden" value="0">
 <input name="idPacienteN" type="hidden" id="idPacienteN"> <input name="firmaU" type="hidden" id="firmaU">
 <input name="temporal_s" type="hidden" id="temporal_s"> <input name="ext_firma" type="hidden" id="ext_firma">
 <input name="p_latitud_s" type="hidden" id="p_latitud_s"> <input name="p_longitud_s" type="hidden" id="p_longitud_s">
 <input name="nuevo_o_viejo_u" type="hidden" id="nuevo_o_viejo_u" value="x"> <input name="ext_foto" type="hidden" id="ext_foto">
 <input name="fotoU" type="hidden" id="fotoU">
 
  <div class="miTab" id="tabs-1" style="font-size:0.75em;">
  	<span class="summary"></span>
    <input name="idUsuarioP" id="idUsuarioP" class="idUsuarioP" type="hidden" value="">
            
    <table width="100%" height="100%" border="0" cellspacing="0" cellpadding="4" class="fondo_tab">
      <tr>
        <td width="" align="left" valign="top">
            <table width="100%" border="0" cellspacing="4" cellpadding="2">
              <tr align="left">
              	<td width="80" nowrap>Título</td>
                <td width="30%">Nombre(s) *</td>
                <td width="30%">A. Paterno *</td>
                <td >A. Materno</td>
              </tr>
              <tr>
              	<td valign="top">
                    <select name="cTituloU" id="cTituloU" class="required">
                      <option value="">-TÍTULO-</option>
                      <option value="C.">C.</option>
                      <option value="DR.">DR.</option>
                      <option value="DRA.">DRA.</option>
                      <option value="QFB.">QFB.</option>
                      <option value="TLC.">TLC.</option>
                      <option value="TR.">TR.</option>
                      <option value="ING.">ING.</option>
                      <option value="CP.">CP.</option>
                      <option value="LIC.">LIC.</option>
                    </select>
                </td>
                <td><input name="nombreP" id="nombreP" type="text" onKeyUp="conMayusculas(this); solo_letras(this.value, this.name);" class="required" value=""></td>
                <td><input name="apaternoP" id="apaternoP" type="text" onKeyUp="conMayusculas(this); solo_letras(this.value, this.name);" class="required" value=""></td>
                <td><input name="amaternoP" id="amaternoP" type="text" onKeyUp="conMayusculas(this); solo_letras(this.value, this.name);" value=""></td>
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
            <td width="33.3%">Sexo *</td>
            <td width="33.3%">Nacionalidad *</td>
            <td >Fecha de nacimiento *</td>
          </tr>
          <tr>
            <td><select name="sexoP" id="sexoP" class="required"></select></td>
            <td><input name="nacionalidadP" id="nacionalidadP" type="text" value="MEXICANA" onKeyUp="conMayusculas(this); solo_letras(this.value, this.name);"></td>
            <td><input name="fnacP" id="fnacP" type="text" placeholder="DD/MM/AAAA" class="required"></td>
          </tr>
        </table>
        </td>
      </tr>
      <tr>
        <td>
        <table width="100%" border="0" cellspacing="4" cellpadding="2">
          <tr align="left">
            <td width="33.3%">Curp</td>
            <td width="17%" align="center">Rfc</td>
            <td>Sucursal</td>
          </tr>
          <tr>
            <td><input name="curpP" type="text" id="curpP" onKeyUp="conMayusculas(this); solo_letras_numeros(this.value, this.name);" maxlength="18"></td>
            <td><input name="rfcP" type="text" id="rfcP" onKeyUp="conMayusculas(this); solo_letras_numeros(this.value, this.name);" maxlength="13"></td>
            <td><select name="sucursalP" id="sucursalP" class="required"></select></td>
          </tr>
        </table>
        </td>
      </tr>
      <tr>
        <td>
        <table width="100%" border="0" cellspacing="2" cellpadding="2">
          <tr align="left">
            <td width="50%"><span title="El tipo de acceso que tendrá el usuario en el sistema">Tipo de usuario *</span></td>
            <td><span title="El nombre de usuario que se utilizará para firmarse y entrar al sistema. Por defaul al crear un usuario su contraseña será la misma que el nommbre de usuario.">Nombre de usuario *</span></td>
          </tr>
          <tr>
            <td>
            <select name="tipoUsuario" id="tipoUsuario" class="required"> </select>
            </td>
            <td>
            <table width="100%" border="0" cellspacing="0" cellpadding="2">
              <tr>
                <td width="100%"><input name="username" id="username" type="text" maxlength="20" onKeyUp="conMayusculas(this); nick(this.value, this.name);" class="required"></td>
                <td class="tAlertaU" nowrap valign="top"><div style="height:30px; width:100px; color:red;"><span id="iconoUsuario" class="ui-icon ui-icon-alert" style="float: left; margin: 0 -5px 0px 16px;"></span><span id="textoUsuarioDisponible" class="textoAlerta">Vacío</span></div></td>
              </tr>
            </table>
            </td>
          </tr>
        </table>
        </td>
        <!--<td></td> -->
      </tr>
      <tr>
        <td colspan="2">
        <table width="100%" border="0" cellspacing="4" cellpadding="2">
          <tr align="left">
            <td >Notas</td>
            <td width="140px" nowrap>Teléfono celular</td>
            <td width="140px">Tipo sanguíneo</td>
          </tr>
          <tr>
            <td>
            <textarea name="notasP" id="notasP" cols="" rows="" style="resize:none;" onKeyUp="conMayusculas(this);"></textarea>
            </td>
            <td>
            <span id="sprytextfield1">
            <input name="telmovilP" id="telmovilP" type="text" maxlength="15">
            <span class="textfieldRequiredMsg">Se necesita un valor.</span><span class="textfieldInvalidFormatMsg">Formato no válido.</span></span>
            </td>
            <td valign="top"><select name="tsanguineoP" id="tsanguineoP"></select></td>
          </tr>
        </table>
        </td>
        <!--<td></td> -->
      </tr>
    </table>
  </div>
  
  <div class="miTab" id="tabs-2" style="font-size:0.75em;">
  	<span class="summary"></span>
  	<table width="100%" height="100%" border="0" cellspacing="3" cellpadding="2" class="fondo_tab">
      <tr align="left"> 
     	<td width="50%">Estado</td> <td colspan="2">Municipio</td> 
      </tr>
      <tr>
        <td valign="top"><select name="estadoP" id="estadoP" class="required mi_dir"></select></td>
        <td valign="top" colspan="2"><select name="municipioP" id="municipioP" class="required mi_dir"></select></td>
      </tr>
      <tr align="left"> 
      	<td width="49%">Colonia</td><td width="49%">Calle y número</td><td style="min-width:80px !important;">C.p.</td></tr>
      <tr>
        <td valign="top"><select name="coloniaP" id="coloniaP" class="mi_dir"></select></td>
        <td valign="top"><input name="calleP" id="calleP" type="text" onKeyUp="conMayusculas(this);" class="mi_dir"></td>
        <td valign="top"><select name="cpP" id="cpP"></select></td>
      </tr>
      <tr align="center">
        <td nowrap width="50%">* LATITUD <span id="p_latitud"></span></td>
        <td nowrap width="50%" colspan="2">* LONGITUD <span id="p_longitud"></span></td>
      </tr>
      <tr align="center" height="95%">
        <td nowrap colspan="3">
        <div id="map" style="width:100%; height:100%; border:1px solid white;"></div>
        </td>
      </tr>
    </table>
  </div>
  
  <div class="miTab" id="tabs-3" style="font-size:0.75em;">
  	<span class="summary"></span>
  	<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="2" class="fondo_tab">
      <tr align="left">
        <td>
        <table width="100%" height="100%" border="0" cellspacing="0" cellpadding="2">
          <tr>
          	<td>
            <table width="100%" height="100%" border="0" cellspacing="0" cellpadding="2">
              <tr>
                <td width="35%">Teléfono particular</td>
              </tr>
              <tr>
                <td valign="top">
                <span id="sprytextfield2">
            <input name="telparticularP" id="telparticularP" type="text" maxlength="15">
            <span class="textfieldRequiredMsg">Se necesita un valor.</span><span class="textfieldInvalidFormatMsg">Formato no válido.</span></span>
                </td>
              </tr>
            </table>
            </td>
            <td>
            <table width="100%" height="100%" border="0" cellspacing="0" cellpadding="2">
              <tr>
                <td width="35%">Teléfono de trabajo</td>
              </tr>
              <tr>
                <td valign="top">
                <span id="sprytextfield3">
            <input name="telefonoTrabajoP" id="telefonoTrabajoP" type="text" maxlength="15">
            <span class="textfieldRequiredMsg">Se necesita un valor.</span><span class="textfieldInvalidFormatMsg">Formato no válido.</span></span>
                </td>
              </tr>
            </table>
            </td>
            <td>
            <table width="100%" height="100%" border="0" cellspacing="0" cellpadding="2">
              <tr>
                <td>Extensión</td>
              </tr>
              <tr>
                <td valign="top"><input name="extensionTelTraP" type="text" id="extensionTelTraP" onKeyUp="telefono(this.value, this.name);" maxlength="5"></td>
              </tr>
            </table>
            </td>
          </tr>
        </table>
        </td>
      </tr>
      <tr align="left">
        <td>
        <table width="100%" height="100%" border="0" cellspacing="0" cellpadding="2">
          <tr>
            <td>Contacto de emergencia</td>
          </tr>
          <tr>
            <td valign="top"><input name="avisarP" id="avisarP" type="text" onKeyUp="conMayusculas(this); solo_letras_numeros(this.value, this.name);"></td>
          </tr>
        </table>
        </td>
      </tr>
      <tr align="left">
        <td>
        <table width="100%" height="100%" border="0" cellspacing="0" cellpadding="2">
          <tr>
            <td>Teléfono de emergencia</td>
          </tr>
          <tr>
            <td valign="top">
            <span id="sprytextfield4">
            <input name="telefonoEmergenciaP" id="telefonoEmergenciaP" type="text" maxlength="15">
            <span class="textfieldRequiredMsg">Se necesita un valor.</span><span class="textfieldInvalidFormatMsg">Formato no válido.</span></span>
            </td>
          </tr>
        </table>
        </td>
      </tr>
      <tr align="left">
        <td>
        <table width="100%" height="100%" border="0" cellspacing="0" cellpadding="2">
          <tr>
            <td>Email</td>
          </tr>
          <tr>
            <td valign="top"><input class="email" name="emailP" id="emailP" type="text" onKeyUp="conMinusculas(this);"></td>
          </tr>
        </table>
        </td>
      </tr>
    </table>
  </div>

  <div class="miTab" id="tabs-4" style="font-size:0.75em;">
  	<span class="summary"></span>
  	<table width="100%" height="100%" border="0" cellspacing="2" cellpadding="2" class="fondo_tab">
      <tr align="left">
        <td>
        <table width="100%" height="100%" border="0" cellspacing="0" cellpadding="2">
          <tr>
            <td width="33.3%">
            <table width="100%" height="100%" border="0" cellspacing="0" cellpadding="2">
              <tr>
                <td>Departamento</td>
              </tr>
              <tr>
                <td valign="top"><select name="departamentoU" id="departamentoU" class="required"></select></td>
              </tr>
            </table>
            </td>
            <td width="33.3%">
            <table width="100%" height="100%" border="0" cellspacing="0" cellpadding="2">
              <tr>
                <td>Área</td>
              </tr>
              <tr>
                <td valign="top"><select name="areaU" id="areaU" class="required"></select></td>
              </tr>
            </table>
            </td>
            <td>
            <table width="100%" height="100%" border="0" cellspacing="0" cellpadding="2">
              <tr>
                <td>Puesto</td>
              </tr>
              <tr>
                <td valign="top"><select name="puestoU" id="puestoU" class="required"></select></td>
              </tr>
            </table>
            </td>
          </tr>
        </table>
        </td>
        <td rowspan="4" width="200" valign="top" align="center"><br>
        <label for="checkbox-fu">Usar firma digital</label> <input onClick="" class="checki1" type="checkbox" name="checkbox-fu" id="checkbox-fu"><br><br>
        <div style="border:1px none red; height:180px; border-radius:4px;" id="firma_usuario"></div><br>
        <div id="progress1"> <div class="bar" style="width: 0%;"></div> </div>
        </td>
      </tr>
      <tr align="left">
        <td>
        <table width="100%" height="100%" border="0" cellspacing="0" cellpadding="2">
          <tr>
          	<td width="33%">Máximo grado de estudios</td> <td>Profesión</td>
          </tr>
          <tr>
          	<td valign="top"><select name="escolaridadP" id="escolaridadP"></select></td>
            <td valign="top"><input name="profesionUsuario" id="profesionUsuario" type="text" onKeyUp="conMayusculas(this); solo_letras(this.value, this.name);"></td>
          </tr>
        </table>
        </td>
      </tr>
      <tr align="left">
        <td>
        <table width="100%" height="100%" border="0" cellspacing="0" cellpadding="2">
          <tr>
            <td>Universidad <button class='ui-button ui-widget ui-corner-all ui-button-icon-only botonaso' onClick='universidad(this.name)' name='' lang='' title=''><span class='ui-icon ui-icon-search'></span>B</button></td>
          </tr>
          <tr>
            <td valign="top"><input name="universidadU" id="universidadU" type="text" readonly><input name="id_uni_u" id="id_uni_u" type="hidden" value=""></td>
          </tr>
        </table>
        </td>
      </tr>
      <tr align="left" class="profesional">
        <td>
        <table width="100%" height="100%" border="0" cellspacing="0" cellpadding="2">
          <tr>
            <td width="33%">
            <table width="100%" height="100%" border="0" cellspacing="0" cellpadding="2">
              <tr>
                <td>Cédula profesional</td>
              </tr>
              <tr>
                <td valign="top"><input name="cedulaU" id="cedulaU" type="text" onKeyUp="conMayusculas(this); nick(this.value, this.name);"></td>
              </tr>
            </table>
            </td>
            <td width="33%">
            <table width="100%" height="100%" border="0" cellspacing="0" cellpadding="2">
              <tr>
                <td>Especialidad</td>
              </tr>
              <tr>
                <td valign="top">
                <select name="especialidadU" id="especialidadU"></select>
                </td>
              </tr>
            </table>
            </td>
            <td width="">
            <table width="100%" height="100%" border="0" cellspacing="0" cellpadding="2">
              <tr>
                <td>Cédula profesional especialidad</td>
              </tr>
              <tr>
                <td valign="top"><input name="cedulaU1" id="cedulaU1" type="text" onKeyUp="conMayusculas(this); nick(this.value, this.name);"></td>
              </tr>
            </table>
            </td>
          </tr>
        </table>
        </td>
      </tr>
      <tr align="left">
        <td>
        <table width="100%" height="100%" border="0" cellspacing="0" cellpadding="2">
          <tr>
            <td>Ocupación</td>
          </tr>
          <tr>
            <td valign="top"><input name="ocupacionP" id="ocupacionP" type="text" onKeyUp="conMayusculas(this); solo_letras(this.value, this.name);"></td>
          </tr>
        </table>
        </td>
      </tr>
    </table>
  </div>
  
  <div class="miTab" id="tabs-5">
  	<table width="100%" height="100%" border="0" cellspacing="2" cellpadding="3" class="">
      <tr align="left"> 
      	<td nowrap align="center" colspan="3">
        	<div class="ui-state-default ui-corner-all ui-helper-clearfix">
            INDIQUE EL HORARIO LABORAL PARA CADA DÍA DE LA SEMANA
            </div>
        </td> 
      </tr>
      <tr align="left">
      	<td width="190px" nowrap>
        	<label for="checkbox-lu">LUNES</label> <input class="checki" type="checkbox" name="checkbox-lu" id="checkbox-lu">
        <td align="right" valign="middle" width="150px" nowrap class="texto_lu">
        	<span style="float:right;">(DE <span class="lun-vier-i" id="lunes_de"></span> 
            A <span class="lun-vier-f" id="lunes_a"></span>)</span>
        </td>
        </td>
        <td>
        	<input name="lunes_de1" id="lunes_de1" type="hidden"> <input name="lunes_a1" id="lunes_a1" type="hidden">
        	<div class="slider_lunes_viernes lunes_de lunes_a" id="slider-lunes"></div>
        </td>
    </tr>
    <tr align="left">
      	<td nowrap>
        	<label for="checkbox-ma">MARTES</label> <input class="checki" type="checkbox" name="checkbox-ma" id="checkbox-ma">
        </td>
        <td align="right" valign="middle" class="texto_ma">
        	<span style="float:right;">(DE <span class="lun-vier-i" id="martes_de"></span> 
            A <span class="lun-vier-f" id="martes_a"></span>)</span></td>
        <td>
        	<input name="martes_de1" id="martes_de1" type="hidden"> <input name="martes_a1" id="martes_a1" type="hidden">
        	<div class="slider_lunes_viernes" id="slider-martes"></div>
        </td>
    </tr>
    <tr align="left">
      	<td nowrap>
        	<label for="checkbox-mi">MIÉRCOLES</label> <input class="checki" type="checkbox" name="checkbox-mi" id="checkbox-mi">
        </td>
        <td align="right" valign="middle" class="texto_mi">
        	<span style="float:right;">(DE <span class="lun-vier-i" id="miercoles_de"></span> 
            A <span class="lun-vier-f" id="miercoles_a"></span>)</span></td>
        <td>
        <input name="miercoles_de1" id="miercoles_de1" type="hidden"> <input name="miercoles_a1" id="miercoles_a1" type="hidden">
        	<div class="slider_lunes_viernes" id="slider-miercoles"></div>
        </td>
    </tr>
    <tr align="left">
      	<td nowrap>
        	<label for="checkbox-ju">JUEVES</label> <input class="checki" type="checkbox" name="checkbox-ju" id="checkbox-ju">
        </td>
        <td align="right" valign="middle" class="texto_ju">
        	<span style="float:right;">(DE <span class="lun-vier-i" id="jueves_de"></span> 
            A <span class="lun-vier-f" id="jueves_a"></span>)</span>
        </td>
        <td>
        	<input name="jueves_de1" id="jueves_de1" type="hidden"> <input name="jueves_a1" id="jueves_a1" type="hidden">
        	<div class="slider_lunes_viernes" id="slider-jueves"></div>
        </td>
    </tr>
    <tr align="left">
      	<td nowrap>
        	<label for="checkbox-vi">VIERNES</label> <input class="checki" type="checkbox" name="checkbox-vi" id="checkbox-vi">
        </td>
        <td align="right" valign="middle" class="texto_vi">
        	<span style="float:right;">(DE <span class="lun-vier-i" id="viernes_de"></span> 
            A <span class="lun-vier-f" id="viernes_a"></span>)</span></td>
        <td>
        	<input name="viernes_de1" id="viernes_de1" type="hidden"> <input name="viernes_a1" id="viernes_a1" type="hidden">
        	<div class="slider_lunes_viernes" id="slider-viernes"></div>
        </td>
    </tr>
    <tr align="left">
      	<td nowrap>
        	<label for="checkbox-sa">SÁBADO</label> <input class="checki" type="checkbox" name="checkbox-sa" id="checkbox-sa">
        </td>
        <td align="right" valign="middle" class="texto_sa">
        	<span style="float:right;">(DE <span class="sab-dom-i" id="sabado_de"></span> 
            A <span class="sab-dom-f" id="sabado_a"></span>)</span>
        </td>
        <td>
        	<input name="sabado_de1" id="sabado_de1" type="hidden"> <input name="sabado_a1" id="sabado_a1" type="hidden">
        	<div class="slider_fin_semana" id="slider-sabado"></div>
        </td>
    </tr>
    <tr align="left">
      	<td nowrap>
        	<label for="checkbox-do">DOMINGO</label> <input class="checki" type="checkbox" name="checkbox-do" id="checkbox-do">
        </td>
        <td align="right" valign="middle" class="texto_do">
        	<span style="float:right;">(DE <span class="sab-dom-i" id="domingo_de"></span> 
            A <span class="sab-dom-f" id="domingo_a"></span>)</span>
        </td>
        <td>
        	<input name="domingo_de1" id="domingo_de1" type="hidden"> <input name="domingo_a1" id="domingo_a1" type="hidden">
        	<div class="slider_fin_semana" id="slider-domingo"></div>
        </td>
    </tr>
    </table>    
  </div> </form>
  
  <div class="miTab" id="tabs-6">
  <table width="99%" height="100%" border="0" cellpadding="1" cellspacing="0" id="dataTableTos" class="tablilla">
    <thead id="cabecera_tBusquedaTos">
      <tr class="titulos_dataceldas" style="font-size:0.8em;">
        <th id="clickmeTos" align="center" width="1px">#</th>
        <th align="center">
        	CONCEPTO
        	<button onClick='nuevo_concepto()' id="nvo_cto" class='ui-button ui-widget ui-corner-all ui-button-icon-only' title=''><span class='ui-icon ui-icon-plusthick'></span>B</button>
        </th>
        <th align="center" width="90px" nowrap>$ PRECIO</th>
        <th align="center" width="120px" nowrap>$ URGENCIA</th>
     	<th align="center" nowrap width="100px"># VENTAS</th>
        <th align="center" nowrap width="10px"> </th>
      </tr>
    </thead>
    <tbody class="cuerpo_datatable"> <tr> <td class="dataTables_empty">Cargando datos del servidor</td> </tr> </tbody>
  </table>
  </div>
  
  <div class="miTab" id="tabs-7">
  <form action="" method="post" name="form-firma" id="form-firma" target="_self" style="height:100%;">
  <input name="titulo_firma" type="hidden" class="required" id="titulo_firma" value="FIRMA">
  <span class="btn btn-success fileinput-button">
    <i class="glyphicon glyphicon-plus"></i> <span></span>
    <input id="fileupload_firma" type="file" name="files[]" style="color:transparent;"accept="image/jpg, image/jpeg, image/png">
  </span>
  </form>
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

</div>

<div id="concepto">
<form action="" method="post" name="formFconsulta" id="formFconsulta" target="_self" style="height:100%;">
 	<input name="idConsulta" type="hidden" id="idConsulta">
    <input name="idUsuarioNC" id="idUsuarioNC" type="hidden" value="">
    <input name="tempCto" type="hidden" id="tempCto">
    <table width="100%" height="100%" border="0" cellspacing="0" cellpadding="4">
      <tr>
        <td>
        <table width="100%" height="100%" border="0" cellspacing="0" cellpadding="4">
          <tr align="left"> 
          	<td nowrap valign="bottom">* NOMBRE DEL CONCEPTO</td> 
          </tr>
          <tr>
            <td valign="top">
            	<input name="nombreC" id="nombreC" type="text" onKeyUp="conMayusculas(this);" class="required" value="">
            </td>
          </tr>
        </table>
        </td>
      </tr>
      <tr>
        <td>
        <table width="100%" border="0" cellspacing="0" cellpadding="4">
          <tr align="left">
            <td width="100%" nowrap>* ÁREA DEL CONCEPTO</td>
          </tr>
          <tr>
            <td><select name="areaC" id="areaC" class="required"></select></td>
          </tr>
        </table>
        </td>
      </tr>
      <tr>
        <td>
        <table width="100%" border="0" cellspacing="0" cellpadding="4" height="100%">
          <tr align="left">
            <td width="50%" valign="bottom" nowrap>PRECIO($) *</td>
            <td valign="bottom" nowrap>PRECIO URGENCIA($) *</td>
          </tr>
          <tr>
            <td valign="top">
            <input name="precioC" id="precioC" type="text" onKeyUp="conMayusculas(this); numeros_decimales(this.value, this.name);" class="required" value="">
            </td>
            <td valign="top">
            <input name="precioCurgencia" id="precioCurgencia" type="text" onKeyUp="conMayusculas(this); numeros_decimales(this.value, this.name);" class="required" value="">
            </td>
          </tr>
        </table>
        </td>
      </tr>
    </table>
</form>
</div>

<table width="100%" height="100%" border="0" cellpadding="1" cellspacing="1" id="dataTableDocs" class="tablilla">
<thead id="cabecera_tBusquedaDocs" class="">
  <tr style="font-size:1.25em;">
    <th id="clickmeDo"class="titulosTabs"align="center" nowrap width="1px">#</th>
    <th class="titulosTabs" align="center">
    	DOCUMENTO<input id="name_doc" type="hidden" value="">
        <button style="height:22px;" name="b_subir_doc" id="b_subir_doc" class="ui-button ui-widget ui-corner-all ui-button-icon-only"><span title="Agregar un documento" class="ui-icon ui-icon-document"></span>B</button>
    </th>
    <th class="titulosTabs" align="center" width="10px" nowrap>
    	<span title="Ver el documento">VISUALIZAR</span> <input id="idS_doc" type="hidden" value="">
    </th>
    <th class="titulosTabs" align="center" width="10px" nowrap> <span title="Eliminar el documento">ELIMINAR</span> </th>
  </tr>
</thead> <tbody style="color:black; text-align:justify;"> <tr> <td class="dataTables_empty">Cargando datos del servidor</td> </tr> </tbody> </tfoot>
</table>

<div id="documento">
<form action="" method="post" name="form-documento" id="form-documento" target="_self" style="height:100%;">
<table width="100%" height="100%" border="0" cellspacing="4" cellpadding="6">
  <tr>
    <td colspan="2" align="justify">Para subir un documento es necesario que seleccione un archivo de imagen o PDF.</td>
  </tr>
  <tr>
    <td width="1%" nowrap valign="top">Título del documento</td>
    <td align="left">
    	<input name="titulo_documento" type="text" class="required" id="titulo_documento" style="width:99%;" onKeyUp="conMayusculas(this); solo_letras_numeros(this.value, this.name);" maxlength="50" autofocus>
    </td>
  </tr>
  <tr>
    <td colspan="2" align="left">
    <span class="btn btn-success fileinput-button">
        <i class="glyphicon glyphicon-plus"></i>
        <span></span>
        <!-- The file input field used as target for the file upload widget -->
        <input id="fileupload_docu" type="file" name="files[]" class="" style="color:transparent;"accept="image/jpg, image/jpeg, image/png, application/pdf">
    </span>
    <br>
    <div id="progress">
        <div class="bar" style="width: 0%;"></div>
    </div>
    </td>
  </tr>
</table>
</form>
</div>

<div id="permisos">

<table width="100%" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td>
    <ul id="pestanas" style="font-size:0.8em;">
        <li><a class="tabs" id="tabs-1-1" href="#tabs-1">RECEPCIÓN</a></li>
        <li><a class="tabs" id="tabs-2-1" href="#tabs-2">CONSULTAS</a></li>
        <li><a class="tabs" id="tabs-3-1" href="#tabs-3">HOSPITAL</a></li>
        <li><a class="tabs" id="tabs-4-1" href="#tabs-4">IMAGEN</a></li>
        <li><a class="tabs" id="tabs-5-1" href="#tabs-5">LABORATORIO</a></li>
        <li><a class="tabs" id="tabs-6-1" href="#tabs-6">REHABILITACIÓN</a></li>
        <li><a class="tabs" id="tabs-7-1" href="#tabs-7">FARMACIA</a></li>
        <li><a class="tabs" id="tabs-8-1" href="#tabs-8">ADMINISTRACIÓN</a></li>
      </ul>
    </td>
    <td>
    <select name="st_usuario_s" id="st_usuario_s">
      <option value="0">SIMPLE</option>
      <option value="2">SUCURSAL</option>
      <option value="1">MULTISUCURSAL</option>
    </select>
    </td>
  </tr>
</table>

<form action="" method="post" name="formGenerales" id="formGenerales" target="_self">
	<div class="miTab" id="tabs-1" style="font-size:0.75em;"> </div>
    <div class="miTab" id="tabs-2" style="font-size:0.75em;"> </div>
    <div class="miTab" id="tabs-3" style="font-size:0.75em;"> </div>
    <div class="miTab" id="tabs-4" style="font-size:0.75em;"> </div>
    <div class="miTab" id="tabs-5" style="font-size:0.75em;"> </div>
    <div class="miTab" id="tabs-6" style="font-size:0.75em;"> </div>
    <div class="miTab" id="tabs-7" style="font-size:0.75em;"> </div>
    <div class="miTab" id="tabs-8" style="font-size:0.75em;"> </div>
</form>

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
