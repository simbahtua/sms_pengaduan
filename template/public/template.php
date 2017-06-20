<!DOCTYPE html>
<html lang="en">
    <head>
        <!-- META SECTION -->
        <title>Home - Sistem Informasi Pengaduan</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />

        <link rel="icon" href="favicon.ico" type="image/x-icon" />
        <!-- END META SECTION -->

        <!-- CSS INCLUDE -->
        <link rel="stylesheet" type="text/css" id="theme" href="<?php echo $themes_url; ?>css/theme-blue.css"/>
        <!-- START PLUGINS -->
        <script type="text/javascript" src="<?php echo $themes_url; ?>js/plugins/jquery/jquery.min.js"></script>
        <script type="text/javascript" src="<?php echo $themes_url; ?>js/plugins/jquery/jquery-ui.min.js"></script>
        <script type="text/javascript" src="<?php echo $themes_url; ?>js/plugins/bootstrap/bootstrap.min.js"></script>
        <!-- END PLUGINS -->
        <!-- EOF CSS INCLUDE -->

        <?php
        if (isset($extra_header)) {
            echo $extra_header;
        }
        ?>

    </head>
    <body>
        <!-- START PAGE CONTAINER -->
        <div class="page-content">

            <!-- START PAGE SIDEBAR -->

            <!-- END PAGE SIDEBAR -->

            <!-- PAGE CONTENT -->
            <!--<div class="page-content">-->

            <!-- START X-NAVIGATION VERTICAL -->
            <ul class="x-navigation x-navigation-horizontal x-navigation-panel">
                <li>
                    <a href="#">Home</a>                        
                </li>
                <li>
                    <a href="#">Tentang Kami</a>
                </li>
                <li>
                    <a href="#">Kontak Kami</a>                     
                </li>
            </ul>
            <!-- END X-NAVIGATION VERTICAL -->                     

            <!-- PAGE CONTENT WRAPPER -->
            <div class="page-content-wrap">


                <!-- START WIDGETS -->                    


                <div class="row">

                    <div class="col-md-12">
                        <div class="panel-heading">
                            <div class="panel-title-box">
                                <h3>Pengaduan SMS</h3>
                            </div>                                    
                        </div>  
                    </div>
                    <div class="col-md-12">

                        <!-- START USERS ACTIVITY BLOCK -->
                        <div class="panel panel-default">

                            <?php $this->load->view($content_view); ?>
                        </div>

                    </div>


                </div>
            </div>

        </div>
        <!-- END MESSAGE BOX-->

        <!-- START PRELOADS -->
        <!-- <audio id="audio-alert" src="audio/alert.mp3" preload="auto"></audio>
        <audio id="audio-fail" src="audio/fail.mp3" preload="auto"></audio> -->
        <!-- END PRELOADS -->

        <!-- START SCRIPTS -->


        <!-- START THIS PAGE PLUGINS-->
        <!-- <script type='text/javascript' src='<?php echo $themes_url; ?>js/plugins/icheck/icheck.min.js'></script> -->
        <script type="text/javascript" src="<?php echo $themes_url; ?>js/plugins/mcustomscrollbar/jquery.mCustomScrollbar.min.js"></script>
        <script type="text/javascript" src="<?php echo $themes_url; ?>js/plugins/scrolltotop/scrolltopcontrol.js"></script>
        <!-- END THIS PAGE PLUGINS-->

        <!-- START TEMPLATE -->


        <script type="text/javascript" src="<?php echo $themes_url; ?>js/plugins.js"></script>
        <script type="text/javascript" src="<?php echo $themes_url; ?>js/actions.js"></script>

        <!-- <script type="text/javascript" src="<?php echo $themes_url; ?>js/demo_dashboard.js"></script> -->
        <!-- END TEMPLATE -->
        <!-- END SCRIPTS -->
    </body>
</html>
