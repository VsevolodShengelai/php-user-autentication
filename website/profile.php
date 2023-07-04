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
                    <a href="data.php">Посмотреть историю изменений</a>
                    <span> </span>
                </div>
            </div>
            <form action="server/profile_handler.php" method="post" class="col-md-4 border-right">

                <div class="p-3 py-5">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h4 class="text-right">Profile Settings</h4>
                    </div>
                    <div class="row mt-2">
                        <div class="form-outline mb-4 input-container col-md-12 input-container">
                            <input id="name" name="name" class="input form-control" value="<?= $_SESSION['user']['name'] ?>" type="text" placeholder=" " />
                            <div class="cut cut-middle"></div>
                            <label for="name" class="placeholder">Name(Login)</label>
                            <small class="text-danger small-container">
                                <?php 
                                  echo $_SESSION['errors']['name'];
                                  unset($_SESSION['errors']['name']);
                                ?>
                            </small>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="form-outline mb-4 input-container col-md-12 input-container">
                            <input id="telephone" name="telephone" class="input form-control" value="<?= $_SESSION['user']['telephone'] ?>" type="tel" placeholder=" " />
                            <div class="cut cut-long"></div>
                            <label for="telephone" class="placeholder">Telephone number</label>
                            <small class="text-danger small-container">
                                <?php 
                                  echo $_SESSION['errors']['telephone'];
                                  unset($_SESSION['errors']['telephone']);
                                ?>
                            </small>
                        </div>
                        <div class="form-outline mb-4 input-container col-md-12 input-container">
                            <input id="email" name="email" class="input form-control" value="<?= $_SESSION['user']['email'] ?>" type="email" placeholder=" " />
                            <div class="cut cut-middle"></div>
                            <label for="email" class="placeholder">Email address</label>
                            <small class="text-danger small-container">
                                <?php 
                                  echo $_SESSION['errors']['email'];
                                  unset($_SESSION['errors']['email']);
                                ?>
                            </small>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="form-outline mb-4 input-container col-md-12 input-container">
                            <input id="password" name="password" class="input form-control" type="password" placeholder=" " />
                            <div class="cut cut-middle"></div>
                            <label for="password" class="placeholder">Old password</label>
                            <small class="text-danger small-container">
                            <?php 
                                  echo $_SESSION['errors']['password'];
                                  unset($_SESSION['errors']['password']);
                                ?>
                            </small>
                        </div>
                        <div class="form-outline mb-4 input-container col-md-12 input-container">
                            <input id="new_password" name="new_password" class="input form-control" type="password" placeholder=" " />
                            <div class="cut cut-middle"></div>
                            <label for="new_password" class="placeholder">New password</label>
                            <small class="text-danger">
                            <?php 
                                  echo $_SESSION['errors']['new_password'];
                                  unset($_SESSION['errors']['new_password']);
                                ?>
                            </small>
                        </div>
                        <div class="form-outline mb-4 input-container col-md-12 input-container">
                            <input id="confirm_new_password" name="confirm_new_password" class="input form-control" type="password" placeholder=" " />
                            <div class="cut cut-long-plus"></div>
                            <label for="confirm_new_password" class="placeholder">Confirm new password</label>
                            <small class="text-danger small-container">
                            <?php 
                                  echo $_SESSION['errors']['confirm_new_password'];
                                  unset($_SESSION['errors']['confirm_new_password']);
                                ?>
                            </small>
                        </div>
                        <div class="form-outline mb-4 input-container col-md-12 input-container">
                            <small class="text-success small-container" style="font-weight:bold">
                                <?php 
                                  if($_SESSION['message']){
                                    echo $_SESSION['message'];
                                  }
                                  unset($_SESSION['message']);
                                ?>
                            </small>
                        </div>
                    </div>
                    <div class="row     ">
                        <div class="container col-md-6">
                            <button class="btn btn-primary profile-button" type="submit">Save Profile</button>
                        </div>
                        <div class="container col-md-3">
                            <a class="btn btn-outline-warning btn-rounded" href="server/logout.php">Exit</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    </div>
    </div>
</body>

</html>