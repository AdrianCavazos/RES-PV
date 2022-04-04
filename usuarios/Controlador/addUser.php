<?php
require_once('../Modelo/usuarios.php');

if($_POST){
    $Modelo = new Usuarios();
    $name = $_POST['name'];
    $lname = $_POST['lname'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $userType = $_POST['userType'];
    $password = $_POST['pass'];
    $password2 = $_POST['pass2'];
    $Modelo->addUser($name,$lname,$email,$phone,$userType,$password);
}else{
    header('Location: ../../index.php');
}

?>