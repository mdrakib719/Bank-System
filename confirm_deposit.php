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
    $userid = $_POST['userid'];

    // Get current balance and deposit_pending
    $sql = "SELECT balance, deposit_pending FROM customers WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $userid);
    $stmt->execute();
    $stmt->bind_result($balance, $deposit_pending);
    $stmt->fetch();
    $stmt->close();

    // Update balance and reset deposit_pending
    $new_balance = $balance + $deposit_pending;
    $sql = "UPDATE customers SET balance = ?, deposit_pending = 0 WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("di", $new_balance, $userid);
    if ($stmt->execute()) {
        echo "Deposit confirmed successfully.";
    } else {
        echo "Error confirming deposit: " . $conn->error;
    }
    $stmt->close();
}

$conn->close();

header("Location: agent_page.php");
exit();
?>
