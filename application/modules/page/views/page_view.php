<div class="col-md-12">
    <div class="panel-heading">
        <div class="panel-title-box">
            <h3>Tentang Kami</h3>
        </div>                                    
    </div>  
</div>
<div class="col-md-12">

    <!-- START USERS ACTIVITY BLOCK -->
    <div class="panel panel-default">



        <div class="page-content-wrap">



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

                        $text = substr($row->content, 0, 50);
                        ?>
                        <div class="panel-body">

                            <div class="messages messages-img">
                                <div class="item item-visible">
                                    <div class="image">
                                        <img src="<?php echo $themes_url; ?>img\user\human.jpg" alt="">
                                    </div>                                
                                    <div class="text">
                                        <div class="heading">
                                            <a href="#"><?php echo $sender_replace; ?></a>
                                            <span class="date"><?php echo $date; ?> - <?php echo $time . ' WIT'; ?></span>  
                                        </div>                                    
                                        <?php echo $text . '...'; ?>
                                    </div>
                                </div>

                            </div>
                        </div>
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
