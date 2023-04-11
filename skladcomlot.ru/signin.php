<?php

session_start();

// Параметры подключения к базе данных
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "storage";

// Создаем подключение к базе данных
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Проверка подключения
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Обработка данных из формы авторизации
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])) {
    $login = $_POST['login'];
    $password = $_POST['password'];

    // Запрос к базе данных для проверки существования пользователя
    $sql = "SELECT * FROM users WHERE login = '$login' AND password = '$password'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        // Аутентифицируем пользователя и сохраняем его идентификатор в сессии
        $user = mysqli_fetch_assoc($result);
        session_start();
        $_SESSION['id'] = $user['id'];

        // Переадресуем на страницу личного кабинета или администратора, в зависимости от типа пользователя
        if ($user['login'] == 'admin') {
            header('Location: admin.php');
            exit();
        } else {
            header('Location: index_worker.php');
            exit();
        }
    } else {
        // Неправильные данные для входа
        echo "<script>alert('Неправильный логин или пароль')</script>";
    }
}




// Закрытие соединения с базой данных
mysqli_close($conn);
?>