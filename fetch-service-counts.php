<?php
require_once "connectDB.php";

$counts = [
    "total" => 0,
    "laboratory" => 0,
    "xray" => 0,
    "2d_echo" => 0,
    "ultrasound" => 0,
    "ecg" => 0,
];

$sql = "SELECT COUNT(*) as total FROM appointments";
$result = mysqli_query($link, $sql);
$row = mysqli_fetch_assoc($result);
$counts["total"] = $row['total'];

$services = ['laboratory', 'xray', '2d_echo', 'ultrasound', 'ecg'];

foreach ($services as $service) {
    $sql = "SELECT COUNT(*) as count FROM appointments WHERE service = '$service'";
    $result = mysqli_query($link, $sql);
    $row = mysqli_fetch_assoc($result);
    $counts[$service] = $row['count'];
}

header('Content-Type: application/json');
echo json_encode($counts);
?>
