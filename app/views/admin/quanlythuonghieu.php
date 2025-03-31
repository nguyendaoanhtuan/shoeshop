<?php include_once 'app/views/sharesadmin/header.php'; ?>

<section id="main-content">
    <section class="wrapper">
        <h3><i class="fa fa-angle-right"></i> Quản lý thương hiệu</h3>
        
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
                    <div style="justify-content: space-between; align-items: center;">
                        <h4><i class="fa fa-angle-right"></i> Danh sách thương hiệu</h4>
                        <a href="?controller=brands&action=create" class="btn btn-primary">
                            <i class="fa fa-plus"></i> Thêm thương hiệu
                        </a>
                    </div>
                    <hr>
                    <table class="table table-striped table-advance table-hover">
                        <thead>
                            <tr>
                                <th><i class="fa fa-bullhorn"></i> Tên thương hiệu</th>
                                <th><i class="fa fa-link"></i> Slug</th>
                                <th><i class="fa fa-image"></i> Logo</th>
                                <th><i class="fa fa-toggle-on"></i> Trạng thái</th>
                                <th><i class="fa fa-calendar"></i> Ngày tạo</th>
                                <th><i class="fa fa-cogs"></i> Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($brands as $brand): ?>
                            <tr>
                                <td><?= htmlspecialchars($brand['name']) ?></td>
                                <td><?= htmlspecialchars($brand['slug']) ?></td>
                                <td>
                                <?php if ($brand['logo_url']): ?>
                                        <img src="public/<?= $brand['logo_url'] ?>" width="50">
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
                                    <a href="?controller=brands&action=edit&id=<?= $brand['brand_id'] ?>" 
                                       class="btn btn-primary btn-xs">
                                        <i class="fa fa-pencil"></i>
                                    </a>
                                    <a href="?controller=brands&action=delete&id=<?= $brand['brand_id'] ?>" 
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