<?php include_once 'app/views/sharesuser/header.php'; ?>

<!-- Start Banner Area -->
<section class="banner-area organic-breadcrumb">
    <div class="container">
        <div class="breadcrumb-banner d-flex flex-wrap align-items-center justify-content-end">
            <div class="col-first">
                <h1>Thanh toán</h1>
                <nav class="d-flex align-items-center">
                    <a href="<?php echo BASE_URL; ?>">Trang chủ<span class="lnr lnr-arrow-right"></span></a>
                    <a href="<?php echo BASE_URL; ?>cart">Giỏ hàng<span class="lnr lnr-arrow-right"></span></a>
                    <a href="<?php echo BASE_URL; ?>checkout">Thanh toán</a>
                </nav>
            </div>
        </div>
    </div>
</section>
<!-- End Banner Area -->

<!--================Checkout Area =================-->
<section class="checkout_area section_gap">
    <div class="container">
        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></div>
        <?php endif; ?>
        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success"><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></div>
        <?php endif; ?>

        <div class="billing_details">
            <div class="row">
                <div class="col-lg-8">
                    <h3>Chi tiết hóa đơn</h3>
               <form class="row contact_form" action="<?php echo BASE_URL; ?>user/checkout/process" method="post" novalidate="novalidate" id="checkoutForm">
                        <div class="col-md-6 form-group p_star">
                            <input type="text" class="form-control" id="first" name="first_name" placeholder="Họ*" required>
                            <p class="form-message"></p>
                        </div>
                        <div class="col-md-6 form-group p_star">
                            <input type="text" class="form-control" id="last" name="last_name" placeholder="Tên*" required>
                            <p class="form-message"></p>
                        </div>
                        <div class="col-md-6 form-group p_star">
                            <input type="text" class="form-control" id="phone" name="phone" placeholder="Số điện thoại*" required pattern="[0-9]{10,11}" title="Số điện thoại phải có 10-11 chữ số">
                            <p class="form-message"></p>
                        </div>
                        <div class="col-md-6 form-group p_star">
                            <input type="email" class="form-control" id="email" name="email" placeholder="Email*" required>
                            <p class="form-message"></p>
                        </div>
                        <div class="col-md-12 form-group p_star">
                            <input type="text" class="form-control" id="address" name="address" placeholder="Địa chỉ*" required>
                            <p class="form-message"></p>
                        </div>
                        <div class="col-md-12 form-group">
                            <div class="creat_account">
                                <h3>Ghi chú đơn hàng</h3>
                            </div>
                            <textarea class="form-control" name="customer_note" id="message" rows="1" placeholder="Ghi chú"></textarea>
                        </div>
                </div>
                <div class="col-lg-4">
                    <div class="order_box">
                        <h2>Đơn hàng của bạn</h2>
                        <ul class="list">
                            <li><a href="#">Sản phẩm <span>Giá</span></a></li>
                            <?php if (isset($items) && !empty($items)): ?>
                                <?php foreach ($items as $item): ?>
                                    <li>
                                        <a href="#">
                                            <?php echo htmlspecialchars($item->product_name); ?> (Size: <?php echo htmlspecialchars($item->size_name); ?>) 
                                            <span class="middle">x <?php echo $item->quantity; ?></span> 
                                            <span class="last"><?php echo number_format(($item->discount_price ?: $item->price) * $item->quantity, 0, ',', '.'); ?>đ</span>
                                        </a>
                                    </li>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <li><a href="#">Không có sản phẩm nào</a></li>
                            <?php endif; ?>
                        </ul>
                        <ul class="list list_2">
                            <li><a href="#">Tổng cộng <span><?php echo isset($subtotal) ? number_format($subtotal, 0, ',', '.') : '0'; ?>đ</span></a></li>
                            <li><a href="#">Phí Ship <span><?php echo isset($shipping_fee) ? number_format($shipping_fee, 0, ',', '.') : '0'; ?>đ</span></a></li>
                            <li><a href="#">Tổng cộng <span><?php echo isset($total) ? number_format($total, 0, ',', '.') : '0'; ?>đ</span></a></li>
                        </ul>
                        <div class="payment_item">
                            <div class="radion_btn">
                                <input type="radio" id="f-option5" name="payment_method" value="cod">
                                <label for="f-option5">Trả tiền mặt</label>
                                <div class="check"></div>
                            </div>
                        </div>
                        <div class="payment_item active">
                            <div class="radion_btn">
                                <input type="radio" id="f-option6" name="payment_method" value="vnpay" checked>
                                <label for="f-option6">Trả thẻ VNPay</label>
                                <img src="<?php echo BASE_URL; ?>public/user/assets/img/product/card.jpg" alt="">
                                <div class="check"></div>
                            </div>
                        </div>
                        <div class="creat_account">
                            <input type="checkbox" id="f-option4" name="terms" required>
                            <label for="f-option4">Tôi đã đọc và chấp nhận </label>
                            <a href="#">mọi điều khoản*</a>
                        </div>
                        <button type="submit" form="checkoutForm" class="primary-btn">Xác nhận</button>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>
</section>
<!--================End Checkout Area =================-->

<?php include_once 'app/views/sharesuser/footer.php'; ?>