<?php
require("../../../Connections/horizonte.php");
require("../../../funciones/php/values.php");

include_once '../../../recursos/session.php';
include_once '../../../Connections/database.php';
include_once '../../../recursos/utilities.php';

$id_del_user = $_SESSION['id'];
?>

<div class="modal-dialog modal-lg" role="document">
<div class="modal-content">
  <div class="modal-header"> <h4 class="modal-title text-dark" id="tituloC"> </h4> </div>
  <div class="modal-body" id="body_modal_compra">
    <table class="table table-hover">
        <thead>
            <th>#</th>
            <th>Producto</th>
            <th>Cantidad</th>
            <th>Entrega</th>
            <th>Precio unitario</th>
            <th>Total</th>
        </thead>
        <tbody id="resumenTable">

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
