<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>AB Bank Account Opening Form - Individual Savings</title>
    <link rel="stylesheet" href="styles.css" />
  </head>
  <body>
    <h1>Goldern Bank Account Opening Form</h1>
    <form action="submit_form.php" method="post">
      <div class="form-section">
        <h2>Personal Information</h2>
        <div class="form-group">
          <label for="full-name">Full Name</label>
          <input type="text" id="full-name" name="full_name" required />
        </div>
        <div class="form-group">
          <label for="dob">Date of Birth</label>
          <input type="date" id="dob" name="dob" required />
        </div>
        <div class="form-group">
          <label for="nationality">Nationality</label>
          <input type="text" id="nationality" name="nationality" required />
        </div>
        <div class="form-group">
          <label for="nid">National ID</label>
          <input type="text" id="nid" name="national_id" required />
        </div>
      </div>

      <div class="form-section">
        <h2>Contact Information</h2>
        <div class="form-group">
          <label for="address">Address</label>
          <input type="text" id="address" name="address" required />
        </div>
        <div class="form-group">
          <label for="city">City</label>
          <input type="text" id="city" name="city" required />
        </div>
        <div class="form-group">
          <label for="postal-code">Postal Code</label>
          <input type="text" id="postal-code" name="postal_code" required />
        </div>
        <div class="form-group">
          <label for="phone">Phone Number</label>
          <input type="tel" id="phone" name="phone" required />
        </div>
        <div class="form-group">
          <label for="email">Email Address</label>
          <input type="email" id="email" name="email" required />
        </div>
      </div>

      <div class="form-section">
        <h2>Account Information</h2>
        <div class="form-group">
          <label for="account-type">Account Type</label>
          <select id="account-type" name="account_type" required>
            <option value="savings">Savings</option>
            <option value="current">Current</option>
          </select>
        </div>
        <div class="form-group">
          <label for="initial-deposit">Initial Deposit</label>
          <input
            type="number"
            id="initial-deposit"
            name="initial_deposit"
            required
          />
        </div>
      </div>

      <div class="form-section">
        <h2>Declaration</h2>
        <div class="form-group">
          <label>
            <input type="checkbox" name="declaration" required /> I hereby
            declare that the information provided is true and correct to the
            best of my knowledge.
          </label>
        </div>
      </div>

      <button type="submit">Submit</button>
    </form>
  </body>
</html>
