<?php
    require_once('../Modelo/menu.php');

    if($_POST){
        $ModeloMenu = new Menu();
        $nombrecategoria = $_POST['nombrecategoria'];
        $ModeloMenu->addCategoria($nombrecategoria);
    }else{
        header('Location: ../../index.php');
    }
?>