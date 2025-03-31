<?php include_once 'app/views/sharesadmin/header.php'; ?>

<section id="main-content">
    <section class="wrapper">
        <div class="content-panel">
            <h4><i class="fa fa-angle-right"></i> Thêm sản phẩm mới</h4>
            <hr>
            
            <form method="POST" action="?controller=product&action=create" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-6">
                        <!-- Basic Information -->
                        <div class="form-group">
                            <label for="name">Tên sản phẩm *</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>                                              
                        <div class="form-group">
                            <label for="short_description">Mô tả ngắn</label>
                            <textarea class="form-control" id="short_description" name="short_description" rows="3"></textarea>
                        </div>
                        
                        <div class="form-group">
                            <label for="description">Mô tả chi tiết</label>
                            <textarea class="form-control" id="description" name="description" rows="5"></textarea>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <!-- Pricing & Inventory -->
                        <div class="form-group">
                            <label for="price">Giá bán *</label>
                            <input type="number" class="form-control" id="price" name="price" min="0" step="1000" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="discount_price">Giá khuyến mãi</label>
                            <input type="number" class="form-control" id="discount_price" name="discount_price" min="0" step="1000">
                        </div>
                        
                        <div class="form-group">
                            <label for="stock_quantity">Số lượng tồn kho</label>
                            <input type="number" class="form-control" id="stock_quantity" name="stock_quantity" min="0" value="0">
                        </div>
                        
                        <!-- Categories & Brands -->
                        <div class="form-group">
                            <label for="category_id">Danh mục *</label>
                            <select class="form-control" id="category_id" name="category_id" required>
                                <option value="">-- Chọn danh mục --</option>
                                <?php foreach ($categories as $category): ?>
                                <option value="<?= $category->category_id ?>"><?= $category->name ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="brand_id">Thương hiệu</label>
                            <select class="form-control" id="brand_id" name="brand_id">
                                <option value="">-- Chọn thương hiệu --</option>
                                <?php foreach ($brands as $brand): ?>
                                <option value="<?= $brand->brand_id ?>"><?= $brand->name ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        
                        <!-- Status & Features -->
                        <div class="form-group">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="is_featured" value="1"> Sản phẩm nổi bật
                                </label>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="is_active" value="1" checked> Kích hoạt
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Thêm sản phẩm</button>
                    <a href="?controller=product&action=index" class="btn btn-default">Hủy bỏ</a>
                </div>
            </form>
        </div>
    </section>
</section>

<?php include_once 'app/views/sharesadmin/footer.php'; ?>