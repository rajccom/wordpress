<?php
    if (!defined('ABSPATH'))
        die('Restricted Access');
    wp_enqueue_script('wpjobportal-res-tables', WPJOBPORTAL_PLUGIN_URL . 'includes/js/responsivetable.js');
?>
<!-- main wrapper -->
<div id="wpjobportaladmin-wrapper">
    <!-- left menu -->
    <div id="wpjobportaladmin-leftmenu">
        <?php  WPJOBPORTALincluder::getClassesInclude('wpjobportaladminsidemenu'); ?>
    </div>
    <div id="wpjobportaladmin-data">
        <?php
            $msgkey = WPJOBPORTALincluder::getJSModel('wpjobportal')->getMessagekey();
            WPJOBPORTALMessages::getLayoutMessage($msgkey);
        ?>
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
                        <li><?php echo __('Help','wp-job-portal'); ?></li>
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
        <?php WPJOBPORTALincluder::getTemplate('templates/admin/pagetitle',array('module' => 'wpjobportal' , 'layouts' => 'help')); ?>
        <!-- page content -->
        <div id="wpjobportal-admin-wrapper" class="p0 bg-n bs-n">
            <!-- help page  -->
            <div class="wpjobportal-help-top">
                <div class="wpjobportal-help-top-left">
                    <div class="wpjobportal-help-top-left-cnt-img">
                        <img alt="<?php echo __('Help icon','wp-job-portal'); ?>" src="<?php echo WPJOBPORTAL_PLUGIN_URL; ?>includes/images/help-page/support-icon.jpg" />
                    </div>
                    <div class="wpjobportal-help-top-left-cnt-info">
                        <h2><?php echo __('We are here to help you','wp-job-portal'); ?></h2>
                        <p><?php echo __('WP Job Portal is a simple yet powerful Jobs Board plugin that provides a Step-by-step Youtube guide for its ease of use.','wp-job-portal'); ?></p>
                        <a href="https://www.youtube.com/channel/UCk_qYTzV6gusKmMHxTrgU2Q" target="_blank" class="wpjobportal-help-top-middle-action" title="<?php echo __('View all videos','wp-job-portal'); ?>"><img alt="<?php echo __('Video icon','wp-job-portal'); ?>" src="<?php echo WPJOBPORTAL_PLUGIN_URL; ?>includes/images/help-page/play-icon.jpg" /><?php echo __('View All Videos','wp-job-portal'); ?></a>
                    </div>
                </div>
                <div class="wpjobportal-help-top-right">
                    <div class="wpjobportal-help-top-right-cnt-img">
                        <img alt="<?php echo __('WP JOB PORTAL icon','wp-job-portal'); ?>" src="<?php echo WPJOBPORTAL_PLUGIN_URL; ?>includes/images/help-page/support.png" />
                    </div>
                    <div class="wpjobportal-help-top-right-cnt-info">
                        <h2><?php echo __('WP Job Portal Support','wp-job-portal'); ?></h2>
                        <p><?php echo __("WP Job Portal delivers timely customer support if you have any query then we're here to show you the way.",'wp-job-portal'); ?></p>
                        <a target="_blank" href="https://wpjobportal.com/support/" class="wpjobportal-help-top-middle-action second" title="<?php echo __('Submit ticket','wp-job-portal'); ?>"><img alt="<?php echo __('Video icon','wp-job-portal'); ?>" src="<?php echo WPJOBPORTAL_PLUGIN_URL; ?>includes/images/help-page/ticket.png" /><?php echo __('Submit Ticket','wp-job-portal'); ?></a>
                    </div>
                </div>
            </div>
            <div class="wpjobportal-help-btm">
                <!-- job portal -->
                <div class="wpjobportal-help-btm-wrp">
                    <h2 class="wpjobportal-help-btm-title"><?php echo __('Job Portal','wp-job-portal'); ?></h2>
                    <?php
                        $title = __('WP Job Portal', 'wp-job-portal');
                        $url = 'UmO6EwsNMZo';
                        printVideoPlaylist($title, $url);
                    ?>
                </div>
                <div class="wpjobportal-help-btm-wrp">
                    <h2 class="wpjobportal-help-btm-title"><?php echo __('How to Setup','wp-job-portal'); ?></h2>
                    <?php
                        $title = __('How to setup WP Job Portal', 'wp-job-portal');
                        $url = '0stgD2ca8Ag';
                        printVideoPlaylist($title, $url);
                    ?>
                </div>
                <!-- jobs -->
                <div class="wpjobportal-help-btm-wrp">
                    <h2 class="wpjobportal-help-btm-title"><?php echo __('Jobs','wp-job-portal'); ?></h2>
                    <?php
                        $title = __('Add Job', 'wp-job-portal');
                        $url = 'F0j8iDirJGU';
                        printVideoPlaylist($title, $url);

                        $title = __('Copy Job', 'wp-job-portal');
                        $url = 'zU10SjrwgAM';
                        printVideoPlaylist($title, $url);

                        $title = __('Featured Jobs', 'wp-job-portal');
                        $url = 'PrBB2Znkfu4';
                        printVideoPlaylist($title, $url);

                        $title = __('Shortlist Jobs', 'wp-job-portal');
                        $url = 'WgAdjOC7Uoo';
                        printVideoPlaylist($title, $url);

                        $title = __('Visitor Create a Job', 'wp-job-portal');
                        $url = 'xx2VWlbwuGw';
                        printVideoPlaylist($title, $url);

                        $title = __('Job Alert', 'wp-job-portal');
                        $url = 'iaYjzbceigg';
                        printVideoPlaylist($title, $url);

                        $title = __('Tell a Friend', 'wp-job-portal');
                        $url = 'DRNLvfBsbSs';
                        printVideoPlaylist($title, $url);
                        
                        $title = __('Apply as a Visitor', 'wp-job-portal');
                        $url = 'YiDasKFGhjY';
                        printVideoPlaylist($title, $url);
                    ?>
                </div>
                <!-- resume -->
                <div class="wpjobportal-help-btm-wrp">
                    <h2 class="wpjobportal-help-btm-title"><?php echo __('Resume','wp-job-portal'); ?></h2>
                    <?php
                        $title = __('Add Resume', 'wp-job-portal');
                        $url = 'Fy6eWUya2GY';
                        printVideoPlaylist($title, $url);

                        $title = __('Featured Resume', 'wp-job-portal');
                        $url = 'RQteSRpy5gM';
                        printVideoPlaylist($title, $url);

                        $title = __('Advance Resume', 'wp-job-portal');
                        $url = 'B1YoPITnjPY';
                        printVideoPlaylist($title, $url);

                        $title = __('Resume Search', 'wp-job-portal');
                        $url = 'WvwHLsg5XGk';
                        printVideoPlaylist($title, $url);

                        $title = __('Resume Actions', 'wp-job-portal');
                        $url = '-QgsW3YL7F4&ab_channel=WPJobPortal';
                        printVideoPlaylist($title, $url);

                        
                    ?>
                </div>
                <!-- company -->
                <div class="wpjobportal-help-btm-wrp">
                    <h2 class="wpjobportal-help-btm-title"><?php echo __('Company','wp-job-portal'); ?></h2>
                    <?php
                        $title = __('Create Company', 'wp-job-portal');
                        $url = 'm9dp0EzzIdI';
                        printVideoPlaylist($title, $url);

                        $title = __('Featured Companies', 'wp-job-portal');
                        $url = 'ShHfBG516NM';
                        printVideoPlaylist($title, $url);
                    ?>
                </div>
                <!-- social apps -->
                <div class="wpjobportal-help-btm-wrp">
                    <h2 class="wpjobportal-help-btm-title"><?php echo __('Social Apps','wp-job-portal'); ?></h2>
                    <?php
                        $title = __('Social Share', 'wp-job-portal');
                        $url = 'Xw88w-21VWQ';
                        printVideoPlaylist($title, $url);

                        $title = __('Social Login', 'wp-job-portal');
                        $url = 'XM6IUzsUw9o';
                        printVideoPlaylist($title, $url);
                    ?>
                </div>
                <!-- misc -->
                <div class="wpjobportal-help-btm-wrp">
                    <h2 class="wpjobportal-help-btm-title"><?php echo __('Misc','wp-job-portal'); ?></h2>
                    <?php
                        $title = __('Widget Settings', 'wp-job-portal');
                        $url = 'wC7g6ELwMGE';
                        printVideoPlaylist($title, $url);
                        
                        $title = __('Tags', 'wp-job-portal');
                        $url = 'hE6-blhggeg';
                        printVideoPlaylist($title, $url);
                        
                        $title = __('RSS', 'wp-job-portal');
                        $url = '_m2Y2WuvzN8';
                        printVideoPlaylist($title, $url);
                        
                        $title = __('PDF', 'wp-job-portal');
                        $url = 'lIaJhOr4fX8';
                        printVideoPlaylist($title, $url);
                        
                        $title = __('Folders', 'wp-job-portal');
                        $url = 'hLj8fsgwE6E';
                        printVideoPlaylist($title, $url);
                        
                        $title = __('Reports', 'wp-job-portal');
                        $url = '0kj6JmMbZsk';
                        printVideoPlaylist($title, $url);
                        
                        $title = __('Print', 'wp-job-portal');
                        $url = 'Ao_9ald1Z4g';
                        printVideoPlaylist($title, $url);
                        
                        $title = __('Departments', 'wp-job-portal');
                        $url = 'HNopX7oU6NU';
                        printVideoPlaylist($title, $url);
                        
                        $title = __('Export', 'wp-job-portal');
                        $url = 'G-uwkNg5Za4';
                        printVideoPlaylist($title, $url);
                        
                        $title = __('Custom Fields', 'wp-job-portal');
                        $url = 'JVWShD3SeuQ';
                        printVideoPlaylist($title, $url);
                        
                        $title = __('Credit Pack', 'wp-job-portal');
                        $url = 'tAipI3jNl60';
                        printVideoPlaylist($title, $url);
                        
                        $title = __('Color Manager', 'wp-job-portal');
                        $url = 'ERjwnU7ps98';
                        printVideoPlaylist($title, $url);
                        
                        $title = __('Address Data', 'wp-job-portal');
                        $url = 'N2PqbNOtqs4';
                        printVideoPlaylist($title, $url);
                        

                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
    function printVideoPlaylist($video_title,$video_url){
        $html = '
        <div class="wpjobportal-help-btm-cnt">
            <a href="https://www.youtube.com/watch?v='.$video_url.'" class="wpjobportal-help-btm-link"  target="_blank" title="'.esc_attr($video_title).'">
                <div class="wpjobportal-help-btm-cnt-img">
                    <img alt="'.esc_attr($video_title).'" src="'. WPJOBPORTAL_PLUGIN_URL .'includes/images/help-page/video-icon.jpg" />
                </div>
                <div class="wpjobportal-help-btm-cnt-title">
                    <span>'.esc_html($video_title).'</span>
                </div>
            </a>
        </div>
        ';
        echo wp_kses($html, WPJOBPORTAL_ALLOWED_TAGS);
    }
      
?>
