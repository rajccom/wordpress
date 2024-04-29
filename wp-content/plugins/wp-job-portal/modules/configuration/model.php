<?php

if (!defined('ABSPATH'))
    die('Restricted Access');

class WPJOBPORTALconfigurationModel {

    var $_data_directory = null;
    var $_comp_editor = null;
    var $_job_editor = null;
    var $_defaultcountry = null;
    var $_config = null;

    function __construct() {

    }

    function getConfiguration() {
        include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
        // check for plugin using plugin name
        if (is_plugin_active('wp-job-portal/wp-job-portal.php')) {
            $query = "SELECT config.* FROM `" . wpjobportal::$_db->prefix . "wj_portal_config` AS config WHERE configfor = 'default'";
            $config = wpjobportaldb::get_results($query);
            foreach ($config as $conf) {
                wpjobportal::$_configuration[$conf->configname] = $conf->configvalue;
            }
            wpjobportal::$_configuration['config_count'] = COUNT($config);
        }
    }

    function getConfigurationsForForm() {
        $query = "SELECT config.* FROM `" . wpjobportal::$_db->prefix . "wj_portal_config` AS config";
        $config = wpjobportaldb::get_results($query);
        foreach ($config as $conf) {
            wpjobportal::$_data[0][$conf->configname] = $conf->configvalue;
        }
        wpjobportal::$_data[0]['config_count'] = COUNT($config);
    }



    function storeConfig($data) {
        if (empty($data))
            return false;

        if ($data['isgeneralbuttonsubmit'] == 1) {
            if (!isset($data['employer_share_fb_like']))
                $data['employer_share_fb_like'] = 0;
            if (!isset($data['employer_share_fb_share']))
                $data['employer_share_fb_share'] = 0;
            if (!isset($data['employer_share_fb_comments']))
                $data['employer_share_fb_comments'] = 0;
            if (!isset($data['employer_share_google_like']))
                $data['employer_share_google_like'] = 0;
            if (!isset($data['employer_share_google_share']))
                $data['employer_share_google_share'] = 0;
            if (!isset($data['employer_share_blog_share']))
                $data['employer_share_blog_share'] = 0;
            if (!isset($data['employer_share_friendfeed_share']))
                $data['employer_share_friendfeed_share'] = 0;
            if (!isset($data['employer_share_linkedin_share']))
                $data['employer_share_linkedin_share'] = 0;
            if (!isset($data['employer_share_digg_share']))
                $data['employer_share_digg_share'] = 0;
            if (!isset($data['employer_share_twitter_share']))
                $data['employer_share_twitter_share'] = 0;
            if (!isset($data['employer_share_myspace_share']))
                $data['employer_share_myspace_share'] = 0;
            if (!isset($data['employer_share_yahoo_share']))
                $data['employer_share_yahoo_share'] = 0;

        }
        if(isset($_POST['offline_text'])){
			$data['offline_text'] = wpautop(wptexturize(wpjobportalphplib::wpJP_stripslashes($_POST['offline_text'])));
		}
        $error = false;
        //DB class limitations
        foreach ($data as $key => $value) {
			if ($key == 'data_directory') {
				$data_directory = $value;
				if(empty($data_directory)){
					WPJOBPORTALMessages::setLayoutMessage(__('Data directory can not empty.', 'wp-job-portal'), 'error',$this->getMessagekey());
					continue;
				}
				if(wpjobportalphplib::wpJP_strpos($data_directory, '/') !== false){
					WPJOBPORTALMessages::setLayoutMessage(__('Data directory is not proper.', 'wp-job-portal'), 'error',$this->getMessagekey());
					continue;
				}
				$path = WPJOBPORTAL_PLUGIN_PATH.'/'.$data_directory;
				if ( ! file_exists($path)) {
				   mkdir($path, 0755);
				}
				if( ! is_writeable($path)){
					WPJOBPORTALMessages::setLayoutMessage(__('Data directory is not writable.', 'wp-job-portal'), 'error',$this->getMessagekey());
					continue;
				}
			}
            $query = "UPDATE `" . wpjobportal::$_db->prefix . "wj_portal_config` SET `configvalue` = '$value' WHERE `configname`= '" . $key . "'";
            if (false === wpjobportaldb::query($query)) {
                $error = true;
            }
        }
        if ($error)
            return WPJOBPORTAL_SAVE_ERROR;
        else
            return WPJOBPORTAL_SAVED;
    }

