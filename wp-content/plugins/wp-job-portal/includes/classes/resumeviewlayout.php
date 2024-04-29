<?php

if (!defined('ABSPATH'))
    die('Restricted Access');

class WPJOBPORTALResumeViewlayout {

    public $config_array_sec=array();
    public $themecall = 0;
    public $class_prefix = '';


    function __construct(){
        $this->config_array_sec = wpjobportal::$_config->getConfigByFor('resume');
        $fieldsordering =wpjobportal::$_wpjpfieldordering->getFieldsOrderingforForm(3); // resume fields
        wpjobportal::$_data[2] = array();
        foreach ($fieldsordering AS $field) {
            wpjobportal::$_data['fieldtitles'][$field->field] = $field->fieldtitle;
            wpjobportal::$_data[2][$field->section][$field->field] = $field;
        }
        if(wpjobportal::$theme_chk == 2){/// code to manage class prefix for diffrent template cases
            $this->class_prefix = 'jsjb-jh';
            $this->themecall = 2;

        }elseif(wpjobportal::$theme_chk == 1){
            $this->class_prefix = 'wpj-jp';
            $this->themecall = 1;
        }else{
            $this->class_prefix = '';
        }

    }
    function getRowMapForView($text, $longitude, $latitude,$themecall=null) {
        $id = uniqid();
        if(null != $themecall){
            $html = '<div class="'.$this->class_prefix.'-resumedetail-address-map-wrap">
                        <div class="'.$this->class_prefix.'-resumedetail-address-map">
                            <span class="'.$this->class_prefix.'-resumedetail-address-map-showhide"><img src="' . JOB_PORTAL_IMAGE . '/cu_loc.png" class="image"/></span>
                            ' . $text . '
                        </div>
                        <div class="'.$this->class_prefix.'-resumedetail-address-map-area" style="display: none;">
                            <div class="'.$this->class_prefix.'-map-inner">
                                <div id="'.$this->class_prefix.'-map" style="position: relative; overflow: hidden;">
                                    <div id="' . $id . '" class="map" style="width:100%;min-height:200px;">' . $longitude . ' - ' . $latitude . '</div>
                                </div>
                            </div>
                        </div>
                        <script id="script_' . $id . '">
                            jQuery(document).ready(function(){
                                initialize("' . $latitude . '","' . $longitude . '","' . $id . '");
                            });
                        </script>
                    </div>';
        }else{
            $html = '<div class="resume-map">
                    <div class="row-title"><img src="' . WPJOBPORTAL_PLUGIN_URL . 'includes/images/resume/hide-map.png" class="image"/>' . $text . '</div>
                    <div class="row-value"><div id="' . $id . '" class="map" style="width:100%;min-height:200px;">' . $longitude . ' - ' . $latitude . '</div></div>
                    <script id="script_' . $id . '">
                        initialize("' . $latitude . '","' . $longitude . '","' . $id . '");
                    </script>
                </div>';
        }
        return $html;
    }


    function getAttachmentRowForViewJobManager($adminLogin) {
        return $this->getAttachmentRowForViewForTemplate($adminLogin);
    }

    function getAttachmentRowForViewJobHub($adminLogin) {
        return $this->getAttachmentRowForViewForTemplate($adminLogin);
    }

