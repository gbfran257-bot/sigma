<div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h3 class="modal-title" id="exampleModalLabel">¿Cuántos <?php echo $_POST['nombreProducto']; ?> deseas agregar?</h3>
        </div>
        <div class="modal-body" id="body-agregar-producto">
            <input id="cantidad-productos" type="number" min="1" max="<?php echo htmlspecialchars($_POST['cantidadMaxima']) ?>" step="1" required placeholder="Cantidad" class="form-control" value="1" />
            <span>Para modificar la cantidad es necesario volver a agregar el producto</span>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" id="cancelar-agregar-cantidad-productos" data-dismiss="modal">Cancelar</button>
            <button type="button" class="btn btn-primary" id="agregar-cantidad-producto">Agregar</button>
        </div>
    </div>
</div>