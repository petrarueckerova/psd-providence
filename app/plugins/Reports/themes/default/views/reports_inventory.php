<?php
//serve link to inventory_dl from ServiceHandler
require_once(__CA_APP_DIR__ . "/plugins/Reports/models/functions.php");

echo '<a href="' . __CA_URL_ROOT__ . '/service.php/Reports/Service/inventory_dl" >Inventarliste herunterladen</a><br><br>
       <a href="' . __CA_URL_ROOT__ . '/service.php/Reports/Service/inventory_dl_readable" >maschinenlesbare Version</a> ';


?>

