<?php
// Require SessionHelper and other necessary files
require_once('app/config/database.php');
require_once('app/models/ProductModel.php');
require_once('app/models/CategoryModel.php');
class ProductController
{
    private $productModel;
    private $db;
    public function __construct()
    {
        $this->db = (new Database())->getConnection();
        $this->productModel = new ProductModel($this->db);
    }
    public function index()
    {
        $products = $this->productModel->getProducts();
        include 'app/views/product/list.php';
    }
    public function show($id)
    {
        $product = $this->productModel->getProductById($id);

        if ($product) {
            include 'app/views/product/show.php';
        } else {
            http_response_code(404); // Set HTTP response code to 404
            include 'app/views/errors/404.php'; // Hiển thị trang lỗi 404
        }
    }

    public function add()
    {
        // Only allow access if the user is an admin
        if (!SessionHelper::isAdmin()) {
            http_response_code(404);
            include_once 'app/views/errors/404.php';
            exit();
        }

        $categories = (new CategoryModel($this->db))->getCategories();
        include_once 'app/views/product/add.php';
    }

    public function save()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Only allow saving if the user is an admin
            if (!SessionHelper::isAdmin()) {
                http_response_code(404);
                include_once 'app/views/errors/404.php';
                exit();
            }

            $name = $_POST['name'] ?? '';
            $description = $_POST['description'] ?? '';
            $price = $_POST['price'] ?? '';
            $category_id = $_POST['category_id'] ?? null;

