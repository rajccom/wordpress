<?php
if (!defined('ABSPATH'))
die('Restricted Access');
wp_enqueue_style('status-graph', WPJOBPORTAL_PLUGIN_URL . 'includes/css/status_graph.css');
wp_enqueue_script('wpjobportal-res-tables', WPJOBPORTAL_PLUGIN_URL . 'includes/js/responsivetable.js');
wp_enqueue_script('wpjobportal-commonjs', WPJOBPORTAL_PLUGIN_URL . 'includes/js/common.js');
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
?>
<script src="<?php echo esc_url($protocol);?>www.google.com/jsapi?autoload={'modules':[{'name':'visualization','version':'1','packages':['corechart']}]}"></script>
<script >
    google.charts.load('current', {'packages':['corechart']});
    google.setOnLoadCallback(drawStackChartHorizontal);
    function drawStackChartHorizontal() {
        var data = google.visualization.arrayToDataTable([
            <?php
                echo wpjobportal::$_data['stack_chart_horizontal']['title'] . ',';
                echo wpjobportal::$_data['stack_chart_horizontal']['data'];
            ?>
        ]);
        var view = new google.visualization.DataView(data);
        var options = {
        curveType: 'function',
                height:286,
                legend: { position: 'top', maxLines: 3 },
                pointSize: 4,
                isStacked: true,
                focusTarget: 'category',
                chartArea: {width:'90%', top:50}
        };
        var chart = new google.visualization.LineChart(document.getElementById("stack_chart_horizontal"));
        chart.draw(view, options);
    }
</script>
<script type="text/javascript" src="https://www.google.com/jsapi?autoload={'modules':[{'name':'visualization','version':'1','packages':['corechart']}]}"></script>
<script>
    google.setOnLoadCallback(drawTodayTicketsChart);
    function drawTodayTicketsChart() {
      var data = google.visualization.arrayToDataTable([
        <?php
            echo wpjobportal::$_data['today_ticket_chart']['title'].',';
            echo wpjobportal::$_data['today_ticket_chart']['data'];
        ?>
      ]);

      var view = new google.visualization.DataView(data);

      var options = {
        height:120,
        chartArea: { width: '80%', left: 30 },
        legend: { position: "top" },
        hAxis: { textPosition: 'none' },
      };
      var chart = new google.visualization.ColumnChart(document.getElementById("today_ticket_chart"));
      chart.draw(view, options);
    }
