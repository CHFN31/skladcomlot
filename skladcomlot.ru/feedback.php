<?php

session_start();

// Параметры подключения к базе данных
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "storage";

// Создаем подключение к базе данных
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Проверяем подключение к базе данных
if (!$conn) {
  die("Ошибка подключения: " . mysqli_connect_error());
}

if(!empty($_POST['name']) && !empty($_POST['email']) && !empty($_POST['text']) && !empty($_POST['phone'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $text = $_POST['text'];
    $phone = $_POST['phone'];
    $created_at = date('Y-m-d H:i:s');

    $sql = "INSERT INTO messages (name, email, text, created_at, phone) VALUES ('$name', '$email', '$text', '$created_at', '$phone')";
    $insert_result = mysqli_query($conn, $sql);

    if($insert_result) {
        // Если сообщение успешно добавлено, перенаправляем пользователя на главную страницу
        header("Location: index.php");
        exit();
    }
    else {
        // Если что-то пошло не так, выводим сообщение об ошибке
        echo "Ошибка при добавлении сообщения";
        exit();
    }
}

// Закрываем подключение к базе данных
mysqli_close($conn);

?>