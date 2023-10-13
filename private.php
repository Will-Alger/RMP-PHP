<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Private Page</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .navbar {
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 1000;
        }

        .content {
            padding-top: 80px;
        }
    </style>
</head>

<body>

    <?php
    require_once('functions.php');

    if (!isset($_SESSION['email'])) {
        header('Location: signin.php');
        exit;
    }

    include 'navbar.php';
    ?>



    <div class="container content mt-5">
        <div class="row justify-content-center">
            <div class="col-md-12 text-center">
                <h1 class="mb-4">Comparison tools</h1>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-4 text-center mb-3">
                <a href="compareProf.php" class="btn btn-primary btn-block">Compare Professors</a>
            </div>
            <div class="col-md-4 text-center mb-3">
                <a href="compareUni.php" class="btn btn-primary btn-block">Compare Universities</a>
            </div>
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