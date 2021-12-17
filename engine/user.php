<?php
include "db.php";

class User
{
    public function register($name, $surname, $patronymic, $email, $password)
    {
        $db = new DB();
        $db->createUser($name, $surname, $patronymic, $email, $password);
    }

    public function auth($email, $password)
    {
        $db = new DB();
        
        return $db->authUser($email, $password);
    }    

    public function logout($token)
    {
        $db = new DB();
        $db->logoutUser($token);
    }

    public function editName($token, $name, $surname, $patronymic)
    {
        $db = new DB();
        $db->editName($token, $name, $surname, $patronymic);
    }

    public function editPassword($token, $password)
    {
        $db = new DB();
        $db->editPassword($token, $password);
    }
    public function getFullName($token)
    {
        $db = new DB();
        $db->getFullName($token);
    }
}
