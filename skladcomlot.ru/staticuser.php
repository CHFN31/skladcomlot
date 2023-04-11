<?php
session_start();

?>

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
    <link rel="apple-touch-icon" sizes="180x180" href="./img/favicon/apple-touch-icon-180x180.png">
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
<div class="wrap">

<!-- МЕНЮ ДЛЯ ТЕЛЕФОНА
    ================================= -->

    <div class="menu">
        <div class="inner work">
            <div class="menu__in">
            <div class="menu__top">
                <div class="cols">
                    <div class="col">
                        <div class="logo">
                            <img src="./img/header/logo.png" alt="">
                        </div>
                    </div>
                    <div class="col">
                        <div class="close-menu"></div>
                    </div>
                </div>
            </div>
            <div class="menu__bottom">
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
                <button class="btn btn-blue btn-callback" onclick="window.location.href='login.php'">Выйти с аккаунта</button>
                <div class="phone">
                        <a class="phone_click" href="tel:+7511549397">+7 (951) 154-93-97</a>
                    </div>
                    <div class="mail">
                        <a class="mail_click" href="mailto:skladcomlot@yandex.ru" target="_blank">skladcomlot@yandex.ru</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

<!-- ОСНОВНОЕ МЕНЮ
    ================================= -->
<div class="header">
<div class="header__bottom">
            <div class="inner work">
                <div class="cols">
                    <div class="col">
                        <div class="logo">
                            <img src="./img/header/logo.png" alt="">
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
                            <button class="btn btn-blue btn-callback" onclick="window.location.href='login.php'">Выйти с аккаунта</a></button>
                            <div class="burger"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<div class="tableWrapper">
    <div class="tableSize">
        <div class="text-monitor">
            <h1>Мониторинг продукции склада</h1>
        </div>
    <table>
  <thead>
    <tr>
      <th>ID</th>
      <th>Название продукта</th>
      <th>Количество на складе</th>
      <th>Цена за единицу</th>
      <th>Количество дней</th>
      <th>Остаток в днях</th>
      <th>Объем продаж за день</th>
      <th>План закупки</th>
      <th>Статус</th>
      <th>Дата добавления товара</th>
    </tr>
  </thead>
  <tbody>
  <?php
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

      // Выборка данных из таблицы
      $result = mysqli_query($link, "SELECT * FROM products");

      // Вывод данных в таблицу
      while ($row = mysqli_fetch_assoc($result)) {
        // определение цвета текста или фона в зависимости от статуса
        $color = ($row['status'] == 'есть в наличии') ? 'green' : 'red';
        echo "<tr>";
        echo "<div style='color: $color;'>";
        echo "<td>" . $row['id'] . "</td>";
        echo "<td>" . $row['product_name'] . "</td>";
        echo "<td>" . $row['quantity'] . " шт.</td>";
        echo "<td>" . $row['price'] . " руб.</td>";
        echo "<td>" . $row['days_in_stock'] . " дней</td>";
        echo "<td>" . $row['days_left'] . " дней</td>";
        echo "<td>" . $row['sales_per_day'] . " шт.</td>";
        echo "<td>" . $row['purchase_plan'] . " руб.</td>";
        echo "<td>" . $row['status'] . "</td>";
        echo "<td>" . $row['date_added'] . "</td>";
        echo "</div>";
        echo "</tr>";
      }

      // Освобождение результата и закрытие соединения с базой данных
      mysqli_free_result($result);
      mysqli_close($link);
?>
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
                            <img src="./img/footer/logo.png" alt="">
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
                                <a class="mail_click" href="mailto:skladcomlot@yandex.ru" target="_blank">skladcomlot@yandex.ru</a>
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
    </div> <!-- END WRAP -->

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
                        <input class="form-control" id="myInput" oninput="validateInput()" pattern="[А-Яа-яЁё0-9\s]+" required title="Имя должно быть на кириллице!" type="text" name="name" required="required" placeholder="______________________________">
                    </div>
                    <div class="form-group form-group_big">
                        <label class="label">Телефон контактного лица</label>
                        <input class="form-control mask" type="text" name="phone" required="required" placeholder="+7 (___) ___-__-__">
                    </div>
                    <div class="form-group form-group_big">
                        <label class="label">E-mail</label>
                        <input class="form-control" size="64" maxLength="64" pattern="[a-z0-9._%+-]+@(gmail|yahoo|mail|yandex|rambler)\.(com|co\.uk|net|ru)" required title="Введит корректную почту! Уберите лишние буквы" type="email" name="email" required="required" placeholder="______________________________">
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
                <img src="./img/thank.svg" alt="Галочка">
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
    <script>
        function validateInput() {
            const input = document.getElementById("myInput");
            input.value = input.value.replace(/[0-9]/g, "");
        }
    </script>

</body>
</html>