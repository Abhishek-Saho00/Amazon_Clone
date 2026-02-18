<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: /Amazon_webSite/FrontEnd/auth.php");
    exit();
}

include 'db.php';

$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';

if (empty($email) || empty($password)) {
    $_SESSION['login_error'] = "Email and password are required.";
    header("Location: /Amazon_webSite/FrontEnd/auth.php");
    exit();
}

$stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows > 0) {

    $user = $result->fetch_assoc();

    if (password_verify($password, $user['password'])) {

        $_SESSION['username'] = $user['username'];
        
        // Check if user is admin
        if (isset($user['is_admin']) && $user['is_admin'] == 1) {
            $_SESSION['admin'] = true;
            header("Location: /Amazon_webSite/admin/index.php");
        } else {
            header("Location: /Amazon_webSite/FrontEnd/index.php");
        }
        exit();

    } else {
        $_SESSION['login_error'] = "Wrong password. Please try again.";
        header("Location: /Amazon_webSite/FrontEnd/auth.php");
        exit();
    }

} else {
    $_SESSION['login_error'] = "User not found. Please sign up first.";
    header("Location: /Amazon_webSite/FrontEnd/auth.php");
    exit();
}


?>
