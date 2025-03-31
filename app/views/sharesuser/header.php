<!DOCTYPE html>
<html lang="vi">

<head>
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
    <title>ShoeShop - Cửa hàng giày uy tín</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="/shoeshop/public/user/assets/css/linearicons.css">
    <link rel="stylesheet" href="/shoeshop/public/user/assets/css/font-awesome.min.css">
    <link rel="stylesheet" href="/shoeshop/public/user/assets/css/themify-icons.css">
    <link rel="stylesheet" href="/shoeshop/public/user/assets/css/bootstrap.css">
    <link rel="stylesheet" href="/shoeshop/public/user/assets/css/owl.carousel.css">
    <link rel="stylesheet" href="/shoeshop/public/user/assets/css/nice-select.css">
    <link rel="stylesheet" href="/shoeshop/public/user/assets/css/nouislider.min.css">
    <link rel="stylesheet" href="/shoeshop/public/user/assets/css/ion.rangeSlider.css">
    <link rel="stylesheet" href="/shoeshop/public/user/assets/css/ion.rangeSlider.skinFlat.css">
    <link rel="stylesheet" href="/shoeshop/public/user/assets/css/magnific-popup.css">
    <link rel="stylesheet" href="/shoeshop/public/user/assets/css/main.css">
</head>

<body>

<!-- Start Header Area -->
<header class="header_area sticky-header">
    <div class="main_menu">
        <nav class="navbar navbar-expand-lg navbar-light">
            <div class="container">
                <!-- Brand -->
                <a class="navbar-brand logo_h" href="/shoeshop"><img src="/shoeshop/public/user/assets/img/logo.png" alt=""></a>
                
                <!-- Toggler/collapsibe Button -->
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <!-- Navbar links -->
                <div class="collapse navbar-collapse offset" id="navbarSupportedContent">
                    <ul class="nav navbar-nav menu_nav ml-auto">
                        <li class="nav-item"><a class="nav-link" href="/shoeshop">Trang chủ</a></li>
                        <li class="nav-item"><a class="nav-link" href="/shoeshop/products">Sản phẩm</a></li>
                        <li class="nav-item"><a class="nav-link" href="/shoeshop/contact">Liên hệ</a></li>
                        <?php if(isset($_SESSION['user_id'])): ?>
                            <li class="nav-item"><a class="nav-link" href="/shoeshop/account">Tài khoản</a></li>
                            <li class="nav-item"><a class="nav-link" href="/shoeshop/logout">Đăng xuất</a></li>
                        <?php else: ?>
                            <li class="nav-item"><a class="nav-link" href="/shoeshop/login">Đăng nhập</a></li>
                            <li class="nav-item"><a class="nav-link" href="/shoeshop/register">Đăng ký</a></li>
                        <?php endif; ?>
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        <li class="nav-item"><a href="/shoeshop/cart" class="cart"><span class="ti-bag"></span></a></li>
                    </ul>
                </div>
            </div>
        </nav>
    </div>

    <div class="search_input" id="search_input_box">
        <div class="container">
            <form class="d-flex justify-content-between">
                <input type="text" class="form-control" id="search_input" placeholder="Tìm kiếm">
                <button type="submit" class="btn"></button>
                <span class="lnr lnr-cross" id="close_search" title="Close Search"></span>
            </form>
        </div>
    </div>

</header>