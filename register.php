<?php
/**
 * Created by PhpStorm.
 * User: Davos
 * Date: 18-Nov-17
 * Time: 13:48
 */
require 'db_config.php';
require 'functions.php';
if(isset($_POST['username']) && isset($_POST['password'])){
    $username=mysqli_real_escape_string($connection,$_POST['username']);
    $pass=mysqli_real_escape_string($connection,$_POST['password']);
    //echo 'ime:'.$ime.',prezime:'.$preime
    $pass1='soljenje'.$pass;
    $pass=md5($pass1);
    if( !empty($username) && !empty($pass)){
        $sql="select user_id from user where username='$username'";
        $result=mysqli_query($connection,$sql);
        if(mysqli_num_rows($result)>0){
            echo create_json_response('unsuccessful','Korisnik sa ovim korisničkim imenom već postoji');
        }else{
            $sql="INSERT INTO `user` (`user_id`, `username`, `password`) VALUES (NULL, '$username', '$pass')";
            if($result=mysqli_query($connection,$sql)){
                echo create_json_response('successful','Uspesno ste se registovali');
            }
        }


    }else echo create_json_response('unsuccessful','Popunite sva polja!');
}

?>