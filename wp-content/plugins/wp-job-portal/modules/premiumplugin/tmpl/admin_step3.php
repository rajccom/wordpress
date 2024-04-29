<div id="wpjobportaladmin-wrapper">
    <div id="wpjobportaladmin-leftmenu">
        <?php  WPJOBPORTALincluder::getClassesInclude('wpjobportaladminsidemenu'); ?>
    </div>
    <div id="wpjobportaladmin-data">
        <div id="wpjobportal-wrapper-top">
            <div id="wpjobportal-wrapper-top-left">
                <div id="wpjobportal-breadcrumbs">
                    <ul>
                        <li>
                            <a href="<?php echo admin_url('admin.php?page=wpjobportal'); ?>" title="<?php echo __('Dashboard','wp-job-portal'); ?>">
                                <?php echo __('Dashboard','wp-job-portal'); ?>
                            </a>
                        </li>
                        <li><?php echo __('Install Addons','wp-job-portal'); ?></li>
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
        <div id="wpjobportal-head">
            <h1 class="wpjobportal-head-text"><?php echo __('Install Addons','wp-job-portal'); ?></h1>
        </div>
        <div id="wpjobportal-admin-wrapper" class="p0 bg-n bs-n">
            <div id="wpjobportal-content">
                <div id="black_wrapper_translation"></div>
                <div id="jstran_loading">
                    <img alt="image" src="<?php echo WPJOBPORTAL_PLUGIN_URL; ?>includes/images/spinning-wheel.gif" />
                </div>
                <div id="wpjobportal-lower-wrapper">
                    <div class="wpjobportal-addon-installer-wrapper step3" >
                        <div class="wpjobportal-addon-installer-left-image-wrap" >
                            <img class="wpjobportal-addon-installer-left-image" src="<?php echo WPJOBPORTAL_PLUGIN_URL; ?>includes/images/addon-images/addon-installer-logo.png" />
                        </div>
                        <div class="wpjobportal-addon-installer-left-heading" >
                            <?php echo __("Add ons installed and activated successfully","wp-job-portal"); ?>
                        </div>
                        <div class="wpjobportal-addon-installer-left-description" >
                            <?php echo __("Add ons for WP Job Portal have been installed and activated successfully. ","wp-job-portal"); ?>
                        </div>
                        <div class="wpjobportal-addon-installer-right-button" >
                            <a class="wpjobportal_btn" href="?page=wpjobportal" ><?php echo __("Control Panel","wp-job-portal"); ?></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
