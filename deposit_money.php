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
$amount = $_POST['amount'];

// Insert into pending_deposits table
$sql_insert_deposit = "INSERT INTO pending_deposits (customer_id, amount) VALUES (?, ?)";
$stmt_insert_deposit = $conn->prepare($sql_insert_deposit);
$stmt_insert_deposit->bind_param("id", $userid, $amount);

if ($stmt_insert_deposit->execute()) {
    echo "Deposit request submitted for approval.";
} else {
    echo "Error submitting deposit request: " . $conn->error;
}

$stmt_insert_deposit->close();
$conn->close();
?>
