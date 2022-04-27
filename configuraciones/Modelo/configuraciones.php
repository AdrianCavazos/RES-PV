<?php
    
    require_once(__DIR__.'/../../db.php');
    session_start();

    class Configuraciones extends Conexion{
        
        public function __construct(){
            $this->db = parent::__construct();
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
                header('Location: ../../index.php');
            }
            
        }

        public function getAllSettings(){
            $rows = null;
            $statement = $this->db->prepare("SELECT * FROM settings");
            $statement->execute();
            while ($result = $statement->fetch()) {
                $rows[] = $result; 
            }
            return $rows;
        }

        public function getSetting($settingname){
            $rows = null;
            $statement = $this->db->prepare("SELECT setting_value FROM settings WHERE setting_name = :settingname");
            $statement->bindParam(':settingname', $settingname);
            $statement->execute();
            while ($result = $statement->fetch()) {
                $rows[] = $result; 
            }
            return $rows;
        }

        public function setSetting($settingvalue, $settingname){
            $rows = null;
            $statement = $this->db->prepare("UPDATE settings SET setting_value = :settingvalue WHERE setting_name = :settingname");
            $statement->bindParam(':settingvalue', $settingvalue);
            $statement->bindParam(':settingname', $settingname);
            if ($statement->execute()) {
                header('Location: ../../configuraciones.php');
            }else{
                header('Location: ../../configuraciones.php');
            }
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