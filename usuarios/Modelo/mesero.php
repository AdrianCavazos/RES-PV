<?php
    
    require_once(__DIR__.'/../../db.php');
    session_start();

    class Meseros extends Conexion{
        
        public function __construct(){
            $this->db = parent::__construct();
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
        
        public function getCategorias(){
            $rows = null;
            $statement = $this->db->prepare("SELECT * FROM product_category");
            $statement->execute();
            while ($result = $statement->fetch()) {
                $rows[] = $result; 
            }
            return $rows;
        }

        public function getProductosDeCategoria($categoria){
            $rows = null;
            $statement = $this->db->prepare("SELECT * FROM product WHERE category_product=?");
            $statement->execute([$categoria]);
            while ($result = $statement->fetch()) {
                $rows[] = $result; 
            }
            return $rows;
        }

        public function getMesas(){
            $rows = null;
            $statement = $this->db->prepare("SELECT DISTINCT(mesa) FROM carrito_tmp");
            $statement->execute();
            while ($result = $statement->fetch()) {
                $rows[] = $result; 
            }
            return $rows;
        }

        public function getCarrito_tmp($mesa){
            $rows = null;
            $statement = $this->db->prepare("SELECT * FROM carrito_tmp WHERE mesa=?");
            $statement->execute([$mesa]);
            while ($result = $statement->fetch()) {
                $rows[] = $result; 
            }
            return $rows;
        }
        public function getLastID_sale(){
            $statement = $this->db->prepare("SELECT MAX(id_sell) FROM sell");
            $statement->execute();
            while ($result = $statement->fetch()) {
                $rows[] = $result; 
            }
            return $rows;
        }
        public function addSale($total, $cambio, $tiempo, $fecha){
            $statement = $this->db->prepare("INSERT INTO sell(date_sell, time_sell, totalQuantity_sell, change_sell) VALUES (?,?,?,?)");
            return $statement->execute([$fecha, $tiempo, $total, $cambio]);
        }

        public function addSaleDetails($id, $id_producto, $cantidad, $precio, $nombre){
            $statement = $this->db->prepare("INSERT INTO selldetail(`id_product`,`name_product`,`unitaryPrice_product`,`cuantity_sellDetail`,`id_sell`) VALUES (?,?,?,?,?)");
            return $statement->execute([$id_producto, $nombre, $precio, $cantidad, $id]);
        }

        public function addDetails_tmp($mesa, $total, $efectivo, $cambio, $impuesto){
            $statement = $this->db->prepare("UPDATE carrito_tmp SET total=?, efectivo=?, cambio=?, impuesto=? WHERE mesa=?");
            return $statement->execute([$total, $efectivo, $cambio, $impuesto, $mesa]);
        }

        public function deleteOrder_tmp($mesa, $id_tmp){
            $statement = $this->db->prepare("DELETE FROM carrito_tmp WHERE id_tmp=? AND mesa=?");
            return $statement->execute([$id_tmp, $mesa]);
        }

        public function deleteAllOrder_tmp($mesa){
            $statement = $this->db->prepare("DELETE FROM carrito_tmp WHERE mesa=?");
            return $statement->execute([$mesa]);
        }

        public function addOrder_tmp($mesa, $id_product, $name_product, $unitaryPrice_product, $cantidad){
            $statement = $this->db->prepare("INSERT INTO carrito_tmp(mesa, id_product, name_product, unitaryPrice_product, cantidad) VALUES (?,?,?,?,?)");
            return $statement->execute([$mesa, $id_product, $name_product, $unitaryPrice_product, $cantidad]);
        }
        
    }

?>