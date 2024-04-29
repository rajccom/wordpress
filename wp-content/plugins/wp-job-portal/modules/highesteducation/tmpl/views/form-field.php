<?php
/**
* @param wp-job-portal Form Field
*/
?>
<div class="wpjobportal-form-wrapper">
    <div class="wpjobportal-form-title">
    	<?php echo __('Title', 'wp-job-portal'); ?>
    	<span style="color: red;" >*</span>
    </div>
    <div class="wpjobportal-form-value">
    	<?php echo wp_kses(WPJOBPORTALformfield::text('title', isset(wpjobportal::$_data[0]->title) ? wpjobportal::$_data[0]->title : '', array('class' => 'inputbox one wpjobportal-form-input-field', 'data-validation' => 'required')),WPJOBPORTAL_ALLOWED_TAGS); ?>
    </div>
</div>
<div class="wpjobportal-form-wrapper">
    <div class="wpjobportal-form-title">
    	<?php echo __('Published', 'wp-job-portal'); ?>
    </div>
    <div class="wpjobportal-form-value">
    	<?php echo wp_kses(WPJOBPORTALformfield::radiobutton('isactive', array('1' => __('Yes', 'wp-job-portal'), '0' => __('No', 'wp-job-portal')), isset(wpjobportal::$_data[0]->isactive) ? wpjobportal::$_data[0]->isactive : 1, array('class' => 'radiobutton')),WPJOBPORTAL_ALLOWED_TAGS); ?>
    </div>
</div>
<div class="wpjobportal-form-wrapper">
    <div class="wpjobportal-form-title">
    	<?php echo __('Default', 'wp-job-portal'); ?>
    </div>
    <div class="wpjobportal-form-value">
    	<?php echo wp_kses(WPJOBPORTALformfield::radiobutton('isdefault', array('1' => __('Yes', 'wp-job-portal'), '0' => __('No', 'wp-job-portal')), isset(wpjobportal::$_data[0]->isdefault) ? wpjobportal::$_data[0]->isdefault : 0, array('class' => 'radiobutton')),WPJOBPORTAL_ALLOWED_TAGS); ?>
    </div>
</div>
<?php echo wp_kses(WPJOBPORTALformfield::hidden('id', isset(wpjobportal::$_data[0]->id) ? wpjobportal::$_data[0]->id : ''),WPJOBPORTAL_ALLOWED_TAGS); ?>
<?php echo wp_kses(WPJOBPORTALformfield::hidden('ordering', isset(wpjobportal::$_data[0]->ordering) ? wpjobportal::$_data[0]->ordering : '' ),WPJOBPORTAL_ALLOWED_TAGS); ?>
<?php echo wp_kses(WPJOBPORTALformfield::hidden('action', 'highesteducation_savehighesteducation'),WPJOBPORTAL_ALLOWED_TAGS); ?>
<?php echo wp_kses(WPJOBPORTALformfield::hidden('wpjobportal_isdefault', isset(wpjobportal::$_data[0]->isdefault) ? wpjobportal::$_data[0]->isdefault : ''),WPJOBPORTAL_ALLOWED_TAGS); ?>
<?php echo wp_kses(WPJOBPORTALformfield::hidden('form_request', 'wpjobportal'),WPJOBPORTAL_ALLOWED_TAGS); ?>
<div class="wpjobportal-form-button">
    <a id="form-cancel-button" class="wpjobportal-form-cancel-btn" href="<?php echo admin_url('admin.php?page=wpjobportal_highesteducation'); ?>" title="<?php echo __('cancel', 'wp-job-portal'); ?>">
    	<?php echo __('Cancel', 'wp-job-portal'); ?>
    </a>
    <?php echo wp_kses(WPJOBPORTALformfield::submitbutton('save', __('Save','wp-job-portal') .' '. __('Highest Education', 'wp-job-portal'), array('class' => 'button wpjobportal-form-save-btn')),WPJOBPORTAL_ALLOWED_TAGS); ?>
</div>
