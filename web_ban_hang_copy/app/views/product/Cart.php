<?php include 'app/views/shares/header.php'; ?>

<div class="container mt-4">
    <div class="row">
        <div class="col-12">
            <h1 class="text-center mb-4">Giỏ hàng</h1>
        </div>
    </div>

    <?php
    $totalPrice = 0;
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }
    ?>

    <?php if (!empty($cart)): ?>
        <div class="row">
            <?php foreach ($cart as $id => $item): ?>
                <?php
                $itemTotal = $item['price'] * $item['quantity'];
                $totalPrice += $itemTotal;
                ?>
                <div class="col-md-4 mb-4">
                    <div class="card product-card">
                        <h5 class="card-header"><?php echo htmlspecialchars($item['name'], ENT_QUOTES, 'UTF-8'); ?></h5>
                        <div class="card-body">
                            <?php if ($item['image']): ?>
                                <div class="product-image-container">
                                    <img src="/web_ban_hang_copy/<?php echo $item['image']; ?>" alt="Product Image" class="product-image">
                                </div>
                            <?php endif; ?>
                            
                            <div class="product-details">
                                <p class="product-price">Giá: <span class="price-value"><?php echo number_format($item['price'], 0, ',', '.'); ?> USD</span></p>
                                
                                <div class="quantity-control">
                                    <label for="quantity<?php echo $id; ?>" class="form-label">Số lượng:</label>
                                    <div class="input-group">
                                        <button type="button" class="btn btn-outline-secondary quantity-btn" onclick="decrementQuantity(<?php echo $id; ?>)">-</button>
                                        <input type="number" id="quantity<?php echo $id; ?>" name="quantity" class="form-control quantity-input" style="border-radius: 20px;"
                                            value="<?php echo $item['quantity']; ?>" min="1" required
                                            data-price="<?php echo $item['price']; ?>" data-id="<?php echo $id; ?>">
                                        <button type="button" class="btn btn-outline-secondary quantity-btn" onclick="incrementQuantity(<?php echo $id; ?>)">+</button>
                                    </div>
                                </div>
                                
                                <div class="item-total mt-2">
                                    Thành tiền: <span class="item-total-value" id="itemTotal<?php echo $id; ?>">
                                        <?php echo number_format($itemTotal, 0, ',', '.'); ?> USD
                                    </span>
                                </div>
                                
                                <div class="action-buttons mt-3">
                                    <button class="btn btn-update" onclick="updateQuantity(event, <?php echo $id; ?>)">
                                        <i class="fas fa-sync-alt"></i> Cập nhật
                                    </button>
                                    <a href="/web_ban_hang_copy/Product/deleteItem/<?php echo $id; ?>" class="btn btn-delete"
                                        onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này?');">
                                        <i class="fas fa-trash"></i> Xóa
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        
        <div class="row">
            <div class="col-12">
                <div class="cart-summary">
                    <div class="d-flex justify-content-between align-items-center">
                        <a href="/web_ban_hang_copy/Product" class="btn btn-continue">
                            <i class="fas fa-arrow-left"></i> Tiếp tục mua sắm
                        </a>
                        <div class="total-price">
                            <strong>Tổng Tiền:</strong>
                            <span id="totalPrice"><?php echo number_format($totalPrice, 0, ',', '.'); ?></span> USD
                        </div>
                        <a href="/web_ban_hang_copy/Product/Checkout" class="btn btn-checkout">
                            Thanh Toán <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    <?php else: ?>
        <div class="row">
            <div class="col-12">
                <div class="empty-cart">
                    <i class="fas fa-shopping-cart fa-4x"></i>
                    <p>Giỏ hàng của bạn đang trống.</p>
                    <a href="/web_ban_hang_copy/Product" class="btn btn-continue mt-3">
                        <i class="fas fa-arrow-left"></i> Tiếp tục mua sắm
                    </a>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>

<?php include 'app/views/shares/footer.php'; ?>