    function getAttachmentRowForViewForTemplate($adminLogin) {
        $html='<div id="'.$this->class_prefix.'-resumedetail-attachment" class="'.$this->class_prefix.'-resumedetail-section">
            <div class="'.$this->class_prefix.'-resumedetail-section-title">
                <span class="'.$this->class_prefix.'-resumedetail-section-icon">
                    <img alt="attachment" title="attachment" src="'.JOB_PORTAL_IMAGE.'/attchments.png">
                </span>
                <h5 class="'.$this->class_prefix.'-resumedetail-section-txt">
                    '.__("Attachment","wp-job-portal").'
                </h5>
            </div>
            <div class="'.$this->class_prefix.'-resumedetail-sec-data">
                <div class="'.$this->class_prefix.'-resumedetail-sec-download">
                    <div class="input-group">';
                        foreach (wpjobportal::$_data[0]['file_section'] AS $file) {
                            $files=$file->filename;
                            $exp_extension = wpjobportalphplib::wpJP_explode(".", $files);
                            $extension = end($exp_extension);
                            $filename=wpjobportalphplib::wpJP_substr($files,'0','3')."...";
                            $html .= '<a target="_blank" href="' . wpjobportal::makeUrl(array('wpjobportalme'=>'resume', 'action'=>'wpjobportaltask', 'task'=>'getresumefiledownloadbyid', 'wpjobportalid'=>$file->id, 'wpjobportalpageid'=>WPJOBPORTALRequest::getVar('wpjobportalpageid'))) . '" class="file">
                                        <span class="wpjp-filename">' . $filename . '</span><span class="wpjp-fileext">'.$extension.'</span>
                                        <i class="fa fa-download download" aria-hidden="true"></i>
                                    </a>';
                        }
                    $html .='</div>';
                    if(!empty(wpjobportal::$_data[0]['file_section']) && (wpjobportal::$_data['resumecontactdetail'] == true || $adminLogin)){
                         $html .= apply_filters('wpjobportal_addons_resume_action_ResumeFile',false,wpjobportal::$_data[0]['personal_section']);
                    }
                $html .= '</div>
            </div>
        </div>';
        return $html;
    }

    function getAttachmentRowForView($text,$themecall=null) {
        if(null !=$themecall) return;
        $html = '<div class="wjportal-resume-sec-row wjportal-resume-attachments-wrp">
                    <div class="wjportal-resume-sec-data wjportal-resume-row-full-width">
                        <div class="wjportal-resume-sec-data-title">' . __($text,'wp-job-portal') . ':</div>
                        <div class="wjportal-resume-sec-data-value">';
        if (!empty(wpjobportal::$_data[0]['file_section'])) {
            foreach (wpjobportal::$_data[0]['file_section'] AS $file) {
                $html .= '<a target="_blank" href="' . wpjobportal::makeUrl(array('wpjobportalme'=>'resume', 'action'=>'wpjobportaltask', 'task'=>'getresumefiledownloadbyid', 'wpjobportalid'=>$file->id, 'wpjobportalpageid'=>WPJOBPORTALRequest::getVar('wpjobportalpageid'))) . '" class="file">
                            <span class="wjportal-resume-attachment-filename">' . $file->filename . '</span>
                            <span class="wjportal-resume-attachment-file-ext"></span>
                            <img class="wjportal-resume-attachment-file-download" src="' . WPJOBPORTAL_PLUGIN_URL . 'includes/images/resume/download.png" />
                        </a>';
            }
        }
        $html .= '      </div>
                    </div>
                </div>';
        return $html;
    }


    function getResumeSection($resumeformview, $call, $viewlayout = 0,$themecall=null) {
        $html = '';
        if ($resumeformview == 0) { // edit form
            $html .= '<div class="wjportal-resume-section-wrapper '.$this->class_prefix.'-resumedetail-sec-data" data-section="resume" data-sectionid="">';
            $i = 0;
            foreach (wpjobportal::$_data[2][6] AS $field => $required) {
                switch ($field) {
                    case 'resume':
                        if(null==$themecall){
                            if ($i % 2 != 0) { // close the div if one field is print and the function is finished;
                                $html .= '</div>'; // closing div for the more option
                            }
                        }
                        $value = wpjobportal::$_data[0]['personal_section']->resume;
                        $html .= '<div class="resume-section-data">' . $value . '</div>';
                        $i = 0;
                        break;
                    default:
                        $array = wpjobportal::$_wpjpcustomfield->showCustomFields($field, 11,wpjobportal::$_data[0]['personal_section']->params); //11 for view resume
                        if (is_array($array))
                            $html .= $this->getRowForView($array['title'], $array['value'], $i);
                        break;
                }
            }
            if(null==$themecall){
                if ($i % 2 != 0) { // close the div if one field is print and the function is finished;
                    $html .= '</div>'; // closing div for the more option
                }
            }
            $html .= '</div>';
        }
        return $html;
    }



