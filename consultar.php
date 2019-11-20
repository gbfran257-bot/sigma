<?php require_once('Connections/horizonte.php'); ?>

<!doctype html>
<html>
<head>
<link rel="shortcut icon" href="imagenes/favicon.ico1">
<meta charset="utf-8">
<title>CONSULTAR ESTUDIO. HORIZONTE</title>

<link href="css/plantilla.css" rel="stylesheet" type="text/css">
<link href="css/index.css" rel="stylesheet" type="text/css">
<link href="jquery-ui-1.11.3/jquery-ui.css" rel="stylesheet">
<link href="jquery-ui-1.11.3/jquery-ui.structure.css" rel="stylesheet">
<link href="jquery-ui-1.11.3/jquery-ui.theme.css" rel="stylesheet">
<script src="jquery-ui-1.11.3/external/jquery/jquery.js"></script>
<script src="jquery-ui-1.11.3/jquery-ui.js"></script>
<script src="jquery-validation-1.9.0/jquery.validate.js"></script>
<script src="funciones/js/caracteres.js"></script>
<script src="funciones/js/jquery.media.js"></script>

<script>
//para las tooltips
$(document).tooltip({ position: { my: "center bottom-20",	at: "center top", using: function( position, feedback ) { $( this ).css( position ); $( "<div>" ).addClass( "arrow" ).addClass( feedback.vertical ).addClass( feedback.horizontal ).appendTo( this ); } } });
$(document).ready(function() { //$('#usuario').focus();
	
	$('#form1').validate({ focusCleanup: true,//onfocusout: false, onkeyup: true,
		rules:{
			curp:{ 
				required:true, minlength:18,
				"remote":{ url:'remote_files/checkCURPu.php', type: "post", data:{ curp:function(){ return $('#curp').val(); } } }
			},
			referenciaE:{ 
				required:true, minlength:12, 
				"remote":{url:'remote_files/checkReferenciaE.php',type:"post",
					data:{
						referencia:function(){ var ref = $('#referenciaE').val().split('/'); return ref[0]; },
						numero:function(){ var ref = $('#referenciaE').val().split('/'); return ref[1]; }, 
						curp:function() { return $('#curp').val(); } } 
					} 
			}
		},//fin reglas
		messages:{
			curp:{ 
				required:"Debe ingresar el CURP del paciente.", minlength:"El CURP consta de 18 dígitos.", 
				remote:'Este CURP no pertenece a ningún paciente.' 
			},//fin mensajes de user
			referenciaE:{ 
				required:"Debe ingresar la referencia del estudio.", minlength:"La referencia consta de 12 dígitos.", 
				remote:'No se reconoce la referencia.' 
			}//fin de mensajes de psw
		}//fin mensajes
	});
	
	var xh = $('#referencia').height();$('#logo').css('max-width',$('#referencia').width()*0.36);
	$('#contenido').css('height',xh);
	
	$( window ).resize(function() {
		var xh = $('#referencia').height();$('#logo').css('max-width',$('#referencia').width()*0.36);
	  	$('#contenido').css('height',xh);
		$('#tablaAcceso').css('width', $('#logo').width()*0.9);
	});
	
	$('#verEstudioL').button({ icons: { primary: "ui-icon-search" }, text: false });
	$('#verEstudioL').click(function(event) { event.preventDefault(); });
	
	$('#referenciaE').val('').prop('disabled',true);
	$('.paciente').hide(); $('.referencia').hide();
		
	$('#curp').keyup(function(e) { curpP(); });
	$('#curp').focusout(function(e) { curpP(); });
	
	$('#referenciaE').keyup(function(e) { referenciaE(); });
	$('#referenciaE').focusout(function(e) { referenciaE(); });
	
	$('#verEstudioL').click(function(e) { //alert($('#nombre_pdf_e').val());
        var x1=$('#nombre_pdf_e').val(); x='laboratorio/takeArchivos/pdf/'+$('#nombre_pdf_e').val()+'.pdf'; 
		$("#dialog-visualizador").load('htmls/miPDF.php #tablaMiPDF', function( response, status, xhr ) { if ( status == "success" ) { //alert(x);
			$('#dialog-visualizador').dialog({
				title: 'RESULTADO DEL ESTUDIO', modal: true, autoOpen: true,
				closeText: '', width: 800, height: 450, closeOnEscape: true, dialogClass: '',
			  open:function( event, ui ){$('a.media').media({width:750, height:450, src:x});}, 
			  close:function( event, ui ){ $("#dialog-visualizador").empty();}
			}); 
		} });
    });
	
});

function curpP(){ $(document).ready(function(e) {
if($('#curp').val().length == 18){ 
	if($('#curp').valid()){ 
		$('#referenciaE').prop('disabled',false).focus(); $('.paciente').show();
		var datosP = { curpPaciente : $('#curp').val() }
		$.post('remote_files/datosPacienteC.php', datosP).done(function( data ) {
			var datosC = data.split('};[');
			$('#miPaciente').text(datosC[0]);
		});
	}else{ $('#referenciaE').val('').prop('disabled',true); $('.paciente').hide(); $('#miPaciente').text(''); }
}else{ $('#referenciaE').val('').prop('disabled',true); $('.paciente').hide(); $('#miPaciente').text(''); }
}); }

