<?php

    require_once('../Modelo/usuarios.php');

    if ($_POST) {
        $Modelo = new Usuarios();
        $email = $_POST['email'];
        $password = $_POST['password'];
        $Modelo->login($email,$password);

    }else{
        header('Location: ../../index.php');
    }

?>