<?php

if (!defined('ABSPATH'))
    die('Restricted Access');

class WPJOBPORTALhandlesearchcookies {
    public $_jsjp_search_array;
    public $_callfrom;
    public $_setcookies;

    function __construct( ) {
        $this->_jsjp_search_array = array();
        $this->_callfrom = 3; // 3 means cookies will be reset
        $this->_setcookies = false;
        $this->init();
    }

    function init(){
        $isadmin = wpjobportal::$_common->wpjp_isadmin();
        $jstlay = '';
        $page = WPJOBPORTALrequest::getVar('page');
        $wpjobportallt = WPJOBPORTALrequest::getVar('wpjobportallt');
        $wpjobportallay = WPJOBPORTALrequest::getVar('wpjobportallay');
        if($page != '' ){ // page is for admin case
            $jstlay = $page;
        }elseif($wpjobportallt !=''){// for layouts
            $jstlay = $wpjobportallt;
        }elseif($wpjobportallay !=''){ // is for search, pagiantion and top sorting case
            $jstlay = $wpjobportallay;
        }

        $layoutname = wpjobportalphplib::wpJP_explode("wpjobportal_", $jstlay);// admin page has wpjobportal_ prefix
        if(isset($layoutname[1])){
            $jstlay = $layoutname[1];
        }

        $from_search = WPJOBPORTALrequest::getVar('WPJOBPORTAL_form_search');
        if( $from_search != '' && $from_search == 'WPJOBPORTAL_SEARCH'){ // search form is submitted set callfrom =1 to set values in cookie
            $this->_callfrom = 1;
        }elseif(WPJOBPORTALrequest::getVar('pagenum', 'get', null) != null){ // pagination case
            $this->_callfrom = 2;
        }

        switch($jstlay){
            case 'jobs':
            case 'job':
                $this->searchdataforjobs();
            break;
            case 'myresume':
            case 'resumes':
            case 'resume':
                $this->searchFormDataForResume($jstlay);
            break;
            case 'appliedjobs': // for jobseeker case
            case 'myjobs': // For employer case
            case 'activitylog': // For activity log
                $this->searchFormDataForCommonData($jstlay);
            break;
            // case 'mycompany': // For employer case
            // case 'company': // For admin case
            //     $this->searchFormDataForCompanies();
            // break;
            case 'careerlevel':
                if(is_admin())
                    $this->searchFormDataForCareerLevel();
            break;
            case 'category':
                if(is_admin())
                    $this->searchFormDataForCategory();
            break;
            case 'city':
                if(is_admin())
                    $this->searchFormDataForCity();
            break;
            case 'country':
                if(is_admin())
                    $this->searchFormDataForCountry();
            break;
            case 'currency':
            case 'fieldordering':
            case 'highesteducation':
            case 'user':
            case 'state':
            case 'slug':
            case 'salaryrangetype':
            case 'jobstatus':
            case 'jobtype':
                if(is_admin()){
                    $this->setSearchFormData($jstlay);
                }
            break;
            case 'departments':
            case 'jobapply':
            case 'coverletter':
            case 'invoice':
            case 'purchasehistory':
            case 'folder':
            case 'jobalert':
            case 'message':
            case 'company':
            case 'mycompany':
            case 'tag':
                    $this->setSearchFormDataAdminListing();
            break;

            default:
                wpjobportal::removeusersearchcookies();
            break;
        }

        if($this->_setcookies){
            wpjobportal::setusersearchcookies($this->_setcookies,$this->_jsjp_search_array);
        }
    }

    private function searchdataforjobs(){
        $search_userfields = array();
        // $search_userfields = JSSTincluder::getObjectClass('customfields')->userFieldsForSearch(1);
        if($this->_callfrom == 1 || $this->_callfrom == 3){ //  3 for theme
            if(is_admin()){
                $this->_jsjp_search_array = WPJOBPORTALincluder::getJSModel('job')->getAdminJobSearchFormData($search_userfields);
            }else{
                $this->_jsjp_search_array = WPJOBPORTALincluder::getJSModel('job')->getFrontSideJobSearchFormData($search_userfields);
            }
            $this->_setcookies = true;
        }elseif($this->_callfrom == 2){
            $this->_jsjp_search_array = WPJOBPORTALincluder::getJSModel('job')->getCookiesSavedSearchDataJob($search_userfields);
        }
        WPJOBPORTALincluder::getJSModel('job')->setSearchVariableForJob($this->_jsjp_search_array,$search_userfields);
    }

    private function searchFormDataForResume($layout){
        if($this->_callfrom == 1 || $this->_callfrom == 3){ // 3 for theme
            if(is_admin()){
                $this->_jsjp_search_array = WPJOBPORTALincluder::getJSModel('resume')->getAdminResumeSearchFormData();
            }else{
                $this->_jsjp_search_array = WPJOBPORTALincluder::getJSModel('resume')->getMyResumeSearchFormData($layout);
            }
            $this->_setcookies = true;
        }elseif($this->_callfrom == 2){
            $this->_jsjp_search_array = WPJOBPORTALincluder::getJSModel('resume')->getResumeSavedCookiesData($layout);
        }
        if(is_admin()){
            WPJOBPORTALincluder::getJSModel('resume')->setSearchVariableForAdminResume($this->_jsjp_search_array,$layout);
        }else{
            WPJOBPORTALincluder::getJSModel('resume')->setSearchVariableForMyResume($this->_jsjp_search_array,$layout);
        }
    }

