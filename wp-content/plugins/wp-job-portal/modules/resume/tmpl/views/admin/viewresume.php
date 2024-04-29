<?php
/**
 * @param job      job object - optional
*/
?>
<?php
 if (isset(wpjobportal::$_data['socialprofile']) && wpjobportal::$_data['socialprofile'] == true && in_array('sociallogin', wpjobportal::$_active_addons)) { // social profile
            $profileid = wpjobportal::$_data['socialprofileid'];
            WPJOBPORTALincluder::getObjectClass('SocialLogin')->showprofilebyprofileid($profileid);
        } else {
            $html = '<div id="resume-wrapper" class="wjportal-resume-detail-wrapper">';
            $isowner = (WPJOBPORTALincluder::getObjectClass('user')->uid() == wpjobportal::$_data[0]['personal_section']->uid) ? 1 : 0;
            $html .= $resumeviewlayout->getPersonalTopSection($isowner, 1);
            $html .= '<div class="resume-section-title wjportal-resume-section-title">
                        ' . __('Personal Information', 'wp-job-portal') . '
                    </div>';
            $html .= $resumeviewlayout->getPersonalSection(0, 1);
            $show_section_that_have_value = wpjobportal::$_config->getConfigValue('show_only_section_that_have_value');
            $showflag = 1;
            if ($show_section_that_have_value == 1 && empty(wpjobportal::$_data[0]['address_section'][0])){
                $showflag = 0;
            }
            if (isset(wpjobportal::$_data[2][2]['section_address']) && $showflag == 1) {
                $html .= $resumeviewlayout->getAddressesSection(0, 0, 1);
            }
            $showflag = 1;
            if ($show_section_that_have_value == 1 && empty(wpjobportal::$_data[0]['institute_section'][0])){
                $showflag = 0;
            }
            if (isset(wpjobportal::$_data[2][3]['section_education']) && $showflag == 1) {
                $html .= apply_filters('wpjobportal_addons_view_resume_by_section',false,'getEducationSection','Education');
            }
            $showflag = 1;
            if ($show_section_that_have_value == 1 && empty(wpjobportal::$_data[0]['employer_section'][0])){
                $showflag = 0;
            }
            if (isset(wpjobportal::$_data[2][4]['section_employer']) && $showflag == 1) {
                $html .= $resumeviewlayout->getEmployerSection(0, 0, 1);
            }
            $showflag = 1;
            if ($show_section_that_have_value == 1 && empty(wpjobportal::$_data[0]['personal_section']->skills)){
                $showflag = 0;
            }
            if (isset(wpjobportal::$_data[2][5]['section_skills']) && $showflag == 1) {
                $html .= apply_filters('wpjobportal_addons_view_resume_by_section',false,'getSkillSection','Skills');
            }
            $showflag = 1;
            if ($show_section_that_have_value == 1 && empty(wpjobportal::$_data[0]['language_section'][0])){
                $showflag = 0;
            }
            if (isset(wpjobportal::$_data[2][8]['section_language']) && $showflag == 1) {
                $html .= apply_filters('wpjobportal_addons_view_resume_by_section',false,'getLanguageSection','Languages');
            }
            $html .= '</div>';
            echo $html;
        }