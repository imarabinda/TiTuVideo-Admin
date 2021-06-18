

<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="UTF-8">
<meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
<title><?php echo APP_NAME; ?> - Login</title>

<link rel="stylesheet" href="<?= base_url(); ?>assets/css/app.min.css">
<link rel="stylesheet" href="<?= base_url(); ?>assets/bundles/bootstrap-social/bootstrap-social.css">

<link rel="stylesheet" href="<?= base_url(); ?>assets/css/style.css">
<link rel="stylesheet" href="<?= base_url(); ?>assets/css/components.css">

<link rel="stylesheet" href="<?= base_url(); ?>assets/css/custom.css">
<link rel="stylesheet" href="<?= base_url(); ?>assets/dist/css/jquery.toast.css" type="text/css">
<link rel='shortcut icon' type='image/x-icon' href='<?= base_url(); ?>assets/img/favicon.ico' />
<script src="<?= base_url(); ?>assets/plugins/jquery/jquery.min.js"></script>
</head>
<body>
<div class="loader"></div>
<div id="app">
<section class="section">
<div class="container mt-5">
<div class="row">
<div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
<div class="card card-primary">
<div class="card-header">
<h4>Login</h4>
</div>
<div class="card-body">
<form method="POST" id="loginform" name="loginform" class="needs-validation" novalidate="">
<div class="form-group">
<label for="username">Username</label>
<input id="username" type="text" class="form-control" name="username" tabindex="1">
</div>
<div class="form-group">
<div class="d-block">
<label for="password" class="control-label">Password</label>
</div>
<input id="password" type="password" class="form-control" name="password" tabindex="2">
<div class="invalid-feedback">
please fill in your password
</div>
</div>

<div class="form-group">
<button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
Login
</button>
</div>
</form>
</div>
</div>
</div>
</div>
</div>
</section>
</div>

<script src="<?= base_url(); ?>assets/js/app.min.js"></script>

<script src="<?= base_url(); ?>assets/dist/js/jquery.validate.js"></script>
<script src="<?= base_url(); ?>assets/dist/js/jquery.toast.js"></script>
<script src="<?= base_url(); ?>assets/dist/js/jquery.validate.min.js"></script>

<script src="<?= base_url(); ?>assets/js/scripts.js"></script>

<script src="<?= base_url(); ?>assets/js/custom.js"></script>
<script>

		var base_url = '<?= base_url(); ?>';

		  	$('.dropdown-toggle').dropdown();

		  	$("form[name='loginform']").validate({

				rules: {
					username: "required",
					password: "required",
				},
				messages: {
					username: "Please enter username",
					password: "Please enter password",
				},

				submitHandler: function (form) {

					 $.ajax({
				        url: base_url+'admin/Login/jadminlogin',
				        data: new FormData($('#loginform')[0]),
				        type: 'POST',
				        contentType : false,
				        processData : false,
				        success: function ( data ) {
				        	if(data == 1)
				        	{
				        		$.toast({
							        heading: 'Success',
							        text: 'Login successfull',
							        icon: 'success',
							        position: 'top-right',
							    });
							    setTimeout(function () {
									window.location.href = base_url+'admin/dashboard';
								}, 3000);
				        	}
				        	else if(data == 2)
				        	{
							    window.location.href = base_url+'admin/two_fa_verify';
				        	}
				        	else
				        	{
				        		$.toast({
									heading: 'Error',
									text: 'Username or password something went wrong',
									icon: 'error',
									position: 'top-right',
							  });
				        	}
				        }
				    });


				}
			});

		</script>
</body>

</html>