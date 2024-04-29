<?php

if (!defined('ABSPATH'))
    die('Restricted Access');

class WPJOBPORTALCompanyController {

    private $_msgkey;

    function __construct() {
        self::handleRequest();
        $this->_msgkey = WPJOBPORTALincluder::getJSModel('company')->getMessagekey();
        $mcompany = WPJOBPORTALincluder::getJSModel('company');
    }

    function handleRequest() {
        $layout = WPJOBPORTALrequest::getLayout('wpjobportallt', null, 'companies');
        $uid = WPJOBPORTALincluder::getObjectClass('user')->uid();
        $mcompany = WPJOBPORTALincluder::getJSModel('company');
        if (self::canaddfile()) {
            $empflag  = WPJOBPORTALincluder::getJSModel('configuration')->getConfigurationByConfigName('disable_employer');
            $string = "'jscontrolpanel','emcontrolpanel','visitor'" ;
            $config_array = WPJOBPORTALincluder::getJSModel('configuration')->getConfigurationByConfigForMultiple($string);
            switch ($layout) {
                case 'admin_companies':
                        WPJOBPORTALincluder::getJSModel('company')->getAllCompanies();
                    break;
                case 'admin_companiesqueue':
                    WPJOBPORTALincluder::getJSModel('company')->getAllUnapprovedCompanies();
                    break;
                case 'mycompanies':
                    try {
                        if (WPJOBPORTALincluder::getObjectClass('user')->isemployer() && $empflag == 1) {
                            WPJOBPORTALincluder::getJSModel('company')->getMyCompanies($uid);
                        } else {
                            wpjobportal::$_common->validateEmployerArea();
                        }

                    } catch (Exception $ex) {
                        wpjobportal::$_error_flag = true;
                        wpjobportal::$_error_flag_message = $ex->getMessage();
                    }

                    break;
                case 'admin_formcompany':
                    try {
                        if (wpjobportal::$_common->wpjp_isadmin() || (WPJOBPORTALincluder::getObjectClass('user')->isemployer() && $empflag == 1)) {
                        $id = WPJOBPORTALrequest::getVar('wpjobportalid');
                            if($id == ''){
                                $check = true;
                            }else{
                                if(!wpjobportal::$_common->wpjp_isadmin()){
                                    $check = WPJOBPORTALincluder::getJSModel('company')->getIfCompanyOwner($id);// so only owner can edit company
                                }
                            }
                            if (wpjobportal::$_common->wpjp_isadmin() || $check == true) {
                                WPJOBPORTALincluder::getJSModel('company')->getCompanybyId($id);
                            }elseif($id != ''){
                                wpjobportal::$_error_flag_message_for=10;//companies
                                throw new Exception(WPJOBPORTALLayout::setMessageFor(10));

                            }
                        } else {
                            if (WPJOBPORTALincluder::getObjectClass('user')->isjobseeker()) {
                                wpjobportal::$_error_flag_message_for=2;
                                throw new Exception(WPJOBPORTALLayout::setMessageFor(2,null,null,1));

                            } elseif (WPJOBPORTALincluder::getObjectClass('user')->isguest()) {
                                $link = wpjobportal::$_common->jsMakeRedirectURL('company', $layout, 1);
                                $linktext = __('Login','wp-job-portal');
                                wpjobportal::$_error_flag_message_for=1;
                                wpjobportal::$_error_flag_message_register_for=2;
                                throw new Exception(WPJOBPORTALLayout::setMessageFor(1 , $link , $linktext,1));

                            } elseif (!WPJOBPORTALincluder::getObjectClass('user')->isWPJOBPortalUser()) {
                                $link = wpjobportal::makeUrl(array('wpjobportalme'=>'common', 'wpjobportallt'=>'newinwpjobportal'));
                                $linktext = __('Select role','wp-job-portal');
                                wpjobportal::$_error_flag_message_for=9;
                                throw new Exception(WPJOBPORTALLayout::setMessageFor(9 , $link , $linktext,1));

                            }
                        }
                        if(isset($link) && isset($linktext)){
                            wpjobportal::$_error_flag_message_for_link=$link;
                            wpjobportal::$_error_flag_message_for_link_text=$linktext;
                        }

                    } catch (Exception $ex) {
                        wpjobportal::$_error_flag = true;
                        wpjobportal::$_error_flag_message=$ex->getMessage();
                    }
                    break;
                case 'addcompany':
                    try {
                         if (WPJOBPORTALincluder::getObjectClass('user')->isemployer() && $empflag == 1) {
                            $id = WPJOBPORTALrequest::getVar('wpjobportalid');
                            $actionname = 'company';
                            if($id == ''){
                                 if(in_array('credits',wpjobportal::$_active_addons)){
                                    // Filter Package For Controller
                                    if(WPJOBPORTALincluder::getJSModel('company')->userCanAddCompany($uid) == true){
                                        $data = json_decode(apply_filters('wpjobportal_addons_available_package',false,'company','company','canAddCompany'));
                                        $check = $data->check;
                                    }else{
                                         wpjobportal::$_common->getMessagesForAddMore('Company');
                                    }
                                    if($check == true){
                                        if(isset($data->layout) && $data->layout == "packageselection" ){
                                            $layout = $data->layout;
                                            $module = 'package';
                                        }
                                   }else{
                                        wpjobportal::$_common->getBuyErrMsg();
                                   }
                                }else{
                                    if(WPJOBPORTALincluder::getJSModel('company')->canAddCompany($uid) == false){
                                        wpjobportal::$_common->getMessagesForAddMore('Company');
                                    }else{
                                        $check =  true;
                                    }
                                }
                            }else{
                                if(!wpjobportal::$_common->wpjp_isadmin()){
                                    $check = WPJOBPORTALincluder::getJSModel('company')->getIfCompanyOwner($id);// so only owner can edit company
                                }
                            }
                            if (wpjobportal::$_common->wpjp_isadmin() || $check == true) {
                                WPJOBPORTALincluder::getJSModel('company')->getCompanybyId($id);
                            }elseif($id != ''){
                                wpjobportal::$_error_flag = true;
                                wpjobportal::$_error_flag_message_for=10;
                                $link = 10;
                                throw new Exception( WPJOBPORTALLayout::setMessageFor(10));

                            } else {
                                wpjobportal::$_common->getBuyErrMsg();
                            }
                        } else {
                            wpjobportal::$_common->validateEmployerArea();
                        }
                        if(isset($link) && isset($linktext)){
                            wpjobportal::$_error_flag_message_for_link=$link;
                            wpjobportal::$_error_flag_message_for_link_text=$linktext;
                        }

                    } catch (Exception $ex) {
                         wpjobportal::$_error_flag = true;
                         wpjobportal::$_error_flag_message = $ex->getMessage();
                    }

                    break;
                case 'admin_view_company':
                    try {
                        if (WPJOBPORTALincluder::getObjectClass('user')->isguest() && $config_array['visitorview_emp_viewcompany'] != 1) {
                            $link = wpjobportal::$_common->jsMakeRedirectURL('company', $layout, 1);
                            $linktext = __('Login','wp-job-portal');
                            wpjobportal::$_error_flag_message_for=1;
                            wpjobportal::$_error_flag_message_register_for=2;
                            throw new Exception(WPJOBPORTALLayout::setMessageFor(1 , $link , $linktext,1));

                        } elseif (!WPJOBPORTALincluder::getObjectClass('user')->isWPJOBPortalUser() && $config_array['visitorview_emp_viewcompany'] != 1) {
                            $link = wpjobportal::makeUrl(array('wpjobportalme'=>'common', 'wpjobportallt'=>'newinwpjobportal'));
                            $linktext = __('Select role','wp-job-portal');
                            wpjobportal::$_error_flag_message_for=9;
                            wpjobportal::$_error_flag_message_register_for=2;
                            throw new Exception(WPJOBPORTALLayout::setMessageFor(9 , $link , $linktext,1));

                        } else {
                            $id = WPJOBPORTALrequest::getVar('wpjobportalid');
                            $id = wpjobportal::$_common->parseID($id);
                            $expiryflag = WPJOBPORTALincluder::getJSModel('company')->getCompanyExpiryStatus($id);
                                if (WPJOBPORTALincluder::getObjectClass('user')->isemployer()) {
                                    if (WPJOBPORTALincluder::getJSModel('company')->getIfCompanyOwner($id)) {
                                        $expiryflag = true;
                                    }
                                }
                                if ($expiryflag == false) {
                                    wpjobportal::$_error_flag_message_for=6;
                                    throw new Exception(WPJOBPORTALLayout::setMessageFor(6,null,null,1));

                                } else {
                                   //echo "Company Perlisting On Contact Detail OF Company";
                                    wpjobportal::$_common->validateEmployerArea();
                                    WPJOBPORTALincluder::getJSModel('company')->getCompanybyIdForView($id);
                                    }
                                }
                            if(isset($link) && isset($linktext)){
                                wpjobportal::$_error_flag_message_for_link=$link;
                                wpjobportal::$_error_flag_message_for_link_text=$linktext;
                            }
                    } catch (Exception $ex) {
                        wpjobportal::$_error_flag = true;
                        wpjobportal::$_error_flag_message = $ex->getMessage();
                    }
                    break;
                case 'viewcompany':
                    try {
                        if (WPJOBPORTALincluder::getObjectClass('user')->isguest() && $config_array['visitorview_emp_viewcompany'] != 1) {
                            $link = wpjobportal::$_common->jsMakeRedirectURL('company', $layout, 1);
                            $linktext = __('Login','wp-job-portal');
                            wpjobportal::$_error_flag_message_for=1;
                            wpjobportal::$_error_flag_message_register_for=2;
                            throw new Exception(WPJOBPORTALLayout::setMessageFor(1 , $link , $linktext,1));

                        } elseif (!WPJOBPORTALincluder::getObjectClass('user')->isWPJOBPortalUser() && $config_array['visitorview_emp_viewcompany'] != 1) {
                            $link = wpjobportal::makeUrl(array('wpjobportalme'=>'common', 'wpjobportallt'=>'newinwpjobportal'));
                            $linktext = __('Select role','wp-job-portal');
                            wpjobportal::$_error_flag_message_for=9;
                            wpjobportal::$_error_flag_message_register_for=2;
                            throw new Exception(WPJOBPORTALLayout::setMessageFor(9 , $link , $linktext,1));

                        } else {
                            $id = WPJOBPORTALrequest::getVar('wpjobportalid');
                            $id = wpjobportal::$_common->parseID($id);
                            $expiryflag = WPJOBPORTALincluder::getJSModel('company')->getCompanyExpiryStatus($id);
                            if (WPJOBPORTALincluder::getObjectClass('user')->isemployer()) {
                                if (WPJOBPORTALincluder::getJSModel('company')->getIfCompanyOwner($id)) {
                                    $expiryflag = true;
                                }
                            }
                            if ($expiryflag == false) {
                                wpjobportal::$_error_flag_message = WPJOBPORTALLayout::setMessageFor(6,null,null,1);
                                wpjobportal::$_error_flag_message_for=6;
                                wpjobportal::$_error_flag = true;
                            } else {
                                WPJOBPORTALincluder::getJSModel('company')->getCompanybyIdForView($id);
                            }
                        }
                        if(isset($link) && isset($linktext)){
                            wpjobportal::$_error_flag_message_for_link=$link;
                            wpjobportal::$_error_flag_message_for_link_text=$linktext;
                        }

                    } catch (Exception $ex) {
                        wpjobportal::$_error_flag = true;
                        wpjobportal::$_error_flag_message = $ex->getMessage();
                    }
                    break;
            }
            if ($empflag == 0) {
                WPJOBPORTALLayout::setMessageFor(5);
                wpjobportal::$_error_flag_message_for=5;
                wpjobportal::$_error_flag = true;
            }

            if(!isset($module)){
                $module = (wpjobportal::$_common->wpjp_isadmin()) ? 'page' : 'wpjobportalme';
                $module = WPJOBPORTALrequest::getVar($module, null, 'company');
            }
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

    function approveQueueCompany() {
        if(!wpjobportal::$_common->wpjp_isadmin())
            return false;
        $id = WPJOBPORTALrequest::getVar('id');
        $result = WPJOBPORTALincluder::getJSModel('company')->approveQueueCompanyModel($id);
        $msg = WPJOBPORTALMessages::getMessage($result, 'company');
        WPJOBPORTALMessages::setLayoutMessage($msg['message'], $msg['status'],$this->_msgkey);
        $url = admin_url("admin.php?page=wpjobportal_company&wpjobportallt=companiesqueue");
        wp_redirect($url);
        die();
    }

    function approveQueueFeaturedCompany() {
        if(!wpjobportal::$_common->wpjp_isadmin())
            return false;
        $id = WPJOBPORTALrequest::getVar('id');
        $result = WPJOBPORTALincluder::getJSModel('company')->approveQueueFeaturedCompanyModel($id);
        $msg = WPJOBPORTALMessages::getMessage($result, 'company');
        WPJOBPORTALMessages::setLayoutMessage($msg['message'], $msg['status'],$this->_msgkey);
        $url = admin_url("admin.php?page=wpjobportal_company&wpjobportallt=companiesqueue");
        wp_redirect($url);
        die();
    }

    function rejectQueueCompany() {
        if(!wpjobportal::$_common->wpjp_isadmin())
            return false;
        $id = WPJOBPORTALrequest::getVar('id');
        $result = WPJOBPORTALincluder::getJSModel('company')->rejectQueueCompanyModel($id);
        $msg = WPJOBPORTALMessages::getMessage($result, 'company');
        WPJOBPORTALMessages::setLayoutMessage($msg['message'], $msg['status'],$this->_msgkey);
        $url = admin_url("admin.php?page=wpjobportal_company&wpjobportallt=companiesqueue");
        wp_redirect($url);
        die();
    }

    function rejectQueueFeatureCompany() {
        if(!wpjobportal::$_common->wpjp_isadmin())
            return false;
        $id = WPJOBPORTALrequest::getVar('id');
        $result = WPJOBPORTALincluder::getJSModel('company')->rejectQueueFeatureCompanyModel($id);
        $msg = WPJOBPORTALMessages::getMessage($result, 'company');
        WPJOBPORTALMessages::setLayoutMessage($msg['message'], $msg['status'],$this->_msgkey);
        $url = admin_url("admin.php?page=wpjobportal_company&wpjobportallt=companiesqueue");
        wp_redirect($url);
        die();
    }

    function approveQueueAllCompanies() {
        if(!wpjobportal::$_common->wpjp_isadmin())
            return false;
        $id = WPJOBPORTALrequest::getVar('id');
        $alltype = WPJOBPORTALrequest::getVar('objid');
        $result = WPJOBPORTALincluder::getJSModel('company')->approveQueueAllCompaniesModel($id, $alltype);
        $msg = WPJOBPORTALMessages::getMessage($result, 'company');
        WPJOBPORTALMessages::setLayoutMessage($msg['message'], $msg['status'],$this->_msgkey);
        $url = admin_url("admin.php?page=wpjobportal_company&wpjobportallt=companiesqueue");
        wp_redirect($url);
        die();
    }

    function rejectQueueAllCompanies() {
        if(!wpjobportal::$_common->wpjp_isadmin())
            return false;
        $id = WPJOBPORTALrequest::getVar('id');
        $alltype = WPJOBPORTALrequest::getVar('objid');
        $result = WPJOBPORTALincluder::getJSModel('company')->rejectQueueAllCompaniesModel($id, $alltype);
        $msg = WPJOBPORTALMessages::getMessage($result, 'company');
        WPJOBPORTALMessages::setLayoutMessage($msg['message'], $msg['status'],$this->_msgkey);
        $url = admin_url("admin.php?page=wpjobportal_company&wpjobportallt=companiesqueue");
        wp_redirect($url);
        die();
    }

    function savecompany() {
        try{
            //requesting parameters
            $mcompany = WPJOBPORTALincluder::getJSModel('company');
            $data = WPJOBPORTALrequest::get('post');
            $companyid = (int) $data['id'];
            $uid = WPJOBPORTALincluder::getObjectClass('user')->uid();

            $isnew = !$companyid;
            if(!wpjobportal::$_common->wpjp_isadmin()){
                if(!$isnew && !$mcompany->getIfCompanyOwner($companyid)){
                    throw new Exception(WPJOBPORTAL_SAVE_ERROR, WPJOBPORTAL_COMPANY);
                }
                if($isnew && !$mcompany->userCanAddCompany($uid)){
                    throw new Exception(WPJOBPORTAL_SAVE_ERROR, WPJOBPORTAL_COMPANY);
                }
            }
            $companyid = $mcompany->storeCompany($data);
            if(!$companyid){
                throw new Exception(WPJOBPORTAL_SAVE_ERROR, WPJOBPORTAL_COMPANY);
            }

            $msg = WPJOBPORTALMessages::getMessage(WPJOBPORTAL_SAVED, WPJOBPORTAL_COMPANY);
            WPJOBPORTALMessages::setLayoutMessage($msg['message'], $msg['status'],$this->_msgkey);
            $redirecturl = wpjobportal::redirectUrl('company.success',isset(wpjobportal::$_data['id']) ? wpjobportal::$_data['id'] : '');

        }catch(Exception $ex){
            $msg = WPJOBPORTALMessages::getMessage($ex->getMessage(), $ex->getCode());
            WPJOBPORTALMessages::setLayoutMessage($msg['message'], $msg['status'],$this->_msgkey);
            $redirecturl = wpjobportal::redirectUrl('company.fail');
        }
        wp_redirect($redirecturl);
        die();
    }

    function enforcedelete() {

        $nonce = WPJOBPORTALrequest::getVar('_wpnonce');
        if (! wp_verify_nonce( $nonce, 'delete-company') ) {
             die( 'Security check Failed' );
        }
        $companyid = WPJOBPORTALrequest::getVar('id');
        $callfrom = WPJOBPORTALrequest::getVar('callfrom');

        $result = WPJOBPORTALincluder::getJSModel('company')->companyEnforceDeletes($companyid);
        $msg = WPJOBPORTALMessages::getMessage($result, 'company');
        WPJOBPORTALMessages::setLayoutMessage($msg['message'], $msg['status'],$this->_msgkey);
        if ($callfrom == 1) {
            $url = admin_url("admin.php?page=wpjobportal_company&wpjobportallt=companies");
        } else {
            $url = admin_url("admin.php?page=wpjobportal_company&wpjobportallt=companiesqueue");
        }
        wp_redirect($url);
        die();
    }

    function remove() {
        $nonce = WPJOBPORTALrequest::getVar('_wpnonce');
        if (! wp_verify_nonce( $nonce, 'delete-company') ) {
             die( 'Security check Failed' );
        }
        $data = WPJOBPORTALrequest::get('post');
        if (!isset($data['callfrom']) || $data['callfrom'] == null) {
            $data['callfrom'] = $callfrom = WPJOBPORTALrequest::getVar('callfrom');
        }
        $ids = WPJOBPORTALrequest::getVar('wpjobportal-cb');
        $result = WPJOBPORTALincluder::getJSModel('company')->deleteCompanies($ids);
        $msg = WPJOBPORTALMessages::getMessage($result, 'company');
        WPJOBPORTALMessages::setLayoutMessage($msg['message'], $msg['status'],$this->_msgkey);
        if (wpjobportal::$_common->wpjp_isadmin()) {
            if ($data['callfrom'] == 1) {
                $url = admin_url("admin.php?page=wpjobportal_company&wpjobportallt=companies");
            } elseif ($data['callfrom'] == 2) {
                $url = admin_url("admin.php?page=wpjobportal_company&wpjobportallt=companiesqueue");
            }
        } else {
            $url = wpjobportal::makeUrl(array('wpjobportalme'=>'company', 'wpjobportallt'=>'mycompanies','wpjobportalpageid'=>wpjobportal::getPageid()));
        }
        wp_redirect($url);
        die();
    }

    function addviewcontactdetail() {
        $id = WPJOBPORTALrequest::getVar('companyid');
        $uid = WPJOBPORTALincluder::getObjectClass('user')->uid();
        WPJOBPORTALincluder::getJSModel('company')->addViewContactDetail($id, $uid);
        $url = wpjobportal::makeUrl(array('wpjobportalme'=>'company', 'wpjobportallt'=>'viewcompany', 'wpjobportalid'=>$id,'wpjobportalpageid'=>wpjobportal::getPageid()));
        wp_redirect($url);
        die();
    }
}

$WPJOBPORTALCompanyController = new WPJOBPORTALCompanyController();
?>
