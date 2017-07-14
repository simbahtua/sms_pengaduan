<style type="text/css">
    thead tr th .center {
        text-align: center;
    }
    tbody tr td .center {
        text-align: center;
    }
    tfoot {
        display: table-header-group;
    }

    .modal-body{
        /*height: 250px;*/
        overflow-y: auto;
    }
</style>


<div class="modal fade modal-sms" id="replysms" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="background-image: none !important;"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Modal title</h4>
            </div>
            <div class="modal-body">
                <div class="message_content">

                </div>
                <div class="row">
                    <div class="col-md-12">

                        <form class="form-horizontal" id="form-reply" method="POST">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 class="panel-title"><strong>FORM BALAS SMS</h4>
                                </div>

                                <div class="panel-body">
                                    <input type="hidden" name='receiver' class='receiver' value=''>
                                    <input type="hidden" name='in_id' class='in_id' value=''>
                                    <input type="hidden" name='notes' class='notes' value=''>
                                    <input type="hidden" name='out_type' class='out_type' value='reply'>
                                    <input type="hidden" name='indate' class='indate' value=''>
                                    <input type="hidden" name='replied' class='replied' value=''>
                                    <input type="hidden" name='responded' class='responded' value=''>

                                    <div class="form-group">
                                        <label class="col-md-3 col-xs-12 control-label">ISI PESAN</label>
                                        <div class="col-md-9 col-xs-12">
                                            <textarea class="form-control input-content" rows="5" name='content' id='content'></textarea>
                                            <span class="help-block"></span>
                                        </div>
                                    </div>

                                </div>
                                <div class="panel-footer">
                                    <button class="btn btn-primary pull-right" id='send-reply'>Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade modal-sms" id="respond-sms" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="background-image: none !important;"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Modal title</h4>
            </div>
            <div class="modal-body">
                <div class="message_content">

                </div>
                <div class="row">
                    <div class="col-md-12">

                        <form class="form-horizontal" action="#" id="form-respond" method="POST" enctype="multipart/form-data">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 class="panel-title"><strong>FORM TINDAK LANJUT ADUAN SMS</h4>
                                </div>
                                <div class="panel-body">
                                    <input type="hidden" name='receiver' class='receiver' value=''>
                                    <input type="hidden" name='in_id' class='in_id' value=''>
                                    <input type="hidden" name='notes' class='notes' value=''>
                                    <input type="hidden" name='out_type' class='out_type' value='respond'>
                                    <input type="hidden" name='indate' class='indate' value=''>
                                    <input type="hidden" name='replied' class='replied' value=''>
                                    <input type="hidden" name='responded' class='responded' value=''>

                                    <div class="form-group">
                                        <label class="col-md-3 col-xs-12 control-label">Kirim SMS</label>
                                        <div class="col-md-4 col-xs-12">
                                            <label class="switch">
                                                <input class="switch" name="is_sms" id="is_sms" value="0"  type="checkbox">
                                                <span></span>
                                            </label>
                                        </div>
                                        <div class="col-md-5 col-xs-12">
                                            <span class="help-block">Kirim SMS Respons</span>
                                        </div>
                                    </div>

                                    <div class="form-group ta-content">
                                    </div>

                                    <div class="form-group" id='respond-aduan'>
                                        <label class="col-md-3 col-xs-12 control-label">Respond Aduan</label>
                                        <div class="col-md-9 col-xs-12">
                                            <textarea class="form-control" rows="5" name="desc" id="desc"></textarea>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-3 col-xs-12 control-label">Upload File</label>
                                        <div class="col-md-4 col-xs-12">
                                            <label class="switch">
                                                <input class="switch" name="is_upload" id="is_upload" value="0"  type="checkbox">
                                                <span></span>
                                            </label>
                                        </div>
                                        <div class="col-md-5 col-xs-12">
                                            <span class="help-block">Upload File Respons</span>
                                        </div>
                                    </div>
                                    <div class="form-group" id='upload-file' style="display:none;">
                                        <label class="col-md-3 col-xs-12 control-label">Upload</label>
                                        <div class="col-md-9 col-xs-12"><div class="dropzone dropzone-previews" id="my-awesome-dropzone"></div></div>
                                    </div>

                                </div>
                                <div class="panel-footer">
                                    <button class="btn btn-primary pull-right" id='save_respond'>Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


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
                    <div class="dataTables_wrapper no-footer">
                        <table class="table table-striped table-bordered " id="example" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Pengirim</th>
                                    <th>Isi Pesan</th>
                                    <th class='dt-head-center'>Status Dibaca</th>
                                    <th class='dt-head-center'>Status Dibalas</th>
                                    <th class='dt-head-center'>Status Tindak Lanjut</th>
                                    <th class='dt-head-center'>Action</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th><input  readonly="readonly" type="text" id="5" class="form-control datepicker" size="12" placeholder="Cari Tanggal"></th>
                                    <th class="input_text">Pengirim</th>
                                    <th class="input_text">Isi Pesan</th>
                                    <th class="input_select" id="read_status">Status Dibaca</th>
                                    <th class="input_select" id="reply_status">Statyus Dibalas</th>
                                    <th class="input_select" id="respond_status">Status Tindak Lanjut</th>
                                    <th>&nbsp;</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
            <!-- END DEFAULT DATATABLE -->
        </div>
    </div>
