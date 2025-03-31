<?php include_once 'app/views/sharesuser/header.php'; ?>


<section class="banner-area organic-breadcrumb">
		<div class="container">
			<div class="breadcrumb-banner d-flex flex-wrap align-items-center justify-content-end">
				<div class="col-first">
					<h1>Đăng nhập</h1>
					<nav class="d-flex align-items-center">
						<a href="index.html">Trang chủ<span class="lnr lnr-arrow-right"></span></a>
						<a href="category.html">Đăng nhập</a>
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
				<div class="col-lg-6">
					<div class="login_box_img">
						<img class="img-fluid" src="public/user/assets/img/login.jpg" alt="">
						<div class="hover">
							<h4>Bạn là người mới?</h4>
							<p>Hãy tạo tài khoản để mua hàng ở trang web chúng tôi!</p>
							<a class="primary-btn" href="app/views/user/dangky.php">Tạo tài khoản</a>
						</div>
					</div>
				</div>
				<div class="col-lg-6">
					<div class="login_form_inner">
						<h3>ĐĂNG NHẬP</h3>
						<form class="row login_form" action="/shoeshop/login" method="post" id="contactForm" novalidate>
							<div class="col-md-12 form-group">
								<input type="email" class="form-control" id="name" name="name" placeholder="Email" required>
								<span class="form-message"></span>
							</div>
							<div class="col-md-12 form-group">
								<input type="password" class="form-control" id="password" name="password" placeholder="Mật khẩu" required>
								<span class="form-message"></span>
							</div>
							<div class="col-md-12 form-group">
								<div class="creat_account">
									<input type="checkbox" id="f-option2" name="selector">
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