<?php
    require_once('../Modelo/menu.php');

    if($_POST){
        $ModeloMenu = new Menu();
        $idcategoria = $_POST['idcategoria'];
        $nuevonombre = $_POST['nuevonombre'];
        $ModeloMenu->setCategoria($nuevonombre,$idcategoria);
    }else{
        header('Location: ../../index.php');
    }
?>