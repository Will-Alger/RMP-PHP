<?php
$professorId = $_GET['professorId'] ?? null;
$highlightValue;
$file_path = '../data/teacherHighlight.csv';

if ($professorId) {
    $file = fopen($file_path, 'r');
    while (($line = fgetcsv($file)) !== FALSE) {
        if ($line[0] == $professorId) {
            $highlightValue = $line[1];
            break;
        }
    }
    fclose($file);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $newHighlightValue = $_POST['highlightValue'];

    $data = array_map(function ($row) use ($professorId, $newHighlightValue) {
        return $row[0] == $professorId ? [$row[0], $newHighlightValue] : $row;
    }, array_map('str_getcsv', file($file_path)));

    $fp = fopen($file_path, 'w');

    foreach ($data as $line) {
        fputcsv($fp, $line);
    }
    fclose($fp);
    header('Location: detail.php?professorId=' . $professorId);
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Edit Professor</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h1>Edit Highlight Value</h1>
        <form method="POST">
            <div class="form-group">
                <label>Highlighted?</label>
                <select class="form-control" name="highlightValue">
                    <option value="0" <?php if ($highlightValue == 0) echo 'selected'; ?>>false</option>
                    <option value="1" <?php if ($highlightValue == 1) echo 'selected'; ?>>true</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Confirm</button>
            <a href="detail.php?professorId=<?= $professorId; ?>" class="btn btn-danger">Cancel</a>
        </form>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>