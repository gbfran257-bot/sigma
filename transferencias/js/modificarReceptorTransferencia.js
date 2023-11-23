const modificarReceptorTransferencia = (folio, button) => {
    const receptor = $(button).text();
    $(button).replaceWith(`<select class="form-control" id="usuario_receptor"></select>`);

    $("#usuario_receptor").select2({
        ajax: {
            url: "transferencias/files-serverside/usuarios_receptor.php",
            dataType: "json",
        },
    }).focus();

    $("#usuario_receptor").select2("open");
    
    $("#usuario_receptor").on("select2:select", (e) => {
        $("#usuario_receptor").select2("destroy");
        actualizarReceptorTransferencia(folio, $("#usuario_receptor").children("option:selected").val());
        $("#dataTablePrincipal").DataTable().ajax.reload();
    });
};