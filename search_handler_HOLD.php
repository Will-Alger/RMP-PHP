<?php
require_once 'db.php';

$db = new SQLiteDB('rmp-py.db');

if (isset($_POST['type']) && isset($_POST['query'])) {
    $query = trim($_POST['query']);
    $nameParts = explode(" ", $query);

    if ($_POST['type'] == 'professor') {
        if (count($nameParts) == 1) {
            $sql = "SELECT * FROM teachers WHERE firstName LIKE :name OR lastName LIKE :name LIMIT 10";
            $params = [':name' => "%$query%"];
        } else {
            $sql = "SELECT * FROM teachers WHERE firstName LIKE :firstname AND lastName LIKE :lastname LIMIT 10";
            $params = [
                ':firstname' => "%$nameParts[0]%",
                ':lastname' => "%$nameParts[1]%"
            ];
        }
        $results = $db->fetchAll($sql, $params);
        foreach ($results as $result) {
            echo "<div>" . htmlspecialchars($result['firstName']) . " " . htmlspecialchars($result['lastName']) . "</div>";
        }
    } elseif ($_POST['type'] == 'university') {
        $sql = "SELECT * FROM schools WHERE name LIKE :name LIMIT 10";
        $params = [':name' => "%$query%"];
        $results = $db->fetchAll($sql, $params);
        foreach ($results as $result) {
            echo "<div>" . htmlspecialchars($result['name']) . "</div>";
        }
    }
}
