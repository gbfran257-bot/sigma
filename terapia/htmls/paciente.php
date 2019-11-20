<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Documento sin título</title>
<script src="../../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<link href="../../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css">
</head>

<body>

<div id="fichaPaciente" style="font-size:14px;">

<div>
  <ul id="pestanas" style="float:left;">
    <li><a class="tabs" id="tabs-1-1" href="#tabs-1" style="color:; background-color:;">PERSONALES</a></li>
    <li><a class="tabs" id="tabs-2-1" href="#tabs-2" style="color:; background-color:;">DOMICILIO</a></li>
    <li><a class="tabs" id="tabs-3-1" href="#tabs-3" style="color:; background-color:;">FISCAL</a></li>
    <li><a class="tabs" id="tabs-4-1" href="#tabs-4" style="color:; background-color:;">ESTUDIO SOCIOECONÓMICO</a></li>
  </ul>
  <table id="botonesPac" style="float:right; display:none;" height="40px" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td class="botonesSaveP"><button id="savePac" class="botonP">Guardar</button></td>
    <td class="botonesSaveP"><button id="cancelSavePac" class="botonP">Cancelar</button></td>
    <td class="botonesUpdateP"><button id="editarPac" class="botonP">Editar</button></td>
    <td class="botonesUpdateP"><button id="cancelEditPac" class="botonP">Cancelar</button></td>
    <td class="botonesUpdateP"><button id="updatePac" class="botonP">Actualizar</button></td>
  </tr>
