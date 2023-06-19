<?php

include "login.php";

$_POST = json_decode(file_get_contents('php://input'), true);
if (!isset($_POST) ||
    !isset($_POST['red']) ||
    !isset($_POST['green']) ||
    !isset($_POST['blue']) ||
    !isset($_POST['deviation'])
) {
    header('Content-Type: application/json');
    echo json_encode(['error' => 'Invalid request']);
    die;
}

$mysqli = mysqli_connect($server, $user, $pass, $database, $port);
if (!$mysqli) {
    header('Content-Type: application/json');
    echo json_encode(['error' => 'Failed to connect to database']);
    die;
}

$red = $_POST['red'];
$green = $_POST['green'];
$blue = $_POST['blue'];
$deviation = $_POST['deviation'];

$sql = "INSERT INTO $table (red, green, blue, deviation) VALUES ('$red', '$green', '$blue', '$deviation')";
if (!$mysqli->query($sql)) {
    header('Content-Type: application/json');
    echo json_encode(['error' => 'Failed to save data']);
    $mysqli->close();
    die;
}

$sql = "SELECT COUNT(deviation)+1 from $table WHERE deviation < $deviation";
if (!$result = $mysqli->query($sql)) {
    header('Content-Type: application/json');
    echo json_encode(['error' => 'Failed to fetch data']);
    $mysqli->close();
    die;
}

$row = $result->fetch_row();
$position = $row[0];

header('Content-Type: application/json');
echo json_encode(['position' => $position]);
$mysqli->close();
die;
