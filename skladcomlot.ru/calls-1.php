<?php
	session_start();
	$phone = $_POST['phone'];

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

	// Проверяем, что номер телефона не пустой
	if(empty($phone)) {
	    echo "<div class='error'>Пожалуйста, заполните номер телефона</div>";
	    exit();
	}

	// Проверяем, есть ли уже звонок с таким номером телефона в базе данных
	$check_query = "SELECT * FROM calls WHERE phone = '$phone'";
	$check_result = mysqli_query($conn, $check_query);

	if(mysqli_num_rows($check_result) > 0) {
	    // Если звонок с таким номером телефона уже есть, выводим сообщение об ошибке
	    echo "<div class='error'>Звонок с таким номером телефона уже зарегистрирован</div>";
	    exit();
	}
	else {
        // Добавляем звонок в базу данных
	    $sql = "INSERT INTO calls (phone, created_at) VALUES ('$phone', NOW())";
$insert_result = mysqli_query($conn, $sql);

if($insert_result) {
// Если звонок успешно зарегистрирован, перенаправляем пользователя на главную страницу
header("Location: index_worker.php");
exit();
}
else {
// Если что-то пошло не так, выводим сообщение об ошибке
echo "Ошибка при регистрации звонка";
exit();
}

// Закрываем подключение к базе данных
mysqli_close($conn);
    }
?>