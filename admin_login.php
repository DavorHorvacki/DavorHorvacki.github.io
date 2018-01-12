<?php
/**
 * Created by PhpStorm.
 * User: Davos
 * Date: 16-Dec-17
 * Time: 13:48
 */
session_start();

require('db_config.php');
require('functions.php');

if (isset($_POST['username']) && isset($_POST['password'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $password2 = 'soljenje' . $password;
    $password1 = md5($password2);

    if (!empty($username) && !empty($password1)) {
        $username = mysqli_real_escape_string($connection, $username);
        $password = mysqli_real_escape_string($connection, $password1);
        $sql = "SELECT `user_id` FROM `user` WHERE `username`='$username' AND `password`='$password' AND `admin`=1";
        $result = mysqli_query($connection, $sql);
        if (mysqli_num_rows($result) == 0) {
            echo create_json_response('unsuccessful', 'Pogrešna kombinacija šifre ili korisnik nije admin');
            header("location: login.html");
        } elseif (mysqli_num_rows($result) == 1) {
            while ($row = mysqli_fetch_array($result)) {
                $user_id = $row['user_id'];
                $_SESSION['admin']=$user_id;
                echo create_json_response('successful', $user_id);
                header("location: admin.php");
            }
        }
    } else echo create_json_response('unsuccessful', 'Morate uneti oba polja');
} else echo create_json_response('unsuccessful', 'Morate uneti oba polja');

?>
