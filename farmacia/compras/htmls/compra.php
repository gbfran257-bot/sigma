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
  <div class="modal-header"> <h4 class="modal-title text-dark" id="registroModalLabel">NUEVA COMPRA </h4> </div>
  <div class="modal-body" id="body_modal_compra">
    <form action="">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item active " id="tab_mi_grales">
                <a class="nav-link" id="compra-tab" data-toggle="tab" href="#t_compra" role="tab" aria-controls="generales" aria-expanded="true">COMPRA</a>
            </li>
            <li class="nav-item " id="tab_mi_dir">
                <a class="nav-link" id="resumen-tab" data-toggle="tab" href="#t_resumen" role="tab" aria-controls="direccion">RESUMEN</a>
            </li>
        </ul>
        <div class="tab-pane active tap-pane-primary" id="t_compra" role="tabpanel" aria-labelledby="compra-tab"><br>
            <div class="row">
                <div class="form-group col-md-4 col-sm-4 text-primary">
                    <label for="producto" class="col-form-label">*PRODUCTO</label>
                    <div style="display:flex;">
                        <select class="form-control form-control-sm" name="producto" id="producto"></select>
                        <button style="margin-left:10px;" class="btn btn-primary"><i class="fa fa-plus"></i> Producto</button>
                    </div>
                    <div class="help-block with-errors"></div>
                </div>
                <div class="form-group col-md-4 col-sm-4 text-primary">
                    <!-- <label  id='productoName'  class="col-form-label"></label> <br>
                    <label id="precioPublicoProd" class="col-form-label"></label> -->
                </div>
                <div class="form-group col-md-4 col-sm-4 text-primary">
                    <label  id='productoName'  class="col-form-label"></label> <br>
                    <label id="precioPublicoProd" class="col-form-label"></label>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-4 col-sm-4 text-primary">
                    <label for="costoU" class="col-form-label">* COSTO UNITARIO</label>
                    <input name="costoU" id="costoU" type="Number" class="form-control form-control-sm" required placeholder="Costo unitario">
                    <div id="costoAlert" class="help-block with-errors"></div>
                </div>
                <div class="form-group col-md-4 col-sm-4 text-primary">
                    <label for="cantidad" class="col-form-label">*CANTIDAD</label>
                    <input name="cantidad" id="cantidad" type="number" class="form-control form-control-sm" placeholder="Cantidad">
                    <div class="help-block with-errors"></div>
                </div>
                <div class="form-group col-md-4 col-sm-4 text-primary">
                    <label for="lote" class="col-form-label">LOTE</label>
                    <input name="lote" id="lote" type="text" class="form-control form-control-sm" placeholder="Cantidad">
                    <div class="help-block with-errors"></div>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-4 col-sm-4 text-primary">
                    <label for="sucursal" class="col-form-label">*SUCURSAL</label>
                    <select class="form-control form-control-sm" name="sucursal" id="sucursal"></select>
                    <div class="help-block with-errors"></div>
                </div>
                <div class="form-group col-md-4 col-sm-4 text-primary">
                    <label for="caducidad" class="col-form-label">*CADUCIDAD</label>
                    <input name="caducidad" id="caducidad" type="date" class="form-control form-control-sm" placeholder="Cantidad">
                    <div class="help-block with-errors"></div>
                </div>
                <div class="form-group col-md-4 col-sm-4 text-primary">
                    <label for="estatus" class="col-form-label">*ENTREGA</label>
                    <select class="form-control form-control-sm" name="estatus" id="estatus">
                        <option value="9">Entregado</option>
                        <option value="1">Pendiente</option>
                    </select>
                    <div class="help-block with-errors"></div>
                </div>
            </div>
        </div>
        <div class="tab-pane tap-pane-primary hide" id="t_resumen" role="tabpanel" aria-labelledby="resumen-tab"><br>
            <table class="table table-hover">
                <thead>
                    <th>#</th>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Entrega</th>
                    <th>Precio unitario</th>
                    <th>Total</th>
                </thead>
                <tbody id="ResumenTable">

                </tbody>
            </table>
        </div>

    </form>
  </div>
  <div class="modal-footer">
    <button type="submit" class="btn btn-success no_document no_nota no_receta no_forma_i" form="form-registro" id="btn_agregar">Agregar</button>
    <button type="submit" class="btn btn-success hidden" form="form-registro" id="btn_pagar">Pagar</button>
    <button type="button" class="btn btn-warning no_document no_nota no_receta no_forma_i" data-dismiss="modal" id="btn_cancel_registro">Cancelar</button>
  </div>
</div>
</div>
