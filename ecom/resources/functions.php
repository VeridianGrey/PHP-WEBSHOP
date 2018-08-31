<?php

$upload_directory = "uploads";

// helper functions

function last_id(){

    global $connection;

    return $connection -> lastInsertId();

}

function set_message($msg){

if(!empty($msg)){

    $_SESSION['message'] = $msg;

}else {

$msg = "";


}

}


function display_message(){

if(isset($_SESSION['message'])){

    echo $_SESSION['message'];
    unset($_SESSION['message']);

}

}


function redirect($location){


header("Location: $location ");


}

function query_PDO($sql) {

global $connection;

return $connection -> query($sql);
}

function confirm($result){
	global $connection;

if(!$result){

	die("QUERY FAILED" . $e->getMessage($connection));

			}
}
function fetch_array($result){


return $result->fetch(PDO::FETCH_ASSOC);

}


/***************************FRONT END FUNCTIONS************************************/

function display_cat_in_cat_page(){
             $id = $_GET['id'];
            $query = query_PDO("SELECT * FROM `categories` WHERE cat_id = $id");
            confirm($query);

             while ($row = fetch_array($query)) {
                    echo $row['cat_title'];
             }
}

function search_bar(){
    if(isset($_POST['submit'])){
                
            $search = $_POST['search'];
                
                
            $query = query_PDO("SELECT * FROM products WHERE product_tags LIKE '%$search%' ");

            confirm($query);

            if(!$query) {

                die("QUERY FAILED");
            }

            $count = fetch_array($query);
            

            if($count == 0) {

                echo "<h1> NO RESULT</h1>";

            } else {

                while($row = fetch_array($query)) {
                    $product_title = $row['product_title'];
                    $product_category_id= $row['product_category_id'];
                    $product_price = $row['product_price'];
                    $product_quantity = $row['product_quantity'];
                    $product_description = $row['product_description'];
                    $product_image= $row['product_image'];
                    $product_description = $row['product_description'];
                    $product_tags = $row['product_tags'];
                    $short_desc= $row['short_desc'];

            }
            }
    }
}

function display_orders(){

$query = query_PDO("SELECT * FROM orders");
confirm($query);

while($row = fetch_array($query)){

$orders = <<<DELIMETER

<tr>
    <td>{$row['order_id']}</td>
    <td>{$row['order_amount']}</td>
    <td>{$row['order_transaction']}</td>
    <td>{$row['order_currency']}</td>
    <td>{$row['order_status']}</td>
    <td><a class="btn btn-danger" href="../../resources/templates/back/delete_order.php?id={$row['order_id']}"><span class="glyphicon glyphicon-remove"></span></a></td>
</tr>



DELIMETER;

echo $orders;
}
}



/********************* Admin Products ********************/

function findAllCategories(){
global $connection;

$query = "SELECT * FROM categories";
$select_categories = query_PDO($query);      


while($row = fetch_array($select_categories))
{
$cat_id = $row['cat_id'];
$cat_title = $row['cat_title'];

echo "<tr>";
echo "<td>{$cat_id}</td>";
echo "<td>{$cat_title}</td>";
echo "<td><a href='index.php?categories&delete={$cat_id}'>Delete</a></td>";
echo "<td><a href='index.php?categories&edit={$cat_id}'>Edit</a></td>";
echo "</tr>";
}
 
}

function delete_categories() {
 
if(isset($_GET['delete'])){

$the_cat_id = $_GET['delete'];

$query = "DELETE FROM categories WHERE cat_id = {$the_cat_id}";

$delete_query = query_PDO($query);

confirm($delete_query);
header("Location: index.php?categories");

}                                                                       
 
}

 

function insert_categories(){
 
          global $connection;
  
          if(isset($_POST['submit'])){
          
          $cat_title = $_POST['cat_title'];
           
           if($cat_title == "" || empty($cat_title)) {
             
            echo "This field should not be empty";
            
           }else{
            
            $query = "INSERT INTO categories(cat_title) ";
            $query .= "VALUE('{$cat_title}')";
            
            $create_category_query = query_PDO($query);
            
            if(!$create_category_query){
             
             die('QUERY FAILED');   
            }
           }
         }
}

