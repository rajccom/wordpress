<?php if (!defined('ABSPATH')) die('Restricted Access'); ?>
<div id="wpjobportaladmin-wrapper">
	<div id="wpjobportaladmin-leftmenu">
        <?php  WPJOBPORTALincluder::getClassesInclude('wpjobportaladminsidemenu'); ?>
    </div>
    <div id="wpjobportaladmin-data">
    <?php
    $msgkey = WPJOBPORTALincluder::getJSModel('report')->getMessagekey();
    WPJOBPORTALMessages::getLayoutMessage($msgkey);
    ?>
    <span class="js-admin-title">
        <a href="<?php echo admin_url('admin.php?page=wpjobportal'); ?>"><img src="<?php echo WPJOBPORTAL_PLUGIN_URL; ?>includes/images/back-icon.png" /></a>
        <?php echo __('Reports', 'wp-job-portal'); ?>
    </span>
    <a href="admin.php?page=wpjobportal_report&wpjobportallt=overallreports" class="overall">
        <span class="left">
            <img src="<?php echo WPJOBPORTAL_PLUGIN_URL; ?>includes/images/job-stats.png">
            <span class="text"><?php echo __('Over All', 'wp-job-portal'); ?></span>
        </span>
        <span class="right">
            <img src="<?php echo WPJOBPORTAL_PLUGIN_URL; ?>includes/images/1.png">
        </span>
    </a>
    <a href="admin.php?page=wpjobportal_report&wpjobportallt=employerreports" class="employer">
        <span class="left">
            <img src="<?php echo WPJOBPORTAL_PLUGIN_URL; ?>includes/images/employer.png">
            <span class="text"><?php echo __('Employer', 'wp-job-portal'); ?></span>
        </span>
        <span class="right">
            <img src="<?php echo WPJOBPORTAL_PLUGIN_URL; ?>includes/images/2.png">
        </span>
    </a>
    <a href="admin.php?page=wpjobportal_report&wpjobportallt=jobseekerreports"  class="jobseeker">
        <span class="left">
            <img src="<?php echo WPJOBPORTAL_PLUGIN_URL; ?>includes/images/jobseeker-2e.png">
            <span class="text"><?php echo __('Job Seeker', 'wp-job-portal'); ?></span>
        </span>
        <span class="right">
            <img src="<?php echo WPJOBPORTAL_PLUGIN_URL; ?>includes/images/3.png">
        </span>
    </a>
</div>
</div>