    function getEmployerSection($resumeformview, $call, $viewlayout = 0,$themecall=null) {
        $html = '';
        if(in_array('advanceresumebuilder', wpjobportal::$_active_addons)){
        if ($resumeformview == 0) { // edit form
            if (!empty(wpjobportal::$_data[0]['employer_section'][0]))
                foreach (wpjobportal::$_data[0]['employer_section'] AS $employer) {
                    $html .= '<div class="wjportal-resume-section-title">' . __('Employer', 'wp-job-portal') . '</div>';
                    $html .= '<div class="wjportal-resume-section-wrapper '.$this->class_prefix.'-resumedetail-sec-data" data-section="employers" data-sectionid="' . $employer->id . '">';
                    $i = 0;
                    $value = $employer->employer;
                    $value .= '<span class="wpjp-resume-employer-dates">(' . date_i18n('M Y', strtotime($employer->employer_from_date)) . ' - ' . date_i18n('M Y', strtotime($employer->employer_to_date)) . ')</span>';
                    if ($viewlayout == 0) {
                        $value .= '<a class="edit" href="#"><img src="' . WPJOBPORTAL_PLUGIN_URL . 'includes/images/edit-resume.png" /></a>';
                        $value .= '<a class="delete" href="#"><img src="' . WPJOBPORTAL_PLUGIN_URL . 'includes/images/delete-resume.png" /></a>';
                    }
                    $html .= $this->getHeadingRowForView($value,$themecall);
                    foreach (wpjobportal::$_data[2][4] AS $field => $required) {
                        switch ($field) {
                            case 'employer_position':
                                $text = $this->getFieldTitleByField($field);
                                $value = $employer->employer_position;
                                $html .= $this->getRowForView($text, $value, $i,$themecall,1);
                                break;
                            case 'employer_city':
                                $text = $this->getFieldTitleByField($field);
                                $value = wpjobportal::$_common->getLocationForView($employer->cityname, '', '');
                                $html .= $this->getRowForView($text, $value, $i,$themecall,1);
                                break;
                            /*EMPLOYEER STATUS IM AVAILABLE     */
                             case 'employer_current_status':
                                $text = $this->getFieldTitleByField($field);
                                $value = $employer->employer_current_status;
                                if($value!="" && $value==1){
                                    $originalDate = $employer->employer_from_date;
                                    $currentDate  =date('d/m/Y');
                                    $multidate=human_time_diff(strtotime($originalDate)).' '.__("",'wp-job-portal');
                                    /*
                                    $duration=wpjobportal::$_common->getYearMonth($mkarray);
                                    $multidate='';
                                    foreach ($duration as $key => $value) {
                                        $name=array_search($value,$duration);
                                        switch ($name) {
                                            case 'years':
                                                if($value>0){
                                                $multidate.=' '.$value.'  '.wpjobportalphplib::wpJP_strtoupper($name);
                                                }
                                                break;
                                            case 'month':
                                               if($value>0){
                                                $multidate.=' '.$value.'  '.wpjobportalphplib::wpJP_strtoupper($name);
                                                }
                                                break;
                                            case 'days':
                                                if($value>0){
                                                $multidate.=' '.$value.'  '.wpjobportalphplib::wpJP_strtoupper($name);
                                                }
                                                break;
                                            default:
                                                if(isset($value)!=''>0){
                                                $multidate.=' '.$value.'  '.wpjobportalphplib::wpJP_strtoupper($name);
                                                }
                                                break;
                                        }
                                    }*/
                                    $html .= $this->getRowForView($text, $multidate, $i,$themecall,1);
                                }
                                break;
                            case 'employer_phone':
                                $text = $this->getFieldTitleByField($field);
                                $value = $employer->employer_phone;
                                $html .= $this->getRowForView($text, $value, $i,$themecall,1);
                                break;
                            case 'employer_address':
                                $text = $this->getFieldTitleByField($field);
                                $value = $employer->employer_address;
                                $html .= $this->getRowForView($text, $value, $i,$themecall,1);

                                break;

                            default:
                                $array = wpjobportal::$_wpjpcustomfield->showCustomFields($field,11,$employer->params); //11 for view resume
                                if (is_array($array))
                                    $html .= $this->getRowForView($array['title'], $array['value'], $i,$themecall,1);
                                break;
                        }
                    }
                    if(null==$themecall){
                        if ($i % 2 != 0) { // close the div if one field is print and the function is finished;
                            $html .= '</div>';
                        }
                    }
                    $html .= '</div>'; // section wrapper end;
                }
        }
        }
        return $html;
    }

