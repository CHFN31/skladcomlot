<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <title>СКЛАДКОМЛот | Авторизация</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#ffffff">
    <link rel="icon" href="admin/favicon/favicon.png">
    <link rel="apple-touch-icon" sizes="180x180" href="css/img/favicon/apple-touch-icon-180x180.png">
    <link rel="stylesheet" href="css/login.css?ver=1">
    <script>
        function validateForm() {
            var x = document.forms["myForm"]["login"].value;
            var y = document.forms["myForm"]["password"].value;
            if (x == "" && y == "") {
                alert("Заполните логин и пароль");
                return false;
            } else if (x == "") {
                alert("Введите логин");
                return false;
            } else if (y == "") {
                alert("Введите пароль");
                return false;
            }
        }
    </script>
</head>

<body>

    <body background="/admin/img/background.jpg">
        <center>
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
                    $_SESSION['first_name'] = $user['first_name'];
                    setcookie('first_name', $user['first_name'], time() + 1800, "/");



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
            <form method="POST" action="" onsubmit="return validateForm()" name="myForm">
                <div class="logo">
                    <img src="css/img/header/logo.png" alt="">
                </div>
                <div class="valitation-form">
                <div class="welcome">Добро пожаловать!</div>
                <div class="title_worker">Вход в кабинет работника</div>
                <input type="text" placeholder="Введите логин..." name="login" required pattern="^[a-zA-Z0-9]+$" required title="Имя должно включать латинские буквы!" size="100" class="password"><br>
                <input type="password" placeholder="Введите пароль..." name="password" required pattern="(?=.*\d)(?=.*[a-zA-Z]).{6,}" required title="Пароль должен содержать как минимум 6 символов, включая цифры и латинские буквы" size="100" class="password"><br>
                <input type="submit" name="save" value="Войти" class="enter"><br>
                <br><br><a href="index.php" class="back">Вернуться назад</a>
                </div>
            </form>
        </center>
    </body>

</html>