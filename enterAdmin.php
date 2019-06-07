<?php
$PERSON = $_POST;
// ПРОВЕРКА НАЖАТИЯ КНОПКИ
if (isset($PERSON['press'])) {
    // ПРОВЕРКА ПУСТЫХ ПОЛЕЙ
    $empty = '';
    if (($PERSON['login'] != $empty) && ($PERSON['password']) && ($PERSON['adKey'])) {
        $mysqli = new mysqli ("84.201.189.23:3306", "tret", "q456123", "bd0");
        $mysqli ->query ("SET NAMES 'utf8'");
        if ($mysqli-> connect_error) {
            die ("Ошибка подключения:". $mysqli-> connect_error);
        }
        $result_set = $mysqli->query("SELECT `login`, `password`,`akey`, `allPlace` FROM `infoabautadmin` ");


        while (($row = $result_set->fetch_assoc())!= false) {
            if ($PERSON['login'] == $row['login']) {
                $testPass = $row['password'];
                if (md5($PERSON['password']) == $testPass) {
                    $testK = $row['akey'];
                    if (md5($PERSON['adKey']) == $row['akey']) {
                        //echo "<br> ";
                        //echo $row['akey'];
                        session_start();
                        $_SESSION['adk'] = $row['akey'];
                        $page = $row['allPlace'];
                        $mysqli->close();
                        if ($page!=NULL) {
                            header('Location: http://84.201.189.23/uliana/statusParking.php');//window.location="http://localhost/1kIT/user.php";
                        } else { header('Location: http://84.201.189.23/uliana/worker.php');}
                    } else {
                        $mysqli->close();
                        header('Location: http://84.201.189.23/uliana/index.php');
                    }
                } else {
                    $mysqli->close();
                    header('Location: http://84.201.189.23/uliana/index.php');
                }
            } else {
                $mysqli->close();
                header('Location: http://84.201.189.23/uliana/index.php');
            }
        } //$mysqli->close();
    } else header('Location: http://84.201.189.23/uliana/index.php');
}
?>



<!DOCTYPE html>
<html lang = "ru">
<head>
    <meta charset="WINDOWS-1251" />
    <meta name="description"content=""/>
    <meta name="keywords"content="IT1"/>
    <meta name="author"content="Третьякова Юлиана 3745"/>
    <title>
        ENTER admin
    </title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

    <style>
        body { background: #E6E6FA url();
            padding: 10%;}
    </style>
</head>
<body>
<div id='goAway' class='alert alert-warning' role='alert'>Если Вы не являетесь сотрудником, то, пожалйста, <a href="http://84.201.189.23/uliana/index.php">покиньте страницу</a></div>

<form action="http://84.201.189.23/uliana/enterAdmin.php" class="form-group" method="POST">
    <div class="form-group">
        <label for="exampleInputEmail1">Ваше ФИО</label>
        <input id="login" type="text" class="form-control" name="login">
    </div>
    <div class="form-group">
        <label for="exampleInputEmail1">Пароль</label>
        <input id="password" type="password" class="form-control" name="password">
    </div>
    <div class="form-group">
        <label for="exampleInputEmail1">Ключ</label>
        <input id="adKey" type="password" class="form-control" name="adKey">
    </div>
    <input id="press" type="submit" name="press" class="btn btn-primary" value="Войти">
    <br><a href="http://84.201.189.23/uliana/index.php">назад</a>
</form>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
<!-- JQuery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>

<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
</body>
</html>
