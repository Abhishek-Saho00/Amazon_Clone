<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Amazon | Authentication</title>
  <link rel="stylesheet" href="style.css">

  <style>
    body{
      background:#f2f2f2;
      font-family: Arial;
    }

    .auth-container{
      width:360px;
      margin:80px auto;
      background:#fff;
      padding:25px;
      border-radius:8px;
      box-shadow:0 0 10px rgba(0,0,0,0.1);
    }

    h2{
      margin-bottom:15px;
    }

    input{
      width:100%;
      padding:10px;
      margin:8px 0;
    }

    button{
      width:100%;
      padding:10px;
      background:#ffd814;
      border:none;
      font-weight:bold;
      cursor:pointer;
      margin-top:10px;
    }

    .switch-text{
      margin-top:15px;
      text-align:center;
      font-size:14px;
    }

    .switch-text span{
      color:#007185;
      cursor:pointer;
    }

    #loginBox{
      display:none;
    }
  </style>
</head>
<body>
  <?php
if(isset($_SESSION['signup_success'])){
    echo "<script>
        alert('" . $_SESSION['signup_success'] . "');
        window.onload = function() {
            document.getElementById('signupBox').style.display = 'none';
            document.getElementById('loginBox').style.display = 'block';
        };
    </script>";
    unset($_SESSION['signup_success']);
}
?>



<div class="auth-container">

  <!-- SIGN UP -->
  <div id="signupBox">
    <h2>Sign Up</h2>
    <form action="/AMAZON_WEBSITE/BackEnd/signup.php" method="POST">
      <input type="text" name="username" placeholder="Username" required>
      <input type="email" name="email" placeholder="Email" required>
      <input type="password" name="password" placeholder="Password" required>
      <button type="submit">Create Account</button>
    </form>

    <div class="switch-text">
      Already have an account?
      <span onclick="showLogin()">Login</span>
    </div>
  </div>

  <!-- LOGIN -->
  <div id="loginBox">
    <h2>Login</h2>
   <form action="/AMAZON_WEBSITE/BackEnd/login.php" method="POST">
     <input type="email" name="email" placeholder="Email" required>
      <input type="password" name="password" placeholder="Password" required>
      <button type="submit">Login</button>
    </form>

    <div class="switch-text">
      New user?
      <span onclick="showSignup()">Create account</span>
    </div>
  </div>

</div>

<script>
  function showLogin(){
    document.getElementById("signupBox").style.display = "none";
    document.getElementById("loginBox").style.display = "block";
  }

  function showSignup(){
    document.getElementById("loginBox").style.display = "none";
    document.getElementById("signupBox").style.display = "block";
  }
</script>

</body>
</html>
