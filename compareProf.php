<?php
include 'navbar.php';

$teacherID = '';
$scope = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $teacherID = filter_input(INPUT_POST, 'teacherID', FILTER_SANITIZE_NUMBER_INT);
    $scope = filter_input(INPUT_POST, 'scope', FILTER_SANITIZE_STRING);

    $url = "compareProfDetail.php?teacherID=$teacherID&scope=$scope";

    header("Location: $url");
    exit;
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Search Form</title>
    <!-- Import Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-5">
        <h1 class="text-center">Select comparison data</h1>

        <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" class="mt-3">
            <div class="form-group">
                <label for="teacherID">Teacher ID:</label>
                <input type="number" class="form-control" id="teacherID" name="teacherID" value="<?= $teacherID ?>">
            </div>

            <div class="form-group">
                <label for="scope">Scope:</label>
                <select class="form-control" id="scope" name="scope">
                    <option value="department" <?= $scope === 'department' ? 'selected' : '' ?>>Department wide</option>
                    <option value="university" <?= $scope === 'university' ? 'selected' : '' ?>>University wide</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</body>

</html>