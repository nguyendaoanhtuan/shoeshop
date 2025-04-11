<?php include_once 'app/views/sharesadmin/header.php'; ?>

<section id="main-content">
    <section class="wrapper">
        <h3><i class="fa fa-angle-right"></i> Thêm hình ảnh sản phẩm</h3>

        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert">×</button>
                <?= $_SESSION['success']; unset($_SESSION['success']); ?>
            </div>
        <?php endif; ?>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert">×</button>
                <?= $_SESSION['error']; unset($_SESSION['error']); ?>
            </div>
        <?php endif; ?>

        <div class="row mt">
            <div class="col-md-12">
                <div class="content-panel">
                    <div class="panel-body">
                        <form action="<?= BASE_URL ?>admin/ProductImg/store" method="POST" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="product_id">Sản phẩm <span class="text-danger">*</span></label>
                                <select class="form-control" id="product_id" name="product_id" required>
                                    <option value="">Chọn sản phẩm</option>
                                    <?php foreach ($products as $product): ?>
                                        <option value="<?= $product['product_id'] ?>" <?= isset($_POST['product_id']) && $_POST['product_id'] == $product['product_id'] ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($product['name']) ?> (ID: <?= $product['product_id'] ?>)
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="image">Hình ảnh <span class="text-danger">*</span></label>
                                <input type="file" class="form-control-file" id="image" name="image" accept="image/*" required>
                                <small class="form-text text-muted">Chỉ chấp nhận file ảnh (jpg, png, gif) - Tối đa 2MB</small>
                            </div>

                            <div class="form-group">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="is_primary" value="1" <?= isset($_POST['is_primary']) ? 'checked' : '' ?>>
                                        Là hình ảnh chính
                                    </label>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="display_order">Thứ tự hiển thị</label>
                                <input type="number" class="form-control" id="display_order" name="display_order" value="<?= isset($_POST['display_order']) ? htmlspecialchars($_POST['display_order']) : '0' ?>">
                            </div>

                            <div class="form-group text-right">
                                <button type="submit" class="btn btn-success">
                                    <i class="fa fa-save"></i> Lưu lại
                                </button>
                                <a href="<?= BASE_URL ?>admin/ProductImg/index" class="btn btn-secondary">
                                    <i class="fa fa-arrow-left"></i> Quay lại
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</section>

<?php include_once 'app/views/sharesadmin/footer.php'; ?>