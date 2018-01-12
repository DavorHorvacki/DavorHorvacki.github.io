<?php
/**
 * Created by PhpStorm.
 * User: Davos
 * Date: 08-Nov-17
 * Time: 18:52
 */
require('db_config.php');
require('functions.php');
if (isset($_POST["userId"])) {

    $userId = $_POST["userId"];
    if (!empty($userId)) {

        $date_from = strtotime(date("Y-m-d"));
        $date_to = strtotime(date("Y-m-d") . '23:59:59');
        $sql = "SELECT * "
            . "FROM `odgovori` "
            . "WHERE UNIX_TIMESTAMP(`created`) > " . $date_from
            . " AND UNIX_TIMESTAMP(`created`) <" . $date_to . "9 AND `user_id`=" . $userId;
        $result = mysqli_query($connection, $sql);

        if (mysqli_num_rows($result) == 0) {
            $sql = "SELECT * FROM pitanja where `pitanje_id` not in (SELECT `pitanje_id` FROM odgovori WHERE user_id='$userId')";
            $result = mysqli_query($connection, $sql);

            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                    $pitanja[] = $row;
                }
                $rand = rand(0, count($pitanja) - 1);
                $response = json_encode($pitanja[$rand]);
                echo $response;
            } else {
                echo create_json_response('successful', 'Congratulations! You have answered on all od our questions, we hope you enjoyed!');
            }
        } else echo '{"pitanje_id":"unsuccessful","pitanje":"unsuccessful","a":"unsuccessful","b":"unsuccessful","c":"unsuccessful","d":"unsuccessful"}';
    }
} else echo create_json_response('unsuccessful', 'Doslo je do greske(no userId)');
?>
