<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Sign In</title>
	<!-- Bootstrap CSS -->
	<link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

	<?php
	require_once('functions.php');
	if (isset($_SESSION['email'])) die('You are already sign in, no need to sign in.');
	$showForm = true;
	if (count($_POST) > 0) {
		if (isset($_POST['email'][0]) && isset($_POST['password'][0])) {
			$index = 0;
			$fp = fopen(__DIR__ . '/data/users.csv.php', 'r');
			while (!feof($fp)) {
				$line = fgets($fp);
				if (strstr($line, '<?php die() ?>') || strlen($line) < 5) continue;
				$index++;
				$line = explode(';', trim($line));
				if ($line[0] == $_POST['email'] && password_verify($_POST['password'], $line[1])) {
					$_SESSION['email'] = $_POST['email'];
					$_SESSION['ID'] = $index;
					echo '<div class="container mt-5"><div class="alert alert-success">Welcome to our website</div></div>';
					$showForm = false;
				}
			}
			fclose($fp);
			if ($showForm) echo '<div class="container mt-5"><div class="alert alert-danger">Your credentials are wrong</div></div>';
		} else {
			echo '<div class="container mt-5"><div class="alert alert-danger">Email and password are missing</div></div>';
		}
	}

	if ($showForm) {
	?>

		<div class="container mt-5">
			<h1>Signin</h1>
			<form method="POST">
				<div class="form-group">
					<label for="email">Email</label>
					<input type="email" class="form-control" id="email" name="email" required>
				</div>
				<div class="form-group">
					<label for="password">Password</label>
					<input type="password" class="form-control" id="password" name="password" required>
				</div>
				<button type="submit" class="btn btn-primary">Sign in</button>
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