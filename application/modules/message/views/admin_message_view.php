<!-- PAGE TITLE -->
<div class="page-title">
    <h2><span class="fa fa-envelope"></span> <?php echo $title ; ?></h2>
</div>

<div class="row">
    <div class="col-md-12">

        <!-- START DEFAULT DATATABLE -->
        <div class="panel panel-default">
            <div class="panel-heading">
                <!-- <h3 class="panel-title">Default</h3> -->
                <ul class="panel-controls">
                    <!-- <li><a href="#" class="panel-collapse"><span class="fa fa-angle-down"></span></a></li> -->
                    <li><a href="#" class="panel-refresh"><span class="fa fa-refresh"></span></a></li>
                    <!-- <li><a href="#" class="panel-remove"><span class="fa fa-times"></span></a></li> -->
                </ul>
            </div>
            <div class="panel-body">
                <table id="gridview" class="table responsive datatable">
                    <thead>
                        <tr>
                            <th>No. Pengirim</th>
                            <th>Tanggal</th>
                            <th>Isi Pesan</th>
                            <th>Status Dibaca</th>
                            <th>Status Dibalas</th>
                            <th>Status Tindak Lanjut</th>
                        </tr>
                    </thead>
                    <tbody>
                        
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


<script>

    $('#gridview').DataTable({
        responsive: true,
        columns: [
            { "name": "sender" },
            { "name": "in_datettime" },
            { "name": "content" },
            { "name": "readed" },
            { "name": "replied" },
            { "name": "responded" },
        ],
        order: [[ 'in_datettime', "desc" ]],
        processing: true,
        serverSide: true,
        ajax: {
            url: '<?php echo $this->module_url; ?>/get_data_inbox',
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
        }

    });
    
    
</script>