</script>
<!-- main wrapper -->
<div id="wpjobportaladmin-wrapper">
    <div id="wpjobportaladmin-leftmenu">
        <?php  wpjobportalincluder::getClassesInclude('wpjobportaladminsidemenu'); ?>
    </div>
    <div id="wpjobportaladmin-data">
        <div class="wpjobportal-admin-cp-wrapper">
            <!-- top bar -->
            <div id="wpjobportal-wrapper-top">
                <div id="wpjobportal-wrapper-top-left">
                    <div id="wpjobportal-breadcrumbs">
                        <ul>
                            <li>
                                <a href="<?php echo admin_url('admin.php?page=wpjobportal'); ?>" title="<?php echo __('dashboard','wp-job-portal'); ?>">
                                    <?php echo __('Dashboard','wp-job-portal'); ?>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div id="wpjobportal-wrapper-top-right">
                    <div id="wpjobportal-config-btn">
                        <a href="admin.php?page=wpjobportal_configuration" title="<?php echo __('configuration','wp-job-portal'); ?>">
                            <img src="<?php echo WPJOBPORTAL_PLUGIN_URL; ?>includes/images/control_panel/dashboard/config.png">
                       </a>
                    </div>
                    <div id="wpjobportal-help-btn" class="wpjobportal-help-btn">
                        <a href="admin.php?page=wpjobportal&wpjobportallt=help" title="<?php echo __('help','wp-job-portal'); ?>">
                            <img src="<?php echo WPJOBPORTAL_PLUGIN_URL; ?>includes/images/control_panel/dashboard/help.png">
                       </a>
                    </div>
                    <div id="wpjobportal-vers-txt">
                        <?php echo __('Version','wp-job-portal').': '; ?>
                        <span class="wpjobportal-ver"><?php echo esc_html(WPJOBPORTALincluder::getJSModel('configuration')->getConfigValue('versioncode')); ?></span>
                    </div>
                </div>
            </div>
            <!-- top head -->
            <?php WPJOBPORTALincluder::getTemplate('templates/admin/pagetitle',array('module' => 'wpjobportal' , 'layouts' => 'controlpanel')); ?>
            <!-- page content -->
            <div id="wpjobportal-admin-wrapper" class="p0 bg-n bs-n">
                <!-- page single section wrp -->
                <div class="wpjobportal-cp-cnt-sec">
                    <div class="wpjobportal-cp-cnt-left">
                        <?php
                            $total_companies = 0;
                            $total_resumes = 0;
                            $total_jobs = 0;
                            $total_activeJObs = 0;
                            $overdue_percentage = 0;
                                if(isset(wpjobportal::$_data['totalcompanies']) && !empty(wpjobportal::$_data['totalcompanies'])){
                                    $open_percentage = @round((wpjobportal::$_data['totalapcompanies'] / wpjobportal::$_data['totalcompanies']) * 100);
                                }else{
                                 $open_percentage = 100;
                                }
                                if(isset(wpjobportal::$_data['totaljobs']) && !empty(wpjobportal::$_data['totaljobs'])){
                                    $total_activeJObs =  @round((wpjobportal::$_data['totalactivejobs'] / wpjobportal::$_data['totaljobs']) * 100);
                                }else{
                                    $total_activeJObs = 100;
                                }

                                if(isset(wpjobportal::$_data['totalresume']) && !empty(wpjobportal::$_data['totalresume'])){
                                    $total_resumes =  @round((wpjobportal::$_data['totalapresume'] / wpjobportal::$_data['totalresume']) * 100);
                                }else{
                                    $total_resumes = 100;
                                }

                                if(isset(wpjobportal::$_data['totaljobs']) && !empty(wpjobportal::$_data['totaljobs'])){
                                    $total_jobs =  @round((wpjobportal::$_data['totalnewjobs'] / wpjobportal::$_data['totaljobs']) * 100);
                                }else{
                                    $total_jobs = 100;
                                }
                        ?>
                        <!-- count boxes -->
                        <div class="wpjobportal-count-wrp">
                            <div class="wpjobportal-count-link">
                                <a class="wpjobportal-count-link wpjobportal-count-companies" href="admin.php?page=wpjobportal_company" data-tab-number="1" title="<?php echo __('Active Companies', 'wp-job-portal'); ?>">
                                    <div class="wpjobportal-count-cricle-wrp" data-per="<?php echo esc_attr($open_percentage); ?>" data-tab-number="1">
                                        <div class="js-mr-rp" data-progress="<?php echo esc_attr($open_percentage); ?>">
                                            <div class="circle">
                                                <div class="mask full">
                                                     <div class="fill"></div>
                                                </div>
                                                <div class="mask half">
                                                    <div class="fill"></div>
                                                    <div class="fill fix"></div>
                                                </div>
                                                <div class="shadow"></div>
                                            </div>
                                            <div class="inset">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="wpjobportal-count-link-text">
                                        <?php
                                            echo __('Companies', 'wp-job-portal');
                                            echo ' ( '.esc_html(wpjobportal::$_data['totalapcompanies']).' )';
                                        ?>
                                    </div>
                                </a>
                            </div>
                            <div class="wpjobportal-count-link">
                                <a class="wpjobportal-count-link wpjobportal-count-jobs" href="admin.php?page=wpjobportal_job" data-tab-number="2" title="<?php echo __('Newest Jobs', 'wp-job-portal'); ?>">
                                    <div class="wpjobportal-count-cricle-wrp" data-per="<?php echo esc_attr($total_jobs); ?>" >
                                        <div class="js-mr-rp" data-progress="<?php echo esc_attr($total_jobs); ?>">
                                            <div class="circle">
                                                <div class="mask full">
                                                     <div class="fill"></div>
                                                </div>
                                                <div class="mask half">
                                                    <div class="fill"></div>
                                                    <div class="fill fix"></div>
                                                </div>
                                                <div class="shadow"></div>
                                            </div>
                                            <div class="inset">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="wpjobportal-count-link-text">
                                        <?php
                                            echo __('Newest Jobs', 'wp-job-portal');
                                            echo ' ( '. esc_html(wpjobportal::$_data['totalnewjobs']).' )';
                                        ?>
                                    </div>
                                </a>
                            </div>
                            <div class="wpjobportal-count-link">
                                <a class="wpjobportal-count-link wpjobportal-count-resume" href="admin.php?page=wpjobportal_resume" data-tab-number="3" title="<?php echo __('Active Resume', 'wp-job-portal'); ?>">
                                    <div class="wpjobportal-count-cricle-wrp" data-per="<?php echo esc_attr($total_resumes); ?>">
                                        <div class="js-mr-rp" data-progress="<?php echo esc_attr($total_resumes); ?>">
                                            <div class="circle">
                                                <div class="mask full">
                                                     <div class="fill"></div>
                                                </div>
                                                <div class="mask half">
                                                    <div class="fill"></div>
                                                    <div class="fill fix"></div>
                                                </div>
                                                <div class="shadow"></div>
                                            </div>
                                            <div class="inset">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="wpjobportal-count-link-text">
                                        <?php
                                            echo __('Resume', 'wp-job-portal');
                                            echo ' ( '. esc_html(wpjobportal::$_data['totalapresume']).' )';
                                        ?>
                                    </div>
                                </a>
                            </div>
                            <div class="wpjobportal-count-link">
                                <a class="wpjobportal-count-link wpjobportal-count-active-jobs" href="admin.php?page=wpjobportal_company" data-tab-number="4" title="<?php echo __('Active Jobs', 'wp-job-portal'); ?>">
                                    <div class="wpjobportal-count-cricle-wrp" data-per="<?php echo esc_attr($total_activeJObs); ?>" >
                                        <div class="js-mr-rp" data-progress="<?php echo esc_attr($total_activeJObs); ?>">
                                            <div class="circle">
                                                <div class="mask full">
                                                     <div class="fill"></div>
                                                </div>
                                                <div class="mask half">
                                                    <div class="fill"></div>
                                                    <div class="fill fix"></div>
                                                </div>
                                                <div class="shadow"></div>
                                            </div>
                                            <div class="inset">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="wpjobportal-count-link-text">
                                        <?php
                                            echo __('Active Jobs', 'wp-job-portal');
                                            echo ' ( '. esc_html(wpjobportal::$_data['totalactivejobs']).' )';
                                        ?>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <!-- statistics -->
                        <div class="wpjobportal-cp-cnt">
                            <div class="wpjobportal-cp-cnt-title">
                                <span class="wpjobportal-cp-cnt-title-txt">
                                    <?php echo __('Statistics', 'wp-job-portal'); ?>
                                    (<?php echo esc_html(wpjobportal::$_data['fromdate']); ?>
                                    <?php echo esc_html(wpjobportal::$_data['curdate']); ?>)
                                </span>
                            </div>
                            <div class="wpjobportal-performance-graph" id="stack_chart_horizontal"></div>
                        </div>
                    </div>
                    <div class="wpjobportal-cp-cnt-right">
                        <!-- today stats -->
                        <div class="wpjobportal-cp-cnt">
                            <div class="wpjobportal-cp-cnt-title">
                                <span class="wpjobportal-cp-cnt-title-txt">
                                    <?php echo __('Today Jobs', 'wp-job-portal'); ?>
                                </span>
                            </div>
                            <div id="today_ticket_chart" class="wpjobportal-today-stats-wrp">
                            </div>
                        </div>
                        <!-- short links -->
                        <div class="wpjobportal-cp-cnt">
                            <div class="wpjobportal-cp-cnt-title">
                                <span class="wpjobportal-cp-cnt-title-txt">
                                    <?php echo __('Short Links', 'wp-job-portal'); ?>
                                </span>
                            </div>
                            <div class="wpjobportal-short-links-wrp">
                                <a title="<?php echo __('configuartion', 'wp-job-portal'); ?>" class="wpjobportal-short-link" href="admin.php?page=wpjobportal_configuration">
                                    <img alt="<?php echo __('configuartion', 'wp-job-portal'); ?>" class="wpjobportal-short-link-img" src="<?php echo WPJOBPORTAL_PLUGIN_URL; ?>includes/images/control_panel/dashboard/admin-left-menu/config.png"/>
                                    <span class="wpjobportal-short-link-text"><?php echo __('Configuartion', 'wp-job-portal'); ?></span>
                                    <img alt="<?php echo __('arrow', 'wp-job-portal'); ?>" class="wpjobportal-short-link-arrow-img" src="<?php echo WPJOBPORTAL_PLUGIN_URL; ?>includes/images/control_panel/dashboard/admin-left-menu/arrows/red.png"/>
                                </a>
                                <a title="<?php echo __('companies', 'wp-job-portal'); ?>" class="wpjobportal-short-link" href="admin.php?page=wpjobportal_company">
                                    <img alt="<?php echo __('companies', 'wp-job-portal'); ?>" class="wpjobportal-short-link-img" src="<?php echo WPJOBPORTAL_PLUGIN_URL; ?>includes/images/control_panel/dashboard/admin-left-menu/companies.png"/>
                                    <span class="wpjobportal-short-link-text"><?php echo __('Companies', 'wp-job-portal'); ?></span>
                                    <img alt="<?php echo __('arrow', 'wp-job-portal'); ?>" class="wpjobportal-short-link-arrow-img" src="<?php echo WPJOBPORTAL_PLUGIN_URL; ?>includes/images/control_panel/dashboard/admin-left-menu/arrows/green.png"/>
                                </a>
                                <a title="<?php echo __('jobs', 'wp-job-portal'); ?>" class="wpjobportal-short-link" href="admin.php?page=wpjobportal_job">
                                    <img alt="<?php echo __('jobs', 'wp-job-portal'); ?>" class="wpjobportal-short-link-img" src="<?php echo WPJOBPORTAL_PLUGIN_URL; ?>includes/images/control_panel/dashboard/admin-left-menu/jobs.png"/>
                                    <span class="wpjobportal-short-link-text"><?php echo __('Jobs', 'wp-job-portal'); ?></span>
                                    <img alt="<?php echo __('arrow', 'wp-job-portal'); ?>" class="wpjobportal-short-link-arrow-img" src="<?php echo WPJOBPORTAL_PLUGIN_URL; ?>includes/images/control_panel/dashboard/admin-left-menu/arrows/dark-blue.png"/>
                                </a>
                                <a title="<?php echo __('resume', 'wp-job-portal'); ?>" class="wpjobportal-short-link" href="admin.php?page=wpjobportal_resume">
                                    <img alt="<?php echo __('resume', 'wp-job-portal'); ?>" class="wpjobportal-short-link-img" src="<?php echo WPJOBPORTAL_PLUGIN_URL; ?>includes/images/control_panel/dashboard/admin-left-menu/resume.png"/>
                                    <span class="wpjobportal-short-link-text"><?php echo __('Resume', 'wp-job-portal'); ?></span>
                                    <img alt="<?php echo __('arrow', 'wp-job-portal'); ?>" class="wpjobportal-short-link-arrow-img" src="<?php echo WPJOBPORTAL_PLUGIN_URL; ?>includes/images/control_panel/dashboard/admin-left-menu/arrows/green.png"/>
                                </a>
                                <?php if(in_array('credits', wpjobportal::$_active_addons)){ ?>
                                    <a title="<?php echo __('credits', 'wp-job-portal'); ?>" class="wpjobportal-short-link" href="admin.php?page=wpjobportal_package">
                                        <img alt="<?php echo __('credits', 'wp-job-portal'); ?>" class="wpjobportal-short-link-img" src="<?php echo WPJOBPORTAL_PLUGIN_URL; ?>includes/images/control_panel/dashboard/admin-left-menu/credits.png"/>
                                        <span class="wpjobportal-short-link-text"><?php echo __('Credits', 'wp-job-portal'); ?></span>
                                        <img alt="<?php echo __('arrow', 'wp-job-portal'); ?>" class="wpjobportal-short-link-arrow-img" src="<?php echo WPJOBPORTAL_PLUGIN_URL; ?>includes/images/control_panel/dashboard/admin-left-menu/arrows/orange.png"/>
                                    </a>
                                <?php } /* ?>
                                <a title="<?php echo __('trannslations', 'wp-job-portal'); ?>" class="wpjobportal-short-link" href="admin.php?page=wpjobportal&wpjobportallt=translations">
                                    <img alt="<?php echo __('trannslations', 'wp-job-portal'); ?>" class="wpjobportal-short-link-img" src="<?php echo WPJOBPORTAL_PLUGIN_URL; ?>includes/images/control_panel/dashboard/admin-left-menu/trannslations.png"/>
                                    <span class="wpjobportal-short-link-text"><?php echo __('Trannslations', 'wp-job-portal'); ?></span>
                                    <img alt="<?php echo __('arrow', 'wp-job-portal'); ?>" class="wpjobportal-short-link-arrow-img" src="<?php echo WPJOBPORTAL_PLUGIN_URL; ?>includes/images/control_panel/dashboard/admin-left-menu/arrows/purple.png"/>
                                </a> <?php */ ?>
                                <a title="<?php echo __('premium add ons', 'wp-job-portal'); ?>" class="wpjobportal-short-link" href="admin.php?page=wpjobportal_premiumplugin">
                                    <img alt="<?php echo __('ad ons', 'wp-job-portal'); ?>" class="wpjobportal-short-link-img" src="<?php echo WPJOBPORTAL_PLUGIN_URL; ?>includes/images/control_panel/dashboard/admin-left-menu/ad-ons.png"/>
                                    <span class="wpjobportal-short-link-text"><?php echo __('Premium Add Ons', 'wp-job-portal'); ?></span>
                                    <img alt="<?php echo __('arrow', 'wp-job-portal'); ?>" class="wpjobportal-short-link-arrow-img" src="<?php echo WPJOBPORTAL_PLUGIN_URL; ?>includes/images/control_panel/dashboard/admin-left-menu/arrows/dark-blue.png"/>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- page single section wrp -->
                <div class="wpjobportal-cp-cnt-sec wpjobportal-cp-baner">
                    <div class="wpjobportal-cp-baner-cnt">
                        <div class="wpjobportal-cp-banner-tit-bold">
                            <?php echo __('Install Now','wp-job-portal'); ?>
                        </div>
                        <div class="wpjobportal-cp-banner-tit">
                            <?php $data = __('Premium Addons List & Features','wp-job-portal');
                            echo esc_html($data); ?>
                        </div>
                        <div class="wpjobportal-cp-banner-desc">
                            <?php echo __('The best support system plugin for WordPress has everything you need.','wp-job-portal'); ?>
                        </div>
                        <div class="wpjobportal-cp-banner-btn-wrp">
                            <a href="?page=wpjobportal_premiumplugin&wpjobportallt=addonfeatures" class="wpjobportal-cp-banner-btn orange-bg">
                                <?php  $data = __('Add-Ons List','wp-job-portal');
                                echo esc_html($data); ?>
                            </a>
                            <a href="?page=wpjobportal_premiumplugin&wpjobportallt=step1" class="wpjobportal-cp-banner-btn">
                                <?php echo __('Add New Addons','wp-job-portal'); ?>
                            </a>
                        </div>
                    </div>
                    <img class="wpjobportal-cp-baner-img" alt="<?php echo __('addon','wp-job-portal'); ?>" src="<?php echo WPJOBPORTAL_PLUGIN_URL; ?>includes/images/control_panel/dashboard/addon-image.png"/>
                </div>
                <!-- page single section wrp -->
                <div class="wpjobportal-cp-cnt-sec wpjobportal-cp-job-list">
                    <div class="wpjobportal-cp-cnt-title">
                        <span class="wpjobportal-cp-cnt-title-txt">
                            <?php echo __('Latest Jobs','wp-job-portal'); ?>
                        </span>
                        <a href="admin.php?page=wpjobportal_job" class="wpjobportal-cp-cnt-title-btn" title="<?php echo __('view all jobs','wp-job-portal'); ?>">
                            <?php echo __('View All Jobs','wp-job-portal'); ?>
                        </a>
                    </div>
                    <div class="wpjobportal-jobs-list-wrapper">
                        <?php
                        if(isset(wpjobportal::$_data[0]['latestjobs']) && !empty(wpjobportal::$_data[0]['latestjobs'])){
                            foreach (wpjobportal::$_data[0]['latestjobs'] AS $latestjobs) {?>
                            <?php
                                WPJOBPORTALincluder::getTemplate('job/views/admin/joblist',array(
                                    'job' => $latestjobs,
                                    'layout' => '',
                                    'logo' => 'logo'
                                ));
                        }
                     }else{ ?>
                        <div class="wpjobportal_no_record">
                                <?php echo __("No Record Found","wp-job-portal"); ?>
                            </div>
                    <?php } ?>
                    </div>
                </div>
                <!-- page single section wrp -->
                <div class="wpjobportal-cp-cnt-sec wpjobportal-cp-res-ad-sec">
                    <!-- resume list -->
                    <?php $fullwidthclass = "";
                    if(count(wpjobportal::$_active_addons) >= 30 ){
                        $fullwidthclass = "style=width:100% !important";
                    }?>
                    <?php  if(isset(wpjobportal::$_data[0]['latestresumes']) && !empty(wpjobportal::$_data[0]['latestresumes'])){ ?>
                            <div class="wpjobportal-cp-resume-wrp" <?php echo esc_attr($fullwidthclass); ?>>
                                <div class="wpjobportal-cp-cnt-title">
                                    <span class="wpjobportal-cp-cnt-title-txt">
                                        <?php echo __('Latest Resume','wp-job-portal'); ?>
                                    </span>
                                </div>
                                <div class="wpjobportal-resume-list-wrp">
                                    <?php foreach (wpjobportal::$_data[0]['latestresumes'] AS $resume) { ?>
                                        <div class="wpjobportal-resume-list">
                                           <?php
                                            WPJOBPORTALincluder::getTemplate('resume/views/admin/details',array(
                                                'resume' => $resume,
                                                'control' => '',
                                                'arr' => ''
                                            ));
                                           ?>
                                        </div>
                                    <?php } ?>
                                </div>
                                <div class="wpjop-portal-cp-view-btn-wrp">
                                    <a href="admin.php?page=wpjobportal_resume" class="wpjop-portal-cp-view-btn" title="<?php echo __('view all','wp-job-portal'); ?>">
                                        <i class="fa fa-plus"></i>
                                        <?php echo __('View All','wp-job-portal'); ?>
                                    </a>
                                </div>
                            </div>
                    <?php } ?>
                    <!-- add on list -->
                    <?php if(count(wpjobportal::$_active_addons) < 30 ){ ?>
                        <div class="wpjobportal-cp-addon-wrp">
                            <div class="wpjobportal-cp-cnt-title">
                                <span class="wpjobportal-cp-cnt-title-txt">
                                    <?php echo __('Addons','wp-job-portal'); ?>
                                </span>
                            </div>
                            <div class="wpjobportal-cp-addon-list">
                                <?php if ( !in_array('addressdata',wpjobportal::$_active_addons)) { ?>
                                        <div class="wpjobportal-cp-addon">
                                            <div class="wpjobportal-cp-addon-image">
                                                <img class="wpjobportal-cp-addon-img" src="<?php echo WPJOBPORTAL_PLUGIN_URL; ?>includes/images/control_panel/dashboard/addons/address-data.png" alt="<?php echo __('address data','wp-job-portal'); ?>">
                                            </div>
                                            <div class="wpjobportal-cp-addon-cnt">
                                                <div class="wpjobportal-cp-addon-tit">
                                                    <?php echo __('Address Data','wp-job-portal'); ?>
                                                </div>
                                                <div class="wpjobportal-cp-addon-desc">
                                                    <?php echo __('WP Job Portal offers 75,000+ world cities database. Employers and job seekers can easily type and select cities.','wp-job-portal'); ?>
                                                </div>
                                            </div>
                                            <?php $plugininfo = checkWPJPPluginInfo('wp-job-portal-addressdata/wp-job-portal-addressdata.php');
                                                if($plugininfo['availability'] == "1"){
                                                    $text = $plugininfo['text'];
                                                    $url = "plugins.php?s=wp-job-portal-addressdata&plugin_status=inactive";
                                                }elseif($plugininfo['availability'] == "0"){
                                                    $text = $plugininfo['text'];
                                                    $url = "https://wpjobportal.com/product/address-data/";
                                                } ?>
                                                <a href="<?php echo esc_url($url); ?>" class="wpjobportal-cp-addon-btn" title="<?php echo esc_attr($text); ?>">
                                                    <?php echo esc_html($text); ?>
                                                </a>
                                            </div>
                                        <?php } ?>
                                <?php if ( !in_array('sociallogin',wpjobportal::$_active_addons)) { ?>
                                        <div class="wpjobportal-cp-addon">
                                            <div class="wpjobportal-cp-addon-image">
                                                <img class="wpjobportal-cp-addon-img" src="<?php echo WPJOBPORTAL_PLUGIN_URL; ?>includes/images/control_panel/dashboard/addons/social-login.png" alt="<?php echo __('social login','wp-job-portal'); ?>">
                                            </div>
                                            <div class="wpjobportal-cp-addon-cnt">
                                                <div class="wpjobportal-cp-addon-tit">
                                                    <?php echo __('Social Login','wp-job-portal'); ?>
                                                </div>
                                                <div class="wpjobportal-cp-addon-desc">
                                                    <?php echo __('WP Job Portal allows logins from social media. Employer and Job Seekers login into WP Jobs Portal by using their social media Logins.','wp-job-portal'); ?>
                                                </div>
                                            </div>
                                                <?php $plugininfo = checkWPJPPluginInfo('wp-job-portal-sociallogin/wp-job-portal-sociallogin.php');
                                                if($plugininfo['availability'] == "1"){
                                                    $text = $plugininfo['text'];
                                                    $url = "plugins.php?s=wp-job-portal-sociallogin&plugin_status=inactive";
                                                }elseif($plugininfo['availability'] == "0"){
                                                    $text = $plugininfo['text'];
                                                    $url = "https://wpjobportal.com/product/social-login/";
                                                } ?>
                                                <a href="<?php echo esc_url($url); ?>" class="wpjobportal-cp-addon-btn" title="<?php echo esc_attr($text); ?>">
                                                    <?php echo esc_html($text); ?>
                                                </a>
                                        </div>

                                        <?php } ?>

                                <?php if ( !in_array('visitorapplyjob',wpjobportal::$_active_addons)) { ?>
                                    <div class="wpjobportal-cp-addon">
                                        <div class="wpjobportal-cp-addon-image">
                                            <img class="wpjobportal-cp-addon-img" src="<?php echo WPJOBPORTAL_PLUGIN_URL; ?>includes/images/control_panel/dashboard/addons/apply-as-visitor.png" alt="<?php echo __('visitor apply job','wp-job-portal'); ?>">
                                        </div>
                                        <div class="wpjobportal-cp-addon-cnt">
                                            <div class="wpjobportal-cp-addon-tit">
                                                <?php echo __('Visitor Apply Job','wp-job-portal'); ?>
                                            </div>
                                            <div class="wpjobportal-cp-addon-desc">
                                                <?php echo __('WP Job Portal offers a feature for visitors. No need to create a account, job seeker apply to any available job as a visitor.','wp-job-portal'); ?>
                                            </div>
                                        </div>
                                            <?php $plugininfo = checkWPJPPluginInfo('wp-job-portal-visitorapplyjob/wp-job-portal-visitorapplyjob.php');
                                            if($plugininfo['availability'] == "1"){
                                                $text = $plugininfo['text'];
                                                $url = "plugins.php?s=wp-job-portal-visitorapplyjob&plugin_status=inactive";
                                            }elseif($plugininfo['availability'] == "0"){
                                                $text = $plugininfo['text'];
                                                $url = "https://wpjobportal.com/product/apply-as-visitor/";
                                            } ?>
                                            <a href="<?php echo esc_url($url); ?>" class="wpjobportal-cp-addon-btn" title="<?php echo esc_attr($text); ?>">
                                                <?php echo esc_html($text); ?>
                                            </a>
                                    </div>
                                <?php } ?>

                                <?php if ( !in_array('multicompany',wpjobportal::$_active_addons)) { ?>
                                        <div class="wpjobportal-cp-addon">
                                            <div class="wpjobportal-cp-addon-image">
                                                <img class="wpjobportal-cp-addon-img" src="<?php echo WPJOBPORTAL_PLUGIN_URL; ?>includes/images/control_panel/dashboard/addons/companies.png" alt="<?php echo __('companies','wp-job-portal'); ?>">
                                            </div>
                                            <div class="wpjobportal-cp-addon-cnt">
                                                <div class="wpjobportal-cp-addon-tit">
                                                    <?php echo __('Multi Company','wp-job-portal'); ?>
                                                </div>
                                                <div class="wpjobportal-cp-addon-desc">
                                                    <?php echo __('WP Job Portal offers a useful feature for employers to control all his companies in a single account.','wp-job-portal'); ?>
                                                </div>
                                            </div>
                                            <?php $plugininfo = checkWPJPPluginInfo('wp-job-portal-multicompany/wp-job-portal-multicompany.php');
                                            if($plugininfo['availability'] == "1"){
                                                $text = $plugininfo['text'];
                                                $url = "plugins.php?s=wp-job-portal-multicompany&plugin_status=inactive";
                                            }elseif($plugininfo['availability'] == "0"){
                                                $text = $plugininfo['text'];
                                                $url = "https://wpjobportal.com/product/multi_companies/";
                                            } ?>
                                            <a href="<?php echo esc_url($url); ?>" class="wpjobportal-cp-addon-btn" title="<?php echo esc_attr($text); ?>">
                                                <?php echo esc_html($text); ?>
                                            </a>
                                        </div>
                                <?php } ?>
                                 <?php if ( !in_array('featuredcompany',wpjobportal::$_active_addons)) { ?>
                                            <div class="wpjobportal-cp-addon">
                                                <div class="wpjobportal-cp-addon-image">
                                                    <img class="wpjobportal-cp-addon-img" src="<?php echo WPJOBPORTAL_PLUGIN_URL; ?>includes/images/control_panel/dashboard/addons/feature-company.png" alt="<?php echo __('featured company','wp-job-portal'); ?>">
                                                </div>
                                                <div class="wpjobportal-cp-addon-cnt">
                                                    <div class="wpjobportal-cp-addon-tit">
                                                        <?php echo __('Featured Company','wp-job-portal'); ?>
                                                    </div>
                                                    <div class="wpjobportal-cp-addon-desc">
                                                        <?php echo __('WP Job Portal offers an outstanding feature for employers to mark their company as featured. Featured companies shows top of companies list.','wp-job-portal'); ?>
                                                    </div>
                                                </div>
                                                <?php $plugininfo = checkWPJPPluginInfo('wp-job-portal-featuredcompany/wp-job-portal-featuredcompany.php');
                                                if($plugininfo['availability'] == "1"){
                                                    $text = $plugininfo['text'];
                                                    $url = "plugins.php?s=wp-job-portal-featuredcompany&plugin_status=inactive";
                                                }elseif($plugininfo['availability'] == "0"){
                                                    $text = $plugininfo['text'];
                                                    $url = "https://wpjobportal.com/product/featured-company/";
                                                } ?>
                                                <a href="<?php echo esc_url($url); ?>" class="wpjobportal-cp-addon-btn" title="<?php echo esc_attr($text); ?>">
                                                    <?php echo esc_html($text); ?>
                                                </a>
                                            </div>
                                        <?php } ?>
                                 <?php if ( !in_array('copyjob',wpjobportal::$_active_addons)) { ?>
                                            <div class="wpjobportal-cp-addon">
                                                <div class="wpjobportal-cp-addon-image">
                                                    <img class="wpjobportal-cp-addon-img" src="<?php echo WPJOBPORTAL_PLUGIN_URL; ?>includes/images/control_panel/dashboard/addons/copy-job.png" alt="<?php echo __('copy job','wp-job-portal'); ?>">
                                                </div>
                                                <div class="wpjobportal-cp-addon-cnt">
                                                    <div class="wpjobportal-cp-addon-tit">
                                                        <?php echo __('Copy Job','wp-job-portal'); ?>
                                                    </div>
                                                    <div class="wpjobportal-cp-addon-desc">
                                                        <?php echo __('WP Job Portal offers a feature for an employer to copy their jobs. Employers can copy their jobs easily.','wp-job-portal'); ?>
                                                    </div>
                                                </div>
                                                <?php $plugininfo = checkWPJPPluginInfo('wp-job-portal-copyjob/wp-job-portal-copyjob.php');
                                                if($plugininfo['availability'] == "1"){
                                                    $text = $plugininfo['text'];
                                                    $url = "plugins.php?s=wp-job-portal-copyjob&plugin_status=inactive";
                                                }elseif($plugininfo['availability'] == "0"){
                                                    $text = $plugininfo['text'];
                                                    $url = "https://wpjobportal.com/product/copy-job/";
                                                } ?>
                                                <a href="<?php echo esc_url($url); ?>" class="wpjobportal-cp-addon-btn" title="<?php echo esc_attr($text); ?>">
                                                    <?php echo esc_html($text); ?>
                                                </a>
                                            </div>
                                <?php } ?>
                                 <?php if ( !in_array('credits',wpjobportal::$_active_addons)) { ?>
                                    <div class="wpjobportal-cp-addon">
                                        <div class="wpjobportal-cp-addon-image">
                                            <img class="wpjobportal-cp-addon-img" src="<?php echo WPJOBPORTAL_PLUGIN_URL; ?>includes/images/control_panel/dashboard/addons/credits.png" alt="<?php echo __('credits','wp-job-portal'); ?>">
                                        </div>
                                        <div class="wpjobportal-cp-addon-cnt">
                                            <div class="wpjobportal-cp-addon-tit">
                                                <?php echo __('Credits','wp-job-portal'); ?>
                                            </div>
                                            <div class="wpjobportal-cp-addon-desc">
                                                <?php echo __('WP Job Portal offers a feature for admin to add multiple credit system against particular actions. Admin can add multiple packages against particular actions.','wp-job-portal'); ?>
                                            </div>
                                        </div>
                                        <?php
                                        $plugininfo = checkWPJPPluginInfo('wp-job-portal-credits/wp-job-portal-credits.php');
                                        if($plugininfo['availability'] == "1"){
                                            $text = $plugininfo['text'];
                                            $url = "plugins.php?s=wp-job-portal-credits&plugin_status=inactive";
                                        }elseif($plugininfo['availability'] == "0"){
                                            $text = $plugininfo['text'];
                                            $url = "https://wpjobportal.com/product/credit-system/";
                                        } ?>
                                        <a href="<?php echo esc_url($url); ?>" class="wpjobportal-cp-addon-btn" title="<?php echo esc_attr($text); ?>">
                                            <?php echo esc_html($text); ?>
                                        </a>
                                    </div>
                                <?php } ?>
                                    <?php if ( !in_array('departments',wpjobportal::$_active_addons)) { ?>
                                            <div class="wpjobportal-cp-addon">
                                                <div class="wpjobportal-cp-addon-image">
                                                    <img class="wpjobportal-cp-addon-img" src="<?php echo WPJOBPORTAL_PLUGIN_URL; ?>includes/images/control_panel/dashboard/addons/departments.png" alt="<?php echo __('department','wp-job-portal'); ?>">
                                                </div>
                                                <div class="wpjobportal-cp-addon-cnt">
                                                    <div class="wpjobportal-cp-addon-tit">
                                                        <?php echo __('Department','wp-job-portal'); ?>
                                                    </div>
                                                    <div class="wpjobportal-cp-addon-desc">
                                                        <?php echo __('WP Job Portal offers this feature to Employes to add multiple departments to better manage his jobs. Job seeker apply to the desired department jobs.','wp-job-portal'); ?>
                                                    </div>
                                                </div>
                                                <?php $plugininfo = checkWPJPPluginInfo('wp-job-portal-departments/wp-job-portal-departments.php');
                                                if($plugininfo['availability'] == "1"){
                                                    $text = $plugininfo['text'];
                                                    $url = "plugins.php?s=wp-job-portal-departments&plugin_status=inactive";
                                                }elseif($plugininfo['availability'] == "0"){
                                                    $text = $plugininfo['text'];
                                                    $url = "https://wpjobportal.com/product/multi_departments/";
                                                } ?>
                                                <a href="<?php echo esc_url($url); ?>" class="wpjobportal-cp-addon-btn" title="<?php echo esc_attr($text); ?>">
                                                    <?php echo esc_html($text); ?>
                                                </a>
                                            </div>
                                        <?php } ?>
                                <?php if ( !in_array('export',wpjobportal::$_active_addons)) { ?>
                                        <div class="wpjobportal-cp-addon">
                                            <div class="wpjobportal-cp-addon-image">
                                                <img class="wpjobportal-cp-addon-img" src="<?php echo WPJOBPORTAL_PLUGIN_URL; ?>includes/images/control_panel/dashboard/addons/export.png" alt="<?php echo __('export','wp-job-portal'); ?>">
                                            </div>
                                            <div class="wpjobportal-cp-addon-cnt">
                                                <div class="wpjobportal-cp-addon-tit">
                                                    <?php echo __('Export','wp-job-portal'); ?>
                                                </div>
                                                <div class="wpjobportal-cp-addon-desc">
                                                    <?php echo __('WP Job Manager offers a feature for Employer and Job Seeker in which they can export Resume information in the form of an excel file easily.','wp-job-portal'); ?>
                                                </div>
                                            </div>
                                            <?php $plugininfo = checkWPJPPluginInfo('wp-job-portal-export/wp-job-portal-export.php');
                                                if($plugininfo['availability'] == "1"){
                                                    $text = $plugininfo['text'];
                                                    $url = "plugins.php?s=wp-job-portal-export&plugin_status=inactive";
                                                }elseif($plugininfo['availability'] == "0"){
                                                    $text = $plugininfo['text'];
                                                    $url = "https://wpjobportal.com/product/export/";
                                                } ?>
                                                <a href="<?php echo esc_url($url); ?>" class="wpjobportal-cp-addon-btn" title="<?php echo esc_attr($text); ?>">
                                                    <?php echo esc_html($text); ?>
                                                </a>
                                        </div>
                                <?php } ?>
                                <?php if ( !in_array('featureresume',wpjobportal::$_active_addons)) { ?>
                                        <div class="wpjobportal-cp-addon">
                                            <div class="wpjobportal-cp-addon-image">
                                                <img class="wpjobportal-cp-addon-img" src="<?php echo WPJOBPORTAL_PLUGIN_URL; ?>includes/images/control_panel/dashboard/addons/featured-resume.png" alt="<?php echo __('feature resume','wp-job-portal'); ?>">
                                            </div>
                                            <div class="wpjobportal-cp-addon-cnt">
                                                <div class="wpjobportal-cp-addon-tit">
                                                    <?php echo __('Feature Resume','wp-job-portal'); ?>
                                                </div>
                                                <div class="wpjobportal-cp-addon-desc">
                                                    <?php echo __('WP Job Portal helps job seekers to make any of his resume as Featured Resume.','wp-job-portal'); ?>
                                                </div>
                                            </div>
                                            <?php $plugininfo = checkWPJPPluginInfo('wp-job-portal-featureresume/wp-job-portal-featureresume.php');
                                                if($plugininfo['availability'] == "1"){
                                                    $text = $plugininfo['text'];
                                                    $url = "plugins.php?s=wp-job-portal-featureresume&plugin_status=inactive";
                                                }elseif($plugininfo['availability'] == "0"){
                                                    $text = $plugininfo['text'];
                                                    $url = "https://wpjobportal.com/product/featured-resume/";
                                                } ?>
                                                <a href="<?php echo esc_url($url); ?>" class="wpjobportal-cp-addon-btn" title="<?php echo esc_attr($text); ?>">
                                                    <?php echo esc_html($text); ?>
                                                </a>
                                        </div>
                                    <?php } ?>
                                <?php if ( !in_array('featuredjob',wpjobportal::$_active_addons)) { ?>
                                        <div class="wpjobportal-cp-addon">
                                            <div class="wpjobportal-cp-addon-image">
                                                <img class="wpjobportal-cp-addon-img" src="<?php echo WPJOBPORTAL_PLUGIN_URL; ?>includes/images/control_panel/dashboard/addons/feature-job.png" alt="<?php echo __('featured job','wp-job-portal'); ?>">
                                            </div>
                                            <div class="wpjobportal-cp-addon-cnt">
                                                <div class="wpjobportal-cp-addon-tit">
                                                    <?php echo __('Featured Job','wp-job-portal'); ?>
                                                </div>
                                                <div class="wpjobportal-cp-addon-desc">
                                                    <?php echo __('WP Job Portal offers a feature for making the jobs as Featured Job. This will help to make it easier for jobseekers to find jobs.','wp-job-portal'); ?>
                                                </div>
                                            </div>
                                            <?php $plugininfo = checkWPJPPluginInfo('wp-job-portal-featuredjob/wp-job-portal-featuredjob.php');
                                                if($plugininfo['availability'] == "1"){
                                                    $text = $plugininfo['text'];
                                                    $url = "plugins.php?s=wp-job-portal-featuredjob&plugin_status=inactive";
                                                }elseif($plugininfo['availability'] == "0"){
                                                    $text = $plugininfo['text'];
                                                    $url = "https://wpjobportal.com/product/featured-job/";
                                                } ?>
                                                <a href="<?php echo esc_url($url); ?>" class="wpjobportal-cp-addon-btn" title="<?php echo esc_attr($text); ?>">
                                                    <?php echo esc_html($text); ?>
                                                </a>
                                        </div>
                                <?php } ?>
                                <?php if ( !in_array('rssfeedback',wpjobportal::$_active_addons)) { ?>
                                    <div class="wpjobportal-cp-addon">
                                        <div class="wpjobportal-cp-addon-image">
                                            <img class="wpjobportal-cp-addon-img" src="<?php echo WPJOBPORTAL_PLUGIN_URL; ?>includes/images/control_panel/dashboard/addons/rss.png" alt="<?php echo __('rss feed','wp-job-portal'); ?>">
                                        </div>
                                        <div class="wpjobportal-cp-addon-cnt">
                                            <div class="wpjobportal-cp-addon-tit">
                                                <?php echo __('Rss Feed','wp-job-portal'); ?>
                                            </div>
                                            <div class="wpjobportal-cp-addon-desc">
                                                <?php echo __('WP Job Portal offers Real Simple Syndication (RSS) to set feeds for the jobs. Everyone can get jobs RSS just by clicking on icon.','wp-job-portal'); ?>
                                            </div>
                                        </div>
                                        <?php $plugininfo = checkWPJPPluginInfo('wp-job-portal-rssfeedback/wp-job-portal-rssfeedback.php');
                                            if($plugininfo['availability'] == "1"){
                                                $text = $plugininfo['text'];
                                                $url = "plugins.php?s=wp-job-portal-rssfeedback&plugin_status=inactive";
                                            }elseif($plugininfo['availability'] == "0"){
                                                $text = $plugininfo['text'];
                                                $url = "https://wpjobportal.com/product/rss-2/";
                                            } ?>
                                            <a href="<?php echo esc_url($url); ?>" class="wpjobportal-cp-addon-btn" title="<?php echo esc_attr($text); ?>">
                                                <?php echo esc_html($text); ?>
                                            </a>
                                    </div>
                                    <?php } ?>
                                <?php if ( !in_array('folder',wpjobportal::$_active_addons)) { ?>
                                        <div class="wpjobportal-cp-addon">
                                            <div class="wpjobportal-cp-addon-image">
                                                <img class="wpjobportal-cp-addon-img" src="<?php echo WPJOBPORTAL_PLUGIN_URL; ?>includes/images/control_panel/dashboard/addons/folders.png" alt="<?php echo __('folder','wp-job-portal'); ?>">
                                            </div>
                                            <div class="wpjobportal-cp-addon-cnt">
                                                <div class="wpjobportal-cp-addon-tit">
                                                    <?php echo __('Folder','wp-job-portal'); ?>
                                                </div>
                                                <div class="wpjobportal-cp-addon-desc">
                                                    <?php echo __('WP Job Portal offers a feature for employers to make folders. Employers can make a folder and copy their resumes into the folders.','wp-job-portal'); ?>
                                                </div>
                                            </div>
                                            <?php $plugininfo = checkWPJPPluginInfo('wp-job-portal-folder/wp-job-portal-folder.php');
                                                if($plugininfo['availability'] == "1"){
                                                    $text = $plugininfo['text'];
                                                    $url = "plugins.php?s=wp-job-portal-folder&plugin_status=inactive";
                                                }elseif($plugininfo['availability'] == "0"){
                                                    $text = $plugininfo['text'];
                                                    $url = "https://wpjobportal.com/product/folders/";
                                                } ?>
                                                <a href="<?php echo esc_url($url); ?>" class="wpjobportal-cp-addon-btn" title="<?php echo esc_attr($text); ?>">
                                                    <?php echo esc_html($text); ?>
                                                </a>
                                        </div>
                                <?php } ?>
                                <?php if ( !in_array('jobalert',wpjobportal::$_active_addons)) { ?>
                                        <div class="wpjobportal-cp-addon">
                                            <div class="wpjobportal-cp-addon-image">
                                                <img class="wpjobportal-cp-addon-img" src="<?php echo WPJOBPORTAL_PLUGIN_URL; ?>includes/images/control_panel/dashboard/addons/job-alert.png" alt="<?php echo __('job alert','wp-job-portal'); ?>">
                                            </div>
                                            <div class="wpjobportal-cp-addon-cnt">
                                                <div class="wpjobportal-cp-addon-tit">
                                                    <?php echo __('Job Alert','wp-job-portal'); ?>
                                                </div>
                                                <div class="wpjobportal-cp-addon-desc">
                                                    <?php echo __('WP Job Portal allows registered users to save their job searches and create alerts that send new jobs via email daily, weekly or fortnightly.','wp-job-portal'); ?>
                                                </div>
                                            </div>
                                            <?php $plugininfo = checkWPJPPluginInfo('wp-job-portal-jobalert/wp-job-portal-jobalert.php');
                                                if($plugininfo['availability'] == "1"){
                                                    $text = $plugininfo['text'];
                                                    $url = "plugins.php?s=wp-job-portal-jobalert&plugin_status=inactive";
                                                }elseif($plugininfo['availability'] == "0"){
                                                    $text = $plugininfo['text'];
                                                    $url = "https://wpjobportal.com/product/job-alert/";
                                                } ?>
                                                <a href="<?php echo esc_url($url); ?>" class="wpjobportal-cp-addon-btn" title="<?php echo esc_attr($text); ?>">
                                                    <?php echo esc_html($text); ?>
                                                </a>
                                        </div>
                                        <?php } ?>
                                    <?php if ( !in_array('message',wpjobportal::$_active_addons)) { ?>
                                        <div class="wpjobportal-cp-addon">
                                            <div class="wpjobportal-cp-addon-image">
                                                <img class="wpjobportal-cp-addon-img" src="<?php echo WPJOBPORTAL_PLUGIN_URL; ?>includes/images/control_panel/dashboard/addons/messages.png" alt="<?php echo __('message','wp-job-portal'); ?>">
                                            </div>
                                            <div class="wpjobportal-cp-addon-cnt">
                                                <div class="wpjobportal-cp-addon-tit">
                                                    <?php echo __('Message System','wp-job-portal'); ?>
                                                </div>
                                                <div class="wpjobportal-cp-addon-desc">
                                                    <?php echo __('WP Job Portal offers a message system for Employers and Job Seekers. Employers initiate messages on any applied resume.','wp-job-portal'); ?>
                                                </div>
                                            </div>
                                            <?php $plugininfo = checkWPJPPluginInfo('wp-job-portal-message/wp-job-portal-message.php');
                                                if($plugininfo['availability'] == "1"){
                                                    $text = $plugininfo['text'];
                                                    $url = "plugins.php?s=wp-job-portal-message&plugin_status=inactive";
                                                }elseif($plugininfo['availability'] == "0"){
                                                    $text = $plugininfo['text'];
                                                    $url = "https://wpjobportal.com/product/messages/";
                                                } ?>
                                                <a href="<?php echo esc_url($url); ?>" class="wpjobportal-cp-addon-btn" title="<?php echo esc_attr($text); ?>">
                                                    <?php echo esc_html($text); ?>
                                                </a>
                                        </div>
                                    <?php } ?>
                                <?php if ( !in_array('pdf',wpjobportal::$_active_addons)) { ?>
                                        <div class="wpjobportal-cp-addon">
                                            <div class="wpjobportal-cp-addon-image">
                                                <img class="wpjobportal-cp-addon-img" src="<?php echo WPJOBPORTAL_PLUGIN_URL; ?>includes/images/control_panel/dashboard/addons/pdf.png" alt="<?php echo __('pdf','wp-job-portal'); ?>">
                                            </div>
                                            <div class="wpjobportal-cp-addon-cnt">
                                                <div class="wpjobportal-cp-addon-tit">
                                                    <?php echo __('PDF','wp-job-portal'); ?>
                                                </div>
                                                <div class="wpjobportal-cp-addon-desc">
                                                    <?php echo __('WP Job Portal offer a feature for Employer and Job Seekers , which allows them to take PDF of Resume and can save it.','wp-job-portal'); ?>
                                                </div>
                                            </div>
                                            <?php $plugininfo = checkWPJPPluginInfo('wp-job-portal-pdf/wp-job-portal-pdf.php');
                                                if($plugininfo['availability'] == "1"){
                                                    $text = $plugininfo['text'];
                                                    $url = "plugins.php?s=wp-job-portal-pdf&plugin_status=inactive";
                                                }elseif($plugininfo['availability'] == "0"){
                                                    $text = $plugininfo['text'];
                                                    $url = "https://wpjobportal.com/product/pdf/";
                                                } ?>
                                                <a href="<?php echo esc_url($url); ?>" class="wpjobportal-cp-addon-btn" title="<?php echo esc_attr($text); ?>">
                                                    <?php echo esc_html($text); ?>
                                                </a>
                                        </div>
                                    <?php } ?>
                                   <?php if ( !in_array('print',wpjobportal::$_active_addons)) { ?>
                                        <div class="wpjobportal-cp-addon">
                                            <div class="wpjobportal-cp-addon-image">
                                                <img class="wpjobportal-cp-addon-img" src="<?php echo WPJOBPORTAL_PLUGIN_URL; ?>includes/images/control_panel/dashboard/addons/print.png" alt="<?php echo __('print','wp-job-portal'); ?>">
                                            </div>
                                            <div class="wpjobportal-cp-addon-cnt">
                                                <div class="wpjobportal-cp-addon-tit">
                                                    <?php echo __('Print','wp-job-portal'); ?>
                                                </div>
                                                <div class="wpjobportal-cp-addon-desc">
                                                    <?php echo __('WP Job Portal offers a Resume and print feature. Employer and Job Seeker can view the Resume page or take a print of the Resume.','wp-job-portal'); ?>
                                                </div>
                                            </div>
                                            <?php $plugininfo = checkWPJPPluginInfo('wp-job-portal-print/wp-job-portal-print.php');
                                                if($plugininfo['availability'] == "1"){
                                                    $text = $plugininfo['text'];
                                                    $url = "plugins.php?s=wp-job-portal-print&plugin_status=inactive";
                                                }elseif($plugininfo['availability'] == "0"){
                                                    $text = $plugininfo['text'];
                                                    $url = "https://wpjobportal.com/product/print/";
                                                } ?>
                                                <a href="<?php echo esc_url($url); ?>" class="wpjobportal-cp-addon-btn" title="<?php echo esc_attr($text); ?>">
                                                    <?php echo esc_html($text); ?>
                                                </a>
                                        </div>
                                    <?php } ?>
                                      <?php if ( !in_array('reports',wpjobportal::$_active_addons)) { ?>
                                                <div class="wpjobportal-cp-addon">
                                                    <div class="wpjobportal-cp-addon-image">
                                                        <img class="wpjobportal-cp-addon-img" src="<?php echo WPJOBPORTAL_PLUGIN_URL; ?>includes/images/control_panel/dashboard/addons/reports.png" alt="<?php echo __('reports','wp-job-portal'); ?>">
                                                    </div>
                                                    <div class="wpjobportal-cp-addon-cnt">
                                                        <div class="wpjobportal-cp-addon-tit">
                                                            <?php echo __('Report\'s','wp-job-portal'); ?>
                                                        </div>
                                                        <div class="wpjobportal-cp-addon-desc">
                                                            <?php echo __('WP Job Portal offers multiple reports by jobs, by companies and by resume. Admin can see overall reports of Employer and Job Seeker.','wp-job-portal'); ?>
                                                        </div>
                                                    </div>
                                                    <?php $plugininfo = checkWPJPPluginInfo('wp-job-portal-reports/wp-job-portal-reports.php');
                                                        if($plugininfo['availability'] == "1"){
                                                            $text = $plugininfo['text'];
                                                            $url = "plugins.php?s=wp-job-portal-reports&plugin_status=inactive";
                                                        }elseif($plugininfo['availability'] == "0"){
                                                            $text = $plugininfo['text'];
                                                            $url = "https://wpjobportal.com/product/reports/";
                                                        } ?>
                                                        <a href="<?php echo esc_url($url); ?>" class="wpjobportal-cp-addon-btn" title="<?php echo esc_attr($text); ?>">
                                                            <?php echo esc_html($text); ?>
                                                        </a>
                                                </div>
                                            <?php } ?>
                                     <?php if ( !in_array('resumeaction',wpjobportal::$_active_addons)) { ?>
                                            <div class="wpjobportal-cp-addon">
                                                <div class="wpjobportal-cp-addon-image">
                                                    <img class="wpjobportal-cp-addon-img" src="<?php echo WPJOBPORTAL_PLUGIN_URL; ?>includes/images/control_panel/dashboard/addons/resume-actions.png" alt="<?php echo __('resume action','wp-job-portal'); ?>">
                                                </div>
                                                <div class="wpjobportal-cp-addon-cnt">
                                                    <div class="wpjobportal-cp-addon-tit">
                                                        <?php echo __('Resume Action','wp-job-portal'); ?>
                                                    </div>
                                                    <div class="wpjobportal-cp-addon-desc">
                                                        <?php echo __('WP Job Portal offers a feature for employers to perform some actions on resumes. Employer mark shortlisted, hired, spam, add a note on the applied resume.','wp-job-portal'); ?>
                                                    </div>
                                                </div>
                                                <?php $plugininfo = checkWPJPPluginInfo('wp-job-portal-resumeaction/wp-job-portal-resumeaction.php');
                                                    if($plugininfo['availability'] == "1"){
                                                        $text = $plugininfo['text'];
                                                        $url = "plugins.php?s=wp-job-portal-resumeaction&plugin_status=inactive";
                                                    }elseif($plugininfo['availability'] == "0"){
                                                        $text = $plugininfo['text'];
                                                        $url = "https://wpjobportal.com/product/resume-action/";
                                                    } ?>
                                                    <a href="<?php echo esc_url($url); ?>" class="wpjobportal-cp-addon-btn" title="<?php echo esc_attr($text); ?>">
                                                        <?php echo esc_attr($text); ?>
                                                    </a>
                                            </div>
                                    <?php } ?>
                            <?php if ( !in_array('multiresume',wpjobportal::$_active_addons)) { ?>
                                    <div class="wpjobportal-cp-addon">
                                        <div class="wpjobportal-cp-addon-image">
                                            <img class="wpjobportal-cp-addon-img" src="<?php echo WPJOBPORTAL_PLUGIN_URL; ?>includes/images/control_panel/dashboard/addons/resume-manager.png" alt="<?php echo __('multi resume','wp-job-portal'); ?>">
                                        </div>
                                        <div class="wpjobportal-cp-addon-cnt">
                                            <div class="wpjobportal-cp-addon-tit">
                                                <?php echo __('Multi Resume','wp-job-portal'); ?>
                                            </div>
                                            <div class="wpjobportal-cp-addon-desc">
                                                <?php echo __('WP Job Portal offers a feature for the job seeker to add multiple resumes. Job seeker have a choice on which job which resume to apply.','wp-job-portal'); ?>
                                            </div>
                                        </div>
                                        <?php $plugininfo = checkWPJPPluginInfo('wp-job-portal-multiresume/wp-job-portal-multiresume.php');
                                            if($plugininfo['availability'] == "1"){
                                                $text = $plugininfo['text'];
                                                $url = "plugins.php?s=wp-job-portal-multiresume&plugin_status=inactive";
                                            }elseif($plugininfo['availability'] == "0"){
                                                $text = $plugininfo['text'];
                                                $url = "https://wpjobportal.com/product/multi-resume/";
                                            } ?>
                                            <a href="<?php echo esc_url($url); ?>" class="wpjobportal-cp-addon-btn" title="<?php echo esc_attr($text); ?>">
                                                <?php echo esc_html($text); ?>
                                            </a>
                                    </div>
                            <?php } ?>
                            <?php if ( !in_array('resumesearch',wpjobportal::$_active_addons)) { ?>
                                    <div class="wpjobportal-cp-addon">
                                        <div class="wpjobportal-cp-addon-image">
                                            <img class="wpjobportal-cp-addon-img" src="<?php echo WPJOBPORTAL_PLUGIN_URL; ?>includes/images/control_panel/dashboard/addons/resume-search.png" alt="<?php echo __('resume search','wp-job-portal'); ?>">
                                        </div>
                                        <div class="wpjobportal-cp-addon-cnt">
                                            <div class="wpjobportal-cp-addon-tit">
                                                <?php echo __('Resume Search','wp-job-portal'); ?>
                                            </div>
                                            <div class="wpjobportal-cp-addon-desc">
                                                <?php echo __('This add-on offers to the employer to search the resume in the system with multiple criteria.','wp-job-portal'); ?>
                                            </div>
                                        </div>
                                        <?php $plugininfo = checkWPJPPluginInfo('wp-job-portal-resumesearch/wp-job-portal-resumesearch.php');
                                            if($plugininfo['availability'] == "1"){
                                                $text = $plugininfo['text'];
                                                $url = "plugins.php?s=wp-job-portal-resumesearch&plugin_status=inactive";
                                            }elseif($plugininfo['availability'] == "0"){
                                                $text = $plugininfo['text'];
                                                $url = "https://wpjobportal.com/product/resume-save-search/";
                                            } ?>
                                            <a href="<?php echo esc_url($url); ?>" class="wpjobportal-cp-addon-btn" title="<?php echo esc_attr($text); ?>">
                                                <?php echo esc_html($text); ?>
                                            </a>
                                    </div>
                                <?php } ?>
                            <?php if ( !in_array('shortlist',wpjobportal::$_active_addons)) { ?>
                                        <div class="wpjobportal-cp-addon">
                                            <div class="wpjobportal-cp-addon-image">
                                                <img class="wpjobportal-cp-addon-img" src="<?php echo WPJOBPORTAL_PLUGIN_URL; ?>includes/images/control_panel/dashboard/addons/shortlist-job.png" alt="<?php echo __('shortlist','wp-job-portal'); ?>">
                                            </div>
                                            <div class="wpjobportal-cp-addon-cnt">
                                                <div class="wpjobportal-cp-addon-tit">
                                                    <?php echo __('Shortlist','wp-job-portal'); ?>
                                                </div>
                                                <div class="wpjobportal-cp-addon-desc">
                                                    <?php echo __('WP Job Portal will help job seekers to shortlist their desired jobs. All shortlisted jobs are available in job seeker dashboard.','wp-job-portal'); ?>
                                                </div>
                                            </div>
                                            <?php $plugininfo = checkWPJPPluginInfo('wp-job-portal-shortlist/wp-job-portal-shortlist.php');
                                                if($plugininfo['availability'] == "1"){
                                                    $text = $plugininfo['text'];
                                                    $url = "plugins.php?s=wp-job-portal-shortlist&plugin_status=inactive";
                                                }elseif($plugininfo['availability'] == "0"){
                                                    $text = $plugininfo['text'];
                                                    $url = "https://wpjobportal.com/product/shortlist-job/";
                                                } ?>
                                                <a href="<?php echo esc_url($url); ?>" class="wpjobportal-cp-addon-btn" title="<?php echo esc_attr($text); ?>">
                                                    <?php echo esc_html($text); ?>
                                                </a>
                                        </div>
                                    <?php } ?>
                            <?php if ( !in_array('socialshare',wpjobportal::$_active_addons)) { ?>
                                        <div class="wpjobportal-cp-addon">
                                            <div class="wpjobportal-cp-addon-image">
                                                <img class="wpjobportal-cp-addon-img" src="<?php echo WPJOBPORTAL_PLUGIN_URL; ?>includes/images/control_panel/dashboard/addons/social-share.png" alt="<?php echo __('social share','wp-job-portal'); ?>">
                                            </div>
                                            <div class="wpjobportal-cp-addon-cnt">
                                                <div class="wpjobportal-cp-addon-tit">
                                                    <?php echo __('Social Share','wp-job-portal'); ?>
                                                </div>
                                                <div class="wpjobportal-cp-addon-desc">
                                                    <?php echo __('WP Job Portal offers a jobs share feature on various social media sites for Employers and Job Seekers.','wp-job-portal'); ?>
                                                </div>
                                            </div>
                                            <?php $plugininfo = checkWPJPPluginInfo('wp-job-portal-socialshare/wp-job-portal-socialshare.php');
                                                if($plugininfo['availability'] == "1"){
                                                    $text = $plugininfo['text'];
                                                    $url = "plugins.php?s=wp-job-portal-socialshare&plugin_status=inactive";
                                                }elseif($plugininfo['availability'] == "0"){
                                                    $text = $plugininfo['text'];
                                                    $url = "https://wpjobportal.com/product/social-share/";
                                                } ?>
                                                <a href="<?php echo esc_url($url); ?>" class="wpjobportal-cp-addon-btn" title="<?php echo esc_attr($text); ?>">
                                                    <?php echo esc_html($text); ?>
                                                </a>
                                        </div>
                                    <?php } ?>
                            <?php if ( !in_array('tag',wpjobportal::$_active_addons)) { ?>
                                        <div class="wpjobportal-cp-addon">
                                            <div class="wpjobportal-cp-addon-image">
                                                <img class="wpjobportal-cp-addon-img" src="<?php echo WPJOBPORTAL_PLUGIN_URL; ?>includes/images/control_panel/dashboard/addons/tags.png" alt="<?php echo __('tags','wp-job-portal'); ?>">
                                            </div>
                                            <div class="wpjobportal-cp-addon-cnt">
                                                <div class="wpjobportal-cp-addon-tit">
                                                    <?php echo __('Tags','wp-job-portal'); ?>
                                                </div>
                                                <div class="wpjobportal-cp-addon-desc">
                                                    <?php echo __('WP Job Portal offers a feature for searching the jobs by tags. Employers will add some tags related to jobs search.','wp-job-portal'); ?>
                                                </div>
                                            </div>
                                            <?php $plugininfo = checkWPJPPluginInfo('wp-job-portal-tag/wp-job-portal-tag.php');
                                                if($plugininfo['availability'] == "1"){
                                                    $text = $plugininfo['text'];
                                                    $url = "plugins.php?s=wp-job-portal-tag&plugin_status=inactive";
                                                }elseif($plugininfo['availability'] == "0"){
                                                    $text = $plugininfo['text'];
                                                    $url = "https://wpjobportal.com/product/tags/";
                                                } ?>
                                                <a href="<?php echo esc_url($url); ?>" class="wpjobportal-cp-addon-btn" title="<?php echo esc_attr($text); ?>">
                                                    <?php echo esc_html($text); ?>
                                                </a>
                                        </div>
                                <?php } ?>
                            <?php if ( !in_array('tellfriend',wpjobportal::$_active_addons)) { ?>
                                        <div class="wpjobportal-cp-addon">
                                            <div class="wpjobportal-cp-addon-image">
                                                <img class="wpjobportal-cp-addon-img" src="<?php echo WPJOBPORTAL_PLUGIN_URL; ?>includes/images/control_panel/dashboard/addons/tell-a-friend.png" alt="<?php echo __('tell friend','wp-job-portal'); ?>">
                                            </div>
                                            <div class="wpjobportal-cp-addon-cnt">
                                                <div class="wpjobportal-cp-addon-tit">
                                                    <?php echo __('Tell Friend','wp-job-portal'); ?>
                                                </div>
                                                <div class="wpjobportal-cp-addon-desc">
                                                    <?php echo __('WP Job Portal offers a feature in which Employer and Job Seekers can share and tell their friends about Jobs by sending them an email.','wp-job-portal'); ?>
                                                </div>
                                            </div>
                                            <?php $plugininfo = checkWPJPPluginInfo('wp-job-portal-departments/wp-job-portal-departments.php');
                                                if($plugininfo['availability'] == "1"){
                                                    $text = $plugininfo['text'];
                                                    $url = "plugins.php?s=wp-job-portal-departments&plugin_status=inactive";
                                                }elseif($plugininfo['availability'] == "0"){
                                                    $text = $plugininfo['text'];
                                                    $url = "https://wpjobportal.com/product/tell-a-friend/";
                                                } ?>
                                                <a href="<?php echo esc_url($url); ?>" class="wpjobportal-cp-addon-btn" title="<?php echo esc_attr($text); ?>">
                                                    <?php echo esc_html($text); ?>
                                                </a>
                                        </div>
                                <?php } ?>
                                <?php if ( !in_array('advanceresumebuilder',wpjobportal::$_active_addons)) { ?>
                                    <div class="wpjobportal-cp-addon">
                                        <div class="wpjobportal-cp-addon-image">
                                            <img class="wpjobportal-cp-addon-img" src="<?php echo WPJOBPORTAL_PLUGIN_URL; ?>includes/images/control_panel/dashboard/addons/resume-manager.png" alt="<?php echo __('advance resume builder','wp-job-portal'); ?>">
                                        </div>
                                        <div class="wpjobportal-cp-addon-cnt">
                                            <div class="wpjobportal-cp-addon-tit">
                                                <?php echo __('Advance Resume Builder','wp-job-portal'); ?>
                                            </div>
                                            <div class="wpjobportal-cp-addon-desc">
                                                <?php echo __('This add-on offers to job seekers create a resume with multiple options like multiple addresses, institutions, employers, references and skills.','wp-job-portal'); ?>
                                            </div>
                                        </div>
                                        <?php $plugininfo = checkWPJPPluginInfo('wp-job-portal-advanceresumebuilder/wp-job-portal-advanceresumebuilder.php');
                                            if($plugininfo['availability'] == "1"){
                                                $text = $plugininfo['text'];
                                                $url = "plugins.php?s=wp-job-portal-advanceresumebuilder&plugin_status=inactive";
                                            }elseif($plugininfo['availability'] == "0"){
                                                $text = $plugininfo['text'];
                                                $url = "https://wpjobportal.com/product/advance-resume-builder/";
                                            } ?>
                                            <a href="<?php echo esc_url($url); ?>" class="wpjobportal-cp-addon-btn" title="<?php echo esc_attr($text); ?>">
                                                <?php echo esc_html($text); ?>
                                            </a>
                                    </div>
                                <?php } ?>
                                <?php if ( !in_array('visitorcanaddjob',wpjobportal::$_active_addons)) { ?>
                                    <div class="wpjobportal-cp-addon">
                                        <div class="wpjobportal-cp-addon-image">
                                            <img class="wpjobportal-cp-addon-img" src="<?php echo WPJOBPORTAL_PLUGIN_URL; ?>includes/images/control_panel/dashboard/addons/visitor-add-job.png" alt="<?php echo __('visitor add job','wp-job-portal'); ?>">
                                        </div>
                                        <div class="wpjobportal-cp-addon-cnt">
                                            <div class="wpjobportal-cp-addon-tit">
                                                <?php echo __('Visitor Add Job','wp-job-portal'); ?>
                                            </div>
                                            <div class="wpjobportal-cp-addon-desc">
                                                <?php echo __('Visitor add job add-on offers guests can add job in the system without logged in the system.','wp-job-portal'); ?>
                                            </div>
                                        </div>
                                        <?php $plugininfo = checkWPJPPluginInfo('wp-job-portal-visitorcanaddjob/wp-job-portal-visitorcanaddjob.php');
                                            if($plugininfo['availability'] == "1"){
                                                $text = $plugininfo['text'];
                                                $url = "plugins.php?s=wp-job-portal-visitorcanaddjob&plugin_status=inactive";
                                            }elseif($plugininfo['availability'] == "0"){
                                                $text = $plugininfo['text'];
                                                $url = "https://wpjobportal.com/product/visitor-add-jobs/";
                                            } ?>
                                            <a href="<?php echo esc_url($url); ?>" class="wpjobportal-cp-addon-btn" title="<?php echo esc_attr($text); ?>">
                                                <?php echo esc_html($text); ?>
                                            </a>
                                    </div>
                                <?php } ?>
                                <?php if ( !in_array('cronjob',wpjobportal::$_active_addons)) { ?>
                                    <div class="wpjobportal-cp-addon">
                                        <div class="wpjobportal-cp-addon-image">
                                            <img class="wpjobportal-cp-addon-img" src="<?php echo WPJOBPORTAL_PLUGIN_URL; ?>includes/images/control_panel/dashboard/addons/cron-job.png" alt="<?php echo __('cron job','wp-job-portal'); ?>">
                                        </div>
                                        <div class="wpjobportal-cp-addon-cnt">
                                            <div class="wpjobportal-cp-addon-tit">
                                                <?php echo __('Cron Job','wp-job-portal'); ?>
                                            </div>
                                            <div class="wpjobportal-cp-addon-desc">
                                                <?php echo __('Cron job adon offers to reduce dependencies on WordPress cron job and support Hosting Panel cron job for WP Job Portal tasks.','wp-job-portal'); ?>
                                            </div>
                                        </div>
                                        <?php $plugininfo = checkWPJPPluginInfo('wp-job-portal-cronjob/wp-job-portal-cronjob.php');
                                            if($plugininfo['availability'] == "1"){
                                                $text = $plugininfo['text'];
                                                $url = "plugins.php?s=wp-job-portal-cronjob&plugin_status=inactive";
                                            }elseif($plugininfo['availability'] == "0"){
                                                $text = $plugininfo['text'];
                                                $url = "https://wpjobportal.com/product/cron-job-copy/";
                                            } ?>
                                            <a href="<?php echo esc_url($url); ?>" class="wpjobportal-cp-addon-btn" title="<?php echo esc_attr($text); ?>">
                                                <?php echo esc_html($text); ?>
                                            </a>
                                    </div>
                                <?php } ?>
                                <?php if ( !in_array('widgets',wpjobportal::$_active_addons)) { ?>
                                    <div class="wpjobportal-cp-addon">
                                        <div class="wpjobportal-cp-addon-image">
                                            <img class="wpjobportal-cp-addon-img" src="<?php echo WPJOBPORTAL_PLUGIN_URL; ?>includes/images/control_panel/dashboard/addons/front-end-widgets.png" height="60px" width="60px" alt="<?php echo __('Front-End Widgets','wp-job-portal'); ?>">
                                        </div>
                                        <div class="wpjobportal-cp-addon-cnt">
                                            <div class="wpjobportal-cp-addon-tit">
                                                <?php echo __('Front-End Widgets','wp-job-portal'); ?>
                                            </div>
                                            <div class="wpjobportal-cp-addon-desc">
                                                <?php echo __('Widgets in WordPress allow you to add content and features in the widgetized areas of your theme.','wp-job-portal'); ?>
                                            </div>
                                        </div>
                                        <?php $plugininfo = checkWPJPPluginInfo('wp-job-portal-widgets/wp-job-portal-widgets.php');
                                            if($plugininfo['availability'] == "1"){
                                                $text = $plugininfo['text'];
                                                $url = "plugins.php?s=wp-job-portal-widgets&plugin_status=inactive";
                                            }elseif($plugininfo['availability'] == "0"){
                                                $text = $plugininfo['text'];
                                                $url = "https://wpjobportal.com/product/widget/";
                                            } ?>
                                            <a href="<?php echo esc_url($url); ?>" class="wpjobportal-cp-addon-btn" title="<?php echo esc_attr($text); ?>">
                                                <?php echo esc_html($text); ?>
                                            </a>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    <?php } ?>
                </div>
                <!-- page single section wrp -->
                <div class="wpjobportal-review-sec">
                    <div class="wpjobportal-review">
                        <div class="wpjobportal-review-upper">
                            <span class="wpjobportal-review-simple-text">
                                <?php echo __('We\'d love to hear from You.', 'wp-job-portal'); ?>
                                <br />
                                <?php echo __('Please write appreciated review at', 'wp-job-portal'); ?>
                            </span>
                            <a class="wpjobportal-review-link" href="https://wordpress.org/support/view/plugin-reviews/wp-job-portal" target="_blank">
                                <img src="<?php echo WPJOBPORTAL_PLUGIN_URL; ?>includes/images/control_panel/dashboard/review/star.png">
                                <?php echo __('WP Extension Directory', 'wp-job-portal'); ?>
                            </a>
                        </div>
                        <div class="wpjobportal-review-lower">
                            <span class="wpjobportal-review-simple-text">
                                <?php echo __('Spread the word : ','wp-job-portal'); ?>
                            </span>
                            <a class="wpjobportal-review-soc-link" href="https://www.facebook.com/joomsky">
                                <img alt="fb" src="<?php echo WPJOBPORTAL_PLUGIN_URL; ?>includes/images/control_panel/dashboard/review/fb.png">
                            </a>
                            <a class="wpjobportal-review-soc-link" href="https://twitter.com/joomsky">
                                <img alt="twitter" src="<?php echo WPJOBPORTAL_PLUGIN_URL; ?>includes/images/control_panel/dashboard/review/twitter.png">
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    jQuery(document).ready(function () {
        jQuery('div.resume').animate({left: '-100%'});
        jQuery('div.companies span.img img').click(function (e) {
            jQuery('div.companies').animate({left: '-100%'});
            jQuery('div.resume').animate({left: '0%'});
        });
        jQuery('div.resume span.img img').click(function (e) {
            jQuery('div.resume').animate({left: '-100%'});
            jQuery('div.companies').animate({left: '0%'});
        });
        jQuery('div.jobs').animate({right: '-100%'});
        jQuery('div.jobs span.img img').click(function (e) {
            jQuery('div.jobs').animate({right: '-100%'});
            jQuery('div.appliedjobs').animate({right: '0%'});
        });
        jQuery('div.appliedjobs span.img img').click(function (e) {
            jQuery('div.appliedjobs').animate({right: '-100%'});
            jQuery('div.jobs').animate({right: '0%'});
        });
        jQuery("span.dashboard-icon").find('span.download').hover(function(){
            jQuery(this).find('span').toggle("slide");
        }, function(){
            jQuery(this).find('span').toggle("slide");
        });
    });
</script>
