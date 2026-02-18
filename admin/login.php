<?php
session_start();

// Simple admin login page (no password required per user request).
// WARNING: This is insecure for production. Use only on local/dev or secure it.

// If already logged in as admin, redirect to dashboard
if (isset($_SESSION['admin']) && $_SESSION['admin'] === true) {
    header("Location: /Amazon_webSite/admin/index.php");
    exit();
}

$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');

    // Simple check: allow admin if email matches the expected admin email
    if (strtolower($email) === 'admin@amazon.com') {
        $_SESSION['admin'] = true;
        // Optionally set username for display
        $_SESSION['username'] = 'admin';
        header("Location: /Amazon_webSite/admin/index.php");
        exit();
    } else {
        $message = 'Unknown admin email.';
    }
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Admin Login</title>
  <style>
    body{font-family:Arial, sans-serif;background:#f2f2f2}
    .box{width:380px;margin:80px auto;background:white;padding:24px;border-radius:8px;box-shadow:0 6px 20px rgba(0,0,0,0.08)}
    input{width:100%;padding:10px;margin:8px 0;border:1px solid #ddd;border-radius:4px}
    button{width:100%;padding:12px;background:#ffd814;border:none;border-radius:4px;font-weight:bold}
    .hint{font-size:13px;color:#666;margin-top:10px}
    .error{color:#c62828;margin-bottom:10px}
  </style>
</head>
<body>
  <div class="box">
    <h2>Admin Login</h2>
    <?php if ($message): ?><div class="error"><?php echo htmlspecialchars($message); ?></div><?php endif; ?>
    <form method="post" action="">
      <label for="email">Admin Email</label>
      <input id="email" name="email" type="email" placeholder="admin@amazon.com" required>
      <button type="submit">Login as Admin</button>
    </form>
    <div class="hint">This page grants admin access..</div>
    <div class="hint"><a href="<?php echo rtrim(dirname(dirname($_SERVER['SCRIPT_NAME'])), '/'); ?>/FrontEnd/auth.php">Back to User Login</a></div>
  </div>
</body>
</html>
