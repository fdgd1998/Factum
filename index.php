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
                    case "clients":
                        include "./pages/clients-manage.php";
                        break;
                    case "new-bill":
                        include "./pages/bill-new.php";
                        break;
                    case "bills":
                        include "./pages/bills-manage.php";
                        break;
                    case "budgets":
                        include "./pages/budgets-manage.php";
                        break;
                }
            }
        ?>
    </div>
    <script src="./includes/js/jquery-3.6.0.min.js"></script>
    <script src="./includes/js/bootstrap.min.js"></script>
    <script src="./includes/js/datatables.min.js"></script>
    <script src="./includes/js/select.bootstrap5.min.js"></script>

    <?php if (isset($_GET["page"])): ?>

    <?php if ($_GET["page"] == "new-client"): ?>
    <script src="./scripts/js/new-client.js"></script>
    <?php endif; ?>

    <?php if ($_GET["page"] == "clients"): ?>
    <script src="./scripts/js/manage-clients.js"></script>
    <script src="./scripts/js/datatables-events.js"></script>
    <?php endif; ?>

    <?php if ($_GET["page"] == "bills"): ?>
    <script src="./scripts/js/manage-bills.js"></script>
    <script src="./scripts/js/datatables-events.js"></script>
    <?php endif; ?>

    <?php if ($_GET["page"] == "new-bill"): ?>
    <script src="./scripts/js/datatables-events-bill-new.js"></script>
    <script src="./classes/js/BillConcept.js"></script>
    <script src="./scripts/js/new-bill.js"></script>
    <?php endif; ?>

    <?php if ($_GET["page"] == "budgets"): ?>
    <script src="./scripts/js/manage-budgets.js"></script>
    <script src="./scripts/js/datatables-events.js"></script>
    <?php endif; ?>

    <?php endif; ?>
</body>
</html>