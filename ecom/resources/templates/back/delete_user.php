<?php require_once("../../config.php");


if(isset($_GET['id'])){

$query = query_PDO("DELETE FROM users WHERE user_id =" . $_GET['id'] . " ");
confirm($query);

set_message("User Deleted");
redirect("../../../public/admin/index.php?users");

}else{

redirect("../../../public/admin/index.php?users");


}



?>