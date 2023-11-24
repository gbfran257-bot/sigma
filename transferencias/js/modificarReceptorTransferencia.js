const modificarReceptorTransferencia = async (folio, button) => {
    const idUsuario = parseInt($("#id_user").val());
    const nombreUsuario = await actualizarReceptorTransferencia(folio, idUsuario);
    $("#dataTablePrincipal").DataTable().ajax.reload();
};
