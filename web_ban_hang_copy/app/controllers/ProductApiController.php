<?php
require_once('app/config/database.php');
require_once('app/models/ProductModel.php');
require_once('app/models/CategoryModel.php');

require_once('app/utils/JWTHandler.php'); //
class ProductApiController
{
    private $productModel;
    private $db;
    private $jwtHandler; //
    public function __construct()
    {
        $this->db = (new Database())->getConnection();
        $this->productModel = new ProductModel($this->db);

        $this->jwtHandler = new JWTHandler(); //
    }
    private function authenticate()
    {
        $headers = apache_request_headers();
        if (isset($headers['Authorization'])) {
            $authHeader = $headers['Authorization'];
            $arr = explode(" ", $authHeader);
            $jwt = $arr[1] ?? null;
            if ($jwt) {
                $decoded = $this->jwtHandler->decode($jwt);
                return $decoded ? true : false;
            }
        }
        return false;
    }
    // Lấy danh sách sản phẩm
    public function index()
    {
        header('Content-Type: application/json');
        $products = $this->productModel->getProducts();
        echo json_encode($products);
        // if ($this->authenticate()) {
        //     header('Content-Type: application/json');
        //     $products = $this->productModel->getProducts();
        //     echo json_encode($products);
        // } else {
        //     http_response_code(401);
        //     echo json_encode(['message' => 'Unauthorized']);
        // }
    }
    // Lấy thông tin sản phẩm theo ID
    public function show($id)
    {
        header('Content-Type: application/json');
        $product = $this->productModel->getProductById($id);
        if ($product) {
            echo json_encode($product);
        } else {
            http_response_code(404);
            echo json_encode(['message' => 'Product not found']);
        }
        // header('Content-Type: application/json');
        // $product = $this->productModel->getProductById($id);
        // if ($product) {
        //     echo json_encode($product);
        // } else {
        //     http_response_code(404);
        //     echo json_encode(['message' => 'Product not found']);
        // }
    }
    // Thêm sản phẩm mới
    public function store()
    {
        header('Content-Type: application/json');

        // Kiểm tra loại request
        $contentType = $_SERVER["CONTENT_TYPE"] ?? '';

        if (strpos($contentType, 'application/json') !== false) {
            // Xử lý dữ liệu JSON
            $data = json_decode(file_get_contents("php://input"), true);

            $name = $data['name'] ?? '';
            $description = $data['description'] ?? '';
            $price = $data['price'] ?? '';
            $category_id = $data['category_id'] ?? null;
            $image = $data['image'] ?? '';
        } else {
            // Xử lý dữ liệu form
            $name = $_POST['name'] ?? '';
            $description = $_POST['description'] ?? '';
            $price = $_POST['price'] ?? '';
            $category_id = $_POST['category_id'] ?? null;

            // Xử lý upload file
            $image = '';
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $uploadDir = 'uploads/';
                if (!file_exists($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }

                $fileName = basename($_FILES['image']['name']);
                $uploadFile = $uploadDir . $fileName;

                if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadFile)) {
                    $image = $uploadFile;
                }
            }
        }

        // Gọi phương thức addProduct
        $result = $this->productModel->addProduct(
            $name,
            $description,
            $price,
            $category_id,
            $image
        );

        // Xử lý kết quả
        if (is_array($result)) {
            http_response_code(400);
            echo json_encode(['errors' => array_values($result)]); // Chuyển thành mảng để phù hợp với frontend
        } else {
            http_response_code(201);
            echo json_encode(['message' => 'Product created successfully']);
        }
    }
    // Cập nhật sản phẩm theo ID

    public function update($id)
    {
        header('Content-Type: application/json');

        // Kiểm tra loại request
        $contentType = $_SERVER["CONTENT_TYPE"] ?? '';

        if (strpos($contentType, 'application/json') !== false) {
            // Xử lý dữ liệu JSON
            $data = json_decode(file_get_contents("php://input"), true);

            $name = $data['name'] ?? '';
            $description = $data['description'] ?? '';
            $price = $data['price'] ?? '';
            $category_id = $data['category_id'] ?? null;

            // Lấy giá trị ảnh hiện tại từ database nếu không được cung cấp trong JSON
            if (!isset($data['image']) || empty($data['image'])) {
                $existingProduct = $this->productModel->getProductById($id);
                $image = $existingProduct->image ?? '';
            } else {
                $image = $data['image'];
            }
        } else {
            // Xử lý dữ liệu form
            $name = $_POST['name'] ?? '';
            $description = $_POST['description'] ?? '';
            $price = $_POST['price'] ?? '';
            $category_id = $_POST['category_id'] ?? null;

            // Lấy sản phẩm hiện tại từ database
            $existingProduct = $this->productModel->getProductById($id);
            $image = $existingProduct->image ?? '';

            // Xử lý upload file mới nếu có
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $uploadDir = 'uploads/';
                if (!file_exists($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }

                $fileName = basename($_FILES['image']['name']);
                $uploadFile = $uploadDir . $fileName;

                if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadFile)) {
                    $image = $uploadFile;
                }
            }
        }

        // Gọi phương thức updateProduct
        $result = $this->productModel->updateProduct(
            $id,
            $name,
            $description,
            $price,
            $category_id,
            $image
        );

        // Xử lý kết quả
        if ($result) {
            http_response_code(200);
            echo json_encode(['message' => 'Product updated successfully']);
        } else {
            http_response_code(400);
            echo json_encode(['message' => 'Product update failed']);
        }
    }
    // Xóa sản phẩm theo ID
    public function destroy($id)
    {
        header('Content-Type: application/json');
        $result = $this->productModel->deleteProduct($id);
        if ($result) {
            echo json_encode(['message' => 'Product deleted successfully']);
        } else {
            http_response_code(400);
            echo json_encode(['message' => 'Product deletion failed']);
        }
    }
}
?>