<?php include_once 'app/views/sharesadmin/header.php'; ?>

<section id="main-content">
    <section class="wrapper">
        <h3><i class="fa fa-angle-right"></i> Quản lý hình ảnh sản phẩm</h3>
        
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
                    <div style=" justify-content: space-between; align-items: center; margin-bottom: 20px;">
                        <h4><i class="fa fa-angle-right"></i> Danh sách hình ảnh sản phẩm</h4>
                        <div style=" gap: 10px;">
                            <!-- Form tìm kiếm -->
                            <form method="GET" action="<?= BASE_URL ?>admin/ProductImg/index">
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
                            <a href="<?= BASE_URL ?>admin/ProductImg/create" class="btn btn-primary">
                                <i class="fa fa-plus"></i> Thêm hình ảnh
                            </a>
                        </div>
                    </div>
                    <hr>
                    <table class="table table-striped table-advance table-hover">
                        <thead>
                            <tr>
                                <th><i class="fa fa-hashtag"></i> ID</th>
                                <th><i class="fa fa-cube"></i> Sản phẩm</th>
                                <th><i class="fa fa-image"></i> Hình ảnh</th>
                                <th><i class="fa fa-link"></i> URL</th>
                                <th><i class="fa fa-star"></i> Chính</th>
                                <th><i class="fa fa-sort"></i> Thứ tự</th>
                                <th><i class="fa fa-cogs"></i> Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($images)): ?>
                                <tr>
                                    <td colspan="7" class="text-center">Chưa có hình ảnh nào</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($images as $image): ?>
                                <tr>
                                    <td><?= htmlspecialchars($image['image_id']) ?></td>
                                    <td><?= htmlspecialchars($image['product_name']) ?> (ID: <?= $image['product_id'] ?>)</td>
                                    <td>
                                        <img src="<?= BASE_URL ?>public/<?= htmlspecialchars($image['image_url']) ?>" width="50" alt="Product Image">
                                    </td>
                                    <td><?= htmlspecialchars($image['image_url']) ?></td>
                                    <td>
                                        <span class="label label-<?= $image['is_primary'] ? 'success' : 'default' ?> label-mini">
                                            <?= $image['is_primary'] ? 'Có' : 'Không' ?>
                                        </span>
                                    </td>
                                    <td><?= htmlspecialchars($image['display_order']) ?></td>
                                    <td>
                                        <a href="<?= BASE_URL ?>admin/ProductImg/edit?image_id=<?= $image['image_id'] ?>" 
                                           class="btn btn-primary btn-xs">
                                            <i class="fa fa-pencil"></i>
                                        </a>
                                        <a href="<?= BASE_URL ?>admin/ProductImg/delete?image_id=<?= $image['image_id'] ?>" 
                                           class="btn btn-danger btn-xs" 
                                           onclick="return confirm('Bạn có chắc chắn muốn xóa?')">
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
                                    <a href="<?= BASE_URL ?>admin/ProductImg/index?page=<?= $page - 1 ?>&search=<?= urlencode($search ?? '') ?>" 
                                       aria-label="Previous">
                                        <span aria-hidden="true">«</span>
                                    </a>
                                </li>
                                
                                <!-- Các trang -->
                                <?php 
                                $startPage = max(1, $page - 2);
                                $endPage = min($totalPages, $page + 2);
                                
                                // Hiển thị dấu ba chấm bên trái
                                if ($startPage > 1): ?>
                                    <li><a href="<?= BASE_URL ?>admin/ProductImg/index?page=1&search=<?= urlencode($search ?? '') ?>">1</a></li>
                                    <?php if ($startPage > 2): ?>
                                        <li><span>...</span></li>
                                    <?php endif; ?>
                                <?php endif; ?>
                                
                                <?php for ($i = $startPage; $i <= $endPage; $i++): ?>
                                    <li class="<?= $i == $page ? 'active' : '' ?>">
                                        <a href="<?= BASE_URL ?>admin/ProductImg/index?page=<?= $i ?>&search=<?= urlencode($search ?? '') ?>">
                                            <?= $i ?>
                                        </a>
                                    </li>
                                <?php endfor; ?>
                                
                                <!-- Hiển thị dấu ba chấm bên phải -->
                                <?php if ($endPage < $totalPages): ?>
                                    <?php if ($endPage < $totalPages - 1): ?>
                                        <li><span>...</span></li>
                                    <?php endif; ?>
                                    <li><a href="<?= BASE_URL ?>admin/ProductImg/index?page=<?= $totalPages ?>&search=<?= urlencode($search ?? '') ?>">
                                        <?= $totalPages ?>
                                    </a></li>
                                <?php endif; ?>
                                
                                <!-- Nút Next -->
                                <li class="<?= $page >= $totalPages ? 'disabled' : '' ?>">
                                    <a href="<?= BASE_URL ?>admin/ProductImg/index?page=<?= $page + 1 ?>&search=<?= urlencode($search ?? '') ?>" 
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