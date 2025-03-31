<?php 
include_once $_SERVER['DOCUMENT_ROOT'] . '/shoeshop/app/views/sharesuser/header.php';
?>
<!-- Start Banner Area -->
<section class="banner-area organic-breadcrumb">
  <div class="container">
    <div class="breadcrumb-banner d-flex flex-wrap align-items-center justify-content-end">
      <div class="col-first">
        <h1>Đăng kí</h1>
        <nav class="d-flex align-items-center">
          <a href="index.html">Trang chủ<span class="lnr lnr-arrow-right"></span></a>
          <a href="registration.html">Đăng kí</a>
        </nav>
      </div>
    </div>
  </div>
</section>
<!-- End Banner Area -->

<!--================Login Box Area =================-->
<section class="login_box_area section_gap">
  <div class="container">
    <div class="row">
      <div class="col-lg-12">
        <div class="login_form_inner register_form_inner">
          <h3>ĐĂNG KÝ TÀI KHOẢN</h3>
          <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
          <?php endif; ?>
          <form class="row login_form" action="/shoeshop/register" method="post" id="register_form">
            <div class="col-md-12 form-group">
              <input type="text" class="form-control" id="username" name="username" placeholder="Tên đăng nhập" required>
            </div>
            <div class="col-md-12 form-group">
              <input type="text" class="form-control" id="full_name" name="full_name" placeholder="Họ và tên" required>
            </div>
            <div class="col-md-12 form-group">
              <input type="email" class="form-control" id="email" name="email" placeholder="Email" required>
            </div>
            <div class="col-md-12 form-group">
              <input type="password" class="form-control" id="password" name="password" placeholder="Mật khẩu" required>
            </div>
            <div class="col-md-12 form-group">
              <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Nhập lại mật khẩu" required>
            </div>
            <div class="col-md-12 form-group">
              <button type="submit" class="primary-btn">Đăng ký</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>

<!--================End Login Box Area =================-->

<?php 
include_once $_SERVER['DOCUMENT_ROOT'] . '/shoeshop/app/views/sharesuser/footer.php';
?>