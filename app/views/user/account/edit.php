<?php include_once 'app/views/sharesuser/header.php'; ?>

<section class="banner-area organic-breadcrumb">
    <div class="container">
        <div class="breadcrumb-banner d-flex flex-wrap align-items-center justify-content-end">
            <div class="col-first">
                <h1>Chỉnh sửa thông tin</h1>
                <nav class="d-flex align-items-center">
                    <a href="<?php echo BASE_URL; ?>">Trang chủ<span class="lnr lnr-arrow-right"></span></a>
                    <a href="<?php echo BASE_URL; ?>user/account">Tài khoản<span class="lnr lnr-arrow-right"></span></a>
                    <a href="<?php echo BASE_URL; ?>user/account/edit">Chỉnh sửa</a>
                </nav>
            </div>
        </div>
    </div>
</section>

<section class="login_box_area section_gap">
    <div class="container">
        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success"><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></div>
        <?php endif; ?>
        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></div>
        <?php endif; ?>

        <div class="row">
            <div class="col-lg-6">
                <div class="login_form_inner">
                    <h3>Cập nhật thông tin cá nhân</h3>
                    <form class="row login_form" action="<?php echo BASE_URL; ?>user/account/updateProfile" method="post" id="profileForm">
                        <div class="col-md-12 form-group">
                            <input type="text" class="form-control" name="full_name" placeholder="Họ tên" 
                                value="<?php echo htmlspecialchars($user['full_name']); ?>" required>
                        </div>
                        <div class="col-md-12 form-group">
                            <input type="email" class="form-control" name="email" placeholder="Email" 
                                value="<?php echo htmlspecialchars($user['email']); ?>" required>
                        </div>
                        <div class="col-md-12 form-group">
                            <input type="text" class="form-control" name="phone" placeholder="Số điện thoại" 
                                value="<?php echo htmlspecialchars($user['phone_number'] ?? ''); ?>">
                        </div>
                        <div class="col-md-12 form-group">
                            <textarea class="form-control" name="address" placeholder="Địa chỉ"><?php echo htmlspecialchars($user['address'] ?? ''); ?></textarea>
                        </div>
                        <div class="col-md-12 form-group">
                            <button type="submit" class="primary-btn">Cập nhật thông tin</button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="login_form_inner">
                    <h3>Đổi mật khẩu</h3>
                    <form class="row login_form" action="<?php echo BASE_URL; ?>user/account/changePassword" method="post" id="passwordForm">
                        <div class="col-md-12 form-group">
                            <input type="password" class="form-control" name="current_password" 
                                placeholder="Mật khẩu hiện tại" required>
                        </div>
                        <div class="col-md-12 form-group">
                            <input type="password" class="form-control" name="new_password" 
                                placeholder="Mật khẩu mới" required>
                        </div>
                        <div class="col-md-12 form-group">
                            <input type="password" class="form-control" name="confirm_password" 
                                placeholder="Xác nhận mật khẩu mới" required>
                        </div>
                        <div class="col-md-12 form-group">
                            <button type="submit" class="primary-btn">Đổi mật khẩu</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include_once 'app/views/sharesuser/footer.php'; ?>