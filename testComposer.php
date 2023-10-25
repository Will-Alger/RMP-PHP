<?php

require_once __DIR__ . '/vendor/autoload.php';

use Doctrine\DBAL\DriverManager;
use Doctrine\DBAL\Tools\DsnParser;

$dsnParser = new DsnParser();
$connectionParams = $dsnParser->parse('sqlite3:///' . __DIR__ . '/rmp-py.db');

$conn = DriverManager::getConnection($connectionParams);

$stmt = $conn->prepare('SELECT * FROM schools LIMIT 5');

$result = $stmt->executeQuery();

var_dump($result->fetchAllAssociative());
