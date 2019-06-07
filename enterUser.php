<?php
session_start();
$PERSON = $_POST;
// ПРОВЕРКА НАЖАТИЯ КНОПКИ
if (isset($PERSON['press'])) {
    // ПРОВЕРКА ПУСТЫХ ПОЛЕЙ
    $empty = '';
    if (($PERSON['login'] != $empty) && ($PERSON['password']!= $empty)) {
        $mysqli = new mysqli ("84.201.189.23:3306", "tret", "q456123", "bd0");
        $mysqli ->query ("SET NAMES 'utf8'");
        if ($mysqli-> connect_error) {
            die ("Ошибка подключения:". $mysqli-> connect_error);
        }
        $result_set = $mysqli->query("SELECT `login`, `password`,`id` FROM `users` ");
        while (($row = $result_set->fetch_assoc())!= false) {
            if ($PERSON['login'] == $row['login']) {
                $testPass = $row['password'];
                if (md5($PERSON['password']) == $testPass) {
                    $byID = $mysqli->query("SELECT `id` FROM `users` WHERE `users`.`login` = {$PERSON['login']}");
                    $_SESSION["id"] = $byID;
                    $mysqli->close();
                    echo "ok.....";
                    exit();
                } else  {
                    echo "#NoPass";
                    $mysqli->close();
                    exit();
                }
            } else $l=0;
        } echo "#NoLog";
        $mysqli->close();
            exit();
        } echo "#no";
    $mysqli->close();
    exit();
}
?>

<!DOCTYPE html>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
<html lang = "ru">
<head>
    <meta charset="WINDOWS-1251" />
    <meta name="description"content=""/>
    <meta name="keywords"content="IT1"/>
    <meta name="author"content="Третьякова Юлиана 3745"/>
    <title>
        ENTER USER
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
            <a class="navbar-brand" href="http://84.201.189.23/uliana/index.php">Parking</a>
        </div>
        <div class="navbar-collapse collapse">
            <div>
                <ul class="nav navbar-nav">
                    <li class="active"><a href="#">главная</a></li>
                    <li><a href="#">о нас</a></li>
                    <li><a href="http://84.201.189.23/uliana/user.php">хотите поставить машину?</a></li>
                    <li><a href="http://84.201.189.23/uliana/enterAdmin.php">вы сотрудник?</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>


<div id='Autoriz' class='alert alert-info' role='alert'>Авторизируйтесь</div>
<div id='no' class='alert alert-danger' role='alert'>Вы не заполнили все окна</div>
<div id='NoLog' class='alert alert-danger' role='alert'>Неверный логин</div>
<div id="NoPass" class='alert alert-danger' role='alert'>Неверный пароль</div>
<div id="lol" class='alert alert-warning' role='alert'>Ожидайте...</div>

<form action="http://84.201.189.23/uliana/enterUser.php" class="form-group" method="POST">
    <div class="form-group">
        <label for="exampleInputEmail1">Ваше имя</label>
        <input type="text" class="form-control" id="login" name="login" placeholder="Логин">
    </div>
    <div class="form-group">
        <label for="exampleInputEmail1">Пароль</label>
        <input type="password" class="form-control" id="password" name="password" placeholder="Пароль">
    </div>
    <input type="button" id="press" name="press" class="btn btn-primary" value="Войти">
    <br><br>  Не зарегистрированы? <a href="http://topilin.ru/uliana/regUser.php">Регистрация</a>
</form>

<script>
    function information() {
        $("#Autoriz").hide();
        $("#no").hide();
        $("#NoLog").hide();
        $("#NoPass").hide();
        $("#lol").hide();
    }
    $(document).ready (function () {
        information();
        $("#Autoriz").show();
        $("#press").bind("click", function () {
            $.ajax({
                url: "enterUser.php",
                type: "POST",
                data: ({login: $("#login").val(), password: $("#password").val(), press: 1}),
                dataType: "html",
                beforeSend: function (){
                    $("#lol").show();
                },
                success: function (data) {
                    information();
                    switch(data) {
                        case '#0':
                            $(data).show();
                            break;
                        case '#NoLog':
                            $(data).show();
                            break;
                        case '#NoPass':
                            $(data).show();
                            break;
                        case  '#lol':
                            $(data).show();
                            break;
                        default:
                            window.location="http://84.201.189.23/uliana/user.php";
                            break;
                    }
                }
            });
        });
    });
</script>

<!-- JQuery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>

<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

</body>
</html>
