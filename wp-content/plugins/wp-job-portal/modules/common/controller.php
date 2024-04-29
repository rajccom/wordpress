<?php

if (!defined('ABSPATH'))
    die('Restricted Access');

class WPJOBPORTALCommonController {

    private $_msgkey;

    function __construct() {
        self::handleRequest();
        $this->_msgkey = WPJOBPORTALincluder::getJSModel('common')->getMessagekey();
    }

    function handleRequest() {
        $layout = WPJOBPORTALrequest::getLayout('wpjobportallt', null, 'newinwpjobportal');
         $socialUser = "";
        if(isset($_COOKIE['wpjobportal-socialid'])){
            $socialUser = sanitize_key($_COOKIE['wpjobportal-socialid']);
        }
        if (self::canaddfile()) {
            switch ($layout) {
                case 'newinwpjobportal':
                    if(WPJOBPORTALincluder::getObjectClass('user')->isguest() && !$socialUser){
                        $link = get_permalink();
                        $linktext = __('Login','wp-job-portal');
                        wpjobportal::$_error_flag_message = WPJOBPORTALLayout::setMessageFor(1 , $link , $linktext,1);
                        wpjobportal::$_error_flag = true;
                    }
                break;
            }
            $module = (wpjobportal::$_common->wpjp_isadmin()) ? 'page' : 'wpjobportalme';
            $module = WPJOBPORTALrequest::getVar($module, null, 'common');
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

    function makedefault() {
        $id = WPJOBPORTALrequest::getVar('id');
        $for = WPJOBPORTALrequest::getVar('for'); // table name
        $pagenum = WPJOBPORTALrequest::getVar('pagenum');
        $result = WPJOBPORTALincluder::getJSModel('common')->setDefaultForDefaultTable($id, $for);
        $object = $this->getpageandlayoutname($for);
        $msg = WPJOBPORTALMessages::getMessage($result, $object['page']);
        switch ($for) {
            case "jobstatus":
                $this->_msgkey = WPJOBPORTALincluder::getJSModel('jobstatus')->getMessagekey();
                break;
            case "jobtypes":
                $this->_msgkey = WPJOBPORTALincluder::getJSModel('jobtype')->getMessagekey();
                break;
            case "careerlevels":
                $this->_msgkey = WPJOBPORTALincluder::getJSModel('careerlevel')->getMessagekey();
                break;
            case "salaryrangetypes":
                $this->_msgkey = WPJOBPORTALincluder::getJSModel('salaryrangetype')->getMessagekey();
                break;
            case "currencies":
                $this->_msgkey = WPJOBPORTALincluder::getJSModel('currency')->getMessagekey();
                break;
            case "heighesteducation":
                $this->_msgkey = WPJOBPORTALincluder::getJSModel('highesteducation')->getMessagekey();
                break;
            case "categories":
                $this->_msgkey = WPJOBPORTALincluder::getJSModel('category')->getMessagekey();
                break;
        }
        WPJOBPORTALMessages::setLayoutMessage($msg['message'], $msg['status'],$this->_msgkey);
        $url = admin_url("admin.php?page=wpjobportal_" . $object['page'] . "&wpjobportallt=" . $object['wpjobportallt']);
        if ($pagenum)
            $url .= "&pagenum=" . $pagenum;
        wp_redirect($url);
        die();
    }

    function defaultorderingup() {
        $id = WPJOBPORTALrequest::getVar('id');
        $for = WPJOBPORTALrequest::getVar('for'); //table name
        $pagenum = WPJOBPORTALrequest::getVar('pagenum');
        $result = WPJOBPORTALincluder::getJSModel('common')->setOrderingUpForDefaultTable($id, $for);
        $object = $this->getpageandlayoutname($for);
        $msg = WPJOBPORTALMessages::getMessage($result, $object['page']);
        $url = admin_url("admin.php?page=wpjobportal_" . $object['page'] . "&wpjobportallt=" . $object['wpjobportallt']);
        if ($pagenum)
            $url .= "&pagenum=" . $pagenum;
        WPJOBPORTALMessages::setLayoutMessage($msg['message'], $msg['status'],$this->_msgkey);
        wp_redirect($url);
        die();
    }

    function defaultorderingdown() {
        $id = WPJOBPORTALrequest::getVar('id');
        $for = WPJOBPORTALrequest::getVar('for'); // table name
        $pagenum = WPJOBPORTALrequest::getVar('pagenum');
        $result = WPJOBPORTALincluder::getJSModel('common')->setOrderingDownForDefaultTable($id, $for);
        $object = $this->getpageandlayoutname($for);
        $msg = WPJOBPORTALMessages::getMessage($result, $object['page']);
        $url = admin_url("admin.php?page=wpjobportal_" . $object['page'] . "&wpjobportallt=" . $object['wpjobportallt']);
        if ($pagenum)
            $url .= "&pagenum=" . $pagenum;
        WPJOBPORTALMessages::setLayoutMessage($msg['message'], $msg['status'],$this->_msgkey);
        wp_redirect($url);
        die();
    }

    function getpageandlayoutname($for) { // for tablename
        switch ($for) {
            case 'jobtypes' : $object['page'] = "jobtype";
                $object['wpjobportallt'] = "jobtypes";
                break;
            case 'shifts' : $object['page'] = "shift";
                $object['wpjobportallt'] = "shifts";
                break;
            case 'ages' : $object['page'] = "age";
                $object['wpjobportallt'] = "ages";
                break;
            case 'careerlevels' : $object['page'] = "careerlevel";
                $object['wpjobportallt'] = "careerlevels";
                break;
            case 'salaryrangetypes' : $object['page'] = "salaryrangetype";
                $object['wpjobportallt'] = "salaryrangetype";
                break;
            case 'currencies' : $object['page'] = "currency";
                $object['wpjobportallt'] = "currency";
                break;
            case 'experiences' : $object['page'] = "experience";
                $object['wpjobportallt'] = "experience";
                break;
            case 'heighesteducation' : $object['page'] = "highesteducation";
                $object['wpjobportallt'] = "highesteducations";
                break;
            case 'categories' : $object['page'] = "category";
                $object['wpjobportallt'] = "categories";
                break;
            case 'subcategories' :
                $object['page'] = "subcategory";
                $categoryid = get_option("wpjobportal_sub_categoryid");
                $object['wpjobportallt'] = "subcategories&categoryid=" . $categoryid;
                break;
            default : $object['page'] = $object['wpjobportallt'] = $for;
                break;
        }
        return $object;
    }

    function savenewinwpjobportal() {
        $data = WPJOBPORTALrequest::get('post');
        $result = WPJOBPORTALincluder::getJSModel('common')->saveNewInWPJOBPORTAL($data);
        if ($data['desired_module'] == 'common' && $data['desired_layout'] == 'newinwpjobportal') {
            if (WPJOBPORTALincluder::getObjectClass('user')->isjobseeker()) {
                $data['desired_module'] = 'job seeker';
            } else {
                $data['desired_module'] = 'employer';
            }
            $data['desired_layout'] = 'controlpanel';
        }
        $url = wpjobportal::makeUrl(array('wpjobportalme'=>$data['desired_module'], 'wpjobportallt'=>$data['desired_layout']));
        $msg = WPJOBPORTALMessages::getMessage($result, 'userrole');
        WPJOBPORTALMessages::setLayoutMessage($msg['message'], $msg['status'],$this->_msgkey);
        wp_redirect($url);
        die();
    }

}

$WPJOBPORTALCommonController = new WPJOBPORTALCommonController;
?>
