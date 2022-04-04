<?php
require_once('../Modelo/mesero.php');

if($_POST){
    $Modelo = new Meseros;
    $mesa = $_POST['mesaAll'];
    $Modelo -> deleteAllOrder_tmp($mesa);
    header("Location: ".$_SERVER['HTTP_REFERER']."");
}else{
    header("Location: ".$_SERVER['HTTP_REFERER']."");
}

?>