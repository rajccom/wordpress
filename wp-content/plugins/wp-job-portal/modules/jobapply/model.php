<?php

if (!defined('ABSPATH'))
    die('Restricted Access');

class WPJOBPORTALjobapplyModel {
    public $class_prefix = '';

    function __construct(){
        if(wpjobportal::$theme_chk == 1){
            $this->class_prefix = 'wpj-jp';
        }elseif(wpjobportal::$theme_chk == 2){
            $this->class_prefix = 'jsjb-jh';
        } else {
            $this->class_prefix = 'wjportal';
        }
    }

    function jsGetPrefix(){
        global $wpdb;
        if(is_multisite()) {
            $prefix = $wpdb->base_prefix;
        }else{
            $prefix = wpjobportal::$_db->prefix;
        }
        return $prefix;
    }

    function getAppliedResume() {
        //Filters
        $searchtitle = WPJOBPORTALrequest::getVar('searchtitle');
        $searchcompany = WPJOBPORTALrequest::getVar('searchcompany');
        $searchjobcategory = WPJOBPORTALrequest::getVar('searchjobcategory');
        $searchjobtype = WPJOBPORTALrequest::getVar('searchjobtype');
        $searchjobstatus = WPJOBPORTALrequest::getVar('searchjobstatus');

        wpjobportal::$_data['filter']['searchtitle'] = $searchtitle;
        wpjobportal::$_data['filter']['searchcompany'] = $searchcompany;
        wpjobportal::$_data['filter']['searchjobcategory'] = $searchjobcategory;
        wpjobportal::$_data['filter']['searchjobtype'] = $searchjobtype;
        wpjobportal::$_data['filter']['searchjobstatus'] = $searchjobstatus;

        if ($searchjobcategory)
            if (is_numeric($searchjobcategory) == false)
                return false;
        if ($searchjobtype)
            if (is_numeric($searchjobtype) == false)
                return false;
        if ($searchjobstatus)
            if (is_numeric($searchjobstatus) == false)
                return false;

        $inquery = "";
        if ($searchtitle)
            $inquery .= " AND LOWER(job.title) LIKE '%" . $searchtitle . "%'";
        if ($searchcompany)
            $inquery .= " AND LOWER(company.name) LIKE '%" . $searchcompany . "%'";
        if ($searchjobcategory)
            $inquery .= " AND job.jobcategory = " . $searchjobcategory;
        if ($searchjobtype)
            $inquery .= " AND job.jobtype = " . $searchjobtype;
        if ($searchjobstatus)
            $inquery .= " AND job.jobstatus = " . $searchjobstatus;

        //Pagination
        $query = "SELECT COUNT(job.id) FROM " . wpjobportal::$_db->prefix . "wj_portal_jobs AS job
        JOIN `" . wpjobportal::$_db->prefix . "wj_portal_companies` AS company ON job.companyid = company.id
        WHERE job.status <> 0";
        $query.=$inquery;

        $total = wpjobportaldb::get_var($query);
        wpjobportal::$_data['total'] = $total;
        wpjobportal::$_data[1] = WPJOBPORTALpagination::getPagination($total);

        //Data
        $query = "SELECT job.*, cat.cat_title, jobtype.title AS jobtypetitle, jobstatus.title AS jobstatustitle, company.name AS companyname
                , ( SELECT COUNT(id) FROM `" . wpjobportal::$_db->prefix . "wj_portal_jobapply` WHERE jobid = job.id) AS totalresume
                FROM `" . wpjobportal::$_db->prefix . "wj_portal_jobs` AS job
                JOIN `" . wpjobportal::$_db->prefix . "wj_portal_categories` AS cat ON job.jobcategory = cat.id
                JOIN `" . wpjobportal::$_db->prefix . "wj_portal_jobtypes` AS jobtype ON job.jobtype = jobtype.id
                JOIN `" . wpjobportal::$_db->prefix . "wj_portal_companies` AS company ON job.companyid = company.id
                LEFT JOIN `" . wpjobportal::$_db->prefix . "wj_portal_jobstatus` AS jobstatus ON job.jobstatus = jobstatus.id
                WHERE job.status <> 0";
        $query.=$inquery;
        $query .= " ORDER BY job.created DESC";
        $query.=" LIMIT " . WPJOBPORTALpagination::$_offset . "," . WPJOBPORTALpagination::$_limit;
        wpjobportal::$_data[0] = wpjobportaldb::get_results($query);
        return;
    }

    function canApplyOnJob($jobid, $uid) {
        $result = $this->checkAlreadyAppliedJob($jobid, $uid);

        if($result){// check credits if user has not already applied on this job
           return true;
        }else{// if already applied on this job return false
            return -1;
        }

    }

    function canAddJobApply($jobapplyid,$userid){
        $result = $this->checkAlreadyAppliedJob($jobapplyid, $userid);
       if($result && in_array('credits', wpjobportal::$_active_addons)){
            $credits = WPJOBPORTALincluder::getObjectClass('userpackage')->do_action($userid,'jobapply');
        }
    }

    function getJobAppliedResume($tab_action, $jobid, $uid) {
        if (!is_numeric($jobid))
            return false;
        if($uid)
        if (!is_numeric($uid))
            return false;

        $query = "SELECT title FROM `" . wpjobportal::$_db->prefix . "wj_portal_jobs` WHERE id = " . $jobid;
        wpjobportal::$_data['jobtitle'] = wpjobportal::$_db->get_var($query);

        $title = isset(wpjobportal::$_search['search_filter']['title']) ? wpjobportal::$_search['search_filter']['title']: '';

        $name = isset(wpjobportal::$_search['search_filter']['name']) ? wpjobportal::$_search['search_filter']['name']: '';
        $nationality = isset(wpjobportal::$_search['search_filter']['nationality']) ? wpjobportal::$_search['search_filter']['nationality']: '';
        $jobcategory = isset(wpjobportal::$_search['search_filter']['jobcategory']) ? wpjobportal::$_search['search_filter']['jobcategory']: '';
        $gender = isset(wpjobportal::$_search['search_filter']['gender']) ? wpjobportal::$_search['search_filter']['gender']: '';
        $jobtype = isset(wpjobportal::$_search['search_filter']['jobtype']) ? wpjobportal::$_search['search_filter']['jobtype']: '';
        $currency = isset(wpjobportal::$_search['search_filter']['currency']) ? wpjobportal::$_search['search_filter']['currency']: '';
        $jobsalaryrange = isset(wpjobportal::$_search['search_filter']['jobsalaryrange']) ? wpjobportal::$_search['search_filter']['jobsalaryrange']: '';
        $heighestfinisheducation = isset(wpjobportal::$_search['search_filter']['heighestfinisheducation']) ? wpjobportal::$_search['search_filter']['heighestfinisheducation']: '';


        // $formsearch = WPJOBPORTALrequest::getVar('WPJOBPORTAL_form_search', 'post');
        // if ($formsearch == 'WPJOBPORTAL_SEARCH') {
        //     $_SESSION['WPJOBPORTAL_SEARCH']['title'] = $title;
        //     $_SESSION['WPJOBPORTAL_SEARCH']['name'] = $name;
        //     $_SESSION['WPJOBPORTAL_SEARCH']['nationality'] = $nationality;
        //     $_SESSION['WPJOBPORTAL_SEARCH']['jobcategory'] = $jobcategory;
        //     $_SESSION['WPJOBPORTAL_SEARCH']['jobtype'] = $jobtype;
        //     $_SESSION['WPJOBPORTAL_SEARCH']['heighestfinisheducation'] = $heighestfinisheducation;
        // }
        // if (WPJOBPORTALrequest::getVar('pagenum', 'get', null) != null) {
        //     $title = (isset($_SESSION['WPJOBPORTAL_SEARCH']['title']) && $_SESSION['WPJOBPORTAL_SEARCH']['title'] != '') ? sanitize_key($_SESSION['WPJOBPORTAL_SEARCH']['title']) : null;
        //     $name = (isset($_SESSION['WPJOBPORTAL_SEARCH']['name']) && $_SESSION['WPJOBPORTAL_SEARCH']['name'] != '') ? sanitize_key($_SESSION['WPJOBPORTAL_SEARCH']['name']) : null;
        //     $nationality = (isset($_SESSION['WPJOBPORTAL_SEARCH']['nationality']) && $_SESSION['WPJOBPORTAL_SEARCH']['nationality'] != '') ? sanitize_key($_SESSION['WPJOBPORTAL_SEARCH']['nationality']) : null;
        //     $jobcategory = (isset($_SESSION['WPJOBPORTAL_SEARCH']['jobcategory']) && $_SESSION['WPJOBPORTAL_SEARCH']['jobcategory'] != '') ? sanitize_key($_SESSION['WPJOBPORTAL_SEARCH']['jobcategory']) : null;

        //     $gender = (isset($_SESSION['WPJOBPORTAL_SEARCH']['gender']) && $_SESSION['WPJOBPORTAL_SEARCH']['gender'] != '') ? sanitize_key($_SESSION['WPJOBPORTAL_SEARCH']['gender']) : null;
        //     $jobtype = (isset($_SESSION['WPJOBPORTAL_SEARCH']['jobtype']) && $_SESSION['WPJOBPORTAL_SEARCH']['jobtype'] != '') ? sanitize_key($_SESSION['WPJOBPORTAL_SEARCH']['jobtype']) : null;
        //     $currency = (isset($_SESSION['WPJOBPORTAL_SEARCH']['currency ']) && $_SESSION['WPJOBPORTAL_SEARCH']['currency '] != '') ? sanitize_key($_SESSION['WPJOBPORTAL_SEARCH']['currency ']) : null;
        //     $jobsalaryrange = (isset($_SESSION['WPJOBPORTAL_SEARCH']['jobsalaryrange']) && $_SESSION['WPJOBPORTAL_SEARCH']['jobsalaryrange'] != '') ? sanitize_key($_SESSION['WPJOBPORTAL_SEARCH']['jobsalaryrange']) : null;
        //     $heighestfinisheducation = (isset($_SESSION['WPJOBPORTAL_SEARCH']['heighestfinisheducation']) && $_SESSION['WPJOBPORTAL_SEARCH']['heighestfinisheducation'] != '') ? sanitize_key($_SESSION['WPJOBPORTAL_SEARCH']['heighestfinisheducation']) : null;
        // } else if ($formsearch !== 'WPJOBPORTAL_SEARCH') {
        //     if(isset($_SESSION['WPJOBPORTAL_SEARCH']))
        //         unset($_SESSION['WPJOBPORTAL_SEARCH']);
        // }

        $inquery = "";
        if ($tab_action) {
            $inquery.=" AND jobapply.action_status =" . $tab_action;
        }
        if ($title) {
            $inquery.=" AND app.application_title LIKE '%" . $title . "%'";
        }
        if ($name) {
            $inquery.=" AND LOWER(app.first_name) LIKE '%" . $name . "%'";
        }

        if (is_numeric($nationality)) {
            $inquery .= " AND app.nationality = " . $nationality;
        }
        if (is_numeric($gender)) {
            $inquery .= " AND app.gender = " . $gender;
        }
        if (is_numeric($jobtype)) {
            $inquery .= " AND app.jobtype = " . $jobtype;
        }
        if (is_numeric($currency)) {
            $inquery .= " AND app.currencyid = " . $currency;
        }
        if (is_numeric($jobsalaryrange)) {
            $inquery .= " AND ( ( dsalarystart.rangestart >= (SELECT rangestart FROM `" . wpjobportal::$_db->prefix . "wj_portal_salaryrange` WHERE id = " . $jobsalaryrange . "))
                          AND ( dsalarystart.rangeend <= (SELECT rangeend FROM `" . wpjobportal::$_db->prefix . "wj_portal_salaryrange` WHERE id = " . $jobsalaryrange . ")) ) ";
        }
        if (is_numeric($heighestfinisheducation)) {
            $inquery .= " AND app.heighestfinisheducation = " . $heighestfinisheducation;
        }
        if (is_numeric($jobcategory)) {
            $inquery .= " AND app.job_category = " . $jobcategory;
        }


        if (!wpjobportal::$_common->wpjp_isadmin()) {
            $inquery .= " AND job.uid= " . $uid;
        }

        wpjobportal::$_data['filter']['title'] = $title;
        wpjobportal::$_data['filter']['name'] = $name;
        wpjobportal::$_data['filter']['nationality'] = $nationality;
        wpjobportal::$_data['filter']['jobcategory'] = $jobcategory;

        wpjobportal::$_data['filter']['gender'] = $gender;
        wpjobportal::$_data['filter']['jobtype'] = $jobtype;
        wpjobportal::$_data['filter']['jobsalaryrange'] = $jobsalaryrange;
        wpjobportal::$_data['filter']['heighestfinisheducation'] = $heighestfinisheducation;


        // $inquery = "";
        if ($tab_action && in_array('resumeaction', wpjobportal::$_active_addons)) {
            $inquery.=" AND jobapply.action_status =" . $tab_action;
        }
        if(wpjobportal::$_common->wpjp_isadmin()){
            wpjobportal::$_data[4]['jobinfo'] = $this->getJobApp($jobid);
        }else{
            wpjobportal::$_data[4]['jobinfo'] = $this->getMyJobs($uid,$jobid);
             wpjobportal::$_data['fields'] = wpjobportal::$_wpjpfieldordering->getFieldsOrderingforForm(2);
        wpjobportal::$_data['config'] = wpjobportal::$_config->getConfigByFor('job');
        }

        //Pagination
        $query = "SELECT COUNT(job.id)
        FROM `" . wpjobportal::$_db->prefix . "wj_portal_jobs` AS job
           , `" . wpjobportal::$_db->prefix . "wj_portal_jobapply` AS jobapply
           , `" . wpjobportal::$_db->prefix . "wj_portal_resume` AS app
        WHERE jobapply.jobid = job.id AND jobapply.cvid = app.id AND jobapply.jobid = " . $jobid." AND jobapply.status = 1 ";
        $query.=$inquery;
        $total = wpjobportaldb::get_var($query);
        wpjobportal::$_data['total'] = $total;

