<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Index</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .list-group-item.disabled {
            background-color: #f5f5f5;
            color: #bbb;
            cursor: not-allowed;
        }
    </style>
</head>

<body>
    <?php
    require_once('functions.php');
    require_once('navbar.php')
    ?>

    <div class="container mt-5 text-center">
        <h1 class="mb-4">RateMyProfessor Data Comparison Tool</h1>
        <?php
        if (!isset($_SESSION['email'])) {
            echo "<p>Please <a href='signin.php'>sign in</a> to make comparisons or visit the <a href='public.php'>public page</a>.</p>";
        }
        ?>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        $(function() {
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>

</body>

</html>