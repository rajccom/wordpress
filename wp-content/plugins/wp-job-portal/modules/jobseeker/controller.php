<?php

if (!defined('ABSPATH'))
    die('Restricted Access');

class WPJOBPORTALJobseekerController {

    function __construct() {

        self::handleRequest();
    }

    function handleRequest() {
        $layout = WPJOBPORTALrequest::getLayout('wpjobportallt', null, 'controlpanel');
        if (self::canaddfile()) {
            switch ($layout) {
                case 'jobseeker_report':
                    break;
                case 'controlpanel':
                    if(get_option( 'wpjobportal_apply_visitor', '' ) != '')
                        delete_option( 'wpjobportal_apply_visitor' );
                    $visitorview_js_controlpanel = wpjobportal::$_config->getConfigurationByConfigName('visitorview_js_controlpanel');
                    try {
                        if ($visitorview_js_controlpanel != 1) {
                            if (WPJOBPORTALincluder::getObjectClass('user')->isguest()) {
                                $link = WPJOBPORTALincluder::getJSModel('common')->jsMakeRedirectURL('jobseeker', $layout, 1);
                                $linktext = __('Login','wp-job-portal');
                                wpjobportal::$_error_flag_message_for=1;
                                wpjobportal::$_error_flag_message_register_for=1; // register as jobseeker
                                throw new Exception(WPJOBPORTALLayout::setMessageFor(1 , $link , $linktext,1));
                            } elseif (!WPJOBPORTALincluder::getObjectClass('user')->isWPJOBPortalUser()) {
                                $link = wpjobportal::makeUrl(array('wpjobportalme'=>'common', 'wpjobportallt'=>'newinwpjobportal',  'wpjobportalpageid'=>wpjobportal::getPageid()));
                                $linktext = __('Select role','wp-job-portal');
                                wpjobportal::$_error_flag_message_for=1;
                                throw new Exception(WPJOBPORTALLayout::setMessageFor(9 , $link , $linktext,1));
                            }
                        }
                        if (WPJOBPORTALincluder::getObjectClass('user')->isemployer()) {
                            $employerview_js_controlpanel = wpjobportal::$_config->getConfigurationByConfigName('employerview_js_controlpanel');
                            if ($employerview_js_controlpanel != 1){
                                wpjobportal::$_error_flag_message_for=7;
                                throw new Exception(WPJOBPORTALLayout::setMessageFor(7,null,null,1));
                            }
                        }
                        if(isset($link) && isset($linktext)){
                            wpjobportal::$_error_flag_message_for_link = $link;
                            wpjobportal::$_error_flag_message_for_link_text = $linktext;
                        }

                    } catch (Exception $ex) {
                        wpjobportal::$_error_flag = true;
                        wpjobportal::$_error_flag_message = $ex->getMessage();
                    }
                    //code for user related jobs
                    $uid = WPJOBPORTALincluder::getObjectClass('user')->uid();
                    WPJOBPORTALincluder::getJSModel('jobseeker')->getResumeStatusByUid($uid);
                    WPJOBPORTALincluder::getJSModel('jobseeker')->getConfigurationForControlPanel();
                    WPJOBPORTALincluder::getJSModel('jobseeker')->getLatestJobs();
                    WPJOBPORTALincluder::getJSModel('jobseeker')->getJobsAppliedRecently($uid);
                    WPJOBPORTALincluder::getJSModel('jobseeker')->getUserinfo($uid);
                    WPJOBPORTALincluder::getJSModel('jobseeker')->getJobsekerResumeTitle($uid);
                    WPJOBPORTALincluder::getJSModel('jobseeker')->getGraphDataNew($uid);
                    if(in_array('credits', wpjobportal::$_active_addons)){
                        WPJOBPORTALincluder::getJSModel('employer')->getDataForDashboard($uid);
                    }
                    // data in this function also prepared above but casues issue on other layouts where left menu is added so changed it
                    WPJOBPORTALincluder::getJSModel('jobseeker')->getResumeInfoForJobSeekerLeftMenu($uid);
                break;
            }
            $module = (wpjobportal::$_common->wpjp_isadmin()) ? 'page' : 'wpjobportalme';
            $module = WPJOBPORTALrequest::getVar($module, null, 'jobseeker');
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

}

$WPJOBPORTALJobseekerController = new WPJOBPORTALJobseekerController();
?>
