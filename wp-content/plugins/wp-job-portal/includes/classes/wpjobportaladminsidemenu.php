<?php
if (!defined('ABSPATH')) die('Restricted Access');
$c = WPJOBPORTALrequest::getVar('page',null,'wpjobportal');
$layout = WPJOBPORTALrequest::getVar('wpjobportallt');
$ff = WPJOBPORTALrequest::getVar('ff');
$for = WPJOBPORTALrequest::getVar('for');
?>
<script type="text/javascript">
    jQuery( function() {
        jQuery( "#accordion" ).accordion({
            heightStyle: "content",
            collapsible: true,
            active: true,
        });
    });
</script>
<div id="wpjobportaladmin-logo">
    <a href="admin.php?page=wpjobportal" class="wpjobportaladmin-anchor">
        <img src="<?php echo WPJOBPORTAL_PLUGIN_URL.'includes/images/control_panel/dashboard/logo.png'; ?>"/>
    </a>
    <img id="wpjobportaladmin-menu-toggle" src="<?php echo WPJOBPORTAL_PLUGIN_URL.'includes/images/control_panel/dashboard/admin-left-menu/menu.png'; ?>" />
</div>
<ul class="wpjobportaladmin-sidebar-menu tree" data-widget="tree" id="accordion">
    <li class="treeview <?php if( ($c == 'wpjobportal' && $layout != 'themes' && $layout != 'shortcodes') || $c == 'wpjobportal_activitylog' || $c == 'wpjobportal_systemerror' || $c == 'wpjobportal_slug' ) echo 'active'; ?>">
        <a href="admin.php?page=wpjobportal" title="<?php echo __('dashboard' , 'wp-job-portal'); ?>">
            <img class="wpjobportaladmin-menu-icon" alt="<?php echo __('dashboard' , 'wp-job-portal'); ?>" src="<?php echo WPJOBPORTAL_PLUGIN_URL.'includes/images/control_panel/dashboard/admin-left-menu/dashboard.png'; ?>" />
            <span class="wpjobportaladmin-text">
                <?php echo __('Dashboard' , 'wp-job-portal'); ?>
            </span>
        </a>
        <ul class="wpjobportaladmin-sidebar-submenu treeview-menu">
            <li class="<?php if($c == 'wpjobportal' && ($layout == 'controlpanel' || $layout == '')) echo 'active'; ?>">
                <a href="admin.php?page=wpjobportal" title="<?php echo __('dashboard', 'wp-job-portal'); ?>">
                    <?php echo __('Dashboard', 'wp-job-portal'); ?>
                </a>
            </li>
            <li class="<?php if($c == 'wpjobportal_activitylog' && ($layout == 'wpjobportal_activitylog' || $layout == '')) echo 'active'; ?>">
                <a href="admin.php?page=wpjobportal_activitylog" title="<?php echo __('activity log','wp-job-portal'); ?>">
                    <?php echo __('Activity Log','wp-job-portal'); ?>
                </a>
            </li>
            <li class="<?php if($c == 'wpjobportal' && ($layout == 'wpjobportalstats' || $layout == '')) echo 'active'; ?>">
                <a href="admin.php?page=wpjobportal&wpjobportallt=wpjobportalstats" title="<?php echo __('stats','wp-job-portal'); ?>">
                    <?php echo __('Stats','wp-job-portal'); ?>
                </a>
            </li>
            <?php /*<li class="<?php if($c == 'wpjobportal' && ($layout == 'translations')) echo 'active'; ?>">
                <a href="admin.php?page=wpjobportal&wpjobportallt=translations" title="<?php echo __('translations','wp-job-portal'); ?>">
                    <?php echo __('Translations','wp-job-portal'); ?>
                </a>
            </li> */?>
            <li class="<?php if($c == 'wpjobportal_systemerror' && ($layout == 'wpjobportal_systemerror' || $layout == '')) echo 'active'; ?>">
                <a href="admin.php?page=wpjobportal_systemerror" title="<?php echo __('system errors','wp-job-portal'); ?>">
                    <?php echo __('System Errors','wp-job-portal'); ?>
                </a>
            </li>
            <li class="<?php if($c == 'wpjobportal_slug' && ($layout == 'slug')) echo 'active'; ?>">
                <a href="admin.php?page=wpjobportal_slug&wpjobportallt=slug" title="<?php echo __('slug','wp-job-portal'); ?>">
                    <?php echo __('Slug','wp-job-portal'); ?>
                </a>
            </li>
        </ul>
    </li>
    <li class="treeview <?php if($c == 'wpjobportal_configuration' || $c == 'wpjobportal_paymentmethodconfiguration' || $c == 'wpjobportal_cronjob' ) echo 'active'; ?>">
        <a href="admin.php?page=wpjobportal_configuration" title="<?php echo __('configuration' , 'wp-job-portal'); ?>">
            <img class="wpjobportaladmin-menu-icon" alt="<?php echo __('configuration' , 'wp-job-portal'); ?>" src="<?php echo WPJOBPORTAL_PLUGIN_URL.'includes/images/control_panel/dashboard/admin-left-menu/config.png'; ?>" />
            <span class="wpjobportaladmin-text">
                <?php echo __('Configuration' , 'wp-job-portal'); ?>
            </span>
        </a>
        <ul class="wpjobportaladmin-sidebar-submenu treeview-menu">
            <li class="<?php if($c == 'wpjobportal_configuration' && ($layout == 'configurations')) echo 'active'; ?>">
                <a href="admin.php?page=wpjobportal_configuration&wpjobportallt=configurations&wpjpconfigid=general_setting" title="<?php echo __('configuration', 'wp-job-portal'); ?>">
                    <?php echo __('Configuration', 'wp-job-portal'); ?>
                </a>
            </li>
        </ul>
    </li>
    <li class="treeview <?php if($c == 'wpjobportal_theme') echo 'active'; ?>">
        <a href="admin.php?page=wpjobportal_theme" title="<?php echo __('colors' , 'wp-job-portal'); ?>">
            <img class="wpjobportaladmin-menu-icon" alt="<?php echo __('colors' , 'wp-job-portal'); ?>" src="<?php echo WPJOBPORTAL_PLUGIN_URL.'includes/images/control_panel/dashboard/admin-left-menu/theme.png'; ?>" />
            <span class="wpjobportaladmin-text">
                <?php echo __('Colors' , 'wp-job-portal'); ?>
            </span>
        </a>
        <ul class="wpjobportaladmin-sidebar-submenu treeview-menu">
            <li class="<?php if($c == 'wpjobportal_theme') echo 'active'; ?>">
                <a href="admin.php?page=wpjobportal_theme" title="<?php echo __('colors','wp-job-portal'); ?>">
                    <?php echo __('Colors','wp-job-portal'); ?>
                </a>
            </li>
        </ul>
    </li>
    <li class="treeview <?php if($c == 'wpjobportal_premiumplugin') echo 'active'; ?>">
        <a href="admin.php?page=wpjobportal_premiumplugin" title="<?php echo __('ad ons' , 'wp-job-portal'); ?>">
            <img class="wpjobportaladmin-menu-icon" alt="<?php echo __('ad ons' , 'wp-job-portal'); ?>" src="<?php echo WPJOBPORTAL_PLUGIN_URL.'includes/images/control_panel/dashboard/admin-left-menu/ad-ons.png'; ?>" />
            <span class="wpjobportaladmin-text">
                <?php echo __('Install Addons' , 'wp-job-portal'); ?>
            </span>
        </a>
        <ul class="wpjobportaladmin-sidebar-submenu treeview-menu">
            <li class="<?php if($c == 'wpjobportal_premiumplugin' && ($layout == '' || $layout == 'step1' || $layout == 'step2' || $layout == 'step3')) echo 'active'; ?>">
                <a href="admin.php?page=wpjobportal_premiumplugin" title="<?php echo __('install addons','wp-job-portal'); ?>">
                    <?php echo __('Install Addons','wp-job-portal'); ?>
                </a>
            </li>
            <li class="<?php if($c == 'wpjobportal_premiumplugin' && ($layout == 'addonfeatures')) echo 'active'; ?>">
                <a href="?page=wpjobportal_premiumplugin&wpjobportallt=addonfeatures" title="<?php echo __('addons list','wp-job-portal'); ?>">
                    <?php echo __('Addons List','wp-job-portal'); ?>
                </a>
            </li>
        </ul>
    </li>
    <li class="treeview <?php if(($c == 'wpjobportal_company' || ($c == 'wpjobportal_fieldordering' && $ff == 1)) ) echo 'active'; ?>">
        <a href="admin.php?page=wpjobportal_company" title="<?php echo __('companies' , 'wp-job-portal'); ?>">
            <img class="wpjobportaladmin-menu-icon" alt="<?php echo __('companies' , 'wp-job-portal'); ?>" src="<?php echo WPJOBPORTAL_PLUGIN_URL.'includes/images/control_panel/dashboard/admin-left-menu/companies.png'; ?>" />
            <span class="wpjobportaladmin-text">
                <?php echo __('Companies' , 'wp-job-portal'); ?>
            </span>
        </a>
        <ul class="wpjobportaladmin-sidebar-submenu treeview-menu">
            <li class="<?php if($c == 'wpjobportal_company' && ($layout == '')) echo 'active'; ?>">
                <a href="admin.php?page=wpjobportal_company" title="<?php echo __('companies', 'wp-job-portal'); ?>">
                    <?php echo __('Companies', 'wp-job-portal'); ?>
                </a>
            </li>
            <li class="<?php if($c == 'wpjobportal_company' && ($layout == 'formcompany')) echo 'active'; ?>">
                <a href="admin.php?page=wpjobportal_company&wpjobportallt=formcompany" title="<?php echo __('add new company', 'wp-job-portal'); ?>">
                    <?php echo __('Add New Company', 'wp-job-portal'); ?>
                </a>
            </li>
            <li class="<?php if($c == 'wpjobportal_company' && ($layout == 'companiesqueue')) echo 'active'; ?>">
                <a href="admin.php?page=wpjobportal_company&wpjobportallt=companiesqueue" title="<?php echo __('approval queue', 'wp-job-portal'); ?>">
                    <?php echo __('Approval Queue', 'wp-job-portal'); ?>
                </a>
            </li>
            <li class="<?php if($c == 'wpjobportal_fieldordering' && ($layout == '')) echo 'active'; ?>">
                <a href="admin.php?page=wpjobportal_fieldordering&ff=1" title="<?php echo __('fields', 'wp-job-portal'); ?>">
                    <?php echo __('Fields', 'wp-job-portal'); ?>
                </a>
            </li>
        </ul>
    </li>
    <?php if(in_array('departments', wpjobportal::$_active_addons)){ ?>
        <li class="treeview <?php if($c == 'wpjobportal_departments') echo 'active'; ?>">
            <a href="admin.php?page=wpjobportal_departments" title="<?php echo __('departments' , 'wp-job-portal'); ?>">
                <img class="wpjobportaladmin-menu-icon" alt="<?php echo __('departments' , 'wp-job-portal'); ?>" src="<?php echo WPJOBPORTAL_PLUGIN_URL.'includes/images/control_panel/dashboard/admin-left-menu/department.png'; ?>" />
                <span class="wpjobportaladmin-text">
                    <?php echo __('Departments' , 'wp-job-portal'); ?>
                </span>
            </a>
            <ul class="wpjobportaladmin-sidebar-submenu treeview-menu">
                <li class="<?php if($c == 'wpjobportal_departments' && ($layout == '')) echo 'active'; ?>">
                    <a href="admin.php?page=wpjobportal_departments" title="<?php echo __('departments', 'wp-job-portal'); ?>">
                        <?php echo __('Departments', 'wp-job-portal'); ?>
                    </a>
                </li>
                <li class="<?php if($c == 'wpjobportal_departments' && ($layout == 'formdepartment')) echo 'active'; ?>">
                    <a href="admin.php?page=wpjobportal_departments&wpjobportallt=formdepartment" title="<?php echo __('add new department', 'wp-job-portal'); ?>">
                        <?php echo __('Add New Department', 'wp-job-portal'); ?>
                    </a>
                </li>
                <li class="<?php if($c == 'wpjobportal_departments' && ($layout == 'departmentqueue')) echo 'active'; ?>">
                    <a href="admin.php?page=wpjobportal_departments&wpjobportallt=departmentqueue" title="<?php echo __('approval queue', 'wp-job-portal'); ?>">
                        <?php echo __('Approval Queue', 'wp-job-portal'); ?>
                    </a>
                </li>
            </ul>
        </li>
    <?php }else{
        $plugininfo = checkWPJPPluginInfo('wp-job-portal-departments/wp-job-portal-departments.php');
        if($plugininfo['availability'] == "1"){
            $text = $plugininfo['text'];
            $url = "plugins.php?s=wp-job-portal-departments&plugin_status=inactive";
        }elseif($plugininfo['availability'] == "0"){
            $text = $plugininfo['text'];
            $url = "https://wpjobportal.com/product/multi_departments/";
        } ?>
        <li class="treeview">
            <a href="javascript: void(0);" title="<?php echo __('departments' , 'wp-job-portal'); ?>">
                <img class="wpjobportaladmin-menu-icon" alt="<?php echo __('departments' , 'wp-job-portal'); ?>" src="<?php echo WPJOBPORTAL_PLUGIN_URL.'includes/images/control_panel/dashboard/admin-left-menu/grey-menu/department.png'; ?>" />
                <span class="wpjobportaladmin-text disabled-menu"><?php echo __('Department' , 'wp-job-portal'); ?></span>
            </a>
            <ul class="wpjobportaladmin-sidebar-submenu treeview-menu">
                <li class="disabled-menu">
                    <span class="wpjobportaladmin-text"><?php echo __('departments' , 'wp-job-portal'); ?></span>
                    <a href="<?php echo esc_url($url); ?>" class="wpjobportaladmin-install-btn" title="<?php echo esc_attr($text); ?>"><?php echo esc_html($text); ?></a>
                </li>
            </ul>
        </li>
    <?php } ?>
    <li class="treeview <?php if($c == 'wpjobportal_job' || $c == 'wpjobportal_jobapply' || $c == 'wpjobportal_jobalert' || $c == 'wpjobportal_customfield' || ($c == 'wpjobportal_fieldordering' && $ff == 2)) echo 'active'; ?>">
        <a href="admin.php?page=wpjobportal_job" title="<?php echo __('jobs' , 'wp-job-portal'); ?>">
            <img class="wpjobportaladmin-menu-icon" alt="<?php echo __('jobs' , 'wp-job-portal'); ?>" src="<?php echo WPJOBPORTAL_PLUGIN_URL.'includes/images/control_panel/dashboard/admin-left-menu/jobs.png'; ?>" />
            <span class="wpjobportaladmin-text">
                <?php echo __('Jobs' , 'wp-job-portal'); ?>
            </span>
        </a>
        <ul class="wpjobportaladmin-sidebar-submenu treeview-menu">
            <li class="<?php if($c == 'wpjobportal_job' && ($c == 'wpjobportal_jobapply' && $layout == 'jobappliedresume' || $layout == '')) echo 'active'; ?>">
                <a href="admin.php?page=wpjobportal_job" title="<?php echo __('jobs', 'wp-job-portal'); ?>">
                    <?php echo __('Jobs', 'wp-job-portal'); ?>
                </a>
            </li>
            <li class="<?php if($c == 'wpjobportal_job' && ($layout == 'formjob')) echo 'active'; ?>">
                <a href="admin.php?page=wpjobportal_job&wpjobportallt=formjob" title="<?php echo __('add new job', 'wp-job-portal'); ?>">
                    <?php echo __('Add New Job', 'wp-job-portal'); ?>
                </a>
            </li>
            <li class="<?php if($c == 'wpjobportal_job' && ($layout == 'jobqueue')) echo 'active'; ?>">
                <a href="admin.php?page=wpjobportal_job&wpjobportallt=jobqueue" title="<?php echo __('approval queue', 'wp-job-portal'); ?>">
                    <?php echo __('Approval Queue', 'wp-job-portal'); ?>
                </a>
            </li>
            <li class="<?php if($c == 'wpjobportal_fieldordering' && ($layout == '')) echo 'active'; ?>">
                <a href="admin.php?page=wpjobportal_fieldordering&ff=2" title="<?php echo __('fields', 'wp-job-portal'); ?>">
                    <?php echo __('Fields', 'wp-job-portal'); ?>
                </a>
            </li>
            <li class="<?php if($c == 'wpjobportal_fieldordering' && ($layout == 'searchfields')) echo 'active'; ?>">
                <a href="admin.php?page=wpjobportal_fieldordering&wpjobportallt=searchfields&ff=2" title="<?php echo __('search fields', 'wp-job-portal'); ?>">
                    <?php echo __('Search Fields', 'wp-job-portal'); ?>
                </a>
            </li>
            <?php
                //do_action('wpjobportal_addons_custom_fields_searchfields',$c,$layout);
            ?>
            <?php
            if(in_array('jobalert', wpjobportal::$_active_addons)){
                do_action('wpjobportal_addons_sidemenue_admin_jobalert',$c,$layout);
            }else{
                $plugininfo = checkWPJPPluginInfo('wp-job-portal-jobalert/wp-job-portal-jobalert.php');
                if($plugininfo['availability'] == "1"){
                    $text = $plugininfo['text'];
                    $url = "plugins.php?s=wp-job-portal-jobalert&plugin_status=inactive";
                }elseif($plugininfo['availability'] == "0"){
                    $text = $plugininfo['text'];
                    $url = "https://wpjobportal.com/product/job-alert/";
                } ?>
                <li class="disabled-menu">
                    <span class="wpjobportaladmin-text"><?php echo __('Job Alert' , 'wp-job-portal'); ?></span>
                    <a href="<?php echo esc_url($url); ?>" class="wpjobportaladmin-install-btn" title="<?php echo esc_attr($text); ?>"><?php echo esc_html($text); ?></a>
                </li>
            <?php } ?>
        </ul>
    </li>
    <?php if(in_array('coverletter', wpjobportal::$_active_addons)){ ?>
        <li class="treeview <?php if($c == 'wpjobportal_coverletter') echo 'active'; ?>">
            <a href="admin.php?page=wpjobportal_coverletter" title="<?php echo __('coverletters' , 'wp-job-portal'); ?>">
                <img class="wpjobportaladmin-menu-icon" alt="<?php echo __('coverletters' , 'wp-job-portal'); ?>" src="<?php echo WPJOBPORTAL_PLUGIN_URL.'includes/images/control_panel/dashboard/admin-left-menu/cover-letter.png'; ?>" />
                <span class="wpjobportaladmin-text">
                    <?php echo __('Cover Letters' , 'wp-job-portal'); ?>
                </span>
            </a>
            <ul class="wpjobportaladmin-sidebar-submenu treeview-menu">
                <li class="<?php if($c == 'wpjobportal_coverletter' && (($layout == '') || ($layout == 'formcoverletter') )) echo 'active'; ?>">
                    <a href="admin.php?page=wpjobportal_coverletter" title="<?php echo __('coverletter', 'wp-job-portal'); ?>">
                        <?php echo __('Cover Letters', 'wp-job-portal'); ?>
                    </a>
                </li>
                <?php /*
                <li class="<?php if($c == 'wpjobportal_coverletter' && ($layout == 'formcoverletter')) echo 'active'; ?>">
                    <a href="admin.php?page=wpjobportal_coverletter&wpjobportallt=formcoverletter" title="<?php //echo __('add new cover letter', 'wp-job-portal'); ?>">
                        <?php //echo __('Add New Cover Letter', 'wp-job-portal'); ?>
                    </a>
                </li>
                */ ?>
                <li class="<?php if($c == 'wpjobportal_coverletter' && ($layout == 'coverletterqueue')) echo 'active'; ?>">
                    <a href="admin.php?page=wpjobportal_coverletter&wpjobportallt=coverletterqueue" title="<?php echo __('approval queue', 'wp-job-portal'); ?>">
                        <?php echo __('Approval Queue', 'wp-job-portal'); ?>
                    </a>
                </li>
            </ul>
        </li>
    <?php }else{
        $plugininfo = checkWPJPPluginInfo('wp-job-portal-coverletter/wp-job-portal-coverletter.php');
        if($plugininfo['availability'] == "1"){
            $text = $plugininfo['text'];
            $url = "plugins.php?s=wp-job-portal-coverletter&plugin_status=inactive";
        }elseif($plugininfo['availability'] == "0"){
            $text = $plugininfo['text'];
            $url = "https://wpjobportal.com/product/multi_coverletter/";
        } ?>
        <li class="treeview">
            <a href="javascript: void(0);" title="<?php echo __('coverletter' , 'wp-job-portal'); ?>">
                <img class="wpjobportaladmin-menu-icon" alt="<?php echo __('coverletter' , 'wp-job-portal'); ?>" src="<?php echo WPJOBPORTAL_PLUGIN_URL.'includes/images/control_panel/dashboard/admin-left-menu/grey-menu/cover-letter.png'; ?>" />
                <span class="wpjobportaladmin-text disabled-menu"><?php echo __('Cover Letter' , 'wp-job-portal'); ?></span>
            </a>
            <ul class="wpjobportaladmin-sidebar-submenu treeview-menu">
                <li class="disabled-menu">
                    <span class="wpjobportaladmin-text"><?php echo __('Cover Letter' , 'wp-job-portal'); ?></span>
                    <a href="<?php echo esc_url($url); ?>" class="wpjobportaladmin-install-btn" title="<?php echo esc_attr($text); ?>"><?php echo esc_html($text); ?></a>
                </li>
            </ul>
        </li>
    <?php } ?>

    <li class="treeview <?php if($c == 'wpjobportal_resume' ||  ($c == 'wpjobportal_fieldordering' && $ff == 3)) echo 'active'; ?>">
        <a href="admin.php?page=wpjobportal_resume" title="<?php echo __('resume' , 'wp-job-portal'); ?>">
            <img class="wpjobportaladmin-menu-icon" alt="<?php echo __('resume' , 'wp-job-portal'); ?>" src="<?php echo WPJOBPORTAL_PLUGIN_URL.'includes/images/control_panel/dashboard/admin-left-menu/resume.png'; ?>" />
            <span class="wpjobportaladmin-text">
                <?php echo __('Resume' , 'wp-job-portal'); ?>
            </span>
        </a>
        <ul class="wpjobportaladmin-sidebar-submenu treeview-menu">
            <li class="<?php if($c == 'wpjobportal_resume' && ($layout == '')) echo 'active'; ?>">
                <a href="admin.php?page=wpjobportal_resume" title="<?php echo __('resume', 'wp-job-portal'); ?>">
                    <?php echo __('Resume', 'wp-job-portal'); ?>
                </a>
            </li>
            <li class="<?php if($c == 'wpjobportal_resume' && ($layout == 'resumequeue')) echo 'active'; ?>">
                <a href="admin.php?page=wpjobportal_resume&wpjobportallt=resumequeue" title="<?php echo __('approval queue', 'wp-job-portal'); ?>">
                    <?php echo __('Approval Queue', 'wp-job-portal'); ?>
                </a>
            </li>
            <li class="<?php if($c == 'wpjobportal_fieldordering' && ($layout == '')) echo 'active'; ?>">
                <a href="admin.php?page=wpjobportal_fieldordering&ff=3" title="<?php echo __('fields', 'wp-job-portal'); ?>">
                    <?php echo __('Fields', 'wp-job-portal'); ?>
                </a>
            </li>
            <li class="<?php if($c == 'wpjobportal_fieldordering' && ($layout == 'searchfields')) echo 'active'; ?>">
                <a href="admin.php?page=wpjobportal_fieldordering&wpjobportallt=searchfields&ff=3" title="<?php echo __('search fields', 'wp-job-portal'); ?>">
                    <?php echo __('Search Fields', 'wp-job-portal'); ?>
                </a>
            </li>
        </ul>
    </li>
    <?php
        if(in_array('message', wpjobportal::$_active_addons)){
            do_action('wpjobportal_addons_admin_sidemenu_links_for_message' , $c,$layout );
        }else{
            $plugininfo = checkWPJPPluginInfo('wp-job-portal-message/wp-job-portal-message.php');
            if($plugininfo['availability'] == "1"){
                $text = $plugininfo['text'];
                $url = "plugins.php?s=wp-job-portal-message&plugin_status=inactive";
            }elseif($plugininfo['availability'] == "0"){
                $text = $plugininfo['text'];
                $url = "https://wpjobportal.com/product/messages/";
            } ?>
            <li class="treeview">
                <a href="javascript: void(0);" title="<?php echo __('Message' , 'wp-job-portal'); ?>">
                    <img src="<?php echo WPJOBPORTAL_PLUGIN_URL.'includes/images/control_panel/dashboard/admin-left-menu/grey-menu/message.png'; ?>" alt="<?php echo __('message' , 'wp-job-portal'); ?>" class="wpjobportaladmin-menu-icon">
                    <span class="wpjobportaladmin-text disabled-menu"><?php echo __('Message' , 'wp-job-portal'); ?></span>
                </a>
                <ul class="wpjobportaladmin-sidebar-submenu treeview-menu">
                    <li class="disabled-menu">
                        <span class="wpjobportaladmin-text"><?php echo __('Message' , 'wp-job-portal'); ?></span>
                        <a href="<?php echo esc_url($url); ?>" class="wpjobportaladmin-install-btn" title="<?php echo esc_attr($text); ?>"><?php echo esc_html($text); ?></a>
                    </li>
                </ul>
            </li>
    <?php } ?>
    <?php
        if(in_array('credits', wpjobportal::$_active_addons)){
            do_action('wpjobportal_addons_admin_sidemenu_package',$c,$layout);
        }else{

            $plugininfo = checkWPJPPluginInfo('wp-job-portal-credits/wp-job-portal-credits.php');
            if($plugininfo['availability'] == "1"){
                $text = $plugininfo['text'];
                $url = "plugins.php?s=wp-job-portal-credits&plugin_status=inactive";
            }elseif($plugininfo['availability'] == "0"){
                $text = $plugininfo['text'];
                $url = "https://wpjobportal.com/product/credit-system/";
            } ?>
            <li class="treeview">
                <a href="javascript: void(0);" title="<?php echo __('Credits' , 'wp-job-portal'); ?>">
                    <img src="<?php echo WPJOBPORTAL_PLUGIN_URL.'includes/images/control_panel/dashboard/admin-left-menu/grey-menu/credits.png'; ?>" alt="<?php echo __('credits' , 'wp-job-portal'); ?>" class="wpjobportaladmin-menu-icon">
                    <span class="wpjobportaladmin-text disabled-menu"><?php echo __('Credits' , 'wp-job-portal'); ?></span>
                </a>
                <ul class="wpjobportaladmin-sidebar-submenu treeview-menu">
                    <li class="disabled-menu">
                        <span class="wpjobportaladmin-text"><?php echo __('Credits' , 'wp-job-portal'); ?></span>
                        <a href="<?php echo esc_url($url); ?>" class="wpjobportaladmin-install-btn" title="<?php echo esc_attr($text); ?>"><?php echo esc_html($text); ?></a>
                    </li>
                </ul>
            </li>
    <?php } ?>
    <?php
        if(in_array('folder', wpjobportal::$_active_addons)){
            do_action('wpjobportal_addons_admin_sidemenu_links_for_folder' , $c,$layout );
        }else{
            $plugininfo = checkWPJPPluginInfo('wp-job-portal-folder/wp-job-portal-folder.php');
            if($plugininfo['availability'] == "1"){
                $text = $plugininfo['text'];
                $url = "plugins.php?s=wp-job-portal-folder&plugin_status=inactive";
            }elseif($plugininfo['availability'] == "0"){
                $text = $plugininfo['text'];
                $url = "https://wpjobportal.com/product/folders/";
            } ?>
            <li class="treeview">
                <a href="javascript: void(0);" title="<?php echo __('Folder' , 'wp-job-portal'); ?>">
                    <img src="<?php echo WPJOBPORTAL_PLUGIN_URL.'includes/images/control_panel/dashboard/admin-left-menu/grey-menu/folders.png'; ?>" alt="<?php echo __('folder' , 'wp-job-portal'); ?>" class="wpjobportaladmin-menu-icon">
                    <span class="wpjobportaladmin-text disabled-menu"><?php echo __('Folder' , 'wp-job-portal'); ?></span>
                </a>
                <ul class="wpjobportaladmin-sidebar-submenu treeview-menu">
                    <li class="disabled-menu">
                        <span class="wpjobportaladmin-text"><?php echo __('Folder' , 'wp-job-portal'); ?></span>
                        <a href="<?php echo esc_url($url); ?>" class="wpjobportaladmin-install-btn" title="<?php echo esc_attr($text); ?>"><?php echo esc_html($text); ?></a>
                    </li>
                </ul>
            </li>
    <?php } ?>
    <li class="treeview <?php if($c == 'wpjobportal_jobtype') echo 'active'; ?>">
        <a href="admin.php?page=wpjobportal_jobtype" title="<?php echo __('job types' , 'wp-job-portal'); ?>">
            <img class="wpjobportaladmin-menu-icon" alt="<?php echo __('job types' , 'wp-job-portal'); ?>" src="<?php echo WPJOBPORTAL_PLUGIN_URL.'includes/images/control_panel/dashboard/admin-left-menu/job-types.png'; ?>" />
            <span class="wpjobportaladmin-text">
                <?php echo __('Job Types' , 'wp-job-portal'); ?>
            </span>
        </a>
        <ul class="wpjobportaladmin-sidebar-submenu treeview-menu">
            <li class="<?php if($c == 'wpjobportal_jobtype' && ($layout == '')) echo 'active'; ?>">
                <a href="admin.php?page=wpjobportal_jobtype" title="<?php echo __('job types','wp-job-portal'); ?>">
                    <?php echo __('Job Types','wp-job-portal'); ?>
                </a>
            </li>
            <li class="<?php if($c == 'wpjobportal_jobtype' && ($layout == 'formjobtype')) echo 'active'; ?>">
                <a href="admin.php?page=wpjobportal_jobtype&wpjobportallt=formjobtype" title="<?php echo __('add new job type','wp-job-portal'); ?>">
                    <?php echo __('Add New Job Type','wp-job-portal'); ?>
                </a>
            </li>
        </ul>
    </li>
    <li class="treeview <?php if($c == 'wpjobportal_jobstatus') echo 'active'; ?>">
        <a href="admin.php?page=wpjobportal_jobstatus" title="<?php echo __('job status' , 'wp-job-portal'); ?>">
            <img class="wpjobportaladmin-menu-icon" alt="<?php echo __('job status' , 'wp-job-portal'); ?>" src="<?php echo WPJOBPORTAL_PLUGIN_URL.'includes/images/control_panel/dashboard/admin-left-menu/status.png'; ?>" />
            <span class="wpjobportaladmin-text">
                <?php echo __('Job Status' , 'wp-job-portal'); ?>
            </span>
        </a>
        <ul class="wpjobportaladmin-sidebar-submenu treeview-menu">
            <li class="<?php if($c == 'wpjobportal_jobstatus' && ($layout == '')) echo 'active'; ?>">
                <a href="admin.php?page=wpjobportal_jobstatus" title="<?php echo __('job status','wp-job-portal'); ?>">
                    <?php echo __('Job Status','wp-job-portal'); ?>
                </a>
            </li>
            <li class="<?php if($c == 'wpjobportal_jobstatus' && ($layout == 'formjobstatus')) echo 'active'; ?>">
                <a href="admin.php?page=wpjobportal_jobstatus&wpjobportallt=formjobstatus" title="<?php echo __('add new job status','wp-job-portal'); ?>">
                    <?php echo __('Add New Job Status','wp-job-portal'); ?>
                </a>
            </li>
        </ul>
    </li>
    <?php /*<li class="treeview <?php if($c == 'wpjobportal_shift') echo 'active'; ?>">
        <a href="admin.php?page=wpjobportal_shift" title="<?php echo __('shifts' , 'wp-job-portal'); ?>">
            <img class="wpjobportaladmin-menu-icon" alt="<?php echo __('shifts' , 'wp-job-portal'); ?>" src="<?php echo WPJOBPORTAL_PLUGIN_URL.'includes/images/control_panel/dashboard/admin-left-menu/job-shifts.png'; ?>" />
            <span class="wpjobportaladmin-text">
                <?php echo __('Shifts' , 'wp-job-portal'); ?>
            </span>
        </a>
        <ul class="wpjobportaladmin-sidebar-submenu treeview-menu">
            <li class="<?php if($c == 'wpjobportal_shift' && ($layout == '')) echo 'active'; ?>">
                <a href="admin.php?page=wpjobportal_shift" title="<?php echo __('shifts','wp-job-portal'); ?>">
                    <?php echo __('Shifts','wp-job-portal'); ?>
                </a>
            </li>
            <li class="<?php if($c == 'wpjobportal_shift' && ($layout == 'formshift')) echo 'active'; ?>">
                <a href="admin.php?page=wpjobportal_shift&wpjobportallt=formshift" title="<?php echo __('add new shift','wp-job-portal'); ?>">
                    <?php echo __('Add New Shift','wp-job-portal'); ?>
                </a>
            </li>
        </ul>
    </li> */ ?>
    <li class="treeview <?php if($c == 'wpjobportal_highesteducation') echo 'active'; ?>">
        <a href="admin.php?page=wpjobportal_highesteducation" title="<?php echo __('highest educations' , 'wp-job-portal'); ?>">
            <img class="wpjobportaladmin-menu-icon" alt="<?php echo __('highest educations' , 'wp-job-portal'); ?>" src="<?php echo WPJOBPORTAL_PLUGIN_URL.'includes/images/control_panel/dashboard/admin-left-menu/highest-education.png'; ?>" />
            <span class="wpjobportaladmin-text">
                <?php echo __('Highest Educations' , 'wp-job-portal'); ?>
            </span>
        </a>
        <ul class="wpjobportaladmin-sidebar-submenu treeview-menu">
            <li class="<?php if($c == 'wpjobportal_highesteducation' && ($layout == '')) echo 'active'; ?>">
                <a href="admin.php?page=wpjobportal_highesteducation" title="<?php echo __('highest educations','wp-job-portal'); ?>">
                    <?php echo __('Highest Educations','wp-job-portal'); ?>
                </a>
            </li>
            <li class="<?php if($c == 'wpjobportal_highesteducation' && ($layout == 'formhighesteducation')) echo 'active'; ?>">
                <a href="admin.php?page=wpjobportal_highesteducation&wpjobportallt=formhighesteducation" title="<?php echo __('add new highest education','wp-job-portal'); ?>">
                    <?php echo __('Add New Highest Education','wp-job-portal'); ?>
                </a>
            </li>
        </ul>
    </li>
    <?php /*<li class="treeview <?php if($c == 'wpjobportal_age') echo 'active'; ?>">
        <a href="admin.php?page=wpjobportal_age" title="<?php echo __('ages' , 'wp-job-portal'); ?>">
            <img class="wpjobportaladmin-menu-icon" alt="<?php echo __('ages' , 'wp-job-portal'); ?>" src="<?php echo WPJOBPORTAL_PLUGIN_URL.'includes/images/control_panel/dashboard/admin-left-menu/ages.png'; ?>" />
            <span class="wpjobportaladmin-text">
                <?php echo __('Ages' , 'wp-job-portal'); ?>
            </span>
        </a>
        <ul class="wpjobportaladmin-sidebar-submenu treeview-menu">
            <li class="<?php if($c == 'wpjobportal_age' && ($layout == '')) echo 'active'; ?>">
                <a href="admin.php?page=wpjobportal_age" title="<?php echo __('ages','wp-job-portal'); ?>">
                    <?php echo __('Ages','wp-job-portal'); ?>
                </a>
            </li>
            <li class="<?php if($c == 'wpjobportal_age' && ($layout == 'formages')) echo 'active'; ?>">
                <a href="admin.php?page=wpjobportal_age&wpjobportallt=formages" title="<?php echo __('add new age','wp-job-portal'); ?>">
                    <?php echo __('Add New Age','wp-job-portal'); ?>
                </a>
            </li>
        </ul>
    </li> */ ?>
    <li class="treeview <?php if($c == 'wpjobportal_careerlevel') echo 'active'; ?>">
        <a href="admin.php?page=wpjobportal_careerlevel" title="<?php echo __('career levels' , 'wp-job-portal'); ?>">
            <img class="wpjobportaladmin-menu-icon" alt="<?php echo __('career levels' , 'wp-job-portal'); ?>" src="<?php echo WPJOBPORTAL_PLUGIN_URL.'includes/images/control_panel/dashboard/admin-left-menu/career-levels.png'; ?>" />
            <span class="wpjobportaladmin-text">
                <?php echo __('Career Levels' , 'wp-job-portal'); ?>
            </span>
        </a>
        <ul class="wpjobportaladmin-sidebar-submenu treeview-menu">
            <li class="<?php if($c == 'wpjobportal_careerlevel' && ($layout == 'wpjobportal_careerlevel' || $layout == '')) echo 'active'; ?>">
                <a href="admin.php?page=wpjobportal_careerlevel" title="<?php echo __('career levels','wp-job-portal'); ?>">
                    <?php echo __('Career Levels','wp-job-portal'); ?>
                </a>
            </li>
            <li class="<?php if($c == 'wpjobportal_careerlevel' && ($layout == 'formcareerlevels')) echo 'active'; ?>">
                <a href="admin.php?page=wpjobportal_careerlevel&wpjobportallt=formcareerlevels" title="<?php echo __('add new career level','wp-job-portal'); ?>">
                    <?php echo __('Add New Career Level','wp-job-portal'); ?>
                </a>
            </li>
        </ul>
    </li>
    <li class="treeview <?php if($c == 'wpjobportal_currency') echo 'active'; ?>">
        <a href="admin.php?page=wpjobportal_currency" title="<?php echo __('currency' , 'wp-job-portal'); ?>">
            <img class="wpjobportaladmin-menu-icon" alt="<?php echo __('currency' , 'wp-job-portal'); ?>" src="<?php echo WPJOBPORTAL_PLUGIN_URL.'includes/images/control_panel/dashboard/admin-left-menu/currency.png'; ?>" />
            <span class="wpjobportaladmin-text">
                <?php echo __('Currency' , 'wp-job-portal'); ?>
            </span>
        </a>
        <ul class="wpjobportaladmin-sidebar-submenu treeview-menu">
            <li class="<?php if($c == 'wpjobportal_currency' && ($layout == 'wpjobportal_currency' || $layout == '')) echo 'active'; ?>">
                <a href="admin.php?page=wpjobportal_currency" title="<?php echo __('currency','wp-job-portal'); ?>">
                    <?php echo __('Currency','wp-job-portal'); ?>
                </a>
            </li>
            <li class="<?php if($c == 'wpjobportal_currency' && ($layout == 'formcurrency')) echo 'active'; ?>">
                <a href="admin.php?page=wpjobportal_currency&wpjobportallt=formcurrency" title="<?php echo __('add new currency','wp-job-portal'); ?>">
                    <?php echo __('Add New Currency','wp-job-portal'); ?>
                </a>
            </li>
        </ul>
    </li>
    <li class="treeview <?php if($c == 'wpjobportal_category') echo 'active'; ?>">
        <a href="admin.php?page=wpjobportal_category" title="<?php echo __('resume' , 'wp-job-portal'); ?>">
            <img class="wpjobportaladmin-menu-icon" alt="<?php echo __('categories' , 'wp-job-portal'); ?>" src="<?php echo WPJOBPORTAL_PLUGIN_URL.'includes/images/control_panel/dashboard/admin-left-menu/category.png'; ?>" />
            <span class="wpjobportaladmin-text">
                <?php echo __('Categories' , 'wp-job-portal'); ?>
            </span>
        </a>
        <ul class="wpjobportaladmin-sidebar-submenu treeview-menu">
            <li class="<?php if($c == 'wpjobportal_category' && ($layout == '')) echo 'active'; ?>">
                <a href="admin.php?page=wpjobportal_category" title="<?php echo __('categories', 'wp-job-portal'); ?>">
                    <?php echo __('Categories', 'wp-job-portal'); ?>
                </a>
            </li>
            <li class="<?php if($c == 'wpjobportal_category' && ($layout == 'formcategory')) echo 'active'; ?>">
                <a href="admin.php?page=wpjobportal_category&wpjobportallt=formcategory" title="<?php echo __('add new category', 'wp-job-portal'); ?>">
                    <?php echo __('Add New Category', 'wp-job-portal'); ?>
                </a>
            </li>
        </ul>
    </li>
    <?php
        if(in_array('tag', wpjobportal::$_active_addons)){
            do_action('wpjobportal_addons_admin_sidemenu_links_for_tags',$c,$layout);
        }else{
            $plugininfo = checkWPJPPluginInfo('wp-job-portal-tag/wp-job-portal-tag.php');
            if($plugininfo['availability'] == "1"){
                $text = $plugininfo['text'];
                $url = "plugins.php?s=wp-job-portal-tag&plugin_status=inactive";
            }elseif($plugininfo['availability'] == "0"){
                $text = $plugininfo['text'];
                $url = "https://wpjobportal.com/product/tags/";
            } ?>
            <li class="treeview">
                <a href="javascript: void(0);" title="<?php echo __('Tags' , 'wp-job-portal'); ?>">
                    <img src="<?php echo WPJOBPORTAL_PLUGIN_URL.'includes/images/control_panel/dashboard/admin-left-menu/grey-menu/tags.png'; ?>" alt="<?php echo __('tags' , 'wp-job-portal'); ?>" class="wpjobportaladmin-menu-icon">
                    <span class="wpjobportaladmin-text disabled-menu"><?php echo __('Tags' , 'wp-job-portal'); ?></span>
                </a>
                <ul class="wpjobportaladmin-sidebar-submenu treeview-menu">
                    <li class="disabled-menu">
                        <span class="wpjobportaladmin-text"><?php echo __('Tags' , 'wp-job-portal'); ?></span>
                        <a href="<?php echo esc_url($url); ?>" class="wpjobportaladmin-install-btn" title="<?php echo esc_attr($text); ?>"><?php echo esc_html($text); ?></a>
                    </li>
                </ul>
            </li>
    <?php } ?>
    <li class="treeview <?php if($c == 'wpjobportal_salaryrange' || $c == 'wpjobportal_salaryrangetype' ) echo 'active'; ?>">
        <a href="admin.php?page=wpjobportal_salaryrangetype" title="<?php echo __('salary range' , 'wp-job-portal'); ?>">
            <img class="wpjobportaladmin-menu-icon" alt="<?php echo __('salary range' , 'wp-job-portal'); ?>" src="<?php echo WPJOBPORTAL_PLUGIN_URL.'includes/images/control_panel/dashboard/admin-left-menu/salary-range.png'; ?>" />
            <span class="wpjobportaladmin-text">
                <?php echo __('Salary Range' , 'wp-job-portal'); ?>
            </span>
        </a>
        <ul class="wpjobportaladmin-sidebar-submenu treeview-menu">
            <li class="<?php if($c == 'wpjobportal_salaryrangetype' && ($layout == '')) echo 'active'; ?>">
                <a href="admin.php?page=wpjobportal_salaryrangetype" title="<?php echo __('salary range type', 'wp-job-portal'); ?>">
                    <?php echo __('Salary Range Type', 'wp-job-portal'); ?>
                </a>
            </li>
            <li class="<?php if($c == 'wpjobportal_salaryrangetype' && ($layout == 'formsalaryrangetype')) echo 'active'; ?>">
                <a href="admin.php?page=wpjobportal_salaryrangetype&wpjobportallt=formsalaryrangetype" title="<?php echo __('add new salary range type', 'wp-job-portal'); ?>">
                    <?php echo __('Add New Salary Range Type', 'wp-job-portal'); ?>
                </a>
            </li>
        </ul>
    </li>
    <li class="treeview <?php if($c == 'wpjobportal_user' || $c == 'wpjobportal_customfield' || ($c == 'wpjobportal_fieldordering' && ($layout == '') && $ff == 4)) echo 'active'; ?>">
        <a href="admin.php?page=wpjobportal_user" title="<?php echo __('users' , 'wp-job-portal'); ?>">
            <img class="wpjobportaladmin-menu-icon" alt="<?php echo __('users' , 'wp-job-portal'); ?>" src="<?php echo WPJOBPORTAL_PLUGIN_URL.'includes/images/control_panel/dashboard/admin-left-menu/users.png'; ?>" />
            <span class="wpjobportaladmin-text">
                <?php echo __('Users' , 'wp-job-portal'); ?>
            </span>
        </a>
        <ul class="wpjobportaladmin-sidebar-submenu treeview-menu">
            <li class="<?php if($c == 'wpjobportal_user' && ($layout == '')) echo 'active'; ?>">
                <a href="admin.php?page=wpjobportal_user" title="<?php echo __('users', 'wp-job-portal'); ?>">
                    <?php echo __('Users', 'wp-job-portal'); ?>
                </a>
            </li>
            <li class="<?php if($c == 'wpjobportal_user' && ($layout == 'assignrole')) echo 'active'; ?>">
                <a href="admin.php?page=wpjobportal_user&wpjobportallt=assignrole" title="<?php echo __('assign role', 'wp-job-portal'); ?>">
                    <?php echo __('Assign Role', 'wp-job-portal'); ?>
                </a>
            </li>
            <li class="<?php if($c == 'wpjobportal_fieldordering' || $c == 'wpjobportal_customfield'  && ($layout == '' || $layout == 'formuserfield')) echo 'active'; ?>">
                <a href="admin.php?page=wpjobportal_fieldordering&ff=4" title="<?php echo __('fields', 'wp-job-portal'); ?>">
                    <?php echo __('Fields', 'wp-job-portal'); ?>
                </a>
            </li>
        </ul>
    </li>
    <li class="treeview <?php if($c == 'wpjobportal' && $layout == 'shortcodes' ) echo 'active'; ?>">
        <a href="admin.php?page=wpjobportal&wpjobportallt=shortcodes" title="<?php echo __('short codes' , 'wp-job-portal'); ?>">
            <img class="wpjobportaladmin-menu-icon" alt="<?php echo __('short codes' , 'wp-job-portal'); ?>" src="<?php echo WPJOBPORTAL_PLUGIN_URL.'includes/images/control_panel/dashboard/admin-left-menu/short-codes.png'; ?>" />
            <span class="wpjobportaladmin-text">
                <?php echo __('Short Codes' , 'wp-job-portal'); ?>
            </span>
        </a>
        <ul class="wpjobportaladmin-sidebar-submenu treeview-menu">
            <li class="<?php if($c == 'wpjobportal' && ($layout == 'shortcodes')) echo 'active'; ?>">
                <a href="admin.php?page=wpjobportal&wpjobportallt=shortcodes" title="<?php echo __('short codes', 'wp-job-portal'); ?>">
                    <?php echo __('Short Codes', 'wp-job-portal'); ?>
                </a>
            </li>
        </ul>
    </li>
    <li class="treeview <?php if($c == 'wpjobportal_report' || ($c == 'wpjobportal_reports')) echo 'active'; ?>">
        <a href="admin.php?page=wpjobportal_report&wpjobportallt=overallreports" title="<?php echo __('reports' , 'wp-job-portal'); ?>">
            <img class="wpjobportaladmin-menu-icon" alt="<?php echo __('reports' , 'wp-job-portal'); ?>" src="<?php echo WPJOBPORTAL_PLUGIN_URL.'includes/images/control_panel/dashboard/admin-left-menu/reports.png'; ?>" />
            <span class="wpjobportaladmin-text">
                <?php echo __('Reports' , 'wp-job-portal'); ?>
            </span>
        </a>
        <ul class="wpjobportaladmin-sidebar-submenu treeview-menu">
            <li class="<?php if($c == 'wpjobportal_report' && ($layout == 'overallreports')) echo 'active'; ?>">
                <a href="admin.php?page=wpjobportal_report&wpjobportallt=overallreports" title="<?php echo __('overall reports', 'wp-job-portal'); ?>">
                    <?php echo __('Overall Reports', 'wp-job-portal'); ?>
                </a>
            </li>
            <?php
                if(in_array('reports', wpjobportal::$_active_addons)){
                    do_action('wpjobportal_addons_admin_sidemenu_links_for_reports',$c,$layout);
                }else{
                    $plugininfo = checkWPJPPluginInfo('wp-job-portal-reports/wp-job-portal-reports.php');
                    if($plugininfo['availability'] == "1"){
                        $text = $plugininfo['text'];
                        $url = "plugins.php?s=wp-job-portal-reports&plugin_status=inactive";
                    }elseif($plugininfo['availability'] == "0"){
                        $text = $plugininfo['text'];
                        $url = "https://wpjobportal.com/product/reports/";
                    } ?>
                    <li class="disabled-menu fw">
                        <span class="wpjobportaladmin-text"><?php echo __('Employer / Job Seeker Report' , 'wp-job-portal'); ?></span>
                        <a href="<?php echo esc_url($url); ?>" class="wpjobportaladmin-install-btn" title="<?php echo esc_attr($text); ?>"><?php echo esc_html($text); ?></a>
                    </li>
               <?php } ?>
        </ul>
    </li>
    <li class="treeview <?php if($c == 'wpjobportal_emailtemplate' || $c == 'wpjobportal_emailtemplatestatus') echo 'active'; ?>">
        <a href="admin.php?page=wpjobportal_emailtemplate" title="<?php echo __('email templates' , 'wp-job-portal'); ?>">
            <img class="wpjobportaladmin-menu-icon" alt="<?php echo __('email templates' , 'wp-job-portal'); ?>" src="<?php echo WPJOBPORTAL_PLUGIN_URL.'includes/images/control_panel/dashboard/admin-left-menu/email-templates.png'; ?>" />
            <span class="wpjobportaladmin-text">
                <?php echo __('Email Templates' , 'wp-job-portal'); ?>
            </span>
        </a>
        <ul class="wpjobportaladmin-sidebar-submenu treeview-menu">
            <li class="<?php if($c == 'wpjobportal_emailtemplatestatus' && ($layout == '')) echo 'active'; ?>">
                <a href="admin.php?page=wpjobportal_emailtemplatestatus" title="<?php echo __('options', 'wp-job-portal'); ?>">
                    <?php echo __('Options', 'wp-job-portal'); ?>
                </a>
            </li>
            <li class="<?php if($c == 'wpjobportal_emailtemplate' && $for == 'ew-cm') echo 'active'; ?>">
                <a href="admin.php?page=wpjobportal_emailtemplate&for=ew-cm" title="<?php echo __('new company', 'wp-job-portal'); ?>">
                    <?php echo __('New Company', 'wp-job-portal'); ?>
                </a>
            </li>
            <li class="<?php if($c == 'wpjobportal_emailtemplate' && $for == 'd-cm') echo 'active'; ?>">
                <a href="admin.php?page=wpjobportal_emailtemplate&for=d-cm" title="<?php echo __('delete company', 'wp-job-portal'); ?>">
                    <?php echo __('Delete Company', 'wp-job-portal'); ?>
                </a>
            </li>
            <li class="<?php if($c == 'wpjobportal_emailtemplate' && $for == 'cm-sts') echo 'active'; ?>">
                <a href="admin.php?page=wpjobportal_emailtemplate&for=cm-sts" title="<?php echo __('company status', 'wp-job-portal'); ?>">
                    <?php echo __('Company Status', 'wp-job-portal'); ?>
                </a>
            </li>
            <li class="<?php if($c == 'wpjobportal_emailtemplate' && $for == 'ew-ob') echo 'active'; ?>">
                <a href="admin.php?page=wpjobportal_emailtemplate&for=ew-ob" title="<?php echo __('new job', 'wp-job-portal'); ?>">
                    <?php echo __('New Job', 'wp-job-portal'); ?>
                </a>
            </li>
            <?php if(in_array('visitorcanaddjob', wpjobportal::$_active_addons)){ ?>
                <li class="<?php if($c == 'wpjobportal_emailtemplate' && $for == 'ew-obv') echo 'active'; ?>">
                    <a href="admin.php?page=wpjobportal_emailtemplate&for=ew-obv" title="<?php echo __('new visitor job', 'wp-job-portal'); ?>">
                        <?php echo __('New Visitor Job', 'wp-job-portal'); ?>
                    </a>
                </li>
            <?php } ?>
            <li class="<?php if($c == 'wpjobportal_emailtemplate' && $for == 'ob-sts') echo 'active'; ?>">
                <a href="admin.php?page=wpjobportal_emailtemplate&for=ob-sts" title="<?php echo __('job status', 'wp-job-portal'); ?>">
                    <?php echo __('Job Status', 'wp-job-portal'); ?>
                </a>
            </li>
            <li class="<?php if($c == 'wpjobportal_emailtemplate' && $for == 'ob-d') echo 'active'; ?>">
                <a href="admin.php?page=wpjobportal_emailtemplate&for=ob-d" title="<?php echo __('job delete', 'wp-job-portal'); ?>">
                    <?php echo __('Job Delete', 'wp-job-portal'); ?>
                </a>
            </li>
            <li class="<?php if($c == 'wpjobportal_emailtemplate' && $for == 'ew-rm') echo 'active'; ?>">
                <a href="admin.php?page=wpjobportal_emailtemplate&for=ew-rm" title="<?php echo __('new resume', 'wp-job-portal'); ?>">
                    <?php echo __('New Resume', 'wp-job-portal'); ?>
                </a>
            </li>
            <li class="<?php if($c == 'wpjobportal_emailtemplate' && $for == 'ew-rmv') echo 'active'; ?>">
                <a href="admin.php?page=wpjobportal_emailtemplate&for=ew-rmv" title="<?php echo __('new visitor resume', 'wp-job-portal'); ?>">
                    <?php echo __('New Visitor Resume', 'wp-job-portal'); ?>
                </a>
            </li>
            <li class="<?php if($c == 'wpjobportal_emailtemplate' && $for == 'rm-sts') echo 'active'; ?>">
                <a href="admin.php?page=wpjobportal_emailtemplate&for=rm-sts" title="<?php echo __('resume status', 'wp-job-portal'); ?>">
                    <?php echo __('Resume Status', 'wp-job-portal'); ?>
                </a>
            </li>
            <li class="<?php if($c == 'wpjobportal_emailtemplate' && $for == 'd-rs') echo 'active'; ?>">
                <a href="admin.php?page=wpjobportal_emailtemplate&for=d-rs" title="<?php echo __('delete resume', 'wp-job-portal'); ?>">
                    <?php echo __('Delete Resume', 'wp-job-portal'); ?>
                </a>
            </li>
            <li class="<?php if($c == 'wpjobportal_emailtemplate' && $for == 'em-n') echo 'active'; ?>">
                <a href="admin.php?page=wpjobportal_emailtemplate&for=em-n" title="<?php echo __('new employer', 'wp-job-portal'); ?>">
                    <?php echo __('New Employer', 'wp-job-portal'); ?>
                </a>
            </li>
            <li class="<?php if($c == 'wpjobportal_emailtemplate' && $for == 'obs-n') echo 'active'; ?>">
                <a href="admin.php?page=wpjobportal_emailtemplate&for=obs-n" title="<?php echo __('new job seeker', 'wp-job-portal'); ?>">
                    <?php echo __('New Job Seeker', 'wp-job-portal'); ?>
                </a>
            </li>
            <li class="<?php if($c == 'wpjobportal_emailtemplate' && $for == 'ad-jap') echo 'active'; ?>">
                <a href="admin.php?page=wpjobportal_emailtemplate&for=ad-jap" title="<?php echo __('job apply admin', 'wp-job-portal'); ?>">
                    <?php echo __('Job Apply Admin', 'wp-job-portal'); ?>
                </a>
            </li>
            <li class="<?php if($c == 'wpjobportal_emailtemplate' && $for == 'em-jap') echo 'active'; ?>">
                <a href="admin.php?page=wpjobportal_emailtemplate&for=em-jap" title="<?php echo __('job apply employer', 'wp-job-portal'); ?>">
                    <?php echo __('Job Apply Employer', 'wp-job-portal'); ?>
                </a>
            </li>
            <li class="<?php if($c == 'wpjobportal_emailtemplate' && $for == 'js-jap') echo 'active'; ?>">
                <a href="admin.php?page=wpjobportal_emailtemplate&for=js-jap" title="<?php echo __('job apply job seeker', 'wp-job-portal'); ?>">
                    <?php echo __('Job Apply Job Seeker', 'wp-job-portal'); ?>
                </a>
            </li>
             <?php if(in_array('resumeaction', wpjobportal::$_active_addons)){ ?>
                <li class="<?php if($c == 'wpjobportal_emailtemplate' && $for == 'ap-jap') echo 'active'; ?>">
                    <a href="admin.php?page=wpjobportal_emailtemplate&for=ap-jap" title="<?php echo __('applied resume status change', 'wp-job-portal'); ?>">
                        <?php echo __('Applied Resume Status Change', 'wp-job-portal'); ?>
                    </a>
                </li>
            <?php } ?>
                 <?php if(in_array('jobalert', wpjobportal::$_active_addons)){ ?>
                        <li class="<?php if($c == 'wpjobportal_emailtemplate' && $for == 'jb-at') echo 'active'; ?>">
                            <a href="admin.php?page=wpjobportal_emailtemplate&for=jb-at" title="<?php echo __('job alert', 'wp-job-portal'); ?>">
                                <?php echo __('Job Alert', 'wp-job-portal'); ?>
                            </a>
                        </li>
                <?php } ?>
                <?php if(in_array('tellfriend', wpjobportal::$_active_addons)){ ?>
                <li class="<?php if($c == 'wpjobportal_emailtemplate' && $for == 'jb-to-fri') echo 'active'; ?>">
                    <a href="admin.php?page=wpjobportal_emailtemplate&for=jb-to-fri" title="<?php echo __('tell to friend', 'wp-job-portal'); ?>">
                        <?php echo __('Tell To Friend', 'wp-job-portal'); ?>
                    </a>
                </li>
                <?php } ?>

                <?php if(in_array('credits', wpjobportal::$_active_addons)){ ?>
                        <li class="<?php if($c == 'wpjobportal_emailtemplate' && $for == 'ew-pk-ad') echo 'active'; ?>">
                            <a href="admin.php?page=wpjobportal_emailtemplate&for=ew-pk-ad" title="<?php echo __('Purchase Package Admin', 'wp-job-portal'); ?>">
                                <?php echo __('Tell To Friend', 'wp-job-portal'); ?>
                            </a>
                        </li>
                        <li class="<?php if($c == 'wpjobportal_emailtemplate' && $for == 'ew-pk') echo 'active'; ?>">
                            <a href="admin.php?page=wpjobportal_emailtemplate&for=ew-pk" title="<?php echo __('Purchase Package Admin', 'wp-job-portal'); ?>">
                                <?php echo __('Purchase Package', 'wp-job-portal'); ?>
                            </a>
                        </li>
                        <li class="<?php if($c == 'wpjobportal_emailtemplate' && $for == 'st-pk') echo 'active'; ?>">
                            <a href="admin.php?page=wpjobportal_emailtemplate&for=st-pk" title="<?php echo __('Purchase Package Admin', 'wp-job-portal'); ?>">
                                <?php echo __('Purchase Status', 'wp-job-portal'); ?>
                            </a>
                        </li>
                <?php } ?>
        </ul>
    </li>
    <li class="treeview <?php if($c == 'wpjobportal_country' || $c == 'wpjobportal_addressdata' || $c == 'wpjobportal_state' || $c == 'wpjobportal_city') echo 'active'; ?>">
        <a href="admin.php?page=wpjobportal_country" title="<?php echo __('countries' , 'wp-job-portal'); ?>">
            <img class="wpjobportaladmin-menu-icon" alt="<?php echo __('countries' , 'wp-job-portal'); ?>" src="<?php echo WPJOBPORTAL_PLUGIN_URL.'includes/images/control_panel/dashboard/admin-left-menu/address-data.png'; ?>" />
            <span class="wpjobportaladmin-text">
                <?php echo __('Countries' , 'wp-job-portal'); ?>
            </span>
        </a>
        <ul class="wpjobportaladmin-sidebar-submenu treeview-menu">
            <li class="<?php if(($c == 'wpjobportal_country' && $layout != 'formcountry') || $c == 'wpjobportal_state' || $c == 'wpjobportal_city' && ($layout == 'formcity' || $layout == '' )) echo 'active'; ?>">
                <a href="admin.php?page=wpjobportal_country" title="<?php echo __('countries', 'wp-job-portal'); ?>">
                    <?php echo __('Countries', 'wp-job-portal'); ?>
                </a>
            </li>
            <li class="<?php if($c == 'wpjobportal_country' && ($layout == 'formcountry')) echo 'active'; ?>">
                <a href="admin.php?page=wpjobportal_country&wpjobportallt=formcountry" title="<?php echo __('add new country', 'wp-job-portal'); ?>">
                    <?php echo __('Add New Country', 'wp-job-portal'); ?>
                </a>
            </li>
            <?php
                if(in_array('addressdata', wpjobportal::$_active_addons)){
                    do_action('wpjobportal_addons_admin_sidemenu_addressdata',$c,$layout);
                }else{
                    $plugininfo = checkWPJPPluginInfo('wp-job-portal-addressdata/wp-job-portal-addressdata.php');
                    if($plugininfo['availability'] == "1"){
                        $text = $plugininfo['text'];
                        $url = "plugins.php?s=wp-job-portal-addressdata&plugin_status=inactive";
                    }elseif($plugininfo['availability'] == "0"){
                        $text = $plugininfo['text'];
                        $url = "https://wpjobportal.com/product/address-data/";
                    } ?>
                    <li class="disabled-menu fw">
                        <span class="wpjobportaladmin-text"><?php echo __('Load Address Data' , 'wp-job-portal'); ?></span>
                        <a href="<?php echo esc_url($url); ?>" class="wpjobportaladmin-install-btn" title="<?php echo esc_attr($text); ?>"><?php echo esc_html($text); ?></a>
                    </li>
             <?php } ?>
        </ul>
    </li>
    <li class="treeview <?php if($c == 'wpjobportal' && $layout == 'help' ) echo 'active'; ?>">
        <a href="admin.php?page=wpjobportal&wpjobportallt=help" title="<?php echo __('help' , 'wp-job-portal'); ?>">
            <img class="wpjobportaladmin-menu-icon" alt="<?php echo __('help' , 'wp-job-portal'); ?>" src="<?php echo WPJOBPORTAL_PLUGIN_URL.'includes/images/control_panel/dashboard/admin-left-menu/help.png'; ?>" />
            <span class="wpjobportaladmin-text">
                <?php echo __('Help' , 'wp-job-portal'); ?>
            </span>
        </a>
        <ul class="wpjobportaladmin-sidebar-submenu treeview-menu">
            <li class="<?php if($c == 'wpjobportal' && ($layout == 'help')) echo 'active'; ?>">
                <a href="admin.php?page=wpjobportal&wpjobportallt=help" title="<?php echo __('help', 'wp-job-portal'); ?>">
                    <?php echo __('Help', 'wp-job-portal'); ?>
                </a>
            </li>
        </ul>
    </li>
