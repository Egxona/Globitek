<?php
  require_once('../private/initialize.php');

  // Set default values for all variables the page needs.
	$first_name = "";
	$last_name = "";
	$username = "";
	$email = "";
	$errors = array();
	$date_created= date("Y-m-d H:i:s");

  // if this is a POST request, process the form
	if(is_post_request()){
		
		$first_name = $_POST['first_name'];
		$last_name = $_POST['last_name'];
		$username = $_POST['username'];
		$email = $_POST['email'];
		$isErr = false;
		
		// Hint: private/functions.php can help

		// Confirm that POST values are present before accessing them.

		// Perform Validations
		// Hint: Write these in private/validation_functions.php

		if (is_blank($_POST['first_name'])) {
			$errors[] = "First name cannot be blank.";
			$isErr = true;
		} elseif (!has_length($_POST['first_name'], ['min' => 2, 'max' => 255])) {
			$errors[] = "First name must be between 2 and 255 characters.";
			$isErr = true;
		}
		if (is_blank($_POST['last_name'])) {
			$errors[] = "Last name cannot be blank.";
			$isErr = true;
		} elseif (!has_length($_POST['last_name'], ['min' => 2, 'max' => 255])) {
			$errors[] = "Last name must be between 2 and 255 characters.";
			$isErr = true;
		}
		if (is_blank($_POST['username'])) {
			$errors[] = "Username cannot be blank.";
			$isErr = true;
		} elseif (!has_length($_POST['username'], ['min' => 8, 'max' => 255])) {
			$errors[] = "Username must be at least 8 characters.";
			$isErr = true;
		}
		if (is_blank($_POST['email'])) {
			$errors[] = "Email cannot be blank.";
			$isErr = true;
		} elseif (!has_valid_email_format($_POST['email'])) {
			$errors[] = "Email must be a valid format.";
			$isErr = true;
		}

    // if there were no errors, submit data to database
	if(!$isErr){
		$mysql_hostname = "127.0.0.1";
		$mysql_username = "root";
		$mysql_password = "";
		$mysql_database = "globitek";
		$db = mysqli_connect($mysql_hostname, $mysql_username, $mysql_password, $mysql_database);
		
		mysql_select_db($mysql_database, $db);
		
      // Write SQL INSERT statement
		$sql = "INSERT INTO users (first_name, last_name, email, username, created_at)
		VALUES('$first_name', '$last_name', '$email', '$username', '$date_created')";
      
	  
      // For INSERT statments, $result is just true/false
      $result = db_query($db, $sql);
      if($result) {
         db_close($db);

      //   TODO redirect user to success page
		 redirect_to('registration_success.php');
       } else {
         // The SQL INSERT statement failed.
         // Just show the error, not the form
         echo db_error($db);
         db_close($db);
         exit;
       }
	}
	}
	else
	{}
	
?>

<?php $page_title = 'Register'; ?>
<?php include(SHARED_PATH . '/header.php'); ?>

<div id="main-content">
  <h1>Register</h1>
  <p>Register to become a Globitek Partner.</p>

 <?php
    // TODO: display any form errors here
	echo display_errors($errors);
    // Hint: private/functions.php can help
 ?>
  <!-- TODO: HTML form goes here -->
  <form action="register.php" method="post">

	First name: <input type="text" name="first_name"><br>
	Last name: <input type="text" name="last_name"><br>
	Email: <input type="text" name="email"><br>
	Username: <input type="text" name="username"><br>
	<input type="Submit" name="Submit" value="Submit">
  
</form>
</div>

<?php include(SHARED_PATH . '/footer.php'); ?>
