<?php

if (!defined('ABSPATH'))
    die('Restricted Access');

class WPJOBPORTALConfigurationController {

    private $_msgkey;

    function __construct() {
        self::handleRequest();
        $this->_msgkey = WPJOBPORTALincluder::getJSModel('configuration')->getMessagekey();        
    }

    function handleRequest() {
        $layout = WPJOBPORTALrequest::getLayout('wpjobportallt', null, 'configurations');
        if (self::canaddfile()) {
            switch ($layout) {
                case 'admin_configurations':
                case 'admin_configurationsemployer':
                case 'admin_configurationsjobseeker':
                    $wpjpconfigid = WPJOBPORTALrequest::getVar('wpjpconfigid');
                    if (isset($wpjpconfigid)) {
                        wpjobportal::$_data['wpjpconfigid'] = $wpjpconfigid;
                    } else {
                        wpjobportal::$_data['wpjpconfigid'] = 'general_setting';
                    }
                    WPJOBPORTALincluder::getJSModel('configuration')->getConfigurationsForForm();
                    break;
            }
            $module = (wpjobportal::$_common->wpjp_isadmin()) ? 'page' : 'wpjobportalme';
            $module = WPJOBPORTALrequest::getVar($module, null, 'configurations');
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

    function saveconfiguration() {
        $data = WPJOBPORTALrequest::get('post');
        $layout = WPJOBPORTALrequest::getVar('wpjobportallt');
        $result = WPJOBPORTALincluder::getJSModel('configuration')->storeConfig($data);
        $msg = WPJOBPORTALMessages::getMessage($result, "configuration");
        WPJOBPORTALMessages::setLayoutMessage($msg['message'], $msg['status'],$this->_msgkey);
        if ($layout == 'configurationsjobseeker') {
            $url = admin_url("admin.php?page=wpjobportal_configuration&wpjobportallt=" . $layout."&wpjpconfigid=jobseeker_general_setting#js_generalsetting");
        } elseif ($layout == 'configurationsemployer') {
            $url = admin_url("admin.php?page=wpjobportal_configuration&wpjobportallt=" . $layout."&wpjpconfigid=emp_general_setting#emp_generalsetting");
        } else {
            $url = admin_url("admin.php?page=wpjobportal_configuration&wpjobportallt=" . $layout."&wpjpconfigid=general_setting#site_setting");
        }
        
        wp_redirect($url);
        die();
    }

}

$WPJOBPORTALConfigurationController = new WPJOBPORTALConfigurationController();
?>
