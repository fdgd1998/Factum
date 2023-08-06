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
    <link rel="stylesheet" href="./includes/css/responsive.bootstrap5.min.css">
</head>
<body>
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
    <script src="./includes/js/jquery-3.6.0.min.js"></script>
    <script src="./includes/js/bootstrap.min.js"></script>
    <script src="./includes/js/datatables.min.js"></script>
    <script src="./includes/js/select.bootstrap5.min.js"></script>
    <script src="./includes/js/dataTables.responsive.min.js"></script>

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
    <script src="./scripts/js/bill.js"></script>
    <script src="./includes/js/window-events.js"></script>
    <?php endif; ?>

    <?php if ($_GET["page"] == "new-bill-from-budget"): ?>
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