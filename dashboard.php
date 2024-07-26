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

$userid = $_SESSION['userid'];
$sql = "SELECT username, fullname, email, balance FROM customers WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userid);
$stmt->execute();
$stmt->bind_result($username, $fullname, $email, $balance);
$stmt->fetch();
$stmt->close();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Grolden Bank</title>
    <link rel="stylesheet" href="dashboard.css">
</head>
<body>
    <header>
        <nav>
            <div class="logo">
                <img src="banklogo.jpg" alt="AB Bank Logo" class="logo-img">
                Grolden Bank
            </div>
            <ul class="nav-links">
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>

    <section class="dashboard">
        <div class="dashboard-container">
            <h1>Welcome, <?php echo htmlspecialchars($fullname); ?>!</h1>
            <p>Account Balance: $<?php echo number_format($balance, 2); ?></p>

            <div class="actions">
                <form action="transfer_money.php" method="post">
                    <h2>Transfer Money</h2>
                    <input type="number" name="amount" placeholder="Amount" required <?php if ($balance < 1) echo 'disabled'; ?>>
                    <input type="text" name="recipient" placeholder="Recipient Username" required <?php if ($balance < 1) echo 'disabled'; ?>>
                    <button type="submit" <?php if ($balance < 1) echo 'disabled'; ?>>Transfer</button>
                    <?php if ($balance < 1) echo '<p style="color:red;">Insufficient balance to transfer money.</p>'; ?>
                </form>
                <form action="deposit_money.php" method="post">
                     <h2>Deposit Money</h2>
                     <input type="number" name="amount" placeholder="Amount" required>
                     <button type="submit">Submit Deposit Request</button>
                </form>


                <!-- <form action="deposit_money.php" method="post">
                    <h2>Deposit Money</h2>
                    <input type="number" name="amount" placeholder="Amount">
                    <button type="submit">Deposit</button>
                </form> -->
                <a href="loan_request.php">For Loan</a>
                <!-- Add this inside the dashboard section in dashboard.php -->
<!-- Add this inside the dashboard section in dashboard.php -->
<div class="actions">
    <!-- Other forms -->
    <a href="loan_status.php">View Loan Status</a>
</div>
<a href="transaction_history.php">View Transaction History</a>




                <!-- <form action="loan_request.php" method="post">
                    <h2>Request a Loan</h2>
                    <input type="number" name="amount" placeholder="Amount" required>
                    <button type="submit">Request Loan</button>
                    <a href="loan_request.php">For Loan</a>
                </form> -->
            </div>
        </div>
    </section>

    <footer>
        <p>&copy; 2024 Grolden Bank. All rights reserved.</p>
    </footer>
</body>
</html>

<?php
$conn->close();
?>
