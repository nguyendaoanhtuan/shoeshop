<?php
class ProductModel {
    private $db;
    
    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
    }
    
    public function getAll($parentCategoryId = null) {
        $query = "SELECT p.*, c.name as category_name, b.name as brand_name,
                  (SELECT pi.image_url FROM product_images pi WHERE pi.product_id = p.product_id AND pi.is_primary = 1 LIMIT 1) as primary_image
                  FROM products p 
                  JOIN categories c ON p.category_id = c.category_id
                  LEFT JOIN brands b ON p.brand_id = b.brand_id";
        
        // Nếu có parentCategoryId, lọc sản phẩm theo danh mục cha
        if ($parentCategoryId) {
            $query .= " WHERE c.parent_id = :parentCategoryId";
        }
        
        $query .= " ORDER BY p.product_id DESC";
        
        $stmt = $this->db->prepare($query);
        
        if ($parentCategoryId) {
            $stmt->bindParam(':parentCategoryId', $parentCategoryId, PDO::PARAM_INT);
        }
        
        $stmt->execute();
        $products = $stmt->fetchAll(PDO::FETCH_OBJ);

        // Lấy danh sách kích thước cho từng sản phẩm
        foreach ($products as $product) {
            $product->sizes = $this->getSizesByProduct($product->product_id);
        }

        return $products;
    }
    
    public function getById($id) {
        $query = "SELECT p.*, c.name as category_name, b.name as brand_name,
                  (SELECT pi.image_url FROM product_images pi WHERE pi.product_id = p.product_id AND pi.is_primary = 1 LIMIT 1) as primary_image
                  FROM products p 
                  JOIN categories c ON p.category_id = c.category_id
                  LEFT JOIN brands b ON p.brand_id = b.brand_id
                  WHERE p.product_id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $product = $stmt->fetch(PDO::FETCH_OBJ);

        if ($product) {
            $product->sizes = $this->getSizesByProduct($product->product_id);
        }

        return $product;
    }

    // Lấy danh sách kích thước của một sản phẩm
    public function getSizesByProduct($product_id) {
        $query = "SELECT pv.variant_id, s.name as size_name 
                  FROM product_variants pv 
                  JOIN sizes s ON pv.size_id = s.size_id 
                  WHERE pv.product_id = :product_id 
                  ORDER BY s.name ASC";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':product_id', $product_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
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
    
    public function getStockByVariantId($variant_id) {
        $query = "SELECT p.stock_quantity 
                  FROM products p
                  JOIN product_variants pv ON p.product_id = pv.product_id
                  WHERE pv.variant_id = :variant_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':variant_id', $variant_id, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_OBJ);
        return $result ? $result->stock_quantity : 0;
    }

    public function updateStockByVariantId($variant_id, $quantity) {
        $query = "UPDATE products p
                  JOIN product_variants pv ON p.product_id = pv.product_id
                  SET p.stock_quantity = p.stock_quantity - :quantity
                  WHERE pv.variant_id = :variant_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':quantity', $quantity, PDO::PARAM_INT);
        $stmt->bindParam(':variant_id', $variant_id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function getPaginatedProducts($search = '', $page = 1, $perPage = 10, $parentCategoryId = null, $sort = 'product_id_asc', $categoryId = null, $brandId = null) {
        $offset = ($page - 1) * $perPage;
        
        $query = "SELECT p.*, c.name as category_name, b.name as brand_name,
                 (SELECT pi.image_url FROM product_images pi WHERE pi.product_id = p.product_id AND pi.is_primary = 1 LIMIT 1) as primary_image
                 FROM products p 
                 JOIN categories c ON p.category_id = c.category_id
                 LEFT JOIN brands b ON p.brand_id = b.brand_id
                 WHERE 1=1";
        
        $params = [];
        if (!empty($search)) {
            $query .= " AND (p.name LIKE :search OR p.sku LIKE :search)";
            $params[':search'] = "%$search%";
        }
        
        if ($parentCategoryId) {
            $query .= " AND c.parent_id = :parentCategoryId";
            $params[':parentCategoryId'] = $parentCategoryId;
        }

        if ($categoryId) {
            $query .= " AND p.category_id = :categoryId";
            $params[':categoryId'] = $categoryId;
        }

        if ($brandId) {
            $query .= " AND p.brand_id = :brandId";
            $params[':brandId'] = $brandId;
        }
        
        $countQuery = "SELECT COUNT(*) FROM products p 
                      JOIN categories c ON p.category_id = c.category_id
                      LEFT JOIN brands b ON p.brand_id = b.brand_id
                      WHERE 1=1";
        if (!empty($search)) {
            $countQuery .= " AND (p.name LIKE :search OR p.sku LIKE :search)";
        }
        if ($parentCategoryId) {
            $countQuery .= " AND c.parent_id = :parentCategoryId";
        }
        if ($categoryId) {
            $countQuery .= " AND p.category_id = :categoryId";
        }
        if ($brandId) {
            $countQuery .= " AND p.brand_id = :brandId";
        }
        
        // Xử lý sắp xếp
        switch ($sort) {
            case 'price_asc':
                $query .= " ORDER BY p.price ASC";
                break;
            case 'price_desc':
                $query .= " ORDER BY p.price DESC";
                break;
            case 'name_asc':
                $query .= " ORDER BY p.name ASC";
                break;
            case 'name_desc':
                $query .= " ORDER BY p.name DESC";
                break;
            case 'date_asc':
                $query .= " ORDER BY p.product_id ASC"; // Giả sử product_id tương ứng với thứ tự tạo
                break;
            case 'date_desc':
                $query .= " ORDER BY p.product_id DESC";
                break;
            default:
                $query .= " ORDER BY p.product_id ASC";
        }
        
        $query .= " LIMIT :offset, :perPage";
        
        $countStmt = $this->db->prepare($countQuery);
        foreach ($params as $key => $value) {
            $countStmt->bindValue($key, $value);
        }
        $countStmt->execute();
        $totalRecords = $countStmt->fetchColumn();
        
        $stmt = $this->db->prepare($query);
        foreach ($params as $key => $value) {
            $stmt->bindValue($key, $value);
        }
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->bindValue(':perPage', $perPage, PDO::PARAM_INT);
        
        $stmt->execute();
        $products = $stmt->fetchAll(PDO::FETCH_OBJ);
        
        foreach ($products as $product) {
            $product->sizes = $this->getSizesByProduct($product->product_id);
        }
        
        return [
            'products' => $products,
            'totalRecords' => $totalRecords,
            'totalPages' => ceil($totalRecords / $perPage)
        ];
    }
}
?>