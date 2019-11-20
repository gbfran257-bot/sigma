<form name="form-pagar" id="form-pagar" data-toggle="validator" role="form"> <input type="hidden" id="opcion_pa" name="opcion_pa">
<div class="modal-dialog modal-lg" role="document" id="contenido_ficha_usuario" style="font-size: 1.4em;">
    <div class="modal-content animated flipInY">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><strong><span id="titulo_modal">PAGO</span></strong></h4>
      </div>
      <div class="modal-body">
      
		<div id="alerta_new_pago" class="alert alert-warning">
        	<i class="fa fa-exclamation-circle" aria-hidden="true"></i> Favor de revisar el formulario, falta el pago.
      	</div>
<table width="100%" height="" class="table-condensed" border="0">
  <tr>
    <td align="right">Forma de pago</td>
    <td width="50%" align="left"><select name="formaPagoP" id="formaPagoP" class="form-control" required></select></td>
  </tr>
  <!--<tr id="numeroCheque" style="display:none;">
    <td align="right">número de cheque</td>
    <td align="left">
    <input name="noChequeP" type="text" id="noChequeP" class="required"onKeyUp="conMayusculas(this);nick(this.value, this.name);">
    </td>
  </tr> -->
  <tr>
    <td align="right">Total de la orden</td>
    <td align="left">
    <div class="input-group">
      <span class="input-group-addon" id="basic-addon1">$</span>
      <input name="totalOVP" type="text" id="totalOVP" class="form-control disabled" style="text-align:right; padding-right:10px;" disabled aria-describedby="basic-addon1">
    </div>
    </td>
  </tr>
  <tr>
    <td align="right">Total abonado</td>
    <td align="left">
    <div class="input-group">
      <span class="input-group-addon" id="basic-addon2">$</span>
      <input name="abonadoOVP" type="text" id="abonadoOVP" class="form-control disabled" style="text-align:right; padding-right:10px;" disabled aria-describedby="basic-addon2">
    </div>
    </td>
  </tr>
  <tr>
    <td align="right">Saldo</td>
    <td>
    <div class="input-group">
      <span class="input-group-addon" id="basic-addon3">$</span>
      <input name="saldoP" type="text" id="saldoP" class="form-control disabled" style="text-align:right; padding-right:10px;" disabled aria-describedby="basic-addon3">
    </div>
    </td>
  </tr>
  <tr>
    <!--<td align="right">Monto a pagar</td>-->
    <td colspan="2">
		<table class="table-condensed text-danger small bg-danger" id="texto_money" style="font-size: 0.75em;"><tr><td id="t" align="justify"></td></tr></table>
		<table border="0" cellpadding="0" cellspacing="0" class="text-info">
			<tr style="font-size: 0.75em;" align="center">
				<td>
					<!--<span class="text-info"></span><br>
					<div class="input-group">
					  <span class="input-group-addon" id="basic-addon5">$</span>
					  <input name="montoPagarP" type="text" id="montoPagarP" class="form-control" onKeyUp="numeros_decimales(this.value, this.name);" style="text-align:right; padding-right:10px;" required aria-describedby="basic-addon5">
					</div>-->
					ASOCIACIÓN M. $<span class="1total_c1" id="1total_c1">0.00</span><br>
					<div class="input-group">
						<span class="input-group-addon bootstrap-touchspin-postfix">$</span>
						<input type="text" class="form-control montoPagarP" id="pago_ov_c" name="pago_ov_c" placeholder="Su pago A.M." style="text-align:right;" min="0" required onKeyUp="su_pago_a(this.value,this.id);">
					</div>
				</td>
				<td>
					IMAGEN $<span class="1total_i" id="1total_i">0.00</span><br>
					<div class="input-group">
						<span class="input-group-addon bootstrap-touchspin-postfix">$</span>
						<input type="text" class="form-control montoPagarP" id="pago_ov_i" name="pago_ov_i" placeholder="Su pago IMG" style="text-align:right;" min="0" required onKeyUp="su_pago_i(this.value,this.id);">
					</div>
				</td>
				<td>
					LABORATORIO $<span class="1total_l" id="1total_l">0.00</span><br>
					<div class="input-group">
						<span class="input-group-addon bootstrap-touchspin-postfix">$</span>
						<input type="text" class="form-control montoPagarP" id="pago_ov_l" name="pago_ov_l" placeholder="Su pago LAB" style="text-align:right;" min="0" required onKeyUp="su_pago_l(this.value,this.id);">
					</div>
				</td>
				<td>
					FARMACIA $<span class="1total_p" id="1total_p">0.00</span><br>
					<div class="input-group">
						<span class="input-group-addon bootstrap-touchspin-postfix">$</span>
						<input type="text" class="form-control montoPagarP" id="pago_ov_f" name="pago_ov_f" placeholder="Su pago FAR" style="text-align:right;" min="0" required onKeyUp="su_pago_p(this.value,this.id);">
					</div>
				</td>
			</tr>
		</table>
    </td>
  </tr>
  <tr>
	<td width="50%" class="text-info">MONTO TOTAL A PAGAR: $<span id="monto_t_p">0.00</span></td>
  	<td align="right"><button type="button" class="btn btn-info" id="btn_liquidar_ov"><i class="fa fa-dollar" aria-hidden="true"></i> Liquidar</button></td>
  </tr>
  <tr>
    <td align="right">Paga con</td>
    <td align="left">
    <div class="input-group">
      	<span class="input-group-addon">$</span>
    	<input name="pagaConP" type="text" id="pagaConP" onKeyUp="numeros_decimales(this.value, this.name);" style="text-align:right; padding-right:10px;" class="form-control">
    </div>
    </td>
  </tr>
  <tr>
    <td align="right">Cambio</td>
    <td>
    <div class="input-group">
      <span class="input-group-addon" id="basic-addon4">$</span>
      <input name="cambioP" type="text" id="cambioP" class="form-control disabled" style="text-align:right; padding-right:10px;" disabled aria-describedby="basic-addon4">
    </div>
    </td>
  </tr>
</table>

	</div>
      <div class="modal-footer">
      	<div class="form-group">
        <div class="col-sm-offset-0 col-sm-12">
          <div class="checkbox">
            <button type="submit" data-loading-text="<i class='fa fa-circle-o-notch fa-spin' aria-hidden='true'></i> Procesando..." class="btn btn-success" id="btn_pago_ov">Pagar</button>
            <button type="button" class="btn btn-warning" data-dismiss="modal" id="btn_cancel_pago_ov">Cancelar</button>
          </div>
        </div>
        </div>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</form>