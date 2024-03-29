<?php
    error_reporting(0);
    session_start();
    header("Cache-Control: no-store, no-cache, private, must-revalidate, max-age=0");
    header("Pragma: no-cache");
    header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // A date in the past
    header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");

    if (!isset($_SESSION["loggedin"])) {
        header("Location: login.php");
        exit();
    }

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Factum - ViGal Boutique</title>
    <link rel="stylesheet" href="./includes/css/bootstrap.min.css">
    <link rel="stylesheet" href="./includes/css/bootstrap-icons.css">
    <link rel="stylesheet" href="./includes/css/styles.css">
    <link rel="stylesheet" href="./includes/css/datatables.min.css">
    <link rel="stylesheet" href="./includes/css/select.bootstrap5.min.css">
    <link rel="stylesheet" href="./includes/css/responsive.bootstrap.min.css">
    
</head>
<body>
    <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
    <symbol id="check-circle-fill" fill="currentColor" viewBox="0 0 16 16">
        <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
    </symbol>
    <symbol id="info-fill" fill="currentColor" viewBox="0 0 16 16">
        <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
    </symbol>
    <symbol id="exclamation-triangle-fill" fill="currentColor" viewBox="0 0 16 16">
        <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
    </symbol>
    </svg>
    <script src="./includes/js/jquery-3.6.0.min.js"></script>
    <script src="./includes/js/bootstrap.min.js"></script>
    <script src="./includes/js/datatables.min.js"></script>
    <script src="./includes/js/select.bootstrap5.min.js"></script>
    <script src="./includes/js/dataTables.responsive.min.js"></script>
    <script src="./scripts/js/banner.js"></script>
    <?php if ($_GET["page"] == "new-bill" || $_GET["page"] == "edit-bill" || $_GET["page"] == "new-bill-from-budget" || $_GET["page"] == "new-budget" || $_GET["page"] == "edit-budget" || $_GET["page"] == "rectify-bill"): ?>
    <script src="./scripts/js/bill.js"></script>
    <script>console.log("tiene iva: "+tiene_iva)</script>
    <?php endif; ?>

    <?php
        include $_SERVER["DOCUMENT_ROOT"]."/includes/header.php";
    ?>
    <div id="main" class="container">
        <?php
            if (isset($_GET["page"])) {
                switch ($_GET["page"]) {
                    case "new-client":
                        include $_SERVER["DOCUMENT_ROOT"]."/pages/client-new.php";
                        break;
                    case "edit-client":
                        include $_SERVER["DOCUMENT_ROOT"]."/pages/client-new.php";
                        break;
                    case "clients":
                        include $_SERVER["DOCUMENT_ROOT"]."/pages/clients-manage.php";
                        break;
                    case "new-bill":
                        include $_SERVER["DOCUMENT_ROOT"]."/pages/bill-new.php";
                        break;
                    case "new-bill-from-budget":
                        include $_SERVER["DOCUMENT_ROOT"]."/pages/bill-new.php";
                        break;
                    case "rectify-bill":
                        include $_SERVER["DOCUMENT_ROOT"]."/pages/bill-new.php";
                        break;
                    case "view-bill":
                        include $_SERVER["DOCUMENT_ROOT"]."/pages/bill-new.php";
                        break;
                    case "new-budget":
                        include $_SERVER["DOCUMENT_ROOT"]."/pages/bill-new.php";
                        break;
                    case "edit-budget":
                        include $_SERVER["DOCUMENT_ROOT"]."/pages/bill-new.php";
                        break;
                    case "edit-bill":
                        include $_SERVER["DOCUMENT_ROOT"]."/pages/bill-new.php";
                        break;
                    case "bills":
                        include $_SERVER["DOCUMENT_ROOT"]."/pages/bills-manage.php";
                        break;
                    case "rbills":
                        include $_SERVER["DOCUMENT_ROOT"]."/pages/bills-manage.php";
                        break;
                    case "bill-options":
                        include $_SERVER["DOCUMENT_ROOT"]."/pages/bill-options.php";
                        break;
                    case "budgets":
                        include $_SERVER["DOCUMENT_ROOT"]."/pages/budgets-manage.php";
                        break;
                    case "archive":
                        include $_SERVER["DOCUMENT_ROOT"]."/pages/bills-manage.php";
                        break;
                }
            } else {
                include $_SERVER["DOCUMENT_ROOT"]."/pages/clients-manage.php";
                $_GET["page"] = "clients";
            }
        ?>
    </div>
    

    <?php if (isset($_GET["page"])): ?>

    <?php if ($_GET["page"] == "new-client" || $_GET["page"] == "edit-client"): ?>
    <script src="./scripts/js/form-values-validator.js"></script>
    <script src="./scripts/js/new-client.js"></script>
    <?php endif; ?>

    <?php if ($_GET["page"] == "clients"): ?>
    <script src="./scripts/js/manage-clients.js"></script>
    <script src="./scripts/js/datatables-events-clients.js"></script>
    <?php endif; ?>

    <?php if ($_GET["page"] == "bills"): ?>
    <script src="./scripts/js/manage-bills.js"></script>
    <script src="./scripts/js/button-events.js"></script>
    <script src="./scripts/js/datatables-events-bills.js"></script>
    <script src="./scripts/js/dTable-render-functions.js"></script>
    <?php endif; ?>

    <?php if ($_GET["page"] == "rbills"): ?>
    <script src="./scripts/js/manage-bills.js"></script>
    <script src="./scripts/js/button-events.js"></script>
    <script src="./scripts/js/datatables-events-rbills.js"></script>
    <script src="./scripts/js/dTable-render-functions.js"></script>
    <?php endif; ?>

    <?php if ($_GET["page"] == "archive"): ?>
    <script src="./scripts/js/manage-bills.js"></script>
    <script src="./scripts/js/button-events.js"></script>
    <script src="./scripts/js/datatables-events-archive.js"></script>
    <script src="./scripts/js/dTable-render-functions.js"></script>
    <?php endif; ?>

    <?php if ($_GET["page"] == "new-bill" || $_GET["page"] == "edit-bill" || $_GET["page"] == "new-bill-from-budget" || $_GET["page"] == "new-budget" || $_GET["page"] == "edit-budget" || $_GET["page"] == "rectify-bill"): ?>
    <script src="./scripts/js/button-events.js"></script>
    <script src="./scripts/js/datatables-events-bill-new.js"></script>
    <script src="./scripts/js/dTable-render-functions.js"></script>
    <script src="./classes/js/BillConcept.js"></script>
    <script src="./includes/js/window-events.js"></script>
    <?php endif; ?>

    <?php if ($_GET["page"] == "new-bill-from-budget" || $_GET["page"] == "new-bill"): ?>
        <script>tiene_iva = 1;</script>
        <script>console.log("tiene iva: "+tiene_iva);</script>
    <?php endif; ?>

    <?php if ($_GET["page"] == "view-bill"): ?>
    <script src="./scripts/js/bill.js"></script>
    <?php endif; ?>

    <?php if ($_GET["page"] == "bill-options"): ?>
    <script src="./scripts/js/bill-options.js"></script>
    <?php endif; ?>

    <?php if ($_GET["page"] == "budgets"): ?>
    <script src="./scripts/js/manage-budgets.js"></script>
    <script src="./scripts/js/button-events.js"></script>
    <script src="./scripts/js/datatables-events-budgets.js"></script>
    <script src="./scripts/js/dTable-render-functions.js"></script>

    <?php endif; ?>

    <?php endif; ?>
</body>
</html>