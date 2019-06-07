<?php
session_start();
if (isset($_SESSION['adk'])) {
    echo '<h2 align="center">Вся информация о парковке</h2>';
    echo 'номер эвакуатора: ***********<br>';
    echo '<a href="http://topilin.ru/uliana/index.php">выход</a>';
    $mysqli = new mysqli ("127.0.0.1:3307", "root", "7ptyn5VT", "bd0");
    $mysqli ->query ("SET NAMES 'utf8'");
    if ($mysqli-> connect_error) {
        die ("Ошибка подключения:". $mysqli-> connect_error);
    }

    $result_set = $mysqli->query("SELECT * FROM `place`");// все места
echo '<form action="http://topilin.ru/uliana/worker.php" method="GET">';
echo '<table class="table table-bordered table-hover">';
echo '<thead>';
echo '<tr class="active">';
echo '<th class="info">Место</th>';
echo '<th class="info">Номер машины</th>';

echo '</tr>';
echo '</thead>';
echo '<tbody>';
echo '<h4 align="center">Состояние мест</h4>';

while (($row = $result_set->fetch_assoc())!= false) {
    echo '<tr>';
    echo '<td><input id="'.$row['num_place'].'" type="submit" name="press" class="btn btn-primary" value="'.$row['num_place'].'"></td>';
    echo '<td>'.$row['status_place'].'</td>';
    echo '</tr>';
}
echo '</tbody>';
echo '</table>';
$mysqli->close();
echo "</form>";

} else header('Location: http://topilin.ru/uliana/index.php');

$ind = $_GET;
if (isset($ind['press'])) {

    $num = $ind['press'];

    $mysqli = new mysqli ("127.0.0.1:3307", "root", "7ptyn5VT", "bd0");
    $mysqli->query("SET NAMES 'utf8'");
    if ($mysqli->connect_error) {
        die ("Ошибка подключения:" . $mysqli->connect_error);
    }


    //ВЗЯТЬ СТАТУС МЕСТА
    $res = $mysqli->query("SELECT * FROM `place`");
    while (($st = $res->fetch_assoc() != false)) {
        if ($st['num_place'] == $num) {
            $per = $st['status_place'];
        }
    }
    // ПО СТАТУСУ НАЙТИ ПОЛЬЗОВАТЕЛЯ
    $resu = $mysqli->query("SELECT * FROM `users`");
    while (($resu = $res->fetch_assoc() != false)) {
        if ($resu['carNumber'] == $per) {
            //пользовательс машиной найден
            $user = $resu['payOK'];
            // ПРОВЕРИТЬ PAYOK
            switch ($user) {
                case 1:
                    $sql = "UPDATE `users` SET `end`='" . time() . "' WHERE `users`.`carNumber` = '$per'";
                    $success = $mysqli->query($sql);
                    //time
                    $tim = ($resu['end'] - $resu['start']) / 3600;
                    //pay
                    $payPl = $tim * 50;
                    //write pay
                    $sql = "UPDATE `users` SET `pay`='$payPl' WHERE `users`.`carNumber` = '$per'";
                    $success = $mysqli->query($sql);
                    //allpay++
                    $result = $mysqli->query("SELECT * FROM `infoabautadmin`");
                    while (($row = $result->fetch_assoc() != false)) {
                        if ($row['allPlace'] != NULL) {
                            $row['allPay'] = +$payPl;
                            $sql = "UPDATE `infoabautadmin` SET `allPay`='{$row['allPay']}' WHERE `infoabautadmin`.`allPlace` = '10'";
                            $success = $mysqli->query($sql);
                        }
                    }
                    //$PAY:=0
                    $sql = "UPDATE `users` SET `payOK`='0', `pay`='0', `place`='0' WHERE `users`.`carNumber` = '$per'";
                    $success = $mysqli->query($sql);
                    //status_place = free
                    $sql = "UPDATE `place` SET `status_place`='free' WHERE `place`.`num_place` = '$num'";
                    $success = $mysqli->query($sql);
                    break;
                case 0:
                    //start
                    //payOK:=1
                    $sql = "UPDATE `users` SET `start`='" . time() . "', `payOK`=1 WHERE `users`.`carNumber` = '$per'";
                    $success = $mysqli->query($sql);
                    break;
                default:
                    echo "ПРОИЗИШЛА ОШИБКА.";
                    break;
            }
        }
    }
}
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
        body {padding: 5%;
        };
    </style>
</head>
<body>

</body>
</html>
