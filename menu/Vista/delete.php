<?php
    require_once('../Modelo/menu.php');


    
    $Id = $_GET['Id'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eliminar</title>
</head>
<body>
    <h1>Eliminar Platillo</h1>
    <form action="../Controlador/delete.php" method="post">
    <input type="hidden" name="Id" value="<?php echo $Id?>">
    <p>Estas seguro que deseas eliminar este Platillo?</p>
    <input type="submit" value="Eliminar Platillo">
    </form>
</body>
</html>