<!DOCTYPE html>
<html lang="en" class="body-full-height">
    <head>
        <!-- META SECTION -->
        <title>Admin Login - Sms Pengaduan</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />

        <!-- END META SECTION -->

        <!-- CSS INCLUDE -->
        <link rel="stylesheet" type="text/css" id="theme" href="<?php echo $themes_url;?>css/theme-default.css"/>
        <link rel="stylesheet" type="text/css" id="theme" href="<?php echo $themes_url;?>css/custom.css"/>
        <!-- EOF CSS INCLUDE -->
    </head>
    <body>

        <div class="login-container lightmode">

            <div class="login-box animated fadeInDown">
                <!-- <div class="login-logo"></div> -->
                <div class="pull-left"><h2>Sistem Pengaduan Berbasis SMS</h2></div>
                <div class="login-body">
                    <div class="login-title"><strong>Log In</strong> to your account</div>

                    <?php
                        if ($this->session->flashdata('message')): ?>
                        <div class="alert alert-danger fade in">
                            <a href="#" class="close" data-dismiss="alert">&times;</a>
                            <?= $this->session->flashdata('message') ?>
                        </div>
                    <?php endif; ?>

                    <form action="<?php echo base_url();?>validate" class="form-horizontal" method="post">
                    <div class="form-group">
                        <div class="col-md-12">
                            <input type="text" name="username" class="form-control" placeholder="Nama User"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-12">
                            <input type="password" name="password" class="form-control" placeholder="Password"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-12">
                            <button class="btn btn-info btn-block">Log In</button>
                        </div>
                        <div class="col-md-12">
                            <a href="#" class="btn btn-link btn-block">Forgot your password?</a>
                        </div>
                    </div>

                    </form>
                </div>
                <div class="login-footer">
                    <div class="pull-right">
                        &copy; 2017::SMS PENGADUAN
                    </div>

                </div>
            </div>

        </div>

    </body>
</html>
