<?php
/**
* @param field    salary field object
* @param job      job object - optional
*/
$salarytypelist = array(
    (object) array('id'=>WPJOBPORTAL_SALARY_NEGOTIABLE,'text'=>__("Negotiable",'wp-job-portal')),
    (object) array('id'=>WPJOBPORTAL_SALARY_FIXED,'text'=>__("Fixed",'wp-job-portal')),
    (object) array('id'=>WPJOBPORTAL_SALARY_RANGE,'text'=>__("Range",'wp-job-portal')),
);
?>
<div class="wjportal-form-5-fields">
    <div class="wjportal-form-inner-fields">
        <?php echo wp_kses(WPJOBPORTALformfield::select('salarytype', $salarytypelist, $job ? $job->salarytype : 2, __("Select",'wp-job-portal').' '.__("Salary Type",'wp-job-portal'), array('class' => 'inputbox sal wjportal-form-select-field', 'data-validation' => $field->validation)),WPJOBPORTAL_ALLOWED_TAGS); ?>
    </div>
    <div class="wjportal-form-inner-fields wjportal-form-symbol-fields">
        <span class="wjportal-form-symbol"><?php echo isset($job->currency) ? $job->currency : esc_html(wpjobportal::$_config->getConfigValue('job_currency')); ?></span>
    </div>
    <div class="wjportal-form-inner-fields">
        <?php echo wp_kses(WPJOBPORTALformfield::text('salaryfixed', $job ? $job->salarymin : '', array('class' => 'inputbox sal wjportal-form-input-field','placeholder'=> __('e.g 45000','wp-job-portal'),'data-validation' => $field->validation)),WPJOBPORTAL_ALLOWED_TAGS); ?>
    </div>
    <div class="wjportal-form-inner-fields">
        <?php echo wp_kses(WPJOBPORTALformfield::text('salarymin', $job ? $job->salarymin : '', array('class' => 'inputbox sal wjportal-form-input-field','placeholder'=> __('e.g 3000','wp-job-portal'),'data-validation' => $field->validation)),WPJOBPORTAL_ALLOWED_TAGS); ?>
    </div>
    <div class="wjportal-form-inner-fields">
        <?php echo wp_kses(WPJOBPORTALformfield::text('salarymax', $job ? $job->salarymax : '', array('class' => 'inputbox sal wjportal-form-input-field','placeholder'=> __('e.g 6000','wp-job-portal'),'data-validation' => $field->validation)),WPJOBPORTAL_ALLOWED_TAGS); ?>
    </div>
    <div class="wjportal-form-inner-fields">
        <?php echo wp_kses(WPJOBPORTALformfield::select('salaryduration', WPJOBPORTALincluder::getJSModel('salaryrangetype')->getSalaryRangeTypesForCombo(), $job ? $job->salaryduration : WPJOBPORTALincluder::getJSModel('salaryrangetype')->getDefaultSalaryRangeTypeId(), __('Select','wp-job-portal'), array('class' => 'inputbox sal wjportal-form-select-field', 'data-validation' => $field->validation)),WPJOBPORTAL_ALLOWED_TAGS); ?>
    </div>
</div>

<script type="text/javascript">

jQuery(document).delegate("#salarytype", "change", function(){
    var salarytype = jQuery(this).val();
    if(salarytype == 1){ //negotiable
        jQuery("#salaryfixed").hide();
        jQuery("#salarymin").hide();
        jQuery("#salarymax").hide();
        jQuery("#salaryduration").hide();
        jQuery(".wjportal-form-symbol").hide();
    }else if(salarytype == 2){ //fixed
        jQuery("#salaryfixed").show();
        jQuery("#salarymin").hide();
        jQuery("#salarymax").hide();
        jQuery("#salaryduration").show();
        jQuery(".wjportal-form-symbol").show();
    }else if(salarytype == 3){ //range
        jQuery("#salaryfixed").hide();
        jQuery("#salarymin").show();
        jQuery("#salarymax").show();
        jQuery("#salaryduration").show();
        jQuery(".wjportal-form-symbol").show();
    }else{ //not selected
        jQuery("#salaryfixed").hide();
        jQuery("#salarymin").hide();
        jQuery("#salarymax").hide();
        jQuery("#salaryduration").hide();
        jQuery(".wjportal-form-symbol").hide();
    }
});

jQuery("#salarytype").change();

</script>
