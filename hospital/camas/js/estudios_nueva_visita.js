// JavaScript Document
function inicio1(){
/*
$(document).ready(function(e) {
	
	$('#dataTable2').DataTable({//inicio de datatable2 la de los estudios
		"bJQueryUI": false,
		"bScrollCollapse": true,
		"bRetrieve": true,
		"bAutoWidth": false,
		"bPaginate": false,
		"bInfo": false,
		"bFilter": false,
		"aaSorting": [[0, "asc"]],
		"aoColumns": [{ "bSortable": false }, { "bSortable": false }, { "bSortable": false }, { "bSortable": false }, { "bSortable": false }],
		"iDisplayLength": 5,
		"bLengthChange": true,
		"sDom": '',
		"sScrollY": "150px"
		
	});//fin datatable
	
	$('#dataTable2 tbody').on( 'click', 'img', function () {
		$(this).closest('tr').remove();
	} );
	
	//para poner cursor pointer sobre el tache de eliminar estudio:
	var img_tache = $('.pointer1');
	img_tache.hover(function(e) {
        $(this).css('cursor','pointer');
    });
	var dataTa2 = $('#dataTable2');
	dataTa2.css('text-align','left');
	var titulosDT2 = $('#my_head2');
	var color_naranja = 'rgba(237,123,38,1)';
	//estilo a las cabeceras de la tabla de busquedas
	titulosDT2.css('width','100%').css('background-color',color_naranja).css('font-style','italic').css('opacity','2');
	$('#my_headC').css('width','100%').css('background-color',color_naranja).css('font-style','italic').css('opacity','2');
	$('#my_headBPS').css('width','100%').css('background-color',color_naranja).css('font-style','italic').css('opacity','2');
	
	var miArray = new Array(),
	arrayPrecioE = new Array();

	var oTable1;//ESTUDIOS

	oTable1 = $('#dataTable1').DataTable({
		"bJQueryUI": false,
		"bScrollCollapse": true,
		"bRetrieve": true,
		"sScrollY": "150px",
		"bAutoWidth": true,
		"bPaginate": true,
		"sPaginationType": "two_button", //full_numbers,two_button
		"bStateSave": false,
		"bInfo": true,
		"bFilter": true,
		"aaSorting": [[2, "asc"]],
		"aoColumns": [{ "bSortable": false }, { "bSortable": false }, { "bSortable": false }, { "bSortable": false }, { "bSortable": false }],
		"iDisplayLength": 15,
		"bLengthChange": false,
		"bProcessing": false,
		"bServerSide": true,
		"sDom": '<"filtro1BE"f>l<"infoBE">r<"data_tBE"t>',
		"sAjaxSource": "js/datatable-serverside/buscar_estudios_nueva_visita.php",
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
	$("tfoot.t1 input").keyup( function () {

        oTable1.fnFilter( this.value, $("tfoot.t1 input").index(this) );
    } );
	
    $("tfoot.t1 input").focus( function () {
        if ( this.className == "search_init" )
        {
            this.className = "";
            this.value = "";
        }
    } );
     
    $("tfoot.t1 input").blur( function (i) {
        if ( this.value == "" )
        {
            this.className = "search_init";
            this.value = asInitVals[$("tfoot.t1 input").index(this)];
        }
    } );
	//fin función para los filtros individuales en el pié de la tabla
	
		var mi_clave_e = $('#mi_clave_e');
		var mi_nombre_e = $('#mi_nombre_e');
		var mi_depto_e = $('#mi_depto_e');
		var mi_precio_e = $('#mi_precio_e');
	
	//funcion al dar click en el estudio de la tabla de buscar estudios y hace que se agreguen en la tabla de abajo
$(document).delegate('#dataTable1 tbody tr','click', function () {
        var sTitle;
		var all_palomas = $('#dataTable1 tbody tr img');
		//var caja = $('input', this);
		//var all_cajas = $('#dataTable tbody tr input');
		var all_celdas = $('#dataTable1 tbody td');
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
		mi_clave_e.val(sClave);
		mi_nombre_e.val(sBrowser);
		mi_depto_e.val(sBrowser1);
		mi_precio_e.val(sBrowser2);
		var i = 0;
		//creamos la nueva fila en la tabla de agregar estudios
		addNewRow(sClave,sBrowser,sBrowser1,sBrowser2); //removeLastRow(event);
		for (i=0;i<1;i++){
			alert(s);
			removeLastRow(event);
		}		
    } );
	
	function fnGetSelected( oTableLocal )
	{
		alert("hi");
    	return "hola";
		//return oTableLocal.$('tr.calda_s');
	}
	//La div de los datos del estudio que aparecen cuando se escoje a uno de ellos en el dialog1
	div_datos_estudios = $('#div_datos_estudios');
	//botón de buscar estudio
	var boton_b_e = $('#b_agregar_e');
	//Div para mostrar texto al darle en aceptar y no tener ningún estudio seleccionado
	var div_falta_e = $('#div_falta_e');
	//span de los datos del estudio q van aparecer al seleccionarlo
	var mi_dato_clave_e = $('#mi_dato_clave_e');
	var mi_dato_nombre_e = $('#mi_dato_nombre_e');
	var mi_dato_depto_m = $('#mi_dato_depto_e');
	var mi_dato_precio_m = $('#mi_dato_precio_e');
	//el cuadro de filtrado en busqueda del médico
	var search_box1 = $('#dialog1 :text :first');
	//boton modificar estudios
	var b_modificare = $('#b_modificar_e');
	//Div datos adicionales estudios
	var datos_adicionalese = $('#datos1_o');
	//tabla que contiene la tabla de buscar estudios
	var tablaContenedoraBe = $('#tablaContenedoraBuscarEstudios');
	
	var a_x=$('#box_urgencia_e').val(),b_x=$('#box_tomaDom_e').val(),c_x=$('#box_entregaDom_e').val(),z_x=$('#box_subtotal_estudios_e').val(), d_x=$('#descuentoAdicional').val(),a5=$('#urgenciaH'),b5=$('#tomaDomicilioH').val(),c5=$('#entregaDomH').val(),z5=$('#subTotalEH').val(),d5=$('#descuentoH').val();
	
	//estilo para los inputs del pié de página
    $('#mi_pie_tabla1 input').css('border-width','2px').css('border-style','solid').css('border-color','rgb(102,102,102)').css('border-radius','3px');
	
	var search_box1 = $('.filtro1BE input');
	var data_t1 = $('#dataTable1 tbody');
	var dataT1 = $('#my_head1');
	var info_t1 = $('.infoBE *');
	var resete1 = $('#resete1');
	var div_botones1 = $('#botones1');
	var mis_botones1 = $('#botones1 img');
	var mi_pie_t1 = $('#mi_pie_tabla1');
	
	mis_botones1.css('cursor','pointer');
	//ocultando la info de la datatable al cargar la pp
	info_t1.css('visibility','hidden');
	//dataT1.css('visibility','hidden');
	data_t1.css('visibility','hidden');
	div_botones1.css('visibility','hidden');
	mi_pie_t1.css('visibility','hidden');
	
	search_box1.focus().css('height','5%').css('text-align','left').css('border-width','2px').css('border-color','rgb(51,51,51)').css('background-color','transparent)').css('color','rgb(0,0,0)').css('border-style','solid').css('border-radius','3px');
	
	search_box1.keyup(function(e) {
    	if( $(this).val() == '' ){
			data_t1.css('visibility','hidden');
			info_t1.css('display','none');
			div_botones1.css('visibility','hidden');
			dataT1.css('visibility','hidden');
			mi_pie_t1.css('visibility','hidden');
		}else {
			data_t1.css('visibility','visible'); 
			info_t1.fadeIn('slow');
			dataT1.css('visibility','visible');
			mi_pie_t1.css('visibility','visible');
			div_botones1.css('visibility','visible');}
    });
	
	resete1.click(function(e) {
        search_box1.val('');
		search_box1.focus();
		data_t1.css('visibility','hidden');
		info_t1.css('display','none');
		div_botones1.css('visibility','hidden');
		dataT1.css('visibility','hidden');
		mi_pie_t1.css('visibility','hidden');
    });
	
	var taches_eliminar_estudio = $('#data tbody .hola');
	taches_eliminar_estudio.hover(function(e) {
        alert("he");
    });
	
	var tamH = $('#referencia').height() - $('#header').height() - $('#footer').height();
	var tamW = $('#referencia').width() * 0.8;
	
	// increase the default animation speed to exaggerate the effect
 $( "#dialog1" ).dialog({
	autoOpen: false,
	closeText: '',
	show: "blind",
	hide: "fold",
	modal: true,
	resizable: false,
	height: tamH,
	width : tamW,
	buttons: {
		"Aceptar": function() {
			if (mi_nombre_e.val() == "" && search_box1.val() != ""){
				div_falta_e.text('Se debe seleccionar un Estudio del Menú');
			}
			else if(mi_nombre_e.val() == "" && search_box1.val() == ""){
				div_falta_e.text('Se debe iniciar la Búsqueda');
			}
			else{
				tablaContenedoraBe.hide();
				var i =0, j=4,cont =1, k = 0,b=0, cont1=1;
				// obtenemos acceso a la tabla por su ID
				var TABLE_q = document.getElementById("mi_tabla_estudios");//ESTUDIOS
				var TABLE_r = document.getElementById("mi_tabla_estudios_TOTAL");//TOTAL
				 // obtenemos acceso a la fila maestra por su ID
				var TROW_q = document.getElementById("celda_maestra_est");//ESTUDIOS
				var TROW_r = document.getElementById("celda_maestra_est_TOTAL");//TOTAL

				// tomamos la celda
				var content_q = TROW_q.getElementsByTagName("td");//ESTUDIOS
				var content_r = TROW_r.getElementsByTagName("td");//TOTAL

				var mi_tabla_est = document.getElementById("dataTable2");//Busqueda Estudiosv(referencia)
				//número de filas de la tabla de busqueda de estudios
				var numFilas = mi_tabla_est.rows.length;//Busqueda Estudiosv(referencia)
				//número de filas de la tabla de estudios ya seleccionados y mostrados
				var numFilas1 = TABLE_q.rows.length;//ESTUDIOS
				var numFilas2 = TABLE_r.rows.length;//TOTAL
										
				//var texto = mi_tabla_est.tBodies[0].rows[1].cells[0].innerHTML;
				var textox = numFilas1;//ESTUDIOS
				var textox1 = numFilas2;//TOTAL
				//alert("Texto de la Columna 1, Fila 1: "+textox);
				
				//eliminar la tabla cuando exista algún estudio, es para el caso de modificar los estudios
					if(numFilas1>3){//ESTUDIOS
						//TABLE_q.deleteRow(1);
						for (k=4; k<=numFilas1;k++ ){
							TABLE_q.deleteRow(3);//ESTUDIOS
						}
					}
					if(numFilas2>2){//TOTAL
						for (b=3; b<=numFilas2;b++ ){
							TABLE_r.deleteRow(2);//TOTAL
						}
					}
				//FIN eliminar la tabla cuando exista algún estudio, es para el caso de modificar los estudios
				
				var subtotalEstudios = 0, miID=0;
					
				for (i = 3; i<=numFilas; i++){
					//Para eliminar la primera fila que en realidad está vacía:
					if(TABLE_q.tBodies[0].rows[1].cells[0].innerHTML==""){
						//TABLE_q.deleteRow(1);
					}
					
					// creamos una nueva fila
					var newRow_q = TABLE_q.insertRow(-1);//ESTUDIOS
					newRow_q.className = TROW_q.attributes['class'].value;//ESTUDIOS
					var newRow_r = TABLE_r.insertRow(-1);//TOTAL
					newRow_r.className = TROW_r.attributes['class'].value;//TOTAL

					// creamos una nueva celda ESTUDIOS
					var newCell_q = newRow_q.insertCell(newRow_q.cells.length);
					var newCell_1_q = newRow_q.insertCell(newRow_q.cells.length);
					var newCell_2_q = newRow_q.insertCell(newRow_q.cells.length);
					var newCell_3_q = newRow_q.insertCell(newRow_q.cells.length);
					var newCell_4_q = newRow_q.insertCell(newRow_q.cells.length);
					// creamos una nueva celda TOTAL
					var newCell_r = newRow_r.insertCell(newRow_r.cells.length);
					var newCell_1_r = newRow_r.insertCell(newRow_r.cells.length);
					var newCell_2_r = newRow_r.insertCell(newRow_r.cells.length);
					var newCell_3_r = newRow_r.insertCell(newRow_r.cells.length);
					var newCell_4_r = newRow_r.insertCell(newRow_r.cells.length);
					var newCell_5_r = newRow_r.insertCell(newRow_r.cells.length);
					var newCell_6_r = newRow_r.insertCell(newRow_r.cells.length);

					// creamos un nuevo control //ESTUDIOS
					txt1_q = cont++;
					txt2_q = mi_tabla_est.tBodies[0].rows[i-2].cells[0].innerHTML;
							//asignando las claves de los estudios a un arreglo para guardarlos en la página serverside con ajax
					miArray[i-3] = txt2_q;
					txt3_q = mi_tabla_est.tBodies[0].rows[i-2].cells[1].innerHTML;
					txt4_q = mi_tabla_est.tBodies[0].rows[i-2].cells[2].innerHTML;
					txt5_q = mi_tabla_est.tBodies[0].rows[i-2].cells[3].innerHTML;
						//asignando los precios de los estudios a un arreglo para guardarlos en la página serverside con ajax
					arrayPrecioE[i-3] = txt5_q;
					// creamos un nuevo control //TOTAL
					txt1_r = cont1++;
					txt2_r = mi_tabla_est.tBodies[0].rows[i-2].cells[0].innerHTML;
					txt3_r = mi_tabla_est.tBodies[0].rows[i-2].cells[1].innerHTML;
					txt4_r = mi_tabla_est.tBodies[0].rows[i-2].cells[2].innerHTML;
					txt5_r = mi_tabla_est.tBodies[0].rows[i-2].cells[3].innerHTML;
					txt6_r = mi_tabla_est.tBodies[0].rows[i-2].cells[3].innerHTML;

					// y lo asignamos a la celda ESTUDIOS
					newCell_q.innerHTML = txt1_q;
					newCell_1_q.innerHTML = '<input type="text" name="cmpoClaveE'+txt1_r+'" id="cmpoClaveE'+txt1_r+'" value="'+txt2_q+'" style="background-color:transparent; text-align:; width:100%; border-color:transparent; color:white; border-style:none" readonly class="campoClaveE">';
					newCell_2_q.innerHTML = '<input type="text" name="cmpoNameE'+txt1_r+'" id="cmpoNameE'+txt1_r+'" value="'+txt3_q+'" style="background-color:transparent; text-align:; width:100%; border-color:transparent; color:white; border-style:none" readonly class="campoNameE">';
					newCell_3_q.innerHTML = '<input type="text" name="cmpoDeptoE'+txt1_r+'" id="cmpoDeptoE'+txt1_r+'" value="'+txt4_q+'" style="background-color:transparent; text-align:; width:130px; border-color:transparent; color:white; border-style:none" readonly class="campoDeptoE">';
					if (txt2_q=="EXTRA"){
						newCell_4_q.innerHTML = '<input type="text" name="cmpoPrecioE'+txt1_r+'" id="cmpoPrecioE'+txt1_r+'" value="'+txt5_q+'" style="background-color:transparent; text-align:; width:5px; border-color:transparent; color:white; border-style:none" onKeyUp="numeros_decimales(this.value, this.name); keyUpp(this.id,this.value);" onFocus="foco(this.id,this.value);" onBlur="blure(this.id,this.value);" class="campoSumaVE precio_e1">';
						}else{newCell_4_q.innerHTML = '<input type="text" name="cmpoPrecioE'+txt1_r+'" id="cmpoPrecioE'+txt1_r+'" value="'+txt5_q+'" style="background-color:transparent; text-align:; width:5px; border-color:transparent; color:white; border-style:none" readonly class="campoSumaVE precio_e1">';}
					// y lo asignamos a la celda TOTAL
					newCell_r.innerHTML = txt1_r;
					newCell_1_r.innerHTML = txt2_r;
					newCell_2_r.innerHTML = txt3_r;
					newCell_3_r.innerHTML = txt4_r;
					newCell_4_r.innerHTML = '<input type="text" name="cmpoPrecioE'+txt1_r+'X" id="cmpoPrecioE'+txt1_r+'X" value="'+txt5_r+'" style="background-color:transparent; text-align:; width:5px; border-color:transparent; color:white; border-style:none" class="campoSumaVEX" readonly>';
					newCell_5_r.innerHTML = '<input type="text" name="cmpoPrecioC'+txt1_r+'" id="cmpoPrecioC'+txt1_r+'" value="'+txt5_r+'" style="background-color:transparent; text-align:; width:5px; border-color:transparent; color:white; border-style:none" readonly>';
					newCell_6_r.innerHTML = '<input type="text" name="cmpoPrecioD'+txt1_r+'" id="cmpoPrecioD'+txt1_r+'" value="'+txt5_r+'" style="background-color:transparent; text-align:; width:5px; border-color:transparent; color:white; border-style:none" readonly><input type="hidden" name="cmp'+txt1_r+'" id="cmp'+txt1_r+'" value="'+txt2_r+'" class="clave_e"><input type="hidden" name="cmp1'+txt1_r+'" id="cmp1'+txt1_r+'" value="'+txt5_r+'" class="precio_e">';
					
					//sumador del precio de los estudios
					subtotalEstudios = parseFloat(subtotalEstudios) + parseFloat(txt5_q);
					//campo del subtotal de la pestaña de estudios
					var Stotal_e = $('#box_total_e');
					
				}//fin del for
				Stotal_e.val(subtotalEstudios);
				
//asignando el subtotal de los estudios al total
				
				//Caja del resultado SUBTOTAL Estudios
				var cajaSubtotalEstudios = $('#box_subtotal_estudios'),
					cajaSubtotalEstudiosE = $('#box_subtotal_estudios_e');
				subtotalEstudios = subtotalEstudios;
				cajaSubtotalEstudios.val(subtotalEstudios);
				cajaSubtotalEstudiosE.val(subtotalEstudios);
				alert('aqui');
				//invocamos la funcion total x de ESTUDIOS para calcular los valores de la preorden de venta al actualizar los estudios
				totalesEstudios( document.getElementById('box_subtotal_estudios_e').value, document.getElementById('box_urgencia_e').value, document.getElementById('box_tomaDom_e').value, document.getElementById('descuentoAdicional').value, document.getElementById('campoOVdescuentoTotal').value, document.getElementById('box_entregaDom_e').value );
				
				//alert(subtotalEstudios);
				var columnas_est = $('#mi_tabla_estudios .celda_maestra_est');
				columnas_est.addClass('un_dato');
				//muestra el boton modificar estudios
				b_modificare.css('display','block');
				//muestra div contenido datos adicionales de los estudios
				datos_adicionalese.css('display','block');
				//cierra la ventana actual
				$( this ).stop().dialog( "close" );
				div_datos_estudios.show('slow');
				boton_b_e.hide();
				mi_dato_clave_e.text(mi_clave_e.val());
				mi_dato_nombre_e.text(mi_nombre_e.val());
				mi_dato_depto_e.text(mi_depto_e.val());
				mi_dato_precio_e.text(mi_precio_e.val()); cont= cont+1;
			}//fin del else
		},//fin de boton aceptar
		Cancelar: function() {
			$( this ).dialog( "close" );
		}
		}
	});
 
	 //Función que desata la ventana emergente de la busqueda de los estudios con el botón AGREGAR
	 $( "#b_agregar_e" ).click(function() {
				$( "#dialog1" ).dialog( "open" );
				return false;
	 });
	 //Función que desata la ventana emergente de la busqueda de los estudios con el botón MODIFICAR
	 $( "#b_modificar_e" ).click(function() {
				$( "#dialog1" ).dialog( "open" );
				return false;
	 });
	 
	 var numero = 0;
//para definir el número de la fila a borrar, empieza en 2
var mi_no_fila = 2;

function addNewRow(a,b,c,d){
//Esta función agregará los datos de los estudios en dos lados, abajo de la tabla de busqueda y en la tabla de TOTAL de estudios donde se desglozan todos
  // obtenemos acceso a la tabla por su ID
  var TABLE = document.getElementById("dataTable2");
  // obtenemos acceso a la fila maestra por su ID
  var TROW = document.getElementById("celda_maestra");
  // tomamos la celda
  var content = TROW.getElementsByTagName("td");
  // creamos una nueva fila
  var newRow = TABLE.insertRow(-1);
  newRow.className = TROW.attributes['class'].value;
  // creamos una nueva celda
  var newCell = newRow.insertCell(newRow.cells.length);
  var newCell_1 = newRow.insertCell(newRow.cells.length);
  var newCell_2 = newRow.insertCell(newRow.cells.length);
  var newCell_3 = newRow.insertCell(newRow.cells.length);
  var newCell_4 = newRow.insertCell(newRow.cells.length);
  // creamos una nueva ID para el examinador
  newID = 'file_' + (++numero);
 var s = numero-1, si = "alert('hola')", si1 = "removeLastRow(this.id)", mi_num = TABLE.rows.length-1, bu = "remove1(this,this.id)";
  // creamos un nuevo control 
  txt1 = a;
  txt2 = b;
  txt3 = c;
  txt4 = d;
  //txt5 = '<img src="../imagenes/pagina_visitas/eliminado.png" id="'+s+'" width="25" align="center" onClick="'+bu+'" style="cursor:pointer" class"hola" height="20">'; asi estaba antes de descubrir la nueva forma de borrar una fila con remove()
  txt5 = "<img src='../imagenes/pagina_visitas/eliminado.png' id=' "+s+" ' width='25' align='center' onClick='' style='cursor:pointer' class'hola' height='20'>";
  // y lo asignamos a la celda
  newCell.innerHTML = txt1;
  newCell_1.innerHTML = txt2;
  newCell_2.innerHTML = txt3;
  newCell_3.innerHTML = txt4;
  newCell_4.innerHTML = txt5;
  
  mi_no_fila = mi_no_fila+1;
}

function remove1(t,k){//elimina la fila seleccionada
	miArray[k]="undefined";
	arrayPrecioE[k]="undefined";
	var td = t.parentNode;var tr = td.parentNode;var table = tr.parentNode;
	table.removeChild(tr);
}

function removeLastRow(x){
  // obtenemos la tabla
  var TABLE = document.getElementById("dataTable2");
  // si tenemos mas de una fila, borramos
  if(TABLE.rows.length > 2) {
	  alert(x);
	  TABLE.deleteRow(x);
	  --numero;
  }
}
	
	$('#urgeAtender').click(function(e) {
        if($(this).prop('checked')==true){
			$('#urgeAtender1').val(1);
		}else{
			$('#urgeAtender1').val(0);
		}
    });
	
});

var contador_items=0, cont=0, contItems=(-1),contItems1=(-1);
//Función para salvar los estudios
function salvarServerSideE(x,departamentos,montos){
	 //alert(contador_items);
	 contador_items--;contItems1++;
	var clasex=$('.clave_e'),i=0,j=0, precios_e=$('.precio_e1'), gg= new Array(),preciosE = new Array(), numAleatorio = $('#num_aleatorio').val(),
		descuentoEstudios = $('#descuentoAdicional').val(), idPaciente = $('#idPaciente').val(), idUsuario = $('#idUsuario').val(), 
		claveMedicoE = $('#clave_medico_E').val(), observacionesEstudios = $('#c_observaciones_o').val(), fechaEntrega = $('#c_fechae_o').val(), 
		horaEntrega = $('#horaEntrega').val(), tUrgente = $('#campoUrgenciaEovT').val(), tTomaDom = $('#campoTomaDomEovT').val(), tEntregaDom = 
		$('#campoEntregaDomEovT1').val(), urgencia;
	//asignando todos los datos del formulario para salvar los estudios en su tabla
	if (tUrgente>0){urgencia = 1;}else{urgencia=0}
	//asignando todos los datos del formulario para salvar la Orden de Venta
    var subtotalEstudios = $('#box_subtotal_estudios_e').val(), totalEstudios = $('#ovTotalCampoTestudios').val(), 
   		totalTotal = $('#ovTotalCampoTtotal').val(), estadoPago = $('#estado_pago_ov').val(), notaDescuentoGralE = $('#notaDescuentoTotal').val(),
   		costoReal = $('#campoOVcostoRealTotal').val(),ahorroTotal = $('#campoOVahorroTotal').val(), notaDescuentoE = $('#notaDescuentoE').val(),
		NoEstudios=parseInt(x)+parseInt(contItems1), cSucursal = $('#sucursalOV').val(), totalNetoEstudios=0, porcentajeEstudioIndividual,montoIndividual;
			
	clasex.each(function(index, element){ gg[i]=$(this).val();i++; });
	precios_e.each(function(index, element){ preciosE[j]=$(this).val();j++; totalNetoEstudios=parseFloat(totalNetoEstudios)+parseFloat($(this).val()); });
	
	if ($('#ovTotalCampoTsaldo').val() > 0){estadoPago=1}else{estadoPago=0;}
	var saldo = $('#ovTotalCampoTsaldo').val(), pago = $('#ovTotalCampoTpago').val(), descuentoGral = $('#campoOVdescuentoTotal').val();
	//de consulta
	var claveMedicoCx = $('#claveMedicoConsul').val();//alert(claveMedicoCx);
	//de servicios
	var clavePersonalS = $('#clavePersonalS').val();
//
	var pagoInicial=$('#pago_pago').val(),pago=$('#ovTotalCampoTpago').val(),totalOV= $('#ovTotalCampoTtotal'),saldoTov=0,pago_pag=0,totalIndividual=0,
		saldoIndividual=0,extras=(parseFloat(tUrgente)+parseFloat(tTomaDom)+parseFloat(tEntregaDom))/NoEstudios,totalEstudioReal=preciosE[x-1],
		pagoOriginal=$('#pagoOriginal_pago').val(), porcentajeEstudioIndividual,montoIndividual;
		var totalServiciosJ = $('#ovTotalCampoTservicios').val();//sacamos el subtotal de servicios
		var totalConsultaJ = $('#ovTotalCampoTconsulta').val();//sacamos el subtotal de consulta
		var totalEstudiosJ = $('#ovTotalCampoTestudios').val();//sacamos el subtotal de consulta
		if (totalServiciosJ==0 & totalConsultaJ==0) {pagoOriginal=pagoInicial;}
		//alert("El total de la consulta es "+totalConsultaJ+" El total de Servicios es "+totalServiciosJ);
		//alert("pagoOriginal"+" "+pagoOriginal);
		//alert("pagoInicial"+" "+pagoInicial);
	//calculamos el porcentaje individual del servicio:
	porcentajeEstudioIndividual=(parseFloat(preciosE[x-1])*100)/parseFloat(totalNetoEstudios);
	//alert("El precio Bruto del E es" + preciosE[x-1]+ "el total de todos los E es "+ totalNetoEstudios +"el porcentaje del estudio es" +porcentajeEstudioIndividual);
	
	if( (descuentoEstudios>0 & descuentoEstudios<=100) & !(descuentoGral>0 & descuentoGral<=100) ){
	  totalEstudioReal=redondear(( parseFloat(parseFloat(totalEstudioReal)-(parseFloat(totalEstudioReal)*parseFloat(descuentoEstudios)/100)) )+parseFloat(extras),2);
	}	
	if( (descuentoGral>0 & descuentoGral<=100) & !(descuentoEstudios>0 & descuentoEstudios<=100) ){
		totalEstudioReal=redondear(parseFloat(totalEstudioReal)+parseFloat(extras),2);totalEstudioReal=redondear(parseFloat(totalEstudioReal)-(parseFloat(totalEstudioReal)*parseFloat(descuentoGral)/100),2);
	}
	if(descuentoGral<=0 & descuentoEstudios<=0 ){	totalEstudioReal=redondear(parseFloat(totalEstudioReal)+parseFloat(extras),2);	}
	if( (descuentoEstudios>0 & descuentoEstudios<=100) & (descuentoGral>0 & descuentoGral<=100) ){	
      totalEstudioReal=redondear(( parseFloat(parseFloat(totalEstudioReal)-(parseFloat(totalEstudioReal)*parseFloat(descuentoEstudios)/100)) )+parseFloat(extras),2);
	  totalEstudioReal=redondear(parseFloat(totalEstudioReal)-(parseFloat(totalEstudioReal)*parseFloat(descuentoGral)/100),2);
	}
	
	var sald=0,tipoConcepto = 3;
	pago_pag=redondear(parseFloat((porcentajeEstudioIndividual)*parseFloat(pagoOriginal))/100,2);
	
	sald=redondear(parseFloat(totalOV.val())-parseFloat(pago_pag),2);
	totalOV.val(redondear(sald,2));saldoTov=redondear(totalOV.val(),2);
		
		document.getElementById('ovTotalCampoTpago').value=redondear(parseFloat($('#ovTotalCampoTpago').val())-parseFloat(pago_pag),2);
		document.getElementById('ovTotalCampoTpago').value=redondear(document.getElementById('ovTotalCampoTpago').value,2);
		if(document.getElementById('ovTotalCampoTpago').value<=0.2){
			setTimeout("$('#dialog-confirmacion1').dialog('close');$('#dialog-confirmacion').dialog('open');",2000);
		}
	//alert('El pago inicial total del cliente es de '+pagoInicial+'el total del servicio es '+totalEstudioReal+'el pago del cliente del servicio es de '+pago_pag+'El saldo de la orden de venta quedó en '+saldoTov+'el resto del pago total del paciente es '+document.getElementById('ovTotalCampoTpago').value);
//	
	var datox ={
		claveE : gg[x-1],precioE : preciosE[x-1],numAleatorio : numAleatorio,descuentoEstudios : descuentoEstudios, descuentoGral:descuentoGral,
		idPaciente : idPaciente,idUsuario : idUsuario,claveMedicoE : claveMedicoE,observacionesEstudios : observacionesEstudios,
		fechaEntrega : fechaEntrega, horaEntrega:horaEntrega,tUrgente : tUrgente,tTomaDom : tTomaDom, tEntregaDom: tEntregaDom, 
		subtotalEstudios : subtotalEstudios, totalEstudios : totalEstudios, totalTotal : totalTotal, estadoPago : estadoPago, 
		costoReal : costoReal, ahorroTotal : ahorroTotal, urgencia : urgencia, saldo : saldo, pago : pago,notaDescuentoGralE : notaDescuentoGralE,
		claveMedicoCx : claveMedicoCx,clavePersonalS : clavePersonalS, NoEstudios:NoEstudios, cSucursal:cSucursal,notaDescuentoE:notaDescuentoE,
		//las variables para la tabla pago:
		pago:pago, saldoTov:saldoTov, pago_pag:pago_pag, totalIndividual:totalIndividual, saldoIndividual:saldoIndividual, totalOV:totalOV.val(),
		tipoConcepto:tipoConcepto
	}

	$.post('files-serverside/saveOrdenVentaEstudios.php',datox,processData).error('ouch');//salva los estudios
	x=x-1;//alert(x);
			function processData(data) {//alert(data);
		  		console.log(data);
				if (x>0 && data == "ok"){
					salvarServerSideE(x,departamentos,montos);
					if (x==0){
					}
				}else {}//alert(data);}
       		} // end processData
	//alert("Se guardó el estudio número "+parseInt(x)+parseInt(1));
	if(x==0){return true;}//cuando se terminan de guardar los estudios, retorna true
}
*/
}