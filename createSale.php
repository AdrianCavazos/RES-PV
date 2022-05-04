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
                header('Location: homeAdministrador.php');
            break;
            case 2:
                header('Location: homeMesero.php');
            break;
            case 3:
                $Usuario = $Modelo->getUser($_SESSION["userId"]);
                $nombreUsuario = $Usuario[0]["name_user"];
                $apellidoUsuario = $Usuario[0]["lname_user"];
                require_once("ventas/Modelo/ventas.php");
                $ModeloVentas = new Ventas();
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

    <title>Inicio - Mesero</title>

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
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-laugh-wink"></i>
                </div>
                <div class="sidebar-brand-text mx-3">Res-PV<sup>Mesero</sup></div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Charts -->
            <li class="nav-item">
                <a class="nav-link" href="createSale.php">
                    <i class="fas fa-fw fa-credit-card"></i>
                    <span>Crear Venta</span></a>
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
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo $nombreUsuario.' '.$apellidoUsuario ?></span>
                                <img class="img-profile rounded-circle"
                                    src="img/undraw_profile.svg">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
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
                        <h1 class="h3 mb-0 text-gray-800">Venta </h1>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <form class="user" action="" method="POST">
                                <div class="form group">
                                    Platillo
                                    <select class="form-control" name="product">
                                        <?php
                                            include "db.php";
                                            session_start();
                                            $consul = "SELECT * FROM product";
                                            $res = mysqli_query($conn,$consul);
                                            $rowType = mysqli_num_rows($res);
                                            while ($rowType=mysqli_fetch_array($res)) {
                                        ?>
                                                <option value="<?php echo $rowType['id_product']; ?>"><?php echo $rowType['name_product']; ?></option>
                                        <?php   
                                            }
                                        ?>
                                    </select>
                                </div>
                                <br>
                                <div class="form-group">
                                    <input type="text" class="form-control" placeholder="Cantidad" name="quantity">
                                </div>
                                <br>
                                <input type ="submit" class="btn btn-primary btn-user btn-block" value="Agregar al carrito">
                                <hr>
                            </form>
                            <?php
                                if (isset($_POST['product'])) {
                                    $product   = $_POST['product'];
                                    $quantity  = $_POST['quantity'];
                                    $insert    = "INSERT INTO `selldetail`(`id_sellDetail`, `id_product`, `quantity_sellDetail`, `id_sell`, `id_cart`) VALUES ('','$product','$quantity','0',1)"; 
                                    mysqli_query($conn,$insert);
                                }
                            ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12"> 
                            Carrito 1
                            <div class="col-md-4">
                                <?php $var = 1 ?>
                                <a href="sell.php?variable=<?php echo 1;?>" class="btn btn-primary btn-user btn-block">Vender</a>   
                            </div>
                            <br>
                            <table class="table table-bordered">
                                <tr>
                                    <td>ID de detalle</td>
                                    <td>ID de Producto</td>
                                    <td>Nombre de Producto</td>
                                    <td>Descripcion de producto</td>
                                    <td>Precio Unitario</td>
                                    <td>Cantidad</td>
                                </tr>
                                <?php
                                    $query = "SELECT * FROM selldetail a INNER JOIN cart b ON a.id_cart = b.id_cart INNER JOIN product c ON a.id_product = c.id_product WHERE a.id_cart = 1";
                                    $result = mysqli_query($conn,$query);
                                    $row = mysqli_num_rows($result);
                                    while ($row = mysqli_fetch_array($result)) {
                                ?>
                                    <tr>
                                        <td><?php echo $row['id_sellDetail'];?></td>
                                        <td><?php echo $row['id_product'];?></td>
                                        <td><?php echo $row['name_product'];?></td>
                                        <td><?php echo $row['description_product'];?></td>
                                        <td><?php echo $row['unitaryPrice_product'];?></td>
                                        <td><?php echo $row['quantity_sellDetail'];?></td>
                                    </tr>
                                <?php        
                                    }
                                ?>
                            </table>
                            
                        </div>
                    </div> 
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
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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