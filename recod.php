<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bank";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if username is provided via POST method
if (isset($_POST['username'])) {
    $username = $_POST['username'];

    // Fetch username and balance from customers table
    $sql_user = "SELECT username, balance FROM customers WHERE username = ?";
    $stmt_user = $conn->prepare($sql_user);
    $stmt_user->bind_param("s", $username);
    $stmt_user->execute();
    $result_user = $stmt_user->get_result();

    if ($result_user->num_rows > 0) {
        $row_user = $result_user->fetch_assoc();
        $username = $row_user['username'];
        $balance = $row_user['balance'];

        // Fetch transaction records for the user
        $sql_transactions = "SELECT * FROM transactions WHERE username = ?";
        $stmt_transactions = $conn->prepare($sql_transactions);
        $stmt_transactions->bind_param("i", $username);
        $stmt_transactions->execute();
        $result_transactions = $stmt_transactions->get_result();

        // Display transaction records
        echo "<h2>Transaction Records for Username: $username</h2>";
        echo "<p>Balance: $balance</p>";
        echo "<table border='1'>";
        echo "<tr><th>Transaction ID</th><th>Amount</th><th>Type</th><th>Date</th></tr>";
        while ($row_transaction = $result_transactions->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row_transaction['transaction_id'] . "</td>";
            echo "<td>" . $row_transaction['amount'] . "</td>";
            echo "<td>" . ($row_transaction['type'] == 'deposit' ? 'Deposit' : 'Withdrawal') . "</td>";
            echo "<td>" . $row_transaction['timestamp'] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "User not found.";
    }

    $stmt_user->close();
    $stmt_transactions->close();
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaction Records by Username</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            background-color: #f2f2f2;
            padding: 20px;
        }
        h2 {
            margin-bottom: 20px;
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 10px;
            text-align: left;
            border: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        form {
            max-width: 400px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .form-group {
            margin-bottom: 1rem;
        }
        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
        }
        .form-group input {
            width: 100%;
            padding: 0.5rem;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        .submit-btn {
            width: 100%;
            background: #6986ee;
            color: #fff;
            padding: 0.75rem;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 1rem;
            transition: background 0.3s;
        }
        .submit-btn:hover {
            background: #5b72cb;
        }
    </style>
</head>
<body>
    <header>
        <h1>Transaction Records by Username</h1>
    </header>

    <section>
        <form action="recod.php" method="post">
            <div class="form-group">
                <label for="username">Enter Username:</label>
                <input type="text" id="username" name="username" required>
            </div>
            <button type="submit" class="submit-btn">Fetch Transactions</button>
        </form>
    </section>

    <footer>
        <p>&copy; 2024 AB Bank. All rights reserved.</p>
    </footer>
</body>
</html>
