<div class="modal-dialog modal-lg" role="document" id="contenido_ficha_consulta">
    <div class="modal-content animated flipInY">
        <div class="modal-header">
            <button type="button" class="close hidden" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title"><strong><span id="titulo_modal">AGREGAR DIAGNOSTICO A PACIENTE HOSPITALIZADO</span></strong></h4>
            <!-- <button type="button" data-loading-text="<i class='fa fa-circle-o-notch fa-spin' aria-hidden='true'></i> Procesando..." style="position: absolute;right: 15px;top: 10px;" class="btn btn-success btn-sm btns-consulta" id="finalizarConsulta"><i class="fa fa-check" aria-hidden="true"></i> Finalizar</button> -->
        </div>
        <div class="modal-body">
            <input name="idUsuario_c" id="idUsuario_c" type="hidden" value=""> 
            <input name="idPaciente_c" id="idPaciente_c" type="hidden" value="">
            <input name="id_cons" id="id_cons" type="hidden" value="">
            <input name="numeroTemporalC" id="numeroTemporalC" type="hidden" value="">
            <input name="id_primer_vc" id="id_primer_vc" type="hidden" value="">
            <input name="nombre_primer_vc" id="nombre_primer_vc" type="hidden" value="">
            <input name="indicador_histo" id="indicador_histo" type="hidden" value="">
            <!-- Nav tabs -->
            <table width="100%" cellpadding="0" cellspacing="0">
                <tr>
                    <td nowrap>
                        <ul class="nav nav-tabs" role="tablist" id="tabs_consulta">
                            <li role="presentation" class="tab_consulta  hsh" id="tab_dx">
                                <a href="#tDx" aria-controls="tDx" role="tab" data-toggle="tab" id="mi_tab_dx">DIAGNÓSTICOS</a>
                            </li>
                        </ul>
                    </td>
                    <td align="right" nowrap>
                        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal" id="salirSGconsulta">Salir</button>
                    </td>
                </tr>
            </table>
            
            <!-- Tab panes -->
            <div class="tab-content">

                <div role="tabpanel" class="tab-pane active" id="tDx"><br>
                <table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr height="50%">
                        <td>
                            <div class="panel panel-info" id="tablaD">
                            <!-- Default panel contents -->
                                <div class="panel-heading">
                                    <strong>LISTA DE DIAGNÓSTICOS DISPONIBLES.</strong> Seleccione los diagnósticos deseados con un <strong>click</strong>.
                                </div>
                                <table width="100%" cellspacing="0" id="dataTableBDX" height="100%" border="0" cellpadding="0" class="table table-striped table-hover table-condensed table-responsive">
                                    <thead id="my_head">
                                        <tr class="">
                                            
                                            <th align="center" >
                                                DIAGNÓSTICO &nbsp;
                                                <button type="button" class="btn btn-success btn-xs hidden" id="altaDX" alt="Dar de alta un diagnóstico">
                                                    <i class="fa fa-plus" aria-hidden="true"></i> Agregar
                                                </button>
                                            </th>
                                            <th align="center" id="clickmeDXD">CLAVE</th>
                                        </tr>
                                    </thead>
                                    <tbody align="left"> 
                                        <tr> 
                                            <td class="dataTables_empty">Cargando datos del servidor</td> 
                                        </tr> 
                                    </tbody>
                                    <tfoot class="pieTablaBDX" id="mi_pie_tabla" align="center">
                                        <tr>
                                            <th>
                                                <input type="text" name="textfield1" id="textfield1" class="form-control" style="width:99%;" placeholder="Buscar">
                                            </th>
                                            <th>
                                                <input type="text" name="textfield2" id="textfield2" class="form-control" style="width:99%;" placeholder="Buscar">
                                            </th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </td> 
                    </tr>
                    <tr>
                        <td>
                            <div class="panel panel-success">
                                <!-- Default panel contents -->
                                <div class="panel-heading">
                                    <strong>LISTA DE DIAGNÓSTICOS SELECCIONADOS</strong>
                                </div>
                                <table width="100%" cellspacing="0" id="dataTableDXS" height="100%" border="0" cellpadding="0" class="table table-bordered table-hover table-condensed table-responsive">
                                    <thead id="my_head">
                                        <tr class="bg-success">
                                            <th align="center">DIAGNÓSTICO</th>
                                            <th id="clickmeDXS" align="center" width="1%">#</th>
                                            <th align="center" width="1%">CLAVE</th>
                                            
                                            <th align="center" width="1%">PRIMARIO</th>
                                            <th align="center" width="1%">ELIMINAR</th>
                                        </tr>
                                    </thead>
                                    <tbody align="left"> 
                                        <tr>
                                            <td class="dataTables_empty">Cargando datos del servidor</td> 
                                        </tr>
                                    </tbody>
                        </table>
                    </div>
                </td> </tr>
                </table>
                </div>
                

            </div>
            <!-- Tab panes -->
            <div class="hidden">
                <canvas id="miFotoX" width="700" height="525"></canvas> <canvas id="miFotoX1" width="200" height="150"></canvas>
            </div>
            
        </div>
      
     
    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
