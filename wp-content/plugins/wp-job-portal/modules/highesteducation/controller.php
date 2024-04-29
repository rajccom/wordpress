<?php

if (!defined('ABSPATH'))
    die('Restricted Access');

class WPJOBPORTALHighesteducationController {

    private $_msgkey;

    function __construct() {

        self::handleRequest();

        $this->_msgkey = WPJOBPORTALincluder::getJSModel('highesteducation')->getMessagekey();
    }

    function handleRequest() {
        $layout = WPJOBPORTALrequest::getLayout('wpjobportallt', null, 'highesteducations');
        if (self::canaddfile()) {
            switch ($layout) {
                case 'admin_highesteducations':
                    WPJOBPORTALincluder::getJSModel('highesteducation')->getAllHighestEducations();
                    break;
                case 'admin_formhighesteducation':
                    $id = WPJOBPORTALrequest::getVar('wpjobportalid');
                    WPJOBPORTALincluder::getJSModel('highesteducation')->getHighestEducationbyId($id);
                    break;
            }
            $module = (wpjobportal::$_common->wpjp_isadmin()) ? 'page' : 'wpjobportalme';
            $module = WPJOBPORTALrequest::getVar($module, null, 'highesteducation');
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

    function savehighesteducation() {
        if(!wpjobportal::$_common->wpjp_isadmin()) return;
        $data = WPJOBPORTALrequest::get('post');
        $result = WPJOBPORTALincluder::getJSModel('highesteducation')->storeHighestEducation($data);
        $url = admin_url('admin.php?page=wpjobportal_highesteducation&wpjobportallt=highesteducations');
        $msg = WPJOBPORTALMessages::getMessage($result, 'highesteducation');
        WPJOBPORTALMessages::setLayoutMessage($msg['message'], $msg['status'],$this->_msgkey);
        wp_redirect($url);
    }

    function remove() {
        if(!wpjobportal::$_common->wpjp_isadmin()) return;
        $nonce = WPJOBPORTALrequest::getVar('_wpnonce');
        if (! wp_verify_nonce( $nonce, 'delete-highesteducation') ) {
             die( 'Security check Failed' );
        }
        $ids = WPJOBPORTALrequest::getVar('wpjobportal-cb');
        $result = WPJOBPORTALincluder::getJSModel('highesteducation')->deleteHighestEducations($ids);
        $msg = WPJOBPORTALMessages::getMessage($result, 'highesteducation');
        WPJOBPORTALMessages::setLayoutMessage($msg['message'], $msg['status'],$this->_msgkey);
        $url = admin_url("admin.php?page=wpjobportal_highesteducation&wpjobportallt=highesteducations");
        wp_redirect($url);
        die();
    }

    function publish() {
        if(!wpjobportal::$_common->wpjp_isadmin()) return;
        $ids = WPJOBPORTALrequest::getVar('wpjobportal-cb');
        $pagenum = WPJOBPORTALrequest::getVar('pagenum');
        $result = WPJOBPORTALincluder::getJSModel('highesteducation')->publishUnpublish($ids, 1); //  for publish
        $msg = WPJOBPORTALMessages::getMessage($result, 'record');
        WPJOBPORTALMessages::setLayoutMessage($msg['message'], $msg['status'],$this->_msgkey);
        $url = admin_url("admin.php?page=wpjobportal_highesteducation&wpjobportallt=highesteducations");
        if ($pagenum)
            $url .= "&pagenum=" . $pagenum;
        wp_redirect($url);
        die();
    }

    function unpublish() {
        if(!wpjobportal::$_common->wpjp_isadmin()) return;
        $ids = WPJOBPORTALrequest::getVar('wpjobportal-cb');
        $pagenum = WPJOBPORTALrequest::getVar('pagenum');
        $result = WPJOBPORTALincluder::getJSModel('highesteducation')->publishUnpublish($ids, 0); //  for unpublish
        $msg = WPJOBPORTALMessages::getMessage($result, 'record');
        WPJOBPORTALMessages::setLayoutMessage($msg['message'], $msg['status'],$this->_msgkey);
        $url = admin_url("admin.php?page=wpjobportal_highesteducation&wpjobportallt=highesteducations");
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
        WPJOBPORTALincluder::getJSModel('highesteducation')->storeOrderingFromPage($post);
        $url = admin_url("admin.php?page=wpjobportal_highesteducation");
        wp_redirect($url);
        exit;
    }
}

$WPJOBPORTALHighesteducationController = new WPJOBPORTALHighesteducationController();
?>
