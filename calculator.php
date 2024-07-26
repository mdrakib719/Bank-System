<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Calculator</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color:#f5f0e9 ;
      margin: 0;
      padding: 0;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }

    ul {
      list-style-type: none;
      padding: 0;
      margin: 0;
      text-align: center;
    }

    li {
      margin: 10px 0;
    }

    a {
      text-decoration: none;
      font-size: 18px;
      color: #4c5baf;
      padding: 10px 20px;
      border: 2px solid #4c5baf;
      border-radius: 4px;
      transition: all 0.3s ease;
    }

    a:hover {
      background-color: #4c5baf;
      color: white;
    }
  </style>
</head>
<body>
  <ul>
    <li><a href="calculator_home.php">Home Loan Total Interest Calculator</a></li>
    <li><a href="calculator_student.php">Student Loan Total Interest Calculator</a></li>
    <li><a href="calculator_cc.php">CC Loan Total Interest Calculator</a></li>
  </ul>
</body>
</html>
