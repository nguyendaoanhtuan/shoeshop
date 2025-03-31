<?php include_once 'app/views/sharesuser/header.php'; ?>

<section class="banner-area organic-breadcrumb">
    <div class="container">
        <div class="breadcrumb-banner d-flex flex-wrap align-items-center justify-content-end">
            <div class="col-first">
                <h1>Sản phẩm</h1>
                <nav class="d-flex align-items-center">
                    <a href="/shoeshop">Trang chủ<span class="lnr lnr-arrow-right"></span></a>
                    <a href="/shoeshop/products">Sản phẩm</a>
                </nav>
            </div>
        </div>
    </div>
</section>

<section class="product_list section_gap">
    <div class="container">
        <div class="row">
            <!-- Filter sidebar -->
            <div class="col-lg-3">
                <div class="left_sidebar_area">
                    <aside class="left_widgets p_filter_widgets">
                        <div class="l_w_title">
                            <h3>Danh mục</h3>
                        </div>
                        <div class="widgets_inner">
                            <ul class="list">
                                <li><a href="#">Giày thể thao</a></li>
                                <li><a href="#">Giày da</a></li>
                                <li><a href="#">Giày sandal</a></li>
                                <li><a href="#">Giày cao gót</a></li>
                            </ul>
                        </div>
                    </aside>
                </div>
            </div>
            
            <!-- Product grid -->
            <div class="col-lg-9">
                <div class="row">
                    <?php foreach($products as $product): ?>
                    <div class="col-lg-4 col-md-6">
                        <div class="single-product">
                            <img class="img-fluid" src="<?php echo $product['image']; ?>" alt="">
                            <div class="product-details">
                                <h6><?php echo $product['name']; ?></h6>
                                <div class="price">
                                    <h6><?php echo number_format($product['price'], 0, ',', '.'); ?>đ</h6>
                                    <?php if($product['sale_price']): ?>
                                    <h6 class="l-through"><?php echo number_format($product['sale_price'], 0, ',', '.'); ?>đ</h6>
                                    <?php endif; ?>
                                </div>
                                <div class="prd-bottom">
                                    <a href="/shoeshop/product/<?php echo $product['id']; ?>" class="social-info">
                                        <span class="lnr lnr-move"></span>
                                        <p class="hover-text">Xem chi tiết</p>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include_once 'app/views/sharesuser/footer.php'; ?> 