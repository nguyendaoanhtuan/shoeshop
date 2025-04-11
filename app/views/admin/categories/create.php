<?php include_once 'app/views/sharesadmin/header.php'; ?>

<section id="main-content">
    <section class="wrapper">
        <h3><i class="fa fa-angle-right"></i> Thêm danh mục mới</h3>
        
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
                        <form action="<?= BASE_URL ?>admin/category/create" method="POST">
                            <div class="form-group">
                                <label for="name">Tên danh mục <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="name" name="name" required 
                                       value="<?= isset($_POST['name']) ? htmlspecialchars($_POST['name']) : '' ?>">
                            </div>
                            
                            <div class="form-group">
                                <label for="parent_id">Loại danh mục</label>
                                <select class="form-control" id="parent_id" name="parent_id">
                                    <option value="">-- Không có --</option>
                                    <option value="1" <?= (isset($_POST['parent_id']) && $_POST['parent_id'] == 1) ? 'selected' : '' ?>>Nam</option>
                                    <option value="2" <?= (isset($_POST['parent_id']) && $_POST['parent_id'] == 2) ? 'selected' : '' ?>>Nữ</option>
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="is_active" value="1" 
                                            <?= (!isset($_POST['is_active']) || $_POST['is_active'] == 1) ? 'checked' : '' ?>>
                                        Kích hoạt
                                    </label>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-save"></i> Lưu lại
                                </button>
                                <a href="<?= BASE_URL ?>admin/category" class="btn btn-default">
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
