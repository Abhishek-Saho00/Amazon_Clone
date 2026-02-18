<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "amazon_clone";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Database Connection Failed");
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

