<?php
	include_once 'recursos/session.php';
	include_once 'Connections/database.php';
	include_once 'recursos/utilities.php';
	include_once 'recursos/datauser.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="SISTEMA DE EXPEDIENTE CLÍNICO ELECTRÓNICO">
    <meta name="author" content="ING JESUS DIAZ CONTRERAS">
    
    <title>SISTEMA - AGENDA</title>
    
    <link rel="shortcut icon" href="imagenes/favicon.ico" type="image/x-icon">
	<link rel="icon" href="imagenes/favicon.ico" type="image/x-icon">
    
    <!-- Mainly scripts -->
	<script src='fullcalendar/lib/jquery.min.js'></script>
	<script src='fullcalendar/lib/moment.min.js'></script>
    <script src='fullcalendar/lib/jquery-ui.custom.min.js'></script>
    <script src='fullcalendar/fullcalendar.js'></script>
    <script src='fullcalendar/locale/es.js'></script>
    
	<script src="bootstrap/js/bootstrap.min.js"></script>
    <script src="js/plugins/metisMenu/jquery.metisMenu.js"></script>
    <script src="js/plugins/slimscroll/jquery.slimscroll.min.js"></script>
    <!-- Custom and plugin javascript -->
    <script src="js/inspinia.js"></script>
    <script src="js/plugins/pace/pace.min.js"></script>
    <script src="bootstrap-validator/js/validator.js"></script>
    <script src="sweetalert/dist/sweetalert.min.js"></script>
    <script src="chosen/chosen.jquery.js" type="text/javascript"></script>
    <script src="funciones/js/jquery.media.js" type="text/javascript"></script>
    <script src="funciones/js/jquery.printElement.min.js" type="text/javascript"></script>
    <!-- Input Mask-->
    <script src="jasny-bootstrap/js/jasny-bootstrap.min.js"></script> 
    <!-- Mis funciones -->
    <script src="funciones/js/inicio.js"></script>
    <script src="funciones/js/caracteres.js"></script>
    <script src="funciones/js/stdlib.js"></script>
    
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="bootstrap/css/bootstrap-theme.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <link href="sweetalert/dist/sweetalert.css" rel="stylesheet">
    <link rel="stylesheet" href="chosen/chosen.css">
    <link rel="stylesheet" href="chosen/chosen-bootstrap.css">
    <link href="jasny-bootstrap/css/jasny-bootstrap.min.css" rel="stylesheet">
    <link href='fullcalendar/fullcalendar.min.css' rel='stylesheet' />
	<link href='fullcalendar/fullcalendar.print.min.css' rel='stylesheet' media='print' />
    <style> #calendar{ margin: 0 auto; color:black; } </style>
</head>
<?php include_once 'partes/header.php'; ?>
<!-- Contenido -->
	<input name="control" type="hidden" value="1" id="control">
	<input name="quien" type="hidden" value="<?php echo $_SESSION['id']; ?>" id="quien">
	<input name="now1" type="hidden" value="<?php echo date('Y-m-d H:i:s'); ?>" id="now1">
	
	<table id="div_principa" width="100%" height="" class="table-condensed" style="overflow-y: scroll;">
		<tr>
			<td width="25%" valign="top">
				<select data-placeholder="-DEPARTAMENTO-" id="s_departamento" name="s_departamento" class="form-control input-sm chosen-select sarea"></select><br><br>
				<select data-placeholder="-ÁREA-" id="s_area" name="s_area" class="form-control input-sm chosen-select sarea"><option value="" selected>-ÁREA-</option></select><br><br>
				<select data-placeholder="-USUARIO-" id="s_usuario" name="s_usuario" class="form-control input-sm chosen-select susuario"></select>
			</td>
			<td align="center" valign="top"><div id='calendar'></div></td>
		</tr>
	</table>
	<div id="auxiliar" class="hidden"></div> <div id="auxiliar1" class="hidden"></div>
<!-- FIN Contenido -->  
<?php include_once 'partes/footer.php'; ?>

