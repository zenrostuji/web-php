<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý sản phẩm</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <nav class="navbar navbar-expand-lg" style="background-color: rgb(85, 92, 99);">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="/web_ban_hang_copy">
                <img src="/web_ban_hang_copy/public/logo02.png" alt="Logo" class="custom-logo">
                <span style="color: white; font-weight: bold; font-size: 20px;">Trang Chủ</span>
            </a>
            <li class="collapse navbar-collapse dropdown">
                <a style="color: white; font-weight: bold; font-size: 17px;" class="nav-link dropdown-toggle" href="#"
                    id="categoryDropdown" role="button" data-toggle="dropdown" aria-haspopup="true"
                    aria-expanded="false">
                    Danh mục sản phẩm
                </a>
                <div class="dropdown-menu dropdown-menu-grid" aria-labelledby="categoryDropdown">
                    <div class="container-fluid px-1">
                        <div class="row row-cols-3">
                            <?php
                            require_once('app/controllers/CategoryController.php');

                            try {
                                $categoryController = new CategoryController();
                                $categories = $categoryController->getCategories();

                                if (!empty($categories)) {
                                    foreach ($categories as $category): ?>
                                        <div class="col mb-2">
                                            <a class="dropdown-item grid-item"
                                                href="/web_ban_hang_copy/Product/byCategory/<?php echo $category->id; ?>">
                                                <?php echo htmlspecialchars($category->name, ENT_QUOTES, 'UTF-8'); ?>
                                            </a>
                                        </div>
                                    <?php endforeach;
                                } else {
                                    echo '<div class="col-12"><a class="dropdown-item disabled">Không có danh mục</a></div>';
                                }
                            } catch (Exception $e) {
                                echo '<div class="col-12"><a class="dropdown-item disabled">Lỗi tải danh mục</a></div>';
                                error_log('Category error: ' . $e->getMessage());
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </li>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">

                    <!-- search -->
                    <form class="form-inline my-2 my-lg-0 search-form">
                        <div class="input-group">
                            <input id="search-input" class="form-control" type="search"
                                placeholder="Tìm kiếm sản phẩm..." aria-label="Search" autocomplete="off">
                            <div class="input-group-append">
                                <button class="btn btn-outline-light" type="submit">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                            <!-- Container cho gợi ý tìm kiếm -->
                            <div id="search-suggestions" class="search-suggestions">
                                <!-- Gợi ý sẽ được thêm vào đây bằng JavaScript -->
                            </div>
                        </div>
                    </form>

                    <?php if (SessionHelper::isLoggedIn()): ?>
                        <li class="nav-item">
                            <a style="color: white; font-weight: bold; font-size: 16px;" class="nav-link"
                                href="/web_ban_hang_copy/Product/Cart">
                                <i class="fas fa-shopping-cart"></i> Giỏ Hàng
                            </a>
                        </li>
                    <?php endif; ?>

                    <?php if (SessionHelper::isAdmin()): ?>
                        <li class="nav-item dropdown">
                            <a style="color: white; font-weight: bold; font-size: 16px;" class="nav-link dropdown-toggle"
                                href="#" id="productDropdown" role="button" data-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false">
                                Quản lý sản phẩm
                            </a>
                            <div class="dropdown-menu" aria-labelledby="productDropdown">
                                <a class="dropdown-item" href="/web_ban_hang_copy/Product">📋 Danh sách sản phẩm</a>
                                <a class="dropdown-item" href="/web_ban_hang_copy/Product/add">➕ Thêm sản phẩm</a>
                                <a class="dropdown-item" href="/web_ban_hang_copy/Product/QL_category">📂 Quản lý Loại sản phẩm</a>
                            </div>
                        </li>
                    <?php endif; ?>


                    <?php if (SessionHelper::isLoggedIn()): ?>
                        <li class="nav-item user-info">
                            <span class="nav-link user-name">
                                <a href="/web_ban_hang_copy/account/profile" style="color: white; text-decoration: none;">
                                    <?php echo $_SESSION['username']; ?>
                                </a>
                            </span>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link logout-btn" href="/web_ban_hang_copy/account/logout">Đăng xuất</a>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link login-btn" href="/web_ban_hang_copy/account/login">Đăng nhập</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <!-- JavaScript -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</body>

</html>

<style>
    .custom-logo {
        border-radius: 50%;
        height: 40px;
        width: 40px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        margin-right: 10px;
        object-fit: cover;
    }

    .navbar {
        padding: 10px 0;
    }

    .nav-link {
        padding: 8px 15px !important;
        transition: all 0.3s ease;
    }

    .nav-link:hover {
        background-color: rgba(255, 255, 255, 0.1);
        border-radius: 4px;
    }

    .user-name {
        background-color: #17a2b8;
        color: white !important;
        border-radius: 20px;
        padding: 5px 15px !important;
        margin-right: 10px;
    }

    .login-btn,
    .logout-btn {
        background-color: #28a745;
        color: white !important;
        border-radius: 20px;
        padding: 5px 15px !important;
        font-weight: bold;
    }

    .logout-btn {
        background-color: #dc3545;
    }

    .dropdown-menu {
        border-radius: 8px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        border: none;
        padding: 10px 0;
    }

    .dropdown-item {
        padding: 8px 20px;
        transition: all 0.2s;
    }

    .dropdown-item:hover {
        background-color: #f8f9fa;
    }

    @media (max-width: 991px) {
        .navbar-nav {
            padding-top: 15px;
        }

        .nav-item {
            margin-bottom: 5px;
        }

        .user-name,
        .login-btn,
        .logout-btn {
            text-align: center;
            display: block;
            margin: 5px 0;
        }
    }



    .dropdown-menu-grid {
        width: auto;
        min-width: 600px;
        /* Điều chỉnh theo nhu cầu */
        padding: 15px;
    }

    .dropdown-menu-grid .container {
        padding: 0;
    }

    .dropdown-menu-grid .row {
        margin-bottom: 10px;
    }

    .grid-item {
        padding: 10px;
        margin: 3px;
        text-align: center;
        border-radius: 5px;
        transition: all 0.2s;
    }

    .grid-item:hover {
        background-color: #f1f1f1;
        transform: translateY(-2px);
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    /* Đảm bảo dropdown menu hiển thị đúng trên thiết bị di động */
    @media (max-width: 767px) {
        .dropdown-menu-grid {
            min-width: 300px;
        }

        .dropdown-menu-grid .col-md-3 {
            width: 50%;
        }
    }

    @media (max-width: 480px) {
        .dropdown-menu-grid .col-md-3 {
            width: 100%;
        }
    }


    /* search */
    .search-form {
        position: relative;
        margin-right: 15px;
    }

    .search-form .form-control {
        border-radius: 20px;
        padding-left: 15px;
        padding-right: 40px;
        width: 140px;
        transition: width 0.3s ease;
    }

    .search-form .form-control:focus {
        width: 210px;
        box-shadow: 0 0 0 0.2rem rgba(255, 255, 255, 0.25);
        border-color: #fff;
    }

    .search-form .btn {
        position: absolute;
        right: 2px;
        top: 2px;
        border-radius: 20px;/*0 20px 20px 0;*/
        padding: 5px 12px;
        z-index: 5;
    }

    .search-suggestions {
        display: none;
        position: absolute;
        top: 100%;
        left: 0;
        right: 0;
        background-color: white;
        border-radius: 0 0 12px 12px;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.15);
        max-height: 350px;
        overflow-y: auto;
        z-index: 1000;
        margin-top: 5px;
    }

    .suggestion-item {
        padding: 12px 15px;
        border-bottom: 1px solid #eee;
        cursor: pointer;
        display: flex;
        align-items: center;
        transition: background-color 0.2s ease;
    }

    .suggestion-item:last-child {
        border-bottom: none;
        border-radius: 0 0 12px 12px;
    }

    .suggestion-item:hover {
        background-color: #f8f9fa;
    }

    .suggestion-item:focus {
        background-color: #f0f0f0;
        outline: none;
    }

    .suggestion-image {
        width: 50px;
        height: 50px;
        object-fit: cover;
        margin-right: 12px;
        border-radius: 8px;
        border: 1px solid #eee;
    }

    .suggestion-info {
        flex: 1;
    }

    .suggestion-name {
        font-weight: bold;
        margin-bottom: 5px;
        color: #333;
    }

    .suggestion-price {
        color: #dc3545;
        font-size: 0.95em;
        font-weight: 500;
    }

    @media (max-width: 991px) {
        .search-form {
            margin: 10px 0;
            width: 100%;
        }

        .search-form .form-control,
        .search-form .form-control:focus {
            width: 100%;
        }
    }
</style>
<script>
    document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('search-input');
    const searchForm = document.querySelector('.search-form');
    const suggestionsContainer = document.getElementById('search-suggestions');
    
    // Debounce function to limit API calls while typing
    function debounce(func, delay) {
        let debounceTimer;
        return function() {
            const context = this;
            const args = arguments;
            clearTimeout(debounceTimer);
            debounceTimer = setTimeout(() => func.apply(context, args), delay);
        };
    }
    
    // Function to search products by name and show suggestions
    const searchProductsByName = debounce(function(query) {
        if (query.length < 2) {
            suggestionsContainer.style.display = 'none';
            return;
        }
        
        // Call search API
        fetch(`/web_ban_hang_copy/Product/search?q=${encodeURIComponent(query)}`)
            .then(response => response.json())
            .then(data => {
                // Clear previous suggestions
                suggestionsContainer.innerHTML = '';
                
                if (data.length === 0) {
                    suggestionsContainer.innerHTML = '<div class="suggestion-item">Không tìm thấy sản phẩm nào</div>';
                    suggestionsContainer.style.display = 'block';
                    return;
                }
                
                // Display product suggestions
                data.forEach(product => {
                    const item = document.createElement('div');
                    item.className = 'suggestion-item';
                    item.innerHTML = `
                        <img src="${product.image}" alt="${product.name}" class="suggestion-image" 
                             onerror="this.src='/web_ban_hang_copy/public/logo01.jpg'">
                        <div class="suggestion-info">
                            <div class="suggestion-name">${product.name}</div>
                            <div class="suggestion-price">${formatPrice(product.price)} USD</div>
                        </div>
                    `;
                    
                    // Add click event to navigate to product detail
                    item.addEventListener('click', () => {
                        window.location.href = `/web_ban_hang_copy/Product/show/${product.id}`;
                    });
                    
                    suggestionsContainer.appendChild(item);
                });
                
                suggestionsContainer.style.display = 'block';
            })
            .catch(error => {
                console.error('Error searching products:', error);
            });
    }, 300);
    
    // Format price with Vietnamese formatting
    function formatPrice(price) {
        return new Intl.NumberFormat('vi-VN').format(price);
    }
    
    // Handle input event to trigger search as user types
    searchInput.addEventListener('input', function() {
        const query = this.value.trim();
        searchProductsByName(query);
    });
    
    // Handle form submission to navigate to search results page
    searchForm.addEventListener('submit', function(e) {
        e.preventDefault();
        const query = searchInput.value.trim();
        
        if (query.length >= 2) {
            window.location.href = `/web_ban_hang_copy/Product/byName?q=${encodeURIComponent(query)}`;
        }
    });
    
    // Hide suggestions when clicking outside
    document.addEventListener('click', function(event) {
        if (!searchInput.contains(event.target) && !suggestionsContainer.contains(event.target)) {
            suggestionsContainer.style.display = 'none';
        }
    });
    
    // Show suggestions when focusing on search input if there's already text
    searchInput.addEventListener('focus', function() {
        if (this.value.trim().length >= 2) {
            searchProductsByName(this.value.trim());
        }
    });
});
</script>




