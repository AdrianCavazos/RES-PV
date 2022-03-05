<?php

    require_once('../Modelo/ventas.php');

    if ($_POST) {
        $ModeloVentas = new Ventas();
        
        $Id = $_POST['Id'];
        $ModeloVentas->delete($Id);
    }else{
        header('Location: ../../index.php');
    }
    

?>