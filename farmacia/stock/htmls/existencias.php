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
  <div class="modal-header text-center"> <h4 class="modal-title text-dark" id="tituloModal"> </h4> </div>
  <div class="modal-body" id="body_modal_compra">
    <form action="">
        
            <div class="row" style="display:flex; justify-content:center">
                <div class="form-group col-md-4 col-sm-6 text-primary">
                    <label id="existActual" class="col-form-label"></label>
                </div>
                <input type="text" id="idStock" class="hide">
                <div class="form-group col-md-4 col-sm-6 text-primary">
                    <label  class="col-form-label">*NUEVO VALOR DE EXISTENCIAS</label> <br>
                    <input class="form-control form-control-sm" name="cant" id="cant" type="number" min="1">
                    <div class="help-block with-errors" id="cantAlerta"></div>
                </div>
            </div>
        

    </form>
  </div>
  <div class="modal-footer">
    <button type="submit" class="btn btn-success no_document no_nota no_receta no_forma_i" id="btn_guardar">GUARDAR</button>
    <!-- <button type="submit" class="btn btn-success hidden" form="form-registro" id="btn_pagar">Pagar</button> -->
    <button type="button" class="btn btn-warning no_document no_nota no_receta no_forma_i" data-dismiss="modal" id="btn_cancel_registro">Cancelar</button>
  </div>
</div>
</div>