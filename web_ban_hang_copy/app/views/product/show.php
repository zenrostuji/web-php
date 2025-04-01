<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi tiết xe sang trọng</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        /* Global styles */
        body {
            font-family: 'Montserrat', 'Segoe UI', sans-serif;
            background-color: #f8f9fa;
            color: #333;
        }

        /* Product container */
        .product-container {
            background-color: #fff;
            border-radius: 0;
            padding: 50px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
            margin-top: 60px;
            margin-bottom: 60px;
        }

        /* Product header */
        .product-header {
            border-bottom: 1px solid #eaeaea;
            padding-bottom: 25px;
            margin-bottom: 40px;
        }

        .product-title {
            font-weight: 700;
            font-size: 36px;
            color: #111;
            letter-spacing: 1px;
            margin-bottom: 15px;
            text-transform: uppercase;
        }
        
        .product-subtitle {
            font-size: 18px;
            color: #666;
            font-weight: 300;
            margin-bottom: 20px;
            font-style: italic;
        }

        .product-category {
            background-color: #d4af37;
            color: #0a0a0a;
            font-size: 14px;
            padding: 8px 20px;
            border-radius: 0;
            display: inline-block;
            margin-bottom: 15px;
            font-weight: 600;
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        /* Product images */
        .product-image-container {
            position: relative;
            overflow: hidden;
            margin-bottom: 30px;
        }

        .product-image {
            border-radius: 0;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
            transition: transform 0.5s ease;
            width: 100%;
            height: 500px;
            object-fit: cover;
        }

        .product-image:hover {
            transform: scale(1.03);
        }

        /* Product details */
        .product-details {
            background-color: #fbfbfb;
            border-radius: 0;
            padding: 40px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.05);
            border-left: 5px solid #d4af37;
        }

        .detail-label {
            font-weight: 600;
            color: #333;
            margin-bottom: 12px;
            font-size: 18px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .detail-value {
            font-size: 16px;
            line-height: 1.8;
            color: #555;
            margin-bottom: 30px;
        }

        .price-tag {
            background-color: #0a0a0a;
            color: #d4af37;
            padding: 12px 25px;
            border-radius: 0;
            font-size: 24px;
            font-weight: 700;
            display: inline-block;
            margin-bottom: 30px;
            letter-spacing: 1px;
        }

        /* Specifications section */
        .specs-section {
            margin-top: 40px;
            padding-top: 30px;
            border-top: 1px solid #eaeaea;
        }

        .spec-item {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }

        .spec-icon {
            width: 50px;
            height: 50px;
            background-color: #f8f9fa;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 20px;
            color: #d4af37;
        }

        .spec-details {
            flex: 1;
        }

        .spec-title {
            font-weight: 600;
            margin-bottom: 5px;
            font-size: 16px;
        }

        .spec-value {
            color: #666;
        }

        /* Action buttons */
        .action-buttons {
            margin-top: 40px;
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
        }

        .btn {
            padding: 12px 30px;
            border-radius: 0;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: all 0.3s ease;
        }

        .btn-primary {
            background-color: #d4af37;
            border: none;
            color: #0a0a0a;
        }

        .btn-primary:hover {
            background-color: #c9a633;
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(212, 175, 55, 0.3);
        }

        .btn-outline-dark {
            border: 2px solid #0a0a0a;
            color: #0a0a0a;
        }

        .btn-outline-dark:hover {
            background-color: #0a0a0a;
            color: #fff;
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        .btn-danger {
            background-color: #dc3545;
            border: none;
        }

        .btn-danger:hover {
            background-color: #c82333;
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(220, 53, 69, 0.3);
        }
        
    </style>
</head>

<body>
    <?php include 'app/views/shares/header.php'; ?>
    
    <?php if ($product): ?>
    <div class="container product-container">
        <div class="row">
            <div class="col-12">
                <div class="product-header">
                    <h1 class="product-title"><?php echo htmlspecialchars($product->name ?? '', ENT_QUOTES, 'UTF-8'); ?></h1>
                    <h2 class="product-subtitle">Trải nghiệm đẳng cấp và sang trọng</h2>
                    <?php if (!empty($product->category_name)): ?>
                    <div class="product-category">
                        <i class="fas fa-tag mr-2"></i> 
                        <?php echo htmlspecialchars($product->category_name, ENT_QUOTES, 'UTF-8'); ?>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-lg-7 mb-4">
                <div class="product-image-container">
                    <?php if (!empty($product->image)): ?>
                    <img src="/web_ban_hang_copy/<?php echo htmlspecialchars($product->image, ENT_QUOTES, 'UTF-8'); ?>"
                        alt="<?php echo htmlspecialchars($product->name, ENT_QUOTES, 'UTF-8'); ?>" 
                        class="product-image"
                        onerror="this.src='/web_ban_hang_copy/public/luxury-car-placeholder.jpg'">
                    <?php else: ?>
                    <img src="/web_ban_hang_copy/public/luxury-car-placeholder.jpg" alt="No image available" class="product-image">
                    <?php endif; ?>
                </div>
            </div>
            
            <div class="col-lg-5">
                <div class="product-details">
                    <div class="price-tag">
                        <i class="fas fa-tag mr-2"></i>
                        <?php echo number_format($product->price ?? 0, 0, ',', '.'); ?> USD
                    </div>
                    
                    <div>
                        <h5 class="detail-label"><i class="fas fa-info-circle mr-2"></i>Mô tả xe</h5>
                        <p class="detail-value">
                            <?php echo htmlspecialchars($product->description ?? 'Không có mô tả', ENT_QUOTES, 'UTF-8'); ?>
                        </p>
                    </div>
                    
                    <div class="action-buttons">
                        <?php if (SessionHelper::isLoggedIn()): ?>
                        <a href="/web_ban_hang_copy/Product/addToCart/<?php echo $product->id; ?>" class="btn btn-primary">
                            <i class="fas fa-shopping-cart mr-2"></i>Đặt mua
                        </a>
                        <?php endif; ?>
                        
                        <a href="/web_ban_hang_copy/Product" class="btn btn-outline-dark">
                            <i class="fas fa-arrow-left mr-2"></i>Quay lại danh sách
                        </a>
                        
                        <?php if (SessionHelper::isAdmin()): ?>
                        <a href="/web_ban_hang_copy/Product/edit/<?php echo $product->id; ?>" class="btn btn-outline-dark">
                            <i class="fas fa-edit mr-2"></i>Chỉnh sửa
                        </a>
                        <a href="/web_ban_hang_copy/Product/delete/<?php echo $product->id; ?>" class="btn btn-danger"
                            onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này?');">
                            <i class="fas fa-trash-alt mr-2"></i>Xóa
                        </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-5">
            <div class="col-12">
                <h3 class="detail-label text-center mb-4">TÍNH NĂNG NỔI BẬT</h3>
                <div class="row">
                    <div class="col-md-4 mb-4">
                        <div class="card h-100 border-0 shadow-sm">
                            <div class="card-body text-center">
                                <i class="fas fa-car-battery fa-3x mb-3" style="color: #d4af37;"></i>
                                <h5 class="card-title">Hệ thống Âm thanh Cao cấp</h5>
                                <p class="card-text">Hệ thống âm thanh vòm 3D với 28 loa, mang đến trải nghiệm âm thanh tuyệt vời.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-4">
                        <div class="card h-100 border-0 shadow-sm">
                            <div class="card-body text-center">
                                <i class="fas fa-couch fa-3x mb-3" style="color: #d4af37;"></i>
                                <h5 class="card-title">Nội thất Da Cao cấp</h5>
                                <p class="card-text">Ghế bọc da Nappa cao cấp với chức năng massage và điều hòa nhiệt độ.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-4">
                        <div class="card h-100 border-0 shadow-sm">
                            <div class="card-body text-center">
                                <i class="fas fa-shield-alt fa-3x mb-3" style="color: #d4af37;"></i>
                                <h5 class="card-title">Công nghệ An toàn</h5>
                                <p class="card-text">Hệ thống an toàn chủ động với các tính năng hỗ trợ lái xe và cảnh báo tiên tiến.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php else: ?>
    <div class="container mt-5">
        <div class="alert alert-danger text-center p-5" role="alert">
            <i class="fas fa-exclamation-circle fa-3x mb-3"></i>
            <h4 class="alert-heading mb-3">Không tìm thấy sản phẩm</h4>
            <p>Xe sang mà bạn đang tìm kiếm không tồn tại hoặc đã bị xóa.</p>
            <hr>
            <a href="/web_ban_hang_copy/Product" class="btn btn-outline-dark mt-3">
                <i class="fas fa-arrow-left mr-2"></i>Quay lại danh sách xe
            </a>
        </div>
    </div>
    <?php endif; ?>
    
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const pathSegments = window.location.pathname.split('/');
            const productId = pathSegments[pathSegments.length - 1];

            if (!productId || isNaN(productId)) {
                document.querySelector('.product-container').innerHTML = '<p>ID sản phẩm không hợp lệ.</p>';
                return;
            }

            fetch(`/web_ban_hang_copy/api/product/${productId}`)
                .then(response => response.json())
                .then(product => {
                    if (product.message === 'Product not found') {
                        document.querySelector('.product-container').innerHTML = '<p>Không tìm thấy sản phẩm.</p>';
                        return;
                    }
                })
                .catch(error => {
                    console.error('Error fetching product:', error);
                });
        });
    </script>
</body>

</html>
<?php include 'app/views/shares/footer.php'; ?>