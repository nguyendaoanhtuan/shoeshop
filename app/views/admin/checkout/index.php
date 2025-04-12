<?php include_once 'app/views/sharesadmin/header.php'; ?>

<section id="main-content">
    <section class="wrapper">
        <h3><i class="fa fa-angle-right"></i> Quản lý đơn hàng</h3>

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
                    <div style="justify-content: space-between; align-items: center; margin-bottom: 20px;">
                        <h4><i class="fa fa-angle-right"></i> Danh sách đơn hàng</h4>
                        <form method="GET" action="<?= BASE_URL ?>admin/checkout">
                            <div class="input-group" style="width: 300px;">
                                <input type="text" name="search" class="form-control" 
                                       placeholder="Tìm kiếm theo mã đơn hoặc địa chỉ" 
                                       value="<?= htmlspecialchars($search ?? '') ?>">
                                <span class="input-group-btn">
                                    <button class="btn btn-primary" type="submit">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </span>
                            </div>
                        </form>
                    </div>
                    <hr>
                    <table class="table table-striped table-advance table-hover">
                        <thead>
                            <tr>
                                <th><i class="fa fa-hashtag"></i> Mã đơn</th>
                                <th><i class="fa fa-user"></i> Khách hàng</th>
                                <th><i class="fa fa-money"></i> Tổng tiền</th>
                                <th><i class="fa fa-truck"></i> Trạng thái</th>
                                <th><i class="fa fa-credit-card"></i> Thanh toán</th>
                                <th><i class="fa fa-calendar"></i> Ngày tạo</th>
                                <th><i class="fa fa-cogs"></i> Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($orders)): ?>
                                <tr>
                                    <td colspan="7" class="text-center">Không tìm thấy đơn hàng nào</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($orders as $order): ?>
                                <tr>
                                    <td><?= htmlspecialchars($order->order_number) ?></td>
                                    <td><?= htmlspecialchars($order->shipping_address) ?></td>
                                    <td><?= number_format($order->total_amount + $order->shipping_fee, 0, ',', '.') ?> VNĐ</td>
                                    <td>
                                        <span class="label label-<?= $order->status == 'delivered' ? 'success' : ($order->status == 'pending' ? 'warning' : 'danger') ?> label-mini">
                                            <?= ucfirst($order->status) ?>
                                        </span>
                                    </td>
                                    <td>
                                        <span class="label label-<?= $order->payment_status == 'completed' ? 'success' : 'warning' ?> label-mini">
                                            <?= ucfirst($order->payment_status) ?>
                                        </span>
                                    </td>
                                    <td><?= date('d/m/Y H:i', strtotime($order->created_at)) ?></td>
                                    <td>
                                        <a href="<?= BASE_URL ?>admin/checkout/edit/<?= $order->order_id ?>" 
                                           class="btn btn-primary btn-xs">
                                            <i class="fa fa-pencil"></i>
                                        </a>
                                        <a href="<?= BASE_URL ?>admin/checkout/delete/<?= $order->order_id ?>" 
                                           class="btn btn-danger btn-xs" 
                                           onclick="return confirm('Bạn có chắc chắn muốn xóa đơn hàng này?')">
                                            <i class="fa fa-trash-o"></i>
                                        </a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>

                    <?php if ($totalPages > 1): ?>
                        <div class="text-center">
                            <ul class="pagination">
                                <li class="<?= $page <= 1 ? 'disabled' : '' ?>">
                                    <a href="<?= BASE_URL ?>admin/checkout?page=<?= $page - 1 ?>&search=<?= urlencode($search ?? '') ?>" 
                                       aria-label="Previous">
                                        <span aria-hidden="true">«</span>
                                    </a>
                                </li>
                                <?php for ($i = max(1, $page - 2); $i <= min($totalPages, $page + 2); $i++): ?>
                                    <li class="<?= $i == $page ? 'active' : '' ?>">
                                        <a href="<?= BASE_URL ?>admin/checkout?page=<?= $i ?>&search=<?= urlencode($search ?? '') ?>">
                                            <?= $i ?>
                                        </a>
                                    </li>
                                <?php endfor; ?>
                                <li class="<?= $page >= $totalPages ? 'disabled' : '' ?>">
                                    <a href="<?= BASE_URL ?>admin/checkout?page=<?= $page + 1 ?>&search=<?= urlencode($search ?? '') ?>" 
                                       aria-label="Next">
                                        <span aria-hidden="true">»</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>
</section>

<?php include_once 'app/views/sharesadmin/footer.php'; ?>