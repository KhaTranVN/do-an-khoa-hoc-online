<?php require_once '../includes/header.php'; ?>

<?php
// Hiển thị thông báo
if (isset($_SESSION['success'])) {
    echo '<div class="alert alert-success alert-dismissible fade show">
            <i class="fas fa-check-circle"></i> ' . $_SESSION['success'] . '
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
          </div>';
    unset($_SESSION['success']);
}
if (isset($_SESSION['error'])) {
    echo '<div class="alert alert-danger alert-dismissible fade show">
            <i class="fas fa-exclamation-triangle"></i> ' . $_SESSION['error'] . '
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
          </div>';
    unset($_SESSION['error']);
}

// Lấy danh sách người dùng
$stmt = $pdo->query("SELECT * FROM users ORDER BY id DESC");
$users = $stmt->fetchAll();
?>

<div class="container-fluid">
    <h2 class="mb-4"><i class="fas fa-users"></i> Quản lý Người dùng (<?= count($users) ?> người)</h2>

    <div class="card border-0 shadow-lg">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0 align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th width="60">ID</th>
                            <th width="80">Avatar</th>
                            <th>Họ tên / Username</th>
                            <th>Email</th>
                            <th width="100">Quyền</th>
                            <th width="140">Ngày đăng ký</th>
                            <th width="110">Trạng thái</th>
                            <th width="200">Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($users as $u): ?>
                        <tr>
                            <td><strong>#<?= $u['id'] ?></strong></td>
                            <td>
                                <div class="rounded-circle overflow-hidden" style="width:50px;height:50px;">
                                    <?php if(!empty($u['avatar'])): ?>
                                        <img src="../../<?= $u['avatar'] ?>" class="w-100 h-100" style="object-fit:cover;">
                                    <?php else: ?>
                                        <div class="bg-primary text-white d-flex align-items-center justify-content-center w-100 h-100">
                                            <i class="fas fa-user fa-xl"></i>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </td>
                            <td>
                                <div class="fw-bold"><?= htmlspecialchars($u['username']) ?></div>
                                <?php if(!empty($u['fullname'])): ?>
                                    <small class="text-muted"><?= htmlspecialchars($u['fullname']) ?></small>
                                <?php endif; ?>
                            </td>
                            <td><?= htmlspecialchars($u['email']) ?></td>
                            <td>
                                <?php if($u['role'] == 'admin'): ?>
                                    <span class="badge bg-danger fs-6">ADMIN</span>
                                <?php else: ?>
                                    <span class="badge bg-success fs-6">USER</span>
                                <?php endif; ?>
                            </td>
                            <td class="small"><?= date('d/m/Y H:i', strtotime($u['created_at'])) ?></td>
                            <td>
                                <?php if($u['is_active'] == 1): ?>
                                    <span class="badge bg-success">HOẠT ĐỘNG</span>
                                <?php else: ?>
                                    <span class="badge bg-secondary">BỊ KHÓA</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <!-- SỬA THÔNG TIN -->
                                    <a href="edit.php?id=<?= $u['id'] ?>" class="btn btn-warning btn-sm" title="Sửa thông tin">
                                        <i class="fas fa-edit"></i> Sửa
                                    </a>

                                    <!-- ĐỔI QUYỀN ADMIN / USER -->
                                    <a href="toggle_role.php?id=<?= $u['id'] ?>" class="btn btn-info btn-sm text-white" title="Đổi quyền <?= $u['role'] == 'admin' ? 'User' : 'Admin' ?>">
                                        <i class="fas fa-exchange-alt"></i> 
                                        <?= $u['role'] == 'admin' ? 'Hạ quyền' : 'Nâng quyền' ?>
                                    </a>

                                    <!-- KHÓA / MỞ KHÓA TÀI KHOẢN -->
                                    <a href="toggle_status.php?id=<?= $u['id'] ?>" 
                                       class="btn <?= $u['is_active'] ? 'btn-secondary' : 'btn-success' ?> btn-sm" 
                                       title="<?= $u['is_active'] ? 'Khóa tài khoản' : 'Mở khóa tài khoản' ?>">
                                        <i class="fas fa-lock<?= $u['is_active'] ? '' : '-open' ?>"></i>
                                        <?= $u['is_active'] ? 'Khóa' : 'Mở khóa' ?>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php require_once '../includes/footer.php'; ?>