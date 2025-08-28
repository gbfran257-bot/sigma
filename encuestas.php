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
  <title>Cuestionario con caritas</title>
  <script src="js/jquery-3.2.1.js"></script>
  <script src="bootstrap-validator/js/validator.js"></script>
  <script src="sweetalert/dist/sweetalert.min.js"></script>
  <link href="sweetalert/dist/sweetalert.css" rel="stylesheet">
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
  </style>
</head>
<body>
  <div class="cuestionario">
    <h2>Cuestionario de satisfacción</h2>

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
        <?php while ($fila = mysql_fetch_assoc($preguntas)): ?>
            <div class="pregunta">
                <h3><?php echo $fila['pregunta_p']; ?></h3>
                <div class="opciones">
                    <input type="radio" id="<?php echo $fila['clave_p'] . '_feliz'; ?>" name="<?php echo $fila['clave_p']; ?>" value="1" required>
                    <label class="opcion" for="<?php echo $fila['clave_p'] . '_feliz'; ?>"><i class="fa-regular fa-face-smile"></i></label>

                    <input type="radio" id="<?php echo $fila['clave_p'] . '_medio'; ?>" name="<?php echo $fila['clave_p']; ?>" value="2">
                    <label class="opcion" for="<?php echo $fila['clave_p'] . '_medio'; ?>"><i class="fa-regular fa-face-meh"></i></label>

                    <input type="radio" id="<?php echo $fila['clave_p'] . '_triste'; ?>" name="<?php echo $fila['clave_p']; ?>" value="3">
                    <label class="opcion" for="<?php echo $fila['clave_p'] . '_triste'; ?>"><i class="fa-regular fa-face-frown"></i></label>
                </div>
            </div>
        <?php endwhile; ?>

        <button type="submit">Enviar respuestas</button>
    </form>
  </div>
</body>
</html>

<script>
  $('#form-encuesta').validator().on('submit', function (e) {
      if (e.isDefaultPrevented()) { 
            
      } else { 
          e.preventDefault(); 
          var datos = $('#form-encuesta').serialize();
          $.post('pacientes/files-serverside/add_encuesta.php',datos).done(function( data ) {
            if (data==1){
              $("#form-encuesta input[type='radio']").prop("checked", false);
              swal({
                title: "¡CONFIRMACIÓN!", type: "success", text: "La encuesta se ha registrado.",
                timer: 1900, showConfirmButton: false
              }); return;
            } else{alert(data);}
          });
      }
  });
</script>

