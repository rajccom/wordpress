<?php
if (!defined('ABSPATH'))
    die('Restricted Access');
wp_enqueue_script('jquery-ui-tabs');
$yesno = array((object) array('id' => 1, 'text' => __('Yes', 'wp-job-portal')), (object) array('id' => 0, 'text' => __('No', 'wp-job-portal')));
$showhide = array((object) array('id' => 1, 'text' => __('Show', 'wp-job-portal')), (object) array('id' => 0, 'text' => __('Hide', 'wp-job-portal')));
$applybutton = array((object) array('id' => 1, 'text' => __('Enable')), (object) array('id' => 2, 'text' => __('Disable')));
$msgkey = WPJOBPORTALincluder::getJSModel('configuration')->getMessagekey();
WPJOBPORTALMessages::getLayoutMessage($msgkey);
$theme_chk = wpjobportal::$theme_chk;
?>

<script type="text/javascript">
// for the set register 
    jQuery(document).ready(function () {
        var wpjpconfigid = '<?php echo esc_js(wpjobportal::$_data["wpjpconfigid"]) ?>';
        if (wpjpconfigid == 'jobseeker_general_setting') {
            jQuery('#jobseeker_general_setting').css('display','inline-block');
            jQuery('#js_setting').addClass('active');
        }
    });
    //end set register
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
                        <li><?php echo __('Jobseeker Configurations','wp-job-portal'); ?></li>
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
        <div id="wpjobportal-head"  class="wpjobportal-config-head">
            <h1 class="wpjobportal-head-text">
                <?php echo __('Jobseeker Configurations', 'wp-job-portal'); ?>
            </h1>
        </div>
        <!-- page content -->
        <div id="wpjobportal-admin-wrapper" class="wpjobportal-config-main-wrapper">
            <form id="wpjobportal-form" class="wpjobportal-configurations" method="post" action="<?php echo admin_url("admin.php?page=wpjobportal_configuration&task=saveconfiguration") ?>">
                <div class="wpjobportal-configurations-toggle">
                    <img alt="<?php echo __('mneu','wp-job-portal'); ?>" src="<?php echo WPJOBPORTAL_PLUGIN_URL; ?>includes/images/control_panel/dashboard/admin-left-menu/menu.png" />
                    <span class="jslm_text"><?php echo __('Select Configuration', 'wp-job-portal'); ?></span>
                </div>
                <div class="wpjobportal-left-menu wpjobportal-config-left-menu">
                    <?php echo WPJOBPORTALincluder::getJSModel('configuration')->getConfigSideMenu(); ?>
                </div>
                <div class="wpjobportal-right-content">
                    <div id="tabs" class="tabs">
                        <div id="jobseeker_general_setting">
                            <ul>
                                <li class="ui-tabs-active">
                                    <a href="#js_generalsetting">
                                        <?php echo __('General Settings', 'wp-job-portal'); ?>
                                    </a>
                                </li>
                                <li>
                                    <a href="#js_resume_setting">
                                        <?php echo __('Resume Settings', 'wp-job-portal'); ?>
                                    </a>
                                </li>
                                <li>
                                    <a href="#js_memberlinks">
                                        <?php echo __('Members Links', 'wp-job-portal'); ?>
                                    </a>
                                </li>
                                <?php if(in_array('email', wpjobportal::$_active_addons)){ ?>
                                        <li>
                                            <a href="#email">
                                                <?php echo __('Email Alert', 'wp-job-portal'); ?>
                                            </a>
                                        </li>
                               <?php } ?>
                            </ul>
                            <div class="tabInner">
                            <!-- GENERAL SETTING -->
                            <div id="js_generalsetting" class="wpjobportal_gen_body">
                                <h3 class="wpjobportal-config-heading-main">
                                    <?php echo __('General Settings', 'wp-job-portal'); ?>
                                </h3>
                                <?php if(in_array('featureresume', wpjobportal::$_active_addons)){ ?>
                                    <div class="wpjobportal-config-row">
                                        <div class="wpjobportal-config-title">
                                            <?php echo __('Enable featured resume', 'wp-job-portal'); ?>

                                        </div>
                                        <div class="wpjobportal-config-value">
                                            <?php echo wp_kses(WPJOBPORTALformfield::select('system_have_featured_resume', $yesno, wpjobportal::$_data[0]['system_have_featured_resume']),WPJOBPORTAL_ALLOWED_TAGS); ?>
                                            <div class="wpjobportal-config-description">
                                                <?php echo __('Featured resume are allowed in plugin', 'wp-job-portal'); ?>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                                <?php if(in_array('credits', wpjobportal::$_active_addons)){ ?>
                                    <div class="wpjobportal-config-row">
                                        <div class="wpjobportal-config-title">
                                            <?php echo __('Show company contact detail', 'wp-job-portal').' ( '.__('effect on credits system', 'wp-job-portal').' )'; ?>

                                        </div>
                                        <div class="wpjobportal-config-value">
                                            <?php echo wp_kses(WPJOBPORTALformfield::select('company_contact_detail', $yesno, wpjobportal::$_data[0]['company_contact_detail']),WPJOBPORTAL_ALLOWED_TAGS); ?>
                                            <div class="wpjobportal-config-description">
                                                <?php echo __('If no then credits will be taken to view contact detail', 'wp-job-portal'); ?>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                                <div class="wpjobportal-config-row">
                                    <div class="wpjobportal-config-title">
                                        <?php echo __('Show apply button', 'wp-job-portal'); ?>
                                    </div>
                                    <div class="wpjobportal-config-value">
                                        <?php echo wp_kses(WPJOBPORTALformfield::select('showapplybutton', $yesno, wpjobportal::$_data[0]['showapplybutton']),WPJOBPORTAL_ALLOWED_TAGS); ?>
                                        <div class="wpjobportal-config-description">
                                            <?php echo __('Controls the visibility of apply now button in plugin', 'wp-job-portal'); ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="wpjobportal-config-row">
                                </div>
                                <?php if(in_array('resumeaction', wpjobportal::$_active_addons)){ ?>
                                <div class="wpjobportal-config-row">
                                    <div class="wpjobportal-config-title">
                                        <?php echo __('Show applied resume status', 'wp-job-portal'); ?>

                                    </div>
                                    <div class="wpjobportal-config-value">
                                        <?php echo wp_kses(WPJOBPORTALformfield::select('show_applied_resume_status', $yesno, wpjobportal::$_data[0]['show_applied_resume_status']),WPJOBPORTAL_ALLOWED_TAGS); ?>
                                    </div>
                                </div>
                                <?php } ?>
                                <div class="wpjobportal-config-row">
                                    <div class="wpjobportal-config-title">
                                        <?php echo __('Show count in jobs by categories page', 'wp-job-portal'); ?>
                                    </div>
                                    <div class="wpjobportal-config-value">
                                        <?php echo wp_kses(WPJOBPORTALformfield::select('categories_numberofjobs', $yesno, wpjobportal::$_data[0]['categories_numberofjobs']),WPJOBPORTAL_ALLOWED_TAGS); ?>
                                    </div>
                                </div>
                                <div class="wpjobportal-config-row">
                                    <div class="wpjobportal-config-title">
                                        <?php echo __('Show count in jobs by types page', 'wp-job-portal'); ?>
                                    </div>
                                    <div class="wpjobportal-config-value">
                                        <?php echo wp_kses(WPJOBPORTALformfield::select('jobtype_numberofjobs', $yesno, wpjobportal::$_data[0]['jobtype_numberofjobs']),WPJOBPORTAL_ALLOWED_TAGS); ?>
                                    </div>
                                </div>
                                <div class="wpjobportal-config-row">
                                    <div class="wpjobportal-config-title">
                                        <?php echo __('Show count in jobs by cities page', 'wp-job-portal'); ?>
                                    </div>
                                    <div class="wpjobportal-config-value">
                                        <?php echo wp_kses(WPJOBPORTALformfield::select('jobsbycities_jobcount', $yesno, wpjobportal::$_data[0]['jobsbycities_jobcount']),WPJOBPORTAL_ALLOWED_TAGS); ?>
                                    </div>
                                </div>
                                <div class="wpjobportal-config-row">
                                    <div class="wpjobportal-config-title">
                                        <?php echo __('Show country in jobs by cities page', 'wp-job-portal'); ?>
                                    </div>
                                    <div class="wpjobportal-config-value">
                                        <?php echo wp_kses(WPJOBPORTALformfield::select('jobsbycities_countryname', $yesno, wpjobportal::$_data[0]['jobsbycities_countryname']),WPJOBPORTAL_ALLOWED_TAGS); ?>
                                    </div>
                                </div>

                                <!-- custome -->
                                <div class="wpjobportal-config-row">
                                    <div class="wpjobportal-config-title">
                                        <?php echo __('Resume','wp-job-portal') .' '. __('auto approve', 'wp-job-portal'); ?>
                                    </div>
                                    <div class="wpjobportal-config-value">
                                        <?php echo wp_kses(WPJOBPORTALformfield::select('empautoapprove', $yesno, wpjobportal::$_data[0]['empautoapprove']),WPJOBPORTAL_ALLOWED_TAGS); ?>
                                    </div>
                                </div>
                                <?php if(in_array('featureresume', wpjobportal::$_active_addons)){ ?>
                                    <div class="wpjobportal-config-row">
                                        <div class="wpjobportal-config-title">
                                            <?php echo __('Featured','wp-job-portal') .' '. __('resume','wp-job-portal') .' '. __('auto approve', 'wp-job-portal'); ?>

                                        </div>
                                        <div class="wpjobportal-config-value">
                                            <?php echo wp_kses(WPJOBPORTALformfield::select('featuredresume_autoapprove', $yesno, wpjobportal::$_data[0]['featuredresume_autoapprove']),WPJOBPORTAL_ALLOWED_TAGS); ?>
                                        </div>
                                    </div>
                                <?php } ?>
                                <?php if(in_array('shortlist', wpjobportal::$_active_addons)){ ?>
                                    <div class="wpjobportal-config-row">
                                        <div class="wpjobportal-config-title">
                                            <?php echo __('Job short list', 'wp-job-portal'); ?>

                                        </div>
                                        <div class="wpjobportal-config-value">
                                            <?php echo wp_kses(WPJOBPORTALformfield::select('allow_jobshortlist', $yesno, wpjobportal::$_data[0]['allow_jobshortlist']),WPJOBPORTAL_ALLOWED_TAGS); ?>
                                            <div class="wpjobportal-config-description">
                                                <?php echo __('Job short list setting effects on jobs listing page', 'wp-job-portal'); ?>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                                <?php if(in_array('jobalert', wpjobportal::$_active_addons)){ ?>
                                    <div class="wpjobportal-config-row">
                                        <div class="wpjobportal-config-title">
                                            <?php echo __('Job alert','wp-job-portal') .' '. __('auto approve', 'wp-job-portal'); ?>
                                        </div>
                                        <div class="wpjobportal-config-value">
                                            <?php echo wp_kses(WPJOBPORTALformfield::select('jobalert_auto_approve', $yesno, wpjobportal::$_data[0]['jobalert_auto_approve']),WPJOBPORTAL_ALLOWED_TAGS); ?>
                                        </div>
                                    </div>
                                <?php } ?>
                                <?php if(in_array('tellfriend', wpjobportal::$_active_addons)){ ?>
                                    <div class="wpjobportal-config-row">
                                        <div class="wpjobportal-config-title">
                                            <?php echo __('Tell a friend', 'wp-job-portal'); ?>
                                        </div>
                                        <div class="wpjobportal-config-value">
                                            <?php echo wp_kses(WPJOBPORTALformfield::select('allow_tellafriend', $yesno, wpjobportal::$_data[0]['allow_tellafriend']),WPJOBPORTAL_ALLOWED_TAGS); ?>
                                            <div class="wpjobportal-config-description">
                                                <?php echo __('Tell a friend setting effects on jobs listing page', 'wp-job-portal'); ?>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                                <?php if(in_array('coverletter', wpjobportal::$_active_addons)){ ?>
                                    <div class="wpjobportal-config-row">
                                        <div class="wpjobportal-config-title">
                                            <?php echo __('Cover Lettter','wp-job-portal') .' '. __('auto approve', 'wp-job-portal'); ?>
                                        </div>
                                        <div class="wpjobportal-config-value">
                                            <?php echo wp_kses(WPJOBPORTALformfield::select('coverletter_auto_approve', $yesno, wpjobportal::$_data[0]['coverletter_auto_approve']),WPJOBPORTAL_ALLOWED_TAGS); ?>
                                            <div class="wpjobportal-config-description">
                                                <?php echo __('Auto approve cover letter for job seeker', 'wp-job-portal'); ?>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                            <!-- RESUME SETTINGS -->
                            <div id="js_resume_setting" class="wpjobportal_gen_body">
                                <h3 class="wpjobportal-config-heading-main">
                                    <?php echo __('Resume Settings', 'wp-job-portal'); ?>
                                </h3>
                                <div class="wpjobportal-config-row">
                                    <div class="wpjobportal-config-title">
                                        <?php echo __('Document file extensions', 'wp-job-portal'); ?>
                                    </div>
                                    <div class="wpjobportal-config-value">
                                        <?php echo wp_kses(WPJOBPORTALformfield::text('document_file_type', wpjobportal::$_data[0]['document_file_type'], array('class' => 'inputbox')),WPJOBPORTAL_ALLOWED_TAGS); ?>
                                        <div class="wpjobportal-config-description">
                                            <?php echo __('Document file extensions allowed', 'wp-job-portal'); ?>, <?php echo __('Must be comma separated', 'wp-job-portal'); ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="wpjobportal-config-row">
                                    <div class="wpjobportal-config-title">
                                        <?php echo __('Resume file maximum size', 'wp-job-portal'); ?>
                                    </div>
                                    <div class="wpjobportal-config-value">
                                        <?php echo wp_kses(WPJOBPORTALformfield::text('document_file_size', wpjobportal::$_data[0]['document_file_size'], array('class' => 'inputbox not-full-width', 'data-validation' => 'number')),WPJOBPORTAL_ALLOWED_TAGS); ?>  KB
                                        <div class="wpjobportal-config-description">
                                            <?php echo __('System will not upload if resume file size exceeds than given size', 'wp-job-portal'); ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="wpjobportal-config-row">
                                    <div class="wpjobportal-config-title">
                                        <?php echo __('Number of files for resume', 'wp-job-portal'); ?>
                                    </div>
                                    <div class="wpjobportal-config-value">
                                        <?php echo wp_kses(WPJOBPORTALformfield::text('document_max_files', wpjobportal::$_data[0]['document_max_files'], array('class' => 'inputbox', 'data-validation' => 'number')),WPJOBPORTAL_ALLOWED_TAGS); ?>
                                        <div class="wpjobportal-config-description">
                                            <?php echo __('Maximum number of files that job seeker can upload in resume', 'wp-job-portal'); ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="wpjobportal-config-row">
                                    <div class="wpjobportal-config-title">
                                        <?php echo __('Resume photo maximum size ', 'wp-job-portal'); ?>
                                    </div>
                                    <div class="wpjobportal-config-value">
                                        <?php echo wp_kses(WPJOBPORTALformfield::text('resume_photofilesize', wpjobportal::$_data[0]['resume_photofilesize'], array('class' => 'inputbox not-full-width', 'data-validation' => 'number')),WPJOBPORTAL_ALLOWED_TAGS); ?>  KB
                                    </div>
                                </div>
                                <?php if(in_array('advanceresumebuilder', wpjobportal::$_active_addons)){ ?>
                                    <div class="wpjobportal-config-row">
                                        <div class="wpjobportal-config-title">
                                            <?php echo __('Number of employers allowed', 'wp-job-portal'); ?>
                                        </div>
                                        <div class="wpjobportal-config-value">
                                            <?php echo wp_kses(WPJOBPORTALformfield::text('max_resume_employers', wpjobportal::$_data[0]['max_resume_employers'], array('class' => 'inputbox', 'data-validation' => 'number')),WPJOBPORTAL_ALLOWED_TAGS); ?>
                                            <div class="wpjobportal-config-description">
                                                <?php echo __('Maximum number of employers allowed in resume', 'wp-job-portal'); ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="wpjobportal-config-row">
                                        <div class="wpjobportal-config-title">
                                            <?php echo __('Number of institutes allowed', 'wp-job-portal'); ?>
                                        </div>
                                        <div class="wpjobportal-config-value">
                                            <?php echo wp_kses(WPJOBPORTALformfield::text('max_resume_institutes', wpjobportal::$_data[0]['max_resume_institutes'], array('class' => 'inputbox', 'data-validation' => 'number')),WPJOBPORTAL_ALLOWED_TAGS); ?>
                                            <div class="wpjobportal-config-description">
                                                <?php echo __('Maximum number of institutes allowed in resume', 'wp-job-portal'); ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="wpjobportal-config-row">
                                        <div class="wpjobportal-config-title">
                                            <?php echo __('Number of languages allowed', 'wp-job-portal'); ?>
                                        </div>
                                        <div class="wpjobportal-config-value">
                                            <?php echo wp_kses(WPJOBPORTALformfield::text('max_resume_languages', wpjobportal::$_data[0]['max_resume_languages'], array('class' => 'inputbox', 'data-validation' => 'number')),WPJOBPORTAL_ALLOWED_TAGS); ?>
                                            <div class="wpjobportal-config-description">
                                                <?php echo __('Maximum number of languages allowed in resume', 'wp-job-portal'); ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="wpjobportal-config-row">
                                        <div class="wpjobportal-config-title">
                                            <?php echo __('Number of addresses allowed', 'wp-job-portal'); ?>
                                        </div>
                                        <div class="wpjobportal-config-value">
                                            <?php echo wp_kses(WPJOBPORTALformfield::text('max_resume_addresses', wpjobportal::$_data[0]['max_resume_addresses'], array('class' => 'inputbox', 'data-validation' => 'number')),WPJOBPORTAL_ALLOWED_TAGS); ?>
                                            <div class="wpjobportal-config-description">
                                                <?php echo __('Maximum number of addresses allowed in resume', 'wp-job-portal'); ?>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                            <!-- MEMBERS LINKS -->
                            <div id="js_memberlinks" class="wpjobportal_gen_body">
                                <?php if($theme_chk == 0){ ?>
                                <?php } else { ?>
                                        <h3 class="wpjobportal-config-heading-main">
                                            <?php echo __('Job Seeker Dashboard','wp-job-portal'); ?>
                                        </h3>
                                        <div class="wpjobportal-config-row">
                                            <div class="wpjobportal-config-title">
                                                <?php echo __('Jobs Graph', 'wp-job-portal'); ?>
                                            </div>
                                            <div class="wpjobportal-config-value">
                                                <?php echo wp_kses(WPJOBPORTALformfield::select('temp_jobseeker_dashboard_jobs_graph', $showhide, wpjobportal::$_data[0]['temp_jobseeker_dashboard_jobs_graph']),WPJOBPORTAL_ALLOWED_TAGS); ?>
                                            </div>
                                        </div>
                                        <div class="wpjobportal-config-row">
                                            <div class="wpjobportal-config-title">
                                                <?php echo __('Useful Links', 'wp-job-portal'); ?>
                                            </div>
                                            <div class="wpjobportal-config-value">
                                                <?php echo wp_kses(WPJOBPORTALformfield::select('temp_jobseeker_dashboard_useful_links', $showhide, wpjobportal::$_data[0]['temp_jobseeker_dashboard_useful_links']),WPJOBPORTAL_ALLOWED_TAGS); ?>
                                            </div>
                                        </div>
                                        <div class="wpjobportal-config-row">
                                            <div class="wpjobportal-config-title">
                                                <?php echo __('Applied jobs', 'wp-job-portal'); ?>
                                            </div>
                                            <div class="wpjobportal-config-value">
                                                <?php echo wp_kses(WPJOBPORTALformfield::select('temp_jobseeker_dashboard_apllied_jobs', $showhide, wpjobportal::$_data[0]['temp_jobseeker_dashboard_apllied_jobs']),WPJOBPORTAL_ALLOWED_TAGS); ?>
                                            </div>
                                        </div>
                                        <div class="wpjobportal-config-row">
                                            <div class="wpjobportal-config-title">
                                                <?php echo __('Shortlisted Jobs', 'wp-job-portal'); ?>
                                            </div>
                                            <div class="wpjobportal-config-value">
                                                <?php echo wp_kses(WPJOBPORTALformfield::select('temp_jobseeker_dashboard_shortlisted_jobs', $showhide, wpjobportal::$_data[0]['temp_jobseeker_dashboard_shortlisted_jobs']),WPJOBPORTAL_ALLOWED_TAGS); ?>
                                            </div>
                                        </div>
                                        <div class="wpjobportal-config-row">
                                            <div class="wpjobportal-config-title">
                                                <?php echo __('Credits Log', 'wp-job-portal'); ?>
                                            </div>
                                            <div class="wpjobportal-config-value">
                                                <?php echo wp_kses(WPJOBPORTALformfield::select('temp_jobseeker_dashboard_credits_log', $showhide, wpjobportal::$_data[0]['temp_jobseeker_dashboard_credits_log']),WPJOBPORTAL_ALLOWED_TAGS); ?>
                                            </div>
                                        </div>
                                        <?php if(in_array('credits', wpjobportal::$_active_addons)){ ?>
                                            <div class="wpjobportal-config-row">
                                                <div class="wpjobportal-config-title">
                                                    <?php echo __('Invoice', 'wp-job-portal'); ?>
                                                </div>
                                                <div class="wpjobportal-config-value">
                                                    <?php echo wp_kses(WPJOBPORTALformfield::select('temp_jobseeker_dashboard_purchase_history', $showhide, wpjobportal::$_data[0]['temp_jobseeker_dashboard_purchase_history']),WPJOBPORTAL_ALLOWED_TAGS); ?>
                                                </div>
                                            </div>
                                        <?php } ?>
                                        <div class="wpjobportal-config-row">
                                            <div class="wpjobportal-config-title">
                                                <?php echo __('Newest Jobs', 'wp-job-portal'); ?>
                                            </div>
                                            <div class="wpjobportal-config-value">
                                                <?php echo wp_kses(WPJOBPORTALformfield::select('temp_jobseeker_dashboard_newest_jobs', $showhide, wpjobportal::$_data[0]['temp_jobseeker_dashboard_newest_jobs']),WPJOBPORTAL_ALLOWED_TAGS); ?>
                                            </div>
                                        </div>
                                <?php } ?>
                                <h3 class="wpjobportal-config-heading-main">
                                    <?php echo __('Job Seeker Control Panel Links','wp-job-portal'); ?>
                                </h3>
                                <?php if($theme_chk == 0){ ?>
                                    <div class="wpjobportal-config-row">
                                        <div class="wpjobportal-config-title">
                                            <?php echo __('Active Jobs Graph', 'wp-job-portal'); ?>

                                        </div>
                                        <div class="wpjobportal-config-value">
                                            <?php echo wp_kses(WPJOBPORTALformfield::select('jsactivejobs_graph', $showhide, wpjobportal::$_data[0]['jsactivejobs_graph']),WPJOBPORTAL_ALLOWED_TAGS); ?>
                                        </div>
                                    </div>
                                <?php } ?>
                                <?php
                                /*
                                if(in_array('message', wpjobportal::$_active_addons)){ ?>
                                        <div class="wpjobportal-config-row">
                                            <div class="wpjobportal-config-title">
                                                <?php echo __('User Messages', 'wp-job-portal'); ?>

                                            </div>
                                            <div class="wpjobportal-config-value">
                                                <?php echo wp_kses(WPJOBPORTALformfield::select('js_cpmessage', $showhide, wpjobportal::$_data[0]['js_cpmessage']),WPJOBPORTAL_ALLOWED_TAGS); ?>
                                            </div>
                                        </div>
                               <?php }  */?>
                                <div class="wpjobportal-config-row">
                                    <div class="wpjobportal-config-title">
                                        <?php echo __('My Resumes', 'wp-job-portal'); ?>
                                    </div>
                                    <div class="wpjobportal-config-value">
                                        <?php echo wp_kses(WPJOBPORTALformfield::select('myresumes', $showhide, wpjobportal::$_data[0]['myresumes']),WPJOBPORTAL_ALLOWED_TAGS); ?>
                                    </div>
                                </div>
                                <div class="wpjobportal-config-row">
                                    <div class="wpjobportal-config-title">
                                        <?php echo __('Add','wp-job-portal') .' '. __('Resume', 'wp-job-portal'); ?>
                                    </div>
                                    <div class="wpjobportal-config-value">
                                        <?php echo wp_kses(WPJOBPORTALformfield::select('formresume', $showhide, wpjobportal::$_data[0]['formresume']),WPJOBPORTAL_ALLOWED_TAGS); ?>
                                    </div>
                                </div>
                                <div class="wpjobportal-config-row">
                                    <div class="wpjobportal-config-title">
                                        <?php echo __('Jobs By Categories', 'wp-job-portal'); ?>
                                    </div>
                                    <div class="wpjobportal-config-value">
                                        <?php echo wp_kses(WPJOBPORTALformfield::select('jobcat', $showhide, wpjobportal::$_data[0]['jobcat']),WPJOBPORTAL_ALLOWED_TAGS); ?>
                                    </div>
                                </div>
                                <div class="wpjobportal-config-row">
                                    <div class="wpjobportal-config-title">
                                        <?php echo __('Newest Jobs', 'wp-job-portal'); ?>
                                    </div>
                                    <div class="wpjobportal-config-value">
                                        <?php echo wp_kses(WPJOBPORTALformfield::select('listnewestjobs', $showhide, wpjobportal::$_data[0]['listnewestjobs']),WPJOBPORTAL_ALLOWED_TAGS); ?>
                                    </div>
                                </div>
                                <div class="wpjobportal-config-row">
                                    <div class="wpjobportal-config-title">
                                        <?php echo __('Jobs By Types', 'wp-job-portal'); ?>
                                    </div>
                                    <div class="wpjobportal-config-value">
                                        <?php echo wp_kses(WPJOBPORTALformfield::select('listjobbytype', $showhide, wpjobportal::$_data[0]['listjobbytype']),WPJOBPORTAL_ALLOWED_TAGS); ?>
                                    </div>
                                </div>
                                <div class="wpjobportal-config-row">
                                    <div class="wpjobportal-config-title">
                                        <?php echo __('Jobs By Cities', 'wp-job-portal'); ?>
                                    </div>
                                    <div class="wpjobportal-config-value">
                                        <?php echo wp_kses(WPJOBPORTALformfield::select('jobsbycities', $showhide, wpjobportal::$_data[0]['jobsbycities']),WPJOBPORTAL_ALLOWED_TAGS); ?>
                                    </div>
                                </div>
                                <div class="wpjobportal-config-row">
                                    <div class="wpjobportal-config-title">
                                        <?php echo __('All Companies', 'wp-job-portal'); ?>
                                    </div>
                                    <div class="wpjobportal-config-value">
                                        <?php echo wp_kses(WPJOBPORTALformfield::select('listallcompanies', $showhide, wpjobportal::$_data[0]['listallcompanies']),WPJOBPORTAL_ALLOWED_TAGS); ?>
                                    </div>
                                </div>

                               <?php if(in_array('credits', wpjobportal::$_active_addons)){ ?>
                                    <div class="wpjobportal-config-row">
                                        <div class="wpjobportal-config-title">
                                            <?php echo __('Invoice', 'wp-job-portal'); ?>

                                        </div>
                                        <div class="wpjobportal-config-value">
                                            <?php echo wp_kses(WPJOBPORTALformfield::select('jspurchasehistory', $showhide, wpjobportal::$_data[0]['jspurchasehistory']),WPJOBPORTAL_ALLOWED_TAGS); ?>
                                        </div>
                                    </div>

                                    <div class="wpjobportal-config-row">
                                        <div class="wpjobportal-config-title">
                                            <?php echo __('My Subscription', 'wp-job-portal'); ?>
                                        </div>
                                        <div class="wpjobportal-config-value">
                                            <?php echo wp_kses(WPJOBPORTALformfield::select('jsratelist', $showhide, wpjobportal::$_data[0]['jsratelist']),WPJOBPORTAL_ALLOWED_TAGS); ?>
                                        </div>
                                    </div>

                                    <div class="wpjobportal-config-row">
                                        <div class="wpjobportal-config-title">
                                            <?php echo __('My Packages', 'wp-job-portal'); ?>

                                        </div>
                                        <div class="wpjobportal-config-value">
                                            <?php echo wp_kses(WPJOBPORTALformfield::select('jscreditlog', $showhide, wpjobportal::$_data[0]['jscreditlog']),WPJOBPORTAL_ALLOWED_TAGS); ?>
                                        </div>
                                    </div>

                                    <div class="wpjobportal-config-row">
                                        <div class="wpjobportal-config-title">
                                            <?php echo __('Packages', 'wp-job-portal'); ?>
                                        </div>
                                        <div class="wpjobportal-config-value">
                                            <?php echo wp_kses(WPJOBPORTALformfield::select('jscredits', $showhide, wpjobportal::$_data[0]['jscredits']),WPJOBPORTAL_ALLOWED_TAGS); ?>
                                        </div>
                                    </div>
                            <?php } ?>
                                <?php if(in_array('coverletter', wpjobportal::$_active_addons)){ ?>
                                    <div class="wpjobportal-config-row">
                                        <div class="wpjobportal-config-title">
                                            <?php echo __('My Cover Letters', 'wp-job-portal'); ?>

                                        </div>
                                        <div class="wpjobportal-config-value">
                                            <?php echo wp_kses(WPJOBPORTALformfield::select('mycoverletter', $showhide, wpjobportal::$_data[0]['mycoverletter']),WPJOBPORTAL_ALLOWED_TAGS); ?>
                                        </div>
                                    </div>
                                    <div class="wpjobportal-config-row">
                                        <div class="wpjobportal-config-title">
                                            <?php echo __('Add Cover Letter', 'wp-job-portal'); ?>

                                        </div>
                                        <div class="wpjobportal-config-value">
                                            <?php echo wp_kses(WPJOBPORTALformfield::select('formcoverletter', $showhide, wpjobportal::$_data[0]['formcoverletter']),WPJOBPORTAL_ALLOWED_TAGS); ?>
                                        </div>
                                    </div>
                                <?php } ?>
                                <div class="wpjobportal-config-row">
                                    <div class="wpjobportal-config-title">
                                        <?php echo __('Search Job', 'wp-job-portal'); ?>
                                    </div>
                                    <div class="wpjobportal-config-value">
                                        <?php echo wp_kses(WPJOBPORTALformfield::select('jobsearch', $showhide, wpjobportal::$_data[0]['jobsearch']),WPJOBPORTAL_ALLOWED_TAGS); ?>
                                    </div>
                                </div>
                                <?php if(in_array('resumeserach', wpjobportal::$_active_addons)){ ?>
                                    <div class="wpjobportal-config-row">
                                        <div class="wpjobportal-config-title">
                                            <?php echo __('Saved Searches', 'wp-job-portal'); ?>

                                        </div>
                                        <div class="wpjobportal-config-value">
                                            <?php echo wp_kses(WPJOBPORTALformfield::select('my_jobsearches', $showhide, wpjobportal::$_data[0]['my_jobsearches']),WPJOBPORTAL_ALLOWED_TAGS); ?>
                                        </div>
                                    </div>
                                <?php } ?>
                                <?php if (in_array('jobalert', wpjobportal::$_active_addons)) { ?>
                                    <div class="wpjobportal-config-row">
                                        <div class="wpjobportal-config-title">
                                            <?php echo __('Job Alert', 'wp-job-portal'); ?>
                                        </div>
                                        <div class="wpjobportal-config-value">
                                            <?php echo wp_kses(WPJOBPORTALformfield::select('jobalertsetting', $showhide, wpjobportal::$_data[0]['jobalertsetting']),WPJOBPORTAL_ALLOWED_TAGS); ?>
                                        </div>
                                    </div>
                                <?php } ?>
                                <?php if(in_array('message', wpjobportal::$_active_addons)){ ?>
                                        <div class="wpjobportal-config-row">
                                            <div class="wpjobportal-config-title">
                                                <?php echo __('Messages', 'wp-job-portal'); ?>

                                            </div>
                                            <div class="wpjobportal-config-value">
                                                <?php echo wp_kses(WPJOBPORTALformfield::select('jsmessages', $showhide, wpjobportal::$_data[0]['jsmessages']),WPJOBPORTAL_ALLOWED_TAGS); ?>
                                            </div>
                                        </div>
                                    <?php } ?>
                                <?php if (in_array('rssfeedback', wpjobportal::$_active_addons)) { ?>
                                    <div class="wpjobportal-config-row">
                                        <div class="wpjobportal-config-title">
                                            <?php echo __('Jobs RSS', 'wp-job-portal'); ?>

                                        </div>
                                        <div class="wpjobportal-config-value">
                                            <?php echo wp_kses(WPJOBPORTALformfield::select('wpjobportal_rss', $showhide, wpjobportal::$_data[0]['wpjobportal_rss']),WPJOBPORTAL_ALLOWED_TAGS); ?>
                                        </div>
                                    </div>
                                <?php } ?>
                                <?php /*
                                ...this configuration is extra...
                                <div class="wpjobportal-config-row">
                                    <div class="wpjobportal-config-title">
                                        <?php echo __('Register', 'wp-job-portal'); ?>
                                    </div>
                                    <div class="wpjobportal-config-value">
                                        <?php echo wp_kses(WPJOBPORTALformfield::select('jsregister', $showhide, wpjobportal::$_data[0]['jsregister']),WPJOBPORTAL_ALLOWED_TAGS); ?>
                                    </div>
                                </div>
                                */ ?>
                                <?php if(in_array('shortlist', wpjobportal::$_active_addons)){ ?>
                                    <div class="wpjobportal-config-row">
                                        <div class="wpjobportal-config-title">
                                            <?php echo __('Short Listed Jobs', 'wp-job-portal'); ?>

                                        </div>
                                        <div class="wpjobportal-config-value">
                                            <?php echo wp_kses(WPJOBPORTALformfield::select('listjobshortlist', $showhide, wpjobportal::$_data[0]['listjobshortlist']),WPJOBPORTAL_ALLOWED_TAGS); ?>
                                        </div>
                                    </div>
                                <?php } ?>
                                <div class="wpjobportal-config-row">
                                    <div class="wpjobportal-config-title">
                                        <?php echo __('My Applied Jobs', 'wp-job-portal'); ?>
                                    </div>
                                    <div class="wpjobportal-config-value">
                                        <?php echo wp_kses(WPJOBPORTALformfield::select('myappliedjobs', $showhide, wpjobportal::$_data[0]['myappliedjobs']),WPJOBPORTAL_ALLOWED_TAGS); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php echo wp_kses(WPJOBPORTALformfield::hidden('isgeneralbuttonsubmit', 0),WPJOBPORTAL_ALLOWED_TAGS); ?>
                <?php echo wp_kses(WPJOBPORTALformfield::hidden('wpjobportallt', 'configurationsjobseeker'),WPJOBPORTAL_ALLOWED_TAGS); ?>
                <?php echo wp_kses(WPJOBPORTALformfield::hidden('action', 'configuration_saveconfiguration'),WPJOBPORTAL_ALLOWED_TAGS); ?>
                <?php echo wp_kses(WPJOBPORTALformfield::hidden('form_request', 'wpjobportal'),WPJOBPORTAL_ALLOWED_TAGS); ?>
                <div class="wpjobportal-config-btn">
                    <?php echo wp_kses(WPJOBPORTALformfield::submitbutton('save', __('Save','wp-job-portal') .' '. __('Configuration', 'wp-job-portal'), array('class' => 'button wpjobportal-config-save-btn')),WPJOBPORTAL_ALLOWED_TAGS); ?>
                </div>
            </form>
        </div>

    <script >
        jQuery(document).ready(function () {
            var value = jQuery("#showapplybutton").val();
            var divsrc = "div#showhideapplybutton";
            if (value == 2) {
                jQuery(divsrc).slideDown("slow");
            }
        });
        function showhideapplybutton(src, value) {
            var divsrc = "div#" + src;
            if (value == 2) {
                jQuery(divsrc).slideDown("slow");
            } else if (value == 1) {
                jQuery(divsrc).slideUp("slow");
                jQuery(divsrc).hide();
            }
            return true;
        }

        jQuery(document).ready(function () {
            // jQuery("#tabs").tabs();
        });
    </script>
</div>
</div>