</table>
</div>

 <form action="" method="post" name="formGenerales" id="formGenerales" target="_self">
 <input name="nombreFotoT" id="nombreFotoT" type="hidden" value=""> <input name="hayFoto" id="hayFoto" type="hidden" value="0">
 <input name="idPacienteN" type="hidden" id="idPacienteN">  <input name="idUsuarioP" id="idUsuarioP" class="idUsuarioP" type="hidden" value="">
  <div class="miTab" id="tabs-1">
    <table class="t_uno" width="100%" height="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="">
      <tr>
        <td>
        <table width="100%" border="0" cellspacing="0" cellpadding="4">
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
        <td style="border:1px none red;" width="25%" rowspan="5">

        <table width="100%" height="100%" border="0" cellspacing="2" cellpadding="2">
          <tr height="40px">
            <td><button id="upload">Agregar fotografía</button></td>
          </tr>
          <tr valign="top">
            <td style="border:1px none gold;" id="miFotito"><ul id="gallery" style="border:1px none red; text-align:center;"> <!-- Cargar Fotos --> </ul></td>
          </tr>
          <!--<tr height="40px"> <td>&nbsp;</td> </tr>-->
        </table>
        
        </td>
      </tr>
      <tr>
        <td>
        <table width="100%" border="0" cellspacing="0" cellpadding="4">
          <!--<tr align="left">
          	<td class="titulosTabs" width="120px" nowrap>Fecha nacimiento *</td>
            <td class="titulosTabs" width="90px" nowrap>Edad(años)</td>
            <td class="titulosTabs" width="140px" nowrap>Sexo *</td>
            <td class="titulosTabs" nowrap>Nacionalidad *</td>
          </tr> -->
          <tr>
          	<td width="190px"><input name="fnacP" id="fnacP" type="text" placeholder="Fecha de nacimiento D/M/A" class="required"></td>
            <td><input name="edadP" id="edadP" type="text" onKeyUp="conMayusculas(this); solo_numeros(this.value, this.name);" readonly class="" placeholder="Edad"></td>
            <td><select name="sexoP" id="sexoP" class="required"></select></td>
            <td><input name="nacionalidadP" id="nacionalidadP" type="text" value="MEXICANO" onKeyUp="conMayusculas(this); solo_letras(this.value, this.name);" class="required" placeholder="Nacionalidad"></td>
          </tr>
        </table>
        </td>
        <!--<td></td> -->
      </tr>
      <tr>
        <td>
        <table width="100%" border="0" cellspacing="2" cellpadding="2">
          <!--<tr align="left">
          	<td class="titulosTabs">Entidad de nacimiento *</td>
            <td class="titulosTabs" width="33.3%">CURP</td>
            <td class="titulosTabs" width="17%" align="center">RFC</td>
          </tr> -->
          <tr>
          	<td><select name="entidadNacimientoP" id="entidadNacimientoP" class="required"></select></td>
            <td width="33.3%">
            <span id="sprytextfield4">
            <input name="curpP" type="text" class="" id="curpP" onKeyUp="conMayusculas(this); solo_letras_numeros(this.value, this.name);" size="18" maxlength="18" placeholder="C U R P">
            <span class="textfieldRequiredMsg">Se necesita un valor.</span><span class="textfieldMinCharsMsg">No se cumple el mínimo de caracteres requerido.</span><span class="textfieldMaxCharsMsg">Se ha superado el número máximo de caracteres.</span></span>
            </td>
            <td width="115px" width="17%"><input name="rfcP" type="text" id="rfcP" onKeyUp="conMayusculas(this); solo_letras_numeros(this.value, this.name);" maxlength="13" placeholder="R F C"></td>
          </tr>
        </table>
        </td>
        <!--<td></td> -->
      </tr>
      <tr>
        <td>
        <table width="100%" border="0" cellspacing="0" cellpadding="4">
          <!--<tr align="left">
            <td class="titulosTabs" width="1%" nowrap>Teléfono personal</td>
            <td class="titulosTabs" width="" nowrap>Sucursal *</td>
            <td class="titulosTabs rnacido" width="17%" align="center">Hora de nacido</td>
          </tr> -->
          <tr>
            <td width="160">
            <span id="sprytextfield1">
            <input name="telmovilP" id="telmovilP" type="text" maxlength="15" placeholder="Teléfono personal">
            <span class="textfieldInvalidFormatMsg">Formato no válido.</span></span>
            </td>
            <td><select name="sucursalP" id="sucursalP" class="required"></select></td>
            <td class="rnacido"><input id="spinner1" name="spinner1" value="0:00 AM" readonly disabled></td>
            <td width="140"><select name="tSangreP" id="tSangreP" class=""></select></td>
          </tr>
        </table>
        </td>
        <!--<td></td> -->
      </tr>
    </table>
  </div>
  
  <div class="miTab" id="tabs-2">
  	<table class="t_uno" width="100%" height="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="">
      <tr align="left">
        <td>
        <table width="100%" height="100%" border="0" cellspacing="2" cellpadding="2">
          <tr>
            <!--<td class="titulosTabs" width="80px" nowrap>Estado</td> -->
            <td> <select name="estadoP" id="estadoP" class=""></select> </td>
          </tr>
        </table>
        </td>
      </tr>
      <tr align="left">
        <td>
        <table width="100%" height="100%" border="0" cellspacing="2" cellpadding="2">
          <tr>
            <td colspan="2">
            	<table width="100%" border="0" cellspacing="0" cellpadding="2">
                  <tr>
                    <!--<td class="titulosTabs" width="80px" nowrap>Municipio</td> -->
                    <td> <select name="municipioP" id="municipioP" class=""></select> </td>
                  </tr>
                </table>
            </td> 
          </tr>
        </table>
        </td>
      </tr>
      <tr align="left">
        <td>
        <table width="100%" height="100%" border="0" cellspacing="2" cellpadding="2">
          <tr>
            <td>
            	<table width="100%" border="0" cellspacing="0" cellpadding="2">
                  <tr>
                    <!--<td class="titulosTabs" width="80px" nowrap>Colonia</td> -->
                    <td> <select name="coloniaP" id="coloniaP"></select> </td>
                    <!--<td class="titulosTabs" width="1%" nowrap>C.P.</td> -->
                    <td width="75px"> <select name="cpP" id="cpP"></select> </td>
                  </tr>
                </table>
            </td>
          </tr>
        </table>
        </td>
      </tr>
      <tr align="left">
        <td>
        <table width="100%" height="100%" border="0" cellspacing="2" cellpadding="2">
          <tr>
            <!--<td class="titulosTabs" width="80px" nowrap>Calle</td> -->
            <td> <input name="calleP" id="calleP" type="text" onKeyUp="conMayusculas(this);" placeholder="Calle"> </td>
          </tr>
        </table>
        </td>
      </tr>
      <tr align="left">
        <td>
        <table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="30%">
            	<table width="100%" height="100%" border="0" cellspacing="2" cellpadding="2">
                  <tr>
                    <!--<td class="titulosTabs" width="80px" nowrap>Número ext</td> -->
                    <td>
                    <input name="noExtP" type="text" id="noExtP" onKeyUp="conMayusculas(this); solo_letras_numeros(this.value, this.name);" maxlength="6" placeholder="Número ext">
                    </td>
                  </tr>
                </table>
            </td>
            <td width="30%">
            	<table width="100%" height="100%" border="0" cellspacing="2" cellpadding="2">
                  <tr>
                    <!--<td class="titulosTabs" width="1%" nowrap>Número int</td> -->
                    <td>
                    <input name="noIntP" type="text" id="noIntP" onKeyUp="conMayusculas(this); solo_letras_numeros(this.value, this.name);" maxlength="6" placeholder="Número int">
                    </td>
                  </tr>
                </table>
            </td>
            <td>
            <table width="100%" height="100%" border="0" cellspacing="2" cellpadding="2">
              <tr>
                <!--<td class="titulosTabs" width="1%" nowrap>Teléfono particular</td> -->
                <td>
                <span id="sprytextfield2">
                <input name="telparticularP" id="telparticularP" type="text" maxlength="15" placeholder="Teléfono particular">
                <span class="textfieldInvalidFormatMsg">Formato no válido.</span></span>
                </td>
              </tr>
            </table>
            </td>
          </tr>
        </table>
        </td>
      </tr>
    </table>
  </div>
  
  <div class="miTab" id="tabs-3">
  	<table class="t_uno" width="100%" height="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="">
    	<tr align="left">
        <td>
        <table width="100%" height="100%" border="0" cellspacing="2" cellpadding="2">
          <tr>
            <!--<td class="titulosTabs" width="150px" nowrap>Nombre o razón social</td> -->
            <td width="150px"> <input name="razonPF" id="razonPF" type="text" onKeyUp="conMayusculas(this);" placeholder="Nombre o razón social"> </td>
            <!--<td class="titulosTabs" width="1%">RFC</td> -->
            <td width="115px"><input name="rfcPF" type="text" id="rfcPF" onKeyUp="conMayusculas(this); solo_letras_numeros(this.value, this.name);" maxlength="13" placeholder="R F C"></td>
          </tr>
        </table>
        </td>
      </tr>
      <tr align="left">
        <td>
        <table width="100%" height="100%" border="0" cellspacing="2" cellpadding="2">
          <tr>
            <!--<td class="titulosTabs" width="1%">Email</td> -->
            <td width="45%"> <input name="emailPF" id="emailPF" class="email" type="text" onKeyUp="conMinusculas(this);" title="Correo al que se enviarán las facturas" placeholder="Email"> </td>
            <!--<td class="titulosTabs" width="1%">Banco</td> -->
            <td><select name="bancoPF" id="bancoPF"></select></td>
            <!--<td class="titulosTabs 4d" width="90px" nowrap>4U-Dígitos</td> -->
            <td width="70px" class="4d"><input name="digitos4B" type="text" id="digitos4B" onKeyUp="solo_numeros(this.value, this.name);" maxlength="4" placeholder="4U-Dígitos"></td>
          </tr>
        </table>
        </td>
      </tr>
      <tr align="left">
        <td>
        <table width="100%" height="100%" border="0" cellspacing="2" cellpadding="2">
          <tr>
            <!--<td class="titulosTabs" width="80px" nowrap>Estado</td> -->
            <td> <select name="estadoPF" id="estadoPF" class=""></select> </td>
          </tr>
        </table>
        </td>
      </tr>
      <tr align="left">
        <td>
        <table width="100%" height="100%" border="0" cellspacing="2" cellpadding="2">
          <tr>
            <td colspan="2">
            	<table width="100%" border="0" cellspacing="0" cellpadding="2">
                  <tr>
                    <!--<td class="titulosTabs" width="80px" nowrap>Municipio</td> -->
                    <td> <select name="municipioPF" id="municipioPF" class=""></select> </td>
                  </tr>
                </table>
            </td> 
          </tr>
        </table>
        </td>
      </tr>
      <tr align="left">
        <td>
        <table width="100%" height="100%" border="0" cellspacing="2" cellpadding="2">
          <tr>
            <td>
            	<table width="100%" border="0" cellspacing="0" cellpadding="2">
                  <tr>
                    <!--<td class="titulosTabs" width="80px" nowrap>Colonia</td> -->
                    <td> <select name="coloniaPF" id="coloniaPF"></select> </td>
                    <!--<td class="titulosTabs" width="1%" nowrap>C.P.</td> -->
                    <td width="75px"> <select name="cpPF" id="cpPF"></select> </td>
                  </tr>
                </table>
            </td>
          </tr>
        </table>
        </td>
      </tr>
      <tr align="left">
        <td>
        <table width="100%" height="100%" border="0" cellspacing="2" cellpadding="2">
          <tr>
            <!--<td class="titulosTabs" width="80px" nowrap>Calle</td> -->
            <td> <input name="callePF" id="callePF" type="text" onKeyUp="conMayusculas(this);" placeholder="Calle"> </td>
          </tr>
        </table>
        </td>
      </tr>
      <tr align="left">
        <td>
        <table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="25%">
            	<table width="100%" height="100%" border="0" cellspacing="2" cellpadding="2">
                  <tr>
                    <!--<td class="titulosTabs" width="80px" nowrap>Número ext</td> -->
                    <td>
                    <input name="noExtPF" type="text" id="noExtPF" onKeyUp="conMayusculas(this); solo_letras_numeros(this.value, this.name);" maxlength="6" placeholder="Número ext">
                    </td>
                  </tr>
                </table>
            </td>
            <td width="25%">
            	<table width="100%" height="100%" border="0" cellspacing="2" cellpadding="2">
                  <tr>
                    <!--<td class="titulosTabs" width="1%" nowrap>Número int</td> -->
                    <td>
                    <input name="noIntPF" type="text" id="noIntPF" onKeyUp="conMayusculas(this); solo_letras_numeros(this.value, this.name);" maxlength="6" placeholder="Número int">
                    </td>
                  </tr>
                </table>
            </td>
            <td>
            <table width="100%" height="100%" border="0" cellspacing="2" cellpadding="2">
              <tr>
                <!--<td class="titulosTabs" width="25%" nowrap>Teléfono de trabajo</td> -->
                <td>
            <span id="sprytextfield3">
            <input name="telefonoTrabajoP"type="text"id="telefonoTrabajoP" maxlength="15" placeholder="Teléfono de trabajo">
            <span class="textfieldInvalidFormatMsg">Formato no válido.</span></span>
            </td>
            <!--<td class="titulosTabs">Extensión</td> -->
            <td>
            <input name="extensionTelTraP"type="text" id="extensionTelTraP" onKeyUp="telefono(this.value, this.name);" maxlength="5" placeholder="Extensión">
            </td>
              </tr>
            </table>
            </td>
          </tr>
        </table>
        </td>
      </tr>
    </table>
  </div>

