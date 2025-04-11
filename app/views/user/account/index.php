<?php include_once 'app/views/sharesuser/header.php'; ?>

<section class="banner-area organic-breadcrumb">
    <div class="container">
        <div class="breadcrumb-banner d-flex flex-wrap align-items-center justify-content-end">
            <div class="col-first">
                <h1>Tài khoản của tôi</h1>
                <nav class="d-flex align-items-center">
                    <a href="<?php echo BASE_URL; ?>">Trang chủ<span class="lnr lnr-arrow-right"></span></a>
                    <a href="<?php echo BASE_URL; ?>user/account">Tài khoản</a>
                </nav>
            </div>
        </div>
    </div>
</section>

<section class="login_box_area section_gap">
    <div class="container">
        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success"><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></div>
        <?php endif; ?>
        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></div>
        <?php endif; ?>

        <div class="row">
            <div class="col-lg-6">
                <div class="login_form_inner">
                    <h3>Thông tin cá nhân</h3>
                    <div class="row">
                        <div class="col-md-12 form-group">
                            <label><strong>Họ tên:</strong> <?php echo isset($user['full_name']) ? htmlspecialchars($user['full_name']) : 'Chưa cập nhật'; ?></label>
                        </div>
                        <div class="col-md-12 form-group">
                            <label><strong>Email:</strong> <?php echo isset($user['email']) ? htmlspecialchars($user['email']) : 'Chưa cập nhật'; ?></label>
                        </div>
                        <div class="col-md-12 form-group">
                            <label><strong>Số điện thoại:</strong> <?php echo isset($user['phone_number']) ? htmlspecialchars($user['phone_number']) : 'Chưa cập nhật'; ?></label>
                        </div>
                        <div class="col-md-12 form-group">
                            <label><strong>Địa chỉ:</strong> <?php echo isset($user['address']) ? htmlspecialchars($user['address']) : 'Chưa cập nhật'; ?></label>
                        </div>
                        <div class="col-md-12 form-group">
                            <a href="<?php echo BASE_URL; ?>user/account/edit" class="primary-btn">Chỉnh sửa thông tin</a>
                            <a href="<?php echo BASE_URL; ?>user/account/logout" class="primary-btn" style="background-color: #dc3545;">Đăng xuất</a>
                        </div>
                    </div>
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
                                <?php if (empty($orders)): ?>
                                    <tr>
                                        <td colspan="5" class="text-center">Bạn chưa có đơn hàng nào</td>
                                    </tr>
                                <?php else: ?>
                                    <?php foreach ($orders as $order): ?>
                                    <tr>
                                        <td>#<?php echo $order['order_id']; ?></td>
                                        <td><?php echo date('d/m/Y', strtotime($order['created_at'])); ?></td>
                                        <td><?php echo number_format($order['total_amount'], 0, ',', '.'); ?>đ</td>
                                        <td>
                                            <?php
                                            $status_class = '';
                                            switch ($order['status']) {
                                                case 'pending':
                                                    $status_class = 'text-warning';
                                                    $status_text = 'Chờ xử lý';
                                                    break;
                                                case 'processing':
                                                    $status_class = 'text-primary';
                                                    $status_text = 'Đang xử lý';
                                                    break;
                                                case 'shipped':
                                                    $status_class = 'text-info';
                                                    $status_text = 'Đang giao hàng';
                                                    break;
                                                case 'delivered':
                                                    $status_class = 'text-success';
                                                    $status_text = 'Đã giao';
                                                    break;
                                                case 'cancelled':
                                                    $status_class = 'text-danger';
                                                    $status_text = 'Đã hủy';
                                                    break;
                                                case 'refunded':
                                                    $status_class = 'text-secondary';
                                                    $status_text = 'Đã hoàn tiền';
                                                    break;
                                                default:
                                                    $status_class = 'text-secondary';
                                                    $status_text = $order['status'];
                                            }
                                            ?>
                                            <span class="<?php echo $status_class; ?>"><?php echo $status_text; ?></span>
                                        </td>
                                        <td>
                                            <a href="<?php echo BASE_URL; ?>order/<?php echo $order['order_id']; ?>" 
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