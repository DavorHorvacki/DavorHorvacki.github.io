<?php
/**
 * Created by PhpStorm.
 * User: Davos
 * Date: 09-Dec-17
 * Time: 12:49
 */
session_start();
require('db_config.php');
require('functions.php');


if (isset($_POST['data']) && !empty($_POST['data'])) {
    if(isset($_SESSION['admin']) && !empty($_SESSION['admin'])) {
        $adminId = $_SESSION['admin'];
    } elseif (isset($_POST['admin_id']) && !empty($_POST['admin_id'])) {
        $adminId = $_POST['admin_id'];
    }

    $dataType = $_POST['data'];
    $sql = "SELECT  `username` FROM  `user` WHERE  `admin`=1 AND  `user_id`=" . $adminId;
    $result = mysqli_query($connection, $sql);

    if (mysqli_num_rows($result) > 0) {

        switch (trim($dataType)) {
            case "user list":
                echo json_encode(user_list());
                break;
            case "questions list":
                echo json_encode(question_list());
                break;
            case "change question":
                if (isset($_POST['question_id']) && isset($_POST['question']) && isset($_POST['a']) &&
                    isset($_POST['b']) && isset($_POST['c']) && isset($_POST['d'])
                ) {

                    if (!empty($_POST['question_id']) && !empty($_POST['question']) && !empty($_POST['a']) &&
                        !empty($_POST['b']) && !empty($_POST['c']) && !empty($_POST['d'])
                    ) {
                        echo change_question($_POST['question_id'], $_POST['question'], $_POST['a'], $_POST['b'], $_POST['c'], $_POST['d']);
                    }
                } else '{"status": "unsuccessful"}';
                break;
            case "answers list":
                echo json_encode(answers_list());
                break;
            case "answers list for user":
                if (isset($_POST['user_id']) && !empty($_POST['user_id'])) {
                    echo json_encode(answers_list_for_user($_POST['user_id']));
                }
                break;
            case "username by id":
                if (isset($_POST['user_id']) && !empty($_POST['user_id'])) {
                    echo json_encode(get_username_by_id($_POST['user_id']));
                }
                break;
            case "id by username":
                if (isset($_POST['username']) && !empty($_POST['username'])) {
                    echo json_encode(get_id_by_username($_POST['username']));
                }
                break;
            case "correct incorrect for question":
                if (isset($_POST['question_id']) && !empty($_POST['question_id'])) {
                    echo json_encode(correct_incorrect_question($_POST['question_id']));
                }
                break;
            case "correct incorrect for user":
                if (isset($_POST['user_id']) && !empty($_POST['user_id'])) {
                    echo json_encode(correct_incorrect_user($_POST['user_id']));
                }
                break;
            case "difficulty stats for question":
                if (isset($_POST['question_id']) && !empty($_POST['question_id'])) {
                    echo json_encode(difficulty_question($_POST['question_id']));
                }
                break;
        }

    } else echo create_json_response('unsuccessful', 'You must be logged in as admin');
}

?>
