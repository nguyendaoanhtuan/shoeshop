<?php include_once 'app/views/sharesadmin/header.php'; ?>

<section id="main-content">
    <section class="wrapper">
        <h3><i class="fa fa-angle-right"></i> Quản lý danh mục</h3>
        
        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <?= $_SESSION['success']; unset($_SESSION['success']); ?>
            </div>
        <?php endif; ?>
        
        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <?= $_SESSION['error']; unset($_SESSION['error']); ?>
            </div>
        <?php endif; ?>
        
        <div class="row mt">
            <div class="col-md-12">
                <div class="content-panel">
                    <div style=" justify-content: space-between; align-items: center;">
                        <h4><i class="fa fa-angle-right"></i> Danh sách danh mục</h4>
                        <a href="?controller=category&action=create" class="btn btn-primary">
                            <i class="fa fa-plus"></i> Thêm danh mục
                        </a>
                    </div>
                    <hr>
                    <table class="table table-striped table-advance table-hover">
                        <thead>
                            <tr>
                                <th><i class="fa fa-bullhorn"></i> Tên danh mục</th>
                                <th><i class="fa fa-link"></i> Slug</th>
                                <th><i class="fa fa-sitemap"></i> Loại</th>
                                <th><i class="fa fa-toggle-on"></i> Trạng thái</th>
                                <th><i class="fa fa-calendar"></i> Ngày tạo</th>
                                <th><i class="fa fa-cogs"></i> Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($categories as $category): ?>
                            <tr>
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
                                    <a href="?controller=category&action=edit&id=<?= $category['category_id'] ?>" 
                                       class="btn btn-primary btn-xs">
                                        <i class="fa fa-pencil"></i>
                                    </a>
                                    <a href="?controller=category&action=delete&id=<?= $category['category_id'] ?>" 
                                       class="btn btn-danger btn-xs" 
                                       onclick="return confirm('Bạn có chắc chắn muốn xóa?')">
                                        <i class="fa fa-trash-o"></i>
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
</section>

<?php include_once 'app/views/sharesadmin/footer.php'; ?>