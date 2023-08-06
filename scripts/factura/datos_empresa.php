<?php
    require_once $_SERVER["DOCUMENT_ROOT"]."/scripts/php/check_url_direct_access.php";
    checkUrlDirectAcces(realpath(__FILE__), realpath($_SERVER['SCRIPT_FILENAME']));
    $nombreEmpresa = "Nombre de la empresa";
    $nifEmpresa = "00000000X";
    $direccionEmpresa = "Calle Falsa, 123. 00000 Ciudad";
    $telefonoEmpresa = "+34 600 00 00 00";
    $emailEmpresa = "contacto@misitio.es";
    $webEmpresa = "misitio.es";
    $ibanEmpresa = "ES00 0000 0000 0000 0000";
?>