<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Goldren Bank</title>
    <link rel="stylesheet" href="home_page.css" />
  </head>
  <body>
    <header>
      <nav>
        <div class="logo">
          <a href="home_page.php">
            <img src="banklogo.jpg" alt="Goldren Bank Logo" class="logo-img"
          /></a>
          Goldren Bank
        </div>
        <ul class="nav-links">
          <li><a href="#">Home</a></li>
          <li class="dropdown">
            <a href="#">Accounts</a>
            <ul class="dropdown-content">
              <li><a href="#">Savings</a></li>
              <li><a href="#">Current</a></li>
              <li><a href="#">Student Account</a></li>
            </ul>
          </li>
          <li class="dropdown">
            <a href="#">Loan</a>
            <ul class="dropdown-content">
              <li><a href="calculator.php">Loan Calculator</a></li>
              <li><a href="#">Current Loan</a></li>
              <li><a href="#">Student Loan</a></li>
              <li><a href="#">Home Loan</a></li>
            </ul>
          </li>
          <li><a href="#">Contact</a></li>
          <li><a href="login.php">Login</a></li>
        </ul>
      </nav>
    </header>

    <section class="hero">
      <div class="hero-content">
        <h1>Welcome to Goldren Bank</h1>
        <p>Your trusted partner for all your banking needs.</p>
        <a
          href="chataccount.php"
          target="_blank"
          class="cta-button"
          >Open an Account</a
        >
      </div>
    </section>

    <section class="features">
      <div class="feature">
        <h2>Accounts Opening</h2>
        <p>Manage your savings with high-interest rates and flexible access.</p>
        <br />
        <a
          href="https://sjiblbd.com/download/Documentation%20Check%20List%20for%20Account%20Opening.pdf"
          target="_blank"
        >
          <button class="apply">Process</button>
        </a>
      </div>
      <div class="feature">
        <h2>Personal Loans</h2>
        <p>Get the funds you need with our low-interest personal loans.</p>
        <br />
        <a
          href="https://www.hsbc.com.bd/1/PA_ES_Content_Mgmt/content/bangladesh60/attachments/Loan_terms_and_conditions_RBWM.pdf"
          target="_blank"
        >
          <button class="apply">Appy for Loans</button></a
        >
      </div>

      <section class="feature">
        <h2>Customer Support</h2>
        <p>
          We're here to help you 24/7 with any banking queries. For more details
          click icons.
        </p>
        <a href="https://www.facebook.com" target="_blank">
          <img src="facebook.png" alt="Customer Support" />
        </a>
        <a href="https://www.instagram.com" target="_blank">
          <img src="insta.png" alt="Customer Support" />
        </a>
        <a href="https://www.twitter.com" target="_blank">
          <img src="twitter.png" alt="Customer Support" />
        </a>
      </section>
    </section>

    <footer>
      <p>&copy; 2024 Goldren Bank. All rights reserved.</p>
    </footer>
  </body>
</html>
