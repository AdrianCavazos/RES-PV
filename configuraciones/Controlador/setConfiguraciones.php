<?php
    require_once('../Modelo/configuraciones.php');

    if($_POST["datosDelNegocio"]){
        $ModeloConfiguraciones = new Configuraciones();
        //print_r($_POST);
        foreach($_POST as $nombre => $valor) {
            if ($valor != "") {
                $ModeloConfiguraciones->setSetting($valor, $nombre);
            }
        }
    }else{
        header('Location: ../../configuraciones.php');
    }
?>