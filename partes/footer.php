    </div><!--FIN de contenido -->

    <div class="navbar-inverse" id="my_footer" style="border-radius:0px;">
        <div class="pull-right hidden"> 10GB of <strong>250GB</strong> Free. </div>
        <div> &copy; <strong>GLOSS</strong> <?php echo date('Y'); ?>. TODOS LOS DERECHOS RESERVADOS. </div>
    </div>

    </div> <!--FIN de page-wrapper -->

    <div id="users-device-size" style="display:none;">
        <div id="xs" class="visible-xs"></div>
        <div id="sm" class="visible-sm"></div>
        <div id="md" class="visible-md"></div>
        <div id="lg" class="visible-lg"></div>
    </div>

    <div id="myModal" class="modal fade" role="dialog" data-backdrop="false" data-keyboard="false"> </div>
    <div id="myModal2" class="modal fade" tabindex="-1" role="dialog" data-backdrop="false" data-keyboard="false"> </div>
    <div id="myModal3" class="modal fade" tabindex="-1" role="dialog" data-backdrop="false" data-keyboard="false"> </div>
    <div id="myModal4" class="modal fade" tabindex="-1" role="dialog" data-backdrop="false" data-keyboard="false"> </div>
    <div id="myModalx" class="modal fade modal-fullscreen" tabindex="-1" role="dialog" data-backdrop="false" data-keyboard="false"> </div>
    <div id="myModal1" class="modal fade" role="dialog" data-backdrop="false" data-keyboard="false"> </div>

    <!--Comprobamos el servidor para cargar los recursos dependiendo de la página en la que se esté-->
    <?php if ($_SERVER['SERVER_NAME'] == "localhost") : ?>
        <!--Laboratorio-->
        <?php if ($_SERVER['REQUEST_URI'] == "/sigma/laboratorio.php" || strpos($_SERVER['REQUEST_URI'], "/laboratorio.php") !== false) : ?>
            <div id="modal_historial" class="modal fade" role="dialog" data-backdrop="false" data-keyboard="false"></div>
        <?php endif; ?>

        <!--Consultas-->
        <?php if ($_SERVER['REQUEST_URI'] == "/sigma/consultas.php" || strpos($_SERVER['REQUEST_URI'], "/consultas.php") !== false) : ?>
            <div id="visualizar_medicamento_sinergias" class="modal fade" role="dialog" data-backdrop="false" data-keyboard="false"></div>
            <div id="modal_ver_archivos" class="modal fade" role="dialog" data-backdrop="false" data-keyboard="false"></div>
        <?php endif; ?>

        <!--Pacientes-->
        <?php if ($_SERVER['REQUEST_URI'] == "/sigma/pacientes.php" || $_SERVER['REQUEST_URI'] == "/sigma/pacientes.php?nuevo-proveedor=true" || strpos($_SERVER['REQUEST_URI'], "/pacientes.php") !== false || strpos($_SERVER['REQUEST_URI'], "/pacientes.php?nuevo-proveedor=true") !== false) : ?>
            <div id="modal_nuevo_cliente" class="modal fade" role="dialog" data-backdrop="false" data-keyboard="false"></div>
            <div id="modal_agregar_cantidad_productos" class="modal fade" role="dialog" data-backdrop="false" data-keyboard="false"></div>
            <div id="modal_ver_factura" class="modal fade" role="dialog" data-backdrop="false" data-keyboard="false"></div>
        <?php endif; ?>

        <!--Stock-->
        <?php if ($_SERVER['REQUEST_URI'] == "/sigma/stock.php" || $_SERVER['REQUEST_URI'] == "/sigma/stock.php?nueva_transferencia=true" || strpos($_SERVER['REQUEST_URI'], "/stock.php") !== false || strpos($_SERVER['REQUEST_URI'], "/stock.php?nueva_transferencia=true") !== false) : ?>
            <div id="modal_agregar_cantidad_productos" class="modal fade" role="dialog" data-backdrop="false" data-keyboard="false"></div>
            <div id="modal_impresion_hoja_entrega" class="modal fade" role="dialog" data-backdrop="false" data-keyboard="false"></div>
        <?php endif; ?>

        <!--Compras-->
        <?php if ($_SERVER['REQUEST_URI'] == "/sigma/compras.php" || strpos($_SERVER['REQUEST_URI'], "/compras.php") !== false) : ?>
            <div id="modal_ver_factura_compra" class="modal fade" role="dialog" data-backdrop="false" data-keyboard="false"></div>
        <?php endif; ?>

        <!--Transferencias-->
        <?php if ($_SERVER['REQUEST_URI'] == "/sigma/transferencias.php" || strpos($_SERVER['REQUEST_URI'], "/transferencias.php") !== false) : ?>
            <div id="modal_ver_factura_compra" class="modal fade" role="dialog" data-backdrop="false" data-keyboard="false"></div>
            <div id="modal_resumen_transferencia" class="modal fade" role="dialog" data-backdrop="false" data-keyboard="false"></div>
            <div id="modal_reporte_entrega_transferencias" class="modal fade" role="dialog" data-backdrop="false" data-keyboard="false"></div>
        <?php endif; ?>

        <!--Transferencias resumen-->
        <?php if ($_SERVER['REQUEST_URI'] == "/sigma/transferencias_resumen.php" || strpos($_SERVER['REQUEST_URI'], "/transferencias_resumen.php") !== false) : ?>
            <div id="modal_reporte_entrega_transferencias" class="modal fade" role="dialog" data-backdrop="false" data-keyboard="false"></div>
            <div id="modal_ver_factura_compra" class="modal fade" role="dialog" data-backdrop="false" data-keyboard="false"></div>
        <?php endif; ?>

        <!--Pedidos-->
        <?php if ($_SERVER['REQUEST_URI'] == "/sigma/pedidos.php" || strpos($_SERVER['REQUEST_URI'], "/pedidos.php") !== false) : ?>
            <div id="modal_impresion_reporte_pedidos" class="modal fade" role="dialog" data-backdrop="false" data-keyboard="false"></div>
        <?php endif; ?>

        <!--Inventario-->
        <?php if ($_SERVER['REQUEST_URI'] == "/sigma/inventario.php") : ?>
            <div id="modal_agregar_cantidad_productos" class="modal fade" role="dialog" data-backdrop="false" data-keyboard="false"></div>
        <?php endif; ?>

        <!--hospitalizacion-->
        <?php if ($_SERVER['REQUEST_URI'] == "/hospitalizacion.php" || strpos($_SERVER['REQUEST_URI'], "/hospitalizacion.php") !== false) : ?>
            <div id="modal_ver_archivos" class="modal fade" role="dialog" data-backdrop="false" data-keyboard="false"></div>
        <?php endif; ?>
    <?php else : ?>
        <!--Laboratorio-->
        <?php if ($_SERVER['REQUEST_URI'] == "/laboratorio.php" || strpos($_SERVER['REQUEST_URI'], "/laboratorio.php") !== false) : ?>
            <div id="modal_historial" class="modal fade" role="dialog" data-backdrop="false" data-keyboard="false"></div>
        <?php endif; ?>

        <!--Consultas-->
        <?php if ($_SERVER['REQUEST_URI'] == "/consultas.php" || strpos($_SERVER['REQUEST_URI'], "/consultas.php") !== false) : ?>
            <div id="visualizar_medicamento_sinergias" class="modal fade" role="dialog" data-backdrop="false" data-keyboard="false"></div>
            <div id="modal_ver_archivos" class="modal fade" role="dialog" data-backdrop="false" data-keyboard="false"></div>
        <?php endif; ?>

        <!--Pacientes-->
        <?php if ($_SERVER['REQUEST_URI'] == "/pacientes.php" || $_SERVER['REQUEST_URI'] == "/pacientes.php?nuevo-proveedor=true" || strpos($_SERVER['REQUEST_URI'], "/pacientes.php") !== false || strpos($_SERVER['REQUEST_URI'], "/pacientes.php?nuevo-proveedor=true") !== false) : ?>
            <div id="modal_nuevo_cliente" class="modal fade" role="dialog" data-backdrop="false" data-keyboard="false"></div>
            <div id="modal_agregar_cantidad_productos" class="modal fade" role="dialog" data-backdrop="false" data-keyboard="false"></div>
            <div id="modal_ver_factura" class="modal fade" role="dialog" data-backdrop="false" data-keyboard="false"></div>
        <?php endif; ?>

        <!--Stock-->
        <?php if ($_SERVER['REQUEST_URI'] == "/stock.php" || $_SERVER['REQUEST_URI'] == "/stock.php?nueva_transferencia=true" || strpos($_SERVER['REQUEST_URI'], "/stock.php") !== false || strpos($_SERVER['REQUEST_URI'], "/stock.php?nueva_transferencia=true") !== false) : ?>
            <div id="modal_agregar_cantidad_productos" class="modal fade" role="dialog" data-backdrop="false" data-keyboard="false"></div>
            <div id="modal_impresion_hoja_entrega" class="modal fade" role="dialog" data-backdrop="false" data-keyboard="false"></div>
        <?php endif; ?>

        <!--Compras-->
        <?php if ($_SERVER['REQUEST_URI'] == "/compras.php" || strpos($_SERVER['REQUEST_URI'], "/compras.php") !== false) : ?>
            <div id="modal_ver_factura_compra" class="modal fade" role="dialog" data-backdrop="false" data-keyboard="false"></div>
        <?php endif; ?>

        <!--Transferencias-->
        <?php if ($_SERVER['REQUEST_URI'] == "/transferencias.php" || strpos($_SERVER['REQUEST_URI'], "/transferencias.php") !== false) : ?>
            <div id="modal_ver_factura_compra" class="modal fade" role="dialog" data-backdrop="false" data-keyboard="false"></div>
            <div id="modal_resumen_transferencia" class="modal fade" role="dialog" data-backdrop="false" data-keyboard="false"></div>
            <div id="modal_reporte_entrega_transferencias" class="modal fade" role="dialog" data-backdrop="false" data-keyboard="false"></div>
        <?php endif; ?>

        <!--Transferencias resumen-->
        <?php if ($_SERVER['REQUEST_URI'] == "/sigma/transferencias_resumen.php" || strpos($_SERVER['REQUEST_URI'], "/transferencias_resumen.php") !== false) : ?>
            <div id="modal_reporte_entrega_transferencias" class="modal fade" role="dialog" data-backdrop="false" data-keyboard="false"></div>
            <div id="modal_ver_factura_compra" class="modal fade" role="dialog" data-backdrop="false" data-keyboard="false"></div>
        <?php endif; ?>

        <!--Pedidos-->
        <?php if ($_SERVER['REQUEST_URI'] == "/pedidos.php" || strpos($_SERVER['REQUEST_URI'], "/pedidos.php") !== false) : ?>
            <div id="modal_impresion_reporte_pedidos" class="modal fade" role="dialog" data-backdrop="false" data-keyboard="false"></div>
        <?php endif; ?>

        <!--Inventario-->
        <?php if ($_SERVER['REQUEST_URI'] == "/inventario.php") : ?>
            <div id="modal_agregar_cantidad_productos" class="modal fade" role="dialog" data-backdrop="false" data-keyboard="false"></div>
        <?php endif; ?>

        <!--hospitalizacion-->
        <?php if ($_SERVER['REQUEST_URI'] == "/hospitalizacion.php" || strpos($_SERVER['REQUEST_URI'], "/hospitalizacion.php") !== false) : ?>
            <div id="modal_ver_archivos" class="modal fade" role="dialog" data-backdrop="false" data-keyboard="false"></div>
        <?php endif; ?>
    <?php endif; ?>
    </body>

    </html>
