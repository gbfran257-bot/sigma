<div class="modal fade" id="modal-precios-descuentos-lab" style="z-index: 2951!important">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Modificación de precio del estudio de laboratorio</h4>
			</div>
			<form action="" method="POST" role="form">
				<input type="hidden" name="id_vc" id="inputId_vc" class="form-control" value="">
				<div class="modal-body">
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<span class="label">Precio del estudio de laboratorio</span>
								<input type="number" name="precio_original" id="inputPrecio_original" class="form-control" value="" step="0.01" required="required">
							</div>
						</div>
						<!-- <div class="col-md-6">
							<div class="form-group">
								<span class="label">Honorarios para el médico</span>
								<input type="number" name="honorarios" id="inputHonorarios" class="form-control" value="" step="0.01" required="required">
							</div>
						</div> -->
						<div class="col-md-6">
							<div class="form-group">
								<span class="label">Descuento</span>
								<input type="number" name="descuento" id="inputDescuento" class="form-control" value="" step="0.01">
							</div>
						</div>
						<div class="col-md-12">
							<span class="label">Motivo de esta modificación*</span>
							<input type="text" name="motivo_alteracion" id="inputMotivo_alteracion" class="form-control" value="" required="required">
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
					<button type="submit" class="btn btn-primary">Guardar cambios</button>
				</div>
			</form>
		</div>
	</div>
</div>