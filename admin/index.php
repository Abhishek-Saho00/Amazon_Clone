<?php 
session_start();

if (!isset($_SESSION['admin'])) {
    // Redirect to dedicated admin login page (no user password required)
    header("Location: /Amazon_webSite/admin/login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            box-sizing: border-box;
        }

        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .admin-container {
            background-color: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
            max-width: 500px;
            width: 100%;
        }

        h1 {
            color: #131921;
            text-align: center;
            margin-bottom: 10px;
            font-size: 28px;
        }

        .subtitle {
            text-align: center;
            color: #666;
            margin-bottom: 30px;
            font-size: 14px;
        }

        .menu-items {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .menu-item {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .menu-item a {
            background-color: #FF9900;
            color: white;
            padding: 15px 20px;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            text-align: center;
            transition: background-color 0.3s;
            font-size: 16px;
        }

        .menu-item a:hover {
            background-color: #e68a00;
        }

        .menu-item.secondary a {
            background-color: #0066c0;
        }

        .menu-item.secondary a:hover {
            background-color: #004ba0;
        }

        .menu-item.danger a {
            background-color: #d32f2f;
        }

        .menu-item.danger a:hover {
            background-color: #b71c1c;
        }

        .footer {
            text-align: center;
            margin-top: 30px;
            color: #999;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <div class="admin-container">
        <h1>🎯 Admin Dashboard</h1>
        <p class="subtitle">Product Management System</p>

        <div class="menu-items">
            <div class="menu-item">
                <a href="products.php">📦 Manage Products (CRUD)</a>
            </div>
            <div class="menu-item secondary">
                <a href="../FrontEnd/index.php">🏠 Back to Homepage</a>
            </div>
            <div class="menu-item danger">
                <a href="../BackEnd/logout.php" onclick="event.preventDefault(); fetch('/Amazon_webSite/BackEnd/logout.php', {credentials:'same-origin'}).then(()=>{ window.location='/Amazon_webSite/FrontEnd/auth.php'; }).catch(()=>{ window.location='/Amazon_webSite/FrontEnd/auth.php'; });">🚪 Logout</a>
            </div>
        </div>

        <div class="footer">
            <p>Amazon Clone - Product Management v1.0</p>
        </div>
    </div>
</body>
</html>
