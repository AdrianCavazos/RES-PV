<?php
    require_once('../Modelo/menu.php');

    if($_POST){
        $ModeloMenu = new Menu();
        $nombre = $_POST['nombre'];
        $descripcion = $_POST['descripcion'];
        $marca = $_POST['marca'];
        $codigo = $_POST['codigo'];
        $existencia = $_POST['existencia'];
        $costo = $_POST['costo'];
        $precio = $_POST['precio'];
        $ModeloMenu->addPlatillo($nombre, $descripcion, $marca, $codigo, $existencia, $costo, $precio);
    }else{
        header('Location: ../../Index.php');
    }
?>