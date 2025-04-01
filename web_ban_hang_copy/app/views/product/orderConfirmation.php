<?php include 'app/views/shares/header.php'; ?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="confirmation-container">
                <div class="success-icon">
                    <svg width="80" height="80" viewBox="0 0 80 80" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="40" cy="40" r="40" fill="#4CAF50" fill-opacity="0.1"/>
                        <circle cx="40" cy="40" r="32" fill="#4CAF50" fill-opacity="0.2"/>
                        <circle cx="40" cy="40" r="24" fill="#4CAF50"/>
                        <path d="M53.3334 34L36.6667 50.6667L26.6667 40.6667" stroke="white" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
                
                <h1 class="confirmation-title">Đặt hàng thành công!</h1>
                
                <div class="confirmation-message">
                    <p>Cảm ơn bạn đã đặt hàng. Đơn hàng của bạn đã được xử lý thành công.</p>
                    <!-- <p>Chúng tôi sẽ liên hệ với bạn sớm nhất có thể để xác nhận đơn hàng.</p> -->
                </div>
                
                <!-- <div class="order-details">
                    <div class="order-detail-item">
                        <div class="detail-label">Mã đơn hàng:</div>
                        <div class="detail-value">#ORD<?php echo rand(10000, 99999); ?></div>
                    </div>
                    <div class="order-detail-item">
                        <div class="detail-label">Ngày đặt hàng:</div>
                        <div class="detail-value"><?php echo date('d/m/Y H:i'); ?></div>
                    </div>
                    <div class="order-detail-item">
                        <div class="detail-label">Trạng thái:</div>
                        <div class="detail-value status-badge">Đang xử lý</div>
                    </div>
                </div> -->
                
                <div class="confirmation-actions">
                    <a href="/web_ban_hang_copy/Product" class="btn-continue">
                        Tiếp tục mua sắm
                    </a>
                    <!-- <a href="/web_ban_hang_copy/User/orders" class="btn-view-orders">
                        Xem đơn hàng của tôi
                    </a> -->
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .confirmation-container {
        background: #ffffff;
        border-radius: 16px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        padding: 40px;
        text-align: center;
        position: relative;
        overflow: hidden;
    }
    
    .confirmation-container::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 6px;
        background: linear-gradient(90deg, #4CAF50, #8BC34A);
    }
    
    .success-icon {
        margin: 0 auto 30px;
        animation: scale-in 0.5s ease-out;
    }
    
    .confirmation-title {
        font-size: 32px;
        font-weight: 700;
        color: #333;
        margin-bottom: 20px;
    }
    
    .confirmation-message {
        font-size: 16px;
        color: #666;
        max-width: 600px;
        margin: 0 auto 30px;
        line-height: 1.6;
    }
    
    .order-details {
        background: #f9f9f9;
        border-radius: 12px;
        padding: 25px;
        margin-bottom: 30px;
        text-align: left;
    }
    
    .order-detail-item {
        display: flex;
        justify-content: space-between;
        padding: 12px 0;
        border-bottom: 1px solid #eee;
    }
    
    .order-detail-item:last-child {
        border-bottom: none;
    }
    
    .detail-label {
        font-weight: 600;
        color: #555;
    }
    
    .detail-value {
        font-weight: 500;
        color: #333;
    }
    
    .status-badge {
        background: #E3F2FD;
        color: #1976D2;
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 14px;
        font-weight: 600;
    }
    
    .confirmation-actions {
        display: flex;
        justify-content: center;
        gap: 20px;
        margin-top: 10px;
    }
    
    .btn-continue {
        padding: 14px 30px;
        background: #4CAF50;
        color: white;
        border-radius: 50px;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.3s;
        box-shadow: 0 4px 10px rgba(76, 175, 80, 0.2);
    }
    
    .btn-continue:hover {
        background: #43A047;
        transform: translateY(-2px);
        box-shadow: 0 6px 12px rgba(76, 175, 80, 0.25);
    }
    
    .btn-view-orders {
        padding: 14px 30px;
        background: white;
        color: #4CAF50;
        border: 1px solid #4CAF50;
        border-radius: 50px;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.3s;
    }
    
    .btn-view-orders:hover {
        background: #f5f5f5;
    }
    
    @keyframes scale-in {
        0% {
            transform: scale(0);
            opacity: 0;
        }
        100% {
            transform: scale(1);
            opacity: 1;
        }
    }
    
    @media (max-width: 768px) {
        .confirmation-container {
            padding: 30px 20px;
        }
        
        .confirmation-actions {
            flex-direction: column;
            gap: 15px;
        }
        
        .btn-continue, .btn-view-orders {
            width: 100%;
            text-align: center;
        }
    }
</style>

<?php include 'app/views/shares/footer.php'; ?>