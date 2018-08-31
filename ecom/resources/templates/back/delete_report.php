<?php require_once("../../config.php");


if(isset($_GET['id'])){

$query = query_PDO("DELETE FROM reports WHERE report_id =" . $_GET['id'] . " ");
confirm($query);

set_message("Report Deleted");
redirect("../../../public/admin/index.php?reports");

}else{

redirect("../../../public/admin/index.php?reports");


}



?>