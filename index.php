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
        <div class="row animated alin">
            <?php if(substr($permisos,0,7) != "0000000"){?>
                <div class="col-md-2">
                    <img src="imagenes/ig/Recepcion-01.png" class="img-responsive fadeInLeft wow menu" data-id="#inicio-menuRecepcion" data-wow-delay="0.1s"
                    id='principal_rec_img'
                    onmouseenter="cambiar(this.id);" 
                    onmouseleave="returner(this.id);">
                </div>
            <?php }?>
            <?php if(substr($permisos,8,3) != "000"){?>
                <div class="col-md-2">
                    <img src="imagenes/ig/Consultas1-01.png" class="img-responsive fadeInDown wow menu" data-id="#inicio-menuConsultas" data-wow-delay="0.2s"
                    id="principal_consultas"
                    onmouseenter="cambiar(this.id);" 
                    onmouseleave="returner(this.id);"
                    >
                </div>
            <?php }?>
            <?php if($permisos[12]){?>
                <div class="col-md-2">
                    <a href="enfermeria.php"><img src="imagenes/ig/Enfermeria-01.png" class="img-responsive fadeInRight wow menu" data-wow-delay="0.1s"
                    id="principal_enfermeria"
                    onmouseenter="cambiar(this.id);" 
                    onmouseleave="returner(this.id);"
                    >
                    </a>
                </div>
            <?php }?>
            <?php if(substr($permisos,13,2) != "00"){?>
                <div class="col-md-2">
                    <img src="imagenes/ig/Hospital-01.png" class="img-responsive fadeInLeft wow menu" data-id="#inicio-menuHospital" data-wow-delay="0.25s"
                    id="principal_hospital"
                    onmouseenter="cambiar(this.id);" 
                    onmouseleave="returner(this.id);">
                </div>
            <?php }?>
        </div>
        <div class="row animated alin">
            <?php if(substr($permisos,15,6) != "000000"){?>
                <div class="col-md-2">
                    <img src="imagenes/ig/Imagen-01.png" class="img-responsive fadeIn wow menu" data-id="#inicio-menuImagen" data-wow-delay="0.35s"
                    id="principal_imagen"
                    onmouseenter="cambiar(this.id);" 
                    onmouseleave="returner(this.id);">
                </div>
            <?php }?>
            <?php if(substr($permisos,22,5) != "00000"){?>
                <div class="col-md-2">
                    <img src="imagenes/ig/Lab-01.png" class="img-responsive fadeInRight wow menu" data-id="#inicio-menuLaboratorio" data-wow-delay="0.25s"
                    id="principal_lab"
                    onmouseenter="cambiar(this.id);" 
                    onmouseleave="returner(this.id);">
                </div>
            <?php } ?>
            <?php if(substr($permisos,28,3) != "000"){?>
                <div class="col-md-2">
                    <img src="imagenes/menu/_servicios.png" class="img-responsive fadeInLeft wow menu" data-id="#inicio-menuServicios" data-wow-delay="0.1s"
                    id="principal_serv"
                    onmouseenter="cambiar(this.id);" 
                    onmouseleave="returner(this.id);">
                </div>
            <?php } ?>
            <?php if(substr($permisos,32,5) != "00000"){?>
                <div class="col-md-2">
                    <img src="imagenes/ig/Farmacia-01.png" class="img-responsive fadeInUp wow menu" data-id="#inicio-menuFarmacia" data-wow-delay="0.2s"
                    id="principal_farm"
                    onmouseenter="cambiar(this.id);" 
                    onmouseleave="returner(this.id);">
                </div>
            <?php } ?>
            <?php if(substr($permisos,38,10) != "0000000000" or $permisos[7] != "0" or $permisos[11] != "0" or $permisos[21] != "0" or $permisos[27] != "0" or $permisos[31] != "0" or $permisos[37] != "0"){?>
                <div class="col-md-2">
                    <img src="imagenes/ig/Admon-01.png" class="img-responsive fadeInRight wow menu" data-id="#inicio-menuAdmin" data-wow-delay="0.1s"
                    id="principal_admon_img"
                    onmouseenter="cambiar(this.id);" 
                    onmouseleave="returner(this.id);"
                    >
                </div>
            <?php } ?>
        </div>
    </div>
    <div class="row hidden animated" id="inicio-menuRecepcion">
        <div class="col-md-12 text-center">
            <h1 class="text-primary">Recepción</h1><br><br>
        </div>
        <div class="row animated alin">
            <?php if($permisos[0]){?>
                <div class="col-md-2">
                    <a href="pacientes.php"><img src="imagenes/ig/Pacientes-01.png" class="img-responsive fadeInLeft wow menu" data-wow-delay="0.1s"
                    id="recepcion_pacientes"
                    onmouseenter="cambiar(this.id);" 
                    onmouseleave="returner(this.id);"
                    ></a>
                </div>
            <?php } ?>
            <?php if(substr($permisos,1,4) != "0000"){ ?>
                <div class="col-md-2">
                    <img src="imagenes/ig/CorteCaja-01.png" class="img-responsive fadeInDown wow menu" data-id="#inicio-menuRecepcionCorte" data-wow-delay="0.2s"
                    id="recepcion_corte_caja"
                    onmouseenter="cambiar(this.id);" 
                    onmouseleave="returner(this.id);">
                </div>
            <?php } ?>
            <?php if($permisos[5]){?>
                <div class="col-md-2">
                    <a href="agenda.php"><img src="imagenes/ig/Agenda-01.png" class="img-responsive fadeIn wow menu" data-wow-delay="0.25s"
                    id="recepcion_agenda"
                    onmouseenter="cambiar(this.id);" 
                    onmouseleave="returner(this.id);"
                    ></a>
                </div>
            <?php } ?>
            <div class="col-md-2">
                <img src="imagenes/ig/Inicio-01.png" class="img-responsive fadeInUp wow menu" data-wow-delay="0.3s" data-id="#inicio-menuPrincipal"
                id="inicio_img_rec"
                onmouseenter="cambiar(this.id);" 
                onmouseleave="returner(this.id);"
                >
            </div>
        </div>
    </div>
    <div class="row hidden animated" id="inicio-menuConsultas">
        <div class="col-md-12 text-center">
            <h1 class="text-primary">Consultas</h1> <br> <br>
        </div>
        <div class="row animated alin">
            <?php if($permisos[8]){?>
                <div class="col-md-2">
                    <a href="consultas.php"><img src="imagenes/ig/ConsultasMedicas-01.png" class="img-responsive fadeInLeft wow menu" data-wow-delay="0.1s"
                    id="consultas_consultas"
                    onmouseenter="cambiar(this.id);" 
                    onmouseleave="returner(this.id);"
                    ></a>
                </div>
            <?php } ?>
            <?php if($permisos[10]){?>
                <div class="col-md-2">
                    <a href="catalogo_consultas.php"><img src="imagenes/ig/Catalogos-01.png" class="img-responsive fadeInDown wow menu" data-wow-delay="0.2s"
                    id="consultas_catalogo"
                    onmouseenter="cambiar(this.id);" 
                    onmouseleave="returner(this.id);"
                    ></a>
                </div>
            <?php } ?>
            <div class="col-md-2">
                <img src="imagenes/ig/Inicio-01.png" class="img-responsive fadeInUp wow menu" data-wow-delay="0.3s" data-id="#inicio-menuPrincipal"
                id="inicio_img_cons"
                onmouseenter="cambiar(this.id);" 
                onmouseleave="returner(this.id);"
                >
            </div>
        </div>
    </div>
    <div class="row hidden animated" id="inicio-menuHospital">
        <div class="col-md-12 text-center">
            <h1 class="text-primary">Hospital</h1> <br> <br>
        </div>
        <div class="row animated alin">
            <?php if($permisos[13]){?>
                <div class="col-md-2">
                    <a href="hospitalizacion.php"><img src="imagenes/ig/Hospital-01.png" class="img-responsive fadeInLeft wow menu" data-wow-delay="0.1s"
                    id="hospital_host"
                    onmouseenter="cambiar(this.id);" 
                    onmouseleave="returner(this.id);"
                    ></a>
                </div>
            <?php } ?>
            <?php if($permisos[14]){?>
                <div class="col-md-2">
                    <a href="camas.php"><img src="imagenes/ig/camas_g.png" class="img-responsive fadeInRight wow menu" data-wow-delay="0.1s"
                    id="hospital_camas"
                    onmouseenter="cambiar(this.id);" 
                    onmouseleave="returner(this.id);"
                    ></a>
                </div>
            <?php } ?>
            <div class="col-md-2">
                <img src="imagenes/ig/Inicio-01.png" class="img-responsive fadeInUp wow menu" data-wow-delay="0.2s" data-id="#inicio-menuPrincipal"
                id="inicio_img_hospital"
                onmouseenter="cambiar(this.id);" 
                onmouseleave="returner(this.id);"
                >
            </div>
        </div>
    </div>
    <div class="row hidden animated" id="inicio-menuImagen">
        <div class="col-md-12 text-center">
            <h1 class="text-primary">Imagen</h1> <br> <br>
        </div>
        <div class="row animated alin">
            <?php if($permisos[15]){?>
                <div class="col-md-2">
                    <a href="imagen.php"><img src="imagenes/ig/Imagenologia-01.png" class="img-responsive fadeInLeft wow menu" data-wow-delay="0.1s"
                    id="imagen_imageo"
                    onmouseenter="cambiar(this.id);" 
                    onmouseleave="returner(this.id);"
                    ></a>
                </div>
            <?php } ?>
            <?php if($permisos[17]){?>
                <div class="col-md-2">
                    <a href="endoscopia.php"><img src="imagenes/ig/Endoscopia-01.png" class="img-responsive fadeInDown wow menu" data-wow-delay="0.2s"
                    id="imagen_endoscopia"
                    onmouseenter="cambiar(this.id);" 
                    onmouseleave="returner(this.id);"
                    ></a>
                </div>
            <?php } ?>
            <?php if($permisos[18]){?>
                <div class="col-md-2">
                    <a href="ultrasonido.php"><img src="imagenes/menu/_ultrasonido.png" class="img-responsive fadeInRight wow menu" data-wow-delay="0.1s"
                    id="imagen_ultrasonido"
                    onmouseenter="cambiar(this.id);" 
                    onmouseleave="returner(this.id);"
                    ></a>
                </div>
            <?php } ?>
            <?php if($permisos[19]){?>
                <div class="col-md-2">
                    <a href="colposcopia.php"><img src="imagenes/ig/Colposcopia-01.png" class="img-responsive fadeInLeft wow menu" data-wow-delay="0.1s"
                    id="imagen_colco"
                    onmouseenter="cambiar(this.id);" 
                    onmouseleave="returner(this.id);"
                    ></a>
                </div>
            <?php } ?>
            <?php if($permisos[20]){?>
                <div class="col-md-2">
                    <a href="catalogo_imagen.php"><img src="imagenes/ig/Catalogos-01.png" class="img-responsive fadeInDown wow menu" data-wow-delay="0.2s"
                    id="imagen_catalogos"
                    onmouseenter="cambiar(this.id);" 
                    onmouseleave="returner(this.id);"
                    ></a>
                </div>
            <?php } ?>
            <div class="col-md-2">
                <img src="imagenes/ig/Inicio-01.png" class="img-responsive fadeInUp wow menu" data-wow-delay="0.3s" data-id="#inicio-menuPrincipal"
                id="inicio_img_imagen"
                onmouseenter="cambiar(this.id);" 
                onmouseleave="returner(this.id);"
                >
            </div>
        </div>
    </div>
    <div class="row hidden animated" id="inicio-menuLaboratorio">
        <div class="col-md-12 text-center">
            <h1 class="text-primary">Laboratorios</h1> <br> <br>
        </div>
        <div class="row animated alin">
            <?php if($permisos[22]){?>
                <div class="col-md-2">
                    <a href="laboratorio.php"><img src="imagenes/ig/EstudiosLab-01.png" class="img-responsive fadeInLeft wow menu" data-wow-delay="0.1s"
                    id="lab_estudios"
                    onmouseenter="cambiar(this.id);" 
                    onmouseleave="returner(this.id);"
                    ></a>
                </div>
            <?php } ?>
            <?php if($permisos[24]){?>
                <div class="col-md-2">
                    <a href="bases_lab.php"><img src="imagenes/ig/Bases-01.png" class="img-responsive fadeInDown wow menu" data-wow-delay="0.2s"
                    id="lab_bases"
                    onmouseenter="cambiar(this.id);" 
                    onmouseleave="returner(this.id);"
                    ></a>
                </div>
            <?php } ?>
            <?php if($permisos[25]){?>
                <div class="col-md-2">
                    <a href="bitacora_lab.php"><img src="imagenes/ig/Bitacoras-01.png" class="img-responsive fadeInRight wow menu" data-wow-delay="0.1s"
                    id="lab_bitacoras"
                    onmouseenter="cambiar(this.id);" 
                    onmouseleave="returner(this.id);"
                    ></a>
                </div>
            <?php } ?>
            <?php if($permisos[26]){?>
                <div class="col-md-2">
                    <a href="catalogo_laboratorio.php"><img src="imagenes/ig/Catalogos-01.png" class="img-responsive fadeInDown wow menu" data-wow-delay="0.2s"
                    id="lab_catalogo"
                    onmouseenter="cambiar(this.id);" 
                    onmouseleave="returner(this.id);"
                    ></a>
                </div>
            <?php } ?>
            <div class="col-md-2">
                <img src="imagenes/ig/Inicio-01.png" class="img-responsive fadeInUp wow menu" data-wow-delay="0.3s" data-id="#inicio-menuPrincipal"
                id="inicio_img_lab"
                onmouseenter="cambiar(this.id);" 
                onmouseleave="returner(this.id);">
            </div>
        </div>
    </div>
    <div class="row hidden animated" id="inicio-menuServicios">
        <div class="col-md-12 text-center">
            <h1 class="text-primary">Servicios</h1> <br> <br>
        </div>
        <div class="row animated alin">
            <?php if($permisos[28]){ ?>
                <div class="col-md-2">
                    <a href="servicios.php"><img src="imagenes/menu/_servicios_m.png" class="img-responsive fadeInLeft wow menu" data-wow-delay="0.1s"
                    id="servicios_m"
                    onmouseenter="cambiar(this.id);" 
                    onmouseleave="returner(this.id);"
                    ></a>
                </div>
            <?php } ?>
            <?php if($permisos[30]){ ?>
                <div class="col-md-2">
                    <a href="catalogo_servicios.php"><img src="imagenes/ig/Catalogos-01.png" class="img-responsive fadeInDown wow menu" data-wow-delay="0.2s"
                    id="servicios_catalogos"
                    onmouseenter="cambiar(this.id);" 
                    onmouseleave="returner(this.id);"
                    ></a>
                </div>
            <?php } ?>
            <div class="col-md-2">
                <img src="imagenes/ig/Inicio-01.png" class="img-responsive fadeInUp wow menu" data-wow-delay="0.3s" data-id="#inicio-menuPrincipal"
                id="inicio_img_serv"
                onmouseenter="cambiar(this.id);" 
                onmouseleave="returner(this.id);">
            </div>
        </div>
    </div>
    <div class="row hidden animated" id="inicio-menuFarmacia">
        <div class="col-md-12 text-center">
            <h1 class="text-primary">Farmacia</h1> <br> <br>
        </div>
        <div class="row animated alin">
            <?php if($permisos[33]){?>
                <div class="col-md-2">
                    <a href="catalogo_medicamentos.php"><img src="imagenes/ig/Medicamentos-01.png" class="img-responsive fadeInLeft wow menu" data-wow-delay="0.1s"
                    id="farmacia_medicamentos"
                    onmouseenter="cambiar(this.id);" 
                    onmouseleave="returner(this.id);"
                    ></a>
                </div>
            <?php } ?>
            <?php if($permisos[34]){?>
                <div class="col-md-2">
                    <a href="#"><img src="imagenes/ig/Productos-01.png" class="img-responsive fadeInDown wow menu" data-wow-delay="0.2s"
                    id="farmacia_productos"
                    onmouseenter="cambiar(this.id);" 
                    onmouseleave="returner(this.id);"
                    ></a>
                </div>
            <?php } ?>
            <?php if($permisos[35]){?>
                <div class="col-md-2">
                    <a href="#"><img src="imagenes/ig/CorteCaja-01.png" class="img-responsive fadeInRight wow menu" data-wow-delay="0.1s"
                    id="farmacia_corte_caja"
                    onmouseenter="cambiar(this.id);" 
                    onmouseleave="returner(this.id);"
                    ></a>
                </div>
            <?php } ?>
            <?php if($permisos[36]){?>
                <div class="col-md-2">
                    <a href="#"><img src="imagenes/menu/_stock.png" class="img-responsive fadeInLeft wow menu" data-wow-delay="0.1s"
                    id="farmacia_stock"
                    onmouseenter="cambiar(this.id);" 
                    onmouseleave="returner(this.id);"
                    ></a>
                </div>
            <?php } ?>
        
            <div class="col-md-2">
                <img src="imagenes/ig/Inicio-01.png" class="img-responsive fadeInUp wow menu" data-wow-delay="0.3s" data-id="#inicio-menuPrincipal"
                id="inicio_img_farmacia"
                onmouseenter="cambiar(this.id);" 
                onmouseleave="returner(this.id);">
            </div>
        </div>
    </div>
    <div class="row hidden animated" id="inicio-menuAdmin">
        <div class="col-md-12 text-center">
            <h1 class="text-primary">Administración</h1> <br> <br>
        </div>
        <div class="row animated alin">
            <?php if($permisos[38]){?>
                <div class="col-md-2">
                    <a href="usuarios.php"><img src="imagenes/menu/_usuarios.png" class="img-responsive fadeInLeft wow menu" data-wow-delay="0.1s"
                    id="admon_user"
                    onmouseenter="cambiar(this.id);" 
                    onmouseleave="returner(this.id);"
                    ></a>
                </div>
            <?php } ?>
            <?php if($permisos[39]){?>
                <div class="col-md-2">
                    <a href="sucursales.php"><img src="imagenes/menu/_sucursales.png" class="img-responsive fadeInLeft wow menu" data-wow-delay="0.1s"
                    id="admon_sucu"
                    onmouseenter="cambiar(this.id);" 
                    onmouseleave="returner(this.id);"
                    ></a>
                </div>
            <?php } ?>
            <?php if($permisos[40]){?>
                <div class="col-md-2">
                    <a href="escuelas.php"><img src="imagenes/ig/ESCUELAS-01.png" class="img-responsive fadeInLeft wow menu" data-wow-delay="0.1s"
                    id="admin_escuela"
                    onmouseenter="cambiar(this.id);" 
                    onmouseleave="returner(this.id);"></a>
                </div>
            <?php } ?>
            <?php if(substr($permisos,41,3) != "000"){?>
                <div class="col-md-2">
                    <img src="imagenes/ig/CorteCaja-01.png" class="img-responsive fadeInDown wow menu" data-id="#inicio-menuAdminCorte" data-wow-delay="0.2s"
                    id="admin_corte_caja"
                    onmouseenter="cambiar(this.id);" 
                    onmouseleave="returner(this.id);"
                    >
                </div>
            <?php } ?>
        </div>
        <div class="row animated alin">
            <?php if($permisos[44]){?>
                <div class="col-md-2">
                    <a href="#"><img src="imagenes/ig/Beneficios-01.png" class="img-responsive fadeInLeft wow menu" data-wow-delay="0.1s"
                    id="admon_Bene"
                    onmouseenter="cambiar(this.id);" 
                    onmouseleave="returner(this.id);"
                    ></a>
                </div>
            <?php } ?>
            <?php if($permisos[45]){?>
                <div class="col-md-2">
                    <a href="formatos.php"><img src="imagenes/ig/Formatos-01.png" class="img-responsive fadeInDown wow menu" data-wow-delay="0.2s"
                    id="admon_formatos"
                    onmouseenter="cambiar(this.id);" 
                    onmouseleave="returner(this.id);"
                    ></a>
                </div>
            <?php } ?>
            <?php if($permisos[7] ||  $permisos[11] || $permisos[21] || $permisos[27] || $permisos[31] || $permisos[37]){?>
                <div class="col-md-2">
                    <img src="imagenes/ig/Productividad-01.png" class="img-responsive fadeInDown wow menu" data-id="#inicio-menuAdminProductividad" data-wow-delay="0.2s"
                    id="admon_productividad"
                    onmouseenter="cambiar(this.id);" 
                    onmouseleave="returner(this.id);"
                    >
                </div>
            <?php }?>
            <div class="col-md-2">
                <img src="imagenes/ig/Inicio-01.png" class="img-responsive fadeInUp wow menu" data-wow-delay="0.3s" data-id="#inicio-menuPrincipal"
                id="inicio_img_admon"
                onmouseenter="cambiar(this.id);" 
                onmouseleave="returner(this.id);">
            </div>
        </div>
    </div>
    <div class="row hidden animated" id="inicio-menuRecepcionCorte">
        <div class="col-md-12 text-center">
            <h1 class=" text-primary">Recepción -> Corte de caja</h1> <br> <br>
        </div>
        <div class="row animated alin">
            <?php if($permisos[1]){?>
                <div class="col-md-2">
                    <a href="ordenes_venta_r.php"><img src="imagenes/ig/OrdenVenta-01.png" class="img-responsive fadeInDown wow menu" data-wow-delay="0.2s"
                    id="orden_venta_recepcion"
                    onmouseenter="cambiar(this.id);" 
                    onmouseleave="returner(this.id);"></a>
                </div>
            <?php } ?>
            <?php if($permisos[3]){?>
                <div class="col-md-2">
                    <a href="pagos_usuario_r.php"><img src="imagenes/ig/PagosPendientes-01.png" class="img-responsive fadeInRight wow menu" data-wow-delay="0.1s"
                    id="pagos_recepcion"
                    onmouseenter="cambiar(this.id);" 
                    onmouseleave="returner(this.id);"></a>
                </div>
            <?php } ?>
            <?php if($permisos[4]){?>
                <div class="col-md-2">
                    <a href="resumen_cc_r.php"><img src="imagenes/menu/_resumen_ventas.png" class="img-responsive fadeInLeft wow menu" data-wow-delay="0.1s"
                    id="resumen_recepcion"
                    onmouseenter="cambiar(this.id);" 
                    onmouseleave="returner(this.id);"></a>
                </div>
            <?php } ?>

            <div class="col-md-2">
                <img src="imagenes/ig/Inicio-01.png" class="img-responsive fadeInUp wow menu" data-wow-delay="0.3s" data-id="#inicio-menuPrincipal"
                id="inicio_img_rece_corte"
                onmouseenter="cambiar(this.id);" 
                onmouseleave="returner(this.id);">
            </div>
        </div>
    </div>
    <div class="row hidden animated" id="inicio-menuAdminCorte">
        <div class="col-md-12 text-center">
            <h1 class="text-primary">Admin -> Corte de caja</h1> <br> <br>
        </div>
        <div class="row animated alin">
            <?php if($permisos[1]){?>
                <div class="col-md-2">
                    <a href="ordenes_venta_a.php"><img src="imagenes/ig/OrdenVenta-01.png" class="img-responsive fadeInDown wow menu" data-wow-delay="0.2s"
                    id="orden_venta_admin"
                    onmouseenter="cambiar(this.id);" 
                    onmouseleave="returner(this.id);"
                    ></a>
                </div>
            <?php } ?>
            <?php if($permisos[3]){?>
                <div class="col-md-2">
                    <a href="pagos_usuario_a.php"><img src="imagenes/ig/PagosPendientes-01.png" class="img-responsive fadeInRight wow menu" data-wow-delay="0.1s"
                    id="pagos_admin"
                    onmouseenter="cambiar(this.id);" 
                    onmouseleave="returner(this.id);"
                    ></a>
                </div>
            <?php } ?>
            <?php if($permisos[4]){?>
                <div class="col-md-2">
                    <a href="resumen_cc.php"><img src="imagenes/menu/_resumen_ventas.png" class="img-responsive fadeInLeft wow menu" data-wow-delay="0.1s"
                    id="resumen_admin"
                    onmouseenter="cambiar(this.id);" 
                    onmouseleave="returner(this.id);"
                    ></a>
                </div>
            <?php } ?>

            <div class="col-md-2">
                <img src="imagenes/ig/Inicio-01.png" class="img-responsive fadeInUp wow menu" data-wow-delay="0.3s" data-id="#inicio-menuPrincipal"
                 id="inicio_img_admon_corte"
                onmouseenter="cambiar(this.id);" 
                onmouseleave="returner(this.id);">
            </div>
        </div>
    </div>
    <div class="row hidden animated" id="inicio-menuAdminProductividad">
        <div class="col-md-12 text-center">
            <h1 class="text-primary">Admin -> Productividad</h1> <br> <br>
        </div>

        <div class="row animated alin">
                <!-- productividad recepción -->
            <?php if($permisos[7]){?>
                <div class="col-md-2">
                    <a href="productividad_rec.php"><img src="imagenes/ig/recepcion_g.png" id="prod_rec_img"
                    onmouseenter="cambiar(this.id);" 
                    onmouseleave="returner(this.id);"
                    class="img-responsive fadeInRight wow menu" data-wow-delay="0.1s"></a>
                </div>
            <?php } ?>

            <!-- productividad consultas -->
            <?php if($permisos[11]){?>
                <div class="col-md-2">
                    <a href="productividad_cst.php"><img src="imagenes/ig/consultas_g.png" 
                    onmouseenter="cambiar(this.id);" 
                    onmouseleave="returner(this.id);"
                    id="prod_consultas_img" class="img-responsive fadeInRight wow menu" data-wow-delay="0.1s"></a>
                </div>
            <?php } ?>

            <!-- productividad imagen -->
            <?php if($permisos[21]){?>
                <div class="col-md-2">
                    <a href="productividad_img.php"><img src="imagenes/ig/imagen_g.png"  
                    onmouseenter="cambiar(this.id);" 
                    onmouseleave="returner(this.id);"
                    id="prod_imagen_img" class="img-responsive fadeInRight wow menu" data-wow-delay="0.1s"></a>
                </div>
            <?php } ?>

            <!-- productividad laboratorio -->
            <?php if($permisos[27]){?>
                <div class="col-md-2">
                    <a href="productividad_lab.php"><img src="imagenes/ig/laboratorio_g.png"  
                    onmouseenter="cambiar(this.id);" 
                    onmouseleave="returner(this.id);"
                    id="prod_lab_img" class="img-responsive fadeInRight wow menu" data-wow-delay="0.1s"></a>
                </div>
            <?php } ?>
        </div>
        <div class="row animated alin">
              
                <!-- productividad servicios -->
            <?php if($permisos[31]){ ?>
                <div class="col-md-2">
                    <a href="productividad_ser.php"><img src="imagenes/ig/servicios_g.png"  
                    onmouseenter="cambiar(this.id);" 
                    onmouseleave="returner(this.id);"
                    id="prod_serv_img" class="img-responsive fadeInRight wow menu" data-wow-delay="0.1s"></a>
                </div>
            <?php } ?>

            <!-- productividad farmacia -->
            <?php if($permisos[37]){?>
                <div class="col-md-2">
                    <a href="productividad_far.php"><img src="imagenes/ig/farmacia_g.png"  
                    onmouseenter="cambiar(this.id);" 
                    onmouseleave="returner(this.id);"
                    id="prod_far_img" class="img-responsive fadeInRight wow menu" data-wow-delay="0.1s"></a>
                </div>
            <?php } ?>
            

            <div class="col-md-2">
                <img src="imagenes/ig/Inicio-01.png" class="img-responsive fadeInUp wow menu" data-wow-delay="0.3s" 
                onmouseenter="cambiar(this.id);" 
                onmouseleave="returner(this.id);"
                data-id="#inicio-menuPrincipal"
                id="prod_inicio_img">
            </div>
        </div>
    </div>
