<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login - AB Bank</title>
    <link rel="stylesheet" href="login_page.css" />
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
          <li><a href="home_page.php">Home</a></li>
          <li class="dropdown">
            <a href="#">Accounts</a>
            <ul class="dropdown-content">
              <li><a href="#">Savings</a></li>
              <li><a href="#">Current</a></li>
              <li><a href="#">Student Account</a></li>
            </ul>
          </li>
          <li><a href="#">Loans</a></li>
          <li><a href="#">Contact</a></li>
        </ul>
      </nav>
    </header>

    <section class="login">
      <div class="login-container">
        <h1>Login to Your Account</h1>
        <form action="submit_login.php" method="post">
          <div class="form-group">
            <label for="username">Username</label>
            <input type="text" id="username" name="username" required />
          </div>
          <div class="form-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" required />
          </div>
          <button type="submit" class="login-button">Login</button>
          <p class="register-link">
            Don't have an account? <a href="#">Register here</a>.
          </p>
        </form>
      </div>
    </section>

    <footer>
      <p>&copy; 2024 Goldren Bank. All rights reserved.</p>
    </footer>
  </body>
</html>
