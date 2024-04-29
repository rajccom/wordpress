<?php
/**
* @param js-job Form Filter  
*/
?>
<?php echo wp_kses(WPJOBPORTALformfield::text('searchname', wpjobportal::$_data['filter']['searchname'], array('class' => 'inputbox wpjobportal-form-input-field', 'placeholder' => __('Name', 'wp-job-portal'))),WPJOBPORTAL_ALLOWED_TAGS); ?>
<?php echo wp_kses(WPJOBPORTALformfield::text('searchusername', wpjobportal::$_data['filter']['searchusername'], array('class' => 'inputbox wpjobportal-form-input-field', 'placeholder' => __('Word Press user login', 'wp-job-portal'))),WPJOBPORTAL_ALLOWED_TAGS); ?>
<?php echo wp_kses(WPJOBPORTALformfield::text('searchcompany', wpjobportal::$_data['filter']['searchcompany'], array('class' => 'inputbox wpjobportal-form-input-field default-hidden', 'placeholder' => __('Company', 'wp-job-portal'))),WPJOBPORTAL_ALLOWED_TAGS); ?>
<?php echo wp_kses(WPJOBPORTALformfield::text('searchresume', wpjobportal::$_data['filter']['searchresume'], array('class' => 'inputbox wpjobportal-form-input-field default-hidden', 'placeholder' => __('Resume', 'wp-job-portal'))),WPJOBPORTAL_ALLOWED_TAGS); ?>
<?php echo wp_kses(WPJOBPORTALformfield::select('searchrole', WPJOBPORTALincluder::getJSModel('common')->getRolesForCombo(), wpjobportal::$_data['filter']['searchrole'], __('Select Role', 'wp-job-portal'), array('class' => 'inputbox wpjobportal-form-select-field')),WPJOBPORTAL_ALLOWED_TAGS); ?>
<?php echo wp_kses(WPJOBPORTALformfield::hidden('WPJOBPORTAL_form_search', 'WPJOBPORTAL_SEARCH'),WPJOBPORTAL_ALLOWED_TAGS); ?>
<?php echo wp_kses(WPJOBPORTALformfield::submitbutton('btnsubmit', __('Search', 'wp-job-portal'), array('class' => 'button wpjobportal-form-search-btn')),WPJOBPORTAL_ALLOWED_TAGS); ?>
<?php echo wp_kses(WPJOBPORTALformfield::button('reset', __('Reset', 'wp-job-portal', 'wp-job-portal', 'wp-job-portal'), array('class' => 'button wpjobportal-form-reset-btn', 'onclick' => 'resetFrom();')),WPJOBPORTAL_ALLOWED_TAGS); ?>
<?php /*
<span id="showhidefilter"><img src="<?php echo WPJOBPORTAL_PLUGIN_URL; ?>includes/images/filter-down.png"/></span>
*/ ?>