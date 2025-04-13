<?php include_once 'app/views/sharesuser/header.php'; ?>

<!-- Start Banner Area -->
<section class="banner-area organic-breadcrumb">
    <div class="container">
        <div class="breadcrumb-banner d-flex flex-wrap align-items-center justify-content-end">
            <div class="col-first">
                <h1>Chi tiết sản phẩm</h1>
                <nav class="d-flex align-items-center">
                    <a href="<?php echo BASE_URL; ?>">Trang chủ<span class="lnr lnr-arrow-right"></span></a>
                    <a href="<?php echo BASE_URL; ?>user/Product/<?php echo $product->category_id == 1 ? 'men' : 'women'; ?>">
                        <?php echo $product->category_id == 1 ? 'Giày Nam' : 'Giày Nữ'; ?>
                        <span class="lnr lnr-arrow-right"></span>
                    </a>
                    <a href="#"><?php echo htmlspecialchars($product->name); ?></a>
                </nav>
            </div>
        </div>
    </div>
</section>
<!-- End Banner Area -->

<!--================Single Product Area =================-->
<div class="product_image_area" style="padding: 15px 0px">
    <div class="container">
        <div class="row s_product_inner">
            <div class="col-lg-6">
                <div class="s_Product_carousel">
                    <div class="single-prd-item">
                        <img class="img-fluid" src="<?php echo $product->primary_image ? BASE_URL . 'public/' . htmlspecialchars($product->primary_image) : BASE_URL . 'public/user/assets/img/product/default.jpg'; ?>" alt="">
                    </div>
                    <div class="single-prd-item">
                        <img class="img-fluid" src="<?php echo $product->primary_image ? BASE_URL . 'public/' . htmlspecialchars($product->primary_image) : BASE_URL . 'public/user/assets/img/product/default.jpg'; ?>" alt="">
                    </div>
                    <div class="single-prd-item">
                        <img class="img-fluid" src="<?php echo $product->primary_image ? BASE_URL . 'public/' . htmlspecialchars($product->primary_image) : BASE_URL . 'public/user/assets/img/product/default.jpg'; ?>" alt="">
                    </div>
                </div>
            </div>
            <div class="col-lg-5 offset-lg-1">
                <div class="s_product_text">
                    <h3><?php echo htmlspecialchars($product->name); ?></h3>
                    <h2><?php echo number_format($product->discount_price ?: $product->price, 0, ',', '.'); ?>đ</h2>
                    <?php if ($product->discount_price && $product->discount_price < $product->price): ?>
                        <h6 class="l-through"><?php echo number_format($product->price, 0, ',', '.'); ?>đ</h6>
                    <?php endif; ?>
                    <ul class="list">
                        <li>
                            <a class="active" href="<?php echo BASE_URL; ?>user/Product/<?php echo $product->category_id == 1 ? 'men' : 'women'; ?>">
                                <span>Phân loại</span> : <?php echo htmlspecialchars($product->category_name); ?>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <span>Tình trạng</span> : <?php echo $product->stock_quantity > 0 ? 'Còn hàng' : 'Hết hàng'; ?>
                            </a>
                        </li>
                    </ul>
                    <p><?php echo htmlspecialchars($product->description ?? 'Chưa có mô tả'); ?></p>
                    <form method="POST" action="<?php echo BASE_URL; ?>user/cart/add">
                        <input type="hidden" name="product_id" value="<?php echo $product->product_id; ?>">
                        <div class="noname align-items-center">
                            <div class="pb-2"><label>Size:</label></div>
                            <div class="default-select pb-2" id="default-select1">
                                <select name="variant_id" required>
                                    <option value="">Chọn kích thước</option>
                                    <?php foreach ($product->sizes as $size): ?>
                                        <option value="<?php echo $size->variant_id; ?>"><?php echo htmlspecialchars($size->size_name); ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="pb-1 pt-2"><label for="qty">Số lượng:</label></div>
                            <div class="product_count">
                                <input type="text" name="qty" id="sst" maxlength="12" value="1" title="Quantity:" class="input-text qty">
                                <button onclick="var result = document.getElementById('sst'); var sst = result.value; if( !isNaN( sst )) result.value++;return false;" class="increase items-count" type="button">
                                    <i class="lnr lnr-chevron-up"></i>
                                </button>
                                <button onclick="var result = document.getElementById('sst'); var sst = result.value; if( !isNaN( sst ) && sst > 0 ) result.value--;return false;" class="reduced items-count" type="button">
                                    <i class="lnr lnr-chevron-down"></i>
                                </button>
                            </div>
                            <br>
                            <div class="card_area d-flex align-items-center">
                                <button type="submit" class="btn primary-btn">Thêm vào giỏ hàng</button>
                                <a class="icon_btn" href="#"><i class="lnr lnr-heart"></i></a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!--================End Single Product Area =================-->

<?php include_once 'app/views/sharesuser/footer.php'; ?>