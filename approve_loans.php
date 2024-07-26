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

// Approve loan
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['approve'])) {
    $loan_id = $_POST['loan_id'];
    $customer_id = $_POST['customer_id'];
    $amount = $_POST['amount'];
    $approval_time = $_POST['approval_time'];

    // Start a transaction
    $conn->begin_transaction();

    try {
        // Update the pending loan status to approved
        $sql_update = "UPDATE pending_loans SET status = 'approved', approved_at = NOW(), approval_time = ? WHERE id = ?";
        $stmt_update = $conn->prepare($sql_update);
        $stmt_update->bind_param("ii", $approval_time, $loan_id);
        $stmt_update->execute();

        if ($stmt_update->affected_rows === 0) {
            throw new Exception("Failed to update loan status.");
        }

        // Update the customer's balance
        $sql_update_balance = "UPDATE customers SET balance = balance + ? WHERE id = ?";
        $stmt_update_balance = $conn->prepare($sql_update_balance);
        $stmt_update_balance->bind_param("di", $amount, $customer_id);
        $stmt_update_balance->execute();

        if ($stmt_update_balance->affected_rows === 0) {
            throw new Exception("Failed to update customer's balance.");
        }

        // Insert the loan status into loan_status table
        $sql_insert_loan_status = "INSERT INTO loan_status (loan_id, customer_id, amount, approval_time) VALUES (?, ?, ?, ?)";
        $stmt_insert_loan_status = $conn->prepare($sql_insert_loan_status);
        $stmt_insert_loan_status->bind_param("iidi", $loan_id, $customer_id, $amount, $approval_time);
        $stmt_insert_loan_status->execute();

        if ($stmt_insert_loan_status->affected_rows === 0) {
            throw new Exception("Failed to insert into loan_status.");
        }

        // Fetch the customer's email
        $sql_fetch_email = "SELECT email FROM customers WHERE id = ?";
        $stmt_fetch_email = $conn->prepare($sql_fetch_email);
        $stmt_fetch_email->bind_param("i", $customer_id);
        $stmt_fetch_email->execute();
        $stmt_fetch_email->bind_result($email);
        $stmt_fetch_email->fetch();

        if (empty($email)) {
            throw new Exception("Failed to fetch customer's email.");
        }

        // Send email notification
        $to = $email;
        $subject = "Loan Approved";
        $message = "Dear customer, your loan request of $amount has been approved.";
        $headers = "From: no-reply@grolden_bank.com";

        if (!mail($to, $subject, $message, $headers)) {
            throw new Exception("Failed to send email notification.");
        }

        // Commit the transaction
        $conn->commit();

        echo "Loan request of $amount approved successfully. Email sent to customer.";

    } catch (Exception $e) {
        // Rollback the transaction
        $conn->rollback();

        // Log the error message (in a real application, consider logging to a file)
        error_log("Error: " . $e->getMessage());

        echo "Error: " . $e->getMessage();
    }
}

// Fetch pending loans
$sql_fetch = "SELECT pl.id, pl.customer_id, pl.amount, pl.reason, c.username 
              FROM pending_loans pl 
              JOIN customers c ON pl.customer_id = c.id 
              WHERE pl.status = 'pending'";
$result = $conn->query($sql_fetch);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Approve Loans - Grolden Bank</title>
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

    <section class="approve-loans">
        <div class="approve-container">
            <h1>Approve Loans</h1>
            <?php
            if ($result->num_rows > 0) {
                echo "<table>
                        <tr>
                            <th>Loan ID</th>
                            <th>Customer Username</th>
                            <th>Amount</th>
                            <th>Reason</th>
                            <th>Approval Time (minutes)</th>
                            <th>Action</th>
                        </tr>";
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>{$row['id']}</td>
                            <td>{$row['username']}</td>
                            <td>{$row['amount']}</td>
                            <td>{$row['reason']}</td>
                            <td>
                                <form action='approve_loans.php' method='post'>
                                    <input type='number' name='approval_time' placeholder='Time in minutes' required>
                                    <input type='hidden' name='loan_id' value='{$row['id']}'>
                                    <input type='hidden' name='customer_id' value='{$row['customer_id']}'>
                                    <input type='hidden' name='amount' value='{$row['amount']}'>
                                    <button type='submit' name='approve'>Approve</button>
                                </form>
                            </td>
                          </tr>";
                }
                echo "</table>";
            } else {
                echo "No pending loans.";
            }
            ?>
        </div>
    </section>
</body>
</html>

<?php
$conn->close();
?>
