<!DOCTYPE html>

<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>NGDRS</title>
        <?= $this->element('components/admin/header'); ?>
        <?php
        echo $this->element("Helper/jqueryhelper");
        ?>
        <?= $this->Html->script('jQueryUI/jquery-ui.min'); ?>                      
        <?= $this->Html->css('Dev_Define'); ?>
    </head>

    <body class="sidebar-mini pace-primary pace-done layout-fixed">
        <!-- Site wrapper -->
        <div class="wrapper">        

            <?= $this->element('components/admin/navbar'); ?> 
            <?= $this->element('components/admin/sidebar'); ?> 



            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">Starter Page</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active">Starter Page</li>
                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->
            <div class="content-wrapper">
                <div class="content">
                    <div class="container-fluid">
                        <?= $this->Flash->render() ?>
                        <?= $this->fetch('content') ?>
                    </div>
                </div>
            </div>



            <footer class="main-footer">
                <div class="float-right d-none d-sm-block">
                    <b>NGDRS</b> 4X
                </div>
                <strong>Copyright &copy; 2011 - <?= date('Y'); ?> <a href="#">NGDRS</a>.</strong> All rights reserved.
            </footer>

            <!-- Control Sidebar -->
            <aside class="control-sidebar control-sidebar-dark">
                <!-- Control sidebar content goes here -->
            </aside>
            <!-- /.control-sidebar -->
        </div>
        <!-- ./wrapper -->

        <?= $this->element('components/admin/footer'); ?>
        <?php
        echo $this->Element('Validationscript/dynamicscript_new');          // Validation Script
        echo $this->Element('Validationscript/server_message_display');
        ?>
    </body>
</html>