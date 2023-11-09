<div class="modal-dialog modal-lg" role="document" style="width: 1000px;">
    <div class="modal-content">
        <div class="modal-header">
            <h3 class="modal-title text-dark" id="titulo_modal_ver_factura_compra">Factura de compra</h3>
            <p> Referencia:
                <strong><?php echo $_POST['referencia']; ?></strong>
            </p>
        </div>
        <div class="modal-body" id="">
            <div>
                <?php if ($_POST['compraFacturada']) : ?>
                    <img class="media_comprobante_factura" src="" alt="comprobante_factura">
                <?php else : ?>
                    <div>
                        <label for="comprobante_factura" class="form-label">Comprobante</label>
                        <input class="form-control form-control-lg" id="comprobante_factura" type="file">
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-success no_document no_nota no_receta no_forma_i" form="form-registro" id="btn_agregar">Agregar</button>
            <button type="submit" class="btn btn-success hidden" form="form-registro" id="btn_pagar">Pagar</button>
            <button type="button" class="btn btn-warning no_document no_nota no_receta no_forma_i" data-dismiss="modal" id="btn_cancel_registro">Cancelar</button>
        </div>
    </div>
</div>