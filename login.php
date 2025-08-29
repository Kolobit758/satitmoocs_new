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
      padding: 50px;
      border: 1px solid #e0e0e0;
      border-radius: 12px;
      min-width: 700px;
      max-width: 100%;
      box-shadow: 0 8px 25px rgba(0,0,0,0.15);
      position: relative;
      overflow: hidden;
      font-size: 18px;
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

    .login-content {
      display: flex;
      justify-content: space-between;
      gap: 30px;
      margin-top: 20px;
    }

    .login-left {
      flex: 1;
    }

    .login-right {
      flex: 1;
      font-size: 14px;
      color: #666;
      line-height: 1.6;
    }

    .login-right a {
      color: #0275d8;
      text-decoration: none;
      transition: color 0.3s ease;
    }

    .login-right a:hover {
      color: #025aa5;
      text-decoration: underline;
    }

    .login-right .help-icon {
      display: inline-block;
      width: 16px;
      height: 16px;
      background: #0275d8;
      color: white;
      border-radius: 50%;
      text-align: center;
      line-height: 16px;
      font-size: 10px;
      margin-left: 5px;
      cursor: help;
      position: relative;
    }

    .login-right .help-icon:hover::after {
      content: 'Some sites require cookies to be enabled for login functionality';
      position: absolute;
      bottom: 25px;
      left: 50%;
      transform: translateX(-50%);
      background: #333;
      color: white;
      padding: 8px 12px;
      border-radius: 6px;
      font-size: 11px;
      white-space: nowrap;
      z-index: 1000;
      box-shadow: 0 4px 12px rgba(0,0,0,0.3);
    }


    .input-group {
      position: relative;
      margin-bottom: 20px;
    }

    input[type="text"],
    input[type="password"] {
      width: 100%;
      padding: 18px 20px;
      border: 2px solid #e1e5e9;
      border-radius: 8px;
      font-size: 16px;
      transition: all 0.3s ease;
      background: #fafbfc;
    }

    input[type="text"]:focus,
    input[type="password"]:focus {
      outline: none;
      border-color: #556d75;
      background: #fff;
      box-shadow: 0 0 0 3px rgba(85, 109, 117, 0.1);
      transform: translateY(-2px);
    }

    input[type="text"]:valid,
    input[type="password"]:valid {
      border-color: #28a745;
    }

    .input-icon {
      position: absolute;
      right: 16px;
      top: 50%;
      transform: translateY(-50%);
      color: #aaa;
      transition: color 0.3s ease;
    }

    input:focus + .input-icon {
      color: #556d75;
    }

    button[type="submit"] {
      width: 100%;
      padding: 20px;
      background: linear-gradient(135deg, #556d75 0%, #455a63 100%);
      border: none;
      border-radius: 8px;
      font-size: 18px;
      font-weight: 600;
      color: #fff;
      cursor: pointer;
      transition: all 0.3s ease;
      position: relative;
      overflow: hidden;
      margin-top: 10px;
    }

    button[type="submit"]::before {
      content: '';
      position: absolute;
      top: 0;
      left: -100%;
      width: 100%;
      height: 100%;
      background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
      transition: left 0.5s ease;
    }

    button[type="submit"]:hover {
      background: linear-gradient(135deg, #455a63 0%, #3a4f57 100%);
      transform: translateY(-2px);
      box-shadow: 0 6px 20px rgba(85, 109, 117, 0.3);
    }

    button[type="submit"]:hover::before {
      left: 100%;
    }

    button[type="submit"]:active {
      transform: translateY(0);
      box-shadow: 0 2px 10px rgba(85, 109, 117, 0.3);
    }

    .login-container h1 {
      font-size: 42px;
      color: #2c3e50;
      text-align: center;
      margin-bottom: 10px;
      font-weight: 700;
      letter-spacing: -0.5px;
      position: relative;
    }

    .remember-me {
      display: flex;
      align-items: center;
      margin-bottom: 20px;
      font-size: 15px;
      color: #666;
    }

    .remember-me input[type="checkbox"] {
      margin-right: 8px;
      transform: scale(1.1);
    }

    .divider {
      text-align: center;
      margin: 30px 0 20px 0;
      position: relative;
      color: #999;
      font-size: 12px;
    }

    .divider::before {
      content: '';
      position: absolute;
      top: 50%;
      left: 0;
      right: 0;
      height: 1px;
      background: #e0e0e0;
    }

    .divider span {
      background: #fff;
      padding: 0 15px;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
      .login-container {
        min-width: auto;
        width: 100%;
        max-width: 400px;
        padding: 30px 25px;
        margin: 20px;
      }

      .login-content {
        flex-direction: column;
        gap: 20px;
      }

      .login-container h1 {
        font-size: 28px;
      }
    }

    /* Loading animation */
    .loading {
      pointer-events: none;
    }

    .loading::after {
      content: '';
      position: absolute;
      top: 50%;
      left: 50%;
      width: 20px;
      height: 20px;
      border: 2px solid transparent;
      border-top: 2px solid #fff;
      border-radius: 50%;
      animation: spin 1s linear infinite;
      transform: translate(-50%, -50%);
    }

    @keyframes spin {
      0% { transform: translate(-50%, -50%) rotate(0deg); }
      100% { transform: translaฆte(-50%, -50%) rotate(360deg); }
    }

    /* Success feedback */
    .success-message {
      background: #d4edda;
      color: #155724;
      padding: 12px 16px;
      border-radius: 6px;
      border: 1px solid #c3e6cb;
      margin-bottom: 20px;
      display: none;
      font-size: 15px; /* ข้อความแจ้งเตือนชัดขึ้น */
      padding: 16px 20px; /* เพิ่มช่องว่าง */
    }

    .error-message {
      background: #f8d7da;
      color: #721c24;
      padding: 12px 16px;
      border-radius: 6px;
      border: 1px solid #f5c6cb;
      margin-bottom: 20px;
      display: none;
       font-size: 15px; /* ข้อความแจ้งเตือนชัดขึ้น */
      padding: 16px 20px; /* เพิ่มช่องว่าง */
      }
  </style>
</head>
<body>
  <div class="login-container">
    <h1>Login</h1>
    
    <div class="success-message" id="successMessage">
      Login successful! Redirecting...
    </div>
    
    <div class="error-message" id="errorMessage">
      Invalid username or password. Please try again.
    </div>

    <div class="login-content">
      <div class="login-left">
        <form action="login_process.php" method="post" id="loginForm">
          <div class="input-group">
            <input type="text" name="email" placeholder="Email" required>
            <span class="input-icon">👤</span>
          </div>
          
          <div class="input-group">
            <input type="password" name="password" placeholder="Password" required>
            <span class="input-icon">🔒</span>
          </div>

          <div class="remember-me">
            <input type="checkbox" name="remember" id="remember">
            <label for="remember">Remember me</label>
          </div>

          <button type="submit" id="loginBtn">Log in</button>
        </form>
      </div>

      <div class="login-right">
        <p><a href="#" onclick="showForgotPassword()">Forgotten your username or password?</a></p>
        <p>Cookies must be enabled in your browser <span class="help-icon">?</span></p>
        
        <div class="divider">
          <span>Need help?</span>
        </div>
        
        <p><a href="#" onclick="showContactSupport()">Contact Support</a></p>
        <p><a href="#" onclick="showBrowserHelp()">Browser Settings Help</a></p>
      </div>
    </div>
  </div>

  
</body>
</html>