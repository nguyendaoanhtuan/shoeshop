<!DOCTYPE html>
<html lang="zxx" class="no-js">

<head>
    <base href="<?php echo BASE_URL; ?>">
    <!-- Mobile Specific Meta -->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Favicon-->
    <link rel="shortcut icon" href="public/user/assets/img/fav.png">
    <!-- Author Meta -->
    <meta name="author" content="CodePixar">
    <!-- Meta Description -->
    <meta name="description" content="">
    <!-- Meta Keyword -->
    <meta name="keywords" content="">
    <!-- meta character set -->
    <meta charset="UTF-8">
    <!-- Site Title -->
    <title>Shop bán giày dép</title>

    <!-- CSS -->
    <link rel="stylesheet" href="public/user/assets/css/linearicons.css">
    <link rel="stylesheet" href="public/user/assets/css/owl.carousel.css">
    <link rel="stylesheet" href="public/user/assets/css/themify-icons.css">
    <link rel="stylesheet" href="public/user/assets/css/font-awesome.min.css">
    <link rel="stylesheet" href="public/user/assets/css/nice-select.css">
    <link rel="stylesheet" href="public/user/assets/css/nouislider.min.css">
    <link rel="stylesheet" href="public/user/assets/css/bootstrap.css">
    <link rel="stylesheet" href="public/user/assets/css/main.css">
</head>

<body>

<!-- Start Header Area -->
<header class="header_area sticky-header">
    <div class="main_menu">
        <nav class="navbar navbar-expand-lg navbar-light main_box">
            <div class="container">
                <!-- Brand and toggle get grouped for better mobile display -->
                <a class="navbar-brand logo_h" href="<?php echo BASE_URL; ?>"><img src="public/user/assets/img/logo.png" alt=""></a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse offset" id="navbarSupportedContent">
                    <ul class="nav navbar-nav menu_nav ml-auto">
                        <li class="nav-item"><a class="nav-link" href="<?php echo BASE_URL; ?>">Trang chủ</a></li>
                        <li class="nav-item submenu dropdown">
                            <a href="<?php echo BASE_URL; ?>user/Product/men" class="nav-link dropdown-toggle" role="button" aria-haspopup="true"
                               aria-expanded="false">Nam</a>
                            <ul class="dropdown-menu">
                                <?php
                                $menCategories = isset($menCategories) ? $menCategories : [];
                                foreach ($menCategories as $category): ?>
                                    <li class="nav-item">
                                    <a class="nav-link" href="<?php 
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
                                        <?php echo htmlspecialchars($category['name']); ?>
                                    </a>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </li>
                        <li class="nav-item submenu dropdown">
                            <a href="<?php echo BASE_URL; ?>user/Product/women" class="nav-link dropdown-toggle" role="button" aria-haspopup="true"
                               aria-expanded="false">Nữ</a>
                            <ul class="dropdown-menu">
                                <?php
                                $womenCategories = isset($womenCategories) ? $womenCategories : [];
                                foreach ($womenCategories as $category): ?>
                                    <li class="nav-item">
                                    <a class="nav-link" href="<?php 
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
                                        <?php echo htmlspecialchars($category['name']); ?>
                                    </a>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </li>
                    </ul>
                    <ul class="nav navbar-nav navbar-right">

                        <li>
                            <a class="nav-link" href="<?php echo BASE_URL; ?>user/cart/index" id="cart">
                                <i class="ti-bag"></i>
                                <span class="badge"><p><span class="total-count"><!--<?php echo $total_count; ?>--></span></p></span>
                            </a>
                        </li>
                        <li class="nav-item"><a href="<?php echo BASE_URL; ?>user/account/index" class="cart"><span class="ti-user"></span></a></li>
                        <li class="nav-item">
                            <button class="search"><span class="lnr lnr-magnifier" id="search"></span></button>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </div>

    <div class="search_input" id="search_input_box">
        <div class="container">
            <?php
            // Xác định route hiện tại để gửi form tìm kiếm tới đúng trang
            $currentRoute = isset($parentCategoryId) ? ($parentCategoryId == 1 ? 'men' : ($parentCategoryId == 2 ? 'women' : 'index')) : 'index';
            ?>
            <form class="d-flex justify-content-between" method="GET" action="<?php echo BASE_URL; ?>user/Product/<?php echo $currentRoute; ?>">
                <input type="text" class="form-control" id="search_input" name="search" placeholder="Tìm kiếm" value="<?php echo htmlspecialchars($search ?? ''); ?>">
                <button type="submit" class="btn"></button>
                <span class="lnr lnr-cross" id="close_search" title="Close Search"></span>
            </form>
        </div>
    </div>
</header>
<!-- End Header Area -->

</body>
</html>