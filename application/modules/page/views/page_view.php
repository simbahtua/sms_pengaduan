<div class="col-md-12">
    <div class="panel-heading">
        <div class="panel-title-box">
            <h3>SMS Pengaduan</h3>
        </div>                                    
    </div>  
</div>
<div class="col-md-12">
    <div class="panel panel-default">
        <div class="page-content-wrap">
            <div class="row">
                <br>
                <?php
                if (!empty($query)) {

                    foreach ($query as $row) {
                        if (!empty($row->content)) {
                            $sender = $row->sender;
                            $count = strlen($sender);
                            $jumlah = $count - 3;
                            $number = substr($sender, $jumlah, 3);
                            $sender_replace = str_replace($number, 'xxx', $sender);
                            $date = substr($row->in_datetime, 0, 10);
                            $time = substr($row->in_datetime, 11, 8);

                            $text = substr($row->content, 0, 70);
                            ?>

                            <div class="media">
                                <div class="pull-left">
                                    <span class="fa-stack fa-2x" style="margin-left: 25px;">
                                        <img src="<?php echo $themes_url; ?>img\user\human.jpg" alt="">
                                    </span> 
                                </div>
                                <div class="media-body">
                                    <h4 class="media-heading"><?php echo $sender_replace; ?></h4>
                                    <span class="date"><?php echo $date; ?> - <?php echo $time . ' WIT'; ?></span> 
                                    <p><?php echo $text . '...'; ?></p>
                                </div>
                            </div>
                            <hr>

                            <?php
                        } else {
                            echo "Data sms belum ada";
                            ?>
                            <?php
                        }
                    }
                }
                ?>
            </div>
        </div>
    </div>
</div>
