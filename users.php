<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

class Users
{

    private $host = "vl103.sofico.cz";
    private $username = "webapp_rh_ordis_cz";
    private $password = "";
    private $database = "webapp_rh_ordis_cz";

    protected function getUser($email)
    {
        $connection = mysqli_connect($this->host, $this->username, $this->password, $this->database);
        $sql = "SELECT * FROM USERS WHERE EMAIL = '$email'";
        $result = mysqli_query($connection, $sql);
        $user = mysqli_fetch_assoc($result);
        if (!$user) {
            return "user_not_exist";
        }
        mysqli_close($connection);
        return $user;
    }

    protected function getAllUserEmail()
    {
        $connection = mysqli_connect($this->host, $this->username, $this->password, $this->database);
        $sql = "SELECT EMAIL FROM USERS WHERE NOT ID_USER=1";
        $result = mysqli_query($connection, $sql);
        $emails = array();
        if (mysqli_num_rows($result) > 0) {
            while ($user = mysqli_fetch_assoc($result)) {
                $emails[] = $user;
            }
        }
        mysqli_close($connection);
        return $emails;
    }

    protected function getUserCount()
    {
        $connection = mysqli_connect($this->host, $this->username, $this->password, $this->database);
        $sql = "SELECT COUNT(*) FROM USERS";
        $result = mysqli_query($connection, $sql);
        $numberOfRows = mysqli_num_rows($result);
        mysqli_close($connection);
        return $numberOfRows;
    }

    protected function setUser($name, $surname, $email, $password, $confirmPassword)
    {
        if (empty($name) || empty($surname) || empty($email) || empty($password) || empty($confirmPassword)) {
            return "fields_not_full";
        }
        if ($password != $confirmPassword) {
            return "passwords_no_match";
        }

        $connection = mysqli_connect($this->host, $this->username, $this->password, $this->database);
        $sql = "SELECT * FROM USERS WHERE EMAIL='$email' LIMIT 1";
        $result = mysqli_query($connection, $sql);
        $user = mysqli_fetch_assoc($result);

        if ($user) {
            return "user_exists";
        }

        $encryptedPassword = md5($password);
        $sql = "INSERT INTO `USERS` (`FIRST_NAME`, `LAST_NAME`, `PASSWORD`, `EMAIL`) VALUES ('$name','$surname','$encryptedPassword','$email')";
        mysqli_query($connection, $sql);
        mysqli_close($connection);
    }

    public function removeUser($email)
    {
        $connection = mysqli_connect($this->host, $this->username, $this->password, $this->database);
        $sql = "DELETE FROM USERS WHERE EMAIL='$email'";
        mysqli_query($connection, $sql);
        mysqli_close($connection);
    }

    protected function startPasswordReset($email)
    {
        $connection = mysqli_connect($this->host, $this->username, $this->password, $this->database);
        $sql = "SELECT * FROM USERS WHERE EMAIL='$email'";
        $result = mysqli_query($connection, $sql);

        $user = mysqli_fetch_array($result);
        if ($user) {
            $token = md5($email) . rand(10, 9999);
            $expFormat = mktime(
                date("H") + 1,
                date("i"),
                date("s"),
                date("m"),
                date("d"),
                date("Y")
            );
            $expDate = date("Y-m-d H:i:s", $expFormat);

            mysqli_query($connection, "UPDATE USERS SET TOKEN='$token', EXP_DATE='$expDate' WHERE EMAIL='$email'");

            $link = "<a href='https://webapp.rh.ordis.cz/password_reset_secondary.php?key={$email}&token={$token}'>https://webapp.rh.ordis.cz/password_reset_secondary.php?key={$email}&token={$token}</a>";

            $mail = new PHPMailer();
            $mail->CharSet = "utf-8";
            $mail->isSMTP();
            $mail->SMTPAuth = true;
            //$mail->SMTPDebug = SMTP::DEBUG_SERVER;
            $mail->Username = "lukbra769@gmail.com";
            $mail->Password = "";
            $mail->SMTPSecure = "ssl";
            $mail->Host = "smtp.gmail.com";
            $mail->Port = "465";
            $mail->From = 'info@sofico.cz';
            $mail->FromName = 'User Administration';
            $mail->AddAddress($email);
            $mail->IsHTML(true);
            $mail->Subject = 'Reset Password';
            $mail->Body = 'Click on this link to reset the password:<br>' . $link . '';
            if ($mail->Send()) {
                return "success";
            } else {
                return $mail->ErrorInfo;
            }
        } else {
            return "invalid_email";
        }

    }

    protected function setPassword($email, $password, $confirmPassword)
    {
        if (empty($email) || empty($password) || empty($confirmPassword)) {
            return "fields_not_full";
        }
        if ($password != $confirmPassword) {
            return "passwords_no_match";
        }

        $connection = mysqli_connect($this->host, $this->username, $this->password, $this->database);
        $encryptedPassword = md5($password);
        $sql = "UPDATE USERS SET PASSWORD='$encryptedPassword' WHERE EMAIL='$email'";
        mysqli_query($connection, $sql);
        mysqli_close($connection);
        return "success";
    }

    protected function tryLogin($email, $password)
    {
        $encryptedPassword = md5($password);
        $connection = mysqli_connect($this->host, $this->username, $this->password, $this->database);
        $sql = "SELECT * FROM USERS WHERE EMAIL='$email' AND PASSWORD='$encryptedPassword'";
        $result = mysqli_query($connection, $sql);

        if (mysqli_num_rows($result)) {
            $user = mysqli_fetch_assoc($result);
            if ($user['EMAIL'] == $email && $user['PASSWORD'] == $encryptedPassword) {
                header("Location: main.php");
            }
        } else {
            return "wrong_credentials";
        }
        mysqli_close($connection);
    }

    protected function setDetails($name, $surname, $email)
    {
        if (empty($name) || empty($surname) || empty($email)) {
            return "fields_not_full";
        }
        $connection = mysqli_connect($this->host, $this->username, $this->password, $this->database);
        $sql = "UPDATE USERS SET FIRST_NAME='$name' WHERE EMAIL='$email'";
        mysqli_query($connection, $sql);
        $sql = "UPDATE USERS SET LAST_NAME='$surname' WHERE EMAIL='$email'";
        mysqli_query($connection, $sql);
        return "success";
        mysqli_close($connection);
    }
}
?>