<?php
/**
 * Created by PhpStorm.
 * User: Davos
 * Date: 18-Dec-17
 * Time: 16:32
 */

require('db_config.php');
require('functions.php');
if (isset($_POST['user_id']) && !empty($_POST['user_id'])) {
    $answers = correct_incorrect_user($_POST['user_id']);
    $sum = (int)$answers['correct'] + $answers['incorrect'];
    $answers['success_rate'] = $sum == 0?0:$answers['correct']/$sum;
    if ($answers['success_rate'] != 0) {
        $answers['success_rate'] = number_format($answers['success_rate'], 2);
        $answers['success_rate'] *= 100;
    }

    echo json_encode($answers);
}
?>
