<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <style>
    * {
      box-sizing: border-box;
    }

    body {
      background: linear-gradient(135deg, #f5f6fa 0%, #e9ecef 100%);
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
      margin: 0;
      padding: 20px;
    }

    .login-container {
      background: #fff;
      padding: 40px;
      border: 1px solid #e0e0e0;
      border-radius: 12px;
      width: 420px;
      max-width: 100%;
      box-shadow: 0 8px 25px rgba(0,0,0,0.15);
      position: relative;
      font-size: 16px;
    }

    .login-container::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      height: 4px;
      background: linear-gradient(90deg, #556d75, #455a63);
    }

    .login-container h1 {
      font-size: 34px;
      color: #2c3e50;
      text-align: center;
      margin-bottom: 25px;
      font-weight: 700;
    }

    .input-group {
      position: relative;
      margin-bottom: 18px;
    }

    input[type="text"],
    input[type="password"] {
      width: 100%;
      padding: 14px 16px;
      border: 2px solid #e1e5e9;
      border-radius: 8px;
      font-size: 15px;
      background: #fafbfc;
      transition: all 0.3s ease;
    }

    input[type="text"]:focus,
    input[type="password"]:focus {
      outline: none;
      border-color: #556d75;
      background: #fff;
      box-shadow: 0 0 0 3px rgba(85, 109, 117, 0.1);
    }

    .remember-me {
      display: flex;
      align-items: center;
      margin-bottom: 20px;
      font-size: 14px;
      color: #666;
    }

    .remember-me input[type="checkbox"] {
      margin-right: 8px;
      transform: scale(1.1);
    }

    button[type="submit"] {
      width: 100%;
      padding: 14px;
      background: linear-gradient(135deg, #556d75 0%, #455a63 100%);
      border: none;
      border-radius: 8px;
      font-size: 16px;
      font-weight: 600;
      color: #fff;
      cursor: pointer;
      transition: all 0.3s ease;
    }

    button[type="submit"]:hover {
      background: linear-gradient(135deg, #455a63 0%, #3a4f57 100%);
      transform: translateY(-2px);
      box-shadow: 0 6px 20px rgba(85, 109, 117, 0.3);
    }

    .extra-link {
      text-align: center;
      margin-top: 15px;
    }

    .extra-link a {
      color: #0275d8;
      text-decoration: none;
      font-size: 14px;
    }

    .extra-link a:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>
  <div class="login-container">
    <h1>Login</h1>
    <form action="login_process.php" method="post">
      <div class="input-group">
        <input type="text" name="username" placeholder="Username" required>
      </div>
      
      <div class="input-group">
        <input type="password" name="password" placeholder="Password" required>
      </div>

      <div class="remember-me">
        <input type="checkbox" name="remember" id="remember">
        <label for="remember">Remember me</label>
      </div>

      <button type="submit">Log in</button>
    </form>

    <div class="extra-link">
      <p><a href="forgot_password.php">Forgot your password?</a></p>
    </div>
  </div>
</body>
</html>
