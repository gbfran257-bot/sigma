<div class="modal-dialog modal-lg" role="document" style="width: 1000px;">
    <div class="modal-content">
        <div class="modal-header">
            <h2 class="modal-title text-dark" id="titulo_modal_ver_factura_compra">Archivo digital</h2>
        </div>
        <div class="modal-body" id="">
            <div>
                <?php if ($_POST['if_exist_file'] || $_POST['if_exist_file_encuesta']) : ?>
                    <img class="media_archivo_consultas" src="" alt="achivo_consultas">
                <?php else : ?>
                    <div>
                        <form name="subirAr" id="subirAr" method="POST" enctype="multipart/form-data">
                            <label for="archivo_consultas" class="form-label">Seleccione su archivo</label>
                            <br>
                            <span>Seleccione el archivo PDF, imagen JPG o PNG.</span>
                            <input class="form-control form-control-lg" id="archivo_consultas" type="file" accept=".pdf, .png, .jpg">
                        </form>
                    </div>
                <?php endif; ?>
            </div>
            
        </div>
        <div class="modal-footer">
            <?php if ($_POST['if_exist_file']) : ?>
                <button id="eliminar_archivo_consultas" type="button" class="btn btn-danger" onclick="eliminarArchivoConsultas('<?php echo $_POST['id_consulta']; ?>');"><i class="fa fa-trash"></i> Eliminar</button>
            <?php endif; ?>
            <?php if ($_POST['if_exist_file_encuesta']) : ?>
                <button id="eliminarArchivoEncuestas" type="button" class="btn btn-danger" onclick="eliminarArchivoEncuestas('<?php echo $_POST['id_consulta']; ?>');"><i class="fa fa-trash"></i> Eliminar</button>
            <?php endif; ?>
            <button type="button" class="btn btn-warning no_document no_nota no_receta no_forma_i" data-dismiss="modal" id="btn_cancel_registro">Cancelar</button>
        </div>
    </div>
</div>