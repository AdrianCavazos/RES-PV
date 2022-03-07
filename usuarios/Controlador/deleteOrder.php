<?php
require_once('../Modelo/mesero.php');

if($_POST){
    $Modelo = new Meseros;
    $id_tmp = $_POST['id_tmp'];
    $mesa = $_POST['mesaModal'];
    $Modelo -> deleteOrder_tmp($mesa, $id_tmp);
    header("Location: ".$_SERVER['HTTP_REFERER']."");
}else{
    header("Location: ".$_SERVER['HTTP_REFERER']."");
}

?>