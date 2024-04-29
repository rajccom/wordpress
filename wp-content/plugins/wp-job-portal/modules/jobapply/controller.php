<?php

if (!defined('ABSPATH'))
    die('Restricted Access');

class WPJOBPORTALJobapplyController {

    private $_msgkey;

    function __construct() {

        self::handleRequest();

        $this->_msgkey = WPJOBPORTALincluder::getJSModel('jobapply')->getMessagekey();
    }

    function handleRequest() {
        $layout = WPJOBPORTALrequest::getLayout('wpjobportallt', null, 'appliedresumes');
        if (self::canaddfile()) {
            switch ($layout) {
                case 'admin_appliedresumes':
                    WPJOBPORTALincluder::getJSModel('jobapply')->getAppliedResume();
                    break;
                case 'myappliedjobs':
                    try {
                        $conflag = wpjobportal::$_config->getConfigurationByConfigName('myappliedjobs');
                        if (WPJOBPORTALincluder::getObjectClass('user')->isjobseeker()) {
                            $uid = WPJOBPORTALincluder::getObjectClass('user')->uid();
                            WPJOBPORTALincluder::getJSModel('jobapply')->getMyAppliedJobs($uid);
                            // to handle jobseeker left menu data
                            WPJOBPORTALincluder::getJSModel('jobseeker')->getResumeInfoForJobSeekerLeftMenu($uid);
                        } else {
                            if (WPJOBPORTALincluder::getObjectClass('user')->isemployer()) {
                                wpjobportal::$_error_flag_message_for=3;
                                throw new Exception(WPJOBPORTALLayout::setMessageFor(3,null,null,1));

                            } elseif (WPJOBPORTALincluder::getObjectClass('user')->isguest()) {
                                $link = wpjobportal::$_common->jsMakeRedirectURL('jobapply', $layout, 1);
                                $linktext = __('Login','wp-job-portal');
                                wpjobportal::$_error_flag_message_for=1;
                                wpjobportal::$_error_flag_message_register_for=1; // register as jobseeker
                                throw new Exception(WPJOBPORTALLayout::setMessageFor(1 , $link , $linktext,1));

                            } elseif (!WPJOBPORTALincluder::getObjectClass('user')->isWPJOBPortalUser()) {
                                $link = wpjobportal::makeUrl(array('wpjobportalme'=>'common', 'wpjobportallt'=>'newinwpjobportal'));
                                $linktext = __('Select role','wp-job-portal');
                                wpjobportal::$_error_flag_message_for=9;
                                throw new Exception(WPJOBPORTALLayout::setMessageFor(9 , $link , $linktext,1));

                            }
                            if(isset($link) && isset($linktext)){
                                wpjobportal::$_error_flag_message_for_link = $link;
                                wpjobportal::$_error_flag_message_for_link_text = $linktext;
                            }
                        }

                    } catch (Exception $ex) {
                        wpjobportal::$_error_flag = true;
                        wpjobportal::$_error_flag_message = $ex->getMessage();
                        if(isset($link) && isset($linktext) && wpjobportal::$theme_chk == 1){
                            wpjobportal::$_error_flag_message_for_link=$link;
                            wpjobportal::$_error_flag_message_for_link_text=$linktext;
                        }


                    }

                    break;
                case 'jobappliedresume':
                case 'admin_jobappliedresume':
                    try {
                        if (WPJOBPORTALincluder::getObjectClass('user')->isemployer() || wpjobportal::$_common->wpjp_isadmin()) {
                            $uid = WPJOBPORTALincluder::getObjectClass('user')->uid();
                            $jobid = WPJOBPORTALrequest::getVar('jobid');
                            $tab_action = WPJOBPORTALrequest::getVar('ta', null, 1);
                            WPJOBPORTALincluder::getJSModel('jobapply')->getJobAppliedResume($tab_action, $jobid, $uid);
                            wpjobportal::$_data['jobid'] = $jobid;
                        } else {
                            if (WPJOBPORTALincluder::getObjectClass('user')->isjobseeker()) {
                                wpjobportal::$_error_flag_message_for=2;
                                throw new Exception(WPJOBPORTALLayout::setMessageFor(2,null,null,1));

                            } elseif (WPJOBPORTALincluder::getObjectClass('user')->isguest()) {
                                $link = wpjobportal::$_common->jsMakeRedirectURL('jobapply', $layout, 1);
                                $linktext = __('Login','wp-job-portal');
                                wpjobportal::$_error_flag_message_for=1;
                                wpjobportal::$_error_flag_message_register_for=2; // register as employer
                                throw new Exception(WPJOBPORTALLayout::setMessageFor(1 , $link , $linktext,1));

                            } elseif (!WPJOBPORTALincluder::getObjectClass('user')->isWPJOBPortalUser()) {
                                $link = wpjobportal::makeUrl(array('wpjobportalme'=>'common', 'wpjobportallt'=>'newinwpjobportal'));
                                $linktext = __('Select role','wp-job-portal');
                                wpjobportal::$_error_flag_message_for=9;
                                throw new Exception(WPJOBPORTALLayout::setMessageFor(9 , $link , $linktext,1));

                            }
                            if(isset($link) && isset($linktext)){
                                wpjobportal::$_error_flag_message_for_link = $link;
                                wpjobportal::$_error_flag_message_for_link_text = $linktext;
                            }
                        }
                    } catch (Exception $ex) {
                        wpjobportal::$_error_flag = true;
                        wpjobportal::$_error_flag_message = $ex->getMessage();
                        if(isset($link) && isset($linktext) && wpjobportal::$theme_chk == 1){
                            wpjobportal::$_error_flag_message_for_link=$link;
                            wpjobportal::$_error_flag_message_for_link_text=$linktext;
                        }
                    }

                    break;

            }
            $module = (wpjobportal::$_common->wpjp_isadmin()) ? 'page' : 'wpjobportalme';
            $module = WPJOBPORTALrequest::getVar($module, null, 'jobapply');
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


    function jobapplyasvisitor() {
        $jobid = WPJOBPORTALrequest::getVar('wpjobportalid-jobid');
        if (!is_numeric($jobid)) { // redirect to jobs page if id is not numeric
            if (wpjobportal::$theme_chk == 1) {
                $url = wpjobportal::makeUrl(array('wpjobportalme'=>'job', 'wpjobportallt'=>'jobs'));
            } else {
                $url = wpjobportal::makeUrl(array('wpjobportalme'=>'job', 'wpjobportallt'=>'jobs'));
            }
        } else {
            wpjobportalphplib::wpJP_setcookie('wpjobportal_apply_visitor' , $jobid , 0 , COOKIEPATH);
            if ( SITECOOKIEPATH != COOKIEPATH ){
                wpjobportalphplib::wpJP_setcookie('wpjobportal_apply_visitor' , $jobid , 0 , SITECOOKIEPATH);
            }
            if (wpjobportal::$theme_chk == 1) {
                $url = wpjobportal::makeUrl(array('wpjobportalme'=>'multiresume', 'wpjobportallt'=>'addresume'));
            } else {
                $url = wpjobportal::makeUrl(array('wpjobportalme'=>'resume', 'wpjobportallt'=>'addresume'));
            }
        }
        wp_redirect($url);
        die();
    }



}

$WPJOBPORTALJobapplyController = new WPJOBPORTALJobapplyController();
?>
