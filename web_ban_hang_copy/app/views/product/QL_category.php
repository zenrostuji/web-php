<?php include 'app/views/shares/header.php'; ?>

<div class="container mt-5">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h4 class="mb-0"><i class="fas fa-tags"></i> Quản lý Loại sản phẩm</h4>
            <button id="add-category-btn" class="btn btn-light">
                <i class="fas fa-plus"></i> Thêm Loại sản phẩm
            </button>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-striped">
                    <thead class="thead-light">
                        <tr>
                            <th width="10%">ID</th>
                            <th width="30%">Tên Loại</th>
                            <th width="40%">Mô tả</th>
                            <th width="20%">Hành động</th>
                        </tr>
                    </thead>
                    <tbody id="category-table-body">
                        <!-- Categories will be dynamically loaded here -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal for Add/Edit Category -->
<div class="modal fade" id="category-modal" tabindex="-1" role="dialog" aria-labelledby="categoryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="categoryModalLabel">
                    <i class="fas fa-tag"></i> Thêm Loại sản phẩm
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="category-form">
                    <input type="hidden" id="category-id">
                    <div class="form-group">
                        <label for="category-name"><i class="fas fa-font"></i> Tên Loại</label>
                        <input type="text" class="form-control" id="category-name" required>
                    </div>
                    <div class="form-group">
                        <label for="category-description"><i class="fas fa-align-left"></i> Mô tả</label>
                        <textarea class="form-control" id="category-description" rows="3"></textarea>
                    </div>
                    <div class="text-right mt-4">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                            <i class="fas fa-times"></i> Hủy
                        </button>
                        <button type="submit" class="btn btn-primary ml-2">
                            <i class="fas fa-save"></i> Lưu
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        // Load categories
        function loadCategories() {
            $.get('/web_ban_hang_copy/CategoryApi/index', function (categories) {
                const tbody = $('#category-table-body');
                tbody.empty();
                categories.forEach(category => {
                    tbody.append(`
                        <tr>
                            <td>${category.id}</td>
                            <td>${category.name}</td>
                            <td>${category.description}</td>
                            <td>
                                <button class="btn btn-warning btn-sm edit-category-btn" data-id="${category.id}" data-name="${category.name}" data-description="${category.description}">
                                    <i class="fas fa-edit"></i> Sửa
                                </button>
                                <button class="btn btn-danger btn-sm delete-category-btn ml-1" data-id="${category.id}">
                                    <i class="fas fa-trash"></i> Xóa
                                </button>
                            </td>
                        </tr>
                    `);
                });
            });
        }

        loadCategories();

        // Show modal for adding a new category
        $('#add-category-btn').click(function () {
            $('#category-id').val('');
            $('#category-name').val('');
            $('#category-description').val('');
            $('#categoryModalLabel').text('Thêm Loại sản phẩm');
            $('#category-modal').modal('show');
        });

        // Show modal for editing a category
        $(document).on('click', '.edit-category-btn', function () {
            const id = $(this).data('id');
            const name = $(this).data('name');
            const description = $(this).data('description');
            $('#category-id').val(id);
            $('#category-name').val(name);
            $('#category-description').val(description);
            $('#categoryModalLabel').text('Sửa Loại sản phẩm');
            $('#category-modal').modal('show');
        });

        // Save category (Add/Edit)
        $('#category-form').submit(function (e) {
            e.preventDefault();
            const id = $('#category-id').val();
            const name = $('#category-name').val();
            const description = $('#category-description').val();
            const url = id ? `/web_ban_hang_copy/CategoryApi/update/${id}` : '/web_ban_hang_copy/CategoryApi/store';
            const method = id ? 'PUT' : 'POST';

            $.ajax({
                url: url,
                method: method,
                contentType: 'application/json',
                data: JSON.stringify({ name, description }),
                success: function () {
                    $('#category-modal').modal('hide');
                    loadCategories();
                },
                error: function () {
                    alert('Có lỗi xảy ra!');
                }
            });
        });

        // Delete category
        $(document).on('click', '.delete-category-btn', function () {
            const id = $(this).data('id');
            if (confirm('Bạn có chắc chắn muốn xóa loại sản phẩm này?')) {
                $.ajax({
                    url: `/web_ban_hang_copy/CategoryApi/destroy/${id}`,
                    method: 'DELETE',
                    success: function () {
                        loadCategories();
                    },
                    error: function () {
                        alert('Có lỗi xảy ra!');
                    }
                });
            }
        });
    });
</script>

<?php include 'app/views/shares/footer.php'; ?>
