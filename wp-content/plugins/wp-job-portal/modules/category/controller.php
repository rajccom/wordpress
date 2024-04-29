<?php

if (!defined('ABSPATH'))
    die('Restricted Access');

class WPJOBPORTALCategoryController {

    private $_msgkey;

    function __construct() {
        self::handleRequest();
        $this->_msgkey = WPJOBPORTALincluder::getJSModel('category')->getMessagekey();
    }

    function handleRequest() {
        $layout = WPJOBPORTALrequest::getLayout('wpjobportallt', null, 'categories');
        if (self::canaddfile()) {
            switch ($layout) {
                case 'admin_categories':
                    WPJOBPORTALincluder::getJSModel('category')->getAllCategories();
                    break;
                case 'admin_formcategory':
                    $id = WPJOBPORTALrequest::getVar('wpjobportalid');
                    WPJOBPORTALincluder::getJSModel('category')->getCategorybyId($id);
                    break;
            }
            $module = (wpjobportal::$_common->wpjp_isadmin()) ? 'page' : 'wpjobportalme';
            $module = WPJOBPORTALrequest::getVar($module, null, 'categories');
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

    function savecategory() {
        $data = WPJOBPORTALrequest::get('post');
        $result = WPJOBPORTALincluder::getJSModel('category')->storeCategory($data);
        $msg = WPJOBPORTALMessages::getMessage($result, 'category');
        WPJOBPORTALMessages::setLayoutMessage($msg['message'], $msg['status'],$this->_msgkey);
        $url = admin_url("admin.php?page=wpjobportal_category&wpjobportallt=categories");
        wp_redirect($url);
        die();
    }

    function remove() {
        $nonce = WPJOBPORTALrequest::getVar('_wpnonce');
        if (! wp_verify_nonce( $nonce, 'delete-category') ) {
             die( 'Security check Failed' );
        }
        $ids = WPJOBPORTALrequest::getVar('wpjobportal-cb');
        $result = WPJOBPORTALincluder::getJSModel('category')->deleteCategories($ids);
        $msg = WPJOBPORTALMessages::getMessage($result, 'category');
        WPJOBPORTALMessages::setLayoutMessage($msg['message'], $msg['status'],$this->_msgkey);
        $url = admin_url("admin.php?page=wpjobportal_category&wpjobportallt=categories");
        wp_redirect($url);
        die();
    }

    function publish() {
        $pagenum = WPJOBPORTALrequest::getVar('pagenum');
        $ids = WPJOBPORTALrequest::getVar('wpjobportal-cb');
        $result = WPJOBPORTALincluder::getJSModel('category')->publishUnpublish($ids, 1); //  for publish
        $msg = WPJOBPORTALMessages::getMessage($result, 'record');
        WPJOBPORTALMessages::setLayoutMessage($msg['message'], $msg['status'],$this->_msgkey);
        $url = admin_url("admin.php?page=wpjobportal_category&wpjobportallt=categories");
        if ($pagenum)
            $url .= "&pagenum=" . $pagenum;
        wp_redirect($url);
        die();
    }

    function unpublish() {
        $pagenum = WPJOBPORTALrequest::getVar('pagenum');
        $ids = WPJOBPORTALrequest::getVar('wpjobportal-cb');
        $result = WPJOBPORTALincluder::getJSModel('category')->publishUnpublish($ids, 0); //  for unpublish
        $msg = WPJOBPORTALMessages::getMessage($result, 'record');
        WPJOBPORTALMessages::setLayoutMessage($msg['message'], $msg['status'],$this->_msgkey);
        $url = admin_url("admin.php?page=wpjobportal_category&wpjobportallt=categories");
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
        WPJOBPORTALincluder::getJSModel('category')->storeOrderingFromPage($post);
        $url = admin_url("admin.php?page=wpjobportal_category");
        wp_redirect($url);
        exit;
    }


}

$WPJOBPORTALCategoryController = new WPJOBPORTALCategoryController();
?>
