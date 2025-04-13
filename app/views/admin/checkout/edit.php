<?php include_once 'app/views/sharesadmin/header.php'; ?>

<section id="main-content">
    <section class="wrapper">
        <h3 style="background-color: #FFFFFF;
        padding: 8px;
        border-radius: 10px;
        width: auto">
            Thông tin đơn hàng #<?= htmlspecialchars($order->order_number) ?></h3>

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

        <div class="row">
            <div class="col-md-12">
                <div
                style="border-radius: 15px;
                padding: 15px;"
                 class="content-panel">
                 <h4 style="color: black;
                 font-weight: bold">Trạng thái đơn hàng</h4>
                    <form method="POST" action="">
                    
                        <div class="form-group">
                            <label>Trạng thái giao hàng</label>
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
                                <option value="paid" <?= $order->payment_status == 'paid' ? 'selected' : '' ?>>Đã thanh toán</option>
                                <option value="failed" <?= $order->payment_status == 'failed' ? 'selected' : '' ?>>Thanh toán thất bại</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Cập nhật</button>
                        <a href="<?= BASE_URL ?>admin/checkout" class="btn btn-default">Quay lại</a>
                    </form>
                    <hr>
                    <h4 style="color: black;
                 font-weight: bold">Địa chỉ giao hàng</h4>
                    <p><?= htmlspecialchars($order->shipping_address) ?></p>
                    <hr>
                    <h4>Ghi chú</h4>
                    <p><?= htmlspecialchars($order->customer_note ?: 'Không có ghi chú') ?></p>
                </div>
            </div>
        </div>
        <div class="row mt">
            <div class="col-md-12">
                <div class="content-panel">
                    <table class="table table-striped table-advance table-hover">
                        <thead>
                            <tr>
                                <th><i class="fa fa-cube"></i> Sản phẩm</th>
                                <th><i class="fa fa-cubes"></i> Kích thước</th>
                                <th><i class="fa fa-sort-numeric-up"></i> Số lượng</th>
                                <th><i class="fa fa-money"></i>Đơn giá</th>
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
                                    <?php if ($item->discount_price > 0): ?>
                                        <td><?= number_format($item->discount_price, 0, ',', '.') ?> ₫ <del><?= number_format($item->price, 0, ',', '.') ?> ₫</del></td>
                                    <?php else: ?>
                                        <td><?= number_format($item->price, 0, ',', '.') ?> ₫</td>
                                    <?php endif; ?>
                                    <td><?= number_format(($item->discount_price ?: $item->price) * $item->quantity, 0, ',', '.') ?> ₫</td>
                                </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                    <hr>
                    <p><strong>Phương thức thanh toán:</strong> <?= htmlspecialchars($order->payment_method) ?></p>
                    <p><strong>Phí vận chuyển:</strong> <?= number_format($order->shipping_fee, 0, ',', '.') ?> ₫</p>
                    <p><strong>Tổng tiền:</strong> <?= number_format($order->total_amount + $order->shipping_fee, 0, ',', '.') ?> ₫</p>
                </div>
            </div>
        </div>
    </section>
</section>

<?php include_once 'app/views/sharesadmin/footer.php'; ?>