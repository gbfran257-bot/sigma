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

    <!-- Hay páginas del sistema que necesitan modales indepentiendes, aquí se verifica en qué página se está para cargar los modales correspondientes -->
    <?php if ($_SERVER['REQUEST_URI'] == "/sigmacruzroja/consultas.php") : ?>
        <div id="visualizar_medicamento_sinergias" class="modal fade" role="dialog" data-backdrop="false" data-keyboard="false"></div>
    <?php endif; ?>

    <?php if ($_SERVER['REQUEST_URI'] == "/sigmacruzroja/laboratorio.php") : ?>

    <?php endif; ?>
        <div id="modal_historial" class="modal fade" role="dialog" data-backdrop="false" data-keyboard="false"></div>

    <?php if ($_SERVER['REQUEST_URI'] == "/sigmacruzroja/pacientes.php") : ?>
        <div id="modal_nuevo_cliente" class="modal fade" role="dialog" data-backdrop="false" data-keyboard="false"></div>
    <?php endif; ?>
    
    </body>

    </html>