    private function searchFormDataForCommonData($jstlay){
        if($this->_callfrom == 1){
            $this->_jsjp_search_array = WPJOBPORTALincluder::getJSModel('common')->getSearchFormDataOnlySort($jstlay);
            $this->_setcookies = true;
        }elseif($this->_callfrom == 2){
            $this->_jsjp_search_array = WPJOBPORTALincluder::getJSModel('common')->getCookiesSavedOnlySortandOrder();
        }
        WPJOBPORTALincluder::getJSModel('common')->setSearchVariableOnlySortandOrder($this->_jsjp_search_array,$jstlay);
    }

    private function searchFormDataForCompanies(){
        if($this->_callfrom == 1){
            if(is_admin()){
                $this->_jsjp_search_array = WPJOBPORTALincluder::getJSModel('company')->getSearchFormAdminCompanyData();
            }else{
                $this->_jsjp_search_array = WPJOBPORTALincluder::getJSModel('company')->getSearchFormDataMyCompany();
            }
            $this->_setcookies = true;
        }elseif($this->_callfrom == 2){
            if(is_admin()){
                $this->_jsjp_search_array = WPJOBPORTALincluder::getJSModel('company')->getAdminCompanySavedCookies();
            }else{
                $this->_jsjp_search_array = WPJOBPORTALincluder::getJSModel('company')->getCookiesSavedMyCompany();
            }
        }
        if(is_admin()){
            WPJOBPORTALincluder::getJSModel('company')->setAdminCompanySearchVariable($this->_jsjp_search_array);
        }else{
            WPJOBPORTALincluder::getJSModel('company')->setSearchVariableMyCompany($this->_jsjp_search_array);
        }
    }

    private function searchFormDataForCareerLevel(){
        if($this->_callfrom == 1){
            $this->_jsjp_search_array = WPJOBPORTALincluder::getJSModel('careerlevel')->getSearchFormDataCareerLevel();
            $this->_setcookies = true;
        }elseif($this->_callfrom == 2){
            $this->_jsjp_search_array = WPJOBPORTALincluder::getJSModel('careerlevel')->getCookiesSavedCareerLevel();
        }
        WPJOBPORTALincluder::getJSModel('careerlevel')->setSearchVariableCareerLevel($this->_jsjp_search_array);
    }

    private function searchFormDataForCategory(){
        if($this->_callfrom == 1){
            $this->_jsjp_search_array = WPJOBPORTALincluder::getJSModel('category')->getSearchFormDataCategory();
            $this->_setcookies = true;
        }elseif($this->_callfrom == 2){
            $this->_jsjp_search_array = WPJOBPORTALincluder::getJSModel('category')->getCookiesSavedCategory();
        }
        WPJOBPORTALincluder::getJSModel('category')->setSearchVariableCategory($this->_jsjp_search_array);
    }

    private function searchFormDataForCity(){
        if($this->_callfrom == 1){
            $this->_jsjp_search_array = WPJOBPORTALincluder::getJSModel('city')->getSearchFormDataCity();
            $this->_setcookies = true;
        }elseif($this->_callfrom == 2){
            $this->_jsjp_search_array = WPJOBPORTALincluder::getJSModel('city')->getCookiesSavedCity();
        }
        WPJOBPORTALincluder::getJSModel('city')->setSearchVariableCity($this->_jsjp_search_array);
    }

    private function searchFormDataForCountry(){
        if($this->_callfrom == 1){
            $this->_jsjp_search_array = WPJOBPORTALincluder::getJSModel('country')->getCountrySearchFormData();
            $this->_setcookies = true;
        }elseif($this->_callfrom == 2){
            $this->_jsjp_search_array = WPJOBPORTALincluder::getJSModel('country')->getCountrySavedCookiesData();
        }
        WPJOBPORTALincluder::getJSModel('country')->setCountrySearchVariable($this->_jsjp_search_array);
    }

    private function setSearchFormData($module){
        if($this->_callfrom == 1){
            $this->_jsjp_search_array = WPJOBPORTALincluder::getJSModel($module)->getSearchFormData();
            $this->_setcookies = true;
        }elseif($this->_callfrom == 2){
            $this->_jsjp_search_array = WPJOBPORTALincluder::getJSModel($module)->getSavedCookiesDataForSearch();
        }
        WPJOBPORTALincluder::getJSModel($module)->setSearchVariableForSearch($this->_jsjp_search_array);
    }

    private function setSearchFormDataAdminListing(){
        if($this->_callfrom == 1){
            $this->_jsjp_search_array = WPJOBPORTALincluder::getJSModel('common')->getSearchFormDataAdmin();
            $this->_setcookies = true;
        }elseif($this->_callfrom == 2){
            $this->_jsjp_search_array = WPJOBPORTALincluder::getJSModel('common')->getCookiesSavedAdmin();
        }
        WPJOBPORTALincluder::getJSModel('common')->setSearchVariableAdmin($this->_jsjp_search_array);
    }

}

?>
