<?php
    
    require_once('db.php');
    session_start();

    class Menu extends Conexion{
        
        public function __construct(){
            $this->db = parent::__construct();
        }

        public function addPlatillo($nombre, $descripcion, $marca, $codigo, $existencia, $costo, $precio){
            $statement = $this->db->prepare("INSERT INTO product (name_product, description_product, mark_product, unitaryPrice_product, cost_product, code_product, productExistance) VALUES (:nombre, :descripcion, :marca, :precio, :costo, :codigo, :existencia)");
            $statement->bindParam(':nombre', $nombre);
            $statement->bindParam(':descripcion', $descripcion);
            $statement->bindParam(':marca', $marca);
            $statement->bindParam(':codigo', $codigo);
            $statement->bindParam(':existencia', $existencia);
            $statement->bindParam(':costo', $costo);
            $statement->bindParam(':precio', $precio);
            if ($statement->execute()) {
                header('Location: ../../menu.php');
            }else{
                header('Location: ../../menu.php');
            }
        }

        public function addUser($name,$lname,$email,$phone,$userType,$password){
            $statement = $this->db->prepare("INSERT INTO user (name_user, lname_user, phone_user, email_user, pass_user, id_userType) VALUES (:name, :lname, :phone, :email, :password, :userType)");
            $statement->bindParam(':name', $name);
            $statement->bindParam(':lname', $lname);
            $statement->bindParam(':email', $email);
            $statement->bindParam(':phone', $phone);
            $statement->bindParam(':userType', $userType);
            $statement->bindParam(':password', $password);
            if ($statement->execute()) {
                header('Location: ../../createUser.php');
            }else{
                header('Location: ../Vista/add.php');
            }
        }

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
                header('Location: ../../Index.php');
            }
            
        }

        public function get(){
            $rows = null;
            $statement = $this->db->prepare("SELECT * FROM product");
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
            $statement = $this->db->prepare("DELETE FROM product WHERE id_product = :Id");
            $statement->bindParam(':Id',$Id);
            if ($statement->execute()) {
                header('Location: ../../menu.php');
            }else{
                header('Location: ../../createUser.php');
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
                header('Location: ../../Index.php');
            }
        }

        public function validateSessionAdministrator(){
            if ($_SESSION['ID'] != null) {
                if ($_SESSION['PERFIL'] == 'Docente') {
                    header('Location: ../../Estudiantes/Vista/Index.php');
                }
            }
        }

        public function salir(){
            $_SESSION['ID'] = null;
            $_SESSION['NOMBRE'] = null;
            $_SESSION['PERFIL'] = null;
            session_destroy();
            header('Location: ../../Index.php');
        }
    }

?>