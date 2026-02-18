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

    .error-message {
      color: #d32f2f;
      background: #ffebee;
      padding: 10px;
      margin-bottom: 15px;
      border-radius: 4px;
      border-left: 4px solid #d32f2f;
    }

    .success-message {
      color: #388e3c;
      background: #e8f5e9;
      padding: 10px;
      margin-bottom: 15px;
      border-radius: 4px;
      border-left: 4px solid #388e3c;
    }
  </style>
</head>
<body>
  <?php
  $login_error = isset($_SESSION['login_error']) ? $_SESSION['login_error'] : '';
  $signup_error = isset($_SESSION['signup_error']) ? $_SESSION['signup_error'] : '';
  $signup_success = isset($_SESSION['signup_success']) ? $_SESSION['signup_success'] : '';
  
  unset($_SESSION['login_error']);
  unset($_SESSION['signup_error']);
  unset($_SESSION['signup_success']);
  ?>
  
  <script>
    var loginError = '<?php echo addslashes($login_error); ?>';
    var signupError = '<?php echo addslashes($signup_error); ?>';
    var signupSuccess = '<?php echo addslashes($signup_success); ?>';
    
    window.onload = function() {
      if (signupSuccess) {
        alert(signupSuccess);
        document.getElementById('signupBox').style.display = 'none';
        document.getElementById('loginBox').style.display = 'block';
      } else if (loginError) {
        alert(loginError);
        // Show the login box when login error occurs
        document.getElementById('signupBox').style.display = 'none';
        document.getElementById('loginBox').style.display = 'block';
      } else if (signupError) {
        alert(signupError);
      }
    };
  </script>



<div class="auth-container">

  <!-- SIGN UP -->
  <div id="signupBox">
    <h2>Sign Up</h2>
    <form action="/Amazon_webSite/BackEnd/signup.php" method="POST">
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
  <form action="/Amazon_webSite/BackEnd/login.php" method="POST">
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
