<?php
    require_once $_SERVER["DOCUMENT_ROOT"]."/scripts/php/check_url_direct_access.php";
    checkUrlDirectAcces(realpath(__FILE__), realpath($_SERVER['SCRIPT_FILENAME']));
    require_once $_SERVER["DOCUMENT_ROOT"]."/scripts/php/db_functions.php";
    if (InsertIntoDb($_POST["table"], json_decode($_POST["columns"]), json_decode($_POST["values"])))
        echo "La base de datos se ha actualizado.";
    else 
        echo "Ha ocurrido un error actulizando la base de datos.";
?>