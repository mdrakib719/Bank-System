# Grolden Bank Management System

## Overview

**Grolden Bank** is a web-based banking management system that provides both customers and bank staff with the tools to manage and track financial transactions. Customers can deposit money, request loans, and transfer funds, while staff members can approve transactions and loans. The system ensures secure processing and easy management of user accounts.

## Features

### Customer Features:
- **Register**: Users can register a new bank account using their username, full name, password, and email.
- **Login**: Customers can log in to their accounts securely.
- **View Balance**: Customers can see their current balance and transaction history.
- **Deposit Request**: Customers can request deposits which are reviewed and approved by bank staff.
- **Loan Request**: Customers can request a loan. The loan status will be updated once approved or denied by the staff.
- **Money Transfer**: Customers can transfer funds between their account and other customer accounts.
- **Transaction History**: Customers can view their transaction history, including approved deposits, transfers, and loan details.

### Staff Features:
- **Approve Deposits**: Staff can view pending deposit requests and approve them. When approving, staff can specify an approval date, which updates the customer's account balance.
- **Approve Loans**: Staff can view pending loan requests, approve or deny them, and set the loan's due date.
- **Customer Account Management**: Staff can view detailed information about customer accounts, including balance and transaction history.

## Prerequisites

Before running the system, make sure the following are installed:

- **PHP 7.0+** (with MySQLi extension)
- **MySQL** Database Server
- **Apache** Web Server or any other web server that supports PHP

## Setup Instructions

### 1. Clone the repository:

```bash
git clone https://github.com/yourusername/grolden-bank.git
cd grolden-bank
2. Database Setup:
  1.Create a MySQL database named bank and import the provided SQL schema.
  2.Open your MySQL CLI or use a GUI like phpMyAdmin.
Run the following SQL code:
CREATE DATABASE bank;
USE bank;

-- Table: customers
CREATE TABLE customers (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    fullname VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    balance DECIMAL(10, 2) DEFAULT 0
);

-- Table: pending_deposits
CREATE TABLE pending_deposits (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    customer_id INT(11) NOT NULL,
    amount DECIMAL(10, 2) NOT NULL,
    status VARCHAR(50) DEFAULT 'pending',
    approval_date DATE,
    FOREIGN KEY (customer_id) REFERENCES customers(id)
);

-- Table: loans
CREATE TABLE loans (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    customer_id INT(11) NOT NULL,
    amount DECIMAL(10, 2) NOT NULL,
    status VARCHAR(50) DEFAULT 'pending',
    due_date DATE,
    FOREIGN KEY (customer_id) REFERENCES customers(id)
);

-- Table: transactions
CREATE TABLE transactions (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    customer_id INT(11) NOT NULL,
    type VARCHAR(50),
    amount DECIMAL(10, 2),
    date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (customer_id) REFERENCES customers(id)
);
```
###3. Update Database Configuration:
- **Modify the database connection details in the PHP files (approve_deposits.php, dashboard.php, etc.) to match your setup:
```
    $servername = "localhost";
    $username = "root";
    $password = "";  // Your MySQL password
    $dbname = "bank";
```
5. Host the Project:
    Host the project using Apache or any PHP-supported server by placing it inside the web root (htdocs or www).
    Alternatively, use a PHP local development environment like XAMPP or MAMP to run the project locally.
6. Access the Project:
    Visit the registration page to create a new customer account: http://localhost/grolden-bank/register.php
    Use the login page for both customers and staff: http://localhost/grolden-bank/login.php
    Usage Instructions
Customer Operations:
    Register Account: Visit the register.php page to create a new account.
    Login: Use the login.php page to log in using your credentials.
    Deposit Request: After logging in, you can request a deposit by specifying the amount. Staff will review and approve the request.
    Money Transfer: Transfer funds by specifying the recipient's username and the amount.
    Request Loan: You can request a loan, which must be reviewed by bank staff for approval.
    View Transactions: Check the history of your transactions, including transfers, deposits, and loan details.
Staff Operations:
    Approve Deposits: Staff can log in and view pending deposits. After reviewing the requests, staff can approve them by specifying the approval date.
    Approve Loans: Staff can view loan requests and approve or deny them. The approval process involves specifying a loan due date.
    Customer Management: Staff can view customer accounts and track their balances and transaction history.
```
Project Structure:
grolden-bank/
│
├── css/
│   └── style.css               # Styles for the web pages
├── index.php                   # Landing page
├── register.php                # Customer registration page
├── login.php                   # Login page for both customers and staff
├── dashboard.php               # Customer dashboard
├── transfer_money.php          # Page to transfer money
├── deposit_money.php           # Page for deposit requests
├── loan_request.php            # Page for loan requests
├── approve_deposits.php        # Staff page to approve deposits
├── approve_loans.php           # Staff page to approve loans
├── logout.php                  # Logout page
├── sql/
│   └── database.sql            # SQL schema for the database
├── images/
│   └── banklogo.jpg            # Bank logo
└── README.md                   # Project documentation
```
## Database Structure

### Customers Table (`customers`)

| Column     | Type             | Description                       |
|------------|------------------|-----------------------------------|
| `id`       | INT(11)          | Primary key                       |
| `username` | VARCHAR(255)     | Customer username (unique)        |
| `password` | VARCHAR(255)     | Hashed customer password          |
| `fullname` | VARCHAR(255)     | Customer full name                |
| `email`    | VARCHAR(255)     | Customer email                    |
| `balance`  | DECIMAL(10,2)    | Account balance                   |

### Pending Deposits Table (`pending_deposits`)

| Column         | Type            | Description                             |
|----------------|-----------------|-----------------------------------------|
| `id`           | INT(11)         | Primary key                             |
| `customer_id`  | INT(11)         | Foreign key to the customers table      |
| `amount`       | DECIMAL(10,2)   | Amount requested for deposit            |
| `status`       | VARCHAR(50)     | Status of the deposit (pending, approved)|
| `approval_date`| DATE            | Date the deposit was approved           |

### Loans Table (`loans`)

| Column        | Type            | Description                             |
|---------------|-----------------|-----------------------------------------|
| `id`          | INT(11)         | Primary key                             |
| `customer_id` | INT(11)         | Foreign key to the customers table      |
| `amount`      | DECIMAL(10,2)   | Loan amount requested                   |
| `status`      | VARCHAR(50)     | Loan status (pending, approved, denied) |
| `due_date`    | DATE            | Date the loan is due                    |

### Transactions Table (`transactions`)

| Column        | Type            | Description                             |
|---------------|-----------------|-----------------------------------------|
| `id`          | INT(11)         | Primary key                             |
| `customer_id` | INT(11)         | Foreign key to the customers table      |
| `type`        | VARCHAR(50)     | Transaction type (deposit, withdrawal, loan)|
| `amount`      | DECIMAL(10,2)   | Transaction amount                      |
| `date`        | TIMESTAMP       | Date and time of the transaction        |

Feel free to fork this repository, make improvements, and submit pull requests! Contributions are welcome.

License
  This project is licensed under the MIT License. See the LICENSE file for more details.
```bash
### Key Additions:
  1. **Enhanced Database Setup**: The full SQL code to create the database and its tables is included.
  2. **Usage Instructions**: Detailed steps for both customers and staff to operate the platform.
  3. **Project Structure**: Clearly outlines where different files are located.
  4. **Database Structure**: Explains the structure of each table and its purpose.

Feel free to customize this `README.md` file further to suit your project needs.
```

