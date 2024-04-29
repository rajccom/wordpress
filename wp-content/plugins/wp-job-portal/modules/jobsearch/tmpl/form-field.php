<?php
/**
* @param wp-job-portal
* Template Form-Field
*/
?>
<?php
///To Store Array and Return whole Form
$formfields = array();
foreach ($fields AS $field) {
    switch ($field->field) {
        case 'metakeywords':
            $content = WPJOBPORTALformfield::text('metakeywords', isset(wpjobportal::$_data[0]['filter']->metakeywords) ? wpjobportal::$_data[0]['filter']->metakeywords : '', array('class' => 'inputbox wjportal-form-input-field','placeholder' => __($field->placeholder,'wp-job-portal')));

            break;
        case 'jobtitle':
            $content = WPJOBPORTALformfield::text('jobtitle', isset(wpjobportal::$_data[0]['filter']->jobtitle) ? wpjobportal::$_data[0]['filter']->jobtitle : '', array('class' => 'inputbox wjportal-form-input-field',$field->placeholder));
            break;
        case 'company':
            $content = WPJOBPORTALformfield::select('company[]', WPJOBPORTALincluder::getJSModel('company')->getCompaniesForCombo(), isset(wpjobportal::$_data[0]['filter']->company) ? wpjobportal::$_data[0]['filter']->company : '', __('Select','wp-job-portal') .' '. __('Company', 'wp-job-portal'), array('class' => 'inputbox wpjobportal-multiselect wjportal-form-select-field', 'multiple' => 'true'));

            break;
        case 'jobcategory':
            $content = WPJOBPORTALformfield::select('category[]', WPJOBPORTALincluder::getJSModel('category')->getCategoriesForCombo(), isset(wpjobportal::$_data[0]['filter']->category) ? wpjobportal::$_data[0]['filter']->category : '', __('Select','wp-job-portal') .' '. __('Category', 'wp-job-portal'), array('class' => 'inputbox wpjobportal-multiselect wjportal-form-select-field', 'multiple' => 'true'));

            break;
        case 'careerlevel':
            $content = WPJOBPORTALformfield::select('careerlevel[]', WPJOBPORTALincluder::getJSModel('careerlevel')->getCareerLevelsForCombo(), isset(wpjobportal::$_data[0]['filter']->careerlevel) ? wpjobportal::$_data[0]['filter']->careerlevel : '', __('Select','wp-job-portal') .' '. __('Career Level', 'wp-job-portal'), array('class' => 'inputbox wpjobportal-multiselect wjportal-form-select-field', 'multiple' => 'true'));

            break;
        case 'gender':
            $content = WPJOBPORTALformfield::select('gender', WPJOBPORTALincluder::getJSModel('common')->getGender(), isset(wpjobportal::$_data[0]['filter']->gender) ? wpjobportal::$_data[0]['filter']->gender : '', __('Select','wp-job-portal') .' '. __('Gender', 'wp-job-portal'), array('class' => 'inputbox wjportal-form-select-field'));

            break;
        case 'jobtype':
            $content = WPJOBPORTALformfield::select('jobtype[]', WPJOBPORTALincluder::getJSModel('jobtype')->getJobTypeForCombo(), isset(wpjobportal::$_data[0]['filter']->jobtype) ? wpjobportal::$_data[0]['filter']->jobtype : '', __('Select','wp-job-portal') .' '. __('Job Type', 'wp-job-portal'), array('class' => 'inputbox wpjobportal-multiselect wjportal-form-select-field', 'multiple' => 'true'));

            break;
        case 'jobstatus':
            $content = WPJOBPORTALformfield::select('jobstatus[]', WPJOBPORTALincluder::getJSModel('jobstatus')->getJobStatusForCombo(), isset(wpjobportal::$_data[0]['filter']->jobstatus) ? wpjobportal::$_data[0]['filter']->jobstatus : '', __('Select','wp-job-portal') .' '. __('Job Status', 'wp-job-portal'), array('class' => 'inputbox wpjobportal-multiselect wjportal-form-select-field', 'multiple' => 'true'));

            break;

        case 'city':
            $content = WPJOBPORTALformfield::text('city', isset(wpjobportal::$_data[0]['filter']->city) ? wpjobportal::$_data[0]['filter']->city : '', array('class' => 'inputbox wjportal-form-input-field'));

            break;
        case 'duration':
            $content = WPJOBPORTALformfield::text('duration', isset(wpjobportal::$_data[0]['filter']->duration) ? wpjobportal::$_data[0]['filter']->duration : '', array('class' => 'inputbox wjportal-form-input-field','placeholder' => __($field->placeholder,'wp-job-portal')));

            break;

        case 'tags':
            $content = '';
            if(in_array('tag', wpjobportal::$_active_addons)){
                $content = WPJOBPORTALformfield::text('tags', '', array('class' => 'inputbox wjportal-form-input-field','placeholder' => __('Tags','wp-job-portal')));
            }
            break;
        case 'jobsalaryrange':
            $content = WPJOBPORTALincluder::getTemplateHtml('jobsearch/salary-field', array('class' => 'inputbox wjportal-form-select-field','field' => $field));
        break;
        case 'heighesteducation':
            $content = WPJOBPORTALformfield::select('educationid[]', WPJOBPORTALincluder::getJSModel('highesteducation')->getHighestEducationForCombo(), isset(wpjobportal::$_data[0]['filter']->educationid) ? wpjobportal::$_data[0]['filter']->educationid : '', __('Select','wp-job-portal') .' '. __('Education', 'wp-job-portal'), array('class' => 'inputbox wpjobportal-multiselect wjportal-form-select-field', 'multiple' => 'true'));
        break;
        default:
            $i = 0;
            $content = wpjobportal::$_wpjpcustomfield->formCustomFieldsForSearch($field, $i, 'f_jobsearch');
            break;
    }

    if (!empty($content)) {
        $formfields[] = array(
            'field' => $field,
            'content' => $content,
            'require' => "no"
        );
    }
}
return $formfields;

?>