<div class="miTab" id="tabs-4" style="overflow:; border:1px none red;">

<div id="miTabsH" style="float:left; display:block; border:1px none red; width:100%; height:100%;">
<table width="100%" border="0" cellspacing="0" cellpadding="2" bgcolor="">
  <tr>
    <td id="">
    <ul id="pestanas1" style="float:left;">
        <li><a class="tabs" id="tabs-1-1h" href="#tabs-1h" style="color:; background-color:;">INGRESOS</a></li>
        <li><a class="tabs" id="tabs-2-1h" href="#tabs-2h" style="color:; background-color:;">EGRESOS</a></li>
        <li><a class="tabs" id="tabs-3-1h" href="#tabs-3h" style="color:; background-color:;">VIVIENDA</a></li>
        <li><a class="tabs" id="tabs-4-1h" href="#tabs-4h" style="color:; background-color:;">SALUD</a></li>
        <li><a class="tabs" id="tabs-5-1h" href="#tabs-5h" style="color:; background-color:;">ALIMENTACIÓN</a></li>
        <li><a class="tabs" id="tabs-6-1h" href="#tabs-6h" style="color:; background-color:;">RECREACIÓN</a></li>
        <li><a class="tabs" id="tabs-7-1h" href="#tabs-7h" style="color:; background-color:;">DX SOCIAL</a></li>
    </ul>
    </td>
  </tr>
