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
$dep = $teacherData['department'];
if ($scope == "department") {
    $schoolSql = "
        SELECT
            ROUND(avg(avgRating), 2) as avgRating, 
            ROUND(avg(avgDifficulty), 2) as avgDifficulty,
            ROUND(avg(wouldTakeAgainPercent), 2) as 'avgWouldTakeAgain%',
            ROUND(avg(numRatings), 2) as avgNumRatings
        FROM teachers
        WHERE schoolID = :schoolID
        AND department = :dep";
    $params = ['schoolID' => $schoolID, 'dep' => $dep];
} else {
    $schoolSql = "
        SELECT
            ROUND(avg(avgRating), 2) as avgRating, 
            ROUND(avg(avgDifficulty), 2) as avgDifficulty,
            ROUND(avg(wouldTakeAgainPercent), 2) as 'avgWouldTakeAgain%',
            ROUND(avg(numRatings), 2) as avgNumRatings
        FROM teachers
        WHERE schoolID = :schoolID";
    $params = ['schoolID' => $schoolID];
}
$schoolData = $db->fetchOne($schoolSql, $params);

function getBoxColor($teacherValue, $schoolAverage, $inverse = false)
{
    if ($inverse) {
        if ($teacherValue < $schoolAverage) {
            return 'bg-success text-white';
        } elseif ($teacherValue <= $schoolAverage * 1.1) {
            return 'bg-secondary text-white';
        } else {
            return 'bg-danger text-white';
        }
    } else {
        if ($teacherValue > $schoolAverage) {
            return 'bg-success text-white';
        } elseif ($teacherValue >= $schoolAverage * 0.9) {
            return 'bg-secondary text-white';
        } else {
            return 'bg-danger text-white';
        }
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Comparison Details</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-5">
        <?php if ($scope == "department") { ?>
            <h1 class="text-center display-4 my-4">Comparative Analysis: Professor vs. <span class="text-primary"><?= $teacherData['department'] ?></span> Department Averages</h1>
        <?php } else { ?>
            <h1 class="text-center display-4 my-4">Comparative Analysis: Professor vs. <span class="text-primary">University</span> Wide Averages</h1>
        <?php } ?>
        <div class="row justify-content-center">
            <div class="col-md-5 mt-3 d-flex">
                <div class="card flex-fill shadow">
                    <div class="card-header">
                        <h3><?= $teacherData['firstName'] . " " . $teacherData['lastName'] ?><br>
                            <h5 class="text-secondary"><?= $teacherData['typename'] ?></h5>
                        </h3>
                    </div>
                    <div class="card-body">
                        <?php if ($teacherData) : ?>
                            <p><strong>AvgRating: </strong> <span class="p-1 rounded <?= getBoxColor($teacherData['avgRating'], $schoolData['avgRating']) ?>"><?= $teacherData['avgRating'] ?></span></p>
                            <p><strong>AvgDifficulty: </strong> <span class="p-1 rounded <?= getBoxColor($teacherData['avgDifficulty'], $schoolData['avgDifficulty'], True) ?>"><?= $teacherData['avgDifficulty'] ?></span></p>
                            <p><strong>AvgWouldTakeAgain%: </strong> <span class="p-1 rounded <?= getBoxColor($teacherData['wouldTakeAgainPercent'], $schoolData['avgWouldTakeAgain%']) ?>"><?= $teacherData['wouldTakeAgainPercent'] ?></span></p>
                            <p><strong>NumRatings: </strong> <span class="p-1 rounded <?= getBoxColor($teacherData['numRatings'], $schoolData['avgNumRatings']) ?>"><?= $teacherData['numRatings'] ?></span></p>
                        <?php else : ?>
                            <p>No teacher data found.</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="col-md-5 mt-3 d-flex">
                <div class="card flex-fill shadow">
                    <div class="card-header">
                        <h3><?= $teacherData['schoolName'] ?></h3>
                        <h5 class="text-secondary">
                            <?= $scope == "department" ? $teacherData['department'] . " department averages" : "university wide averages" ?>
                        </h5>
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
            <a href="compareProf.php" class="btn btn-primary shadow">Back</a>
        </div>
    </div>
</body>

</html>