<?php

if (!defined('ABSPATH'))
    die('Restricted Access');

class WPJOBPORTALUserController {

    private $_msgkey;

    function __construct() {

        self::handleRequest();

        $this->_msgkey = WPJOBPORTALincluder::getJSModel('user')->getMessagekey();
    }

    function handleRequest() {
        $layout = WPJOBPORTALrequest::getLayout('wpjobportallt', null, 'users');
        if (self::canaddfile()) {
            switch ($layout) {
                case 'admin_users':
                    WPJOBPORTALincluder::getJSModel('user')->getAllUsers();
                    break;
                case 'admin_changerole':
                    $id = WPJOBPORTALrequest::getVar('wpjobportalid');
                    WPJOBPORTALincluder::getJSModel('user')->getChangeRolebyId($id);
                    break;
                case 'admin_userdetail':
                    $id = WPJOBPORTALrequest::getVar('id');
                    WPJOBPORTALincluder::getJSModel('user')->getUserData($id);
                    break;
                case 'admin_userstate_companies':
                    $companyuid = WPJOBPORTALrequest::getVar('md');
                    $result = WPJOBPORTALincluder::getJSModel('user')->getUserStatsCompanies($companyuid);
                    break;
                case 'formprofile':
                    if( WPJOBPORTALincluder::getObjectClass('user')->isguest() ){
                        $link = WPJOBPORTALincluder::getJSModel('common')->jsMakeRedirectURL('employer', $layout, 1);
                        $linktext = __('Login','wp-job-portal');
                        wpjobportal::$_error_flag_message_for = 1;
                        wpjobportal::$_error_flag_message = WPJOBPORTALLayout::setMessageFor(1 , $link , $linktext,1);
                        // wpjobportal::$_error_flag_message = WPJOBPORTAL_GUEST;
                    }else{
                        $id = WPJOBPORTALincluder::getObjectClass('user')->uid();
                        WPJOBPORTALincluder::getJSModel('user')->getUserForForm($id);
                    }
                    break;
                case 'regemployer':
                case 'regjobseeker':
                case 'userregister':
                    $allow_reg_as_emp = wpjobportal::$_config->getConfigurationByConfigName('showemployerlink');
                    $cpfrom = 0;
                    if($layout!="userregister"){
                        if ($layout == 'regemployer') {
                            if ($allow_reg_as_emp == 1) {
                                $cpfrom = 1;
                            } else {
                                $cpfrom = 2;
                            }
                        } else {
                            $cpfrom = 2;
                        }
                        $_SESSION['js_cpfrom'] = $cpfrom;
                        $layout = 'userregister';
                    }

                    $layout = 'userregister';
                    if($cpfrom != 0){
                        $_SESSION['js_cpfrom'] = $cpfrom;
                    }

                    break;
            }
            $module = (wpjobportal::$_common->wpjp_isadmin()) ? 'page' : 'wpjobportalme';
            $module = WPJOBPORTALrequest::getVar($module, null, 'user');
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

    function saveuserrole() {
        $data = WPJOBPORTALrequest::get('post');
        $result = WPJOBPORTALincluder::getJSModel('user')->storeUserRole($data);
        $msg = WPJOBPORTALMessages::getMessage($result, 'userrole');
        $url = admin_url("admin.php?page=wpjobportal_user&wpjobportallt=users");
        WPJOBPORTALMessages::setLayoutMessage($msg['message'], $msg['status'],$this->_msgkey);
        wp_redirect($url);
        die();
    }

     function saveuser() {
        $nonce = WPJOBPORTALrequest::getVar('_wpnonce');
        if(! wp_verify_nonce( $nonce, 'store-user') ) {
             die( 'Security check Failed' );
        }
        $data = WPJOBPORTALrequest::get('post');
        if( !wpjobportal::$_common->wpjp_isadmin() ){
            $data['id'] = WPJOBPORTALincluder::getObjectClass('user')->uid();
        }
        $result = WPJOBPORTALincluder::getJSModel('user')->storeUser($data);
        if( wpjobportal::$_common->wpjp_isadmin() ){
            $msg = WPJOBPORTALmessages::getMessage($result, 'user');
            WPJOBPORTALmessages::setLayoutMessage($msg['message'], $msg['status'],$this->_msgkey);
            $url = admin_url("admin.php?page=wpjobportal_user&wpjobportallt=users");
        }else{
            if (WPJOBPORTALincluder::getObjectClass('user')->isemployer()) {
                $userrole = 1;
                $url = wpjobportal::makeUrl(array('wpjobportalme'=>'employer', 'wpjobportallt'=>'controlpanel',"wpjobportalpageid"=>wpjobportal::getPageid()));
                $usermsgrole = "employer";
            } elseif (WPJOBPORTALincluder::getObjectClass('user')->isjobseeker()) {
                $userrole = 2;
                $url = wpjobportal::makeUrl(array('wpjobportalme'=>'jobseeker', 'wpjobportallt'=>'controlpanel',"wpjobportalpageid"=>wpjobportal::getPageid()));
                $usermsgrole = "jobseeker";
            }
            $msg = WPJOBPORTALmessages::getMessage($result, $usermsgrole);
            WPJOBPORTALmessages::setLayoutMessage($msg['message'], $msg['status'],WPJOBPORTALincluder::getJSModel($usermsgrole)->getMessagekey());
        }
        wp_redirect($url);
        die();
    }

    function assignuserrole() {
        $data = WPJOBPORTALrequest::get('post');
        $result = WPJOBPORTALincluder::getJSModel('user')->assignUserRole($data);
        $msg = WPJOBPORTALMessages::getMessage($result, 'userrole');
        $url = admin_url("admin.php?page=wpjobportal_user&wpjobportallt=users");
        WPJOBPORTALMessages::setLayoutMessage($msg['message'], $msg['status'],$this->_msgkey);
        wp_redirect($url);
        die();
    }

    function changeuserstatus() {
        $userid = WPJOBPORTALrequest::getVar('wpjobportalid');
        $result = WPJOBPORTALincluder::getJSModel('user')->changeUserStatus($userid);
        $msg = WPJOBPORTALMessages::getMessage($result, 'user');
        WPJOBPORTALMessages::setLayoutMessage($msg['message'], $msg['status'],$this->_msgkey);
        $detail = WPJOBPORTALrequest::getVar('detail');
        if($detail == 1){
            $url = admin_url('admin.php?page=wpjobportal_user&wpjobportallt=userdetail&id='.$userid);
        }else{
            $url = admin_url('admin.php?page=wpjobportal_user&wpjobportallt=users');
        }
        wp_redirect($url);
        die();
    }

    function deleteuser() {
        $userid = WPJOBPORTALrequest::getVar('wpjobportalid');
        $result = WPJOBPORTALincluder::getJSModel('user')->deleteUser($userid);
        $msg = WPJOBPORTALMessages::getMessage($result, 'user');
        WPJOBPORTALMessages::setLayoutMessage($msg['message'], $msg['status'],$this->_msgkey);
        $url = admin_url('admin.php?page=wpjobportal_user&wpjobportallt=users');
        wp_redirect($url);
        die();
    }

    function enforcedeleteuser() {
        $userid = WPJOBPORTALrequest::getVar('wpjobportalid');
        $result = WPJOBPORTALincluder::getJSModel('user')->enforceDeleteUser($userid);
        //var_dump($result); die();
        $msg = WPJOBPORTALMessages::getMessage($result, 'user');
        WPJOBPORTALMessages::setLayoutMessage($msg['message'], $msg['status'],$this->_msgkey);
        $url = admin_url('admin.php?page=wpjobportal_user&wpjobportallt=users');
        wp_redirect($url);
        die();
    }

}

$WPJOBPORTALUserController = new WPJOBPORTALUserController();
?>