        wpjobportal::$_data[1] = WPJOBPORTALpagination::getPagination($total);
        $this->sorting();
        $query = "SELECT app.uid AS jobseekerid,company.uid AS employerid,jobapply.comments,jobapply.id AS jobapplyid ,job.id,job.uid as userid,cat.cat_title ,jobapply.apply_date, jobapply.resumeview, jobapply.socialprofileid, jobtype.title AS jobtypetitle,app.endfeatureddate,app.isfeaturedresume,app.id AS appid,app.id AS id, app.first_name, app.last_name,app.email_address, app.jobtype,app.gender,job.id AS jobid
                , app.id as resumeid ,job.hits AS jobview,app.last_modified,app.salaryfixed as salary,jobapply.rating,jobtype.color as jobtypecolor
                ,(SELECT COUNT(id) FROM `" . wpjobportal::$_db->prefix . "wj_portal_jobapply` WHERE jobid = job.id) AS totalapply
                ,(SELECT address_city FROM `" . wpjobportal::$_db->prefix . "wj_portal_resumeaddresses` WHERE resumeid = app.id ORDER BY created DESC LIMIT 1) AS resumecity ,app.photo AS photo,app.application_title AS applicationtitle
                ,CONCAT(app.alias,'-',app.id) resumealiasid, CONCAT(job.alias,'-',job.id) AS jobaliasid
                ,( Select rinsitute.institute From`" . wpjobportal::$_db->prefix . "wj_portal_resumeinstitutes` AS rinsitute Where rinsitute.resumeid = app.id LIMIT 1 ) AS institute
                ,( Select rinsitute.institute_study_area From`" . wpjobportal::$_db->prefix . "wj_portal_resumeinstitutes` AS rinsitute Where rinsitute.resumeid = app.id LIMIT 1 ) AS institute_study_area
                ,job.companyid,app.params, jobapply.coverletterid ";
                if(in_array('sociallogin', wpjobportal::$_active_addons)){
                    $query.=" ,socialprofiles.profiledata as socialprofile ";
                }
                $query.=" FROM `" . wpjobportal::$_db->prefix . "wj_portal_jobs` AS job
                JOIN `" . wpjobportal::$_db->prefix . "wj_portal_jobapply` AS jobapply  ON jobapply.jobid = job.id
                LEFT JOIN `" . wpjobportal::$_db->prefix . "wj_portal_resume` AS app ON app.id = jobapply.cvid
                LEFT JOIN `" . wpjobportal::$_db->prefix . "wj_portal_categories` AS cat ON cat.id = job.jobcategory
                LEFT JOIN `" . wpjobportal::$_db->prefix . "wj_portal_jobtypes` AS jobtype ON jobtype.id = app.jobtype
                 LEFT JOIN `" . wpjobportal::$_db->prefix . "wj_portal_cities` AS city ON city.id = (SELECT address_city FROM `" . wpjobportal::$_db->prefix . "wj_portal_resumeaddresses` WHERE resumeid = app.id LIMIT 1)
                LEFT JOIN `" . wpjobportal::$_db->prefix . "wj_portal_companies` AS company ON company.id = job.companyid";
                if(in_array('sociallogin', wpjobportal::$_active_addons)){
                    $query.=" LEFT JOIN `" . wpjobportal::$_db->prefix . "wj_portal_socialprofiles` AS socialprofiles ON socialprofiles.id = jobapply.socialprofileid";
                }
            $query.=" WHERE jobapply.jobid = $jobid AND jobapply.status = 1 ";
        $query.= $inquery;
        $query .= " ORDER BY " . wpjobportal::$_data['sorting'];
        $query .= " LIMIT " . WPJOBPORTALpagination::$_offset . "," . WPJOBPORTALpagination::$_limit;
        $result = wpjobportaldb::get_results($query);
        wpjobportal::$_data[0]['ta'] = $jobid;
        wpjobportal::$_data[0]['tabaction'] = $tab_action;
        wpjobportal::$_data[0]['jobid'] = $jobid;
        $data = array();
        foreach ($result AS $d) {
            $d->location = WPJOBPORTALincluder::getJSModel('city')->getLocationDataForView($d->resumecity);
            if(in_array('coverletter',wpjobportal::$_active_addons)){
                $d->coverletterdata = WPJOBPORTALincluder::getJSModel('coverletter')->getCoverLetterTitleDescFromID($d->coverletterid);
            }
            $data[] = $d;
        }
        wpjobportal::$_data[0]['data'] = $data;
        $query = "Select Count(id) from`" . wpjobportal::$_db->prefix . "wj_portal_jobapply` WHERE action_status=1 AND jobid = " . $jobid ." AND status = 1";
        wpjobportal::$_data[0]['inbox'] = wpjobportaldb::get_var($query);


        $query = "Select Count(id) from`" . wpjobportal::$_db->prefix . "wj_portal_jobapply` WHERE action_status=2 AND jobid = " . $jobid ." AND status = 1";
        wpjobportal::$_data[0]['spam'] = wpjobportaldb::get_var($query);


        $query = "Select Count(id) from`" . wpjobportal::$_db->prefix . "wj_portal_jobapply` WHERE action_status=3 AND jobid = " . $jobid ." AND status = 1";
        wpjobportal::$_data[0]['hired'] = wpjobportaldb::get_var($query);

        $query = "Select Count(id) from`" . wpjobportal::$_db->prefix . "wj_portal_jobapply` WHERE jobid = $jobid AND status = 1 " ;
        wpjobportal::$_data[0]['applied'] = wpjobportaldb::get_var($query);

        $query = "Select hits from`" . wpjobportal::$_db->prefix . "wj_portal_jobs` WHERE id = " . $jobid;
        wpjobportal::$_data[0]['hits'] = wpjobportaldb::get_var($query);


        $query = "Select Count(id) from`" . wpjobportal::$_db->prefix . "wj_portal_jobapply` WHERE action_status=4 AND jobid = " . $jobid ." AND status = 1";
        wpjobportal::$_data[0]['reject'] = wpjobportaldb::get_var($query);


        $query = "Select Count(id) from`" . wpjobportal::$_db->prefix . "wj_portal_jobapply` WHERE action_status=5 AND jobid = " . $jobid ." AND status = 1";
        wpjobportal::$_data[0]['shortlisted'] = wpjobportaldb::get_var($query);

        $query = "Select job.title,jobtype.title AS jobtypetitle,LOWER(jobtype.title) AS jobtypetit from`" . wpjobportal::$_db->prefix . "wj_portal_jobs` AS job

                  JOIN `" . wpjobportal::$_db->prefix . "wj_portal_jobtypes` AS jobtype ON job.jobtype = jobtype.id

         WHERE job.id = " . $jobid;
        $job_info=wpjobportaldb::get_row($query);
        wpjobportal::$_data[0]['jobtitle'] = $job_info->title;
        wpjobportal::$_data[0]['jobtypetitle'] = $job_info->jobtypetitle;
        wpjobportal::$_data[0]['jobtypetit'] = $job_info->jobtypetit;
        // wpjobportal::$_data['fields'] = WPJOBPORTALincluder::getJSModel('fieldordering')->getFieldsOrderingforSearch(3);// search fields
        wpjobportal::$_data['field'] = WPJOBPORTALincluder::getJSModel('fieldordering')->getFieldsOrderingforView(2);

        wpjobportal::$_data['listingfields'] = wpjobportal::$_wpjpfieldordering->getFieldsForListing(3);

