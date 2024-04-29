<?php
if (!defined('ABSPATH'))
    die('Restricted Access');

class WPJOBPORTALfieldorderingController {

    private $_msgkey;

    function __construct() {
        self::handleRequest();
        $this->_msgkey = WPJOBPORTALincluder::getJSModel('fieldordering')->getMessagekey();
    }

    function handleRequest() {
        $layout = WPJOBPORTALrequest::getLayout('wpjobportallt', null, 'fieldsordering');
        if (self::canaddfile()) {
            switch ($layout) {
                case 'admin_fieldsordering':
                    $fieldfor = WPJOBPORTALrequest::getVar('ff');
                    wpjobportal::$_data['fieldfor'] = $fieldfor;
                    WPJOBPORTALincluder::getJSModel('fieldordering')->getFieldsOrdering($fieldfor);
                    break;
                case 'admin_searchfields':
                    $fieldfor = WPJOBPORTALrequest::getVar('ff','',2);
                    wpjobportal::$_data['fieldfor'] = $fieldfor;
                    WPJOBPORTALincluder::getJSModel('fieldordering')->getSearchFieldsOrdering($fieldfor);
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
                    WPJOBPORTALincluder::getJSModel('fieldordering')->getUserFieldbyId($id, $fieldfor);
                    break;
            }
            $module = (wpjobportal::$_common->wpjp_isadmin()) ? 'page' : 'wpjobportalme';
            $module = WPJOBPORTALrequest::getVar($module, null, 'fieldordering');
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
        $result = WPJOBPORTALincluder::getJSModel('fieldordering')->fieldsRequiredOrNot($ids, 1); // required
        $msg = WPJOBPORTALMessages::getMessage($result, 'fieldordering');
        WPJOBPORTALMessages::setLayoutMessage($msg['message'], $msg['status'],$this->_msgkey);
        $url = admin_url('admin.php?page=wpjobportal_fieldordering&wpjobportallt=fieldsordering&ff=' . $fieldfor);
        if ($pagenum)
            $url .= "&pagenum=" . $pagenum;
        wp_redirect($url);
        die();
    }

    function fieldnotrequired() {
        $pagenum = WPJOBPORTALrequest::getVar('pagenum');
        $fieldfor = WPJOBPORTALrequest::getVar('ff');
        $ids = WPJOBPORTALrequest::getVar('wpjobportal-cb');
        $result = WPJOBPORTALincluder::getJSModel('fieldordering')->fieldsRequiredOrNot($ids, 0); // notrequired
        $msg = WPJOBPORTALMessages::getMessage($result, 'fieldordering');
        WPJOBPORTALMessages::setLayoutMessage($msg['message'], $msg['status'],$this->_msgkey);
        $url = admin_url('admin.php?page=wpjobportal_fieldordering&wpjobportallt=fieldsordering&ff=' . $fieldfor);
        if ($pagenum)
            $url .= "&pagenum=" . $pagenum;
        wp_redirect($url);
        die();
    }

    function fieldpublished() {
        $pagenum = WPJOBPORTALrequest::getVar('pagenum');
        $fieldfor = WPJOBPORTALrequest::getVar('ff');
        $ids = WPJOBPORTALrequest::getVar('wpjobportal-cb');
        $result = WPJOBPORTALincluder::getJSModel('fieldordering')->fieldsPublishedOrNot($ids, 1);
        $msg = WPJOBPORTALMessages::getMessage($result, 'record');
        WPJOBPORTALMessages::setLayoutMessage($msg['message'], $msg['status'],$this->_msgkey);
        $url = admin_url('admin.php?page=wpjobportal_fieldordering&wpjobportallt=fieldsordering&ff=' . $fieldfor);
        if ($pagenum)
            $url .= "&pagenum=" . $pagenum;
        wp_redirect($url);
        die();
    }

    function fieldunpublished() {
        $pagenum = WPJOBPORTALrequest::getVar('pagenum');
        $fieldfor = WPJOBPORTALrequest::getVar('ff');
        $ids = WPJOBPORTALrequest::getVar('wpjobportal-cb');
        $result = WPJOBPORTALincluder::getJSModel('fieldordering')->fieldsPublishedOrNot($ids, 0);
        $msg = WPJOBPORTALMessages::getMessage($result, 'record');
        WPJOBPORTALMessages::setLayoutMessage($msg['message'], $msg['status'],$this->_msgkey);
        $url = admin_url('admin.php?page=wpjobportal_fieldordering&wpjobportallt=fieldsordering&ff=' . $fieldfor);
        if ($pagenum)
            $url .= "&pagenum=" . $pagenum;
        wp_redirect($url);
        die();
    }

    function visitorfieldpublished() {
        $pagenum = WPJOBPORTALrequest::getVar('pagenum');
        $fieldfor = WPJOBPORTALrequest::getVar('ff');
        $ids = WPJOBPORTALrequest::getVar('wpjobportal-cb');
        $result = WPJOBPORTALincluder::getJSModel('fieldordering')->visitorFieldsPublishedOrNot($ids, 1);
        $msg = WPJOBPORTALMessages::getMessage($result, 'record');
        WPJOBPORTALMessages::setLayoutMessage($msg['message'], $msg['status'],$this->_msgkey);
        $url = admin_url('admin.php?page=wpjobportal_fieldordering&wpjobportallt=fieldsordering&ff=' . $fieldfor);
        if ($pagenum)
            $url .= "&pagenum=" . $pagenum;
        wp_redirect($url);
        die();
    }

    function visitorfieldunpublished() {
        $pagenum = WPJOBPORTALrequest::getVar('pagenum');
        $fieldfor = WPJOBPORTALrequest::getVar('ff');
        $ids = WPJOBPORTALrequest::getVar('wpjobportal-cb');
        $result = WPJOBPORTALincluder::getJSModel('fieldordering')->visitorFieldsPublishedOrNot($ids, 0);
        $msg = WPJOBPORTALMessages::getMessage($result, 'record');
        WPJOBPORTALMessages::setLayoutMessage($msg['message'], $msg['status'],$this->_msgkey);
        $url = admin_url('admin.php?page=wpjobportal_fieldordering&wpjobportallt=fieldsordering&ff=' . $fieldfor);
        if ($pagenum)
            $url .= "&pagenum=" . $pagenum;
        wp_redirect($url);
        die();
    }

    function fieldorderingup() {
        $pagenum = WPJOBPORTALrequest::getVar('pagenum');
        $fieldfor = WPJOBPORTALrequest::getVar('ff');
        $id = WPJOBPORTALrequest::getVar('fieldid');
        $result = WPJOBPORTALincluder::getJSModel('fieldordering')->fieldOrderingUp($id);
        $msg = WPJOBPORTALMessages::getMessage($result, 'fieldordering');
        WPJOBPORTALMessages::setLayoutMessage($msg['message'], $msg['status'],$this->_msgkey);
        $url = admin_url('admin.php?page=wpjobportal_fieldordering&wpjobportallt=fieldsordering&ff=' . $fieldfor);
        if ($pagenum)
            $url .= "&pagenum=" . $pagenum;
        wp_redirect($url);
        die();
    }

    function fieldorderingdown() {
        $pagenum = WPJOBPORTALrequest::getVar('pagenum');
        $fieldfor = WPJOBPORTALrequest::getVar('ff');
        $id = WPJOBPORTALrequest::getVar('fieldid');
        $result = WPJOBPORTALincluder::getJSModel('fieldordering')->fieldOrderingDown($id);
        $msg = WPJOBPORTALMessages::getMessage($result, 'fieldordering');
        WPJOBPORTALMessages::setLayoutMessage($msg['message'], $msg['status'],$this->_msgkey);
        $url = admin_url('admin.php?page=wpjobportal_fieldordering&wpjobportallt=fieldsordering&ff=' . $fieldfor);
        if ($pagenum)
            $url .= "&pagenum=" . $pagenum;
        wp_redirect($url);
        die();
    }

    function saveuserfield() {
        $data = WPJOBPORTALrequest::get('post');
        $fieldfor = WPJOBPORTALrequest::getVar('fieldfor');
        if($fieldfor == ''){
            $fieldfor = $data['fieldfor'];
        }
        $result = WPJOBPORTALincluder::getJSModel('fieldordering')->storeUserField($data);
        if ($result === WPJOBPORTAL_SAVE_ERROR || $result === false) {
            $url = admin_url("admin.php?page=wpjobportal_fieldordering&wpjobportallt=formuserfield&ff=" . $fieldfor);
        } else
            $url = admin_url("admin.php?page=wpjobportal_fieldordering&ff=" . $fieldfor);
        $msg = WPJOBPORTALMessages::getMessage($result, 'customfield');
        WPJOBPORTALMessages::setLayoutMessage($msg['message'], $msg['status'],$this->_msgkey);
        wp_redirect($url);
        die();
    }

    function savesearchfieldordering() {
        $data = WPJOBPORTALrequest::get('post');
        $fieldfor = WPJOBPORTALrequest::getVar('fieldfor');
        if($fieldfor == ''){
            $fieldfor = $data['fieldfor'];
        }
        $result = WPJOBPORTALincluder::getJSModel('fieldordering')->storeSearchFieldOrdering($data);
        $url = admin_url("admin.php?page=wpjobportal_fieldordering&wpjobportallt=searchfields&fieldfor=" . $fieldfor."&ff=" . $fieldfor);
        $msg = WPJOBPORTALMessages::getMessage($result, 'customfield');
        WPJOBPORTALMessages::setLayoutMessage($msg['message'], $msg['status'],$this->_msgkey);
        wp_redirect($url);
        die();
    }

    function savesearchfieldorderingFromForm() {
        $data = WPJOBPORTALrequest::get('post');
        $fieldfor = WPJOBPORTALrequest::getVar('fieldfor');
        if($fieldfor == ''){
            $fieldfor = $data['fieldfor'];
        }
        $result = WPJOBPORTALincluder::getJSModel('fieldordering')->storeSearchFieldOrderingByForm($data);
        $url = admin_url("admin.php?page=wpjobportal_fieldordering&wpjobportallt=searchfields&fieldfor=" . $fieldfor."&ff=" . $fieldfor);
        $msg = WPJOBPORTALMessages::getMessage($result, 'customfield');
        WPJOBPORTALMessages::setLayoutMessage($msg['message'], $msg['status'],$this->_msgkey);
        wp_redirect($url);
        die();
    }

    function remove() {
        $nonce = WPJOBPORTALrequest::getVar('_wpnonce');
        if (! wp_verify_nonce( $nonce, 'delete-fieldordering') ) {
             die( 'Security check Failed' );
        }
        $pagenum = WPJOBPORTALrequest::getVar('pagenum');
        $id = WPJOBPORTALrequest::getVar('fieldid');
        $ff = WPJOBPORTALrequest::getVar('ff');
        $result = WPJOBPORTALincluder::getJSModel('fieldordering')->deleteUserField($id);
        $msg = WPJOBPORTALMessages::getMessage($result, 'fieldordering');
        WPJOBPORTALMessages::setLayoutMessage($msg['message'], $msg['status'],$this->_msgkey);
        $url = admin_url("admin.php?page=wpjobportal_fieldordering&ff=".$ff);
        if ($pagenum)
            $url .= "&pagenum=" . $pagenum;
        wp_redirect($url);
        die();
    }

}

$WPJOBPORTALfieldorderingController = new WPJOBPORTALfieldorderingController();
?>
