<?php include_once 'app/views/sharesadmin/header.php'; ?>

<section id="main-content">
    <section class="wrapper">
        <h3><i class="fa fa-angle-right"></i> Sửa hình ảnh sản phẩm</h3>
        
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
                        <form action="<?= BASE_URL ?>admin/ProductImg/update" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="image_id" value="<?= $image['image_id'] ?>">
                            <div class="form-group">
                                <label>Hình ảnh hiện tại</label>
                                <div>
                                    <img src="<?= BASE_URL ?>public/<?= htmlspecialchars($image['image_url']) ?>" width="100" style="margin-bottom: 10px;">
                                </div>
                                <label for="image">Cập nhật hình ảnh</label>
                                <input type="file" class="form-control-file" id="image" name="image" accept="image/*">
                                <small class="form-text text-muted">Để trống nếu không muốn thay đổi</small>
                            </div>
                            
                            <div class="form-group">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="is_primary" value="1" <?= $image['is_primary'] ? 'checked' : '' ?>>
                                        Là hình ảnh chính
                                    </label>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="display_order">Thứ tự hiển thị</label>
                                <input type="number" class="form-control" id="display_order" name="display_order" value="<?= htmlspecialchars($image['display_order']) ?>">
                            </div>
                            
                            <div class="form-group text-right">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-save"></i> Cập nhật
                                </button>
                                <a href="<?= BASE_URL ?>admin/product_images/index" class="btn btn-default">
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