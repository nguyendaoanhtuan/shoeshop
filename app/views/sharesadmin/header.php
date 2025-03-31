<!DOCTYPE html>
<html lang="en">
  <head>
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

          <!--
            <div class="nav notify-row" id="top_menu">

                <ul class="nav top-menu">

                    <li class="dropdown">
                        <a data-toggle="dropdown" class="dropdown-toggle" href="index.html#">
                            <i class="fa fa-tasks"></i>
                            <span class="badge bg-theme">4</span>
                        </a>
                        <ul class="dropdown-menu extended tasks-bar">
                            <div class="notify-arrow notify-arrow-green"></div>
                            <li>
                                <p class="green">Bạn có 4 nhiệm vụ đang chờ xử lí</p>
                            </li>
                            <li>
                                <a href="index.html#">
                                    <div class="task-info">
                                        <div class="desc"> Bảng quản trị</div>
                                        <div class="percent">40%</div>
                                    </div>
                                    <div class="progress progress-striped">
                                        <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 40%">
                                            <span class="sr-only">40% Hoàn thành(thành công)</span>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="index.html#">
                                    <div class="task-info">
                                        <div class="desc">Cập nhật dữ liệu</div>
                                        <div class="percent">60%</div>
                                    </div>
                                    <div class="progress progress-striped">
                                        <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%">
                                            <span class="sr-only">60% Hoàn thành( cảnh báo)</span>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="index.html#">
                                    <div class="task-info">
                                        <div class="desc">Phát triển sản phẩm</div>
                                        <div class="percent">80%</div>
                                    </div>
                                    <div class="progress progress-striped">
                                        <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" style="width: 80%">
                                            <span class="sr-only">80% Hoàn thành</span>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="index.html#">
                                    <div class="task-info">
                                        <div class="desc">Thanh toán đã được gửi</div>
                                        <div class="percent">70%</div>
                                    </div>
                                    <div class="progress progress-striped">
                                        <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100" style="width: 70%">
                                            <span class="sr-only">70% Hoàn thành( quan trọng)</span>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <li class="external">
                                <a href="#">Xem tất cả</a>
                            </li>
                        </ul>
                    </li>


                    <li id="header_inbox_bar" class="dropdown">
                        <a data-toggle="dropdown" class="dropdown-toggle" href="index.html#">
                            <i class="fa fa-envelope-o"></i>
                            <span class="badge bg-theme">5</span>
                        </a>
                        <ul class="dropdown-menu extended inbox">
                            <div class="notify-arrow notify-arrow-green"></div>
                            <li>
                                <p class="green">Bạn có 5 tin nhắn</p>
                            </li>
                            <li>
                                <a href="index.html#">
                                    <span class="photo"><img alt="avatar" src="assets/img/ui-zac.jpg"></span>
                                    <span class="subject">
                                    <span class="from">Zac Snider</span>
                                    <span class="time">Bây giờ</span>
                                    </span>
                                    <span class="message">
                                        Hi, mọi thứ thế nào?
                                    </span>
                                </a>
                            </li>
                            <li>
                                <a href="index.html#">
                                    <span class="photo"><img alt="avatar" src="assets/img/ui-divya.jpg"></span>
                                    <span class="subject">
                                    <span class="from">Divya Manian</span>
                                    <span class="time">40 phút</span>
                                    </span>
                                    <span class="message">
                                     Hi, tôi cần bạn giúp cái này.
                                    </span>
                                </a>
                            </li>
                            <li>
                                <a href="index.html#">
                                    <span class="photo"><img alt="avatar" src="assets/img/ui-danro.jpg"></span>
                                    <span class="subject">
                                    <span class="from">Dan Rogers</span>
                                    <span class="time">2 giờ.</span>
                                    </span>
                                    <span class="message">
                                        Cảm ơn.
                                    </span>
                                </a>
                            </li>
                            <li>
                                <a href="index.html#">
                                    <span class="photo"><img alt="avatar" src="assets/img/ui-sherman.jpg"></span>
                                    <span class="subject">
                                    <span class="from">Dj Sherman</span>
                                    <span class="time">4 giờ.</span>
                                    </span>
                                    <span class="message">
                                        Làm ơn, trả lời lại đi.
                                    </span>
                                </a>
                            </li>
                            <li>
                                <a href="index.html#">Xem tất cả</a>
                            </li>
                        </ul>
                    </li>

                </ul>

            </div>
          -->
            <div class="top-menu">
            	<ul class="nav pull-right top-menu">
                    <li><a class="logout" href="login.html">Đăng xuất</a></li>
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
                <p class="centered"><a href="?controller=user&action=profile"><img src="assets/img/ui-sam.jpg" class="img-circle" width="60"></a></p>
                <h5 class="centered">Ngân Nguyễn</h5>

                <li class="mt">
                    <a href="?controller=home&action=index">
                        <i class="fa fa-dashboard"></i>
                        <span>Trang chủ</span>
                    </a>
                </li>
                
                <li class="sub-menu">
                    <a href="javascript:;">
                        <i class="fa fa-cogs"></i>
                        <span>Các thành phần</span>
                    </a>
                    <ul class="sub">
                        <li><a href="?controller=calendar&action=index">Lịch</a></li>
                        <li><a href="?controller=todo&action=index">Todo List</a></li>
                    </ul>
                </li>

                <li class="sub-menu">
                    <a href="?controller=chart&action=index">
                        <i class="fa fa-bar-chart-o"></i>
                        <span>Biểu đồ</span>
                    </a>
                </li>
                
                <li class="active sub-menu">
                    <a href="?controller=supplier&action=index">
                        <i class="fa fa-truck"></i>
                        <span>Nhà cung cấp</span>
                    </a>
                </li>
                
                <li class="sub-menu">
                    <a href="?controller=account&action=index">
                        <i class="fa fa-user"></i>
                        <span>Tài khoản</span>
                    </a>
                </li>
                
                <li class="sub-menu">
                    <a href="?controller=product&action=index">
                        <i class="fa fa-cube"></i>
                        <span>Sản phẩm</span>
                    </a>
                </li>
                
                <li class="sub-menu">
                    <a href="?controller=category&action=index">
                        <i class="fa fa-list"></i>
                        <span>Danh mục</span>
                    </a>
                </li>
                <li class="sub-menu">
                    <a href="?controller=brands&action=index">
                        <i class="fa fa-building"></i>
                        <span>Thương hiệu</span>
                    </a>
                </li>
            </ul>
            <!-- sidebar menu end-->
        </div>
    </aside>
      <!--sidebar end-->
      