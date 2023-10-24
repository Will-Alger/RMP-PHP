<?php
require_once 'navbar.php';
require_once 'db.php';
require_once 'functions.php';

$scope = '';
$queryString = '';

$type = filter_input(INPUT_GET, 'type', FILTER_SANITIZE_STRING);
$db = new rmpDB('rmp-py.db');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $type = filter_input(INPUT_POST, 'type', FILTER_SANITIZE_STRING);
    $scope = filter_input(INPUT_POST, 'scope', FILTER_SANITIZE_STRING);

    $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);

    $data = [];
    $redirectUrl = "";

    if ($type == "professor") {
        $data = $db->getProfessorByLegacyId($id);
        $redirectUrl = "compareDetail.php?type=$type&id=";
    } elseif ($type == "university") {
        $data = $db->getUniversityByLegacyId($id);
        $redirectUrl = "compareDetail.php?type=$type&id=";
    }

    if (!$data) {
        $errorMsg = "Sorry, we couldn't find a {$type} with that ID.";
        $queryParams = ['type' => $type];
        $queryString = http_build_query($queryParams);
    } else {
        $url = "$redirectUrl$id&scope=$scope";
        header("Location: $url");
        exit;
    }
}

?>

<!DOCTYPE html>
<html>

<head>
    <title>Search Form</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-5">
        <h1 class="text-center">Select comparison data</h1>
        <?php if (isset($errorMsg) && $errorMsg) : ?>
            <div class="alert alert-danger" role="alert">
                <?= $errorMsg; ?>
            </div>
        <?php endif; ?>
        <form action="<?php echo $_SERVER['PHP_SELF'] . '?' . $queryString ?>" method="post" class="mt-3">
            <div class="form-group">
                <?php if ($type == "professor") { ?>
                    <label for="id">Teacher ID:</label>
                <?php } else { ?>
                    <label for="id">School ID:</label>
                <?php } ?>
                <input type="number" class="form-control" id="id" name="id" value="<?= $id ?>">
            </div>
            <div class="form-group">
                <label for="scope">Scope:</label>
                <select class="form-control" id="scope" name="scope">
                    <?php
                    if ($type == "professor") { ?>
                        <option value="department" <?= $type === 'department' ? 'selected' : '' ?>>Department wide</option>
                        <option value="university" <?= $type === 'university' ? 'selected' : '' ?>>University wide</option>
                    <?php
                    } else { ?>
                        <option value="state" <?= $type === 'state' ? 'selected' : '' ?>>State-wide</option>
                        <option value="platform" <?= $type === 'platform' ? 'selected' : '' ?>>Platform-wide</option>
                    <?php
                    } ?>
                </select>
            </div>
            <input type="hidden" name="type" value="<?= $type ?>">
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</body>

</html>