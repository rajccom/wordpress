<?php
/**
 * @param wp job portal     job object - optional---
 * WP job portal Object's for calling Resume
 * Resume Section wise over Classes
*/
?>
<?php
    $html = '<div class="wjportal-resume-detail-wrapper">';
    $isowner = (WPJOBPORTALincluder::getObjectClass('user')->uid() == wpjobportal::$_data[0]['personal_section']->uid) ? 1 : 0;
    $html .= $resumeviewlayout->getPersonalTopSection($isowner, 1);
    $html .= '<div class="wjportal-resume-section-title">'. __('Personal information', 'wp-job-portal') . '</div>';
    $html .= $resumeviewlayout->getPersonalSection(0, 1);
    $show_section_that_have_value = wpjobportal::$_config->getConfigValue('show_only_section_that_have_value');
    $showflag = 1;
    if ($show_section_that_have_value == 1 && empty(wpjobportal::$_data[0]['institute_section'][0])){
        $showflag = 0;
    }
    if (isset(wpjobportal::$_data[2][3]['section_education']) && $showflag == 1) {
        // Handling Advance Resume Builder's Addons 
        $html .= apply_filters('wpjobportal_addons_view_resume_by_section',false,'getEducationSection','Education');
    }
    $showflag = 1;
    if ($show_section_that_have_value == 1 && empty(wpjobportal::$_data[0]['employer_section'][0])){
        $showflag = 0;
    }
    if (isset(wpjobportal::$_data[2][4]['section_employer']) && $showflag == 1) {
        // Employer Section Resume
        $html .= $resumeviewlayout->getEmployerSection(0, 0, 1);
    }

    $showflag = 1;
    if ($show_section_that_have_value == 1 && empty(wpjobportal::$_data[0]['address_section'][0])){
        $showflag = 0;
    }
    if (isset(wpjobportal::$_data[2][2]['section_address']) && $showflag == 1) {
        // Address Section Resume
        $html .= $resumeviewlayout->getAddressesSection(0, 0, 1);
    }

    $showflag = 1;
    if ($show_section_that_have_value == 1 && empty(wpjobportal::$_data[0]['personal_section']->skills)){
        $showflag = 0;
    }
    if (isset(wpjobportal::$_data[2][5]['section_skills']) && $showflag == 1) {
        // Handling Advance Resume Builder's Addons 
        $html .= apply_filters('wpjobportal_addons_view_resume_by_section',false,'getSkillSection','Skills');
    }

    $showflag = 1;
    if ($show_section_that_have_value == 1 && empty(wpjobportal::$_data[0]['language_section'][0])){
        $showflag = 0;
    }
    if (isset(wpjobportal::$_data[2][8]['section_language']) && $showflag == 1) {
        $html .= apply_filters('wpjobportal_addons_view_resume_by_section',false,'getLanguageSection','Languages');
    }
    // getting Data over resume class and Show
    echo $html;

    //new change
    if (isset(wpjobportal::$_data[0]) && isset(wpjobportal::$_data[0]['personal_section'])) {
        $viewtags = wpjobportal::$_data[0]['personal_section']->viewtags;
    } else {
        $viewtags = '';
    }
    $viewtags = apply_filters('wpjobportal_addons_makeanchor_for_tags',false,$viewtags);
    echo $viewtags;
?>
