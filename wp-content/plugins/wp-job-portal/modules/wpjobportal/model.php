<?php

if (!defined('ABSPATH'))
    die('Restricted Access');

class WPJOBPORTALwpjobportalModel {

    function getCPJobs() {
        $query = "SELECT comp.name,comp.logofilename,cat.cat_title ,job.city
            FROM " . wpjobportal::$_db->prefix . "wj_portal_jobs as job
            JOIN " . wpjobportal::$_db->prefix . "wj_portal_companies as comp on comp.id = job.companyid
            JOIN " . wpjobportal::$_db->prefix . "wj_portal_categories as cat on cat.id = job.jobcategory";
        wpjobportal::$_data[0]['jobs'] = wpjobportaldb::get_results($query);
    }

    function getAdminControlPanelData() {
        $curdate = date_i18n('Y-m-d');
        //AND date(created) = '".$curdate."'
        $query = "SELECT jobtype.title,(SELECT COUNT(id) FROM `" . wpjobportal::$_db->prefix . "wj_portal_jobs` WHERE jobtype = jobtype.id ) AS totaljob FROM  `" . wpjobportal::$_db->prefix . "wj_portal_jobtypes` AS jobtype ORDER BY jobtype.id";
        $priorities = wpjobportal::$_db->get_results($query);
        wpjobportal::$_data['today_ticket_chart']['title'] = "['".__('Today Jobs','wp-job-portal')."',";
        wpjobportal::$_data['today_ticket_chart']['data'] = "['',";
        foreach($priorities AS $pr){
            wpjobportal::$_data['today_ticket_chart']['title'] .= "'".__($pr->title,'wp-job-portal')."',";
            wpjobportal::$_data['today_ticket_chart']['data'] .= $pr->totaljob.",";
        }
        wpjobportal::$_data['today_ticket_chart']['title'] .= "]";
        wpjobportal::$_data['today_ticket_chart']['data'] .= "]";



        wpjobportal::$_data[0]['today_stats'] = WPJOBPORTALincluder::getJSModel('wpjobportal')->getTodayStats();
        WPJOBPORTALincluder::getJSModel('wpjobportal')->getNewestJObs();
        // Data for the control panel graph
        $query = "SELECT COUNT(id) FROM `" . wpjobportal::$_db->prefix . "wj_portal_jobs`";
        wpjobportal::$_data['totaljobs'] = wpjobportal::$_db->get_var($query);
        $query = "SELECT COUNT(id) FROM `" . wpjobportal::$_db->prefix . "wj_portal_companies`";
        wpjobportal::$_data['totalcompanies'] = wpjobportal::$_db->get_var($query);

        $query = "SELECT COUNT(id) FROM `" . wpjobportal::$_db->prefix . "wj_portal_companies` WHERE status = 1";
        wpjobportal::$_data['totalapcompanies'] = wpjobportal::$_db->get_var($query);


        $query = "SELECT COUNT(id) FROM `" . wpjobportal::$_db->prefix . "wj_portal_resume`";
        wpjobportal::$_data['totalresume'] = wpjobportal::$_db->get_var($query);

        $query = "SELECT COUNT(id) FROM `" . wpjobportal::$_db->prefix . "wj_portal_resume` WHERE status = 1";
        wpjobportal::$_data['totalapresume'] = wpjobportal::$_db->get_var($query);


        $query = "SELECT COUNT(id) FROM `" . wpjobportal::$_db->prefix . "wj_portal_jobapply`";
        wpjobportal::$_data['totaljobapply'] = wpjobportal::$_db->get_var($query);
        $curdate = date('Y-m-d');
        $query = "SELECT COUNT(id) FROM `" . wpjobportal::$_db->prefix . "wj_portal_jobs` WHERE DATE(startpublishing) <= '$curdate' AND DATE(stoppublishing) >= '$curdate' AND status = 1";
        wpjobportal::$_data['totalactivejobs'] = wpjobportal::$_db->get_var($query);
        $newindays = WPJOBPORTALincluder::getJSModel('configuration')->getConfigurationByConfigName('newdays');
        if ($newindays == 0) {
            $newindays = 7;
        }
        $time = strtotime($curdate . ' -' . $newindays . ' days');
        $lastdate = date("Y-m-d", $time);
        $query = "SELECT COUNT(id) FROM `" . wpjobportal::$_db->prefix . "wj_portal_jobs` WHERE DATE(created) >= DATE('$lastdate') AND DATE(created) <= DATE('$curdate')";
        wpjobportal::$_data['totalnewjobs'] = wpjobportal::$_db->get_var($query);
        $query = "SELECT COUNT(id) FROM `" . wpjobportal::$_db->prefix . "wj_portal_companies` WHERE DATE(created) >= DATE('$lastdate') AND DATE(created) <= DATE('$curdate')";
        wpjobportal::$_data['totalnewcompanies'] = wpjobportal::$_db->get_var($query);
        $query = "SELECT COUNT(id) FROM `" . wpjobportal::$_db->prefix . "wj_portal_resume` WHERE DATE(created) >= DATE('$lastdate') AND DATE(created) <= DATE('$curdate')";
        wpjobportal::$_data['totalnewresume'] = wpjobportal::$_db->get_var($query);
        $query = "SELECT COUNT(id) FROM `" . wpjobportal::$_db->prefix . "wj_portal_jobapply` WHERE DATE(apply_date) >= DATE('$lastdate') AND DATE(apply_date) <= DATE('$curdate')";
        wpjobportal::$_data['totalnewjobapply'] = wpjobportal::$_db->get_var($query);

        $curdate = date('Y-m-d');
        $fromdate = date('Y-m-d', strtotime("now -1 month"));
        wpjobportal::$_data['curdate'] = $curdate;
        wpjobportal::$_data['fromdate'] = $fromdate;
        $query = "SELECT job.startpublishing AS created
                    FROM `" . wpjobportal::$_db->prefix . "wj_portal_jobs` AS job WHERE date(job.startpublishing) >= '" . $fromdate . "' AND date(job.startpublishing) <= '" . $curdate . "' ORDER BY job.startpublishing";
        $alljobs = wpjobportal::$_db->get_results($query);
        $jobs = array();
        foreach ($alljobs AS $job) {
            $date = date('Y-m-d', strtotime($job->created));
            $jobs[$date] = isset($jobs[$date]) ? ($jobs[$date] + 1) : 1;
        }
        $query = "SELECT company.created
                    FROM `" . wpjobportal::$_db->prefix . "wj_portal_companies` AS company WHERE date(company.created) >= '" . $fromdate . "' AND date(company.created) <= '" . $curdate . "' ORDER BY company.created";
        $allcompanies = wpjobportal::$_db->get_results($query);
        $companies = array();
        foreach ($allcompanies AS $company) {
            $date = date('Y-m-d', strtotime($company->created));
            $companies[$date] = isset($companies[$date]) ? ($companies[$date] + 1) : 1;
        }
        $query = "SELECT resume.created
                    FROM `" . wpjobportal::$_db->prefix . "wj_portal_resume` AS resume WHERE date(resume.created) >= '" . $fromdate . "' AND date(resume.created) <= '" . $curdate . "'  ORDER BY resume.created";
        $allresume = wpjobportal::$_db->get_results($query);
        $resumes = array();
        foreach ($allresume AS $resume) {
            $date = date('Y-m-d', strtotime($resume->created));
            $resumes[$date] = isset($resumes[$date]) ? ($resumes[$date] + 1) : 1;
        }
        $query = "SELECT job.startpublishing AS created
                    FROM `" . wpjobportal::$_db->prefix . "wj_portal_jobs` AS job WHERE date(job.startpublishing) >= '" . $fromdate . "' AND date(job.startpublishing) <= '" . $curdate . "' AND job.status = 1 ORDER BY job.created";
        $allactivejob = wpjobportal::$_db->get_results($query);
        $activejobs = array();
        foreach ($allactivejob AS $ajob) {
            $date = date('Y-m-d', strtotime($ajob->created));
            $activejobs[$date] = isset($activejobs[$date]) ? ($activejobs[$date] + 1) : 1;
        }
        wpjobportal::$_data['stack_chart_horizontal']['title'] = "['" . __('Dates', 'wp-job-portal') . "','" . __('Jobs', 'wp-job-portal') . "','" . __('Companies', 'wp-job-portal') . "','" . __('Resume', 'wp-job-portal') . "','" . __('Active Jobs', 'wp-job-portal') . "']";
        wpjobportal::$_data['stack_chart_horizontal']['data'] = '';
        for ($i = 29; $i >= 0; $i--) {
            $checkdate = date('Y-m-d', strtotime($curdate . " -$i days"));
            if ($i != 29) {
                wpjobportal::$_data['stack_chart_horizontal']['data'] .= ',';
            }
            wpjobportal::$_data['stack_chart_horizontal']['data'] .= "['" . date_i18n('Y-M-d', strtotime($checkdate)) . "',";
            $job = isset($jobs[$checkdate]) ? $jobs[$checkdate] : 0;
            $company = isset($companies[$checkdate]) ? $companies[$checkdate] : 0;
            $resume = isset($resumes[$checkdate]) ? $resumes[$checkdate] : 0;
            $ajob = isset($activejobs[$checkdate]) ? $activejobs[$checkdate] : 0;
            wpjobportal::$_data['stack_chart_horizontal']['data'] .= "$job,$company,$resume,$ajob]";

        }
        return;
    }


