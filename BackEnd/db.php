<?php
// ========== IMPORTANT: UPDATE FOR PRODUCTION DEPLOYMENT ==========
// Before uploading to a hosting provider, update these credentials:
// $host is usually "localhost" on shared hosting
// $user and $pass are found in your hosting control panel (cPanel, etc.)
// $db should match the database name you created on your hosting provider
// ===================================================================

$host = "localhost";              // Usually stays "localhost"
$user = "root";                   // ← UPDATE FOR PRODUCTION
$pass = "";                       // ← UPDATE FOR PRODUCTION  
$db   = "amazon_clone";           // ← UPDATE IF DIFFERENT

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    error_log("Database Connection Error: " . $conn->connect_error);
    die("Database Connection Failed. Please contact the site administrator.");
}

// ================= CRUD FUNCTIONS FOR PRODUCTS =================

// CREATE - Add new product
function addProduct($name, $price, $image) {
    global $conn;
    $name = $conn->real_escape_string($name);
    $price = $conn->real_escape_string($price);
    $image = $conn->real_escape_string($image);
    
    $sql = "INSERT INTO products (name, price, image) VALUES ('$name', '$price', '$image')";
    
    if ($conn->query($sql) === TRUE) {
        return ["success" => true, "message" => "Product added successfully"];
    } else {
        return ["success" => false, "message" => "Error: " . $conn->error];
    }
}

// READ - Get all products
function getAllProducts() {
    global $conn;
    $sql = "SELECT * FROM products";
    $result = $conn->query($sql);
    
    $products = [];
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $products[] = $row;
        }
    }
    return $products;
}

// READ - Get single product by ID
function getProductById($id) {
    global $conn;
    $id = intval($id);
    $sql = "SELECT * FROM products WHERE id = $id";
    $result = $conn->query($sql);
    
    if ($result && $result->num_rows > 0) {
        return $result->fetch_assoc();
    }
    return null;
}

// UPDATE - Edit product
function updateProduct($id, $name, $price, $image) {
    global $conn;
    $id = intval($id);
    $name = $conn->real_escape_string($name);
    $price = $conn->real_escape_string($price);
    $image = $conn->real_escape_string($image);
    
    $sql = "UPDATE products SET name='$name', price='$price', image='$image' WHERE id=$id";
    
    if ($conn->query($sql) === TRUE) {
        return ["success" => true, "message" => "Product updated successfully"];
    } else {
        return ["success" => false, "message" => "Error: " . $conn->error];
    }
}

// DELETE - Remove product
function deleteProduct($id) {
    global $conn;
    $id = intval($id);
    $sql = "DELETE FROM products WHERE id = $id";
    
    if ($conn->query($sql) === TRUE) {
        return ["success" => true, "message" => "Product deleted successfully"];
    } else {
        return ["success" => false, "message" => "Error: " . $conn->error];
    }
}

?>

