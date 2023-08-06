<?php
    function checkUrlDirectAcces($path, $path1) {
        if ( $_SERVER['REQUEST_METHOD']=='GET' && $path == $path1 ) {
            echo "No puedes acceder a este recurso.";
            exit();
        }
    }
?>