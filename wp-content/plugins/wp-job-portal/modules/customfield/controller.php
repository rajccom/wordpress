<?php
if (!defined('ABSPATH'))
    die('Restricted Access');

class WPJOBPORTALCustomFieldController {

    private $_msgkey;

    function __construct() {
        self::handleRequest();
        $this->_msgkey = WPJOBPORTALincluder::getJSModel('customfield')->getMessagekey();
    }

    function handleRequest() {
        $layout = WPJOBPORTALrequest::getLayout('wpjobportallt', null, 'fieldsordering');
        if (self::canaddfile()) {
            switch ($layout) {
                case 'admin_searchfields':
                    $fieldfor = WPJOBPORTALrequest::getVar('ff','',2);
                    wpjobportal::$_data['fieldfor'] = $fieldfor;
                    WPJOBPORTALincluder::getJSModel('customfield')->getSearchFieldsOrdering($fieldfor);
                    break;

                case 'admin_formuserfield':
                    $id = WPJOBPORTALrequest::getVar('wpjobportalid');
                    $fieldfor = WPJOBPORTALrequest::getVar('ff');
                    if (empty($fieldfor)){
                        $fieldfor = wpjobportal::$_data['fieldfor'];
                    }else{
                        wpjobportal::$_data['fieldfor'] = $fieldfor;
                    }
                    wpjobportal::$_data[0]['fieldfor'] = $fieldfor;
                    WPJOBPORTALincluder::getJSModel('customfield')->getUserFieldbyId($id, $fieldfor);
                    break;
            }
            $module = (wpjobportal::$_common->wpjp_isadmin()) ? 'page' : 'wpjobportalme';
            $module = WPJOBPORTALrequest::getVar($module, null, 'customfield');
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

    function fieldrequired() {
        $pagenum = WPJOBPORTALrequest::getVar('pagenum');
        $fieldfor = WPJOBPORTALrequest::getVar('ff');
        $ids = WPJOBPORTALrequest::getVar('wpjobportal-cb');
        $result = WPJOBPORTALincluder::getJSModel('customfield')->fieldsRequiredOrNot($ids, 1); // required
        $msg = WPJOBPORTALMessages::getMessage($result, 'customfield');
        WPJOBPORTALMessages::setLayoutMessage($msg['message'], $msg['status'],$this->_msgkey);
        $url = admin_url('admin.php?page=wpjobportal_customfield&wpjobportallt=fieldsordering&ff=' . $fieldfor);
        if ($pagenum)
            $url .= "&pagenum=" . $pagenum;
        wp_redirect($url);
        die();
    }

    function fieldnotrequired() {
        $pagenum = WPJOBPORTALrequest::getVar('pagenum');
        $fieldfor = WPJOBPORTALrequest::getVar('ff');
        $ids = WPJOBPORTALrequest::getVar('wpjobportal-cb');
        $result = WPJOBPORTALincluder::getJSModel('customfield')->fieldsRequiredOrNot($ids, 0); // notrequired
        $msg = WPJOBPORTALMessages::getMessage($result, 'customfield');
        WPJOBPORTALMessages::setLayoutMessage($msg['message'], $msg['status'],$this->_msgkey);
        $url = admin_url('admin.php?page=wpjobportal_customfield&wpjobportallt=fieldsordering&ff=' . $fieldfor);
        if ($pagenum)
            $url .= "&pagenum=" . $pagenum;
        wp_redirect($url);
        die();
    }

    function fieldpublished() {
        $pagenum = WPJOBPORTALrequest::getVar('pagenum');
        $fieldfor = WPJOBPORTALrequest::getVar('ff');
        $ids = WPJOBPORTALrequest::getVar('wpjobportal-cb');
        $result = WPJOBPORTALincluder::getJSModel('customfield')->fieldsPublishedOrNot($ids, 1);
        $msg = WPJOBPORTALMessages::getMessage($result, 'record');
        WPJOBPORTALMessages::setLayoutMessage($msg['message'], $msg['status'],$this->_msgkey);
        $url = admin_url('admin.php?page=wpjobportal_customfield&wpjobportallt=fieldsordering&ff=' . $fieldfor);
        if ($pagenum)
            $url .= "&pagenum=" . $pagenum;
        wp_redirect($url);
        die();
    }

    function fieldunpublished() {
        $pagenum = WPJOBPORTALrequest::getVar('pagenum');
        $fieldfor = WPJOBPORTALrequest::getVar('ff');
        $ids = WPJOBPORTALrequest::getVar('wpjobportal-cb');
        $result = WPJOBPORTALincluder::getJSModel('customfield')->fieldsPublishedOrNot($ids, 0);
        $msg = WPJOBPORTALMessages::getMessage($result, 'record');
        WPJOBPORTALMessages::setLayoutMessage($msg['message'], $msg['status'],$this->_msgkey);
        $url = admin_url('admin.php?page=wpjobportal_customfield&wpjobportallt=fieldsordering&ff=' . $fieldfor);
        if ($pagenum)
            $url .= "&pagenum=" . $pagenum;
        wp_redirect($url);
        die();
    }

    /*function visitorfieldpublished() {
        $pagenum = WPJOBPORTALrequest::getVar('pagenum');
        $fieldfor = WPJOBPORTALrequest::getVar('ff');
        $ids = WPJOBPORTALrequest::getVar('wpjobportal-cb');
        $result = WPJOBPORTALincluder::getJSModel('customfield')->visitorFieldsPublishedOrNot($ids, 1);
        $msg = WPJOBPORTALMessages::getMessage($result, 'record');
        WPJOBPORTALMessages::setLayoutMessage($msg['message'], $msg['status'],$this->_msgkey);
        $url = admin_url('admin.php?page=wpjobportal_customfield&wpjobportallt=fieldsordering&ff=' . $fieldfor);
        if ($pagenum)
            $url .= "&pagenum=" . $pagenum;
        wp_redirect($url);
        die();
    }

    function visitorfieldunpublished() {
        $pagenum = WPJOBPORTALrequest::getVar('pagenum');
        $fieldfor = WPJOBPORTALrequest::getVar('ff');
        $ids = WPJOBPORTALrequest::getVar('wpjobportal-cb');
        $result = WPJOBPORTALincluder::getJSModel('customfield')->visitorFieldsPublishedOrNot($ids, 0);
        $msg = WPJOBPORTALMessages::getMessage($result, 'record');
        WPJOBPORTALMessages::setLayoutMessage($msg['message'], $msg['status'],$this->_msgkey);
        $url = admin_url('admin.php?page=wpjobportal_customfield&wpjobportallt=fieldsordering&ff=' . $fieldfor);
        if ($pagenum)
            $url .= "&pagenum=" . $pagenum;
        wp_redirect($url);
        die();
    }*/

    /*function customfieldup() {
        $pagenum = WPJOBPORTALrequest::getVar('pagenum');
        $fieldfor = WPJOBPORTALrequest::getVar('ff');
        $id = WPJOBPORTALrequest::getVar('fieldid');
        $result = WPJOBPORTALincluder::getJSModel('customfield')->fieldOrderingUp($id);
        $msg = WPJOBPORTALMessages::getMessage($result, 'customfield');
        WPJOBPORTALMessages::setLayoutMessage($msg['message'], $msg['status'],$this->_msgkey);
        $url = admin_url('admin.php?page=wpjobportal_customfield&wpjobportallt=fieldsordering&ff=' . $fieldfor);
        if ($pagenum)
            $url .= "&pagenum=" . $pagenum;
        wp_redirect($url);
        die();
    }

    function customfielddown() {
        $pagenum = WPJOBPORTALrequest::getVar('pagenum');
        $fieldfor = WPJOBPORTALrequest::getVar('ff');
        $id = WPJOBPORTALrequest::getVar('fieldid');
        $result = WPJOBPORTALincluder::getJSModel('customfield')->fieldOrderingDown($id);
        $msg = WPJOBPORTALMessages::getMessage($result, 'customfield');
        WPJOBPORTALMessages::setLayoutMessage($msg['message'], $msg['status'],$this->_msgkey);
        $url = admin_url('admin.php?page=wpjobportal_customfield&wpjobportallt=fieldsordering&ff=' . $fieldfor);
        if ($pagenum)
            $url .= "&pagenum=" . $pagenum;
        wp_redirect($url);
        die();
    }*/

    function saveuserfield() {
        $data = WPJOBPORTALrequest::get('post');
        $fieldfor = WPJOBPORTALrequest::getVar('fieldfor');
        if($fieldfor == ''){
            $fieldfor = $data['fieldfor'];
        }
        $result = WPJOBPORTALincluder::getJSModel('customfield')->storeUserField($data);
        if ($result === WPJOBPORTAL_SAVE_ERROR || $result === false) {
            $url = admin_url("admin.php?page=wpjobportal_customfield&wpjobportallt=formuserfield&ff=" . $fieldfor);
        } else
            $url = admin_url("admin.php?page=wpjobportal_customfield&ff=" . $fieldfor);
        $msg = WPJOBPORTALMessages::getMessage($result, 'customfield');
        WPJOBPORTALMessages::setLayoutMessage($msg['message'], $msg['status'],$this->_msgkey);
        wp_redirect($url);
        die();
    }

    function savesearchcustomfield() {
        $data = WPJOBPORTALrequest::get('post');
        $fieldfor = WPJOBPORTALrequest::getVar('fieldfor');
        if($fieldfor == ''){
            $fieldfor = $data['fieldfor'];
        }
        $result = WPJOBPORTALincluder::getJSModel('customfield')->storeSearchFieldOrdering($data);
        $url = admin_url("admin.php?page=wpjobportal_customfield&wpjobportallt=searchfields&fieldfor=" . $fieldfor);
        $msg = WPJOBPORTALMessages::getMessage($result, 'customfield');
        WPJOBPORTALMessages::setLayoutMessage($msg['message'], $msg['status'],$this->_msgkey);
        wp_redirect($url);
        die();
    }

    function savesearchcustomfieldFromForm() {
        $data = WPJOBPORTALrequest::get('post');
        $fieldfor = WPJOBPORTALrequest::getVar('fieldfor');
        if($fieldfor == ''){
            $fieldfor = $data['fieldfor'];
        }
        $result = WPJOBPORTALincluder::getJSModel('customfield')->storeSearchFieldOrderingByForm($data);
        $url = admin_url("admin.php?page=wpjobportal_customfield&wpjobportallt=searchfields&fieldfor=" . $fieldfor);
        $msg = WPJOBPORTALMessages::getMessage($result, 'customfield');
        WPJOBPORTALMessages::setLayoutMessage($msg['message'], $msg['status'],$this->_msgkey);
        wp_redirect($url);
        die();
    }

    function remove() {
        $nonce = WPJOBPORTALrequest::getVar('_wpnonce');
        if (! wp_verify_nonce( $nonce, 'delete-customfield') ) {
             die( 'Security check Failed' );
        }
        $pagenum = WPJOBPORTALrequest::getVar('pagenum');
        $id = WPJOBPORTALrequest::getVar('fieldid');
        $ff = WPJOBPORTALrequest::getVar('ff');
        $result = WPJOBPORTALincluder::getJSModel('customfield')->deleteUserField($id);
        $msg = WPJOBPORTALMessages::getMessage($result, 'customfield');
        WPJOBPORTALMessages::setLayoutMessage($msg['message'], $msg['status'],$this->_msgkey);
        $url = admin_url("admin.php?page=wpjobportal_customfield&ff=".$ff);
        if ($pagenum)
            $url .= "&pagenum=" . $pagenum;
        wp_redirect($url);
        die();
    }

}

$WPJOBPORTALcustomfieldController = new WPJOBPORTALcustomfieldController();
?>
