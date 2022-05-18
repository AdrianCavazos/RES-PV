<?php
require_once('../Modelo/mesero.php');

if($_POST){
    $Modelo = new Meseros;
    $pIva = $Modelo->getIva();
    $pIva = $pIva[0][0];
    $efectivo = $_POST['efectivoDetails'];
    $total = $_POST['totalDetails'];
    $mesa = $_POST['mesaDetails'];
    $cambio = $total - $efectivo;
    $impuesto = $total * ($pIva/100);

    $Modelo -> addDetails_tmp($mesa, $total, $efectivo, $cambio, $impuesto );
    header("Location: ".$_SERVER['HTTP_REFERER']."");
}else{
    header("Location: ".$_SERVER['HTTP_REFERER']."");
}

?>