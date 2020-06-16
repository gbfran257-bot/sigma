<?php
	include_once 'recursos/session.php';
	include_once 'Connections/database.php';
	include_once 'recursos/utilities.php';
	include_once 'recursos/datauser.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="SISTEMA DE EXPEDIENTE CLÍNICO ELECTRÓNICO">
    <meta name="author" content="ING EMMANUEL ANZURES BAUTISTA">

	<title>PRINCIPAL</title>
    
    <link rel="shortcut icon" href="imagenes/favicon.ico" type="image/x-icon">
	<link rel="icon" href="imagenes/favicon.ico" type="image/x-icon">
    
    <!-- Mainly scripts -->
	<script src="js/jquery-3.2.1.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <script src="js/plugins/metisMenu/jquery.metisMenu.js"></script>
    <script src="js/plugins/slimscroll/jquery.slimscroll.min.js"></script>
    <!-- Custom and plugin javascript -->
    <script src="js/inspinia.js"></script>
    <script src="js/plugins/pace/pace.min.js"></script>
    <script src="DataTables-1.10.13/media/js/jquery.dataTables.min.js"></script>
    <script src="DataTables-1.10.13/media/js/dataTables.bootstrap.min.js"></script>
    <script src="DataTables-1.10.13/extensions/Scroller/js/dataTables.scroller.min.js"></script>
    <script src="DataTables-1.10.13/extensions/Select/js/dataTables.select.min.js"></script>
    <!-- Mis funciones -->
    <script src="funciones/js/inicio.js"></script>
    <script src="funciones/js/caracteres.js"></script>
    <script src="funciones/js/modulos/pacientes.js"></script>
    
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <link href="DataTables-1.10.13/media/css/dataTables.bootstrap.min.css" rel="stylesheet">
    <link href="DataTables-1.10.13/extensions/Scroller/css/scroller.bootstrap.min.css" rel="stylesheet">
    <link href="DataTables-1.10.13/extensions/Select/css/select.bootstrap.min.css" rel="stylesheet">
    <style>
        #inicio-menuPrincipal .menu{
            cursor: pointer;
        }
    </style>
