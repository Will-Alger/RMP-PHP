<?php
require_once 'db.php';

$db = new SQLiteDB('rmp-py.db');

$teacherID = filter_input(INPUT_GET, 'teacherID', FILTER_SANITIZE_NUMBER_INT);
$scope = filter_input(INPUT_GET, 'scope', FILTER_SANITIZE_STRING);

$teacherSql = "SELECT * FROM teachers WHERE legacyId = :teacherID";
$teacherData = $db->fetchOne($teacherSql, ['teacherID' => $teacherID]);

$schoolID = $teacherData['schoolId'];

$schoolSql = "";
$params = [];
if ($scope == "department") {
    $dep = $teacherData['department'];
    $schoolSql = "
        SELECT avg(avgRating) as averageRating
        FROM teachers
        WHERE schoolID = :schoolID
        AND department = :dep";
    $params = ['schoolID' => $schoolID, 'dep' => $dep];
}
$schoolData = $db->fetchOne($schoolSql, $params);
?>

<!DOCTYPE html>
<html>

<head>
    <title>Comparison Details</title>
    <!-- Import Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-5">
        <h1 class="text-center">Comparison Details</h1>

        <div class="row justify-content-center">
            <div class="col-md-4 mt-3">
                <div class="card">
                    <div class="card-header">
                        Teacher Details
                    </div>
                    <div class="card-body">
                        <?php if ($teacherData) : ?>
                            <?php foreach ($teacherData as $key => $value) : ?>
                                <p><strong><?= ucfirst($key) ?>: </strong> <?= $value ?></p>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <p>No teacher data found.</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mt-3">
                <div class="card">
                    <div class="card-header">
                        School Details
                    </div>
                    <div class="card-body">
                        <?php if ($schoolData) : ?>
                            <?php foreach ($schoolData as $key => $value) : ?>
                                <p><strong><?= ucfirst($key) ?>: </strong> <?= $value ?></p>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <p>No school data found.</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-center mt-3">
            <a href="private.php" class="btn btn-primary">Back</a>
        </div>
    </div>
</body>

</html>