    function getConfigByFor($configfor) {
        if (!$configfor)
            return;
        $query = "SELECT * FROM `" . wpjobportal::$_db->prefix . "wj_portal_config` WHERE configfor = '" . $configfor . "'";
        $config = wpjobportaldb::get_results($query);
        $configs = array();
        foreach ($config as $conf) {
            $configs[$conf->configname] = $conf->configvalue;
        }
        return $configs;
    }

    function getCountConfig() {

        $query = "SELECT COUNT(*) FROM `" . wpjobportal::$_db->prefix . "wj_portal_config`";
        $result = wpjobportaldb::get_var($query);
        return $result;
    }

    function getConfigValue($configname) {
        $query = "SELECT configvalue FROM `" . wpjobportal::$_db->prefix . "wj_portal_config` WHERE configname = '" . $configname . "'";
        //return wpjobportaldb::get_var($query);
		return wpjobportal::$_db->get_var($query);
    }

    function getConfigurationByConfigForMultiple($configfor){
        $query = "SELECT configname,configvalue
                  FROM `".wpjobportal::$_db->prefix."wj_portal_config` WHERE configfor IN (".$configfor.")";
        $result = wpjobportaldb::get_results($query);
        $config_array =  array();
        //to make configuration in to an array with key as index
        foreach ($result as $config ) {
           $config_array[$config->configname] = $config->configvalue;
        }
        return $config_array;
    }

    function getConfigurationByConfigName($configname){
        $query = "SELECT configvalue
                  FROM `".wpjobportal::$_db->prefix."wj_portal_config` WHERE configname ='" . $configname . "'";
        $result = wpjobportaldb::get_var($query);
        return $result;

    }

    function checkCronKey($passkey) {

        $query = "SELECT COUNT(configvalue) FROM `".wpjobportal::$_db->prefix."wj_portal_config` WHERE configname = 'cron_job_alert_key' AND configvalue = '" . $passkey . "'";
        $key = wpjobportaldb::get_var($query);
        if ($key == 1)
            return true;
        else
            return false;
    }

    function getLoginRegisterRedirectLink($defaulUrl,$redirectType) {
        if ($redirectType == 'register') {
            $val = wpjobportal::$_configuration['set_register_redirect_link'];
            $link = wpjobportal::$_configuration['register_redirect_link'];
            $wpDefaultPage = wp_registration_url();
        } else if ($redirectType == 'login') {
            $val = wpjobportal::$_configuration['set_login_redirect_link'];
            $link = wpjobportal::$_configuration['login_redirect_link'];
            $wpDefaultPage = wp_login_url();
        }
        $redirectval = $val;
        $redirectlink = $link;
        if ($redirectval == 3){
            $hreflink = $wpDefaultPage;
        }
        else if($redirectval == 2 && $redirectlink != ""){
            $hreflink = $redirectlink;
        }else{
            $hreflink = $defaulUrl;
        }
        return $hreflink;
    }
    function getMessagekey(){
        $key = 'configuration';if(wpjobportal::$_common->wpjp_isadmin()){$key = 'admin_'.$key;}return $key;
    }