   function getAddressesSection($resumeformview, $call, $viewlayout = 0,$themecall=null) {
        $html = '';
        if(in_array('advanceresumebuilder', wpjobportal::$_active_addons)){
        if ($resumeformview == 0) { // view address sections
            if (!empty(wpjobportal::$_data[0]['address_section'][0]))
                foreach (wpjobportal::$_data[0]['address_section'] AS $address) {
                   $html .= '<div class="wjportal-resume-section-title">' . __('Addresses', 'wp-job-portal') . '</div>';
                    $html .= '<div class="wjportal-resume-section-wrapper '.$this->class_prefix.'-resumedetail-sec-data" data-section="addresses" data-sectionid="' . $address->id . '">';
                    $i = 0;
                    $loc = 0;
                    $value = $address->address;
                    if ($viewlayout == 0) {
                        $value .= '<a class="edit" href="#"><img src="' . WPJOBPORTAL_PLUGIN_URL . 'includes/images/edit-resume.png" /></a>';
                        $value .= '<a class="delete" href="#"><img src="' . WPJOBPORTAL_PLUGIN_URL . 'includes/images/delete-resume.png" /></a>';
                    }
                    $html .= $this->getHeadingRowForView($value,$themecall);
                    foreach (wpjobportal::$_data[2][2] AS $field => $required) {
                        switch ($field) {
                            case 'address_city':
                            case 'address_state':
                            case 'address_country':
                                if ($loc == 0) {
                                    $text = $this->getFieldTitleByField($field);
                                    $value = wpjobportal::$_common->getLocationForView($address->cityname, $address->statename, $address->countryname);
                                    $html .= $this->getRowForView($text, $value, $i,$themecall,1);
                                    $loc++;
                                }
                                break;
                            case 'address_location':
                                if(!empty($address->longitude) && !empty($address->latitude)){
                                    $text = $this->getFieldTitleByField($field);
                                    $html .= apply_filters('wpjobportal_addons_map_resune_view',false,$text,$address,$themecall);
                                }
                                break;

                            default:
                                $array = wpjobportal::$_wpjpcustomfield->showCustomFields($field,11,$address->params);
                                //11 for view resume
                                if (is_array($array))
                                    $html .= $this->getRowForView($array['title'], $array['value'], $i,$themecall,1);
                                break;
                        }
                    }
                    if(null==$themecall){
                        if ($i % 2 != 0) { // close the div if one field is print and the function is finished;
                            $html .= '</div>';
                        }
                    }
                $html .= '</div>'; //section wrapper end;
            }
        }
        }
        return $html;
    }

