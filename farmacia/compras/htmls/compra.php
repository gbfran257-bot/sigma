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
        <!-- INICIO DE LOS CAMBIOS PARA EL FUNCIONAMIENTO DE LOS PROVEEDORES -->
            <div class="row">
                <div class="form-group col-md-8 col-sm-8 text-primary">
                    <label for="nota" class="bg-info" style="color:black;">NOTA: No repetir lote en una misma compra.</label> <i class="fa fa-exclamation-triangle" aria-hidden="true" style="color:red;"></i>
                    <br>
                    <strong style="margin-right: 1rem;">Selecciona un proveedor para comenzar con la compra</strong> <button type="button" id="cambiar-proveedor" class="btn btn-warning btn-sm" style="display: none;"><i class="fa fa-pencil"></i></button> <br> <br>
                    <label for="select-proveedores" class="col-form-label">*PROVEEDOR</label>
                    <div style="display:flex;">
                        <select class="form-control form-control-sm" name="select-proveedores" id="select-proveedores"></select>
                        <button style="margin-left:10px;" class="btn btn-primary btn-xs" id="redirect-nuevo-proveedor"><i class="fa fa-plus"></i> Proveedor</button>
                        <button type="button" style="margin-left:10px;" class="btn btn-primary btn-xs" id="actualizar_proveedores"><i class="fa fa-spinner"></i> Actualizar</button>
                    </div>
                    <div class="help-block with-errors"></div>
                </div>
            </div>
            <!-- FINAL DE LOS CAMBIOS PARA EL FUNCIONAMIENTO DE LOS PROVEEDORES -->

            <div class="row" id="div-compra-container" style="display: none; padding-left: 1.5rem;">
                <div class="row">
                    <div class="form-group col-md-8 col-sm-8 text-primary">
                        <label for="producto" class="col-form-label">*PRODUCTO O CÓDIGO DE BARRAS</label>
                        <div style="display:flex;">
                            <select class="form-control form-control-sm" name="producto" id="producto"></select>
                            <button style="margin-left:10px;" class="btn btn-primary btn-xs" id="redirect-nuevo-medicamento"><i class="fa fa-plus"></i> Producto</button>
                            <button type="button" style="margin-left:10px;" class="btn btn-primary btn-xs" id="actualizar_productos"><i class="fa fa-spinner"></i> Actualizar</button>
                        </div>
                        <div class="help-block with-errors"></div>
                    </div>
                    <!--Se comenta el siguiente div que no se utiliza para acomodar mejor la lista despegable de productos. 17/10/2023-->
                    <!-- <div class="form-group col-md-4 col-sm-4 text-primary">
                        <label  id='productoName'  class="col-form-label"></label> <br>
                        <label id="precioPublicoProd" class="col-form-label"></label>
                    </div> -->
                    <div class="form-group col-md-4 col-sm-4 text-primary">
                        <label  id='productoName'  class="col-form-label"></label> <br>
                        <i class="fa fa-pencil-square-o hidden ico-edit" aria-hidden="true" style="color: black;"></i> <label style="cursor: pointer;" id="precioPublicoProd" class="col-form-label"></label> <br>
                        <label id="precioUltimaCompra" class="col-form-label"></label> <br>
                        <i class="fa fa-pencil-square-o hidden ico-edit" aria-hidden="true" style="color: black;"></i> <label id="cantMax" class="col-form-label" style="cursor: pointer;"></label> <br>
                        <i class="fa fa-pencil-square-o hidden ico-edit" aria-hidden="true" style="color: black;"></i> <label id="cantMin" class="col-form-label" style="cursor: pointer;"></label><br>
                        <i class="fa fa-pencil-square-o hidden ico-edit" aria-hidden="true" style="color: black;"></i> <label id="codigoBarras" class="col-form-label" style="cursor: pointer;"></label>
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
                        <input name="lote" id="lote" type="text" class="form-control form-control-sm" placeholder="Lote">
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
                        <?php $current_date = date("Y-m-d");?>
                        <input name="caducidad" id="caducidad" type="date" min="<?php echo $current_date; ?>" max="2100-01-01" class="form-control form-control-sm" placeholder="Cantidad">
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

                <div class="row">
                    <div class="form-group col-md-4 col-sm-4 text-primary">
                        <label for="folio" class="col-form-label">*FOLIO</label>
                        <input name="folio" id="folio" type="text" class="form-control form-control-sm" placeholder="folio">
                        <div class="help-block with-errors"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-pane tap-pane-primary hide" id="t_resumen" role="tabpanel" aria-labelledby="resumen-tab"><br>
        <label for="nota" class="bg-info" style="color:black;">NOTA: No repetir lote en una misma compra.</label> <i class="fa fa-exclamation-triangle" aria-hidden="true" style="color:red;"></i>
            <table class="table table-hover">
                <thead>
                    <th>#</th>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Precio unitario</th>
                    <th>Lote</th>
                    <th>Acciones</th>
                    <th>Total</th>
                </thead>
                <tbody id="ResumenTable">

                </tbody>
            </table>
        </div>
        <input name="id_compra_oculto" type="hidden" value="" id="id_compra_oculto" required>
    </form>
  </div>
  <div class="modal-footer">
    <button type="submit" class="btn btn-success no_document no_nota no_receta no_forma_i" form="form-registro" id="btn_agregar">Agregar</button>
    <button type="submit" class="btn btn-success hidden" form="form-registro" id="btn_pagar">Pagar</button>
    <button type="button" class="btn btn-warning no_document no_nota no_receta no_forma_i" data-dismiss="modal" id="btn_cancel_registro">Cancelar</button>
  </div>
</div>
</div>
