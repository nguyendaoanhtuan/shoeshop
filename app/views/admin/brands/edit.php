<?php include_once 'app/views/sharesadmin/header.php'; ?>

<section id="main-content">
    <section class="wrapper">
        <h3><i class="fa fa-angle-right"></i> Sửa thương hiệu</h3>
        
        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <?= $_SESSION['error']; unset($_SESSION['error']); ?>
            </div>
        <?php endif; ?>
        
        <div class="row mt">
            <div class="col-md-12">
                <div class="content-panel">
                    <div class="panel-body">
                        <form action="<?= BASE_URL ?>admin/brands/edit/<?= $brand['brand_id'] ?>" method="POST" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="name">Tên thương hiệu <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="name" name="name" required 
                                       value="<?= htmlspecialchars($brand['name']) ?>">
                            </div>
                            
                            <div class="form-group">
                                <label for="description">Mô tả</label>
                                <textarea class="form-control" id="description" name="description" rows="3"><?= htmlspecialchars($brand['description']) ?></textarea>
                            </div>
                            
                            <div class="form-group">
                                <label>Logo hiện tại</label>
                                <?php if ($brand['logo_url']): ?>
                                    <div>
                                        <img src="<?= BASE_URL ?>public/<?= $brand['logo_url'] ?>" width="100" style="margin-bottom: 10px;">
                                    </div>
                                <?php else: ?>
                                    <p>Không có logo</p>
                                <?php endif; ?>
                                <label for="logo">Cập nhật logo</label>
                                <input type="file" class="form-control-file" id="logo" name="logo" accept="image/*">
                            </div>
                            
                            <div class="form-group">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="is_active" value="1" 
                                            <?= ($brand['is_active'] == 1) ? 'checked' : '' ?>>
                                        Kích hoạt
                                    </label>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-save"></i> Cập nhật
                                </button>
                                <a href="<?= BASE_URL ?>admin/brands" class="btn btn-default">
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
