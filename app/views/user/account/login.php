<?php include_once 'app/views/sharesuser/header.php'; ?>

<section class="banner-area organic-breadcrumb">
    <div class="container">
        <div class="breadcrumb-banner d-flex flex-wrap align-items-center justify-content-end">
            <div class="col-first">
                <h1>Đăng nhập</h1>
                <nav class="d-flex align-items-center">
                    <a href="<?php echo BASE_URL; ?>">Trang chủ<span class="lnr lnr-arrow-right"></span></a>
                    <a href="<?php echo BASE_URL; ?>user/account/login">Đăng nhập</a>
                </nav>
            </div>
        </div>
    </div>
</section>

<section class="login_box_area section_gap">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <div class="login_box_img">
                    <img class="img-fluid" src="<?php echo BASE_URL; ?>public/user/assets/img/login.jpg" alt="">
                    <div class="hover">
                        <h4>Bạn là người mới?</h4>
                        <p>Hãy tạo tài khoản để mua hàng ở trang web chúng tôi!</p>
                        <a class="primary-btn" href="<?php echo BASE_URL; ?>user/account/register">Tạo tài khoản</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="login_form_inner">
                    <h3>ĐĂNG NHẬP</h3>
                    <?php if (isset($_SESSION['login_error'])): ?>
                        <div class="alert alert-danger">
                            <?php echo $_SESSION['login_error']; unset($_SESSION['login_error']); ?>
                        </div>
                    <?php endif; ?>
                    <?php if (isset($_SESSION['error'])): ?>
                        <div class="alert alert-danger">
                            <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
                        </div>
                    <?php endif; ?>
                    <?php if (isset($_SESSION['register_success'])): ?>
                        <div class="alert alert-success">
                            <?php echo $_SESSION['register_success']; unset($_SESSION['register_success']); ?>
                        </div>
                    <?php endif; ?>
                    <form class="row login_form" action="<?php echo BASE_URL; ?>user/account/login" method="post" id="contactForm" novalidate>
                        <div class="col-md-12 form-group">
                            <input type="email" class="form-control" id="email" name="email" placeholder="Email" required>
                        </div>
                        <div class="col-md-12 form-group">
                            <input type="password" class="form-control" id="password" name="password" placeholder="Mật khẩu" required>
                        </div>
                        <div class="col-md-12 form-group">
                            <div class="creat_account">
                                <input type="checkbox" id="f-option2" name="remember">
                                <label for="f-option2">Duy trì đăng nhập</label>
                            </div>
                        </div>
                        <div class="col-md-12 form-group">
                            <button type="submit" class="primary-btn">Đăng nhập</button>
                            <a href="#">Quên mật khẩu?</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include_once 'app/views/sharesuser/footer.php'; ?>