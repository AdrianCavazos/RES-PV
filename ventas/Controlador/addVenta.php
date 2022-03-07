<?php
    require_once('../Modelo/ventas.php');

    if($_POST){
        $ModeloVentas = new Ventas();
        $id_producto = $_POST['id_producto'];
        $nombre_producto = $_POST['nombre_producto'];
        $precio = $_POST['precio'];
        $cantidad = $_POST['cantidad'];
        $ModeloVentas->addVenta($id_producto, $nombre_producto, $precio, $cantidad);
    }else{
        header('Location: ../../index.php');
    }
?>