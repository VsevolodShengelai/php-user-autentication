<?php
    session_start();
    require_once 'connect.php';

    $captcha = $_POST['token'];
    $secretKey = "6Lf-rikmAAAAALnc4MzeL6yifWVGUSgfBZFhDGJx";

    $url = 'URL: https://www.google.com/recaptcha/api/siteverify?secret=' . $secretKey . '&response=' . $captcha;

    $response = file_get_contents($url);
    $responseKeys = json_decode($response, true);
    header('Content-type: application/json');

    if(!($responseKeys["success"] && $responseKeys["score"] >= 0.5)){
        //die('Вы робот');
    }

    $telephone_or_email = $_POST['telephone_or_email'];
    $password = $_POST['password'];
    $hash = password_hash($password, PASSWORD_DEFAULT);

    //password_verify(string $password, string $hash);
    
    //Найдём запись о пользователе по телефону или почте
    //Запись должна быть одна
    $result= mysqli_query($link, "SELECT * FROM `users` 
    WHERE (`telephone` = '$telephone_or_email' OR `email` = '$telephone_or_email')");

    //Преобразуем результат запроса в ассоциативный массив (словарь)
    $user = mysqli_fetch_assoc($result);

    //Получим захешированный пароль, хранящийся в БД
    $userpassword = $user['password'];

    //Если пароль правильный
    if(password_verify($password, $userpassword) == 1){
        print('Всё гуд');

        $_SESSION['user'] = [
            'id' => $user['id'],
            'name' => $user['login'],
            'email' => $user['email'],
            'telephone' => $user['telephone'],
        ];

        header('Location: ../profile.php');
    }
    else{
        $_SESSION['message'] = 'Не верный логин или пароль';
        header('Location: ../index.php'); 
    }

    //print($userpassword);

    //echo mysqli_num_rows($check_user);
?>