</table>

<div class="miTab" id="tabs-1h">
<table width="100%" border="0" cellspacing="0" cellpadding="2" style="background-color:#CCC;" class="tablaTS">
  <tr>
    <td colspan="2" align="center">INDIQUE LOS INGRESOS MENSUALES</td>
  </tr>
  <tr align="center">
    <td>Concepto</td>
    <td nowrap>Monto $</td>
  </tr>
  <tr>
    <td align="center"><input class="concepto" name="conceptoI1" type="text" id="conceptoI1"></td>
    <td align="center"><input class="ingreso" name="ingreso1" type="text" id="ingreso1"></td>
  </tr>
  <tr>
    <td align="center"><input class="concepto" name="conceptoI2" type="text" id="conceptoI2"></td>
    <td align="center"><input class="ingreso" name="ingreso2" type="text" id="ingreso2"></td>
  </tr>
  <tr>
    <td align="center"><input class="concepto" name="conceptoI3" type="text" id="conceptoI3"></td>
    <td align="center"><input class="ingreso" name="ingreso3" type="text" id="ingreso3"></td>
  </tr>
  <tr>
    <td align="center"><input class="concepto" name="conceptoI4" type="text" id="conceptoI4"></td>
    <td align="center"><input class="ingreso" name="ingreso4" type="text" id="ingreso4"></td>
  </tr>
  <tr>
    <td align="center"><input class="concepto" name="conceptoI4" type="text" id="conceptoI4"></td>
    <td align="center"><input class="ingreso" name="ingreso5" type="text" id="ingreso5"></td>
  </tr>
  <tr>
    <td align="right">Total de ingreso mensual</td>
    <td align="left"><span id="totalIngresos">$0.00</span></td>
  </tr>
</table>
</div>

<div class="miTab" id="tabs-2h">
<table width="100%" border="0" cellspacing="0" cellpadding="2" style="background-color:#CCC;" class="tablaTS">
  <tr>
    <td colspan="4" align="center">INDIQUE LOS EGRESOS MENSUALES</td>
  </tr>
  <tr align="center">
    <td width="25%">Concepto</td>
    <td width="25%">Monto $</td>
    <td width="25%">Concepto</td>
    <td width="25%">Monto $</td>
  </tr>
  <tr>
    <td align="left">Alimentación</td>
    <td align="center"><input class="egreso" name="egreso1" type="text" id="egreso1"></td>
    <td align="left">Transporte</td>
    <td align="center"><input class="egreso" name="egreso2" type="text" id="egreso2"></td>
  </tr>
  <tr>
    <td align="left">Gas O Combustible</td>
    <td align="center"><input class="egreso" name="egreso3" type="text" id="egreso3"></td>
    <td align="left">Educación</td>
    <td align="center"><input class="egreso" name="egreso4" type="text" id="egreso4"></td>
  </tr>
  <tr>
    <td align="left">Renta</td>
    <td align="center"><input class="egreso" name="egreso5" type="text" id="egreso5"></td>
    <td align="left">Gastos médicos</td>
    <td align="center"><input class="egreso" name="egreso6" type="text" id="egreso6"></td>
  </tr>
  <tr>
    <td align="left">Agua</td>
    <td align="center"><input class="egreso" name="egreso7" type="text" id="egreso7"></td>
    <td align="left">Recreación</td>
    <td align="center"><input class="egreso" name="egreso8" type="text" id="egreso8"></td>
  </tr>
  <tr>
    <td align="left">Predial</td>
    <td align="center"><input class="egreso" name="egreso9" type="text" id="egreso9"></td>
    <td align="left">Abonos o créditos</td>
    <td align="center"><input class="egreso" name="egreso10" type="text" id="egreso10"></td>
  </tr>
  <tr>
    <td align="left">Electricidad (Luz)</td>
    <td align="center"><input class="egreso" name="egreso11" type="text" id="egreso11"></td>
    <td align="left">Ropa y calzado</td>
    <td align="center"><input class="egreso" name="egreso12" type="text" id="egreso12"></td>
  </tr>
  <tr>
    <td align="left">Teléfono</td>
    <td align="center"><input class="egreso" name="egreso13" type="text" id="egreso13"></td>
    <td align="left">Fondos de ahorro,tandas ,prestamos</td>
    <td align="center"><input class="egreso" name="egreso14" type="text" id="egreso14"></td>
  </tr>
  <tr>
    <td align="left">Teléfono celular</td>
    <td align="center"><input class="egreso" name="egreso15" type="text" id="egreso15"></td>
    <td align="left">Crédito para construcciónde vivienda</td>
    <td align="center"><input class="egreso" name="egreso16" type="text" id="egreso16"></td>
  </tr>
  <tr>
    <td align="right" colspan="4">
    	<table width="100%" border="0" cellspacing="0" cellpadding="2">
          <tr>
            <td align="right">Total egresos</td>
            <td align="left"><span id="totalEgresos">$0.00</span></td>
            <td align="right">Superávit</td>
            <td align="left"><span id="superavit">$0.00</span></td>
            <td align="right">Déficit</td>
            <td align="left"><span id="deficit">$0.00</span></td>
          </tr>
        </table>
    </td>
  </tr>
</table>
</div>

