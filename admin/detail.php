<?php

require_once '../db.php';
$db = new SQLiteDB('../rmp-py.db');

$professorId = $_GET['professorId'] ?? null;
$highlightValue;

if ($professorId) {
    $teacherSql = "SELECT * FROM teachers WHERE legacyId = :professorId";
    $professor = $db->fetchOne($teacherSql, ['professorId' => $professorId]);
}

$file = fopen('../data/teacherHighlight.csv', 'r');
while (($line = fgetcsv($file)) !== FALSE) {
    //$line is an array of the csv elements
    if ($line[0] == $professorId) {
        $highlightValue = $line[1]; // assuming highlight value is in second column
        break;
    }
}
fclose($file);

?>



<!DOCTYPE html>
<html lang="en">

<head>
    <title>Professor Details</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h1>Professor Detail</h1>

        <?php if ($professor) : ?>
            <ul class="list-group list-group-flush mb-3">
                <li class="list-group-item"><strong>Name:</strong> <?php echo $professor['firstName'] . ' ' . $professor['lastName']; ?></li>
                <li class="list-group-item"><strong>School:</strong> <?php echo $professor['schoolName']; ?></li>
                <li class="list-group-item"><strong>Department:</strong> <?php echo $professor['department']; ?></li>
                <li class="list-group-item"><strong>Type:</strong> <?php echo $professor['typename']; ?></li>
                <li class="list-group-item"><strong>Average Difficulty:</strong> <?php echo $professor['avgDifficulty']; ?></li>
                <li class="list-group-item"><strong>Average Rating:</strong> <?php echo $professor['avgRating']; ?></li>
                <li class="list-group-item"><strong>Number of Ratings:</strong> <?php echo $professor['numRatings']; ?></li>
                <li class="list-group-item"><strong>Would Take Again Percent:</strong> <?php echo $professor['wouldTakeAgainPercent']; ?>%</li>
                <li class="list-group-item"><strong>Highlighted?:</strong> <?= $highlightValue == 0 ? 'false' : 'true'; ?></li>
            </ul>
        <?php else : ?>
            <p class="text-danger">No information found for this professor.</p>
        <?php endif; ?>
        <a href="index.php" class="btn btn-primary">Back</a>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>