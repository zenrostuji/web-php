<?php include 'app/views/shares/header.php'; ?>

<div class="product-section">
    <h1 class="section-title">Kết quả tìm kiếm: "<?php echo htmlspecialchars($searchQuery, ENT_QUOTES, 'UTF-8'); ?>"</h1>
    
    <?php if (empty($products)): ?>
        <div class="alert alert-info">
            Không tìm thấy sản phẩm nào phù hợp với từ khóa "<?php echo htmlspecialchars($searchQuery, ENT_QUOTES, 'UTF-8'); ?>".
        </div>
    <?php else: ?>
        <p class="results-count">Đã tìm thấy <?php echo count($products); ?> sản phẩm.</p>
        
        <div class="product-grid">
            <?php foreach ($products as $product): ?>
                <div class="product-card">
                    <div class="product-image">
                        <img src="<?php echo !empty($product['image']) ? '/web_ban_hang_copy/' . htmlspecialchars($product['image']) : '/web_ban_hang_copy/uploads/default.png'; ?>" 
                             alt="<?php echo htmlspecialchars($product['name']); ?>">
                        <div class="quick-actions">
                            <?php if (SessionHelper::isLoggedIn()): ?>
                            <a href="/web_ban_hang_copy/Product/addToCart/<?php echo $product['id']; ?>" class="add-to-cart">
                                <i class="fa fa-shopping-cart"></i>
                            </a>
                            <?php endif; ?>
                            <a href="/web_ban_hang_copy/Product/show/<?php echo $product['id']; ?>" class="view-details">
                                <i class="fa fa-eye"></i>
                            </a>
                        </div>
                    </div>
                    <div class="product-info">
                        <h2 class="product-name">
                            <a href="/web_ban_hang_copy/Product/show/<?php echo $product['id']; ?>">
                                <?php echo htmlspecialchars($product['name']); ?>
                            </a>
                        </h2>
                        <div class="product-category">
                            <span><?php echo htmlspecialchars($product['category_name'] ?? 'Không xác định'); ?></span>
                        </div>
                        <div class="product-price">
                            <?php echo number_format($product['price']); ?> USD
                        </div>
                        <?php if (SessionHelper::isAdmin()): ?>
                        <div class="admin-actions">
                            <a href="/web_ban_hang_copy/Product/edit/<?php echo $product['id']; ?>" class="btn-edit">
                                <i class="fa fa-edit"></i> Sửa
                            </a>
                            <a href="/web_ban_hang_copy/Product/delete/<?php echo $product['id']; ?>" class="btn-delete" 
                               onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này?');">
                                <i class="fa fa-trash"></i> Xóa
                            </a>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<style>
    /* Section Title */
    .section-title {
        text-align: center;
        margin: 50px 0 30px;
        font-size: 36px;
        font-weight: 700;
        color: #2c3e50;
        position: relative;
        padding-bottom: 15px;
    }

    .section-title:after {
        content: '';
        position: absolute;
        width: 100px;
        height: 4px;
        background: linear-gradient(to right, #3498db, #2c3e50);
        bottom: 0;
        left: 50%;
        transform: translateX(-50%);
        border-radius: 2px;
    }

    /* Product Section */
    .product-section {
        max-width: 1500px;
        margin: 0 auto;
        padding: 0 15px;
    }

    .product-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 30px;
        margin-bottom: 50px;
    }

    /* Product Card */
    .product-card {
        border-radius: 12px;
        overflow: hidden;
        background-color: #fff;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
        position: relative;
    }

    .product-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.15);
    }

    .product-image {
        height: 250px;
        position: relative;
        overflow: hidden;
    }

    .product-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }

    .product-card:hover .product-image img {
        transform: scale(1.1);
    }

    .quick-actions {
        position: absolute;
        top: 10px;
        right: 10px;
        display: flex;
        flex-direction: column;
        gap: 10px;
        opacity: 0;
        transform: translateX(20px);
        transition: all 0.3s ease;
    }

    .product-card:hover .quick-actions {
        opacity: 1;
        transform: translateX(0);
    }

    .quick-actions a {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background-color: white;
        display: flex;
        justify-content: center;
        align-items: center;
        color: #2c3e50;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
    }

    .add-to-cart:hover {
        background-color: #27ae60;
        color: white;
    }

    .view-details:hover {
        background-color: #3498db;
        color: white;
    }

    .product-info {
        padding: 20px;
    }

    .product-name {
        font-size: 20px;
        margin: 0 0 10px;
        font-weight: 600;
    }

    .product-name a {
        color: #2c3e50;
        text-decoration: none;
        transition: color 0.3s ease;
    }

    .product-name a:hover {
        color: #3498db;
    }

    .product-category {
        margin-bottom: 10px;
    }

    .product-category span {
        background-color: #f1f1f1;
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 14px;
        color: #555;
    }

    .product-price {
        font-size: 22px;
        font-weight: 700;
        color: #3498db;
        margin-bottom: 15px;
    }

    .admin-actions {
        display: flex;
        gap: 10px;
        margin-top: 15px;
    }

    .btn-edit, .btn-delete {
        padding: 8px 15px;
        border-radius: 6px;
        font-size: 14px;
        font-weight: 500;
        text-decoration: none;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }

    .btn-edit {
        background-color: #f1c40f;
        color: #2c3e50;
    }

    .btn-delete {
        background-color: #e74c3c;
        color: white;
    }

    .btn-edit:hover {
        background-color: #f39c12;
        transform: translateY(-3px);
    }

    .btn-delete:hover {
        background-color: #c0392b;
        transform: translateY(-3px);
    }

    /* Search Results Specific Styles */
    .results-count {
        text-align: center;
        margin-bottom: 30px;
        color: #555;
        font-size: 18px;
    }

    .alert {
        max-width: 800px;
        margin: 30px auto;
        padding: 20px;
        border-radius: 10px;
        text-align: center;
        background-color: #f8f9fa;
        border: 1px solid #dee2e6;
        color: #555;
    }

    /* Responsive Adjustments */
    @media (max-width: 768px) {
        .product-grid {
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        }
    }

    @media (max-width: 576px) {
        .product-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<?php include 'app/views/shares/footer.php'; ?>