</div>

<div class="message-box message-box-success animated fadeIn" id="message-box-success">
    <div class="mb-container">
        <div class="mb-middle">
            <div class="mb-title"><span class="fa fa-check"></span> SUKSES</div>
            <div class="mb-content success-sent">

            </div>
            <div class="mb-footer">
                <button class="btn btn-default btn-lg pull-right mb-control-close">Close</button>
            </div>
        </div>
    </div>
</div>
<div class="message-box message-box-danger animated fadeIn" id="message-box-danger">
    <div class="mb-container">
        <div class="mb-middle">
            <div class="mb-title"><span class="fa fa-times"></span> GAGAL</div>
            <div class="mb-content failed-sent">

            </div>
            <div class="mb-footer">
                <button class="btn btn-default btn-lg pull-right mb-control-close">Close</button>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="<?php echo $themes_url; ?>js/plugins/bootstrap/bootstrap-datepicker.js"></script>

<script>
    $(document).ready(function () {
        $('#example .input_text').each(function () {
            var title = $(this).text();
            var inp = '<input type="text" class="form-control" size="12" placeholder="Cari ' + title + '" />';
            $(this).html(inp);
        });

        $("#example #read_status").html('<select class="form-control" id="opt-readed" "width="10px" > <option value="" disabled selected>STATUS</option> <option value="0">Belum</option><option value="1">Sudah</option></select>');
        $("#example #reply_status").html('<select class="form-control" id="opt-replied" width="10px" >   <option value="" disabled selected>STATUS</option> <option value="0">Belum</option><option value="1">Sudah</option></select>');
        $("#example #respond_status").html('<select class="form-control" id="opt-responded" width="10px">  <option value="" disabled selected>STATUS</option> <option value="0">Belum</option><option value="1">Sudah</option></select>');

        var table = $("#example").DataTable({
            responsive: true,
            colReorder: false,
            columns: [
                {"name": "in_datetime"},
                {"name": "sender"},
                {"name": "content"},
                {"name": "read_status", "className": "center"},
                {"name": "reply_status", "className": "center"},
                {"name": "respond_status", "className": "center"},
                {"name": "action", 'sortable': false},
            ],
            order: [[0, "desc"]],
            processing: true,
            serverSide: true,
            stateSave: false,
            ajax: {
                url: '<?php echo $service_url; ?>',
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

        // Apply the search
        table.columns().every(function () {
            var that = this;

            $('input', this.footer()).on('keyup change', function () {
                if (that.search() !== this.value) {
                    that.search(this.value).draw();
                }
            });

            $('select', this.footer()).on('change', function () {
                if (that.search() !== this.value) {
                    that.search(this.value).draw();
                }
            });
        });

        setInterval(function () {
            get_unshown_message();
        }, 30000);
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

    function get_unshown_message() {
        var panel = $(".panel-refresh").parents(".panel");
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url(); ?>service/get_unshown_message',
            dataType: 'json',
            success: function (count) {
                if (count > 0) {
                    panel_refresh(panel);
                    setTimeout(function () {
                        panel_refresh(panel);
                    }, 5000);
                }
            }
        });
    }

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

    $(function () {
        $(".datepicker").datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true
        });
    });

    $(".clear-filter").on('click', function () {
        clear_filter();
    });

    function delete_message(inbox_id) {
        confirmation = confirm('Anda Yakin Akan Menghapus Pesan Ini?');

        if(confirmation) {
            information = 'Penghapusan Pesan Dibatalkan';
            $.ajax({
                type: 'POST',
                url: '<?php echo base_url('service/act_delete'); ?>',
                data: 'id='+inbox_id,
                dataType: 'json',
                async: false,
                success: function (response) {

                    information = response['message'];
                    if (response['status'] == true) {
                        box = 'message-box-success';
                    }else {
                        box = 'message-box-danger';
                    }

                    $('.success-sent').html(information);
                    $('#' + box).toggleClass("open");
                }

            });

        }else {
            information = 'Penghapusan Pesan Dibatalkan';
            $('.success-sent').html(information);
            $('#message-box-success').toggleClass("open");
        }

    }


    function clear_filter() {
        var panel = $(".panel-refresh").parents(".panel");

        var table = $("#example").DataTable();
        panel_refresh(panel);
        setTimeout(function () {
            panel_refresh(panel);
            $('input[type="text"]').val('');
            $('#opt-readed').val('');
            $('#opt-replied').val('');
            $('#opt-responded').val('');
            table.search('').columns().search('').draw();
        }, 5000);
    }

</script>
<script>
    $(document).ready(function () {
        var panel = $(this).parents(".panel");
        $('.modal').on('shown.bs.modal', function (event) {
            $('.modal-body').css('height', $(window).height() * 0.6);
            button = $(event.relatedTarget); // Button that triggered the modal
            content = button.data('content');
            sender = button.data('senderphone');
            readed = button.data('readed');
            date = button.data('indatetime');
            messageID = button.data('id');
            responded = button.data('responded');
            replied = button.data('replied');

            notes = 'Aduan dari ' + sender + ', tentang : ' + content;

            $('.receiver').val(sender);
            $('.in_id').val(messageID);
            $('.notes').val(notes);
            $('.indate').val(date);
            $('.replied').val(replied);
            $('.responded').val(responded);

            upstatus = 'readed';
            updateInbox(messageID, upstatus, readed, date);
            $('.modal-title').html('<div class="alert alert-info" >PESAN DARI ' + sender + ' </div>');
            $('.message_content').html('<div class="alert alert-success"> ISI PESAN : <br><blockquote>' + content + '</blockquote> </div>');
        });

        $("#respond-sms").on('shown.bs.modal', function() {
            $("#is_sms").val(0);
            $(".ta-content").html('');
            $("#desc").val('');
            $("#is_upload").val(0);
            $("#upload-file").hide();
            $('.switch').attr('checked',false);
        });

        $(".modal").on('hidden.bs.modal', function () {
            $(this).removeData('bs.modal');
            $('#content').val('');
            panel_refresh(panel);
        });

        $("#send-reply").click(function (e) {
            e.preventDefault();
            var form_data = $("#form-reply").serialize();
            $.ajax({
                type: 'POST',
                url: '<?php echo base_url('service/act_reply'); ?>',
                data: form_data,
                dataType: 'json',
                async: false,
                success: function (status) {
                    if (status == 'success') {
                        updateInbox($('.in_id').val(), 'replied', $('.replied').val(), $('.indate').val());
                        var information = 'Pesan Telah dikirim ke ' + $('.receiver').val();
                        $('.success-sent').html(information);
                        $('#replysms').hide();
                        $('#message-box-success').toggleClass("open");
                    } else {
                        var information = 'Pesan Gagal dikirim ke ' + $('.receiver').val();
                        $('.failed-sent').html(information);
                        $('#message-box-danger').toggleClass("open");
                    }
                }
            });
        });

        $(".mb-control-close").on("click", function () {
            $(".message-box").removeClass("open");
            panel_refresh(panel);
        });
    });

    $('#is_sms').on('change', function () {
        if ($(this).is(':checked')) {
            $("#is_sms").val(1);
            $(".ta-content").html('<label class="col-md-3 col-xs-12 control-label">ISI PESAN</label><div class="col-md-9 col-xs-12"><textarea class="form-control input-content" rows="5" name="content" id="content"></textarea></div>');
        } else {
            $("#is_sms").val(0);
            $(".ta-content").html("");
        }
    });
    $('#is_upload').on('change', function () {
        if ($(this).is(':checked')) {
            $("#is_upload").val(1);
            $("#upload-file").show();
        } else {
            $("#is_upload").val(0);
            $("#upload-file").hide();
        }
    });

</script>
<script>
    Dropzone.autoDiscover = false;
    $("#my-awesome-dropzone").dropzone({
        removeAllFiles: true,
        url: '<?php echo base_url('service/act_respond'); ?>',
        autoProcessQueue: false,
        uploadMultiple: true,
        parallelUploads: 5,
        maxFiles: 5,
        maxFilesize: 1,
        acceptedFiles: 'image/*',
        addRemoveLinks: true,
        init: function () {
            dzClosure = this; // Makes sure that 'this' is understood inside the functions below.

            $("#save_respond").on("click", function (e) {
                e.preventDefault();
                e.stopPropagation();

                if (dzClosure.getQueuedFiles().length > 0) {
                    dzClosure.processQueue();
                } else {
                    submitMyFormWithData('<?php echo base_url('service/act_respond'); ?>');
                }
            });

            //send all the form data along with the files:
            this.on("sendingmultiple", function (data, xhr, formData) {
                var form_Data = $("#form-respond").serializeArray();
                $.each(form_Data, function (i, field) {
                    formData.append(field.name, field.value);
                });
            });

            this.on("success", function (file, response) {
                var obj = jQuery.parseJSON(response)
                is_sms = $("#is_sms").val();
                is_upload = $("#is_upload").val();
                if (obj == 'success') {
                    updateInbox($('.in_id').val(), 'responded', $('.responded').val(), $('.indate').val());
                    if (is_sms == 1) {
                        updateInbox($('.in_id').val(), 'replied', $('.replied').val(), $('.indate').val());
                        information = 'Pesan Telah dikirim ke ' + $('.receiver').val();
                    } else {
                        information = 'Data Tindak Lanjut berhasil disimpan';
                    }

                    $('.success-sent').html(information);
                    $('#respond-sms').hide();
                    $('#message-box-success').toggleClass("open");
                } else {
                    if (is_sms == 1) {
                        information = 'Pengiriman SMS Tindak Lanjut ke ' + $('.receiver').val() + ' Gagal';
                    } else {
                        information = 'Data Tindak Lanjut Gagal disimpan';
                    }
                    $('.failed-sent').html(information);
                    $('#message-box-danger').toggleClass("open");
                    $('#respond-sms').show();
                }
                this.removeAllFiles();
            });
        }
    });

    function submitMyFormWithData(url)
    {
        is_sms = $("#is_sms").val();
        is_upload = $("#is_upload").val();
        var formData = $("#form-respond").serialize();

        $.ajax({
            url: url,
            data: formData + '&is_sms=' + is_sms + '&is_upload=' + is_upload,
            dataType: 'json',
            async: false,
            type: 'POST',
            success: function (status) {
                if (status == 'success') {
                    updateInbox($('.in_id').val(), 'responded', $('.responded').val(), $('.indate').val());
                    if (is_sms == 1) {
                        updateInbox($('.in_id').val(), 'replied', $('.replied').val(), $('.indate').val());
                        var information = 'Pesan Telah dikirim ke ' + $('.receiver').val();
                    } else {
                        var information = 'Data Tindak Lanjut berhasil disimpan';
                    }

                    $('.success-sent').html(information);
                    $('#respond-sms').hide();
                    $('#message-box-success').toggleClass("open");
                } else {
                    if (is_sms == 1) {
                        var information = 'Pengiriman SMS Tindak Lanjut ke ' + $('.receiver').val() + ' Gagal';
                    } else {
                        var information = 'Data Tindak Lanjut Gagal disimpan';
                    }
                    $('.failed-sent').html(information);
                    $('#message-box-danger').toggleClass("open");
                    $('#respond-sms').show();
                }
            }
        });
    }
</script>
<script>
    function updateInbox(id, status, prev_status, date) {
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url('service/updateInboxStatus'); ?>',
            data: 'message_id= ' + id + '&status=' + status + '&prev_status=' + prev_status + '&indate=' + date,
            dataType: 'json',
            async: false,
        });
    }
</script>
