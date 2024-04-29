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
                        <li><?php echo __('Short Codes','wp-job-portal'); ?></li>
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
        <?php WPJOBPORTALincluder::getTemplate('templates/admin/pagetitle',array('module' => 'wpjobportal' , 'layouts' => 'shortcodes')); ?>
        <!-- page content -->
        <div id="wpjobportal-admin-wrapper" class="p0">
            <div id="wpjobportal-shortcode-wrapper">
                <div class="wpjobportal-shortcode-1">
                    <?php echo __('Job seeker control panel','wp-job-portal'); ?>
                </div>
                <div class="wpjobportal-shortcode-2">
                    <?php echo '[wpjobportal_jobseeker_controlpanel]'; ?>
                </div>
                <div class="wpjobportal-shortcode-3">
                    <?php echo __('Show','wp-job-portal').' '. __('job seeker control panel','wp-job-portal'); ?>
                </div>
            </div>
            <div id="wpjobportal-shortcode-wrapper">
                <div class="wpjobportal-shortcode-1">
                    <?php echo __('Employer control panel','wp-job-portal'); ?>
                </div>
                <div class="wpjobportal-shortcode-2">
                    <?php echo '[wpjobportal_employer_controlpanel]'; ?>
                </div>
                <div class="wpjobportal-shortcode-3">
                    <?php echo __('Show','wp-job-portal').' '. __('employer control panel','wp-job-portal'); ?>
                </div>
            </div>
            <div id="wpjobportal-shortcode-wrapper">
                <div class="wpjobportal-shortcode-1">
                    <?php echo __('Job','wp-job-portal').' '. __('search','wp-job-portal'); ?>
                </div>
                <div class="wpjobportal-shortcode-2">
                    <?php echo '[wpjobportal_job_search]'; ?>
                </div>
                <div class="wpjobportal-shortcode-3">
                    <?php echo __('Show','wp-job-portal').' '. __('job','wp-job-portal').' '. __('search','wp-job-portal').' '. __('form','wp-job-portal'); ?>
                </div>
            </div>
            <div id="wpjobportal-shortcode-wrapper">
                <div class="wpjobportal-shortcode-1">
                    <?php echo __('Jobs','wp-job-portal'); ?>
                </div>
                <div class="wpjobportal-shortcode-2">
                    <?php echo '[wpjobportal_job]'; ?>
                </div>
                <div class="wpjobportal-shortcode-3">
                    <?php echo __('Show','wp-job-portal').' '. __('jobs','wp-job-portal'); ?>
                </div>
            </div>
            <div id="wpjobportal-shortcode-wrapper">
                <div class="wpjobportal-shortcode-1">
                    <?php echo __('Job categories','wp-job-portal'); ?>
                </div>
                <div class="wpjobportal-shortcode-2">
                    <?php echo '[wpjobportal_job_categories]'; ?>
                </div>
                <div class="wpjobportal-shortcode-3">
                    <?php echo __('Show','wp-job-portal').' '. __('job categories','wp-job-portal'); ?>
                </div>
            </div>
            <div id="wpjobportal-shortcode-wrapper">
                <div class="wpjobportal-shortcode-1">
                    <?php echo __('Job types','wp-job-portal'); ?>
                </div>
                <div class="wpjobportal-shortcode-2">
                    <?php echo '[wpjobportal_job_types]'; ?>
                </div>
                <div class="wpjobportal-shortcode-3">
                    <?php echo __('Show','wp-job-portal').' '. __('job types','wp-job-portal'); ?>
                </div>
            </div>
            <div id="wpjobportal-shortcode-wrapper">
                <div class="wpjobportal-shortcode-1">
                    <?php echo __('My applied jobs','wp-job-portal'); ?>
                </div>
                <div class="wpjobportal-shortcode-2">
                    <?php echo '[wpjobportal_my_appliedjobs]'; ?>
                </div>
                <div class="wpjobportal-shortcode-3">
                    <?php echo __('Show','wp-job-portal').' '. __('job seeker','wp-job-portal').' '. __('My applied jobs','wp-job-portal'); ?>
                </div>
            </div>
            <div id="wpjobportal-shortcode-wrapper">
                <div class="wpjobportal-shortcode-1">
                    <?php echo __('My companies','wp-job-portal'); ?>
                </div>
                <div class="wpjobportal-shortcode-2">
                    <?php echo '[wpjobportal_my_companies]'; ?>
                </div>
                <div class="wpjobportal-shortcode-3">
                    <?php echo __('Show employer','wp-job-portal').' '. __('My companies','wp-job-portal'); ?>
                </div>
            </div>
              <?php if(in_array('departments', wpjobportal::$_active_addons)){ ?>
                <div id="wpjobportal-shortcode-wrapper">
                    <div class="wpjobportal-shortcode-1">
                        <?php echo __('My departments','wp-job-portal'); ?>
                    </div>
                    <div class="wpjobportal-shortcode-2">
                        <?php echo '[wpjobportal_my_departments]'; ?>
                    </div>
                    <div class="wpjobportal-shortcode-3">
                        <?php echo __('Show','wp-job-portal').' '. __('employer','wp-job-portal').' '. __('My departments','wp-job-portal'); ?>
                    </div>
                </div>
                <?php } ?>
            <div id="wpjobportal-shortcode-wrapper">
                <div class="wpjobportal-shortcode-1">
                    <?php echo __('My jobs','wp-job-portal'); ?>
                </div>
                <div class="wpjobportal-shortcode-2">
                    <?php echo '[wpjobportal_my_jobs]'; ?>
                </div>
                <div class="wpjobportal-shortcode-3">
                    <?php echo __('Show','wp-job-portal').' '. __('employer','wp-job-portal').' '. __('My jobs','wp-job-portal'); ?>
                </div>
            </div>
            <div id="wpjobportal-shortcode-wrapper">
                <div class="wpjobportal-shortcode-1">
                    <?php echo __('My resume','wp-job-portal'); ?>
                </div>
                <div class="wpjobportal-shortcode-2">
                    <?php echo '[wpjobportal_my_resumes]'; ?>
                </div>
                <div class="wpjobportal-shortcode-3">
                    <?php echo __('Show','wp-job-portal').' '. __('job seeker','wp-job-portal').' '. __('My resumes','wp-job-portal'); ?>
                </div>
            </div>
            <div id="wpjobportal-shortcode-wrapper">
                <div class="wpjobportal-shortcode-1">
                    <?php echo __('Add','wp-job-portal').' '. __('Company','wp-job-portal'); ?>
                </div>
                <div class="wpjobportal-shortcode-2">
                    <?php echo '[wpjobportal_add_company]'; ?>
                </div>
                <div class="wpjobportal-shortcode-3">
                    <?php echo __('Show','wp-job-portal').' '. __('add','wp-job-portal').' '. __('company','wp-job-portal').' '. __('form','wp-job-portal'); ?>
                </div>
            </div>
             <?php if(in_array('departments', wpjobportal::$_active_addons)){ ?>
                <div id="wpjobportal-shortcode-wrapper">
                    <div class="wpjobportal-shortcode-1">
                        <?php echo __('Add','wp-job-portal').' '. __('Department','wp-job-portal'); ?>
                    </div>
                    <div class="wpjobportal-shortcode-2">
                        <?php echo '[wpjobportal_add_department]'; ?>
                    </div>
                    <div class="wpjobportal-shortcode-3">
                        <?php echo __('Show','wp-job-portal').' '. __('add','wp-job-portal').' '. __('Department','wp-job-portal').' '. __('form','wp-job-portal'); ?>
                    </div>
                </div>
                <?php } ?>
            <div id="wpjobportal-shortcode-wrapper">
                <div class="wpjobportal-shortcode-1">
                    <?php echo __('Add','wp-job-portal').' '. __('job','wp-job-portal'); ?>
                </div>
                <div class="wpjobportal-shortcode-2">
                    <?php echo '[wpjobportal_add_job]'; ?>
                </div>
                <div class="wpjobportal-shortcode-3">
                    <?php echo __('Show','wp-job-portal').' '. __('add','wp-job-portal').' '. __('job','wp-job-portal').' '. __('form','wp-job-portal'); ?>
                </div>
            </div>
            <div id="wpjobportal-shortcode-wrapper">
                <div class="wpjobportal-shortcode-1">
                    <?php echo __('Add','wp-job-portal').' '. __('resume','wp-job-portal'); ?>
                </div>
                <div class="wpjobportal-shortcode-2">
                    <?php echo '[wpjobportal_add_resume]'; ?>
                </div>
                <div class="wpjobportal-shortcode-3">
                    <?php echo __('Show','wp-job-portal').' '. __('add','wp-job-portal').' '. __('resume','wp-job-portal').' '. __('form','wp-job-portal'); ?>
                </div>
            </div>
            <div id="wpjobportal-shortcode-wrapper">
                <div class="wpjobportal-shortcode-1">
                    <?php echo __('Resume','wp-job-portal').' '. __('search','wp-job-portal'); ?>
                </div>
                <div class="wpjobportal-shortcode-2">
                    <?php echo '[wpjobportal_resume_search]'; ?>
                </div>
                <div class="wpjobportal-shortcode-3">
                    <?php echo __('Show','wp-job-portal').' '. __('resume','wp-job-portal').' '. __('search','wp-job-portal').' '. __('form','wp-job-portal'); ?>
                </div>
            </div>
            <div id="wpjobportal-shortcode-wrapper">
                <div class="wpjobportal-shortcode-1">
                    <?php echo __('Employer registration','wp-job-portal'); ?>
                </div>
                <div class="wpjobportal-shortcode-2">
                    <?php echo '[wpjobportal_employer_registration]'; ?>
                </div>
                <div class="wpjobportal-shortcode-3">
                    <?php echo __('Show','wp-job-portal').' '. __('employer','wp-job-portal').' '. __('registration form','wp-job-portal'); ?>
                </div>
            </div>
            <div id="wpjobportal-shortcode-wrapper">
                <div class="wpjobportal-shortcode-1">
                    <?php echo __('Job seeker registration','wp-job-portal'); ?>
                </div>
                <div class="wpjobportal-shortcode-2">
                    <?php echo '[wpjobportal_jobseeker_registration]'; ?>
                </div>
                <div class="wpjobportal-shortcode-3">
                    <?php echo __('Show','wp-job-portal').' '. __('job seeker','wp-job-portal').' '. __('registration form','wp-job-portal'); ?>
                </div>
            </div>


            <div id="wpjobportal-shortcode-wrapper">
                <div class="wpjobportal-shortcode-1">
                    <?php echo __('Login page','wp-job-portal'); ?>
                </div>
                <div class="wpjobportal-shortcode-2">
                    <?php echo '[wpjobportal_login_page]'; ?>
                </div>
                <div class="wpjobportal-shortcode-3">
                    <?php echo __('Show login page','wp-job-portal'); ?>
                </div>
            </div>
            <div id="wpjobportal-shortcode-wrapper">
                <div class="wpjobportal-shortcode-1">
                    <?php echo __('Search job','wp-job-portal').' '. __('widget','wp-job-portal'); ?>
                </div>
                <div class="wpjobportal-shortcode-2">
                    <?php echo '[wpjobportal_searchjob]'; ?>
                </div>
                <div class="wpjobportal-shortcode-3">
                    <?php echo __('Show','wp-job-portal').' '. __('search','wp-job-portal').' '. __('job','wp-job-portal').' '. __('form','wp-job-portal').' '. __('in widget style','wp-job-portal'); ?>
                </div>
            </div>
        <?php if(in_array('credits', wpjobportal::$_active_addons)){ ?>
                <div id="wpjobportal-shortcode-wrapper">
                    <div class="wpjobportal-shortcode-1">
                        <?php echo __('My Packages','wp-job-portal'); ?>
                    </div>
                    <div class="wpjobportal-shortcode-2">
                        <?php echo '[wpjobportal_mypackages]'; ?>
                    </div>
                    <div class="wpjobportal-shortcode-3">
                        <?php echo __('Show','wp-job-portal').' '. __('My','wp-job-portal').' '. __('Packages','wp-job-portal').' '. __('form','wp-job-portal').' '. __('in widget style','wp-job-portal'); ?>
                    </div>
                </div>

                <div id="wpjobportal-shortcode-wrapper">
                    <div class="wpjobportal-shortcode-1">
                        <?php echo __('My Subscription','wp-job-portal'); ?>
                    </div>
                    <div class="wpjobportal-shortcode-2">
                        <?php echo '[wpjobportal_mysubscription]'; ?>
                    </div>
                    <div class="wpjobportal-shortcode-3">
                        <?php echo __('Show','wp-job-portal').' '. __('My','wp-job-portal').' '. __('Subscription','wp-job-portal').' '. __('form','wp-job-portal'); ?>
                    </div>
                </div>

                <div id="wpjobportal-shortcode-wrapper">
                    <div class="wpjobportal-shortcode-1">
                        <?php echo __('All Packages','wp-job-portal'); ?>
                    </div>
                    <div class="wpjobportal-shortcode-2">
                        <?php echo '[wpjobportal_allpackages]'; ?>
                    </div>
                    <div class="wpjobportal-shortcode-3">
                        <?php echo __('Show','wp-job-portal').' '. __('All','wp-job-portal').' '. __('Packages','wp-job-portal').' '. __('form','wp-job-portal'); ?>
                    </div>
                </div>

                <div id="wpjobportal-shortcode-wrapper">
                    <div class="wpjobportal-shortcode-1">
                        <?php echo __('My Invoices','wp-job-portal'); ?>
                    </div>
                    <div class="wpjobportal-shortcode-2">
                        <?php echo '[wpjobportal_myinvoices]'; ?>
                    </div>
                    <div class="wpjobportal-shortcode-3">
                        <?php echo __('Show','wp-job-portal').' '. __('My','wp-job-portal').' '. __('Invoices','wp-job-portal').' '. __('form','wp-job-portal'); ?>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</div>