<div class="miTab" id="tabs-3h">
<table width="100%" border="0" cellspacing="0" cellpadding="2" style="background-color:#CCC;" class="tablaTS">
  <tr>
    <td align="left" width="1%" nowrap>Tenencia de la vivienda</td>
    <td align="center">
    	<select name="tenenciaVivienda" id="tenenciaVivienda">
    	  <option value="">-SELECCIONAR-</option>
    	  <option value="Propia">Propia</option>
    	  <option value="Rentada">Rentada</option>
    	  <option value="Prestada">Prestada</option>
    	  <option value="Invadida">Invadida</option>
    	</select>
    </td>
    <td align="left" width="1%" nowrap>Tipo de vivienda</td>
    <td align="center">
    	<select name="tipoVivienda" id="tipoVivienda">
    	  <option value="">-SELECCIONAR-</option>
    	  <option value="Casa sola">Casa sola</option>
    	  <option value="Vecindad">Vecindad</option>
    	  <option value="Campamento">Campamento</option>
    	  <option value="Albergue">Albergue</option>
          <option value="Accesoria">Accesoria</option>
    	</select>
    </td>
  </tr>
  <tr>
    <td align="left" width="1%" nowrap>Número de dormitorios</td>
    <td align="center"><input class="vivienda" class="required" name="noDormitorios" type="text" id="noDormitorios"></td>
    <td align="left" width="1%" nowrap>Índice de hacinamiento</td>
    <td align="center"><input class="vivienda" class="vivienda" name="hacinamiento" type="text" id="hacinamiento"></td>
  </tr>
  <tr>
    <td align="left" colspan="4">
    	<table width="100%" border="0" cellspacing="0" cellpadding="2">
          <tr>
            <td nowrap valign="middle" width="20%">
            	<label for="vSala">Sala</label><input name="vSala" id="vSala" type="checkbox" value="">
            </td>
            <td nowrap valign="middle" width="20%">
            	<label for="vComedor">Comedor</label><input name="vComedor" id="vComedor" type="checkbox" value="">
            </td>
            <td nowrap valign="middle" width="20%">
            	<label for="vCocina">Cocina</label><input name="vCocina" id="vCocina" type="checkbox"value="">
            </td>
            <td nowrap valign="middle" width="20%">
            	<label for="vBanoPrivado">Baño privado</label><input name="vBanoPrivado" id="vBanoPrivado" type="checkbox"value="">
            </td>
            <td nowrap valign="middle" width="20%">
            <label for="vBanoColectivo">Baño colectivo</label><input name="vBanoColectivo"id="vBanoColectivo"type="checkbox"value="">
            </td>
          </tr>
        </table>
    </td>
  </tr>
  <tr>
    <td align="center" colspan="4">Materia predominante en la construcción de la vivienda</td>
  </tr>
  <tr>
  	<td align="" colspan="4">
    	<table border="0" width="100%" cellpadding="2" cellspacing="0">
        <tr>
        	<td align="left" width="1%">Paredes</td>
            <td align="center">
                <select name="mParedes" id="mParedes" class="required">
                  <option value="">-SELECCIONAR-</option>
                  <option value="Tabique">Tabique</option>
                  <option value="Madera">Madera</option>
                  <option value="Carton">Carton</option>
                </select>
            </td>
            <td align="left" width="1%">Techos</td>
            <td align="center">
                <select name="mTechos" id="mTechos" class="required">
                  <option value="">-SELECCIONAR-</option>
                  <option value="Concreto">Concreto</option>
                  <option value="Lámina de asbesto">Lámina de asbesto</option>
                  <option value="Lámina de cartón">Lámina de cartón</option>
                  <option value="Lámina metálica">Lámina metálica</option>
                </select>
            </td>
            <td align="left" width="1%">Pisos</td>
            <td align="center">
                <select name="mPisos" id="mPisos" class="required">
                  <option value="">-SELECCIONAR-</option>
                  <option value="Mosaicos">Mosaicos</option>
                  <option value="Loseta">Loseta</option>
                  <option value="Cemento">Cemento</option>
                  <option value="Tierra apisonada">Tierra apisonada</option>
                  <option value="Madera">Madera</option>
                </select>
            </td>   
          </tr>
        </table>
    </td>
  </tr>
  <tr>
    <td align="left" colspan="4">Mobiliario</td>
  </tr>
  <tr>
    <td align="left" colspan="4">
    	<table width="100%" border="0" cellspacing="0" cellpadding="2">
          <tr>
            <td nowrap valign="middle" width="20%">
            	<label for="vTelevisión">Televisión</label><input name="vTelevisión" id="vTelevisión" type="checkbox" value="">
            </td>
            <td nowrap valign="middle" width="20%">
            	<label for="vEstéreo">Estéreo</label><input name="vEstéreo" id="vEstéreo" type="checkbox" value="">
            </td>
            <td nowrap valign="middle" width="20%">
            	<label for="vVideo">Video</label><input name="vVideo" id="vVideo" type="checkbox"value="">
            </td>
            <td nowrap valign="middle" width="20%">
            	<label for="vDVD">DVD</label><input name="vDVD" id="vDVD" type="checkbox"value="">
            </td>
            <td nowrap valign="middle" width="20%">
            	<label for="vEstufa">Estufa</label><input name="vEstufa"id="vEstufa"type="checkbox"value="">
            </td>
            <td nowrap valign="middle" width="20%">
            	<label for="vHorno">Horno de microondas</label><input name="vHorno"id="vHorno"type="checkbox"value="">
            </td>
          </tr>
        </table>
    </td>
  </tr>
  <tr>
    <td align="left" colspan="4">
    	<table width="100%" border="0" cellspacing="0" cellpadding="2">
          <tr>
            <td nowrap valign="middle" width="20%">
            	<label for="vLavadora">Lavadora</label><input name="vLavadora" id="vLavadora" type="checkbox" value="">
            </td>
            <td nowrap valign="middle" width="20%">
            	<label for="vCentroLav">Centro de lavado</label><input name="vCentroLav" id="vCentroLav" type="checkbox" value="">
            </td>
            <td nowrap valign="middle" width="20%">
            	<label for="vRefri">Refrigerador</label><input name="vRefri"id="vRefri"type="checkbox"value="">
            </td>
            <td nowrap valign="middle" width="20%">
            	<label for="vComputadora">Computadora</label><input name="vComputadora" id="vComputadora" type="checkbox"value="">
            </td>
          </tr>
        </table>
    </td>
  </tr>
