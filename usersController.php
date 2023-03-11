<?php

require_once "users.php";
require_once "usersView.php";

class UsersController extends Users{

    public function seeUserCount(){
        return $this->getUserCount();
    }

    public function seeUser($email) {
        return $this->getUser($email);
    }

    public function seeAllUsers(){
        $emails = $this->getAllUserEmail();
        $usersView = new UsersView();
        $usersView->viewUsers($emails);
    }

    public function showModal($email){
        $usersView = new UsersView();
        $usersView->showDetailsModal($email);
    }

    public function createUser($name, $surname, $email, $password, $repeat_password) {
        return $this->setUser($name, $surname, $email, $password, $repeat_password);
    }

    public function deleteUser($email){
        $this->removeUser($email);
    }

    public function startPassReset($email){
        return $this->startPasswordReset($email);
    }

    public function resetPassword($email, $password, $repeat_password) {
        return $this->setPassword($email, $password, $repeat_password);
    }

    public function login($email, $password) {
        return $this->tryLogin($email, $password);
    }

    public function resetDetails($name, $surname, $email){
        return $this->setDetails($name, $surname, $email);
    }
}

?>