<?php
require_once "connectDB.php";


$currentYear = isset($_GET['YEAR']) ? (int)$_GET['YEAR'] : date('Y');


$months = [];
$counts = array_fill(0, 12, 0); 

for ($i = 1; $i <= 12; $i++) {
    $months[] = date("M", mktime(0, 0, 0, $i, 1));
}


$sql = "SELECT MONTH(datetime) as month, COUNT(*) as count 
        FROM appointments 
        WHERE YEAR(datetime) = ? 
        GROUP BY MONTH(datetime)";

$stmt = mysqli_prepare($link, $sql);
mysqli_stmt_bind_param($stmt, "i", $currentYear);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);


while ($row = mysqli_fetch_assoc($result)) {
    $counts[(int)$row['month'] - 1] = (int)$row['count'];
}

$response = [
    'months' => $months,
    'counts' => $counts,
];

header('Content-Type: application/json');
echo json_encode($response);
