<?php
session_start();

//Неавторизированных пользователей перенаправляем на главную страницу
if (!$_SESSION['user']) {
    header('Location: /');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/profile.css">
    <title>Profile</title>
</head>

<body class="bg-image">
    <div class="container rounded bg-white mt-5 mb-5">
        <div class="row">
            <div class="col-md-4 border-right">
                <div class="d-flex flex-column align-items-center text-center p-3 py-5">
                    <img class="rounded-circle mt-5" width="150px" src="/assets/images/avatar-demo.png">
                    <span class="font-weight-bold"><?= $_SESSION['user']['name'] ?></span>
                    <span class="text-black-50"><?= $_SESSION['user']['email'] ?></span>
                    <a href="profile.php">Назад к профилю</a>
                    <span> </span>
                </div>
            </div>
            <form action="server/data_handler.php" method="post" class="col-md-4 border-right">
                <div class="p-3 py-5">
                    <?php
                    // Получение данных из сессионной переменной
                    if (isset($_SESSION['user']['dataList'])) {
                        $dataList = $_SESSION['user']['dataList'];

                        $output = "<h2>Data List</h2>";
                        $output .= "<ul>";
                        foreach ($dataList as $data) {
                            $output .= "<li>Record_ID: " . $data["record_id"] . "</li>";
                            $output .= "<li>Login: " . $data["login"] . "</li>";
                            $output .= "<li>Email: " . $data["email"] . "</li>";
                            $output .= "<li>Telephone: " . $data["telephone"] . "</li>";
                            $output .= "<li>Timestamp: " . $data["timestamp"] . "</li>";
                            $output .= "<br>";
                        }
                        $output .= "</ul>";

                        // Удаление данных из сессии (если необходимо)
                        unset($_SESSION['user']['dataList']);

                        // Вывод данных на страницу
                        echo $output;
                    } else {
                        echo "No data available.";
                    }
                    ?>
                </div>
                <div class="container col-md-6 mb-3">
                    <button class="btn btn-primary profile-button" type="submit">Take data changes</button>
                </div>
            </form>
        </div>
    </div>
    </div>
    </div>
</body>

</html>