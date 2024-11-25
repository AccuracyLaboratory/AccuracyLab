<?php
require_once "connectDB.php";

$totals = [
    "machines" => [],
    "quantities" => [],
    "downtimes" => []
];

$sql = "SELECT DISTINCT machine FROM machine";
$result = mysqli_query($link, $sql);

while ($row = mysqli_fetch_assoc($result)) {
    $machine = $row['machine'];
    $totals['machines'][] = $machine;
    $totals['quantities'][$machine] = 0;
    $totals['downtimes'][$machine] = 0;
}

$sql = "SELECT machine, SUM(quantity) AS total_quantity, SUM(downtime) AS total_downtime FROM machine GROUP BY machine";
$result = mysqli_query($link, $sql);

while ($row = mysqli_fetch_assoc($result)) {
    $machine = $row['machine'];
    if (in_array($machine, $totals['machines'])) {
        $totals['quantities'][$machine] = (int)$row['total_quantity'];
        $totals['downtimes'][$machine] = (int)$row['total_downtime'];
    }
}

$totals['quantities'] = array_values($totals['quantities']);
$totals['downtimes'] = array_values($totals['downtimes']);

header('Content-Type: application/json');
echo json_encode($totals);
?>
