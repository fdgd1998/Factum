<?php
    require_once "db_functions.php";
    if (InsertIntoDb($_POST["table"], json_decode($_POST["columns"]), json_decode($_POST["values"])))
        echo "La base de datos se ha actualizado.";
    else 
        echo "Ha ocurrido un error actulizando la base de datos.";
?>