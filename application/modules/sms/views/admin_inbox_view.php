<style type="text/css">
    thead tr th .center {
        text-align: center;
    }

    tfoot {
        display: table-header-group;
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
                                    <input type="hidden" name='receiver' id='receiver' value=''>
                                    <input type="hidden" name='in_id' id='in_id' value=''>
                                    <input type="hidden" name='notes' id='notes' value=''>
                                    <input type="hidden" name='out_type' id='out_type' value=''>

                                    <div class="form-group">
                                        <label class="col-md-3 col-xs-12 control-label">ISI PESAN</label>
                                        <div class="col-md-6 col-xs-12">
                                            <textarea class="form-control" rows="5" name='content' id='content'></textarea>
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


<div class="page-content-wrap">
    <div class="row">
        <div class="col-md-12">

            <!-- START DEFAULT DATATABLE -->
            <div class="panel panel-default">
                <div class="panel-heading ui-draggable-handle">
                    <h2 class="panel-title"><span class="fa fa-envelope"></span> <?php echo $title; ?></h2>
                    <ul class="panel-controls">
                         <!-- <li><a href="#" class="panel-collapse"><span class="fa fa-angle-down"></span></a></li> -->
                        <li><button class="button panel-refresh"><span class="fa fa-refresh"></span></button></li>
                        <!-- <li><a href="#" class="panel-remove"><span class="fa fa-times"></span></a></li> -->
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
                                    <th class='dt-head-center'>Dibaca</th>
                                    <th class='dt-head-center'>Dibalas</th>
                                    <th class='dt-head-center'>Tindak Lanjut</th>
                                    <th class='dt-head-center'>Action</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th><input  readonly="readonly" type="text" id="5" class="form-control datepicker" size="12" placeholder="Cari Tanggal"></th>
                                    <th class="input_text">Pengirim</th>
                                    <th class="input_text">Isi Pesan</th>
                                    <th class="input_select" id="read_status">Dibaca</th>
                                    <th class="input_select" id="reply_status">Dibalas</th>
                                    <th class="input_select" id="respons_status">Tindak Lanjut</th>
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
<script type="text/javascript" src="<?php echo $themes_url; ?>js/plugins/bootstrap/bootstrap-datepicker.js"></script>

<script>
    $(document).ready(function () {
        $('#example .input_text').each(function () {
            var title = $(this).text();
            var inp = '<input type="text" class="form-control" size="12" placeholder="Cari ' + title + '" />';
            $(this).html(inp);
        });

        $("#example #read_status").html('<select class="form-control" wodth="10" > <option value="def" disabled selected>STATUS</option> <option value="0">Belum</option><option value="1">Sudah</option></select>');
        $("#example #reply_status").html('<select class="form-control" width="10" >   <option value="def" disabled selected>STATUS</option> <option value="0">Belum</option><option value="1">Sudah</option></select>');
        $("#example #respons_status").html('<select class="form-control" wodth="10">  <option value="def" disabled selected>STATUS</option> <option value="0">Belum</option><option value="1">Sudah</option></select>');

        var table = $("#example").DataTable({
            responsive: true,
            colReorder: true,
            columns: [
                {"name": "in_datetime"},
                {"name": "sender"},
                {"name": "content"},
                {"name": "read_status"},
                {"name": "reply_status"},
                {"name": "respons_status"},
                {"name": "action", 'sortable': false},
            ],
            order: [[0, "desc"]],
            processing: true,
            serverSide: true,
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
            columnDefs: [
                {
                    width: "8%", targets: 0,
                    width: "8%", targets: 1,
                    width: "40%", targets: 2,
                }
            ],
        });

        // Apply the search
        table.columns().every(function () {
            var that = this;

            $('input', this.footer()).on('keyup change', function () {
                if (that.search() !== this.value) {
                    that
                            .search(this.value)
                            .draw();
                }
            });

            $('select', this.footer()).on('change', function () {
                if (that.search() !== this.value) {
                    that
                            .search(this.value)
                            .draw();
                }
            });
        });

    });

    $(".panel-refresh").on("click", function () {
        var panel = $(this).parents(".panel");
        panel_refresh(panel);

        setTimeout(function () {
            panel_refresh(panel);
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
//        $("input").val("");
        table.search('').draw();
    }
    $(function () {
        $(".datepicker").datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true
        });
    });
</script>
<script>
    $(document).ready(function () {
        var panel = $(this).parents(".panel");
        $('#replysms').on('shown.bs.modal', function (event) { // id of the modal with event

            button = $(event.relatedTarget); // Button that triggered the modal
            content = button.data('content');
            sender = button.data('senderphone');
            readed = button.data('readed');
            messageID = button.data('id');
            notes = 'Balasan Aduan dari ' + sender + ', tentang : ' + content;
            $('#receiver').val(sender);
            $('#in_id').val(messageID);
            $('#notes').val(notes);
            $('#out_type').val('reply');

            status = 'readed';
            updateInbox(messageID, status);
            $('.modal-title').html('<div class="alert alert-info" >PESAN DARI ' + sender + ' </div>');
            $('.message_content').html('<div class="alert alert-success"> ISI PESAN : <br><blockquote>' + content + '</blockquote> </div>');
        });


        $(".modal").on('hidden.bs.modal', function(){
            panel_refresh(panel);
        } );


        $("#send-reply").click(function (e) {
            e.preventDefault();
            var form_data = $("#form-reply").serialize();
//            console.log(form_data);
//            alert(form_data);
            $.ajax({
                type: 'POST',
                url: '<?php echo base_url('service/insert_outbox'); ?>',
                data: form_data,
                dataType: 'json',
                async: false,
                success: function (response) {
//                    alert(response['status']);
                    if(response['status'] == 'success') {
                        updateInbox($('#in_id').val(),'replied');
                        alert('Pesan Telah dikirim ke ' + $('#receiver').val());
                    }else{
                        alert('Pesan Gagal dikirim ke ' + $('#receiver').val());
                    }
                }
            });
        });

        function updateInbox(id, status) {
            $.ajax({
                type: 'POST',
                url: '<?php echo base_url('service/updateInboxStatus'); ?>',
                data: 'message_id= ' + id + '&status=' + status,
                dataType: 'json',
                async: false,
            });
        }

    });
</script>
