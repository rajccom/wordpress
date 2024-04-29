    <div id="wpjobportaladmin-wrapper">
        <div id="wpjobportaladmin-leftmenu">
            <?php  WPJOBPORTALincluder::getClassesInclude('wpjobportaladminsidemenu'); ?>
        </div>
    <div id="wpjobportaladmin-data">
        <span class="js-adminhead-title"><a class="jsanchor-backlink" href="<?php echo admin_url('admin.php?page=wpjobportal');?>"><img alt="image" src="<?php echo WPJOBPORTAL_PLUGIN_URL; ?>includes/images/back-icon.png" /></a><span class="jsheadtext"><?php echo __('Premium Addons', 'wp-job-portal'); ?></span></span>

        <div id="wpjobportal-content">
            <h1 class="wpjobportal-missing-addon-message" >
                <?php
                $addon_name = WPJOBPORTALrequest::getVar('page');
                echo esc_html(wpjobportalphplib::wpJP_ucfirst($addon_name)).' ';
                echo __('addon in no longer active','wp-job-portal').'!';
                ?>

            </h1>
        </div>
    </div>
</div>
