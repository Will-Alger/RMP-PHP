<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Sign Up</title>
	<!-- Bootstrap CSS -->
	<link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

	<?php
	require_once('functions.php');
	if (isset($_SESSION['email'])) die('You are already signed in, please sign out if you want to create a new account.');
	$showForm = true;

	if (count($_POST) > 0) {
		if (isset($_POST['email'][0]) && isset($_POST['password'][0])) {

			// Check if the email already exists
			$emailExists = false;
			$fp = fopen(__DIR__ . '/data/users.csv.php', 'a+');
			while ($line = fgets($fp)) {
				$data = explode(';', $line);
				if ($data[0] == $_POST['email']) {
					$emailExists = true;
					break;
				}
			}

			if ($emailExists) {
				echo '<div class="container mt-5"><div class="alert alert-danger">This email is already registered. Please use a different one or sign in.</div></div>';
			} else {
				fputs($fp, $_POST['email'] . ';' . password_hash($_POST['password'], PASSWORD_DEFAULT) . PHP_EOL);
				echo '<div class="container mt-5"><div class="alert alert-success">Your account has been created, proceed to the <a href="signin.php" class="alert-link">Sign in page</a>.</div></div>';
				$showForm = false;
			}
			fclose($fp);
		} else {
			echo '<div class="container mt-5"><div class="alert alert-danger">Email and password are missing</div></div>';
		}
	}


	if ($showForm) {
	?>

		<div class="container mt-5">
			<h1>Signup</h1>
			<form method="POST">
				<div class="form-group">
					<label for="email">Email</label>
					<input type="email" class="form-control" id="email" name="email" required>
				</div>
				<div class="form-group">
					<label for="password">Password</label>
					<input type="password" class="form-control" id="password" name="password" required>
				</div>
				<button type="submit" class="btn btn-primary">Sign up</button>
			</form>
		</div>

	<?php
	}
	?>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>

</html>