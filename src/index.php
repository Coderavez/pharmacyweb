<?php
include __DIR__ . '/db_connection.php';

$results = [];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $searchTerm = $_POST['searchTerm'];

    $stmt = $pdo->prepare("
        SELECT * FROM lekarstvo 
        WHERE name_drug LIKE :searchTerm
    ");

    $stmt->execute([
        'searchTerm' => "%" . $searchTerm . "%"
    ]);

    $results = $stmt->fetchAll();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Apteka</title>
    <style>
        body { font-family: Arial; margin: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; }
        th { background: #f2f2f2; }
        input { padding: 5px; }
    </style>
</head>
<body>

<h1>Welcome to Apteka</h1>


<!--
 ________  ________  ________  _______   ________  ________  ___      ___ _______   ________
|\   ____\|\   __  \|\   ___ \|\  ___ \ |\   __  \|\   __  \|\  \    /  /|\  ___ \ |\_____  \
\ \  \___|\ \  \|\  \ \  \_|\ \ \   __/|\ \  \|\  \ \  \|\  \ \  \  /  / | \   __/| \|___/  /|
 \ \  \    \ \  \\\  \ \  \ \\ \ \  \_|/_\ \   _  _\ \   __  \ \  \/  / / \ \  \_|/__   /  / /
  \ \  \____\ \  \\\  \ \  \_\\ \ \  \_|\ \ \  \\  \\ \  \ \  \ \    / /   \ \  \_|\ \ /  /_/__
   \ \_______\ \_______\ \_______\ \_______\ \__\\ _\\ \__\ \__\ \__/ /     \ \_______\\________\
    \|_______|\|_______|\|_______|\|_______|\|__|\|__|\|__|\|__|\|__|/       \|_______|\|_______|    
!-->
<form method="post">
    <input type="text" name="searchTerm" placeholder="Enter medication name" required>
    <input type="submit" value="Search">
</form>

<?php if ($_SERVER["REQUEST_METHOD"] === "POST"): ?>

    <?php if ($results): ?>

        <table>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Country</th>
                <th>Storage Life</th>
                <th>Recipe</th>
                <th>Price</th>
            </tr>

            <?php foreach ($results as $row): ?>
                <tr>
                    <td><?= $row['id'] ?></td>
                    <td><?= htmlspecialchars($row['name_drug']) ?></td>
                    <td><?= htmlspecialchars($row['country']) ?></td>
                    <td><?= htmlspecialchars($row['storage_life']) ?></td>
                    <td><?= $row['recipe'] ? 'Yes' : 'No' ?></td>
                    <td><?= htmlspecialchars($row['price']) ?></td>
                </tr>
            <?php endforeach; ?>

        </table>

    <?php else: ?>
        <p>No results found.</p>
    <?php endif; ?>

<?php endif; ?>

</body>
</html>
