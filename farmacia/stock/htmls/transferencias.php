<?php
require("../../../Connections/horizonte.php");
require("../../../funciones/php/values.php");

include_once '../../../recursos/session.php';
include_once '../../../Connections/database.php';
include_once '../../../recursos/utilities.php';

$id_del_user = $_SESSION['id'];
?>

<div class="modal-dialog modal-lg" role="document" style="width: 1200px;">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title text-dark" id="tituloModal"> </h4>
        </div>
        <div class="modal-body" id="body_modal_compra">
            <form action="">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item active " id="tab_mi_grales">
                        <a class="nav-link" id="compra-tab" data-toggle="tab" href="#t_compra" role="tab" aria-controls="generales" aria-expanded="true">TRANFERENCIAS <span id="nameProd"></span> </a>
                    </li>
                </ul>
                <div class="tab-pane active tap-pane-primary" id="t_compra" role="tabpanel" aria-labelledby="compra-tab"><br>
                    <div class="row">
                        <div class="form-group col-md-6 col-sm-6 text-primary">
                            <label for="sucursal-origen" class="col-form-label">*SUCURSAL ORIGEN</label>
                            <div style="display:flex;">
                                <select class="form-control form-control-sm" name="sucursal-origen" id="sucursal-origen"></select>
                            </div>
                            <div class="help-block with-errors"></div>
                        </div>
                        <div class="form-group col-md-6 col-sm-6 text-primary">
                            <label for="sucursal-destino" class="col-form-label">*SUCURSAL DESTINO</label>
                            <div style="display:flex;">
                                <select class="form-control form-control-sm" name="sucursal-destino" id="sucursal-destino"></select>
                            </div>
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                    <div class="row">
                        <table width="100%" cellspacing="0" id="dataTableProductos" height="100%" border="0" cellpadding="0" class="table table-striped table-hover table-bordered table-responsive">
                            <thead id="my_head">
                                <tr class="bg-info">
                                    <th align="center" id="clickmePr">PRODUCTOS DISPONIBLES</th>
                                    <th align="center">CÓDIGO DE BARRAS</th>
                                    <th align="center">ÁREA&nbsp;</th>
                                    <th align="center">PRECIO</th>
                                    <th align="center">LOTE</th>
                                    <th align="center">STOCK</th>
                                    <th align="center">CADUCIDAD</th>
                                </tr>
                            </thead>
                            <tbody align="left" id="tbody-datatable-productos">
                            </tbody>
                        </table>
                    </div>
                </div>

            </form>
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-success no_document no_nota no_receta no_forma_i" id="btn_trans">Tranferir</button>
            <!-- <button type="submit" class="btn btn-success hidden" form="form-registro" id="btn_pagar">Pagar</button> -->
            <button type="button" class="btn btn-warning no_document no_nota no_receta no_forma_i" data-dismiss="modal" id="btn_cancel_registro">Cancelar</button>
        </div>
    </div>
</div>