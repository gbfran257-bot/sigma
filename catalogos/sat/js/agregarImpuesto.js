let cont = new Date().getTime();
/**
 * @param { string } id_impuesto_catalogo
 */
const agregarImpuesto = (id_impuesto_catalogo = null) => {
    $("#div_impuestos_extra").append(`
        <div class="row impuesto_extra" id="impuesto_extra_${cont++}" style="padding: 0px 1rem;">
            <input type="hidden" id="id_impuesto_catalogo" name="id_impuesto_catalogo" value=${id_impuesto_catalogo} />
            <div class="float-sm-end" style="margin: 1.2rem;">
                <button type="button" class="btn btn-danger btn-sm" onclick="eliminarImpuesto(this);">Eliminar impuesto</button>
            </div>
            <div class="form-group col-md-3 col-sm-3 text-primary ">
                <label for=" select_tipo" class="col-form-label rec-requeridos">Tipo*</label>
                <select name="select_tipo" id="select_tipo" class="form-control form-control-sm" required onchange="tipoChangeHandler(this);" impuesto_extra>
                <option value="" selected></option>
                <option value="1">Traslado</option>
                <option value="2">Retención</option>
                </select>
                <div class="help-block with-errors"></div>
            </div>
            <div class="form-group col-md-3 col-sm-3 text-primary ">
                <label for=" select_impuesto" class="col-form-label rec-requeridos">Impuesto*</label>
                <select name="select_impuesto" id="select_impuesto" class="form-control form-control-sm" required onchange="impuestoChangeHandler(this)" impuesto_extra>
                <option value="" selected></option>
                </select>
                <div class="help-block with-errors"></div>
            </div>
            <div class="form-group col-md-3 col-sm-3 text-primary ">
                <label for=" select_factor" class="col-form-label rec-requeridos">Factor*</label>
                <select name="select_factor" id="select_factor" class="form-control form-control-sm" required onchange="factorChangeHandler(this)" impuesto_extra>
                <option value="" selected></option>
                </select>
                <div class="help-block with-errors"></div>
            </div>
            <div class="form-group col-md-3 col-sm-3 text-primary ">
                <label for=" select_tasa_cuota" class="col-form-label rec-requeridos">Tasa/Cuota %*</label>
                <select name="select_tasa_cuota" id="select_tasa_cuota" class="form-control form-control-sm" required onchange="mostrarOcultarInputOtroExtra(this);">
                <option value="" selected></option>
                </select>
                <input type="number" min="0" max="16" step="0.01" id="monto_impuesto" name="monto_impuesto" class="form-control form-control-sm" style="display: none; margin-top: 1rem;" required>
                <div class="help-block with-errors"></div>
            </div>
        </div>
    `);
};

/**
 * Elimina el
 * @param { HTMLButtonElement } buttonEliminar
 */
const eliminarImpuesto = (buttonEliminar) => {
    if (buttonEliminar.parentElement.previousElementSibling.value === "null") {
        return buttonEliminar.parentElement.parentElement.remove();
    }

    return swal(
        {
            title: "Eliminar impuesto",
            text: "¿Estás seguro que deseas elimnar el impuesto?",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Eliminar",
            cancelButtonText: "Cancelar",
            closeOnConfirm: false,
        },
        () => {
            const bodyID = new FormData();
            bodyID.append(
                "id_impuesto_catalogo",
                buttonEliminar.parentElement.previousElementSibling.value
            );
            fetch("catalogos/sat/files-serverside/EliminarImpuestoExtra.php", {
                method: "POST",
                body: bodyID,
            })
                .then((response) => response.text())
                .then((data) => {
                    swal({
                        title: "Impuesto eliminado",
                        text: "El impuesto ha sido eliminado de manera exitosa",
                        type: "success",
                        timer: 1800,
                        showConfirmButton: false,
                    });
                    buttonEliminar.parentElement.parentElement.remove();
                })
                .catch((error) =>
                    swal({
                        title: "Ocurrió un error",
                        text: error.message,
                        type: "error",
                    })
                );
        }
    );
};
