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
        .form-container {
            margin-bottom: 20px;
        }
        .form-container input[type="text"] {
            padding: 5px;
            width: 300px;
        }
        .form-container input[type="submit"] {
            padding: 5px 10px;
        }
        .form-container input[type="hidden"] {
            display: none;
        }
        .form-container button {
            padding: 5px 10px;
            margin-left: 5px;
        }
    </style>
</head>
<body>
    <h1>Pharmacy Workers</h1>
    <a href="index.php">Back to Home</a>

    <!-- Form for adding and editing workers -->
    <div class="form-container">
        <form id="workerForm" method="post" action="">
            <input type="hidden" name="id" id="id" value="">
            <input type="text" name="name" id="name" placeholder="Name" required>
            <input type="text" name="work_experience" id="work_experience" placeholder="Work Experience (years)" required>
            <input type="text" name="post" id="post" placeholder="Post" required>
            <input type="submit" value="Save">
            <button type="button" onclick="resetForm()">Cancel</button>
        </form>
    </div>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Work Experience</th>
                <th>Post</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            include 'db_connection.php';

            // Handle form submission
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $id = $_POST['id'] ?? null;
                $name = $_POST['name'];
                $work_experience = $_POST['work_experience'];
                $post = $_POST['post'];

                if ($id) {
                    // Update worker
                    $stmt = $pdo->prepare("UPDATE trydyaga SET name_worker = :name, work_experience = :work_experience, post = :post WHERE id = :id");
                    $stmt->execute(['id' => $id, 'name' => $name, 'work_experience' => $work_experience, 'post' => $post]);
                } else {
                    // Insert new worker
                    $stmt = $pdo->prepare("INSERT INTO trydyaga (name_worker, work_experience, post) VALUES (:name, :work_experience, :post)");
                    $stmt->execute(['name' => $name, 'work_experience' => $work_experience, 'post' => $post]);
                }

                header('Location: workers.php');
                exit;
            }

            // Fetch workers
            $stmt = $pdo->query("SELECT * FROM trydyaga");
            $workers = $stmt->fetchAll();

            if ($workers) {
                foreach ($workers as $worker) {
                    echo "<tr>
                            <td>" . htmlspecialchars($worker['id']) . "</td>
                            <td>" . htmlspecialchars($worker['name_worker']) . "</td>
                            <td>" . htmlspecialchars($worker['work_experience']) . " years</td>
                            <td>" . htmlspecialchars($worker['post']) . "</td>
                            <td>
                                <button onclick='editWorker(" . htmlspecialchars($worker['id']) . ")'>Edit</button>
                                <button onclick='deleteWorker(" . htmlspecialchars($worker['id']) . ")'>Delete</button>
                            </td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='5'>No workers found.</td></tr>";
            }
            ?>
        </tbody>
    </table>

    <script>
        function editWorker(id) {
            fetch('get_worker.php?id=' + id)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('id').value = data.id;
                    document.getElementById('name').value = data.name_worker;
                    document.getElementById('work_experience').value = data.work_experience;
                    document.getElementById('post').value = data.post;
                });
        }

        function deleteWorker(id) {
            if (confirm('Are you sure you want to delete this worker?')) {
                fetch('delete_worker.php?id=' + id, {
                    method: 'DELETE'
                }).then(response => {
                    if (response.ok) {
                        location.reload();
                    } else {
                        alert('Error deleting worker');
                    }
                });
            }
        }

        function resetForm() {
            document.getElementById('workerForm').reset();
            document.getElementById('id').value = '';
        }
    </script>
</body>
</html>