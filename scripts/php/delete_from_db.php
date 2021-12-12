<?php
    require_once "db_functions.php";
    if (DeleteFromDb($_POST["table"], $_POST["cell"], $_POST["value"]))
        echo "La base de datos se ha actualizado.";
    else 
        echo "Ha ocurrido un error actulizando la base de datos.";
?>