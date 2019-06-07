<?php
session_start();
if (isset($_SESSION['adk'])) {
    //session_destroy();
    echo '<h2 align="center">Вся информация о парковке</h2>';
    echo 'номер эвакуатора: ***********<br>';
    echo '<a href="http://topilin.ru/uliana/index.php">выход</a>';
    $mysqli = new mysqli ("127.0.0.1:3307", "root", "7ptyn5VT", "bd0");
    $mysqli ->query ("SET NAMES 'utf8'");
    if ($mysqli-> connect_error) {
        die ("Ошибка подключения:". $mysqli-> connect_error);
    }
    $result_set = $mysqli->query("SELECT * FROM `infoabautadmin` WHERE `allPlace` = '10'");
    echo '<table class="table table-bordered table-hover">';
    echo '<thead>';
    echo '<tr class="active">';
    echo '<th class="info">Информация</th>';
    echo '<th class="info">Информация</th>';
    echo '</tr>';
    echo '</thead>';
    echo '<tbody>';
    echo '<h4 align="center">Общая информация</h4>';
    while (($row = $result_set->fetch_assoc())!= false) { //fetch_assoc - поочередно возвращает по одной строке из результата запроса.
        echo '<tr>';
        echo '<td>Всего мест</td>';
        echo '<td>'.$row['allPlace'].'</td>';
        echo '</tr>';
        echo '<tr>';
        echo '<td>Сейчас занятых мест</td>';
        echo '<td>'.$row['zan'].'</td>';
        echo '</tr>';
        echo '<tr>';
        echo '<td>Заработоно</td>';
        echo '<td>'.$row['allPay'].'</td>';
        echo '</tr>';
    }
    echo '</tbody>';
    echo '</table>';
    $mysqli->close();
///////////////////////////////////////////////////////////////////
    $mysqli = new mysqli ("127.0.0.1:3307", "root", "7ptyn5VT", "bd0");
    $mysqli ->query ("SET NAMES 'utf8'");
    if ($mysqli-> connect_error) {
        die ("Ошибка подключения:". $mysqli-> connect_error);
    }
    $result_set = $mysqli->query("SELECT `login`, `carNumber`,`phone`,`place`, `payOK` FROM `users`");
    echo '<table class="table table-bordered table-hover">';
    echo '<thead>';
    echo '<tr class="active">';
    echo '<th class="info">Имя пользователя</th>';
    echo '<th class="info">Номер машины</th>';
    echo '<th class="info">Телефон</th>';
    echo '<th class="info">Место</th>';
    echo '<th class="info">Состояние оплаты</th>';
    echo '</tr>';
    echo '</thead>';
    echo '<tbody>';
    echo '<h4 align="center">Список машин</h4>';
    while (($row = $result_set->fetch_assoc())!= false) { //fetch_assoc - поочередно возвращает по одной строке из результата запроса.
        echo '<tr>';
        echo '<td>'.$row['login'].'</td>';
        echo '<td>'.$row['carNumber'].'</td>';
        echo '<td>'.$row['phone'].'</td>';
        echo '<td>'.$row['place'].'</td>';
        echo '<td>'.$row['payOK'].'</td>';
        echo '</tr>';
    }
    echo '</tbody>';
    echo '</table>';
    $mysqli->close();
    //session_destroy();
}else header('Location: http://topilin.ru/uliana/index.php');
session_destroy();
?>
<!DOCTYPE html>
<html lang = "ru">
<head>
    <meta charset="WINDOWS-1251" />
    <meta name="description"content="">
    <meta name="keywords"content="KRIT">
    <meta name="author"content="Третьякова Юлиана 3745">
    <meta name="viewport" content="width=device, initial-scale=1">
    <title>
        общая ин-ия
    </title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <style>
        body {padding: 10%;
        };
    </style>
</head>
<body>
</body>
</html>
