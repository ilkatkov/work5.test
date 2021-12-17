<?php
include_once "../engine/user.php";

session_start();

$email = $_POST['email'];
$password = $_POST['password'];
$token = $_SESSION["token"];
$email = $_SESSION["email"];

var_dump($token);

$user = new User();
if (count($token) > 0) {
    $full_name = $user->getFullName($token);
    echo "<h1>Привет, " . $full_name['name'] . $full_name['surname'] . $full_name['patronymic'] . "!";
} else {
    $new_token = $user->auth($email, $password);
    if ($new_token != "") {
        echo "вы авторизованы";
    }
    else {
        echo "no auth";
    }
}
