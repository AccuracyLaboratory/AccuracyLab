<?php
$host = 'localhost';
$dbname = 'alc_db';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $pdo->query("
        SELECT 
            SUM(CASE WHEN datetime >= DATE_SUB(CURDATE(), INTERVAL 7 DAY) THEN 1 ELSE 0 END) as new_appointments,
            SUM(CASE WHEN datetime < DATE_SUB(CURDATE(), INTERVAL 7 DAY) THEN 1 ELSE 0 END) as old_appointments
        FROM appointments
    ");
    
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $new_appointments = $row['new_appointments'];
    $old_appointments = $row['old_appointments'];

    header('Content-Type: application/json');
    echo json_encode(['new' => $new_appointments, 'old' => $old_appointments]);

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