            if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
                $image = $this->uploadImage($_FILES['image']);
            } else {
                $image = "";
            }

            $result = $this->productModel->addProduct(
                $name,
                $description,
                $price,
                $category_id,
                $image
            );

            if (is_array($result)) {
                $errors = $result;
                $categories = (new CategoryModel($this->db))->getCategories();
                include 'app/views/product/add.php';
            } else {
                header('Location: /web_ban_hang_copy/Product');
            }
        }
    }

    public function edit($id)
    {
        // Only allow editing if the user is an admin
        if (!SessionHelper::isAdmin()) {
            http_response_code(404); // Set HTTP response code to 404
            include_once 'app/views/errors/404.php';
            exit();
        }

        $product = $this->productModel->getProductById($id);
        $categories = (new CategoryModel($this->db))->getCategories();
        if ($product) {
            include 'app/views/product/edit.php';
        } else {
            echo "Không thấy sản phẩm.";
        }
    }

    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Only allow updates if the user is an admin
            if (!SessionHelper::isAdmin()) {
                http_response_code(404); // Set HTTP response code to 404
                include_once 'app/views/errors/404.php';
                exit();
            }

            $id = $_POST['id'];
            $name = $_POST['name'];
            $description = $_POST['description'];
            $price = $_POST['price'];
            $category_id = $_POST['category_id'];

            if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
                $image = $this->uploadImage($_FILES['image']);
            } else {
                $image = $_POST['existing_image'];
            }

            $edit = $this->productModel->updateProduct(
                $id,
                $name,
                $description,
                $price,
                $category_id,
                $image
            );

            if ($edit) {
                header('Location: /web_ban_hang_copy/Product');
            } else {
                echo "Đã xảy ra lỗi khi lưu sản phẩm.";
            }
        }
    }

    public function delete($id)
    {
        // Only allow deleting if the user is an admin
        if (!SessionHelper::isAdmin()) {
            http_response_code(404); // Set HTTP response code to 404
            include_once 'app/views/errors/404.php';
            exit();
        }

        if ($this->productModel->deleteProduct($id)) {
            header('Location: /web_ban_hang_copy/Product');
        } else {
            echo "Đã xảy ra lỗi khi xóa sản phẩm.";
        }
    }

    private function uploadImage($file)
    {
        $target_dir = "uploads/";
        // Kiểm tra và tạo thư mục nếu chưa tồn tại
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        $target_file = $target_dir . basename($file["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        // Kiểm tra xem file có phải là hình ảnh không
        $check = getimagesize($file["tmp_name"]);
        if ($check === false) {
            throw new Exception("File không phải là hình ảnh.");
        }
        // Kiểm tra kích thước file (10 MB = 10 * 1024 * 1024 bytes)
        if ($file["size"] > 10 * 1024 * 1024) {
            throw new Exception("Hình ảnh có kích thước quá lớn.");
        }
        // Chỉ cho phép một số định dạng hình ảnh nhất định
        if (
            $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType !=
            "jpeg" && $imageFileType != "gif"
        ) {

            throw new Exception("Chỉ cho phép các định dạng JPG, JPEG, PNG và GIF.");
        }
        // Lưu file
        if (!move_uploaded_file($file["tmp_name"], $target_file)) {
            throw new Exception("Có lỗi xảy ra khi tải lên hình ảnh.");
        }
        return $target_file;
    }

    public function addToCart($id)
    {
        if (!SessionHelper::isLoggedIn()) {
            header('Location: /web_ban_hang_copy/account/login');
            return;
        }

        $userId = $_SESSION['user_id'];
        $this->productModel->addToCart($userId, $id);
        header('Location: /web_ban_hang_copy/Product/cart');
    }

    public function cart()
    {
        if (!SessionHelper::isLoggedIn()) {
            header('Location: /web_ban_hang_copy/account/login');
            return;
        }

        $userId = $_SESSION['user_id'];
        $cart = $this->productModel->getCartByUserId($userId);
        include 'app/views/product/cart.php';
    }

    public function updateQuantity($productId)
    {
        if (!SessionHelper::isLoggedIn()) {
            echo json_encode(['success' => false, 'message' => 'Unauthorized']);
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $userId = $_SESSION['user_id'];
            $quantity = intval($_POST['quantity']);

            if ($quantity > 0) {
                $this->productModel->updateCartQuantity($userId, $productId, $quantity);

                // Get updated cart total
                $cart = $this->productModel->getCartByUserId($userId);
                $totalPrice = array_reduce($cart, function ($carry, $item) {
                    return $carry + ($item['price'] * $item['quantity']);
                }, 0);

                echo json_encode([
                    "success" => true,
                    "totalPrice" => $totalPrice
                ]);
                exit();
            }
        }
        echo json_encode(["success" => false]);
    }

    public function deleteItem($productId)
    {
        if (!SessionHelper::isLoggedIn()) {
            header('Location: /web_ban_hang_copy/account/login');
            return;
        }

        $userId = $_SESSION['user_id'];
        $this->productModel->removeFromCart($userId, $productId);
        header('Location: /web_ban_hang_copy/Product/cart');
    }

    public function processCheckout()
    {
        if (!SessionHelper::isLoggedIn()) {
            header('Location: /web_ban_hang_copy/account/login');
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $userId = $_SESSION['user_id'];
            $name = $_POST['name'];
            $phone = $_POST['phone'];
            $address = $_POST['address'];

            $cart = $this->productModel->getCartByUserId($userId);
            if (empty($cart)) {
                echo "Giỏ hàng trống.";
                return;
            }

            $this->db->beginTransaction();
            try {
                // Create order
                $stmt = $this->db->prepare("INSERT INTO orders (user_id, name, phone, address) VALUES (:user_id, :name, :phone, :address)");
                $stmt->execute([
                    ':user_id' => $userId,
                    ':name' => $name,
                    ':phone' => $phone,
                    ':address' => $address
                ]);
                $orderId = $this->db->lastInsertId();

                // Create order details from cart items
                foreach ($cart as $item) {
                    $stmt = $this->db->prepare("INSERT INTO order_details (order_id, product_id, quantity, price) VALUES (:order_id, :product_id, :quantity, :price)");
                    $stmt->execute([
                        ':order_id' => $orderId,
                        ':product_id' => $item['product_id'],
                        ':quantity' => $item['quantity'],
                        ':price' => $item['price']
                    ]);
                }

                // Clear the cart
                $this->productModel->clearCart($userId);

                $this->db->commit();
                header('Location: /web_ban_hang_copy/Product/orderConfirmation');
            } catch (Exception $e) {
                $this->db->rollBack();
                echo "Đã xảy ra lỗi khi xử lý đơn hàng: " . $e->getMessage();
            }
        }
    }

    public function orderConfirmation()
    {
        include 'app/views/product/orderConfirmation.php';
    }

    // Add this method to your ProductController class
    public function byCategory($category_id)
    {
        $products = $this->productModel->getProductsByCategory($category_id);

        // Get category name
        require_once('app/models/CategoryModel.php');
        $categoryModel = new CategoryModel($this->db);
        $category = $categoryModel->getCategoryById($category_id);
        $categoryName = $category ? $category->name : 'Unknown';

        include 'app/views/product/by_category.php';
    }

    public function search()
    {
        $query = isset($_GET['q']) ? trim($_GET['q']) : '';

        if (strlen($query) < 2) {
            header('Content-Type: application/json');
            echo json_encode([]);
            return;
        }

        try {
            $products = $this->productModel->searchProducts($query);
            
            // Process image paths for each product
            foreach ($products as &$product) {
                if (!empty($product['image'])) {
                    // Add path prefix if needed
                    if (strpos($product['image'], '/web_ban_hang_copy/') !== 0) {
                        $product['image'] = '/web_ban_hang_copy/' . $product['image'];
                    }
                } else {
                    $product['image'] = '/web_ban_hang_copy/uploads/default.png';
                }
            }

            header('Content-Type: application/json');
            echo json_encode($products);
        } catch (PDOException $e) {
            error_log('Search error: ' . $e->getMessage());
            header('Content-Type: application/json');
            echo json_encode([]);
        }
    }

    public function searchResults()
    {
        $searchQuery = isset($_GET['q']) ? trim($_GET['q']) : '';

        if (strlen($searchQuery) < 2) {
            header('Location: /web_ban_hang_copy/');
            exit;
        }

        try {
            $products = $this->productModel->searchProducts($searchQuery);
            include 'app/views/product/search-results.php';
        } catch (PDOException $e) {
            error_log('Search results error: ' . $e->getMessage());
            $products = [];
            include 'app/views/product/search-results.php';
        }
    }

    public function byName()
    {
        $searchQuery = isset($_GET['q']) ? trim($_GET['q']) : '';

        if (strlen($searchQuery) < 2) {
            header('Location: /web_ban_hang_copy/');
            exit;
        }

        try {
            $products = $this->productModel->searchProducts($searchQuery);
            $pageTitle = "Tìm kiếm: " . htmlspecialchars($searchQuery);
            include 'app/views/product/search-results.php';
        } catch (PDOException $e) {
            error_log('Search error: ' . $e->getMessage());
            $products = [];
            $pageTitle = "Tìm kiếm: " . htmlspecialchars($searchQuery);
            include 'app/views/product/search-results.php';
        }
    }

    public function QL_category()
    {
        if (!SessionHelper::isAdmin()) {
            http_response_code(404);
            include_once 'app/views/errors/404.php';
            exit();
        }
        include 'app/views/product/QL_category.php';
    }

    public function Checkout()
    {
        include 'app/views/product/Checkout.php';
    }
}
?>