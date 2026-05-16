<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Pharmacy Workers</title>
    <style>
        body { font-family: Arial; margin: 20px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 8px; }
        th { background: #f2f2f2; }
        button { padding: 5px 10px; }
    </style>
</head>
<body>

<h1>Pharmacy Workers</h1>
<a href="index.php">Back to Home</a>

<?php
include 'db_connection.php';

$stmt = $pdo->query("SELECT * FROM trydyaga");
$workers = $stmt->fetchAll();
?>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Experience</th>
            <th>Post</th>
            <th>Action</th>
        </tr>
    </thead>

    <tbody>
    <?php foreach ($workers as $worker): ?>
        <tr>
            <td><?= $worker['id'] ?></td>
            <td><?= htmlspecialchars($worker['name_worker']) ?></td>
            <td><?= htmlspecialchars($worker['work_experience']) ?> years</td>
            <td><?= htmlspecialchars($worker['post']) ?></td>
            <td>
                <button onclick="deleteWorker(<?= $worker['id'] ?>)">
                    Delete
                </button>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<script>
function deleteWorker(id) {
    if (!confirm("Delete this worker?")) return;

    fetch('delete_worker.php?id=' + id)
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('Delete failed');
            }
        });
}
</script>

</body>
</html>
