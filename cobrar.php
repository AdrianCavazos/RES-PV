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
                $Usuario = $Modelo->getUser($_SESSION["userId"]);
                $nombreUsuario = $Usuario[0]["name_user"];
                $apellidoUsuario = $Usuario[0]["lname_user"];
                $idUsuario = $Usuario[0]["id_user"];
                require_once("usuarios/Modelo/mesero.php");
                $ModeloMesero  = new Meseros();
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

    <title>Ordenar - Mesero</title>

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
            
            <li class="nav-item ">
                <a class="nav-link" href="homeMesero.php">
                    <i class="fas fa-fw fa-utensils"></i>
                    <span>ORDENAR</span></a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="cobrar.php">
                    <i class="fas fa-fw fa-credit-card"></i>
                    <span>COBRAR</span></a>
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
                    <div class=" d-sm-flex align-items-center justify-content-between ">
                        <h3 class=" mb-0 text-gray-900"> COBRAR </h3>
                    </div>
                    <p class="mb-4">Selecciona la mesa que cobraras en efectivo para saber los detalles de su orden</p>
                    
                    <?php
                        //VERIFICA SI SE ESCOGIÓ UNA MESA
                        if(isset($_GET['mesa'])){
                            $visible = "block";
                            $mesa_sel = $_GET['mesa'];
                    ?>
                        <!-- TABLA DE PEDIDO [SOLO EXISTE SI ESCOGE MESA]-->
                        <div class="row d-flex justify-content-center mt-4 mb-4 card shadow border-info" style="display: <?php echo $visible; ?>">
                            <div class="card-body">
                            <h4>ORDEN DE LA MESA <?php echo $mesa_sel;?></h4>
                            <table class="table">
                                <thead class="thead-light">
                                    <tr>
                                    <th scope="col">Comida</th>
                                    <th scope="col">Cantidad</th>
                                    <th scope="col">Precio</th>
                                    <th scope="col">Importe</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    
                                    <?php
                                    $mesa = $_GET['mesa'];
                                    $total = 0;
                                    $detalles = $ModeloMesero->getCarrito_tmp($mesa);
                                    if($detalles != null){
                                        foreach($detalles as $detalle){
                                    ?>
                                        <tr>
                                            <th scope="row"><?php echo $detalle['name_product']; ?></th>
                                            <td><?php echo $detalle['cantidad']; ?></td>
                                            <td><?php echo $detalle['unitaryPrice_product']; ?></td>
                                            <td><?php echo $detalle['cantidad'] * $detalle['unitaryPrice_product']; ?></td>
                                            <?php $total = $total + $detalle['cantidad'] * $detalle['unitaryPrice_product']; ?>
                                        </tr>
                                    <?php }} ?>
                                </tbody>
                            </table>

                                <div class="d-flex justify-content-end mr-4">
                                    <h4 class="text-dark ml-1">TOTAL: <?php echo $total; ?> </h4>
                                    
                                </div>
                                <!-- SOLO APARECE SI YA PAGASTE -->
                                <?php 
                                    $detalles = $ModeloMesero->getCarrito_tmp($mesa);
                                    if($detalles[0]['efectivo'] != 0){
                                ?>
                                <div class="d-flex justify-content-end mr-4">
                                    <h6 class="text-dark ml-1">Efectivo: <?php echo $detalles[0]['efectivo']; ?> </h6>
                                    <h6 class="text-dark ml-1">Cambio: <?php echo $detalles[0]['total'] - $detalles[0]['efectivo']; ?> </h6>
                                    <h6 class="text-dark ml-1">IVA 10%: <?php echo $detalles[0]['impuesto']; ?> </h6>

                                    
                                </div>
                                <div class="row" style="width:100%;height:4rem;">
                                    <form class="form-inline" method="post" action="usuarios/Controlador/endSale.php" style="width:100%;height:4rem;">
                                        <input name="mesaEndSale" type="hidden" value="<?php echo $mesa;?>" />
                                        <input name="totalEndSale" type="hidden" value="<?php echo $total;?>" />
                                        <input name="cambioEndSale" type="hidden" value="<?php echo $detalles[0]['cambio'];?>" />
                                        <input name="idMeseroSale" type="hidden" value="<?php echo $idUsuario;?>" />
                                        <button class="btn btn-success btn-icon-split my-auto" action="submit" style="width:100%;height:4rem;">
                                            <span style="width:80%;" class="text my-auto">FINALIZAR LA VENTA</span>
                                            <span style="width:20%; height:4rem;" class="icon text-white-100 my-auto">
                                                <i  class="fas fa-solid fa-step-forward py-3"></i>
                                            </span>
                                        </button>
                                    </form>
                                    
                                </div>
                                <?php 
                                    }else{

                                ?>
                                    <form class="form-inline" method="post" action="usuarios/Controlador/addDetails.php">
                                        <input name="mesaDetails" type="hidden" value="<?php echo $mesa;?>" />
                                        <input name="totalDetails" type="hidden" value="<?php echo $total;?>" />
                                        <div class="form-group mb-2 ">
                                            <label for="staticEmail2" class="sr-only">Efectivo</label>
                                            <input type="text" readonly class="form-control-plaintext" id="staticEmail2" value="Cantidad de Efectivo:">
                                        </div>
                                        <div class="form-group mx-sm-3 mb-2">
                                            <label for="inputPassword2" class="sr-only">$$$</label>
                                            <input type="text" required class="form-control" name="efectivoDetails" placeholder="$$$">
                                        </div>
                                        <button action="submit" class="btn btn-primary mb-2">Pagar</button>
                                    </form>
                                <?php } ?>

                            </div>
                        </div>

                    <?php
                        } 
                    ?>
                    
                    <div class="row " style="justify-content: center;">
                        <!-- ORDENA LAS MESAS A COMO ORDENA LA GENTE -->
                        <?php
                            $mesas = $ModeloMesero->getMesas();
                            if($mesas != null){
                            foreach($mesas as $mesa){
                                $pedidos = $ModeloMesero ->getCarrito_tmp($mesa[0]);
                        ?>
                        <!-- INICIO CARD -->
                        <div class="card mt-1 mx-2 shadow border-left-info" style="width: 18rem;">
                            
                            <div class="card-body" style=" height: 20 rem; ">
                                

                                
                                <br>
                                <h1 class="h3 m-auto">MESA <?php echo $mesa[0]; ?></h1>
                                    <!-- BOTON QUE MANDA LA MESA Y ACTIVA TABLA -->
                                    <a class="btn btn-info btn-icon-split my-auto" href="cobrar.php?mesa=<?php echo $mesa[0]; ?>" style="width:15rem;height:4rem;">
                                        <span style="width:3rem; height:4rem;" class="icon text-white-100 my-auto">
                                            <i  class="fas fa-solid fa-check-double py-3"></i>
                                        </span>
                                        <span style="width:12rem;" class="text my-auto">Ver Orden Actual</span>
                                    </a>
                                </form>
                            </div>
                        </div>  
                        <?php  
                                }
                           }
                        ?>
                        
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