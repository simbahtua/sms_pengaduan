
<div class="page-content-wrap">
    <div class="row">
        <div class="col-md-12">
            <!-- START DEFAULT DATATABLE -->
            <div class="panel new-message panel-default">
                <div class="panel-heading ui-draggable-handle">
                    <h2 class="panel-title"><span class="fa fa-envelope"></span> <?php echo $title; ?></h2>
                    <ul class="panel-controls">
                        <li><button class="button panel-refresh" data-toggle="tooltip" data-placement="top" title="Refresh"><span class="fa fa-refresh"></span></button></li>
                        <li><button class="button clear-filter" data-toggle="tooltip" data-placement="top" title="Clear Filter"><span class="fa fa-times"></span></button></li>
                    </ul>
                </div>
                <div class="panel-body">
                    <button class="btn btn-success" onclick="add_person()"><i class="glyphicon glyphicon-plus"></i> Tambah Administrator</button>
                    <br /> <br />
                    <div class="dataTables_wrapper no-footer">
                        <table class="table table-striped table-bordered " id="example" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Nama User</th>
                                    <th style="width:20%">Nama Admin</th>
                                    <th>Email</th>
                                    <th>No Telp / HP</th>
                                    <th style="width:10%;">Terima SMS Aduan</th>
                                    <th>Login Terakhir</th>
                                    <!-- <th>Group Admin</th> -->
                                    <!-- <th style="width:10%;text-align:center; ">Action</th> -->
                                </tr>
                            </thead>

                        </table>
                    </div>
                </div>
            </div>
            <!-- END DEFAULT DATATABLE -->
        </div>
    </div>
</div>

<script>
var save_method; //for save method string
var table;
var base_url = '<?php echo base_url();?>';
    $(document).ready(function () {
        $('#example .input_text').each(function () {
            var title = $(this).text();
            var inp = '<input type="text" class="form-control" size="12" placeholder="Cari ' + title + '" />';
            $(this).html(inp);


            $('#modal_form').on('shown.bs.modal',function() {
                $('#respons_message').html('');
            });
        });

        var table = $("#example").DataTable({
            responsive: true,
            colReorder: false,
            columns: [
                {"name": "username"},
                {"name": "name"},
                // {"name": "last_name"},
                {"name": "email", "className": "center"},
                {"name": "phone", "className": "center"},
                // {"name": "avatar"}
                {"name": "forward_status"},
                {"name": "last_login", "className": "center"},
                // {"name": "description"},
                // {"name": "action"},
            ],
            order: [[0, "desc"]],
            processing: true,
            serverSide: true,
            ajax: {
                url: '<?php echo base_url("service/getUsers") ?>',
                type: 'POST'
            },
            language: {
                info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data.",
                emptyTable: "Tidak ada data",
                lengthMenu: "Menampilkan _MENU_ data",
                search: "Cari:",
                zeroRecords: "Data tidak ditemukan",
                infoEmpty: "Menampilkan 0 data",
                infoFiltered: "(difilter dari _MAX_ total data)",
                paginate: {
                    next: "Berikutnya",
                    previous: "Sebelumnya"
                }
            },
        });

        $.ajaxSetup({cache: false});

    });

    $(".panel-refresh").on("click", function () {
        var panel = $(this).parents(".panel");
        panel_refresh(panel, 'hidden');

        setTimeout(function () {
            panel_refresh(panel, 'hidden');
        }, 3000);

        $(this).parents(".dropdown").removeClass("open");
        return false;
    });


    function panel_refresh(panel, action, callback) {
        var table = $("#example").DataTable();

        if (!panel.hasClass("panel-refreshing")) {
            panel.append('<div class="panel-refresh-layer"><img src="<?php echo $themes_url; ?>img/loaders/default.gif"/></div>');
            panel.find(".panel-refresh-layer").width(panel.width()).height(panel.height());
            panel.addClass("panel-refreshing");

            if (action && action === "shown" && typeof callback === "function")
                callback();
        } else {
            panel.find(".panel-refresh-layer").remove();
            panel.removeClass("panel-refreshing");
            if (action && action === "hidden" && typeof callback === "function")
                callback();
        }
        onload();
        table.draw();
    }

    function add_person()
    {
        save_method = 'add';
        $('#form')[0].reset(); // reset form on modals
        $('.form-group').removeClass('has-error'); // clear error class
        $('.help-block').empty(); // clear error string
        $('#modal_form').modal('show'); // show bootstrap modal
        $('#respons_message').html(''); // show bootstrap modal
        $('.modal-title').text('Tambah Data Administrator'); // Set Title to Bootstrap modal title

    }

    function edit_person(id)
    {
        save_method = 'update';
        $('#form')[0].reset(); // reset form on modals
        $('.form-group').removeClass('has-error'); // clear error class
        $('.help-block').empty(); // clear error string


        //Ajax Load data from ajax
        $.ajax({
            url : "<?php echo site_url('person/ajax_edit')?>/" + id,
            type: "GET",
            dataType: "JSON",
            success: function(data)
            {

                $('[name="id"]').val(data.id);
                $('[name="firstName"]').val(data.firstName);
                $('[name="lastName"]').val(data.lastName);
                $('[name="gender"]').val(data.gender);
                $('[name="address"]').val(data.address);

                $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
                // $('#respons_message').html(''); // show bootstrap modal
                $('.modal-title').text('Edit Data Administrator'); // Set title to Bootstrap modal title
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error get data from ajax');
            }
        });
    }


    function save()
    {
        $('#btnSave').text('saving...'); //change button text
        $('#btnSave').attr('disabled',true); //set button disable
        var url;
        var panel = $(this).parents(".panel");

        if(save_method == 'add') {
            url = "<?php echo base_url('admin/administrator/act_add_user')?>";
        } else {
            url = "<?php echo site_url('person/ajax_update')?>";
        }

        // ajax adding data to database

        var formData = new FormData($('#form')[0]);
        $.ajax({
            url : url,
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            dataType: "JSON",
            success: function(data)
            {

                if(data.status) //if success close modal and reload ajax table
                {
                    $('#modal_form').modal('hide');
                    panel_refresh(panel);
                }
                else
                {
                    $('#respons_message').html(data.message);
                }
                $('#btnSave').text('save'); //change button text
                $('#btnSave').attr('disabled',false); //set button enable


            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error adding / update data');
                $('#btnSave').text('save'); //change button text
                $('#btnSave').attr('disabled',false); //set button enable

            }
        });
    }

    function delete_person(id)
    {
        if(confirm('Are you sure delete this data?'))
        {
            // ajax delete data to database
            $.ajax({
                url : "<?php echo site_url('person/ajax_delete')?>/"+id,
                type: "POST",
                dataType: "JSON",
                success: function(data)
                {
                    //if success reload ajax table
                    $('#modal_form').modal('hide');
                    reload_table();
                },
                error: function (jqXHR, textStatus, errorThrown)
                {
                    alert('Error deleting data');
                }
            });

        }
    }
