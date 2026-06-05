<?php
include 'db.php';
session_start();

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

/*
|--------------------------------------------------------------------------
| ADDRESS
|--------------------------------------------------------------------------
*/
$addressQuery = mysqli_query($conn,"
    SELECT *
    FROM addresses
    WHERE user_id = $user_id
    ORDER BY is_default DESC
");

$addresses = [];

while($row = mysqli_fetch_assoc($addressQuery)){
    $addresses[] = $row;
}

$defaultAddress = $addresses[0] ?? null;

/*
|--------------------------------------------------------------------------
| CART
|--------------------------------------------------------------------------
*/
$cartQuery = mysqli_query($conn,"
    SELECT
        carts.book_id,
        carts.quantity AS cart_quantity,
        books.*
    FROM carts
    JOIN books
        ON books.id = carts.book_id
    WHERE carts.user_id = $user_id
");

$cartBooks = [];

while($row = mysqli_fetch_assoc($cartQuery)){
    $cartBooks[] = $row;
}

if(count($cartBooks) == 0){
    header("Location: cart.php");
    exit();
}

$total = 0;
$shipping = 30000;

foreach($cartBooks as $book){
    $total += $book['price'] * $book['cart_quantity'];
}

$grandTotal = $total + $shipping;
?>

<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<title>Thanh toán</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
<link rel="stylesheet" href="css/order.css">

</head>
<body>

<?php include 'header.php'; ?>

<div class="container py-5">

    <a href="cart.php" class="back-link">
        <i class="bi bi-arrow-left"></i>
        Quay lại giỏ hàng
    </a>

    <h1 class="page-title">
        Thanh toán
    </h1>

    <form action="place_order.php" method="POST">

        <div class="row g-4">

            <!-- LEFT -->
            <div class="col-lg-8">

                <!-- ADDRESS -->
                <div class="checkout-section">

                    <div class="section-header">

                        <div class="section-title">
                            <i class="bi bi-geo-alt"></i>
                            Địa chỉ giao hàng
                        </div>

                        <button
                            type="button"
                            class="change-address-btn"
                            id="toggleAddress"
                        >
                            <i class="bi bi-pencil-square"></i>
                            Thay đổi
                        </button>

                    </div>

                    <?php if($defaultAddress): ?>

                        <input
                            type="hidden"
                            name="address_id"
                            id="selectedAddress"
                            value="<?= $defaultAddress['id'] ?>"
                        >

                        <div class="address-card active" id="currentAddress">

                            <div class="address-name" id="currentAddressName">
                                <?= $defaultAddress['title'] ?>
                            </div>

                            <div class="address-detail" id="currentAddressDetail">
                                <?= $defaultAddress['address'] ?>
                            </div>

                            <div class="address-phone" id="currentAddressPhone">
                                SĐT: <?= $defaultAddress['phone'] ?>
                            </div>

                        </div>

                        <div
                            id="addressList"
                            style="display:none"
                        >

                            <hr>

                            <h5>Chọn địa chỉ khác:</h5>

                            <?php foreach($addresses as $addr): ?>

                                <div
                                    class="address-card selectable-address"
                                    data-id="<?= $addr['id'] ?>"
                                    data-title="<?= htmlspecialchars($addr['title']) ?>"
                                    data-address="<?= htmlspecialchars($addr['address']) ?>"
                                    data-phone="<?= htmlspecialchars($addr['phone']) ?>"
                                >

                                    <div class="address-name">
                                        <?= $addr['title'] ?>
                                    </div>

                                    <div class="address-detail">
                                        <?= $addr['address'] ?>
                                    </div>

                                    <div class="address-phone">
                                        SĐT: <?= $addr['phone'] ?>
                                    </div>

                                </div>

                            <?php endforeach; ?>

                            <a
                                href="user.php?tab=address"
                                class="add-address-btn"
                            >
                                + Thêm địa chỉ mới
                            </a>

                        </div>

                    <?php endif; ?>

                </div>

                <!-- PAYMENT -->
                <div class="checkout-section mt-4">

                    <div class="section-title">
                        <i class="bi bi-credit-card"></i>
                        Phương thức thanh toán
                    </div>

                    <div class="payment-option">

                        <label class="payment-card">

                            <input
                                type="radio"
                                name="payment_method"
                                value="cod"
                                checked
                            >

                            <div class="payment-icon">
                                <i class="bi bi-truck"></i>
                            </div>

                            <div class="payment-content">

                                <div class="payment-title">
                                    Thanh toán khi nhận hàng (COD)
                                </div>

                                <div class="payment-desc">
                                    Thanh toán bằng tiền mặt khi nhận hàng
                                </div>

                            </div>
                            <div class="payment-check">
                                <i class="bi bi-check-circle-fill"></i>
                            </div>        
                        </label>

                    </div>

                    <div class="payment-option">

                        <label class="payment-card">

                            <input
                                type="radio"
                                name="payment_method"
                                value="bank"
                            >

                            <div class="payment-icon bank">
                                <i class="bi bi-bank"></i>
                            </div>

                            <div class="payment-content">

                                <div class="payment-title">
                                    Chuyển khoản ngân hàng
                                </div>

                                <div class="payment-desc">
                                    Thanh toán qua tài khoản ngân hàng
                                </div>

                            </div>

                            <div class="payment-check">
                                <i class="bi bi-check-circle-fill"></i>
                            </div>        
                        </label>

                    </div>

                    <div class="bank-info">

                        <h6>
                            Thông tin chuyển khoản
                        </h6>

                        <p>
                            Ngân hàng: Vietcombank
                        </p>

                        <p>
                            Số tài khoản: 123456789
                        </p>

                        <p>
                            Chủ tài khoản: BOOKSTORE CO., LTD
                        </p>

                        <p>
                            Nội dung:
                            [Họ tên] [Số điện thoại]
                        </p>

                    </div>

                </div>

                <!-- PRODUCTS -->
                <div class="checkout-section mt-4">

                    <div class="section-title">

                        Sản phẩm
                        (<?= count($cartBooks) ?>)

                    </div>

                    <?php foreach($cartBooks as $book): ?>

                    <div class="product-item">

                        <img
                            src="<?= htmlspecialchars($book['image']) ?>"
                            class="product-image"
                            alt=""
                        >

                        <div class="product-info">

                            <h6>
                                <?= htmlspecialchars($book['title']) ?>
                            </h6>

                            <p>
                                Số lượng:
                                <?= $book['cart_quantity'] ?>
                            </p>

                        </div>

                        <div class="product-price">

                            <?= number_format($book['price'] * $book['cart_quantity']) ?>đ

                        </div>

                    </div>

                    <?php endforeach; ?>

                </div>

            </div>

            <!-- RIGHT -->
            <div class="col-lg-4">

                <div class="summary-box">

                    <h3>
                        Tóm tắt đơn hàng
                    </h3>

                    <div class="summary-row">

                        <span>Tạm tính</span>

                        <span>
                            <?= number_format($total) ?>đ
                        </span>

                    </div>

                    <div class="summary-row">

                        <span>Phí vận chuyển</span>

                        <span>
                            <?= number_format($shipping) ?>đ
                        </span>

                    </div>

                    <hr>

                    <div class="summary-total">

                        <span>Tổng cộng</span>

                        <span>
                            <?= number_format($grandTotal) ?>đ
                        </span>

                    </div>

                    <?php if($defaultAddress): ?>

                        <button
                            type="submit"
                            class="place-order-btn"
                        >
                            Đặt hàng
                        </button>
                        <hr>

                        <div class="payment-info-box">

                            <h5>
                                Thông tin thanh toán
                            </h5>

                            <div class="info-row">

                                <i class="bi bi-geo-alt"></i>

                                <div>

                                    <strong>Giao đến:</strong>

                                    <div id="summaryAddress">
                                        <?= $defaultAddress['title'] ?>
                                    </div>

                                </div>

                            </div>

                            <div class="info-row">

                                <i class="bi bi-credit-card"></i>

                                <div>

                                    <strong>Thanh toán:</strong>

                                    <div id="paymentText">
                                        Thanh toán khi nhận hàng
                                    </div>

                                </div>

                            </div>

                        </div>                        

                    <?php else: ?>

                        <button
                            type="button"
                            class="btn btn-secondary w-100"
                            disabled
                        >
                            Vui lòng thêm địa chỉ giao hàng
                        </button>

                    <?php endif; ?>

                </div>

            </div>

        </div>

    </form>

</div>

<script>

const radios =
    document.querySelectorAll(
        'input[name="payment_method"]'
    );

const bankInfo =
    document.querySelector('.bank-info');

function toggleBankInfo(){

    const selected =
        document.querySelector(
            'input[name="payment_method"]:checked'
        ).value;

    if(selected === 'bank'){
        bankInfo.style.display = 'block';
    }else{
        bankInfo.style.display = 'none';
    }
}

radios.forEach(radio => {
    radio.addEventListener(
        'change',
        toggleBankInfo
    );
});

toggleBankInfo();

</script>

</body>
<script>

document
.getElementById('toggleAddress')
.addEventListener('click',()=>{

    const list =
        document.getElementById('addressList');

    list.style.display =
        list.style.display === 'none'
        ? 'block'
        : 'none';
});

document
.querySelectorAll('.selectable-address')
.forEach(item=>{

    item.addEventListener('click',()=>{

        document
        .querySelectorAll('.selectable-address')
        .forEach(card=>{

            card.classList.remove('active');

        });

        item.classList.add('active');

        document
        .getElementById('selectedAddress')
        .value = item.dataset.id;

        // cập nhật card phía trên

        document
        .getElementById('currentAddressName')
        .innerText = item.dataset.title;

        document
        .getElementById('currentAddressDetail')
        .innerText = item.dataset.address;

        document
        .getElementById('currentAddressPhone')
        .innerText = 'SĐT: ' + item.dataset.phone;

        // cập nhật phần tóm tắt đơn hàng

        document
        .getElementById('summaryAddress')
        .innerText = item.dataset.title;

        document
        .getElementById('addressList')
        .style.display = 'none';

    }); 

});

const paymentText =
document.getElementById('paymentText');

document
.querySelectorAll(
'input[name="payment_method"]'
)
.forEach(r=>{

    r.addEventListener('change',()=>{

        if(r.value === 'cod'){

            paymentText.innerHTML =
            'Thanh toán khi nhận hàng';

        }else{

            paymentText.innerHTML =
            'Chuyển khoản ngân hàng';

        }

    });

});

function updatePaymentCards(){

    document
    .querySelectorAll('.payment-card')
    .forEach(card=>{

        card.classList.remove('active');

        if(card.querySelector('input').checked){

            card.classList.add('active');

        }

    });

}

document
.querySelectorAll(
'input[name="payment_method"]'
)
.forEach(r=>{

    r.addEventListener(
        'change',
        updatePaymentCards
    );

});

updatePaymentCards();

</script>
</html>