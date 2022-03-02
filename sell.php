<?php
    // ----- Insertar venta en tabla SELL ----- //
    include "db.php";
    $cartNumber = $_GET['variable'];
    $query = "SELECT * FROM selldetail a INNER JOIN cart b ON a.id_cart = b.id_cart INNER JOIN product c ON a.id_product = c.id_product WHERE a.id_cart = $cartNumber";
    $data = mysqli_query($conn,$query);
    $row = mysqli_num_rows($data);
    date_default_timezone_set('America/Mexico_City');
    $today = date("Y-m-d");
    $total = 0;
    while ($row = mysqli_fetch_array($data)) {
        $total = $total + $row['quantity_sellDetail'] * $row['unitaryPrice_product'];
    }
    echo $total;
    $sell = "INSERT INTO `sell`(`id_sell`, `date_sell`, `totalQuantity_sell`, `status_sell`) VALUES ('','".$today."','$total',0)";
    mysqli_query($conn,$sell);
    $query = 0;
    $data = 0;
    $row = 0;

    // ----- actualizar tabla sellDetail para asignar la venta a su detalle ----- //
    $query = "SELECT id_sell FROM sell WHERE status_sell = 0";
    $data = mysqli_query($conn,$query);
    $row = mysqli_num_rows($data);
    while ($row = mysqli_fetch_array($data)) {
        $update = "UPDATE `selldetail` SET `id_sell`='".$row['id_sell']."',`id_cart`= 0 WHERE id_sell = 0";
        mysqli_query($conn,$update);
    }
    $query = "UPDATE `sell` SET `status_sell`=1 ";
    mysqli_query($conn,$query);
    // ----- Borrar carrito ----- //
    // ----- Regresar al generador de venta ----- //
    header("location:createSale.php")
?>

