<?php require('includes/config.php'); 
if(!$user->is_logged_in()){ header('Location: login.php'); exit(); }
$title = 'Members Page';

require('layout/header.php'); 
?>

<div class="container">

	<div class="row">

	    <div class="col-xs-12 col-sm-8 col-md-6 col-sm-offset-2 col-md-offset-3">
			
				<h2>Welcome <?php echo htmlspecialchars($_SESSION['username'], ENT_QUOTES); ?></h2>
				<p><a href='sesssion.php'>Logout</a></p>
				<hr>

		</div>
	</div>


</div>

<?php 
//include header template
require('layout/footer.php'); 
?>