</ul>
<script >
    var cookielist = document.cookie.split(';');
    for (var i=0; i<cookielist.length; i++) {
        if (cookielist[i].trim() == "wpjobportaladmin_collapse_admin_menu=1") {
            jQuery("#wpjobportaladmin-wrapper").addClass("menu-collasped-active");
            break;
        }
    }

    jQuery(document).ready(function(){

        var pageWrapper = jQuery("#wpjobportaladmin-wrapper");
        var sideMenuArea = jQuery("#wpjobportaladmin-leftmenu");

        jQuery("#wpjobportaladmin-menu-toggle").on("click", function () {

            if (pageWrapper.hasClass("menu-collasped-active")) {
                pageWrapper.removeClass("menu-collasped-active");
                document.cookie = 'wpjobportaladmin_collapse_admin_menu=0; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/';
            }else{
                pageWrapper.addClass("menu-collasped-active");
                document.cookie = 'wpjobportaladmin_collapse_admin_menu=1; expires=Sat, 01 Jan 2050 00:00:00 UTC; path=/';
            }

        });

        // to set anchor link active on menu collpapsed
        jQuery('.wpjobportaladmin-sidebar-menu li.treeview a').on('click', function() {
            if (!(pageWrapper.hasClass("menu-collasped-active"))) {
                window.location.href = jQuery(this).attr("href");
            }
        });
    });

</script>
