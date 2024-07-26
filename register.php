<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - AB Bank</title>
    <link rel="stylesheet" href="login_page.css">
</head>
<body>
    <section class="login">
        <div class="login-container">
            <h1>Register New Account</h1>
            <form action="register.php" method="post">
                <div class="form-group">
                    <label for="username">User name</label>
                    <input type="text" id="username" name="username" required>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <div class="form-group">
                    <label for="fullname">Full Name</label>
                    <input type="text" id="fullname" name="fullname" required>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <button type="submit" class="login-button">Register</button>
                <p class="register-link">Already have an account? <a href="login.php">Login here</a>.</p>
            </form>
        </div>
    </section>
</body>
</html>

<?php
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
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];

    // Check if username already exists
    $sql_check = "SELECT id FROM customers WHERE username = ?";
    $stmt_check = $conn->prepare($sql_check);
    $stmt_check->bind_param("s", $username);
    $stmt_check->execute();
    $stmt_check->store_result();

    if ($stmt_check->num_rows > 0) {
        echo "Username already exists. Please choose another username.";
    } else {
        // Proceed with registration
        $sql_insert = "INSERT INTO customers (username, password, fullname, email) VALUES (?, ?, ?, ?)";
        if ($stmt_insert = $conn->prepare($sql_insert)) {
            $stmt_insert->bind_param("ssss", $username, $password, $fullname, $email);

            if ($stmt_insert->execute()) {
                echo "Registration successful!";
            } else {
                echo "Error: " . $stmt_insert->error;
            }

            $stmt_insert->close();
        }
    }

    $stmt_check->close();
}

$conn->close();
?>
