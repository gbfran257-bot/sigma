<form id="form-ficha_us" name="form-ficha_us" data-toggle="validator" role="form">
<div class="modal-dialog modal-fullscreen" role="document" id="contenido_ficha_usuario">
    <div class="modal-content animated flipInY">
      <div class="modal-header">
            <button type="button" class="close hidden" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">
                <table border="0" cellpadding="0" cellspacing="0" width="100%">
                    <tr>
                    <td><strong><span id="titulo_modal">INFORMACIÓN DE LA REFERENCIA: </span></strong></td>
                    <td align="right">
                        <button type="button" class="btn btn-success btn-sm" data-dismiss="modal" id="btn_cancel1">Cerrar</button>
                    </td>
                    </tr>
                </table>
            </h4>
      </div>
      
      <div class="modal-body">

        <div class="row">
            <!-- Nav tabs -->
            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active">
                    <a href="#tab_agregar_ref" aria-controls="tab_agregar_ref" role="tab" data-toggle="tab" id="t_ref">REFERENCIAS</a>
                </li>
                <li role="presentation">
                    <a href="#tab_abonos" aria-controls="tab_abonos" role="tab" data-toggle="tab" id="t_abonos">ABONOS</a>
                </li>
                <li role="presentation">
                    <a href="#tab_rep_con" aria-controls="tab_rep_con" role="tab" data-toggle="tab" id="t_rep_con">REPORTE DE CONCEPTOS</a>
                </li>
                <li role="presentation">
                    <a href="#tab_historial" aria-controls="tab_historial" role="tab" data-toggle="tab" id="t_his">HISTORIAL</a>
                </li>
                <li role="presentation" class="hidden">
                    <a href="#tab_pagos" aria-controls="tab_pagos" role="tab" data-toggle="tab" id="t_pagos">PAGOS</a>
                </li>
            </ul>

            <!-- tab panes -->
            <div class="tab-content">
                <!-- referencias -->
                <div role="tabpanel" class="tab-pane active" id="tab_agregar_ref"><br>
                    <div class="row">
                        <div class="col-sm-12 col-xs-12 depende_medico_s ">
                            <table class="tablasaldos" name="tablasaldos" style="width:100%; text-align:center;">
                                <thead>
                                    <tr>
                                        <!-- <td> <label for="lblsubtotal" id="lblsubtotal"></label></td> -->
                                        <td> <label for="lbltotal" id="lbltotal"></label></td>
                                        <td> <label for="lblabono_orden" id="lblabono_orden"></label></td>
                                        <td> <label for="lblabono" id="lblabono" style="font-size: 14px;"></label></td>
                                        <td> <label for="lblsaldo" id="lblsaldo" style="color:red; font-size: 16px;"></label></td>
                                    </tr>
                                </thead>
                            </table>

                           
                           
                           

                            <table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0" style="margin-top:5px;">
                            <tr height="50%">
                                <td>
                                <table width="100%" cellspacing="0" id="dataTableBserviciosM" height="100%" border="0" cellpadding="0" class="table table-striped table-hover table-bordered table-responsive">
                                    <thead id="my_head">
                                    <tr class="bg-primary">
                                        <th align="center" id="clickmeSe">REFERENCIAS DISPONIBLES. <span class="small">Seleccione con un click</span>.</th>
                                        <th align="center">
                                        FECHA&nbsp;
                                        </th>
                                        <th align="center">SUCURSAL</th>
                                        <th align="center">TOTAL</th>
                                        <th align="center">CANTIDAD PAGADA</th>
                                        <th align="center">TOTAL POR ORDEN</th>
                                    </tr>
                                    </thead>
                                    <tbody align="left">
                                    <tr>
                                        <td class="dataTables_empty">Cargando datos del servidor</td>
                                    </tr>
                                    </tbody>
                                    <tfoot align="center">
                                    <tr>
                                        <th> <!-- <input type="text" name="text1" class="form-control input-sm" style="width:99%;" placeholder="Buscar"> --> </th>
                                        <th> <!-- <input type="text" name="text2" class="form-control input-sm" style="width:99%;" placeholder="Buscar"> --> </th>
                                        <th> </th>
                                        <th> <!-- <select id="beneficio_s" name="beneficio_s" class="form-control input-sm" style=""> </select> --> </th>
                                    </tr>
                                    </tfoot>
                                </table>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                <table width="100%" cellspacing="0" id="dataTableSmS" height="100%" border="0" cellpadding="0" class="table table-bordered table-hover table-responsive">
                                    <thead>
                                    <tr class="bg-primary">
                                        <!-- <th id="clickmeSmS" align="center" width="1%">#</th> -->
                                        <th id="clickmeSmS" align="center">REFERENCIAS SELECCIONADAS</th>
                                        <th align="center">FECHA</th>
                                        <th align="center">SUCURSAL</th>
                                        <th align="center">TOTAL</th>
                                        <th align="center">CANTIDAD PAGADA</th>
                                        <th align="center">TOTAL POR ORDEN</th>
                                        <th align="center" width="1%">DESVINCULAR</th>
                                    </tr>
                                    </thead>
                                    <tfoot>
                                        <tr class="bg-primary">
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                        </tr>
                                    </tfoot>
                                    <tbody align="left">
                                    <tr>
                                        <td class="dataTables_empty">Cargando datos del servidor</td>
                                    </tr>
                                    </tbody>
                                </table>
                                </td>
                            </tr>
                            </table>
                        </div>

                    </div>
                </div>
                <!-- /referencias -->
                <!-- historial -->
                <div role="tabpanel" class="tab-pane" id="tab_historial"><br>
                    <div class="row">

                        <!--  -->
                        <div class="col-sm-12 col-xs-12">
                                <table width="100%" cellspacing="0" id="dataTableHis" height="100%" border="0" cellpadding="0" class="table table-bordered table-hover table-responsive">
                                    <thead>
                                    <tr class="bg-primary">
                                        <!-- <th id="clickmeSmS" align="center" width="1%">#</th> -->
                                        <th id="clickmeHis" align="center">REFERENCIA</th>
                                        <th align="center">USUARIO</th>
                                        <th align="center">FECHA</th>
                                        <th align="center">INFORMACIÓN</th>
                                        <!-- <th align="center" width="1%">DESVINCULAR</th> -->
                                    </tr>
                                    </thead>
                                    <tbody align="left">
                                    <tr>
                                        <td class="dataTables_empty">Cargando datos del servidor</td>
                                    </tr>
                                    </tbody>
                                </table>
                           
                        </div>
                        <!--  -->

                    </div>
                </div>
                <!-- historial -->
                
                <!-- pagos -->
                <div role="tabpanel" class="tab-pane hidden" id="tab_pagos"><br>
                    <div class="row">

                        <!--  -->
                        <div class="col-sm-12 col-xs-12">
                                <table width="100%" cellspacing="0" id="dataTablePag" height="100%" border="0" cellpadding="0" class="table table-bordered table-hover table-responsive">
                                    <thead>
                                    <tr class="bg-primary">
                                        <!-- <th id="clickmeSmS" align="center" width="1%">#</th> -->
                                        <th id="clickmePag" align="center">REFERENCIA</th>
                                        <th align="center">F.PAGO</th>
                                        <th align="center">SUBTOTAL</th>
                                        <th align="center">SALDO</th>
                                        <th align="center">PAGADO</th>
                                    </tr>
                                    </thead>
                                    <tbody align="left">
                                    <tr>
                                        <td class="dataTables_empty">Cargando datos del servidor</td>
                                    </tr>
                                    </tbody>
                                </table>
                           
                        </div>
                        <!--  -->

                    </div>
                </div>
                <!-- pagos -->

                <!-- ABONOS -->
                <div role="tabpanel" class="tab-pane" id="tab_abonos"><br>
                    <div class="row">

                        <!--  -->
                        <div class="col-sm-12 col-xs-12">

                            <table class="tablasaldos" name="tablasaldos" style="width:100%; text-align:center;">
                                <thead>
                                    <tr>
                                        <!-- <td> <label for="lblsubtotal" id="lblsubtotal"></label></td> -->
                                        <td> <label for="lbltotal" id="lbltotal"></label></td>
                                        <td> <label for="lblabono_orden" id="lblabono_orden"></label></td>
                                        <td> <label for="lblabono" id="lblabono" style="font-size: 14px;"></label></td>
                                        <td> <label for="lblsaldo" id="lblsaldo" style="color:red; font-size: 16px;"></label></td>
                                    </tr>
                                </thead>
                            </table>

                                <table width="100%" cellspacing="0" id="dataTableAbo" height="100%" border="0" cellpadding="0" class="table table-bordered table-hover table-responsive">
                                    <thead>
                                    <tr class="bg-primary">
                                        <!-- <th id="clickmeSmS" align="center" width="1%">#</th> -->
                                        <th id="clickmeAbo" align="center">USUARIO</th>
                                        <th align="center">FECHA</th>
                                        <th align="center">PERSONA QUE ABONÓ</th>
                                        <th align="center">FORMA DE PAGO</th>
                                        <th align="center">
                                            CANTIDAD ABONADA
                                            <button class="btn btn-success btn-sm" type="button" id="btn_abonar">ABONAR <i class="fa fa-plus-circle" aria-hidden="true"></i></button>
                                        </th>
                                        <!-- <th align="center">SALDO</th> -->
                                        <!-- <th align="center">PAGADO</th> -->
                                    </tr>
                                    </thead>
                                    <tfoot>
                                        <tr class="bg-primary">
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                        </tr>
                                    </tfoot>
                                    <tbody align="left">
                                    <tr>
                                        <td class="dataTables_empty">Cargando datos del servidor</td>
                                    </tr>
                                    </tbody>
                                </table>
                           
                        </div>
                        <!--  -->

                    </div>
                </div>
                <!-- ABONOS -->

                <!-- reporte conceptos -->
                <div role="tabpanel" class="tab-pane" id="tab_rep_con"><br>
                    <div class="row">

                        <!--  -->
                        <div class="col-sm-12 col-xs-12">

                            <table class="tablasaldos" name="tablasaldos" style="width:100%; text-align:center;">
                                <thead>
                                    <tr>
                                        <!-- <td> <label for="lblsubtotal" id="lblsubtotal"></label></td> -->
                                        <td> <label for="lbltotal" id="lbltotal"></label></td>
                                        <td> <label for="lblabono_orden" id="lblabono_orden"></label></td>
                                        <td> <label for="lblabono" id="lblabono" style="font-size: 14px;"></label></td>
                                        <td> <label for="lblsaldo" id="lblsaldo" style="color:red; font-size: 16px;"></label></td>
                                    </tr>
                                </thead>
                            </table>

                                <table width="100%" cellspacing="0" id="dataTableRep" height="100%" border="0" cellpadding="0" class="table table-bordered table-hover table-responsive">
                                    <thead>
                                    <tr class="bg-primary">
                                        <!-- <th id="clickmeSmS" align="center" width="1%">#</th> -->
                                        <th id="clickmeRep" align="center">REFERENCIA</th>
                                        <th align="center">FECHA</th>
                                        <th align="center">CONCEPTO</th>
                                        <th align="center">TIPO CONCEPTO</th>
                                        <th align="center">
                                            PRECIO
                                        </th>
                                        <!-- <th align="center">SALDO</th> -->
                                        <!-- <th align="center">PAGADO</th> -->
                                    </tr>
                                    </thead>
                                    <tfoot>
                                        <tr class="bg-primary">
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                        </tr>
                                    </tfoot>
                                    <tbody align="left">
                                    <tr>
                                        <td class="dataTables_empty">Cargando datos del servidor</td>
                                    </tr>
                                    </tbody>
                                </table>
                           
                        </div>
                        <!--  -->

                    </div>
                </div>
                <!-- reporte conceptoa -->
                
            </div>
            <!-- /tab panes -->
        </div>

        <div id="alerta_new_user" class="alert alert-warning hidden">
        <i class="fa fa-exclamation-circle" aria-hidden="true"></i> Favor de revisar el formulario, hay algunos errores.
        </div>
        
      </div>
      <div class="modal-footer">
      	<div class="form-group">
        <div class="col-sm-offset-0 col-sm-12">
        </div>
        </div>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</form>
