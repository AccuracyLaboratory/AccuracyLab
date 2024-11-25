<?php
require_once "connectDB.php";

$totals = [
    "items" => [],
    "quantities" => [],
    "quantities_used" => [],
    "appointments" => []
];

$services = [];

$sql = "SELECT DISTINCT service FROM inventory";
$result = mysqli_query($link, $sql);

while ($row = mysqli_fetch_assoc($result)) {
    $service = $row['service'];
    $services[] = $service;
    $totals['items'][] = $service;
    $totals['quantities'][$service] = 0;
    $totals['quantities_used'][$service] = 0;
    $totals['appointments'][$service] = 0;
}

$sql = "SELECT service, SUM(quantity) AS total_quantity, SUM(quantity_used) AS total_quantity_used FROM inventory GROUP BY service";
$result = mysqli_query($link, $sql);

while ($row = mysqli_fetch_assoc($result)) {
    $service = $row['service'];
    if (in_array($service, $services)) {
        $totals['quantities'][$service] = (int)$row['total_quantity'];
        $totals['quantities_used'][$service] = (int)$row['total_quantity_used'];
    }
}

$appointment_sql = "SELECT service, COUNT(*) as completed_count FROM appointments WHERE status = 1 GROUP BY service";
$appointment_result = mysqli_query($link, $appointment_sql);

while ($row = mysqli_fetch_assoc($appointment_result)) {
    $service = $row['service'];
    if (in_array($service, $services)) {
        $totals['appointments'][$service] = (int)$row['completed_count'];
    }
}

$totals['quantities'] = array_values($totals['quantities']);
$totals['quantities_used'] = array_values($totals['quantities_used']);
$totals['appointments'] = array_values($totals['appointments']);

header('Content-Type: application/json');
echo json_encode($totals);
?>
