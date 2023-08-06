<?php
    session_start();
    if (!isset($_SESSION["loggedin"])) {
        header("Location: login.php");
        exit();
    }
    require_once $_SERVER["DOCUMENT_ROOT"]."/scripts/factura/phpwkhtmltopdf/Command.php";
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

        if (isset($_GET["archivo"]) && $_GET["archivo"] == "si") $pdf->AddPage("http://localhost/scripts/factura/template.php?numero=".$_GET["numero"]."&archivo=si");
        else $pdf->AddPage("http://localhost/scripts/factura/template.php?numero=".$_GET["numero"]);

        if (!$pdf->send(null, false, array('Content-Length' => false))) {
            echo $pdf->getError();
        }
    } else if ($_GET["action"] == "download") {
        require_once "../../classes/php/Database.php";
        $conn = new DatabaseConnection();
        $conn->Connect();
        
        $facturas = $conn->Select("select * from facturas where fecha between '".$_GET["i"]."' and '".$_GET["f"]."'");
        $facturasrec = $conn->Select("select * from facturasrec where fecha between '".$_GET["i"]."' and '".$_GET["f"]."'");

        // Enter the name of directory 
        $pathdir = dirname(__DIR__, 2)."\\temp\\";
    
        $files = glob($pathdir.'*'); // get all file names
        foreach($files as $file){ // iterate files
            if(is_file($file)) {
                unlink($file); // delete file
            }
        }

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
                if (!$pdf->saveAs($pathdir.$factura["numero"].".pdf")) {
                    echo $pdf->getError();
                }
            }
        }

        // Enter the name to creating zipped directory 
        $zipcreated = "facturas.zip";

        // Create new zip class 
        $zip = new ZipArchive; 

        $total_bills = 0;

        if($zip -> open($pathdir.$zipcreated, ZipArchive::CREATE ) === TRUE) { 
            // Store the path into the variable 
            $dir = opendir($pathdir); 
            while($file = readdir($dir)) { 
                
                if(is_file($pathdir.$file)) {
                    $total_bills++;
                    $zip -> addFile($pathdir.$file, $file); 
                } 
            } 
            $zip ->close(); 
        }

        if ($total_bills == 0) {
            echo "<script>
                alert('No hay facturas para descargar en el rango seleccionado.');
                window.location.href = 'http://localhost?page=bill-options';
            </script>";
            exit();
        }

        // or however you get the path
        $yourfile = $pathdir."facturas.zip";

        $file_name = basename($yourfile);

        header("Content-Type: application/zip");
        header("Content-Disposition: attachment; filename=$file_name");
        header("Content-Length: " . filesize($yourfile));

        ob_end_clean();
        readfile($yourfile);
        exit;
    }
    
?>