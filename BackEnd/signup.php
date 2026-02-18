<?php
session_start();
include 'db.php';

if($_SERVER["REQUEST_METHOD"] == "POST"){

    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $email, $password);

    if ($stmt->execute()) {

        $_SESSION['signup_success'] = "Signup successful! Now login.";

       header("Location: /AMAZON_WEBSITE/FrontEnd/auth.php");
exit();

        exit();

    } else {

        echo "Email already exists";

    }

} else {

    header("Location: http://localhost/Amazon webSite/FrontEnd/auth.php");
    exit();

}
?>