function display_image($picture){

global $upload_directory;

return $upload_directory . DS . $picture;

}



function get_products_in_admin(){

$query = query_PDO("SELECT * FROM products");

confirm($query);

while($row = fetch_array($query)){

$category = show_product_category_title($row['product_category_id']);

$product_image = display_image($row['product_image']);

$product = <<<DELIMETER

    <tr>
        <td>{$row['product_id']}</td>
        <td>{$row['product_title']}<br>
    <a href="index.php?edit_product&id={$row['product_id']}"><img width="100" src="../../resources/{$product_image}" alt=""></a>
        </td>
        <td>{$category}</td>
        <td>{$row['product_price']}</td>
        <td>{$row['product_quantity']}</td>
        <td><a class="btn btn-danger" href="../../public/admin/index.php?edit_product&id={$row['product_id']}"><span class="glyphicon glyphicon-pencil"></span></a>
        <a class="btn btn-danger" href="../../resources/templates/back/delete_product.php?id={$row['product_id']}"><span class="glyphicon glyphicon-remove"></span></a></td>
    </tr>

DELIMETER;

echo $product;

}


}


function show_product_category_title($product_category_id){

$category_query = query_PDO("SELECT * FROM categories WHERE cat_id = '{$product_category_id}' ");
confirm($category_query);

while($category_row = fetch_array($category_query)) {

return $category_row['cat_title'];

}

}



/************************* Add products in admin ********************/

function add_product(){

if(isset($_POST['publish'])){

$product_title        =     $_POST['product_title'];
$product_description  =     $_POST['product_description'];
$product_price        =     $_POST['product_price'];
$product_category_id  =     $_POST['product_category_id'];
$short_desc     =           $_POST['short_desc'];
$product_quantity    =      $_POST['product_quantity'];
$product_tags       =       $_POST['product_tags'];
$product_image  =           $_FILES['file']['name'];
$image_temp_location =$_FILES['file']['tmp_name'];


move_uploaded_file($image_temp_location , UPLOAD_DIRECTORY . DS . $product_image);

$check_rows = query_PDO("SELECT * FROM products WHERE product_title LIKE '%$product_title%' ");
 
confirm($check_rows);

$count = fetch_array($check_rows);


if($count > 0){

echo "THIS ITEM ALLREADY EXISTS";

}else{

$query = query_PDO("INSERT INTO products(product_title, product_category_id, product_price, product_description, short_desc, product_quantity, product_tags, product_image) VALUES('{$product_title}', '{$product_category_id}', '{$product_price}', '{$product_description}', '{$short_desc}', '{$product_quantity}', '{$product_tags}', '{$product_image}')");


confirm($query);

$last_id = last_id();
set_message("New Product with id {$last_id} Just Added");

redirect("index.php?products");

}


}

}

function show_categories_add_product_page(){

$query = query_PDO("SELECT * FROM categories");
confirm($query);

while ($row = fetch_array($query)) {

$categories_options = <<<DELIMETER

<option value="{$row['cat_id']}">{$row['cat_title']}</option>

DELIMETER;


echo $categories_options;
}       
}


/*********************************updating product code *************************/

function update_product(){

if(isset($_POST['update'])){

$product_title     = $_POST['product_title'];
$product_description      = $_POST['product_description'];
$product_price     =    $_POST['product_price'];
$product_category_id =  $_POST['product_category_id'];
$short_desc     =       $_POST['short_desc'];
$product_quantity   =   $_POST['product_quantity'];
$product_tags       =   $_POST['product_tags'];
$product_image  =       $_FILES['file']['name'];
$image_temp_location =  $_FILES['file']['tmp_name'];

if(empty($product_image)){

$get_pic = query_PDO("SELECT product_image FROM products WHERE product_id =" .$_GET['id']. "");
confirm($get_pic);

while ($pic = fetch_array($get_pic)) {

$product_image = $pic['product_image'];
}
}
if($product_category_id == 0){
    
$get_cat = query_PDO("SELECT product_category_id FROM products WHERE product_id =" .$_GET['id']. "");
confirm($get_cat);

while ($pic = fetch_array($get_cat)) {

$product_category_id = $pic['product_category_id'];
}

}

move_uploaded_file($image_temp_location , UPLOAD_DIRECTORY . DS . $product_image);



$query = "UPDATE products SET ";
$query .= "product_title        = '{$product_title}'        , ";
$query .= "product_category_id  = '{$product_category_id}'  , ";
$query .= "product_price        = '{$product_price}'        , ";
$query .= "product_description  = '{$product_description}'  , ";
$query .= "short_desc           = '{$short_desc}'           , "; 
$query .= "product_quantity     = '{$product_quantity}'     , "; 
$query .= "product_tags         = '{$product_tags}'         , ";
$query .= "product_image        = '{$product_image}'          ";
$query .= "WHERE product_id=" .  $_GET['id'];

query_PDO($query);

confirm($query);
set_message("Product has been updated");

redirect("index.php?products");

}

}