    function getConfigSideMenu(){
        $html = '<ul id="wpjobportaladmin-menu-links" class="tree config-accordion accordion wpjobportaladmin-sidebar-menu "  data-widget="tree">
            <li class="treeview" id="gen_setting">
                <a class="js-icon-left" href="#" title="'. __('general setting' , 'wp-job-portal') .'">
                    <img src="'. WPJOBPORTAL_PLUGIN_URL."includes/images/control_panel/dashboard/admin-left-menu/config.png" .'"/>
                    <span class="wpjobportal_text wpjobportal-parent">'. __("General Settings" , "wp-job-portal") .'</span>
                </a>
                <ul class="wpjobportaladmin-sidebar-submenu treeview-menu">
                    <li class="wpjobportal-child"><a href="?page=wpjobportal_configuration&wpjobportallt=configurations&wpjpconfigid=general_setting#site_setting" class="jslm_text">'. __("Site Settings","wp-job-portal") .'</a></li>';
                    if(in_array('message', wpjobportal::$_active_addons)){
                        $html .= '<li class="wpjobportal-child"><a href="?page=wpjobportal_configuration&wpjobportallt=configurations&wpjpconfigid=general_setting#message" class="jslm_text">'.  __("Messages" , "wp-job-portal") .'</a></li>';
                    }
                    $html .= '<li class="wpjobportal-child"><a href="?page=wpjobportal_configuration&wpjobportallt=configurations&wpjpconfigid=general_setting#defaul_setting" class="jslm_text">'.  __("Default Settings" , "wp-job-portal") .'</a></li>
                    <li class="wpjobportal-child"><a href="?page=wpjobportal_configuration&wpjobportallt=configurations&wpjpconfigid=general_setting#categories" class="jslm_text">'.  __("Categories" , "wp-job-portal") .'</a></li>
                    <li class="wpjobportal-child"><a href="?page=wpjobportal_configuration&wpjobportallt=configurations&wpjpconfigid=general_setting#email" class="jslm_text">'.  __("Email" , "wp-job-portal") .'</a></li>';
                    if(in_array('addressdata', wpjobportal::$_active_addons)){
                        $html .= '<li class="wpjobportal-child"><a href="?page=wpjobportal_configuration&wpjobportallt=configurations&wpjpconfigid=general_setting#googlemapadsense" class="jslm_text">'.  __("Map" , "wp-job-portal") .'</a></li>';
                    }
                    $html .= '<li class="wpjobportal-child"><a href="?page=wpjobportal_configuration&wpjobportallt=configurations&wpjpconfigid=general_setting#offline" class="jslm_text">'.  __("Offline" , "wp-job-portal") .'</a></li>
                    <li class="wpjobportal-child"><a href="?page=wpjobportal_configuration&wpjobportallt=configurations&wpjpconfigid=general_setting#terms" class="jslm_text">'.  __("Term And Conditions" , "wp-job-portal") .'</a></li>
                </ul>
            </li>
            <li class="treeview" id="emp_setting">
                <a class="js-icon-left" href="#" title="'. __('employer' , 'wp-job-portal') .'">
                    <img src="'.  WPJOBPORTAL_PLUGIN_URL."includes/images/config/employer.png" .'"/>
                    <span class="jslm_text wpjobportal-parent ">'.  __("Employer" , "wp-job-portal") .'</span>
                </a>
                <ul class="wpjobportaladmin-sidebar-submenu treeview-menu">
                    <li class="wpjobportal-child"><a href="admin.php?page=wpjobportal_configuration&wpjobportallt=configurationsemployer&wpjpconfigid=emp_general_setting#emp_generalsetting" class="jslm_text">'.  __("General Settings","wp-job-portal") .'</a></li>';
                    if(in_array('addressdata', wpjobportal::$_active_addons)){
                        $html .= '<li class="wpjobportal-child"><a href="admin.php?page=wpjobportal_configuration&wpjobportallt=configurationsemployer&wpjpconfigid=emp_general_setting#emp_listresume" class="jslm_text">'.  __("Search Resume" , "wp-job-portal") .'</a></li> ';
                    }
                    $html .= '<li class="wpjobportal-child"><a href="admin.php?page=wpjobportal_configuration&wpjobportallt=configurationsemployer&wpjpconfigid=emp_general_setting#email" class="jslm_text">'.  __("Email" , "wp-job-portal") .'</a></li>
                    <li class="wpjobportal-child"><a href="admin.php?page=wpjobportal_configuration&wpjobportallt=configurationsemployer&wpjpconfigid=emp_general_setting#emp_auto_approve" class="jslm_text">'.  __("Auto Approve" , "wp-job-portal") .'</a></li>
                    <li class="wpjobportal-child"><a href="admin.php?page=wpjobportal_configuration&wpjobportallt=configurationsemployer&wpjpconfigid=emp_general_setting#emp_company" class="jslm_text">'.  __("Company" , "wp-job-portal") .'</a></li>
                    <li class="wpjobportal-child"><a href="admin.php?page=wpjobportal_configuration&wpjobportallt=configurationsemployer&wpjpconfigid=emp_general_setting#emp_memberlinks" class="jslm_text">'.  __("Members Links" , "wp-job-portal") .'</a></li>
                </ul>
            </li>
            <li class="treeview" id="js_setting">
                <a class="js-icon-left" href="#" title="'. __('job seeker' , 'wp-job-portal') .'">
                    <img src="'. WPJOBPORTAL_PLUGIN_URL."includes/images/config/joseeker.png" .'"/>
                    <span class="jslm_text wpjobportal-parent">'. __("Job Seeker" , "wp-job-portal") .'</span>
                </a>
                <ul class="wpjobportaladmin-sidebar-submenu treeview-menu">
                    <li class="wpjobportal-child"><a href="admin.php?page=wpjobportal_configuration&wpjobportallt=configurationsjobseeker&wpjpconfigid=jobseeker_general_setting#js_generalsetting" class="jslm_text">'.  __("General Settings","wp-job-portal") .'</a></li>
                    <li class="wpjobportal-child"><a href="admin.php?page=wpjobportal_configuration&wpjobportallt=configurationsjobseeker&wpjpconfigid=jobseeker_general_setting#js_resume_setting" class="jslm_text">'.  __("Resume Settings" , "wp-job-portal") .'</a></li>
                    <li class="wpjobportal-child"><a href="admin.php?page=wpjobportal_configuration&wpjobportallt=configurationsjobseeker&wpjpconfigid=jobseeker_general_setting#js_memberlinks" class="jslm_text">'.  __("Members Links" , "wp-job-portal") .'</a></li>
                </ul>
            </li>
            <li class="treeview" id="vis_setting">
                <a class="js-icon-left" href="#" title="'. __('visitor setting' , 'wp-job-portal') .'">
                    <img src="'. WPJOBPORTAL_PLUGIN_URL."includes/images/config/user.png" .'"/>
                    <span class="jslm_text wpjobportal-parent">'. __("Visitor Settings" , "wp-job-portal") .'</span>
                </a>
                <ul class="wpjobportaladmin-sidebar-submenu treeview-menu">
                    <li class="wpjobportal-child"><a href="admin.php?page=wpjobportal_configuration&wpjobportallt=configurations&wpjpconfigid=visitor_setting#captcha_setting" class="jslm_text">'.  __("Captcha Settings","wp-job-portal") .'</a></li>
                    <li class="wpjobportal-child"><a href="admin.php?page=wpjobportal_configuration&wpjobportallt=configurations&wpjpconfigid=visitor_setting#visitor_setting_employer_side" class="jslm_text">'.  __("Employer Settings" , "wp-job-portal") .'</a></li>
                    <li class="wpjobportal-child"><a href="admin.php?page=wpjobportal_configuration&wpjobportallt=configurations&wpjpconfigid=visitor_setting#js_visitor" class="jslm_text">'.  __("Jobseeker Settings" , "wp-job-portal") .'</a></li>
                    <li class="wpjobportal-child"><a href="admin.php?page=wpjobportal_configuration&wpjobportallt=configurations&wpjpconfigid=visitor_setting#emp_visitorlinks" class="jslm_text">'.  __("Employer Links" , "wp-job-portal") .'</a></li>
                    <li class="wpjobportal-child"><a href="admin.php?page=wpjobportal_configuration&wpjobportallt=configurations&wpjpconfigid=visitor_setting#js_memberlinks" class="jslm_text">'.  __("Jobseeker Links" , "wp-job-portal") .'</a></li>
                </ul>
            </li>';
            if(in_array('credits', wpjobportal::$_active_addons)){
                 $html .= '<li class="treeview" id="pack_setting">
                    <a class="js-icon-left" href="#" title="'. __('package setting' , 'wp-job-portal') .'">
                        <img src="'. WPJOBPORTAL_PLUGIN_URL."includes/images/config/package.png" .'"/>
                        <span class="jslm_text wpjobportal-parent">'. __("Package Settings" , "wp-job-portal") .'</span>
                    </a>
                    <ul class="wpjobportaladmin-sidebar-submenu treeview-menu">
                        <li class="wpjobportal-child"><a href="admin.php?page=wpjobportal_configuration&wpjobportallt=configurations&wpjpconfigid=package_setting#package" class="jslm_text">'.  __("Free Packages","wp-job-portal") .'</a></li>
                        <li class="wpjobportal-child"><a href="admin.php?page=wpjobportal_configuration&wpjobportallt=configurations&wpjpconfigid=package_setting#paid_submission" class="jslm_text">'.  __("Paid Submissions" , "wp-job-portal") .'</a></li>
                    </ul>
                </li>';
            } else {
                $plugininfo = checkWPJPPluginInfo('wp-job-portal-credits/wp-job-portal-credits.php');
                if($plugininfo['availability'] == "1"){
                    $text = $plugininfo['text'];
                    $url = "plugins.php?s=wp-job-portal-credits&plugin_status=inactive";
                }elseif($plugininfo['availability'] == "0"){
                    $text = $plugininfo['text'];
                    $url = "https://wpjobportal.com/product/credit-system/";
                }
                $html .= '<li class="disabled-menu">
                    <img src="'. WPJOBPORTAL_PLUGIN_URL."includes/images/config/package-grey.png" .'"/>
                    <span class="wpjobportaladmin-text">'. __('Package Settings' , 'wp-job-portal').'</span>
                    <a href="'. esc_url($url).'" class="wpjobportaladmin-install-btn" title="'. esc_attr($text).'">'. esc_html($text).'</a>
               </li>';
            }
            $html .= '<li class="treeview" id="social_setting">
                <a class="js-icon-left" href="#" title="'. __('social apps' , 'wp-job-portal') .'">
                    <img src="'. WPJOBPORTAL_PLUGIN_URL."includes/images/config/social_share.png" .'"/>
                    <span class="jslm_text wpjobportal-parent">'. __(" Social Apps" , "wp-job-portal") .'</span>
                </a>
                <ul class="wpjobportaladmin-sidebar-submenu treeview-menu">';
                    if(in_array('socialshare', wpjobportal::$_active_addons)){
                        $html .= '<li class="wpjobportal-child"><a href="admin.php?page=wpjobportal_configuration&wpjobportallt=configurations&wpjpconfigid=social_share#socialsharing" class="jslm_text">'.  __("Social Links","wp-job-portal") .'</a></li>';
                    } else {
                        $plugininfo = checkWPJPPluginInfo('wp-job-portal-socialshare/wp-job-portal-socialshare.php');
                        if($plugininfo['availability'] == "1"){
                            $text = $plugininfo['text'];
                            $url = "plugins.php?s=wp-job-portal-socialshare&plugin_status=inactive";
                        }elseif($plugininfo['availability'] == "0"){
                            $text = $plugininfo['text'];
                            $url = "https://wpjobportal.com/product/social-share/";
                        }
                        $html .= '<li class="disabled-menu">
                                    <span class="wpjobportaladmin-text">'. __('Social Share' , 'wp-job-portal').'</span>
                                    <a href="'. esc_url($url).'" class="jslm_text">'. esc_html($text).'</a>
                                 </li>';
                    }
                    if(in_array('sociallogin', wpjobportal::$_active_addons)){
                        $html .= '<li class="wpjobportal-child"><a href="admin.php?page=wpjobportal_configuration&wpjobportallt=configurations&wpjpconfigid=social_share#facebook" class="jslm_text">'.  __("Facebook" , "wp-job-portal") .'</a></li>
                        <li class="wpjobportal-child"><a href="admin.php?page=wpjobportal_configuration&wpjobportallt=configurations&wpjpconfigid=social_share#linkedin" class="jslm_text">'.  __("Linkedin" , "wp-job-portal") .'</a></li>
                        <li class="wpjobportal-child"><a href="admin.php?page=wpjobportal_configuration&wpjobportallt=configurations&wpjpconfigid=social_share#xing" class="jslm_text">'.  __("Xing" , "wp-job-portal") .'</a></li>';
                    } else {
                        $plugininfo = checkWPJPPluginInfo('wp-job-portal-sociallogin/wp-job-portal-sociallogin.php');
                        if($plugininfo['availability'] == "1"){
                            $text = $plugininfo['text'];
                            $url = "plugins.php?s=wp-job-portal-sociallogin&plugin_status=inactive";
                        }elseif($plugininfo['availability'] == "0"){
                            $text = $plugininfo['text'];
                            $url = "https://wpjobportal.com/product/social-login/";
                        }
                        $html .= '<li class="disabled-menu">
                                    <span class="wpjobportaladmin-text">'. __('Social Login' , 'wp-job-portal').'</span>
                                    <a href="'. esc_url($url).'" class="jslm_text">'. esc_html($text).'</a>
                                 </li>';
                    }
                $html .= '</ul>
            </li>';
            if(in_array('rssfeedback', wpjobportal::$_active_addons)){
                $html .= '<li class="treeview" id="rs_setting">
                    <a class="js-icon-left" href="#" title="'. __('rss' , 'wp-job-portal') .'">
                        <img src="'. WPJOBPORTAL_PLUGIN_URL."includes/images/config/rss.png" .'"/>
                        <span class="jslm_text wpjobportal-parent">'. __("RSS" , "wp-job-portal") .'</span>
                    </a>
                    <ul class="wpjobportaladmin-sidebar-submenu treeview-menu">
                        <li class="wpjobportal-child"><a href="admin.php?page=wpjobportal_configuration&wpjobportallt=configurations&wpjpconfigid=rss_setting#rssjob" class="jslm_text">'.  __("Job Settings","wp-job-portal") .'</a></li>
                        <li class="wpjobportal-child"><a href="admin.php?page=wpjobportal_configuration&wpjobportallt=configurations&wpjpconfigid=rss_setting#rssresume" class="jslm_text">'.  __("Resume Settings" , "wp-job-portal") .'</a></li>
                    </ul>
                </li>';
            } else {
                $plugininfo = checkWPJPPluginInfo('wp-job-portal-rssfeedback/wp-job-portal-rssfeedback.php');
                if($plugininfo['availability'] == "1"){
                    $text = $plugininfo['text'];
                    $url = "plugins.php?s=wp-job-portal-rssfeedback&plugin_status=inactive";
                }elseif($plugininfo['availability'] == "0"){
                    $text = $plugininfo['text'];
                    $url = "https://wpjobportal.com/product/rss-2/";
                }
                $html .= '<li class="disabled-menu">
                    <img src="'. WPJOBPORTAL_PLUGIN_URL."includes/images/config/package-grey.png" .'"/>
                    <span class="wpjobportaladmin-text">'. __('RSS' , 'wp-job-portal').'</span>
                    <a href="'. esc_url($url).'" class="wpjobportaladmin-install-btn" title="'. esc_attr($text).'">'. esc_html($text).'</a>
               </li>';
            }
            $html .= '<li class="treeview" id="lr_setting">
                    <a class="js-icon-left" href="#" title="'. __('login/register' , 'wp-job-portal') .'">
                        <img src="'. WPJOBPORTAL_PLUGIN_URL."includes/images/config/login.png" .'"/>
                        <span class="jslm_text wpjobportal-parent">'. __(" Login/Register" , "wp-job-portal") .'</span>
                    </a>
                    <ul class="wpjobportaladmin-sidebar-submenu treeview-menu">
                        <li class="wpjobportal-child"><a href="admin.php?page=wpjobportal_configuration&wpjobportallt=configurations&wpjpconfigid=login_register#login" class="jslm_text">'.  __("Login","wp-job-portal") .'</a></li>
                        <li class="wpjobportal-child"><a href="admin.php?page=wpjobportal_configuration&wpjobportallt=configurations&wpjpconfigid=login_register#register" class="jslm_text">'.  __("Register" , "wp-job-portal") .'</a></li>
                    </ul>
                </li>';
            if(in_array('credits', wpjobportal::$_active_addons)){
                $html .= '<li class="treeview" id="pm_setting">
                    <a class="js-icon-left" href="#" title="'. __('payment method' , 'wp-job-portal') .'">
                        <img src="'. WPJOBPORTAL_PLUGIN_URL."includes/images/config/payment.png" .'"/>
                        <span class="jslm_text wpjobportal-parent">'. __("Payment Method" , "wp-job-portal") .'</span>
                    </a>
                    <ul class="wpjobportaladmin-sidebar-submenu treeview-menu">
                        <li class="wpjobportal-child"><a href="admin.php?page=wpjobportal_paymentmethodconfiguration&wpjpconfigid=pay_setting#paypal" class="jslm_text">'.  __("PayPal","wp-job-portal") .'</a></li>
                        <li class="wpjobportal-child"><a href="admin.php?page=wpjobportal_paymentmethodconfiguration&wpjpconfigid=pay_setting#stripe" class="jslm_text">'.  __("Stripe" , "wp-job-portal") .'</a></li>
                        <li class="wpjobportal-child"><a href="admin.php?page=wpjobportal_paymentmethodconfiguration&wpjpconfigid=pay_setting#others" class="jslm_text">'.  __("Woocommerce" , "wp-job-portal") .'</a></li>
                    </ul>
                </li>';
            }
            else{
                $plugininfo = checkWPJPPluginInfo('wp-job-portal-credits/wp-job-portal-credits.php');
                if($plugininfo['availability'] == "1"){
                    $text = $plugininfo['text'];
                    $url = "plugins.php?s=wp-job-portal-credits&plugin_status=inactive";
                }elseif($plugininfo['availability'] == "0"){
                    $text = $plugininfo['text'];
                    $url = "https://wpjobportal.com/product/credit-system/";
                }
                $html .= '<li class="disabled-menu">
                    <img src="'. WPJOBPORTAL_PLUGIN_URL."includes/images/config/payment_grey.png" .'"/>
                    <span class="wpjobportaladmin-text">'. __('Payment Method' , 'wp-job-portal').'</span>
                    <a href="'. esc_url($url).'" class="wpjobportaladmin-install-btn" title="'. esc_attr($text).'">'. esc_html($text).'</a>
                </li>';
            }
            if(in_array('cronjob', wpjobportal::$_active_addons)){
                $html .= '<li class="treeview" id="cj_setting">
                    <a class="js-icon-left" href="#" title="'. __('cron job' , 'wp-job-portal') .'">
                        <img src="'. WPJOBPORTAL_PLUGIN_URL."includes/images/config/cron_job.png" .'"/>
                        <span class="jslm_text wpjobportal-parent">'. __("Cron Job" , "wp-job-portal") .'</span>
                    </a>
                    <ul class="wpjobportaladmin-sidebar-submenu treeview-menu">
                        <li class="wpjobportal-child"><a href="admin.php?page=wpjobportal_cronjob&wpjobportallt=cronjob&wpjpconfigid=cron_setting#webcrown" class="jslm_text">'.  __("Webcrown.org","wp-job-portal") .'</a></li>
                        <li class="wpjobportal-child"><a href="admin.php?page=wpjobportal_cronjob&wpjobportallt=cronjob&wpjpconfigid=cron_setting#wget" class="jslm_text">'.  __("Wget" , "wp-job-portal") .'</a></li>
                        <li class="wpjobportal-child"><a href="admin.php?page=wpjobportal_cronjob&wpjobportallt=cronjob&wpjpconfigid=cron_setting#curl" class="jslm_text">'.  __("Curl" , "wp-job-portal") .'</a></li>
                        <li class="wpjobportal-child"><a href="admin.php?page=wpjobportal_cronjob&wpjobportallt=cronjob&wpjpconfigid=cron_setting#phpscript" class="jslm_text">'.  __("Php Script" , "wp-job-portal") .'</a></li>
                        <li class="wpjobportal-child"><a href="admin.php?page=wpjobportal_cronjob&wpjobportallt=cronjob&wpjpconfigid=cron_setting#url" class="jslm_text">'.  __("Website" , "wp-job-portal") .'</a></li>
                    </ul>
                </li>';
            }else{
                $plugininfo = checkWPJPPluginInfo('wp-job-portal-cronjob/wp-job-portal-cronjob.php');
                if($plugininfo['availability'] == "1"){
                    $text = $plugininfo['text'];
                    $url = "plugins.php?s=wp-job-portal-cronjob&plugin_status=inactive";
                }elseif($plugininfo['availability'] == "0"){
                    $text = $plugininfo['text'];
                    $url = "https://wpjobportal.com/product/cron-job-copy/";
                }
                $html .= '<li class="disabled-menu">
                    <img src="'. WPJOBPORTAL_PLUGIN_URL."includes/images/config/cron_job_grey.png" .'"/>
                    <span class="wpjobportaladmin-text">'. __('Cron Job' , 'wp-job-portal').'</span>
                    <a href="'. esc_url($url).'" class="wpjobportaladmin-install-btn" title="'. esc_attr($text).'">'. esc_html($text).'</a>
                </li>';
             }
        $html .= '</ul>';
        return $html;
    }
}

?>
