<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <title>Detail Aduan</title>
        <style>
            @media print { .notPrinted { display: none; } }

            body, th, td {
                font-family:tahoma, verdana, courier new;
                font-size:9pt;
            }

            small {
                font-size:8pt;
            }

            th, td {
                font-size:9pt;
            }

            .table-id {
                padding:5px 0;
            }

            .table-id td {
                padding:2px 0 2px 0;
                font-size:9pt;
            }

            .table-print {
                border:1px solid #aaa;
                border-right:none;
                border-top:none;
                border-collapse:collapse;
            }

            .table-print th {
                height:25px;
                border-right:1px solid #aaa;
                border-top:1px solid #aaa;
                text-align:center;
                font-weight:normal;
                background:#f0f0f0;
            }

            .table-print td {
                border-right:1px solid #aaa;
                border-top:1px solid #aaa;
                padding:3px 10px;
            }

            .hr11 {
                height:2px;
                border-top:1px solid #aaa;
                border-bottom:1px solid #aaa;
            }

            a {
                color:#ccc;
                font-size:9pt;
            }
        </style>
    </head>
    <body>
        <h2>Detail Aduan</h2>
        <?php
        if (isset($detail)) {
            ?>

            <table width="100%" class="table-print" border="0" cellpadding="5" cellspacing="0">
                <thead>
                    <tr>
                        <th>Pengirim</th>
                        <th>Aduan</th>
                        <th>Tanggal Aduan</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th><?php echo $detail->sender;?></th>
                        <th><?php echo $detail->content;?></th>
                        <th><?php echo $detail->in_datetime;?></th>
                    </tr>
                </tbody>

            </table>
            <br />
            <center><a href="javascript:print()" class="notPrinted">print</a></center>
            <script>window.print();</script>

        <?php
        }else {
            echo '<div class="error alert alert-danger"><p>Maaf, data tidak tersedia.</p></div>';
        }
        ?>

    </body>
</html>