</div>
<!-- FIN Contenido -->  
<?php include_once 'partes/footer.php'; ?>
<script src="js/plugins/wow/wow.min.js"></script>
<script>
    function cambiar(id){
        const ALMACEN_IMAGENES_MENU_AZUL = {
            //inicios
        'inicio_img_rec': 'inicio_a.png',
        'prod_inicio_img': 'inicio_a.png',
        'inicio_img_cons': 'inicio_a.png',
        'inicio_img_hospital': 'inicio_a.png',
        'inicio_img_imagen': 'inicio_a.png',
        'inicio_img_lab': 'inicio_a.png',
        'inicio_img_serv': 'inicio_a.png',
        'inicio_img_farmacia': 'inicio_a.png',
        'inicio_img_admon': 'inicio_a.png',
        'inicio_img_rece_corte': 'inicio_a.png',
        'inicio_img_admon_corte': 'inicio_a.png',

            //menu principal
        'principal_admon_img': 'admon_a.png',
        'principal_rec_img':'Recepcion_a_a.png',
        'principal_consultas': 'consultas_a_pricipal.png',
        'principal_enfermeria':'enfermeria_a.png',
        'principal_farm':'principal_farmacia_a.png',
        'principal_hospital':'principal_hospital_a.png',
        'principal_imagen':'principal_imagen_a.png',
        'principal_lab':'principal_lab_a.png',
        'principal_serv': 'principal_servicios_a.png',

          //menu Recepcion
        'recepcion_pacientes': 'pacientes_a.png',
        'recepcion_corte_caja':'corte_caja_a.png',
        'recepcion_agenda': 'agenda_a.png',
        'resumen_recepcion':'_resumen_ventas_a.png',
        'orden_venta_recepcion':'OrdenVenta_a.png',
        'pagos_recepcion':'PagosPendientes_a.png',

        //consultas
        'consultas_catalogo':'catalogos_a.png',
        'consultas_consultas':'ConsultasMedicas_a.png',

        //imagen
        'imagen_imageo':'img_a.png',
        'imagen_ultrasonido': 'ultrasonido_a.png',
        'imagen_colco':'colnoscopia_a.png',
        'imagen_endoscopia':'endoscopia_a.png',
        'imagen_catalogos':'catalogos_a.png',

        //hospital
        'hospital_host':'principal_hospital_a.png',
        'hospital_camas':'camas_a.png',

        //laboratorio
        'lab_estudios':'estudios_a.png',
        'lab_bases':'bases_a.png',
        'lab_catalogo':'catalogos_a.png',
        'lab_bitacoras':'bitacoras_a.png',

        //farmacia
        'farmacia_corte_caja':'corte_caja_a.png',
        'farmacia_stock':'stock_a.png',
        'farmacia_productos':'productos_a.png',
        'farmacia_medicamentos':'medicamentos_a.png',

        //servicios
        'servicios_catalogos':'catalogos_a.png',
        'servicios_m':'servicios_m_a.png',

        //Administracion
        'admin_corte_caja':'corte_caja_a.png',
        'admon_user':'_usuarios_a.png',
        'admon_sucu':'sucursales_a.png',
        'admon_Bene':'Beneficios_a.png',
        'admon_formatos':'Formatos_a.png',
        'admon_productividad':'productividad_a.png',
        'admin_escuela':'ESCUELAS-02.png',
        'orden_venta_admin':'OrdenVenta_a.png',
        'pagos_admin':'PagosPendientes_a.png',
        'resumen_admin':'_resumen_ventas_a.png',

            
            //menu Administracion/productividad 
        'prod_rec_img': 'recepcion_a.png',
        'prod_consultas_img':'consultas_a.png',
        'prod_imagen_img':'imagen_a.png',
        'prod_lab_img':'laboratorio_a.png',
        'prod_serv_img':'servicios_a.png',
        'prod_far_img':'principal_farmacia_a.png',
        }
         var img = document.getElementById(id);
         img.src ="imagenes/ig/"+ALMACEN_IMAGENES_MENU_AZUL[id];
    }

    function returner(id){
        const ALMACEN_IMAGENES_MENU_DEFAULT = {
             //inicios
        'inicio_img_rec': 'Inicio-01.png',
        'prod_inicio_img': 'Inicio-01.png',
        'inicio_img_cons': 'Inicio-01.png',
        'inicio_img_hospital': 'Inicio-01.png',
        'inicio_img_imagen': 'Inicio-01.png',
        'inicio_img_lab': 'Inicio-01.png',
        'inicio_img_serv': 'Inicio-01.png',
        'inicio_img_farmacia': 'Inicio-01.png',
        'inicio_img_admon': 'Inicio-01.png',
        'inicio_img_rece_corte': 'Inicio-01.png',
        'inicio_img_admon_corte': 'Inicio-01.png',

            //menu principal
        'principal_admon_img': 'Admon-01.png',
        'principal_rec_img': 'Recepcion-01.png',
        'principal_consultas':'Consultas1-01.png',
        'principal_enfermeria':'Enfermeria-01.png',
        'principal_hospital':'Hospital-01.png',
        'principal_imagen':'Imagen-01.png',
        'principal_lab':'Lab-01.png',
        'principal_serv': '_servicios.png',
        'principal_farm':'Farmacia-01.png',

           //menu Recepcion
        'recepcion_pacientes': 'Pacientes-01.png',
        'recepcion_corte_caja':'CorteCaja-01.png',
        'recepcion_agenda': 'Agenda-01.png',
        'resumen_recepcion':'_resumen_ventas.png',
        'orden_venta_recepcion':'OrdenVenta-01.png',
        'pagos_recepcion':'PagosPendientes-01.png',

        //consultas
        'consultas_catalogo':'Catalogos-01.png',
        'consultas_consultas':'ConsultasMedicas-01.png',

        //imagen
        'imagen_imageo':'Imagenologia-01.png',
        'imagen_endoscopia':'Endoscopia-01.png',
        'imagen_ultrasonido': '_ultrasonido.png',
        'imagen_colco':'Colposcopia-01.png',
        'imagen_catalogos':'Catalogos-01.png',

        //hospital
        'hospital_host':'Hospital-01.png',
        'hospital_camas':'camas_g.png',

        //laboratorio
        'lab_estudios':'EstudiosLab-01.png',
        'lab_bases':'Bases-01.png',
        'lab_catalogo':'Catalogos-01.png',
        'lab_bitacoras':'Bitacoras-01.png',

        //servicios
        'servicios_catalogos':'Catalogos-01.png',
        'servicios_m':'_servicios_m.png',

            //farmacia
        'farmacia_corte_caja':'CorteCaja-01.png',
        'farmacia_stock':'_stock.png',
        'farmacia_productos':'Productos-01.png',
        'farmacia_medicamentos':'Medicamentos-01.png',

         //Administracion
         'admin_corte_caja':'CorteCaja-01.png',
         'admon_user':'_usuarios.png',
         'admon_sucu':'_sucursales.png',
         'admon_Bene':'Beneficios-01.png',
         'admon_formatos':'Formatos-01.png',
         'admon_productividad':'Productividad-01.png',
         'admin_escuela':'ESCUELAS-01.png',
         'resumen_admin':'_resumen_ventas.png',
         'pagos_admin':'PagosPendientes-01.png',
         'orden_venta_admin':'OrdenVenta-01.png',

         
            //menu Administracion/productividad 
        'prod_rec_img': 'recepcion_g.png',
        'prod_consultas_img':'consultas_g.png',
        'prod_imagen_img':'imagen_g.png',
        'prod_lab_img':'laboratorio_g.png',
        'prod_serv_img':'servicios_g.png',
        'prod_far_img':'farmacia_g.png',
        }
         var img = document.getElementById(id);
         img.src ="imagenes/ig/"+ALMACEN_IMAGENES_MENU_DEFAULT[id];
    }

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
