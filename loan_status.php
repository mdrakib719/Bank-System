<?php
session_start();

// Database connection details
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

// Fetch loan statuses
$sql_fetch = "SELECT ls.loan_id, c.username, ls.amount, ls.approval_time, TIMESTAMPDIFF(MINUTE, NOW(), DATE_ADD(ls.approved_at, INTERVAL ls.approval_time MINUTE)) AS time_remaining
              FROM loan_status ls
              JOIN customers c ON ls.customer_id = c.id";
$result = $conn->query($sql_fetch);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Loan Status - Grolden Bank</title>
    <link rel="stylesheet" href="agent_page.css">
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

    <section class="loan-status">
        <div class="loan-status-container">
            <h1>Loan Status</h1>
            <?php
            if ($result->num_rows > 0) {
                echo "<table>
                        <tr>
                            <th>Loan ID</th>
                            <th>Customer Username</th>
                            <th>Amount</th>
                            <th>Approval Time (minutes)</th>
                            <th>Time Remaining (minutes)</th>
                        </tr>";
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>{$row['loan_id']}</td>
                            <td>{$row['username']}</td>
                            <td>{$row['amount']}</td>
                            <td>{$row['approval_time']}</td>
                            <td>{$row['time_remaining']}</td>
                          </tr>";
                }
                echo "</table>";
            } else {
                echo "No loan statuses available.";
            }
            ?>
        </div>
    </section>
</body>
</html>

<?php
$conn->close();
?>
