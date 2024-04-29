<?php

if (!defined('ABSPATH'))
    die('Restricted Access');

class WPJOBPORTALjobSearchModel {

    function getSearchJobs_Widget($title, $showtitle, $fieldtitle, $category, $jobtype, $jobstatus, $salaryrange, $shift, $duration, $startpublishing, $stoppublishing, $company, $address, $columnperrow) {
        if ($columnperrow <= 0)
            $columnperrow = 1;
        $width = round(100 / $columnperrow);
        $style = "style='width:" . $width . "%'";

        $html = '
                <div id="wpjobportal_mod_wrapper" class="wjportal-search-mod wjportal-form-mod">';
        if ($showtitle == 1) {
            $html .= '<div id="wpjobportal-mod-heading" class="wjportal-mod-heading"> ' . $title . ' </div>';
        }
        $html .='<form class="job_form wjportal-form" id="job_form" method="post" action="' . wpjobportal::makeUrl(array('wpjobportalme'=>'job', 'wpjobportallt'=>'jobs', 'wpjobportalpageid'=>wpjobportal::getPageid())) . '">';

        if ($fieldtitle == 1) {
            $title = __('Title', 'wp-job-portal');
            $value = WPJOBPORTALformfield::text('jobtitle', '', array('class' => 'inputbox'));
            $html .= '<div class="wjportal-form-row" ' . $style . '>
                <div class="wjportal-form-tit">' . $title . '</div>
                <div class="wjportal-form-val">' . $value . '</div>
            </div>';
        }

        if ($category == 1) {
            $title = __('Category', 'wp-job-portal');
            $value = WPJOBPORTALformfield::select('category[]', WPJOBPORTALincluder::getJSModel('category')->getCategoriesForCombo(), isset(wpjobportal::$_data['filter']['category']) ? wpjobportal::$_data['filter']['category'] : '', __('Select','wp-job-portal') .' '. __('Category', 'wp-job-portal'), array('class' => 'inputbox'));
            $html .= '<div class="wjportal-form-row" ' . $style . '>
                <div class="wjportal-form-tit">' . $title . '</div>
                <div class="wjportal-form-val">' . $value . '</div>
            </div>';
        }

        if ($jobtype == 1) {
            $title = __('Job Type', 'wp-job-portal');
            $value = WPJOBPORTALformfield::select('jobtype[]', WPJOBPORTALincluder::getJSModel('jobtype')->getJobTypeForCombo(), isset(wpjobportal::$_data['filter']['jobtype']) ? wpjobportal::$_data['filter']['jobtype'] : '', __('Select','wp-job-portal') .' '. __('Job Type', 'wp-job-portal'), array('class' => 'inputbox'));
            $html .= '<div class="wjportal-form-row" ' . $style . '>
                <div class="wjportal-form-tit">' . $title . '</div>
                <div class="wjportal-form-val">' . $value . '</div>
            </div>';
        }
        if ($jobstatus == 1) {
            $title = __('Job Status', 'wp-job-portal');
            $value = WPJOBPORTALformfield::select('jobstatus[]', WPJOBPORTALincluder::getJSModel('jobstatus')->getJobStatusForCombo(), isset(wpjobportal::$_data['filter']['jobstatus']) ? wpjobportal::$_data['filter']['jobstatus'] : '', __('Select','wp-job-portal') .' '. __('Job Status', 'wp-job-portal'), array('class' => 'inputbox'));
            $html .= '<div class="wjportal-form-row" ' . $style . '>
                <div class="wjportal-form-tit">' . $title . '</div>
                <div class="wjportal-form-val">' . $value . '</div>
            </div>';
        }
        /*if ($salaryrange == 1) {
            $title = __('Salary Range', 'wp-job-portal');
            $value = WPJOBPORTALformfield::select('currencyid', WPJOBPORTALincluder::getJSModel('currency')->getCurrencyForCombo(), isset(wpjobportal::$_data[0]['filter']->currencyid) ? wpjobportal::$_data[0]['filter']->currencyid : '', __('Select','wp-job-portal') .' '. __('Currency', 'wp-job-portal'), array('class' => 'inputbox sal'));
            $value .= WPJOBPORTALformfield::select('salaryrangestart', WPJOBPORTALincluder::getJSModel('salaryrange')->getJobStartSalaryRangeForCombo(), isset(wpjobportal::$_data[0]['filter']->salaryrange) ? wpjobportal::$_data[0]['filter']->salaryrange : '', __('Select','wp-job-portal') .' '. __('Salary Range','wp-job-portal') .' '. __('Start', 'wp-job-portal'), array('class' => 'inputbox sal'));
            $value .= WPJOBPORTALformfield::select('salaryrangeend', WPJOBPORTALincluder::getJSModel('salaryrange')->getJobEndSalaryRangeForCombo(), isset(wpjobportal::$_data[0]['filter']->salaryrange) ? wpjobportal::$_data[0]['filter']->salaryrange : '', __('Select','wp-job-portal') .' '. __('Salary Range','wp-job-portal') .' '. __('End', 'wp-job-portal'), array('class' => 'inputbox sal'));
            $value .= WPJOBPORTALformfield::select('salaryrangetype', WPJOBPORTALincluder::getJSModel('salaryrangetype')->getSalaryRangeTypesForCombo(), isset(wpjobportal::$_data[0]['filter']->salaryrangetype) ? wpjobportal::$_data[0]['filter']->salaryrangetype : '', __('Select','wp-job-portal') .' '. __('Salary Range Type', 'wp-job-portal'), array('class' => 'inputbox sal'));
            $html .= '<div class="wjportal-form-row" ' . $style . '>
                <div class="wjportal-form-tit">' . $title . '</div>
                <div class="wjportal-form-val">' . $value . '</div>
            </div>';
        }*/

        if ($duration == 1) {
            $title = __('Duration', 'wp-job-portal');
            $value = WPJOBPORTALformfield::text('duration', isset(wpjobportal::$_data['filter']['duration']) ? wpjobportal::$_data['filter']['duration'] : '', array('class' => 'inputbox'));
            $html .= '<div class="wjportal-form-row" ' . $style . '>
                <div class="wjportal-form-tit">' . $title . '</div>
                <div class="wjportal-form-val">' . $value . '</div>
            </div>';
        }
        if ($startpublishing == 1) {

        }
        if ($stoppublishing == 1) {

        }
        if ($company == 1) {
            $title = __('Company', 'wp-job-portal');
            $value = WPJOBPORTALformfield::select('company[]', WPJOBPORTALincluder::getJSModel('company')->getCompaniesForCombo(), isset(wpjobportal::$_data['filter']['company']) ? wpjobportal::$_data['filter']['company'] : '', __('Select','wp-job-portal') .' '. __('Company', 'wp-job-portal'), array('class' => 'inputbox'));
            $html .= '<div class="wjportal-form-row" ' . $style . '>
                <div class="wjportal-form-tit">' . $title . '</div>
                <div class="wjportal-form-val">' . $value . '</div>
            </div>';
        }
        if ($address == 1) {
            $title = __('City', 'wp-job-portal');
            $value = WPJOBPORTALformfield::text('city', isset(wpjobportal::$_data['filter']['city']) ? wpjobportal::$_data['filter']['city'] : '', array('class' => 'inputbox'));
            $html .= '<div class="wjportal-form-row" ' . $style . '>
                <div class="wjportal-form-tit">' . $title . '</div>
                <div class="wjportal-form-val">' . $value . '</div>
            </div>';
        }

        $html .= '<div class="wjportal-form-btn-row">
                        ' . WPJOBPORTALformfield::submitbutton('save', __('Search Job', 'wp-job-portal'), array('class' => 'button wjportal-form-btn wjportal-form-srch-btn')) . '
                        <a class="anchor wjportal-form-btn wjportal-form-adv-srch-btn" href="' . wpjobportal::makeUrl(array('wpjobportalme'=>'jobsearch', 'wpjobportallt'=>'jobsearch', 'wpjobportalpageid'=>wpjobportal::getPageid())) . '">
                        ' . __('Advance Search', 'wp-job-portal') . '
                        </a>
                    </div>
                    <input type="hidden" id="issearchform" name="issearchform" value="1"/>
                    <input type="hidden" id="WPJOBPORTAL_form_search" name="WPJOBPORTAL_form_search" value="WPJOBPORTAL_SEARCH"/>
                    <input type="hidden" id="wpjobportallay" name="wpjobportallay" value="jobs"/>
                </form>
                </div>


            <script >
                function getTokenInput() {
                    var cityArray = "' . admin_url("admin.php?page=wpjobportal_city&action=wpjobportaltask&task=getaddressdatabycityname") . '";
                    jQuery("#city").tokenInput(cityArray, {
                        theme: "wpjobportal",
                        preventDuplicates: true,
                        hintText: "' . __('Type In A Search Term', 'wp-job-portal') . '",
                        noResultsText: "' . __('No Results', 'wp-job-portal') . '",
                        searchingText: "' . __('Searching', 'wp-job-portal') . '"
                    });
                }
                jQuery(document).ready(function(){
                    getTokenInput();
                });
            </script>
            ';




        return $html;
    }

    function getJobSearchOptions() {
        wpjobportal::$_data[2] = WPJOBPORTALincluder::getJSModel('fieldordering')->getFieldsOrderingforSearch(2);
    }

function getMessagekey(){
        $key = 'jobsearch';if(wpjobportal::$_common->wpjp_isadmin()){$key = 'admin_'.$key;}return $key;
    }



}

?>
