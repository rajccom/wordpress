<?php
/**
* 
*/
?>
<div class="wpjobportal-form-wrapper">
    <div class="wpjobportal-form-title">
    	<?php echo __('Name', 'wp-job-portal'); ?>
    	<font class="required-notifier">*</font>
    </div>
    <div class="wpjobportal-form-value">
    	<?php echo wp_kses(WPJOBPORTALformfield::text('name', isset(wpjobportal::$_data[0]->name) ? __(wpjobportal::$_data[0]->name,'wp-job-portal') : '', array('class' => 'inputbox one wpjobportal-form-input-field', 'data-validation' => 'required')),WPJOBPORTAL_ALLOWED_TAGS) ?>
    </div>
</div>
<div class="wpjobportal-form-wrapper">
    <div class="wpjobportal-form-title">
    	<?php echo __('Published', 'wp-job-portal'); ?>
    </div>
    <div class="wpjobportal-form-value">
    	<?php echo wp_kses(WPJOBPORTALformfield::radiobutton('enabled', array('1' => __('Yes', 'wp-job-portal'), '0' => __('No', 'wp-job-portal')), isset(wpjobportal::$_data[0]->enabled) ? wpjobportal::$_data[0]->enabled : 1, array('class' => 'radiobutton')),WPJOBPORTAL_ALLOWED_TAGS); ?>
    </div>
</div>
<?php echo wp_kses(WPJOBPORTALformfield::hidden('id', isset(wpjobportal::$_data[0]->id) ? wpjobportal::$_data[0]->id : ''),WPJOBPORTAL_ALLOWED_TAGS); ?>
<?php echo wp_kses(WPJOBPORTALformfield::hidden('action', 'country_savecountry'),WPJOBPORTAL_ALLOWED_TAGS); ?>
<?php echo wp_kses(WPJOBPORTALformfield::hidden('form_request', 'wpjobportal'),WPJOBPORTAL_ALLOWED_TAGS); ?>
<div class="wpjobportal-form-button">
    <a id="form-cancel-button" class="wpjobportal-form-cancel-btn" href="<?php echo admin_url('admin.php?page=wpjobportal_country'); ?>" title="<?php echo __('cancel', 'wp-job-portal'); ?>">
    	<?php echo __('Cancel', 'wp-job-portal'); ?>
	</a>
    <?php echo wp_kses(WPJOBPORTALformfield::submitbutton('save', __('Save','wp-job-portal') .' '. __('Country', 'wp-job-portal'), array('class' => 'button wpjobportal-form-save-btn')),WPJOBPORTAL_ALLOWED_TAGS); ?>
</div>