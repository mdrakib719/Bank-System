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
    $accountName = $_POST['account_name'];
    $sql = "SELECT id, username, fullname, email, balance, deposit_pending FROM customers WHERE fullname LIKE ?";
    $stmt = $conn->prepare($sql);
    $likeAccountName = "%" . $accountName . "%";
    $stmt->bind_param("s", $likeAccountName);
    $stmt->execute();
    $result = $stmt->get_result();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agent Page - AB Bank</title>
    <link rel="stylesheet" href="agent_page.css">
</head>
<body>
    <header>
        <nav>
            <div class="logo">
                <img src="banklogo.jpg" alt="AB Bank Logo" class="logo-img">
                AB Bank
            </div>
            <ul class="nav-links">
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>

    <section class="agent">
        <div class="agent-container">
            <h1>Bank Agent Dashboard</h1>
            <form action="agent_page.php" method="post">
                <input type="text" name="account_name" placeholder="Search by account name" required>
                <button type="submit">Search</button>
            </form>

            <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                if ($result->num_rows > 0) {
                    echo '<table>';
                    echo '<tr><th>ID</th><th>Username</th><th>Full Name</th><th>Email</th><th>Balance</th><th>Deposit Pending</th><th>Action</th></tr>';
                    while ($row = $result->fetch_assoc()) {
                        echo '<tr>';
                        echo '<td>' . $row['id'] . '</td>';
                        echo '<td>' . $row['username'] . '</td>';
                        echo '<td>' . $row['fullname'] . '</td>';
                        echo '<td>' . $row['email'] . '</td>';
                        echo '<td>' . $row['balance'] . '</td>';
                        echo '<td>' . $row['deposit_pending'] . '</td>';
                        echo '<td>';
                        if ($row['deposit_pending'] > 0) {
                            echo '<form action="confirm_deposit.php" method="post" style="display:inline;">
                                    <input type="hidden" name="userid" value="' . $row['id'] . '">
                                    <button type="submit">Confirm Deposit</button>
                                  </form>';
                        }
                        echo '</td>';
                        echo '</tr>';
                    }
                    echo '</table>';
                } else {
                    echo "<p>No accounts found.</p>";
                }
            }
            ?>
        </div>
    </section>

    <footer>
        <p>&copy; 2024 AB Bank. All rights reserved.</p>
    </footer>
</body>
</html>

<?php
$conn->close();
?>
