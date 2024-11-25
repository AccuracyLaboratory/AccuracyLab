<?php
$host = 'localhost';
$dbname = 'alc_db';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $pdo->query("
        SELECT service, COUNT(*) as count 
        FROM appointments 
        WHERE DATE(datetime) = CURDATE() 
        GROUP BY service
    ");
    
    $services = [];
    $counts = [];

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $services[] = $row['service'];
        $counts[] = $row['count'];
    }

    echo json_encode(['services' => $services, 'counts' => $counts]);

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
