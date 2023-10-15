<?php

require_once 'db.php';
require_once 'navbar.php';
$db = new SQLiteDB('rmp-py.db');

$file = fopen('data/teacherHighlight.csv', 'r');
$professors = [];

while (($line = fgetcsv($file)) !== FALSE) {
    $professorId = $line[0];
    $highlightValue = $line[1];

    if ($highlightValue == 1) {
        $teacherSql = "SELECT * FROM teachers WHERE legacyId = :professorId";
        $professor = $db->fetchOne($teacherSql, ['professorId' => $professorId]);

        $professor['highlightValue'] = $highlightValue == 0 ? 'false' : 'true';

        if ($professor) {
            $professors[] = $professor;
        }
    }
}

fclose($file);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Highlighted Professors</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h1>Highlighted Professors</h1>
        <div class="row">
            <?php foreach ($professors as $professor) : ?>
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card shadow p-3">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $professor['firstName'] . ' ' . $professor['lastName']; ?></h5>
                            <p class="card-text"><strong>School:</strong> <?php echo $professor['schoolName']; ?></p>
                            <p class="card-text"><strong>Type:</strong> <?php echo $professor['typename']; ?></p>
                            <p class="card-text"><strong>Average Rating:</strong> <?php echo $professor['avgRating']; ?></p>
                            <p class="card-text"><strong>Highlighted?:</strong> <?php echo $professor['highlightValue']; ?></p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>