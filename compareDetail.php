<?php
require_once 'db.php';
require_once 'sql/queries.php';

$db = new SQLiteDB('rmp-py.db');

$type = filter_input(INPUT_GET, 'type', FILTER_SANITIZE_STRING);
$scope = filter_input(INPUT_GET, 'scope', FILTER_SANITIZE_STRING);
$teacherData;
$schoolData;
$aggregateSchoolData;

if ($type == "professor") {
    // get the professor that will be compared
    $teacherId = filter_input(INPUT_GET, 'teacherId', FILTER_SANITIZE_NUMBER_INT);
    $teacherSql = "SELECT * FROM teachers WHERE legacyId = :teacherId";
    $teacherData = $db->fetchOne($teacherSql, ['teacherId' => $teacherId]);

    $schoolId = $teacherData['schoolId'];
    $department = $teacherData['department'];

    $params = ['schoolId' => $schoolId];

    // if filtering by department, add it to the query + query parameters
    if ($scope == "department") {
        $aggregateTeacherSql .= " AND department = :department AND avgRating != 0";
        $params['department'] = $department;
    }
    $schoolData = $db->fetchOne($aggregateTeacherSql, $params);
} else if ($type == "university") {

    // get the university that will be compared
    $schoolId = filter_input(INPUT_GET, 'schoolId', FILTER_SANITIZE_NUMBER_INT);
    $schoolData = $db->fetchOne($schoolDataQuery, ['schoolId' => $schoolId]);

    $state = $schoolData['state'];
    if ($scope == "state") {
        // filter by state
        $aggregateSchoolDataSql .= " WHERE state = :state";
        $aggregateSchoolData = $db->fetchOne($aggregateSchoolDataSql, ['state' => $state]);
    } else if ($scope == "platform") {
        $aggregateSchoolData = $db->fetchOne($aggregateSchoolDataSql);
    }
}

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
        <?php
        if ($type == "professor") {
            if ($scope == "department") { ?>
                <h1 class="text-center display-4 my-4">Comparative Analysis: Professor vs. <span class="text-primary"><?= $teacherData['department'] ?> Department Averages</span></h1>
            <?php } else { ?>
                <h1 class="text-center display-4 my-4">Comparative Analysis: Professor vs. <span class="text-primary">University Wide Averages</span></h1>
            <?php }
        } elseif ($type == "university") {
            if ($scope == "state") { ?>
                <h1 class="text-center display-4 my-4">Comparative Analysis: University vs. <span class="text-primary"><?= $schoolData['state'] ?> Averages</span></h1>
            <?php } else { ?>
                <h1 class="text-center display-4 my-4">Comparative Analysis: University vs. <span class="text-primary">?Ratemyprofessor Averages</span></h1>
        <?php }
        }
        ?>
        <div class="row justify-content-center">

            <!-- FIRST CARD DISPLAY -->
            <div class="col-md-5 mt-3 d-flex">
                <div class="card flex-fill shadow">
                    <div class="card-header">
                        <?php
                        if ($type == "professor" && $teacherData) : ?>
                            <h3><?= $teacherData['firstName'] . " " . $teacherData['lastName'] ?><br>
                                <h5 class="text-secondary"><?= $teacherData['typename'] ?></h5>
                            </h3>
                        <?php
                        elseif ($type == "university" && $schoolData) : ?>
                            <h3><?= $schoolData['name'] ?><br>
                                <h5 class="text-secondary"><?= $schoolData['state'] ?></h5>
                            </h3>
                        <?php
                        else : ?>
                            <h3>No data found</h3>
                        <?php
                        endif;
                        ?>
                    </div>
                    <div class="card-body">
                        <?php
                        if ($type == "professor" && $teacherData) : ?>
                            <p><strong>AvgRating: </strong> <span class="p-1 rounded <?= getBoxColor($teacherData['avgRating'], $schoolData['avgRating']) ?>"><?= $teacherData['avgRating'] ?></span></p>
                            <p><strong>AvgDifficulty: </strong> <span class="p-1 rounded <?= getBoxColor($teacherData['avgDifficulty'], $schoolData['avgDifficulty'], True) ?>"><?= $teacherData['avgDifficulty'] ?></span></p>
                            <p><strong>AvgWouldTakeAgain%: </strong> <span class="p-1 rounded <?= getBoxColor($teacherData['wouldTakeAgainPercent'], $schoolData['avgWouldTakeAgain%']) ?>"><?= $teacherData['wouldTakeAgainPercent'] ?></span></p>
                            <p><strong>NumRatings: </strong> <span class="p-1 rounded <?= getBoxColor($teacherData['numRatings'], $schoolData['avgNumRatings']) ?>"><?= $teacherData['numRatings'] ?></span></p>
                        <?php
                        elseif ($type == "university" && $schoolData) : ?>
                            <p><strong>NumRatings: </strong> <span class="p-1 rounded <?= getBoxColor($schoolData['numRatings'], $aggregateSchoolData['avgNumRatings']) ?>"><?= $schoolData['numRatings'] ?></span></p>
                            <p><strong>CampusCondition: </strong> <span class="p-1 rounded <?= getBoxColor($schoolData['campusCondition'], $aggregateSchoolData['avgCampusCondition']) ?>"><?= $schoolData['campusCondition'] ?></span></p>
                            <p><strong>CampusLocation: </strong> <span class="p-1 rounded <?= getBoxColor($schoolData['campusLocation'], $aggregateSchoolData['avgCampusLocation']) ?>"><?= $schoolData['campusLocation'] ?></span></p>
                            <p><strong>CareerOpportunities: </strong> <span class="p-1 rounded <?= getBoxColor($schoolData['careerOpportunities'], $aggregateSchoolData['avgCareerOpportunities']) ?>"><?= $schoolData['careerOpportunities'] ?></span></p>
                            <p><strong>ClubAndEventActivities: </strong> <span class="p-1 rounded <?= getBoxColor($schoolData['clubAndEventActivities'], $aggregateSchoolData['avgClubAndEventActivities']) ?>"><?= $schoolData['clubAndEventActivities'] ?></span></p>
                            <p><strong>FoodQuality: </strong> <span class="p-1 rounded <?= getBoxColor($schoolData['foodQuality'], $aggregateSchoolData['avgFoodQuality']) ?>"><?= $schoolData['foodQuality'] ?></span></p>
                            <p><strong>InternetSpeed: </strong> <span class="p-1 rounded <?= getBoxColor($schoolData['internetSpeed'], $aggregateSchoolData['avgInternetSpeed']) ?>"><?= $schoolData['internetSpeed'] ?></span></p>
                            <p><strong>LibraryCondition: </strong> <span class="p-1 rounded <?= getBoxColor($schoolData['libraryCondition'], $aggregateSchoolData['avgLibraryCondition']) ?>"><?= $schoolData['libraryCondition'] ?></span></p>
                            <p><strong>SchoolReputation: </strong> <span class="p-1 rounded <?= getBoxColor($schoolData['schoolReputation'], $aggregateSchoolData['avgSchoolReputation']) ?>"><?= $schoolData['schoolReputation'] ?></span></p>
                            <p><strong>SchoolSafety: </strong> <span class="p-1 rounded <?= getBoxColor($schoolData['schoolSafety'], $aggregateSchoolData['avgSchoolSafety']) ?>"><?= $schoolData['schoolSafety'] ?></span></p>
                            <p><strong>SchoolSatisfaction: </strong> <span class="p-1 rounded <?= getBoxColor($schoolData['schoolSatisfaction'], $aggregateSchoolData['avgSchoolSatisfaction']) ?>"><?= $schoolData['schoolSatisfaction'] ?></span></p>
                            <p><strong>SocialActivities: </strong> <span class="p-1 rounded <?= getBoxColor($schoolData['socialActivities'], $aggregateSchoolData['avgSocialActivities']) ?>"><?= $schoolData['socialActivities'] ?></span></p>
                        <?php
                        endif;
                        ?>
                    </div>
                </div>
            </div>

            <!-- SECOND CARD DISPLAY -->
            <div class="col-md-5 mt-3 d-flex">
                <div class="card flex-fill shadow">
                    <div class="card-header">
                        <?php
                        if ($type == "professor" && $teacherData) : ?>
                            <h3><?= $teacherData['schoolName'] ?></h3>
                            <h5 class="text-secondary">
                                <?= $scope == "department" ? $teacherData['department'] . " department averages" : "university wide averages" ?>
                            </h5>
                        <?php
                        elseif ($type == "university" && $schoolData) : ?>
                            <h3><?= $scope == "state" ? $schoolData['state'] : "Ratemyprofessor" ?></h3>
                            <h5 class="text-secondary">
                                <?= $scope == "state" ? "state averages" : "Ratemyprofessor averages" ?>
                            </h5>
                        <?php
                        endif;
                        ?>
                    </div>
                    <div class="card-body">
                        <?php
                        if ($type == "professor" && $teacherData) :
                            foreach ($schoolData as $key => $value) : ?>
                                <p><strong><?= ucfirst($key) ?>: </strong> <?= $value ?></p>
                            <?php
                            endforeach;
                        elseif ($type == "university" && $schoolData) :
                            foreach ($aggregateSchoolData as $key => $value) : ?>
                                <p><strong><?= ucfirst($key) ?>: </strong> <?= $value ?></p>
                            <?php
                            endforeach;
                        else : ?>
                            <p>No relevant data found.</p>
                        <?php
                        endif; ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="d-flex justify-content-center mt-3">
            <a href="compare.php?type=<?= $type ?>" class="btn btn-primary shadow">Back</a>
        </div>
    </div>
</body>

</html>