<?php

if (!defined('ABSPATH'))
    die('Restricted Access');

class WPJOBPORTALpostinstallationController {

    function __construct() {

        self::handleRequest();
    }

    function handleRequest() {
        $layout = WPJOBPORTALrequest::getLayout('wpjobportallt', null, 'stepone');
        if($this->canaddfile()){
            switch ($layout) {
                case 'admin_stepone':
                    WPJOBPORTALincluder::getJSModel('postinstallation')->getConfigurationValues();
					WPJOBPORTALincluder::getJSModel('postinstallation')->addMissingUsers();
                break;
                case 'admin_steptwo':
                    WPJOBPORTALincluder::getJSModel('postinstallation')->getConfigurationValues();
                break;
                case 'admin_stepthree':
                    WPJOBPORTALincluder::getJSModel('postinstallation')->getConfigurationValues();
                break;
                case 'admin_themedemodata':
                    wpjobportal::$_data['flag'] = WPJOBPORTALrequest::getVar('flag');
                break;
                case 'admin_demoimporter':
                    WPJOBPORTALincluder::getJSModel('postinstallation')->getListOfDemoVersions();
                break;
            }
            $module = (wpjobportal::$_common->wpjp_isadmin()) ? 'page' : 'wpjobportalme';
            $module = WPJOBPORTALrequest::getVar($module, null, 'postinstallation');
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

    function save(){
        $data = WPJOBPORTALrequest::get('post');
        $url = admin_url("admin.php?page=wpjobportal_postinstallation&wpjobportallt=steptwo");
        $result = WPJOBPORTALincluder::getJSModel('postinstallation')->storeconfigurations($data);
        if($data['step'] == 2){
            $url = admin_url("admin.php?page=wpjobportal_postinstallation&wpjobportallt=stepthree");
        }
        if($data['step'] == 3){
            $url = admin_url("admin.php?page=wpjobportal_postinstallation&wpjobportallt=stepfour");
        }
        wp_redirect($url);
        exit();
    }

    function savesampledata(){
        $data = WPJOBPORTALrequest::get('post');
        $sampledata = $data['sampledata'];
        $temp_data = 0;
        if(isset($data['temp_data'])){
            $temp_data = 1;
            $jsmenu = 0;
            $empmenu = 0;
        }else{
            $jsmenu = $data['jsmenu'];
            $empmenu = $data['empmenu'];
        }
        if(wpjobportal::$theme_chk == 1){
            update_option( 'wpjobportal_jobs_sample_data', 1 ); // flag to messge that jobs data has been inserted.
            $url = admin_url("admin.php?page=wpjobportal_postinstallation&wpjobportallt=demoimporter");
        }else{
            $url = admin_url("admin.php?page=wpjobportal");
        }
        $result = WPJOBPORTALincluder::getJSModel('postinstallation')->installSampleData($sampledata,$jsmenu,$empmenu,$temp_data);
        wp_redirect($url);
        exit();
    }

    function savetemplatesampledata(){
        $flag = WPJOBPORTALrequest::getVar('flag');
        $result = WPJOBPORTALincluder::getJSModel('postinstallation')->installSampleDataTemplate($flag);
        $url = admin_url("admin.php?page=wpjobportal_postinstallation&wpjobportallt=themedemodata&flag=".$result);
        wp_redirect($url);
        exit();
    }

    function importtemplatesampledata(){
        $flag = WPJOBPORTALrequest::getVar('flag','',0);// zero as default value to avoid problems
        if($flag == 'f'){
            $result = WPJOBPORTALincluder::getJSModel('postinstallation')->importTemplateSampleData($flag);
        }else{
            $result = 0;
        }
        $url = admin_url("admin.php?page=wpjobportal_postinstallation&wpjobportallt=themedemodata&flag=".$result);
        wp_redirect($url);
        exit();
    }

    function getdemocode(){
        $demoid = WPJOBPORTALrequest::getVar('demoid');
        $foldername = WPJOBPORTALrequest::getVar('foldername');
        $demo_overwrite = WPJOBPORTALrequest::getVar('demo_overwrite');
        $result = WPJOBPORTALincluder::getJSModel('postinstallation')->getDemo($demoid,$foldername,$demo_overwrite);
        $url = admin_url("admin.php?page=wpjobportal");
        wp_redirect($url);
        exit();
    }

    function importfreetoprotemplatedata(){
        if(wpjobportal::$theme_chk == 1){// 1 for job manager
            $result = WPJOBPORTALincluder::getJSModel('postinstallation')->installFreeToProData();
        }else{
            $result = WPJOBPORTALincluder::getJSModel('postinstallation')->installFreeToProDataJobHub();
        }
        $url = admin_url("admin.php?page=wpjobportal");
        wp_redirect($url);
        exit();
    }
}
$WPJOBPORTALpostinstallationController = new WPJOBPORTALpostinstallationController();
?>
