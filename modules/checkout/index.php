<?php require_once '../../init.php'; ?>
<?php 
if (!is_logged_in()) header("Location: http://localhost:3000/auth/login");
if (empty($_SESSION['cart'])) header("Location: http://localhost:3000/cart");

$total = 0;
foreach($_SESSION['cart'] as $item) {
    $total += $item['price'] * $item['quantity'];
}
$base_url = "http://localhost:3000";
?>
<?php require_once '../../includes/header.php'; ?>

<div class="container py-5 min-vh-100">
    <div class="row justify-content-center">
        <div class="col-lg-9">
            <h1 class="text-center mb-5 display-4 fw-bold text-primary">
                Thanh toán đơn hàng
            </h1>

            <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                <div class="card-body p-5">
                    <div class="row g-5">
                        <!-- Form thanh toán -->
                        <div class="col-lg-7">
                            <div class="bg-light p-4 rounded-4 mb-4">
                                <h4 class="mb-4">
                                    Thông tin người nhận
                                </h4>
                                <div class="row g-3">
                                    <div class="col-12">
                                        <label class="form-label">Họ tên</label>
                                        <input type="text" class="form-control form-control-lg bg-white" 
                                               value="<?= htmlspecialchars($_SESSION['user']['fullname'] ?? $_SESSION['user']['username']) ?>" readonly>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Email</label>
                                        <input type="email" class="form-control form-control-lg bg-white" 
                                               value="<?= $_SESSION['user']['email'] ?>" readonly>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Số điện thoại</label>
                                        <input type="text" class="form-control form-control-lg bg-white" 
                                               value="<?= htmlspecialchars($_SESSION['user']['phone'] ?? 'Chưa cập nhật') ?>" readonly>
                                    </div>
                                </div>
                            </div>

                            <h4 class="mb-4">Thanh toán bằng thẻ</h4>
                            <form id="payment-form" action="<?= $base_url ?>/modules/checkout/process.php" method="post">
                                <div class="mb-4">
                                    <label class="form-label fw-bold">Thẻ tín dụng / Thẻ ghi nợ</label>
                                    <div id="card-element" class="form-control p-4 rounded-3 border" style="height:60px;background:white;"></div>
                                    <div id="card-errors" role="alert" class="text-danger mt-2 fw-bold"></div>
                                </div>

                                <button type="submit" id="submit-btn" class="btn btn-success btn-lg w-100 shadow-lg py-3">
                                    <span id="button-text">Thanh toán <?= number_format($total) ?>đ</span>
                                    <span id="spinner" class="spinner-border spinner-border-sm d-none" role="status"></span>
                                </button>
                            </form>
                        </div>

                        <!-- Tóm tắt đơn hàng -->
                        <div class="col-lg-5">
                            <div class="card border-0 shadow-sm h-100">
                                <div class="card-header bg-primary text-white">
                                    <h4 class="mb-0">Tóm tắt đơn hàng</h4>
                                </div>
                                <div class="card-body">
                                    <?php foreach($_SESSION['cart'] as $id => $item): ?>
                                    <div class="d-flex justify-content-between py-2 border-bottom">
                                        <div>
                                            <strong><?= htmlspecialchars($item['title']) ?></strong><br>
                                            <small class="text-muted">× <?= $item['quantity'] ?></small>
                                        </div>
                                        <strong class="text-danger"><?= number_format($item['price'] * $item['quantity']) ?>đ</strong>
                                    </div>
                                    <?php endforeach; ?>
                                    <div class="d-flex justify-content-between mt-4 pt-3 border-top">
                                        <h5 class="fw-bold">Tổng cộng</h5>
                                        <h4 class="text-primary fw-bold"><?= number_format($total) ?>đ</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Stripe JS + Xử lý thanh toán -->
<script src="https://js.stripe.com/v3/"></script>
<script>
// THAY ĐỔI DÒNG NÀY BẰNG PUBLISHABLE KEY CỦA BẠN
const stripe = Stripe('pk_test_51Q9yB9RwXV123456789abcdefgHIJKLMNopqrstUVWXYz'); 

const elements = stripe.elements();
const card = elements.create('card', {
    style: {
        base: {
            fontSize: '18px',
            color: '#424770',
            '::placeholder': { color: '#aab7c4' },
            fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
        },
        invalid: {
            color: '#dc3545',
            iconColor: '#dc3545'
        }
    }
});
card.mount('#card-element');

const form = document.getElementById('payment-form');
const submitBtn = document.getElementById('submit-btn');
const buttonText = document.getElementById('button-text');
const spinner = document.getElementById('spinner');

form.addEventListener('submit', async (event) => {
    event.preventDefault();
    
    submitBtn.disabled = true;
    buttonText.classList.add('d-none');
    spinner.classList.remove('d-none');

    const {paymentMethod, error} = await stripe.createPaymentMethod({
        type: 'card',
        card: card,
    });

    if (error) {
        document.getElementById('card-errors').textContent = error.message;
        submitBtn.disabled = false;
        buttonText.classList.remove('d-none');
        spinner.classList.add('d-none');
    } else {
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'payment_method_id';
        input.value = paymentMethod.id;
        form.appendChild(input);
        form.submit();
    }
});
</script>

<?php require_once '../../includes/footer.php'; ?>