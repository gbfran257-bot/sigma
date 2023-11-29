const modificarReceptorTransferencia = async (folio, button) => {
    swal({
        type: "info",
        title: "¡ATENCIÓN!",
        text: "¿Recibir la transferencia?",
        showCancelButton: true,
        cancelButtonText: "Cancelar",
        confirmButtonText: "Aceptar",
    }, async (isConfirmed) => {
        if (!isConfirmed) {
            return;
        }
        const idUsuario = parseInt($("#id_user").val());
        const response = await actualizarReceptorTransferencia(folio, idUsuario);
        $("#dataTablePrincipal").DataTable().ajax.reload();
        setTimeout(async () => {
            const idUsuario = parseInt($("#id_user").val());
            const response = await actualizarReceptorTransferencia(folio, idUsuario);
            $("#dataTablePrincipal").DataTable().ajax.reload();
            swal("¡HECHO!", response, "success");
        }, 1000);
    });
};
