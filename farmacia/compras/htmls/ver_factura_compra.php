<div class="modal-dialog modal-lg" role="document" style="width: 1000px;">
    <div class="modal-content">
        <div class="modal-header">
            <h2 class="modal-title text-dark" id="titulo_modal_ver_factura_compra">Factura de compra</h2>
            <?php if ($_POST['compraFacturada']) : ?>
                <p style="font-size: 1.5rem; margin: 0rem;"> Referencia: <strong><?php echo $_POST['referencia']; ?></strong></p>
                <p style="font-size: 1.5rem; margin: 0rem;"> Usuario: <strong><?php echo $_POST['usuario']; ?></strong></p>
                <p style="font-size: 1.5rem; margin: 0rem;"> Fecha y hora: <strong><?php echo $_POST['fecha_hora']; ?></strong></p>
            <?php endif; ?>
        </div>
        <div class="modal-body" id="">
            <div>
                <?php if ($_POST['compraFacturada']) : ?>
                    <img class="media_comprobante_factura" src="" alt="comprobante_factura">
                <?php elseif ($_POST['transferencias']) : ?>
                    <div>
                        <p>Aún no hay comprobante.</p>
                    </div>
                <?php else : ?>
                    <div>
                        <label for="comprobante_factura" class="form-label">Comprobante</label>
                        <input class="form-control form-control-lg" id="comprobante_factura" type="file">
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <div class="modal-footer">
            <?php if (!$_POST['transferencias'] && $_POST['compraFacturada']) : ?>
                <button id="eliminar_factura_compra" type="button" class="btn btn-danger" onclick="eliminarFacturaCompra('<?php echo $_POST['referencia']; ?>');"><i class="fa fa-trash"></i> Eliminar</button>
            <?php endif; ?>
            <button type="button" class="btn btn-warning no_document no_nota no_receta no_forma_i" data-dismiss="modal" id="btn_cancel_registro">Cancelar</button>
        </div>
    </div>
</div>