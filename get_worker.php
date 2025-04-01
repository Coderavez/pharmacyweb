<?php
include 'db_connection.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $pdo->prepare("SELECT * FROM trydyaga WHERE id = :id");
    $stmt->execute(['id' => $id]);
    $worker = $stmt->fetch(PDO::FETCH_ASSOC);
    echo json_encode($worker);
} else {
    echo json_encode([]);
}
?>