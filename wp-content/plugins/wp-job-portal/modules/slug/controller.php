<?php
if (!defined('ABSPATH'))
    die('Restricted Access');

class WPJOBPORTALslugController {
    private $_msgkey;
    function __construct() {
        self::handleRequest();
        $this->_msgkey = WPJOBPORTALincluder::getJSModel('slug')->getMessagekey();        
    }

    function handleRequest() {
        $layout = WPJOBPORTALrequest::getLayout('wpjobportallt', null, 'slug');
        if (self::canaddfile()) {
            switch ($layout) {
                case 'admin_slug':
                    WPJOBPORTALincluder::getJSModel('slug')->getSlug();
                    break;
            }
            $module = 'page';
            $module = WPJOBPORTALrequest::getVar($module, null, 'slug');
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

    function saveSlug() {
        $data = WPJOBPORTALrequest::get('post');
        $result = WPJOBPORTALincluder::getJSModel('slug')->storeSlug($data);
        if($data['pagenum'] > 0){
            $url = admin_url("admin.php?page=wpjobportal_slug&pagenum=".$data['pagenum']);
        }else{
            $url = admin_url("admin.php?page=wpjobportal_slug");
        }

        $msg = WPJOBPORTALMessages::getMessage($result, 'slug');
        WPJOBPORTALMessages::setLayoutMessage($msg['message'], $msg['status'],$this->_msgkey);
        wp_redirect($url);
        exit;
    }

    function saveprefix() {
        $data = WPJOBPORTALrequest::get('post');
        $result = WPJOBPORTALincluder::getJSModel('slug')->savePrefix($data);
        $url = admin_url("admin.php?page=wpjobportal_slug");
        $msg = WPJOBPORTALMessages::getMessage($result, 'prefix');
        WPJOBPORTALMessages::setLayoutMessage($msg['message'], $msg['status'],$this->_msgkey);
        wp_redirect($url);
        exit;
    }

    function savehomeprefix() {
        $data = WPJOBPORTALrequest::get('post');
        $result = WPJOBPORTALincluder::getJSModel('slug')->saveHomePrefix($data);
        $url = admin_url("admin.php?page=wpjobportal_slug");
        $msg = WPJOBPORTALMessages::getMessage($result, 'prefix');
        WPJOBPORTALMessages::setLayoutMessage($msg['message'], $msg['status'],$this->_msgkey);
        wp_redirect($url);
        exit;
    }

    function resetallslugs() {
        $data = WPJOBPORTALrequest::get('post');
        $result = WPJOBPORTALincluder::getJSModel('slug')->resetAllSlugs();
        $url = admin_url("admin.php?page=wpjobportal_slug");
        $msg = WPJOBPORTALMessages::getMessage($result, 'slug');
        WPJOBPORTALMessages::setLayoutMessage($msg['message'], $msg['status'],$this->_msgkey);
        wp_redirect($url);
        exit;
    }
}

$WPJOBPORTALslugController = new WPJOBPORTALslugController();
?>