function referenciaE(){ $(document).ready(function(e) {
if($('#referenciaE').val().length == 12){ 
	if($('#referenciaE').valid()){ 
		$('.referencia').show();
		var datosRef = $('#referenciaE').val().split('/');
		var refEst = datosRef[0]; var numeroEst = datosRef[1];
		var datosR = { referenciaEstudio : refEst, numeroE : numeroEst, curp : $('#curp').val() }
		$.post('remote_files/datosReferenciaC.php', datosR).done(function( data ) {
			var datosR = data.split('};[');
			$('#tipoEstudio').text(datosR[0]);
			$('#miEstudio').text(datosR[1]);
			$('#nombre_pdf_e').val(datosR[2]); 
			if(datosR[3]==3){ //laboratorio
				if(datosR[5]>=7){
					$('.verEstudioPDF').show();
					$('.noVerEstudioPDF').hide();
				}else{
					$('.verEstudioPDF').hide();
					$('.noVerEstudioPDF').show();
				}
			}else if (datosR[3]==4){//imagen
				if(datosR[5]>=5){
					$('.verEstudioPDF').show();
					$('.noVerEstudioPDF').hide();
				}else{
					$('.verEstudioPDF').hide();
					$('.noVerEstudioPDF').show();
				}
			}
		});
	}else{ $('.referencia').hide(); }
}else{ $('.referencia').hide(); }
}); }

</script>

</head>
<body>

<div id="referencia" style="display:none; position:fixed; width:100%; height:100%; border: 1px solid red; z-index:1000000000000000000000;"></div>

<div class="contenido" id="contenido" align="center">
<form style="height:100%;" name="form1" id="form1" method="POST">
<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td valign="middle">
    <table width="100%" border="0" cellspacing="0" cellpadding="2">
      <tr>
      	<td class="celda_relleno" width="45%"></td>
        <td style="max-width:250px;min-width:250px;" nowrap>
        <table width="100%" height="100%" border="0" cellspacing="0" cellpadding="2">
          <tr>
            <td>
            	<table width="100%" border="0" cellspacing="0" cellpadding="2" style="color:#00a0dc;">
                  <tr>
                    <td>curp del paciente</td>
                  </tr>
                  <tr>
                    <td><input name="curp" type="text" class="campoDatosTabla" id="curp" onKeyUp="conMayusculas(this); nick(this.value, this.name);" maxlength="18" placeholder=""></td>
                  </tr>
                </table>
            </td>
          </tr>
          <tr>
            <td>
            	<table width="100%" border="0" cellspacing="0" cellpadding="2" style="color:#00a0dc;">
                  <tr>
                    <td>referencia dle estudio</td>
                  </tr>
                  <tr>
                    <td><input name="referenciaE" type="text" class="campoDatosTabla" id="referenciaE" onKeyUp="conMayusculas(this);" maxlength="12" placeholder=""></td>
                  </tr>
                </table>
            </td>
          </tr>
          <tr>
            <td>
            	<table width="100%" border="0" cellspacing="0" cellpadding="4" style="color:white;">
                  <tr>
                    <td><span class="paciente" style="color:#00a0dc;">NOMBRE DEL PACIENTE:</span></td>
                  </tr>
                  <tr>
                    <td><span class="paciente" id="miPaciente" style="color:;"></span></td>
                  </tr>
                </table>
            </td>
          </tr>
          <tr>
            <td>
            	<table width="100%" border="0" cellspacing="0" cellpadding="4" style="color:white;">
                  <tr>
                    <td><span class="referencia" style="color:;">ESTUDIO DE <span id="tipoEstudio"></span></span></td>
                  </tr>
                  <tr>
                    <td><span class="referencia" id="miEstudio" style="color:;"></span></td>
                  </tr>
                  <tr>
                    <td align="left">
                        <span class="referencia verEstudioPDF" style="color:;">
                            VER ESTUDIO <button id="verEstudioL">&nbsp;</button> 
                            <input name="nombre_pdf_e" id="nombre_pdf_e" type="hidden" value="">
                        </span>
                        <span class="referencia noVerEstudioPDF" style="color:red; font-size:0.8em;">
                        	EL RESULTADO AÚN NO ESTÁ DISPONIBLE.
                        </span>
                        <span class="referenciaI verEstudioInterpretacionI" style="color:; display:none;">
                            VER INTERPRETACIÓN <button id="verInterpretacionI">&nbsp;</button> 
                            <input name="nombre_interpretacion_ei" id="nombre_interpretacion_ei" type="hidden" value="">
                        </span>
                    </td>
                  </tr>
                </table>
            </td>
          </tr>
        </table>
        </td>
        <td class="celda_relleno" width="45%"></td>
      </tr>
    </table>
    </td>
  </tr>
</table>
</form>
</div>

<div id="dialog-visualizador" style="display:none;"> </div>
    
</body>
</html>