    function getPersonalSection($resumeformview, $viewlayout = 0,$themecall=null) {
        $html = '';
        $personal=wpjobportal::$_data[0]['personal_section'];
        if ($resumeformview == 0) { // view section resume
            $html .= '<div class="wjportal-resume-section-wrapper '.$this->class_prefix.'-resumedetail-sec-data" data-section="personal" data-sectionid="">';
            $i = 0;
            foreach (wpjobportal::$_data[2][1] AS $field => $required) {
                switch ($field) {
                    case 'cell':
                        if (wpjobportal::$_data['resumecontactdetail'] == true) {
                            $text = $this->getFieldTitleByField($field);
                            $value = wpjobportal::$_data[0]['personal_section']->cell;
                            $html .= $this->getRowForView($text, $value, $i,$themecall);
                        }
                        break;
                    case 'nationality':
                        $text = $this->getFieldTitleByField($field);
                        $value = wpjobportal::$_data[0]['personal_section']->nationality;
                        $html .= $this->getRowForView($text, $value, $i,$themecall);
                        break;
                    case 'gender':
                        $text = $this->getFieldTitleByField($field);
                        $value = '';
                        switch (wpjobportal::$_data[0]['personal_section']->gender) {
                            case '0':$value = __('Does not matter', 'wp-job-portal');
                                break;
                            case '1':$value = __('Male', 'wp-job-portal');
                                break;
                            case '2':$value = __('Female', 'wp-job-portal');
                                break;
                        }
                        $html .= $this->getRowForView($text, $value, $i,$themecall);
                        break;
                    case 'job_category':
                        $text = $this->getFieldTitleByField($field);
                        $value = wpjobportal::$_data[0]['personal_section']->categorytitle;
                        $html .= $this->getRowForView($text, $value, $i,$themecall);
                        break;
                    case 'jobtype':
                        $text = $this->getFieldTitleByField($field);
                        $value = wpjobportal::$_data[0]['personal_section']->jobtypetitle;
                        $html .= $this->getRowForView($text, $value, $i,$themecall);
                        break;
                    case 'salaryfixed':
                        $text = $this->getFieldTitleByField($field);
                        $value = isset(wpjobportal::$_data[0]['personal_section']->salaryfixed) ?wpjobportal::$_data[0]['personal_section']->salaryfixed : '';
                        $html .= $this->getRowForView($text, $value, $i,$themecall,1);
                        break;
                    case 'keywords':
                        $text = $this->getFieldTitleByField($field);
                        $value = wpjobportal::$_data[0]['personal_section']->keywords;
                        $html .= $this->getRowForView($text, $value, $i,$themecall);
                        break;
                    case 'searchable':
                        $text = $this->getFieldTitleByField($field);
                        $value = (wpjobportal::$_data[0]['personal_section']->searchable == 1) ? __('Yes','wp-job-portal') : __('No','wp-job-portal');
                        $html .= $this->getRowForView($text, $value, $i,$themecall);
                        break;
                    case 'resumefiles':
                        if ($i % 2 != 0) { // close the div if one field is print and the function is finished;
                            $html .= '</div>'; // closing div for the more option
                        }
                        $text = $this->getFieldTitleByField($field);
                        $html .= $this->getAttachmentRowForView($text,$themecall);
                        $i = 0;
                        break;
                    default:
                        $array = wpjobportal::$_wpjpcustomfield->showCustomFields($field,11,wpjobportal::$_data[0]['personal_section']->params);
                        if (is_array($array)){
                            $html .= $this->getRowForView($array['title'], $array['value'], $i,$themecall);
                        }
                        break;
                }
            }
            if ($i % 2 != 0) { // close the div if one field is print and the function is finished;
                $html .= '</div>'; // closing div for the more option
            }
            $html .= '</div>'; //section wrapper end;// commented it to solve issue with design.
        }
        return $html;
    }

