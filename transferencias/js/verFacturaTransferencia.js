const verFacturaCompra = (button, compraFacturada, nombreFactura) => {
    const idCompra = parseInt(
        $(button).parent().parent().children("td")[1].textContent
    );
    const referencia = $(button)
        .parent()
        .parent()
        .children("td")[2].textContent
        .replaceAll(" ", "_")
        .replaceAll(":", "_");

    // Abrimos el modal que permite visualizar o cargar la factura de la compra
    $("#modal_ver_factura_compra").load(
        "farmacia/compras/htmls/ver_factura_compra.php",
        {
            idCompra,
            referencia,
            compraFacturada,
            transferencias: true,
        },
        (response, status, xhr) => {
            if (status === "success") {
                // Función para enviar la imagen
                $("#comprobante_factura").on("change", (e) => {
                    const comprobante = e.target.files[0];
                    const body = new FormData();
                    body.append("comprobante_factura", comprobante);
                    body.append("referencia", referencia);
                    subirComprobanteFactura(body);
                });

                $("img.media_comprobante_factura").media({
                    width: 100 + "%",
                    height: "600px",
                    src: "./farmacia/compras/facturas/" + nombreFactura,
                });

                // Comportamiento del modal
                $("#modal_ver_factura_compra").modal("show");
                $("#modal_ver_factura_compra").on("hidden.bs.modal", (e) => {
                    $(".modal-content").remove();
                    $("#modal_ver_factura_compra").empty();
                });
            }
        }
    );
};
