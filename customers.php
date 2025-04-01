<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customers</title>
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
        .form-container input[type="text"],
        .form-container input[type="email"] {
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
    <h1>Customers</h1>
    <a href="index.php">Back to Home</a>

    <!-- Form for adding and editing customers -->
    <div class="form-container">
        <form id="customerForm" method="post" action="">
            <input type="hidden" name="id" id="id" value="">
            <input type="text" name="name" id="name" placeholder="Name" required>
            <input type="text" name="phone" id="phone" placeholder="Phone" required>
            <input type="email" name="email" id="email" placeholder="Email" required>
            <input type="submit" value="Save">
            <button type="button" onclick="resetForm()">Cancel</button>
        </form>
    </div>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Phone</th>
                <th>Email</th>
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
                $phone = $_POST['phone'];
                $email = $_POST['email'];

                if ($id) {
                    // Update customer
                    $stmt = $pdo->prepare("UPDATE pokypatelya SET name = :name, phone = :phone, email = :email WHERE id = :id");
                    $stmt->execute(['id' => $id, 'name' => $name, 'phone' => $phone, 'email' => $email]);
                } else {
                    // Insert new customer
                    $stmt = $pdo->prepare("INSERT INTO pokypatelya (name, phone, email) VALUES (:name, :phone, :email)");
                    $stmt->execute(['name' => $name, 'phone' => $phone, 'email' => $email]);
                }

                header('Location: customers.php');
                exit;
            }

            // Fetch customers
            $stmt = $pdo->query("SELECT * FROM pokypatelya");
            $customers = $stmt->fetchAll();

            if ($customers) {
                foreach ($customers as $customer) {
                    echo "<tr>
                            <td>" . htmlspecialchars($customer['id']) . "</td>
                            <td>" . htmlspecialchars($customer['name']) . "</td>
                            <td>" . htmlspecialchars($customer['phone']) . "</td>
                            <td>" . htmlspecialchars($customer['email']) . "</td>
                            <td>
                                <button onclick='editCustomer(" . htmlspecialchars($customer['id']) . ")'>Edit</button>
                                <button onclick='deleteCustomer(" . htmlspecialchars($customer['id']) . ")'>Delete</button>
                            </td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='5'>No customers found.</td></tr>";
            }
            ?>
        </tbody>
    </table>

    <script>
        function editCustomer(id) {
            fetch('get_customer.php?id=' + id)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('id').value = data.id;
                    document.getElementById('name').value = data.name;
                    document.getElementById('phone').value = data.phone;
                    document.getElementById('email').value = data.email;
                });
        }

        function deleteCustomer(id) {
            if (confirm('Are you sure you want to delete this customer?')) {
                fetch('delete_customer.php?id=' + id, {
                    method: 'DELETE'
                }).then(response => {
                    if (response.ok) {
                        location.reload();
                    } else {
                        alert('Error deleting customer');
                    }
                });
            }
        }

        function resetForm() {
            document.getElementById('customerForm').reset();
            document.getElementById('id').value = '';
        }
    </script>
</body>
</html>