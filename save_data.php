<?php
require_once 'mysql/mysqlsorgu.php';

$conn = dbConnect();

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $day = intval($_POST['day']);
    $month = $_POST['month'];
    $field = $_POST['field'];
    $value = floatval(str_replace(',', '.', $_POST['value']));

    $sql = "INSERT INTO energy_consumption (day, month, $field) VALUES ($day, '$month', $value)
            ON DUPLICATE KEY UPDATE $field = VALUES($field)";

    if ($conn->query($sql) === TRUE) {
        echo "Record updated successfully";
    } else {
        echo "Error updating record: " . $conn->error;
    }

    $conn->close();
}
?>
