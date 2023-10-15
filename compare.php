<?php
require_once 'navbar.php';
require_once 'db.php';

$teacherId = '';
$schoolId = '';
$scope = '';
$queryString = '';

$db = new SQLiteDB('rmp-py.db');
$type = filter_input(INPUT_GET, 'type', FILTER_SANITIZE_STRING);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $type = filter_input(INPUT_POST, 'type', FILTER_SANITIZE_STRING);
    $scope = filter_input(INPUT_POST, 'scope', FILTER_SANITIZE_STRING);

    if ($type == "professor") {
        $teacherId = filter_input(INPUT_POST, 'teacherId', FILTER_SANITIZE_NUMBER_INT);
        $teacherSql = "SELECT * FROM teachers WHERE legacyId = :teacherId";
        $teacherData = $db->fetchOne($teacherSql, ['teacherId' => $teacherId]);

        if (!$teacherData) {
            $errorMsg = "Sorry, we couldn't find a teacher with that ID.";
            $queryParams = ['type' => $type];
            $queryString = http_build_query($queryParams);
        } else {
            $url = "compareDetail.php?type=$type&teacherId=$teacherId&scope=$scope";
            header("Location: $url");
            exit;
        }
    } else if ($type == "university") {

        $schoolId = filter_input(INPUT_POST, 'schoolId', FILTER_SANITIZE_NUMBER_INT);
        $schoolSql = "SELECT * FROM schools WHERE legacyId = :schoolId";
        $schoolData = $db->fetchOne($schoolSql, ['schoolId' => $schoolId]);

        if (!$schoolData) {
            $errorMsg = "Sorry, we couldn't find a school with that ID.";
            $queryParams = ['type' => $type];
            $queryString = http_build_query($queryParams);
        } else {
            $url = "compareDetail.php?type=$type&schoolId=$schoolId&scope=$scope";
            header("Location: $url");
            exit;
        }
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Search Form</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-5">
        <h1 class="text-center">Select comparison data</h1>
        <?php if (isset($errorMsg) && $errorMsg) : ?>
            <div class="alert alert-danger" role="alert">
                <?= $errorMsg; ?>
            </div>
        <?php endif; ?>
        <form action="<?php echo $_SERVER['PHP_SELF'] . '?' . $queryString ?>" method="post" class="mt-3">
            <div class="form-group">
                <?php
                if ($type == "professor") { ?>
                    <label for="teacherId">Teacher ID:</label>
                    <input type="number" class="form-control" id="teacherId" name="teacherId" value="<?= $teacherId ?>">
                <?php
                } else { ?>
                    <label for="schoolId">School ID:</label>
                    <input type="number" class="form-control" id="schoolId" name="schoolId" value="<?= $schoolId ?>">
                <?php
                } ?>
            </div>
            <div class="form-group">
                <label for="scope">Scope:</label>
                <select class="form-control" id="scope" name="scope">
                    <?php
                    if ($type == "professor") { ?>
                        <option value="department" <?= $type === 'department' ? 'selected' : '' ?>>Department wide</option>
                        <option value="university" <?= $type === 'university' ? 'selected' : '' ?>>University wide</option>
                    <?php
                    } else { ?>
                        <option value="state" <?= $type === 'state' ? 'selected' : '' ?>>State-wide</option>
                        <option value="platform" <?= $type === 'platform' ? 'selected' : '' ?>>Platform-wide</option>
                    <?php
                    } ?>
                </select>
            </div>
            <input type="hidden" name="type" value="<?= $type ?>">
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</body>

</html>