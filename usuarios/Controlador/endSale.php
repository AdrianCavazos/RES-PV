<?php
require_once('../Modelo/mesero.php');

if($_POST){
    $Modelo = new Meseros;
    $mesa = $_POST['mesaEndSale'];
    $total = $_POST['totalEndSale'];
    $cambio = $_POST['cambioEndSale'];
    $tiempo = date("h:i:sa");
    $fecha = date("Y/m/d");
    $Modelo -> addSale($total, $cambio, $tiempo, $fecha);

    $ids = $Modelo -> getLastID_sale();
    if(is_null($ids)){
        $id=0;
    } else{
        $id = $ids[0][0];
    }
    $detalles = $Modelo -> getCarrito_tmp($mesa);
    foreach($detalles as $detalle){
        $id_producto = $detalle['id_product'];
        $cantidad = $detalle['cantidad'];
        $precio = $detalle['unitaryPrice_product'];
        $nombre = $detalle['name_product'];
        $Modelo -> addSaleDetails($id, $id_producto, $cantidad, $precio, $nombre);
    }

    $Modelo -> deleteAllOrder_tmp($mesa);
    header("Location: http://localhost/RES-PV/cobrar.php");
}else{
    header("Location: http://localhost/RES-PV/cobrar.php");
}

?>