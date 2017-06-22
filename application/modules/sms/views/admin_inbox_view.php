<style>
#example thead,
#example .center {text-align: center;}
</style>

<div class="page-content-wrap">
    <div class="row">
        <div class="col-md-12">

            <!-- START DEFAULT DATATABLE -->
            <div class="panel panel-default">
                <div class="panel-heading ui-draggable-handle">
                    <h2 class="panel-title"><span class="fa fa-envelope"></span> <?php echo $title; ?></h2>
                   <ul class="panel-controls">
                        <!-- <li><a href="#" class="panel-collapse"><span class="fa fa-angle-down"></span></a></li> -->
                        <li><a href="#" class="panel-refresh"><span class="fa fa-refresh"></span></a></li>
                        <!-- <li><a href="#" class="panel-remove"><span class="fa fa-times"></span></a></li> -->
                    </ul>
                </div>
                <div class="panel-body">
                    <div class="dataTables_wrapper no-footer">
                        <table class="table table-striped table-bordered nofooter" id="example" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Tanggal</th>
                                    <th>No. Pengirim</th>
                                    <th>Isi Pesan</th>
                                    <th class='center'>Status Dibaca</th>
                                    <th class='center'>Status Dibalas</th>
                                    <th class='center'>Status Tindak Lanjut</th>
                                    <!-- <th class='center'>Action</th> -->
                                </tr>
                            </thead>

                            <tfoot>
                                <tr>
                                    <th class="input_text">Tanggal</th>
                                    <th class="input_text">No. Pengirim</th>
                                    <th class="input_text">Isi Pesan</th>
                                    <th class="input_select" id="read_status">Status Dibaca</th>
                                    <th class="input_select" id="reply_status">Status Dibalas</th>
                                    <th class="input_select" id="respons_status">Status Tindak Lanjut</th>
                                    <!-- <th></th> -->
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

<script>
$(document).ready(function() {
    $('#example .input_text').each(function () {
        var title = $(this).text();
        var inp = '<input type="text" class="form-control" size="12" placeholder="Cari ' + title + '" />';
        $(this).html(inp);
    });


    $("#example #read_status").html('<select class="form-control" wodth="10" > <option value="" disabled selected>Status Dibaca</option> <option value="0">Belum Dibaca</option><option value="1">Sudah Dibaca</option></select>');
    $("#example #reply_status").html('<select class="form-control" width="10" >   <option value="" disabled selected>Status Dibalas</option> <option value="0">Belum Dibaca</option><option value="1">Sudah Dibaca</option></select>');
    $("#example #respons_status").html('<select class="form-control" wodth="10">  <option value="" disabled selected>Status Tindak Lanjut</option> <option value="0">Belum Dibaca</option><option value="1">Sudah Dibaca</option></select>');


    var table = $("#example").DataTable( {
       responsive: true,
       columns: [
           { "name": "in_datetime" },
           { "name": "sender" },
           { "name": "content" },
           { "name": "read_status" },
           { "name": "reply_status" },
           { "name": "respons_status" },
       ],
       order: [[ 0, "desc" ]],
       processing: true,
       serverSide: true,
       ajax: {
           url: '<?php echo $service_url; ?>',
           type:'POST'
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
           { width: 400, targets: 2 }
       ],

    } );

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
    });

} );
</script>

<script>
$(".panel-refresh").on("click",function(){
       var panel = $(this).parents(".panel");
       panel_refresh(panel);

       setTimeout(function(){
           panel_refresh(panel);
       },3000);

       $(this).parents(".dropdown").removeClass("open");
       return false;
   });


   function panel_refresh(panel,action,callback){
    if(!panel.hasClass("panel-refreshing")){
        panel.append('<div class="panel-refresh-layer"><img src="<?php echo $themes_url;?>img/loaders/default.gif"/></div>');
        panel.find(".panel-refresh-layer").width(panel.width()).height(panel.height());
        panel.addClass("panel-refreshing");

        if(action && action === "shown" && typeof callback === "function")
            callback();
    }else{
        panel.find(".panel-refresh-layer").remove();
        panel.removeClass("panel-refreshing");
        if(action && action === "hidden" && typeof callback === "function")
            callback();
    }
    onload();
}
</script>