</head>
<?php include_once 'partes/header.php'; ?>
<!-- Contenido -->
<p><h1 class="text-center text-primary"><?php echo $usuario_bienvenida; ?></h1></p>
<div style="width:80%" class="center-block">
    <br>
    <div class="row hidden animated activo" id="inicio-menuPrincipal">
        <?php if(substr($permisos,0,8) != "00000000"){?>
            <div class="col-md-2">
                <img src="imagenes/ig/Recepcion-01.png" class="img-responsive fadeInLeft wow menu" data-id="#inicio-menuRecepcion" data-wow-delay="0.1s">
            </div>
        <?php }?>
        <?php if(substr($permisos,8,4) != "0000"){?>
            <div class="col-md-2">
                <img src="imagenes/ig/Consultas1-01.png" class="img-responsive fadeInDown wow menu" data-id="#inicio-menuConsultas" data-wow-delay="0.2s">
            </div>
        <?php }?>
        <?php if($permisos[12]){?>
            <div class="col-md-2">
                <a href="enfermeria.php"><img src="imagenes/ig/Enfermeria-01.png" class="img-responsive fadeInRight wow menu" data-wow-delay="0.1s"></a>
            </div>
        <?php }?>
        <?php if(substr($permisos,13,2) != "00"){?>
            <div class="col-md-2">
                <img src="imagenes/ig/Hospital-01.png" class="img-responsive fadeInLeft wow menu" data-id="#inicio-menuHospital" data-wow-delay="0.25s">
            </div>
        <?php }?>
        <?php if(substr($permisos,15,7) != "0000000"){?>
            <div class="col-md-2">
                <img src="imagenes/ig/Imagen-01.png" class="img-responsive fadeIn wow menu" data-id="#inicio-menuImagen" data-wow-delay="0.35s">
            </div>
        <?php }?>
        <?php if(substr($permisos,22,6) != "000000"){?>
            <div class="col-md-2">
                <img src="imagenes/ig/Lab-01.png" class="img-responsive fadeInRight wow menu" data-id="#inicio-menuLaboratorio" data-wow-delay="0.25s">
            </div>
        <?php } ?>
        <?php if(substr($permisos,28,4) != "0000"){?>
            <div class="col-md-2">
                <img src="imagenes/menu/_servicios.png" class="img-responsive fadeInLeft wow menu" data-id="#inicio-menuServicios" data-wow-delay="0.1s">
            </div>
        <?php } ?>
        <?php if(substr($permisos,32,6) != "000000"){?>
            <div class="col-md-2">
                <img src="imagenes/ig/Farmacia-01.png" class="img-responsive fadeInUp wow menu" data-id="#inicio-menuFarmacia" data-wow-delay="0.2s">
            </div>
        <?php } ?>
        <?php if(substr($permisos,38,10) != "0000000000"){?>
            <div class="col-md-2">
                <img src="imagenes/ig/Admon-01.png" class="img-responsive fadeInRight wow menu" data-id="#inicio-menuAdmin" data-wow-delay="0.1s">
            </div>
        <?php } ?>
    </div>
    <div class="row hidden animated" id="inicio-menuRecepcion">
        <div class="col-md-12 text-center">
            <h1>Recepción</h1>
        </div>
        <?php if($permisos[0]){?>
            <div class="col-md-2">
                <a href="pacientes.php"><img src="imagenes/ig/Pacientes-01.png" class="img-responsive fadeInLeft wow menu" data-wow-delay="0.1s"></a>
            </div>
        <?php } ?>
        <?php if(substr($permisos,1,4) != "0000"){ ?>
            <div class="col-md-2">
                <img src="imagenes/ig/CorteCaja-01.png" class="img-responsive fadeInDown wow menu" data-id="#inicio-menuRecepcionCorte" data-wow-delay="0.2s">
            </div>
        <?php } ?>
        <?php if($permisos[5]){?>
            <div class="col-md-2">
                <a href="agenda.php"><img src="imagenes/ig/Agenda-01.png" class="img-responsive fadeIn wow menu" data-wow-delay="0.25s"></a>
            </div>
        <?php } ?>
        <?php if($permisos[7]){?>
            <div class="col-md-2">
                <a href="productividad_rec.php"><img src="imagenes/ig/Productividad-01.png" class="img-responsive fadeInRight wow menu" data-wow-delay="0.1s"></a>
            </div>
        <?php } ?>
        <div class="col-md-2">
            <img src="imagenes/ig/Inicio-01.png" class="img-responsive fadeInUp wow menu" data-wow-delay="0.3s" data-id="#inicio-menuPrincipal">
        </div>
    </div>
    <div class="row hidden animated" id="inicio-menuConsultas">
        <div class="col-md-12 text-center">
            <h1>Consultas</h1>
        </div>
        <?php if($permisos[8]){?>
            <div class="col-md-2">
                <a href="consultas.php"><img src="imagenes/ig/ConsultasMedicas-01.png" class="img-responsive fadeInLeft wow menu" data-wow-delay="0.1s"></a>
            </div>
        <?php } ?>
        <?php if($permisos[10]){?>
            <div class="col-md-2">
                <a href="catalogo_consultas.php"><img src="imagenes/ig/Catalogos-01.png" class="img-responsive fadeInDown wow menu" data-wow-delay="0.2s"></a>
            </div>
        <?php } ?>
        <?php if($permisos[11]){?>
            <div class="col-md-2">
                <a href="productividad_cst.php"><img src="imagenes/ig/Productividad-01.png" class="img-responsive fadeInRight wow menu" data-wow-delay="0.1s"></a>
            </div>
        <?php } ?>
        <div class="col-md-2">
            <img src="imagenes/ig/Inicio-01.png" class="img-responsive fadeInUp wow menu" data-wow-delay="0.3s" data-id="#inicio-menuPrincipal">
        </div>
    </div>
    <div class="row hidden animated" id="inicio-menuHospital">
        <div class="col-md-12 text-center">
            <h1>Hospital</h1>
        </div>
        <?php if($permisos[13]){?>
            <div class="col-md-2">
                <a href="hospitalizacion.php"><img src="imagenes/ig/Hospital-01.png" class="img-responsive fadeInLeft wow menu" data-wow-delay="0.1s"></a>
            </div>
        <?php } ?>
        <?php if($permisos[14]){?>
            <div class="col-md-2">
                <a href="camas.php"><img src="imagenes/ig/Camas-01.png" class="img-responsive fadeInRight wow menu" data-wow-delay="0.1s"></a>
            </div>
        <?php } ?>
        <div class="col-md-2">
            <img src="imagenes/ig/Inicio-01.png" class="img-responsive fadeInUp wow menu" data-wow-delay="0.2s" data-id="#inicio-menuPrincipal">
        </div>
    </div>
    <div class="row hidden animated" id="inicio-menuImagen">
        <div class="col-md-12 text-center">
            <h1>Imagen</h1>
        </div>
        <?php if($permisos[15]){?>
            <div class="col-md-2">
                <a href="imagen.php"><img src="imagenes/ig/Imagenologia-01.png" class="img-responsive fadeInLeft wow menu" data-wow-delay="0.1s"></a>
            </div>
        <?php } ?>
        <?php if($permisos[17]){?>
            <div class="col-md-2">
                <a href="endoscopia.php"><img src="imagenes/ig/Endoscopia-01.png" class="img-responsive fadeInDown wow menu" data-wow-delay="0.2s"></a>
            </div>
        <?php } ?>
        <?php if($permisos[18]){?>
            <div class="col-md-2">
                <a href="ultrasonido.php"><img src="imagenes/menu/_ultrasonido.png" class="img-responsive fadeInRight wow menu" data-wow-delay="0.1s"></a>
            </div>
        <?php } ?>
        <?php if($permisos[19]){?>
            <div class="col-md-2">
                <a href="colposcopia.php"><img src="imagenes/ig/Colposcopia-01.png" class="img-responsive fadeInLeft wow menu" data-wow-delay="0.1s"></a>
            </div>
        <?php } ?>
        <?php if($permisos[20]){?>
            <div class="col-md-2">
                <a href="catalogo_imagen.php"><img src="imagenes/ig/Catalogos-01.png" class="img-responsive fadeInDown wow menu" data-wow-delay="0.2s"></a>
            </div>
        <?php } ?>
        <?php if($permisos[21]){?>
            <div class="col-md-2">
                <a href="productividad_img.php"><img src="imagenes/ig/Productividad-01.png" class="img-responsive fadeInRight wow menu" data-wow-delay="0.1s"></a>
            </div>
        <?php } ?>
        <div class="col-md-2">
            <img src="imagenes/ig/Inicio-01.png" class="img-responsive fadeInUp wow menu" data-wow-delay="0.3s" data-id="#inicio-menuPrincipal">
        </div>
    </div>
    <div class="row hidden animated" id="inicio-menuLaboratorio">
        <div class="col-md-12 text-center">
            <h1>Laboratorios</h1>
        </div>
        <?php if($permisos[22]){?>
            <div class="col-md-2">
                <a href="laboratorio.php"><img src="imagenes/ig/EstudiosLab-01.png" class="img-responsive fadeInLeft wow menu" data-wow-delay="0.1s"></a>
            </div>
        <?php } ?>
        <?php if($permisos[24]){?>
            <div class="col-md-2">
                <a href="bases_lab.php"><img src="imagenes/ig/Bases-01.png" class="img-responsive fadeInDown wow menu" data-wow-delay="0.2s"></a>
            </div>
        <?php } ?>
        <?php if($permisos[25]){?>
            <div class="col-md-2">
                <a href="bitacora_lab.php"><img src="imagenes/ig/Bitacoras-01.png" class="img-responsive fadeInRight wow menu" data-wow-delay="0.1s"></a>
            </div>
        <?php } ?>
        <?php if($permisos[26]){?>
            <div class="col-md-2">
                <a href="catalogo_laboratorio.php"><img src="imagenes/ig/Catalogos-01.png" class="img-responsive fadeInDown wow menu" data-wow-delay="0.2s"></a>
            </div>
        <?php } ?>
        <?php if($permisos[27]){?>
            <div class="col-md-2">
                <a href="productividad_lab.php"><img src="imagenes/ig/Productividad-01.png" class="img-responsive fadeInRight wow menu" data-wow-delay="0.1s"></a>
            </div>
        <?php } ?>
        <div class="col-md-2">
            <img src="imagenes/ig/Inicio-01.png" class="img-responsive fadeInUp wow menu" data-wow-delay="0.3s" data-id="#inicio-menuPrincipal">
        </div>
    </div>
    <div class="row hidden animated" id="inicio-menuServicios">
        <div class="col-md-12 text-center">
            <h1>Servicios</h1>
        </div>
        <?php if($permisos[28]){ ?>
            <div class="col-md-2">
                <a href="servicios.php"><img src="imagenes/menu/_servicios_m.png" class="img-responsive fadeInLeft wow menu" data-wow-delay="0.1s"></a>
            </div>
        <?php } ?>
        <?php if($permisos[30]){ ?>
            <div class="col-md-2">
                <a href="catalogo_servicios.php"><img src="imagenes/ig/Catalogos-01.png" class="img-responsive fadeInDown wow menu" data-wow-delay="0.2s"></a>
            </div>
        <?php } ?>
        <?php if($permisos[31]){ ?>
            <div class="col-md-2">
                <a href="productividad_ser.php"><img src="imagenes/ig/Productividad-01.png" class="img-responsive fadeInRight wow menu" data-wow-delay="0.1s"></a>
            </div>
        <?php } ?>
        <div class="col-md-2">
            <img src="imagenes/ig/Inicio-01.png" class="img-responsive fadeInUp wow menu" data-wow-delay="0.3s" data-id="#inicio-menuPrincipal">
        </div>
    </div>
    <div class="row hidden animated" id="inicio-menuFarmacia">
        <div class="col-md-12 text-center">
            <h1>Farmacia</h1>
        </div>
        <?php if($permisos[33]){?>
            <div class="col-md-2">
                <a href="catalogo_medicamentos.php"><img src="imagenes/ig/Medicamentos-01.png" class="img-responsive fadeInLeft wow menu" data-wow-delay="0.1s"></a>
            </div>
        <?php } ?>
        <?php if($permisos[34]){?>
            <div class="col-md-2">
                <a href="#"><img src="imagenes/ig/Productos-01.png" class="img-responsive fadeInDown wow menu" data-wow-delay="0.2s"></a>
            </div>
        <?php } ?>
        <?php if($permisos[35]){?>
            <div class="col-md-2">
                <a href="#"><img src="imagenes/ig/CorteCaja-01.png" class="img-responsive fadeInRight wow menu" data-wow-delay="0.1s"></a>
            </div>
        <?php } ?>
        <?php if($permisos[36]){?>
            <div class="col-md-2">
                <a href="#"><img src="imagenes/menu/_stock.png" class="img-responsive fadeInLeft wow menu" data-wow-delay="0.1s"></a>
            </div>
        <?php } ?>
        <?php if($permisos[37]){?>
            <div class="col-md-2">
                <a href="productividad_far.php"><img src="imagenes/ig/Productividad-01.png" class="img-responsive fadeInRight wow menu" data-wow-delay="0.1s"></a>
            </div>
        <?php } ?>
        <div class="col-md-2">
            <img src="imagenes/ig/Inicio-01.png" class="img-responsive fadeInUp wow menu" data-wow-delay="0.3s" data-id="#inicio-menuPrincipal">
        </div>
    </div>
    <div class="row hidden animated" id="inicio-menuAdmin">
        <div class="col-md-12 text-center">
            <h1>Administración</h1>
        </div>
        <?php if($permisos[38]){?>
            <div class="col-md-2">
                <a href="usuarios.php"><img src="imagenes/menu/_usuarios.png" class="img-responsive fadeInLeft wow menu" data-wow-delay="0.1s"></a>
            </div>
        <?php } ?>
        <?php if($permisos[39]){?>
            <div class="col-md-2">
                <a href="sucursales.php"><img src="imagenes/menu/_sucursales.png" class="img-responsive fadeInLeft wow menu" data-wow-delay="0.1s"></a>
            </div>
        <?php } ?>
        <?php if($permisos[40]){?>
            <div class="col-md-2">
                <a href="escuelas.php"><img src="imagenes/menu/_sucursales.png" class="img-responsive fadeInLeft wow menu" data-wow-delay="0.1s"></a> Escuelas
            </div>
        <?php } ?>
        <?php if(substr($permisos,41,3) != "000"){?>
            <div class="col-md-2">
                <img src="imagenes/ig/CorteCaja-01.png" class="img-responsive fadeInDown wow menu" data-id="#inicio-menuAdminCorte" data-wow-delay="0.2s">
            </div>
        <?php } ?>
        <?php if($permisos[44]){?>
            <div class="col-md-2">
                <a href="#"><img src="imagenes/ig/Beneficios-01.png" class="img-responsive fadeInLeft wow menu" data-wow-delay="0.1s"></a>
            </div>
        <?php } ?>
        <?php if($permisos[45]){?>
            <div class="col-md-2">
                <a href="formatos.php"><img src="imagenes/ig/Formatos-01.png" class="img-responsive fadeInDown wow menu" data-wow-delay="0.2s"></a>
            </div>
        <?php } ?>
        <div class="col-md-2">
            <img src="imagenes/ig/Inicio-01.png" class="img-responsive fadeInUp wow menu" data-wow-delay="0.3s" data-id="#inicio-menuPrincipal">
        </div>
    </div>
    <div class="row hidden animated" id="inicio-menuRecepcionCorte">
        <div class="col-md-12 text-center">
            <h1>Recepción -> Corte de caja</h1>
        </div>
        <?php if($permisos[1]){?>
            <div class="col-md-2">
                <a href="ordenes_venta_r.php"><img src="imagenes/ig/OrdenVenta-01.png" class="img-responsive fadeInDown wow menu" data-wow-delay="0.2s"></a>
            </div>
        <?php } ?>
        <?php if($permisos[3]){?>
            <div class="col-md-2">
                <a href="pagos_usuario_r.php"><img src="imagenes/ig/PagosPendientes-01.png" class="img-responsive fadeInRight wow menu" data-wow-delay="0.1s"></a>
            </div>
        <?php } ?>
        <?php if($permisos[4]){?>
            <div class="col-md-2">
                <a href="resumen_cc_r.php"><img src="imagenes/menu/_resumen_ventas.png" class="img-responsive fadeInLeft wow menu" data-wow-delay="0.1s"></a>
            </div>
        <?php } ?>

        <div class="col-md-2">
            <img src="imagenes/ig/Inicio-01.png" class="img-responsive fadeInUp wow menu" data-wow-delay="0.3s" data-id="#inicio-menuPrincipal">
        </div>
    </div>
    <div class="row hidden animated" id="inicio-menuAdminCorte">
        <div class="col-md-12 text-center">
            <h1>Admin -> Corte de caja</h1>
        </div>
        <?php if($permisos[1]){?>
            <div class="col-md-2">
                <a href="ordenes_venta_a.php"><img src="imagenes/ig/OrdenVenta-01.png" class="img-responsive fadeInDown wow menu" data-wow-delay="0.2s"></a>
            </div>
        <?php } ?>
        <?php if($permisos[3]){?>
            <div class="col-md-2">
                <a href="pagos_usuario_a.php"><img src="imagenes/ig/PagosPendientes-01.png" class="img-responsive fadeInRight wow menu" data-wow-delay="0.1s"></a>
            </div>
        <?php } ?>
        <?php if($permisos[4]){?>
            <div class="col-md-2">
                <a href="resumen_cc.php"><img src="imagenes/menu/_resumen_ventas.png" class="img-responsive fadeInLeft wow menu" data-wow-delay="0.1s"></a>
            </div>
        <?php } ?>

        <div class="col-md-2">
            <img src="imagenes/ig/Inicio-01.png" class="img-responsive fadeInUp wow menu" data-wow-delay="0.3s" data-id="#inicio-menuPrincipal">
        </div>
    </div>
