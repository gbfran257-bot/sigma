const verReporteEntregaTransferencia = (folio, receptor, idUsuario, emisor) => {
    $("#modal_reporte_entrega_transferencias").html('<div class="modal-dialog modal-lg" role="document" style="width: 1000px;"><div class="modal-content animated flipInY"><div class="modal-header"> <button type="button" class="close hidden" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button> <h4 class="modal-title"><strong><span id="titulo_modal"></span> </strong></h4> </div> <div class="modal-body"> <div id="body_modal4"></div> </div><div class="modal-footer"> <div class="form-group"> <div class="col-sm-offset-0 col-sm-12"> <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Salir</button> </div> </div> </div> </div></div>');

    const usuario = emisor.split("<br>")[0];
    const hora = emisor.split("<br>")[2];
    const datosFecha = emisor.split("<br>")[1].split("/");
    const fecha = datosFecha[2] + "-" + datosFecha[1] + "-" + datosFecha[0];
    const emisorFechaHora = usuario + " " + fecha + " " + hora;

    const configuracion = {
        folio,
        receptor,
        idU: idUsuario,
        emisor: emisorFechaHora,
    };

    $("#body_modal4").load("transferencias/html/frame_reporte_entrega_transferencias.php", configuracion, (response, status, xhr) => {
		if (status === "success") {
			$("#titulo_modal").text("IMPRESIÓN HOJA DE ENTREGA");
            $("#body_modal4").height(500);
            $("#modal_reporte_entrega_transferencias").modal("show");

            // Comportamiento del modal
            $("#modal_reporte_entrega_transferencias").on("hidden.bs.modal", function (e) {
                $("#modal_reporte_entrega_transferencias").empty();
                $("body").addClass("modal-open");
            });
		}
	});
};
