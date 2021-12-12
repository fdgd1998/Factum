<?php
    require_once "db_functions.php";
    if (UpdateDb($_POST["table"], json_decode($_POST["data"]), json_decode($_POST["where"])))
        echo "La base de datos se ha actualizado.";
    else 
        echo "Ha ocurrido un error actulizando la base de datos.";
?>