<?php include_once 'app/views/sharesuser/header.php'; ?>

<section class="banner-area organic-breadcrumb">
    <div class="container">
        <div class="breadcrumb-banner d-flex flex-wrap align-items-center justify-content-end">
            <div class="col-first">
                <h1>Tài khoản của tôi</h1>
                <nav class="d-flex align-items-center">
                    <a href="/shoeshop">Trang chủ<span class="lnr lnr-arrow-right"></span></a>
                    <a href="/shoeshop/account">Tài khoản</a>
                </nav>
            </div>
        </div>
    </div>
</section>

<section class="login_box_area section_gap">
    <div class="container">
        <?php if(isset($_SESSION['success'])): ?>
            <div class="alert alert-success"><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></div>
        <?php endif; ?>
        <?php if(isset($_SESSION['error'])): ?>
            <div class="alert alert-danger"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></div>
        <?php endif; ?>

        <div class="row">
            <div class="col-lg-6">
                <div class="login_form_inner">
                    <h3>Thông tin cá nhân</h3>
                    <form class="row login_form" action="/shoeshop/account/update" method="post" id="profileForm">
                        <div class="col-md-12 form-group">
                            <input type="text" class="form-control" name="name" placeholder="Họ tên" 
                                value="<?php echo htmlspecialchars($user['name']); ?>" required>
                        </div>
                        <div class="col-md-12 form-group">
                            <input type="email" class="form-control" name="email" placeholder="Email" 
                                value="<?php echo htmlspecialchars($user['email']); ?>" required>
                        </div>
                        <div class="col-md-12 form-group">
                            <input type="text" class="form-control" name="phone" placeholder="Số điện thoại" 
                                value="<?php echo htmlspecialchars($user['phone'] ?? ''); ?>">
                        </div>
                        <div class="col-md-12 form-group">
                            <textarea class="form-control" name="address" placeholder="Địa chỉ"><?php echo htmlspecialchars($user['address'] ?? ''); ?></textarea>
                        </div>
                        <div class="col-md-12 form-group">
                            <button type="submit" class="primary-btn">Cập nhật thông tin</button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="login_form_inner">
                    <h3>Đổi mật khẩu</h3>
                    <form class="row login_form" action="/shoeshop/account/change-password" method="post" id="passwordForm">
                        <div class="col-md-12 form-group">
                            <input type="password" class="form-control" name="current_password" 
                                placeholder="Mật khẩu hiện tại" required>
                        </div>
                        <div class="col-md-12 form-group">
                            <input type="password" class="form-control" name="new_password" 
                                placeholder="Mật khẩu mới" required>
                        </div>
                        <div class="col-md-12 form-group">
                            <input type="password" class="form-control" name="confirm_password" 
                                placeholder="Xác nhận mật khẩu mới" required>
                        </div>
                        <div class="col-md-12 form-group">
                            <button type="submit" class="primary-btn">Đổi mật khẩu</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="row mt-5">
            <div class="col-lg-12">
                <div class="order_details_table">
                    <h2>Lịch sử đơn hàng</h2>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">Mã đơn hàng</th>
                                    <th scope="col">Ngày đặt</th>
                                    <th scope="col">Tổng tiền</th>
                                    <th scope="col">Trạng thái</th>
                                    <th scope="col">Chi tiết</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(empty($orders)): ?>
                                    <tr>
                                        <td colspan="5" class="text-center">Bạn chưa có đơn hàng nào</td>
                                    </tr>
                                <?php else: ?>
                                    <?php foreach($orders as $order): ?>
                                    <tr>
                                        <td>#<?php echo $order['id']; ?></td>
                                        <td><?php echo date('d/m/Y', strtotime($order['created_at'])); ?></td>
                                        <td><?php echo number_format($order['total'], 0, ',', '.'); ?>đ</td>
                                        <td>
                                            <?php
                                            $status_class = '';
                                            switch($order['status']) {
                                                case 'pending':
                                                    $status_class = 'text-warning';
                                                    $status_text = 'Chờ xử lý';
                                                    break;
                                                case 'processing':
                                                    $status_class = 'text-primary';
                                                    $status_text = 'Đang xử lý';
                                                    break;
                                                case 'completed':
                                                    $status_class = 'text-success';
                                                    $status_text = 'Hoàn thành';
                                                    break;
                                                case 'cancelled':
                                                    $status_class = 'text-danger';
                                                    $status_text = 'Đã hủy';
                                                    break;
                                                default:
                                                    $status_class = 'text-secondary';
                                                    $status_text = $order['status'];
                                            }
                                            ?>
                                            <span class="<?php echo $status_class; ?>"><?php echo $status_text; ?></span>
                                        </td>
                                        <td>
                                            <a href="/shoeshop/order/<?php echo $order['id']; ?>" 
                                               class="btn btn-sm btn-outline-primary">Xem chi tiết</a>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include_once 'app/views/sharesuser/footer.php'; ?> 