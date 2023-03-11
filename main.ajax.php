<?php
    session_start();
    require_once "usersController.php";
    $userContr = new UsersController();
    include "footer.php";

    if(isset($_POST['delete'])){
        $userContr->deleteUser($_POST['delete']);
        callAlert("User successfully deleted.", "alert-success");
        die();
    }
    if(isset($_POST['details'])) {
        $userEmail = $_POST['details'];
        $userContr->showModal($userEmail);
        die();
    }