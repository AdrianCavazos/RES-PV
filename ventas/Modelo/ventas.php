<?php
    
    require_once(__DIR__.'/../../db.php');
    if(!isset($_SESSION)) { 
        session_start(); 
    } 

    class Ventas extends Conexion{
        
        public function __construct(){
            $this->db = parent::__construct();
        }

//TODO: implementar o eliminar funcion addVenta para contador
/*        public function addVenta($id_producto, $nombre_producto, $precio, $cantidad){
            $statement = $this->db->prepare("INSERT INTO sell (id_product, name_product, unitaryPrice_product, quantity_sell) VALUES (:id_producto, :nombre_producto, :precio, :cantidad)");
            $statement->bindParam(':id_producto', $id_producto);
            $statement->bindParam(':nombre_producto', $nombre_producto);
            $statement->bindParam(':precio', $precio);
            $statement->bindParam(':cantidad', $cantidad);
            if ($statement->execute()) {
                header('Location: ../../sales.php');
            }else{
                header('Location: ../../sales.php');
            }
        }
        */

        public function login($email, $password){
            // $rows = null;
            $statement = $this->db->prepare("SELECT * FROM user WHERE email_user = :Email AND pass_user = :Password LIMIT 1");
            $statement->bindParam(':Email',$email);
            $statement->bindParam(':Password',$password);
            if ($statement->execute()) {
                $user = $statement->fetch();
                if($user!=null){
                    switch($user['userType']){
                        case 1:
                            header('Location:../../homeAdministrador.php');
                        break;
                        case 2:
                            header('Location:../../homeMesero.php');
                        break;
                        case 3:
                            header('Location:../../homeContador.php');
                        break;
                    }
                }else{
                    echo "No existe ese usuario con esa contraseña";
                }
               
            }else{
                header('Location: ../../index.php');
            }
            
        }

        public function get(){
            $rows = null;
            $statement = $this->db->prepare("SELECT * FROM sell");
            $statement->execute();
            while ($result = $statement->fetch()) {
                $rows[] = $result; 
            }
            return $rows;
        }

        public function getVenta($id_venta){
            $rows = null;
            $statement = $this->db->prepare("SELECT * FROM sell WHERE id_sell = :id_venta");
            $statement->bindParam(':id_venta', $id_venta);
            $statement->execute();
            while ($result = $statement->fetch()) {
                $rows[] = $result; 
            }
            return $rows;
        }

        public function getArticulosVenta($id_venta){
            $rows = null;
            $statement = $this->db->prepare("SELECT * FROM selldetail WHERE id_sell = :id_venta");
            $statement->bindParam(':id_venta', $id_venta);
            $statement->execute();
            while ($result = $statement->fetch()) {
                $rows[] = $result; 
            }
            return $rows;
        }

        public function getUserType(){
            $rows = null;
            $statement = $this->db->prepare("SELECT * FROM userType");
            $statement->execute();
            while($result = $statement->fetch()){
                $rows[] = $result;
            }
            return $rows;
        }

        public function delete($Id){
            $statement = $this->db->prepare("DELETE FROM sell WHERE id_sell = :Id");
            $statement->bindParam(':Id',$Id);
            if ($statement->execute()) {
                header('Location: ../../sales.php');
            }else{
                header('Location: ../../sales.php');
            }
        }

        public function getNombre(){
            return $_SESSION['NOMBRE'];
        }

        public function getId(){
            return $_SESSION['ID'];
        }

        public function getPerfil(){
            return $_SESSION['PERFIL'];
        }

        public function validateSession(){
            if ($_SESSION['ID'] == null) {
                header('Location: ../../index.php');
            }
        }

        public function salir(){
            $_SESSION['ID'] = null;
            $_SESSION['NOMBRE'] = null;
            $_SESSION['PERFIL'] = null;
            session_destroy();
            header('Location: ../../index.php');
        }
    }

?>