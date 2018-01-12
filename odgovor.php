<?php
/**
 * Created by PhpStorm.
 * User: Davos
 * Date: 19-Nov-17
 * Time: 15:02
 */

require("db_config.php");
require("functions.php");

if(isset($_POST["user_id"]) && isset($_POST["pitanje_id"]) && isset($_POST["odgovor"]) && isset($_POST['ocena'])) {

    $userId = $_POST['user_id'];
    $pitanjeId = $_POST['pitanje_id'];
    $odgovor = $_POST['odgovor'];
    $ocena = $_POST['ocena'];

    if(!empty($userId) && !empty($pitanjeId) && !empty($odgovor) && !empty($ocena)) {
        if($odgovor == "a" || $odgovor == "b" || $odgovor == "c" || $odgovor == "d") {
            if ($ocena == "Easy" || $ocena == "Medium" || $ocena == "Hard") {

                $sql = "INSERT INTO odgovori(odgovor_id,user_id,pitanje_id,odgovor,ocena) VALUES (NULL ,'$userId','$pitanjeId','$odgovor', '$ocena')";
                if ($result = mysqli_query($connection, $sql)) {
                    echo create_json_response('succesful', 'Odgovor je prihvacen');
                } else {
                    echo create_json_response('unsuccesful', 'Doslo je do greske');
                }

            } else echo create_json_response('unsuccesful', 'Ocena nije ispravna');
        } else echo create_json_response('unsuccesful', 'Odgovor nije ispravan');
    }else echo create_json_response('unsuccesful', 'Neka polja nisu popunjena');

}else echo create_json_response('unsuccesful', 'Neka polja nisu popunjena');