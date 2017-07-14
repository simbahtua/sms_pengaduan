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
    <body class="page-container-boxed">
        <!-- START PAGE CONTAINER -->
        <div class="page-container">

            <!-- START PAGE SIDEBAR -->
            <div class="page-sidebar  page-navigation-toggled page-container-wide">
                <!-- START X-NAVIGATION -->
                <ul class="x-navigation">
                    <li class="xn-logo">
                        <a href="#">SMS ADUAN</a>
                        <a href="#" class="x-navigation-control"></a>
                    </li>
                    <li class="xn-profile">
                        <?php
                            if($this->session->userdata('avatar') && $this->session->userdata('avatar') != '') {
                                $image = $this->session->userdata('avatar');
                            }else {
                                $image = 'avatar.jpg';
                            }
                            $img_url = 'assets/images/users/'.$image;
                        ?>
                        <a href="#" class="profile-mini">
                            <img src="<?php echo base_url($img_url); ?>" alt="John Doe"/>
                        </a>
                        <div class="profile">
                            <div class="profile-image">
                                <img src="<?php echo base_url($img_url); ?>" alt="John Doe"/>
                            </div>
                            <div class="profile-data">
                                <!-- <div class="profile-data-name">John Doe</div>
                                <div class="profile-data-title">Web Developer/Designer</div> -->
                            </div>
                            <div class="profile-controls">
                                <!-- <a href="pages-profile.html" class="profile-control-left"><span class="fa fa-info"></span></a>
                                <a href="pages-messages.html" class="profile-control-right"><span class="fa fa-envelope"></span></a> -->
                            </div>
                        </div>
                    </li>
                    <li class="xn-title">MENU ADMIN</li>
                    <li>
                        <a href="<?php echo base_url('admin/dashboard') ?>"><span class="fa fa-home" data-toggle="tooltip" data-placement="right" title="DASHBOARD"></span> <span class="xn-text">Dashboard</span></a>
                    </li>
                    <li>
                        <a href="<?php echo base_url('admin/sms/inbox') ?>"><span class="fa fa-envelope" data-toggle="tooltip" data-placement="right" title="INBOX" ></span> <span class="xn-text">INBOX</span></a>
                    </li>
                    <li>
                        <a href="<?php echo base_url('admin/sms/outbox') ?>"><span class="glyphicon glyphicon-send" data-toggle="tooltip" data-placement="right" title="OUTBOX"></span> <span class="xn-text">OUTBOX</span></a>
                    </li>
                    <li class="xn-openable">
                        <a href="#"><span class="fa fa-cogs"></span> <span class="xn-text">Systems</span></a>
                        <ul>
                            <li><a href="<?php echo base_url('admin/_system/profile');?>"><span class="fa fa-user"></span>Profil</a></li>
                            <li><a href="<?php echo base_url('admin/_system/password');?>"><span class="fa fa-key"></span>Ubah Password</a></li>
                        </ul>
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
                </ul>
                <!-- END X-NAVIGATION VERTICAL -->

                <!-- START BREADCRUMB -->
                <ul class="breadcrumb">
                    <?php
                    if (isset($breadcrumps)) {
                        if (is_array($breadcrumps)) {
                            $i = 0;
                            foreach ($breadcrumps as $breadcrumps_title => $breadcrumps_links) {
                                if ($breadcrumps_links != '#') {
                                    $breadcrumps_links = base_url() . $breadcrumps_links;
                                }
                                if ($i == count($breadcrumps)) {
                                    echo '<li class="active">' . $breadcrumps_title . '</li>';
                                } else {
                                    echo '<li><a href="' . $breadcrumps_links . '">' . $breadcrumps_title . '</a></li>';
                                }
                                $i++;
                            }
                        }
                    }
                    ?>
                </ul>
                <!-- END BREADCRUMB -->

                <!-- PAGE CONTENT WRAPPER -->
                <div class="page-content-wrap">
                    <?php $this->load->view($content_view); ?>

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
                            <a href="<?php echo base_url('logout'); ?>" class="btn btn-success btn-lg">Yes</a>
                            <button class="btn btn-default btn-lg mb-control-close">No</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END MESSAGE BOX-->
        <!-- START SCRIPTS -->


        <!-- START THIS PAGE PLUGINS-->
        <script type='text/javascript' src='<?php echo $themes_url; ?>js/plugins/icheck/icheck.min.js'></script>
        <script type="text/javascript" src="<?php echo $themes_url; ?>js/plugins/mcustomscrollbar/jquery.mCustomScrollbar.min.js"></script>
        <script type="text/javascript" src="<?php echo $themes_url; ?>js/plugins/scrolltotop/scrolltopcontrol.js"></script>
        <!-- END THIS PAGE PLUGINS-->

        <!-- START TEMPLATE -->


        <script type="text/javascript" src="<?php echo $themes_url; ?>js/plugins.js"></script>
        <script type="text/javascript" src="<?php echo $themes_url; ?>js/actions.js"></script>
        <script>
            $(document).ready(function () {
                setInterval(function () {
                    get_new_message();
                }, 25000);

                setInterval(function () {
                    check_outbox();
                }, 25000);
                $.ajaxSetup({cache: false});
            });

            function get_new_message() {
                $.ajax({
                    type: 'POST',
                    url: '<?php echo base_url(); ?>_service/_cron/read_inbox',
                    dataType: 'json',
                });
            }
            function check_outbox() {
                $.ajax({
                    type: 'POST',
                    url: '<?php echo base_url('service/check_outbox_status'); ?>',
                    dataType: 'json',
                });
            }

        </script>

        <?php
        if (isset($extra_footer)) {
            echo $extra_footer;
        }
        ?>
    </body>
</html>
