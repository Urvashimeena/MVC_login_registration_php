<?php

require_once('includes/config.php');


$title = 'Login';
require('layout/header.php'); 

if(isset($_POST['submit']))
{
	$username = $_POST['username'];
	$password = $_POST['password'];
	$result = $user->login($username,$password);

	if($result)
	{

		header('location:member.php');
	}
	else
	{
		$error[] = 'Wrong username or password or your account has not been activated.';
	}
}

?>

	
<div class="container">

	<div class="row">

	    <div class="col-xs-12 col-sm-8 col-md-6 col-sm-offset-2 col-md-offset-3">
			<form role="form" method="post" action="" autocomplete="off">
				<h2>Please Login</h2>
				<p><a href='register.php'>Back to home page</a></p>
				<hr>

				<?php
				//check for any errors
				if(isset($error)){
					foreach($error as $error){
						echo '<p class="bg-danger">'.$error.'</p>';
					}
				}
				if(isset($_GET['action'])){
				
					switch ($_GET['action']) {
						case 'active':
							echo "<h2 class='bg-success'>Your account is now active you may now log in.</h2>";
							break;
						case 'reset':
							echo "<h2 class='bg-success'>Please check your inbox for a reset link.</h2>";
							break;
					}
				}
				
				?>
				<div class="form-group">
					<input type="text" name="username" id="username" class="form-control input-lg" placeholder="User Name">
				</div>

				<div class="form-group">
					<input type="password" name="password" id="password" class="form-control input-lg" placeholder="Password tabindex="3">
				</div>
				
				
				
				<hr>
				<div class="row">
					<div class="col-xs-6 col-md-6"><input type="submit" name="submit" value="Login" class="btn btn-primary btn-block btn-lg" tabindex="5"></div>
				</div>
			</form>
		</div>
	</div>



</div>


<?php 

//include footer template
require('layout/footer.php'); 
?>