<script>
$(document).ready(function(e) {
	//breadcrumb
	$('#breadc').html('<li><a href="index.php">HOME</a></li><li>RECEPCIÓN</li><li class="active"><strong>AGENDA</strong></li>');
	
	$('#my_search').addClass('hidden');
	$('#div_principa').height($('#referencia').height()-$('#my_footer').height()-$('#my_nav').height()-30-$('#breadc').height());
	$('#calendar').width($('#referencia').height()-$('#my_footer').height()-$('#my_nav').height()-$('#breadc').height()+185);
	
	$("#s_departamento").load('agenda/genera/departamentos.php',function(response,status,xhr){if(status=="success"){
		window.setTimeout(function(){$('#s_departamento').chosen();},300);
	}});
	$("#s_departamento").change(function(e) {
        $("#s_area,#s_usuario").val('');
		$("#s_area").load('agenda/genera/areas.php?idd='+$("#s_departamento").val(),function(response,status,xhr){if(status=="success"){
			$("#s_area").trigger("chosen:updated");
		}});
    });
	$("#s_area").load('agenda/genera/areas.php?idd='+$("#s_departamento").val(),function(response,status,xhr){if(status=="success"){
		window.setTimeout(function(){$('#s_area').chosen();},300);
	}});
	$("#s_area").change(function(e) {
        $("#s_usuario").val(''); $("#s_usuario").trigger("chosen:updated"); $('#control').val(2); $('#quien').val($(this).val());
		
		var events = {
            url: "fullcalendar/demos/php/events.php", type: 'GET', data: { que: 2, quien: $(this).val() }
        }

        $('#calendar').fullCalendar( 'removeEventSource', events);
        $('#calendar').fullCalendar( 'addEventSource', events);         
        $('#calendar').fullCalendar('removeEvents'); $('#calendar').fullCalendar( 'refetchEvents' );
    }).change();
	
	$("#s_usuario").load('agenda/genera/usuarios.php?myidu='+$('#id_user').val(),function(response,status,xhr){if(status=="success"){
		window.setTimeout(function(){$('#s_usuario').chosen();},300); $("#s_usuario, #quien").val($('#id_user').val());
		$("#s_usuario").trigger("chosen:updated");
		
		var events = {
            url: "fullcalendar/demos/php/events.php", type: 'GET', data: { que: 1, quien: $('#id_user').val() }
        }

        $('#calendar').fullCalendar( 'removeEventSource', events);
        $('#calendar').fullCalendar( 'addEventSource', events);         
        $('#calendar').fullCalendar('removeEvents'); $('#calendar').fullCalendar( 'refetchEvents' );
	}});
	
	$("#s_usuario").change(function(e) {
        $("#s_departamento,#s_area").val(''); $("#s_departamento,#s_area").trigger("chosen:updated");
		$("#s_area").load('agenda/genera/areas.php?idd='+$("#s_departamento").val(),function(response,status,xhr){if(status=="success"){
			$("#s_area").trigger("chosen:updated");
		}}); $('#control').val(1); $('#quien').val($(this).val());
		
		var events = {
            url: "fullcalendar/demos/php/events.php", type: 'GET', data: { que: 1, quien: $(this).val() }
        }

        $('#calendar').fullCalendar( 'removeEventSource', events);
        $('#calendar').fullCalendar( 'addEventSource', events);         
        $('#calendar').fullCalendar('removeEvents'); $('#calendar').fullCalendar( 'refetchEvents' );
    }).change();
	
	function fmt(date) { //alert(moment.utc(date).format()); 
	  	if (date == null){ date = $('#starti').val();return moment.utc(date).format() }
		else{ $('#starti').val(date); return moment.utc(date).format() }
    }

    var date = new Date(), d = date.getDate(), m = date.getMonth(), y = date.getFullYear();

    var calendar = $('#calendar').fullCalendar({
        lang: 'es', allDaySlot: false, now: $('#now1').val(), slotDuration: '00:15:00', defaultTimedEventDuration: '00:15:00',
        header: {
          left: 'prev,next today', center: 'title', right: 'month,agendaWeek,agendaDay'
        }, defaultView: 'agendaWeek',
        events: "fullcalendar/demos/php/events.php?que="+$('#control').val()+"&quien="+$('#quien').val(),
		
		allDayDefault: false, eventColor: 'gray', editable:true,
        // Convert the allDay from string to boolean
        eventRender: function(ev, el, v){ if(ev.allDay && ev.end){ ev.end.add(1, 'days'); console.log(ev.end); } },
        selectable: true, selectHelper: true,
        select: function (start, end, allDay) { var start = fmt(start), end = fmt(end); //alert(start+' '+end);
			switch($('#control').val()){
				case '1':
					if($('#s_usuario').val()!=''){//nuevo_evento($('#control').val(),$('#s_usuario').val());
						var fecha = start.split('T'), tiempo = fecha[1].split('Z'), fecha1 = end.split('T'), tiempo1 = fecha1[1].split('Z');
						var para = 'NUEVO EVENTO PARA '+$("#s_usuario option:selected").text()+' FECHA '+fecha[0]+'/'+tiempo[0]+'-'+tiempo1[0];
					}
				break;
				case '2':
					if($('#s_area').val()!=''){//nuevo_evento($('#control').val(),$('#s_area').val());
						var fecha = start.split('T'), tiempo = fecha[1].split('Z'), fecha1 = end.split('T'), tiempo1 = fecha1[1].split('Z');
						var para='NUEVO EVENTO PARA EL ÁREA DE '+$("#s_area option:selected").text()+' DEL DEPARTEMENTO DE '+$("#s_departamento option:selected").text()+' FECHA '+fecha[0]+'/'+tiempo[0]+'-'+tiempo1[0];
					}
				break;
				default: alert('Ha ocurrido un error.');
			}
			
			$("#myModal").load('agenda/htmls/ficha_evento.php', function( response, status, xhr ){ if(status=="success"){
				$('#alerta_1').hide(); $('#title_panel').text(para); $('#estatus_evt, #btn_eliminar_e').remove();
				
				$('#form-principal').validator().on('submit', function (e) {
				  if (e.isDefaultPrevented()) { // handle the invalid form...
					$("#alerta_1").fadeTo(2000,500).slideUp(500,function(){ $("#alerta_1").slideUp(600); });
				  } else { // everything looks good!
					e.preventDefault(); 
					var $btn = $('#btn_new').button('loading'); $('#btn_cancel_new').hide();

					$.ajax({
					  url: 'fullcalendar/demos/php/add_events.php',
					  data: 'title=' + $('#titulo_e').val() + '&start=' + start + '&end=' + end + '&que=' + $('#control').val() + '&quien=' + $('#quien').val() + '&descripcion=' + $('#descripcion_e').val() + '&id_user_r=' + $('#id_user').val(), 
					  type: "POST",
					  success: function (json) {
						  $btn.button('reset'); $('#btn_cancel_new').show(); $('#myModal').modal('hide'); 
						  swal({ title: "", type: "success", text: "El evento ha sido creado.", timer: 1800, showConfirmButton: false });
						  
						  var datosE = {control:$('#control').val(), quien:$('#quien').val()}
						  $.post('agenda/files-serverside/datosE.php',datosE).done(function(data){
						  	var datos = data.split('}[-]{');
							calendar.fullCalendar('renderEvent',{title:datos[1],start:start,end:end,id:datos[0]}, true);// make the event "stick"
						  });
					  }
					});
				  }
				});
		
				$('#myModal').modal('show');
				$('#myModal').on('shown.bs.modal', function(e){ $('#form-principal').validator(); });
				$('#myModal').on('hidden.bs.modal', function (e) { $(".modal-content").remove(); $("#myModal").empty(); });
			}});
          calendar.fullCalendar('unselect');
        },
        eventDrop: function (event, delta) {//document.getElementById('starti').value=event.start;//alert(delta);
			if(event.estatus=='PENDIENTE'){
			  var start = fmt(event.start), end = fmt(event.end); 
			  $.ajax({
				url: 'fullcalendar/demos/php/update_events.php',
				data: 'title=' + event.title + '&start=' + start + '&end=' + end + '&id=' + event.id, type: "POST",
				success: function (json) {
				  //alert("Updated Successfully");
				}
			  });
			}
        },
        eventClick: function (event){ var start = fmt(event.start), end = fmt(event.end); 
			var datosE = {id:event.id}
		    $.post('agenda/files-serverside/datosEvent.php',datosE).done(function(data){
			  var datos = data.split('}[-]{');
			  //calendar.fullCalendar('renderEvent',{title:datos[1],start:start,end:end,id:datos[0]}, true);// make the event "stick"
			  $("#myModal").load('agenda/htmls/ficha_evento.php', function( response, status, xhr ){ if(status=="success"){//alert(datos[3]);
				  if(datos[3]!='PENDIENTE'){$('#btn_eliminar_e, #btn_new').remove();}
				  $('#titulo_modal').text('FICHA DEL EVENTO'); $('#titulo_e').val(datos[1]); $('#descripcion_e').val(datos[2]);
				  $('#btn_hide_modal').removeClass('hidden'); $('#btn_new').text('Aceptar'); $('#estatus_e').val(datos[3]);
				  $('#btn_cancel_new').text('Cerrar');
				  switch(datos[4]){
					case '1':
						var fecha = start.split('T'), tiempo = fecha[1].split('Z'), fecha1 = end.split('T'), tiempo1 = fecha1[1].split('Z');
						var para = 'EVENTO DE '+$("#s_usuario option:selected").text()+' FECHA '+fecha[0]+'/'+tiempo[0]+'-'+tiempo1[0];
					break;
					case '2':
						var fecha = start.split('T'), tiempo = fecha[1].split('Z'), fecha1 = end.split('T'), tiempo1 = fecha1[1].split('Z');
						var para='EVENTO DEL ÁREA DE '+$("#s_area option:selected").text()+' DEL DEPARTEMENTO DE '+$("#s_departamento option:selected").text()+' FECHA '+fecha[0]+'/'+tiempo[0]+'-'+tiempo1[0];
					break;
					default: alert('Ha ocurrido un error.');
				  }
				  $('#alerta_1').hide(); $('#title_panel').text(para);
				  
				  $('#form-principal').validator().on('submit', function (e) {
					  if (e.isDefaultPrevented()) { // handle the invalid form...
						$("#alerta_1").fadeTo(2000,500).slideUp(500,function(){ $("#alerta_1").slideUp(600); });
					  } else { // everything looks good!
						e.preventDefault(); 
						var $btn = $('#btn_new').button('loading'); $('#btn_cancel_new, #btn_eliminar_e').hide();
						var datosEv = {titulo:$('#titulo_e').val(), start:start,end:end, que:$('#control').val(), quien:$('#quien').val(),descripcion:$('#descripcion_e').val(),id_user_r:$('#id_user').val(), estatus:$('#estatus_e').val(), id:event.id}
						$.post('agenda/files-serverside/updateEvento.php',datosEv).done(function(data){
							var datox = data.split(';');
							if(datox[0]==1){
								$('#calendar').fullCalendar('removeEvents', event.id);
								$btn.button('reset'); $('#btn_cancel_new, #btn_eliminar_e').show(); $('#myModal').modal('hide');
								swal({ title: "", type: "success", text: "El evento ha sido actualizado.", timer: 1800, showConfirmButton: false });
								var datosE = {id:event.id}
								$.post('agenda/files-serverside/datosEvent.php',datosE).done(function(data){
									var datos = data.split('}[-]{');
									calendar.fullCalendar('renderEvent',{title:datos[1],start:start,end:end,id:datos[0],color:datos[6]}, true);// make the event "stick"
								});
							}else{alert(datox[0]);}
						});
					  }
					});
					$('#btn_eliminar_e').click(function(e) {
                        swal({
						  title: "ELIMINAR EL EVENTO", text: "Esta acción no se puede deshacer", type: "warning", showCancelButton: true,
						  confirmButtonColor: "#DD6B55", confirmButtonText: "Eliminar", cancelButtonText: "Cancelar", closeOnConfirm: false
						},
						function(){
							$.ajax({
							  type: "POST", url: "fullcalendar/demos/php/delete_event.php", data: "&id=" + event.id,
							  success: function (json) {
								$('#calendar').fullCalendar('removeEvents', event.id); $('#myModal').modal('hide');
								swal({ title: "", type: "success", text: "El evento ha sido eliminado.", timer: 1800, showConfirmButton: false });
							  }
							});
						});
                    });
				
				  $('#myModal').modal('show');
				  $('#myModal').on('shown.bs.modal', function(e){ $('#form-principal').validator(); });
				  $('#myModal').on('hidden.bs.modal', function (e) { $(".modal-content").remove(); $("#myModal").empty(); });
			  }});
		    });
        },
        eventResize: function (event) {
			if(event.estatus=='PENDIENTE'){
			  var start = fmt(event.start), end = fmt(event.end);
			  $.ajax({
				url: 'fullcalendar/demos/php/update_events.php',
				data: 'title=' + event.title + '&start=' + start + '&end=' + end + '&id=' + event.id, type: "POST",
				success: function (json) {
				  //alert("Updated Successfully");
				}
			  });
			}
        }
    });
});

function nuevo_evento(que,quien){
	
}
</script>