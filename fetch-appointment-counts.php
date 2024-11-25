<?php
require_once "connectDB.php";

$sql = "SELECT COUNT(*) as total, 
               SUM(CASE WHEN status = 1 THEN 1 ELSE 0 END) as approved,
               SUM(CASE WHEN status = 2 THEN 1 ELSE 0 END) as cancelled
        FROM appointments";

$result = mysqli_query($link, $sql);
$row = mysqli_fetch_assoc($result);

$response = [
    'total' => (int)$row['total'],
    'approved' => (int)$row['approved'],
    'cancelled' => (int)$row['cancelled'],
];

header('Content-Type: application/json');
echo json_encode($response);
