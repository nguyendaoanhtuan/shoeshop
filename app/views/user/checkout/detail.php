<?php include_once 'app/views/sharesuser/header.php'; ?>
<!-- Start Banner Area -->
<section class="banner-area organic-breadcrumb">
    <div class="container">
        <div class="breadcrumb-banner d-flex flex-wrap align-items-center justify-content-end">
            <div class="col-first">
                <h1>Chi tiết đơn hàng</h1>
                <nav class="d-flex align-items-center">
                    <a href="<?php echo BASE_URL; ?>">Trang chủ<span class="lnr lnr-arrow-right"></span></a>
                    <a href="#">Chi tiết đơn hàng</a>
                </nav>
            </div>
        </div>
    </div>
</section>
<!-- End Banner Area -->
<div class="container order-detail">
<?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success"><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></div>
        <?php endif; ?>
        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></div>
        <?php endif; ?>
<a href="<?= BASE_URL ?>shoeshop/user/account/index" class="btn btn-primary mb-2">Quay lại</a>
    <div class="row">
        <div class="col-md-8">
            <div class="content-panel content-panel-body">
                <span>Mã đơn hàng: #<?php echo htmlspecialchars($order->order_number); ?></span>
                <span style="margin-left: auto;" class="label label-<?= $order->status == 'delivered' ? 'success' : ($order->status == 'pending' ? 'warning' : 'danger') ?> label-mini">
                    <?php
                    switch ($order->status) {
                        case 'delivered':
                            echo 'Đã giao';
                            break;
                        case 'pending':
                            echo 'Chờ xử lý';
                            break;
                        case 'processing':
                            echo 'Đang xử lý';
                            break;
                        case 'shipped':
                            echo 'Đang giao';
                            break;
                        default:
                            echo 'Đã hủy';
                            break;
                    }
                    ?>
                </span>
                <br>
                <span><?php echo date('d/m/Y', strtotime($order->created_at)); ?></span>
            </div>
            <div class="content-panel">
                <div class="content-panel-header">
                    NGƯỜI NHẬN
                </div>
                <div class="content-panel-body">
                    <?php
                    $parts = array_map('trim', explode('|', $order->shipping_address));
                    foreach ($parts as $i) {
                        echo "<span>$i</span><br>";
                    }
                    ?>
                </div>
            </div>
            <div class="">
                <div class="content-panel-body">
                <table class="table table-striped table-advance table-hover">
                        <thead>
                            <tr>
                                <th>Sản phẩm</th>
                                <th>Kích thước</th>
                                <th>Số lượng</th>
                                <th>Đơn giá</th>
                                <th>Tổng</th>
                            </tr>
                        </thead>
                        <tbody>
                                <?php foreach ($orderItems as $item): ?>
                                <tr>
                                    <td><?= htmlspecialchars($item->product_name) ?></td>
                                    <td><?= htmlspecialchars($item->size_name) ?></td>
                                    <td><?= $item->quantity ?></td>
                                    <?php if ($item->discount_price > 0): ?>
                                        <td><?= number_format($item->discount_price, 0, ',', '.') ?> ₫ <del><?= number_format($item->price, 0, ',', '.') ?> ₫</del></td>
                                    <?php else: ?>
                                        <td><?= number_format($item->price, 0, ',', '.') ?> ₫</td>
                                    <?php endif; ?>
                                    <td><?= number_format(($item->discount_price ?: $item->price) * $item->quantity, 0, ',', '.') ?> ₫</td>
                                </tr>
                                <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="content-panel">
                <div class="content-panel-header">
                    <span>PHƯƠNG THỨC THANH TOÁN</span>
                </div>
                <div class="content-panel-body">
                    <div style="margin-bottom: 8px;" class="row">
                        <div class="col-md-7">
                            <span>Phương thức thanh toán</span>
                        </div>
                        <div class="col-md-5">
                            <span><?php echo htmlspecialchars($order->payment_method); ?></span>
                        </div>
                    </div>
                    <div style="margin-bottom: 8px;" class="row">
                        <div class="col-md-7">
                            <span>Phí vận chuyển</span>
                        </div>
                        <div class="col-md-5">
                            <span><?= number_format($order->shipping_fee, 0, ',', '.') ?> ₫</span>
                        </div>
                    </div>
                    <div style="margin-bottom: 8px;" class="row">
                        <div class="col-md-7">
                            <span>Tổng tiền sản phẩm</span>
                        </div>
                        <div class="col-md-5">
                            <span><?= number_format($order->total_amount - $order->shipping_fee, 0, ',', '.') ?> ₫</span>
                        </div>
                    </div>
                    <div style="margin-bottom: 8px;" class="row">
                        <div class="col-md-7">
                            <span>Thành tiền</span>
                        </div>
                        <div class="col-md-5">
                            <span style="color: red;"><?= number_format($order->total_amount, 0, ',', '.') ?> ₫</span>
                        </div>
                    </div>
                </div>
            </div>
            <?php
                switch($order->status){
                    case 'pending':
                    case 'processing':
                        echo '<a href="' . htmlspecialchars(BASE_URL . 'user/checkout/cancel/' . $order->order_id) . '" 
                                           class="btn btn-danger btn-xs" 
                                           onclick="return confirm(\'Bạn có chắc chắn muốn hủy đơn hàng này?\')">Hủy đơn hàng
                                        </a>';
                        break;
                    default:
                        break;
                }
            ?>
        </div>
    </div>

</div>
<?php include_once 'app/views/sharesuser/footer.php'; ?>