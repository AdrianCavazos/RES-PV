<?php
    include "db.php";
    $id = $_GET['variable'];
    $query = "DELETE FROM product WHERE id_product = $id";
    mysqli_query($conn,$query);
    header("location:menu.php");



?>