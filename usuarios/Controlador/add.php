<?php
    require_once('../Modelo/usuarios.php');

    if($_POST){
        $Modelo = new Usuarios();
        $email = $_POST['email'];
        $password = $_POST['password'];
        $userType = $_POST['usertype'];
        $Modelo->add($email,$password,$userType);
    }else{
        header('Location: ../../index.php');
    }
?>