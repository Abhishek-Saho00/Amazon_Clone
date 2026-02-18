<?php
include '../BackEnd/db.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action'])) {
    if ($_GET['action'] === 'get_all') {
        $products = getAllProducts();
        echo json_encode(["products" => $products]);
        exit;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $action = $_POST['action'];

    if ($action === 'add') {
        $name = $_POST['name'] ?? '';
        $price = $_POST['price'] ?? '';

        // Handle uploaded image if provided
        $image = '';
        if (isset($_FILES['productImage']) && $_FILES['productImage']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = __DIR__ . '/../FrontEnd/images/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }

            $tmpName = $_FILES['productImage']['tmp_name'];
            $origName = basename($_FILES['productImage']['name']);
            $ext = strtolower(pathinfo($origName, PATHINFO_EXTENSION));
            $allowed = ['jpg','jpeg','png','gif','webp','svg'];
            if (!in_array($ext, $allowed)) {
                echo json_encode(["success" => false, "message" => "Invalid image type"]);
                exit;
            }

            // create unique filename to avoid collisions
            $safeName = time() . '_' . preg_replace('/[^a-zA-Z0-9_\.-]/', '_', $origName);
            $dest = $uploadDir . $safeName;

            if (move_uploaded_file($tmpName, $dest)) {
                $image = $safeName;
            } else {
                echo json_encode(["success" => false, "message" => "Failed to move uploaded file"]);
                exit;
            }
        } else {
            // fallback to text field if front-end passed a filename
            $image = $_POST['image'] ?? '';
        }

        if (!$name || !$price || !$image) {
            echo json_encode(["success" => false, "message" => "All fields are required"]);
            exit;
        }

        $result = addProduct($name, $price, $image);
        echo json_encode($result);
        exit;
    }

    if ($action === 'update') {
        $id = $_POST['id'] ?? '';
        $name = $_POST['name'] ?? '';
        $price = $_POST['price'] ?? '';
        $image = $_POST['image'] ?? '';

        if (!$id || !$name || !$price || !$image) {
            echo json_encode(["success" => false, "message" => "All fields are required"]);
            exit;
        }

        $result = updateProduct($id, $name, $price, $image);
        echo json_encode($result);
        exit;
    }

    if ($action === 'delete') {
        $id = $_POST['id'] ?? '';

        if (!$id) {
            echo json_encode(["success" => false, "message" => "Product ID is required"]);
            exit;
        }

        $result = deleteProduct($id);
        echo json_encode($result);
        exit;
    }
}

echo json_encode(["success" => false, "message" => "Invalid request"]);
?>
