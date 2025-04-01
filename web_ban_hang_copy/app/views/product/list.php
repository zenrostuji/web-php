<?php include 'app/views/shares/header.php'; ?>

<!-- Banner with grayscale effect -->
<div class="banner">
    <div class="tranding-slider swiper">
        <div class="swiper-wrapper">
            <!-- Display featured products -->
            <?php foreach (array_slice($products, 0, 5) as $index => $product): ?>
            <div class="swiper-slide">
                <div class="car-card">
                    <img src="/web_ban_hang_copy/<?php echo $product->image ? $product->image : 'uploads/default.png'; ?>" alt="<?php echo htmlspecialchars($product->name, ENT_QUOTES, 'UTF-8'); ?>">
                    <div class="car-info">
                        <h3><?php echo htmlspecialchars($product->name, ENT_QUOTES, 'UTF-8'); ?></h3>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <div class="swiper-pagination"></div>
    </div>
</div>

<!-- Product Section -->
<div class="product-section">
    <h1 class="section-title">Danh sách sản phẩm</h1>
    
    <?php if (SessionHelper::isAdmin()): ?>
    <a href="/web_ban_hang_copy/Product/add" class="btn-add-product">
        <i class="fa fa-plus"></i> Thêm sản phẩm mới
    </a>
    <?php endif; ?>
    
    <div class="product-grid" id="product-list">
        <!-- Products will be dynamically loaded here -->
    </div>
</div>

<?php include 'app/views/shares/footer.php'; ?>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        fetch('/web_ban_hang_copy/api/product')
            .then(response => response.json())
            .then(data => {
                const productList = document.getElementById('product-list');
                data.forEach(product => {
                    const productCard = document.createElement('div');
                    productCard.className = 'product-card';
                    productCard.innerHTML = `
                        <div class="product-image">
                            <img src="/web_ban_hang_copy/${product.image || 'uploads/default.png'}" alt="${product.name}">
                            <div class="quick-actions">
                                ${<?php echo json_encode(SessionHelper::isLoggedIn()); ?> ? `
                                <a href="/web_ban_hang_copy/Product/addToCart/${product.id}" class="add-to-cart">
                                    <i class="fa fa-shopping-cart"></i>
                                </a>` : ''}
                                <a href="/web_ban_hang_copy/Product/show/${product.id}" class="view-details">
                                    <i class="fa fa-eye"></i>
                                </a>
                            </div>
                        </div>
                        <div class="product-info">
                            <h2 class="product-name">
                                <a href="/web_ban_hang_copy/Product/show/${product.id}">
                                    ${product.name}
                                </a>
                            </h2>
                            <div class="product-category">
                                <span>${product.category_name}</span>
                            </div>
                            <div class="product-price">
                                ${product.price} USD
                            </div>
                            ${<?php echo json_encode(SessionHelper::isAdmin()); ?> ? `
                            <div class="admin-actions">
                                <a href="/web_ban_hang_copy/Product/edit/${product.id}" class="btn-edit">
                                    <i class="fa fa-edit"></i> Sửa
                                </a>
                                <a href="/web_ban_hang_copy/Product/delete/${product.id}" class="btn-delete" 
                                   onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này?');">
                                    <i class="fa fa-trash"></i> Xóa
                                </a>
                            </div>` : ''}
                        </div>
                    `;
                    productList.appendChild(productCard);
                });
            });
    });
</script>

<style>
    /* Banner Styles Improved - Grayscale effect */
    .banner {
        margin: 20px auto;
        padding: 40px 15px;
        background: linear-gradient(135deg, #34495e, #2c3e50);
        border-radius: 15px;
        max-width: 1500px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
    }

    .swiper-wrapper {
        display: flex;
        gap: 15px;
    }

    .swiper-slide {
        flex: 1;
        overflow: hidden;
        cursor: pointer;
        height: 350px;
        transition: all 0.4s ease;
        border-radius: 15px;
        position: relative;
    }

    .swiper-slide:hover {
        flex: 3;
        transform: translateY(-10px);
    }

    .car-card {
        width: 100%;
        height: 100%;
        border-radius: 15px;
        overflow: hidden;
        position: relative;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
    }

    .car-card img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        filter: grayscale(1);
        transition: all 0.4s ease;
    }

    .swiper-slide:hover .car-card img {
        filter: grayscale(0);
        transform: scale(1.05);
    }

    .car-info {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        background: linear-gradient(transparent, rgba(0, 0, 0, 0.8));
        color: white;
        padding: 20px;
        border-bottom-left-radius: 15px;
        border-bottom-right-radius: 15px;
        text-align: center;
        transform: translateY(0);
        transition: all 0.3s ease;
    }

    .car-info h3 {
        margin: 0 0 8px 0;
        font-size: 20px;
        font-weight: 600;
    }

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

    /* Add Product Button */
    .btn-add-product {
        display: block;
        width: 250px;
        margin: 0 auto 40px;
        padding: 12px 20px;
        font-size: 18px;
        text-align: center;
        background: linear-gradient(135deg, #3498db, #2980b9);
        color: #fff;
        border: none;
        border-radius: 30px;
        box-shadow: 0 4px 10px rgba(41, 128, 185, 0.3);
        transition: all 0.3s ease;
        text-decoration: none;
    }

    .btn-add-product:hover {
        transform: translateY(-5px);
        box-shadow: 0 6px 15px rgba(41, 128, 185, 0.4);
    }

    /* Product Grid */
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

    /* Responsive Adjustments */
    @media (max-width: 768px) {
        .product-grid {
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        }
        
        .swiper-slide {
            height: 300px;
        }
    }

    @media (max-width: 576px) {
        .product-grid {
            grid-template-columns: 1fr;
        }
        
        .banner {
            padding: 30px 10px;
        }
    }
</style>