    function getPersonalTopSection($owner, $resumeformview) {
        $adminLogin = current_user_can('manage_options');
        $html = '<div class="wjportal-resume-top-section">';
        if (isset(wpjobportal::$_data[2][1]['photo'])) {
            $html .= '<div class="wjportal-resume-image">';
            if (wpjobportal::$_data[0]['personal_section']->photo != '') {
                $wpdir = wp_upload_dir();
                $data_directory = wpjobportal::$_config->getConfigurationByConfigName('data_directory');
                $img = $wpdir['baseurl'] . '/' . $data_directory . '/data/jobseeker/resume_' . wpjobportal::$_data[0]['personal_section']->id . '/photo/' . wpjobportal::$_data[0]['personal_section']->photo;
            } else {
                $img = WPJOBPORTAL_PLUGIN_URL . 'includes/images/users.png';
            }
            $html .= '<img src="' . $img . '" />';
            $html .= '</div>';
            $html .= '<div class="wjportal-resume-adv-act-wrp">';
            $layout = WPJOBPORTALrequest::getVar('wpjobportallt');
                if ($layout != 'printresume') {
                    if ($owner != 1) { // Current user is not owner and (Consider as employer)
                        if(!current_user_can('manage_options') && WPJOBPORTALincluder::getObjectClass('user')->isemployer()){
                            $html .= apply_filters('wpjobportal_addons_sendMessage_resume',false) ;
                        }
                    }

                    if (wpjobportal::$_data['resumecontactdetail'] == true || $adminLogin) {
                        $class = '';
                        //PDF + EXCEL HOOK
                            $html  .= apply_filters('wpjobportal_addons_resume_views_action_for_pdf',false,wpjobportal::$_data[0]['personal_section']->id);
                            $html  .= apply_filters('wpjobportal_addons_resume_views_action_export',false,wpjobportal::$_data[0]['personal_section']->id);
                       }
                       //PRINT HOOK
                       $html .= apply_filters('wpjobportal_addons_resume_views_action_for_print',false,wpjobportal::$_data[0]['personal_section']->id);
                    if(!empty(wpjobportal::$_data[0]['file_section']) && (wpjobportal::$_data['resumecontactdetail'] == true || $adminLogin)){
                        //Downloadable File Addons HOOK
                        $html .= apply_filters('wpjobportal_addons_resume_action_ResumeFile',false,wpjobportal::$_data[0]['personal_section']);
                    }
                    $html .= apply_filters('wpjobportal_addons_showresume_contact_detail',false,wpjobportal::$_data[0]['personal_section']->id,wpjobportal::$_data['resumecontactdetail'],$adminLogin);

                } elseif ($layout == 'printresume') {
                    $html .= '<a href="javascript:window.print();" class="grayBtn">' . __('Print', 'wp-job-portal') . '</a>';
                }
            $html .='</div>';
            $html .= '<div class="wjportal-personal-data">';
        } else {
            $html .= '<div class="js-col-lg-12">';
        }
        //getResumeSectionAjax
        if (isset(wpjobportal::$_data[2][1]['first_name']) || isset(wpjobportal::$_data[2][1]['last_name'])) {
            $layout = WPJOBPORTALrequest::getVar('layout');
            $editsocialclass = '';
            /*if ($resumeformview == 0 && ($layout == 'addresume' || $owner == 1)) {
                $html .= '<a class="personal_section_edit" href="#"><img src="' . WPJOBPORTAL_PLUGIN_URL . 'includes/images/edit-resume.png" /></a>';
                $editsocialclass = 'editform';
            }elseif($adminLogin || (!is_user_logged_in() && isset($_SESSION['wp-wpjobportal']))) {
                $html .= '<a class="personal_section_edit" href="#"><img src="' . WPJOBPORTAL_PLUGIN_URL . 'includes/images/edit-resume.png" /></a>';
                $editsocialclass = 'editform';
            }*/
            $html .= '<div id="job-info-sociallink" class="' . $editsocialclass . '">';
            if (!empty(wpjobportal::$_data[0]['personal_section']->facebook)) {
                if(wpjobportalphplib::wpJP_strstr(wpjobportal::$_data[0]['personal_section']->facebook, 'http') ){
                    $facebook = wpjobportal::$_data[0]['personal_section']->facebook ;
                }else{
                    $facebook = 'http://'.wpjobportal::$_data[0]['personal_section']->facebook;
                }
                $html .= '<a href="' . $facebook . '" target="_blank"><img src="' . WPJOBPORTAL_PLUGIN_URL . 'includes/images/scround/fb.png"/></a>';
            }
            if (!empty(wpjobportal::$_data[0]['personal_section']->twitter)) {
                if(wpjobportalphplib::wpJP_strstr(wpjobportal::$_data[0]['personal_section']->twitter, 'http') ){
                    $twitter = wpjobportal::$_data[0]['personal_section']->twitter;
                }else{
                    $twitter = 'http://'.wpjobportal::$_data[0]['personal_section']->twitter;
                }
                $html .= '<a href="' . $twitter . '" target="_blank"><img src="' . WPJOBPORTAL_PLUGIN_URL . 'includes/images/scround/twitter.png"/></a>';
            }
            if (!empty(wpjobportal::$_data[0]['personal_section']->googleplus)) {
                if(wpjobportalphplib::wpJP_strstr(wpjobportal::$_data[0]['personal_section']->googleplus, 'http') ){
                    $googleplus = wpjobportal::$_data[0]['personal_section']->googleplus;
                }else{
                    $googleplus = 'http://'.wpjobportal::$_data[0]['personal_section']->googleplus;
                }
                $html .= '<a href="' . $googleplus . '" target="_blank"><img src="' . WPJOBPORTAL_PLUGIN_URL . 'includes/images/scround/gmail.png"/></a>';
            }
            if (!empty(wpjobportal::$_data[0]['personal_section']->linkedin)) {
                if(wpjobportalphplib::wpJP_strstr(wpjobportal::$_data[0]['personal_section']->linkedin, 'http') ){
                    $linkedin = wpjobportal::$_data[0]['personal_section']->linkedin;
                }else{
                    $linkedin = 'http://'.wpjobportal::$_data[0]['personal_section']->linkedin;
                }
                $html .= '<a href="' . $linkedin . '" target="_blank"><img src="' . WPJOBPORTAL_PLUGIN_URL . 'includes/images/scround/in.png"/></a>';
            }
            $html .= '</div>';

            $html .= '</span>';
        }
        if (isset(wpjobportal::$_data[2][1]['application_title'])) {
            $html .= '<div class="wjportal-resume-title">' . wpjobportal::$_data[0]['personal_section']->application_title . '</div>';
        }
        if (wpjobportal::$_data['resumecontactdetail'] == true || $adminLogin) {
            if (isset(wpjobportal::$_data[2][1]['jobtype'])) {
                    if(isset(wpjobportal::$_data[0]) && !empty(wpjobportal::$_data[0]['personal_section']->jobtypetitle)){
                        $html .= '<div class="wjportal-resume-info"> <span class="wjportal-jobtype" style="background-color: '.wpjobportal::$_data[0]['personal_section']->jobtypecolor.';">'  . wpjobportal::$_data[0]['personal_section']->jobtypetitle . '</span></div>';
                    }
            }
            if (isset(wpjobportal::$_data[2][1]['email_address'])) {
                $html .= '<div class="wjportal-resume-info"><img src="' . WPJOBPORTAL_PLUGIN_URL . 'includes/images/email.png" alt="'.__('email','wp-job-portal').'" title="'.__('email','wp-job-portal').'" />' . wpjobportal::$_data[0]['personal_section']->email_address . '</div>';
            }

            if (isset(wpjobportal::$_data[2][1]['salaryfixed'])) {
                if(isset(wpjobportal::$_data[0]) && !empty(wpjobportal::$_data[0]['personal_section']->salaryfixed)){
                    $html .= '<div class="wjportal-resume-info"><img src="' . WPJOBPORTAL_PLUGIN_URL . 'includes/images/salary.png" alt="'.__('salary','wp-job-portal').'" title="'.__('salary','wp-job-portal').'"/>'  . wpjobportal::$_data[0]['personal_section']->salaryfixed . '</div>';
                }
            }
            if (isset(wpjobportal::$_data[2][1]['cell'])) {
                    if(isset(wpjobportal::$_data[0]) && !empty(wpjobportal::$_data[0]['personal_section']->cell)){
                        $html .= '<div class="wjportal-resume-info"><img src="' . WPJOBPORTAL_PLUGIN_URL . 'includes/images/number.png" alt="'.__('number','wp-job-portal').'"title="'.__('number','wp-job-portal').'" />'  . wpjobportal::$_data[0]['personal_section']->cell . '</div>';
                    }
            }

            if (isset(wpjobportal::$_data[2][2]['address'])) {
                if(isset(wpjobportal::$_data[0]) && !empty(wpjobportal::$_data[0]['personal_section']->address)){
                    $address = isset(wpjobportal::$_data[0]['address_section'][0]) ?  wpjobportal::$_data[0]['address_section'][0]->address : '';
                    $country = isset(wpjobportal::$_data[0]['address_section'][0]) ? wpjobportal::$_data[0]['address_section'][0]->countryname : '';
                    $html .= '<div class="wjportal-resume-info"><img src="' . WPJOBPORTAL_PLUGIN_URL . 'includes/images/location.png" alt="'.__('location','wp-job-portal').'" title="'.__('location','wp-job-portal').'"/>' . $address.','.$country . '</div>';
                }
            }

        }
        $html .= '</div>'; // close for the inner section
        $html .= '</div>'; // closing div of resume-top-section
        return $html;
    }

