<?php
/**
 * @param field 		fieldordering field object
 * @param title 		field title or name
 * @param required  	is field required
 * @param content 		field html
 * @param description 	field description
 */
if (isset($field)) {
	if (!isset($title)) {
		$title = $field->fieldtitle;
	}
	if (!isset($required)) {
		$required = $field->required;
	}
	 if (!isset($description)) {
	 	$description = $field->description;
	 }
} else {
    if (!isset($title)) {
        $title = '';
    }
    if (!isset($required)) {
        $required = false;
    }
    if (!isset($description)) {
        $description = '';
    }
}
?>
<div class="wjportal-form-row">
    <div class="wjportal-form-title">

        <?php echo __(esc_html($title), 'wp-job-portal'); ?>
        
        <?php if($required == 1 && WPJOBPORTALrequest::getVar('wpjobportalme') != "jobsearch"): ?>
        	<font>*</font>
    	<?php endif; ?>

    </div>
    <div class="wjportal-form-value">

        <?php echo wp_kses($content, WPJOBPORTAL_ALLOWED_TAGS); ?>

        <?php if(!empty($description)): ?>
        	<div class="wjportal-form-help-txt"><?php echo __(esc_html($description), 'wp-job-portal'); ?></div>
        <?php endif; ?>

    </div>
</div>
