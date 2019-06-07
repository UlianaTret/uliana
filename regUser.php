<?php
$PERSON = $_POST;
// ПРОВЕРКА НАЖАТИЯ КНОПКИ
if (isset($PERSON['press'])) {
    // ПРОВЕРКА ПУСТЫХ ПОЛЕЙ
    $empty = '';
    if (($PERSON['login'] != $empty) && ($PERSON['car'] != $empty) && ($PERSON['useNum'] != $empty) && ($PERSON['password1'] != $empty) && ($PERSON['password2'] != $empty)) {
        //пользователь есть в бд???
        $mysqli = new mysqli ("127.0.0.1:3307", "root", "7ptyn5VT", "bd0");
        $mysqli ->query ("SET NAMES 'utf8'");// указание кодировки при запросе
        //// Проверка подключения
        if ($mysqli-> connect_error) {
            die ("Ошибка подключения:". $mysqli-> connect_error);
        }
        //echo "Подключено успешно";
        $test = $mysqli->query("SELECT count(`login`) FROM `users` WHERE login='{$PERSON['login']}'");
        if($test != false) {
            //ПРОВЕРКА ОДИНАКОГО ПАРОЛЯ
            if ($PERSON['password1'] == $PERSON['password2']) {
                if ($PERSON['login'] != $PERSON['password1']) {
                    $PERSON['password1'] = md5($PERSON['password1']);
                    $success = "INSERT INTO `users` (`login`, `password`, `carNumber`, `phone`,`start`, `end`, `time`, `place`, `pay`, `payOK`) VALUES ('{$PERSON['login']}', '{$PERSON['password1']}', '{$PERSON['car']}','{$PERSON['useNum']}', 0, 0, 0, 0, 0, 0)";
                    $result = mysqli_query($mysqli, $success) or die("Ошибка " . mysqli_error($mysqli));
                    $for = $mysqli->query("SELECT count(`id`) FROM `users` WHERE login='{$PERSON['login']}'");
                    session_start();
                    $_SESSION['id'] = $for;
                    $mysqli->close();
                    echo "http://topilin.ru/uliana/user.php";
                    exit();
                } else {echo "#lg";
                    exit();}
            } else {echo "#noPass";
                exit();}
        } else {echo "#dLog";
            exit();}
        } else {echo "#notAll";
    exit();}
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
        REG USER
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
            <a class="navbar-brand" href="http://topilin.ru/uliana/index.php">Parking</a>
        </div>
        <div class="navbar-collapse collapse">
            <div>
                <ul class="nav navbar-nav">
                    <li class="active"><a href="#">главная</a></li>
                    <li><a href="#">о нас</a></li>
                    <li><a href="http://topilin.ru/uliana/user.php">хотите поставить машину?</a></li>
                    <li><a href="http://topilin.ru/uliana/enterAdmin.php">вы сотрудник?</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>
<div id='All' class='alert alert-info' role='alert'>Все поля обязательны для заполнения!</div>
<div id='lol' class='alert alert-warning' role='alert'>Ожидайте...</div>
<div id="notAll" class='alert alert-danger' role='alert'>Вы не заполнили все окна</div>
<div id='dLog' class='alert alert-danger' role='alert'>Пользователь с таким логином существут</div>
<div id='noPass' class='alert alert-danger' role='alert'>Пароли не совпадают</div>
<div id="lg" class='alert alert-danger' role='alert'>ПАРОЛЬ НЕ МОЖЕТ СОВПАДАТЬ С ЛОГИНОМ</div>
<form action="http://topilin.ru/uliana/regUser.php" class="form-group" method="POST">
    <div class="form-group">
        <label for="exampleInputEmail1">Ваше имя</label>
        <input id='login' type="text" class="form-control" name="login" placeholder="Пишите, что хотите">
        <small id="emailHelp" class="form-text text-muted">Например, хочу 5)</small>
    </div>
    <div class="form-group">
        <label for="exampleInputEmail1">Введите нормер своей машины</label>
        <input id='car' type="text" class="form-control" name="car" placeholder="Например, с065мк78RUS">
        <small id="emailHelp" class="form-text text-muted">Это нужно для того, что мы могли связаться с Вами в случае ЧП.</small>
    </div>
    <div class="form-group">
        <label for="exampleInputEmail1">Введите свой нормер телефона</label>
        <input id='useNum' type="text" class="form-control" name="useNum" placeholder="Например, 88002000122">
        <small id="emailHelp" class="form-text text-muted">Это нужно для того, что мы могли связаться с Вами в случае ЧП.</small>
    </div>
    <div class="form-group">
        <label for="exampleInputEmail1">Придумайте пароль</label>
        <input id='password1' type="password" class="form-control" name="password1" placeholder="Придумайте пароль">
        <small id="emailHelp" class="form-text text-muted">Помните, что пароль НЕ должен совпадать с логином.</small>
    </div>
    <div class="form-group">
        <label for="exampleInputEmail1">Повторить пароль</label>
        <input id='password2' type="password" class="form-control" name="password2" placeholder="Повторите пароль">
        <small id="emailHelp" class="form-text text-muted">Мы не настаиваем, но советуем придумать пароль не мение 8 символов.</small>
    </div>
    <input type="button" id="press" class="btn btn-primary" value="Регистрация">
</form>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
<script>
    function information() {
        $("#All").hide();
        $("#notAll").hide();
        $("#dLog").hide();
        $("#noPass").hide();
        $("#lg").hide();
        $("#lol").hide();
    }
    $(document).ready (function () {
        information();
        $("#All").show();
        $("#press").bind("click", function () {
            $.ajax({
                url: "regUser.php",
                type: "POST",
                data: ({login: $("#login").val(), car: $("#car").val(), useNum: $("#useNum").val(),password1: $("#password1").val(), password2: $("#password2").val(), press: 1}),
                dataType: "html",
                beforeSend: function (){
                    $("#lol").show();
                },
                success: function (data) {
                    information();
                    switch(data) {
                        case '#notAll':
                            $(data).show();
                            break;
                        case '#dLog':
                            $(data).show();
                            break;
                        case '#noPass':
                            $(data).show();
                            break;
                        case  '#lg':
                            $(data).show();
                            break;
                        default:
                            window.location=(data);
                            break;
                    }
                }
            });
        });
    });
</script>

<!-- в конце чтобы сайт сильно не нагружался при загрузке -->
<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
<!-- JQuery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>

<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

</body>
</html>