<style>
    .product-card {
        border-radius: 15px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        height: 100%;
        transition: transform 0.2s;
    }
    
    .product-card:hover {
        transform: translateY(-5px);
    }
    
    .card-header {
        background-color: #f8f9fa;
        border-radius: 15px 15px 0 0 !important;
        font-weight: bold;
    }
    
    .product-image-container {
        text-align: center;
        margin-bottom: 15px;
    }
    
    .product-image {
        max-width: 100%;
        height: auto;
        border-radius: 10px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }
    
    .product-price {
        font-size: 18px;
        margin-bottom: 15px;
    }
    
    .price-value {
        font-weight: bold;
        color: #2c3e50;
    }
    
    .quantity-control {
        margin-bottom: 15px;
    }
    
    .quantity-input {
        text-align: center;
    }
    
    .item-total {
        font-size: 16px;
        font-weight: bold;
        color: #2c3e50;
    }
    
    .action-buttons {
        display: flex;
        justify-content: space-between;
    }
    
    .btn-update {
        background-color: #3498db;
        color: white;
        border-radius: 20px;
        padding: 8px 15px;
        flex: 1;
        margin-right: 10px;
        transition: background-color 0.3s;
    }
    
    .btn-update:hover {
        background-color: #2980b9;
    }
    
    .btn-delete {
        background-color: #e74c3c;
        color: white;
        border-radius: 20px;
        padding: 8px 15px;
        flex: 1;
        transition: background-color 0.3s;
    }
    
    .btn-delete:hover {
        background-color: #c0392b;
    }
    
    .quantity-btn {
        border-radius: 50%;
        width: 38px;
        height: 38px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
    }
    
    .cart-summary {
        background-color: #f8f9fa;
        border-radius: 15px;
        padding: 20px;
        margin-top: 20px;
        margin-bottom: 30px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }
    
    .total-price {
        font-size: 24px;
        color: #2c3e50;
    }
    
    .btn-continue {
        background-color: #7f8c8d;
        color: white;
        border-radius: 20px;
        padding: 10px 20px;
        transition: background-color 0.3s;
    }
    
    .btn-continue:hover {
        background-color: #636e72;
    }
    
    .btn-checkout {
        background-color: #27ae60;
        color: white;
        border-radius: 20px;
        padding: 10px 20px;
        transition: background-color 0.3s;
    }
    
    .btn-checkout:hover {
        background-color: #2ecc71;
    }
    
    .empty-cart {
        text-align: center;
        padding: 50px 0;
        color: #7f8c8d;
    }
</style>

<script>
    function formatCurrency(amount) {
        return new Intl.NumberFormat('vi-VN').format(amount);
    }
    
    function incrementQuantity(productId) {
        const quantityInput = document.getElementById("quantity" + productId);
        quantityInput.value = parseInt(quantityInput.value) + 1;
        updateItemTotal(productId);
    }
    
    function decrementQuantity(productId) {
        const quantityInput = document.getElementById("quantity" + productId);
        if (parseInt(quantityInput.value) > 1) {
            quantityInput.value = parseInt(quantityInput.value) - 1;
            updateItemTotal(productId);
        }
    }
    
    function updateItemTotal(productId) {
        const quantityInput = document.getElementById("quantity" + productId);
        const price = parseFloat(quantityInput.getAttribute("data-price"));
        const quantity = parseInt(quantityInput.value);
        const itemTotal = price * quantity;
        
        document.getElementById("itemTotal" + productId).innerText = formatCurrency(itemTotal) + " VND";
    }
    
    function updateQuantity(event, productId) {
        event.preventDefault();
        
        const quantityInput = document.getElementById("quantity" + productId);
        const quantity = quantityInput.value;
        
        fetch("/web_ban_hang_copy/Product/updateQuantity/" + productId, {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded"
            },
            body: "quantity=" + quantity
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Update the total price
                document.getElementById("totalPrice").innerText = formatCurrency(data.totalPrice);
                
                // Show success notification
                showNotification("Cập nhật số lượng thành công!", "success");
            } else {
                showNotification("Có lỗi xảy ra khi cập nhật số lượng!", "error");
            }
        })
        .catch(error => {
            console.error("Error:", error);
            showNotification("Có lỗi xảy ra khi cập nhật số lượng!", "error");
        });
    }
    
    function showNotification(message, type) {
        // Create notification element
        const notification = document.createElement("div");
        notification.className = "notification " + type;
        notification.innerHTML = message;
        
        // Add to body
        document.body.appendChild(notification);
        
        // Show notification
        setTimeout(() => {
            notification.className += " show";
        }, 100);
        
        // Remove after 3 seconds
        setTimeout(() => {
            notification.className = notification.className.replace(" show", "");
            setTimeout(() => {
                document.body.removeChild(notification);
            }, 500);
        }, 3000);
    }
    
    // Add event listeners to quantity inputs
    document.addEventListener("DOMContentLoaded", function() {
        const quantityInputs = document.querySelectorAll(".quantity-input");
        quantityInputs.forEach(input => {
            input.addEventListener("change", function() {
                const productId = this.getAttribute("data-id");
                updateItemTotal(productId);
            });
        });
    });
</script>

<style>
    /* Notification styles */
    .notification {
        position: fixed;
        top: 20px;
        right: 20px;
        padding: 15px 20px;
        border-radius: 5px;
        color: white;
        font-weight: bold;
        opacity: 0;
        transform: translateY(-20px);
        transition: opacity 0.3s, transform 0.3s;
        z-index: 1000;
        max-width: 300px;
    }
    
    .notification.show {
        opacity: 1;
        transform: translateY(0);
    }
    
    .notification.success {
        background-color: #27ae60;
    }
    
    .notification.error {
        background-color: #e74c3c;
    }
</style>