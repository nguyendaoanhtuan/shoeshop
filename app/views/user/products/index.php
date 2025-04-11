<?php include_once 'app/views/sharesuser/header.php'; ?>

<!-- Start Banner Area -->
<section class="banner-area organic-breadcrumb">
    <div class="container">
        <div class="breadcrumb-banner d-flex flex-wrap align-items-center justify-content-end">
            <div class="col-first">
                <h1><?php echo htmlspecialchars($categoryName); ?></h1>
                <nav class="d-flex align-items-center">
                    <a href="<?php echo BASE_URL; ?>">Trang chủ<span class="lnr lnr-arrow-right"></span></a>
                    <a href="<?php echo BASE_URL; ?>user/Product/<?php echo $parentCategoryId == 1 ? 'men' : ($parentCategoryId == 2 ? 'women' : 'index'); ?>">
                        <?php echo htmlspecialchars($categoryName); ?>
                    </a>
                </nav>
            </div>
        </div>
    </div>
</section>
<!-- End Banner Area -->

<div class="container">
    <div class="row">
        <div class="col-xl-3 col-lg-4 col-md-5">
            <div class="sidebar-categories">
                <div class="head">Loại giày</div>
                <ul class="main-categories">
                    <?php 
                    $categoriesToShow = ($parentCategoryId == 1) ? $menCategories : $womenCategories;
                    foreach ($categoriesToShow as $category): 
                    ?>
                        <li class="main-nav-list">
                            <a href="<?php 
                                $url = BASE_URL . "user/Product/" . ($parentCategoryId == 1 ? 'men' : ($parentCategoryId == 2 ? 'women' : 'index'));
                                $params = array_filter([
                                    'category_id' => $category['category_id'],
                                    'brand_id' => isset($_GET['brand_id']) ? $_GET['brand_id'] : null,
                                    'sort' => isset($_GET['sort']) ? $_GET['sort'] : null,
                                    'search' => isset($_GET['search']) ? $_GET['search'] : null,
                                    'page' => 1
                                ]);
                                echo $url . ($params ? '?' . http_build_query($params) : '');
                            ?>">
                                <span class="lnr lnr-arrow-right"></span>
                                <?php echo htmlspecialchars($category['name']); ?>

                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <div class="sidebar-filter mt-50">
                <div class="top-filter-head">Bộ lọc</div>
                <div class="common-filter">
                    <div class="head">Thương hiệu</div>
                    <form id="brand-filter-form" action="<?php echo BASE_URL; ?>user/Product/<?php echo $parentCategoryId == 1 ? 'men' : ($parentCategoryId == 2 ? 'women' : 'index'); ?>" method="GET">
                        <ul>
                            <?php foreach ($brands as $brand): ?>
                                <li class="filter-list">
                                    <input class="pixel-radio" type="radio" id="brand-<?php echo $brand['brand_id']; ?>" name="brand_id_radio" value="<?php echo $brand['brand_id']; ?>" 
                                        <?php echo (isset($_GET['brand_id']) && $_GET['brand_id'] == $brand['brand_id']) ? 'checked' : ''; ?>
                                        onclick="handleBrandFilter(this)">
                                    <label for="brand-<?php echo $brand['brand_id']; ?>">
                                        <?php echo htmlspecialchars($brand['name']); ?>
                                    </label>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                        <!-- Input hidden để quản lý brand_id -->
                        <input type="hidden" name="brand_id" id="brand_id_hidden" value="<?php echo isset($_GET['brand_id']) ? htmlspecialchars($_GET['brand_id']) : ''; ?>">
                        <!-- Giữ các tham số khác -->
                        <?php if (isset($_GET['category_id'])): ?>
                            <input type="hidden" name="category_id" value="<?php echo htmlspecialchars($_GET['category_id']); ?>">
                        <?php endif; ?>
                        <?php if (isset($_GET['sort'])): ?>
                            <input type="hidden" name="sort" value="<?php echo htmlspecialchars($_GET['sort']); ?>">
                        <?php endif; ?>
                        <?php if (isset($_GET['search'])): ?>
                            <input type="hidden" name="search" value="<?php echo htmlspecialchars($_GET['search']); ?>">
                        <?php endif; ?>
                    </form>
                </div>
                <div class="common-filter">
                    <div class="head">Giá</div>
                    <div class="price-range-area">
                        <div id="price-range"></div>
                        <div class="value-wrapper d-flex">
                            <div class="price">Price:</div>
                            <div id="lower-value"></div>
                            <span>đ</span>
                            <div class="to">đến</div>
                            <div id="upper-value"></div>
                            <span>đ</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-9 col-lg-8 col-md-7">
            <!-- Start Filter Bar -->
            <div class="filter-bar d-flex flex-wrap align-items-center">
                <div class="sorting">
                    <form action="<?php echo BASE_URL; ?>user/Product/<?php echo $parentCategoryId == 1 ? 'men' : ($parentCategoryId == 2 ? 'women' : 'index'); ?>" method="GET">
                        <select name="sort" onchange="this.form.submit()">
                            <option value="price_asc" <?php echo (isset($_GET['sort']) && $_GET['sort'] == 'price_asc') ? 'selected' : ''; ?>>Giá: Tăng dần</option>
                            <option value="price_desc" <?php echo (isset($_GET['sort']) && $_GET['sort'] == 'price_desc') ? 'selected' : ''; ?>>Giá: Giảm dần</option>
                            <option value="name_asc" <?php echo (isset($_GET['sort']) && $_GET['sort'] == 'name_asc') ? 'selected' : ''; ?>>Tên: A-Z</option>
                            <option value="name_desc" <?php echo (isset($_GET['sort']) && $_GET['sort'] == 'name_desc') ? 'selected' : ''; ?>>Tên: Z-A</option>
                            <option value="date_asc" <?php echo (isset($_GET['sort']) && $_GET['sort'] == 'date_asc') ? 'selected' : ''; ?>>Cũ nhất</option>
                            <option value="date_desc" <?php echo (isset($_GET['sort']) && $_GET['sort'] == 'date_desc') ? 'selected' : ''; ?>>Mới nhất</option>
                        </select>
                        <!-- Giữ các tham số khác -->
                        <?php if (isset($_GET['category_id'])): ?>
                            <input type="hidden" name="category_id" value="<?php echo htmlspecialchars($_GET['category_id']); ?>">
                        <?php endif; ?>
                        <?php if (isset($_GET['brand_id'])): ?>
                            <input type="hidden" name="brand_id" value="<?php echo htmlspecialchars($_GET['brand_id']); ?>">
                        <?php endif; ?>
                        <?php if (isset($_GET['search'])): ?>
                            <input type="hidden" name="search" value="<?php echo htmlspecialchars($_GET['search']); ?>">
                        <?php endif; ?>
                    </form>
                </div>
                <div class="pagination">
                    <?php if ($totalPages > 1): ?>
                        <?php if ($page > 1): ?>
                            <a href="<?php 
                                $params = array_filter([
                                    'page' => $page - 1,
                                    'search' => isset($_GET['search']) ? $_GET['search'] : null,
                                    'sort' => isset($_GET['sort']) ? $_GET['sort'] : null,
                                    'category_id' => isset($_GET['category_id']) ? $_GET['category_id'] : null,
                                    'brand_id' => isset($_GET['brand_id']) ? $_GET['brand_id'] : null
                                ]);
                                echo BASE_URL . "user/Product/" . ($parentCategoryId == 1 ? 'men' : ($parentCategoryId == 2 ? 'women' : 'index')) . '?' . http_build_query($params);
                            ?>" class="prev-arrow">
                                <i class="fa fa-long-arrow-left" aria-hidden="true"></i>
                            </a>
                        <?php endif; ?>
                        <?php 
                        $startPage = max(1, $page - 2);
                        $endPage = min($totalPages, $page + 2);
                        if ($startPage > 1): ?>
                            <a href="<?php 
                                $params = array_filter(['page' => 1, 'search' => isset($_GET['search']) ? $_GET['search'] : null, 'sort' => isset($_GET['sort']) ? $_GET['sort'] : null, 'category_id' => isset($_GET['category_id']) ? $_GET['category_id'] : null, 'brand_id' => isset($_GET['brand_id']) ? $_GET['brand_id'] : null]);
                                echo BASE_URL . "user/Product/" . ($parentCategoryId == 1 ? 'men' : ($parentCategoryId == 2 ? 'women' : 'index')) . '?' . http_build_query($params);
                            ?>">1</a>
                            <?php if ($startPage > 2): ?>
                                <span>...</span>
                            <?php endif; ?>
                        <?php endif; ?>
                        <?php for ($i = $startPage; $i <= $endPage; $i++): ?>
                            <a href="<?php 
                                $params = array_filter(['page' => $i, 'search' => isset($_GET['search']) ? $_GET['search'] : null, 'sort' => isset($_GET['sort']) ? $_GET['sort'] : null, 'category_id' => isset($_GET['category_id']) ? $_GET['category_id'] : null, 'brand_id' => isset($_GET['brand_id']) ? $_GET['brand_id'] : null]);
                                echo BASE_URL . "user/Product/" . ($parentCategoryId == 1 ? 'men' : ($parentCategoryId == 2 ? 'women' : 'index')) . '?' . http_build_query($params);
                            ?>" <?php echo $i == $page ? 'class="active"' : ''; ?>>
                                <?php echo $i; ?>
                            </a>
                        <?php endfor; ?>
                        <?php if ($endPage < $totalPages): ?>
                            <?php if ($endPage < $totalPages - 1): ?>
                                <span>...</span>
                            <?php endif; ?>
                            <a href="<?php 
                                $params = array_filter(['page' => $totalPages, 'search' => isset($_GET['search']) ? $_GET['search'] : null, 'sort' => isset($_GET['sort']) ? $_GET['sort'] : null, 'category_id' => isset($_GET['category_id']) ? $_GET['category_id'] : null, 'brand_id' => isset($_GET['brand_id']) ? $_GET['brand_id'] : null]);
                                echo BASE_URL . "user/Product/" . ($parentCategoryId == 1 ? 'men' : ($parentCategoryId == 2 ? 'women' : 'index')) . '?' . http_build_query($params);
                            ?>"><?php echo $totalPages; ?></a>
                        <?php endif; ?>
                        <?php if ($page < $totalPages): ?>
                            <a href="<?php 
                                $params = array_filter(['page' => $page + 1, 'search' => isset($_GET['search']) ? $_GET['search'] : null, 'sort' => isset($_GET['sort']) ? $_GET['sort'] : null, 'category_id' => isset($_GET['category_id']) ? $_GET['category_id'] : null, 'brand_id' => isset($_GET['brand_id']) ? $_GET['brand_id'] : null]);
                                echo BASE_URL . "user/Product/" . ($parentCategoryId == 1 ? 'men' : ($parentCategoryId == 2 ? 'women' : 'index')) . '?' . http_build_query($params);
                            ?>" class="next-arrow">
                                <i class="fa fa-long-arrow-right" aria-hidden="true"></i>
                            </a>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
            </div>
            <!-- End Filter Bar -->
            <!-- Start Best Seller -->
            <section class="lattest-product-area pb-40 category-list">
                <div class="row">
                    <?php if (empty($products)): ?>
                        <div class="col-12 text-center">
                            <p>Chưa có sản phẩm nào.</p>
                        </div>
                    <?php else: ?>
                        <?php foreach ($products as $product): ?>
                            <div class="col-lg-4 col-md-6">
                                <div class="single-product">
                                    <img class="img-fluid resize" src="<?php echo $product->primary_image ? BASE_URL . 'public/' . htmlspecialchars($product->primary_image) : BASE_URL . 'public/user/assets/img/product/default.jpg'; ?>" alt="">
                                    <div class="product-details">
                                        <a href="<?php echo BASE_URL; ?>product/<?php echo $product->product_id; ?>">
                                            <h6><?php echo htmlspecialchars($product->name); ?></h6>
                                        </a>
                                        <div class="price">
                                            <h6><?php echo number_format($product->discount_price ?: $product->price, 0, ',', '.'); ?>đ</h6>
                                            <?php if ($product->discount_price && $product->discount_price < $product->price): ?>
                                                <h6 class="l-through"><?php echo number_format($product->price, 0, ',', '.'); ?>đ</h6>
                                            <?php endif; ?>
                                        </div>
                                        <div class="size-selection" style="margin-bottom: 10px;">
                                            <form method="POST" action="<?php echo BASE_URL; ?>cart/add">
                                                <div class="prd-bottom">
                                                    <a href="" class="social-info">
                                                        <span class="ti-bag"></span>
                                                        <p class="hover-text">Thêm vào giỏ</p>
                                                    </a>
                                                    <a href="<?php echo BASE_URL; ?>user/Product/detail/<?php echo $product->product_id; ?>" class="social-info">
                                                        <span class="lnr lnr-move"></span>
                                                        <p class="hover-text">Xem thêm</p>
                                                    </a>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </section>
            <!-- End Best Seller -->
        </div>
    </div>