    function storeServerSerailNumber($data) {
        if (empty($data))
            return false;
        // DB class limitations
        if ($data['server_serialnumber']) {
            $query = "UPDATE  `" . wpjobportal::$_db->prefix . "wj_portal_config` SET configvalue='" . $data['server_serialnumber'] . "' WHERE configname='server_serial_number'";

            if (!wpjobportaldb::query($query))
                return WPJOBPORTAL_SAVE_ERROR;
            else
                return WPJOBPORTAL_SAVED;
        } else
            return WPJOBPORTAL_SAVE_ERROR;
    }

    function storeModule($data,$actionname){
        # Woo Commerce Save WOrking For Module
        # Configuration Base Switch
        switch ($actionname) {
            case 'job_department_price_perlisting':
                # Department Configuration + subAddon(Purchase History)
                WPJOBPORTALincluder::getJSModel('purchasehistory')->storeDepartmentPayment($data);
                break;
            case 'job_coverletter_price_perlisting':
                # Department Configuration + subAddon(Purchase History)
                WPJOBPORTALincluder::getJSModel('purchasehistory')->storeCoverLetterPayment($data);
                break;
            case 'company_price_perlisting':
                WPJOBPORTALincluder::getJSModel('purchasehistory')->storeCompanyPayment($data);
                break;
            case 'company_feature_price_perlisting':
                WPJOBPORTALincluder::getJSModel('purchasehistory')->storeFeaturedCompanyPayment($data);
                break;
            case 'job_currency_price_perlisting':
                WPJOBPORTALincluder::getJSModel('purchasehistory')->StoreJobPayment($data);
                break;
            case 'jobs_feature_price_perlisting':
                WPJOBPORTALincluder::getJSModel('purchasehistory')->storeFeaturedJobPayment($data);
                break;
            case 'job_resume_price_perlisting':
                WPJOBPORTALincluder::getJSModel('purchasehistory')->StoreResumePayment($data);
                break;
            case 'job_featureresume_price_perlisting':
                WPJOBPORTALincluder::getJSModel('purchasehistory')->storeFeaturedResumePayment($data);
                break;
            case 'job_jobalert_price_perlisting':
               WPJOBPORTALincluder::getJSModel('purchasehistory')->storeJobAlertPayment($data);
                break;
            case 'job_resumesavesearch_price_perlisting':
                # Resume Search Payment
               WPJOBPORTALincluder::getJSModel('purchasehistory')->storeResumeSearchPayment($data);
                break;
            case 'job_jobapply_price_perlisting':
                WPJOBPORTALincluder::getJSModel('purchasehistory')->storeJobApplyPayment($data);
                break;
            case 'job_viewcompanycontact_price_perlisting':
                WPJOBPORTALincluder::getJSModel('purchasehistory')->storeCompanyViewPayment($data);
                break;
           case 'job_viewresumecontact_price_perlisting':
                WPJOBPORTALincluder::getJSModel('purchasehistory')->storeResumeViewPayment($data);
                break;
        }
    }


    function getNewestJobs() {
        $query = "SELECT  DISTINCT job.id AS id,job.currency,job.tags AS jobtags,job.title,job.created,job.city,
                    CONCAT(job.alias,'-',job.id) AS jobaliasid,job.noofjobs,job.isfeaturedjob,job.status,
                    cat.cat_title,company.id AS companyid,company.name AS companyname,company.logofilename AS logo, jobtype.title AS jobtypetitle,job.endfeatureddate,job.startpublishing,job.stoppublishing,
                    job.params,CONCAT(company.alias,'-',company.id) AS companyaliasid,LOWER(jobtype.title) AS jobtypetit,
                    job.salarymax,job.salarymin,job.salarytype,srtype.title AS salaryrangetype,jobtype.color AS jobtypecolor
                    FROM `" . wpjobportal::$_db->prefix . "wj_portal_jobs` AS job
                    JOIN `" . wpjobportal::$_db->prefix . "wj_portal_companies` AS company ON company.id = job.companyid
                    LEFT JOIN `" . wpjobportal::$_db->prefix . "wj_portal_categories` AS cat ON cat.id = job.jobcategory
                    LEFT JOIN `" . wpjobportal::$_db->prefix . "wj_portal_salaryrangetypes` AS srtype ON srtype.id = job.salaryduration
                    LEFT JOIN `" . wpjobportal::$_db->prefix . "wj_portal_jobtypes` AS jobtype ON jobtype.id = job.jobtype
                    LEFT JOIN `" . wpjobportal::$_db->prefix . "wj_portal_jobcities` AS jobcity ON jobcity.jobid = job.id
                    LEFT JOIN `" . wpjobportal::$_db->prefix . "wj_portal_cities` AS city ON city.id = jobcity.cityid
                    LEFT JOIN `" . wpjobportal::$_db->prefix . "wj_portal_states` AS state ON state.countryid = city.countryid
                    LEFT JOIN `" . wpjobportal::$_db->prefix . "wj_portal_countries` AS country ON country.id = city.countryid
                    ORDER BY job.created DESC
                    LIMIT 0,5";
                    //getMyResumes
        wpjobportal::$_data[0]['latestjobs'] = wpjobportaldb::get_results($query);
        $query = "SELECT app.uid,app.id,app.endfeatureddate, app.application_title,app.first_name, app.last_name,
                        app.jobtype,app.photo,app.salaryfixed, app.created, app.status, cat.cat_title
                , jobtype.title AS jobtypetitle,app.isfeaturedresume,city.id as city,jobtype.color
            FROM " . wpjobportal::$_db->prefix . "wj_portal_resume AS app
            LEFT JOIN " . wpjobportal::$_db->prefix . "wj_portal_categories AS cat ON app.job_category = cat.id
            LEFT JOIN " . wpjobportal::$_db->prefix . "wj_portal_jobtypes AS jobtype    ON app.jobtype = jobtype.id
            LEFT JOIN `" . wpjobportal::$_db->prefix . "wj_portal_cities` AS city ON city.id = (SELECT address_city FROM `" . wpjobportal::$_db->prefix . "wj_portal_resumeaddresses` WHERE resumeid = app.id ORDER BY id DESC LIMIT 1)
            WHERE app.status <> 0 ";

            $query.=" ORDER BY app.id ASC LIMIT 0,5 ";

        $results = wpjobportal::$_db->get_results($query);
        wpjobportal::$_data[0]['latestresumes'] = wpjobportaldb::get_results($query);
        wpjobportal::$_data['fields'] = wpjobportal::$_wpjpfieldordering->getFieldsOrderingforView(3);
        wpjobportal::$_data['config'] = wpjobportal::$_config->getConfigByFor('resume');
    }

