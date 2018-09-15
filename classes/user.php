<?php
class User
{	

	public function __construct($db)
    {
        try {
            	$this->db = $db;
        	} catch (PDOException $e) {
            	exit('Database connection could not be established.');
        	}
    }
	
	private function get_User($username)
	{
		
		$stmt = $this->db->prepare("SELECT * FROM members WHERE username = :username");
		$stmt->execute(array(':username' => $username));
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		if(isset($row))
		{
			return $row;
		}
		else
		{
			return [];
		}
		

		

	}
	public function isValidateUsername($username)
	{

		if(strlen($username) > 20 )
		return false;
		if(strlen($username) < 3)
		return false;
		return true;
	}
	public function login($username,$password)
	{
		
		if(!$this->isValidateUsername($username)) return false;
		if(strlen($password) <  3) return false;
		$row = $this->get_User($username);
		$result = password_verify($password,$row['password']);
		if($result)
		{
			
			$_SESSION['loggedin'] = true;
		    $_SESSION['username'] = $row['username'];
		    $_SESSION['memberID'] = $row['memberID'];
		    return true;

		} 
		else
		{
			return false;
		}


	}
	public function isValidEmail($email)
	{
		$email = htmlspecialchars_decode($email, ENT_QUOTES);
		if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
		    $error[] = 'Please enter a valid email address';
		} else {
			$user = $this->db->prepare('SELECT email FROM members WHERE email = :email');
			$user->execute(array(':email' => $email));
			$row = $user->fetch(PDO::FETCH_ASSOC);

			if(!empty($row['email'])){
				return false;
		
			}
			else
			{
				return true;
			}
		}
	}
	public function is_logged_in()
	{
		if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] = true)
		{
			return true;
		}
	}
	public function register($username,$password,$email)
	{
		
			if(!$this->isValidateUsername($username))
			{
				$error[] = "Username length must be greater than 2 characte";
			}
			else
			{
				$row = $this->get_User($username);
		
				if(!empty($row['username']))
				{
				
					$error[] = "Username already exist";
				}
			}

			if(!$this->isValidEmail($email)) $error[] = 'Email provided is already in use.';

			if(!isset($error))
			{
				$hashed_password = password_hash($password, PASSWORD_DEFAULT);
				//create the activasion code
			

				$activasion = md5(uniqid(rand(),true));
				try {
					//insert into database with a prepared statement

					$user = $this->db->prepare('INSERT INTO members (username,password,email,active) VALUES (:username, :password, :email, :active)');
					$user->bindParam(':username', $username);
					$user->bindParam(':password', $hashed_password);
					$user->bindParam(':email', $email);
					$user->bindParam(':active', $activasion);
					$user->execute();
					
					echo $id = $this->db->lastInsertId();
					$dir = getcwd();
					$to = $email;
					$subject = "Registration Confirmation";
					$body = "<p>Thank you for registering at demo site.</p>
					<p>To activate your account, please click on this link: <a href='http://localhost/MVClogin_Registration/activate.php?x=$id&y=$activasion'>http://localhost/MVClogin_Registration/activate.php?x=$id&y=$actiMVClogin_Registration/vasion</a></p>
					<p>Regards Site Admin</p>";
					$mail = new Mail();
					$mail->setFrom(SITEEMAIL);
					$mail->addAddress($to);
					$mail->subject($subject);
					$mail->body($body);
					
					if(!$mail->send()) {
					   echo 'Message could not be sent.';
					   print_r($mail->ErrorInfo);
					   exit;
					}
					
					header('Location: register.php?action=joined');
					
					exit;
					} catch(PDOException $e) {
				    $error[] = $e->getMessage();
					}
				}
				else 
				{
					foreach($error as $error){
						echo '<p class="bg-danger">'.$error.'</p>';
					}
				}
	} 


}

?>