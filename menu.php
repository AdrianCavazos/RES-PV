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
                require_once("menu/Modelo/menu.php");
                $ModeloMenu = new Menu();
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

    <title>Menu - Administrador</title>

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
                    <?php
                        if(!empty($_GET['editarId'])) {
                        //cuando pide editar platillo:
                        $idPlatillo = $_GET['editarId'];
                        $datosDePlatillo = $ModeloMenu->getPlatillo($idPlatillo);
                        if($datosDePlatillo != null){
                            foreach($datosDePlatillo as $datoPlatillo){
                    ?>
                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Editar platillo</h1>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <form class="user" action="menu/Controlador/editPlatillo.php" method="POST" enctype="multipart/form-data">
                                <input name="id" type="hidden" value="<?php echo $idPlatillo;?>" />
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Nombre:</label>
                                    <div class="col-sm-10">
                                    <input required type="text" class="form-control" value="<?php echo $datoPlatillo['name_product'];?>" name="nombre">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Descripcion:</label>
                                    <div class="col-sm-10">
                                    <textarea required class="form-control" name="descripcion" maxlength="50"><?php echo $datoPlatillo['description_product'];?></textarea>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Marca:</label>
                                    <div class="col-sm-10">
                                    <input required type="text" class="form-control" value="<?php echo $datoPlatillo['mark_product'];?>" name="marca">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Codigo:</label>
                                    <div class="col-sm-10">
                                    <input required type="text" class="form-control" value="<?php echo $datoPlatillo['code_product'];?>" name="codigo">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" name="imagen">
                                        <label class="custom-file-label" for="inputGroupFile01">Elige una imagen</label>
                                    </div>
                                </div>
                                <div class="form group">
                                    <select class="form-control" name="existencia">
                                    
                                        <option value="1"><?php echo 'En existencia'; ?></option>
                                        <option value="0"><?php echo 'Sin existencia'; ?></option>
                                        
                                    </select>
                                </div>
                                <br>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Costo:</label>
                                    <div class="col-sm-10">
                                    <input requiredtype="text" class="form-control" value="<?php echo $datoPlatillo['cost_product'];?>" name="costo">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Precio de venta:</label>
                                    <div class="col-sm-10">
                                    <input requiredtype="text" class="form-control" value="<?php echo $datoPlatillo['unitaryPrice_product'];?>" name="precio">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Categoría:</label>
                                    <div class="col-sm-10">
                                        <select class="form-control"  name="categoria">
                                            <?php
                                                $categorias = $ModeloMenu->getCategorias();
                                                if($categorias != null){
                                                    foreach($categorias as $categoria){
                                                        if ($categoria['id_category'] == $datoPlatillo['category_product']) {
                                                            echo '<option value="'.$categoria['id_category'].'" selected>'.$categoria['category_name'].'</option>';
                                                        } else {
                                                            echo '<option value="'.$categoria['id_category'].'">'.$categoria['category_name'].'</option>';
                                                        }
                                                    }
                                                }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <input type ="submit" class="btn btn-primary btn-user btn-block" value="Editar Platillo">
                                <hr>
                            </form>
                        </div>
                    </div>
                    <hr>
                    <?php
                            }
                            }
                        } else { //cuando no esta pidiendo editar platillo:
                    ?>
                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Agregar platillo al menu </h1>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <form class="user" action="menu/Controlador/addPlatillo.php" method="POST" enctype="multipart/form-data">
                                <div class="form-group">
                                    <input required type="text" class="form-control" placeholder="Nombre del platillo" name="nombre">
                                </div>
                                <div class="form-group">
                                    <textarea required class="form-control" placeholder="Descripcion" name="descripcion" maxlength="50"></textarea>
                                </div>
                                <div class="form-group">
                                    <input required type="text" class="form-control" placeholder="Marca" name="marca">
                                </div>
                                <div class="form-group">
                                    <input required type="text" class="form-control" placeholder="Codigo" name="codigo">
                                </div>
                                <div class="form-group">
                                    <div class="custom-file">
                                        <input required type="file" class="custom-file-input" name="imagen">
                                        <label class="custom-file-label" for="inputGroupFile01">Elige una imagen</label>
                                    </div>
                                </div>
                                <div class="form group">
                                    <select class="form-control" name="existencia">
                                    
                                        <option value="1"><?php echo 'En existencia'; ?></option>
                                        <option value="0"><?php echo 'Sin existencia'; ?></option>
                                        
                                    </select>
                                </div>
                                <br>
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input requiredtype="text" class="form-control" placeholder="Costo" name="costo">
                                    </div>
                                    <div class="col-sm-6">
                                        <input requiredtype="text" class="form-control" placeholder="Precio de venta" name="precio">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Categoría:</label>
                                    <div class="col-sm-10">
                                        <select class="form-control"  name="categoria">
                                            <?php
                                                $categorias = $ModeloMenu->getCategorias();
                                                if($categorias != null){
                                                    foreach($categorias as $categoria){
                                                        echo '<option value="'.$categoria['id_category'].'">'.$categoria['category_name'].'</option>';
                                                    }
                                                }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <input type ="submit" class="btn btn-primary btn-user btn-block" value="Registrar Platillo">
                                <hr>
                            </form>
                        </div>
                    </div>
                    <hr>
                    <div class="card shadow mb-4 col-lg w-100">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">MENU</h6>
                        </div>
                        <div class="card-body" >
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <th></th>
                                    <th>Id</th>
                                    <th>Producto</th>
                                    <th>Descripcion</th>
                                    <th>Marca</th>
                                    <th>Costo</th>
                                    <th>Precio de Venta</th>
                                    <th>existencia</th>
                                </thead>
                                <tbody>
                                <?php
                                    $productos = $ModeloMenu->get();
                                    if($productos != null){
                                        foreach($productos as $platillo){
                                ?>
                                    <tr>
                                        <td><a href="menu.php?editarId=<?php echo $platillo['id_product'];?>"><span class="fa fa-edit" style="color: blue;"></span></a></td>
                                        <td><?php echo $platillo['id_product'];?></td>
                                        <td><?php echo $platillo['name_product'];?></td>
                                        <td><?php echo $platillo['description_product'];?></td>
                                        <td><?php echo $platillo['mark_product'];?></td>
                                        <td><?php echo number_format(round($platillo['cost_product'],2), 2, '.', ',');?></td>
                                        <td><?php echo number_format(round($platillo['unitaryPrice_product'],2), 2, '.', ',');?></td>
                                        
                                        <td>
                                            <?php 
                                                if ($platillo['productExistance']==1) {
                                                    echo "En existencia";
                                                }else{
                                                    if ($platillo['productExistance']==0) {
                                                        echo "Sin existencia";
                                                    }
                                                } 
                                            ?>
                                        </td>
                                        <td>
                                        <a href="menu/Vista/delete.php?Id=<?php echo $platillo['id_product'];?>"><span class="fa fa-trash" style="color: red;"></span></a>
                                        </td>
                                    </tr>
                                <?php        
                                        }
                                    }
                                ?>
                                </tbody>
                            </table>
                            </div>
                     </div>
                    <?php
                        } //cierra else para cuando no esta pidiendo editar platillo
                    ?>
 
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