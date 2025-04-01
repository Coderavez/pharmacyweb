<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Purchase Details</title>
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
    <h1>Purchase Details</h1>
    <a href="index.php">Back to Home</a>
    <?php
    include 'db_connection.php';

    // Fetch purchase details
    $stmt = $pdo->query("SELECT * FROM chek");
    $cheks = $stmt->fetchAll();

    if ($cheks) {
        echo "<table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Total Sum</th>
                        <th>Date of Purchase</th>
                        <th>Customer ID</th>
                        <th>Pharmacist ID</th>
                        <th>Medications</th>
                    </tr>
                </thead>
                <tbody>";
        foreach ($cheks as $chek) {
            // Fetch medications for each purchase
            $stmtTovarcheka = $pdo->prepare("SELECT * FROM tovarcheka WHERE id_cheka = :id_cheka");
            $stmtTovarcheka->execute(['id_cheka' => $chek['id']]);
            $tovarchekas = $stmtTovarcheka->fetchAll();

            $medications = [];
            foreach ($tovarchekas as $tovarcheka) {
                $stmtLekarstvo = $pdo->prepare("SELECT name_drug FROM lekarstvo WHERE id = :id_lekarstva");
                $stmtLekarstvo->execute(['id_lekarstva' => $tovarcheka['id_lekarstva']]);
                $medication = $stmtLekarstvo->fetch();
                if ($medication) {
                    $medications[] = htmlspecialchars($medication['name_drug']);
                }
            }

            echo "<tr>
                    <td>" . htmlspecialchars($chek['id']) . "</td>
                    <td>" . htmlspecialchars($chek['all_sum']) . "</td>
                    <td>" . htmlspecialchars($chek['date_buy']) . "</td>
                    <td>" . htmlspecialchars($chek['id_pokypatelya']) . "</td>
                    <td>" . htmlspecialchars($chek['id_trydyaga']) . "</td>
                    <td>" . implode(', ', $medications) . "</td>
                  </tr>";
        }
        echo "</tbody></table>";
    } else {
        echo "No purchase details found.";
    }
    ?>
</body>
</html>