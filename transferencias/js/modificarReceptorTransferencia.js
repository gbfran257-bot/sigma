const modificarReceptorTransferencia = async (folio, button) => {
    const idUsuario = parseInt($("#id_user").val());
    const response = await actualizarReceptorTransferencia(folio, idUsuario);
    $("#dataTablePrincipal").DataTable().ajax.reload();
    swal("¡HECHO!", response, "success");
};
