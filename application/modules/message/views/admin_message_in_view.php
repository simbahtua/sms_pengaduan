<div class="page-content-wrap">                

    <div class="row">
        <div class="col-md-12">

            <!-- START DEFAULT DATATABLE -->
            <div class="panel panel-default">
                <div class="panel-heading ui-draggable-handle">                                
                    <h2 class="panel-title"><span class="fa fa-envelope"></span> <?php echo $title; ?></h2>
<!--                    <ul class="panel-controls">
                        <li><a href="#" class="panel-collapse"><span class="fa fa-angle-down"></span></a></li>
                        <li><a href="#" class="panel-refresh"><span class="fa fa-refresh"></span></a></li>
                        <li><a href="#" class="panel-remove"><span class="fa fa-times"></span></a></li>
                    </ul>                                -->
                </div>
                <div class="panel-body">
                    <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper no-footer">
                        <table class="table datatable dataTable no-footer" id="example" role="grid" aria-describedby="DataTables_Table_0_info">
                            <thead>
                                <tr>
                                    <th>sender</th>
                                    <th>content</th>
                                    <th>in_datetime</th>
                                    <th>readed</th>
                                    <th>readed</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>sender</th>
                                    <th>content</th>
                                    <th>in_datetime</th>
                                    <th>readed</th>
                                    <th>readed</th>
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

<script src="<?php echo base_url('assets/js/jquery.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/bootstrap.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/jquery.dataTables.min.js'); ?>"></script>
<script>
    /**
     * Gunaknan ini jika TIDAK ingin menggunakan pencarian perkolom
     */
    // $(document).ready(function() {
    //    $('#example').DataTable({
    //        "processing": true,
    //        "serverSide": true,
    //        "ajax": {
    //            "url": "<?php //echo base_url('karyawan/datatables_ajax'); ?>",
    //            "type": "POST"
    //        }
    //    });
    //  });


    /**
     * Gunaknan ini jika ingin menggunakan pencarian perkolom 
     */
    $(document).ready(function () {
        // Setup - add a text input to each footer cell
        $('#example tfoot th').each(function () {
            var title = $(this).text();
            var inp = '<input type="text" class="form-control" placeholder="Search ' + title + '" />';
            $(this).html(inp);
        });

        // DataTable
        var table = $('#example').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": "<?php echo base_url('message/admin/datatables_inbox') ?>",
                "type": "POST"
            }
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
        });
    });
</script>