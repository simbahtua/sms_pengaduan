<style>
.kanan {
    padding-right:10px;
}
</style>
<div class="panel panel-default">
    <div class="panel-heading">
        <h2 class="panel-title"><span class="fa fa-info-circle"></span>DASHBOARD</h2>
        <ul class="panel-controls">
            <li><button class="button panel-refresh"><span class="fa fa-refresh"></span></button></li>
        </ul>
    </div>
    <div class="panel-body response-data">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <div class="panel-title-box">
                            <h3>INFO CREDIT </h3>
                        </div>

                    </div>
                    <div class="panel-body padding-0">
                        <div class="row" id="credit-info">
                            <div class="col-md-6">
                                <div class="widget widget-warning widget-item-icon">
                                   <div class="widget-item-left">
                                       <span class="fa fa-credit-card"></span>
                                   </div>
                                   <div class="widget-data">
                                       <div class="widget-title">Saldo Kredit SMS</div>
                                       <div class="widget-int num-count kanan" style="text-align:right;" id="credit-value"></div>
                                   </div>
                               </div>
                            </div>
                            <div class="col-md-6">
                                <div class="widget widget-warning widget-item-icon">
                                   <div class="widget-item-left">
                                       <span class="fa fa-calendar"></span>
                                   </div>
                                   <div class="widget-data">
                                       <div class="widget-title">MASA AKTIF</div>
                                       <div class="widget-subtitle">Aktif sampai dengan</div>
                                       <div class="widget-title kanan" style="text-align:right;font-size:20px;" id="credit-active"></div>
                                   </div>
                               </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <div class="panel-title-box">
                            <h3>INFO SMS ADUAN HARI INI </h3>
                        </div>
                    </div>
                    <div class="panel-body padding-0">

                        <div class="widget widget-warning widget-carousel">
                            <div class="owl-carousel" id="owl-example">
                                <div>
                                    <div class="widget-title">TOTAL ADUAN</div>
                                    <div class="widget-subtitle"></div>
                                    <div class="widget-int" id="today-in">0 </div>
                                </div>
                                <div>
                                    <div class="widget-title">TOTAL DIBACA</div>
                                    <div class="widget-subtitle"></div>
                                    <div class="widget-int" id="today-read">0 </div>
                                </div>
                                <div>
                                    <div class="widget-title">TOTAL DIBALAS</div>
                                    <div class="widget-subtitle"></div>
                                    <div class="widget-int" id="today-reply">0 </div>
                                </div>
                                <div>
                                    <div class="widget-title">TOTAL DI FOLLOW UP</div>
                                    <div class="widget-subtitle"></div>
                                    <div class="widget-int" id="today-responds">0 </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <div class="panel-title-box">
                            <h3>INFO SMS ADUAN BULAN INI </h3>
                        </div>
                    </div>
                    <div class="panel-body padding-0">

                        <div class="widget widget-warning widget-carousel">
                            <div class="owl-carousel" id="owl-example">
                                <div>
                                    <div class="widget-title">TOTAL ADUAN</div>
                                    <div class="widget-subtitle"></div>
                                    <div class="widget-int" id="monthly-in">0 </div>
                                </div>
                                <div>
                                    <div class="widget-title">TOTAL DIBACA</div>
                                    <div class="widget-subtitle"></div>
                                    <div class="widget-int" id="monthly-read">0 </div>
                                </div>
                                <div>
                                    <div class="widget-title">TOTAL DIBALAS</div>
                                    <div class="widget-subtitle"></div>
                                    <div class="widget-int" id="monthly-reply"> </div>
                                </div>
                                <div>
                                    <div class="widget-title">TOTAL DI FOLLOW UP</div>
                                    <div class="widget-subtitle"></div>
                                    <div class="widget-int" id="monthly-responds">0 </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <div class="panel-title-box">
                            <h3>INFO SUMMARY SMS ADUAN </h3>
                        </div>
                    </div>
                    <div class="panel-body padding-0">

                        <div class="widget widget-warning widget-carousel">
                            <div class="owl-carousel" id="owl-example">
                                <div>
                                    <div class="widget-title">TOTAL ADUAN</div>
                                    <div class="widget-subtitle"></div>
                                    <div class="widget-int" id="summary-in">0 </div>
                                </div>
                                <div>
                                    <div class="widget-title">TOTAL DIBACA</div>
                                    <div class="widget-subtitle"></div>
                                    <div class="widget-int" id="summary-read">0 </div>
                                </div>
                                <div>
                                    <div class="widget-title">TOTAL DIBALAS</div>
                                    <div class="widget-subtitle"></div>
                                    <div class="widget-int" id="summary-reply">0 </div>
                                </div>
                                <div>
                                    <div class="widget-title">TOTAL DI FOLLOW UP</div>
                                    <div class="widget-subtitle"></div>
                                    <div class="widget-int" id="summary-responds">0 </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        var panel = $(this).parents(".panel");
        panel.append('<div class="panel-refresh-layer"><img src="<?php echo $themes_url; ?>img/loaders/default.gif"/></div>');
        setInterval(function () {
            get_dashboard_info();
        }, 60000);
        $.ajaxSetup({cache: false});
        get_dashboard_info();
    });

    function get_dashboard_info() {
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url('service/dashboard_info'); ?>',
            dataType: 'json',
            async: false,
            success : function(response) {
                var credit = response['credit'];
                var daily = response['daily'];
                var monthly = response['monthly'];
                var summary = response['all'];

                $('#credit-value').html(credit['value']);
                $('#credit-active').html(credit['activedate']);

                $("#today-in").html(daily['in_count']);
                $("#today-read").html(daily['read_count']);
                $("#today-reply").html(daily['reply_count']);
                $("#today-responds").html(daily['respons_count']);

                $("#monthly-in").html(monthly['in_count']);
                $("#monthly-read").html(monthly['read_count']);
                $("#monthly-reply").html(monthly['reply_count']);
                $("#monthly-responds").html(monthly['respons_count']);

                $("#summary-in").html(summary['in_count']);
                $("#summary-read").html(summary['read_count']);
                $("#summary-reply").html(summary['reply_count']);
                $("#summary-responds").html(summary['respons_count']);
            }
        })
    }
    
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
    }
</script>
