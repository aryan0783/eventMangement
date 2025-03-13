<!DOCTYPE html>
<html>
<head>
    <title>Event Registration & Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #ff7a18, #af002d);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            flex-direction: column;
            margin: 0;
        }
        .container {
            background: #ffffff;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
            width: 350px;
            text-align: center;
            background-color: rgba(255, 255, 255, 0.9);
        }
        h2 {
            color: #4a148c;
            font-size: 24px;
            margin-bottom: 20px;
            font-weight: bold;
        }
        input[type="text"], input[type="password"] {
            width: 90%;
            padding: 12px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
            box-sizing: border-box;
        }
        .button-group {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }
        input[type="submit"] {
            width: 48%;
            padding: 12px;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: all 0.3s ease-in-out;
        }
        .register {
            background: #28a745;
        }
        .register:hover {
            background: #218838;
            transform: scale(1.05);
        }
        .login {
            background: #007bff;
        }
        .login:hover {
            background: #0056b3;
            transform: scale(1.05);
        }
        .forgot-password {
            display: block;
            margin-top: 10px;
            font-size: 14px;
            color: #007bff;
            text-decoration: none;
        }
        .forgot-password:hover {
            text-decoration: underline;
        }
        .footer {
            margin-top: 20px;
            font-size: 14px;
            color: #777;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Event Registration and Login</h2>
        <form method="post">
            <input type="text" name="username" placeholder="Enter Username" required><br>
            <input type="password" name="password" placeholder="Enter Password" required><br><br>
            <div class="button-group">
                <input type="submit" name="register" value="Register" class="register">
                <input type="submit" name="login" value="Login" class="login">
            </div>
        </form>
        <a href="#" class="forgot-password">Forgot Password?</a>
        <div class="footer">
            <p>© 2025 Event Management System</p>
        </div>
    </div>

<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "user_db";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if (isset($_POST['register'])) {
        // Register user
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);
        $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
        $stmt->bind_param("ss", $username, $hashed_password);
        if ($stmt->execute()) {
            echo "<h2>User registered successfully!</h2>";
        } else {
            echo "Error: " . $stmt->error;
        }
        $stmt->close();
    } elseif (isset($_POST['login'])) {
        // Authenticate user
        $stmt = $conn->prepare("SELECT password FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->bind_result($hashed_password);
        if ($stmt->fetch() && password_verify($password, $hashed_password)) {
            // Redirect to index.html after successful login
            header("Location: index.html");
            exit();
        } else {
            echo "<h2>Invalid username or password!</h2>";
        }
        $stmt->close();
    }
}
?>
</body>
</html>
