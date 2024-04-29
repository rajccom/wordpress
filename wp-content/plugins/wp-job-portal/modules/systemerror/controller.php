<?php

if (!defined('ABSPATH'))
    die('Restricted Access');

class WPJOBPORTALsystemerrorController {

    function __construct() {

        self::handleRequest();
    }

    function handleRequest() {
        $layout = WPJOBPORTALrequest::getLayout('wpjobportallt', null, 'systemerrors');

        if (self::canaddfile()) {
            switch ($layout) {
                case 'admin_systemerrors':
                    WPJOBPORTALincluder::getJSModel('systemerror')->getSystemErrors();
                    break;

                case 'admin_addsystemerror':
                    $id = WPJOBPORTALrequest::getVar('jssupportticketid', 'get');
                    WPJOBPORTALincluder::getJSModel('systemerror')->getsystemerrorForForm($id);
                    break;
            }
            $module = (wpjobportal::$_common->wpjp_isadmin()) ? 'page' : 'wpjobportalme';
            $module = WPJOBPORTALrequest::getVar($module, null, 'systemerror');
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

$systemerrorController = new WPJOBPORTALsystemerrorController();
?>