</script>


<!-- Bootstrap modal -->
<div class="modal fade" id="modal_form" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title">Form Tambah Administrator</h3>
            </div>
            <div class="modal-body form">
                <div id="respons_message"> </div>
                <form action="#" id="form" class="form-horizontal">
                    <input type="hidden" value="" name="id"/>
                    <!-- <div class="form-group">
                        <label class="control-label col-md-4">Group Administrator <span class='required'> * <span></label>
                        <div class="col-md-8">

                                <?php echo form_dropdown('groups', $opt_group, '', 'class="form-control"'); ?>

                            <span class="help-block"></span>
                        </div>
                    </div> -->

                    <div class="form-body">
                        <div class="form-group">
                            <label class="control-label col-md-4">Nama User <span class='required'> * <span></label>
                            <div class="col-md-8">
                                <input name="identity" placeholder="Nama User" class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-4">Password <span class='required'> * <span></label>
                            <div class="col-md-8">
                                <input name="password" placeholder="Last Name" class="form-control" type="password">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-4">Re-Password <span class='required'> * <span></label>
                            <div class="col-md-8">
                                <input name="conf_password" placeholder="Konfirmasi Password" class="form-control" type="password">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <hr>
                        <div class="form-group">
                            <label class="control-label col-md-4">Forward SMS Aduan</label>
                            <div class="col-md-8">
                                <select name="forwarded" class="form-control">
                                    <option value="0">Tidak</option>
                                    <option value="1">Ya</option>
                                </select>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="control-label col-md-4">Nama Depan <span class='required'> * <span></label>
                            <div class="col-md-8">
                                <input name="first_name" placeholder="Nama Depan" class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-4">Nama Belakang</label>
                            <div class="col-md-8">
                                <input name="last_name" placeholder="Nama Belakang" class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-4">Email</label>
                            <div class="col-md-8">
                                <input name="email" placeholder="Nama Belakang" class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-4">No Hp</label>
                            <div class="col-md-8">
                                <input name="phone" placeholder="Nomer Handphone" class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>

                        

                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" id="btnSave" onclick="save()" class="btn btn-primary">Save</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- End Bootstrap modal -->
