<?php require_once("../../config.php");
require_once("../../cart.php"); 


if(isset($_SESSION['item_quantity']) && $_SESSION['item_quantity']){

set_message("ITEM IS IN SOMEONE ELSES CHECKOUT");
redirect("../../../public/admin/index.php?products");
} 
else{
if(isset($_GET['id'])){
$query = query_PDO("DELETE FROM products WHERE product_id =" . $_GET['id'] . " ");
confirm($query);

set_message("Product Deleted");

redirect("../../../public/admin/index.php?products");

}
}



?>