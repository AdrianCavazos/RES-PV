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
        $categoria = $_POST['categoria'];
        $imagen = file_get_contents($_FILES['imagen']['tmp_name']);
        $ModeloMenu->addPlatillo($nombre, $descripcion, $marca, $codigo, $existencia, $costo, $precio, $categoria, $imagen);
    }else{
        header('Location: ../../index.php');
    }
?>