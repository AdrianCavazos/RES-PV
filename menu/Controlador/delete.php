<?php

    require_once('../Modelo/menu.php');

    if ($_POST) {
        $ModeloMenu = new Menu();
        
        $Id = $_POST['Id'];
        $ModeloMenu->delete($Id);
    }else{
        header('Location: ../../Index.php');
    }
    

?>