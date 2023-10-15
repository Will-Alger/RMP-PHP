<?php
require_once '../db.php';
require_once('../functions.php');



if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $db = new SQLiteDB('../rmp-py.db');
    $professorId = filter_input(INPUT_POST, 'professorId', FILTER_SANITIZE_NUMBER_INT);
    $includeInHighlight = isset($_POST['includeInHighlight']) ? 1 : 0;

    if (!empty($professorId)) {

        $file = fopen('../data/teacherHighlight.csv', 'r');
        $existsInCsv = false;
        while (($data = fgetcsv($file)) !== FALSE) {
            if ($data[0] == $professorId) {
                $existsInCsv = true;
                break;
            }
        }
        fclose($file);

        if (!$existsInCsv) {

            $teacherSql = "SELECT * FROM teachers WHERE legacyId = :professorId";
            $teacherData = $db->fetchOne($teacherSql, ['professorId' => $professorId]);

            if ($teacherData) {
                $file = fopen('../data/teacherHighlight.csv', 'a');
                fputcsv($file, [$professorId, $includeInHighlight]);
                fclose($file);
                $responseMsg = "Professor " . $teacherData['firstName'] . ' ' . $teacherData['lastName'] . ' added to highlights';
            } else {
                $responseMsg = "Could not find that professor ID, sorry.";
            }
        } else {
            $responseMsg = "Professor ID already exists in highlights";
        }
    } else {
        $responseMsg = "Please enter a valid professor ID.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Add a professor to highlights</title>
    <meta charset="utf-8">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

    <div class="container">
        <h1>Enter Professor ID</h1>

        <?php if (isset($responseMsg)) : ?>
            <div class="alert alert-info">
                <?php echo $responseMsg; ?>
            </div>
        <?php endif; ?>

        <form action="create.php" method="post">
            <div class="form-group">
                <label for="professorId">Professor ID:</label>
                <input type="number" class="form-control" id="professorId" name="professorId">
            </div>
            <div class="form-check">
                <input type="checkbox" class="form-check-input" id="includeInHighlight" name="includeInHighlight">
                <label class="form-check-label" for="includeInHighlight">Include in Highlight</label>
            </div>
            <button type="submit" class="btn btn-primary mt-3">Submit</button>
        </form>

        <a href="index.php" class="btn btn-secondary mt-3">Back</a>

    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>

</html>