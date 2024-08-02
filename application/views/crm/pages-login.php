<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Login - Admin</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="<?php echo base_url();?>assets/img/fev.png" rel="icon">
  <link href="<?php echo base_url();?>assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="<?php echo base_url();?>assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="<?php echo base_url();?>assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="<?php echo base_url();?>assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="<?php echo base_url();?>assets/vendor/quill/quill.snow.css" rel="stylesheet">
  <link href="<?php echo base_url();?>assets/vendor/quill/quill.bubble.css" rel="stylesheet">
  <link href="<?php echo base_url();?>assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="<?php echo base_url();?>assets/vendor/simple-datatables/style.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="<?php echo base_url();?>assets/css/style.css" rel="stylesheet">
</head>

<body>

<main>
  <div class="container">
    <section class="section login min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

            <div class="d-flex justify-content-center py-4">
              <a href="<?php echo base_url();?>" class="logo d-flex align-items-center w-auto">
                <img src="<?php echo base_url();?>assets/img/Logo-1.png" alt="">
                <span class="d-none d-lg-block">Admin</span>
              </a>
            </div><!-- End Logo -->

            <div class="card mb-3">
              <div class="card-body">
                <div class="pt-4 pb-2">
                  <h5 class="card-title text-center pb-0 fs-4">Login to Your Account</h5>
                  <p class="text-center small">Enter your username & password to login</p>
                </div>

                <form id="loginForm" class="row g-3 needs-validation" novalidate>
                  <div class="col-12">
                    <label for="yourUsername" class="form-label">Username</label>
                    <div class="input-group has-validation">
                      <span class="input-group-text" id="inputGroupPrepend">@</span>
                      <input type="text" name="username" class="form-control" id="username" required>
                      <div class="invalid-feedback">Please enter your username.</div>
                    </div>
                  </div>

                  <div class="col-12">
                    <label for="yourPassword" class="form-label">Password</label>
                    <div class="input-group has-validation">
                    <span class="input-group-text"><i class="bi bi-eye-slash" id="togglePassword"></i></span>
                    <input type="password" name="password" class="form-control" id="password" required>        
                    <div class="invalid-feedback">Please enter your password!</div>
                    </div>
                  </div>

                  <div class="col-12">
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" name="remember" value="true" id="rememberMe">
                      <label class="form-check-label" for="rememberMe">Remember me</label>
                    </div>
                  </div>
                  <div class="col-12">
                    <button class="btn btn-primary w-100" type="submit">Login</button>
                  </div>
                  <div class="col-12">
                    <p class="small mb-0">Don't have an account? <a href="<?php echo base_url()?>index.php/Login/register">Create an account</a></p>
                  </div>
                  <div id="responseMessage" class="col-12"></div>
                </form>

              </div>
            </div>

          </div>
        </div>
      </div>
    </section>
  </div>
</main>

<a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

<!-- Vendor JS Files -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> <!-- Ensure jQuery is included -->
<script src="<?php echo base_url();?>assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="<?php echo base_url();?>assets/vendor/apexcharts/apexcharts.min.js"></script>
<script src="<?php echo base_url();?>assets/vendor/chart.js/chart.umd.js"></script>
<script src="<?php echo base_url();?>assets/vendor/echarts/echarts.min.js"></script>
<script src="<?php echo base_url();?>assets/vendor/quill/quill.js"></script>
<script src="<?php echo base_url();?>assets/vendor/simple-datatables/simple-datatables.js"></script>
<script src="<?php echo base_url();?>assets/vendor/tinymce/tinymce.min.js"></script>
<script src="<?php echo base_url();?>assets/vendor/php-email-form/validate.js"></script>

<!-- Template Main JS File -->
<script src="<?php echo base_url();?>assets/js/main.js"></script>
<script>
 $(document).ready(function() {
    $('#loginForm').on('submit', function(event) {
        event.preventDefault(); // Prevent the form from submitting the default way

        $.ajax({
            url: "<?php echo base_url(); ?>index.php/Dashboard",
            method: "POST",
            data: $(this).serialize(),
            dataType: "json",
            success: function(data) {
                if (data.success) {
                    $('#responseMessage').html('<p style="color:green;">' + data.message + '</p>');
                    setTimeout(function() {
                        window.location.href = "<?php echo base_url(); ?>index.php/Dashboard"; // Redirect to a logged-in page
                    }, 2000);
                } else {
                    $('#responseMessage').html('<p style="color:red;">' + data.message + '</p>');
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error('AJAX Error: ', textStatus, errorThrown);
                $('#responseMessage').html('<p style="color:red;">An error occurred while processing your request.</p>');
            }
        });
    });
});

</script>
<script>
        const togglePassword = document.querySelector("#togglePassword");
        const password = document.querySelector("#password");

        togglePassword.addEventListener("click", function () {
            // toggle the type attribute
            const type = password.getAttribute("type") === "password" ? "text" : "password";
            password.setAttribute("type", type);
            
            // toggle the icon
            this.classList.toggle("bi-eye");
        });

        // prevent form submit
        const form = document.querySelector("form");
        form.addEventListener('submit', function (e) {
            e.preventDefault();
        });
    </script>
</body>

</html>
