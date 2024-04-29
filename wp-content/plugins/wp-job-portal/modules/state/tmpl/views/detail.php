<?php
/**
*
*/
?>
<tr>
    <td>
        <input type="checkbox" class="wpjobportal-cb" id="wpjobportal-cb" name="wpjobportal-cb[]" value="<?php echo esc_attr($row->id); ?>" />
    </td>
    <td>
        <a href="<?php echo esc_url($link); ?>" title="<?php echo __('name','wp-job-portal'); ?>">
            <?php echo esc_html(__($row->name,'wp-job-portal')); ?>
        </a>
    </td>
    <td>
        <?php if ($row->enabled == '1') { ?>
	        <a href="<?php echo admin_url('admin.php?page=wpjobportal_state&task=unpublish&action=wpjobportaltask&wpjobportal-cb[]='.$row->id.$pageid); ?>" title="<?php echo __('published', 'wp-job-portal'); ?>">
	            <img src="<?php echo WPJOBPORTAL_PLUGIN_URL; ?>includes/images/control_panel/dashboard/good.png" border="0" alt="<?php echo __('published', 'wp-job-portal'); ?>" />
	        </a>
       <?php } else { ?>
	        <a href="<?php echo admin_url('admin.php?page=wpjobportal_state&task=publish&action=wpjobportaltask&wpjobportal-cb[]='.$row->id.$pageid); ?>" title="<?php echo __('not published', 'wp-job-portal'); ?>">
	            <img src="<?php echo WPJOBPORTAL_PLUGIN_URL; ?>includes/images/control_panel/dashboard/close.png" border="0" alt="<?php echo __('not published', 'wp-job-portal'); ?>" />
	        </a>
		<?php } ?>
    </td>
    <td>
        <a href="<?php echo admin_url('admin.php?page=wpjobportal_city&stateid='.$row->id.'&countryid='.$row->countryid); ?>" title="<?php echo __('cities', 'wp-job-portal'); ?>">
            <?php echo __('Cities', 'wp-job-portal'); ?>
        </a>
    </td>
    <td>
        <a class="wpjobportal-table-act-btn" href="<?php echo esc_url($link); ?>" title="<?php echo __('edit', 'wp-job-portal'); ?>">
            <img src="<?php echo WPJOBPORTAL_PLUGIN_URL; ?>includes/images/control_panel/dashboard/edit.png" alt="<?php echo __('edit', 'wp-job-portal'); ?>">
        </a>
        <a class="wpjobportal-table-act-btn" href="<?php echo wp_nonce_url(admin_url('admin.php?page=wpjobportal_state&task=remove&action=wpjobportaltask&wpjobportal-cb[]='.$row->id),'delete-state'); ?>" onclick='return confirmdelete("<?php echo __('Are you sure to delete', 'wp-job-portal').' ?'; ?>");' title="<?php echo __('delete', 'wp-job-portal'); ?>">
            <img src="<?php echo WPJOBPORTAL_PLUGIN_URL; ?>includes/images/control_panel/dashboard/delete.png" alt="<?php echo __('delete', 'wp-job-portal'); ?>">
        </a>
    </td>
</tr>
