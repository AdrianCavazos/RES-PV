<?php
require_once(__DIR__.'/../Modelo/mesero.php');
require_once(__DIR__.'/../../ticket.php');

if($_POST){
    $Modelo = new Meseros;
    $mesa = $_POST['mesaEndSale'];
    $total = $_POST['totalEndSale'];
    $efectivo = $_POST['efectivoEndSale'];
    $cambio = $_POST['cambioEndSale'];
    $idusuario = $_POST['idMeseroSale'];
    $timezone = $_POST['timezone'];
    $generarTicket = $_POST['generarTicket'];
    date_default_timezone_set($timezone);
    $tiempo = date("H:i:s");
    $fecha = date("Y/m/d");
    $Modelo -> addSale($total, $cambio, $tiempo, $fecha, $idusuario);

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

    if ($generarTicket == "Yes") {
        $datosTienda = $Modelo->getAllSettings();
        if ($datosTienda != null) {
            $valor = array_search('nombre_comercial',array_column($datosTienda,'setting_name'));
            $nombreCom = $datosTienda[$valor][2];
            $valor = array_search('razon_social',array_column($datosTienda,'setting_name'));
            $razonSoc = $datosTienda[$valor][2];
            $valor = array_search('direccion_1',array_column($datosTienda,'setting_name'));
            $dir1 = $datosTienda[$valor][2];
            $valor = array_search('direccion_2',array_column($datosTienda,'setting_name'));
            $dir2 = $datosTienda[$valor][2];
            $valor = array_search('direccion_cp',array_column($datosTienda,'setting_name'));
            $cPostal = $datosTienda[$valor][2];
            $valor = array_search('direccion_ciudad',array_column($datosTienda,'setting_name'));
            $ciudad = $datosTienda[$valor][2];
            $valor = array_search('direccion_estado',array_column($datosTienda,'setting_name'));
            $estado = $datosTienda[$valor][2];
            $valor = array_search('direccion_pais',array_column($datosTienda,'setting_name'));
            $pais = $datosTienda[$valor][2];
            $valor = array_search('email',array_column($datosTienda,'setting_name'));
            $email = $datosTienda[$valor][2];
            $valor = array_search('telefono',array_column($datosTienda,'setting_name'));
            $telefono = $datosTienda[$valor][2];
            $valor = array_search('rfc',array_column($datosTienda,'setting_name'));
            $rfc = $datosTienda[$valor][2];
            $valor = array_search('porcentaje_iva',array_column($datosTienda,'setting_name'));
            $pIva = $datosTienda[$valor][2];
            $valor = array_search('numero_caja',array_column($datosTienda,'setting_name'));
            $nCaja = $datosTienda[$valor][2];
            $valor = array_search('numero_sucursal',array_column($datosTienda,'setting_name'));
            $nSuc = $datosTienda[$valor][2];
            $valor = array_search('contacto_sucursal',array_column($datosTienda,'setting_name'));
            $contSuc = $datosTienda[$valor][2];
            $idusuario = $Modelo->getUser($_SESSION["userId"]);
            $mesero = $idusuario[0]["name_user"];
        }
        $Modelo -> deleteAllOrder_tmp($mesa);
        hacerTicket($nombreCom,$razonSoc,$dir1,$dir2,$cPostal,$ciudad,$estado,$pais,$email,$telefono,$rfc,$id,$fecha,$tiempo,$mesero,$mesa,$nCaja,$pIva,$total,$efectivo,$cambio,$detalles,$nSuc,$contSuc);
    }
    $Modelo -> deleteAllOrder_tmp($mesa);
    header("Location: /cobrar.php");
}else{
    header("Location: /cobrar.php");
}

?>