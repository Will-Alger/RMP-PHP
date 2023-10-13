<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Index</title>
    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Enhance the appearance of the disabled link */
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
    /* 
    TODO:
    1. Implment dynamic pages for two types of items (universities and teachers?)
    2. be able to list, preview, create, edit, delete entities.
    3. admin has functionality for index, detailing, creating, editing, delting.
    // 4. Authentication
    // 5. use bootstrap
    6. create a max 10 minute video demonstrating the project and its features.
*/
    ?>

    <div class="container mt-5">
        <h1 class="mb-4">RateMyProfessor Data Comparison Tool</h1>
        <div class="list-group">
            <a href="signup.php" class="list-group-item list-group-item-action">Sign up</a>
            <a href="signin.php" class="list-group-item list-group-item-action">Sign in</a>

            <?php
            if (isset($_SESSION['email'])) {
                echo '<a href="signout.php" class="list-group-item list-group-item-action">Sign out</a>';
            } else {
                echo '<a href="#" class="list-group-item list-group-item-action disabled" data-toggle="tooltip" title="Please sign in to use this option.">Sign out</a>';
            }
            ?>

            <a href="public.php" class="list-group-item list-group-item-action">Public</a>
            <a href="private.php" class="list-group-item list-group-item-action">Private</a>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        // Initialize tooltips
        $(function() {
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>

</body>

</html>