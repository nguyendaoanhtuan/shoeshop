<!DOCTYPE html>
<html lang="en">
  <head>
    <base href="<?php echo BASE_URL; ?>">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Dashboard">
    <meta name="keyword" content="Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">
    <title>Admin</title>

    <!-- Bootstrap core CSS -->
    <link href="public/admin/assets/css/bootstrap.css" rel="stylesheet">
    <!--external css-->
    <link href="public/admin/assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
    <!-- Custom styles for this template -->
    <link href="public/admin/assets/css/style.css" rel="stylesheet">
    <link href="public/admin/assets/css/style-responsive.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js IE8 support -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
    <div id="login-page">
      <div class="container">
        <form class="form-login" method="post" action="/shoeshop/admin/login">
          <h2 class="form-login-heading">Đăng nhập</h2>
          <div class="login-wrap">
            <input type="text" name="username" class="form-control" placeholder="User ID" autofocus>
            <br>
            <input type="password" name="password" class="form-control" style="margin-bottom: 10px;" placeholder="Password">

            <button class="btn btn-theme btn-block"  type="submit"><i class="fa fa-lock"></i> Đăng nhập</button>
            <hr>


        </form>
      </div>
    </div>

    <!-- js placed at the end of the document so the pages load faster -->
    <script src="public/admin/assets/js/jquery.js"></script>
    <script src="public/admin/assets/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="public/admin/assets/js/jquery.backstretch.min.js"></script>
    <script>
        $.backstretch("public/admin/assets/img/login-bg.jpg", {speed: 500});
    </script>
  </body>
</html>