    function getTodayStats() {

        $query = "SELECT count(id) AS totalcompanies
		FROM " . wpjobportal::$_db->prefix . "wj_portal_companies AS company WHERE company.status=1 AND company.created >= CURDATE();";

        $companies = wpjobportaldb::get_row($query);
        $query = "SELECT count(id) AS totaljobs
		FROM " . wpjobportal::$_db->prefix . "wj_portal_jobs AS job WHERE job.status=1 AND job.created >= CURDATE();";

        $jobs = wpjobportaldb::get_row($query);
        $query = "SELECT count(id) AS totalresume
		FROM " . wpjobportal::$_db->prefix . "wj_portal_resume AS resume WHERE resume.status=1 AND resume.created >= CURDATE();";

        $resumes = wpjobportaldb::get_row($query);

        $query = "SELECT count(user.id) AS totalemployer
                    FROM " . wpjobportal::$_db->prefix . "wj_portal_users AS user
                    WHERE user.roleid = 1 AND DATE(user.created) = CURDATE()";

        $employer = wpjobportaldb::get_row($query);

        $query = "SELECT count(user.id) AS totaljobseeker
                    FROM " . wpjobportal::$_db->prefix . "wj_portal_users AS user
                    WHERE user.roleid = 2 AND DATE(user.created) = CURDATE()";

        $jobseeker = wpjobportaldb::get_row($query);

        wpjobportal::$_data[0]['companies'] = $companies;
        wpjobportal::$_data[0]['jobs'] = $jobs;
        wpjobportal::$_data[0]['resumes'] = $resumes;
        wpjobportal::$_data[0]['employer'] = $employer;
        wpjobportal::$_data[0]['jobseeker'] = $jobseeker;
        return;
    }

    function getConcurrentRequestData() {

        $query = "SELECT configname,configvalue FROM `".wpjobportal::$_db->prefix."wj_portal_config` WHERE configfor = hostdata";
        $result = wpjobportaldb::get_results($query);
        foreach ($result AS $res) {
            $return[$res->configname] = $res->configvalue;
        }
        return $return;
    }

    function getMultiCityDataForView($id, $for) {
        if (!is_numeric($id))
            return false;

        $query = "select mcity.id AS id,country.name AS countryName,city.cityName AS cityName,state.name AS stateName, city.id AS cityid";
        switch ($for) {
            case 1:
                $query.=" FROM `" . wpjobportal::$_db->prefix . "wj_portal_jobcities` AS mcity";
                $query.=" LEFT JOIN `" . wpjobportal::$_db->prefix . "wj_portal_jobs` AS job ON mcity.jobid=job.id";
                break;
            case 2:
                $query.=" FROM `" . wpjobportal::$_db->prefix . "wj_portal_companycities` AS mcity";
                $query.=" LEFT JOIN `" . wpjobportal::$_db->prefix . "wj_portal_companies` AS company ON mcity.companyid=company.id";
                break;
        }
        $query.=" LEFT JOIN `" . wpjobportal::$_db->prefix . "wj_portal_cities` AS city ON mcity.cityid=city.id
				  LEFT JOIN `" . wpjobportal::$_db->prefix . "wj_portal_states` AS state ON city.stateid=state.id
				  LEFT JOIN `" . wpjobportal::$_db->prefix . "wj_portal_countries` AS country ON city.countryid=country.id";
        switch ($for) {
            case 1:
                $query.=" where mcity.jobid=" . $id;
                break;
            case 2:
                $query.=" where mcity.companyid=" . $id;
                break;
        }
        $query.=" ORDER BY country.name";

        $cities = wpjobportaldb::get_results($query);
        $mloc = array();
        $mcountry = array();
        $finalloc = "";
        $cityids = '';
        foreach ($cities AS $city) {
            if($cityids != ''){
                $cityids .= ',';
            }
            $cityids .= $city->cityid;
            // if ($city->countryName != null)
            //     $mcountry[] = $city->countryName;
        }
        if($cityids != ''){
            $finalloc = WPJOBPORTALincluder::getJSModel('city')->getLocationDataForView($cityids);
        }
        // if (!empty($mcountry)) {
        //     $country_total = array_count_values($mcountry);
        // } else {
        //     $country_total = array();
        // }
        // $i = 0;
        // foreach ($country_total AS $key => $val) {
        //     foreach ($cities AS $city) {
                
        //         if ($key == $city->countryName) {
        //             $i++;
        //             if ($val == 1) {
        //                 $finalloc.="[" . $city->cityName . ", " . $key . " ] ";
        //                 $i = 0;
        //             } elseif ($i == $val) {
        //                 $finalloc.=$city->cityName . ", " . $key . " ] ";
        //                 $i = 0;
        //             } elseif ($i == 1)
        //                 $finalloc.= "[" . $city->cityName . ", ";
        //             else
        //                 $finalloc.=$city->cityName . ", ";
        //         }
        //     }
        // }
        return $finalloc;
    }

    function getwpjobportalStats() {

        $query = "SELECT count(id) AS totalcompanies,(SELECT count(company.id) FROM " . wpjobportal::$_db->prefix . "wj_portal_companies AS company WHERE company.status=1 ) AS activecompanies
		FROM " . wpjobportal::$_db->prefix . "wj_portal_companies ";

        $companies = wpjobportaldb::get_row($query);

        $query = "SELECT count(id) AS totaljobs,(SELECT count(job.id) FROM " . wpjobportal::$_db->prefix . "wj_portal_jobs AS job WHERE job.status=1 AND job.stoppublishing >= CURDATE())  AS activejobs
		FROM " . wpjobportal::$_db->prefix . "wj_portal_jobs ";

        $jobs = wpjobportaldb::get_row($query);

        $query = "SELECT count(id) AS totalresumes,(SELECT count(resume.id) FROM " . wpjobportal::$_db->prefix . "wj_portal_resume AS resume WHERE resume.status=1 ) AS activeresumes
		FROM " . wpjobportal::$_db->prefix . "wj_portal_resume ";

        $resumes = wpjobportaldb::get_row($query);

        if(in_array('featuredcompany', wpjobportal::$_active_addons) && in_array('credits', wpjobportal::$_active_addons)){
            $query = "SELECT (SELECT COUNT(id) FROM " . wpjobportal::$_db->prefix . "wj_portal_companies WHERE isfeaturedcompany=1) AS totalfeaturedcompanies,
    				(SELECT count(featuredcompany.id) FROM " . wpjobportal::$_db->prefix . "wj_portal_companies  AS featuredcompany
    				JOIN  " . wpjobportal::$_db->prefix . "wj_portal_userpackages AS package ON package.id=featuredcompany.userpackageid
    				WHERE  featuredcompany.status=1 AND featuredcompany.isfeaturedcompany=1  AND featuredcompany.endfeatureddate >= CURDATE() ) AS activefeaturedcompanies
    		FROM " . wpjobportal::$_db->prefix . "wj_portal_companies";

            $featuredcompanies = wpjobportaldb::get_row($query);
            wpjobportal::$_data[0]['featuredcompanies'] = $featuredcompanies;
        }
        if(in_array('featuredjob', wpjobportal::$_active_addons) && in_array('credits', wpjobportal::$_active_addons)){
            $query = "SELECT ( SELECT COUNT(id) FROM " . wpjobportal::$_db->prefix . "wj_portal_jobs WHERE isfeaturedjob=1 ) AS totalfeaturedjobs,(SELECT count(featuredjob.id) FROM " . wpjobportal::$_db->prefix . "wj_portal_jobs AS featuredjob
    		JOIN  " . wpjobportal::$_db->prefix . "wj_portal_userpackages AS package ON package.id=featuredjob.userpackageid
    		WHERE  featuredjob.status= 1 AND featuredjob.isfeaturedjob= 1  AND featuredjob.endfeatureddate >= CURDATE() ) AS activefeaturedjobs
    		";
            $featuredjobs = wpjobportaldb::get_row($query);
            wpjobportal::$_data[0]['featuredjobs'] = $featuredjobs;
        }


