const subirComprobanteFactura = (body) => {
    fetch("farmacia/compras/files-serverside/subir_comprobante_factura.php", {
        method: "POST",
        body,
    })
        .then((response) => response.json())
        .then((respuesta) => {
            if (respuesta.error) {
                throw new Error(respuesta.error);
            }

            swal(
                {
                    icon: "success",
                    title: "¡HECHO!",
                    text: respuesta.success,
                    showConfirmButton: false,
                    timer: 1800,
                },
                () => {
                    $("#dataTablePrincipal").DataTable().ajax.reload();
                    $("#modal_ver_factura_compra").modal("hide");
                }
            );
        })
        .catch((error) => console.error(error));
};