        return;
    }

    function getResumeDetail($themecall=null) {
        $salary = WPJOBPORTALrequest::getVar('sal');
        $exprince = WPJOBPORTALrequest::getVar('expe');
        $insitute = WPJOBPORTALrequest::getVar('institue');
        $study = WPJOBPORTALrequest::getVar('stud');
        $available = WPJOBPORTALrequest::getVar('ava');

        if ($available == 1) {
            $res = "Yes";
        } else {
            $res = "No";
        }
        if(null != $themecall){
            $return['salary']=$salary;
            $return['exprince']=$exprince;
            $return['insitute']=$insitute;
            $return['study']=$study;
            $return['available']=$available;
            $return['res']=$res;
            return $return;
        }
        $html = '';
        if (wpjobportal::$theme_chk == 1) {
            $html.='<img id="close-section" onclick="closeSection()" src="' . WPJOBPORTAL_PLUGIN_URL . 'includes/images/no.png"/>';
            $html.='<div class="wpj-jp-applied-resume-cnt wpj-jp-actions-detail-wrp">';
            $html.='<div class="wpj-jp-applied-resume-cnt-row">';
            $html.='<span class="wpj-jp-applied-resume-cnt-tit">' . esc_html__('Current Salary', 'job-portal') . ': </span><span class="wpj-jp-applied-resume-cnt-val">' . $salary;
            $html.='</span></div>';
            $html.='</div>';
        } else {
            $html.='<img id="close-section" onclick="closeSection()" src="' . WPJOBPORTAL_PLUGIN_URL . 'includes/images/no.png"/>';
            $html.='<div class="wjportal-applied-job-actions-wrp wjportal-job-actions-detail-wrp">';
            $html.='<div class="wjportal-job-actions-detail-row">';
            $html.='<span class="wjportal-job-actions-detail-tit">' . __('Current Salary', 'wp-job-portal') . ': </span><span class="wjportal-job-actions-detail-val">' . $salary;
            $html.='</span></div>';
            $html.='</div>';
        }
        return $html;
    }

    function getJobApplyDetailByid(){
        $id = WPJOBPORTALrequest::getVar('id');
        $pageid = WPJOBPORTALrequest::getVar('pageid');
        $content="";
        if ($id && is_numeric($id)) {
            $query = "SELECT resume.id AS resumeid
                    ,CONCAT(resume.first_name, ' ', resume.last_name) AS Name,jobapply.id AS id
                     FROM `" . wpjobportal::$_db->prefix . "wj_portal_jobapply` AS jobapply
                     JOIN `" . wpjobportal::$_db->prefix . "wj_portal_resume` AS resume ON resume.id = jobapply.cvid
                     WHERE jobapply.id = " . $id;
            $result = wpjobportaldb::get_row($query);
            if($result){
                $content .='<div class="modal-content '.$this->class_prefix.'-modal-wrp">
                                <div class="'.$this->class_prefix.'-modal-header">
                                    <a title="close" class="close '.$this->class_prefix.'-modal-close-icon-wrap" href="#" onclick="wpjobportalClosePopup(1);" >
                                        <img id="popup_cross" alt="popup cross" src="'.WPJOBPORTAL_PLUGIN_URL.'includes/images/popup-close.png">
                                    </a>
                                    <h2 class="'.$this->class_prefix.'-modal-title">'.__("Applied Info","job-portal").'</h2>
                                </div>
                                <div class="col-md-12 '.$this->class_prefix.'-appliedinformation-modal-data-wrp">
                                    <div class="modal-body '.$this->class_prefix.'-modal-body">
                                       <div class="'.$this->class_prefix.'-appliedinformation-title">

                                       <h5 class="'.$this->class_prefix.'-appliedinformation-title-txt">
                                            <a href="'.wpjobportal::makeUrl(array("wpjobportalpageid"=>$pageid,"wpjobportalme"=>"resume","wpjobportallt"=>"viewresume","wpjobportalid"=>$result->resumeid)).'">
                                                '.$result->Name.'
                                            </a>';
                                            if($result->application_title != ''){
                                                $content .= '('.$result->application_title.')';
                                            }
                                        $content .='
                                        </h5>
                                       </div>
                                    </div>
                                </div>
                            </div>';
            }else{
                $content .='<div class="modal-content '.$this->class_prefix.'-modal-wrp">
                    <div class="'.$this->class_prefix.'-modal-header">
                        <a title="close" class="close '.$this->class_prefix.'-modal-close-icon-wrap" href="#" onclick="wpjobportalClosePopup(1);" >
                            <img id="popup_cross" alt="popup cross" src="'.WPJOBPORTAL_PLUGIN_URL.'includes/images/popup-close.png">
                        </a><h2 class="'.$this->class_prefix.'-modal-title">'.__("Applied Info","job-portal").'</h2></div>
                        <div class="col-md-12 '.$this->class_prefix.'-appliedinformation-modal-data-wrp">
                            <h3 class="'.$this->class_prefix.'-modal-title">'.__("No Record Found","job-portal").'</h3>
                        </div>
                        </div>';
            }
        }else{
            $content .='<div class="modal-content '.$this->class_prefix.'-modal-wrp">
            <div class="'.$this->class_prefix.'-modal-header">
                <a title="close" class="close '.$this->class_prefix.'-modal-close-icon-wrap" href="#" onclick="wpjobportalClosePopup(1);" >
                    <img id="popup_cross" alt="popup cross" src="'.WPJOBPORTAL_PLUGIN_URL.'includes/images/popup-close.png">
                </a><h2 class="'.$this->class_prefix.'-modal-title">'.__("Applied Info","job-portal").'</h2></div>
                <div class="col-md-12 '.$this->class_prefix.'-appliedinformation-modal-data-wrp">
                    <h3 class="'.$this->class_prefix.'-modal-title">'.__("Something wrong pleas try later","job-portal").'</h3>
                </div>
                </div>';
        }
        $array = array('title' => "", 'content' => $content);
        return json_encode($array);
    }

    function getApplyNowByJobid() {
        $jobid = WPJOBPORTALrequest::getVar('jobid');
        $themecall = WPJOBPORTALrequest::getVar('themecall');
        $upakid = WPJOBPORTALrequest::getVar('upkid');
        $config_array = wpjobportal::$_config->getConfigByFor('jobapply');
        $user = WPJOBPORTALincluder::getObjectClass('user');
        $config_array = wpjobportal::$_config->getConfigByFor('jobapply');
        if ($jobid && is_numeric($jobid)) {

                // redundunt code
                // $query = "SELECT job.title FROM `" . wpjobportal::$_db->prefix . "wj_portal_jobs` AS job WHERE job.id = " . $jobid;
                // $jobtitle = wpjobportal::$_db->get_var($query);

                # Credit Member Ship Type
                $visitorcanapply = wpjobportal::$_config->getConfigurationByConfigName('visitor_can_apply_to_job');
                if((in_array('credits', wpjobportal::$_active_addons) && WPJOBPORTALincluder::getObjectClass('user')->isguest() && $visitorcanapply != 1) || (in_array('credits', wpjobportal::$_active_addons) && !WPJOBPORTALincluder::getObjectClass('user')->isguest())){
                    if(wpjobportal::$_config->getConfigValue('submission_type') == 3){
                        /** 21/02/2019***/
                        //Member ship Show
                        $title = '';
                        $content = '';
                        $package = apply_filters('wpjobportal_addons_userpackages_permodule',false,$upakid,$user->uid(),'remjobapply');
                        if( !$package ){
                            $title = __('Apply Now Failed', 'wp-job-portal');
                            $content = __('You do not have package required for job apply', 'wp-job-portal');
                        }else{
                            if( $package->expired ){
                                $title = __('Apply Now Failed', 'wp-job-portal');
                                $content = __('You package has expired', 'wp-job-portal');
                            }
                            //if Department are not unlimited & there is no remaining left
                            if( $package->jobapply!=-1 && !$package->remjobapply ){ //-1 = unlimited
                                $title = __('Apply Now Failed', 'wp-job-portal');
                                $content = __('You do not any more job apply available', 'wp-job-portal');
                            }
                        }
                        // show proper messages
                        if($title != '' && $content != ''){
                            $title = wpjobportalphplib::wpJP_safe_encoding($title);
                            $content = wpjobportalphplib::wpJP_safe_encoding($content);
                            $array = array('title' => $title, 'content' => $content);
                            return json_encode($array);
                        }

                        $data['status'] = 1;
                        $data['userpackageid'] = $upakid;
                    }
               }

                // die($user->uid());
                $result = $this->getJobByid($jobid);
                $job = $result[0];
                $title = __('Apply Now', 'wp-job-portal');
                $content = '';// to handle log error of appending to non exsistent variable content
                if (wpjobportal::$theme_chk == 1) {
                    /*Pop up detail data For Job(Extra Detail)*/
                    $content .=  '<div class="wpj-jp-popup-cnt-wrp">';
                    $content .=  '<i class="fas fa-times wpj-jp-popup-close-icon" data-dismiss="modal"></i>';
                    $content .=  '<div class="wpj-jp-popup-right">';
                    $content .=  '<div class="wpj-jp-popup-list">';
                    if ($job->logofilename != "") {
                        $wpdir = wp_upload_dir();
                        $data_directory = wpjobportal::$_config->getConfigurationByConfigName('data_directory');
                        $path = $wpdir['baseurl'] . '/' . $data_directory . '/data/employer/comp_' . $job->companyid . '/logo/' . $job->logofilename;
                    } else {
                        $path = JOB_PORTAL_IMAGE . '/default_logo.png';
                    }
                    if(in_array('multicompany', wpjobportal::$_active_addons)){
                        $mod = "multicompany";
                    }else{
                        $mod = "company";
                    }
                    $content .= '<div class="wpj-jp-popup-list-logo">';
                    $content .=     '<a href='. esc_url(wpjobportal::makeUrl(array('wpjobportalme'=>$mod, 'wpjobportallt'=>'viewcompany', 'wpjobportalid'=>$job->companyid,'wpjobportalpageid'=>wpjobportal::getPageid()))) .' title='. esc_attr__('company logo','job-portal').'>';
                    $content .=         '<img src='. esc_url($path) .' alt="'.esc_attr__('Company logo','job-portal').'" >';
                    $content .=     '</a>';
                    $content .= '</div>';
                    $content .= '<div class="wpj-jp-popup-list-cnt-wrp">';
                    $content .=     '<div class="wpj-jp-popup-list-cnt">';
                    $content .=          '<span class="wpj-jp-job-type" style="color:'.$job->jobtypecolor.'">';
                    $content .=             sprintf(__('%s','job-portal'), $job->jobtypetitle);
                    $content .=          '</span>';
                    $content .=     '</div>';
                    $content .=     '<div class="wpj-jp-popup-list-cnt">';
                    $content .=         '<a class="wpj-jp-popup-list-comp-tit" href='. esc_url(wpjobportal::makeUrl(array('wpjobportalme'=>$mod, 'wpjobportallt'=>'viewcompany', 'wpjobportalid'=>$job->companyid,'wpjobportalpageid'=>wpjobportal::getPageid()))).' title="'.esc_attr__('Company name','job-portal').'">
                                            '.sprintf(__('%s','job-portal'), $job->companyname).'
                                        </a>';
                    $content .=     '</div>';
                    $content .=     '<div class="wpj-jp-popup-list-cnt">';
                    $content .=         '<h5 class="wpj-jp-popup-list-tit">
                                            <a href='.esc_url(wpjobportal::makeUrl(array('wpjobportalme'=>'job', 'wpjobportallt'=>'viewjob', 'wpjobportalid'=>$job->jobaliasid,'wpjobportalpageid'=>wpjobportal::getPageid()))).' title="'.esc_attr__('job title','job-portal').'">
                                                '.sprintf(__('%s','job-portal'), $job->title).'
                                            </a>
                                        </h5>';
                    $content .=     '</div>';
                    $content .=     '<div class="wpj-jp-popup-list-cnt">';
                    $content .=         '<ul>';
                    $content .=             '<li>';
                                                if(isset($job) && !empty($job->cat_title)){
                    $content .=                     '<span class="wpj-jp-popup-list-meta-tit">';
                    $content .=                         esc_html__('Category','job-portal'). ':';
                    $content .=                     '</span>';
                    $content .=                      sprintf(__('%s','job-portal'), $job->cat_title);
                                                }
                    $content .=             '</li>';
                    $content .=             '<li>';
                    $content .=                  '<span class="wpj-jp-popup-list-meta-tit">';
                    $content .=                       esc_html__('Salary','job-portal'). ':';
                    $content .=                   '</span>';
                    $content .=                    wpjobportal::$_common->getSalaryRangeView($job->salarytype, $job->salarymin, $job->salarymax,$job->currency);
                                                   if($job->salarytype==3 || $job->salarytype==2) {
                    $content .=                      ' - ' .$job->srangetypetitle;
                                                   }
                    $content .=             '</li>';
                    $content .=             '<li>';
                                                if(isset($job) && !empty($job->location)){
                    $content .=                     '<span class="wpj-jp-popup-list-meta-tit">';
                    $content .=                         esc_html__('Location','job-portal'). ':';
                    $content .=                     '</span>';
                    $content .=                     sprintf(__('%s','job-portal'), $job->location);
                                                }
                    $content .=             '</li>';
                    $content .=         '</ul>';
                    $content .=     '</div>';
                    $content .= '</div>'; 
                    $content .= '</div>'; // end job list
                    $content .= '</div>'; // right div
                    // Pop up detail data For Job Ends there
                } else {
                    /*Pop up detail data For Job(Extra Detail)*/
                    $content =  '<div class="wjportal-jobs-list">';
                    $content .= ' <div class="wjportal-jobs-list-top-wrp">';
                    if ($job->logofilename != "") {
                        $wpdir = wp_upload_dir();
                        $data_directory = wpjobportal::$_config->getConfigurationByConfigName('data_directory');
                        $path = $wpdir['baseurl'] . '/' . $data_directory . '/data/employer/comp_' . $job->companyid . '/logo/' . $job->logofilename;
                    } else {
                        $path = WPJOBPORTAL_PLUGIN_URL . '/includes/images/default_logo.png';
                    }
                    if(in_array('multicompany', wpjobportal::$_active_addons)){
                        $mod = "multicompany";
                    }else{
                        $mod = "company";
                    }
                    $content .= '<div class="wjportal-jobs-logo">';
                    $content .=     '<a href='. wpjobportal::makeUrl(array('wpjobportalme'=>$mod, 'wpjobportallt'=>'viewcompany', 'wpjobportalid'=>$job->companyid,'wpjobportalpageid'=>wpjobportal::getPageid())) .'>';
                    $content .=         '<img src='. $path .' alt="'.__('Company logo','wp-job-portal').'" >';
                    $content .=     '</a>';
                    $content .= '</div>';
                    $content .= '<div class="wjportal-jobs-cnt-wrp">';
                    $content .= '<div class="wjportal-jobs-middle-wrp">';
                    $content .=     '<div class="wjportal-jobs-data">';
                    $content .=         '<a class="wjportal-companyname" href='. wpjobportal::makeUrl(array('wpjobportalme'=>$mod, 'wpjobportallt'=>'viewcompany', 'wpjobportalid'=>$job->companyid,'wpjobportalpageid'=>wpjobportal::getPageid())).' title="'.__('Company name','wp-job-portal').'">'. $job->companyname.'</a>';
                    $content .=     '</div>';
                    $content .=     '<div class="wjportal-jobs-data">';
                    $content .=         '<span class="wjportal-job-title">';
                    $content .=             '<a href='.wpjobportal::makeUrl(array('wpjobportalme'=>'job', 'wpjobportallt'=>'viewjob', 'wpjobportalid'=>$job->jobaliasid,'wpjobportalpageid'=>wpjobportal::getPageid())).' title="'.__('Job title','wp-job-portal').'">';
                    $content .=                 $job->title;
                    $content .=             '</a>';
                    $content .=         '</span>';
                    $content .=     '</div>';
                    $content .=     '<div class="wjportal-jobs-data">';
                    if(isset($job) && !empty($job->cat_title)){
                        $content .= '<span class="wjportal-jobs-data-text">
                                        '. __($job->cat_title,'wp-job-portal').'
                                    </span>';
                    }
                    if(isset($job) && !empty($job->location)){
                        $content .= '<span class="wjportal-jobs-data-text">'. $job->location.'</span>';
                    }
                    $content .=     '</div>';
                    $content .= '</div>';
                    $content .= '<div class="wjportal-jobs-right-wrp">';
                    $content .=     '<div class="wjportal-jobs-info">';
                                        // if ($print[0] == 1) {
                    $content .=            '<span class="wjportal-job-type" style="background:'.$job->jobtypecolor.'">';
                    $content .=                 __($job->jobtypetitle,'wp-job-portal');
                    $content .=             '</span>';
                                        //}
                    $content .=     '</div>';
                    $content .=     '<div class="wjportal-jobs-info">';
                    $content .=         '<div class="wjportal-jobs-salary">';
                    $content .=             wpjobportal::$_common->getSalaryRangeView($job->salarytype, $job->salarymin, $job->salarymax,$job->currency);
                                            if($job->salarytype==3 || $job->salarytype==2) {
                    $content .=                 '<span class="wjportal-salary-type">'. ' / ' .__($job->srangetypetitle, 'wp-job-portal').'</span>';
                                            }
                    $content .=         '</div>';
                    $content .=     '</div>';
                    $content .=     '<div class="wjportal-jobs-info">';
                    $dateformat =       wpjobportal::$_configuration['date_format'];
                    $content .=         date_i18n($dateformat, strtotime($job->created));
                    $print =            WPJOBPORTALincluder::getJSModel('job')->checkLinks('jobtype');
                    $content .=     '</div>';
                    $content .= '</div>';
                    $content .= '</div>';
                    $content .= '</div>';
                    $content .= '</div>';
                    /*Pop up detail data For Job Ends there*/
                }
                $showlink = true;
                if (wpjobportal::$theme_chk == 1) {
                    $content .= '<div class="wpj-jp-popup-left  ">';
                    $content .=  '<h3 class="wpj-jp-popup-heading">'.$title.'</h3>';
                }
                if (!WPJOBPORTALincluder::getObjectClass('user')->isguest()) {
                    $uid = WPJOBPORTALincluder::getObjectClass('user')->uid();
                    $resumelist = null;
                    $isjobseeker = WPJOBPORTALincluder::getObjectClass('user')->isjobseeker();
                    $isemployer = WPJOBPORTALincluder::getObjectClass('user')->isemployer();
                    if (is_numeric($uid) && $uid != 0 && $isjobseeker == true) {
                        $query = "SELECT id,application_title AS text FROM `" . wpjobportal::$_db->prefix . "wj_portal_resume` WHERE status = 1 AND uid = " . $uid;
                        $resumelist = wpjobportal::$_db->get_results($query);
                        }
                    if ($resumelist != null && $isjobseeker == true) {
                        $content .= '<div class="'.$this->class_prefix.'-popup-field-wrp">';
                        $content .= '<div class="'.$this->class_prefix.'-popup-field">';
                        $content .= '<label for="cvid">' . __('Apply With Resume', 'wp-job-portal') . '</label>';
                        $content .= WPJOBPORTALformfield::select('cvid', $resumelist, '');
                        $content .= '</div>';

                        // to add coverletter combo box on popup
                        if(in_array('coverletter', wpjobportal::$_active_addons)){

                            $cover_letter_list = WPJOBPORTALincluder::getJSModel('coverletter')->getCoverLetterForCombocoverletter($uid);
                            $content .= '<div class="'.$this->class_prefix.'-popup-field">';
                                $content .= '<label for="coverletterid">' . __('Cover Letter', 'wp-job-portal') . '</label>';
                            if($cover_letter_list !='' && !empty($cover_letter_list)){
                                $content .= WPJOBPORTALformfield::select('coverletterid', $cover_letter_list, '');
                            }else{
                                $content .= __('No Cover Letter', 'wp-job-portal');
                            }
                            $content .= '</div>';

                        }
                        $content .= '</div>';
                        if (wpjobportal::$theme_chk == 1) {
                            if (!isset($upakid)) {
                                $upakid = 0;
                            }
                            $link1 = 'href="#" onclick="jobApply(' . $jobid . ',' .$upakid. ',1);"';
                        } else {
                            $link1 = 'href="#" onclick="jobApply(' . $jobid . ',' .$upakid. ');"';
                        }
                        $link2 = 'href="#" onclick="closePopup();"';
                        $text1 = __('Apply Now', 'wp-job-portal');
                        $text2 = '';
                        $class1 = '';
                        $class2 = '';
                    } else {
                        $showlink = false;
                        if ($isjobseeker == true) {
                            $content .= '<div class="'.$this->class_prefix.'-visitor-msg-wrp">';
                            if (wpjobportal::$theme_chk == 1) {
                                $content .= '<span class="'.$this->class_prefix.'-visitor-msg">' . __('You do not have any resume!', 'wp-job-portal') . '</span>';
                            } else {
                                $content .= '<span class="'.$this->class_prefix.'-visitor-msg"><img src="' . WPJOBPORTAL_PLUGIN_URL . 'includes/images/not-loggedin.png" />' . __('You do not have any resume!', 'wp-job-portal') . '</span>';
                            }
                            $content .= '</div>';
                            $content .= '   <div class="'.$this->class_prefix.'-visitor-msg-btn-wrp">
                                                <a class="'.$this->class_prefix.'-visitor-msg-btn wpj-jp-visitor-msg-primary-btn" href="'.wpjobportal::makeUrl(array('wpjobportalme'=>'resume', 'wpjobportallt'=>'addresume', 'wpjobportalpageid'=>wpjobportal::getPageid())).'" class="resumeaddlink">' . __('Add Resume', 'wp-job-portal') . '</a>
                                            </div>';
                        } elseif($isemployer == true) {
                            $content .= '<div class="'.$this->class_prefix.'-visitor-msg-wrp">';
                            if (wpjobportal::$theme_chk == 1) {
                                $content .= '<span class="'.$this->class_prefix.'-visitor-msg">' . __('You are employer, you can not apply to job', 'wp-job-portal') . '!</span>';
                            }
                            $content .= '<span class="'.$this->class_prefix.'-visitor-msg"><img src="' . WPJOBPORTAL_PLUGIN_URL . 'includes/images/not-loggedin.png" />' . __('You are employer, you can not apply to job', 'wp-job-portal') . '!</span>';
                            $content .= '</div>';
                        } else {
                            $showlink = true;
                            $content .= '<div class="'.$this->class_prefix.'-visitor-msg-wrp">';
                            if (wpjobportal::$theme_chk == 1) {
                                $content .= '<span class="'.$this->class_prefix.'-visitor-msg">' . __('You do not have any role', 'wp-job-portal') . '!</span>';
                            } else {
                                $content .= '<span class="'.$this->class_prefix.'-visitor-msg"><img src="' . WPJOBPORTAL_PLUGIN_URL . 'includes/images/not-loggedin.png" />' . __('You do not have any role', 'wp-job-portal') . '!</span>';
                            }
                            $content .= '</div>';
                            $link1 = 'href="' . wpjobportal::makeUrl(array('wpjobportalme'=>'common','wpjobportallt'=>'newinwpjobportal', 'wpjobportalid-jobid'=>$jobid, 'wpjobportalpageid'=>wpjobportal::getPageid())) . '" target="_blank" ';
                            $text1 = __('Select Role', 'wp-job-portal');
                            // $link2 = 'href="#" onclick="closePopup();"';
                            // $text2 = __('Close', 'wp-job-portal');
                        }
                    }
                } else {
                    $msgapply = "You are not a logged in member. Please select below option";
                    $content .= '<div class="'.$this->class_prefix.'-visitor-msg-wrp">';
                    if (wpjobportal::$theme_chk == 1) {
                        $content .= '<span class="'.$this->class_prefix.'-visitor-msg">' . __($msgapply , 'wp-job-portal') . '</span>';
                    } else {
                        $content .= '<span class="'.$this->class_prefix.'-visitor-msg"><img src="' . WPJOBPORTAL_PLUGIN_URL . 'includes/images/not-loggedin.png" />' . __($msgapply , 'wp-job-portal') . '</span>';
                    }
                    $content .= '</div>';
                    $link1 = 'href="' . wpjobportal::makeUrl(array('wpjobportalme'=>'jobapply', 'action'=>'wpjobportaltask', 'task'=>'jobapplyasvisitor', 'wpjobportalid-jobid'=>$jobid, 'wpjobportalpageid'=>wpjobportal::getPageid())) . '"';
                    $thiscpurl = wpjobportal::makeUrl(array('wpjobportalme'=>'job', 'wpjobportallt'=>'viewjob', 'wpjobportalid'=>$jobid, 'wpjobportalpageid'=>wpjobportal::getPageid()));
                    $thiscpurl = wpjobportalphplib::wpJP_safe_encoding($thiscpurl);
                    $link2 = 'href="'.wpjobportal::makeUrl(array('wpjobportalme'=>'wpjobportal', 'wpjobportallt'=>'login', 'wpjobportalredirecturl'=>$thiscpurl, 'wpjobportalpageid'=>wpjobportal::getPageid())).'"';
                    $text1 = __('Apply as visitor', 'wp-job-portal');
                    $text2 = __('Login', 'wp-job-portal');
                    $class1 = 'login';
                    $class2 = 'applyvisitor';
                }
                $jsnext = wpjobportal::makeUrl(array('wpjobportalme'=>'job','wpjobportallt'=>'viewjob','wpjobportalid'=>$jobid,'wpjobportalpageid'=>wpjobportal::getPageid()));
                $visitor_can_apply_to_job = wpjobportal::$_config->getConfigurationByConfigName('visitor_can_apply_to_job');
                if ($showlink == true) {
                    $content .= '   <div class="'.$this->class_prefix.'-visitor-msg-btn-wrp">';
                     if($text2 != ''){
                        $content .= ' <div class="quickviewbutton">
                                        <a ' . $link2 . ' class="'.$this->class_prefix.'-visitor-msg-btn ' . $class1 . '" >' . $text2 . '</a>';
                     }
                    if(WPJOBPORTALincluder::getObjectClass('user')->isguest()){
                        if($visitor_can_apply_to_job == 1){
                            $content .= apply_filters('wpjobportal_addons_apply_as_visitor',false,$link1,$class2,$text1);
                        }
                    }else{
                        $content .= '<a ' . $link1 . ' class="'.$this->class_prefix.'-visitor-msg-btn login' . $class2 . '" id="apply-now-btn" >' . $text1 . '</a>';
                    }                    $content .= ' </div>';
                }
                $isemployer = WPJOBPORTALincluder::getObjectClass('user')->isemployer();
                $content .= apply_filters('wpjobportal_addons_social_appy_job',false,$config_array,$isemployer,$jobid);
                $content .= '</div>';
                if (wpjobportal::$theme_chk == 1) {
                    $content .= '</div>'; /// end left wrp
                    $content .= '</div>'; /// end cnt wrp
                }
            } else {
                $title = __('No record found', 'wp-job-portal');
                $content = '<h1>' . __('No record found', 'wp-job-portal') . '</h1>';
            }
        $title = mb_convert_encoding($title, 'UTF-8', mb_detect_encoding($title));
        $content = mb_convert_encoding($content, 'UTF-8', mb_detect_encoding($content));
        $array = array('title' => $title, 'content' => $content);
        return json_encode($array);
    }

    function jobapplyjobmanager(){
        $jobid = WPJOBPORTALrequest::getVar('jobid');
        $return_val=$this->jobapply(1);
        if($return_val===1){
            $msg = '<div id="'.$this->class_prefix.'-notification-not-ok"><div id="'.$this->class_prefix.'-popup_message">
            <img src="' . WPJOBPORTAL_PLUGIN_URL . 'includes/images/unpublish.png"/><spam class="'.$this->class_prefix.'-popup_msg_txt">' . __("please select a resume first", "wp-job-portal") . '</spam><button class="applynow-closebutton" onclick="wpjobportalClosePopup(1);" ><img src="'.WPJOBPORTAL_PLUGIN_URL.'/includes/images/popupcloseicon.png"/>'.__('Close','wp-job-portal').'</button></div></div>';
        }elseif($return_val === 2) {
            $msg = '<div id="'.$this->class_prefix.'-notification-ok"><div id="'.$this->class_prefix.'-popup_message">
            <img src="' . WPJOBPORTAL_PLUGIN_URL . 'includes/images/approve.png"/><spam class="'.$this->class_prefix.'-popup_msg_txt">' . __("You have already applied this job", "wp-job-portal") . '</spam><button class="applynow-closebutton" onclick="wpjobportalClosePopup(1);" ><img src="'.WPJOBPORTAL_PLUGIN_URL.'/includes/images/popupcloseicon.png"/>'.__('Close','wp-job-portal').'</button></div></div>';
        }elseif($return_val == WPJOBPORTAL_SAVE_ERROR) {
            $msg = '<div id="'.$this->class_prefix.'-notification-not-ok"><div id="'.$this->class_prefix.'-popup_message">
            <img src="' . WPJOBPORTAL_PLUGIN_URL . 'includes/images/unpublish.png"/><spam class="'.$this->class_prefix.'-popup_msg_txt">' . __("Failed while performing this action", "wp-job-portal") . '</spam><button class="applynow-closebutton" onclick="wpjobportalClosePopup(1);" ><img src="'.WPJOBPORTAL_PLUGIN_URL.'/includes/images/popupcloseicon.png"/>'.__('Close','wp-job-portal').'</button></div></div>';
        }elseif($return_val == 3) { //payment
            $arr = array('wpjobportalme'=>'purchasehistory','wpjobportallt'=>'payjobapply','wpjobportalid'=>$jobid,'wpjobportalpageid'=>wpjobportal::getPageid());
            $msg = '<div id="'.$this->class_prefix.'-notification-ok"><div id="'.$this->class_prefix.'-popup_message">
            <img src="' . WPJOBPORTAL_PLUGIN_URL . 'includes/images/approve.png"/><spam class="'.$this->class_prefix.'-popup_msg_txt"><a href="'.esc_url(wpjobportal::makeUrl($arr)).'">' . __("Job has been Pending Due to Payment", "wp-job-portal") . '</a></spam><button class="applynow-closebutton" onclick="wpjobportalClosePopup(1);" ><img src="'.WPJOBPORTAL_PLUGIN_URL.'/includes/images/popupcloseicon.png"/>'.__('Close','wp-job-portal').'</button></div></div>';
        }elseif($return_val == WPJOBPORTAL_SAVED) {
            $msg = '<div id="'.$this->class_prefix.'-notification-ok"><div id="'.$this->class_prefix.'-popup_message">
            <img src="' . WPJOBPORTAL_PLUGIN_URL . 'includes/images/approve.png"/><spam class="'.$this->class_prefix.'-popup_msg_txt">' . __("Job has been applied", "wp-job-portal") . '</spam><button class="applynow-closebutton" onclick="wpjobportalClosePopup(1);" ><img src="'.WPJOBPORTAL_PLUGIN_URL.'/includes/images/popupcloseicon.png"/>'.__('Close','wp-job-portal').'</button></div></div>';
        }
        return $msg;
    }

    function jobapply($themecall=null) {
        $jobid = WPJOBPORTALrequest::getVar('jobid');
        $cvid = WPJOBPORTALrequest::getVar('cvid');
        $coverletterid = WPJOBPORTALrequest::getVar('coverletterid');
        $upkid = WPJOBPORTALrequest::getVar('upkid');
        $uid = WPJOBPORTALincluder::getObjectClass('user')->uid();
        $user = WPJOBPORTALincluder::getObjectClass('user');
        $action_status = 1;

        if (! is_numeric($cvid)) {
            if(null !=$themecall) return 1;
            $msg = '<div id="notification-not-ok"><label id="popup_message"><img src="' . WPJOBPORTAL_PLUGIN_URL . 'includes/images/unpublish.png"/>' . __("please select a resume first", "wp-job-portal") . '</label><button class="applynow-closebutton" onclick="closePopup();" ><img src="'.WPJOBPORTAL_PLUGIN_URL.'/includes/images/popupcloseicon.png"/>'.__('Close','wp-job-portal').'</button></div>';
            return $msg;
        }

        $isspam = $this->validateJobFilters($jobid , $cvid);
        if($isspam === false){
            return WPJOBPORTAL_SAVE_ERROR;
        }elseif($isspam == 1){
            $action_status = 2;
        }
        $data = array();
        $data['jobid'] = $jobid;
        $data['cvid'] = $cvid;
        $data['coverletterid'] = $coverletterid;
        $data['uid'] = $uid;
        $data['action_status'] = $action_status;
        $data['apply_date'] = date('Y-m-d H:i:s');
        $row = WPJOBPORTALincluder::getJSTable('jobapply');
        $result = array();
        $alreadycheck = $this->checkAlreadyAppliedJob($data['jobid'], $data['uid']);

        if ($alreadycheck == false) {
            if(null !=$themecall) return 2;
            $msg = '<div id="notification-ok"><label id="popup_message"><img src="' . WPJOBPORTAL_PLUGIN_URL . 'includes/images/approve.png"/>' . __("You have already applied this job", "wp-job-portal") . '</label><button class="applynow-closebutton" onclick="closePopup();" ><img src="'.WPJOBPORTAL_PLUGIN_URL.'/includes/images/popupcloseicon.png"/>'.__('Close','wp-job-portal').'</button></div>';
            return $msg;
        }
        $return = WPJOBPORTAL_SAVED;
        $submitType = wpjobportal::$_config->getConfigValue('submission_type');
        if(in_array('credits', wpjobportal::$_active_addons)){
            if($submitType == 2){
                # Perlisting
                if(wpjobportal::$_config->getConfigValue('job_jobapply_price_perlisting') > 0){
                    $data['status'] = 3;
                }else{
                    $data['status'] = 1;
                }
            }elseif ($submitType == 1) {
                $data['status'] = 1;
            }elseif ($submitType == 3) {
                $package = WPJOBPORTALincluder::getJSModel('purchasehistory')->getUserPackageById($upkid,$uid,'remjobapply');
                if( !$package ){
                    return WPJOBPORTAL_SAVE_ERROR;
                }
                if( $package->expired ){
                    return WPJOBPORTAL_SAVE_ERROR;
                }
                //if Department are not unlimited & there is no remaining left
                if( $package->jobapply!=-1 && !$package->remjobapply ){ //-1 = unlimited
                    return WPJOBPORTAL_SAVE_ERROR;
                }
                $data['status'] = 1;
                $data['userpackageid'] = $upkid;
            }
        }else{
            if(isset($data) && empty($data['status'])){
                $data['status'] = 1;
            }
        }

        if (!$row->bind($data)) {
            $return = WPJOBPORTAL_SAVE_ERROR;
        }
        if (!$row->store()) {
            $return = WPJOBPORTAL_SAVE_ERROR;
        }
        $job_apply_id = $row->id;
        if(in_array('credits', wpjobportal::$_active_addons)){
            if($submitType == 3 &&  WPJOBPORTALincluder::getObjectClass('user')->isjobseeker()){
            # Transaction For Job Apply--
                $trans = WPJOBPORTALincluder::getJSTable('transactionlog');
                $arr = array();
                $arr['uid'] = $uid;
                $arr['userpackageid'] = $upkid;
                $arr['recordid'] = $row->id;
                $arr['type'] = 'jobapply';
                $arr['created'] = current_time('mysql');
                $arr['status'] = 1;
                $trans->bind($arr);
                $trans->store();
            }
        }

        if ($return != WPJOBPORTAL_SAVE_ERROR) {
            if($submitType == 2){
                if(wpjobportal::$_config->getConfigValue('job_jobapply_price_perlisting') > 0){
                    $arr = array('wpjobportalme'=>'purchasehistory','wpjobportallt'=>'payjobapply','wpjobportalid'=>$row->jobid,'wpjobportalpageid'=>wpjobportal::getPageid());
                    $msg = '<div id="notification-ok"><label id="popup_message"><img src="' . WPJOBPORTAL_PLUGIN_URL . 'includes/images/approve.png"/>' . __("Job has been Pending Due to Payment", "wp-job-portal") . '</label><a class="wjportal-job-act-btn" href='. esc_url(wpjobportal::makeUrl($arr)).' title='. esc_attr(__('make payment','wp-job-portal')).'>
                                '. esc_html(__('Make Payment To Apply', 'wp-job-portal')).'
                        </a>
                    </div>';
                    $return = 3;
                }else{
                    $msg = '<div id="notification-ok"><label id="popup_message"><img src="' . WPJOBPORTAL_PLUGIN_URL . 'includes/images/approve.png"/>' . __("Job has been applied", "wp-job-portal") . '</label><button class="applynow-closebutton" onclick="closePopup();" ><img src="'.WPJOBPORTAL_PLUGIN_URL.'/includes/images/popupcloseicon.png"/>'.__('Close','wp-job-portal').'</button></div>';
                    $this->sendMail($jobid,$cvid,$job_apply_id);
                }
            }else{
                $msg = '<div id="notification-ok"><label id="popup_message"><img src="' . WPJOBPORTAL_PLUGIN_URL . 'includes/images/approve.png"/>' . __("Job has been applied", "wp-job-portal") . '</label><button class="applynow-closebutton" onclick="closePopup();" ><img src="'.WPJOBPORTAL_PLUGIN_URL.'/includes/images/popupcloseicon.png"/>'.__('Close','wp-job-portal').'</button></div>';
                $this->sendMail($jobid,$cvid,$job_apply_id);
            }
            $uid = wpjobportal::$_common->getUidByObjectId('job', $row->jobid);
        } else {
            $msg = '<div id="notification-not-ok"><label id="popup_message"><img src="' . WPJOBPORTAL_PLUGIN_URL . 'includes/images/unpublish.png"/>' . __("Failed while performing this action", "wp-job-portal") . '</label><button class="applynow-closebutton" onclick="closePopup();" ><img src="'.WPJOBPORTAL_PLUGIN_URL.'/includes/images/popupcloseicon.png"/>'.__('Close','wp-job-portal').'</button></div>';
        }
        if(null !=$themecall) return $return;
        return $msg;
    }

    private function sendMail($jobid, $resumeid,$jobapplyid = '') {
        //this code is not moved into email template model bcz of its high complextiy and low usage

        if ($jobid)
            if ((is_numeric($jobid) == false) || ($jobid == 0) || ($jobid == ''))
                return false;
        if ($resumeid)
            if ((is_numeric($resumeid) == false) || ($resumeid == 0) || ($resumeid == ''))
                return false;
        if ($jobapplyid)
            if ((is_numeric($jobapplyid) == false) || ($jobapplyid == 0) || ($jobapplyid == ''))
                return false;


        $jobquery = "SELECT company.name AS companyname, company.contactemail AS email, job.title, job.sendemail
            FROM `".wpjobportal::$_db->prefix."wj_portal_companies` AS company
            JOIN `".wpjobportal::$_db->prefix."wj_portal_jobs` AS job ON job.companyid = company.id
            WHERE job.id = " . $jobid;

        $jobuser = wpjobportaldb::get_row($jobquery);

        $userquery = "SELECT CONCAT(first_name,' ',last_name) AS name, email_address AS email,application_title FROM `".wpjobportal::$_db->prefix."wj_portal_resume`
            WHERE id = " . $resumeid;
        $user = wpjobportaldb::get_row($userquery);
        $emailconfig = wpjobportal::$_config->getConfigByFor('email');

//MAIL TO ADMIN ON JOBAPPLY
        $templatefor = 'jobapply-jobapply';
        $query = "SELECT template.* FROM `".wpjobportal::$_db->prefix."wj_portal_emailtemplates` AS template WHERE template.templatefor = '" . $templatefor . "'";

        $template = wpjobportaldb::get_row($query);
        $msgSubject = $template->subject;
        $msgBody = $template->body;

        $ApplicantName = $user->name;
        $EmployerEmail = $emailconfig['adminemailaddress'];
        $EmployerName = $user->name;
        $JobTitle = $jobuser->title;
        $siteTitle = wpjobportal::$_config->getConfigValue('title');

        $msgSubject = wpjobportalphplib::wpJP_str_replace('{JOBSEEKER_NAME}', $ApplicantName, $msgSubject);
        $msgSubject = wpjobportalphplib::wpJP_str_replace('{EMPLOYER_NAME}', $EmployerName, $msgSubject);
        $msgSubject = wpjobportalphplib::wpJP_str_replace('{JOB_TITLE}', $JobTitle, $msgSubject);
        $msgBody = wpjobportalphplib::wpJP_str_replace('{JOBSEEKER_NAME}', $ApplicantName, $msgBody);
        $msgBody = wpjobportalphplib::wpJP_str_replace('{EMPLOYER_NAME}', $EmployerName, $msgBody);
        $msgBody = wpjobportalphplib::wpJP_str_replace('{JOB_TITLE}', $JobTitle, $msgBody);

        // fatal error cause setting up string type variable as a array
        // $msgSubject['{SITETITLE}'] = $siteTitle;
        // $msgBody['{SITETITLE}'] = $siteTitle;
        // $msgBody['{EMAIL}'] = $EmployerEmail;
        // $msgBody['{CURRENT_YEAR}'] = date('Y');

        $msgSubject = wpjobportalphplib::wpJP_str_replace('{SITETITLE}', $siteTitle, $msgSubject);
        $msgBody = wpjobportalphplib::wpJP_str_replace('{SITETITLE}', $siteTitle, $msgBody);
        $msgBody = wpjobportalphplib::wpJP_str_replace('{EMAIL}', $EmployerEmail, $msgBody);
        $msgBody = wpjobportalphplib::wpJP_str_replace('{CURRENT_YEAR}', date('Y'), $msgBody);
        if(in_array('coverletter', wpjobportal::$_active_addons)){
            $jobquery = "SELECT jobapply.coverletterid
            FROM `".wpjobportal::$_db->prefix."wj_portal_jobapply` AS jobapply
            WHERE jobapply.id = " . $jobapplyid;
            $coverletterid = wpjobportaldb::get_var($jobquery);
            $coverletdata = WPJOBPORTALincluder::getJSModel('coverletter')->getCoverLetterTitleDescFromID($coverletterid);
            $msgBody = wpjobportalphplib::wpJP_str_replace('{COVER_LETTER_DESCRIPTION}', $coverletdata->description, $msgBody);
        }else{
            $msgBody = wpjobportalphplib::wpJP_str_replace('{COVER_LETTER_DESCRIPTION}', '&nbsp;', $msgBody);
        }

        $emailstatus = WPJOBPORTALincluder::getJSModel('emailtemplatestatus')->getEmailTemplateStatus('jobapply_jobapply');
        $senderName = $emailconfig['mailfromname'];
        $senderEmail = $emailconfig['mailfromaddress'];
        $resume_data = $this->prepareResumeDataForEmployer($resumeid);
        if (wpjobportalphplib::wpJP_strstr($msgBody, '{RESUME_DATA}')) {
            $msgBody = wpjobportalphplib::wpJP_str_replace('{RESUME_DATA}', $resume_data, $msgBody);
        }
            $parsed_url_admin = admin_url('admin.php?page=wpjobportal_resume&wpjobportallt=viewresume&wpjobportalid='.$resumeid);
            //$applied_resume_link_admin = '<br><a href="' . $parsed_url_admin . '" target="_blank" >' . __('Resume','wp-job-portal') . '</a>';
            $msgBody = wpjobportalphplib::wpJP_str_replace('{RESUME_LINK}', $parsed_url_admin , $msgBody);
            $recevierEmail = $EmployerEmail;
            $subject = $msgSubject;
            $body = $msgBody;
        if ($emailstatus->admin == 1) {
            $datadirectory = wpjobportal::$_config->getConfigurationByConfigName('data_directory');
            $resumeFiles = WPJOBPORTALincluder::getJSModel('resume')->getResumeFilesByResumeId($resumeid);
            $attachments = '';
            if (!empty($resumeFiles)) {
                $attachments = array();
                foreach ($resumeFiles as $resumeFile) {
                    $iddir = 'resume_' . $resumeid;
                    $wpdir = wp_upload_dir();
                    $path = $wpdir['baseurl'] . '/' . $datadirectory;
                    $path = $path . '/data/jobseeker/' . $iddir . '/resume/' . $resumeFile->filename;
                    $attachments[] = $path;
                }
            }
            wpjobportal::$_common->sendEmail($recevierEmail, $subject, $body, $senderEmail, $senderName, $attachments);
        }
    //MAIL TO EMPLOYER
        $templatefor = 'jobapply-employer';
        $query = "SELECT template.* FROM `".wpjobportal::$_db->prefix."wj_portal_emailtemplates` AS template WHERE template.templatefor = '" . $templatefor . "'";

        $template = wpjobportaldb::get_row($query);
        $msgSubject = $template->subject;
        $msgBody = $template->body;

        $ApplicantName = $user->name;
        $EmployerEmail = $jobuser->email;
        $EmployerName = $jobuser->companyname;
        $JobTitle = $jobuser->title;
        $siteTitle = wpjobportal::$_config->getConfigValue('title');
        $msgSubject = wpjobportalphplib::wpJP_str_replace('{JOBSEEKER_NAME}', $ApplicantName, $msgSubject);
        $msgSubject = wpjobportalphplib::wpJP_str_replace('{JOB_TITLE}', $JobTitle, $msgSubject);
        $msgSubject = wpjobportalphplib::wpJP_str_replace('{SITETITLE}', $siteTitle, $msgSubject);
        $msgBody = wpjobportalphplib::wpJP_str_replace('{SITETITLE}', $siteTitle, $msgBody);
        $msgBody = wpjobportalphplib::wpJP_str_replace('{JOBSEEKER_NAME}', $ApplicantName, $msgBody);
        $msgBody = wpjobportalphplib::wpJP_str_replace('{JOB_TITLE}', $JobTitle, $msgBody);
        $msgBody = wpjobportalphplib::wpJP_str_replace('{EMPLOYER_NAME}', $EmployerName, $msgBody);
        $msgBody = wpjobportalphplib::wpJP_str_replace('{EMAIL}', $EmployerEmail, $msgBody);
        $msgBody = wpjobportalphplib::wpJP_str_replace('{CURRENT_YEAR}', date('Y'), $msgBody);
        if(in_array('coverletter', wpjobportal::$_active_addons)){
            $jobquery = "SELECT jobapply.coverletterid
            FROM `".wpjobportal::$_db->prefix."wj_portal_jobapply` AS jobapply
            WHERE jobapply.id = " . $jobapplyid;
            $coverletterid = wpjobportaldb::get_var($jobquery);
            $coverletdata = WPJOBPORTALincluder::getJSModel('coverletter')->getCoverLetterTitleDescFromID($coverletterid);
            $msgBody = wpjobportalphplib::wpJP_str_replace('{COVER_LETTER_DESCRIPTION}', $coverletdata->description, $msgBody);
        }else{
            $msgBody = wpjobportalphplib::wpJP_str_replace('{COVER_LETTER_DESCRIPTION}', '&nbsp;', $msgBody);
        }

        //$msgBody['{EMAIL}'] = $EmployerEmail;
        $emailconfig = wpjobportal::$_config->getConfigByFor('email');
        $senderName = $emailconfig['mailfromname'];
        $senderEmail = $emailconfig['mailfromaddress'];
        $resume_data = $this->prepareResumeDataForEmployer($resumeid);
        if (wpjobportalphplib::wpJP_strstr($msgBody, '{RESUME_DATA}')) {
            $msgBody = wpjobportalphplib::wpJP_str_replace('{RESUME_DATA}', $resume_data, $msgBody);
        }
        $parsed_url = wpjobportal::makeUrl(array('wpjobportalme'=>'resume', 'wpjobportallt'=>'viewresume','wpjobportalid'=>$resumeid,'wpjobportalpageid'=>wpjobportal::getPageid()));

        // to handle job apply action status
        $jobquery = "SELECT jobapply.action_status
            FROM `".wpjobportal::$_db->prefix."wj_portal_jobapply` AS jobapply
            WHERE jobapply.id = " . $jobapplyid;
        $job_apply_action_status = wpjobportaldb::get_var($jobquery);

        $applied_resume_status = '';
        if(isset($job_apply_action_status) &&  $job_apply_action_status != ''){
            switch ($job_apply_action_status) {
                case 1:
                    $applied_resume_status = __('Inbox','wp-job-portal');
                break;
                case 2:
                    $applied_resume_status = __('Spam','wp-job-portal');
                break;
                case 3:
                    $applied_resume_status = __('Hired','wp-job-portal');
                break;
                case 4:
                    $applied_resume_status = __('Rejected','wp-job-portal');
                break;
                case 5:
                    $applied_resume_status = __('Short listed','wp-job-portal');
                break;
            }
        }


        //$applied_resume_link = '<br><a href="' . $parsed_url . '" target="_blank" >' . __('Resume','wp-job-portal') . '</a>';
        $msgBody = wpjobportalphplib::wpJP_str_replace('{RESUME_LINK}', $parsed_url, $msgBody);
        $msgBody = wpjobportalphplib::wpJP_str_replace('{RESUME_APPLIED_STATUS}', $applied_resume_status, $msgBody);
        $recevierEmail = $EmployerEmail;
        $subject = $msgSubject;
        $body = $msgBody;
        if ($jobuser->sendemail == 1 && $emailstatus->employer == 1) {
            $attachments = '';
            wpjobportal::$_common->sendEmail($recevierEmail, $subject, $body, $senderEmail, $senderName, $attachments);
        }elseif ($jobuser->sendemail == 2 && $emailstatus->employer == 1) {
            $datadirectory = wpjobportal::$_config->getConfigurationByConfigName('data_directory');
            $resumeFiles = WPJOBPORTALincluder::getJSModel('resume')->getResumeFilesByResumeId($resumeid);
            if (!empty($resumeFiles) && isset($resumeFiles)) {
                $attachments = array();
                foreach ($resumeFiles as $resumeFile) {
                    $iddir = 'resume_' . $resumeid;
                    $wpdir = wp_upload_dir();
                    $path = $wpdir['baseurl'] . '/' . $datadirectory;
                    $path = $path . '/data/jobseeker/' . $iddir . '/resume/' . $resumeFile->filename;
                    $attachments[] = $path;
                }
            }
            wpjobportal::$_common->sendEmail($recevierEmail, $subject, $body, $senderEmail, $senderName, $attachments);
        }

    // MAIL TO JOB SEEKER
        $templatefor = 'jobapply-jobseeker';
        $query = "SELECT template.* FROM `".wpjobportal::$_db->prefix."wj_portal_emailtemplates` AS template WHERE template.templatefor = '" . $templatefor . "'";
        $template = wpjobportaldb::get_row($query);
        $msgSubject = $template->subject;
        $msgBody = $template->body;

        $applied_resume_status = '';
        $jobquery = "SELECT jobapply.action_status
            FROM `".wpjobportal::$_db->prefix."wj_portal_jobapply` AS jobapply
            WHERE jobapply.id = " . $jobapplyid;
        $job_apply_action_status = wpjobportaldb::get_var($jobquery);

        if(isset($job_apply_action_status) &&  $job_apply_action_status != ''){
            switch ($job_apply_action_status) {
                case 1:
                    $applied_resume_status = __('Inbox','wp-job-portal');
                break;
                case 2:
                    $applied_resume_status = __('Spam','wp-job-portal');
                break;
                case 3:
                    $applied_resume_status = __('Hired','wp-job-portal');
                break;
                case 4:
                    $applied_resume_status = __('Rejected','wp-job-portal');
                break;
                case 5:
                    $applied_resume_status = __('Short listed','wp-job-portal');
                break;
            }
        }
        $msgSubject = wpjobportalphplib::wpJP_str_replace('{JOB_TITLE}', $JobTitle, $msgSubject);
        $msgSubject = wpjobportalphplib::wpJP_str_replace('{SITETITLE}', $siteTitle, $msgSubject);
        $msgBody = wpjobportalphplib::wpJP_str_replace('{SITETITLE}', $siteTitle, $msgBody);
        $msgBody = wpjobportalphplib::wpJP_str_replace('{JOBSEEKER_NAME}', $ApplicantName, $msgBody);
        $msgBody = wpjobportalphplib::wpJP_str_replace('{JOB_TITLE}', $JobTitle, $msgBody);
        $msgBody = wpjobportalphplib::wpJP_str_replace('{RESUME_APPLIED_STATUS}', $applied_resume_status, $msgBody);
        $msgBody = wpjobportalphplib::wpJP_str_replace('{RESUME_TITLE}', $user->application_title, $msgBody);
        $msgBody = wpjobportalphplib::wpJP_str_replace('{COMPANY_NAME}', $jobuser->companyname, $msgBody);
        $msgBody = wpjobportalphplib::wpJP_str_replace('{EMAIL}', $user->email, $msgBody);
        $msgBody = wpjobportalphplib::wpJP_str_replace('{CURRENT_YEAR}', date('Y'), $msgBody);
        $subject = $msgSubject;
        $body = $msgBody;
        $recevierEmail = $user->email;
        $attachments ='';
        if($emailstatus->jobseeker == 1){
            wpjobportal::$_common->sendEmail($recevierEmail, $subject, $body, $senderEmail, $senderName, $attachments);
        }
        return true;
    }


    function checkAlreadyAppliedJob($jobid, $uid) {
        if (!is_numeric($jobid))
            return false;
        if (!is_numeric($uid))
            return false;
        unset($result);
        $query = "SELECT COUNT(id) FROM `" . wpjobportal::$_db->prefix . "wj_portal_jobapply` WHERE jobid = " . $jobid . " AND uid = " . $uid;
        $result = wpjobportal::$_db->get_var($query);
        if ($result == 0) {
            return true;
        } else {
            return false;
        }
    }

    function checkjobappllystats($jobid,$uid){
        if (!is_numeric($jobid))
            return false;
        if (!is_numeric($uid))
            return false;
        unset($result);
        $query = "SELECT COUNT(id) FROM `" . wpjobportal::$_db->prefix . "wj_portal_jobapply` WHERE jobid = " . $jobid . " AND uid = " . $uid ." and status = 3";
        $result = wpjobportal::$_db->get_var($query);
        if ($result == 0) {
            return true;
        } else {
            return false;
        }
    }

    function getEmailFieldsJobManager(){
        $email = WPJOBPORTALrequest::getVar('em');
        $resumeid = WPJOBPORTALrequest::getVar('resumeid');
        $html = '<div class="'.$this->class_prefix.'-sendemail-form">
                    <form class="">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">'. __('Job seeker', 'job-portal'). ':</label>
                                <input type="text" id="jobseeker" class="form-control" value="' . $email . '" disabled >
                            </div>
                            <div class="form-group">
                                <label for="exampleInputName2">'. __('Subject', 'job-portal'). ':</label>
                                <input type="text" id="subject" class="form-control" placeholder="' . __('Subject', 'job-portal') . '">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputName2">'. __('Sender Email', 'job-portal'). ':</label>
                                <input type="email" id="sender"  class="form-control " placeholder="'. __('Sender Email', 'job-portal'). '">
                            </div>
                        </div>
                        <div class="col-md-4 '.$this->class_prefix.'-ar-se">
                            <div class="form-group">
                                <textarea id="email-body" placeholder="' . __('Type here', 'job-portal') . '" class="form-control note-txt" rows="8"></textarea>
                            </div>
                        </div>
                        <div class="col-md-4 '.$this->class_prefix.'-sendemail-btn-wrp">
                            <div class="form-group '.$this->class_prefix.'-sendemail-btn-data">
                                <input type="button" class="form-control '.$this->class_prefix.'-sendemail-btn" value="' . __('Send', 'job-portal') . '" onclick="sendEmail('.$resumeid.')">
                                <input type="button" class="form-control '.$this->class_prefix.'-sendemail-btn" onclick="closeSection()" value="' . __('Cancel', 'job-portal') . '">
                            </div>
                        </div>
                    </form>
                </div>';
        return $html;
    }


    private function validateJobFilters($jobid , $cvid ){

        if( (! is_numeric($jobid)) || (! is_numeric($cvid)) )
            return false;

        $isspam = 0;

        $query = "SELECT job.raf_gender AS gender, job.raf_location AS location, job.raf_education AS education, job.raf_category AS category, job.raf_experience AS experience
                    FROM `" . wpjobportal::$_db->prefix . "wj_portal_jobs` AS job
                    WHERE job.id = ".$jobid;
        $job_filters = wpjobportaldb::get_row($query);
        if($job_filters){
            $query = "SELECT job.educationid,job.jobcategory,job.city
                    FROM `".wpjobportal::$_db->prefix."wj_portal_jobs` AS job
                    WHERE job.id = " . $jobid;
            $job = wpjobportaldb::get_row($query);

            $query = "SELECT resume.gender,resume.job_category,address.address_city
                    FROM `".wpjobportal::$_db->prefix."wj_portal_resume` AS resume
                    LEFT JOIN `".wpjobportal::$_db->prefix."wj_portal_resumeaddresses` AS address ON resume.id = address.resumeid
                    WHERE resume.id = " . $cvid;
            $resume = wpjobportaldb::get_row($query);

            if($job_filters->gender == 1){
                if($job->gender != $resume->gender)
                    $isspam = 1;
            }
            if($job_filters->category == 1){
                if($job->jobcategory != $resume->job_category)
                    $isspam = 1;
            }
            if($job_filters->education == 1){
                if($job->educationid != $resume->heighestfinisheducation)
                    $isspam = 1;
            }
            if($job_filters->location == 1){
                $joblocation = wpjobportalphplib::wpJP_explode(',', $job->city);
                if(! in_array($resume->address_city, $joblocation))
                    $isspam = 1;
            }
        }

        return $isspam;
    }


    function getOrdering() {
        $sort = WPJOBPORTALrequest::getVar('sortby', '');
        $this->getListOrdering($sort);
        $this->getListSorting($sort);
    }

    function getMyAppliedJobs($uid) {
        if (!is_numeric($uid)) return false;

        WPJOBPORTALincluder::getJSModel('job')->sorting();
        $query = "SELECT COUNT(jobapply.id)
                 FROM `" . wpjobportal::$_db->prefix . "wj_portal_jobapply` AS jobapply
                 JOIN `" . wpjobportal::$_db->prefix . "wj_portal_jobs` AS job ON job.id = jobapply.jobid
                 JOIN `" . wpjobportal::$_db->prefix . "wj_portal_resume` AS resume ON resume.id = jobapply.cvid
                 JOIN `" . wpjobportal::$_db->prefix . "wj_portal_companies` AS company ON company.id = job.companyid
                 JOIN `" . wpjobportal::$_db->prefix . "wj_portal_categories` AS category ON category.id = job.jobcategory
                 JOIN `" . wpjobportal::$_db->prefix . "wj_portal_jobtypes` AS jobtype ON jobtype.id = job.jobtype
                 WHERE jobapply.uid = " . $uid;
        $total = wpjobportaldb::get_var($query);
        wpjobportal::$_data['total'] = $total;
        wpjobportal::$_data[1] = WPJOBPORTALpagination::getPagination($total,'appliedjobs');
        $query = "SELECT job.id AS jobid,job.city,job.title,job.noofjobs,job.currency,CONCAT(job.alias,'-',job.id) AS jobaliasid ,CONCAT(company.alias,'-',companyid) AS companyaliasid, job.serverid,job.status,job.endfeatureddate,job.isfeaturedjob,job.startpublishing,job.stoppublishing,
                 jobapply.action_status AS resumestatus,jobapply.apply_date,
                 company.id AS companyid, company.name AS companyname,company.logofilename,category.cat_title,
                 jobtype.title AS jobtypetitle, jobstatus.title AS jobstatustitle,resume.id AS resumeid,resume.salaryfixed as salary,resume.application_title,job.params,job.created,LOWER(jobtype.title) AS jobtype
                ,jobapply.id AS id,resume.first_name,resume.last_name,job.salarytype,job.salarymin,job.salarymax,jobapply.status AS applystatus,
                salaryrangetype.title AS srangetypetitle,jobtype.color AS jobtypecolor, jobapply.coverletterid
                 FROM `" . wpjobportal::$_db->prefix . "wj_portal_jobapply` AS jobapply
                 JOIN `" . wpjobportal::$_db->prefix . "wj_portal_jobs` AS job ON job.id = jobapply.jobid
                 JOIN `" . wpjobportal::$_db->prefix . "wj_portal_resume` AS resume ON resume.id = jobapply.cvid
                 JOIN `" . wpjobportal::$_db->prefix . "wj_portal_companies` AS company ON company.id = job.companyid
                 JOIN `" . wpjobportal::$_db->prefix . "wj_portal_categories` AS category ON category.id = job.jobcategory
                 JOIN `" . wpjobportal::$_db->prefix . "wj_portal_jobtypes` AS jobtype ON jobtype.id = job.jobtype
                 LEFT JOIN `" . wpjobportal::$_db->prefix . "wj_portal_cities` AS city ON job.city = city.id
                 LEFT JOIN `" . wpjobportal::$_db->prefix . "wj_portal_jobstatus` AS jobstatus ON jobstatus.id = job.jobstatus
                 LEFT JOIN `" . wpjobportal::$_db->prefix . "wj_portal_salaryrangetypes` AS salaryrangetype ON salaryrangetype.id = job.salaryduration
                 WHERE jobapply.uid = " . $uid;
        $query.= " ORDER BY " . wpjobportal::$_data['sorting'];
        $query.=" LIMIT " . WPJOBPORTALpagination::$_offset . "," . WPJOBPORTALpagination::$_limit;
        $results = wpjobportaldb::get_results($query);
        $data = array();
        foreach ($results AS $d) {
            $d->location = WPJOBPORTALincluder::getJSModel('city')->getLocationDataForView($d->city);
            if(in_array('coverletter', wpjobportal::$_active_addons)){
                $d->coverlettertitle = WPJOBPORTALincluder::getJSModel('coverletter')->getCoverLetterTitleFromID($d->coverletterid);
            }
            $data[] = $d;
        }
        $results = $data;
        $data = array();
        foreach ($results AS $d) {
            $data[] = $d;
        }
        wpjobportal::$_data[0] = $data;
        wpjobportal::$_data['fields'] = wpjobportal::$_wpjpfieldordering->getFieldsOrderingforForm(2);
        wpjobportal::$_data['config'] = wpjobportal::$_config->getConfigByFor('job');
        return;
    }

    function getListOrdering($sort) {
        switch ($sort) {
          case 'newest':
                wpjobportal::$_ordering = "resumeid DESC";
                wpjobportal::$_sorton = "newest";
                wpjobportal::$_sortorder = "DESC";
                break;
            case 'salary':
                wpjobportal::$_ordering = "app.salaryfixed DESC";
                wpjobportal::$_sorton = "salary";
                wpjobportal::$_sortorder = "DESC";
                break;
            case 'newestdesc':
                wpjobportal::$_ordering = "resumeid DESC";
                wpjobportal::$_sorton = "newest";
                wpjobportal::$_sortorder = "DESC";
                break;
            case 'newestasc':
                wpjobportal::$_ordering = "resumeid ASC";
                wpjobportal::$_sorton = "newest";
                wpjobportal::$_sortorder = "ASC";
                break;
            default: wpjobportal::$_ordering = "job.title DESC";
            break;
        }
        return;
    }

    function getListSorting($sort) {
        wpjobportal::$_sortlinks['title'] = $this->getSortArg("title", $sort);
        wpjobportal::$_sortlinks['category'] = $this->getSortArg("category", $sort);
        wpjobportal::$_sortlinks['jobtype'] = $this->getSortArg("jobtype", $sort);
        wpjobportal::$_sortlinks['jobstatus'] = $this->getSortArg("jobstatus", $sort);
        wpjobportal::$_sortlinks['company'] = $this->getSortArg("company", $sort);
        wpjobportal::$_sortlinks['salary'] = $this->getSortArg("salary", $sort);
        wpjobportal::$_sortlinks['posted'] = $this->getSortArg("posted", $sort);
        wpjobportal::$_sortlinks['newest'] = $this->getSortArg("newest",$sort);
        return;
    }

    function getSortArg($type, $sort) {
        $mat = array();
        if (wpjobportalphplib::wpJP_preg_match("/(\w+)(asc|desc)/i", $sort, $mat)) {
            if ($type == $mat[1]) {
                return ( $mat[2] == "asc" ) ? "{$type}desc" : "{$type}asc";
            } else {
                return $type . $mat[2];
            }
        }
        if(WPJOBPORTALrequest::getVar('wpjobportallt')=="jobappliedresume"){
            return "newestasc";
        }else{
        return "iddesc";
        }
    }

   function setJobApplyRating() {
        $jobapplyid = WPJOBPORTALrequest::getVar('jobapplyid');
        if (!is_numeric($jobapplyid))
            return false;
        $newrating = WPJOBPORTALrequest::getVar('newrating');

        $row = WPJOBPORTALincluder::getJSTable('jobapply');
        if ($row->update(array('id' => $jobapplyid , 'rating' => $newrating))){
            return true;
        } else {
            return false;
        }
    }

    function prepareResumeDataForEmployer($resumeid) {
        $send_only_filled_fields = wpjobportal::$_config->getConfigByFor('employer_resume_alert_fields');
        $show_only_section_that_have_value = wpjobportal::$_config->getConfigByFor('show_only_section_that_have_value');

        WPJOBPORTALincluder::getJSModel('resume')->getResumebyId($resumeid);
        $personalInfo = wpjobportal::$_data[0]['personal_section'];
        $addresses = wpjobportal::$_data[0]['address_section'];
        $institutes = wpjobportal::$_data[0]['institute_section'];
        $employers = wpjobportal::$_data[0]['employer_section'];
        $languages = wpjobportal::$_data[0]['language_section'];
        $show_contact_detail =  wpjobportal::$_data['resumecontactdetail'];

        $userfields = ''; // Ask form Shees
        $fieldsordering = wpjobportal::$_wpjpfieldordering->getFieldsOrderingforForm(3); // resume fields
        wpjobportal::$_data[2] = array();
        foreach ($fieldsordering AS $field) {
            wpjobportal::$_data['fieldtitles'][$field->field] = $field->fieldtitle;
            wpjobportal::$_data[2][$field->section][$field->field] = $field->published;
        }
        $fieldsordering = wpjobportal::$_data[2];
        $msgBody = "<table cellpadding='5' style='border-color: #666;' cellspacing='0' border='0' width='100%'>";

        $temp_body = '';
        $flag = 0;
        if(isset($fieldsordering[1]))
        foreach ($fieldsordering[1] as $field => $required) {
            switch ($field) {
                case "section_personal":
                    $temp_body .= "<tr style='background: #eee;'>";
                    $temp_body .= "<td colspan='2' align='center'><strong>" . __('Personal Information','wp-job-portal') . "</strong></td></tr>";
                    break;
                case "application_title":
                    $this->getRowForResume(__('Application title','wp-job-portal'), $personalInfo->application_title, $temp_body, $required,$send_only_filled_fields , $flag);
                    break;
                case "first_name":
                    $this->getRowForResume(__('First name','wp-job-portal'), $personalInfo->first_name, $temp_body, $required,$send_only_filled_fields , $flag);
                    break;
                case "last_name":
                    $this->getRowForResume(__('Last name','wp-job-portal'), $personalInfo->last_name, $temp_body, $required,$send_only_filled_fields , $flag);
                    break;
                case "email_address":
                    if($show_contact_detail){
                        $this->getRowForResume(__('Email address','wp-job-portal'), $personalInfo->email_address, $temp_body, $required,$send_only_filled_fields , $flag);
                    }
                    break;
                case "cell":
                    if($show_contact_detail){
                        $this->getRowForResume(__('Cell','wp-job-portal'), $personalInfo->cell, $temp_body, $required,$send_only_filled_fields , $flag);
                    }
                    break;
                case "gender":
                    $genderText = ($personalInfo->gender == 1) ? __('Male','wp-job-portal') : __('Female','wp-job-portal');
                    $this->getRowForResume(__('Gender','wp-job-portal'), $genderText, $temp_body, $required,$send_only_filled_fields , $flag);
                    break;
                case "nationality":
                    $this->getRowForResume(__('Country','wp-job-portal'), $personalInfo->nationality, $temp_body, $required,$send_only_filled_fields , $flag);
                    break;
                case "category":
                    $this->getRowForResume(__('Category','wp-job-portal'), $personalInfo->categorytitle, $temp_body, $required,$send_only_filled_fields , $flag);
                    break;

                case "salaryfixed":
                    $salary = $personalInfo->salaryfixed;
                    $this->getRowForResume(__('Salary','wp-job-portal'), $salary, $temp_body, $required,$send_only_filled_fields , $flag);
                    break;

                case "jobtype":
                    $this->getRowForResume(__('Work preference','wp-job-portal'), $personalInfo->jobtypetitle, $temp_body, $required,$send_only_filled_fields , $flag);
                    break;
                default:
                    $data = apply_filters('wpjobportal_addons_show_customfields_params',false,$field,11,$personalInfo->params);
                    if(!empty($data)){
                        if($send_only_filled_fields == 1){
                            if(! empty($data['value'])){
                                $temp_body .= "<tr style='background: #eee;'>";
                                $temp_body .= "<td><strong>" . $data['title'] . "</strong></td>";
                                $temp_body .= "<td>" . $data['value'] . "</td></tr>";
                            }
                        }else{
                            if(is_array($data)){
                                $temp_body .= "<tr style='background: #eee;'>";
                                $temp_body .= "<td><strong>" . $data['title'] . "</strong></td>";
                                $temp_body .= "<td>" . $data['value'] . "</td></tr>";
                            }
                        }
                    }
                break;
            }
        }
        if($show_only_section_that_have_value == 1){
            if($flag > 0){
                $msgBody .= $temp_body;
            }
        }else{
            $msgBody .= $temp_body;
        }

        $flag = 0;
        $temp_body = '';

        $i = 0;
        $temp_body .= "<tr style='background: #eee;'>";
        $temp_body .= "<td colspan='2' align='center'><strong>" . __('Address','wp-job-portal') . "</strong></td></tr>";
        if(isset($addresses) && is_array($addresses))
        foreach ($addresses as $address) {
            $i++;
            foreach ($fieldsordering[2] as $field => $required) {
                switch ($field) {
                    case "section_address":
                        if ($required == 1) {
                            $temp_body .= "<tr style='background: #eee;'>";
                            $temp_body .= "<td colspan='2' align='center'><strong>" . __('Address','wp-job-portal') . "-" . $i . "</strong></td></tr>";
                        }
                        break;
                    case "address_city":
                        $this->getRowForResume(__('City'), $address->cityname, $temp_body, $required,$send_only_filled_fields , $flag);
                        break;
                    case "address":
                        $this->getRowForResume(__('Address','wp-job-portal'), $address->address, $temp_body, $required,$send_only_filled_fields , $flag);
                        break;
                    default:
                        $data = apply_filters('wpjobportal_addons_show_customfields_params',false,$field,11,$address->params);
                        if(!empty($data)){
                            if($send_only_filled_fields == 1){
                                if(! empty($data['value'])){
                                    $temp_body .= "<tr style='background: #eee;'>";
                                    $temp_body .= "<td><strong>" . $data['title'] . "</strong></td>";
                                    $temp_body .= "<td>" . $data['value'] . "</td></tr>";
                                }
                            }else{
                                $temp_body .= "<tr style='background: #eee;'>";
                                $temp_body .= "<td><strong>" . $data['title'] . "</strong></td>";
                                $temp_body .= "<td>" . $data['value'] . "</td></tr>";
                            }
                        }
                        break;
                }
            }
        }

        if($show_contact_detail){
            if($show_only_section_that_have_value == 1){
                if($flag > 0){
                    $msgBody .= $temp_body;
                }
            }else{
                $msgBody .= $temp_body;
            }
        }

        $flag = 0;
        $temp_body = '';

        $i = 0;
        $temp_body .= "<tr style='background: #eee;'>";
        $temp_body .= "<td colspan='2' align='center'><strong>" . __('Institutes','wp-job-portal') . "</strong></td></tr>";
        if(isset($institutes) && is_array($institutes))
        foreach ($institutes as $institute) {
            $i++;
            foreach ($fieldsordering[3] as $field => $required) {
                switch ($field) {
                    case "section_education":
                        if ($required == 1) {
                            $temp_body .= "<tr style='background: #eee;'>";
                            $temp_body .= "<td colspan='2' align='center'><strong>" . __('Institute','wp-job-portal') . "-" . $i . "</strong></td></tr>";
                        }
                        break;
                    case "institute":
                        $this->getRowForResume(__('Institution Name','wp-job-portal'), $institute->institute, $temp_body, $required,$send_only_filled_fields , $flag);
                        break;
                    case "institute_city":
                        // institute table does not have city field
                        //$this->getRowForResume(__('City'), $institute->cityname, $temp_body, $required,$send_only_filled_fields , $flag);
                        break;
                    case "institute_certificate":
                        $this->getRowForResume(__('Cert/deg/oth'), $institute->institute_certificate, $temp_body, $required,$send_only_filled_fields , $flag);
                        break;
                    default:
                        $data = apply_filters('wpjobportal_addons_show_customfields_params',false,$field,11,$institute->params);
                        if(!empty($data)){
                            if($send_only_filled_fields == 1){
                                if(! empty($data['value'])){
                                    $temp_body .= "<tr style='background: #eee;'>";
                                    $temp_body .= "<td><strong>" . $data['title'] . "</strong></td>";
                                    $temp_body .= "<td>" . $data['value'] . "</td></tr>";
                                }
                            }else{
                                $temp_body .= "<tr style='background: #eee;'>";
                                $temp_body .= "<td><strong>" . $data['title'] . "</strong></td>";
                                $temp_body .= "<td>" . $data['value'] . "</td></tr>";
                            }
                        }
                        break;
                }
            }
        }

        if($show_only_section_that_have_value == 1){
            if($flag > 0){
                $msgBody .= $temp_body;
            }
        }else{
            $msgBody .= $temp_body;
        }

        $flag = 0;
        $temp_body = '';

        $i = 0;
        $temp_body .= "<tr style='background: #eee;'>";
        $temp_body .= "<td colspan='2' align='center'><strong>" . __('Employers','wp-job-portal') . "</strong></td></tr>";
        if(isset($employers) && is_array($employers))
        foreach ($employers as $employer) {
            $i++;
            foreach ($fieldsordering[4] as $field => $required) {
                switch ($field) {
                    case "section_employer":
                        if ($required == 1) {
                            $temp_body .= "<tr style='background: #eee;'>";
                            $temp_body .= "<td colspan='2' align='center'><strong>" . __('Employer','wp-job-portal') . "-" . $i . "</strong></td></tr>";
                        }
                        break;
                    case "employer":
                        $this->getRowForResume(__('Employer','wp-job-portal'), $employer->employer, $temp_body, $required,$send_only_filled_fields , $flag);
                        break;
                    case "employer_position":
                        $this->getRowForResume(__('Position','wp-job-portal'), $employer->employer_position, $temp_body, $required,$send_only_filled_fields , $flag);
                        break;
                    case "employer_from_date":
                        $this->getRowForResume(__('From Date','wp-job-portal'), $employer->employer_from_date, $temp_body, $required,$send_only_filled_fields , $flag);
                        break;
                    case "employer_to_date":
                        $this->getRowForResume(__('To Date','wp-job-portal'), $employer->employer_to_date, $temp_body, $required,$send_only_filled_fields , $flag);
                        break;
                   case "employer_city":
                        $this->getRowForResume(__('City'), $employer->cityname, $temp_body, $required,$send_only_filled_fields , $flag);
                        break;
                    case "employer_address":
                        $this->getRowForResume(__('Address','wp-job-portal'), $employer->employer_address, $temp_body, $required,$send_only_filled_fields , $flag);
                        break;
                    case "employer_phone":
                        $this->getRowForResume(__('Phone','wp-job-portal'), $employer->employer_phone, $temp_body, $required,$send_only_filled_fields , $flag);
                        break;
                    default:
                        $data = apply_filters('wpjobportal_addons_show_customfields_params',false,$field,11,$employer->params);
                        if(!empty($data)){
                            if($send_only_filled_fields == 1){
                                if(! empty($data['value'])){
                                    $temp_body .= "<tr style='background: #eee;'>";
                                    $temp_body .= "<td><strong>" . $data['title'] . "</strong></td>";
                                    $temp_body .= "<td>" . $data['value'] . "</td></tr>";
                                }
                            }else{
                                $temp_body .= "<tr style='background: #eee;'>";
                                $temp_body .= "<td><strong>" . $data['title'] . "</strong></td>";
                                $temp_body .= "<td>" . $data['value'] . "</td></tr>";
                            }
                        }
                        break;
                }
            }
        }

        if($show_only_section_that_have_value == 1){
            if($flag > 0){
                $msgBody .= $temp_body;
            }
        }else{
            $msgBody .= $temp_body;
        }

        $flag = 0;
        $temp_body = '';

        if(isset($fieldsordering['skills']))
        foreach ($fieldsordering[5] as $field => $required) {
            switch ($field) {
                case "section_skills":
                    if ($required == 1) {
                        $temp_body .= "<tr style='background: #eee;'>";
                        $temp_body .= "<td colspan='2' align='center'><strong>" . __('Skills','wp-job-portal') . "</strong></td></tr>";
                    }
                    break;
                case "skills":
                    $this->getRowForResume(__('Skills','wp-job-portal'), $personalInfo->skills, $temp_body, $required,$send_only_filled_fields , $flag);
                    break;
                default:
                    $data = apply_filters('wpjobportal_addons_show_customfields_params',false,$field,11,$personalInfo->params);
                    if(!empty($data)){
                        if($send_only_filled_fields == 1){
                            if(! empty($data['value'])){
                                $temp_body .= "<tr style='background: #eee;'>";
                                $temp_body .= "<td><strong>" . $data['title'] . "</strong></td>";
                                $temp_body .= "<td>" . $data['value'] . "</td></tr>";
                            }
                        }else{
                            $temp_body .= "<tr style='background: #eee;'>";
                            $temp_body .= "<td><strong>" . $data['title'] . "</strong></td>";
                            $temp_body .= "<td>" . $data['value'] . "</td></tr>";
                        }
                    }
                    break;
            }
        }

        if($show_only_section_that_have_value == 1){
            if($flag > 0){
                $msgBody .= $temp_body;
            }
        }else{
            $msgBody .= $temp_body;
        }

        $flag = 0;
        $temp_body = '';


        if(isset($fieldsordering['resume']))
        foreach ($fieldsordering['resume'] as $field) {
            switch ($field) {
                case "section_resume":
                    if ($required == 1) {
                        $temp_body .= "<tr style='background: #eee;'>";
                        $temp_body .= "<td colspan='2' align='center'><strong>" . __('Resume','wp-job-portal') . "</strong></td></tr>";
                    }
                    break;
                case "resume":
                    $this->getRowForResume(__('Resume','wp-job-portal'), $personalInfo->resume, $temp_body, $required,$send_only_filled_fields , $flag);
                    break;
                default:
                    $data = apply_filters('wpjobportal_addons_show_customfields_params',false,$field,11,$personalInfo->params);
                    if(!empty($data)){
                        if($send_only_filled_fields == 1){
                            if(! empty($data['value'])){
                                $temp_body .= "<tr style='background: #eee;'>";
                                $temp_body .= "<td><strong>" . $data['title'] . "</strong></td>";
                                $temp_body .= "<td>" . $data['value'] . "</td></tr>";
                            }
                        }else{
                            $temp_body .= "<tr style='background: #eee;'>";
                            $temp_body .= "<td><strong>" . $data['title'] . "</strong></td>";
                            $temp_body .= "<td>" . $data['value'] . "</td></tr>";
                        }
                    }
                    break;
            }
        }

        if($show_only_section_that_have_value == 1){
            if($flag > 0){
                $msgBody .= $temp_body;
            }
        }else{
            $msgBody .= $temp_body;
        }

        $flag = 0;
        $temp_body = '';


        $i = 0;
        $temp_body .= "<tr style='background: #eee;'>";
        $temp_body .= "<td colspan='2' align='center'><strong>" . __('References','wp-job-portal') . "</strong></td></tr>";
        if(isset($references) && is_array($references))
            if($show_only_section_that_have_value == 1){
                if($flag > 0){
                    $msgBody .= $temp_body;
                }
            }else{
                $msgBody .= $temp_body;
            }
        $flag = 0;
        $temp_body = '';


        $i = 0;
        $temp_body .= "<tr style='background: #eee;'>";
        $temp_body .= "<td colspan='2' align='center'><strong>" . __('Language','wp-job-portal') . "</strong></td></tr>";
        if(isset($languages) && is_array($languages))
        foreach ($languages as $language) {
            $i++;
            foreach ($fieldsordering[8] as $field => $required) {
                switch ($field) {
                    case "section_language":
                        if ($required == 1) {
                            $temp_body .= "<tr style='background: #eee;'>";
                            $temp_body .= "<td colspan='2' align='center'><strong>" . __('Language','wp-job-portal') . "-" . $i . "</strong></td></tr>";
                        }
                        break;
                    case "language_name":
                        $this->getRowForResume(__('Language Name','wp-job-portal'), $language->language, $temp_body, $required,$send_only_filled_fields , $flag);
                        break;
                    default:
                        $data = apply_filters('wpjobportal_addons_show_customfields_params',false,$field,11,$language->params);
                        if(!empty($data)){
                            if($send_only_filled_fields == 1){
                                if(! empty($data['value'])){
                                    $temp_body .= "<tr style='background: #eee;'>";
                                    $temp_body .= "<td><strong>" . $data['title'] . "</strong></td>";
                                    $temp_body .= "<td>" . $data['value'] . "</td></tr>";
                                }
                            }else{
                                $temp_body .= "<tr style='background: #eee;'>";
                                $temp_body .= "<td><strong>" . $data['title'] . "</strong></td>";
                                $temp_body .= "<td>" . $data['value'] . "</td></tr>";
                            }
                        }
                        break;
                }
            }
        }

        if($show_only_section_that_have_value == 1){
            if($flag > 0){
                $msgBody .= $temp_body;
            }
        }else{
            $msgBody .= $temp_body;
        }
        $msgBody .= "</table>";

        return $msgBody;
    }

    protected function getRowForResume($title, $value, &$msgBody, $published , $send_ifnotempty , &$flag) {

        if ($published == 1) {
            if($send_ifnotempty == 1){
                if(! empty($value)){
                    $msgBody .= "<tr style='background: #eee;'>";
                    $msgBody .= "<td><strong>" . $title . "</strong></td>";
                    $msgBody .= "<td>" . $value . "</td></tr>";
                    $flag++;
                }
            }else{
                    $msgBody .= "<tr style='background: #eee;'>";
                    $msgBody .= "<td><strong>" . $title . "</strong></td>";
                    $msgBody .= "<td>" . $value . "</td></tr>";
                    $flag++;
            }

        }
    }

    protected function getUserFieldRowForResume( &$msgBody , $section) {
        $customfields = apply_filters('wpjobportal_addons_get_custom_field',false,3);
        foreach ($customfields as $field) {
            $data = apply_filters('wpjobportal_addons_show_customfields_params',false,$field,6,$section->params);
            $msgBody .= "<tr style='background: #eee;'>";
            $msgBody .= "<td><strong>" . $data['title'] . "</strong></td>";
            $msgBody .= "<td>" . $data['value'] . "</td></tr>";

        }
    }
    function canceljobapplyasvisitor(){
        wpjobportalphplib::wpJP_setcookie('wpjobportal_apply_visitor' , '' , time() - 3600 , COOKIEPATH);
        if ( SITECOOKIEPATH != COOKIEPATH ){
            wpjobportalphplib::wpJP_setcookie('wpjobportal_apply_visitor' , '' , time() - 3600 , SITECOOKIEPATH);
        }

        unset($_SESSION['wp-wpjobportal']);
        $link = wpjobportal::makeUrl(array('wpjobportalme'=>'job', 'wpjobportallt'=>'newestjobs'));
        echo esc_url($link);
        die();
    }

    function getJobByid($jobid){
        if(!is_numeric($jobid))
            return false;
        $query = "SELECT job.endfeatureddate,job.id,job.uid,job.title,job.isfeaturedjob,job.serverid,job.noofjobs,job.city,job.status,job.currency,
                CONCAT(job.alias,'-',job.id) AS jobaliasid,job.created,job.serverid,company.name AS companyname,company.id AS companyid,company.logofilename,CONCAT(company.alias,'-',company.id) AS compnayaliasid,job.salarytype,job.salarymin,job.salarymax,salaryrangetype.title AS salarydurationtitle,
                cat.cat_title, jobtype.title AS jobtypetitle,salaryrangetype.title AS srangetypetitle,jobtype.color AS jobtypecolor,
                (SELECT count(jobapply.id) FROM `" . wpjobportal::$_db->prefix . "wj_portal_jobapply` AS jobapply
                 WHERE jobapply.jobid = job.id) AS resumeapplied ,job.params,job.startpublishing,job.stoppublishing
                 ,LOWER(jobtype.title) AS jobtypetit
                FROM `" . wpjobportal::$_db->prefix . "wj_portal_jobs` AS job
                JOIN `" . wpjobportal::$_db->prefix . "wj_portal_companies` AS company ON company.id = job.companyid
                JOIN `" . wpjobportal::$_db->prefix . "wj_portal_categories` AS cat ON cat.id = job.jobcategory
                LEFT JOIN `" . wpjobportal::$_db->prefix . "wj_portal_jobtypes` AS jobtype ON jobtype.id = job.jobtype
                LEFT JOIN `" . wpjobportal::$_db->prefix . "wj_portal_salaryrangetypes` AS salaryrangetype ON salaryrangetype.id = job.salaryduration
                WHERE  job.id = " .$jobid;

        $results = wpjobportaldb::get_results($query);
        $data = array();
        foreach ($results AS $d) {
            $d->location = WPJOBPORTALincluder::getJSModel('city')->getLocationDataForView($d->city);
            $data[] = $d;
        }
        $results = $data;
       return $results;
    }

     function getMyJobs($uid,$jobid='') {
       if (!is_numeric($uid)) return false;
        # Data Query Listing
        $query = "SELECT job.endfeatureddate,job.id,job.uid,job.title,job.isfeaturedjob,job.serverid,job.noofjobs,job.city,job.status,job.currency,
                CONCAT(job.alias,'-',job.id) AS jobaliasid,job.created,job.serverid,company.name AS companyname,company.id AS companyid,company.logofilename,CONCAT(company.alias,'-',company.id) AS compnayaliasid,job.salarytype,job.salarymin,job.salarymax,salaryrangetype.title AS salarydurationtitle,
                cat.cat_title, jobtype.title AS jobtypetitle,salaryrangetype.title AS srangetypetitle,
                (SELECT count(jobapply.id) FROM `" . wpjobportal::$_db->prefix . "wj_portal_jobapply` AS jobapply
                 WHERE jobapply.jobid = job.id) AS resumeapplied ,job.params,job.startpublishing,job.stoppublishing
                 ,LOWER(jobtype.title) AS jobtypetit,jobtype.color as jobtypecolor
                FROM `" . wpjobportal::$_db->prefix . "wj_portal_jobs` AS job
                JOIN `" . wpjobportal::$_db->prefix . "wj_portal_companies` AS company ON company.id = job.companyid
                JOIN `" . wpjobportal::$_db->prefix . "wj_portal_categories` AS cat ON cat.id = job.jobcategory
                LEFT JOIN `" . wpjobportal::$_db->prefix . "wj_portal_jobtypes` AS jobtype ON jobtype.id = job.jobtype
                LEFT JOIN `" . wpjobportal::$_db->prefix . "wj_portal_salaryrangetypes` AS salaryrangetype ON salaryrangetype.id = job.salaryduration
                WHERE job.uid =". $uid  ;
                $query .= " AND job.id =".$jobid;

        # Sorting Merge In Query
        $results = wpjobportaldb::get_results($query);
        $data = array();
        foreach ($results AS $d) {
            $d->location = WPJOBPORTALincluder::getJSModel('city')->getLocationDataForView($d->city);
            $data[] = $d;
        }
        return  $data;
    }


     function sorting() {
        $pagenum = WPJOBPORTALrequest::getVar('pagenum');
        wpjobportal::$_data['sorton'] = WPJOBPORTALrequest::getVar('sorton', 'post', 6);
        wpjobportal::$_data['sortby'] = WPJOBPORTALrequest::getVar('sortby', 'post', 2);
        if($pagenum > 1 && isset($_SESSION['resume'])){
            wpjobportal::$_data['sorton'] = sanitize_key($_SESSION['resume']['sorton']);
            wpjobportal::$_data['sortby'] = sanitize_key($_SESSION['resume']['sortby']);
        }else{
            $_SESSION['resume']['sorton'] = wpjobportal::$_data['sorton'];
            $_SESSION['resume']['sortby'] = wpjobportal::$_data['sortby'];
        }
        switch (wpjobportal::$_data['sorton']) {
            case 1: // appilcation title
                wpjobportal::$_data['sorting'] = ' app.application_title ';
                break;
            case 2: // first name
                wpjobportal::$_data['sorting'] = ' app.first_name ';
                break;
            case 3: // category
                wpjobportal::$_data['sorting'] = ' cat.cat_title ';
                break;
            case 4: // job type
                wpjobportal::$_data['sorting'] = ' app.jobtype ';
                break;
            case 5: // location
                wpjobportal::$_data['sorting'] = ' city.cityName ';
                break;
            case 6: // created
                wpjobportal::$_data['sorting'] = ' app.created ';
                break;
            case 7: // status
                wpjobportal::$_data['sorting'] = ' app.status ';
                break;
        }
        if (wpjobportal::$_data['sortby'] == 1) {
            wpjobportal::$_data['sorting'] .= ' ASC ';
        } else {
            wpjobportal::$_data['sorting'] .= ' DESC ';
        }
        wpjobportal::$_data['combosort'] = wpjobportal::$_data['sorton'];
    }

    function sendEmailToJobSeeker() {
        $jobseekeremail = WPJOBPORTALrequest::getVar('jobseekerid');
        $subject = WPJOBPORTALrequest::getVar('emailsubject');
        $senderemail = WPJOBPORTALrequest::getVar('senderid');
        $mail = WPJOBPORTALrequest::getVar('mailbody');
        $return = wpjobportal::$_common->sendEmail($jobseekeremail, $subject, $mail, $senderemail, '');
        if($return == 1){
            return __('Email has been send','wp-job-portal');
        }else{
            return __('Email has not been send','wp-job-portal');
        }
    }

    function getEmailFields() {
        $email = WPJOBPORTALrequest::getVar('em');
        $resumeid = WPJOBPORTALrequest::getVar('resumeid');
        $html = '';
        if (wpjobportal::$theme_chk == 1) {
            $html.='<img id="close-section" onclick="closeSection()" src="' . WPJOBPORTAL_PLUGIN_URL . 'includes/images/no.png"/>';
            $html.='<div class="email-feilds wpj-jp-applied-resume-cnt wpj-jp-email-actions-wrp"><div class="wpj-jp-applied-resume-cnt-row">';
            $html.='<label for="jobseeker">'
                    . esc_html__('Job Seeker', 'job-portal')
                    . ' : </label>';
            $html.='<input type="text" id="jobseeker" value="' . $email . '" disabled /></div><div class="wpj-jp-applied-resume-cnt-row"><label for="subject">'
                    . esc_html__('Subject', 'job-portal') .
                    ' : </label>';
            $html.='<input type="text" id="e-subject" />';
            $html.='</div><div class="wpj-jp-applied-resume-cnt-row">';
            $html.='<label for="sender">' . esc_html__('Sender Email', 'job-portal') . '  : </label>';
            $html.='<input type="text" id="sender"  /></div>';
            $html.='<div class="wpj-jp-applied-resume-cnt-row"><textarea id="email-body" placeholder=' . esc_html__('Type here', 'job-portal') . '>';
            $html.='</textarea></div> <div class="wpj-jp-applied-resume-cnt-row"><input class="wpj-jp-outline-btn" type="button" id="send" value=' . esc_html__('Send', 'job-portal') . ' onclick="sendEmail('.$resumeid.')" /></div></div>';
        } else {
            $html.='<img id="close-section" onclick="closeSection()" src="' . WPJOBPORTAL_PLUGIN_URL . 'includes/images/no.png"/>';
            $html.='<div class="email-feilds wjportal-applied-job-actions-wrp wjportal-email-actions-wrp"><div class="wjportal-applied-job-actions-row">';
            $html.='<label for="jobseeker">'
                    . __('Job Seeker', 'wp-job-portal')
                    . ' : </label>';
            $html.='<input type="text" id="jobseeker" value="' . $email . '" disabled /></div><div class="wjportal-applied-job-actions-row"><label for="subject">'
                    . __('Subject', 'wp-job-portal') .
                    ' : </label>';
            $html.='<input type="text" id="e-subject" />';
            $html.='</div><div class="wjportal-applied-job-actions-row">';
            $html.='<label for="sender">' . __('Sender Email', 'wp-job-portal') . '  : </label>';
            $html.='<input type="text" id="sender"  /></div>';
            $html.='<div class="wjportal-applied-job-actions-row"><textarea id="email-body" placeholder=' . __('Type here', 'wp-job-portal') . '>';
            $html.='</textarea></div> <div class="wjportal-job-applied-actions-btn-wrp"><input class="wjportal-job-applied-actions-btn" type="button" id="send" value=' . __('Send', 'wp-job-portal') . ' onclick="sendEmail('.$resumeid.')" /></div></div>';
        }
        return $html;
    }

    function getJobApp($jobid){
        if(!is_numeric($jobid))
            return false;
        $query = "SELECT job.*, cat.cat_title, jobtype.title AS jobtypetitle, company.name AS companyname ,company.logofilename AS logo ,company.id AS companyid,salaryrangetype.title AS salaryrangetype,jobtype.color AS jobtypecolor,( SELECT COUNT(id) FROM `" . wpjobportal::$_db->prefix . "wj_portal_jobapply` WHERE jobid = job.id) AS totalresume
                FROM `" . wpjobportal::$_db->prefix . "wj_portal_jobs` AS job
                JOIN `" . wpjobportal::$_db->prefix . "wj_portal_categories` AS cat ON job.jobcategory = cat.id
                JOIN `" . wpjobportal::$_db->prefix . "wj_portal_jobtypes` AS jobtype ON job.jobtype = jobtype.id
                JOIN `" . wpjobportal::$_db->prefix . "wj_portal_companies` AS company ON job.companyid = company.id
                LEFT JOIN `" . wpjobportal::$_db->prefix . "wj_portal_salaryrangetypes` AS salaryrangetype ON salaryrangetype.id = job.salaryduration
                LEFT JOIN `" . wpjobportal::$_db->prefix . "wj_portal_cities` AS city ON city.id = (SELECT cityid FROM `" . wpjobportal::$_db->prefix . "wj_portal_jobcities` WHERE jobid = job.id ORDER BY id DESC LIMIT 1)
                WHERE job.status != 0 AND job.id = $jobid";
        $result = wpjobportaldb::get_results($query);

        return $result;
    }

    function getMessagekey(){
        $key = 'jobapply';if(wpjobportal::$_common->wpjp_isadmin()){$key = 'admin_'.$key;}return $key;
    }

}
?>
