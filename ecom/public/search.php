<?php require_once("../resources/config.php"); ?>
<?php include(TEMPLATE_FRONT . DS . "header.php") ?>

<style type="text/css">

   body { 
  
</style>
    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <!--Categories here -->
<?php include(TEMPLATE_FRONT . DS . "side_nav.php") ?>

            <div class="col-md-9">

                <div class="row carousel-holder">

                </div>
                <div class="row">

                 <header class="jumbotron hero-spacer">
                <img src="imageshop/WELCOME-banner-shop.gif" class="img-responsive">
                 </header>
                 <?php
                 if(isset($_POST['submit'])){
                
            $search = $_POST['search'];
                
                
            $query = query_PDO("SELECT * FROM products WHERE product_tags LIKE '%$search%' ");

            confirm($query);

            if(!$query) {

                die("QUERY FAILED");
            }

            $count = $query-> rowCount();
            

            if($count == 0) {

                echo "<h1> NO RESULT</h1>";

            } else {

                while($row = fetch_array($query)) {

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
}
?>
                <!-- First Blog Post -->

            </div>

        </div>

    </div>
    <!-- /.container -->
<?php include(TEMPLATE_FRONT . DS . "footer.php") ?>
    
