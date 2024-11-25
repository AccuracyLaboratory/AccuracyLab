<?php
$host = 'localhost';
$dbname = 'alc_db';
$username = 'root';
$password = '';

$selectedYear = isset($_GET['year']) ? $_GET['year'] : date("Y");

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $pdo->prepare("
        SELECT service, MONTH(datetime) AS month, COUNT(*) AS count
        FROM appointments
        WHERE YEAR(datetime) = :selectedYear
        GROUP BY service, MONTH(datetime)
        ORDER BY service, month
    ");
    $stmt->execute(['selectedYear' => $selectedYear]);

    $data = [];
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $service = $row['service'];
        $month = $row['month'];
        $count = $row['count'];

        if (!isset($data[$service])) {
            $data[$service] = array_fill(0, 12, 0);
        }
        
        $data[$service][$month - 1] = $count;
    }

    header('Content-Type: application/json');
    echo json_encode($data);

} catch (PDOException $e) {
    echo json_encode(["error" => $e->getMessage()]);
}
?>
