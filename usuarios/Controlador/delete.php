<?php

    require_once('../Modelo/usuarios.php');

    if ($_POST) {
        $Modelo = new Usuarios();
        
        $Id = $_POST['Id'];
        $Modelo->delete($Id);
    }else{
        header('Location: ../../Index.php');
    }
    

?>