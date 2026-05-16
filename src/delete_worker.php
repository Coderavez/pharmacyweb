<?php
include 'db_connection.php';

header('Content-Type: application/json');

$id = $_GET['id'] ?? null;

if (!$id) {
    echo json_encode([
        'success' => false,
        'error' => 'ID не передан'
    ]);
    exit;
}

try {
    $stmt = $pdo->prepare("DELETE FROM trydyaga WHERE id = :id");
    $stmt->execute(['id' => $id]);

    echo json_encode([
        'success' => true
    ]);

} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
}
?>
