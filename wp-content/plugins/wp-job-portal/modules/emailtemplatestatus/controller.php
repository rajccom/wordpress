<?php

if (!defined('ABSPATH'))
    die('Restricted Access');

class WPJOBPORTALemailtemplatestatusController {

    function __construct() {

        self::handleRequest();
    }

    function handleRequest() {
        $layout = WPJOBPORTALrequest::getLayout('wpjobportallt', null, 'emailtemplatestatus');
        if (self::canaddfile()) {
            switch ($layout) {
                case 'admin_emailtemplatestatus':
                    WPJOBPORTALincluder::getJSModel('emailtemplatestatus')->getEmailTemplateStatusData();
                    break;
            }
            $module = (wpjobportal::$_common->wpjp_isadmin()) ? 'page' : 'wpjobportalme';
            $module = WPJOBPORTALrequest::getVar($module, null, 'emailtemplatestatus');
            $module = wpjobportalphplib::wpJP_str_replace('wpjobportal_', '', $module);
            WPJOBPORTALincluder::include_file($layout, $module);
        }
    }

    function sendEmail() {
        $id = WPJOBPORTALrequest::getVar('wpjobportalid');
        $action = WPJOBPORTALrequest::getVar('actionfor');
        WPJOBPORTALincluder::getJSModel('emailtemplatestatus')->sendEmailModel($id, $action); //  for send email
        $url = admin_url("admin.php?page=wpjobportal_emailtemplatestatus");
        wp_redirect($url);
        die();
    }

    function noSendEmail() {
        $id = WPJOBPORTALrequest::getVar('wpjobportalid');
        $action = WPJOBPORTALrequest::getVar('actionfor');
        WPJOBPORTALincluder::getJSModel('emailtemplatestatus')->noSendEmailModel($id, $action); //  for notsendemail
        $url = admin_url("admin.php?page=wpjobportal_emailtemplatestatus");
        wp_redirect($url);
        die();
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

$WPJOBPORTALEmailtemplatestatusController = new WPJOBPORTALEmailtemplatestatusController();
?>
