<?php
    require_once('../Modelo/usuarios.php');

   
  
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema</title>
</head>
<body>
    <h1>Registrar Usuario</h1>
    <form action="../Controlador/add.php" method="post">
        Email <br>
        <input type="text" name="email" required="" autocomplete="off"><br><br>
        Contra <br>
        <input type="password" name="password" required="" autocomplete="off"><br><br>
        Tipo de usuario <br>
        <input type="text" name="usertype" required="" autocomplete="off"><br><br>
        <input type="submit" value="Registrar Usuario">
    </form>
</body>
</html>