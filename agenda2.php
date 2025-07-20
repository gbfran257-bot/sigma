<?php

/** https://github.com/icodeart/Calendario-Bootstrap-php-mysql **/

// Definimos nuestra zona horaria
date_default_timezone_set("America/Santiago");

// incluimos el archivo de funciones
include './agenda2/funciones.php';

// incluimos el archivo de configuracion
include './agenda2/config.php';

// Verificamos si se ha enviado el campo con name from
if (isset($_POST['from'])) 
{

    // Si se ha enviado verificamos que no vengan vacios
    if ($_POST['from']!="" AND $_POST['to']!="") 
    {

        // Recibimos el fecha de inicio y la fecha final desde el form
        $Datein                    = date('d/m/Y H:i:s', strtotime($_POST['from']));
        $Datefi                    = date('d/m/Y H:i:s', strtotime($_POST['to']));
        $inicio = _formatear($Datein);
        // y la formateamos con la funcion _formatear

        $final  = _formatear($Datefi);

        // Recibimos el fecha de inicio y la fecha final desde el form
        $orderDate                      = date('d/m/Y H:i:s', strtotime($_POST['from']));
        $inicio_normal = $orderDate;

        // y la formateamos con la funcion _formatear
        $orderDate2                      = date('d/m/Y H:i:s', strtotime($_POST['to']));
        $final_normal  = $orderDate2;

        // Recibimos los demas datos desde el form
        $titulo = evaluar($_POST['title']);

        // y con la funcion evaluar
        $body   = evaluar($_POST['event']);

        // reemplazamos los caracteres no permitidos
        $clase  = evaluar($_POST['class']);

        /* Valores agregados para agenda medica */
        $id_departamento  = evaluar($_POST['id_departamento']);
        $id_doctor  = evaluar($_POST['id_doctor']);
        $telefono_paciente  = evaluar($_POST['telefono_paciente']);
        $telefono_paciente = preg_replace('/\D/', '', $telefono_paciente); // \D significa "todo lo que no sea un dígito"
        $email_doctor  = evaluar($_POST['email_doctor']);
        $nombre_paciente  = evaluar($_POST['nombre_paciente']);
        $direccion_paciente  = evaluar($_POST['direccion_paciente']);
        $email_paciente  = evaluar($_POST['email_paciente']);
        $telefono_doctor  = evaluar($_POST['telefono_doctor']);
        $telefono_doctor = preg_replace('/\D/', '', $telefono_doctor); // \D significa "todo lo que no sea un dígito"
        $editando  = evaluar($_POST['editando']);

        if($editando == 0){
            // insertamos el evento
            $query="INSERT INTO agenda VALUES(null,'$titulo','$body','','$clase','$inicio','$final','$inicio_normal','$final_normal','$id_departamento','$id_doctor','$telefono_paciente','$email_doctor','$nombre_paciente','$direccion_paciente','$email_paciente','$telefono_doctor')";

            // Ejecutamos nuestra sentencia sql
            $conexion->query($query)or die('<script type="text/javascript">alert("Horario No Disponible ")</script>');

            // Obtenemos el ultimo id insetado
            $im=$conexion->query("SELECT MAX(id) AS id FROM agenda");
            $row = $im->fetch_row();  
            $id = trim($row[0]);

            // para generar el link del evento
            $link = "$base_url"."descripcion_evento.php?id=$id";

            // y actualizamos su link
            $query="UPDATE agenda SET url = '$link' WHERE id = $id";

            // Ejecutamos nuestra sentencia sql
            $conexion->query($query); 
        }else{
            // Actualizamos el evento
            $query="UPDATE agenda SET title = '$titulo', body = '$body', class = '$clase', start = '$inicio', end = '$final', inicio_normal = '$inicio_normal', final_normal = '$final_normal', id_departamento = '$id_departamento', id_doctor = '$id_doctor', telefono_paciente = '$telefono_paciente', email_doctor = '$email_doctor', nombre_paciente = '$nombre_paciente', direccion_paciente = '$direccion_paciente', email_paciente = '$email_paciente', telefono_doctor = '$telefono_doctor' WHERE id = $editando";
            //var_dump($query);
            $conexion->query($query)or die('<script type="text/javascript">alert("Error ")</script>');
        }

       

    }
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Calendario</title>
    <link rel="stylesheet" type="text/css" href="<?=$base_url?>css/bootstrap.min.css">
    <link rel="stylesheet" href="<?=$base_url?>css/calendar.css">
    <link href="<?=$base_url?>css/font-awesome.min.css" rel="stylesheet">
    <script type="text/javascript" src="<?=$base_url?>js/es-ES.js"></script>
    <script src="<?=$base_url?>js/jquery.min.js"></script>
    <script src="<?=$base_url?>js/moment.js"></script>
    <script src="<?=$base_url?>js/bootstrap.min.js"></script>
    <script src="<?=$base_url?>js/bootstrap-datetimepicker.js"></script>
    <link rel="stylesheet" href="<?=$base_url?>css/bootstrap-datetimepicker.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    
</head>
</head>
<body style="background: white;">
    <div class="container">
        <div class="row">
            <!--<div class="page-header"><h4></h4></div>-->
            <div class="pull-left form-inline"><br>
                <button class="btn btn-primary" style="margin-right:30px;" id="regresar" name="regresar">Regresar</button>
            </div>
            <div class="pull-left form-inline"><br>
                <div class="btn-group">
                    <button class="btn btn-primary" data-calendar-nav="prev"><i class="fa fa-arrow-left"></i>  </button>
                    <button class="btn" data-calendar-nav="today">Hoy</button>
                    <button class="btn btn-primary" data-calendar-nav="next"><i class="fa fa-arrow-right"></i>  </button>
                </div>
                <div class="btn-group">
                    <button class="btn btn-warning" data-calendar-view="year">Año</button>
                    <button class="btn btn-warning active" data-calendar-view="month">Mes</button>
                    <button class="btn btn-warning" data-calendar-view="week">Semana</button>
                    <button class="btn btn-warning" data-calendar-view="day">Dia</button>
                </div>
            </div>
            <div class="pull-right form-inline"><br>
                <button class="btn btn-info" data-toggle='modal' data-target='#add_evento' id="mostrar_modal_nuevo">Añadir Evento</button>
            </div>
        </div>
        <br><br><br>
        <div class="row">
            <div id="calendar"></div> <!-- Aqui se mostrara nuestro calendario -->
            
        </div>
        <!--ventana modal para el calendario-->
        <div class="modal fade" id="events-modal">
            <div class="modal-dialog">
                <div class="modal-content">
                       <div class="modal-header">
                        <a href="#" data-dismiss="modal" style="float: right;"> <i class="glyphicon glyphicon-remove "></i> </a>
                        <br>
                    </div>
                    <div class="modal-body" style="height: 400px">
                        <p>One fine body&hellip;</p>
                    </div>
                 
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
    </div>

    <script src="<?=$base_url?>js/underscore-min.js"></script>
    <script src="<?=$base_url?>js/calendar.js"></script>
    <script type="text/javascript">
        (function($){
                //creamos la fecha actual
                var date = new Date();
                var yyyy = date.getFullYear().toString();
                var mm = (date.getMonth()+1).toString().length == 1 ? "0"+(date.getMonth()+1).toString() : (date.getMonth()+1).toString();
                var dd  = (date.getDate()).toString().length == 1 ? "0"+(date.getDate()).toString() : (date.getDate()).toString();

                //establecemos los valores del calendario
                var options = {

                    // definimos que los agenda se mostraran en ventana modal
                    modal: '#events-modal', 

                        // dentro de un iframe
                        modal_type:'iframe',    

                        //obtenemos los agenda de la base de datos
                        events_source: '<?=$base_url?>obtener_eventos.php', 

                        // mostramos el calendario en el mes
                        view: 'month',             

                        // y dia actual
                        day: yyyy+"-"+mm+"-"+dd,   


                        // definimos el idioma por defecto
                        language: 'es-ES', 

                        //Template de nuestro calendario
                        tmpl_path: '<?=$base_url?>tmpls/', 
                        tmpl_cache: false,


                        // Hora de inicio
                        time_start: '08:00', 

                        // y Hora final de cada dia
                        time_end: '22:00',   

                        // intervalo de tiempo entre las hora, en este caso son 30 minutos
                        time_split: '30',    

                        // Definimos un ancho del 100% a nuestro calendario
                        width: '100%', 

                        onAfterEventsLoad: function(events)
                        {
                            if(!events)
                            {
                                return;
                            }
                            var list = $('#eventlist');
                            list.html('');

                            $.each(events, function(key, val)
                            {
                                $(document.createElement('li'))
                                .html('<a href="' + val.url + '">' + val.title + '</a>')
                                .appendTo(list);
                            });
                        },
                        onAfterViewLoad: function(view)
                        {
                            $('#page-header').text(this.getTitle());
                            $('.btn-group button').removeClass('active');
                            $('button[data-calendar-view="' + view + '"]').addClass('active');
                        },
                        classes: {
                            months: {
                                general: 'label'
                            }
                        }
                    };


                // id del div donde se mostrara el calendario
                var calendar = $('#calendar').calendar(options); 

                $('.btn-group button[data-calendar-nav]').each(function()
                {
                    var $this = $(this);
                    $this.click(function()
                    {
                        calendar.navigate($this.data('calendar-nav'));
                    });
                });

                $('.btn-group button[data-calendar-view]').each(function()
                {
                    var $this = $(this);
                    $this.click(function()
                    {
                        calendar.view($this.data('calendar-view'));
                    });
                });

                $('#first_day').change(function()
                {
                    var value = $(this).val();
                    value = value.length ? parseInt(value) : null;
                    calendar.setOptions({first_day: value});
                    calendar.view();
                });
            }(jQuery));

            /* $(document).on('click', 'span[data-cal-date]', function() {
    const fecha = $(this).data('cal-date');
    alert('Fecha seleccionada: ' + fecha);
}); */

        $('#regresar').on('click', function() {
            window.location.href = 'index.php';
        });

        $(document).ready(function() {
            $('#id_doctor').select2({
                placeholder: "Elige un Doctor",
                allowClear: true,
                width: '100%', // para que no se desborde
                minimumResultsForSearch: 0,
                dropdownParent: $('#add_evento') // o el id de tu modal
            }).on('change', function () {
                let valor1 = $(this).val();
                var datos1 = { id_e_d:valor1 }
                $.post('agenda2/obtener_email_doctor.php', datos1).done(function(data1) {
                    var datosD = data1.split(';}');
                    if (data1) { 
                        $("#email_doctor").val(datosD[0]);
                    return;
                    } else {
                        alert(data1);
                    }
                });
            });

            $('#id_doctor').load('pacientes/genera/medicos_estudios.php', function(response, status, xhr) {
                if (status == "success") {
                    
                }
			});

            $('#id_paciente').select2({
                placeholder: "Elige un paciente",
                allowClear: true,
                width: '100%',
                minimumResultsForSearch: 0,
                dropdownParent: $('#add_evento') 
            }).on('change', function () {
                let valor = $(this).val();
                var datos = { id_p:valor }
                $.post('agenda2/obtener_datos_paciente.php', datos).done(function(data) {
                    var datosP = data.split(';}');
                    if (data) { 
                        $("#telefono_paciente").val(datosP[0]);
                        $("#nombre_paciente").val(datosP[1]);
                        $("#direccion_paciente").val(datosP[2]);
                        $("#email_paciente").val(datosP[3]);
                    return;
                    } else {
                        alert(data);
                    }
                });
            });

            $('#id_paciente').load('agenda2/lista_pacientes.php', function(response, status, xhr) {
                if (status == "success") {
                    
                }
			});

            $("#mostrar_modal_nuevo").on('click', function() {
                $("#btn_nuevo").removeClass('hidden');
            });
            
            });
            
            function editar_evento(id){
                $('#add_evento').modal('show');
                $("#editando").val(id);
                //$("#btn_nuevo").addClass('hidden');
              
                var datosAgenda = { id:id }
                $.post('agenda2/obtener_datos_agenda.php', datosAgenda).done(function(dataAgenda) {
                    var datosA = dataAgenda.split(';}');
                    if (dataAgenda) { 
                        $("#telefono_paciente").val(datosA[0]);
                        $("#nombre_paciente").val(datosA[1]);
                        $("#direccion_paciente").val(datosA[2]);
                        $("#email_paciente").val(datosA[3]);
                        $("#id_departamento").val(datosA[6]);
                        $('#id_doctor').val(datosA[7]).trigger('change');
                        $("#telefono_doctor").val(datosA[8]); 

                        window.setTimeout(function() {
                            $("#email_doctor").val(datosA[9]);
						}, 800);

                        $("#title").val(datosA[10]);
                        $("#body").val(datosA[11]);
                        $("#tipo").val(datosA[12]);

                        /* var fecha_inicio = moment(datosA[4], 'DD-MM-YYYY HH:mm:ss');
                        $('#from').datetimepicker('setDate', fecha_inicio.toDate());
                        $('#from input').val(fecha_inicio.format('MM/DD/YYYY HH:mm:ss'));

                        var fecha_fin = moment(datosA[5], 'DD-MM-YYYY HH:mm:ss');
                        $('#to').datetimepicker('setDate', fecha_fin.toDate());
                        $('#to input').val(fecha_fin.format('MM/DD/YYYY HH:mm:ss')); */
                    return;
                    } else {
                        alert(dataAgenda);
                    }
                });
            }



        </script>

        <div class="modal fade" id="add_evento" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Agregar nuevo evento</h4>
            </div>
            <div class="modal-body">
                <form action="" method="post">
                    <!-- campos agregados para agenda medica -->
                    <input type="text" id="editando" name="editando" value="0" class="hidden">
                    <label for="id_paciente">Paciente (Opcional)</label>
                    <select class="form-control" name="id_paciente" id="id_paciente">
                    </select>
                    <hr style="border: none; height: 1px; background-color: orange;">

                    <label for="id_departamento">Departamento</label>
                    <select class="form-control" name="id_departamento" id="id_departamento" required>
                        <option value="" disabled selected hidden>Elige un departamento</option>
                        <option value="4">ASOCIACION MEDICA</option>
                        <option value="2">IMAGEN</option>
                        <option value="1">LABORATORIO</option>
                        <option value="3">FARMACIA</option>
                    </select>
                    <br>

                    <label for="id_doctor">Doctor</label>
                        <select class="form-control" name="id_doctor" id="id_doctor" required>
                    </select>
                    <br>
                    <br>

                    <label for="telefono_doctor">Teléfono Doctor</label>
                    <input type="text" required autocomplete="off" name="telefono_doctor" class="form-control" id="telefono_doctor" placeholder="Introduce un Teléfono">
                    <br>

                    <label for="email_doctor">Email Doctor</label>
                    <input type="email" autocomplete="off" name="email_doctor" class="form-control" id="email_doctor" placeholder="Introduce un Email">

                    <hr style="border: none; height: 1px; background-color: orange;">

                    <label for="nombre_paciente">Nombre Paciente</label>
                    <input type="text" required autocomplete="off" name="nombre_paciente" class="form-control" id="nombre_paciente" placeholder="Introduce un Nombre">
                    <br>

                    <label for="email_paciente">Email Paciente</label>
                    <input type="email" autocomplete="off" name="email_paciente" class="form-control" id="email_paciente" placeholder="Introduce un Email">
                    <br>

                    <label for="telefono_paciente">Teléfono Paciente</label>
                    <input type="text" required autocomplete="off" name="telefono_paciente" class="form-control" id="telefono_paciente" placeholder="Introduce un Teléfono">
                    <br>

                    <label for="direccion_paciente">Dirección Paciente</label>
                    <input type="text" autocomplete="off" name="direccion_paciente" class="form-control" id="direccion_paciente" placeholder="Introduce una Dirección">

                    <hr style="border: none; height: 1px; background-color: orange;">
                    <!--  -->
                    <label for="from">Inicio</label>
                    <div class='input-group date' id='from'>
                        <input type='text' id="from" name="from" class="form-control" readonly />
                        <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span>
                    </div>
                    <br>

                    <label for="to">Final</label>
                    <div class='input-group date' id='to'>
                        <input type='text' name="to" id="to" class="form-control" readonly />
                        <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span>
                    </div>
                    <br>

                    <label for="tipo">Color de evento</label>
                    <select class="form-control" name="class" id="tipo">
                        <option value="event-info">Azul</option>
                        <option value="event-success">Verde</option>
                        <option value="event-important">Rojo</option>
                        <option value="event-warning">Amarillo</option>
                        <option value="event-special">Morado</option>
                    </select>
                    <br>


                    <label for="title">Título</label>
                    <input type="text" required autocomplete="off" name="title" class="form-control" id="title" placeholder="Introduce un título">
                    <br>


                    <label for="body">Descripción</label>
                    <textarea id="body" name="event" required class="form-control" rows="3"></textarea>

                    <script type="text/javascript">
                        $(function () {
                            $('#from').datetimepicker({
                                language: 'es',
                                minDate: new Date()
                            });
                            $('#to').datetimepicker({
                                language: 'es',
                                minDate: new Date()
                            });

                        });
                    </script>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Cancelar</button>
                  <button type="submit" class="btn btn-success" id="btn_nuevo"><i class="fa fa-check"></i> Agregar</button>
              </form>
          </div>
      </div>
  </div>
</div>
</body>
</html>
