<!DOCTYPE html>
<html lang="en">
    <head>
        <!-- META SECTION -->
        <title>Admin :: Sistem Pengaduan</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />

        <link rel="icon" href="favicon.ico" type="image/x-icon" />
        <!-- END META SECTION -->

        <!-- BEGIN GLOBAL MANDATORY STYLES -->
       <link type="text/css" rel="stylesheet" href="<?php echo $themes_url; ?>/css/fontawesome/font-awesome.min.css" />
       <link type="text/css" rel="stylesheet" href="<?php echo $themes_url; ?>/css/bootstrap/bootstrap.min.css" />
       <!-- END GLOBAL MANDATORY STYLES -->

        <!-- CSS INCLUDE -->
        <link type="text/css" rel="stylesheet" href="<?php echo base_url('plugins/jquery/css/jquery-ui.min.css'); ?>" />
        <link type="text/css" rel="stylesheet" href="<?php echo base_url('plugins/jquery/css/jquery-ui.theme.min.css'); ?>" />
        <link rel="stylesheet" type="text/css" id="theme" href="<?php echo $themes_url;?>css/custom.css"/>
        <!-- @import "mcustomscrollbar/jquery.mCustomScrollbar.css"; -->
        <!-- START PLUGINS -->
        <!-- <script type="text/javascript" src="<?php echo $themes_url;?>js/plugins/jquery/jquery.min.js"></script>
        <script type="text/javascript" src="<?php echo $themes_url;?>js/plugins/jquery/jquery-ui.min.js"></script> -->
        <script type="text/javascript" src="<?php echo base_url('plugins/jquery/jquery-3.2.1.min.js');?>"></script>
        <script type="text/javascript" src="<?php echo base_url('plugins/jquery/jquery-ui.min.js');?>"></script>
        <!-- <script type="text/javascript" src="<?php echo $themes_url;?>js/plugins/bootstrap/bootstrap.min.js"></script> -->
        <script src="<?php echo base_url('assets/js/bootstrap.min.js'); ?>"></script>
        <!-- END PLUGINS -->
        <!-- EOF CSS INCLUDE -->

        <?php
            if (isset($extra_header)) {
                echo $extra_header;
            }
        ?>

    </head>
    <body class="page-container-boxed">
        <!-- START PAGE CONTAINER -->
        <div class="page-container">

            <!-- START PAGE SIDEBAR -->
            <div class="page-sidebar">
                <!-- START X-NAVIGATION -->
                <ul class="x-navigation">
                    <li class="xn-logo">
                       <a href="index.html">SMS ADUAN</a>
                       <a href="#" class="x-navigation-control"></a>
                   </li>
                    <li class="xn-profile">
                        <a href="#" class="profile-mini">
                            <img src="<?php echo base_url('assets/images/users/avatar.jpg');?>" alt="John Doe"/>
                        </a>
                        <div class="profile">
                            <div class="profile-image">
                                <img src="<?php echo base_url('assets/images/users/avatar.jpg');?>" alt="John Doe"/>
                            </div>
                            <div class="profile-data">
                                <div class="profile-data-name">John Doe</div>
                                <div class="profile-data-title">Web Developer/Designer</div>
                            </div>
                            <div class="profile-controls">
                                <a href="pages-profile.html" class="profile-control-left"><span class="fa fa-info"></span></a>
                                <a href="pages-messages.html" class="profile-control-right"><span class="fa fa-envelope"></span></a>
                            </div>
                        </div>
                    </li>
                    <li class="xn-title">MENU ADMIN</li>
                    <li class="active">
                        <a href="<?php echo base_url('admin/dashboard')?>"><span class="fa fa-home"></span> <span class="xn-text">Dashboard</span></a>
                    </li>
                    <li>
                        <a href="<?php echo base_url('admin/message/inbox')?>"><span class="fa fa-envelope"></span> <span class="xn-text">INBOX</span></a>
                    </li>
                    <li>
                        <a href="<?php echo base_url('admin/message/outbox')?>"><span class="fa fa-envelope-open"></span> <span class="xn-text">OUTBOX</span></a>
                    </li>

                </ul>
                <!-- END X-NAVIGATION -->
            </div>
            <!-- END PAGE SIDEBAR -->

            <!-- PAGE CONTENT -->
            <div class="page-content">

                <!-- START X-NAVIGATION VERTICAL -->
                <ul class="x-navigation x-navigation-horizontal x-navigation-panel">
                    <!-- TOGGLE NAVIGATION -->
                    <li class="xn-icon-button">
                        <a href="#" class="x-navigation-minimize"><span class="fa fa-dedent"></span></a>
                    </li>
                    <!-- END TOGGLE NAVIGATION -->
                    <!-- SEARCH -->
                    <!-- <li class="xn-search">
                        <form role="form">
                            <input type="text" name="search" placeholder="Search..."/>
                        </form>
                    </li> -->
                    <!-- END SEARCH -->
                    <!-- SIGN OUT -->
                    <li class="xn-icon-button pull-right">
                        <a href="#" class="mb-control" data-box="#mb-signout"><span class="fa fa-sign-out"></span></a>
                    </li>
                    <!-- END SIGN OUT -->
                    <!-- MESSAGES -->
                    <!-- <li class="xn-icon-button pull-right">
                        <a href="#"><span class="fa fa-comments"></span></a>
                        <div class="informer informer-danger">4</div>
                        <div class="panel panel-primary animated zoomIn xn-drop-left xn-panel-dragging">
                            <div class="panel-heading">
                                <h3 class="panel-title"><span class="fa fa-comments"></span> Messages</h3>
                                <div class="pull-right">
                                    <span class="label label-danger">4 new</span>
                                </div>
                            </div>

                            <div class="panel-footer text-center">
                                <a href="pages-messages.html">Show all messages</a>
                            </div>
                        </div>
                    </li> -->
                    <!-- END MESSAGES -->
                    <!-- TASKS -->
                    <!-- <li class="xn-icon-button pull-right">
                        <a href="#"><span class="fa fa-tasks"></span></a>
                        <div class="informer informer-warning">3</div>
                        <div class="panel panel-primary animated zoomIn xn-drop-left xn-panel-dragging">
                            <div class="panel-heading">
                                <h3 class="panel-title"><span class="fa fa-tasks"></span> Tasks</h3>
                                <div class="pull-right">
                                    <span class="label label-warning">3 active</span>
                                </div>
                            </div>

                            <div class="panel-footer text-center">
                                <a href="pages-tasks.html">Show all tasks</a>
                            </div>
                        </div>
                    </li> -->
                    <!-- END TASKS -->
                </ul>
                <!-- END X-NAVIGATION VERTICAL -->

                <!-- START BREADCRUMB -->
                <ul class="breadcrumb">
                    <li><a href="#">Home</a></li>
                    <li class="active">Dashboard</li>
                </ul>
                <!-- END BREADCRUMB -->

                <!-- PAGE CONTENT WRAPPER -->
                <div class="page-content-wrap">
                <?php $this->load->view($content_view);?>

                </div>
                <!-- END PAGE CONTENT WRAPPER -->
            </div>
            <!-- END PAGE CONTENT -->
        </div>
        <!-- END PAGE CONTAINER -->

        <!-- MESSAGE BOX-->
        <div class="message-box animated fadeIn" data-sound="alert" id="mb-signout">
            <div class="mb-container">
                <div class="mb-middle">
                    <div class="mb-title"><span class="fa fa-sign-out"></span> Log <strong>Out</strong> ?</div>
                    <div class="mb-content">
                        <p>Are you sure you want to log out?</p>
                        <p>Press No if youwant to continue work. Press Yes to logout current user.</p>
                    </div>
                    <div class="mb-footer">
                        <div class="pull-right">
                            <a href="<?php echo base_url('logout');?>" class="btn btn-success btn-lg">Yes</a>
                            <button class="btn btn-default btn-lg mb-control-close">No</button>
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
        <!-- <script type='text/javascript' src='<?php echo $themes_url;?>js/plugins/icheck/icheck.min.js'></script> -->
        <script type="text/javascript" src="<?php echo $themes_url;?>js/plugins/mcustomscrollbar/jquery.mCustomScrollbar.min.js"></script>
        <script type="text/javascript" src="<?php echo $themes_url;?>js/plugins/scrolltotop/scrolltopcontrol.js"></script>
        <!-- END THIS PAGE PLUGINS-->

        <!-- START TEMPLATE -->


        <script type="text/javascript" src="<?php echo $themes_url;?>js/plugins.js"></script>
        <script type="text/javascript" src="<?php echo $themes_url;?>js/actions.js"></script>

        <!-- <script type="text/javascript" src="<?php echo $themes_url;?>js/demo_dashboard.js"></script> -->
        <!-- END TEMPLATE -->
    <!-- END SCRIPTS -->
        <?php
            if (isset($extra_footer)) {
                echo $extra_footer;
            }
        ?>
    </body>
</html>
