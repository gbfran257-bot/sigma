<div class="modal-dialog modal-lg" role="document" style="width: 1000px;">
    <div class="modal-content">
        <div class="modal-header">
            <h3 class="modal-title text-dark" id="titulo_modal_ver_factura_compra">Factura de compra</h3>
            <?php if ($_POST['nombreFactura']) : ?>
                <p style="font-size: 1.5rem; margin: 0rem;"> Referencia: <strong><?php echo $_POST['referenciaCompra']; ?></strong></p>
                <p style="font-size: 1.5rem; margin: 0rem;"> Usuario: <strong><?php echo $_POST['usuario']; ?></strong></p>
                <p style="font-size: 1.5rem; margin: 0rem;"> Fecha y hora: <strong><?php echo $_POST['fechaHora']; ?></strong></p>
            <?php endif; ?>
        </div>
        <div class="modal-body" id="">
            <div>
                <?php if ($_POST['nombreFactura']) : ?>
                    <img class="media_comprobante_factura" src="" alt="comprobante_factura">
                <?php else : ?>
                    <div>
                        <p>Aún no hay comprobante.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-warning no_document no_nota no_receta no_forma_i" data-dismiss="modal" id="btn_cancel_registro">Cancelar</button>
        </div>
    </div>
</div>