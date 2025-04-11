<?php include_once 'app/views/sharesadmin/header.php'; ?>

<section id="main-content">
    <section class="wrapper">
        <h3><i class="fa fa-angle-right"></i>Sản phẩm</h3>

        <!-- Hiển thị thông báo -->
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
            <div class="col-md-12 mt">
                <div class="content-panel">
                    <div style=" justify-content: space-between; align-items: center; margin-bottom: 20px;">
                        <h4><i class="fa fa-angle-right"></i> Danh sách sản phẩm</h4>
                        <div style=" gap: 10px;">
                            <!-- Form tìm kiếm -->
                            <form method="GET" action="<?= BASE_URL ?>admin/product">
                                <div class="input-group" style="margin-bottom: 10px;">
                                    <input type="text" name="search" class="form-control" 
                                           placeholder="Tìm kiếm theo tên sản phẩm" 
                                           value="<?= htmlspecialchars($search ?? '') ?>">
                                    <span class="input-group-btn">
                                        <button class="btn btn-primary" type="submit">
                                            <i class="fa fa-search"></i>
                                        </button>
                                    </span>
                                </div>
                            </form>
                            <a href="<?= BASE_URL ?>admin/product/create" class="btn btn-primary">
                                <i class="fa fa-plus"></i> Thêm sản phẩm
                            </a>
                        </div>
                    </div>
                    <hr>
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Tên</th>
                            <th>Danh mục</th>
                            <th>Thương hiệu</th>
                            <th>Giá</th>
                            <th>Giảm giá</th>
                            <th>Tồn kho</th>
                            <th>Trạng thái</th>
                            <th>Hành động</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if (empty($products)): ?>
                            <tr>
                                <td colspan="9" class="text-center">Không tìm thấy sản phẩm nào</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($products as $product): ?>
                            <tr>
                                <td><?= htmlspecialchars($product->product_id) ?></td>
                                <td><?= htmlspecialchars($product->name) ?></td>
                                <td><?= htmlspecialchars($product->category_name) ?></td>
                                <td><?= htmlspecialchars($product->brand_name ?? 'N/A') ?></td>
                                <td><?= number_format($product->price, 0, ',', '.') ?> đ</td>
                                <td><?= $product->discount_price ? number_format($product->discount_price, 0, ',', '.') . ' đ' : 'N/A' ?></td>
                                <td><?= htmlspecialchars($product->stock_quantity) ?></td>
                                <td>
                                    <span class="label label-<?= $product->is_active ? 'success' : 'danger' ?>">
                                        <?= $product->is_active ? 'Active' : 'Inactive' ?>
                                    </span>
                                    <?php if ($product->is_featured): ?>
                                        <span class="label label-warning">Featured</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <a href="<?= BASE_URL ?>admin/product/edit/<?= $product->product_id ?>" 
                                       class="btn btn-primary btn-xs">
                                       <i class="fa fa-pencil"></i>
                                    </a>
                                    <a href="<?= BASE_URL ?>admin/product/delete/<?= $product->product_id ?>" 
                                       class="btn btn-danger btn-xs" 
                                       onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này?')">
                                       <i class="fa fa-trash-o"></i>
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                        </tbody>
                    </table>

                    <!-- Phân trang -->
                    <?php if ($totalPages > 1): ?>
                        <div class="text-center">
                            <ul class="pagination">
                                <!-- Nút Previous -->
                                <li class="<?= $page <= 1 ? 'disabled' : '' ?>">
                                    <a href="<?= BASE_URL ?>admin/product?page=<?= $page - 1 ?>&search=<?= urlencode($search ?? '') ?>" 
                                       aria-label="Previous">
                                        <span aria-hidden="true">&laquo;</span>
                                    </a>
                                </li>
                                
                                <!-- Các trang -->
                                <?php 
                                $startPage = max(1, $page - 2);
                                $endPage = min($totalPages, $page + 2);
                                
                                // Hiển thị dấu ba chấm bên trái
                                if ($startPage > 1): ?>
                                    <li><a href="<?= BASE_URL ?>admin/product?page=1&search=<?= urlencode($search ?? '') ?>">1</a></li>
                                    <?php if ($startPage > 2): ?>
                                        <li><span>...</span></li>
                                    <?php endif; ?>
                                <?php endif; ?>
                                
                                <?php for ($i = $startPage; $i <= $endPage; $i++): ?>
                                    <li class="<?= $i == $page ? 'active' : '' ?>">
                                        <a href="<?= BASE_URL ?>admin/product?page=<?= $i ?>&search=<?= urlencode($search ?? '') ?>">
                                            <?= $i ?>
                                        </a>
                                    </li>
                                <?php endfor; ?>
                                
                                <!-- Hiển thị dấu ba chấm bên phải -->
                                <?php if ($endPage < $totalPages): ?>
                                    <?php if ($endPage < $totalPages - 1): ?>
                                        <li><span>...</span></li>
                                    <?php endif; ?>
                                    <li><a href="<?= BASE_URL ?>admin/product?page=<?= $totalPages ?>&search=<?= urlencode($search ?? '') ?>">
                                        <?= $totalPages ?>
                                    </a></li>
                                <?php endif; ?>
                                
                                <!-- Nút Next -->
                                <li class="<?= $page >= $totalPages ? 'disabled' : '' ?>">
                                    <a href="<?= BASE_URL ?>admin/product?page=<?= $page + 1 ?>&search=<?= urlencode($search ?? '') ?>" 
                                       aria-label="Next">
                                        <span aria-hidden="true">&raquo;</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    <?php endif; ?>
                </div><!--/content-panel -->
            </div><!-- /col-md-12 -->
        </div>
    </section>
</section>

<?php include_once 'app/views/sharesadmin/footer.php'; ?>