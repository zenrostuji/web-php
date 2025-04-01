<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm sản phẩm mới</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        /* Form container styling */
        .add-container {
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
            background-color:rgb(168, 170, 169);
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
            .add-container {
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
        <div class="add-container">
            <div class="form-header">
                <h1 class="form-title"><i class="fas fa-plus-circle mr-2"></i>Thêm sản phẩm mới</h1>
            </div>

            <div id="error-messages" class="alert alert-danger d-none">
                <ul class="mb-0"></ul>
            </div>

            <div id="success-message" class="alert alert-success d-none">
                Sản phẩm đã được thêm thành công!
            </div>

            <form id="add-product-form" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="name"><i class="fas fa-tag mr-2"></i>Tên sản phẩm:</label>
                    <input type="text" id="name" name="name" class="form-control" required>
                </div>
                
                <div class="form-group">
                    <label for="description"><i class="fas fa-align-left mr-2"></i>Mô tả:</label>
                    <textarea id="description" name="description" class="form-control" rows="4" required></textarea>
                </div>
                
                <div class="form-group">
                    <label for="price"><i class="fas fa-dollar-sign mr-2"></i>Giá:</label>
                    <input type="number" id="price" name="price" class="form-control" step="0.01" required>
                </div>
                
                <div class="form-group">
                    <label for="category_id"><i class="fas fa-folder mr-2"></i>Danh mục:</label>
                    <select id="category_id" name="category_id" class="form-control" required>
                        <?php foreach ($categories as $category): ?>
                        <option value="<?php echo $category->id; ?>">
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
                </div>
                
                <div class="form-actions">
                    <button type="submit" class="btn btn-save">
                        <i class="fas fa-save mr-2"></i>Thêm sản phẩm
                    </button>
                    <a href="/web_ban_hang_copy/Product" class="btn btn-back">
                        <i class="fas fa-arrow-left mr-2"></i>Quay lại danh sách
                    </a>
                </div>
            </form>
        </div>
    </div>
    <?php include 'app/views/shares/footer.php'; ?>
    <!-- JavaScript libraries -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        // Display selected filename in the custom file input
        document.querySelector(".custom-file-input").addEventListener("change", function () {
            const fileName = this.value.split("\\").pop();
            this.nextElementSibling.classList.add("selected");
            this.nextElementSibling.innerHTML = fileName || "Chọn file...";
        });

        // Handle form submission via Fetch API
        document.getElementById("add-product-form").addEventListener("submit", function (e) {
            e.preventDefault();

            const formData = new FormData(this);

            fetch('/web_ban_hang_copy/api/product/store', {
                method: 'POST',
                body: formData
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
                document.getElementById("error-messages").classList.add("d-none");
                document.getElementById("success-message").classList.remove("d-none");
                this.reset();
                document.querySelector(".custom-file-label").innerHTML = "Chọn file...";
                // Redirect to the product list page after successful addition
                window.location.href = '/web_ban_hang_copy/Product';
            })
            .catch(error => {
                const errorMessages = document.getElementById("error-messages");
                const errorList = errorMessages.querySelector("ul");
                errorList.innerHTML = "";
                (error.errors || ["Đã xảy ra lỗi không xác định."]).forEach(err => {
                    const li = document.createElement("li");
                    li.textContent = err;
                    errorList.appendChild(li);
                });
                errorMessages.classList.remove("d-none");
                document.getElementById("success-message").classList.add("d-none");
            });
        });
    </script>
</body>
</html>