        if(in_array('featureresume', wpjobportal::$_active_addons) && in_array('credits', wpjobportal::$_active_addons)){
            $query = "SELECT ( SELECT COUNT(id) FROM " . wpjobportal::$_db->prefix . "wj_portal_resume WHERE isfeaturedresume=1 ) AS totalfeaturedresumes,(SELECT count(featuredresume.id) FROM " . wpjobportal::$_db->prefix . "wj_portal_resume  AS featuredresume
    		JOIN  " . wpjobportal::$_db->prefix . "wj_portal_userpackages AS package ON package.id=featuredresume.userpackageid
    		WHERE  featuredresume.status= 1 AND featuredresume.isfeaturedresume= 1  AND featuredresume.endfeatureddate >= CURDATE() ) AS activefeaturedresumes
    		";

            $featuredresumes = wpjobportaldb::get_row($query);
            wpjobportal::$_data[0]['featuredresumes'] = $featuredresumes;
        }


        $totalpaidamount = 'Recalculate';

        $query = "SELECT count(user.id) AS totalemployer
                    FROM " . wpjobportal::$_db->prefix . "wj_portal_users AS user
                    WHERE user.roleid = 1";

        $totalemployer = wpjobportaldb::get_row($query);

        $query = "SELECT count(user.id) AS totaljobseeker
                    FROM " . wpjobportal::$_db->prefix . "wj_portal_users AS user
                    WHERE user.roleid=2";

        $totaljobseeker = wpjobportaldb::get_row($query);

        wpjobportal::$_data[0]['companies'] = $companies;
        wpjobportal::$_data[0]['jobs'] = $jobs;
        wpjobportal::$_data[0]['resumes'] = $resumes;
        wpjobportal::$_data[0]['totalpaidamount'] = $totalpaidamount;
        wpjobportal::$_data[0]['totalemployer'] = $totalemployer;
        wpjobportal::$_data[0]['totaljobseeker'] = $totaljobseeker;
        return;
    }


    function widgetTotalStatsData() {
        $query = "SELECT count(id) AS totalcompanies
        FROM " . wpjobportal::$_db->prefix . "wj_portal_companies ";

        $companies = wpjobportaldb::get_row($query);

        $query = "SELECT count(id) AS totaljobs,(SELECT count(job.id) FROM " . wpjobportal::$_db->prefix . "wj_portal_jobs AS job WHERE job.status=1 AND job.stoppublishing >= CURDATE())  AS activejobs
        FROM " . wpjobportal::$_db->prefix . "wj_portal_jobs ";

        $jobs = wpjobportaldb::get_row($query);

        $query = "SELECT count(id) AS totalresumes
        FROM " . wpjobportal::$_db->prefix . "wj_portal_resume ";

        $resumes = wpjobportaldb::get_row($query);

        $query = "SELECT count(DISTINCT jobid) AS appliedjobs
        FROM " . wpjobportal::$_db->prefix . "wj_portal_jobapply ";

        $aplliedjobs = wpjobportaldb::get_row($query);


        wpjobportal::$_data['widget']['companies'] = $companies;
        wpjobportal::$_data['widget']['jobs'] = $jobs;
        wpjobportal::$_data['widget']['resumes'] = $resumes;
        wpjobportal::$_data['widget']['aplliedjobs'] = $aplliedjobs;
        return true;
    }

    function widgetLastWeekData() {
        $newindays = 7;
        $curdate = date('Y-m-d');
        $time = strtotime($curdate . ' -' . $newindays . ' days');
        $lastdate = date("Y-m-d", $time);
        $query = "SELECT COUNT(id) FROM `" . wpjobportal::$_db->prefix . "wj_portal_jobs` WHERE DATE(created) >= DATE('" . $lastdate . "') AND DATE(created) <= '" . $curdate . "'";
        wpjobportal::$_data['widget']['newjobs'] = wpjobportal::$_db->get_var($query);
        $query = "SELECT COUNT(id) FROM `" . wpjobportal::$_db->prefix . "wj_portal_companies` WHERE DATE(created) >= DATE('" . $lastdate . "') AND DATE(created) <= DATE('" . $curdate . "')";
        wpjobportal::$_data['widget']['newcompanies'] = wpjobportal::$_db->get_var($query);

        $query = "SELECT COUNT(id) FROM `" . wpjobportal::$_db->prefix . "wj_portal_resume` WHERE DATE(created) >= DATE('" . $lastdate . "') AND DATE(created) <= DATE('" . $curdate . "')";
        wpjobportal::$_data['widget']['newresume'] = wpjobportal::$_db->get_var($query);

        $query = "SELECT COUNT(id) FROM `" . wpjobportal::$_db->prefix . "wj_portal_jobapply` WHERE DATE(apply_date) >= '" . $lastdate . "' AND DATE(apply_date) <= '" . $curdate . "'";
        wpjobportal::$_data['widget']['newjobapply'] = wpjobportal::$_db->get_var($query);
        if(!wpjobportal::$_data['widget']['newjobapply']) wpjobportal::$_data['widget']['newjobapply'] = 0;

        wpjobportal::$_data['widget']['startdate'] = date('d M, Y', strtotime($lastdate));
        wpjobportal::$_data['widget']['enddate'] = date('d M, Y', strtotime($curdate));
        return true;
    }

    function getDataForWidgetPopup() {
        $dataid = WPJOBPORTALrequest::getVar('dataid');
        $newindays = 7;
        $curdate = date('Y-m-d');
        $time = strtotime($curdate . ' -' . $newindays . ' days');
        $lastdate = date("Y-m-d", $time);
        if ($dataid == 1) { //job
            $query = "SELECT job.companyid AS id,job.title,isfeaturedjob AS isfeatured
                        ,job.status,cat.cat_title,job.city,comp.logofilename AS photo
            FROM `" . wpjobportal::$_db->prefix . "wj_portal_jobs` AS job
            JOIN `" . wpjobportal::$_db->prefix . "wj_portal_companies` AS comp ON comp.id = job.companyid
            JOIN `" . wpjobportal::$_db->prefix . "wj_portal_categories` AS cat ON cat.id = job.jobcategory
            WHERE DATE(job.created) >= DATE('" . $lastdate . "') AND DATE(job.created) <= DATE('" . $curdate . "')
            ORDER BY job.created DESC LIMIT 5";
            $results = wpjobportal::$_db->get_results($query);
        }
        if ($dataid == 2) { //company
            $query = "SELECT comp.id ,comp.name AS title,comp.isfeaturedcompany AS isfeatured
                        ,comp.city,comp.status,comp.logofilename AS photo,cat.cat_title
            FROM `" . wpjobportal::$_db->prefix . "wj_portal_companies` AS comp
            JOIN `" . wpjobportal::$_db->prefix . "wj_portal_categories` AS cat ON cat.id = comp.category
            WHERE DATE(comp.created) >= DATE('" . $lastdate . "') AND DATE(comp.created) <= DATE('" . $curdate . "')
            ORDER BY comp.created DESC LIMIT 5";
            $results = wpjobportal::$_db->get_results($query);
        }
        if ($dataid == 3) {     //resume
            $query = "SELECT resume.id, CONCAT(resume.application_title,' ( ',resume.first_name,' ',resume.last_name,' )' ) AS title,resume.isfeaturedresume AS isfeatured,resume.status,cat.cat_title,resume.photo
            FROM `" . wpjobportal::$_db->prefix . "wj_portal_resume` AS resume
            JOIN `" . wpjobportal::$_db->prefix . "wj_portal_categories` AS cat ON cat.id = resume.job_category
            WHERE DATE(resume.created) >= DATE('" . $lastdate . "') AND DATE(resume.created) <= DATE('" . $curdate . "')
            ORDER BY resume.created DESC LIMIT 5";
            $results = wpjobportal::$_db->get_results($query);
        }
        if ($dataid == 4) {  //jobappply
            $query = "SELECT  comp.id,comp.logofilename AS logo,job.title AS title
                    ,CONCAT(resume.application_title,' / ',resume.first_name,' ',resume.last_name) AS name
                    ,jobapp.apply_date,jobapp.action_status as status,job.isfeaturedjob AS isfeatured
            FROM `" . wpjobportal::$_db->prefix . "wj_portal_jobapply` AS jobapp
            JOIN `" . wpjobportal::$_db->prefix . "wj_portal_resume` AS resume ON resume.id = jobapp.cvid
            JOIN `" . wpjobportal::$_db->prefix . "wj_portal_jobs` AS job on job.id = jobapp.jobid
            JOIN `" . wpjobportal::$_db->prefix . "wj_portal_companies` AS comp ON comp.id = job.companyid
            WHERE DATE(jobapp.apply_date) >= DATE('" . $lastdate . "') AND DATE(jobapp.apply_date) <= DATE('" . $curdate . "')
            ORDER BY jobapp.apply_date DESC LIMIT 5";
            $results = wpjobportal::$_db->get_results($query);
        }
        $html = $this->generatePopup($results, $dataid);
        return $html;
    }

