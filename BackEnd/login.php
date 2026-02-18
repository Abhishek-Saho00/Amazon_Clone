<?php
session_start();   // ✅ ADD THIS LINE

include 'db.php';

$email = $_POST['email'];
$password = $_POST['password'];

$stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows > 0) {

    $user = $result->fetch_assoc();

    if (password_verify($password, $user['password'])) {

        $_SESSION['username'] = $user['username'];  // ✅ ADD THIS LINE

        header("Location: /AMAZON_WEBSITE/FrontEnd/index.php");
exit();

    // ✅ CHANGE THIS LINE
        exit();

    } else {
        echo "Wrong Password";
    }

} else {
    echo "User Not Found";
}


?>
