<?php

$recepient = "skladcomlot@yandex.ru";
$siteName = "СКЛАДКОМЛот.Ру";

$name = trim($_POST["name"]);
$phone = trim($_POST["phone"]);
$email = trim($_POST["email"]);
$text = trim($_POST["text"]);

$message = '
<html>
<body>
<center>
<table border="1" cellpadding="6" cellspacing="0" width="90%" bordercolor="#DBDBDB">
<tr><td colspan="2" align="center" bgcolor="#E4E4E4"><b>Информация о клиенте</b></td></tr>
<tr>
<td><b>Имя клиента:</b></td>
<td>'. $name .'</td>
</tr>
<tr>
<td><b>Телефон:</b></td>
<td>'. $phone .'</td>
</tr>
<tr>
<td><b>E-mail:</b></td>
<td>'. $email .'</td>
</tr>
<tr>
<td><b>Сообщение:</b></td>
<td>'. $text .'</td>
</tr>';


$pagetitle = "Заявка с сайта \"$siteName\"";
mail($recepient, $pagetitle, $message, "Content-type: text/html; charset=\"utf-8\"\n From: $recepient");

?>