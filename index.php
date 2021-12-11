<?php
    header("Cache-Control: no-store, no-cache, private, must-revalidate, max-age=0");
    header("Pragma: no-cache");
    header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // A date in the past
    header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Factum - ViGal Artesana</title>
    <link rel="stylesheet" href="./includes/css/bootstrap.min.css">
    <link rel="stylesheet" href="./includes/css/bootstrap-icons.css">
    <link rel="stylesheet" href="./includes/css/styles.css">
    <link rel="stylesheet" href="./includes/css/datatables.min.css">
    <link rel="stylesheet" href="./includes/css/select.bootstrap5.min.css">
</head>
<body>
    <?php
        include "includes/header.php";
    ?>
    <div id="main" class="container">
        <?php
            if (isset($_GET["page"])) {
                switch ($_GET["page"]) {
                    case "new-client":
                        include "./pages/client-new.php";
                        break;
                    case "edit-client":
                        include "./pages/client-new.php";
                        break;
                    case "clients":
                        include "./pages/clients-manage.php";
                        break;
                    case "new-bill":
                        include "./pages/bill-new.php";
                        break;
                    case "rectify-bill":
                        include "./pages/bill-new.php";
                        break;
                    case "view-bill":
                        include "./pages/bill-new.php";
                        break;
                    case "new-budget":
                        include "./pages/bill-new.php";
                        break;
                    case "edit-budget":
                        include "./pages/bill-new.php";
                        break;
                    case "bills":
                        include "./pages/bills-manage.php";
                        break;
                    case "rbills":
                        include "./pages/bills-manage.php";
                        break;
                    case "budgets":
                        include "./pages/budgets-manage.php";
                        break;
                }
            } else {
                include "./pages/clients-manage.php";
                $_GET["page"] = "clients";
            }
        ?>
    </div>
    <script src="./includes/js/jquery-3.6.0.min.js"></script>
    <script src="./includes/js/bootstrap.min.js"></script>
    <script src="./includes/js/datatables.min.js"></script>
    <script src="./includes/js/select.bootstrap5.min.js"></script>

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
    <script src="./scripts/js/datatables-events-bills.js"></script>
    <?php endif; ?>

    <?php if ($_GET["page"] == "rbills"): ?>
    <script src="./scripts/js/manage-bills.js"></script>
    <script src="./scripts/js/datatables-events-rbills.js"></script>
    <?php endif; ?>

    <?php if ($_GET["page"] == "new-bill" || $_GET["page"] == "new-bill" || $_GET["page"] == "new-budget" || $_GET["page"] == "edit-budget" || $_GET["page"] == "rectify-bill"): ?>
    <script src="./scripts/js/datatables-events-bill-new.js"></script>
    <script src="./classes/js/BillConcept.js"></script>
    <script src="./scripts/js/bill.js"></script>
    <?php endif; ?>

    <?php if ($_GET["page"] == "view-bill"): ?>
    <script src="./scripts/js/bill.js"></script>
    <?php endif; ?>

    <?php if ($_GET["page"] == "budgets"): ?>
    <script src="./scripts/js/manage-budgets.js"></script>
    <script src="./scripts/js/datatables-events-budgets.js"></script>
    <?php endif; ?>

    <?php endif; ?>
    <script>
window.addEventListener('popstate', function(event) {
    // The popstate event is fired each time when the current history entry changes.

    var r = confirm("You pressed a Back button! Are you sure?!");

    if (r == true) {
        // Call Back button programmatically as per user confirmation.
        history.back();
        // Uncomment below line to redirect to the previous page instead.
        // window.location = document.referrer // Note: IE11 is not supporting this.
    } else {
        // Stay on the current page.
        history.pushState(null, null, window.location.pathname);
    }

    history.pushState(null, null, window.location.pathname);

}, false);
    </script>
</body>
</html>