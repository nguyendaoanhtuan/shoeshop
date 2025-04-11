<?php include_once 'app/views/sharesadmin/header.php'; ?>

<section id="main-content">
    <section class="wrapper">
        <h3><i class="fa fa-angle-right"></i> Quản lý thương hiệu</h3>
        
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
                        <h4><i class="fa fa-angle-right"></i> Danh sách thương hiệu</h4>
                        <div style="gap: 10px;">
                            <!-- Form tìm kiếm -->
                            <form method="GET" action="<?= BASE_URL ?>admin/brands">
                                <div class="input-group" style="margin-bottom: 10px;">
                                    <input type="text" name="search" class="form-control" 
                                           placeholder="Tìm kiếm theo tên thương hiệu" 
                                           value="<?= htmlspecialchars($search ?? '') ?>">
                                    <span class="input-group-btn">
                                        <button class="btn btn-primary" type="submit">
                                            <i class="fa fa-search"></i>
                                        </button>
                                    </span>
                                </div>
                            </form>
                            <a href="<?= BASE_URL ?>admin/brands/create" class="btn btn-primary">
                                <i class="fa fa-plus"></i> Thêm thương hiệu
                            </a>
                        </div>
                    </div>
                    <hr>
                    <table class="table table-striped table-advance table-hover">
                        <thead>
                            <tr>
                                <th><i class="fa fa-hashtag"></i> ID</th>
                                <th><i class="fa fa-bullhorn"></i> Tên thương hiệu</th>
                                <th><i class="fa fa-link"></i> Slug</th>
                                <th><i class="fa fa-image"></i> Logo</th>
                                <th><i class="fa fa-toggle-on"></i> Trạng thái</th>
                                <th><i class="fa fa-calendar"></i> Ngày tạo</th>
                                <th><i class="fa fa-cogs"></i> Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($brands)): ?>
                                <tr>
                                    <td colspan="7" class="text-center">Không tìm thấy thương hiệu nào</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($brands as $brand): ?>
                                <tr>
                                    <td><?= htmlspecialchars($brand['brand_id']) ?></td>
                                    <td><?= htmlspecialchars($brand['name']) ?></td>
                                    <td><?= htmlspecialchars($brand['slug']) ?></td>
                                    <td>
                                        <?php if ($brand['logo_url']): ?>
                                            <img src="<?= BASE_URL ?>public/<?= htmlspecialchars($brand['logo_url']) ?>" width="50" alt="<?= htmlspecialchars($brand['name']) ?>">
                                        <?php else: ?>
                                            Không có
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <span class="label label-<?= $brand['is_active'] ? 'success' : 'danger' ?> label-mini">
                                            <?= $brand['is_active'] ? 'Kích hoạt' : 'Vô hiệu' ?>
                                        </span>
                                    </td>
                                    <td><?= date('d/m/Y', strtotime($brand['created_at'])) ?></td>
                                    <td>
                                        <a href="<?= BASE_URL ?>admin/brands/edit/<?= $brand['brand_id'] ?>" 
                                           class="btn btn-primary btn-xs">
                                            <i class="fa fa-pencil"></i>
                                        </a>
                                        <a href="<?= BASE_URL ?>admin/brands/delete/<?= $brand['brand_id'] ?>" 
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
                                    <a href="<?= BASE_URL ?>admin/brands?page=<?= $page - 1 ?>&search=<?= urlencode($search ?? '') ?>" 
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
                                    <li><a href="<?= BASE_URL ?>admin/brands?page=1&search=<?= urlencode($search ?? '') ?>">1</a></li>
                                    <?php if ($startPage > 2): ?>
                                        <li><span>...</span></li>
                                    <?php endif; ?>
                                <?php endif; ?>
                                
                                <?php for ($i = $startPage; $i <= $endPage; $i++): ?>
                                    <li class="<?= $i == $page ? 'active' : '' ?>">
                                        <a href="<?= BASE_URL ?>admin/brands?page=<?= $i ?>&search=<?= urlencode($search ?? '') ?>">
                                            <?= $i ?>
                                        </a>
                                    </li>
                                <?php endfor; ?>
                                
                                <!-- Hiển thị dấu ba chấm bên phải -->
                                <?php if ($endPage < $totalPages): ?>
                                    <?php if ($endPage < $totalPages - 1): ?>
                                        <li><span>...</span></li>
                                    <?php endif; ?>
                                    <li><a href="<?= BASE_URL ?>admin/brands?page=<?= $totalPages ?>&search=<?= urlencode($search ?? '') ?>">
                                        <?= $totalPages ?>
                                    </a></li>
                                <?php endif; ?>
                                
                                <!-- Nút Next -->
                                <li class="<?= $page >= $totalPages ? 'disabled' : '' ?>">
                                    <a href="<?= BASE_URL ?>admin/brands?page=<?= $page + 1 ?>&search=<?= urlencode($search ?? '') ?>" 
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