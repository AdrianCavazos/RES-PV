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
        <div id="left-sidebar-wrapper">
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
            
            <li class="nav-item active">
                <a class="nav-link" href="homeMesero.php">
                    <i class="fas fa-fw fa-utensils"></i>
                    <span>ORDENAR</span></a>
            </li>
            <li class="nav-item">
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
        </div>
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
                    <div class=" d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-900"> ORDENES </h1>
                        <!-- DROPDOWN PARA MESA -->
                        <div class="dropdown">
                                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Mesa 
                                    <?php
                                        if(!empty($_GET['mesa'])) {
                                        $selected = $_GET['mesa'];
                                        echo $selected;
                                        } else {
                                            $_GET['mesa'] = 1;
                                            $selected = $_GET['mesa'];
                                            echo $selected;
                                        }
                                    ?>
                                </button>
                                <div name="opciones" class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <a class="dropdown-item" href="homeMesero.php?mesa=1">1</a>
                                    <a class="dropdown-item" href="homeMesero.php?mesa=2">2</a>
                                    <a class="dropdown-item" href="homeMesero.php?mesa=3">3</a>
                                    <a class="dropdown-item" href="homeMesero.php?mesa=4">4</a>
                                    <a class="dropdown-item" href="homeMesero.php?mesa=5">5</a>
                                </div>
                            </div>
                        <!-- boton que activa el modal -->
                        <button class="btn btn-info btn-icon-split my-auto" data-toggle="modal" data-target="#orderModal" style="width:15rem;height:4rem;">
                            <span style="width:3rem; height:4rem;" class="icon text-white-100 my-auto">
                                <i  class="fas fa-solid fa-check-double py-3"></i>
                            </span>
                            <span style="width:12rem;" class="text my-auto">Ver Orden Actual</span>
                        </button>
                    </div>
                    <?php
                        // REFLEJA LA MESA SELECCIONADA
                        if(isset($_GET['submit'])){
                            if(!empty($_GET['opciones'])) {
                            $selected = $_GET['opciones'];
                            echo 'You have chosen: ' . $selected;
                            } else {
                            echo 'Please select the value.';
                            }
                        }
                    ?>
                    
                    <div class="container">
                        <!-- CATEGORIAS DE PRODUCTOS -->
                        <ul class="nav nav-tabs">
                            <?php
                                $categorias = $ModeloMesero->getCategorias();
                                if($categorias != null) {
                                    $active_class = 0;
                                    $category_html = '';
                                    $product_html = '';	
                                    foreach($categorias as $categoria) {
                                        $current_tab = "";
                                        $current_content = "";
                                        if(!$active_class) {
                                            $active_class = 1;
                                            $current_tab = 'active';
                                            $current_content = 'in active';
                                        }
                                        $category_html.= '<li class="nav-item"><a class="nav-link '.$current_tab.'" href="#tab'.$categoria['id_category'].'" data-toggle="tab">'.           
                                        $categoria['category_name'].'</a></li>';
                                    }
                                }
                                echo $category_html;
                            ?>
                        </ul>
                        <div class="tab-content">
                            <?php
                            if($categorias != null) {
                                $active_class = 0;
                                $category_html = '';
                                $product_html = '';	
                                foreach($categorias as $categoria) {
                                    $current_tab = "";
                                    $current_content = "";
                                    if(!$active_class) {
                                        $active_class = 1;
                                        $current_tab = 'active';
                                        $current_content = 'show active';
                                    }
                                    echo '<div id="tab'.$categoria['id_category'].'" class="tab-pane fade '.$current_content.'">';
                                    echo '<div class="row " style="justify-content: center;">';
                                    $productos = $ModeloMesero->getProductosDeCategoria($categoria['id_category']);
                                    if($productos == null){
                                        echo  '<br>No product found!';
                                    } else{
                                        foreach($productos as $producto){
                                            // VERIFICA SI EL PRODUCTO ESTÁ DISPONIBLE
                                            if($producto['productExistance']==0){
                                                $disponible = 0;
                                            } else{
                                                $disponible = 1;
                                            }
                                            //mostrar productos    
                                    ?>
                                        <!-- INICIO CARD -->
                                        <div class="card mt-1 mx-2 shadow" style="width: 18rem; filter: brightness(<?php 
                                            // SOMBREA SI NO ESTA DISPONIBLE
                                            if($disponible == 0){
                                                echo "50";
                                            } else{
                                                echo "100";
                                            }    
                                            ?>%); ">

                                            <div class="card-body" style=" height: 30 rem; ">
                                                <img style='display:block; width:15rem;height:10rem;' src="data:image/jpg;base64,<?php echo base64_encode($producto['img_product']); ?>"/>
                                                <br>
                                                <h5 class="card-title"><?php echo $producto['name_product'];?> $<?php echo $producto['unitaryPrice_product'];?></td></h5>
                                                <p class="card-text"><?php echo $producto['description_product'];?></p>
                                                
                                                <!-- TODO PARA EL FORMS -->
                                                <form id="formulario" name="formulario" method="post" action="usuarios/Controlador/addOrder.php">
                                                    <input name="mesa" type="hidden" value="<?php echo $_GET['mesa'];?>" />
                                                    <input name="id_product" type="hidden" value="<?php echo $producto['id_product'];?>" />
                                                    <input name="name_product" type="hidden" value="<?php echo $producto['name_product'];?>" />
                                                    <input name="unitaryPrice_product" type="hidden"  value="<?php echo $producto['unitaryPrice_product'];?>" class="pl-2" />
                                                
                                                <?php 
                                                    // ELECCION DE BOTON SI ESTA DISPONIBLE
                                                    if($disponible==0){
                                                ?>
                                                    <button type="button" class="btn btn-warning btn-icon-split disabled" style="width:15rem;height:4rem;">
                                                        <span class="icon text-white-50 py-3">
                                                            <i class="my-auto fas fa-exclamation-triangle"></i>
                                                        </span>
                                                        <span class="text my-auto">No Disponible por el Momento</span>
                                                    </button>
                                                <?php  
                                                    } else {
                                                ?>
                                                    <div class="form-group row">
                                                        <label class="col-sm-4 col-form-label">Cantidad</label>
                                                        <div class="col-sm-7">
                                                            <input required class="form-control" name="cantidad" type="text" placeholder="# de este plato"/>
                                                        </div>
                                                    </div>
                                                    <button type="submit" class="btn btn-primary btn-icon-split my-auto" style="width:15rem;height:4rem;">
                                                        <span style="width:3rem; height:4rem;" class="icon text-white-100 my-auto">
                                                            <i  class="fas fa-cart-plus py-3"></i>
                                                        </span>
                                                        <span style="width:12rem;" class="text my-auto">Agregar a la Orden</span>
                                                    </button>
                                                <?php } ?>
                                                </form>
                                            </div>
                                        </div>
                                    <?php
                                        }
                                        echo '</div>';
                                        echo '</div>';	
                                    }
                                    ?>
                                    
                                    <?php
                                }
                            }
                            ?>
                                </div>
                            </div>
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

    <!--Modal Orden Actual -->
    <div class="modal fade" id="orderModal" tabindex="-1" role="dialog" >
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="orderModalTitle">ORDEN ACTUAL</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                <table class="table">
                    <thead>
                        <tr>
                        <th scope="col">Mesa</th>
                        <th scope="col">Comida</th>
                        <th scope="col">Precio</th>
                        <th scope="col">Cantidad</th>
                        <th scope="col">Eliminar</th>
                        </tr>
                    </thead>
                    <tbody>
                        
                        <?php
                        $mesa = $_GET['mesa'];
                        $detalles = $ModeloMesero->getCarrito_tmp($mesa);
                        if($detalles != null){
                            foreach($detalles as $detalle){
                        ?>
                            <tr>
                                <th scope="row"><?php echo $mesa; ?></th>
                                <td><?php echo $detalle['name_product']; ?></td>
                                <td><?php echo $detalle['unitaryPrice_product']; ?></td>
                                <td><?php echo $detalle['cantidad']; ?></td>
                                <td> 
                                    <form method="post" action="usuarios/Controlador/deleteOrder.php">
                                        <input name="id_tmp" type="hidden" value="<?php echo $detalle['id_tmp'];   ?>" />
                                        <input name="mesaModal" type="hidden" value="<?php echo $mesa;   ?>" />
                                        <button type="submit" name="delete_detail" class="btn btn-danger btn-circle">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php }} ?>
                    </tbody>
                </table>
                </div>
                <div class="modal-footer">
                <form method="post" action="usuarios/Controlador/deleteAllOrder.php">
                <input name="mesaAll" type="hidden" value="<?php echo $mesa;   ?>" />
                <button type="submit" class="btn btn-danger btn-icon-split my-auto">
                    <span class="icon text-white-100 my-auto">
                        <i  class="fas fa-trash py-3"></i>
                    </span>
                    <span class="text my-auto">ELIMINAR TODA LA ORDEN</span>
                 </button>
                </form>
                </div>
            </div>
        </div>
    </div>

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