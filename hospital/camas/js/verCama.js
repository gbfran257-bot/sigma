/**
 * Abre el modal en el que se puede editar la información de la cama seleccionada
 * @param { number } idCama
 */
const verCama = (idCama) => {
    $("#myModal").load("hospital/camas/htmls/cama.php", (response, status, xhr) => {
        if (status === "success") {
            fetch("hospital/camas/files-serverside/infoCama.php?idc=" + idCama, {
                method: "GET",
            })
                .then(response => response.json())
                .then(response => {
                    if (response.error) {
                        throw new Error(response.error);
                    }
                    $("#no_ca").val(response.success.no_ca);
                    $("#area_ca").empty();
                    $("#area_ca").append(`<option value="${response.success.area_ca}">${response.success.area}</option>`);
                    $("#area_ca").val(response.success.area_ca);
                    $("#area_ca").change();
                    $("#area_ca").val(response.success.area_ca);
                    $("#ubicacion_ca").val(response.success.ubicacion_ca);
                    $("#hora_ca").val();
                    $("#descripcion_ca").val(response.success.descripcion_ca);
                    $("#btn_save_escuela").click((e) => actualizarCama(e));
                })
                .catch(error => {
                    console.error(error);
                });

            $("#myModal").modal("show");
            $("#myModal").on("hidden.bs.modal", (e) => {
                $("myModal > .modal-content").remove();
                $("#myModal").empty();
            });
        }
    });
};
