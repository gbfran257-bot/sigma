<div class="modal-dialog modal-lg" role="document" style="width: 1000px;">
    <div class="modal-content">
        <div class="modal-header">
            <h3 class="modal-title text-dark" id="titulo_resumen_transferencia">RESUMEN DE TRANSFERENCIA / <?php echo $_POST['usuario_fecha_hora']; ?></h3>
        </div>
        <div class="modal-body" id="body_modal_compra">
            <table class="table table-hover">
                <thead>
                    <th>#</th>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Precio unitario</th>
                    <th>Total</th>
                </thead>
                <tbody id="resumenTable">
                    <?php $transferencias = $_POST['transferencias']; ?>
                    <?php $datos_stock = $_POST['datos_stock']; ?>
                    <?php $total = 0; ?>
                    <?php for ($i = 0; $i < count($transferencias); $i++) : ?>
                        <tr>
                            <td><?php echo $i + 1; ?></td>
                            <td><?php echo $transferencias[$i]['producto']; ?></td>
                            <td><?php echo $datos_stock[$i]['cant']; ?></td>
                            <td>$<?php echo $datos_stock[$i]['precio_unitario']; ?></td>
                            <td><strong>$<?php echo $datos_stock[$i]['total']; ?></strong></td>
                        </tr>
                        <?php $total += intval($datos_stock[$i]['total']); ?>
                    <?php endfor; ?>
                    <tr>
                        <td colspan="4"></td>
                        <td>
                            <strong>$<?php echo $total; ?></strong>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="modal-footer">
            <!-- <button type="submit" class="btn btn-success no_document no_nota no_receta no_fo]]rma_i" form="form-registro" id="btn_agregar">Agregar</button> -->
            <button type="submit" class="btn btn-success hidden" form="form-registro" id="btn_pagar">Pagar</button>
            <button type="button" class="btn btn-warning no_document no_nota no_receta no_forma_i" data-dismiss="modal" id="btn_cancel_registro">Cancelar</button>
        </div>
    </div>
</div>