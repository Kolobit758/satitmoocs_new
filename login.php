<?php
include "includes/db.php"

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
</head>
<body>
    <h2>Login</h2>
    <form action="login_process.php" method="post">
        <label>Email:</label>
        <input type="email" name="email" required><br><br>
        
        <label>Password:</label>
        <input type="password" name="password" required><br><br>
        kkk
        <button type="submit">Login</button>
    </form>
</body>
</html>
