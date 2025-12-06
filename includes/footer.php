</div> <!-- .main-content -->

<!-- Footer -->
<footer class="bg-dark text-white py-5 mt-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-4">
                <h5><i class="fas fa-graduation-cap text-warning"></i> KHÓA HỌC ONLINE PRO</h5>
                <p>Học lập trình – Thiết kế – Marketing online cùng giảng viên hàng đầu Việt Nam!</p>
            </div>
            <div class="col-lg-4">
                <h5>Liên kết nhanh</h5>
                <ul class="list-unstyled">
                    <li><a href="<?= $base_url ?>/" class="text-white">Trang chủ</a></li>
                    <li><a href="<?= $base_url ?>/modules/courses" class="text-white">Khóa học</a></li>
                    <li><a href="<?= $base_url ?>/modules/news" class="text-white">Tin tức</a></li>
                </ul>
            </div>
            <div class="col-lg-4">
                <h5>Liên hệ</h5>
                <p><i class="fas fa-envelope"></i> support@khoahoconline.pro</p>
                <p><i class="fas fa-phone"></i> 1900 1234</p>
            </div>
        </div>
        <hr>
        <div class="text-center">
            <p>&copy; <?= date('Y') ?> Khóa Học Online Pro Made By Kha Trần. All rights reserved.</p>
        </div>
    </div>
</footer>

<!-- Bootstrap Bundle JS (bao gồm Popper) – BẮT BUỘC ĐỂ MENU MỞ ĐƯỢC -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- jQuery (nếu cần) -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<!-- Custom JS (nếu có) -->
<?php if(file_exists(__DIR__ . '/assets/js/custom.js')): ?>
    <script src="<?= $base_url ?>/assets/js/custom.js"></script>
<?php endif; ?>

</body>
</html>