<?php
session_start();
include 'db.php';

if($_SERVER["REQUEST_METHOD"] == "POST"){

    $username = $_POST['username'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    
    // Validate that all fields are not empty
    if (empty($username) || empty($email) || empty($password)) {
        $_SESSION['signup_error'] = "All fields are required.";
        header("Location: /Amazon_webSite/FrontEnd/auth.php");
        exit();
    }
    
    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['signup_error'] = "Invalid email format.";
        header("Location: /Amazon_webSite/FrontEnd/auth.php");
        exit();
    }
    
    $password = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $email, $password);

    if ($stmt->execute()) {

        $_SESSION['signup_success'] = "Signup successful! Now login.";

    header("Location: /Amazon_webSite/FrontEnd/auth.php");
    exit();

    } else {

        $_SESSION['signup_error'] = "Email already exists. Please use a different email.";
        header("Location: /Amazon_webSite/FrontEnd/auth.php");
        exit();

    }

} else {

    header("Location: /Amazon_webSite/FrontEnd/auth.php");
    exit();

}
?>
