<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Index</title>
    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

    <?php
    require_once('functions.php');
    ?>

    <div class="container mt-5">
        <h1 class="mb-4">Index</h1>
        <div class="list-group">
            <a href="signup.php" class="list-group-item list-group-item-action">Sign up</a>
            <a href="signin.php" class="list-group-item list-group-item-action">Sign in</a>
            <a href="signout.php" class="list-group-item list-group-item-action">Sign out</a>
            <a href="public.php" class="list-group-item list-group-item-action">Public</a>
            <a href="private.php" class="list-group-item list-group-item-action">Private</a>
        </div>
    </div>

    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!-- Popper JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>

</html>