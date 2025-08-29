<?php
    require("Connections/horizonte.php");
    require("funciones/php/values.php"); 

    mysql_select_db($database_horizonte, $horizonte); 
    $preguntas = mysql_query("SELECT * FROM preguntas_encuesta WHERE clave_e = 1",$horizonte) or die (mysql_error());
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>encuesta</title>
  <script src="js/jquery-3.2.1.js"></script>
  <script src="bootstrap-validator/js/validator.js"></script>
  <script src="sweetalert/dist/sweetalert.min.js"></script>
  <link href="sweetalert/dist/sweetalert.css" rel="stylesheet">
  <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <!-- Iconos de Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #f4f6f9;
      padding: 20px;
    }
    .cuestionario {
      max-width: 600px;
      margin: auto;
      background: #fff;
      padding: 20px;
      border-radius: 12px;
      box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }
    .pregunta {
      margin-bottom: 25px;
    }
    .pregunta h3 {
      font-size: 18px;
      margin-bottom: 10px;
      color: #333;
    }
    .opciones {
      display: flex;
      gap: 20px;
    }
    .opcion {
      cursor: pointer;
      font-size: 28px;
      color: #bbb;
      transition: transform 0.2s, color 0.2s;
    }
    .opcion:hover {
      transform: scale(1.2);
    }
    input[type="radio"] {
      display: none;
    }
    input[type="radio"]:checked + label {
      color: #0077ff;
    }
    button {
      display: block;
      width: 100%;
      padding: 12px;
      font-size: 16px;
      background: #0077ff;
      color: #fff;
      border: none;
      border-radius: 8px;
      cursor: pointer;
      transition: background 0.3s;
    }
    button:hover {
      background: #005fcc;
    }

    /* Tooltip */
    .nuevotitle::after {
      content: attr(data-title);
      position: absolute;
      bottom: 120%; /* arriba del botón */
      left: 50%;
      transform: translateX(-50%);
      background: #4D4D4D;
      color: white;
      padding: 6px 10px;
      border-radius: 6px;
      font-size: 14px;
      opacity: 0;
      white-space: nowrap;
      pointer-events: none;
      transition: opacity 0.3s;
    }

    /* Flecha */
    .nuevotitle::before {
      content: "";
      position: absolute;
      bottom: 90%;
      left: 50%;
      transform: translateX(-50%);
      border: 6px solid transparent;
      border-top-color: black;
      opacity: 0;
      transition: opacity 0.3s;
    }

    .nuevotitle:hover::after,
    .nuevotitle:hover::before {
      opacity: 1;
    }
    /* Tooltip */
  </style>
</head>
<body>
  <div class="cuestionario">
    <h2 id="titulo_encuesta" name="titulo_encuesta">Cuestionario de satisfacción</h2>
    <div class="alert alert-warning text-center hidden" role="alert" id="alerta_encuesta" name="alerta_encuesta">
      <h2 class="alert-heading">Esta encuesta ya fue realizada.</h2>
      <h3>Favor de cerrar esta ventana.</h3>
    </div>


    <!-- <div class="pregunta">
      <h3>1. ¿Qué tan satisfecho estás con el servicio?</h3>
      <div class="opciones">
        <input type="radio" id="p1_feliz" name="p1">
        <label class="opcion" for="p1_feliz"><i class="fa-regular fa-face-smile"></i></label>

        <input type="radio" id="p1_medio" name="p1">
        <label class="opcion" for="p1_medio"><i class="fa-regular fa-face-meh"></i></label>

        <input type="radio" id="p1_triste" name="p1">
        <label class="opcion" for="p1_triste"><i class="fa-regular fa-face-frown"></i></label>
      </div>
    </div> -->
    <form method="POST" name="form-encuesta" id="form-encuesta">
      <input id="idp" name="idp" type="hidden" value="">
      <input id="idu" name="idu" type="hidden" value="">
      <input id="ref" name="ref" type="hidden" value="">
      <?php while ($fila = mysql_fetch_assoc($preguntas)): ?>
        <div class="pregunta">
            <h3><?php echo $fila['pregunta_p']; ?></h3>
            <div class="opciones">
                <input type="radio" id="<?php echo $fila['clave_p'] . '_feliz'; ?>" name="<?php echo $fila['clave_p']; ?>" value="1" required>
                <label data-title="Bueno." class="opcion nuevotitle" for="<?php echo $fila['clave_p'] . '_feliz'; ?>"><i class="fa-regular fa-face-smile"></i></label>

                <input type="radio" id="<?php echo $fila['clave_p'] . '_medio'; ?>" name="<?php echo $fila['clave_p']; ?>" value="2">
                <label data-title="Regular." class="opcion nuevotitle" for="<?php echo $fila['clave_p'] . '_medio'; ?>"><i class="fa-regular fa-face-meh"></i></label>

                <input type="radio" id="<?php echo $fila['clave_p'] . '_triste'; ?>" name="<?php echo $fila['clave_p']; ?>" value="3">
                <label data-title="Malo." class="opcion nuevotitle" for="<?php echo $fila['clave_p'] . '_triste'; ?>"><i class="fa-regular fa-face-frown"></i></label>
            </div>
        </div>
      <?php endwhile; ?>
      <div class="mb-3">
        <h3>Comentarios</h3>
        <textarea class="form-control" style="width: 100%;" id="comentarios" name="comentarios" rows="4" placeholder="Escribe aquí tus comentarios..."></textarea>
      </div>
      <br>
      <button type="submit">Enviar respuestas</button>
    </form>
  </div>
</body>
</html>

<script>
  $(document).ready(function(e) {

    window.setTimeout(function() {
      // Obtiene toda la query string de la URL actual
      let params = new URLSearchParams(window.location.search);
      $("#idp").val(params.get("patid"));
      $("#idu").val(params.get("usid"));
      $("#ref").val(params.get("reftarget"));

      var datosenc = {ref:params.get("reftarget")}
      $.post('pacientes/files-serverside/revisar_encuesta.php',datosenc).done(function( dataenc ) {
        if(dataenc==1){
          $("#titulo_encuesta").addClass("hidden");
          $("#alerta_encuesta").removeClass("hidden");
        }
      });
    }, 500);

  });

  $('#form-encuesta').validator().on('submit', function (e) {
      if (e.isDefaultPrevented()) { 
            
      } else { 
          e.preventDefault(); 
          var datos = $('#form-encuesta').serialize();
          $.post('pacientes/files-serverside/add_encuesta.php',datos).done(function( data ) {
            if (data==1){
              $("#form-encuesta input[type='radio']").prop("checked", false);
              $("#titulo_encuesta").addClass("hidden");
              $("#alerta_encuesta").removeClass("hidden");
              swal({
                title: "¡CONFIRMACIÓN!", type: "success", text: "La encuesta se ha registrado.",
                timer: 1900, showConfirmButton: false
              }); return;
            } else{
              swal({
                title: "Advertencia", type: "warning", text: data,
                timer: 1900, showConfirmButton: false
              }); return;
            }
          });
      }
  });
</script>

