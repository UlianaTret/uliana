<?php
echo '<h1>Приветствуем Вас на нашей парковке</h1>';
$mysqli = new mysqli ("84.201.189.23:3306", "tret", "q456123", "bd0");
$mysqli ->query ("SET NAMES 'utf8'");
// Проверьте подключение
if ($mysqli-> connect_error) {
    die ("Ошибка подключения:". $mysqli-> connect_error);
}
$result_sett = $mysqli->query("SELECT * FROM `place`");
$freePL = 0;
while (($Place = $result_sett->fetch_assoc())!= false) { //fetch_assoc - поочередно возвращает по одной строке из результата запроса.
    if ($Place['status_place'] == 'free') {
        $freePL = $freePL + 1;
    }
}
echo "<h3 align=\'center\'>Свободных мест $freePL</h3>";
$mysqli->close();

session_start();
    if(isset($_SESSION['id'])) {
        $mysqli = new mysqli ("84.201.189.23:3306", "tret", "q456123", "bd0");
        $mysqli ->query ("SET NAMES 'utf8'");
        if ($mysqli-> connect_error) {
            die ("Ошибка подключения:". $mysqli-> connect_error);
        }
        $test = $_SESSION['id'];
        $success = $mysqli->query("SELECT * FROM `users`");
        while (($row = $success->fetch_assoc())!= false) {
            if ($row['id'] == $test) {
                $car = $row['carNumber'];
                if ($freePL!=0) {
                    //echo $row['payOK'];
                    if ($row['payOK'] == 0) {
                        if($row['place'] == NULL) {
                            $result_pl = $mysqli->query("SELECT * FROM `place`");// все места
                            $status = 0;
                            while (($row = $result_pl->fetch_assoc())!= false) {
                                switch ($status) {
                                    case 0:
                                        switch ($row['status_place']) {
                                            case 1:
                                                echo "<h3>Ваше место ".$row['num_place']."</h3>";
                                                $rec = $row['num_place'];
                                                $sql = "UPDATE users SET place = '$rec' WHERE id = '$test' ";
                                                $success = $mysqli->query($sql);
                                                $status = 1;
                                                break;
                                        }
                                        break;
                                }
                            }
                            echo "<small id=\"emailHelp\" class=\"form-text text-muted\">Счет времени начнется, когда Вы заедете на парковку</small>";
                        } else {
                            echo "<h3>Ваше место ".$success['place']."</h3>";
                            echo "<small id=\"emailHelp\" class=\"form-text text-muted\">Счет времени начнется, когда Вы заедете на парковку</small>";
                        }
                    } else { echo '<button class="btn btn-default disabled">Получить место</button>';
                        echo "<small id=\"emailHelp\" class=\"form-text text-muted\">Вы не оплатили предыдущую бронь)<a href=\"http://topilin.ru/uliana/enterUser\"> хотите оплатить? </a></small>";
                    }
                } else echo "<h3>К сожалению свободных мест пока нет(...</h3>";
            }
        }
    } else { echo '<br><input class="btn btn-default disabled" value="Получить место">';
        echo '<br><small id=\"emailHelp\" class=\"form-text text-muted\">чтобы поставить машину авторизируйтесь или зарегистрируйтесь<a href="http://topilin.ru/uliana/enterUser.php"> enter </a> или <a href="http://topilin.ru/uliana/regUser.php"> зарегистрируйтесь </a></small>';
    }
//$mysqli->close();
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
        бронь
    </title>

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

    <style>
        body { background: #E6E6FA url();
            padding: 10%;
        };
    </style>

</head>
<body>

<div class="navbar navbar-inverse navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <button class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="http://84.201.189.23/uliana/index">Parking</a>
        </div>
        <div class="navbar-collapse collapse">
            <div>
                <ul class="nav navbar-nav">
                    <li class="active"><a href="http://84.201.189.23/uliana/index.php">главная</a></li>
                    <li><a href="#">о нас</a></li>
                    <li><a href="http://84.201.189.23/uliana/user.php">хотите поставить машину?</a></li>
                    <li><a href="http://84.201.189.23/uliana/enterAdmin.php">вы сотрудник?</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>


<div class="dropdown">
    <button class="btn btn-info btn-block dropdown-toggle" data-toggle="dropdown">о наших услугах <span class="caret"></span></button>
    <ul class="dropdown-menu">
        <li class="dropdown-header">Стоимость</li>
        <li><a href="#">1 час 50 рублей</a></li>
        <li><a href="#">приятного время препровождения</a></li>
    </ul>
</div>

<!-- в конце чтобы сайт сильно не нагружался при загрузке -->
<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
<!-- JQuery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>

<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

</body>
</html>
