<?php require_once("../resources/config.php"); ?>
<?php include(TEMPLATE_FRONT . DS . "header.php") ?>


    <!-- Page Content -->
    <div class="container">
        
        <!-- Jumbotron Header -->

        <!-- Title -->
        <div class="row"> 
      <?php include(TEMPLATE_FRONT . DS . "side_nav.php") ?>
            <div class="col-md-9">
      
                 <header class="jumbotron hero-spacer">
                 <img class="img-responsive" src="imageshop/WELCOME-banner-shop.gif">
                </header>


            <div class="bg-primary">
            <h1 class="text-center"> <?php display_cat_in_cat_page(); ?> </h1>
            </div>

            </div>
        </div>
        <!-- /.row -->
       
        <!-- Page Features -->
        <div class="row text-center"> 
         <?php get_products_in_cat_page(); ?>
            </div>
        <!-- /.row -->

       

    </div>
    <!-- /.container -->

<?php include(TEMPLATE_FRONT . DS . "footer.php") ?>

  