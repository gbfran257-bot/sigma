<div class="modal-dialog modal-lg" role="document" id="contenido_ficha_consulta">
    <div class="modal-content animated flipInY">
        <div class="modal-header">
            <button type="button" class="close hidden" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <h4 class="modal-title">
                <strong>
                    <span id="titulo_modal">AGREGAR DIAGNOSTICO A PACIENTE HOSPITALIZADO</span>
                </strong>
            </h4>
            <!-- <button type="button"
                data-loading-text="<i class='fa fa-circle-o-notch fa-spin' aria-hidden='true'></i> Procesando..."
                style="position: absolute;right: 15px;top: 10px;" class="btn btn-success btn-sm btns-consulta"
                id="salirSGconsulta">
                <i class="fa fa-check" aria-hidden="true"></i> Finalizar
            </button> -->
            <button type="button" style="position: absolute;right: 15px;top: 10px;" class="btn btn-danger btn-sm" data-dismiss="modal" id="salirSGconsulta">
                Salir
            </button>
        </div>
        <div class="modal-body">
            <div role="tabpanel" class="tab-pane" id="tHisto">
                <br>
                <div class="si_img_h" id="mostrar_img_histor" align="center">

                </div>
                <!-- Nav tabs -->
                <ul class="nav nav-tabs no_img_h" role="tablist" id="tabs_historiales">
                    <li role="presentation" class="tab_historiales active">
                        <a href="#tHisto1" aria-controls="tHisto1" role="tab" data-toggle="tab" id="tab_histo_1">HC</a>
                    </li>
                    <li role="presentation" class="tab_historiales">
                        <a href="#tHisto2" aria-controls="tHisto2" role="tab" data-toggle="tab" id="tab_histo_2">LAB</a>
                    </li>
                    <li role="presentation" class="tab_historiales">
                        <a href="#tHisto3" aria-controls="tHisto3" role="tab" data-toggle="tab" id="tab_histo_3">USG</a>
                    </li>
                    <li role="presentation" class="tab_historiales">
                        <a href="#tHisto4" aria-controls="tHisto4" role="tab" data-toggle="tab" id="tab_histo_4">IMG</a>
                    </li>
                    <li role="presentation" class="tab_historiales">
                        <a href="#tHisto5" aria-controls="tHisto5" role="tab" data-toggle="tab" id="tab_histo_5">END</a>
                    </li>
                    <li role="presentation" class="tab_historiales">
                        <a href="#tHisto6" aria-controls="tHisto6" role="tab" data-toggle="tab" id="tab_histo_6">COL</a>
                    </li>
                    <li role="presentation" class="tab_historiales">
                        <a href="#tHisto7" aria-controls="tHisto7" role="tab" data-toggle="tab"
                            id="tab_histo_7">CNTS</a>
                    </li>
                </ul>

                <!-- Tab panes -->
                <div class="tab-content no_img_h">
                    <div role="tabpanel" class="tab-pane active" id="tHisto1">
                        <br>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="tHisto2">
                        <table width="100%" border="0">
                            <tr>
                                <td width="30%">
                                    <table width="100%" height="100%"
                                        class="table table-bordered table-hover table-condensed table-striped"
                                        id="dataTableHLab">
                                        <thead>
                                            <tr class="bg-info">
                                                <th id="clickmeHLab">#</th>
                                                <th align="center">FECHA</th>
                                                <th align="center">
                                                    ESTUDIO
                                                    <button type="button" class="btn btn-default btn-xs" id="">
                                                        <i class="fa fa-caret-left" aria-hidden="true"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-default btn-xs" id="">
                                                        <i class="fa fa-caret-right" aria-hidden="true"></i>
                                                    </button>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody align="left">
                                            <tr>
                                                <td class="dataTables_empty">Cargando datos del servidor</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                                <td valign="top">
                                    <!-- Nav tabs -->
                                    <ul class="nav nav-tabs" role="tablist" id="tabs_sub_histos"
                                        style="margin-top:6px;">
                                        <li role="presentation" class="tab_sub_histos active">
                                            <a href="#tHLab" aria-controls="tHLab" role="tab" data-toggle="tab"
                                                id="tab_histo_lab">RESULTADOS</a>
                                        </li>
                                    </ul>
                                    <!-- Tab panes -->
                                    <div class="tab-content">
                                        <div role="tabpanel" class="tab-pane active" id="tHLab" align="center"
                                            style="height:100px; overflow:scroll; vertical-align:top; border:1px none red;">

                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="tHisto3">
                        <table width="100%" border="0">
                            <tr>
                                <td width="30%">
                                    <table width="100%" height="100%"
                                        class="table table-bordered table-hover table-condensed table-striped"
                                        id="dataTableHusg">
                                        <thead>
                                            <tr class="bg-info">
                                                <th id="clickmeHusg">#</th>
                                                <th align="center">FECHA</th>
                                                <th align="center">
                                                    ESTUDIO
                                                    <button type="button" class="btn btn-default btn-xs" id="">
                                                        <i class="fa fa-caret-left" aria-hidden="true"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-default btn-xs" id="">
                                                        <i class="fa fa-caret-right" aria-hidden="true"></i>
                                                    </button>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody align="left">
                                            <tr>
                                                <td class="dataTables_empty">Cargando datos del servidor</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                                <td valign="top">
                                    <!-- Nav tabs -->
                                    <ul class="nav nav-tabs" role="tablist" id="tabs_sub_histosU"
                                        style="margin-top:6px;">
                                        <li role="presentation" class="tab_sub_histosU active">
                                            <a href="#tHusg" aria-controls="tHusg" role="tab" data-toggle="tab"
                                                id="tab_histo_usg">INTERPRETACIÓN</a>
                                        </li>
                                        <li role="presentation" class="tab_sub_histosU">
                                            <a href="#tHusg1" aria-controls="tHusg1" role="tab" data-toggle="tab"
                                                id="tab_histo_usg1">IMÁGENES</a>
                                        </li>
                                    </ul>
                                    <!-- Tab panes -->
                                    <div class="tab-content">
                                        <div role="tabpanel" class="tab-pane active" id="tHusg" align="center"
                                            style="height:100px; overflow:scroll; vertical-align:top; border:1px none red;">
                                            <table width="100%" class="table table-condensed table-bordered">
                                                <tr>
                                                    <td id="dx_ehu" align="left" valign="top"> </td>
                                                </tr>
                                                <tr height="1px">
                                                    <td nowrap align="right" id="doctor_ehu"></td>
                                                </tr>
                                            </table>
                                        </div>
                                        <div role="tabpanel" class="tab-pane" id="tHusg1" align="center"
                                            style="height:100px; overflow:scroll; vertical-align:top; border:1px none red;">
                                            <table width="100%" border="0" class="table table-condensed table-bordered">
                                                <tr>
                                                    <td id="deCanvas1" align="center" valign="top" align="center"></td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="tHisto4">
                        <table width="100%" border="0">
                            <tr>
                                <td width="30%">
                                    <table width="100%" height="100%"
                                        class="table table-bordered table-hover table-condensed table-striped"
                                        id="dataTableHimg">
                                        <thead>
                                            <tr class="bg-info">
                                                <th id="clickmeHimg">#</th>
                                                <th align="center">FECHA</th>
                                                <th align="center">
                                                    ESTUDIO
                                                    <button type="button" class="btn btn-default btn-xs" id="">
                                                        <i class="fa fa-caret-left" aria-hidden="true"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-default btn-xs" id="">
                                                        <i class="fa fa-caret-right" aria-hidden="true"></i>
                                                    </button>
                                                </th>
                                                <th align="center" style="width:1px;">PACS</th>
                                            </tr>
                                        </thead>
                                        <tbody align="left">
                                            <tr>
                                                <td class="dataTables_empty">Cargando datos del servidor</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                                <td valign="top">
                                    <!-- Nav tabs -->
                                    <ul class="nav nav-tabs" role="tablist" id="tabs_sub_histosIm"
                                        style="margin-top:6px;">
                                        <li role="presentation" class="tab_sub_histosIm active">
                                            <a href="#tHimg" aria-controls="tHimg" role="tab" data-toggle="tab"
                                                id="tab_histo_img">INTERPRETACIÓN</a>
                                        </li>
                                        <li role="presentation" class="tab_sub_histosIm">
                                            <a href="#tHimg2" aria-controls="tHimg2" role="tab" data-toggle="tab"
                                                id="tab_histo_img2">CAPTURAS</a>
                                        </li>
                                    </ul>
                                    <!-- Tab panes -->
                                    <div class="tab-content">
                                        <div role="tabpanel" class="tab-pane active" id="tHimg" align="center"
                                            style="height:100px; overflow:scroll; vertical-align:top; border:1px none red;">
                                            <table width="100%" class="table table-condensed table-bordered">
                                                <tr>
                                                    <td id="dx_ehi" align="left" valign="top"> </td>
                                                </tr>
                                                <!--<tr height="1px"> <td nowrap align="right" id="doctor_ehi"></td> </tr> -->
                                            </table>
                                        </div>
                                        <div role="tabpanel" class="tab-pane" id="tHimg2" align="center"
                                            style="height:100px; overflow:scroll; vertical-align:top; border:1px none red;">
                                            <table width="100%" border="0" class="table table-condensed table-bordered">
                                                <tr>
                                                    <td id="deCanvas2i" align="center" valign="top" align="center"></td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="tHisto5">
                        <table width="100%" border="0">
                            <tr>
                                <td width="30%">
                                    <table width="100%" height="100%"
                                        class="table table-bordered table-hover table-condensed table-striped"
                                        id="dataTableHend">
                                        <thead>
                                            <tr class="bg-info">
                                                <th id="clickmeHend">#</th>
                                                <th align="center">FECHA</th>
                                                <th align="center">
                                                    ESTUDIO
                                                    <button type="button" class="btn btn-default btn-xs" id="">
                                                        <i class="fa fa-caret-left" aria-hidden="true"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-default btn-xs" id="">
                                                        <i class="fa fa-caret-right" aria-hidden="true"></i>
                                                    </button>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody align="left">
                                            <tr>
                                                <td class="dataTables_empty">Cargando datos del servidor</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                                <td valign="top">
                                    <!-- Nav tabs -->
                                    <ul class="nav nav-tabs" role="tablist" id="tabs_sub_histosEn"
                                        style="margin-top:6px;">
                                        <li role="presentation" class="tab_sub_histosEn active">
                                            <a href="#tHend" aria-controls="tHend" role="tab" data-toggle="tab"
                                                id="tab_histo_end">INTERPRETACIÓN</a>
                                        </li>
                                        <li role="presentation" class="tab_sub_histosEn">
                                            <a href="#tHend1" aria-controls="tHend1" role="tab" data-toggle="tab"
                                                id="tab_histo_end1">IMÁGENES</a>
                                        </li>
                                    </ul>
                                    <!-- Tab panes -->
                                    <div class="tab-content">
                                        <div role="tabpanel" class="tab-pane active" id="tHend" align="center"
                                            style="height:100px; overflow:scroll; vertical-align:top; border:1px none red;">
                                            <table width="100%" class="table table-condensed table-bordered">
                                                <tr>
                                                    <td id="dx_ehe" align="left" valign="top"> </td>
                                                </tr>
                                                <tr height="1px">
                                                    <td nowrap align="right" id="doctor_ehe"></td>
                                                </tr>
                                            </table>
                                        </div>
                                        <div role="tabpanel" class="tab-pane" id="tHend1" align="center"
                                            style="height:100px; overflow:scroll; vertical-align:top; border:1px none red;">
                                            <table width="100%" border="0" class="table table-condensed table-bordered">
                                                <tr>
                                                    <td id="deCanvas1e" align="center" valign="top" align="center"></td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="tHisto6">
                        <table width="100%" border="0">
                            <tr>
                                <td width="30%">
                                    <table width="100%" height="100%"
                                        class="table table-bordered table-hover table-condensed table-striped"
                                        id="dataTableHcol">
                                        <thead>
                                            <tr class="bg-info">
                                                <th id="clickmeHcol">#</th>
                                                <th align="center">FECHA</th>
                                                <th align="center">
                                                    ESTUDIO
                                                    <button type="button" class="btn btn-default btn-xs" id="">
                                                        <i class="fa fa-caret-left" aria-hidden="true"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-default btn-xs" id="">
                                                        <i class="fa fa-caret-right" aria-hidden="true"></i>
                                                    </button>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody align="left">
                                            <tr>
                                                <td class="dataTables_empty">Cargando datos del servidor</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                                <td valign="top">
                                    <!-- Nav tabs -->
                                    <ul class="nav nav-tabs" role="tablist" id="tabs_sub_histosCo"
                                        style="margin-top:6px;">
                                        <li role="presentation" class="tab_sub_histosCo active">
                                            <a href="#tHcol" aria-controls="tHcol" role="tab" data-toggle="tab"
                                                id="tab_histo_col">INTERPRETACIÓN</a>
                                        </li>
                                        <li role="presentation" class="tab_sub_histosCo">
                                            <a href="#tHcol1" aria-controls="tHcol1" role="tab" data-toggle="tab"
                                                id="tab_histo_col1">IMÁGENES</a>
                                        </li>
                                    </ul>
                                    <!-- Tab panes -->
                                    <div class="tab-content">
                                        <div role="tabpanel" class="tab-pane active" id="tHcol" align="center"
                                            style="height:100px; overflow:scroll; vertical-align:top; border:1px none red;">
                                            <table width="100%" class="table table-condensed table-bordered">
                                                <tr>
                                                    <td id="dx_ehc" align="left" valign="top"> </td>
                                                </tr>
                                                <tr height="1px">
                                                    <td nowrap align="right" id="doctor_ehc"></td>
                                                </tr>
                                            </table>
                                        </div>
                                        <div role="tabpanel" class="tab-pane" id="tHcol1" align="center"
                                            style="height:100px; overflow:scroll; vertical-align:top; border:1px none red;">
                                            <table width="100%" border="0" class="table table-condensed table-bordered">
                                                <tr>
                                                    <td id="deCanvas1c" align="center" valign="top" align="center"></td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="tHisto7">
                        <table width="100%" border="0">
                            <tr>
                                <td width="30%">
                                    <table width="100%" height="100%"
                                        class="table table-bordered table-hover table-condensed table-striped"
                                        id="dataTableHnot">
                                        <thead>
                                            <tr class="bg-info">
                                                <th id="clickmeHnot">#</th>
                                                <th align="center">FECHA</th>
                                                <th align="center">
                                                    CONCEPTO
                                                    <button type="button" class="btn btn-default btn-xs" id="">
                                                        <i class="fa fa-caret-left" aria-hidden="true"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-default btn-xs" id="">
                                                        <i class="fa fa-caret-right" aria-hidden="true"></i>
                                                    </button>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody align="left">
                                            <tr>
                                                <td class="dataTables_empty">Cargando datos del servidor</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                                <td valign="top">
                                    <!-- Nav tabs -->
                                    <ul class="nav nav-tabs" role="tablist" id="tabs_sub_histosNo"
                                        style="margin-top:6px;">
                                        <li role="presentation" class="tab_sub_histosNo active">
                                            <a href="#tHnot" aria-controls="tHnot" role="tab" data-toggle="tab"
                                                id="tab_histo_not">NOTA MÉDICA</a>
                                        </li>
                                        <li role="presentation" class="tab_sub_histosNo">
                                            <a href="#tHnot1" aria-controls="tHnot1" role="tab" data-toggle="tab"
                                                id="tab_histo_not1">RECETA</a>
                                        </li>
                                        <li role="presentation" class="tab_sub_histosNo">
                                            <a href="#tHnot2" aria-controls="tHnot2" role="tab" data-toggle="tab"
                                                id="tab_histo_not2">CAPTURAS</a>
                                        </li>
                                    </ul>
                                    <!-- Tab panes -->
                                    <div class="tab-content">
                                        <div role="tabpanel" class="tab-pane active" id="tHnot" align="center"
                                            style="height:100px; overflow:scroll; vertical-align:top; border:1px none red;">
                                            <table width="100%" class="table table-condensed table-bordered">
                                                <tr>
                                                    <td id="dx_ehn" align="left" valign="top"> </td>
                                                </tr>
                                                <tr height="1px">
                                                    <td nowrap align="right" id="doctor_ehn"></td>
                                                </tr>
                                            </table>
                                        </div>
                                        <div role="tabpanel" class="tab-pane" id="tHnot1" align="center"
                                            style="height:100px; overflow:scroll; vertical-align:top; border:1px none red;">
                                            <table width="100%" class="table table-condensed table-bordered">
                                                <tr>
                                                    <td id="dx_ehn1" align="left" valign="top"> </td>
                                                </tr>
                                                <tr height="1px">
                                                    <td nowrap align="right" id="doctor_ehn1"></td>
                                                </tr>
                                            </table>
                                        </div>
                                        <div role="tabpanel" class="tab-pane" id="tHnot2" align="center"
                                            style="height:100px; overflow:scroll; vertical-align:top; border:1px none red;">
                                            <table width="100%" border="0" class="table table-condensed table-bordered">
                                                <tr>
                                                    <td id="deCanvas1n" align="center" valign="top" align="center"></td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->