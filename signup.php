<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sign Up</title>
  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- SweetAlert2 CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.min.css">
</head>
<body>
<div class="container mt-5">
  <div class="row justify-content-center">
    <div class="col-lg-6">
      <div class="card shadow">
        <div class="card-body">
          <h2 class="card-title text-center">Sign Up</h2>
          <form id="signupForm" action="signupHandler.php" method="post">
            <div class="row mb-3">
              <div class="col">
                <label for="name" class="form-label">Full Name</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Enter your full name" required>
              </div>
              <div class="col">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" required>
              </div>
            </div>
            <div class="row mb-3">
              <div class="col">
                <label for="address" class="form-label">Address</label>
                <input type="text" class="form-control" id="address" name="address" placeholder="Enter your address" required>
              </div>
              <div class="col">
                <label for="phone" class="form-label">Phone</label>
                <input type="text" class="form-control" id="phone" name="phone" placeholder="Enter your phone number" required>
              </div>
            </div>
            <div class="row mb-3">
              <div class="col">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" required>
              </div>
              <div class="col">
                <label for="confirmPassword" class="form-label">Confirm Password</label>
                <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" placeholder="Confirm your password" required>
              </div>
            </div>
            <div class="text-center">
              <button type="submit" class="btn btn-primary">Sign Up</button>
            </div>
            <div class="text-center mt-3">
              <p>Already have an account? <a href="login.php">Log In</a></p>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Bootstrap 5 JS (optional) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- SweetAlert2 JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.all.min.js"></script>

<!-- Your custom JavaScript code (AJAX form submission) -->
<script>
// Form submission using AJAX
$('#signupForm').submit(function(e) {
    e.preventDefault(); // Prevent default form submission behavior

    // Collect form data
    var formData = $(this).serialize();

    // AJAX request
    $.ajax({
      url: 'signupHandler.php',
      type: 'POST',
      data: formData,
      success: function(resp) {
        console.log(resp);
        var res = jQuery.parseJSON(resp);
        if (res.status == 200) {
          // User created successfully
          Swal.fire({
            icon: 'success',
            title: 'Success',
            text: res.message,
          }).then(function() {
            window.location.href = "login.php"; // Redirect to success page
          });
        } else {
          // Failed to create user
          Swal.fire({
            icon: 'error',
            title: 'Error',
            text: res.message,
          });
        }
      },
      error: function(xhr, status, error) {
        // Handle error response from the server
        Swal.fire({
          icon: 'error',
          title: 'Error',
          text: 'Error: ' + error,
        });
      }
    });
  });
</script>
</body>
</html>