<?php

if (!defined('ABSPATH'))
    die('Restricted Access');

class WPJOBPORTALcountryController {

    private $_msgkey;

    function __construct() {
        self::handleRequest();
        $this->_msgkey = WPJOBPORTALincluder::getJSModel('country')->getMessagekey();        
    }

    function handleRequest() {

        $layout = WPJOBPORTALrequest::getLayout('wpjobportallt', null, 'countries');
        if (self::canaddfile()) {
            switch ($layout) {
                case 'admin_countries':
                    WPJOBPORTALincluder::getJSModel('country')->getAllCountries();
                    break;
                case 'admin_formcountry':
                    $id = WPJOBPORTALrequest::getVar('wpjobportalid');
                    WPJOBPORTALincluder::getJSModel('country')->getCountrybyId($id);
                    break;
            }

            $module = (wpjobportal::$_common->wpjp_isadmin()) ? 'page' : 'wpjobportalme';
            $module = WPJOBPORTALrequest::getVar($module, null, 'countries');
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

    function remove() {
        $nonce = WPJOBPORTALrequest::getVar('_wpnonce');
        if (! wp_verify_nonce( $nonce, 'delete-country') ) {
             die( 'Security check Failed' ); 
        }
        $ids = WPJOBPORTALrequest::getVar('wpjobportal-cb');
        $result = WPJOBPORTALincluder::getJSModel('country')->deleteCountries($ids);
        $msg = WPJOBPORTALMessages::getMessage($result, 'country');
        WPJOBPORTALMessages::setLayoutMessage($msg['message'], $msg['status'],$this->_msgkey);
        $url = admin_url("admin.php?page=wpjobportal_country&wpjobportallt=countries");
        wp_redirect($url);
        die();
    }

    function publish() {
        $pagenum = WPJOBPORTALrequest::getVar('pagenum');
        $ids = WPJOBPORTALrequest::getVar('wpjobportal-cb');
        $result = WPJOBPORTALincluder::getJSModel('country')->publishUnpublish($ids, 1); //  for publish
        $msg = WPJOBPORTALMessages::getMessage($result, 'record');
        WPJOBPORTALMessages::setLayoutMessage($msg['message'], $msg['status'],$this->_msgkey);
        $url = admin_url("admin.php?page=wpjobportal_country&wpjobportallt=countries");
        if ($pagenum)
            $url .= "&pagenum=" . $pagenum;
        wp_redirect($url);
        die();
    }

    function unpublish() {
        $pagenum = WPJOBPORTALrequest::getVar('pagenum');
        $ids = WPJOBPORTALrequest::getVar('wpjobportal-cb');
        $result = WPJOBPORTALincluder::getJSModel('country')->publishUnpublish($ids, 0); //  for unpublish
        $msg = WPJOBPORTALMessages::getMessage($result, 'record');
        WPJOBPORTALMessages::setLayoutMessage($msg['message'], $msg['status'],$this->_msgkey);
        $url = admin_url("admin.php?page=wpjobportal_country&wpjobportallt=countries");
        if ($pagenum)
            $url .= "&pagenum=" . $pagenum;
        wp_redirect($url);
        die();
    }

    function savecountry() {

        $data = WPJOBPORTALrequest::get('post');
        $result = WPJOBPORTALincluder::getJSModel('country')->storeCountry($data);
        $url = admin_url("admin.php?page=wpjobportal_country&wpjobportallt=countries");
        $msg = WPJOBPORTALMessages::getMessage($result, 'country');
        WPJOBPORTALMessages::setLayoutMessage($msg['message'], $msg['status'],$this->_msgkey);
        wp_redirect($url);
        die();
    }

}

$WPJOBPORTALcountry = new WPJOBPORTALcountryController();
?>
