<?php

class DB
{
    public $salt = "work5";

    public function __construct()
    {
        $link = $this->connectDB();
        $create_users_query = "
        CREATE TABLE IF NOT EXISTS `users` (
            `id` int NOT NULL AUTO_INCREMENT,
            `name` varchar(32) NOT NULL,
            `surname` varchar(32) NOT NULL,
            `patronymic` varchar(32) NOT NULL,
            `email` varchar(64) NOT NULL UNIQUE,
            `token` varchar(5) NOT NULL UNIQUE,
            `password` varchar(64) NOT NULL,
            PRIMARY KEY (`id`)
        )";
        mysqli_query($link, $create_users_query);
    }

    public function connectDB()
    {
        $DB_HOST = "localhost";
        $DB_NAME = "work5.test";
        $DB_USER = "root";
        $DB_PASS = "AHBkfyx17";

        $link = mysqli_connect($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
        return $link;
    }

    public function saveData($query)
    {
        $link = $this->connectDB();
        mysqli_query($link, $query);
    }

    public function loadData($query)
    {
        $link = $this->connectDB();
        $data_sql = mysqli_query($link, $query);
        for ($data = []; $row = mysqli_fetch_assoc($data_sql); $data[] = $row);
        return $data;
    }

    public function createUser($name, $surname, $patronymic, $email, $password)
    {
        include "functions.php";
        $link = $this->connectDB();
        $name = mysqli_real_escape_string($link, $name);
        $surname = mysqli_real_escape_string($link, $surname);
        $patronymic = mysqli_real_escape_string($link, $patronymic);
        $email = mysqli_real_escape_string($link, $email);
        $password = mysqli_real_escape_string($link, $password);
        $token = generateToken();

        $create_user_query = "INSERT INTO users (name, surname, patronymic, email, token, password) VALUES ('" . $name . "', '" . $surname . "', '" . $patronymic . "', '" . $email . "', '" . $token . "', '" .  hash('sha256', $password . $salt) . "')";
        $this->saveData($create_user_query);
    }

    public function generateUserToken($email)
    {
        include "functions.php";
        $link = $this->connectDB();
        $token = generateToken();
        $update_token_query = "UPDATE users SET token = '" . mysqli_real_escape_string($link, $token) . "' WHERE email = '" . mysqli_real_escape_string($link, $email) . "'";
        $this->saveData($update_token_query);
        return $token;
    }

    public function authUser($email, $password)
    {
        $link = $this->connectDB();
        $email = mysqli_real_escape_string($link, $email);
        $password = hash('sha256', mysqli_real_escape_string($link, $password));
        $auth_query = "SELECT id FROM `users` WHERE `email` = '" . $email . "' AND `password` = '" . $password . "'";
        $data = $this->loadData($auth_query);

        if (count($data) == 1) {
            $token = $this->generateUserToken($email);
            
            $_SESSION["token"] = $token;
            $_SESSION["email"] = $email;
            return $token;
        }

        return '';
    }

    public function logoutUser()
    {
        $_SESSION['token'] = '';
        session_destroy();
    }

    public function editName($token, $name, $surname, $patronymic)
    {
        $link = $this->connectDB();
        $name = mysqli_real_escape_string($link, $name);
        $surname = mysqli_real_escape_string($link, $surname);
        $patronymic = mysqli_real_escape_string($link, $patronymic);
        $update_name_query = "UPDATE users SET name = '" . mysqli_real_escape_string($link, $name) . "', surname = '" . mysqli_real_escape_string($link, $surname) . "', patronymic = '" . mysqli_real_escape_string($link, $patronymic) . "' WHERE token = '" . mysqli_real_escape_string($link, $token) . "'";
        $this->saveData($update_name_query);
    }

    public function editPassword($token, $password)
    {
        $link = $this->connectDB();
        $password = mysqli_real_escape_string($link, $password);
        $token = mysqli_real_escape_string($link, $token);
        $update_password_query = "UPDATE users SET password = '" . $password . "' WHERE token = '" . $token . "'";
        $this->saveData($update_password_query);
    }

    public function getFullName($token)
    {
        $link = $this->connectDB();
        $token = mysqli_real_escape_string($link, $token);
        $name_query = "SELECT name, surname, patronymic FROM users WHERE token = '" . $token . "')";
        $data = $this->loadData($name_query);
        return $data[0];

    }
}
