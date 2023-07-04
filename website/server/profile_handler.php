<?php
    session_start();
    require_once 'connect.php';
    require_once 'functions.php';

    $name = clear_data($_POST['name']);
    $telephone = clear_data($_POST['telephone']);
    $email = clear_data($_POST['email']);
    $password = clear_data($_POST['password']);
    $new_password = clear_data($_POST['new_password']);
    $confirm_new_password = clear_data($_POST['confirm_new_password']);
   
    $errors = [];
    $error_flag = 0;

    if (!is_valid_login($name)){
        $errors['name'] = 'Строка должна начинаться с буквы и заканчиваться ею. Длина строки - 4 до 31 символов';
        $error_flag = 1;
    } elseif (!is_login_unique($name, $link) and $name != $_SESSION['user']['name']){
        $errors['name'] = 'Этот логин уже занят';
        $error_flag = 1;
    }
    if (!is_valid_telephone($telephone)){
        $errors['telephone'] = 'Формат телефона не верный';
        $error_flag = 1;
    } elseif(!is_telephone_unique($telephone, $link) and $telephone != $_SESSION['user']['telephone']){
        $errors['telephone'] = 'Такой телефон уже есть в базе данных';
        $error_flag = 1;
    }
    if (!is_valid_email($email)){
        $errors['email'] = 'Формат email-адреса не верный';
        $error_flag = 1;
    } elseif(!is_email_unique($email, $link) and $email != $_SESSION['user']['email']){
        $errors['email'] = 'Такой email уже есть в базе данных';
        $error_flag = 1;
    }

    $passwords_are_empty = true;

    if(!(empty($password) and empty($new_password) and empty($confirm_new_password))){
        $passwords_are_empty = false;
        if (strlen($password) < 4){
            $errors['password'] = 'Слишком короткий пароль';
            $error_flag = 1;
        }
        if (strlen($new_password) < 4){
            $errors['new_password'] = 'Слишком короткий пароль';
            $error_flag = 1;
        }
        if (strlen($confirm_new_password) < 4){
            $errors['confirm_new_password'] = 'Слишком короткий пароль';
            $error_flag = 1;
        }
    }

    

    if($passwords_are_empty and !$error_flag){
        //Найдём запись о пользователе по его id
        //Запись должна быть одна
        $id = $_SESSION['user']['id'];

        mysqli_query($link, "UPDATE `users` SET
        `login` = '$name', `email` = '$email', `telephone` = '$telephone'
        WHERE `id` = $id;");

        $_SESSION['message'] = 'Данные успешно изменены';
        
        /*Здесь нужно вытянуть из БД информацию*/
        $_SESSION['user'] = [
            'id' => $id,
            'name' => $name,
            'email' => $email,
            'telephone' => $telephone,
        ];

        header('Location: ../profile.php'); 
    }
    elseif ($new_password === $confirm_new_password and !$error_flag) {
        //Найдём запись о пользователе по id
        //Запись должна быть одна
        $id = $_SESSION['user']['id'];
        $result= mysqli_query($link, "SELECT * FROM `users` 
        WHERE (`id` = '$id')");

        //Преобразуем результат запроса в ассоциативный массив (словарь)
        $user = mysqli_fetch_assoc($result);
        //Получим захешированный пароль, хранящийся в БД
        $userpassword = $user['password'];

        /*Если пароль правильный*/
        if(password_verify($password, $userpassword) == 1){
            
            $hash = password_hash($new_password, PASSWORD_DEFAULT);

            mysqli_query($link, "UPDATE `users` SET
            `login` = '$name', `email` = '$email', `telephone` = '$telephone', `password` = '$hash'
            WHERE `id` = $id;");

            $_SESSION['message'] = 'Данные успешно изменены';

            $_SESSION['user'] = [
                'id' => $id,
                'name' => $name,
                'email' => $email,
                'telephone' => $telephone,
            ];
    
            header('Location: ../profile.php');
        }
        else{
            $errors['password'] = 'Неверный пароль';
            $_SESSION['errors'] = $errors;
            header('Location: ../profile.php'); 
        }
    }
    else{
        if ($new_password !== $confirm_new_password){
            $errors['new_password'] = 'Пароли не совпадают';
            $errors['confirm_new_password'] = 'Пароли не совпадают';
        }
        $_SESSION['errors'] = $errors;
        $_SESSION['POST'] = $_POST;

        header('Location: ../profile.php'); 
    }