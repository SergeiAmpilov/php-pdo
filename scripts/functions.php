<?php

function pre($data) {
  echo '<pre>' . print_r($data, 1) . "</pre>";
}


function registration(): bool {
  
  global $pdo;

  $login = trim($_POST['login']) ?: '';
  $pass = trim($_POST['pass']) ?: '';

  if (empty($login) || empty($pass)) {
    $_SESSION['errors'] = 'Empty username or password';
    return false;
  }

  $res = $pdo->prepare("SELECT COUNT(*) FROM users WHERE login = ?");
  $res->execute([$login]);

  if ($res->fetchColumn()) {
    $_SESSION['errors'] = "This login ($login) allready exist";
    return false;
  }

  $pass = password_hash($pass, PASSWORD_DEFAULT);
  $res = $pdo->prepare("INSERT INTO users (login, pass) VALUES (?, ?)");
  if ($res->execute([$login, $pass])) {
    $_SESSION['success'] = 'Successful registration';
    return true;
  } else {
    $_SESSION['errors'] = "Registration error";
    return false;
  }




  return true;

}