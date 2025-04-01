<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sửa sản phẩm</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        /* Form container styling */
        .edit-container {
            background-color: #ffffff;
            border-radius: 15px;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.15);
            padding: 30px;
            max-width: 700px;
            margin: 40px auto;
        }

        .form-header {
            text-align: center;
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 2px solid #f0f0f0;
        }

        .form-title {
            color: #343a40;
            font-weight: 700;
            font-size: 28px;
        }

        /* Form field styling */
        .form-group label {
            font-weight: 600;
            color: #555;
            margin-bottom: 8px;
        }

        .form-control {
            border-radius: 8px;
            padding: 12px;
            border: 1px solid #ddd;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: #17a2b8;
            box-shadow: 0 0 0 0.2rem rgba(23, 162, 184, 0.25);
        }

        /* Image preview styling */
        .image-preview-container {
            margin-top: 15px;
            padding: 10px;
            border-radius: 8px;
            background-color: #f8f9fa;
        }

        .image-preview {
            max-width: 150px;
            max-height: 150px;
            border-radius: 8px;
            border: 1px solid #ddd;
            padding: 5px;
            background-color: white;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        /* Button styling */
        .btn-save {
            background-color: #28a745;
            color: white;
            border: none;
            font-weight: 600;
            padding: 10px 25px;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .btn-back {
            background-color: #6c757d;
            color: white;
            border: none;
            font-weight: 600;
            padding: 10px 20px;
            border-radius: 8px;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
        }

        .btn-save:hover, .btn-back:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 10px rgba(0, 0, 0, 0.3);
            background-color:rgb(168, 170, 169)
        }

        .form-actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 30px;
        }

        /* Error message styling */
        .alert-danger {
            border-left: 4px solid #dc3545;
            border-radius: 8px;
        }

        /* Custom file input */
        .custom-file-label::after {
            content: "Duyệt";
        }

        /* Mobile responsiveness */
        @media (max-width: 768px) {
            .edit-container {
                width: 90%;
                padding: 20px;
                margin: 20px auto;
            }

            .form-actions {
                flex-direction: column;
                gap: 10px;
            }

            .btn-save, .btn-back {
                width: 100%;
                text-align: center;
                justify-content: center;
            }
        }
    </style>
</head>

<body>
    <?php include 'app/views/shares/header.php'; ?>

    <div class="container">
        <div class="edit-container">
            <div class="form-header">
                <h1 class="form-title"><i class="fas fa-edit mr-2"></i>Sửa sản phẩm</h1>
            </div>

            <?php if (!empty($errors)): ?>
            <div class="alert alert-danger">
                <ul class="mb-0">
                    <?php foreach ($errors as $error): ?>
                    <li><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <?php endif; ?>

            <form method="POST" action="/web_ban_hang_copy/Product/update" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?php echo $product->id; ?>">
                
                <div class="form-group">
                    <label for="name"><i class="fas fa-tag mr-2"></i>Tên sản phẩm:</label>
                    <input type="text" id="name" name="name" class="form-control" 
                        value="<?php echo htmlspecialchars($product->name, ENT_QUOTES, 'UTF-8'); ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="description"><i class="fas fa-align-left mr-2"></i>Mô tả:</label>
                    <textarea id="description" name="description" class="form-control" rows="4" required><?php 
                        echo htmlspecialchars($product->description, ENT_QUOTES, 'UTF-8'); 
                    ?></textarea>
                </div>
                
                <div class="form-group">
                    <label for="price"><i class="fas fa-dollar-sign mr-2"></i>Giá (USD):</label>
                    <input type="number" id="price" name="price" class="form-control" step="0.01"
                        value="<?php echo htmlspecialchars($product->price, ENT_QUOTES, 'UTF-8'); ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="category_id"><i class="fas fa-folder mr-2"></i>Danh mục:</label>
                    <select id="category_id" name="category_id" class="form-control" required>
                        <?php foreach ($categories as $category): ?>
                        <option value="<?php echo $category->id; ?>" <?php echo $category->id == $product->category_id ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($category->name, ENT_QUOTES, 'UTF-8'); ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="image"><i class="fas fa-image mr-2"></i>Hình ảnh:</label>
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" id="image" name="image">
                        <label class="custom-file-label" for="image">Chọn file...</label>
                    </div>
                    <input type="hidden" name="existing_image" value="<?php echo $product->image; ?>">
                    
                    <?php if ($product->image): ?>
                    <div class="image-preview-container mt-3">
                        <p class="mb-2"><strong>Hình ảnh hiện tại:</strong></p>
                        <img src="/<?php echo $product->image; ?>" alt="Product Image" class="image-preview">
                    </div>
                    <?php endif; ?>
                </div>
                
                <div class="form-actions">
                    <button type="submit" class="btn btn-save">
                        <i class="fas fa-save mr-2"></i>Lưu thay đổi
                    </button>
                    <a href="/web_ban_hang_copy/Product" class="btn btn-back">
                        <i class="fas fa-arrow-left mr-2"></i>Quay lại danh sách
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Footer is included via PHP include, not repeated here -->

    <!-- JavaScript libraries -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        // Display selected filename in the custom file input
        $(".custom-file-input").on("change", function() {
            var fileName = $(this).val().split("\\").pop();
            $(this).siblings(".custom-file-label").addClass("selected").html(fileName || "Chọn file...");
        });

        // Handle form submission via Fetch API
        document.querySelector("form").addEventListener("submit", function(e) {
            e.preventDefault();

            const formData = new FormData(this);
            const productId = formData.get("id");

            fetch(`/web_ban_hang_copy/api/product/update/${productId}`, {
                method: "POST",
                body: formData,
            })
            .then(response => {
                if (!response.ok) {
                    return response.json().then(data => {
                        throw data;
                    });
                }
                return response.json();
            })
            .then(data => {
                alert("Sản phẩm đã được cập nhật thành công!");
                window.location.href = "/web_ban_hang_copy/Product";
            })
            .catch(error => {
                alert("Đã xảy ra lỗi khi cập nhật sản phẩm: " + (error.message || "Không xác định"));
            });
        });
    </script>
</body>
<?php include 'app/views/shares/footer.php'; ?>
</html>