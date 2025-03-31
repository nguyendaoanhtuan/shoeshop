<?php
class ProductModel {
    private $db;
    
    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
    }
    
    public function getAll() {
        $query = "SELECT p.*, c.name as category_name, b.name as brand_name 
                 FROM products p 
                 JOIN categories c ON p.category_id = c.category_id
                 LEFT JOIN brands b ON p.brand_id = b.brand_id
                 ORDER BY p.product_id DESC";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
    
    public function getById($id) {
        $query = "SELECT p.*, c.name as category_name, b.name as brand_name 
                 FROM products p 
                 JOIN categories c ON p.category_id = c.category_id
                 LEFT JOIN brands b ON p.brand_id = b.brand_id
                 WHERE p.product_id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }
    
    public function add($data) {
        $query = "INSERT INTO products 
                 (name, slug, description, short_description, category_id, brand_id, 
                  price, discount_price, sku, stock_quantity, is_featured, is_active) 
                 VALUES 
                 (:name, :slug, :description, :short_description, :category_id, :brand_id, 
                  :price, :discount_price, :sku, :stock_quantity, :is_featured, :is_active)";
        
        $stmt = $this->db->prepare($query);
        return $stmt->execute($data);
    }
    
    public function update($data) {
        $query = "UPDATE products SET 
                  name = :name,
                  slug = :slug,  
                  description = :description,
                  short_description = :short_description,
                  category_id = :category_id,
                  brand_id = :brand_id,
                  price = :price,
                  discount_price = :discount_price,
                  sku = :sku,
                  stock_quantity = :stock_quantity,
                  is_featured = :is_featured,
                  is_active = :is_active
                  WHERE product_id = :product_id";
        
        $stmt = $this->db->prepare($query);
        return $stmt->execute($data);
    }
    
    public function delete($id) {
        $query = "DELETE FROM products WHERE product_id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
    
    public function getAllCategories() {
        $query = "SELECT * FROM categories ORDER BY name";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
    
    public function getAllBrands() {
        $query = "SELECT * FROM brands ORDER BY name";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
    
    public function updateStock($id, $quantity) {
        $query = "UPDATE products SET stock_quantity = :quantity WHERE product_id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':quantity', $quantity);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}