// get products
function get_products_index(){

$query = query_PDO("SELECT * FROM products ORDER BY product_id DESC");

confirm($query);

while($row = fetch_array($query)){


$product_image = display_image($row['product_image']);

$product = <<<DELIMETER

<div class="col-sm-4 col-lg-4 col-md-4">
        <div class="thumbnail">
            <a href="item.php?id={$row['product_id']}"><img src="../resources/{$product_image}" alt=""></a>
            <div class="caption">
                <h4 class="pull-right">&#8364;{$row['product_price']}</h4>
                <h4><a href="item.php?id={$row['product_id']}">{$row['product_title']}</a>
                </h4>
                <a class="btn btn-primary" target="_blank" href="../resources/cart.php?add={$row['product_id']}">Add to cart</a>
            </div>
        </div>
    </div>

DELIMETER;

echo $product;

}

}

function get_products(){

$query = query_PDO("SELECT * FROM products ORDER BY product_id DESC");

confirm($query);

while($row = fetch_array($query)){


$product_image = display_image($row['product_image']);

$product = <<<DELIMETER

<div class="col-sm-4 col-lg-4 col-md-4">
        <div class="thumbnail">
            <a href="item.php?id={$row['product_id']}"><img src="../resources/{$product_image}" alt=""></a>
            <div class="caption">
                <h4 class="pull-right">&#8364;{$row['product_price']}</h4>
                <h4><a href="item.php?id={$row['product_id']}">{$row['product_title']}</a>
                </h4>
                <h4> {$row['product_description']} </h4>
                <a class="btn btn-primary" target="_blank" href="../resources/cart.php?add={$row['product_id']}">Add to cart</a>
            </div>
        </div>
    </div>

DELIMETER;

echo $product;

}

}

function get_categories(){

$query = query_PDO("SELECT * FROM categories");
confirm($query);

while ($row = fetch_array($query)) {

$categories_links = <<<DELIMETER

<a href='category.php?id={$row['cat_id']}' class='list-group-item'>{$row['cat_title']}</a>

DELIMETER;


echo $categories_links;
}		
}


function get_products_in_cat_page(){

$query = query_PDO("SELECT * FROM products WHERE product_category_id =" . ($_GET['id']) . " ");

confirm($query);

while($row = fetch_array($query)){

$product_image = display_image($row['product_image']);

$product = <<<DELIMETER

<div class="col-md-3 col-sm-6 hero-feature">
                <div class="thumbnail">
                    <img src="../resources/{$product_image}" alt="">
                    <div class="caption">
                        <h3>{$row['product_title']}</h3>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
                        <p>
                            <a href="../resources/cart.php?add={$row['product_id']}" class="btn btn-primary">Buy Now!</a> <a href="item.php?id={$row['product_id']}" class="btn btn-default">More Info</a>
                        </p>
                    </div>
                </div>
            </div>

DELIMETER;

echo $product;

}

}


