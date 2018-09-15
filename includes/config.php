<?php
	ob_start();
	session_start();


	define('DBHOST','localhost');
	define('DBUSER','root');
	define('DBPASS','');
	define('DBNAME','mvc_login_register');

//application address
// define('DIR','http://domain.com/');
// define('SITEEMAIL','noreply@domain.com');

	try {

	    	$db = new PDO("mysql:host=".DBHOST.";dbname=".DBNAME, DBUSER, DBPASS);
		    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		} catch(PDOException $e) {
    	//show error
    		echo '<p class="bg-danger">'.$e->getMessage().'</p>';
    		exit;	
		}

//include the user class, pass in the database connection
include('classes/user.php');
include('classes/phpmailer/mail.php');
$user = new User($db);
?>