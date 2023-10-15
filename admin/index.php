<?php

require_once '../db.php';
$db = new SQLiteDB('../rmp-py.db');

$file = fopen('../data/teacherHighlight.csv', 'r');
$professors = [];

while (($data = fgetcsv($file)) !== FALSE) {
    $professorId = $data[0];

    $teacherSql = "SELECT legacyId, firstName, lastName, schoolName, department FROM teachers WHERE legacyId = :professorId";
    $teacherData = $db->fetchOne($teacherSql, ['professorId' => $professorId]);

    if ($teacherData) {
        $professors[] = $teacherData;
    }
}

fclose($file);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>All highlighted professors</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container">
        <h1>List of Highlighted Professors</h1>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>School</th>
                    <th>Department</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($professors as $professor) : ?>
                    <tr>
                        <td><a href="detail.php?professorId=<?php echo $professor['legacyId']; ?>"><?php echo $professor['firstName'] . ' ' . $professor['lastName']; ?></a></td>
                        <td><?php echo $professor['schoolName']; ?></td>
                        <td><?php echo $professor['department']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <a href="create.php" class="btn btn-primary mb-3">Add Highlight</a>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>