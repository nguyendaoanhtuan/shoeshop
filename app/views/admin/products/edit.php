<?php include_once 'app/views/sharesadmin/header.php'; ?>

<section id="main-content">
    <section class="wrapper">
        <div class="content-panel">
            <h4><i class="fa fa-angle-right"></i> Chỉnh sửa sản phẩm</h4>
            <hr>

            <?php if (isset($_SESSION['error'])): ?>
                <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    <?= $_SESSION['error']; unset($_SESSION['error']); ?>
                </div>
            <?php endif; ?>

            <?php if (isset($_SESSION['success'])): ?>
                <div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    <?= $_SESSION['success']; unset($_SESSION['success']); ?>
                </div>
            <?php endif; ?>

            <form method="POST" action="<?= BASE_URL ?>admin/product/edit/<?= $product->product_id ?>" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-6">
                        <!-- Basic Information -->
                        <div class="form-group">
                            <label for="name">Tên sản phẩm *</label>
                            <input type="text" class="form-control" id="name" name="name" value="<?= htmlspecialchars($product->name) ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="short_description">Mô tả ngắn</label>
                            <textarea class="form-control" id="short_description" name="short_description" rows="3"><?= htmlspecialchars($product->short_description ?? '') ?></textarea>
                        </div>
                        <div class="form-group">
                            <label for="description">Mô tả chi tiết</label>
                            <textarea class="form-control" id="description" name="description" rows="5"><?= htmlspecialchars($product->description ?? '') ?></textarea>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <!-- Pricing & Inventory -->
                        <div class="form-group">
                            <label for="price">Giá bán *</label>
                            <input type="number" class="form-control" id="price" name="price" min="0" step="1000" value="<?= htmlspecialchars($product->price) ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="discount_price">Giá khuyến mãi</label>
                            <input type="number" class="form-control" id="discount_price" name="discount_price" min="0" step="1000" value="<?= htmlspecialchars($product->discount_price ?? '') ?>">
                        </div>
                        <div class="form-group">
                            <label for="stock_quantity">Số lượng tồn kho</label>
                            <input type="number" class="form-control" id="stock_quantity" name="stock_quantity" min="0" value="<?= htmlspecialchars($product->stock_quantity ?? 0) ?>">
                        </div>

                        <!-- Categories & Brands -->
                        <div class="form-group">
                            <label for="category_id">Danh mục *</label>
                            <select class="form-control" id="category_id" name="category_id" required>
                                <option value="">-- Chọn danh mục --</option>
                                <?php foreach ($categories as $category): ?>
                                    <option value="<?= $category->category_id ?>" <?= $product->category_id == $category->category_id ? 'selected' : '' ?>>
                                        <?= $category->name ?> (<?= $category->parent_id == 1 ? 'Nam' : ($category->parent_id == 2 ? 'Nữ' : 'Không xác định') ?>)
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="brand_id">Thương hiệu</label>
                            <select class="form-control" id="brand_id" name="brand_id">
                                <option value="">-- Chọn thương hiệu --</option>
                                <?php foreach ($brands as $brand): ?>
                                    <option value="<?= $brand->brand_id ?>" <?= $product->brand_id == $brand->brand_id ? 'selected' : '' ?>>
                                        <?= $brand->name ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- Status & Features -->
                        <div class="form-group">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="is_featured" value="1" <?= $product->is_featured ? 'checked' : '' ?>> Sản phẩm nổi bật
                                </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="is_active" value="1" <?= $product->is_active ? 'checked' : '' ?>> Kích hoạt
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Cập nhật sản phẩm</button>
                    <a href="<?= BASE_URL ?>admin/product" class="btn btn-default">Hủy bỏ</a>
                </div>
            </form>
        </div>
    </section>
</section>

<?php include_once 'app/views/sharesadmin/footer.php'; ?>