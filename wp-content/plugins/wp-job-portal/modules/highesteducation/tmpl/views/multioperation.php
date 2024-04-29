<?php
/**
* @param relational Files
*/
?>
<div id="wpjobportal-page-quick-actions">
	<a class="wpjobportal-page-quick-act-btn multioperation" message="<?php echo esc_attr(WPJOBPORTALMessages::getMSelectionEMessage()); ?>" data-for="publish" href="#" title="<?php echo __('publish', 'wp-job-portal') ?>">
		<img src="<?php echo WPJOBPORTAL_PLUGIN_URL; ?>includes/images/control_panel/dashboard/good.png" alt="<?php echo __('publish', 'wp-job-portal') ?>" />
		<?php echo __('Publish', 'wp-job-portal') ?>
	</a>
	<a class="wpjobportal-page-quick-act-btn multioperation" message="<?php echo esc_attr(WPJOBPORTALMessages::getMSelectionEMessage()); ?>" data-for="unpublish" href="#" title="<?php echo __('unpublish', 'wp-job-portal') ?>">
		<img src="<?php echo WPJOBPORTAL_PLUGIN_URL; ?>includes/images/control_panel/dashboard/close.png" alt="<?php echo __('unpublish', 'wp-job-portal') ?>" />
		<?php echo __('Unpublish', 'wp-job-portal') ?>
	</a>
	<a class="wpjobportal-page-quick-act-btn multioperation" message="<?php echo esc_attr(WPJOBPORTALMessages::getMSelectionEMessage()); ?>" confirmmessage="<?php echo __('Are you sure to delete', 'wp-job-portal') .' ?'; ?>" data-for="remove" href="#" title="<?php echo __('delete', 'wp-job-portal') ?>">
		<img src="<?php echo WPJOBPORTAL_PLUGIN_URL; ?>includes/images/control_panel/dashboard/forced-delete.png" alt="<?php echo __('delete', 'wp-job-portal') ?>" />
		<?php echo __('Delete', 'wp-job-portal') ?>
	</a>
</div>