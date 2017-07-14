<style>
 .mandatory {
     color: #d51513;
 }
 .help-inline-error{color:red;}
</style>

<div class="page-content-wrap">
    <div class="row">
        <div class="col-md-12">
            <!-- START DEFAULT DATATABLE -->
            <div class="panel new-message panel-default">
                <div class="panel-heading ui-draggable-handle">
                    <h2 class="panel-title"><span class="fa fa-key"></span> Ubah Password</h2>
                </div>
                <?php echo form_open(base_url('admin/_system/act_password'), array('class' => 'form-horizontal form-bordered','id'=>'myForm')); ?>
                <div class="panel-body">
                    <div class="alert alert-info">
                        <ul>
                            <li>Semua Input bertanda <span class="mandatory"> * </span> harus diisi</li>
                            <li>Untuk Keamanan gunakan kombinasi angka dan huruf</li>
                            <li>Jumlah Karakter password minimal 8 dan maksimal 20 karakter</li>
                        </ul>
                    </div>

                    <?php
                        echo $this->session->flashdata('confirmation');
                    ?>

                    <div class="form-group">
                        <label class="col-md-3 control-label">Password Lama <span class="mandatory"> * </span></label>
                        <div class="col-md-6">
                            <div class="input-group">
                                <input type="password" name="old_pass" id="old_pass" size="30" class="form-control"/>
                            </div>

                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3  control-label">Password Baru <span class="mandatory"> * </span></label>
                        <div class="col-md-6 ">
                            <div class="input-group">
                                <input type="password" name="new_pass" id="new_pass" size="30" class="form-control"/>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label">Konfirmasi Password Baru <span class="mandatory"> * </span></label>
                        <div class="col-md-6">
                            <div class="input-group">
                                <input type="password" name='new_confirm' id='new_confirm' size="30" class="form-control"/>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="panel-footer">
                    <div class="col-md-6 "><button class="btn btn-danger pull-right" type="reset">Clear Form</button></div>
                    <div class="col-md-6 "><button class="btn btn-primary pull-left" name="change_password" > <i class="icon-ok"></i> Submit</button></div>
                </div>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="<?php echo base_url();?>plugins/jquery/jquery.validate.js"></script>
<script>
$(document).ready(function () {
        var form = $("#myForm");
        form.validate({
            // errorClass: "help-inline-error",
            rules: {
                    old_pass: {
                            required: true,
                    },
                    new_pass: {
                            required: true,
                            minlength: 8,
                            maxlength: 20
                    },
                    new_confirm: {
                            required: true,
                            minlength: 8,
                            maxlength: 20,
                            equalTo: "#new_pass"
                    },
        },
        messages: {
                old_pass: {
                    required: "Password Lama harus Diisi",
                },
                new_pass : {
                    required: "Password Baru Harus Diisi",
                    minlength: "Password Baru Minimal 8 Karakter",
                    maxlength: "Password Baru Maksimal 20 Karakter",
                },
                new_confirm: {
                    required: "Konfirmasi Password Baru Harus Diisi",
                    minlength: "Konfirmasi Password Baru Minimal 8 Karakter",
                    maxlength: "Konfirmasi Password Baru Maksimal 20 Karakter",
                    equalTo: "Konfirmasi Password Harus Sama Dengan Password Baru",

                },
            }
    });
});
</script>
