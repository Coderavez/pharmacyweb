<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Apteka</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        form {
            margin-bottom: 20px;
        }
        input[type="text"] {
            padding: 5px;
            width: 300px;
        }
        input[type="submit"] {
            padding: 5px 10px;
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
    <h1>Welcome to Apteka</h1>
    <form method="post" action="">
        <input type="text" name="searchTerm" placeholder="Enter medication name" required>
        <input type="submit" value="Search">
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $searchTerm = $_POST['searchTerm'];

        // Include the database connection file
        include 'db_connection.php';

        // Prepare and execute the query
        $stmt = $pdo->prepare("SELECT * FROM lekarstvo WHERE name_drug LIKE :searchTerm");
        $stmt->execute(['searchTerm' => "%" . $searchTerm . "%"]);

        // Fetch results
        $results = $stmt->fetchAll();
        if ($results) {
            echo "<table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Country</th>
                            <th>Storage Life</th>
                            <th>Recipe Required</th>
                            <th>Price</th>
                        </tr>
                    </thead>
                    <tbody>";
            foreach ($results as $row) {
                echo "<tr>
                        <td>" . htmlspecialchars($row['id']) . "</td>
                        <td>" . htmlspecialchars($row['name_drug']) . "</td>
                        <td>" . htmlspecialchars($row['country']) . "</td>
                        <td>" . htmlspecialchars($row['storage_life']) . "</td>
                        <td>" . ($row['recipe'] ? 'Yes' : 'No') . "</td>
                        <td>" . htmlspecialchars($row['price']) . "</td>
                      </tr>";
            }
            echo "</tbody></table>";
        } else {
            echo "No results found.";
        }
    }
    ?>
</body>
</html>