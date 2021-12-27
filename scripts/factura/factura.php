<?php
    require_once "phpwkhtmltopdf/Command.php";
    require_once "phpwkhtmltopdf/Pdf.php"; 

    $options = array(
        'footer-font-name' => 'Quicksand',
        'footer-font-size' => 7,
        'footer-center' => 'Página  [page]  de  [topage]',
        'footer-spacing' => 5,
        'margin-bottom' => 20,
        'viewport-size' => '1920x1080'
    );
    
    if ($_GET["action"] == "display") {
        $pdf = new Pdf($options);
        $pdf->AddPage("http://localhost/scripts/factura/template.php?numero=".$_GET["numero"]);
        if (!$pdf->send($_GET["numero"].".pdf", false, array('Content-Length' => false))) {
            echo $pdf->getError();
        }
    } else if ($_GET["action"] == "download") {
        require_once "../../classes/php/Database.php";
        $conn = new DatabaseConnection();
        $conn->Connect();
        $sql1 = "select * from facturas where fecha between '".$_GET["i"]."' and '".$_GET["f"]."'";
        $sql2 = "select * from facturasrec where fecha between '".$_GET["i"]."' and '".$_GET["f"]."'";
        $facturas = $conn->Select($sql1);
        $facturasrec = $conn->Select($sql2);
        echo var_dump($facturas);
        echo var_dump($facturasrec);
        
        if ($facturas) {
            foreach($facturas as $factura) {
                $pdf = new Pdf($options);
                $pdf->AddPage("http://localhost/scripts/factura/template.php?numero=".$factura["numero"]);
                if (!$pdf->saveAs(dirname(__DIR__, 2)."//temp/".$factura["numero"].".pdf")) {
                    echo $pdf->getError();
                }
            }
        }

        if ($facturasrec) {
            foreach($facturasrec as $factura) {
                $pdf = new Pdf($options);
                $pdf->AddPage("http://localhost/scripts/factura/template.php?numero=".$factura["numero"]);
                if (!$pdf->saveAs(dirname(__DIR__, 2)."//temp/".$factura["numero"].".pdf")) {
                    echo $pdf->getError();
                }
            }
        }
        
    }
    
?>