//function to denerate popup from new jobs companies and resume
    function generatePopup($results, $dataid) {
        if ($dataid == 1) {
            $title = __('Newest Jobs', 'wp-job-portal');
        } elseif ($dataid == 2) {
            $title = __('Newest Companies', 'wp-job-portal');
        } elseif ($dataid == 3) {
            $title = __('Newest Resumes', 'wp-job-portal');
        } elseif ($dataid == 4) {
            $title = __('Newest Applied Jobs', 'wp-job-portal');
        }
        $html = '';
        $html = '<span class="popup-top">
                    <span id="popup_title" >
                    ' . $title . '
                    </span>
                    <img id="popup_cross" src="' . WPJOBPORTAL_PLUGIN_URL . 'includes/images/popup-close.png">
                </span>
                <div class="widget-popup-body">';
        if (empty($results)) {
            $error = '
                <div class="js_job_error_messages_wrapper">
                    <div class="message1">
                        <span>
                            ' . __("Oops...", "wp-job-portal") . '
                        </span>
                    </div>
                    <div class="message2">
                         <span class="img">
                        <img class="js_job_messages_image" src="' . WPJOBPORTAL_PLUGIN_URL . 'includes/images/norecordfound.png"/>
                         </span>
                         <span class="message-text">
                            ' . __('Record Not Found', 'wp-job-portal') . '
                         </span>
                    </div>
                    <div class="footer">
                        <a href ="' . 'admin.php?page=wpjobportal' . '">' . __('Back to control panel', 'wp-job-portal') . '</a>
                    </div>
                </div>
        ';
            $html .= ' ' . $error . '</div>';
            return $html;
        }

        //popup layout for new job /company/resume
        if ($dataid != 4) {
            //1 = newest jobs
            //2 = newest compnay
            //3 = newest resume
            //4 = applied jobs

            foreach ($results as $data) {
                //photo / logo
                //for company and job
                $data_directory = WPJOBPORTALincluder::getJSModel('configuration')->getConfigurationByConfigName('data_directory');
                $wpdir = wp_upload_dir();
                if ($dataid == 1 || $dataid == 2) {
                    if ($data->photo != "") {
                        $path = $wpdir['baseurl'] . '/' . $data_directory . '/data/employer/comp_' . $data->id . '/logo/' . $data->photo;
                    } else {
                        $path = WPJOBPORTAL_PLUGIN_URL . '/includes/images/default_logo.png';
                    }
                } elseif ($data->photo != "") {
                    $path = $wpdir['baseurl'] . '/' . $data_directory . '/data/jobseeker/resume_' . $data->id . '/photo/' . $data->photo;
                } else {
                    $path = WPJOBPORTAL_PLUGIN_URL . '/includes/images/users.png';
                }

                $picstyle = '';
                //bottom link

                if ($dataid == 1) {
                    $link = 'admin.php?page=wpjobportal_job&wpjobportallt=jobs';
                }
                if ($dataid == 2) {
                    $link = 'admin.php?page=wpjobportal_company&wpjobportallt=companies';
                }
                if ($dataid == 3) {
                    $link = 'admin.php?page=wpjobportal_resume&wpjobportallt=resumes';
                    $picstyle = 'resume-img';
                }


                //city //resume has education not city
                if ($dataid != 3) {
                    $data->city = WPJOBPORTALincluder::getJSModel('city')->getLocationDataForView($data->city);
                }
                //flags expressing status
                if ($data->status == 0) {
                    $flaghtml = '<div class="pending-badge badges">
                                        <span class="flag pending"><span></span>' . __('Pending', 'wp-job-portal') . '</span>
                                        </div>';
                } elseif ($data->status == 1) {
                    $flaghtml = '<div class="approved-badge badges">
                                        <span class="flag approved"><span></span>' . __('Approved', 'wp-job-portal') . '</span>
                                        </div>';
                } else {
                    $flaghtml = '<div class="rejected-badge badges">
                                        <span class="flag rejected"><span></span>' . __('Rejected', 'wp-job-portal') . '</span>
                                        </div>';
                }


                $html .= '<div class="widget-data-wrapper">
                                    <div class="left-data ' . $picstyle . '">
                                    <img class="left-data-img" src="' . $path . '"/>
                                    </div>
                                    <div class="right-data">
                                        <div class="data-title">
                                        ' . $data->title;
                if ($data->isfeatured == 1) {
                    $html .= '<span id="badge_featured" class="feature badge featured">' . __('Featured', 'wp-job-portal') . '</span>';
                }

                $html .= '</div>
                                        <div class="data-data">
                                            <span class="heading">
                                            ' . __('Category', 'wp-job-portal') . ' :
                                            </span>
                                            <span class="text">
                                            ' . $data->cat_title . '
                                            </span>
                                        </div>';
                if ($dataid != 3) {
                    $html .= '<div class="data-data">
                                                    <span class="heading">
                                                ' . __('Location', 'wp-job-portal') . ' :
                                                </span>
                                                <span class="text">
                                                ' . $data->city . '
                                                </span>';
                } else {
                    $html .= '<div class="data-data">
                                                    <span class="heading">
                                                ' . __('Highest Education', 'wp-job-portal') . ' :
                                                </span>
                                                <span class="text">
                                                ' . $data->education . '
                                                </span>';
                }
                $html .='
                                        </div>
                                        ' . $flaghtml . '
                                    </div>
                                </div>';
            }
        } elseif ($dataid == 4) {
            $html .= $this->getAppliedJobPopup($results);
            return $html;
        }
        $html .= '<a href = "' . $link . '" class="popup-bottom-button">' . __('Show More', 'wp-job-portal') . '</a></div>';
        return $html;
    }

