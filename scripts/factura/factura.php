<?php
    require_once "phpwkhtmltopdf/Command.php";
    require_once "phpwkhtmltopdf/Pdf.php"; 

    $pdf = new Pdf( array(
        'footer-font-name' => 'Quicksand',
        'footer-font-size' => 7,
        'footer-center' => 'Página  [page]  de  [topage]',
        'footer-spacing' => 5,
        'margin-bottom' => 20,
        'viewport-size' => '1920x1080'
    ));

    $pdf->AddPage(__DIR__."\\template.html");

    if (!$pdf->send()) {
        echo $pdf->getError();
    }
    
?>