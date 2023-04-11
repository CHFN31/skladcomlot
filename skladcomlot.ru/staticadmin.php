<!DOCTYPE html>
<html lang="ru">

    <!-- ШАПКА САЙТА
    ================================= -->

<head>
    <meta charset="utf-8">
    <meta name="robots" content="noindex, nofollow">
    <title>СКЛАДКОМЛот | Статистика</title>
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="icon" href="css/img/favicon/favicon.png">
    <link rel="apple-touch-icon" sizes="180x180" href="css/img/favicon/apple-touch-icon-180x180.png">
    <meta name="theme-color" content="#ffffff">
    <link rel="stylesheet" href="css/libs/animate.min.css">
    <link rel="stylesheet" href="css/libs/slick.css">
    <link rel="stylesheet" href="css/libs/slick-theme.css">
    <link rel="stylesheet" href="css/libs/jquery.fancybox.css">
    <link rel="stylesheet" href="css/libs/reset.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/media.css">
    <link rel="stylesheet" href="css/static.css">
</head>

    <!-- ТЕЛО САЙТА
    ================================= -->

<body>
    
<div class="header__bottom">
            <div class="inner work">
                <div class="cols">
                    <div class="col">
                        <div class="logo">
                            <img src="css/img/header/logo.png" alt="">
                        </div>
                    </div>
                    <div class="col">
                        <div class="header__right">
                            <div class="nav">
                                <ul>
                                    <li><a href="index_worker.php">На главную</a></li>
                                    <li><a href="index_worker.php#about">О компании</a></li>
                                    <li><a href="index_worker.php#tasks">Цели</a></li>
                                    <li><a href="index_worker.php#capability">Возможности</a></li>
                                    <li><a href="index_worker.php#equipment">Обеспечение</a></li>
                                    <li><a href="index_worker.php#contacts">Контакты</a></li>
                                </ul>
                            </div>
                            <button class="btn btn-blue btn-callback" onclick="window.location.href='admin.php'">Вернуться в панель</a></button>
                            <div class="burger"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<div class="alertWrapper">
    <div class="alert404">
    <table>
  <tbody>

<?php
session_start();

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
if(isset($_POST['delete'])) {
  $id = $_POST['id'];
  $deleteQuery = "DELETE FROM products WHERE id='$id'";
  if(mysqli_query($link, $deleteQuery)) {
    echo "Товар удален успешно";
  } else {
    echo "Ошибка удаления товара: " . mysqli_error($link);
  }
}

// Обработка изменения товара
if(isset($_POST['update'])) {
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
    header("Location: staticadmin.php");
  } else {
    echo "Ошибка обновления данных: " . mysqli_error($link);
  }
}

// Обработка добавления товара
if(isset($_POST['add'])) {
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
      header("Location: staticadmin.php");
    } else {
      echo "Ошибка добавления товара: " . mysqli_error($link);
    }
  }

// Выборка данных из таблицы
$result = mysqli_query($link, "SELECT * FROM products");

