<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Documento sin título</title>
<script src="../jquery-ui-1.12.0/external/jquery/jquery.js"></script>
<script src="js/tinymce/tinymce.min.js"></script>
<script>
        tinymce.init({selector:'textarea'});
</script>
</head>

<body>
<textarea style="width:100%; height:300px" name="chile" id="chile"></textarea>
<br>
</body>
</html>
<script>
function hola(){
	return tinyMCE.get('chile').getContent();
}
</script>