<?php
session_start();

if (!isset($_SESSION['userid'])) {
    header("Location: login.php");
    exit();
}

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
    $userid = $_SESSION['userid'];
    $amount = $_POST['amount'];
    $reason = $_POST['reason'];

    // Validate amount (check if positive)
    if ($amount <= 0) {
        echo "Invalid amount. Please enter a positive number.";
        exit();
    }

    // Prepare and execute SQL statement to insert pending loan request
    $sql_insert = "INSERT INTO pending_loans (customer_id, amount, reason, status) VALUES (?, ?, ?, 'pending')";
    $stmt_insert = $conn->prepare($sql_insert);
    $stmt_insert->bind_param("ids", $userid, $amount, $reason);

    // Execute the insert statement
    if ($stmt_insert->execute()) {
        echo "Loan request of $amount successfully submitted for approval.";
    } else {
        echo "Error: " . $conn->error;
    }

    $stmt_insert->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Request Loan - Grolden Bank</title>
    <link rel="stylesheet" href="loan_request.css">
</head>
<body>
    <header>
        <nav>
            <div class="logo">
                <img src="banklogo.jpg" alt="Grolden Bank Logo" class="logo-img">
                Grolden Bank
            </div>
            <ul class="nav-links">
                <li><a href="dashboard.php">Dashboard</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>

    <section class="loan-request">
        <div class="loan-request-container">
            <h1>Request a Loan</h1>
            <form action="loan_request.php" method="post">
                <div class="form-group">
                    <label for="amount">Amount</label>
                    <input type="number" id="amount" name="amount" step="0.01" min="0" required>
                </div>
                <div class="form-group">
                    <label for="reason">Reason</label>
                    <textarea id="reason" name="reason" required></textarea>
                </div>
                <button type="submit">Submit Loan Request</button>
            </form>
        </div>
    </section>


</body>
</html>

<?php
$conn->close();
?>
