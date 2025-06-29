<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">
        <link href="https://fonts.googleapis.com/css?family=Poppins:100,200,300,400,500,600,700,800,900&display=swap" rel="stylesheet">
        <title>Toko maju jaya</title>
        <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/css/default/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/css/default/font-awesome.css">
        <link rel="stylesheet" href="<?= base_url() ?>assets/css/default/templatemo-hexashop.css">
        <link rel="stylesheet" href="<?= base_url() ?>assets/css/default/owl-carousel.css">
        <link rel="stylesheet" href="<?= base_url() ?>assets/css/default/lightbox.css">
    </head>
    <body>
        <div id="preloader">
            <div class="jumper">
                <div></div>
                <div></div>
                <div></div>
            </div>
        </div>  
        <?php if($this->uri->uri_string() != 'auth/login') : ?>
        <!-- <header class="header-area header-sticky">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <nav class="main-nav">
                            <a href="#" class="logo">
                                <img src="<?= base_url() ?>assets/img/logo.png">
                            </a>
                            <ul class="nav">
                                <li class="scroll-to-section"><a href="<?= site_url('home') ?>" class="active">Home</a></li>
                                <li class="scroll-to-section"><a href="">Product</a></li>
                                <?php if(!empty($this->session->userdata('username'))) : ?>
                                    <li class="scroll-to-section"><a href="<?= site_url('auth/logout') ?>">Logout</a></li>
                                <?php else : ?>
                                    <li class="scroll-to-section"><a href="<?= site_url('auth/login') ?>">Login</a></li>
                                <?php endif ?>
                                <li class="scroll-to-section"><a href="<?= site_url('home/keranjang') ?>"><i class="fa fa-shopping-cart"></i></a></li>
                            </ul>        
                            <a class='menu-trigger'>
                                <span>Menu</span>
                            </a>
                        </nav>
                    </div>
                </div>
            </div>
        </header> -->
        <?php endif; ?>

        <?php echo $pageContent ?? 'Konten tidak tersedia.'; ?>
        
        <?php if($this->uri->uri_string() != 'auth/login') : ?>
        <!-- <footer>
            <div class="container">
                <div class="row">
                    <div class="col-lg-3">
                        <div class="first-item">
                            <div class="logo">
                                <img src="<?= base_url() ?>assets/img/white-logo.png" alt="">
                            </div>
                            <ul>
                                <li><a href="#">Address</a></li>
                                <li><a href="#">gmail@company.com</a></li>
                                <li><a href="#">0810-2020-0340</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <h4>Shopping &amp; Categories</h4>
                        <ul>
                            <li><a href="#">Men’s Shopping</a></li>
                            <li><a href="#">Women’s Shopping</a></li>
                            <li><a href="#">Kid's Shopping</a></li>
                        </ul>
                    </div>
                    <div class="col-lg-3">
                        <h4>Useful Links</h4>
                        <ul>
                            <li><a href="#">Homepage</a></li>
                            <li><a href="#">About Us</a></li>
                            <li><a href="#">Help</a></li>
                            <li><a href="#">Contact Us</a></li>
                        </ul>
                    </div>
                    <div class="col-lg-3">
                        <h4>Help &amp; Information</h4>
                        <ul>
                            <li><a href="#">Help</a></li>
                            <li><a href="#">FAQ's</a></li>
                            <li><a href="#">Shipping</a></li>
                            <li><a href="#">Tracking ID</a></li>
                        </ul>
                    </div>
                    <div class="col-lg-12">
                        <div class="under-footer">
                            <p>Copyright © 2022 Market Co., Ltd. All Rights Reserved.</p>
                            <ul>
                                <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                                <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                                <li><a href="#"><i class="fa fa-linkedin"></i></a></li>
                                <li><a href="#"><i class="fa fa-behance"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </footer> -->
        <?php endif; ?>
        
        <script src="<?= base_url() ?>assets/js/default/jquery-2.1.0.min.js"></script>
        <script src="<?= base_url() ?>assets/js/default/popper.js"></script>
        <script src="<?= base_url() ?>assets/js/default/bootstrap.min.js"></script>
        <script src="<?= base_url() ?>assets/js/default/owl-carousel.js"></script>
        <script src="<?= base_url() ?>assets/js/default/accordions.js"></script>
        <script src="<?= base_url() ?>assets/js/default/datepicker.js"></script>
        <script src="<?= base_url() ?>assets/js/default/scrollreveal.min.js"></script>
        <script src="<?= base_url() ?>assets/js/default/waypoints.min.js"></script>
        <script src="<?= base_url() ?>assets/js/default/jquery.counterup.min.js"></script>
        <script src="<?= base_url() ?>assets/js/default/imgfix.min.js"></script> 
        <script src="<?= base_url() ?>assets/js/default/slick.js"></script> 
        <script src="<?= base_url() ?>assets/js/default/lightbox.js"></script> 
        <script src="<?= base_url() ?>assets/js/default/isotope.js"></script> 
        <script src="<?= base_url() ?>assets/js/default/custom.js"></script>
        <script>
            $(function() {
                var selectedClass = "";
                $("p").click(function(){
                selectedClass = $(this).attr("data-rel");
                $("#portfolio").fadeTo(50, 0.1);
                    $("#portfolio div").not("."+selectedClass).fadeOut();
                setTimeout(function() {
                $("."+selectedClass).fadeIn();
                $("#portfolio").fadeTo(50, 1);
                }, 500);
                    
                });
            });
        </script>
    </body>
</html>