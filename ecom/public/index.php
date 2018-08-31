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

                    <div class="col-md-12">
                        <!--carousel-->
                        <?php include(TEMPLATE_FRONT . DS . "slider.php") ?>
                    </div>

                </div>
                <div class="row">
                <?php get_products_index(); ?>

               
        

                </div><!--- row ends here -->

            </div>

        </div>

    </div>
    <!-- /.container -->
<?php include(TEMPLATE_FRONT . DS . "footer.php") ?>
    
