<?php include_once 'app/views/sharesadmin/header.php'; ?>

<section id="main-content">
    <section class="wrapper">
        <h3><i class="fa fa-angle-right"></i> Chỉnh sửa tài khoản người dùng</h3>
        
        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert">×</button>
                <?= $_SESSION['error']; unset($_SESSION['error']); ?>
            </div>
        <?php endif; ?>
        
        <div class="row mt">
            <div class="col-md-12">
                <div class="content-panel">
                    <form class="form-horizontal style-form" method="POST" 
                          action="<?= BASE_URL ?>admin/user/edit/<?= $user['user_id'] ?>">
                        <div class="form-group">
                            <label class="col-sm-2 col-sm-2 control-label">Email</label>
                            <div class="col-sm-10">
                                <input type="email" class="form-control" 
                                       value="<?= htmlspecialchars($user['email']) ?>" 
                                       readonly>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="col-sm-2 col-sm-2 control-label">Họ tên</label>
                            <div class="col-sm-10">
                                <input type="text" name="full_name" class="form-control" 
                                       value="<?= htmlspecialchars($user['full_name']) ?>" 
                                       required>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="col-sm-2 col-sm-2 control-label">Số điện thoại</label>
                            <div class="col-sm-10">
                                <input type="text" name="phone_number" class="form-control" 
                                       value="<?= htmlspecialchars($user['phone_number'] ?? '') ?>">
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="col-sm-2 col-sm-2 control-label">Trạng thái</label>
                            <div class="col-sm-10">
                                <label class="checkbox-inline">
                                    <input type="checkbox" name="is_active" 
                                           value="1" <?= $user['is_active'] ? 'checked' : '' ?>>
                                    Kích hoạt
                                </label>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <div class="col-sm-10 col-sm-offset-2">
                                <button type="submit" class="btn btn-primary">Cập nhật</button>
                                <a href="<?= BASE_URL ?>admin/account_users" 
                                   class="btn btn-default">Hủy</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</section>

<?php include_once 'app/views/sharesadmin/footer.php'; ?>