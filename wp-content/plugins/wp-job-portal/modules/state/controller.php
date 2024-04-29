<?php

if (!defined('ABSPATH'))
    die('Restricted Access');

class WPJOBPORTALStateController {

    private $_msgkey;

    function __construct() {

        self::handleRequest();

        $this->_msgkey = WPJOBPORTALincluder::getJSModel('state')->getMessagekey();
    }

    function handleRequest() {
        $layout = WPJOBPORTALrequest::getLayout('wpjobportallt', null, 'states');
        if (self::canaddfile()) {
            switch ($layout) {
                case 'admin_states':
                    $countryid = WPJOBPORTALrequest::getVar('countryid');
                    if (!$countryid)
                        $countryid = get_option("wpjobportal_countryid_for_stateid");

                    update_option( 'wpjobportal_countryid_for_stateid', $countryid );
                    WPJOBPORTALincluder::getJSModel('state')->getAllCountryStates($countryid);
                    break;
                case 'admin_formstate':
                    $id = WPJOBPORTALrequest::getVar('wpjobportalid');
                    WPJOBPORTALincluder::getJSModel('state')->getStatebyId($id);
                    break;
            }
            $module = (wpjobportal::$_common->wpjp_isadmin()) ? 'page' : 'wpjobportalme';
            $module = WPJOBPORTALrequest::getVar($module, null, 'states');
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
        if (! wp_verify_nonce( $nonce, 'delete-state') ) {
             die( 'Security check Failed' );
        }
        $ids = WPJOBPORTALrequest::getVar('wpjobportal-cb');
        $countryid = get_option("wpjobportal_countryid_for_stateid");

        $result = WPJOBPORTALincluder::getJSModel('state')->deleteStates($ids);
        $msg = WPJOBPORTALMessages::getMessage($result, 'state');
        WPJOBPORTALMessages::setLayoutMessage($msg['message'], $msg['status'],$this->_msgkey);
        $url = admin_url("admin.php?page=wpjobportal_state&wpjobportallt=states&countryid=" . $countryid);
        wp_redirect($url);
        die();
    }

    function publish() {
        $pagenum = WPJOBPORTALrequest::getVar('pagenum');
        $ids = WPJOBPORTALrequest::getVar('wpjobportal-cb');
        $countryid = get_option("wpjobportal_countryid_for_stateid");
        $result = WPJOBPORTALincluder::getJSModel('state')->publishUnpublish($ids, 1); //  for publish
        $msg = WPJOBPORTALMessages::getMessage($result, 'record');
        WPJOBPORTALMessages::setLayoutMessage($msg['message'], $msg['status'],$this->_msgkey);
        $url = admin_url("admin.php?page=wpjobportal_state&wpjobportallt=states&countryid=" . $countryid);
        if ($pagenum)
            $url .= "&pagenum=" . $pagenum;
        wp_redirect($url);
        die();
    }

    function unpublish() {
        $pagenum = WPJOBPORTALrequest::getVar('pagenum');
        $ids = WPJOBPORTALrequest::getVar('wpjobportal-cb');
        $countryid = get_option("wpjobportal_countryid_for_stateid");
        $result = WPJOBPORTALincluder::getJSModel('state')->publishUnpublish($ids, 0); //  for unpublish
        $msg = WPJOBPORTALMessages::getMessage($result, 'record');
        WPJOBPORTALMessages::setLayoutMessage($msg['message'], $msg['status'],$this->_msgkey);
        $url = admin_url("admin.php?page=wpjobportal_state&wpjobportallt=states&countryid=" . $countryid);
        if ($pagenum)
            $url .= "&pagenum=" . $pagenum;
        wp_redirect($url);
        die();
    }

    function savestate() {
        $data = WPJOBPORTALrequest::get('post');
        $countryid = get_option("wpjobportal_countryid_for_stateid");
        $result = WPJOBPORTALincluder::getJSModel('state')->storeState($data, $countryid);
        $url = admin_url("admin.php?page=wpjobportal_state&wpjobportallt=states&countryid=" . $countryid);
        $msg = WPJOBPORTALMessages::getMessage($result, 'state');
        WPJOBPORTALMessages::setLayoutMessage($msg['message'], $msg['status'],$this->_msgkey);
        wp_redirect($url);
        die();
    }

}

$WPJOBPORTALStateController = new WPJOBPORTALStateController();
?>
