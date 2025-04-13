<?php include_once 'app/views/sharesuser/header.php'; ?>

<!-- Start Banner Area -->
<section class="banner-area organic-breadcrumb">
    <div class="container">
        <div class="breadcrumb-banner d-flex flex-wrap align-items-center justify-content-end">
            <div class="col-first">
                <h1>Giỏ hàng</h1>
                <nav class="d-flex align-items-center">
                    <a href="<?php echo BASE_URL; ?>">Trang chủ<span class="lnr lnr-arrow-right"></span></a>
                    <a href="<?php echo BASE_URL; ?>cart">Giỏ hàng</a>
                </nav>
            </div>
        </div>
    </div>
</section>
<!-- End Banner Area -->

<section class="cart_area">
    <div class="container">
        <div class="cart_inner">
            <?php if (isset($_SESSION['error'])): ?>
                <div class="alert alert-danger">
                    <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
                </div>
            <?php endif; ?>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Sản phẩm</th>
                            <th scope="col">Giá</th>
                            <th scope="col">Số lượng</th>
                            <th scope="col">Tổng</th>
                            <th scope="col">Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($items)): ?>
                            <tr>
                                <td colspan="5" class="text-center">Giỏ hàng của bạn đang trống.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($items as $index => $item): ?>
                                <tr>
                                    <td>
                                        <div class="media">
                                            <div class="d-flex">
                                                <img src="<?php echo $item->primary_image ? BASE_URL . 'public/' . htmlspecialchars($item->primary_image) : BASE_URL . 'public/user/assets/img/product/default.jpg'; ?>" alt="" style="width: 100px; height: auto;">
                                            </div>
                                            <div class="media-body">
                                                <p><?php echo htmlspecialchars($item->product_name); ?> (Size: <?php echo htmlspecialchars($item->size_name); ?>)</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <h5><?php echo number_format($item->discount_price ?: $item->price, 0, ',', '.'); ?>đ</h5>
                                    </td>
                                    <td>
                                        <div class="product_count">
                                            <form method="POST" action="<?php echo BASE_URL; ?>user/cart/update" id="form-<?php echo $index; ?>">
                                                <input type="hidden" name="item_id" value="<?php echo $item->item_id; ?>">
                                                <input type="text" name="quantity" id="sst<?php echo $index; ?>" maxlength="12" value="<?php echo $item->quantity; ?>" title="Quantity:" class="input-text qty">
                                                <button onclick="var result = document.getElementById('sst<?php echo $index; ?>'); var sst = result.value; if( !isNaN( sst )) result.value++; document.getElementById('form-<?php echo $index; ?>').submit(); return false;" class="increase items-count" type="button"><i class="lnr lnr-chevron-up"></i></button>
                                                <button onclick="var result = document.getElementById('sst<?php echo $index; ?>'); var sst = result.value; if( !isNaN( sst ) && sst > 0 ) result.value--; document.getElementById('form-<?php echo $index; ?>').submit(); return false;" class="reduced items-count" type="button"><i class="lnr lnr-chevron-down"></i></button>
                                            </form>
                                        </div>
                                    </td>
                                    <td>
                                        <h5><?php echo number_format(($item->discount_price ?: $item->price) * $item->quantity, 0, ',', '.'); ?>đ</h5>
                                    </td>
                                    <td>
                                        <a href="<?php echo BASE_URL; ?>user/cart/remove?item_id=<?php echo $item->item_id; ?>" class="gray_btn">Xóa</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                        <tr class="bottom_button">
                            <td>
                                <a class="gray_btn" href="<?php echo BASE_URL; ?>cart">Cập nhật giỏ hàng</a>
                            </td>
                            <td></td>
                            <td></td>
                            <td>
                                <div class="cupon_text d-flex align-items-center">
                                    <input type="text" placeholder="Mã giảm giá">
                                    <a class="primary-btn" href="#">Áp dụng</a>
                                </div>
                            </td>
                            <td></td>
                        </tr>
                        <tr class="shipping_area">
                            <td></td>
                            <td></td>
                            <td>
                                <h5>Phí vận chuyển</h5>
                            </td>
                            <td>
                                <h5><?php echo number_format($shipping_fee, 0, ',', '.'); ?>đ</h5>
                            </td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td>
                                <h5>Tổng cộng</h5>
                            </td>
                            <td>
                                <h5><?php echo number_format($total, 0, ',', '.'); ?>đ</h5>
                            </td>
                            <td></td>
                        </tr>
                        <tr class="out_button_area">
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>
                                <div class="checkout_btn_inner d-flex align-items-center">
                                    <a class="gray_btn" href="<?php echo BASE_URL; ?>"><h5 style="padding-top: 10px">Tiếp tục mua sắm</h5></a>
                                    <a class="primary-btn" href="<?php echo BASE_URL; ?>user/checkout/index">Đến trang thanh toán</a>
                                </div>
                            </td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>

<?php include_once 'app/views/sharesuser/footer.php'; ?>