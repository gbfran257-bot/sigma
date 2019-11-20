<div class="modal-dialog modal-lg" role="document" id="contenido_ficha_consulta">
    <div class="modal-content animated flipInY">
      <div class="modal-header">
        <button type="button" class="close hidden" data-dismiss="modal" aria-label="Close">
        	<span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title"><strong><span id="titulo_modal"> </span></strong></h4>
      </div>
      <div class="modal-body">
      
      <input name="tamHcanvas" id="tamHcanvas" type="hidden" value="">
	<table width="100%" border="0" cellpadding="0" cellspacing="0">
		<tr>
			<td width="99%" nowrap>
				<ul class="nav nav-tabs">
				  <li role="presentation" class="active" id="t-captura">
					<a href="#tCaptura" aria-controls="tCaptura" role="tab" data-toggle="tab">CAPTURA</a>
				  </li>
				  <li role="presentation" class="hidden" id="t-imagenes">
					<a href="#tImagenes" aria-controls="tImagenes" role="tab" data-toggle="tab">IMÁGENES</a>
				  </li>
				  <li role="presentation" class="hidden" id="t-interpretacion">
					<a href="#tInterpretacion" aria-controls="tInterpretacion"role="tab" data-toggle="tab"id="st-interpretacion">INTERPRETACIÓN</a>
				  </li>
				  <li role="presentation" class="hidden" id="t-estudio">
					<a href="#tEstudio" aria-controls="tEstudio" role="tab" data-toggle="tab">ESTUDIO</a>
				  </li>
				  <li role="presentation" class="hidden" id="t-imagenes1">
					<a href="#tImagenes1" aria-controls="tImagenes1" role="tab" data-toggle="tab">IMÁGENES</a>
				  </li>
				</ul>
			</td>
			<td nowrap>
				<button type='submit' class="btn btn-primary btn-sm hidden" id="guardarE">Guardar</button> 
    			<button type='submit' class="btn btn-success btn-sm hidden" id="finalizarE">Finalizar</button>
        		<button type='button' class="btn btn-primary btn-sm hidden" id="imprimirE">Imprimir</button> 
        		<button type='button' class="btn btn-warning btn-sm" data-dismiss="modal">Salir</button>
			</td>
		</tr>
	</table>
    
    <!-- Tab panes -->
    <div class="tab-content">
        <div role="tabpanel" class="tab-pane active" id="tCaptura"><br>
        	<table width="100%" border="0" cellspacing="0" cellpadding="0" id="tablaVideos" class="table table-condensed table-bordered">
              <tr>
                <td id="celdaVideo" width="60%">
                <table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0" class="table-condensed" id="mi_video_ver">
                  <tr height="1%">
                    <td valign="top">
                    	<button type='button' id="start" class="btn btn-info btn-sm">
                            <i class='fa fa-play' aria-hidden='true'></i> Iniciar video
                        </button>
                        <button type='button' id="capture" class="btn btn-info btn-sm disabled">
                            <i class='fa fa-camera' aria-hidden='true'></i> Capturar imagen
                        </button>
                        <button type='button' id="stop" class="btn btn-warning btn-sm">
                            <i class='fa fa-stop' aria-hidden='true'></i> Finalizar video
                        </button>
                    </td>
                  </tr>
                  <tr> <td id="contenedorVideo" valign="top"><video id="video" autoplay width="" height=""></video></td> </tr>
                </table>
                
                <table class="hidden" id="mi_foto_ver" width="100%" height="100%">
                	<tr height="1px"><td align="right">
                    	<button type='button' id="close_img_ver" class="btn btn-primary btn-xs">
                            <i class='fa fa-close' aria-hidden='true'></i>
                        </button>
                    </td></tr>
                	<tr><td id="foto_ver" align="center"></td></tr>
                </table>
                
                </td>
                <td  id="contenedorCanvas" valign="top" bgcolor="#FFFFFF">
                <div id="divCanvas">
                <table width="100%" border="0" cellspacing="0" cellpadding="2">
                  <tr> <td id="deCanvas" align="center" valign="top" align="center"></td> </tr>
                </table>
                </div>
                </td>
              </tr>
            </table>
        </div>
        <div role="tabpanel" class="tab-pane" id="tImagenes"><br>
        	<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0" class="">
              <tr> <td id="imagenesEndo" valign="top" height="1%" style="padding-bottom:6px; padding-top:6px;"></td> </tr>
          </table>
        </div>
        <div role="tabpanel" class="tab-pane" id="tInterpretacion"><br>
        	<form action="" method="post" name="formEstudio" id="formEstudio" target="_self">
            	<input name="idEstudioE" type="hidden" id="idEstudioE">
            	<input style="height:90px; resize:none;" name="input" id="input" type="text" class="required"> 
            	<input name="miDiagnostico" id="miDiagnostico" type="hidden">
          	</form>
        </div>
        <div role="tabpanel" class="tab-pane" id="tEstudio"><br>
        	<div id="gallery" style="display:none;"> </div>
        </div>
        <div role="tabpanel" class="tab-pane" id="tImagenes1"><br>
        	<canvas id="miFotoX" width="500" height="375"></canvas> <canvas id="miFotoX1" width="200" height="150"></canvas>
        </div>
    </div>
      
  </div>
</div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->