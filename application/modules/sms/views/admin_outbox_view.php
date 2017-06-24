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
                                    <th>Penerima</th>
                                    <th>Isi Pesan</th>
                                    <th class='dt-head-center'>Keterangan</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th><input  readonly="readonly" type="text" id="5" class="form-control datepicker" size="12" placeholder="Cari Tanggal"></th>
                                    <th class="input_text">Pengirim</th>
                                    <th class="input_text">Isi Pesan</th>
                                    <th class="input_text">Keterangan</th>
                                    <th class="input_select" id='sending_status'>Status</th>
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
        $("#example #sending_status").html('<select class="form-control" wodth="10" > <option value="def" disabled selected>STATUS</option> <option value="sending">Proses</option><option value="sent">Terkirim</option><option value="failed">Gagal</option></select>');

        var table = $("#example").DataTable({
            responsive: true,
            colReorder: true,
            columns: [
                {"name": "out_datetime"},
                {"name": "receiver"},
                {"name": "content"},
                {"name": "notes"},
                {"name": "status"},
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