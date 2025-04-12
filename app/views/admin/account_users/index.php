<?php include_once 'app/views/sharesadmin/header.php'; ?>

<section id="main-content">
    <section class="wrapper">
        <h3><i class="fa fa-angle-right"></i> Quản lý tài khoản người dùng</h3>
        
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
                        <h4><i class="fa fa-angle-right"></i> Danh sách người dùng</h4>
                        <div style="gap: 10px;">
                            <form method="GET" action="<?= BASE_URL ?>admin/account_users">
                                <div class="input-group" style="margin-bottom: 10px;">
                                    <input type="text" name="search" class="form-control" 
                                           placeholder="Tìm kiếm theo email hoặc tên" 
                                           value="<?= htmlspecialchars($search ?? '') ?>">
                                    <span class="input-group-btn">
                                        <button class="btn btn-primary" type="submit">
                                            <i class="fa fa-search"></i>
                                        </button>
                                    </span>
                                </div>
                            </form>
                        </div>
                    </div>
                    <hr>
                    <table class="table table-striped table-advance table-hover">
                        <thead>
                            <tr>
                                <th><i class="fa fa-hashtag"></i> ID</th>
                                <th><i class="fa fa-envelope"></i> Email</th>
                                <th><i class="fa fa-user"></i> Họ tên</th>
                                <th><i class="fa fa-phone"></i> Số điện thoại</th>
                                <th><i class="fa fa-toggle-on"></i> Trạng thái</th>
                                <th><i class="fa fa-calendar"></i> Ngày tạo</th>
                                <th><i class="fa fa-cogs"></i> Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($users)): ?>
                                <tr>
                                    <td colspan="7" class="text-center">Không tìm thấy người dùng nào</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($users as $user): ?>
                                <tr>
                                    <td><?= htmlspecialchars($user['user_id']) ?></td>
                                    <td><?= htmlspecialchars($user['email']) ?></td>
                                    <td><?= htmlspecialchars($user['full_name']) ?></td>
                                    <td><?= htmlspecialchars($user['phone_number'] ?? '-') ?></td>
                                    <td>
                                        <span class="label label-<?= $user['is_active'] ? 'success' : 'danger' ?> label-mini">
                                            <?= $user['is_active'] ? 'Kích hoạt' : 'Vô hiệu' ?>
                                        </span>
                                    </td>
                                    <td><?= date('d/m/Y', strtotime($user['created_at'])) ?></td>
                                    <td>
                                        <a href="<?= BASE_URL ?>admin/user/edit/<?= $user['user_id'] ?>" 
                                           class="btn btn-primary btn-xs">
                                            <i class="fa fa-pencil"></i>
                                        </a>
                                        <a href="<?= BASE_URL ?>admin/user/delete/<?= $user['user_id'] ?>" 
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

                    <?php if ($totalPages > 1): ?>
                        <div class="text-center">
                            <ul class="pagination">
                                <li class="<?= $page <= 1 ? 'disabled' : '' ?>">
                                    <a href="<?= BASE_URL ?>admin/account_users?page=<?= $page - 1 ?>&search=<?= urlencode($search ?? '') ?>" 
                                       aria-label="Previous">
                                        <span aria-hidden="true">«</span>
                                    </a>
                                </li>
                                
                                <?php 
                                $startPage = max(1, $page - 2);
                                $endPage = min($totalPages, $page + 2);
                                
                                if ($startPage > 1): ?>
                                    <li><a href="<?= BASE_URL ?>admin/account_users?page=1&search=<?= urlencode($search ?? '') ?>">1</a></li>
                                    <?php if ($startPage > 2): ?>
                                        <li><span>...</span></li>
                                    <?php endif; ?>
                                <?php endif; ?>
                                
                                <?php for ($i = $startPage; $i <= $endPage; $i++): ?>
                                    <li class="<?= $i == $page ? 'active' : '' ?>">
                                        <a href="<?= BASE_URL ?>admin/account_users?page=<?= $i ?>&search=<?= urlencode($search ?? '') ?>">
                                            <?= $i ?>
                                        </a>
                                    </li>
                                <?php endfor; ?>
                                
                                <?php if ($endPage < $totalPages): ?>
                                    <?php if ($endPage < $totalPages - 1): ?>
                                        <li><span>...</span></li>
                                    <?php endif; ?>
                                    <li><a href="<?= BASE_URL ?>admin/account_users?page=<?= $totalPages ?>&search=<?= urlencode($search ?? '') ?>">
                                        <?= $totalPages ?>
                                    </a></li>
                                <?php endif; ?>
                                
                                <li class="<?= $page >= $totalPages ? 'disabled' : '' ?>">
                                    <a href="<?= BASE_URL ?>admin/account_users?page=<?= $page + 1 ?>&search=<?= urlencode($search ?? '') ?>" 
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