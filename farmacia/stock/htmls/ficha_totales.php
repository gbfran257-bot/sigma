<div class="modal-dialog modal-lg" role="document" id="contenido_ficha_usuario">
    <div class="modal-content animated flipInY">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title"><strong><span id="titulo_modal">Totales</span></strong></h4>
        </div>
        <div class="modal-body" id="contenido_tabi">
    
            <table width="100%" height="100%" border="0" id="dataTableTotales" class="table-condensed table-striped table-bordered table-hover" style="overflow: hidden;">
                <thead id="cabecera_tBusquedaMedicamentos" class="">
                <tr class="bg-primary" style="font-size: 1.1em;">
                    <th id="clickmeMdtos1"class="titulosTabs"align="center" nowrap width="1px">#</th>
                    <th class="titulosTabs" align="center" width="">REFERENCIA</th>
                    <th class="titulosTabs" align="center" width="" id="title_medicamento" nowrap>CONCEPTO</th>
                    <th class="titulosTabs" align="center" width="" nowrap>LOTE</th>
                    <th class="titulosTabs" align="center" width="" nowrap>EXISTENCIAS</th>
                </tr>
                </thead> <tbody> <tr> <td class="dataTables_empty">Cargando datos del servidor</td> </tr> </tbody> 
                <tfoot style="display:;">
                    <tr>
                        <th></th>
                        <th><!-- <input type="text" class="form-control input-sm" placeholder="-FECHA-" style="width: 99%"/> --></th>
                        <th><!-- <input type="text" class="form-control input-sm" placeholder="-MEDICAMENTO-" style="width: 99%"/> --></th>
                        <th></th>
                        <th><!-- <input type="text" class="form-control input-sm" placeholder="-PERSONAL MÉDICO-" style="width: 99%"/> --></th>
                    </tr>
                </tfoot>
            </table>                       
                            
        </div>	
        
        <div class="modal-footer">
            <div class="form-group">
                <div class="col-sm-offset-0 col-sm-12">
                    <div class="checkbox">
                    <button type="button" class="btn btn-info hidden" id="btn_print">IMPRIMIR</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal" id="btn_cancel">SALIR</button>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
