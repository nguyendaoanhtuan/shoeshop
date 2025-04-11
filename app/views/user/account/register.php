<?php include_once 'app/views/sharesuser/header.php'; ?>

<section class="banner-area organic-breadcrumb">
    <div class="container">
        <div class="breadcrumb-banner d-flex flex-wrap align-items-center justify-content-end">
            <div class="col-first">
                <h1>Đăng ký</h1>
                <nav class="d-flex align-items-center">
                    <a href="<?php echo BASE_URL; ?>">Trang chủ<span class="lnr lnr-arrow-right"></span></a>
                    <a href="<?php echo BASE_URL; ?>user/account/register">Đăng ký</a>
                </nav>
            </div>
        </div>
    </div>
</section>

<section class="login_box_area section_gap">
    <div class="container">
        <div class="row justify-content-around">
            <div class="col-lg-6">
                <div class="login_form_inner">
                    <h2>ĐĂNG KÝ</h2>
                    
                    <?php if (isset($_SESSION['register_success'])): ?>
                        <div class="alert alert-success">
                            <?php echo $_SESSION['register_success']; unset($_SESSION['register_success']); ?>
                        </div>
                    <?php endif; ?>
                    
                    <?php if (isset($_SESSION['register_error'])): ?>
                        <div class="alert alert-danger">
                            <?php echo $_SESSION['register_error']; unset($_SESSION['register_error']); ?>
                        </div>
                    <?php endif; ?>

                    <form action="<?php echo BASE_URL; ?>user/account/register" method="POST" class="row login_form pb-3 mb-5 form" id="form-1">
                        <div class="col-md-12 form-group">
                            <label for="fullname" class="form-label">Tên đầy đủ</label>
                            <input id="fullname" name="fullname" type="text" 
                                placeholder="VD: Nguyễn Văn Nam" 
                                class="form-control <?php echo isset($_SESSION['register_errors']['fullname']) ? 'is-invalid' : ''; ?>"
                                value="<?php echo $_SESSION['old_register_data']['fullname'] ?? ''; ?>">
                            <?php if (isset($_SESSION['register_errors']['fullname'])): ?>
                                <div class="invalid-feedback">
                                    <?php echo $_SESSION['register_errors']['fullname']; unset($_SESSION['register_errors']['fullname']); ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="col-md-12 form-group">
                            <label for="email" class="form-label">Email</label>
                            <input id="email" name="email" type="text" 
                                placeholder="VD: email@domain.com" 
                                class="form-control <?php echo isset($_SESSION['register_errors']['email']) ? 'is-invalid' : ''; ?>"
                                value="<?php echo $_SESSION['old_register_data']['email'] ?? ''; ?>">
                            <?php if (isset($_SESSION['register_errors']['email'])): ?>
                                <div class="invalid-feedback">
                                    <?php echo $_SESSION['register_errors']['email']; unset($_SESSION['register_errors']['email']); ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="col-md-12 form-group">
                            <label for="DOB" class="form-label">Ngày tháng năm sinh</label>
                            <input type="text" class="form-control" id="DOB" name="DOB" 
                                placeholder="Ngày sinh (dd/mm/yyyy)"
                                value="<?php echo $_SESSION['old_register_data']['DOB'] ?? ''; ?>">
                        </div>

                        <div class="col-md-12 form-group">
                            <label for="password" class="form-label">Mật khẩu</label>
                            <input id="password" name="password" type="password" 
                                placeholder="Nhập mật khẩu" 
                                class="form-control <?php echo isset($_SESSION['register_errors']['password']) ? 'is-invalid' : ''; ?>">
                            <?php if (isset($_SESSION['register_errors']['password'])): ?>
                                <div class="invalid-feedback">
                                    <?php echo $_SESSION['register_errors']['password']; unset($_SESSION['register_errors']['password']); ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="col-md-12 form-group">
                            <label for="password_confirmation" class="form-label">Nhập lại mật khẩu</label>
                            <input id="password_confirmation" name="password_confirmation" 
                                placeholder="Nhập lại mật khẩu" type="password" 
                                class="form-control <?php echo isset($_SESSION['register_errors']['password_confirmation']) ? 'is-invalid' : ''; ?>">
                            <?php if (isset($_SESSION['register_errors']['password_confirmation'])): ?>
                                <div class="invalid-feedback">
                                    <?php echo $_SESSION['register_errors']['password_confirmation']; unset($_SESSION['register_errors']['password_confirmation']); ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="col-md-12 form-group">
                            <a href="<?php echo BASE_URL; ?>user/account/login" class="hover-text">Đã có tài khoản?/Đăng nhập</a>
                            <button type="submit" class="form-submit">Đăng ký</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<?php 
unset($_SESSION['old_register_data']);
include_once 'app/views/sharesuser/footer.php'; 
?>