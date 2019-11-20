<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
	<title>File uploader</title>
	<script src="../jquery/jquery-1.8.2.js" type="text/javascript"></script>
	<script src="axuploader.js" type="text/javascript"></script>
    <script src="../funciones/js/retardo.js" type="text/javascript"></script>
	<script>
	$(document).ready(function(){
		var xx=$('#suck');
		$('.prova').axuploader({
			url:'upload.php',
			success:function(a,b){
				$('.prova').axuploader('clear'); $('#debug').html('<span class="aviso">El archivo se cargó correctamente.</span>'); 
				document.querySelector('.prova form').reset();retardo(30000);
			},
			finish:function(x,files){ //se ejecuta al terminar de subir el archivo
				parent.parentt(document.getElementById('idIcono').value, document.getElementById('suck').value, document.getElementById('t').value, document.getElementById('y').value);
			},
			enable:true,
			data:function(){
				xx=document.getElementById('suck').value;
				return 'miId='+xx;
			},
			remotePath:function(){
				return 'up_files/';
			}
		});
	});
	</script>
</head>

<body>

<div class="prova" style="color:white"></div>
<?php // echo $_GET['tu']; ?>
<input name="suck" id="suck" type="hidden" value="<?php echo $_GET['tu']; ?>" />
<input name="idIcono" id="idIcono" type="hidden" value="<?php echo $_GET['idIcono']; ?>" />
<input name="t" id="t" type="hidden" value="<?php echo $_GET['t']; ?>" />
<input name="y" id="y" type="hidden" value="<?php echo $_GET['y']; ?>" />
	<!--<input type="button" onclick="$('.prova').axuploader('disable')" value="asd" />
	<input type="button" onclick="$('.prova').axuploader('enable')" value="ok" /> -->
<div id="debug"></div>
</body>
</html>
<style>
* {	font-family:Helvetica, sans-serif, Arial;}
.aviso{ color:red; font-weight:bolder; font-size:22px; font-variant:small-caps;}
</style>