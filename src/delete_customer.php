<?php
include 'db_connection.php';

header('Content-Type: application/json');

// берём id безопасно (GET работает стабильнее в Apache)
$id = $_GET['id'] ?? null;

if (!$id) {
    echo json_encode(['success' => false, 'error' => 'No ID']);
    exit;
}

try {
    $stmt = $pdo->prepare("DELETE FROM pokypatel WHERE id = :id");
    $stmt->execute(['id' => $id]);

    echo json_encode(['success' => true]);

} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
}
?>
