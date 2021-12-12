<?php
    require_once "db_functions.php";
    if (DbTransaction(json_decode($_POST["sql"])))
        echo "La base de datos se ha actualizado.";
    else 
        echo "Ha ocurrido un error actulizando la base de datos.";
?>