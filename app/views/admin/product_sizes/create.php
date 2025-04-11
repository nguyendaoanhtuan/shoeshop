<?php include_once 'app/views/sharesadmin/header.php'; ?>

<section id="main-content">
    <section class="wrapper">
        <h3><i class="fa fa-angle-right"></i> Thêm kích thước sản phẩm</h3>

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
                        <form action="<?= BASE_URL ?>admin/ProductSize/store" method="POST">
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
                                <label>Kích thước <span class="text-danger">*</span></label>
                                <div class="row">
                                    <?php foreach ($all_sizes as $size): ?>
                                        <div class="col-md-3">
                                            <div class="checkbox">
                                                <label>
                                                    <input type="checkbox" name="size_ids[]" value="<?= $size['size_id'] ?>">
                                                    <?= htmlspecialchars($size['name']) ?> (ID: <?= $size['size_id'] ?>)
                                                </label>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>

                            <div class="form-group text-right">
                                <button type="submit" class="btn btn-success">
                                    <i class="fa fa-save"></i> Lưu lại
                                </button>
                                <a href="<?= BASE_URL ?>admin/ProductSize/index" class="btn btn-secondary">
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