    function getFieldTitleByField($field){

        return __(wpjobportal::$_data['fieldtitles'][$field],'wp-job-portal');
    }

    function getRowForView($text, $value, &$i,$themecall=null,$full=0) {
        $html = '';
        if(null != $themecall){
            if(1!=$full){
                if ($i == 0 || $i % 2 == 0) {
                    $html .= '<div class="wjportal-resume-sec-row '.$this->class_prefix.'-resumedetail-sec-value">';
                }
            }
        }else{
            if ($i == 0 || $i % 2 == 0) {
                $html .= '<div class="wjportal-resume-sec-row '.$this->class_prefix.'-resumedetail-sec-value">';
            }
        }
        if(null != $themecall){
            if(0==$full){
                $html .= '<div class="'.$this->class_prefix.'-resumedetail-sec-value-left '.$this->class_prefix.'-bigfont">
                            <span class="'.$this->class_prefix.'-resumedetail-title">' . $text . ':</span>
                            <span class="'.$this->class_prefix.'-resumedetail-value">' . __($value,'wp-job-portal') . '</span>
                        </div>';
            }else if(1==$full){
                $html .='<div class="'.$this->class_prefix.'-resumedetail-sec-value '.$this->class_prefix.'-bigfont">
                            <span class="'.$this->class_prefix.'-resumedetail-sec-title">' . $text . ':</span>
                            <span class="'.$this->class_prefix.'-resumedetail-sec-value">' . __($value,'wp-job-portal') . '</span>
                        </div>';
            }
        }else{
            $html .= '<div class="wjportal-custom-field wjportal-resume-sec-data">
                        <div class="wjportal-custom-field-tit wjportal-resume-sec-data-title">' . $text . ':</div>
                        <div class="wjportal-custom-field-val wjportal-resume-sec-data-value">' . __($value,'wp-job-portal') . '</div>
                    </div>';
        }
        $i++;
        if(null != $themecall){
            if(1!=$full){
                if ($i % 2 == 0) {
                    $html .= '</div>';
                }
            }
        }else{
            if ($i % 2 == 0) {
                $html .= '</div>';
            }
        }
        return $html;
    }

