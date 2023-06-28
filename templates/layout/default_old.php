<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @since         0.10.0
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 * @var \App\View\AppView $this
 */
$cakeDescription = 'CakePHP: the rapid development php framework';
?>
<!DOCTYPE html>
<html>
    <head>
        <?= $this->Html->charset() ?>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>
            <?= $cakeDescription ?>:
            <?= $this->fetch('title') ?>
        </title>
        <?= $this->Html->meta('icon') ?>

        <link href="https://fonts.googleapis.com/css?family=Raleway:400,700" rel="stylesheet">        
        <?= $this->Html->css(['bootstrap.min', 'home','fontawesome/css/all','jquery.dataTables.min','bootstrap-datepicker3.min']) ?>
        <?= $this->Html->script(['jquery-3.6.1']) ?>
        <?php
        echo $this->element("Helper/jqueryhelper");
        ?>


    </head>
    <body>
        <div class="header-wrapper">
            <div class="container">

                <header role="banner">
                    <div class="row row-with-vspace site-branding">

                        <div class="col-sm-2  site-title">
                            <h1 class="site-title-heading">
                                <a href="#" title="Example Home" rel="home"><img src="https://jharnibandhan.gov.in/img/images/JH_logo2.png" class="img-responsive home" border="0"></a>
                            </h1>

                        </div><!-- Close col sm2-->
                        <div class="col-sm-8 page-header-top-right">

                            <div class="site-description">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <h1>National Generic Document Registration System</h1>
                                        <small>Department of Land Resources - Government of India</small>
                                    </div> <!-- Close col sm8-->
                                    <div class="col-sm-12">
                                        Department of Revenue, Registration & Land Reforms, Government of Jharkhand             
                                    </div>
                                    <div class="clearfix"></div>

                                </div><!-- Close col sm4-->
                            </div><!-- Close col row-->

                        </div><!-- Close col site description-->      
                        <div class="col-sm-2  site-title">
                            <img src="https://jharnibandhan.gov.in/img/images/embelem1.png" class="img-fluid" alt="">       
<!--                            <small><br>Shri. Hafizul Hassan
                                <br>Hon'ble Minister,<br> Department of Registration
                                <br>Jharkhand State</small>-->
                        </div>
                    </div>
                </header>

            </div>
            <!--row .site-branding-->

            <nav class="navbar navbar-expand-lg navbar-dark ftco_navbar bg-dark ftco-navbar-light" id="ftco-navbar">
                <div class="container">
                    <a class="navbar-brand" href="#">Welcome - <?php
        $username = $this->Identity->get('username');
        if (!empty($username)) {
            echo $username;
        } else {
            echo 'Guest';
        }
        ?></a>
                    <form action="#" class="searchform order-sm-start order-lg-last">
                        <div class="form-group d-flex">
                            <input type="text" class="form-control pl-3" placeholder="Search">
                            <button type="submit" placeholder="" class="form-control search"><span class="fa fa-search"></span></button>
                        </div>
                    </form>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav" aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="fa fa-bars"></span> Menu
                    </button>
                    <div class="collapse navbar-collapse" id="ftco-nav">
                        <ul class="navbar-nav m-auto">
                            <li class="nav-item active"><a href="<?php echo $this->Url->build('/Users/index'); ?>" class="nav-link">Home</a></li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="dropdown04" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Page</a>
                                <div class="dropdown-menu" aria-labelledby="dropdown04">
                                    <a class="dropdown-item" href="#">Page 1</a>
                                    <a class="dropdown-item" href="#">Page 2</a>
                                    <a class="dropdown-item" href="#">Page 3</a>
                                    <a class="dropdown-item" href="#">Page 4</a>
                                </div>
                            </li>
                            <li class="nav-item"><a href="#" class="nav-link">Catalog</a></li>
                            <li class="nav-item"><a href="#" class="nav-link">Work</a></li>
                            <li class="nav-item"><a href="#" class="nav-link">Blog</a></li>
                            <?php if (!empty($username)) { ?>
                                <li class="nav-item"><a href="<?php echo $this->Url->build('/Users/logout'); ?>" class="nav-link">Logout</a></li>
                            <?php } else { ?>
                                <li class="nav-item"><a href="<?php echo $this->Url->build('/Users/login'); ?>" class="nav-link">Login</a></li>
                            <?php } ?>
                        </ul>
                    </div>
                </div>
            </nav>

        </div>
        <!--.container-->

        <!--.header-wrapper-->

        <!--    <nav class="top-nav">
                <div class="top-nav-title">
                    <a href="<?= $this->Url->build('/') ?>"><span>Cake</span>PHP</a>
                </div>
                <div class="top-nav-links">
                    <a   rel="noopener" ><?php echo $this->Identity->get('username'); ?></a>
        <?php if (!empty($this->Identity->get('username'))) { ?>
                                                            
        <?php } ?>
                </div>
            </nav>-->
        <main class="main">
            <div class="container">
                <?= $this->Flash->render() ?>
                <?= $this->fetch('content') ?>
            </div>
        </main>
        <!-- Remove the container if you want to extend the Footer to full width. -->


        <!-- Footer -->

        <!-- Footer -->


        <!-- End of .container -->
    </body>
    <?= $this->Html->script(['bootstrap', 'main','jquery.dataTables.min','bootstrap-datepicker.min']) ?>
    
    <?php
    echo $this->Element('Validationscript/dynamicscript_new');          // Validation Script
    echo $this->Element('Validationscript/server_message_display');
    ?>
</html>
