<?php
    include "db.php";
    $idUser = $_GET['variable'];
    $query = "DELETE FROM user WHERE id_user = $idUser";
    mysqli_query($conn,$query);
    header("location:createUser.php");

?>