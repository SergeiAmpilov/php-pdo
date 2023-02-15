<?php

$host   = getEnvParam('HOST') ?: 'localhost';
$db   = getEnvParam('HOST122') ?: 'my_db';
$user = getEnvParam('USER') ?: 'root';
$pass = getEnvParam('PASS') ?: '';
$charset = 'utf8';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

$options = [
  PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
  PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];

$pdo = new PDO($dsn, $user, $pass, $options);

var_dump($pdo);