//function to create popup of newest applied jobs
    function getAppliedJobPopup($results) {
        $html = '';
        $wpdir = wp_upload_dir();
        foreach ($results as $data) {
            //photo / logo
            if ($data->logo != "") {
                $data_directory = WPJOBPORTALincluder::getJSModel('configuration')->getConfigurationByConfigName('data_directory');
                $path = $wpdir['baseurl'] . '/' . $data_directory . '/data/employer/comp_' . $data->id . '/logo/' . $data->logo;
            } else {
                $path = WPJOBPORTAL_PLUGIN_URL . '/includes/images/default_logo.png';
            }


            //flags expressing status
            $flaghtml = '';
            if ($data->status == 2) {
                $flaghtml = '<div class="spam-badge badges">
                                        <span class="flag spam"><span></span>' . __('Spam', 'wp-job-portal') . '</span>
                                        </div>';
            } elseif ($data->status == 3) {
                $flaghtml = '<div class="hired-badge badges">
                                        <span class="flag hired"><span></span>' . __('Hired', 'wp-job-portal') . '</span>
                                        </div>';
            } elseif ($data->status == 4) {
                $flaghtml = '<div class="reject-badge badges">
                                        <span class="flag reject"><span></span>' . __('Rejected', 'wp-job-portal') . '</span>
                                        </div>';
            } elseif ($data->status == 5) {
                $flaghtml = '<div class="shortlisted-badge badges">
                                        <span class="flag shortlisted"><span></span>' . __('Short listed', 'wp-job-portal') . '</span>
                                        </div>';
            }


            $html .= '<div class="widget-data-wrapper">
                                    <div class="left-data">
                                        <img class="left-data-img" src="' . $path . '"/>
                                    </div>
                                    <div class="right-data">
                                        <div class="data-title">
                                        ' . $data->title;
            if ($data->isfeatured == 1) {
                $html .= '<span id="badge_featured" class="feature badge featured">' . __('Featured', 'wp-job-portal') . '</span>';
            }

            $html .= '</div>
                                        <div class="data-data">
                                            <span class="heading">
                                            ' . __('Applicant', 'wp-job-portal') . ' :
                                            </span>
                                            <span class="text">
                                            ' . $data->name . '
                                            </span>
                                        </div>';
            $html .= '<div class="data-data">
                                                    <span class="heading">
                                                ' . __('Applied Date', 'wp-job-portal') . ' :
                                                </span>
                                                <span class="text">
                                                ' . $data->apply_date . '
                                                </span>';

            $html .='
                                        </div>
                                        ' . $flaghtml . '
                                    </div>

                        </div>';
        }
        $html .= '</div>';
        return $html;
    }

    function getLatestResumes() {
        $query = "SELECT resume.id,resume.first_name,resume.last_name,resume.application_title as applicationtitle,CONCAT(resume.alias,'-',resume.id) resumealiasid,resume.email_address,category.cat_title,resume.experienceid,resume.created,jobtype.title AS jobtypetitle,resume.photo,resume.salaryfixed as salary,resume.isfeaturedresume,resume.status,city.cityName AS cityname,state.name AS statename,country.name AS countryname,resume.endfeatureddate,resume.params,resume.last_modified,LOWER(jobtype.title) AS jobtypetit,jobtype.color as jobtypecolor
                FROM `" . wpjobportal::$_db->prefix . "wj_portal_resume` AS resume
                JOIN `" . wpjobportal::$_db->prefix . "wj_portal_categories` AS category ON category.id = resume.job_category
                LEFT JOIN `" . wpjobportal::$_db->prefix . "wj_portal_jobtypes` AS jobtype ON jobtype.id = resume.jobtype
                LEFT JOIN `" . wpjobportal::$_db->prefix . "wj_portal_cities` AS city ON city.id = (SELECT address_city FROM `" . wpjobportal::$_db->prefix . "wj_portal_resumeaddresses` WHERE resumeid = resume.id LIMIT 1)
                LEFT JOIN `" . wpjobportal::$_db->prefix . "wj_portal_states` AS state ON state.id = city.stateid
                LEFT JOIN `" . wpjobportal::$_db->prefix . "wj_portal_countries` AS country ON country.id = city.countryid
                WHERE resume.uid = " . $uid;
                $query.=" ORDER BY resume.id ASC LIMIT 0,5 ";

        $results = wpjobportal::$_db->get_results($query);
        $data = array();
        foreach ($results AS $d) {
            $d->location = wpjobportal::$_common->getLocationForView($d->cityname, $d->statename, $d->countryname);
            $data[] = $d;
        }
        wpjobportal::$_data['fields'] = WPJOBPORTALincluder::getJSModel('fieldordering')->getFieldsOrderingforView(3);
        wpjobportal::$_data[0]['latestresumes'] = $data;
        wpjobportal::$_data['config'] = wpjobportal::$_config->getConfigByFor('resume');
        wpjobportal::$_data['listingfields'] = WPJOBPORTALincluder::getJSModel('fieldordering')->getFieldsForListing(3);
        return;
    }

    function getNewestUsers($role) {
        if (!is_numeric($role))
            return false;
        $query = "SELECT u.id,CONCAT(u.first_name,' ',u.last_name) AS username,u.emailaddress AS email,u.created AS created
        FROM `" . wpjobportal::$_db->prefix . "wj_portal_users` AS u
        WHERE u.roleid = " . $role . " ORDER BY u.created DESC LIMIT 5";

        $results = wpjobportal::$_db->get_results($query);
        //company logo for employer
        if ($role == 1) {
            $data = array();
            foreach ($results AS $d) {
                $query = "SELECT logofilename AS photo,id AS companyid FROM `" . wpjobportal::$_db->prefix . "wj_portal_companies`
                WHERE uid = " . $d->id . " ORDER BY logofilename DESC LIMIT 1";
				$result = wpjobportal::$_db->get_row($query);
                if($result){
                    $d->photo = $result->photo;
                    $d->companyid = $result->companyid;
                }else{
                    $d->photo = '';
                    $d->companyid = '';
                }
                $data[] = $d;
            }
            $results = $data;
        }
        //resume photo  for jobseeker
        if ($role == 2) {
            $data = array();
            foreach ($results AS $d) {
                $query = "SELECT photo,id AS resumeid FROM `" . wpjobportal::$_db->prefix . "wj_portal_resume`
                WHERE uid = " . $d->id . " ORDER BY photo DESC LIMIT 1";
				$result = wpjobportal::$_db->get_row($query);
                if($result){
                    $d->photo = $result->photo;
                    $d->resumeid = $result->resumeid;
                }else{
                    $d->photo = '';
                    $d->resumeid = '';
                }
                $data[] = $d;
            }
            $results = $data;
        }
        $html = $this->genrateUserWidget($results, $role);
        return $html;
    }

    function genrateUserWidget($results, $role) {
        $html = '';
        $html .= '<div id="wp-job-portal-widget-wrapper">';
        $wpdir = wp_upload_dir();
        foreach ($results as $data) {
            //name
            $name = $data->username;
            //photo code
            $data_directory = WPJOBPORTALincluder::getJSModel('configuration')->getConfigurationByConfigName('data_directory');
            if ($role == 1) {
                if ($data->photo != "") {
                    $path = $wpdir['baseurl'] . '/' . $data_directory . '/data/employer/comp_' . $data->companyid . '/logo/' . $data->photo;
                } else {
                    $path = WPJOBPORTAL_PLUGIN_URL . '/includes/images/users.png';
                }
            } elseif ($data->photo != "") {
                $path = $wpdir['baseurl'] . '/' . $data_directory . '/data/jobseeker/resume_' . $data->resumeid . '/photo/' . $data->photo;
            } else {
                $path = WPJOBPORTAL_PLUGIN_URL . '/includes/images/users.png';
            }
            //photo code
            $dateformat = wpjobportal::$_configuration['date_format'];
            $html .= '<div class="users-widget-data">
                        <img class="photo" src="' . $path . '"/>
                        <div class="widget-data-upper">
                            <a href="'.admin_url('admin.php?page=wpjobportal_user&wpjobportallt=userdetail&id='.$data->id).'">
                                '. $name .'
                            </a>
                            <span class="Widget-data-date">( ' . date_i18n($dateformat, strtotime($data->created)) . ' )</span>
                        </div>
                        <div class="widget-data-lower">
                            ' . $data->email . '
                        </div>
                    </div>';
        }

        $html .= '</div>';
        return $html;
    }

    function getListTranslations() {

        $result = array();
        $result['error'] = false;

        $path = WPJOBPORTAL_PLUGIN_PATH.'languages';

        if( ! is_writeable($path)){
            $result['error'] = __('Dir is not writable','wp-job-portal').' '.$path;

        }else{

            if($this->isConnected()){

                $version = WPJOBPORTALIncluder::getJSModel('configuration')->getConfigByFor('default');

                $post_data = array();
                $url = "http://www.joomsky.com/translations/api/1.0/index.php";
                $post_data['product'] ='wp-job-portal-wp';
                $post_data['domain'] = get_site_url();
                $post_data['producttype'] = $version['producttype'];
                $post_data['productcode'] = 'wpjobportal';
                $post_data['productversion'] = $version['version'];
                $post_data['JVERSION'] = get_bloginfo('version');
                $post_data['method'] = 'getTranslations';

                $response = wp_remote_post( $url, array('body' => $post_data,'timeout'=>7,'sslverify'=>false));
                if( !is_wp_error($response) && $response['response']['code'] == 200 && isset($response['body']) ){
                    $call_result = $response['body'];
                }else{
                    $call_result = false;
                    if(!is_wp_error($response)){
                       $error = $response['response']['message'];
                   }else{
                        $error = $response->get_error_message();
                   }
                }

                $result['data'] = $call_result;
                if(!$call_result){
                    $result['error'] = $error;
                }
            }else{
                $result['error'] = __('Unable to connect to server','wp-job-portal');
            }
        }

        $result = json_encode($result);

        return $result;
    }

    function makeLanguageCode($lang_name){
        $langarray = wp_get_installed_translations('core');
        $langarray = $langarray['default'];
        $match = false;
        if(array_key_exists($lang_name, $langarray)){
            $lang_name = $lang_name;
            $match = true;
        }else{
            $m_lang = '';
            foreach($langarray AS $k => $v){
                if($lang_name[0].$lang_name[1] == $k[0].$k[1]){
                    $m_lang .= $k.', ';
                }
            }

            if($m_lang != ''){
                $m_lang = wpjobportalphplib::wpJP_substr($m_lang, 0,wpjobportalphplib::wpJP_strlen($m_lang) - 2);
                $lang_name = $m_lang;
                $match = 2;
            }else{
                $lang_name = $lang_name;
                $match = false;
            }
        }

        return array('match' => $match , 'lang_name' => $lang_name);
    }

    function validateAndShowDownloadFileName( ){
        $lang_name = WPJOBPORTALrequest::getVar('langname');
        if($lang_name == '') return '';
        $result = array();
        $f_result = $this->makeLanguageCode($lang_name);
        $path = WPJOBPORTAL_PLUGIN_PATH.'languages';
        $result['error'] = false;
        if($f_result['match'] === false){
            $result['error'] = $lang_name. ' ' . __('Language is not installed','wp-job-portal');
        }elseif( ! is_writeable($path)){
            $result['error'] = $lang_name. ' ' . __('Language directory is not writeable','wp-job-portal').': '.$path;
        }else{
            $result['input'] = '<input id="languagecode" class="text_area" type="text" value="'.$lang_name.'" name="languagecode">';
            if($f_result['match'] === 2){
                $result['input'] .= '<div id="js-emessage-wrapper" style="display:block;margin:20px 0px 20px;">';
                $result['input'] .= __('Required language is not installed but similar language[s] like').': "<b>'.$f_result['lang_name'].'</b>" '.__('is found in your system','wp-job-portal');
                $result['input'] .= '</div>';

            }
            $result['path'] = __('Language code','wp-job-portal');
        }
        $result = json_encode($result);
        return $result;
    }

    function getLanguageTranslation(){

        $lang_name = WPJOBPORTALrequest::getVar('langname');
        $language_code = WPJOBPORTALrequest::getVar('filename');

        $result = array();
        $result['error'] = false;
        $path = WPJOBPORTAL_PLUGIN_PATH.'languages';

        if($lang_name == '' || $language_code == ''){
            $result['error'] = __('Empty values','wp-job-portal');
            return json_encode($result);
        }

        $final_path = $path.'/wp-job-portal-'.$language_code.'.po';


        $langarray = wp_get_installed_translations('core');
        $langarray = $langarray['default'];

        if(!array_key_exists($language_code, $langarray)){
            $result['error'] = $lang_name. ' ' . __('Language is not installed','wp-job-portal');
            return json_encode($result);
        }elseif( ! is_writeable($path)){
            $result['error'] = $lang_name. ' ' . __('Language directory is not writable','wp-job-portal').': '.$path;
            return json_encode($result);
        }

        if( ! file_exists($final_path)){
            touch($final_path);
        }

        if( ! is_writeable($final_path)){
            $result['error'] = __('File is not writable','wp-job-portal').': '.$final_path;
        }else{

            if($this->isConnected()){

                $version = WPJOBPORTALIncluder::getJSModel('configuration')->getConfigByFor('version');

                $url = "http://www.joomsky.com/translations/api/1.0/index.php";
                $post_data['product'] ='wp-job-portal-wp';
                $post_data['domain'] = get_site_url();
                $post_data['producttype'] = $version['versiontype'];
                $post_data['productcode'] = 'wpjobportal';
                $post_data['productversion'] = $version['version'];
                $post_data['JVERSION'] = get_bloginfo('version');
                $post_data['translationcode'] = $lang_name;
                $post_data['method'] = 'getTranslationFile';

                $curl_response = wp_remote_post($url,array('body'=>$post_data));
                if( !is_wp_error($curl_response) && $curl_response['response']['code'] == 200 && isset($curl_response['body']) ){
                    $response = $curl_response['body'];
                    $array = json_decode($response, true);
                    $ret = $this->writeLanguageFile( $final_path , $array['file']);
                    if($ret != false){
                        $url = "https://www.joomsky.com/translations/api/1.0/index.php";
                        $post_data['product'] ='wp-job-portal';
                        $post_data['domain'] = get_site_url();
                        // $post_data['producttype'] = $version['versiontype'];
                        $post_data['productcode'] = 'wpjobportal';
                        $post_data['productversion'] = $version['productversion'];
                        $post_data['JVERSION'] = get_bloginfo('version');
                        $post_data['folder'] = $array['foldername'];
                        $curl_response = wp_remote_post($url,array('body'=>$post_data));
                        $response = $curl_response['body'];
                    }
                    $result['data'] = __('File Downloaded Successfully','wp-job-portal');
                }else{
                    $result['error'] = $curl_response->get_error_message();
                }
            }else{
                $result['error'] = __('Unable to connect to server','wp-job-portal');
            }
        }

        $result = json_encode($result);

        return $result;

    }

    function writeLanguageFile( $path , $url ){
		include(ABSPATH . "wp-admin/includes/admin.php");
		$tmpfile = download_url( $url);
		copy( $tmpfile, $path );
		@unlink( $tmpfile ); // must unlink afterwards

        //make mo for po file
        $this->phpmo_convert($path);
        return $result;
    }

    function isConnected(){

        $connected = @fsockopen("www.google.com", 80);
        if ($connected){
            $is_conn = true; //action when connected
            fclose($connected);
        }else{
            $is_conn = false; //action in connection failure
        }
        return $is_conn;
    }

    function phpmo_convert($input, $output = false) {
        if ( !$output )
            $output = wpjobportalphplib::wpJP_str_replace( '.po', '.mo', $input );
        $hash = $this->phpmo_parse_po_file( $input );
        if ( $hash === false ) {
            return false;
        } else {
            $this->phpmo_write_mo_file( $hash, $output );
            return true;
        }
    }

    function phpmo_clean_helper($x) {
        if (is_array($x)) {
            foreach ($x as $k => $v) {
                $x[$k] = $this->phpmo_clean_helper($v);
            }
        } else {
            if ($x[0] == '"')
                $x = wpjobportalphplib::wpJP_substr($x, 1, -1);
            $x = wpjobportalphplib::wpJP_str_replace("\"\n\"", '', $x);
            $x = wpjobportalphplib::wpJP_str_replace('$', '\\$', $x);
        }
        return $x;
    }
    /* Parse gettext .po files. */
    /* @link http://www.gnu.org/software/gettext/manual/gettext.html#PO-Files */
    function phpmo_parse_po_file($in) {
    if (!file_exists($in)){ return false; }
    $ids = array();
    $strings = array();
    $language = array();
    $lines = file($in);
    foreach ($lines as $line_num => $line) {
        if (wpjobportalphplib::wpJP_strstr($line, 'msgid')){
            $endpos = strrchr($line, '"');
            $id = wpjobportalphplib::wpJP_substr($line, 7, $endpos-2);
            $ids[] = $id;
        }elseif(wpjobportalphplib::wpJP_strstr($line, 'msgstr')){
            $endpos = strrchr($line, '"');
            $string = wpjobportalphplib::wpJP_substr($line, 8, $endpos-2);
            $strings[] = array($string);
        }else{}
    }
    for ($i=0; $i<count($ids); $i++){
        //Shoaib
        if(isset($ids[$i]) && isset($strings[$i])){
            if($entry['msgstr'][0] == '""'){
                continue;
            }
            $language[$ids[$i]] = array('msgid' => $ids[$i], 'msgstr' =>$strings[$i]);
        }
    }
    return $language;
    }
    /* Write a GNU gettext style machine object. */
    /* @link http://www.gnu.org/software/gettext/manual/gettext.html#MO-Files */
    function phpmo_write_mo_file($hash, $out) {
        // sort by msgid
        ksort($hash, SORT_STRING);
        // our mo file data
        $mo = '';
        // header data
        $offsets = array ();
        $ids = '';
        $strings = '';
        foreach ($hash as $entry) {
            $id = $entry['msgid'];
            $str = implode("\x00", $entry['msgstr']);
            // keep track of offsets
            $offsets[] = array (
                            wpjobportalphplib::wpJP_strlen($ids), wpjobportalphplib::wpJP_strlen($id), wpjobportalphplib::wpJP_strlen($strings), wpjobportalphplib::wpJP_strlen($str)
                            );
            // plural msgids are not stored (?)
            $ids .= $id . "\x00";
            $strings .= $str . "\x00";
        }
        // keys start after the header (7 words) + index tables ($#hash * 4 words)
        $key_start = 7 * 4 + sizeof($hash) * 4 * 4;
        // values start right after the keys
        $value_start = $key_start +wpjobportalphplib::wpJP_strlen($ids);
        // first all key offsets, then all value offsets
        $key_offsets = array ();
        $value_offsets = array ();
        // calculate
        foreach ($offsets as $v) {
            list ($o1, $l1, $o2, $l2) = $v;
            $key_offsets[] = $l1;
            $key_offsets[] = $o1 + $key_start;
            $value_offsets[] = $l2;
            $value_offsets[] = $o2 + $value_start;
        }
        $offsets = array_merge($key_offsets, $value_offsets);
        // write header
        $mo .= pack('Iiiiiii', 0x950412de, // magic number
        0, // version
        sizeof($hash), // number of entries in the catalog
        7 * 4, // key index offset
        7 * 4 + sizeof($hash) * 8, // value index offset,
        0, // hashtable size (unused, thus 0)
        $key_start // hashtable offset
        );
        // offsets
        foreach ($offsets as $offset)
            $mo .= pack('i', $offset);
        // ids
        $mo .= $ids;
        // strings
        $mo .= $strings;
        file_put_contents($out, $mo);
    }

    function updateDate($addon_name,$plugin_version){
        return WPJOBPORTALincluder::getJSModel('premiumplugin')->verfifyAddonActivation($addon_name);
    }

    function getAddonSqlForActivation($addon_name,$addon_version){
        return WPJOBPORTALincluder::getJSModel('premiumplugin')->verifyAddonSqlFile($addon_name,$addon_version);
    }

    function storeOrderingFromPage($data) {//
        if (empty($data)) {
            return false;
        }
        $sorted_array = array();
        wpjobportalphplib::wpJP_parse_str($data['fields_ordering_new'],$sorted_array);
        $sorted_array = reset($sorted_array);
        if(!empty($sorted_array)){
            if($data['ordering_for'] == 'fieldordering'){
                $row = WPJOBPORTALincluder::getJSTable('fieldsordering');
                $ordering_coloumn = 'ordering';
                $msgkey = WPJOBPORTALincluder::getJSModel('fieldordering')->getMessagekey();
            }
            $page_multiplier = 1;
            if($data['pagenum_for_ordering'] > 1){
                $page_multiplier = ($data['pagenum_for_ordering'] - 1) * wpjobportal::$_configuration['pagination_default_page_size'] + 1;
            }
            for ($i=0; $i < count($sorted_array) ; $i++) {
                $row->update(array('id' => $sorted_array[$i], $ordering_coloumn => $page_multiplier + $i));
            }
        }
        WPJOBPORTALMessages::setLayoutMessage(__('Ordering updated', 'wp-job-portal'), 'updated', $msgkey);
        return ;
    }



    function getMessagekey(){
        $key = 'wpjobportal';if(wpjobportal::$_common->wpjp_isadmin()){$key = 'admin_'.$key;}return $key;
    }



}

?>