function get_products_in_shop_page(){

$query = query_PDO("SELECT * FROM products");

confirm($query);

while($row = fetch_array($query)){

$product_image = display_image($row['product_image']);

$product = <<<DELIMETER

<div class="col-md-3 col-sm-6 hero-feature">
                <div class="thumbnail">
                    <img src="../resources/{$product_image}" alt="">
                    <div class="caption">
                        <h3>{$row['product_title']}</h3>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
                        <p>
                            <a href="../resources/cart.php?add={$row['product_id']}" class="btn btn-primary">Buy Now!</a> <a href="item.php?id={$row['product_id']}" class="btn btn-default">More Info</a>
                        </p>
                    </div>
                </div>
            </div>

DELIMETER;

echo $product;

}

}


function get_shop_slide(){

$query = query_PDO("SELECT * FROM slider");
confirm($query);

while ($row = fetch_array($query)) {

$shop_image = <<<DELIMETER

<img class = "img-responsive" src="{$row['slider_image']}" alt="">

DELIMETER;


echo $shop_image;
}       
}


function get_reports(){

$query = query_PDO("SELECT * FROM reports");

confirm($query);

while($row = fetch_array($query)){


$report = <<<DELIMETER

    <tr>
        <td>{$row['report_id']}</td>
        <td>{$row['product_id']}</td>
        <td>{$row['order_id']}</td>
        <td>{$row['product_price']}</td>
        <td>{$row['product_title']}<br>
        <td>{$row['product_quantity']}</td>
        <td><a class="btn btn-danger" href="../../resources/templates/back/delete_report.php?id={$row['report_id']}"><span class="glyphicon glyphicon-remove"></span></a></td>
    </tr>

DELIMETER;

echo $report;

}


}

function login_user(){

if(isset($_POST['submit'])){

$username = $_POST['username'];
$password = $_POST['password'];


$query = query_PDO("SELECT * FROM users WHERE username = '{$username}' AND password = '{$password}' ");
confirm($query);


if($query-> rowCount() == 0){



set_message("Your Password or Username are wrong");
redirect("login.php");



}else {

$_SESSION['username'] = $username;

redirect("admin");


}
}
}

function send_message(){


if(isset($_POST['submit'])){


$to           =  "example@email.com";
$from_name    =  $_POST['name'];
$subject      =  $_POST['subject'];
$email        =  $_POST['email'];
$message      =  $_POST['message'];


$headers= "From: {$from_name} {$email}";

$result = mail($to, $subject, $message, $headers);

if(!result){

    set_message("Sorry we could not send your message.");
    redirect("contact.php");
}else {

    set_message("Your message has been sent.");
    redirect("contact.php");
}


}

}
/***************************ADMIN USERS*****************************************/

function display_users(){
global $connection;

$query = "SELECT * FROM users";
$show_users = query_PDO($query);      


while($row = fetch_array($show_users))
{
$user_id = $row['user_id'];
$username = $row['username'];
$email = $row['email'];
$password = $row['password'];

$user_photo = display_image($row['user_photo']);

$users = <<<DELIMETER

<tr>
    <td>{$user_id}</td>
    <td><img width="75" height="75" src="../../resources/{$user_photo}" alt=""></a></td>
    <td>{$username}</td>
    <td>{$email}</td>
    <td><a class="btn btn-danger" href="../../resources/templates/back/delete_user.php?id={$row['user_id']}"><span class="glyphicon glyphicon-remove"></span></a></td>
</tr>



DELIMETER;

echo $users;
}
}

function add_user() {

if(isset($_POST['add_user'])){

$username   = $_POST['username'];
$email      = $_POST['email'];
$password   = $_POST['password'];
$user_photo = $_FILES['file']['name'];
$photo_temp = $_FILES['file']['tmp_name'];

move_uploaded_file($photo_temp, UPLOAD_DIRECTORY . DS . $user_photo);

$check_rows = query_PDO("SELECT * FROM users WHERE username ='$username' ");
 
confirm($check_rows);

$count = fetch_array($check_rows);


if($count > 0){

    echo ("THIS USERNAME ALLREADY EXISTS");
    
}else{

$query = query_PDO("INSERT INTO users(username,email,password,user_photo) VALUES('{$username}','{$email}','{$password}','{$user_photo}')");

confirm($query);

set_message("USER CREATED");

redirect("index.php?users");
}

}
}





/***************************BACK END FUNCTIONS************************************/




?>