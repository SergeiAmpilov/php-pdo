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


function login(): bool {

  global $pdo;

  $login = trim($_POST['login']) ?: '';
  $pass = trim($_POST['pass']) ?: '';

  if (empty($login) || empty($pass)) {
    $_SESSION['errors'] = 'Empty username or password';
    return false;
  }

  $res = $pdo->prepare("SELECT * FROM users WHERE login = ?");
  $res->execute([$login]);

  if (!$user = $res->fetch()) {
    $_SESSION['errors'] = 'Login or password is incorrect';
    return false;
  } else {
    if (!password_verify($pass, $user['pass'])) {
      $_SESSION['errors'] = 'Login or password is incorrect.';
      return false;
    } else {
      $_SESSION['success'] = 'Successful login';
      $_SESSION['user'] = [
        'id' => $user['id'],
        'login' => $user['login'],
      ];
      return true;
    }
  }
  return false;
}

function logout() {
  unset($_SESSION['user']);
  $_SESSION['success'] = 'Successful Logout';
}

function saveMessage(): bool {

  global $pdo;

  $message = trim($_POST['message']) ?: '';

  if (empty($_SESSION['user'])) {
    $_SESSION['errors'] = 'Need auth.';
    return false;
  }

  if (empty($message)) {
    $_SESSION['errors'] = 'Message is empty. Insert message text.';
    return false;
  }

  $res = $pdo->prepare("INSERT INTO messages (name, message) VALUES (?, ?)");
  if ($res->execute([$_SESSION['user']['login'], $message])) {
    $_SESSION['success'] = 'Message was successfully added';
    return true;
  } else {
    $_SESSION['errors'] = 'Error.';
    return false;
  }

}

function get_messages(): array {

  global $pdo;

  if (empty($_SESSION['user'])) {
    $_SESSION['errors'] = 'Need auth.';
    return [];
  }

  $res = $pdo->prepare("SELECT * FROM messages WHERE name = ?");
  $res->execute([$_SESSION['user']['login']]);
  return $res->fetchAll();
  
}