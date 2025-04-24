<?php
include_once __DIR__ . '/../model/pdo.php';

class concessions_services{
    public function __construct() {
    }

    public function ShowConcessionsAdmin(){
        $sql = "SELECT * FROM concessions Where hide =0 ORDER BY concession_id DESC";
        return pdo_query($sql);
    }
}
?>  