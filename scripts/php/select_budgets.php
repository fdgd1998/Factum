<?php
 
/*
 * DataTables example server-side processing script.
 *
 * Please note that this script is intentionally extremely simple to show how
 * server-side processing can be implemented, and probably shouldn't be used as
 * the basis for a large complex system. It is suitable for simple use cases as
 * for learning.
 *
 * See http://datatables.net/usage/server-side for full details on the server-
 * side processing requirements of DataTables.
 *
 * @license MIT - http://datatables.net/license_mit
 */
 
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * Easy set variables
 */
 
require 'connection.php';

// DB table to use
$table = 'presupuestos';
 
// Table's primary key
$primaryKey = 'numero';
 
// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case object
// parameter names
$columns = array(
    array( 'db' => 'numero', 'dt' => 'id' ),
    array( 'db' => 'nif',  'dt' => 'nif' ),
    array( 'db' => 'fecha',     'dt' => 'fecha' ),
    array( 'db' => 'nombrecliente',     'dt' => 'name' ),
    array( 'db' => 'total',     'dt' => 'total' )
);
 
// SQL server connection information
$sql_details = array(
    'user' => $DB_USER,
    'pass' => $DB_PASSWD,
    'db'   => $DB_NAME,
    'host' => $DB_HOST
);
 
 
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * If you just want to use the basic configuration for DataTables with PHP
 * server-side, there is no need to edit below this line.
 */
 
require '../../classes/php/ssp.class.php';
 
echo json_encode(
    SSP::simple( $_POST, $sql_details, $table, $primaryKey, $columns )
);