<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bank";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Prepare SQL query
    $sql = "SELECT id, username, password, fullname, email, balance FROM customers WHERE username = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();

        // Check if the username exists
        if ($stmt->num_rows == 1) {
            $stmt->bind_result($id, $username, $hashed_password, $fullname, $email, $balance);
            $stmt->fetch();

            // Verify password
            if (password_verify($password, $hashed_password)) {
                // Password is correct, start a session
                $_SESSION['userid'] = $id;
                $_SESSION['username'] = $username;
                $_SESSION['fullname'] = $fullname;
                $_SESSION['email'] = $email;
                $_SESSION['balance'] = $balance;
                header("Location: dashboard.php");
                exit();
            } else {
                echo "Invalid password.";
            }
        } else {
            echo "Invalid username.";
        }

        $stmt->close();
    } else {
        echo "Error preparing statement: " . $conn->error;
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Goldren Bank</title>
    <link rel="stylesheet" href="login_page.css">
</head>
<body>
    <header>
        <nav>
            <div class="logo">
                <a href="home_page.php">
                    <img src="banklogo.jpg" alt="Goldren Bank Logo" class="logo-img">
                </a>
                Goldren Bank
            </div>
            <ul class="nav-links">
                <li><a href="home_page.php">Home</a></li>
                <li class="dropdown">
                    <a href="#">Accounts</a>
                    <ul class="dropdown-content">
                        <li><a href="#">Savings</a></li>
                        <li><a href="#">Current</a></li>
                        <li><a href="#">Student Account</a></li>
                    </ul>
                </li>
                <li><a href="#">Loans</a></li>
                <li><a href="#">Contact</a></li>
            </ul>
        </nav>
    </header>

    <section class="login">
        <div class="login-container">
            <h1>Login to Your Account</h1>
            <form action="login.php" method="post">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" required>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <button type="submit" class="login-button">Login</button>
                <p class="register-link">
                    Don't have an account? <a href="chataccount.php">Register here</a>.
                </p>
            </form>
        </div>
    </section>

    <footer>
        <p>&copy; 2024 Goldren Bank. All rights reserved.</p>
    </footer>
</body>
</html>
