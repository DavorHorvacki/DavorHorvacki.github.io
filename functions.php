<?php
/**
 * Created by PhpStorm.
 * User: Davos
 * Date: 18-Nov-17
 * Time: 14:22
 */

function create_json_response($status, $message)
{
    $response['status'] = $status;
    $response['message'] = $message;
    $response = json_encode($response);
    return $response;
}

function user_list()
{
    global $connection;
    $sql = "SELECT `username`, `user_id` FROM `user` WHERE `admin`=0";
    $result = mysqli_query($connection, $sql);

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $users[] = $row;
        }
        return $users;
    } else return $users[] = "No users";
}

function question_list()
{
    global $connection;
    $sql = "SELECT * FROM `pitanja`";
    $result = mysqli_query($connection, $sql);

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $questions[] = $row;
        }
        return $questions;
    } else return $questions[] = "No questions";
}

function change_question($question_id, $question, $a, $b, $c, $d)
{

    global $connection;
    $sql = "UPDATE `pitanja` SET `pitanje`='" . $question . "',`a` = '" . $a . "', `b` = '" . $b . "', `c` = '" . $c . "', `d` = '" . $d . "' WHERE `pitanje_id` = " . $question_id;
    if ($result = mysqli_query($connection, $sql)) {
        return create_json_response('successful', 'Uspesno ste promenili pitanje');
    } else return create_json_response('unsuccessful', 'Neuspesno ste promenili pitanje');

}

function answers_list()
{
    global $connection;
    $sql = "SELECT * FROM `odgovori`";
    $result = mysqli_query($connection, $sql);

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $answers[] = $row;
        }
        return $answers;
    } else return $answers[] = "No answers";
}

function answers_list_for_user($userId)
{
    global $connection;
    $sql = "SELECT * FROM `odgovori` WHERE `user_id`=" . $userId;
    $result = mysqli_query($connection, $sql);

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $answers[] = $row;
        }
        return $answers;
    } else return $answers[] = "No answers";
}

function get_username_by_id($id)
{
    global $connection;
    $sql = "SELECT `username` FROM `user` WHERE `user_id`=" . $id;
    $result = mysqli_query($connection, $sql);

    if (mysqli_num_rows($result) == 1) {
        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $username[] = $row;
        }
        return $username;
    } else return $username[] = "ERROR";
}

function get_id_by_username($username)
{
    global $connection;
    $sql = "SELECT `user_id` FROM `user` WHERE `username`=" . $username;
    $result = mysqli_query($connection, $sql);

    if (mysqli_num_rows($result) == 1) {
        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $userId[] = $row;
        }
        return $userId;
    } else return $userId[] = "ERROR";
}

function correct_incorrect_question($id)
{
    global $connection;
    $sql = "SELECT `odgovor_id` FROM `odgovori` WHERE `odgovor`='a' AND `pitanje_id`=" . $id;
    $result = mysqli_query($connection, $sql);
    $answers['correct'] = mysqli_num_rows($result);

    $sql = "SELECT odgovor_id FROM `odgovori` WHERE `odgovor`!='a' AND `pitanje_id`=" . $id;
    $result = mysqli_query($connection, $sql);
    $answers['incorrect'] = mysqli_num_rows($result);

    return $answers;
}

function correct_incorrect_user($id)
{
    global $connection;
    $sql = "SELECT odgovor_id FROM `odgovori` WHERE `odgovor`='a' AND `user_id`=" . $id;
    $result = mysqli_query($connection, $sql);
    $answers['correct'] = mysqli_num_rows($result);;

    $sql = "SELECT odgovor_id FROM `odgovori` WHERE `odgovor`!='a' AND `user_id`=" . $id;
    $result = mysqli_query($connection, $sql);
    $answers['incorrect'] = mysqli_num_rows($result);;

    return $answers;
}

function difficulty_question($id)
{
    global $connection;
    $sql = "SELECT `odgovor_id` FROM `odgovori` WHERE `ocena`='Easy' AND `pitanje_id`=" . $id;
    $result = mysqli_query($connection, $sql);
    $answers['Easy'] = mysqli_num_rows($result);

    $sql = "SELECT `odgovor_id` FROM `odgovori` WHERE `ocena`='Medium' AND `pitanje_id`=" . $id;
    $result = mysqli_query($connection, $sql);
    $answers['Medium'] = mysqli_num_rows($result);

    $sql = "SELECT `odgovor_id` FROM `odgovori` WHERE `ocena`='Hard' AND `pitanje_id`=" . $id;
    $result = mysqli_query($connection, $sql);
    $answers['Hard'] = mysqli_num_rows($result);

    return $answers;
}

?>