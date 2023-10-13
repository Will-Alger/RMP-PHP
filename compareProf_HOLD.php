<?php
require_once('functions.php');
require_once('navbar.php');

if (!isset($_SESSION['email'])) {
    die('This is a private area, you are not allowed here');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>

<body>
    <div class="container mt-5">
        <a href="private.php" class="btn btn-secondary mb-3">Back</a>
        <h1 class="mb-4 text-center">Search</h1>

        <!-- Professor search -->
        <div class="mb-4">
            <h2>Search For Professor</h2>
            <input type="text" id="professorSearch" class="form-control" placeholder="Search for a professor">
            <div id="professorDropdown" class="dropdown-content"></div>
        </div>

        <!-- University search -->
        <div class="mb-4">
            <h2>Search For University</h2>
            <input type="text" id="universitySearch" class="form-control" placeholder="Search for a university">
            <div id="universityDropdown" class="dropdown-content"></div>
        </div>

        <!-- Results display area -->
        <div id="resultsArea"></div>
    </div>

    <script>
        $(document).ready(function() {
            const fetchResults = (type, query) => {
                $.ajax({
                    url: 'search_handler.php',
                    method: 'POST',
                    data: {
                        type: type,
                        query: query
                    },
                    success: function(data) {
                        if (type === 'professor') {
                            $("#professorDropdown").html(data);
                            $("#professorDropdown").show();
                        } else {
                            $("#universityDropdown").html(data);
                            $("#universityDropdown").show();
                        }
                    }
                });
            };

            $("#professorSearch").on("keyup", function() {
                const query = $(this).val();
                if (query) {
                    fetchResults('professor', query);
                } else {
                    $("#professorDropdown").hide();
                }
            });

            $("#universitySearch").on("keyup", function() {
                const query = $(this).val();
                if (query) {
                    fetchResults('university', query);
                } else {
                    $("#universityDropdown").hide();
                }
            });
        });
    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>