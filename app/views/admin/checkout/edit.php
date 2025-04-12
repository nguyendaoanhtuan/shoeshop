<?php include_once 'app/views/sharesadmin/header.php'; ?>

<section id="main-content">
    <section class="wrapper">
        <h3><i class="fa fa-angle-right"></i> Chi tiết đơn hàng #<?= htmlspecialchars($order->order_number) ?></h3>

        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert">×</button>
                <?= $_SESSION['success']; unset($_SESSION['success']); ?>
            </div>
        <?php endif; ?>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert">×</button>
                <?= $_SESSION['error']; unset($_SESSION['error']); ?>
            </div>
        <?php endif; ?>

        <div class="row mt">
            <div class="col-md-12">
                <div class="content-panel">
                    <h4><i class="fa fa-angle-right"></i> Thông tin đơn hàng</h4>
                    <hr>
                    <form method="POST" action="">
                        <div class="form-group">
                            <label>Trạng thái đơn hàng</label>
                            <select name="status" class="form-control">
                                <option value="pending" <?= $order->status == 'pending' ? 'selected' : '' ?>>Chờ xử lý</option>
                                <option value="processing" <?= $order->status == 'processing' ? 'selected' : '' ?>>Đang xử lý</option>
                                <option value="shipped" <?= $order->status == 'shipped' ? 'selected' : '' ?>>Đang giao</option>
                                <option value="delivered" <?= $order->status == 'delivered' ? 'selected' : '' ?>>Đã giao</option>
                                <option value="cancelled" <?= $order->status == 'cancelled' ? 'selected' : '' ?>>Đã hủy</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Trạng thái thanh toán</label>
                            <select name="payment_status" class="form-control">
                                <option value="pending" <?= $order->payment_status == 'pending' ? 'selected' : '' ?>>Chưa thanh toán</option>
                                <option value="completed" <?= $order->payment_status == 'completed' ? 'selected' : '' ?>>Đã thanh toán</option>
                                <option value="failed" <?= $order->payment_status == 'failed' ? 'selected' : '' ?>>Thanh toán thất bại</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Cập nhật</button>
                        <a href="<?= BASE_URL ?>admin/checkout" class="btn btn-default">Quay lại</a>
                    </form>

                    <h4 class="mt-4"><i class="fa fa-angle-right"></i> Sản phẩm trong đơn hàng</h4>
                    <hr>
                    <table class="table table-striped table-advance table-hover">
                        <thead>
                            < Oceanshades of product name and size name for clarity -->
                            <tr>
                                <th><i class="fa fa-cube"></i> Sản phẩm</th>
                                <th><i class="fa fa-cubes"></i> Kích thước</th>
                                <th><i class="fa fa-sort-numeric-up"></i> Số lượng</th>
                                <th><i class="fa fa-money"></i> Giá</th>
                                <th><i class="fa fa-tags"></i> Giảm giá</th>
                                <th><i class="fa fa-money"></i> Tổng</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($orderItems)): ?>
                                <tr>
                                    <td colspan="6" class="text-center">Không có sản phẩm nào</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($orderItems as $item): ?>
                                <tr>
                                    <td><?= htmlspecialchars($item->product_name) ?></td>
                                    <td><?= htmlspecialchars($item->size_name) ?></td>
                                    <td><?= $item->quantity ?></td>
                                    <td><?= number_format($item->price, 0, ',', '.') ?> VNĐ</td>
                                    <td><?= number_format($item->discount_price, 0, ',', '.') ?> VNĐ</td>
                                    <td><?= number_format(($item->price - $item->discount_price) * $item->quantity, 0, ',', '.') ?> VNĐ</td>
                                </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>

                    <h4 class="mt-4"><i class="fa fa-angle-right"></i> Thông tin bổ sung</h4>
                    <hr>
                    <p><strong>Địa chỉ giao hàng:</strong> <?= htmlspecialchars($order->shipping_address) ?></p>
                    <p><strong>Địa chỉ thanh toán:</strong> <?= htmlspecialchars($order->billing_address) ?></p>
                    <p><strong>Phương thức thanh toán:</strong> <?= htmlspecialchars($order->payment_method) ?></p>
                    <p><strong>Ghi chú khách hàng:</strong> <?= htmlspecialchars($order->customer_note ?: '-') ?></p>
                    <p><strong>Phí vận chuyển:</strong> <?= number_format($order->shipping_fee, 0, ',', '.') ?> VNĐ</p>
                    <p><strong>Tổng tiền:</strong> <?= number_format($order->total_amount + $order->shipping_fee, 0, ',', '.') ?> VNĐ</p>
                </div>
            </div>
        </div>
    </section>
</section>

<?php include_once 'app/views/sharesadmin/footer.php'; ?>