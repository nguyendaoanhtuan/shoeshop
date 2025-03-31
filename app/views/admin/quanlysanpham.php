<?php include_once 'app/views/sharesadmin/header.php'; ?>

<section id="main-content">
    <section class="wrapper">
        <h3><i class="fa fa-angle-right"></i>Sản phẩm</h3>

        <!-- Hiển thị thông báo -->
        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success">
                <?= $_SESSION['success'] ?>
                <?php unset($_SESSION['success']); ?>
            </div>
        <?php endif; ?>
        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger">
                <?= $_SESSION['error'] ?>
                <?php unset($_SESSION['error']); ?>
            </div>
        <?php endif; ?>

        <div class="row mt">
            <div class="col-md-12 mt">
                <div class="content-panel">
                    <table class="table table-hover">
                        <div style="justify-content: space-between; align-items: center;">
                            <h4><i class="fa fa-angle-right"></i> Danh sách sản phẩm</h4>
                            <a href="?controller=product&action=create" class="btn btn-primary">
                                <i class="fa fa-plus"></i> Thêm sản phẩm
                            </a>
                        </div>
                        <hr>
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
                        <?php foreach ($products as $product): ?>
                        <tr>
                            <td><?= $product->product_id ?></td>
                            <td><?= $product->name ?></td>
                            <td><?= $product->category_name ?></td>
                            <td><?= $product->brand_name ?? 'N/A' ?></td>
                            <td><?= number_format($product->price, 0, ',', '.') ?> đ</td>
                            <td><?= $product->discount_price ? number_format($product->discount_price, 0, ',', '.') . ' đ' : 'N/A' ?></td>
                            <td><?= $product->stock_quantity ?></td>
                            <td>
                                <span class="label label-<?= $product->is_active ? 'success' : 'danger' ?>">
                                    <?= $product->is_active ? 'Active' : 'Inactive' ?>
                                </span>
                                <?php if ($product->is_featured): ?>
                                    <span class="label label-warning">Featured</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <a href="?controller=product&action=edit&id=<?= $product->product_id ?>" 
                                   class="btn btn-primary btn-xs">
                                   <i class="fa fa-pencil"></i>
                                </a>
                                <a href="?controller=product&action=delete&id=<?= $product->product_id ?>" 
                                   class="btn btn-danger btn-xs" 
                                   onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này?')">
                                   <i class="fa fa-trash-o"></i>
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div><!--/content-panel -->
            </div><!-- /col-md-12 -->
        </div>
    </section>
</section>

<?php include_once 'app/views/sharesadmin/footer.php'; ?>