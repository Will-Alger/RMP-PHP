<?php
require_once('functions.php');
require_once('navbar.php');
if (!isset($_SESSION['email'])) {
    die('This is a private area, you are not allowed here');
}

$results = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    require_once 'db.php';

    $db = new SQLiteDB('E:/rmp-py-db/rmp-py.db');
    $professor_firstname = filter_input(INPUT_POST, 'professor_firstname', FILTER_SANITIZE_STRING);
    $professor_lastname = filter_input(INPUT_POST, 'professor_lastname', FILTER_SANITIZE_STRING);

    $sql = "SELECT * FROM teachers WHERE firstName LIKE :firstname AND lastName LIKE :lastname";
    $params = [':firstname' => "%$professor_firstname%", ':lastname' => "%$professor_lastname%"];

    $results = $db->fetchAll($sql, $params);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Professors</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <a href="private.php" class="btn btn-secondary mb-3">Back</a>
        <h1 class="mb-4 text-center">Search For Professor</h1>
        <form method="POST">
            <div class="form-row justify-content-center">
                <div class="form-group col-md-4">
                    <label for="firstname">Professor's First Name:</label>
                    <input type="text" class="form-control" name="professor_firstname" id="firstname" required>
                </div>
                <div class="form-group col-md-4">
                    <label for="lastname">Professor's Last Name:</label>
                    <input type="text" class="form-control" name="professor_lastname" id="lastname" required>
                </div>
            </div>
            <div class="text-center">
                <button type="submit" class="btn btn-primary">Search</button>
            </div>
        </form>

        <?php if (!empty($results)) : ?>
            <div class="container mt-3">
                <h2 class="mb-3">Search Results</h2>
                <?php foreach ($results as $result) : ?>
                    <div class="row border mb-3 p-2">
                        <div class="col-sm"><?= htmlspecialchars($result['firstName']) . ' ' . htmlspecialchars($result['lastName']) ?></div>
                        <div class="col-sm">Type: <?= htmlspecialchars($result['typename']) ?></div>
                        <div class="col-sm">Avg Difficulty: <?= htmlspecialchars($result['avgDifficulty']) ?></div>
                        <div class="col-sm">Avg Rating: <?= htmlspecialchars($result['avgRating']) ?></div>
                        <div class="col-sm">Dept.: <?= htmlspecialchars($result['department']) ?></div>
                        <!-- <div class="col-sm">ID: <?= htmlspecialchars($result['id']) ?></div> -->
                        <!-- <div class="col-sm">Is Saved: <?= $result['isSaved'] ? 'Yes' : 'No' ?></div> -->
                        <!-- <div class="col-sm">Legacy ID: <?= htmlspecialchars($result['legacyId']) ?></div> -->
                        <div class="col-sm">Num Ratings: <?= htmlspecialchars($result['numRatings']) ?></div>
                        <!-- <div class="col-sm">School ID: <?= htmlspecialchars($result['schoolId']) ?></div> -->
                        <div class="col-sm">School Name: <?= htmlspecialchars($result['schoolName']) ?></div>
                        <div class="col-sm">Would Take Again%: <?= htmlspecialchars($result['wouldTakeAgainPercent']) ?></div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>