</div>
<!-- FIN Contenido -->  
<?php include_once 'partes/footer.php'; ?>
<script src="js/plugins/wow/wow.min.js"></script>
<script>
    function reset($elem) {
        $elem.before($elem.clone(true));
        var $newElem = $elem.prev();
        $elem.remove();
        return $newElem;
    } // end reset()

    $("#button").click(function () {
        var $this = $(this);
        $this.removeClass();
        $this = reset($this);
        $this.addClass("fadeInDown");
    });
    var esto_;
$(document).ready(function(e) {
    //breadcrumb
   new WOW().init();
	$('#breadc').html('<li class="active"><strong>HOME</strong></li>');
	
    $('#container').height($('#referencia').height()-$('#my_nav').height()-$('#my_footer').height()-$('#breadc').height()-7);
    $("#inicio-menuPrincipal").removeClass("hidden");
    $(".menu").click(function(){
        if($(this).attr("data-id") != undefined){
            esto_ = $(this).attr("data-id");
            $(".activo").addClass("fadeOutLeft");
            console.log(esto_);
            setTimeout(function(){
                $(".activo").addClass("hidden");
                $(".activo").removeClass("fadeOutLeft");
                $(".activo .menu").each(function(e){
                    reset($(this));
                });
                $(".activo").removeClass("activo");
                $(esto_).removeClass("hidden");
                $(esto_).addClass("activo");
            }, 200);
        }
    });
});
</script>
