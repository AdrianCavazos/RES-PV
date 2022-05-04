<?php
session_start();
if(!empty($_SESSION["userId"])) {
    require_once('usuarios/Modelo/usuarios.php');
    $Modelo = new Usuarios();
    $tipoDeUsuario = $Modelo->getUserType($_SESSION["userId"]);
    if (!$tipoDeUsuario) {
        $_SESSION["errorMessage"] = "Invalid Credentials";
    } else {
        switch($tipoDeUsuario){
            case 1:
                header('Location: homeAdministrador.php');
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
    require_once 'login.php';
}
?>