    function getRowForForm($text, $value) {
        $html = '<div class="wpjp-resume-date-wrp form">
                    <div class="row-title">' . $text . ':</div>
                    <div class="row-value">' . $value . '</div>
                </div>';
        return $html;
    }
    function getHeadingRowForView($value,$themecall=null) {
        if(null != $themecall){
            $html='<div class="'.$this->class_prefix.'-resumedetail-sec-title1">
                <h6 class="'.$this->class_prefix.'-resumedetail-sec-title1-txt">'.$value.'</h6>
            </div>';
        }else{
            $html = '<div class="wjportal-resume-inner-sec-heading">' . $value . '</div>';
        }
        return $html;
    }
    function makeanchorfortags($tags,$themecall=null) {
        if (empty($tags)) {
            if(null != $themecall) return;
            $anchor = '<div id="jsresume-tags-wrapper"></div>';
            return $anchor;
        }
        $array = wpjobportalphplib::wpJP_explode(',', $tags);
        $anchor="";
        if(null != $themecall){
            for ($i = 0; $i < count($array); $i++) {
                $with_spaces = wpjobportal::tagfillin($array[$i]);
                $anchor .= '<a title="tags" class="'.$this->class_prefix.'-tag" href="' . wpjobportal::makeUrl(array('wpjobportalme'=>'resume', 'wpjobportallt'=>'resumes', 'tags'=>$with_spaces)) . '"><i class="fas fa-tags tag" aria-hidden="true"></i>' . __($array[$i], 'wp-job-portal') . '</a>';
            }
        }else{
            $anchor .= '<div id="jsresume-tags-wrapper">';
            $anchor .= '<span class="jsresume-tags-title">' . __('Tags', 'wp-job-portal') . '</span>';
            $anchor .= '<div class="tags-wrapper-border">';
            for ($i = 0; $i < count($array); $i++) {
                $with_spaces = wpjobportal::tagfillin($array[$i]);
                $anchor .= '<a class="wpjobportal_tags_a" href="' . wpjobportal::makeUrl(array('wpjobportalme'=>'resume', 'wpjobportallt'=>'resumes', 'tags'=>$with_spaces)) . '">' . __($array[$i], 'wp-job-portal') . '</a>';
            }
            $anchor .= '</div>';
            $anchor .= '</div>';
        }
        return $anchor;
    }

}

?>
