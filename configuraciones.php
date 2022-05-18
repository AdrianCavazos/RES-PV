<?php
session_start();
if(!empty($_SESSION["userId"])) {
    require_once('usuarios/Modelo/usuarios.php');
    $Modelo = new Usuarios();
    $tipoDeUsuario = $Modelo->getUserType($_SESSION["userId"]);
    if (!$tipoDeUsuario) {
        $_SESSION["errorMessage"] = "Invalid Credentials";
        header('Location: logout.php');
    } else {
        switch($tipoDeUsuario){
            case 1:
                $Usuario = $Modelo->getUser($_SESSION["userId"]);
                $nombreUsuario = $Usuario[0]["name_user"];
                $apellidoUsuario = $Usuario[0]["lname_user"];
                require_once("configuraciones/Modelo/configuraciones.php");
                $ModeloMenu = new Configuraciones();
            break;
            case 2:
                header('Location: homeMesero.php');
            break;
            case 3:
                header('Location: homeContador.php');
            break;
        }
    }
} else {
    header('Location: logout.php');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Configuraciones - Administrador</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="homeAdministrador.php">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-laugh-wink"></i>
                </div>
                <div class="sidebar-brand-text mx-3">Res-PV<sup>Admin</sup></div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Charts -->
            <li class="nav-item">
                <a class="nav-link" href="createUser.php">
                    <i class="fas fa-fw fa-user"></i>
                    <span>Crear nuevo usuario</span></a>
            </li>

            <!-- Nav Item - Tables -->
            <li class="nav-item">
                <a class="nav-link" href="menu.php">
                    <i class="fas fa-fw fa-list"></i>
                    <span>Menú</span></a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="adminCategorias.php">
                    <i class="fas fa-fw fa-list"></i>
                    <span>Categorías</span></a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="sales.php">
                    <i class="fas fa-fw fa-credit-card"></i>
                    <span>Ventas</span></a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="analisisVentas.php">
                    <i class="fas fa-fw fa-money-bill"></i>
                    <span>Analisis Ventas</span></a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="dashboard.php">
                    <i class="fas fa-fw fa-book"></i>
                    <span>Dashboard</span></a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="configuraciones.php">
                    <i class="fas fa-fw fa-cog"></i>
                    <span>Configuraciones</span></a>
            </li>
            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo $nombreUsuario.' '.$apellidoUsuario?></span>
                                <img class="img-profile rounded-circle"
                                    src="img/undraw_profile.svg">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="index.php" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Configuraciones</h1>
                    </div>
                    <?php
                        $configs = $ModeloMenu->getAllSettings();
                        if($configs != null){
                    ?>
                    <hr>
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Configuraciones del software</h1>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <form class="user" action="configuraciones/Controlador/setConfiguraciones.php" method="POST" enctype="multipart/form-data">
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Huso horario:</label>
                                    <div class="col-sm-10">
                                        <?php
                                            $valor=array_search('timezone',array_column($configs,'setting_name'));
                                            $currentTimezone=$configs[$valor][2];
                                            echo "<select class=\"form-control\" name=\"timezone\">";
                                            $tzlist = DateTimeZone::listIdentifiers(DateTimeZone::ALL);
                                            foreach($tzlist as $value) {
                                                if ($value != $currentTimezone) {
                                                    echo "<option value=". $value .">". $value ."</option>";
                                                } else {
                                                    echo "<option value=". $value ." selected>". $value ."</option>";
                                                }
                                            }
                                            echo "<select>";
                                        ?>
                                    </div>
                                </div>
                                <input type ="submit" class="btn btn-primary btn-user btn-block" value="Actualizar datos" name="datosDelNegocio">
                                <hr>
                            </form>
                        </div>
                    </div>
                    <hr>
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Datos del negocio</h1>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <form class="user" action="configuraciones/Controlador/setConfiguraciones.php" method="POST" enctype="multipart/form-data">
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Nombre comercial:</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" placeholder="<?php $valor=array_search('nombre_comercial',array_column($configs,'setting_name'));echo $configs[$valor][2];?>" name="nombre_comercial">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Razón social:</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" placeholder="<?php $valor=array_search('razon_social',array_column($configs,'setting_name'));echo $configs[$valor][2];?>" name="razon_social">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">RFC:</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" placeholder="<?php $valor=array_search('rfc',array_column($configs,'setting_name'));echo $configs[$valor][2];?>" name="rfc">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Dirección 1:</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" placeholder="<?php $valor=array_search('direccion_1',array_column($configs,'setting_name'));echo $configs[$valor][2];?>" name="direccion_1">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Dirección 2:</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" placeholder="<?php $valor=array_search('direccion_2',array_column($configs,'setting_name'));echo $configs[$valor][2];?>" name="direccion_2">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Código Postal:</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" placeholder="<?php $valor=array_search('direccion_cp',array_column($configs,'setting_name'));echo $configs[$valor][2];?>" name="direccion_cp">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Ciudad:</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" placeholder="<?php $valor=array_search('direccion_ciudad',array_column($configs,'setting_name'));echo $configs[$valor][2];?>" name="direccion_ciudad">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Estado:</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" placeholder="<?php $valor=array_search('direccion_estado',array_column($configs,'setting_name'));echo $configs[$valor][2];?>" name="direccion_estado">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">País:</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" placeholder="<?php $valor=array_search('direccion_pais',array_column($configs,'setting_name'));echo $configs[$valor][2];?>" name="direccion_pais">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">E-mail:</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" placeholder="<?php $valor=array_search('email',array_column($configs,'setting_name'));echo $configs[$valor][2];?>" name="email">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Teléfono:</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" placeholder="<?php $valor=array_search('telefono',array_column($configs,'setting_name'));echo $configs[$valor][2];?>" name="telefono">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">% IVA:</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" placeholder="<?php $valor=array_search('porcentaje_iva',array_column($configs,'setting_name'));echo $configs[$valor][2];?>" name="porcentaje_iva">
                                    </div>
                                </div>
                                <input type ="submit" class="btn btn-primary btn-user btn-block" value="Actualizar datos" name="datosDelNegocio">
                                <hr>
                            </form>
                        </div>
                    </div>
                    <hr>
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Datos de la sucursal</h1>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <form class="user" action="configuraciones/Controlador/setConfiguraciones.php" method="POST" enctype="multipart/form-data">
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Número de Caja:</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" placeholder="<?php $valor=array_search('numero_caja',array_column($configs,'setting_name'));echo $configs[$valor][2];?>" name="numero_caja">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Número de Sucursal:</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" placeholder="<?php $valor=array_search('numero_sucursal',array_column($configs,'setting_name'));echo $configs[$valor][2];?>" name="numero_sucursal">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Contacto de Sucursal:</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" placeholder="<?php $valor=array_search('contacto_sucursal',array_column($configs,'setting_name'));echo $configs[$valor][2];?>" name="contacto_sucursal">
                                    </div>
                                </div>
                                <input type ="submit" class="btn btn-primary btn-user btn-block" value="Actualizar datos" name="datosDelNegocio">
                                <hr>
                            </form>
                        </div>
                    </div>
                    <?php
                        }
                    ?>
                    <hr>
 
                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Res-PV, 2022 </span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="logout.php">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="vendor/chart.js/Chart.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="js/demo/chart-area-demo.js"></script>
    <script src="js/demo/chart-pie-demo.js"></script>

</body>

</html>