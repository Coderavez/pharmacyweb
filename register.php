<? php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "registration_db";

// Подключение к базе данных
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Ошибка подключения: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullName = trim($_POST["fullName"]);
    $email = trim($_POST["email"]);
    $phone = trim($_POST["phone"]);
    $address = trim($_POST["address"]);
    $age = intval($_POST["age"]);
    $password = $_POST["password"];
    $gender = $_POST["gender"];

    // Валидация данных на сервере
    $errors = [];

    if (!preg_match("/^[А-ЯЁ][а-яё]+\s[А-ЯЁ][а-яё]+\s[А-ЯЁ][а-яё]+$/u", $fullName)) {
        $errors[] = "ФИО должно быть в формате: Иванов Иван Иванович.";
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Некорректный email.";
    }
    if (!preg_match("/^\d{10,15}$/", $phone)) {
        $errors[] = "Телефон должен содержать от 10 до 15 цифр.";
    }
    if ($age < 0 || $age > 150) {
        $errors[] = "Возраст должен быть от 0 до 150.";
    }
    if (strlen($password) < 6 || !preg_match("/\d/", $password)) {
        $errors[] = "Пароль должен содержать минимум 6 символов и хотя бы одну цифру.";
    }

    // Если есть ошибки, выводим их
    if (!empty($errors)) {
        foreach ($errors as $error) {
            echo "<p style='color: red;'>$error</p>";
        }
        exit;
    }

    // Хеширование пароля
    $passwordHash = password_hash($password, PASSWORD_DEFAULT);

    // Сохранение в БД
    $stmt = $conn->prepare("INSERT INTO users (full_name, email, phone, address, age, gender, password_hash) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssiss", $fullName, $email, $phone, $address, $age, $gender, $passwordHash);

    if ($stmt->execute()) {
        echo "Регистрация успешна!";
    } else {
        echo "Ошибка: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
