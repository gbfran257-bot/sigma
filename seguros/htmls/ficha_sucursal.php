<div id="ficha_sucursal" style="overflow:hidden;">
<ul id="pestanas">
    <li><a class="tabs" id="tabs-1-1" href="#tabs-1">GENERALES</a></li>
    <li><a class="tabs" id="tabs-2-1" href="#tabs-2">DIRECCIÓN</a></li>
    <li><a class="tabs" id="tabs-3-1" href="#tabs-3">HORARIOS</a></li>
    <li><a class="tabs" id="tabs-4-1" href="#tabs-4">MONEDERO</a></li>
</ul>
<form action="" method="post" name="formSucursal" id="formSucursal" target="_self" style="height:100%;">
 	<input name="idSucursal" type="hidden" id="idSucursal"> <input name="idUsuarioNC" id="idUsuarioNC" type="hidden" value="">
    <input name="p_t_i" type="hidden" id="p_t_i"> <input name="p_t_l" type="hidden" id="p_t_l">
    <input name="p_t_s" type="hidden" id="p_t_s"> <input name="temporal_s" type="hidden" id="temporal_s">
    <input name="p_latitud_s" type="hidden" id="p_latitud_s" value="18.8135"> 
    <input name="p_longitud_s" type="hidden" id="p_longitud_s" value="-19.9535">
    <div class="miTab" id="tabs-1">
    <table width="100%" height="100%" border="0" cellspacing="2" cellpadding="2" id="t_t_1_1">
      <tr>
        <td>
        <table width="100%" height="100%" border="0" cellspacing="3" cellpadding="4">
          <tr align="left">
            <td width="320" nowrap>* NOMBRE, CLAVE Y CLUES</td>
            <td colspan="1">
            	<input name="nombreC" id="nombreC" type="text" onKeyUp="conMayusculas(this);" class="required" placeholder="Nombre de la sucursal">
            </td>
            <td width="130px">
            	<input name="claveC" type="text" class="required" id="claveC" onKeyUp="conMayusculas(this);" maxlength="6"placeholder="Clave">
            </td>
            <td width="100px" colspan="3">
            	<input name="cluesC" type="text" class="required" id="cluesC" onKeyUp="conMayusculas(this);" placeholder="CLUES">
            </td>
          </tr>
          <tr align="left">
            <td width="" nowrap id="celda_maqui_i" style="white-space:nowrap;">TABULADOR IMAGEN<span id="amountI" style="float:right" class="verMenu"></span></td>
            <td colspan="4">
            	<div id="sliderI"></div>
            </td>
            <td width="190" nowrap>
            	<select name="tab_img" id="tab_img" class="required">
            	  <option value="">-TABULADOR BASE-</option> <option value="1">MAQUILA</option> <option value="2">SUCURSAL</option>
            	</select>
            </td>
          </tr>
          <tr align="left">
            <td nowrap id="tabu_lab" width="1%">TABULADOR LABORATORIO<span id="amountL" style="float:right" class="verMenu"></span></td>
            <td colspan="4">
            	<div id="sliderL"></div>
            </td>
            <td width="" id="celda_maqui_l" nowrap>
            	<select name="tab_lab" id="tab_lab" class="required">
            	  <option value="">-TABULADOR BASE-</option> <option value="1">MAQUILA</option> <option value="2">SUCURSAL</option>
            	</select>
            </td>
          </tr>
          <tr align="left">
            <td nowrap id="celda_maqui_s">TABULADOR SERVICIOS<span id="amountS" style="float:right" class="verMenu"></span></td>
            <td colspan="4">
            	<div id="sliderS"></div>
            </td>
            <td id="reset_all"></td>
          </tr>
        </table>
        </td>
      </tr>
      <tr>
        <td>
        <table width="100%" height="100%" border="0" cellspacing="3" cellpadding="4">
          <tr align="left">
            <td width="1%" nowrap>* TELÉFONO(S)</td>
            <td>
            	<input name="telefonoS" type="text" class="required" id="telefonoS" onKeyUp="conMayusculas(this);" placeholder="Teléfono(s) de la sucursal">
            </td>
            <td width="1%" nowrap>EMAIL</td>
            <td>
            	<input name="emailS" type="text" class="" id="emailS" onKeyUp="conMinusculas(this);" placeholder="Correo electrónico de la sucursal">
            </td>
          </tr>
          <tr align="left">
            <td width="1%" nowrap>SITIO WEB</td>
            <td>
            	<input name="sitioS" type="text" class="" id="sitioS" onKeyUp="conMinusculas(this);" placeholder="http://tusitioweb.com">
            </td>
            <td width="1%" nowrap>* LINK PACS</td>
            <td>
            <input name="linkP" type="text" class="required" id="linkP" onKeyUp="conMinusculas(this);" value="http://192.168.1.59:8080/"placeholder="http://ip_pacs:puerto_pacs">
            </td>
          </tr>
        </table>
        </td>
      </tr>
    </table>
    </div>
    
    <div class="miTab" id="tabs-2">
    <table width="100%" height="100%" border="0" cellspacing="3" cellpadding="4" id="t_t_1_2">
      <tr align="left">
        <td width="1%" nowrap>* ESTADO</td>
        <td>
            <input name="estadoS" type="text" class="required mi_dir" id="estadoS" onKeyUp="conMayusculas(this);" placeholder="Entidad federativa">
        </td>
        <td width="1%" nowrap>* MUNICIPIO</td>
        <td>
            <input name="municipioS" type="text" class="required mi_dir" id="municipioS" onKeyUp="conMayusculas(this);" placeholder="Municipio">
        </td>
      </tr>
      <tr align="left">
        <td>* CIUDAD</td>
        <td>
        	<input name="ciudadS" type="text" class="required mi_dir" id="ciudadS" onKeyUp="conMayusculas(this);" placeholder="Ciudad">
        </td>
        <td>* COLONIA</td>
        <td>
        	<input name="coloniaS" type="text" class="required mi_dir" id="coloniaS" onKeyUp="conMayusculas(this);" placeholder="Colonia">
        </td>
      </tr>
      <tr align="left">
        <td nowrap>* CALLE Y NÚMERO</td>
        <td>
        	<input name="calleS" type="text" class="required mi_dir" id="calleS" onKeyUp="conMayusculas(this);" placeholder="Calle y número">
        </td>
        <td nowrap>* CÓDIGO POSTAL</td>
        <td>
        	<input name="cpS" type="text" class="required" id="cpS" onKeyUp="conMayusculas(this);" placeholder="Código postal" maxlength="5">
        </td>
      </tr>
      <tr align="center">
        <td nowrap width="50%" colspan="2">* LATITUD <span id="p_latitud"></span></td>
        <td nowrap width="50%" colspan="2">* LONGITUD <span id="p_longitud"></span></td>
      </tr>
      <tr align="center" height="90%">
        <td nowrap width="" colspan="4">
        <div id="map" style="width:100%; height:100%; border:1px solid white;"></div>
        </td>
      </tr>
    </table>
  </div>
  
  <div class="miTab" id="tabs-3">
  	<table width="100%" height="100%" border="0" cellspacing="2" cellpadding="3">
      <tr align="left"> 
      	<td nowrap align="center" colspan="3">
        	<div class="ui-state-default ui-corner-all ui-helper-clearfix">
            INDIQUE LOS HORARIOS DE ATENCIÓN NORMALES EN CADA DÍA DE LA SEMANA
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
    <p style="text-align:left">Fuera de cualquiera de estos horarios, se considerará como horarios con cargos extra (urgencia) a menos que la sucursal no atienda extrictamente más que en sus horarios establecidos.</p>
    
  </div>
  
  <div class="miTab" id="tabs-4"><input name="monedero_act" type="hidden" value="0" id="monedero_act">
  <table width="100%" height="100%" border="0" cellspacing="2" cellpadding="4">
      <tr>
        <td align="center" colspan="2">
        <div class="ui-state-default ui-corner-all ui-helper-clearfix">
        SELECCIONE LOS PORCENTAJES DE BONIFICACIÓN DE CADA DEPARTAMENTO PARA EL MONEDERO DE LA SUCURSAL</td>
        </div>
      </tr>
      <tr>
        <td width="200" nowrap align="left">CONSULTA <span id="amountMC" style="float:right" class="verMenu">0%</span></td>
        <td><div id="sliderMC"></div><input name="p_m_c" type="hidden" value="0" id="p_m_c"></td>
      </tr>
      <tr>
      	<td width="1%" nowrap align="left">IMAGENOLOGÍA <span id="amountMI" style="float:right" class="verMenu">0%</span></td>
        <td><div id="sliderMI"></div><input name="p_m_i" type="hidden" value="0" id="p_m_i"></td>
      </tr>
      <tr>
      	<td width="1%" nowrap align="left">LABORATORIO <span id="amountML" style="float:right" class="verMenu">0%</span></td>
        <td><div id="sliderML"></div><input name="p_m_l" type="hidden" value="0" id="p_m_l"></td>
      </tr>
      <tr>
      	<td width="1%" nowrap align="left">SERVICIOS <span id="amountMS" style="float:right" class="verMenu">0%</span></td>
        <td><div id="sliderMS"></div><input name="p_m_s" type="hidden" value="0" id="p_m_s"></td>
      </tr>
      <tr>
      	<td width="1%" nowrap align="left">FARMACIA <span id="amountMF" style="float:right" class="verMenu">0%</span></td>
        <td><div id="sliderMF"></div><input name="p_m_f" type="hidden" value="0" id="p_m_f"></td>
      </tr>
    </table>
  </div>
  </form>
