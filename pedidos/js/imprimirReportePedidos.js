const imprimirReportePedidos = () => {
    // Verificamos que se haya seleccionado una sucursal
    if (!$("#sucursales-pedidos").val()) {
        return swal("ERROR", "Selecciona antes una sucursal.", "error");
    }

    $("#modal_impresion_reporte_pedidos").html('<div class="modal-dialog modal-lg" role="document" style="width: 1000px;"><div class="modal-content animated flipInY"><div class="modal-header"> <button type="button" class="close hidden" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button> <h4 class="modal-title"><strong><span id="titulo_modal"></span> </strong></h4> </div> <div class="modal-body"> <div id="body_modal4"></div> </div><div class="modal-footer"> <div class="form-group"> <div class="col-sm-offset-0 col-sm-12"> <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Salir</button> </div> </div> </div> </div></div>');
    
    const fecha_impresion = generatePrintingDate();

    /* const pedidos = $("#dataTablePrincipal").DataTable().rows().data().toArray();
    for (let i = 0; i < pedidos.length; i++) {
        pedidos[i][6] = pedidos[i][6].replace(/\D/g, "");
    } */

    const pedidos = [];
    const filas = $("#dataTablePrincipal > tbody").children("tr").toArray();
    for (let i = 0; i < filas.length; i++) {
        const pedido = $(filas[i]).children("td").map((index, td) => {
            return $(td).text();
        }).toArray();
        pedidos.push(pedido);
    }

    const configuracion = {
        id_usuario: $("#id_user").val(),
        sucursal: $("#sucursales-pedidos").children("option:selected").text(),
        fecha_impresion,
        pedidos: JSON.stringify(pedidos),
    };
    
    $("#body_modal4").load("pedidos/html/frame_reporte_pedidos.php", configuracion, (response, status, xhr) => {
        if (status === "success") {
			$('#titulo_modal').text('IMPRESIÓN REPORTE DE PEDIDOS');
			$("#body_modal4").height(500);
			$('#modal_impresion_reporte_pedidos').modal('show');

			// Comportamiento del modal
			$('#modal_impresion_reporte_pedidos').on('hidden.bs.modal', function(e) {
				$("#modal_impresion_reporte_pedidos").empty();
				$('body').addClass('modal-open');
            });
        }
    });
};
