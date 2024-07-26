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

// Approve deposit
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['approve'])) {
    $deposit_id = $_POST['deposit_id'];
    $customer_id = $_POST['customer_id'];
    $amount = $_POST['amount'];
    $approval_date = $_POST['approval_date']; // Get the approval date from the form input

    // Start a transaction
    $conn->begin_transaction();

    try {
        // Update the pending deposit status to approved and set the approval date
        $sql_update = "UPDATE pending_deposits SET status = 'approved', approval_date = ? WHERE id = ?";
        $stmt_update = $conn->prepare($sql_update);
        if (!$stmt_update) {
            throw new Exception("Prepare failed: " . $conn->error);
        }
        $stmt_update->bind_param("si", $approval_date, $deposit_id);
        if (!$stmt_update->execute()) {
            throw new Exception("Execute failed: " . $stmt_update->error);
        }

        // Update the customer's balance
        $sql_update_balance = "UPDATE customers SET balance = balance + ? WHERE id = ?";
        $stmt_update_balance = $conn->prepare($sql_update_balance);
        if (!$stmt_update_balance) {
            throw new Exception("Prepare failed: " . $conn->error);
        }
        $stmt_update_balance->bind_param("di", $amount, $customer_id);
        if (!$stmt_update_balance->execute()) {
            throw new Exception("Execute failed: " . $stmt_update_balance->error);
        }

        // Commit the transaction
        $conn->commit();

        echo "Deposit of $amount approved successfully with date $approval_date.";
    } catch (Exception $e) {
        // Rollback the transaction
        $conn->rollback();

        echo "Error: " . $e->getMessage();
    }
}

// Fetch pending deposits
$sql_fetch = "SELECT pd.id, pd.customer_id, pd.amount, c.username 
              FROM pending_deposits pd 
              JOIN customers c ON pd.customer_id = c.id 
              WHERE pd.status = 'pending'";
$result = $conn->query($sql_fetch);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Approve Deposits - AB Bank</title>
    <link rel="stylesheet" href="agent_page.css">
</head>
<body>
    <header>
        <nav>
            <div class="logo">
                <img src="banklogo.jpg" alt="AB Bank Logo" class="logo-img">
                Grolden Bank
            </div>
            <ul class="nav-links">
                <li><a href="dashboard.php">Dashboard</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>

    <section class="approve-deposits">
        <div class="approve-container">
            <h1>Approve Deposits</h1>
            <?php
            if ($result->num_rows > 0) {
                echo "<table>
                        <tr>
                            <th>Deposit ID</th>
                            <th>Customer Username</th>
                            <th>Amount</th>
                            <th>Approval Date</th>
                            <th>Action</th>
                        </tr>";
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>{$row['id']}</td>
                            <td>{$row['username']}</td>
                            <td>{$row['amount']}</td>
                            <td>
                                <form action='approve_deposits.php' method='post'>
                                    <input type='date' name='approval_date' required>
                                    <input type='hidden' name='deposit_id' value='{$row['id']}'>
                                    <input type='hidden' name='customer_id' value='{$row['customer_id']}'>
                                    <input type='hidden' name='amount' value='{$row['amount']}'>
                                    <button type='submit' name='approve'>Approve</button>
                                </form>
                            </td>
                          </tr>";
                }
                echo "</table>";
            } else {
                echo "No pending deposits.";
            }
            ?>
        </div>
    </section>
</body>
</html>

<?php
$conn->close();
?>
