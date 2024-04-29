<?php

if (!defined('ABSPATH'))
    die('Restricted Access');

class WPJOBPORTALemailtemplatestatusModel {

    function sendEmailModel($id, $actionfor) {
        if (empty($id))
            return false;
        if (!is_numeric($actionfor))
            return false;

        $row = WPJOBPORTALincluder::getJSTable('emailtemplateconfig');
        $value = 1;

        switch ($actionfor) {
            case 1: //updation for employer send email
                $row->update(array('id' => $id, 'employer' => $value));
                break;
            case 2: //updation for jobseeker send email
                $row->update(array('id' => $id, 'jobseeker' => $value));

                break;
            case 3: //updation for admin send email
                $row->update(array('id' => $id, 'admin' => $value));
                break;
            case 4: //updation for jobseeker visitor send email
                $row->update(array('id' => $id, 'jobseeker_visitor' => $value));
                break;
            case 5: //updation for employer visitor send email
                $row->update(array('id' => $id, 'employer_visitor' => $value));
        }
    }

    function noSendEmailModel($id, $actionfor) {
        if (empty($id))
            return false;
        if (!is_numeric($actionfor))
            return false;

        $row = WPJOBPORTALincluder::getJSTable('emailtemplateconfig');
        $value = 0;

        switch ($actionfor) {
            case 1: //updation for employer not send email
                $row->update(array('id' => $id, 'employer' => $value));
                break;
            case 2: //updation for jobseeker not send email
                $row->update(array('id' => $id, 'jobseeker' => $value));
                break;
            case 3: //updation for admin not send email
                $row->update(array('id' => $id, 'admin' => $value));
                break;
            case 4: //updation for jobseeker visitor not send email
                $row->update(array('id' => $id, 'jobseeker_visitor' => $value));
                break;
            case 5: //updation for employer visitor not send email
                $row->update(array('id' => $id, 'employer_visitor' => $value));
        }
    }

    function getLanguageForEmail($keyword) {
        switch ($keyword) {
            case 'add_new_company':
                $lanng = __('Add','wp-job-portal'). __('new','wp-job-portal').__('company', 'wp-job-portal');
                return $lanng;
                break;
            case 'delete_company':
                $lanng = __('Delete','wp-job-portal') .' '. __('company', 'wp-job-portal');
                return $lanng;
                break;
            case 'company_status':
                $lanng = __('Company','wp-job-portal') .' '. __('status', 'wp-job-portal');
                return $lanng;
                break;
            case 'job_status':
                $lanng = __('Job','wp-job-portal') .' '. __('Status', 'wp-job-portal');
                return $lanng;
                break;
            case 'add_new_job':
                $lanng = __('Add','wp-job-portal') .' '. __('new','wp-job-portal') .' '. __('job', 'wp-job-portal');
                return $lanng;
                break;
            case 'add_new_resume':
                $lanng = __('Add','wp-job-portal') .' '. __('new','wp-job-portal') .' '. __('resume', 'wp-job-portal');
                return $lanng;
                break;
            case 'resume_status':
                $lanng = __('Resume','wp-job-portal') .' '. __('status', 'wp-job-portal');
                return $lanng;
                break;
            case 'employer_purchase_credits_pack':
                $lanng = __('Employer','wp-job-portal') .' '. __('buy credits pack', 'wp-job-portal');
                return $lanng;
                break;
            case 'jobseeker_package_expire':
                $lanng = __('Job seeker','wp-job-portal') .' '. __('expire package', 'wp-job-portal');
                return $lanng;
                break;
            case 'jobseeker_purchase_credits_pack':
                $lanng = __('Job seeker','wp-job-portal') .' '. __('buy credits pack', 'wp-job-portal');
                return $lanng;
                break;
            case 'employer_package_expire':
                $lanng = __('Employer','wp-job-portal') .' '. __('expire package', 'wp-job-portal');
                return $lanng;
                break;
            case 'jobapply_employer':
                $lanng = __('Employer','wp-job-portal') .' '. __('job apply', 'wp-job-portal');
                return $lanng;
                break;
            case 'jobapply_jobseeker':
                $lanng = __('Job seeker','wp-job-portal') .' '. __('job apply', 'wp-job-portal');
                return $lanng;
                break;
            case 'delete_job':
                $lanng = __('Delete','wp-job-portal') .' '. __('job', 'wp-job-portal');
                return $lanng;
                break;
            case 'add_new_employer':
                $lanng = __('Add','wp-job-portal') .' '. __('New','wp-job-portal') .' '. __('Employer', 'wp-job-portal');
                return $lanng;
                break;
            case 'add_new_jobseeker':
                $lanng = __('Add','wp-job-portal') .' '. __('New','wp-job-portal') .' '. __('Job Seeker', 'wp-job-portal');
                return $lanng;
                break;
            case 'add_new_resume_visitor':
                $lanng = __('Add','wp-job-portal') .' '. __('new','wp-job-portal') .' '. __('resume ','wp-job-portal') .' '. __('by visitor', 'wp-job-portal');
                return $lanng;
                break;
            case 'add_new_job_visitor':
                $lanng = __('Add','wp-job-portal') .' '. __('new','wp-job-portal') .' '. __('job','wp-job-portal') .' '. __('by visitor', 'wp-job-portal');
                return $lanng;
                break;
            case 'resume-delete':
                $lanng = __('Delete','wp-job-portal') .' '. __('resume', 'wp-job-portal');
                return $lanng;
                break;
            case 'jobapply_jobapply':
                $lanng = __('job apply', 'wp-job-portal');
                return $lanng;
                break;
            case 'applied-resume_status':
                $lanng = __('Applied resume status change', 'wp-job-portal');
                return $lanng;
                break;
            case 'package-purchase-admin':
                $lanng = __('Package Purchase Admin', 'wp-job-portal');
                return $lanng;
                break;
            case 'package_status':
                $lanng = __('Package Status', 'wp-job-portal');
                return $lanng;
                break;
            case 'package_purchase':
                $lanng = __('Package Purchase', 'wp-job-portal');
                return $lanng;
                break;
        }
    }

    function getEmailTemplateStatusData() {
        $query = "SELECT * FROM " . wpjobportal::$_db->prefix . "wj_portal_emailtemplates_config";
        wpjobportal::$_data[0] = wpjobportaldb::get_results($query);
        $newdata = array();
        foreach (wpjobportal::$_data[0] as $data) {
            $newdata[$data->emailfor] = array(
                'tempid' => $data->id,
                'tempname' => $data->emailfor,
                'admin' => $data->admin,
                'employer' => $data->employer,
                'jobseeker' => $data->jobseeker,
                'jobseeker_vis' => $data->jobseeker_visitor,
                'employer_vis' => $data->employer_visitor
            );
        }
        wpjobportal::$_data[0] = $newdata;
    }

    function getEmailTemplateStatus($template_name) {
        $query = "SELECT emc.admin,emc.employer,emc.jobseeker,emc.employer_visitor,emc.jobseeker_visitor
                FROM " . wpjobportal::$_db->prefix . "wj_portal_emailtemplates_config AS emc
                where  emc.emailfor = '" . $template_name . "'";
        $templatestatus = wpjobportaldb::get_row($query);
        return $templatestatus;
    }
    function getMessagekey(){
        $key = 'emailtemplatestatus';if(wpjobportal::$_common->wpjp_isadmin()){$key = 'admin_'.$key;}return $key;
    }


}

?>
