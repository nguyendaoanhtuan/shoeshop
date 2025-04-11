<?php include_once 'app/views/sharesadmin/header.php'; ?>

<section id="main-content">
    <section class="wrapper">
        <h3><i class="fa fa-angle-right"></i> Sửa kích thước sản phẩm: <?= htmlspecialchars($product['name']) ?></h3>

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
                        <form action="<?= BASE_URL ?>admin/ProductSize/update" method="POST">
                            <input type="hidden" name="product_id" value="<?= $product['product_id'] ?>">
                            <div class="form-group">
                                <label>Kích thước</label>
                                <div class="row">
                                    <?php 
                                        $current_size_ids = array_column($current_sizes, 'size_id');
                                        foreach ($all_sizes as $size): 
                                    ?>
                                        <div class="col-md-3">
                                            <div class="checkbox">
                                                <label>
                                                    <input type="checkbox" name="size_ids[]" value="<?= $size['size_id'] ?>" 
                                                        <?= in_array($size['size_id'], $current_size_ids) ? 'checked' : '' ?>>
                                                    <?= htmlspecialchars($size['name']) ?> (ID: <?= $size['size_id'] ?>)
                                                </label>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>

                            <div class="form-group text-right">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-save"></i> Cập nhật
                                </button>
                                <a href="<?= BASE_URL ?>admin/ProductSize/index" class="btn btn-default">
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