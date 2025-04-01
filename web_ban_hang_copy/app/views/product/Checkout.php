<?php include 'app/views/shares/header.php'; ?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="checkout-container">
                <div class="checkout-header" >
                    <h2>Thanh Toán</h2>
                </div>

                <div class="checkout-form-wrapper">
                    <form method="POST" action="/web_ban_hang_copy/Product/processCheckout">
                        <div class="form-group">
                            <label for="name">Họ tên</label>
                            <input type="text" id="name" name="name" class="form-control" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="phone">Số điện thoại</label>
                            <input type="tel" id="phone" name="phone" class="form-control" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="address">Địa chỉ giao hàng</label>
                            <textarea id="address" name="address" class="form-control" rows="3" required></textarea>
                        </div>
                        
                        <div class="form-actions">
                            <a href="/web_ban_hang_copy/Product/cart" class="btn-back">
                                <i class="fas fa-arrow-left"></i> Quay lại giỏ hàng
                            </a>
                            <button type="submit" class="btn-checkout">
                                Xác nhận thanh toán <i class="fas fa-arrow-right"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .checkout-container {
        background: #ffffff;
       
        border-radius: 16px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        margin-bottom: 30px;
    }
    
    .checkout-header {
        background-color: rgb(85, 92, 99);
        /* background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); */
        color: white;
        padding: 25px 30px;
        position: relative;
    }
    
    .checkout-header h2 {
        margin: 0;
        font-size: 28px;
        font-weight: 700;
        text-align: center;
        margin-bottom: 25px;
    }
    
    .checkout-steps {
        display: flex;
        justify-content: space-between;
        position: relative;
        z-index: 1;
    }
    
    .checkout-steps:before {
        content: '';
        position: absolute;
        top: 20px;
        left: 10%;
        right: 10%;
        height: 3px;
        background: rgba(255, 255, 255, 0.3);
        z-index: -1;
    }
    
    .step {
        display: flex;
        flex-direction: column;
        align-items: center;
        position: relative;
        flex: 1;
    }
    
    .step-number {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.2);
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        margin-bottom: 8px;
        transition: all 0.3s ease;
    }
    
    .step.active .step-number {
        background: white;
        color: #764ba2;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }
    
    .step-label {
        font-size: 14px;
        font-weight: 500;
    }
    
    .checkout-form-wrapper {
        padding: 40px 30px;
    }
    
    .form-group {
        margin-bottom: 25px;
    }
    
    .form-group label {
        display: block;
        font-weight: 600;
        margin-bottom: 8px;
        color: #4a4a4a;
    }
    
    .form-control {
        width: 100%;
        padding: 15px;
        border: 2px solid #e0e0e0;
        border-radius: 8px;
        font-size: 16px;
        transition: all 0.3s;
    }
    
    .form-control:focus {
        border-color: #764ba2;
        box-shadow: 0 0 0 3px rgba(118, 75, 162, 0.15);
        outline: none;
    }
    
    .form-actions {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 30px;
    }
    
    .btn-back {
        padding: 12px 20px;
        background: transparent;
        border: none;
        color: #666;
        font-weight: 600;
        cursor: pointer;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        transition: all 0.3s;
    }
    
    .btn-back:hover {
        color: #764ba2;
    }
    
    .btn-checkout {
        padding: 15px 30px;
        /* background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); */
        background-color: rgb(85, 92, 99);
        color: white;
        border: none;
        border-radius: 50px;
        font-weight: 600;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        transition: all 0.3s;
        box-shadow: 0 8px 15px rgba(118, 75, 162, 0.25);
    }
    
    .btn-checkout:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 20px rgba(118, 75, 162, 0.3);
    }
    
    .btn-checkout i, .btn-back i {
        margin: 0 8px;
    }
    
    @media (max-width: 768px) {
        .checkout-header {
            padding: 20px 15px;
        }
        
        .checkout-form-wrapper {
            padding: 30px 20px;
        }
        
        .step-label {
            font-size: 12px;
        }
        
        .form-actions {
            flex-direction: column-reverse;
            gap: 15px;
        }
        
        .btn-checkout, .btn-back {
            width: 100%;
            justify-content: center;
        }
    }
</style>

<?php include 'app/views/shares/footer.php'; ?>