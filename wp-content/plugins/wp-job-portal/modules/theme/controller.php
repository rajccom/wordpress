<?php

if (!defined('ABSPATH'))
    die('Restricted Access');

class WPJOBPORTALthemeController {

    private $_msgkey;

    function __construct() {

        self::handleRequest();
        
    }

    function handleRequest() {
        $layout = WPJOBPORTALrequest::getLayout('wpjobportallt', null, 'themes');
        $uid = WPJOBPORTALincluder::getObjectClass('user')->uid();
        if (self::canaddfile()) {
            $empflag  = WPJOBPORTALincluder::getJSModel('configuration')->getConfigurationByConfigName('disable_employer');
            $string = "'jscontrolpanel','emcontrolpanel'";
            $config_array = WPJOBPORTALincluder::getJSModel('configuration')->getConfigurationByConfigForMultiple($string);

            switch ($layout) {
                case 'admin_themes':
                    WPJOBPORTALincluder::getJSModel('theme')->getCurrentTheme();
                    WPJOBPORTALincluder::getJSModel('wpjobportal')->getCPJobs();
                   break;
            }
            if ($empflag == 0) {
                WPJOBPORTALLayout::setMessageFor(5);
                wpjobportal::$_error_flag_message_register_for=5; 
                wpjobportal::$_error_flag = true;
            }

            $module = (wpjobportal::$_common->wpjp_isadmin()) ? 'page' : 'wpjobportalme';
            $module = WPJOBPORTALrequest::getVar($module, null, 'theme');
            $module = wpjobportalphplib::wpJP_str_replace('wpjobportal_', '', $module);
            WPJOBPORTALincluder::include_file($layout, $module);
        }
    }

    function canaddfile() {
        if (isset($_POST['form_request']) && $_POST['form_request'] == 'wpjobportal')
            return false;
        elseif (isset($_GET['action']) && $_GET['action'] == 'wpjobportaltask')
            return false;
        else
            return true;
    }

    static function savetheme() {
        $data = WPJOBPORTALrequest::get('post');
        WPJOBPORTALincluder::getJSModel('theme')->storeTheme($data);
        $url = admin_url("admin.php?page=wpjobportal_theme&wpjobportallt=themes");
        wp_redirect($url);
        die();
    }
}

$WPJOBPORTALthemeController = new WPJOBPORTALthemeController();
?>
