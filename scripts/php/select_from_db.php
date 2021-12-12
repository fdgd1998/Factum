<?php
    require_once "db_functions.php";
    echo json_encode(SelectFromDb($_POST["sql"]));
?>