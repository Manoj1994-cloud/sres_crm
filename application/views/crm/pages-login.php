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
  <link href="https://fonts.googleapis.com/css?family=Open+Sans|Nunito|Poppins" rel="stylesheet">
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
                <form id="Loginform" class="row g-3 needs-validation" novalidate>
                  <div class="col-12">
                    <label for="username" class="form-label">Username</label>
                    <div class="input-group has-validation">
                      <span class="input-group-text"><i class="bi bi-person"></i></span>
                      <input type="text" name="username" class="form-control" id="username" required>
                      <div class="invalid-feedback">Please enter your username.</div>
                    </div>
                  </div>
                  <div class="col-12">
                    <label for="password" class="form-label">Password</label>
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
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="<?php echo base_url();?>assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="<?php echo base_url();?>assets/vendor/apexcharts/apexcharts.min.js"></script>
<script src="<?php echo base_url();?>assets/vendor/chart.js/chart.umd.js"></script>
<script src="<?php echo base_url();?>assets/vendor/echarts/echarts.min.js"></script>
<script src="<?php echo base_url();?>assets/vendor/quill/quill.js"></script>
<script src="<?php echo base_url();?>assets/vendor/simple-datatables/simple-datatables.js"></script>
<script src="<?php echo base_url();?>assets/vendor/tinymce/tinymce.min.js"></script>
<script src="<?php echo base_url();?>assets/vendor/php-email-form/validate.js"></script>
<script src="<?php echo base_url();?>assets/js/main.js"></script>
<script>
$(document).ready(function(){
		$("#Loginform").submit(function(event){
		   $("#btnCont").attr('disabled',true);
		   $("#loaderImg").show();
		   var formData=new FormData($(this)[0]);
		   event.preventDefault();
		   $.ajax({
				url: '<?php echo base_url(); ?>index.php/Login/UserLogin',
				type: 'POST',
				data: formData,            
				processData: false,
				contentType: false,
				success: function(data){
					var obj=$.parseJSON(data);
					if(obj.message=="Success"){
						$("#btnCont").attr('disabled',false);
						$("#loaderImg").hide();	
						window.location="<?php echo base_url() ?>index.php/Admin";
					}
					else{
					  $("#btnCont").attr('disabled',false);
					  $("#loaderImg").hide();	
					  swal({
						title:"Incorrect Username / Password",
						text:"Username or Password is incorrect! Please Try Again",
						type:"error"
					  });
					}		
				},
				error: function(e){

				} 

			});

		});	
		
		$("#user").keyup(function(){
			$.ajax({
				url:'<?php echo base_url();?>index.php/Password/Getuserid',
				type:'POST',
				data:{'title':$('#user').val()},
				success: function(data)
				{
					var obj= $.parseJSON(data);
					if(obj.msg=='Not Exist')
					{	
						$("#subtn").attr('disabled',true);
					}
					else if(obj.msg=='Exist')
					{
						$("#user_id").val(obj.id);
						$("#subtn").attr('disabled',false);
					}
				},
				error: function()
				{
				}
			});
		});
		
		$("#forgotFrm").submit(function(e){
			$("#user_id1").val($("#user_id").val());
		   e.preventDefault();
			$.ajax({
			  url:'<?php echo base_url();?>index.php/Password/mail_code', 
			  contentType: false,
			  processData: false,
			  cache: false,
			  type: 'POST',
			  data      : new FormData(this),
			  success : function (data)
			  {
				 var obj = $.parseJSON(data);
				$("#user").val("");
				$("#modal2").css("display", "none");
				$("#modal3").css("display", "block");
				//$("#modal2").modal('hide');
				//$("#modal3").modal('show');
				//$('#modal3').modal('open');
			  } 
			}); 
		});
		
		$("#verifycode").submit(function(e){
			$("#user_id2").val($("#user_id1").val());
		   e.preventDefault();
			$.ajax({
			  url:'<?php echo base_url();?>index.php/Password/verify', 
			  contentType: false,
			  processData: false,
			  cache: false,
			  type: 'POST',
			  data      : new FormData(this),
			  success : function (data)
			  {
				var obj = $.parseJSON(data);
				if(obj.msg=='Exist')
				{
					$("#code").val("");
					$("#modal3").modal('hide');
					$("#modal4").modal('show');
					$("#pass").val("");
				}
				else if(obj.msg=='Not Exist')
				{
				    $("#ext1").show();
				    $("#code").val("");
				    $("#ext1").delay(2000).fadeOut(300);
				}
				 
			  } 
			 
			}); 
		});
		
		$("#resetFrm").submit(function(e){
			$("#user_id2").val($("#user_id1").val());
		   e.preventDefault();
			$.ajax({
			  url:'<?php echo base_url();?>index.php/Password/change_pass', 
			  contentType: false,
			  processData: false,
			  cache: false,
			  type: 'POST',
			  data      : new FormData(this),
			  success : function (data)
			  {
				var obj = $.parseJSON(data);
				alert(obj.message);
				$("#pass").val("");
				$("#cp").val("");
				$("#modal4").modal('hide');
			  } 
			 
			}); 
			
		});
		
		$("#pass").keyup(function(){
			$("#cp").val("");
			$("#text_match").text("");
		});
		
		$("#cp").keyup(function(){
			var len = $("#pass").val().length;
			if($("#cp").val().length>=len){
			if($("#cp").val()==$("#pass").val()){
				$("#text_match").css('color','green');
				$("#text_match").text("Password Match");
				$("#subtn2").attr('disabled',false);
			}
			else{
				$("#text_match").css('color','red');
				$("#text_match").text("Not Match");
				$("#subtn2").attr('disabled',true);
			}
			}
		});	
     // Toggle password visibility
     const togglePassword = document.querySelector("#togglePassword");
    const password = document.querySelector("#password");

    togglePassword.addEventListener("click", function () {
        // Toggle the type attribute
        const type = password.getAttribute("type") === "password" ? "text" : "password";
        password.setAttribute("type", type);
        // Toggle the icon
        this.classList.toggle("bi-eye");
        this.classList.toggle("bi-eye-slash");
    });
	});
   

</script>
</body>
</html>
