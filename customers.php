<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Customers</title>
    <style>
        body { font-family: Arial; margin: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; }
        th { background: #f2f2f2; }
        input { padding: 5px; margin: 5px; }
    </style>
</head>
<body>

<h1>Customers</h1>
<a href="index.php">Back</a>

<?php
include 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $id = $_POST['id'] ?? null;
    $name = $_POST['name_shoper'];
    $number = $_POST['number'];
    $password = $_POST['password'];

    if ($id) {
        $stmt = $pdo->prepare("
            UPDATE pokypatel
            SET name_shoper = :name, number = :number, password = :password
            WHERE id = :id
        ");
        $stmt->execute([
            'id' => $id,
            'name' => $name,
            'number' => $number,
            'password' => $password
        ]);
    } else {
        $stmt = $pdo->prepare("
            INSERT INTO pokypatel (name_shoper, number, password)
            VALUES (:name, :number, :password)
        ");
        $stmt->execute([
            'name' => $name,
            'number' => $number,
            'password' => $password
        ]);
    }

    header("Location: customers.php");
    exit;
}

$stmt = $pdo->query("SELECT * FROM pokypatel");
$customers = $stmt->fetchAll();
?>

<!-- FORM -->
<form method="post">
    <input type="hidden" name="id" id="id">

    <input type="text" name="name_shoper" id="name_shoper" placeholder="Name" required>
    <input type="text" name="number" id="number" placeholder="Phone" required>
    <input type="text" name="password" id="password" placeholder="Password" required>

    <button type="submit">Save</button>
    <button type="button" onclick="resetForm()">Cancel</button>
</form>

<!-- TABLE -->
<table>
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Number</th>
        <th>Password</th>
        <th>Actions</th>
    </tr>

    <?php foreach ($customers as $c): ?>
        <tr>
            <td><?= $c['id'] ?></td>
            <td><?= htmlspecialchars($c['name_shoper']) ?></td>
            <td><?= htmlspecialchars($c['number']) ?></td>
            <td><?= htmlspecialchars($c['password']) ?></td>
            <td>
                <button onclick="editCustomer(
                    <?= $c['id'] ?>,
                    '<?= $c['name_shoper'] ?>',
                    '<?= $c['number'] ?>',
                    '<?= $c['password'] ?>'
                )">Edit</button>
            </td>
        </tr>
    <?php endforeach; ?>
</table>

<script>
function editCustomer(id, name, number, password) {
    document.getElementById('id').value = id;
    document.getElementById('name_shoper').value = name;
    document.getElementById('number').value = number;
    document.getElementById('password').value = password;
}

function resetForm() {
    document.getElementById('id').value = "";
    document.getElementById('name_shoper').value = "";
    document.getElementById('number').value = "";
    document.getElementById('password').value = "";
}
</script>

</body>
</html>