</table>
</div>

<div class="miTab" id="tabs-4h">
<table width="100%" border="0" cellspacing="0" cellpadding="2" style="background-color:#CCC;" class="tablaTS">
  <tr>
    <td align="center">Servicios médicos con los que cuenta</td>
  </tr>
  <tr>
    <td>
    	<table width="100%" border="0" cellspacing="0" cellpadding="2">
          <tr>
            <td nowrap valign="middle" width="20%">
            	<label for="sIMSS">IMSS</label><input name="sIMSS" id="sIMSS" type="checkbox" value="">
            </td>
            <td nowrap valign="middle" width="20%">
            	<label for="sISSSTE">ISSSTE</label><input name="sISSSTE" id="sISSSTE" type="checkbox" value="">
            </td>
            <td nowrap valign="middle" width="20%">
            	<label for="sCentroS">Centro de salud</label><input name="sCentroS"id="sCentroS"type="checkbox"value="">
            </td>
            <td nowrap valign="middle" width="20%">
            	<label for="sDispensario">Dispensario</label><input name="sDispensario" id="sDispensario" type="checkbox"value="">
            </td>
            <td nowrap valign="middle" width="20%">
            	<label for="sMedicoP">Médico Privado</label><input name="sMedicoP" id="sMedicoP" type="checkbox"value="">
            </td>
          </tr>
        </table>
    </td>
  </tr>
  <tr>
    <td align="center">Frecuencia con la que asiste el usuario al médico</td>
  </tr>
  <tr>
    <td>
    	<table width="100%" border="0" cellspacing="0" cellpadding="2">
          <tr>
            <td nowrap valign="middle" width="25%">
            	<label for="s1vm">Una vez por semana</label><input name="s1vm" id="s1vm" type="checkbox" value="">
            </td>
            <td nowrap valign="middle" width="25%">
            	<label for="sMensual">Mensualmente</label><input name="sMensual" id="sMensual" type="checkbox" value="">
            </td>
            <td nowrap valign="middle" width="25%">
            	<label for="sAnualmente">Anualmente</label><input name="sAnualmente"id="sAnualmente"type="checkbox"value="">
            </td>
            <td nowrap valign="middle" width="25%">
            	<label for="sCuandoE">Cuando se enferma</label><input name="sCuandoE" id="sCuandoE" type="checkbox"value="">
            </td>
          </tr>
        </table>
    </td>
  </tr>
  <tr>
    <td align="left">Notas:</td>
  </tr>
  <tr>
    <td>
    	<textarea name="notasSalud" id="notasSalud" cols="" rows="" style="resize:none;"></textarea>
    </td>
  </tr>
</table>
</div>

