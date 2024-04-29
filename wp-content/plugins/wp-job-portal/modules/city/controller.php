<?php

if (!defined('ABSPATH'))
    die('Restricted Access');

class WPJOBPORTALCityController {

    private $_msgkey;

    function __construct() {
        self::handleRequest();
        $this->_msgkey = WPJOBPORTALincluder::getJSModel('city')->getMessagekey();
    }

    function handleRequest() {
        $layout = WPJOBPORTALrequest::getLayout('wpjobportallt', null, 'cities');
        if (self::canaddfile()) {
            switch ($layout) {
                case 'admin_cities':
                    $countryid = WPJOBPORTALrequest::getVar('countryid');
                    $stateid = WPJOBPORTALrequest::getVar('stateid');

                    update_option( 'wpjobportal_countryid_for_city', $countryid);
                    update_option( 'wpjobportal_stateid_for_city', $stateid);
                    WPJOBPORTALincluder::getJSModel('city')->getAllStatesCities($countryid, $stateid);
                    break;
                case 'admin_formcity':
                    $id = WPJOBPORTALrequest::getVar('wpjobportalid');
                    WPJOBPORTALincluder::getJSModel('city')->getCitybyId($id);
                    break;
            }
            $module = (wpjobportal::$_common->wpjp_isadmin()) ? 'page' : 'wpjobportalme';
            $module = WPJOBPORTALrequest::getVar($module, null, 'city');
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

    function getaddressdatabycityname() {
        $cityname = WPJOBPORTALrequest::getVar('q');
        $result = WPJOBPORTALincluder::getJSModel('city')->getAddressDataByCityName($cityname);
        $json_response = json_encode($result);
        echo wp_kses($json_response,WPJOBPORTAL_ALLOWED_TAGS);
        exit();
    }

    function removecity() {
        $nonce = WPJOBPORTALrequest::getVar('_wpnonce');
        if (! wp_verify_nonce( $nonce, 'delete-city') ) {
             die( 'Security check Failed' );
        }
        $countryid = get_option("wpjobportal_countryid_for_city" );
        $stateid = get_option( "wpjobportal_stateid_for_city" );

        $ids = WPJOBPORTALrequest::getVar('wpjobportal-cb');
        $result = WPJOBPORTALincluder::getJSModel('city')->deleteCities($ids);
        $msg = WPJOBPORTALMessages::getMessage($result, 'city');
        WPJOBPORTALMessages::setLayoutMessage($msg['message'], $msg['status'],$this->_msgkey);
        $url = admin_url("admin.php?page=wpjobportal_city&wpjobportallt=cities&countryid=" . $countryid . "&stateid=" . $stateid);
        wp_redirect($url);
        die();
    }

    function publish() {
        $countryid = get_option("wpjobportal_countryid_for_city" );
        $stateid = get_option( "wpjobportal_stateid_for_city" );

        $pagenum = WPJOBPORTALrequest::getVar('pagenum');
        $ids = WPJOBPORTALrequest::getVar('wpjobportal-cb');
        $result = WPJOBPORTALincluder::getJSModel('city')->publishUnpublish($ids, 1); //  for publish
        $msg = WPJOBPORTALMessages::getMessage($result, 'record');
        WPJOBPORTALMessages::setLayoutMessage($msg['message'], $msg['status'],$this->_msgkey);
        $url = admin_url("admin.php?page=wpjobportal_city&wpjobportallt=cities&countryid=" . $countryid . "&stateid=" . $stateid);
        if ($pagenum)
            $url .= "&pagenum=" . $pagenum;
        wp_redirect($url);
        die();
    }

    function unpublish() {
        $countryid = get_option("wpjobportal_countryid_for_city" );
        $stateid = get_option( "wpjobportal_stateid_for_city" );

        $pagenum = WPJOBPORTALrequest::getVar('pagenum');
        $ids = WPJOBPORTALrequest::getVar('wpjobportal-cb');
        $result = WPJOBPORTALincluder::getJSModel('city')->publishUnpublish($ids, 0); //  for unpublish
        $msg = WPJOBPORTALMessages::getMessage($result, 'record');
        WPJOBPORTALMessages::setLayoutMessage($msg['message'], $msg['status'],$this->_msgkey);
        $url = admin_url("admin.php?page=wpjobportal_city&wpjobportallt=cities&countryid=" . $countryid . "&stateid=" . $stateid);
        if ($pagenum)
            $url .= "&pagenum=" . $pagenum;
        wp_redirect($url);
        die();
    }

    function savecity() {
        $countryid = get_option("wpjobportal_countryid_for_city" );
        $stateid = get_option( "wpjobportal_stateid_for_city" );
        $url = admin_url("admin.php?page=wpjobportal_city&wpjobportallt=cities&countryid=" . $countryid . "&stateid=" . $stateid);

        $data = WPJOBPORTALrequest::get('post');
        if ($data['stateid'])
            $stateid = $data['stateid'];
        $result = WPJOBPORTALincluder::getJSModel('city')->storeCity($data, $countryid, $stateid);
        $msg = WPJOBPORTALMessages::getMessage($result, 'city');
        WPJOBPORTALMessages::setLayoutMessage($msg['message'], $msg['status'],$this->_msgkey);
        wp_redirect($url);
        die();
    }

}

$WPJOBPORTALCityController = new WPJOBPORTALCityController();
?>
