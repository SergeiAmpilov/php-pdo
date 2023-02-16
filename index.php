<?php
error_reporting(-1);
session_start();

require_once(__DIR__ . '/scripts/get-env.php');
require_once(__DIR__ . '/scripts/db.php');
require_once(__DIR__ . '/scripts/functions.php');
?>

<?
if (isset($_POST['register'])) {
  registration();
  header("Location: index.php");
  die;
}

if (isset($_POST['auth'])) {
  login();
  header("Location: index.php");
  die;
}

if (isset($_GET['do']) && $_GET['do'] === 'exit' && isset($_SESSION['user'])) {
  logout();
  header("Location: index.php");
  die;
}

if (isset($_POST['add'])) {
  saveMessage();
  header("Location: index.php");
  die;
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <link rel="stylesheet" href="assets/index.css">
  <title>Document</title>
</head>
<body>
  <div class="container">

    <div class="row my-3">
      <div class="col">
        <?php if (!empty($_SESSION['errors'])) { ?>
          <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?php
              echo $_SESSION['errors'];
              unset($_SESSION['errors']);
            ?>  
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        <? } ?>
        <?php if (!empty($_SESSION['success'])) { ?>
          <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?php
              echo $_SESSION['success'];
              unset($_SESSION['success']);
            ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        <? } ?>
      </div>
    </div>



    <?php if (empty($_SESSION['user'])) { ?>
      <div class="row">
        <div class="col-md-6 offset-md-3">
          <h3>Регистрация</h3>
        </div>
      </div>
  
      <form action="index.php" method="post" class="row g-3">
        <div class="col-md-6 offset-md-3">
          <div class="form-floating mb-3">
            <input type="text" name="login" class="form-control" id="floatingInput" placeholder="Имя">
            <label for="floatingInput">Имя</label>
          </div>
        </div>
  
        <div class="col-md-6 offset-md-3">
          <div class="form-floating">
            <input type="password" name="pass" class="form-control" id="floatingPassword"
                  placeholder="Password">
            <label for="floatingPassword">Пароль</label>
            </div>
        </div>
  
        <div class="col-md-6 offset-md-3">
          <button type="submit" name="register" class="btn btn-primary">Зарегистрироваться</button>
        </div>
      </form>
  
      <div class="row mt-3">
        <div class="col-md-6 offset-md-3">
          <h3>Авторизация</h3>
        </div>
      </div>
  
      <form action="index.php" method="post" class="row g-3">
        <div class="col-md-6 offset-md-3">
          <div class="form-floating mb-3">
            <input type="text" name="login" class="form-control" id="floatingInput" placeholder="Имя">
            <label for="floatingInput">Имя</label>
          </div>
        </div>  
        <div class="col-md-6 offset-md-3">
          <div class="form-floating">
            <input type="password" name="pass" class="form-control" id="floatingPassword" placeholder="Password">
            <label for="floatingPassword">Пароль</label>
          </div>
        </div>  
        <div class="col-md-6 offset-md-3">
          <button type="submit" name="auth" class="btn btn-primary">Войти</button>
        </div>
      </form>
    <? } else { ?>
      <div class="row">
        <div class="col-md-6 offset-md-3">
            <p>Добро пожаловать, <?= htmlspecialchars($_SESSION['user']['login']) ?>! <a href="?do=exit">Log out</a></p>
        </div>
      </div>
      <form action="index.php" method="post" class="row g-3 mb-5">
        <div class="col-md-6 offset-md-3">
          <div class="form-floating">
            <textarea class="form-control" name="message" placeholder="Leave a comment here"
                      id="floatingTextarea" style="height: 100px;"></textarea>
            <label for="floatingTextarea">Сообщение</label>
          </div>
        </div>
        <div class="col-md-6 offset-md-3">
          <button type="submit" name="add" class="btn btn-primary">Отправить</button>
        </div>
      </form>
  
      <? } ?>
      <div class="row">
        <div class="col-md-6 offset-md-3">
            <hr>
            <div class="card my-3">
                <div class="card-body">
                    <h5 class="card-title">Автор: User</h5>
                    <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Blanditiis distinctio
                        est illum in ipsum nemo nostrum odit optio quibusdam velit. Commodi dolores dolorum ex facere
                        maiores porro, reprehenderit velit voluptatum.</p>
                    <p>Дата: 01.01.2000</p>
                </div>
            </div>
        </div>
      </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>
