<?php
session_start();
$pass = 'admin11'; // Пароль для входа в Админку
$adm = 1; // Если в переменной $adm==1 то вы успешно авторизованы

if ($adm == 1) {
	if (isset($_POST['pagename'])) {
		$_SESSION['pagename'] = $_POST['pagename']; // Получаем имя страницы для редактирования
	};
	if (isset($_SESSION['pagename'])) {
		$pagename = $_SESSION['pagename'];
	} else {
		$pagename = 'index.php';	// Если его нет в куках и нет в POST запросе то ставим его=index.html
	};

	// В переменную $template поместим код редактируемой странички
	$template = file_get_contents($pagename);
?>

	<html>

	<head>
		<meta charset="UTF-8">
		<title>СКЛАДКОМЛот | Авторизация</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="theme-color" content="#ffffff">
		<link rel="icon" href="admin/favicon/favicon.png">
		<link rel="apple-touch-icon" sizes="180x180" href="css/img/favicon/apple-touch-icon-180x180.png">
		<link rel="stylesheet" href="css/admin.css?ver=1">
		<link rel="stylesheet" href="css/static-1.css?ver=1">
		<link rel="stylesheet" href="css/styleadmin.css">
		<link rel="stylesheet" href="css/media-admin.css">
	</head>

	<body>
		<div id="menu">
			<form action="admin.php" id="myform" method="POST">
				<select name="pagename">

					<?php

					// Создаем список страниц в корневой папке доступных для редактирования
					$filelist1 = glob("*.php");
					$ddd = 0;
					$ssss = '';
					for ($j = 0; $j < count($filelist1); $j++) {
						if ($filelist1[$j] == $_SESSION['pagename']) {
							$ssss .= ('<option selected>' . $filelist1[$j] . '</option>');
							$ddd = 1;
						} else {
							$ssss .= ('<option>' . $filelist1[$j] . '</option>');
						};
					};
					if ($ddd == 0) {
						$ssss = '';
						for ($j = 0; $j < count($filelist1); $j++) {
							if ($filelist1[$j] == 'index.php') {
								$ssss .= ('<option selected>' . $filelist1[$j] . '</option>');
								$ddd = 1;
							} else {
								$ssss .= ('<option>' . $filelist1[$j] . '</option>');
							};
						};
					};
					echo ($ssss);

					?>
				</select>
				<input type="submit" value="Редактировать" title="Редактировать">
			</form>
			<a href="admin.php?mode=0">Текст</a>
			<a href="admin.php?mode=7">Картинки</a>
			<a href="admin.php?mode=11">Статистика и заявки</a>
			<a href="admin.php?mode=12">Добавление нового работнка</a>
			<a href="admin.php">Помощь</a>
			<a href="out.php">Выйти с аккаунта</a>
		</div>
	<?php
	//******************************************************************************************
	// Список картинок
	if ($_GET['mode'] == '7') {
		// Вытаскиваем список картинок из HTML кода
		$imgreg = "/[\"|\(']((.*\\/\\/|)([\\/a-z0-9_%]+\\.(jpg|png|gif)))[\"|\)']/";
		preg_match_all($imgreg, $template, $imgmas);
		for ($j = 0; $j < count($imgmas[1]); $j++) {
			$imgname = trim($imgmas[1][$j]);
			echo ('<div class="kartinka"><a href="admin.php?mode=1&img=' . $imgname . '"><img src="' . $imgname . '?' . rand(1, 32000) . '"></a><br>' . $imgname . '<br>');
			if (file_exists($imgname)) {
				$size = getimagesize($imgname);
				echo "Размер картинки: $size[0] * $size[1]" . "<p>";
			} else {
				echo ("Картинка не загружена");
			};
			echo ("</div>");
		};
		// Получаем список CSS файлов в массив $mycss
		$mycss = array();
		$cssreg = "/[\"']((.*\\/\\/|)([\\/a-z0-9_%]+\\.(css)))[\"']/";
		preg_match_all($cssreg, $template, $cssmas);
		for ($j = 0; $j < count($cssmas[1]); $j++) {
			array_push($mycss, trim($cssmas[1][$j]));
		};
		echo ('<hr>');
		// Вытаскиваем с каждого CSS файла адреса картинок
		for ($i = 0; $i < count($mycss); $i++) {
			$template = file_get_contents($mycss[$i]);
			$imgreg = "/[.\(]((.*\\/\\/|)([\\/a-z0-9_%]+\\.(jpg|png|gif)))[\)]/";
			preg_match_all($imgreg, $template, $imgmas);
			for ($j = 0; $j < count($imgmas[1]); $j++) {
				$imgname = trim($imgmas[1][$j]);
				echo ('<div class="kartinka"><a href="admin.php?mode=1&img=' . $imgname . '"><img src="' . $imgname . '?' . rand(1, 32000) . '"></a><br>' . $imgname . '<br>');
				if (file_exists($imgname)) {
					$size = getimagesize($imgname);
					echo "Размер картинки: $size[0] * $size[1]" . "<p>";
				} else {
					if (file_exists(substr($imgname, 1))) {
						$size = getimagesize(substr($imgname, 1));
						echo "Размер картинки: $size[0] * $size[1]" . "<p>";
					} else {
						echo ("Картинка не загружена");
					};
				};
				echo ("</div>");
			};
		};
	};

	//******************************************************************************************
	// Одна картинка
	if ($_GET['mode'] == '1') {
		$imgname = $_GET['img'];
		if ($imgname[0] == '/') {
			$imgname = substr($imgname, 1);
		};
		echo ('<center><img src="' . $imgname . '" class="bigkartinka"><br>' . $imgname . '<p>');
		if (file_exists($imgname)) {
			$size = getimagesize($imgname);
			echo "ВНИМАНИЕ: Размер картинки должен быть: $size[0] * $size[1]" . "<p>";
		} else {
			if (file_exists(substr($imgname, 1))) {
				$size = getimagesize(substr($imgname, 1));
				echo "Размер картинки: $size[0] * $size[1]" . "<p>";
			} else {
				echo ("Картинка не загружена");
			};
		};
		echo ('<form enctype="multipart/form-data" action="admin.php?mode=2&img=' . $imgname . '" method="POST">Загрузить картинку с компьютера: <p><input name="userfile" type="file" required><p><input type="submit" style="width: 300px;
    padding-top: 19px;
    padding-bottom: 22px;
	background: -o-linear-gradient(166.81deg, #c8691b 28.23%, #a04f19 95.2%);
    background: linear-gradient(283.19deg, #c8691b 28.23%, #a04f19 95.2%);
	box-shadow: 0 20px 18px -10px rgba(198, 105, 28, 0.7);
    box-shadow: 0 20px 18px -10px rgba(198, 105, 28, 0.7);
    font-size: 20px;
    color: white;
    margin-top: 20px;" value="Начать загрузку" /></form>');
	};


	//******************************************************************************************
	// Замена картинки
	if ($_GET['mode'] == '2') {
		$imgname = $_GET['img'];
		if (move_uploaded_file($_FILES['userfile']['tmp_name'], $imgname)) {
			echo "<br><br><center>Файл был успешно загружен.<p><a href='admin.php?mode=7' class='a'>Вернуться к списку картинок</a><p>Чтобы увидеть изменения на сайте, обновите страницу на сайте!";
		};
	};


	//******************************************************************************************
	// Список текстовых фрагментов
	if ($_GET['mode'] == '0') {
		// Помещаем в массив $ff все тексты из HTML кода
		$ff = array();
		$content = preg_replace('/<[^>]+>/', '^', $template);
		$teksta = explode('^', $content);
		for ($j = 0; $j < count($teksta); $j++) {
			if (strlen(trim($teksta[$j])) > 1) $ff[] = (trim($teksta[$j]));
		};
		for ($j = 0; $j < count($ff); $j++) {
			echo ('<a href="admin.php?mode=3&j=' . $j . '" class="mytext">' . $ff[$j] . '</a>');
		};
	};


	//******************************************************************************************
	// Текстовый фрагмент
	if ($_GET['mode'] == '3') {
		// Помещаем в массив $ff все текстовые фрагменты из HTML кода
		$ff = array();
		$content = preg_replace('/<[^>]+>/', '^', $template);
		$teksta = explode('^', $content);
		for ($j = 0; $j < count($teksta); $j++) {
			if (strlen(trim($teksta[$j])) > 1) $ff[] = (trim($teksta[$j]));
		};
		$jj = $_GET['j'];
		$tektekst = $ff[$jj];
		$kol = 1;
		for ($j = 0; $j < $jj; $j++) {
			$kol = $kol + substr_count($ff[$j], $tektekst);
		};
		echo ('<div style="margin: 0 auto; text-align: center;"><form method="POST" action="admin.php?mode=4&j=' . $jj . '"><br><br><h2>Редактирование текстового фрагмента</h2><br><br><textarea name="mytext">' . $tektekst . '</textarea><br><input style="width: 300px;
    padding-top: 19px;
    padding-bottom: 22px;
	box-shadow: 0 20px 18px -10px rgb(198 105 28 / 70%);
    box-shadow: 0 20px 18px -10px rgb(198 105 28 / 70%);
    background: -o-linear-gradient(166.81deg, #c8691b 28.23%, #a04f19 95.2%);
    background: linear-gradient(283.19deg, #c8691b 28.23%, #a04f19 95.2%);
    font-size: 20px;
    color: white;
    margin-top: 20px;" type="submit" value="Заменить текст" title="Заменить текст"></form></div>');
	};


	//******************************************************************************************
	// Редактирование текстового фрагмента
	if ($_GET['mode'] == '4') {
		// Помещаем в массив $ff все текста из HTML кода
		$ff = array();
		$content = preg_replace('/<[^>]+>/', '^', $template);
		$teksta = explode('^', $content);
		for ($j = 0; $j < count($teksta); $j++) {
			if (strlen(trim($teksta[$j])) > 1) $ff[] = (trim($teksta[$j]));
		};
		$jj = $_GET['j'];
		$tektekst = $ff[$jj];
		$kol = 1;
		for ($j = 0; $j < $jj; $j++) {
			$kol = $kol + substr_count($ff[$j], $tektekst);
		};
		$subject = file_get_contents($pagename);
		function str_replace_nth($search, $replace, $subject, $nth)
		{
			$found = preg_match_all('/' . preg_quote($search) . '/', $subject, $matches, PREG_OFFSET_CAPTURE);
			if (false !== $found && $found > $nth) {
				return substr_replace($subject, $replace, $matches[0][$nth][1], strlen($search));
			}
			return $subject;
		};
		$rez = str_replace_nth($tektekst, $_POST['mytext'], $subject, $kol - 1);
		file_put_contents($pagename, $rez);
		echo "<br><br><center>Текст был успешно изменен.<p><a href='admin.php?mode=0' class='a'>Вернуться к списку текстов</a><p>Что бы увидеть изменения на сайте, нажмите на кнопку!)";
	};

	//******************************************************************************************
	//Редактирование статистики
	if ($_GET['mode'] == '11') {

		echo ('<div class="text"><h1>Мониторинг продукции склада</h1></div>');
		echo ('<div class="tableWrapper">
		<div class="tableSize">');

		// Параметры подключения к базе данных
		$servername = "localhost";
		$username = "root";
		$password = "";
		$dbname = "storage";
		$link = mysqli_connect($servername, $username, $password, $dbname);

		// Проверка наличия ошибок
		if (mysqli_connect_errno()) {
			die("Ошибка подключения: " . mysqli_connect_error());
		}

		// Обработка удаления товара
		if (isset($_POST['delete'])) {
			$id = $_POST['id'];
			$deleteQuery = "DELETE FROM products WHERE id='$id'";
			if (mysqli_query($link, $deleteQuery)) {
				echo "<div style='padding: 50px; color: green;'>Товар удален успешно!</div>";
			} else {
				echo "Ошибка удаления товара: " . mysqli_error($link);
			}
		}

		// Обработка изменения товара
		if (isset($_POST['update'])) {
			$id = $_POST['id'];
			$new_product_name = $_POST['new_product_name'];
			$new_quantity = $_POST['new_quantity'];
			$new_price = $_POST['new_price'];
			$new_days_in_stock = $_POST['new_days_in_stock'];
			$new_days_left = $_POST['new_days_left'];
			$new_sales_per_day = $_POST['new_sales_per_day'];
			$new_purchase_plan = $_POST['new_purchase_plan'];

			// Проверить входные данные
			if (empty($new_quantity) || !is_numeric($new_quantity)) {
				echo "Ошибка: количество должно быть числом.";
				exit();
			}

			// Обновить данные в базе
			$update_query = "UPDATE products SET product_name='$new_product_name', quantity=$new_quantity, price=$new_price, days_in_stock=$new_days_in_stock, days_left=$new_days_left, sales_per_day=$new_sales_per_day, purchase_plan=$new_purchase_plan WHERE id=$id";
			if (mysqli_query($link, $update_query)) {
				echo "<div style='padding: 50px; color: green;'>Товар обновлен успешно!</div>";
			} else {
				echo "Ошибка обновления данных: " . mysqli_error($link);
			}
		}

		// Обработка добавления товара
		if (isset($_POST['add'])) {
			$product_name = $_POST['product_name'];
			$quantity = $_POST['quantity'];
			$price = $_POST['price'];
			$days_in_stock = $_POST['days_in_stock'];
			$days_left = $_POST['days_left'];
			$sales_per_day = $_POST['sales_per_day'];
			$purchase_plan = $_POST['purchase_plan'];

			// Проверить входные данные
			if (empty($quantity) || !is_numeric($quantity)) {
				echo "Ошибка: количество должно быть числом.";
				exit();
			}

			// Добавить товар в базу
			$add_query = "INSERT INTO products (product_name, quantity, price, days_in_stock, days_left, sales_per_day, purchase_plan) VALUES ('$product_name', $quantity, $price, $days_in_stock, $days_left, $sales_per_day, $purchase_plan)";
			if (mysqli_query($link, $add_query)) {
				echo "<div style='padding: 50px; color: green;'>Товар добавлен успешно!</div>";
			} else {
				echo "Ошибка добавления товара: " . mysqli_error($link);
			}
		}

		// Выборка данных из таблицы
		$result = mysqli_query($link, "SELECT * FROM products");

		// Вывод данных в таблицу
		echo "<table>";
		echo "<tr><th>ID продукта</th><th>Название товара</th><th>Количество</th><th>Цена</th><th>Дней на складе</th><th>Осталось дней</th><th>Продажи в день</th><th>План закупки</th><th>Действия</th></tr>";
		while ($row = mysqli_fetch_assoc($result)) {
			echo "<tr>";
			echo "<td>" . $row['id'] . "</td>";
			echo "<td>" . $row['product_name'] . "</td>";
			echo "<td>" . $row['quantity'] . "</td>";
			echo "<td>" . $row['price'] . " руб.</td>";
			echo "<td>" . $row['days_in_stock'] . "</td>";
			echo "<td>" . $row['days_left'] . "</td>";
			echo "<td>" . $row['sales_per_day'] . "</td>";
			echo "<td>" . $row['purchase_plan'] . " руб.</td>";
			echo "<td>";
			echo "<form method='post' class='form__static'>";
			echo "<input type='hidden' name='id' value='" . $row['id'] . "'>";
			echo "<input type='text' name='new_product_name' value='" . $row['product_name'] . "' placeholder='Новое название'>";
			echo "<input type='number' name='new_quantity' value='" . $row['quantity'] . "' placeholder=''></input>";
			echo "<input type='number' name='new_price' value='" . $row['price'] . "' placeholder='Новая цена'>";
			echo "<input type='number' name='new_days_in_stock' value='" . $row['days_in_stock'] . "' placeholder='Новое количество дней в наличии'>";
			echo "<input type='number' name='new_days_left' value='" . $row['days_left'] . "' placeholder='Новое количество дней'>";
			echo "<input type='number' name='new_sales_per_day' value='" . $row['sales_per_day'] . "' placeholder='Новое количество продаж в день'>";
			echo "<input type='number' name='new_purchase_plan' value='" . $row['purchase_plan'] . "' placeholder='Новый план закупки'>";
			echo "<input type='submit' class='btn btn-red btn-send btnFix form_click' name='update' value='Обновить'>";
			echo "<input type='submit' class='btn btn-red btn-send btnFix form_click' name='delete' value='Удалить'>";
			echo "</form>";
			echo "</td>";
			echo "</tr>";
		}
		echo "</table>";

		echo ('<form method="post" class="form__static">
	<label for="product_name">Название товара:</label>
	<input type="text" id="product_name" name="product_name" required>
  
	<label for="quantity">Количество:</label>
	<input type="number" id="quantity" name="quantity" required>
  
	<label for="price">Цена:</label>
	<input type="number" id="price" name="price" required>
  
	<label for="days_in_stock">Дней на складе:</label>
	<input type="number" id="days_in_stock" name="days_in_stock" required>
  
	<label for="days_left">Осталось дней:</label>
	<input type="number" id="days_left" name="days_left" required>
  
	<label for="sales_per_day">Продажи в день:</label>
	<input type="number" id="sales_per_day" name="sales_per_day" required>
  
	<label for="purchase_plan">План закупки:</label>
	<input type="number" id="purchase_plan" name="purchase_plan" required>
  
	<input type="submit" class="btn btn-red btn-send btnFix form_click" name="add" value="Добавить товар">
  </form>
	</tbody>
  </table>
  
  	</div>
  </div>');

		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////// ЗАЯВКИ //////////

		echo ('<div class="text"><h1>Заявки с сайта</h1></div>');
		echo ('<div class="tableWrapper">
  <div class="tableSize">');

		// Выборка данных из таблицы
		$result = mysqli_query($link, "SELECT * FROM calls");

		// Вывод данных в таблицу
		echo "<table>";
		echo "<tr><th>ID</th><th>Номер телефона</th><th>Дата создания</th></tr>";
		while ($row = mysqli_fetch_assoc($result)) {
			echo "<tr>";
			echo "<td>" . $row['id'] . "</td>";
			echo "<td>" . $row['phone'] . "</td>";
			echo "<td>" . $row['created_at'] . "</td>";
			echo "</tr>";
		}
		echo "</table>";

		// Закрытие соединения с базой данных
		mysqli_close($link);

		echo ('</div>
</div>');

		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////// ПОЛЬЗОВАТЕЛИ //////////

	}

	//Редактирование пользователя
	if ($_GET['mode'] == '12') {

		echo ('<div class="text"><h1>Работники склада</h1></div>');
		echo ('<div class="tableWrapper">
  <div class="tableSize">');

		// Параметры подключения к базе данных
		$servername = "localhost";
		$username = "root";
		$password = "";
		$dbname = "storage";
		$link = mysqli_connect($servername, $username, $password, $dbname);

		// Проверка наличия ошибок
		if (mysqli_connect_errno()) {
			die("Ошибка подключения: " . mysqli_connect_error());
		}

		// Обработка удаления пользователя
		if (isset($_POST['delete'])) {
			$id = $_POST['id'];
			$deleteQuery = "DELETE FROM users WHERE id='$id'";
			if (mysqli_query($link, $deleteQuery)) {
				echo "<div style='padding: 50px; color: green;'>Пользователь удален успешно!</div>";
			} else {
				echo "Ошибка удаления пользователя: " . mysqli_error($link);
			}
		}

		// Обработка изменения пользователя
		if (isset($_POST['update'])) {
			$id = $_POST['id'];
			$new_last_name = $_POST['new_last_name'];
			$new_first_name = $_POST['new_first_name'];
			$new_patronymic = $_POST['new_patronymic'];
			$new_login = $_POST['new_login'];
			$new_password = $_POST['new_password'];

			// Проверить входные данные
			if (empty($new_login) || !is_string($new_login)) {
				echo "Ошибка: логин должен быть буквами.";
				exit();
			}

			// Обновить данные в базе
			$update_query = "UPDATE users SET last_name='$new_last_name', first_name='$new_first_name', patronymic='$new_patronymic', login='$new_login', password='$new_password' WHERE id=$id";
			if (mysqli_query($link, $update_query)) {
				echo "<div style='padding: 50px; color: green;'>Пользователь обновлен успешно!</div>";
			} else {
				echo "Ошибка обновления данных: " . mysqli_error($link);
			}
		}

		// Обработка добавления пользователя
		if (isset($_POST['add'])) {
			$last_name = $_POST['last_name'];
			$first_name = $_POST['first_name'];
			$patronymic = $_POST['patronymic'];
			$login = $_POST['login'];
			$password = $_POST['password'];

			// Проверить входные данные
			if (empty($login) || !is_string($login)) {
				echo "Ошибка: логин должен быть буквами.";
				exit();
			}

			// Добавить товар в базу
			$add_query = "INSERT INTO users (last_name, first_name, patronymic, login, password) VALUES ('$last_name', '$first_name', '$patronymic', '$login', '$password')";
			if (mysqli_query($link, $add_query)) {
				echo "<div style='padding: 50px; color: green;'>Пользователь добавлен успешно!</div>";
			} else {
				echo "Ошибка добавления пользователя: " . mysqli_error($link);
			}
		}

		// Выборка данных из таблицы
		$result = mysqli_query($link, "SELECT * FROM users");

		// Вывод данных в таблицу

		echo "<table>
  <thead>
    <tr>
	  <th>ID</th>
      <th>Фамилия</th>
      <th>Имя</th>
      <th>Отчество</th>
      <th>Логин</th>
	  <th>Пароль</th>
	  <th>Действия</th>
    </tr>
  </thead>";
		while ($row = mysqli_fetch_assoc($result)) {
			echo "<tr>";
			echo "<td>" . $row['id'] . "</td>";
			echo "<td>" . $row['last_name'] . "</td>";
			echo "<td>" . $row['first_name'] . "</td>";
			echo "<td>" . $row['patronymic'] . "</td>";
			echo "<td>" . $row['login'] . "</td>";
			echo "<td>" . $row['password'] . "</td>";
			echo "<td>";
			echo "<form method='post' class='form__static'>";
			echo "<input type='hidden' name='id' value='" . $row['id'] . "'>";
			echo "<input type='text' name='new_last_name' value='" . $row['last_name'] . "' placeholder='Новая фамилия'>";
			echo "<input type='text' name='new_first_name' value='" . $row['first_name'] . "' placeholder='Новое имя'>";
			echo "<input type='text' name='new_patronymic' value='" . $row['patronymic'] . "' placeholder='Новое отчество'>";
			echo "<input type='text' name='new_login' value='" . $row['login'] . "' placeholder='Логин сотрудника'>";
			echo "<input type='text' name='new_password' value='" . $row['password'] . "' placeholder='Пароль сотрудника'>";
			echo "<input type='submit' class='btn btn-red btn-send btnFix form_click' name='update' value='Обновить'>";
			echo "<input type='submit' class='btn btn-red btn-send btnFix form_click' name='delete' value='Удалить'>";
			echo "</form>";
			echo "</td>";
			echo "</tr>";
		}

		echo "</table>";

		// Закрываем подключение к базе данных
		mysqli_close($link);

		echo ('<form method="post" class="form__static">
	<label for="last_name">Новая фамилия:</label>
	<input type="text" pattern="[А-Яа-яЁё]{4,}" id="last_name" name="last_name" required>
  
	<label for="first_name">Новое имя:</label>
	<input type="text" pattern="[А-Яа-яЁё]{4,}" id="first_name" name="first_name" required>
  
	<label for="patronymic">Новое отчество:</label>
	<input type="text" pattern="[А-Яа-яЁё]{4,}" id="patronymic" name="patronymic" required>
  
	<label for="login">Новый логин:</label>
	<input type="text" pattern="[ A-Za-z]{12,}" id="login" name="login" required>
  
	<label for="password">Новый	пароль:</label>
	<input type="text" pattern="[0-9a-zA-Z]{8,}" id="password" name="password" required>
  
	<input type="submit" class="btn btn-red btn-send btnFix form_click" name="add" value="Добавить пользователя">
  </form>');

		echo ('</div>
</div>');
	}

	//******************************************************************************************
	// Помощь
	if (!isset($_GET['mode'])) {
		echo ('
		<div id="help">
			
			<br>
			<h2>Добро пожаловать! Вы попали в панель управления сайтом: "СКЛАДКОМЛот"
			</h2>
			<img src="css/img/about/pic.png" alt="Склад" class="imagelot">
			
			<h3>Инструкция по использованию сайта:
			</h3>
		1. Слева вверху есть выпадающий список, там выбирается страница, которую нужно отредактировать, index это всегда главная страница, остальные внутренние, их названия видно в адрестной строке браузера.
		<p>
		2. При нажатии на кнопку "Картинки" можно менять старые картинки на новые, просто нажав по той, которую нужно заменить, загрузить на ее место новую и сохранить изменения.
		<hr>
		<p>ОБРАТИТЕ ВНИМАНИЕ: размер новой картинки должен быть такой же как и у старой, если старая была 348 пикселей на 234 пикселя, то и новая тоже должна быть 348 пикселей на 234 пикселя.</div>');
	};

	echo ('</body></html>');
};
	?>
<div id="footer"></div>