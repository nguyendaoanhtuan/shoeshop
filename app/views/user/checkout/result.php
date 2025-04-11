<?php
require_once 'app/views/sharesuser/header.php'; // Giả sử bạn có file header chung
?>

<!-- Start Banner Area -->
<section class="banner-area organic-breadcrumb">
    <div class="container">
        <div class="breadcrumb-banner d-flex flex-wrap align-items-center justify-content-end">
            <div class="col-first">
                <h1>Xác Nhận</h1>
                <nav class="d-flex align-items-center">
                    <a href="<?= BASE_URL ?>">Trang chủ<span class="lnr lnr-arrow-right"></span></a>
                    <a href="<?= BASE_URL . 'user/checkout/result' ?>">Xác Nhận</a>
                </nav>
            </div>
        </div>
    </div>
</section>
<!-- End Banner Area -->

<!--================Order Details Area =================-->
<section class="order_details section_gap">
    <div class="container">
        <?php if (isset($_SESSION['success'])): ?>
            <h3 class="title_confirmation">
            Cảm ơn bạn. Đơn hàng của bạn đã được tiếp nhận.</h3>
            <?php 
                // Lấy thông tin đơn hàng từ session hoặc database nếu cần
                $order_id = $_SESSION['order_id'] ?? null; // Giả sử bạn lưu order_id trong session sau khi thanh toán
                if ($order_id) {
                    $orderModel = new OrderModel();
                    $order = $orderModel->getOrderById($order_id);
                    $orderItems = (new OrderItemModel())->getItemsByOrderId($order_id);
                }
            ?>
            <div class="row order_d_inner">
                <div class="col-lg-4">
                    <div class="details_item">
                        <h4>Order Info</h4>
                        <ul class="list">
                            <li><a href="#"><span>Order number</span> : <?= htmlspecialchars($order->order_number ?? 'N/A') ?></a></li>
                            <li><a href="#"><span>Date</span> : <?= htmlspecialchars(date('d/m/Y H:i:s', strtotime($order->created_at ?? 'now'))) ?></a></li>
                            <li><a href="#"><span>Total</span> : <?= number_format($order->total_amount ?? 0, 0, ',', '.') ?> VND</a></li>
                            <li><a href="#"><span>Payment method</span> : <?= htmlspecialchars($order->payment_method === 'vnpay' ? 'VNPay' : 'Cash on Delivery') ?></a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="details_item">
                        <h4>Billing Address</h4>
                        <ul class="list">
                            <?php
                            $billingParts = explode(', ', $order->billing_address ?? '');
                            $name = $billingParts[0] ?? '';
                            $address = $billingParts[1] ?? '';
                            $phone = str_replace('SĐT: ', '', $billingParts[2] ?? '');
                            $email = str_replace('Email: ', '', $billingParts[3] ?? '');
                            ?>
                            <li><a href="#"><span>Name</span> : <?= htmlspecialchars($name) ?></a></li>
                            <li><a href="#"><span>Address</span> : <?= htmlspecialchars($address) ?></a></li>
                            <li><a href="#"><span>Phone</span> : <?= htmlspecialchars($phone) ?></a></li>
                            <li><a href="#"><span>Email</span> : <?= htmlspecialchars($email) ?></a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="details_item">
                        <h4>Shipping Address</h4>
                        <ul class="list">
                            <?php
                            $shippingParts = explode(', ', $order->shipping_address ?? '');
                            $name = $shippingParts[0] ?? '';
                            $address = $shippingParts[1] ?? '';
                            $phone = str_replace('SĐT: ', '', $shippingParts[2] ?? '');
                            $email = str_replace('Email: ', '', $shippingParts[3] ?? '');
                            ?>
                            <li><a href="#"><span>Name</span> : <?= htmlspecialchars($name) ?></a></li>
                            <li><a href="#"><span>Address</span> : <?= htmlspecialchars($address) ?></a></li>
                            <li><a href="#"><span>Phone</span> : <?= htmlspecialchars($phone) ?></a></li>
                            <li><a href="#"><span>Email</span> : <?= htmlspecialchars($email) ?></a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="order_details_table">
                <h2>Order Details</h2>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Product</th>
                                <th scope="col">Quantity</th>
                                <th scope="col">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $subtotal = 0;
                            if (!empty($orderItems)):
                                foreach ($orderItems as $item): 
                                    $itemTotal = ($item->discount_price ?? $item->price) * $item->quantity;
                                    $subtotal += $itemTotal;
                            ?>
                                <tr>
                                    <td>
                                        <p><?= htmlspecialchars($item->product_name . ' (Size: ' . $item->size_name . ')') ?></p>
                                    </td>
                                    <td>
                                        <h5>x <?= htmlspecialchars($item->quantity) ?></h5>
                                    </td>
                                    <td>
                                        <p><?= number_format($itemTotal, 0, ',', '.') ?> VND</p>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            <tr>
                                <td>
                                    <h4>Subtotal</h4>
                                </td>
                                <td>
                                    <h5></h5>
                                </td>
                                <td>
                                    <p><?= number_format($subtotal, 0, ',', '.') ?> VND</p>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <h4>Shipping</h4>
                                </td>
                                <td>
                                    <h5></h5>
                                </td>
                                <td>
                                    <p><?= number_format($order->shipping_fee ?? 0, 0, ',', '.') ?> VND</p>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <h4>Total</h4>
                                </td>
                                <td>
                                    <h5></h5>
                                </td>
                                <td>
                                    <p><?= number_format($order->total_amount ?? 0, 0, ',', '.') ?> VND</p>
                                </td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        <?php else: ?>
            <h3 class="title_confirmation text-danger">
                <?= htmlspecialchars($_SESSION['error'] ?? 'An error occurred. Please try again.') ?>
            </h3>
        <?php endif; ?>
    </div>
</section>
<!--================End Order Details Area =================-->

<?php
// Xóa các thông báo session sau khi hiển thị
unset($_SESSION['success']);
unset($_SESSION['error']);
unset($_SESSION['order_id']);

require_once 'app/views/sharesuser/footer.php'; // Giả sử bạn có file footer chung
?>