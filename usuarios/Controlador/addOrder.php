<?php
require_once('../Modelo/mesero.php');

if($_POST){
    $Modelo = new Meseros;
    $id_product = $_POST['id_product'];
    $name_product = $_POST['name_product'];
    $unitaryPrice_product = $_POST['unitaryPrice_product'];
    $cantidad = $_POST['cantidad'];
    $mesa = $_POST['mesa'];
    $Modelo -> addOrder_tmp($mesa, $id_product, $name_product, $unitaryPrice_product, $cantidad);
    header("Location: ".$_SERVER['HTTP_REFERER']."");
}else{
    header("Location: ".$_SERVER['HTTP_REFERER']."");
}

?>