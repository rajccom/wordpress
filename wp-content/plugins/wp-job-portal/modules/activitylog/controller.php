<?php

if (!defined('ABSPATH'))
    die('Restricted Access');

class WPJOBPORTALactivitylogController {

    function __construct() {

        self::handleRequest();
    }

    function handleRequest() {
        $layout = WPJOBPORTALrequest::getLayout('wpjobportallt', null, 'activitylogs');
        if (self::canaddfile()) {
            switch ($layout) {
                case 'admin_activitylogs':
                    WPJOBPORTALincluder::getJSModel('activitylog')->getAllActivities();
                    break;
            }
            $module = (wpjobportal::$_common->wpjp_isadmin()) ? 'page' : 'wpjobportalme';
            $module = WPJOBPORTALrequest::getVar($module, null, 'activitylog');
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

}

$WPJOBPORTALactivitylogController = new WPJOBPORTALactivitylogController();
?>
