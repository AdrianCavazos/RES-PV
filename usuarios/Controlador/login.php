<?php

require_once('../Modelo/usuarios.php');

if (!empty($_POST["login"])) {
    session_start();
    $Modelo = new Usuarios();
    $email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);
    $password = filter_var($_POST["password"], FILTER_SANITIZE_STRING);
    $isLoggedIn = $Modelo->login($email,$password);
    if (!$isLoggedIn) {
        $_SESSION["errorMessage"] = "Invalid Credentials";
    } else {
        switch($isLoggedIn){
            case 1:
                header('Location:../../homeAdministrador.php');
            break;
            case 2:
                header('Location:../../homeMesero.php');
            break;
            case 3:
                header('Location:../../homeContador.php');
            break;
        }
    }
}else{
    header('Location: ../../index.php');
}

?>

<?php
/* 
require_once('../Modelo/usuarios.php');

if (!empty($_POST["login"])) {
    session_start();
    $email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);
    $password = filter_var($_POST["password"], FILTER_SANITIZE_STRING);
    
    $Modelo = new Usuarios();
    $isLoggedIn = $Modelo->login($email, $password);
    if (! $isLoggedIn) {
        $_SESSION["errorMessage"] = "Invalid Credentials";
    }
    header('Location: ../../index.php');
    exit();
}
 */
?>