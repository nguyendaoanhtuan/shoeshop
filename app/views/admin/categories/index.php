<?php include_once 'app/views/sharesadmin/header.php'; ?>

<section id="main-content">
    <section class="wrapper">
        <h3><i class="fa fa-angle-right"></i> Quản lý danh mục</h3>
        
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
                        <h4><i class="fa fa-angle-right"></i> Danh sách danh mục</h4>
                        <div style="gap: 10px;">
                            <!-- Form tìm kiếm -->
                            <form method="GET" action="<?= BASE_URL ?>admin/category">
                                <div class="input-group" style="margin-bottom: 10px;">
                                    <input type="text" name="search" class="form-control" 
                                           placeholder="Tìm kiếm theo tên danh mục" 
                                           value="<?= htmlspecialchars($search ?? '') ?>">
                                    <span class="input-group-btn">
                                        <button class="btn btn-primary" type="submit">
                                            <i class="fa fa-search"></i>
                                        </button>
                                    </span>
                                </div>
                            </form>
                            <a href="<?= BASE_URL ?>admin/category/create" class="btn btn-primary">
                                <i class="fa fa-plus"></i> Thêm danh mục
                            </a>
                        </div>
                    </div>
                    <hr>
                    <table class="table table-striped table-advance table-hover">
                        <thead>
                            <tr>
                                <th><i class="fa fa-hashtag"></i> ID</th>
                                <th><i class="fa fa-bullhorn"></i> Tên danh mục</th>
                                <th><i class="fa fa-link"></i> Slug</th>
                                <th><i class="fa fa-sitemap"></i> Loại</th>
                                <th><i class="fa fa-toggle-on"></i> Trạng thái</th>
                                <th><i class="fa fa-calendar"></i> Ngày tạo</th>
                                <th><i class="fa fa-cogs"></i> Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($categories)): ?>
                                <tr>
                                    <td colspan="7" class="text-center">Không tìm thấy danh mục nào</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($categories as $category): ?>
                                <tr>
                                    <td><?= htmlspecialchars($category['category_id']) ?></td>
                                    <td><?= htmlspecialchars($category['name']) ?></td>
                                    <td><?= htmlspecialchars($category['slug']) ?></td>
                                    <td>
                                        <?php 
                                        if ($category['parent_id'] == 1) {
                                            echo 'Nam';
                                        } elseif ($category['parent_id'] == 2) {
                                            echo 'Nữ';
                                        } else {
                                            echo 'Không có';
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <span class="label label-<?= $category['is_active'] ? 'success' : 'danger' ?> label-mini">
                                            <?= $category['is_active'] ? 'Kích hoạt' : 'Vô hiệu' ?>
                                        </span>
                                    </td>
                                    <td><?= date('d/m/Y', strtotime($category['created_at'])) ?></td>
                                    <td>
                                        <a href="<?= BASE_URL ?>admin/category/edit/<?= $category['category_id'] ?>" 
                                           class="btn btn-primary btn-xs">
                                            <i class="fa fa-pencil"></i>
                                        </a>
                                        <a href="<?= BASE_URL ?>admin/category/delete/<?= $category['category_id'] ?>" 
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
                                    <a href="<?= BASE_URL ?>admin/category?page=<?= $page - 1 ?>&search=<?= urlencode($search ?? '') ?>" 
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
                                    <li><a href="<?= BASE_URL ?>admin/category?page=1&search=<?= urlencode($search ?? '') ?>">1</a></li>
                                    <?php if ($startPage > 2): ?>
                                        <li><span>...</span></li>
                                    <?php endif; ?>
                                <?php endif; ?>
                                
                                <?php for ($i = $startPage; $i <= $endPage; $i++): ?>
                                    <li class="<?= $i == $page ? 'active' : '' ?>">
                                        <a href="<?= BASE_URL ?>admin/category?page=<?= $i ?>&search=<?= urlencode($search ?? '') ?>">
                                            <?= $i ?>
                                        </a>
                                    </li>
                                <?php endfor; ?>
                                
                                <!-- Hiển thị dấu ba chấm bên phải -->
                                <?php if ($endPage < $totalPages): ?>
                                    <?php if ($endPage < $totalPages - 1): ?>
                                        <li><span>...</span></li>
                                    <?php endif; ?>
                                    <li><a href="<?= BASE_URL ?>admin/category?page=<?= $totalPages ?>&search=<?= urlencode($search ?? '') ?>">
                                        <?= $totalPages ?>
                                    </a></li>
                                <?php endif; ?>
                                
                                <!-- Nút Next -->
                                <li class="<?= $page >= $totalPages ? 'disabled' : '' ?>">
                                    <a href="<?= BASE_URL ?>admin/category?page=<?= $page + 1 ?>&search=<?= urlencode($search ?? '') ?>" 
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