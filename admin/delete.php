<?php

require_once '../db.php';
$db = new SQLiteDB('../rmp-py.db');

$professorId = $_GET['professorId'] ?? null;

if ($professorId) {
    $teacherSql = "SELECT * FROM teachers WHERE legacyId = :professorId";
    $professor = $db->fetchOne($teacherSql, ['professorId' => $professorId]);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $file = '../data/teacherHighlight.csv';
    $lines = file($file);
    foreach ($lines as $key => $line)
        if (str_getcsv($line)[0] == $professorId)
            unset($lines[$key]);
    file_put_contents($file, $lines);

    header('Location: index.php');
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Confirm Delete</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h1>Are you sure you want to delete this profile?</h1>

        <?php if ($professor) : ?>
            <ul class="list-group list-group-flush mb-3">
                <li class="list-group-item"><strong>Name:</strong> <?php echo $professor['firstName'] . ' ' . $professor['lastName']; ?></li>
            </ul>
        <?php else : ?>
            <p class="text-danger">No information found for this professor.</p>
        <?php endif; ?>

        <form method="post">
            <button class="btn btn-danger">Confirm Delete</button>
            <a href="detail.php?professorId=<?= $professorId; ?>" class="btn btn-secondary">Cancel</a>
        </form>

    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>