<?php

    $image = $user->avatar;
    $directory = 'assets/images/users/';
    if ($image != '' && file_exists($directory . $image)) {
        $image_source = $image;
        $image_stat = '<font color="4e9a16"><i>(gambar tersedia)</i></font>';
        $image_show = '<div><img src="' . base_url() . $directory  . $image_source . '" border="0" alt="' . $image_source . '" /></div>';
    } else {
        $image_source = '';
        $image_stat = '<font color="cd412f"><i>(gambar tidak tersedia)</i></font>';
        $image_show = '';
    }
    ?>
<div class="page-content-wrap">
    <div class="row">
        <div class="col-md-12">
            <!-- START DEFAULT DATATABLE -->
            <div class="panel panel-default">
                <div class="panel-heading ui-draggable-handle">
                    <h2 class="panel-title"><span class="fa fa-user"></span> <?php echo lang('edit_user_heading_show');?></h2>
                </div>
                <div class="panel-body">
                    <div class="alert alert-info">
                        <strong>Profil Admin </strong>
                        <ul>
                            <li>Untuk Perubahan Data Profil silahkan isi form dibawah</li>
                        </ul>
                    </div>
                    <?php
                        echo $this->session->flashdata('confirmation');
                    ?>
                    <div class="panel panel-form">
                        <div class="panel-heading ui-draggable-handle">
                            <h2 class="panel-title"><i class="glyphicon glyphicon-edit"></i> Form Profil Admin</h2>
                        </div>
                        <?php echo form_open_multipart(base_url('admin/_system/act_profile'), array('class' => 'form-horizontal form-bordered','id'=>'myForm')); ?>
                        <?php echo form_hidden('old_image', $user->avatar); ?>

                        <div class="panel-body">
                            <div class="form-group">
                                <label class="col-md-3 control-label">Nama User<span class="mandatory"> * </span></label>
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <input type="text" name="username" id="username" size="30" class="form-control" value="<?php echo $user->username; ?>"/>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Nama Depan<span class="mandatory"> * </span></label>
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <input type="text" name="first_name" id="first_name" size="30" class="form-control" value="<?php echo $user->first_name; ?>"/>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Nama Belakang</label>
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <input type="text" name="last_name" id="last_name" size="30" class="form-control" value="<?php echo $user->last_name; ?>"/>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Email</label>
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <input type="text" name="email" id="email" size="30" class="form-control" value="<?php echo $user->email; ?>"/>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">No. HP / Telepon</label>
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <input type="text" name="phone" id="phone" size="30" class="form-control" value="<?php echo ($user->phone == 0) ? '' : $user->phone; ?>"/>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                            <label class="control-label col-md-3">Gambar Profil</label>
                            <div class="col-md-6">
                                <div class="input-group" id="defaultrange">
                            <label><?php echo $image_show; ?><br /><?php echo $image_source; ?>&nbsp;&nbsp;<?php echo $image_stat; ?></label><br /><br />
                            <?php echo form_upload('image', '', 'size="50"'); ?>
                            <?php
                            if(isset($image_width) && isset($image_height)) {
                                echo '<br /><small>(Ukuran terbaik ' . $image_width . 'px x ' . $image_height . 'px)</small>';
                            }
                            ?>
                        </div>
                    </div>
                </div>
                        </div>
                        <div class="panel-footer">
                            <div class="col-md-6 "><button class="btn btn-danger pull-right" type="reset">Clear Form</button></div>
                            <div class="col-md-6 "><button class="btn btn-primary pull-left" name="change_password" > <i class="icon-ok"></i> Submit</button></div>
                        </div>
                        <?php echo form_close();?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
