// JavaScript Document
function inicio(){
/*$(document).ready(function(e) {
	var boton_b_m = $('#b_buscarm_o');
	
	var allBotonesIcono = $('.b_bme');
	allBotonesIcono.css('min-width','40px').css('min-height','40px');
	//botón de buscar el médico
	$( "#b_total" ).attr('disabled',true);
	$( '#b_buscarm_o' ).button({
		icons: {
			primary: "ui-icon-search"
		},
		text: false
	});
	//botón de cambiar de médico
        $( '#b_cambiarm_o' ).button({
            icons: {
                primary: "ui-icon-refresh"
            },
            text: false
        });
	//botón de cambiar de convenio del paciente
        $( '#b_reasignarc_o' ).button({
            icons: {
                primary: "ui-icon-refresh"
            },
            text: false
        });
	//botón de cambiar de agregar estudios
        $( '#b_agregar_e' ).button({
            icons: {
                primary: "ui-icon-plusthick"
            },
            text: false
        });	
		$( "#b_agregar_e" ).button( "disable" );
	//botón de Actualizar los estudios de la orden
        $( '#b_modificar_e' ).button({
            icons: {
                primary: "ui-icon-refresh"
            },
            text: false
        });
		//botón de Hacer Pago para la OV
        $( '#b_pago_ov' ).button({
            icons: {
                primary: "ui-icon-plusthick"
            },
            text: false
        });
		
   $( "#c_fechae_o" ).datepicker({
		showAnim : "slideDown",
		maxDate: +20,
		minDate: -0,
		dateFormat: "dd/mm/yy"
	});
	$( "#format" ).buttonset({
		icons: { primary: "ui-icon-gear", secondary: "ui-icon-triangle-1-s" }
	});
	
	var color_naranja = 'rgba(237,123,8,1)', div_datos_medico = $('#div_datos_medico'), b_buscar_medico = $('#b_buscarm_o'), div_datos_estudios = $('#div_datos_estudios'), div_opciones_estudios = $('#datos1_o');
	//Div Sección de los estudios
	var divSeccionEstudios = $('#contenido_11');
	//Cabecera de las tabla naranjas mostradas
	var cabecera_tnaranja = $('.cabecera_tabla_naranja');
	//Pintamos la cabecera de las tablas naranja
	cabecera_tnaranja.css('background-color',color_naranja).css('text-align','center');
	//centramos verticalmente el contenido de la sección ESTUDIOS al centro
	divSeccionEstudios.css('vertical-align','middle');
	
	//ocultamos todo lo que no sea necesario al cargar la página:
	div_datos_medico.hide();
	div_opciones_estudios.hide();
	div_datos_estudios.hide();
	var miTablaMedicoSeleccionado = $('#miTablaMedicoSeleccionado'), b_eliminarM_E = $('#b_eliminarEstudios');
	miTablaMedicoSeleccionado.css('width','99.7%').css('margin-top','1px');
	b_eliminarM_E.button({
		icons: {
                primary: "ui-icon-trash"
            },
        text: false
	});
	
	var miTablaestudios = $('#mi_tabla_estudios'),subtotalEH = $('#subTotalEH'),subtotal_e_h = $('#box_subtotal_estudios_e'),b_modif_e=$('#b_modificar_e');
		miTablaestudios.css('margin-top','1px').css('width','99.7%');
		
	b_modif_e.click(function(e) {
	   subtotalEH.val(subtotal_e_h);
	});
	//para seleccionar las claves de los estudios seleccionados
	var cabecera_tabla_estudios=$('#mi_tabla_estudios tr'), imgg = $('#help img');
	imgg.click(function(e) {
       //alert(miArray.length);
    });
	
	var cajasResultadosEstudios = $('.box_resultado_e'), tablaTotalEstudiosE = $('#tablaTotalEstudiosE'), ahorroTotal=0, costoReal=0;
	cajasResultadosEstudios.css('text-align','center').css('color','white').css('width','5px').css('opacity','1');
	tablaTotalEstudiosE.css('width','99.7%').css('margin-top','1px');
	
	//sacando el TOTAL
	var subtotal_e = $('#box_subtotal_estudios_e'), descuentoC = $('#box_descuentoConvenio_e'), descuentoA = $('#box_descuentoAdicional_e'), total_e = $('#box_total_e'), descuento = $('#descuentoAdicional'), campoSumaTomaE = $('#campoSumaTomaEovT'),
		costoRealOV = $('#campoOVcostoRealTotal'), entregaDom = $('#box_entregaDom_e'), urgencia = $('#box_urgencia_e'), tomaDomicilio = $('#box_tomaDom_e'), mi_total_e, UrgTemp = $('#box_urgencia_e').val(), patron="$",	subtotal_e1, urgencia1,temp;
		
		total_e.val(0);
		
		urgencia.focus(function(e) {
            var urgTemp = $(this).val(), urgenciaH = $('#urgenciaH');
			if (urgTemp>=0 && urgTemp<=100000){ urgenciaH.val(urgTemp)}
			$(this).val("");
        });//fin focus urgencia
		urgencia.blur(function(e) {
            var urgTemp1 = $(this).val(), urgenciaH = $('#urgenciaH').val(),x=$(this).val(),b=$('#box_tomaDom_e').val(),c=$('#box_entregaDom_e').val(),z=$('#box_subtotal_estudios_e').val(), d=$('#descuentoAdicional').val(),y=$(this).val();
			if ( urgTemp1==""){
				$(this).val(urgenciaH);
			}
        });//fin blur urgencia
		
		tomaDomicilio.focus(function(e) {
            var tomaDomicilioTemp = $(this).val(), tomaDomicilioH = $('#tomaDomicilioH');
			if (tomaDomicilioTemp>=0 && tomaDomicilioTemp<=100000){ tomaDomicilioH.val(tomaDomicilioTemp)}
			$(this).val("");
        });//fin focus tomaDomicilio
		tomaDomicilio.blur(function(e) {
            var tomaDomicilioTemp1 = $(this).val(), tomaDomicilioH = $('#tomaDomicilioH').val(), a=$('#box_urgencia_e').val(),b=$(this).val(),c=$('#box_entregaDom_e').val(),z=$('#box_subtotal_estudios_e').val(), d=$('#descuentoAdicional').val();
			if ( tomaDomicilioTemp1==""){
				$(this).val(tomaDomicilioH);
			}
        });//fin blur tomaDomicilio
		
		entregaDom.focus(function(e) {
            var entregaDomTemp = $(this).val(), entregaDomH = $('#entregaDomH');
			if (entregaDomTemp>=0 && entregaDomTemp<=100000){ entregaDomH.val(entregaDomTemp)}
			$(this).val("");
        });//fin focus entregaDom
		entregaDom.blur(function(e) {
            var entregaDomTemp1 = $(this).val(), entregaDomH = $('#entregaDomH').val(),a=$('#box_urgencia_e').val(),b=$('#box_tomaDom_e').val(),c=$(this).val(),z=$('#box_subtotal_estudios_e').val(), d=$('#descuentoAdicional').val();
			if ( entregaDomTemp1==""){
				$(this).val(entregaDomH);
			}
        });//fin blur entregaDom
		
		descuento.keyup(function(e) {
			var a=$('#box_urgencia_e').val(),b=$('#box_tomaDom_e').val(),c=$('#box_entregaDom_e').val(),z=$('#box_subtotal_estudios_e').val(),d=$(this).val();
				if (d>100){ $(this).val(100).css('color','red');totalesEstudios( document.getElementById('box_subtotal_estudios_e').value, document.getElementById('box_urgencia_e').value, document.getElementById('box_tomaDom_e').value, 100, document.getElementById('campoOVdescuentoTotal').value, document.getElementById('box_entregaDom_e').value );}
				if (d<=0 || d ==""){$(this).css('color','white');}else if(d>0 && d <=100){$(this).css('color','red');} 
        });//fin keyup descuento
		descuento.focus(function(e) {
            var descuentoTemp = $(this).val(), descuentoH = $('#descuentoH');
			if (descuentoTemp>=0 && descuentoTemp<=100){ descuentoH.val(descuentoTemp).css('color','red');}else{ }
			if (descuentoTemp>0 && descuentoTemp<=100){$('.notaDescuentoE').fadeIn('fast');}
			$(this).val("");
        });//fin focus descuento
		descuento.blur(function(e) {
            var descuentoTemp1 = $(this).val(), descuentoH = $('#descuentoH').val(),a=$('#box_urgencia_e').val(),b=$('#box_tomaDom_e').val(),c=$('#box_entregaDom_e').val(),z=$('#box_subtotal_estudios_e').val(),d=$(this).val();
			if ( descuentoTemp1==""){
				$(this).val(descuentoH);
			if (descuentoTemp1 > 0 && descuentoTemp1<=100){$(this).css('color','red')}
			if (descuentoH > 0 && descuentoH<=100){$(this).css('color','red'); $('.notaDescuentoE').fadeIn('fast');}
			}
        });//fin blur descuento
		
		//boton para escoger la fecha de entrega
	var b_fechae = $('#c_fechae_o');
	//reducimos el boton fecha entrega de estudio, de tamaño
	b_fechae.css('width','20px').css('text-align','center');
	
        $('#horaEntrega').timepicker({
			currentText: 'Ahora',
			closeText: 'Ok',
			timeOnlyTitle: 'Escoge la Hora',
			timeText: 'Hora',
			hourText: 'Horas',
			minuteText: 'Minutos'
		});
		var horaEntrega = $('#horaEntrega');
		horaEntrega.css('text-align','center').css('width','5%');
		
	//tamaño campo observaciones
	var c_observaciones_o = $('#c_observaciones_o'), notaDescuentoE = $('#notaDescuentoE');
	c_observaciones_o.css('width','100%');
	notaDescuentoE.css('width','100%').css('text-align','left');
	    
		//mostrar-ocultar la nota del descuento de los estudios
	var descuentoAdicional = $('#descuentoAdicional'), spanNotaDescuentoE=$('.notaDescuentoE');
	spanNotaDescuentoE.hide();
	descuentoAdicional.keyup(function(e) {
        var x = $(this).val();
		if( x >0 && x<=100 ){ spanNotaDescuentoE.stop().show(); }
		else{ spanNotaDescuentoE.stop().hide(); }
		if (x>100){$(this).val(100); spanNotaDescuentoE.stop().show(); }
    });    //Fin mostrar-ocultar la nota del descuento de los estudios
	
// Funciones para buscar al médico de estudios
	var tamH1 = $('#referencia').height() - $('#header').height() - $('#footer').height() -0;
	
	var oTable;
	oTable = $('#dataTableBME').dataTable({
		"bJQueryUI": false,
		"bScrollCollapse": true,
		"bRetrieve": true,
		"sScrollY": 100,
		"bAutoWidth": true,
		"bPaginate": true,
		"sPaginationType": "two_button", //full_numbers,two_button
		"bStateSave": false,
		"bInfo": true,
		"bFilter": true,
		"aaSorting": [[2, "asc"]],
		"aoColumns": [{ "bSortable": false }, { "bSortable": false },
            { "bSortable": false }, { "bSortable": false }, { "bSortable": false }, { "bSortable": false }],
		"iDisplayLength": 50,
		"bLengthChange": false,
		"bProcessing": false,
		"bServerSide": true,
		"sDom": '<"filtro1BME"f>l<"infoBME">r<"data_tbmE"t>',
		"sAjaxSource": "js/datatable-serverside/buscar_medico_nueva_visita.php",
		"aLengthMenu": [[9, 25, 50, 100, -1], [9, 25, 50, 100, "Todos"]],
		"oLanguage": {
			"sLengthMenu": "MONSTRANDO _MENU_ records per page",
			"sZeroRecords": "SIN COINCIDENCIAS - LO SENTIMOS",
			"sInfo": "MOSTRADOS: _END_",
			"sInfoEmpty": "MOSTRADOS: 0",
			"sInfoFiltered": "<br/>PACIENTES: _MAX_",
			"sSearch": "BUSCAR"
		}
	});//fin datatable

	//función para los filtros individuales en el pié de la tabla
//	$(".pieTablaBM input").keyup( function () {oTable.fnFilter( this.value, $(".pieTablaBM input").index(this) );} );

    $(".pieTablaBM input").focus( function () {
        if ( this.className == "search_init" )
        {
            this.className = "";
            this.value = "";
        }
    } );
     
    $(".pieTablaBM input").blur( function (i) {
        if ( this.value == "" )
        {
            this.className = "search_init";
            this.value = asInitVals[$(".pieTablaBM input").index(this)];
        }
    } );
	//fin función para los filtros individuales en el pié de la tabla
	
		var mi_clave_m = $('#mi_clave_m');
		var mi_nombre_m = $('#mi_nombre_m');
		var mi_especialidad_m = $('#mi_especialidad_m');
	
	$(document).delegate('#dataTableBME tbody tr','click', function () {
        var sTitle; 
		var all_palomas = $('#dataTableBME tbody tr img');
		//var caja = $('input', this);
		//var all_cajas = $('#dataTable tbody tr input');
		var all_celdas = $('#dataTableBME tbody td');
        var nTds = $('td', this);
		var mi_paloma = $('img', this);
        var sBrowser = $(nTds[1]).text();
		var sBrowser1 = $(nTds[2]).text();
		var sBrowser2 = $(nTds[3]).text();
		var sClave = $(nTds[0]).text();
		var sEspecialidad = $(nTds[4]).text();
		sTitle =  sBrowser;
		all_celdas.removeClass('celda_s');
		nTds.addClass('celda_s');
		
		all_palomas.addClass('opacidad_0');
		mi_paloma.removeClass('opacidad_0');
		
		all_celdas.removeClass('celda_s');
		nTds.addClass('celda_s');
		mi_clave_m.val(sClave);
		mi_nombre_m.val(sBrowser+" "+sBrowser1+" "+sBrowser2);
		mi_especialidad_m.val(sEspecialidad);
    } );
	
	function fnGetSelected( oTableLocal )
	{
		alert("hi");
    	return "hola";
	}
	//La div de los datos de médico que aparecen cuando se escoje a uno de ellos en el dialog
	div_datos_medico = $('#div_datos_medico');
	//botón de buscar médico
	var boton_b_m = $('#b_buscarm_o');
	//Cuadro diálogo para buscar el médico
	var div_falta_m = $('#div_falta_m');
	//span de los datos del medico q van aparecer al seleccionarlo en ESTUDIOS
	var mi_dato_clave_m = $('#mi_dato_clave_m');
	var mi_dato_nombre_m = $('#mi_dato_nombre_m');
	var mi_dato_especialidad_m = $('#mi_dato_especialidad_m');
	//span de los datos del medico q van aparecer al seleccionarlo en TOTAL
	var mi_dato_clave_m_ov = $('#mi_dato_clave_m_ov');
	var mi_dato_medico_m_ov = $('#mi_dato_medico_m_ov');
	var mi_dato_especialidad_m_ov = $('#mi_dato_especialidad_m_ov');
	//el cuadro de filtrado en busqueda del médico
	var search_box = $('#dialog :text :first');
	//el boton de cambiar al médico
	var b_cambiarm = $('#b_cambiarm_o');
	//el boton de modificar los estudios
	var b_modificare = $('#b_modificar_e');
	//Botón Cambiar Mpedido
	var b_cambiarm = $('#b_cambiarm_o');
	// tabla que contiene a la tabla de buscar al medico
	var tablaTbMedico = $('#tablaContenedoraTablaBuscarMedico');
	//ocultar los botones Cambiar médico y Modificar Estudios al cargar la página:
	b_cambiarm.css('display','none');
	b_modificare.css('display','none');
	
	// increase the default animation speed to exaggerate the effect
	
	var tamH = $('#referencia').height() - $('#header').height() - $('#footer').height()-20;
	var tamW = $('#referencia').width() * 0.8;
	
	$( "#dialog" ).dialog({
		autoOpen: false,
		closeText: '',
		show: "blind",
		hide: "fold",
		modal: true,
		height : tamH,
		width : tamW,
		buttons: {
			"Aceptar": function() {
				if (mi_nombre_m.val() == "" && search_box.val() != ""){
					div_falta_m.text('Se debe seleccionar un Médico');
					
				}
				else if(mi_nombre_m.val() == "" && search_box.val() == ""){
					div_falta_m.text('Se debe iniciar la Búsqueda');
				}
				else{
					//habilitamos los bobones de agregar medico para estudios y el de la pestaña TOTAL
					$( "#b_agregar_e" ).button( "enable" );
					$('#b_total').attr('disabled',false);
					//cierra la ventana actual
					$( this ).stop().dialog( "close" );
					//Muestra el botón de Cambiar al médico
					b_cambiarm.css('display','block');
					//ocultamos la tabla de buscar medico
					tablaTbMedico.hide();
					
					div_datos_medico.show('slow');
					boton_b_m.hide();
					//aparece los datos del medico seleccionado en ESTUDIOS
					mi_dato_clave_m.text(mi_clave_m.val());
					mi_dato_nombre_m.text(mi_nombre_m.val());
					mi_dato_especialidad_m.text(mi_especialidad_m.val());
					//aparece los datos del medico seleccionado en TOTAL
					mi_dato_clave_m_ov.text(mi_clave_m.val());
					mi_dato_medico_m_ov.text(mi_nombre_m.val());
					mi_dato_especialidad_m_ov.text(mi_especialidad_m.val());
					//asignamos la clave del médico a su campo oculto para guardar la OV
					document.getElementById('clave_medico_E').value = mi_clave_m.val();
				}
			},//Fin botón acepar
			Cancelar: function() {
				$( this ).dialog( "close" );
			}
		}
    });
 
  //funcion q desata la ventana emergente de la búsqueda del médico con el botón BUSCAR
  $( "#b_buscarm_o" ).click(function() {
            $( "#dialog" ).dialog( "open" );
            return false;
  });
  //funcion q desata la ventana emergente de la búsqueda del médico con el botón CAMBIAR
  $( "#b_cambiarm_o" ).click(function() {
            $( "#dialog" ).dialog( "open" );
            return false;
  });
  
  $('#mi_pie_tabla input').css('border-width','2px').css('border-style','solid').css('border-color','rgb(102,102,102)').css('border-radius','3px');
	
	var search_box = $('.filtro1BME input'), data_t = $('#dataTableBME tbody'), dataT = $('#my_headBME'), info_t = $('.infoBME *'), resete = $('#reseteBME'), div_botones = $('.botonesBME'), mis_botones = $('.botonesBME img'), mi_pie_t = $('#mi_pie_tabla');
	
	mis_botones.css('cursor','pointer');
	//ocultando la info de la datatable al cargar la pp
	info_t.css('visibility','hidden');
	dataT.css('visibility','hidden');
	data_t.css('visibility','hidden');
	div_botones.css('visibility','hidden');
	mi_pie_t.css('visibility','hidden');
	
	search_box.focus().css('height','5%').css('text-align','left').css('border-width','2px').css('border-color','rgb(51,51,51)').css('background-color','transparent)').css('color','rgb(0,0,0)').css('border-style','solid').css('border-radius','3px');
	
	search_box.keyup(function(e) {
    	if( $(this).val() == '' ){
			data_t.css('visibility','hidden');
			info_t.css('display','none');
			div_botones.css('visibility','hidden');
			dataT.css('visibility','hidden');
			mi_pie_t.css('visibility','hidden');
		}else {data_t.css('visibility','visible');
			info_t.fadeIn('slow');
			dataT.css('visibility','visible');
			mi_pie_t.css('visibility','visible');
			div_botones.css('visibility','visible');}
    });
	
	resete.click(function(e) {
        search_box.val('');
		search_box.focus();
		data_t.css('visibility','hidden');
		info_t.css('display','none');
		div_botones.css('visibility','hidden');
		dataT.css('visibility','hidden');
		mi_pie_t.css('visibility','hidden');
    });
	
	//los botones aceptar y cancelar de la busqueda del medico
	$('#dia').text('hola');
	
//Fin funciones para buscar al médico de los estudios
	
});
*/
}