<?php

?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Login - Res-PV</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body class="bg-gradient-primary">

    <div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-xl-6 col-lg-12 col-md-9">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Res-PV</h1>
                                        <h2 class="h4 text-gray-900 mb-4">Bienvenido</h2>
                                    </div>
                                    <form class="user" method="post" action="usuarios/Controlador/login.php" id="frmLogin" onSubmit="return validate();">
                                        <?php 
                                            if(isset($_SESSION["errorMessage"])) {
                                            ?>
                                            <div class="error-message"><?php  echo $_SESSION["errorMessage"]; ?></div>
                                            <?php 
                                            unset($_SESSION["errorMessage"]);
                                            }
                                        ?> 
                                        <div class="form-group">
                                            <input required type="email" name="email" class="form-control form-control-user" id="email"
                                                aria-describedby="emailHelp" placeholder="Direccion de correo electronico">
                                        </div>
                                        <div>
                                            <span id="user_info" class="error-info"></span>
                                        </div>
                                        <div class="form-group">
                                            <input required type="password" name="password" class="form-control form-control-user" placeholder="Contraseña">
                                        </div>
                                        <div>
                                            <span id="password_info" class="error-info"></span>
                                        </div>
                                        <hr>
                                        <input type="submit" class="btn btn-primary btn-user btn-block" name="login" value="Iniciar Sesion">
                                        <hr>
                                    </form>
                                    <div class="text-center">
                                        <a class="small" href="forgot-password.php">Olvidaste tu contraseña?</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
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

    <script>
    function validate() {
        var $valid = true;
        document.getElementById("user_info").innerHTML = "";
        document.getElementById("password_info").innerHTML = "";
        
        var userName = document.getElementById("email").value;
        var password = document.getElementById("password").value;
        if(userName == "") 
        {
            document.getElementById("user_info").innerHTML = "required";
        	$valid = false;
        }
        if(password == "") 
        {
        	document.getElementById("password_info").innerHTML = "required";
            $valid = false;
        }
        return $valid;
    }
    </script>

</body>

</html>