</div>

<div id="mis_membretes">
  <table width="99%" height="100%" border="0" cellpadding="1" cellspacing="0" id="dataTableMem" class="tablilla">
    <thead id="cabecera_tBusquedaMem">
      <tr class="titulos_dataceldas">
        <th id="clickmeMem" align="center" width="1px">#</th>
        <th align="center">TIPO DE MEMBRETE</th>
        <th align="center" width="10px" nowrap>INFO</th>
     	<th align="center" nowrap width="10px">ARCHIVO</th>
      </tr>
    </thead>
    <tbody class="cuerpo_datatable"> <tr> <td class="dataTables_empty">Cargando datos del servidor</td> </tr> </tbody>
  </table>
</div>

<table width="100%" height="100%" border="0" cellpadding="1" cellspacing="1" id="dataTableFotos" class="tablilla">
<thead id="cabecera_tBusquedaFotos" class="">
  <tr style="font-size:1.25em;">
    <th id="clickmeFo"class="titulosTabs"align="center" nowrap width="1px">#</th>
    <th class="titulosTabs" align="center">
    	FOTOGRAFÍA<input id="name_foto" type="hidden" value="">
        <button style="height:22px;" name="b_subir_foto" id="b_subir_foto" class="ui-button ui-widget ui-corner-all ui-button-icon-only"><span title="Agregar una fotografía" class="ui-icon ui-icon-image"></span>B</button>
    </th>
    <th class="titulosTabs" align="center" width="10px" nowrap>
    	<span title="Ver la fotografía">VISUALIZAR</span> <input id="idS_documento" type="hidden" value="">
    </th>
    <th class="titulosTabs" align="center" width="10px" nowrap> <span title="Eliminar la fotografía">ELIMINAR</span> </th>
  </tr>
</thead> <tbody style="color:black; text-align:justify;"> <tr> <td class="dataTables_empty">Cargando datos del servidor</td> </tr> </tbody> </tfoot>
</table>

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