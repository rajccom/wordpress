<?php

if (!defined('ABSPATH'))
    die('Restricted Access');

class WPJOBPORTALsalaryrangetypeController {

    private $_msgkey;

    function __construct() {

        self::handleRequest();
        $this->_msgkey = WPJOBPORTALincluder::getJSModel('salaryrangetype')->getMessagekey();
    }

    function handleRequest() {
        $layout = WPJOBPORTALrequest::getLayout('wpjobportallt', null, 'salaryrangetype');
        if (self::canaddfile()) {
            switch ($layout) {
                case 'admin_salaryrangetype':
                    WPJOBPORTALincluder::getJSModel('salaryrangetype')->getAllSalaryRangeType();
                    break;
                case 'admin_formsalaryrangetype':
                    $id = WPJOBPORTALrequest::getVar('wpjobportalid');
                    WPJOBPORTALincluder::getJSModel('salaryrangetype')->getSalaryRangeTypebyId($id);
                    break;
            }
            $module = (wpjobportal::$_common->wpjp_isadmin()) ? 'page' : 'wpjobportalme';
            $module = WPJOBPORTALrequest::getVar($module, null, 'salaryrangetype');
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

    function savesalaryrangetype() {
        $data = WPJOBPORTALrequest::get('post');
        $result = WPJOBPORTALincluder::getJSModel('salaryrangetype')->storeSalaryRangeType($data);
        $url = admin_url('admin.php?page=wpjobportal_salaryrangetype&wpjobportallt=salaryrangetype');
        $msg = WPJOBPORTALMessages::getMessage($result, 'salaryrangetype');
        WPJOBPORTALMessages::setLayoutMessage($msg['message'], $msg['status'],$this->_msgkey);
        wp_redirect($url);
        die();
    }

    function remove() {
        $nonce = WPJOBPORTALrequest::getVar('_wpnonce');
        if (! wp_verify_nonce( $nonce, 'delete-salaryrangetype') ) {
             die( 'Security check Failed' );
        }
        $ids = WPJOBPORTALrequest::getVar('wpjobportal-cb');
        $result = WPJOBPORTALincluder::getJSModel('salaryrangetype')->deleteSalaryRangesType($ids);
        $msg = WPJOBPORTALMessages::getMessage($result, 'salaryrangetype');
        WPJOBPORTALMessages::setLayoutMessage($msg['message'], $msg['status'],$this->_msgkey);
        $url = admin_url('admin.php?page=wpjobportal_salaryrangetype&wpjobportallt=salaryrangetype');
        wp_redirect($url);
        die();
    }

    function publish() {
        $pagenum = WPJOBPORTALrequest::getVar('pagenum');
        $ids = WPJOBPORTALrequest::getVar('wpjobportal-cb');
        $result = WPJOBPORTALincluder::getJSModel('salaryrangetype')->publishUnpublish($ids, 1); //  for publish
        $msg = WPJOBPORTALMessages::getMessage($result, 'record');
        WPJOBPORTALMessages::setLayoutMessage($msg['message'], $msg['status'],$this->_msgkey);
        $url = admin_url('admin.php?page=wpjobportal_salaryrangetype&wpjobportallt=salaryrangetype');
        if ($pagenum)
            $url .= "&pagenum=" . $pagenum;
        wp_redirect($url);
        die();
    }

    function unpublish() {
        $pagenum = WPJOBPORTALrequest::getVar('pagenum');
        $ids = WPJOBPORTALrequest::getVar('wpjobportal-cb');
        $result = WPJOBPORTALincluder::getJSModel('salaryrangetype')->publishUnpublish($ids, 0); //  for unpublish
        $msg = WPJOBPORTALMessages::getMessage($result, 'record');
        WPJOBPORTALMessages::setLayoutMessage($msg['message'], $msg['status'],$this->_msgkey);
        $url = admin_url('admin.php?page=wpjobportal_salaryrangetype&wpjobportallt=salaryrangetype');
        if ($pagenum)
            $url .= "&pagenum=" . $pagenum;
        wp_redirect($url);
        die();
    }


    // WE will Save the Ordering system in this Function
    function saveordering(){
        $post = WPJOBPORTALrequest::get('post');
        if($post['task'] == 'unpublish'){
            $this->unpublish();
            exit();
        }
        if($post['task'] == 'publish'){
            $this->publish();
            exit();
        }
        if($post['task'] == 'remove'){
            $this->remove();
            exit();
        }
        WPJOBPORTALincluder::getJSModel('salaryrangetype')->storeOrderingFromPage($post);
        $url = admin_url("admin.php?page=wpjobportal_salaryrangetype");
        wp_redirect($url);
        exit;
    }

}

$WPJOBPORTALsalaryrangetypeController = new WPJOBPORTALSalaryrangetypeController();
?>