<div class="miTab" id="tabs-5h">
<table width="100%" border="0" cellspacing="0" cellpadding="2" style="background-color:#CCC;" class="tablaTS">
  <tr>
    <td width="200px" nowrap>Tipo dealimento</td>
    <td colspan="5">Frecuencia con que lo consume</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="left">Diario</td>
    <td align="left">Cada tercer día</td>
    <td align="left">Una vez a lasemana</td>
    <td align="left">Una vezal mes</td>
    <td align="left">Ocasionalmente</td>
  </tr>
  <tr>
    <td align="left">Carne de res</td>
    <td align="center"><input name="aRes" id="aRes" type="checkbox" value=""></td>
    <td align="center"><input name="aRes1" id="aRes1" type="checkbox" value=""></td>
    <td align="center"><input name="aRes2" id="aRes2" type="checkbox" value=""></td>
    <td align="center"><input name="aRes3" id="aRes3" type="checkbox" value=""></td>
    <td align="center"><input name="aRes4" id="aRes4" type="checkbox" value=""></td>
  </tr>
  <tr>
    <td align="left">Carne de pollo</td>
    <td align="center"><input name="aPollo" id="aPollo" type="checkbox" value=""></td>
    <td align="center"><input name="aPollo1" id="aPollo1" type="checkbox" value=""></td>
    <td align="center"><input name="aPollo2" id="aPollo2" type="checkbox" value=""></td>
    <td align="center"><input name="aPollo3" id="aPollo3" type="checkbox" value=""></td>
    <td align="center"><input name="aPollo4" id="aPollo4" type="checkbox" value=""></td>
  </tr>
  <tr>
    <td align="left">Carne de cerdo</td>
    <td align="center"><input name="aPollo" id="aPollo" type="checkbox" value=""></td>
    <td align="center"><input name="aPollo1" id="aPollo1" type="checkbox" value=""></td>
    <td align="center"><input name="aPollo2" id="aPollo2" type="checkbox" value=""></td>
    <td align="center"><input name="aPollo3" id="aPollo3" type="checkbox" value=""></td>
    <td align="center"><input name="aPollo4" id="aPollo4" type="checkbox" value=""></td>
  </tr>
  <tr>
    <td align="left">Carne depescado</td>
    <td align="center"><input name="aPollo" id="aPollo" type="checkbox" value=""></td>
    <td align="center"><input name="aPollo1" id="aPollo1" type="checkbox" value=""></td>
    <td align="center"><input name="aPollo2" id="aPollo2" type="checkbox" value=""></td>
    <td align="center"><input name="aPollo3" id="aPollo3" type="checkbox" value=""></td>
    <td align="center"><input name="aPollo4" id="aPollo4" type="checkbox" value=""></td>
  </tr>
  <tr>
    <td align="left">Leche</td>
    <td align="center"><input name="aPollo" id="aPollo" type="checkbox" value=""></td>
    <td align="center"><input name="aPollo1" id="aPollo1" type="checkbox" value=""></td>
    <td align="center"><input name="aPollo2" id="aPollo2" type="checkbox" value=""></td>
    <td align="center"><input name="aPollo3" id="aPollo3" type="checkbox" value=""></td>
    <td align="center"><input name="aPollo4" id="aPollo4" type="checkbox" value=""></td>
  </tr>
  <tr>
    <td align="left">Cereales</td>
    <td align="center"><input name="aPollo" id="aPollo" type="checkbox" value=""></td>
    <td align="center"><input name="aPollo1" id="aPollo1" type="checkbox" value=""></td>
    <td align="center"><input name="aPollo2" id="aPollo2" type="checkbox" value=""></td>
    <td align="center"><input name="aPollo3" id="aPollo3" type="checkbox" value=""></td>
    <td align="center"><input name="aPollo4" id="aPollo4" type="checkbox" value=""></td>
  </tr>
  <tr>
    <td align="left">Huevo</td>
    <td align="center"><input name="aPollo" id="aPollo" type="checkbox" value=""></td>
    <td align="center"><input name="aPollo1" id="aPollo1" type="checkbox" value=""></td>
    <td align="center"><input name="aPollo2" id="aPollo2" type="checkbox" value=""></td>
    <td align="center"><input name="aPollo3" id="aPollo3" type="checkbox" value=""></td>
    <td align="center"><input name="aPollo4" id="aPollo4" type="checkbox" value=""></td>
  </tr>
  <tr>
    <td align="left">Frutas</td>
    <td align="center"><input name="aPollo" id="aPollo" type="checkbox" value=""></td>
    <td align="center"><input name="aPollo1" id="aPollo1" type="checkbox" value=""></td>
    <td align="center"><input name="aPollo2" id="aPollo2" type="checkbox" value=""></td>
    <td align="center"><input name="aPollo3" id="aPollo3" type="checkbox" value=""></td>
    <td align="center"><input name="aPollo4" id="aPollo4" type="checkbox" value=""></td>
  </tr>
  <tr>
    <td align="left">Verduras</td>
    <td align="center"><input name="aPollo" id="aPollo" type="checkbox" value=""></td>
    <td align="center"><input name="aPollo1" id="aPollo1" type="checkbox" value=""></td>
    <td align="center"><input name="aPollo2" id="aPollo2" type="checkbox" value=""></td>
    <td align="center"><input name="aPollo3" id="aPollo3" type="checkbox" value=""></td>
    <td align="center"><input name="aPollo4" id="aPollo4" type="checkbox" value=""></td>
  </tr>
  <tr>
    <td align="left">Leguminosas</td>
    <td align="center"><input name="aPollo" id="aPollo" type="checkbox" value=""></td>
    <td align="center"><input name="aPollo1" id="aPollo1" type="checkbox" value=""></td>
    <td align="center"><input name="aPollo2" id="aPollo2" type="checkbox" value=""></td>
    <td align="center"><input name="aPollo3" id="aPollo3" type="checkbox" value=""></td>
    <td align="center"><input name="aPollo4" id="aPollo4" type="checkbox" value=""></td>
  </tr>
</table>
</div>

