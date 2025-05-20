<?php
include_once __DIR__ . '/../model/pdo.php';

class concessions_services{
    public function __construct() {
    }

    public function ShowConcessionsAdmin(){
        $sql = "SELECT * FROM concessions ORDER BY concession_id DESC";
        return pdo_query($sql);
    }

    public function ShowConcessions(){
        $sql = "SELECT * FROM concessions WHERE hide=0 ORDER BY concession_id DESC";
        return pdo_query($sql);
    }

    public function GetConcessionByID($ConcessionID){
        $sql = "SELECT * FROM concessions WHERE concession_id=?";
        return pdo_query_one($sql,$ConcessionID);
    }
}
?>  