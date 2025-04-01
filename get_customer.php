<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pharmacy Workers</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h1>Pharmacy Workers</h1>
    <a href="index.php">Back to Home</a>
    <?php
    include 'db_connection.php';

    // Fetch workers
    $stmt = $pdo->query("SELECT * FROM trydyaga");
    $workers = $stmt->fetchAll();

    if ($workers) {
        echo "<table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Work Experience</th>
                        <th>Post</th>
                    </tr>
                </thead>
                <tbody>";
        foreach ($workers as $worker) {
            echo "<tr>
                    <td>" . htmlspecialchars($worker['id']) . "</td>
                    <td>" . htmlspecialchars($worker['name_worker']) . "</td>
                    <td>" . htmlspecialchars($worker['work_experience']) . " years</td>
                    <td>" . htmlspecialchars($worker['post']) . "</td>
                  </tr>";
        }
        echo "</tbody></table>";
    } else {
        echo "No workers found.";
    }
    ?>
</body>
</html>