<div class="miTab" id="tabs-6h">
<table width="100%" border="0" cellspacing="0" cellpadding="2" style="background-color:#CCC;" class="tablaTS">
  <tr>
    <td align="center">Actividades familiares el fin de semana</td>
  </tr>
  <tr>
    <td>
    <table width="100%" border="0" cellspacing="0" cellpadding="2">
          <tr>
            <td nowrap valign="middle" width="20%">
            	<label for="rPracticarD">Practicar deporte</label><input name="rPracticarD"id="rPracticarD"type="checkbox"value="">
            </td>
            <td nowrap valign="middle" width="20%">
            	<label for="rIrCine">Ir al cine</label><input name="rIrCine" id="rIrCine" type="checkbox" value="">
            </td>
            <td nowrap valign="middle" width="20%">
            	<label for="rVisitarF">Visitar familiares</label><input name="rVisitarF"id="rVisitarF"type="checkbox"value="">
            </td>
            <td nowrap valign="middle" width="20%">
            	<label for="rQuehacer">Realizar quehaceres del hogar</label><input name="rQuehacer" id="rQuehacer" type="checkbox"value="">
            </td>
            <td nowrap valign="middle" width="20%">
            	<label for="rActAire_ibre">Actividades al aire libre</label><input name="rActAire_ibre" id="rActAire_ibre" type="checkbox"value="">
            </td>
          </tr>
        </table>
    </td>
  </tr>
  <tr>
    <td align="center">Actividades del paciente</td>
  </tr>
  <tr>
    <td>
    	<table width="100%" border="0" cellspacing="0" cellpadding="2">
          <tr>
            <td nowrap valign="middle" width="20%">
            	<label for="rEstudia">Estudia</label><input name="rEstudia"id="rEstudia"type="checkbox"value="">
            </td>
            <td nowrap valign="middle" width="20%">
            	<label for="rRealizaD">Realiza deporte</label><input name="rRealizaD" id="rRealizaD" type="checkbox" value="">
            </td>
            <td nowrap valign="middle" width="20%">
            	<label for="rVeTV">Ve televisión</label><input name="rVeTV"id="rVeTV"type="checkbox"value="">
            </td>
            <td nowrap valign="middle" width="20%">
            	<label for="rHaceTareas">Hace sus tareas</label><input name="rHaceTareas" id="rHaceTareas" type="checkbox"value="">
            </td>
            <td nowrap valign="middle" width="20%">
            	<label for="rquehacerHogar">Realiza los quehaceres del hogar</label><input name="rquehacerHogar" id="rquehacerHogar" type="checkbox"value="">
            </td>
          </tr>
        </table>
    </td>
  </tr>
  <tr>
    <td>
    	<table width="100%" border="0" cellspacing="0" cellpadding="2">
          <tr>
            <td nowrap valign="middle" width="25%">
            	<label for="rVideojuegos">Videojuegos</label><input name="rVideojuegos"id="rVideojuegos"type="checkbox"value="">
            </td>
            <td nowrap valign="middle" width="25%">
            	<label for="rRealizaD">Juega con amigos</label><input name="rRealizaD" id="rRealizaD" type="checkbox" value="">
            </td>
            <td nowrap valign="middle" width="25%">
            	<label for="rVeTV">Juega con hermano o familiares</label><input name="rVeTV"id="rVeTV"type="checkbox"value="">
            </td>
            <td nowrap valign="middle" width="25%">
            	<label for="rHaceTareas">Trabaja</label><input name="rHaceTareas" id="rHaceTareas" type="checkbox"value="">
            </td>
          </tr>
        </table>
    </td>
  </tr>
</table>
</div>

<div class="miTab" id="tabs-7h">
<table width="100%" border="0" cellspacing="0" cellpadding="2" style="background-color:#CCC;" class="tablaTS">
  <tr>
    <td>DIAGNOSTICO SOCIAL</td>
  </tr>
  <tr>
    <td valign="top"><textarea name="dxSocial" id="dxSocial" cols="" rows="4" style="resize:none; height:100px;"></textarea></td>
  </tr>
  <tr>
    <td>OBSERVACIONES</td>
  </tr>
  <tr>
    <td valign="top"><textarea name="dxObservaciones" id="dxObservaciones" cols="" rows="4" style="resize:none; height:100px;"></textarea></td>
  </tr>
  <tr>
    <td>NIVEL SOCIOECONÓMICO</td>
  </tr>
  <tr>
    <td>
    	<select name="dxNS" id="dxNS" class="required">
          <option value="">-SELECCIONAR-</option>
          <option value="A">Nivel A</option>
          <option value="B">Nivel B</option>
          <option value="C">Nivel C</option>
          <option value="D">Nivel D</option>
          <option value="E">Nivel E</option>
        </select>
    </td>
  </tr>
</table>
</div>

</div>
</div>
  
</form>

</div>

<div id="conveniosP">
<table width="100%" cellspacing="0" id="dataTableC1" height="100%" border="0" cellpadding="5" class="tablilla">
<thead>
  <tr style="color:; background-color:; font-size:0.9em;" bgcolor="#FF6633">
    <th class="titulosTabs" align="center" id="miClick1" style="color:white;">BENEFICIO</th>
    <th class="titulosTabs" align="center" style="color:white;" nowrap>FECHA EXPEDICIÓN</th>
    <th class="titulosTabs" align="center" style="color:white;" nowrap>FECHA EXPIRACIÓN</th>
    <th class="titulosTabs" align="center" style="color:white;">ESTATUS</th>
    <th class="titulosTabs" align="center" style="color:white;" nowrap>DÍAS(-)</th>
  </tr>
</thead>
<tbody align="left" bgcolor="#FF6600">
    <tr>
        <td class="dataTables_empty">Cargando datos del servidor</td>
    </tr>
</tbody>
</table>
</div>

<div id="detallesConvenioP">
<table width="100%" cellspacing="0" id="dataTableDCP" height="100%" border="0" cellpadding="4" class="tablilla">
<thead>
  <tr style="color:; background-color:; font-size:1em;" bgcolor="#FF6633">
    <th class="titulosTabs" align="center" id="miClickDCP" style="color:white;">#</th>
    <th class="titulosTabs" align="center" style="color:white;">CONCEPTO</th>
    <th class="titulosTabs" align="center" style="color:white;">TIPO</th>
    <th class="titulosTabs" align="center" style="color:white;">DISPONIBILIDAD</th>
  </tr>
</thead>
<tbody align="left" bgcolor="#FF6600">
    <tr>
        <td class="dataTables_empty">Cargando datos del servidor</td>
    </tr>
</tbody>
</table>
</div>

<script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "phone_number", {validateOn:["blur"], isRequired:false, useCharacterMasking:true});
var sprytextfield4 = new Spry.Widget.ValidationTextField("sprytextfield4", "none", {validateOn:["blur", "change"], minChars:18, maxChars:18});
</script>
</body>
</html>
