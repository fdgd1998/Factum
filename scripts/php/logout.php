<?php
    session_start();
    if (!isset($_SESSION["loggedin"])) {
        header("Location: ".$_SERVER["DOCUMENT_ROOT"]."/login.php");
        exit();
    }

    session_unset();
    session_destroy();
    
    header("Location: ".$_SERVER["DOCUMENT_ROOT"]);
    exit();
?>