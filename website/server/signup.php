<?php
    session_start();
    require_once 'connect.php';
    require_once 'functions.php';

    $name = clear_data($_POST['name']);
    $telephone = clear_data($_POST['telephone']);
    $email = clear_data($_POST['email']);
    $password = clear_data($_POST['password']);
    $confirm_password = clear_data($_POST['confirm_password']);


    $pattern_email = '/^[A-Z0-9._%+-]+@[A-Z0-9-]+.+.[A-Z]{2,4}$/i';

    /*
    На будущее: добавить больше условий к паролю
    Сейчас ограничение только по длине
    */ 

    $errors = [];
    $error_flag = 0;

    if (!is_valid_login($name)){
        $errors['name'] = 'Строка должна начинаться с буквы и заканчиваться ею. Длина строки - 4 до 31 символов';
        $error_flag = 1;
    } elseif (!is_login_unique($name, $link)){
        $errors['name'] = 'Этот логин уже занят';
        $error_flag = 1;
    }
    if (!is_valid_telephone($telephone)){
        $errors['telephone'] = 'Формат телефона не верный';
        $error_flag = 1;
    } elseif(!is_telephone_unique($telephone, $link)){
        $errors['telephone'] = 'Такой телефон уже есть в базе данных';
        $error_flag = 1;
    }
    if (!is_valid_email($email)){
        $errors['email'] = 'Формат email-адреса не верный';
        $error_flag = 1;
    } elseif(!is_email_unique($email, $link)){
        $errors['email'] = 'Такой email уже есть в базе данных';
        $error_flag = 1;
    }
    if (strlen($password) < 4){
        $errors['password'] = 'Слишком короткий пароль';
        $error_flag = 1;
    }
    if (strlen($confirm_password) < 4){
        $errors['confirm_password'] = 'Слишком короткий пароль';
        $error_flag = 1;
    }
    

    if ($password === $confirm_password and !$error_flag){
        //print("Пароли совпадают");

        //Хешируем пароль. Алгоритмы MD5 и SHA1 устарели. Используем функциюю password_hash()
        $hash = password_hash($password, PASSWORD_DEFAULT);
        
        mysqli_query($link, "INSERT INTO `users` 
        (`id`, `login`, `email`, `telephone`, `password`) VALUES 
        (NULL, '$name', '$email', '$telephone', '$hash')");
        
        $_SESSION['message'] = 'Регистрация прошла успешно';
        header('Location: ../index.php'); 
    }
    else{
        if ($password !== $confirm_password){
            $errors['password'] = 'Пароли не совпадают';
            $errors['confirm_password'] = 'Пароли не совпадают';
        }
        $_SESSION['errors'] = $errors;
        $_SESSION['POST'] = $_POST;
        //die($errors['name']);
        //print("Пароли НЕ совпадают");
        //die('пароли не совпадают'); //Передать это сообщение на клент
        header('Location: ../registration.php'); 
    }