// Вывод данных в таблицу
echo "<table>";
echo "<tr><th>Название товара</th><th>Количество</th><th>Цена</th><th>Дней на складе</th><th>Осталось дней</th><th>Продажи в день</th><th>План закупки</th><th>Действия</th></tr>";
while ($row = mysqli_fetch_assoc($result)) {
echo "<tr>";
echo "<td>" . $row['product_name'] . "</td>";
echo "<td>" . $row['quantity'] . "</td>";
echo "<td>$" . $row['price'] . "</td>";
echo "<td>" . $row['days_in_stock'] . "</td>";
echo "<td>" . $row['days_left'] . "</td>";
echo "<td>" . $row['sales_per_day'] . "</td>";
echo "<td>" . $row['purchase_plan'] . "</td>";
echo "<td>";
echo "<form method='post'>";
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

// Закрытие соединения с базой данных
mysqli_close($link);
?>

<form method="post">
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
</div>   
    <!-- ПОДВАЛ
    ================================= -->
    <div class="footer">
        <div class="footer__top">
            <div class="inner work">
                <div class="cols">
                    <div class="col">
                        <div class="logo">
                            <img src="css/img/footer/logo.png" alt="">
                        </div>
                        <div class="copyright copyright_mob">ООО "СКЛАДКОМЛот"</div>
                    </div>
                    <div class="col">
                        <div class="footer__nav">
                            <ul>
                                <li><a href="index.php">На главную</a></li>
                                <li><a href="index_worker.php#about">О компании</a></li>
                                <li><a href="index_worker.php#tasks">Цели</a></li>
                                <li><a href="index_worker.php#capability">Возможности</a></li>
                                <li><a href="index_worker.php#equipment">Обеспечение</a></li>
                                <li><a href="index_worker.php#contacts">Контакты</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col">
                        <button class="btn btn-red btn-callback">Оставить заявку</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer__bottom">
            <div class="inner work">
                <div class="cols">
                    <div class="col">
                        <div class="copyright copyright_des">ООО "СКЛАДКОМЛот"</div>
                    </div>
                    <div class="col">
                        <div class="politics">
                            <a href="uploads/policy.pdf" target="_blank" rel="nofollow"><span>Политика</span> конфиденциальности</a>
                        </div>
                    </div>
                    <div class="col">
                        <div class="footer__right">
                            <div class="mail">
                                <a class="mail_click" href="mailto:skladkomlot@gmail.com" target="_blank">skladkomlot@gmail.com</a>
                            </div>
                            <div class="phone">
                                <a class="phone_click" href="tel:+79511549397">+7 (951) 154-93-97</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- POP-UP ОКНО №1 - ОФОРМЛЕНИЕ ЗАЯВКИ
    ================================= -->
    <div class="modal modal_callback">
        <div class="popup">
            <div class="close-popup"></div>
            <div class="title">Оформление заявки</div>
            <p class="sub">Оставьте заявку, и наши специалисты свяжутся с Вами в ближайшее время.</p>
            <div class="form order__popup">
                <form class="form" id="form" name="form">
                    <div class="form-group form-group_big">
                        <label class="label">Контактное лицо</label>
                        <input class="form-control" id="myInput" oninput="validateInput()" type="text" name="name" required="required" placeholder="______________________________">
                    </div>
                    <div class="form-group form-group_big">
                        <label class="label">Телефон контактного лица</label>
                        <input class="form-control mask" type="text" name="phone" required="required" placeholder="+7 (___) ___-__-__">
                    </div>
                    <div class="form-group form-group_big">
                        <label class="label">E-mail</label>
                        <input class="form-control" type="email" name="email" required="required" placeholder="______________________________">
                    </div>
                    <div class="form-group form-group_big">
                        <label class="label">Сообщение</label>
                        <input class="form-control" type="text" name="text" required="required" placeholder="______________________________">
                    </div>
                    <p class="agree">Оставляя данные в этой форме, Вы даете согласие на обработку <a href="uploads/persInfo.pdf" class="linkTdu" rel="nofollow" target="_blank">персональных данных.</a></p>
                    <button class="btn btn-red btn-send btnFix form_click"><span class="text-button">Отправить заявку</span></button>
                </form>
            </div>
        </div>
    </div>

    <!-- POP-UP ОКНО №2 - ОКНО БЛАГОДАРНОСТИ
    ================================= -->
    <div class="modal modal_thanks">
        <div class="popup">
            <div class="close-popup"></div>
            <div class="img">
                <img src="css/img/thank.svg" alt="Галочка">
            </div>
            <div class="title">Ваша заявка отправлена </div>
            <p class="sub">Наш менеджер свяжется с Вами<br> в ближайшее время </p>

        </div>
    </div>

    <!-- ВЗАИМОДЕЙСТВИЕ СКРИПТОВ
    ================================= -->
    <script src="js/libs/jquery-3.5.1.min.js"></script> 
    <script src="js/libs/jquery.fancybox.min.js"></script> 
    <script src="js/libs/slick.min.js"></script> 
    <script src="js/libs/jquery.maskedinput.min.js"></script> 
    <script src="js/libs/wow.min.js"></script>
    <script src="js/script.js"></script>
    <script src="js/main.js"></script>

    <!-- ФУНКЦИИ СКРИПТОВ
    ================================= -->
    <script type="text/javascript">
        function validateInput() {
            const input = document.getElementById("myInput");
            input.value = input.value.replace(/[0-9]/g, "");
        }
    </script>

</body>
</html>