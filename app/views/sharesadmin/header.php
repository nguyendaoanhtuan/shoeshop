<!DOCTYPE html>
<html lang="en">
  <head>
    <base href="<?php echo BASE_URL; ?>">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Dashboard">
    <meta name="keyword" content="Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">

    <title>Admin-Shop bán giày dép</title>

    <!-- Bootstrap core CSS -->
    <link href="public/admin/assets/css/bootstrap.css" rel="stylesheet">
    <!--external css-->
    <link href="public/admin/assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="public/admin/assets/css/zabuto_calendar.css">
    <link rel="stylesheet" type="text/css" href="public/admin/assets/js/gritter/css/jquery.gritter.css" />
    <link rel="stylesheet" type="text/css" href="public/admin/assets/lineicons/style.css">    
    
    <!-- Custom styles for this template -->
    <link href="public/admin/assets/css/style.css" rel="stylesheet">
    <link href="public/admin/assets/css/style-responsive.css" rel="stylesheet">

    <script src="public/admin/assets/js/chart-master/Chart.js"></script>
    
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

  <section id="container" >
      <!-- **********************************************************************************************************************************************************
      TOP BAR CONTENT & NOTIFICATIONS
      *********************************************************************************************************************************************************** -->
      <!--header start-->
      <header class="header black-bg">
              <div class="sidebar-toggle-box">
                  <div class="fa fa-bars tooltips" data-placement="right" ></div>
              </div>
            <!--logo start-->
            <a href="index.html" class="logo"><b>Shop bán giày dép</b></a>
            <!--logo end-->


          <div class="top-menu">
                <ul class="nav pull-right top-menu">
                    <li>
                        <!-- Tạo form đăng xuất với phương thức POST -->
                        <form action="/shoeshop/admin/logout" method="POST">
                            <button type="submit" class="logout">Đăng xuất</button>
                        </form>
                    </li>
                </ul>
            </div>
        </header>
      <!--header end-->
      
      <!-- **********************************************************************************************************************************************************
      MAIN SIDEBAR MENU
      *********************************************************************************************************************************************************** -->
      <!--sidebar start-->
      <aside>
    <div id="sidebar" class="nav-collapse">
        <!-- sidebar menu start-->
        <ul class="sidebar-menu" id="nav-accordion">
            <p class="centered">
                <a href="admin/profile">
                    <img src="public/admin/assets/img/ui-sam.jpg" class="img-circle" width="60">
                </a>
            </p>
            <h5 class="centered">Admin</h5>

            <li class="active sub-menu">
                <a href="admin/supplier">
                    <i class="fa fa-truck"></i>
                    <span>Đơn hàng</span>
                </a>
            </li>

            <li class="sub-menu">
                <a href="admin/account">
                    <i class="fa fa-user"></i>
                    <span>Tài khoản</span>
                </a>
            </li>

            <li class="sub-menu">
                <a href="admin/product">
                    <i class="fa fa-cube"></i>
                    <span>Sản phẩm</span>
                </a>
            </li>

            <li class="sub-menu">
                <a href="admin/category">
                    <i class="fa fa-list"></i>
                    <span>Danh mục</span>
                </a>
            </li>

            <li class="sub-menu">
                <a href="admin/brands">
                    <i class="fa fa-building"></i>
                    <span>Thương hiệu</span>
                </a>
            </li>

            <li class="sub-menu">
                <a href="admin/ProductImg">
                    <i class="fa fa-picture-o"></i>
                    <span>Hình ảnh sản phẩm</span>
                </a>
            </li>
            <li class="sub-menu">
                <a href="admin/ProductSize">
                    <i class="fa fa-database"></i>
                    <span>Kích thước sản phẩm</span>
                </a>
            </li>
        </ul>
        <!-- sidebar menu end-->
    </div>
</aside>

      <!--sidebar end-->
      