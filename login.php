<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>S.TSU Login</title>
  <style>
    * { box-sizing: border-box; margin: 0; padding: 0; }

    body {
      font-family: 'Segoe UI', Tahoma, sans-serif;
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
      background: url('../assets/background02.jpg') no-repeat center center/cover;
    }

    .wrapper {
      position: relative;
      width: 1000px;
      height: 600px;
      display: flex;
      justify-content: center;
      align-items: center;
    }

    .new-box {
      position: absolute;
      width: 120%;
      height: 100%;
      background: #ffffff;
      border-radius: 15px;
      box-shadow: 0 8px 25px rgba(0,0,0,0.15);
    }

    .login-container {
      position: relative;
      z-index: 2;
      background: rgba(255,255,255,0.95);
      padding: 40px 50px;
      border-radius: 20px;
      width: 350px;
      text-align: center;
      box-shadow: 0 10px 30px rgba(0,0,0,0.2);
      margin-left: auto;
      transform: translateX(50px); 
    }

    .login-header {
      font-size: 32px;  
      font-weight: 700;
      margin-bottom: 25px;
      color: #0048ff;
    }

    .form-group { margin-bottom: 20px; text-align: left; }
    .form-label { display: block; margin-bottom: 8px; font-weight: 600; color: #444; }
    .form-input {
      width: 100%;
      padding: 12px 15px;
      border: 2px solid #ccc;
      border-radius: 10px;
      font-size: 14px;
      outline: none;
    }
    .form-input:focus { border-color: #0048ff; }
    .login-btn {
      width: 100%;
      padding: 14px;
      background: #0048ff;
      color: #fff;
      font-size: 16px;
      font-weight: 600;
      border: none;
      border-radius: 10px;
      cursor: pointer;
    }
    .login-btn:hover { background: #0066ff; }
    .remember-forgot {
      display: flex;
      justify-content: space-between;
      align-items: center;
      font-size: 13px;
      margin: 15px 0;
    }
    .help-links { margin-top: 15px; font-size: 13px; }
    .help-links a { margin: 0 10px; color: #0048ff; text-decoration: none; }
    .help-links a:hover { text-decoration: underline; }
  </style>
</head>
<body>
  <div class="wrapper">
    <!-- กล่องพื้นหลัง -->
    <div class="new-box"></div>

    <!-- กล่อง Login -->
    <div class="login-container">
      <div class="login-header">LOGIN</div>
      <form action="login_process.php" method="post">
        <div class="form-group">
          <label for="email" class="form-label">Email</label>
          <input type="email" name="email" id="email" class="form-input" placeholder="Enter your email" required>
        </div>
        <div class="form-group">
          <label for="password" class="form-label">Password</label>
          <input type="password" name="password" id="password" class="form-input" placeholder="Enter your password" required>
        </div>
        <div class="remember-forgot">
          <label><input type="checkbox" name="remember"> Remember me</label>
          <a href="#">Forgot Password?</a>
        </div>
        <button type="submit" class="login-btn">Login</button>
      </form>
      <div class="help-links">
        <a href="#">Contact Support</a>
        <a href="#">Help</a>
      </div>
    </div>
  </div>
</body>
</html>
