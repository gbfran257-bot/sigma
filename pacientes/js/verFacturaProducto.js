const verFacturaProducto = (nombreFactura, referenciaCompra, usuario, fechaHora) => {
    $("#modal_ver_factura").load("pacientes/htmls/ver_factura.php", {
            nombreFactura,
            referenciaCompra,
            usuario,
            fechaHora
        }, (response, status, xhr) => {
        if (status === "success") {
            $("img.media_comprobante_factura").media({
				width: 100 + "%",
				height: "600px",
				src: "farmacia/compras/facturas/" + nombreFactura,
			});

            $('#modal_ver_factura').modal('show');
			$('#modal_ver_factura').on('hidden.bs.modal', (e) => {
				$("modal_ver_factura > .modal-content").remove();
				$("#modal_ver_factura").empty();
                $("#cancelar-agregar-cantidad-productos").click();
			});
        }
    });
};