</div>

<!-- Start related-product Area -->
<!-- Start related-product Area -->
<section class="related-product-area section_gap">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6 text-center">
                <div class="section-title">
                    <h1>Sản phẩm nổi bật</h1>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-9">
                <div class="row">
                    <?php
                    // Lọc các sản phẩm có is_featured = 1
                    $featuredProducts = array_filter($products, function($product) {
                        return !empty($product->is_featured) && $product->is_featured == 1;
                    });
                    // Giới hạn tối đa 9 sản phẩm
                    $featuredProducts = array_slice($featuredProducts, 0, 9);
                    ?>
                    <?php if (empty($featuredProducts)): ?>
                        <div class="col-12 text-center">
                            <p>Chưa có sản phẩm nổi bật nào.</p>
                        </div>
                    <?php else: ?>
                        <?php foreach ($featuredProducts as $product): ?>
                            <div class="col-lg-4 col-md-4 col-sm-6 mb-20">
                                <div class="single-related-product d-flex">
                                    <a href="<?php echo BASE_URL; ?>user/Product/detail/<?php echo $product->product_id; ?>">
                                        <img src="<?php echo $product->primary_image ? BASE_URL . 'public/' . htmlspecialchars($product->primary_image) : BASE_URL . 'public/user/assets/img/product/default.jpg'; ?>" alt="">
                                    </a>
                                    <div class="desc">
                                        <a href="<?php echo BASE_URL; ?>user/Product/detail/<?php echo $product->product_id; ?>" class="title">
                                            <?php echo htmlspecialchars($product->name); ?>
                                        </a>
                                        <div class="price">
                                            <h6><?php echo number_format($product->discount_price ?: $product->price, 0, ',', '.'); ?>đ</h6>
                                            <?php if ($product->discount_price && $product->discount_price < $product->price): ?>
                                                <h6 class="l-through"><?php echo number_format($product->price, 0, ',', '.'); ?>đ</h6>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="ctg-right">
                    <a href="#" target="_blank">
                        <img class="img-fluid d-block mx-auto" src="public/user/assets/img/categories/c5.jpg" alt="">
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End related-product Area -->
<script>
function handleBrandFilter(radio) {
    const form = document.getElementById('brand-filter-form');
    const hiddenInput = document.getElementById('brand_id_hidden');
    
    // Debug: Kiểm tra trạng thái radio
    console.log('Radio clicked:', radio.value, 'Checked:', radio.checked);

    // Nếu radio đã được chọn trước đó và được click lại
    if (radio.checked && radio.dataset.wasChecked === 'true') {
        console.log('Deselecting radio:', radio.value);
        radio.checked = false; // Bỏ chọn radio
        radio.dataset.wasChecked = 'false'; // Cập nhật trạng thái
        hiddenInput.value = ''; // Xóa giá trị brand_id
    } else {
        // Nếu chọn radio mới
        console.log('Selecting radio:', radio.value);
        document.querySelectorAll('input[name="brand_id_radio"]').forEach(r => {
            r.dataset.wasChecked = 'false'; // Xóa trạng thái của tất cả radio khác
        });
        radio.dataset.wasChecked = 'true'; // Đánh dấu radio hiện tại
        hiddenInput.value = radio.value; // Cập nhật giá trị brand_id
    }

    // Debug: Kiểm tra giá trị hidden input trước khi submit
    console.log('Hidden input value:', hiddenInput.value);

    form.submit(); // Gửi form
}

// Khởi tạo trạng thái ban đầu
document.addEventListener('DOMContentLoaded', function() {
    const radios = document.querySelectorAll('input[name="brand_id_radio"]');
    radios.forEach(radio => {
        if (radio.checked) {
            radio.dataset.wasChecked = 'true';
        } else {
            radio.dataset.wasChecked = 'false';
        }
    });
});
</script>

<?php include_once 'app/views/sharesuser/footer.php'; ?>