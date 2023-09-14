<!DOCTYPE html>
<html lang="en">
    <head>
        <title>NGDRS | </title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">


        <?= $this->Html->css(['../vendor/bootstrap/css/bootstrap.min', 'user/base', 'user/base-responsive', 'user/animate.min', 'user/slicknav.min', 'user/all-site-style', '../vendor/fontawesome/css/all.min.css','ngdrstyle.css','Dev_Define.css']) ?>

         <?= $this->fetch('css') ?>
         <?= $this->Html->script(['jquery-3.6.1']) ?>
		 <?= $this->Html->script(['crypto']) ?>
         <?= $this->Html->script('jQueryUI/jquery-ui.min'); ?>                      
    </head>

    <body>
        <?= $this->element('components/user/header'); ?>
        <?= $this->Flash->render() ?>
        <?= $this->fetch('content') ?>
        <?= $this->element('components/user/footer'); ?>
        <script>
            (function ($) {

                "use strict";

                $('nav .dropdown').hover(function () {
                    var $this = $(this);
                    $this.addClass('show');
                    $this.find('> a').attr('aria-expanded', true);
                    $this.find('.dropdown-menu').addClass('show');
                }, function () {
                    var $this = $(this);
                    $this.removeClass('show');
                    $this.find('> a').attr('aria-expanded', false);
                    $this.find('.dropdown-menu').removeClass('show');
                });

            })(jQuery);
        </script>
        <?= $this->fetch('script') ?>

        <?php
        echo $this->Element('Validationscript/dynamicscript_new');          // Validation Script
        echo $this->Element('Validationscript/server_message_display');
        ?>
    </body>
</html>