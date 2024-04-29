<?php if (!defined('ABSPATH')) die('Restricted Access'); ?>
<script >
    jQuery(document).ready(function ($) {
        $.validate();
    });
</script>
<!-- main wrapper -->
<div id="wpjobportaladmin-wrapper">
    <!-- left menu -->
    <div id="wpjobportaladmin-leftmenu">
        <?php  WPJOBPORTALincluder::getClassesInclude('wpjobportaladminsidemenu'); ?>
    </div>
    <div id="wpjobportaladmin-data">
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
                        <li><?php echo __('Add New State','wp-job-portal'); ?></li>
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
            <h1 class="wpjobportal-head-text">
                <?php
                    $heading = isset(wpjobportal::$_data[0]) ? __('Edit', 'wp-job-portal') : __('Add New', 'wp-job-portal');
                    echo esc_html($heading) . ' ' . __('State', 'wp-job-portal');
                ?>
            </h1>
        </div>
        <!-- page content -->
        <div id="wpjobportal-admin-wrapper">
            <form id="wpjobportal-form" class="wpjobportal-form" method="post" action="<?php echo admin_url("admin.php?page=wpjobportal_state&task=savestate"); ?>">
                <div class="wpjobportal-form-wrapper">
                    <div class="wpjobportal-form-title">
                        <?php echo __('Name', 'wp-job-portal'); ?><font class="required-notifier">*</font>
                    </div>
                    <div class="wpjobportal-form-value">
                        <?php echo wp_kses(WPJOBPORTALformfield::text('name', isset(wpjobportal::$_data[0]->name) ? __(wpjobportal::$_data[0]->name,'wp-job-portal') : '', array('class' => 'inputbox one wpjobportal-form-input-field', 'data-validation' => 'required')),WPJOBPORTAL_ALLOWED_TAGS) ?>
                    </div>
                </div>
                <div class="wpjobportal-form-wrapper">
                    <div class="wpjobportal-form-title">
                        <?php echo __('Published', 'wp-job-portal'); ?>
                    </div>
                    <div class="wpjobportal-form-value">
                        <?php echo wp_kses(WPJOBPORTALformfield::radiobutton('enabled', array('1' => __('Yes', 'wp-job-portal'), '0' => __('No', 'wp-job-portal')), isset(wpjobportal::$_data[0]->enabled) ? wpjobportal::$_data[0]->enabled : 1, array('class' => 'radiobutton')),WPJOBPORTAL_ALLOWED_TAGS); ?>
                    </div>
                </div>
                <?php echo wp_kses(WPJOBPORTALformfield::hidden('id', isset(wpjobportal::$_data[0]->id) ? wpjobportal::$_data[0]->id : ''),WPJOBPORTAL_ALLOWED_TAGS); ?>
                <?php echo wp_kses(WPJOBPORTALformfield::hidden('action', 'state_savestate'),WPJOBPORTAL_ALLOWED_TAGS); ?>
                <?php echo wp_kses(WPJOBPORTALformfield::hidden('form_request', 'wpjobportal'),WPJOBPORTAL_ALLOWED_TAGS); ?>
                <div class="wpjobportal-form-button">
                    <a id="form-cancel-button" class="wpjobportal-form-cancel-btn" href="<?php echo admin_url('admin.php?page=wpjobportal_state&countryid='.get_option('wpjobportal_countryid_for_stateid')); ?>" title="<?php echo __('cancel', 'wp-job-portal'); ?>">
                        <?php echo __('Cancel', 'wp-job-portal'); ?>
                    </a>
                    <?php echo wp_kses(WPJOBPORTALformfield::submitbutton('save', __('Save','wp-job-portal') .' '. __('State', 'wp-job-portal'), array('class' => 'button wpjobportal-form-save-btn')),WPJOBPORTAL_ALLOWED_TAGS); ?>
                </div>
            </form>
        </div>
    </div>
</div>
