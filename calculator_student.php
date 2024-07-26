<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="calculator_student.css">
</head>
<body>
  <form action="calculator_student.php" method="post">
    <label class="label">Student Loan Calculator</label><br>
    <input type="number" name="Ammount" placeholder="Enter amount"><br>
    <input type="submit" value="Calculate">
  </form>

  <?php if ($_SERVER["REQUEST_METHOD"] == "POST"): ?>
    <?php
      $total = null;
      $x = $_POST["Ammount"];
      $total = $x * (5 / 100);
      $y = $total + $x;
    ?>
    <div class="result-box">
      <p>You need to pay <?php echo $total; ?> tk as interest</p>
      <p>Total amount after interest: <?php echo $y; ?> tk</p>
      <p>Time left: 3 years</p>
    </div>
  <?php endif; ?>

  <a href="https://mof.portal.gov.bd/sites/default/files/files/mof.portal.gov.bd/page/e65b0930_46ad_49f0_9b09_234e3a62d87c/ch13.pdf">More Information</a>
  <button class="exit-button" onclick="window.location.href='home_page.php'">Exit</button>
</body>
</html>
