<?php
    require_once $_SERVER["DOCUMENT_ROOT"]."/scripts/php/check_url_direct_access.php";
    checkUrlDirectAcces(realpath(__FILE__), realpath($_SERVER['SCRIPT_FILENAME']));
    function GetDataForTable($sql) {
        require_once $_SERVER["DOCUMENT_ROOT"]."/classes/php/Database.php";

        $output = array();
        $output["draw"] = 0;

        $conn = new DatabaseConnection();
        if ($conn->Connect()) {
            $res = $conn->Select($sql);

            if ($conn->GetNumRows() > 0) {
                $output["recordsTotal"] = $conn->GetNumRows();
                $output["recordsFiltered"] = $conn->GetNumRows();

                $aux = [];

                foreach ($res as $key => $value) {
                    $aux[$key] = $value;
                }

                $output["data"] = $aux;
            } else {
                $output["recordsTotal"] = 0;
                $output["recordsFiltered"] = 0;
                $output["data"] = [];
            }
        } 

        $conn->Close();
        unset($conn);
        return $output;
    }

    echo json_encode(GetDataForTable($_POST["sql"]));
?>