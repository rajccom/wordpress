<?php

if (!defined('ABSPATH'))
    die('Restricted Access');

class WPJOBPORTALJobController {

    private $_msgkey;

    function __construct() {

        self::handleRequest();
        $this->_msgkey = WPJOBPORTALincluder::getJSModel('job')->getMessagekey();

     }

    function handleRequest() {
        $layout = WPJOBPORTALrequest::getLayout('wpjobportallt', null, 'jobs');
        $uid = WPJOBPORTALincluder::getObjectClass('user')->uid();
        $wpjpjob = WPJOBPORTALincluder::getJSModel('job');
        if (self::canaddfile()) {
            $empflag  = wpjobportal::$_config->getConfigurationByConfigName('disable_employer');
            $string = "'jscontrolpanel','emcontrolpanel','visitor'" ;
            $config_array = wpjobportal::$_config->getConfigurationByConfigForMultiple($string);
            switch ($layout) {
                case 'myjobs':
                    try {
                        if (WPJOBPORTALincluder::getObjectClass('user')->isemployer() && $empflag == 1) {
                            $wpjpjob->getMyJobs($uid);
                        } else {
                            wpjobportal::$_common->validateEmployerArea();
                            wpjobportal::$_error_flag = true;
                            if (WPJOBPORTALincluder::getObjectClass('user')->isguest()) {
                                $linktext = __('Login','wp-job-portal');
                                $link = wpjobportal::$_common->jsMakeRedirectURL('job', $layout, 1);
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
                case 'jobs':
                case 'newestjobs':
                    $flag = true;
                    $search = WPJOBPORTALrequest::getVar('issearchform', 'post');
                    $companyid = WPJOBPORTALrequest::getVar('companyid', 'get');
                    $jobtypeid = WPJOBPORTALrequest::getVar('jobtype', 'get');
                    $categoryid = WPJOBPORTALrequest::getVar('category', 'get');
                    $wpjobportalid = WPJOBPORTALrequest::getVar('wpjobportalid', 'get');
                    $wpjobportalid = wpjobportal::$_common->parseID($wpjobportalid);
                    if ($categoryid != null) {
                        if(WPJOBPORTALincluder::getObjectClass('user')->isguest() && $config_array['visitorview_js_jobcat'] != 1){
                            $flag = 2;
                        }
                        if(!WPJOBPORTALincluder::getObjectClass('user')->isWPJOBPortalUser() && $config_array['visitorview_js_jobcat'] != 1){
                            $flag = 3;
                        }
                    }elseif(WPJOBPORTALincluder::getObjectClass('user')->isguest() && $config_array['visitorview_js_newestjobs'] != 1) {
                        $flag = 2;
                    }elseif(!WPJOBPORTALincluder::getObjectClass('user')->isWPJOBPortalUser() && $config_array['visitorview_js_newestjobs'] != 1) {
                        $flag = 3;
                    } elseif (WPJOBPORTALincluder::getObjectClass('user')->isguest() && $config_array['visitorview_js_jobsearchresult'] != 1 && $search != null) {
                        $flag = 2;
                    } elseif (!WPJOBPORTALincluder::getObjectClass('user')->isWPJOBPortalUser() && $config_array['visitorview_js_jobsearchresult'] != 1 && $search != null) {
                        $flag = 3;
                    }
                    if ($flag === true) {
                        $vars = $wpjpjob->getjobsvar();
                        $wpjpjob->getJobs($vars);
                        wpjobportal::$_data['vars'] = $vars;
                        $issearchform = WPJOBPORTALrequest::getVar('issearchform', 'post', null);
                        if ($issearchform != null) {
                            wpjobportal::$_data['issearchform'] = $issearchform;
                        }
                    }elseif($flag === 2){
                        $link = wpjobportal::$_common->jsMakeRedirectURL('job', $layout, 1);
                        $linktext = __('Login','wp-job-portal');
                        wpjobportal::$_error_flag_message = WPJOBPORTALLayout::setMessageFor(1 , $link , $linktext,1);
                        wpjobportal::$_error_flag_message_for=1; // user is guest
                        wpjobportal::$_error_flag_message_register_for=1; // register as jobseeker
                        wpjobportal::$_error_flag = true;
                    }elseif($flag === 3){
                        $link = wpjobportal::makeUrl(array('wpjobportalme'=>'common', 'wpjobportallt'=>'newinwpjobportal'));
                        $linktext = __('Select role','wp-job-portal');
                        wpjobportal::$_error_flag_message = WPJOBPORTALLayout::setMessageFor(9 , $link , $linktext,1);
                        wpjobportal::$_error_flag_message_for=9;
                        wpjobportal::$_error_flag = true;
                    }elseif($flag === 4){
                        wpjobportal::$_error_flag_message = WPJOBPORTALLayout::setMessageFor(2 , null , null,1);
                        wpjobportal::$_error_flag_message_for=2;
                        wpjobportal::$_error_flag = true;
                    }
                    if(isset($link) && isset($linktext)){
                        wpjobportal::$_error_flag_message_for_link = $link;
                        wpjobportal::$_error_flag_message_for_link_text = $linktext;
                    }
                    $layout = 'jobs';

                    break;
                case 'viewjob':
                    $jobid = WPJOBPORTALrequest::getVar('wpjobportalid');
                    $jobid = wpjobportal::$_common->parseID($jobid);
                    # paid submission
                    $submission_type = wpjobportal::$_config->getConfigValue('submission_type');

                    $expiryflag = $wpjpjob->getJobsExpiryStatus($jobid);
                    if (WPJOBPORTALincluder::getObjectClass('user')->isemployer()) {
                        if ($wpjpjob->getIfJobOwner($jobid)) {
                            $expiryflag = true;
                        }
                    }

                    if($wpjpjob->getJobPay($jobid)){
                        $expiryflag = false;
                    }
                    if (WPJOBPORTALincluder::getObjectClass('user')->isguest() && $config_array['visitorview_emp_viewjob'] != 1) {
                        $linktext = __('Login','wp-job-portal');
                        $link = wpjobportal::$_common->jsMakeRedirectURL('job', $layout, 1);
                        wpjobportal::$_error_flag_message = WPJOBPORTALLayout::setMessageFor(1 , $link , $linktext,1);
                        wpjobportal::$_error_flag = true;
                        wpjobportal::$_error_flag_message_for=1;
                        wpjobportal::$_error_flag_message_register_for=1;
                    } elseif ($expiryflag == false) {
                        wpjobportal::$_error_flag_message = WPJOBPORTALLayout::setMessageFor(6,null,null,1);
                        wpjobportal::$_error_flag_message_for=6;
                        wpjobportal::$_error_flag = true;
                    } else {
                        # Submission Type for User pakeg
                        if($submission_type == 3){
                            $check = WPJOBPORTALincluder::getJSModel('jobapply')->canAddJobApply($jobid,$uid);
                        }
                        $wpjpjob->getJobbyIdForView($jobid);
                    }
                    if(isset($link) && isset($linktext)){
                        wpjobportal::$_error_flag_message_for_link=$link;
                        wpjobportal::$_error_flag_message_for_link_text=$linktext;
                    }
                    break;
                case 'jobsbycategories':
                    try {
                        if (WPJOBPORTALincluder::getObjectClass('user')->isguest() && $config_array['visitorview_js_jobcat'] != 1) {
                            $link = WPJOBPORTALincluder::getJSModel('common')->jsMakeRedirectURL('company', $layout, 1);
                            $linktext = __('Login','wp-job-portal');
                            wpjobportal::$_error_flag_message_for=1;
                            wpjobportal::$_error_flag_message_register_for=2;
                            throw new Exception(WPJOBPORTALLayout::setMessageFor(1 , $link , $linktext,1));

                        } elseif ((WPJOBPORTALincluder::getObjectClass('user')->isjobseeker()) || ($config_array['visitorview_js_jobcat'] == 1)) {
                            $wpjpjob->getJobsByCategories();
                        } else {
                            wpjobportal::$_common->validateEmployerArea();
                            wpjobportal::$_error_flag = true;
                            $link = wpjobportal::$_common->jsMakeRedirectURL('job', $layout, 1);
                            $linktext = __('Login','wp-job-portal');
                            wpjobportal::$_error_flag_message_for=1; // user is guest;
                            wpjobportal::$_error_flag_message_register_for=1;
                            if(isset($link) && isset($linktext)){
                                wpjobportal::$_error_flag_message_for_link=$link;
                                wpjobportal::$_error_flag_message_for_link_text=$linktext;
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
                case 'jobsbytypes':
                    $wpjpjob->getJobsByTypes();
                    break;
                case 'jobsbycities':
                    $wpjpjob->getJobsByCities();
                    break;
                case 'admin_jobs':
                    $wpjpjob->getAllJobs();
                    break;
               case 'addjob':
               case 'admin_formjob':
                    try {
                        if (wpjobportal::$_common->wpjp_isadmin() || (WPJOBPORTALincluder::getObjectClass('user')->isemployer() && $empflag == 1)) {
                            $id = WPJOBPORTALrequest::getVar('wpjobportalid');
                            if($id == '' && !wpjobportal::$_common->wpjp_isadmin()){
                                $actionname = 'job';
                                if(in_array('credits',wpjobportal::$_active_addons)){
                                        # Filter Package For Controller
                                        $data = json_decode(apply_filters('wpjobportal_addons_available_package',false,'job','job','canAddJob'));
                                        $check = $data->check;
                                        if($check == true){
                                            if(isset($data->layout) && $data->layout == "packageselection" ){
                                                $layout = $data->layout;
                                                $module = 'package';
                                            }
                                       }else{
                                            wpjobportal::$_common->getBuyErrMsg();
                                       }
                                    }else{
                                    $check = true;
                                }
                                if(!in_array('multicompany',wpjobportal::$_active_addons)){
                                    $company = WPJOBPORTALincluder::getJSModel('company')->getSingleCompanyByUid($uid);
                                }
                            }else{
                                if(!wpjobportal::$_common->wpjp_isadmin()){
                                    $check = $wpjpjob->getIfJobOwner($id);// owner check
                                    if(!in_array('multicompany',wpjobportal::$_active_addons)){
                                        $company = WPJOBPORTALincluder::getJSModel('company')->getSingleCompanyByUid($uid);
                                    }
                                }
                            }
                            if (wpjobportal::$_common->wpjp_isadmin() || $check == true) {
                                $wpjpjob->getJobbyId($id);
                            }elseif($id != ''){
                                wpjobportal::$_error_flag_message_for=4; //credit not enough to perform this action
                                throw new Exception( WPJOBPORTALLayout::setMessageFor(10));

                            }else {
                                wpjobportal::$_common->getBuyErrMsg();
                            }
                        } else {
                            if (WPJOBPORTALincluder::getObjectClass('user')->isjobseeker()) {
                                wpjobportal::$_error_flag_message_for=2;
                                throw new Exception( WPJOBPORTALLayout::setMessageFor(2,null,null,1));

                            } elseif ((WPJOBPORTALincluder::getObjectClass('user')->isguest() || !WPJOBPORTALincluder::getObjectClass('user')->isWPJOBPortalUser()) && $config_array['visitor_can_post_job'] == 1 && in_array('visitorcanaddjob', wpjobportal::$_active_addons)) {
                                $visitor_add_job = 0;
                                if(in_array('credits', wpjobportal::$_active_addons)){
                                    if($config_array['visitor_can_post_job'] == 1 && in_array('visitorcanaddjob', wpjobportal::$_active_addons)){
                                        $visitor_add_job = 1;
                                    }else{
                                        $link = WPJOBPORTALincluder::getJSModel('common')->jsMakeRedirectURL('job', $layout, 1);
                                        $linktext = __('Login','wp-job-portal');
                                        wpjobportal::$_error_flag_message_for=1;
                                        wpjobportal::$_error_flag_message_register_for=2;
                                        throw new Exception(WPJOBPORTALLayout::setMessageFor(1 , $link , $linktext,1));
                                    }
                                } 
                                if($visitor_add_job == 1) {
                                    $layout = 'visitoraddjob';
                                    $module = "visitorcanaddjob";
                                    $id = WPJOBPORTALrequest::getVar('wpjobportalid');
                                    WPJOBPORTALincluder::getJSModel('company')->getCompanybyId($id);
                                    if (isset(wpjobportal::$_data[0])) {
                                        wpjobportal::$_data[4] = wpjobportal::$_data[0]; //company data
                                    }
                                    //wpjobportal::$_data[5] = wpjobportal::$_data[2]; //company fields ordering
                                    $wpjpjob->getJobbyId($id);
                                    if (isset(wpjobportal::$_data[0])) {
                                        wpjobportal::$_data[7] = wpjobportal::$_data[0]; //job data
                                    }
                                    wpjobportal::$_data[8] = wpjobportal::$_data[2];
                                }
                            } else{
                                if(wpjobportal::$theme_chk == 1){
                                    $link = WPJOBPORTALincluder::getJSModel('common')->jsMakeRedirectURL('job', $layout, 1);
                                    $linktext = __('Login','wp-job-portal');
                                    wpjobportal::$_error_flag_message_for=1;
                                    wpjobportal::$_error_flag_message_register_for=2;
                                    throw new Exception(WPJOBPORTALLayout::setMessageFor(1 , $link , $linktext,1));

                                }else{
                                    wpjobportal::$_common->validateEmployerArea();
                                }
                            }
                        }
                        if(isset($link) && isset($linktext)){
                            wpjobportal::$_error_flag_message_for_link=$link;
                            wpjobportal::$_error_flag_message_for_link_text=$linktext;
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
                case 'admin_jobqueue':
                    $wpjpjob->getAllUnapprovedJobs();
                    break;
                case 'admin_job_searchresult':
                    $wpjpjob->getJobSearch();
                    break;
                case 'admin_jobsearch':
                    $wpjpjob->getSearchOptions();
                    break;
                case 'admin_view_job':
                    $id = WPJOBPORTALrequest::getVar('wpjobportalid');
                    $wpjpjob->getJobbyIdForView($jobid);
                    break;
            }

            if ($empflag == 0) {
                WPJOBPORTALLayout::setMessageFor(5);
                wpjobportal::$_error_flag_message_for=5;
                wpjobportal::$_error_flag = true;
            }
            if(!isset($module)){
                $module = (wpjobportal::$_common->wpjp_isadmin()) ? 'page' : 'wpjobportalme';
                $module = WPJOBPORTALrequest::getVar($module, null, 'job');
            }
            $module = wpjobportalphplib::wpJP_str_replace('wpjobportal_', '', $module);
            //die($module);
            WPJOBPORTALincluder::include_file($layout, $module);
        }
    }

    function approveQueueJob() {
        $id = WPJOBPORTALrequest::getVar('id');
        $result = WPJOBPORTALincluder::getJSModel('job')->approveQueueJobModel($id);
        $msg = WPJOBPORTALMessages::getMessage($result, 'job');
        WPJOBPORTALMessages::setLayoutMessage($msg['message'], $msg['status'],$this->_msgkey);
        $url = admin_url("admin.php?page=wpjobportal_job&wpjobportallt=jobqueue");
        wp_redirect($url);
        die();
    }

    function rejectQueueJob() {
        $id = WPJOBPORTALrequest::getVar('id');
        $result = WPJOBPORTALincluder::getJSModel('job')->rejectQueueJobModel($id);
        $msg = WPJOBPORTALMessages::getMessage($result, 'job');
        WPJOBPORTALMessages::setLayoutMessage($msg['message'], $msg['status'],$this->_msgkey);
        $url = admin_url("admin.php?page=wpjobportal_job&wpjobportallt=jobqueue");
        wp_redirect($url);
        die();
    }

    function approveQueueFeaturedJob() {
        $id = WPJOBPORTALrequest::getVar('id');
        $result = WPJOBPORTALincluder::getJSModel('job')->approveQueueFeaturedJobModel($id);
        $msg = WPJOBPORTALMessages::getMessage($result, 'job');
        WPJOBPORTALMessages::setLayoutMessage($msg['message'], $msg['status'],$this->_msgkey);
        $url = admin_url("admin.php?page=wpjobportal_job&wpjobportallt=jobqueue");
        wp_redirect($url);
        die();
    }

    function rejectQueueFeaturedJob() {
        $id = WPJOBPORTALrequest::getVar('id');
        $result = WPJOBPORTALincluder::getJSModel('job')->rejectQueueFeaturedJobModel($id);
        $msg = WPJOBPORTALMessages::getMessage($result, 'job');
        WPJOBPORTALMessages::setLayoutMessage($msg['message'], $msg['status'],$this->_msgkey);
        $url = admin_url("admin.php?page=wpjobportal_job&wpjobportallt=jobqueue");
        wp_redirect($url);
        die();
    }

    function approveQueueAllJobs() {
        $id = WPJOBPORTALrequest::getVar('id');
        $alltype = WPJOBPORTALrequest::getVar('objid');
        $result = WPJOBPORTALincluder::getJSModel('job')->approveQueueAllJobsModel($id, $alltype);
        $msg = WPJOBPORTALMessages::getMessage($result, 'job');
        WPJOBPORTALMessages::setLayoutMessage($msg['message'], $msg['status'],$this->_msgkey);
        $url = admin_url("admin.php?page=wpjobportal_job&wpjobportallt=jobqueue");

        wp_redirect($url);
        die();
    }

    function rejectQueueAllJobs() {
        $id = WPJOBPORTALrequest::getVar('id');
        $alltype = WPJOBPORTALrequest::getVar('objid');
        $result = WPJOBPORTALincluder::getJSModel('job')->rejectQueueAllJobsModel($id, $alltype);
        $msg = WPJOBPORTALMessages::getMessage($result, 'job');
        WPJOBPORTALMessages::setLayoutMessage($msg['message'], $msg['status'],$this->_msgkey);
        $url = admin_url("admin.php?page=wpjobportal_job&wpjobportallt=jobqueue");
        wp_redirect($url);
    }

    function canaddfile() {
        if (isset($_POST['form_request']) && $_POST['form_request'] == 'wpjobportal')
            return false;
        elseif (isset($_GET['action']) && $_GET['action'] == 'wpjobportaltask')
            return false;
        else
            return true;
    }

    function savejob() {
        $mjob = WPJOBPORTALincluder::getJSModel('job');
        $data = WPJOBPORTALrequest::get('post');
        $result = $mjob->storeJob($data);
        $isnew = !( isset($data['id']) && (int)$data['id'] ) ? 1 : 0;
        $adminjoblayout = (isset($_POST['isqueue']) && $_POST['isqueue'] == 1) ? 'jobqueue' : 'jobs';
        $submission_type = wpjobportal::$_config->getConfigValue('submission_type');
        $isnew = !( isset($data['id']) && (int)$data['id'] ) ? 1 : 0;
        if ($result == WPJOBPORTAL_SAVED) {
            if (wpjobportal::$_common->wpjp_isadmin()) {
                $url = admin_url("admin.php?page=wpjobportal_job&wpjobportallt=".$adminjoblayout);
            } else {
                if(in_array('credits', wpjobportal::$_active_addons)){
                    if($submission_type == 2 &&   $isnew == 1 ){
                        if(wpjobportal::$_config->getConfigValue('job_currency_price_perlisting') > 0){
                            # credit to save
                            $url = apply_filters('wpjobportal_addons_credit_save_perlisting',false,wpjobportal::$_data['id'],'payjob');
                        }else{
                            $url = wpjobportal::makeUrl(array('wpjobportalme'=>'job', 'wpjobportallt'=>'myjobs'));
                        }
                    }else{
                        $url = wpjobportal::makeUrl(array('wpjobportalme'=>'job', 'wpjobportallt'=>'myjobs'));
                    }
                }else{
                    $url = wpjobportal::makeUrl(array('wpjobportalme'=>'job', 'wpjobportallt'=>'myjobs'));
                }
            }
            if(WPJOBPORTALincluder::getObjectClass('user')->isguest()){
                $pageid = wpjobportal::$_config->getConfigurationByConfigName('visitor_add_job_redirect_page');
                $url = get_the_permalink($pageid);
            }
        } else {
            if (wpjobportal::$_common->wpjp_isadmin()) {
                $url = admin_url("admin.php?page=wpjobportal_job&wpjobportallt=formjob");
            } else {
                $url = wpjobportal::makeUrl(array('wpjobportalme'=>'job', 'wpjobportallt'=>'addjob'));
            }
        }
        $msg = WPJOBPORTALMessages::getMessage($result, 'job');
        WPJOBPORTALMessages::setLayoutMessage($msg['message'], $msg['status'],$this->_msgkey);
        wp_redirect($url);
        die();
    }

    function remove() {
        $nonce = WPJOBPORTALrequest::getVar('_wpnonce');
        if (! wp_verify_nonce( $nonce, 'delete-job') ) {
             die( 'Security check Failed' );
        }
        $ids = WPJOBPORTALrequest::getVar('wpjobportal-cb');
        $data = WPJOBPORTALrequest::get('post');
        $callfrom = '';
        if (!isset($data['callfrom']) || $data['callfrom'] == null) {
            $data['callfrom'] = $callfrom = WPJOBPORTALrequest::getVar('callfrom');
        }

        $result = WPJOBPORTALincluder::getJSModel('job')->deleteJobs($ids);
        $msg = WPJOBPORTALMessages::getMessage($result, 'job');
        WPJOBPORTALMessages::setLayoutMessage($msg['message'], $msg['status'],$this->_msgkey);
        if (wpjobportal::$_common->wpjp_isadmin()) {
            if (isset($data['callfrom']) AND $data['callfrom'] == 2) {
                $url = admin_url("admin.php?page=wpjobportal_job&wpjobportallt=jobqueue");
            }else{
                $url = admin_url("admin.php?page=wpjobportal_job&wpjobportallt=jobs");
            }
        } else {
            $url = wpjobportal::makeUrl(array('wpjobportalme'=>'job', 'wpjobportallt'=>'myjobs'));
        }
        wp_redirect($url);
        die();
    }

    function jobenforcedelete() {
        $nonce = WPJOBPORTALrequest::getVar('_wpnonce');
        if (! wp_verify_nonce( $nonce, 'delete-job') ) {
             die( 'Security check Failed' );
        }
        $jobid = WPJOBPORTALrequest::getVar('jobid');
        $callfrom = WPJOBPORTALrequest::getVar('callfrom');
        $uid = WPJOBPORTALincluder::getObjectClass('user')->uid();
        $resultforsendmail = WPJOBPORTALincluder::getJSModel('job')->getJobInfoForEmail($jobid);
        $mailextradata = array();
        $mailextradata['jobtitle'] = $resultforsendmail->jobtitle;
        $mailextradata['useremail'] = $resultforsendmail->useremail;
        // log error resolved
        $mailextradata['companyname'] = $resultforsendmail->companyname;
        $mailextradata['user'] = $resultforsendmail->username;

        $result = WPJOBPORTALincluder::getJSModel('job')->jobEnforceDelete($jobid, $uid);

        $msg = WPJOBPORTALMessages::getMessage($result, 'job');
        WPJOBPORTALMessages::setLayoutMessage($msg['message'], $msg['status'],$this->_msgkey);
        if ($callfrom == 1) {
            $url = admin_url("admin.php?page=wpjobportal_job&wpjobportallt=jobs");
        } else {
            $url = admin_url("admin.php?page=wpjobportal_job&wpjobportallt=jobqueue");
        }
        if ($result == WPJOBPORTAL_DELETED) {
            WPJOBPORTALincluder::getJSModel('emailtemplate')->sendMail(2, 2, $jobid,$mailextradata); // 2 for job,2 for DELETE job
        }
        wp_redirect($url);
        die();
    }
}

$WPJOBPORTALJobController = new WPJOBPORTALJobController();
?>
