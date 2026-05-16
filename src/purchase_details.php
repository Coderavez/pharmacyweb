<?php
include __DIR__ . '/db_connection.php';

$sql = "
SELECT 
    c.id,
    c.all_sum,
    c.date_buy,
    c.id_pokypatelya,
    c.id_trydyaga,
    l.name_drug
FROM chek c
LEFT JOIN tovarcheka t ON c.id = t.id_cheka
LEFT JOIN lekarstvo l ON t.id_lekarstva = l.id
ORDER BY c.id
";

$stmt = $pdo->query($sql);
$data = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Purchase Details</title>
    <style>
        body { font-family: Arial; margin: 20px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 8px; }
        th { background: #f2f2f2; }
    </style>
</head>
<body>

<h1>Purchase Details</h1>
<a href="index.php">Back to Home</a>

<table>
    <tr>
        <th>ID</th>
        <th>Total Sum</th>
        <th>Date</th>
        <th>Customer ID</th>
        <th>Worker ID</th>
        <th>Medicines</th>
    </tr>

    <?php
    $grouped = [];

    foreach ($data as $row) {
        $id = $row['id'];

        if (!isset($grouped[$id])) {
            $grouped[$id] = $row;
            $grouped[$id]['medicines'] = [];
        }

        if ($row['name_drug']) {
            $grouped[$id]['medicines'][] = $row['name_drug'];
        }
    }

    foreach ($grouped as $chek):
    ?>
        <tr>
            <td><?= $chek['id'] ?></td>
            <td><?= $chek['all_sum'] ?></td>
            <td><?= $chek['date_buy'] ?></td>
            <td><?= $chek['id_pokypatelya'] ?></td>
            <td><?= $chek['id_trydyaga'] ?></td>
            <td><?= implode(', ', $chek['medicines']) ?></td>
        </tr>
    <?php endforeach; ?>

</table>

</body>
</html>
