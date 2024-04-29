<?php
/**
* 
*/
$upimg = 'uparrow.png';
$downimg = 'downarrow.png';
?>
 <tr id="id_<?php echo esc_attr($row->id);?>">
    <td>
        <input type="checkbox" class="wpjobportal-cb" id="wpjobportal-cb" name="wpjobportal-cb[]" value="<?php echo esc_attr($row->id); ?>" />
    </td>
    <td class="wpjobportal-order-grab-column">
        <img alt="<?php echo __('grab','wp-job-portal'); ?>" src="<?php echo WPJOBPORTAL_PLUGIN_URL . 'includes/images/list-full.png'?>"/>
     </td>
    <td class="wpjobportal-text-left">
        <a href="<?php echo admin_url('admin.php?page=wpjobportal_salaryrangetype&wpjobportallt=formsalaryrangetype&wpjobportalid='.esc_attr($row->id)); ?>" title="<?php echo __('title','wp-job-portal'); ?>">
            <?php echo __(esc_html($row->title),'wp-job-portal'); ?>
        </a>
    </td>
    <td>
        <?php if ($row->isdefault == 1) { ?> 
            <img src="<?php echo WPJOBPORTAL_PLUGIN_URL; ?>includes/images/default.png" alt="Default" border="0" alt="<?php echo __('default', 'wp-job-portal'); ?>" />
        <?php } else { ?>
            <a href="<?php echo esc_url(admin_url('admin.php?page=wpjobportal_common&task=makedefault&action=wpjobportaltask&for=salaryrangetypes&id='.$row->id.$pageid)); ?>" title="<?php echo __('not default', 'wp-job-portal'); ?>">
                <img src="<?php echo WPJOBPORTAL_PLUGIN_URL; ?>includes/images/notdefault.png" border="0" alt="<?php echo __('not default', 'wp-job-portal'); ?>" />
            </a>
        <?php } ?>  
    </td>   
    <td>
        <?php if ($row->status == 1) { ?>
        <a href="<?php echo esc_url(admin_url('admin.php?page=wpjobportal_salaryrangetype&task=unpublish&action=wpjobportaltask&wpjobportal-cb[]='.$row->id.$pageid)); ?>" title="<?php echo __('published', 'wp-job-portal'); ?>">
            <img src="<?php echo WPJOBPORTAL_PLUGIN_URL; ?>includes/images/control_panel/dashboard/good.png" border="0" alt="<?php echo __('published', 'wp-job-portal'); ?>" />
        </a>
       <?php } else { ?>
        <a href="<?php echo esc_url(admin_url('admin.php?page=wpjobportal_salaryrangetype&task=publish&action=wpjobportaltask&wpjobportal-cb[]='.$row->id.$pageid)); ?>" title="<?php echo __('not published', 'wp-job-portal'); ?>">
            <img src="<?php echo WPJOBPORTAL_PLUGIN_URL; ?>includes/images/control_panel/dashboard/close.png" border="0" alt="<?php echo __('not published', 'wp-job-portal'); ?>" />
        </a>
        <?php } ?>
    </td>
    <td>
        <a class="wpjobportal-table-act-btn" href="<?php echo esc_url(admin_url('admin.php?page=wpjobportal_salaryrangetype&wpjobportallt=formsalaryrangetype&wpjobportalid='.$row->id)); ?>" title="<?php echo __('edit', 'wp-job-portal'); ?>">
            <img src="<?php echo WPJOBPORTAL_PLUGIN_URL; ?>includes/images/control_panel/dashboard/edit.png" alt="<?php echo __('edit', 'wp-job-portal'); ?>">
        </a>
        <a class="wpjobportal-table-act-btn" href="<?php echo esc_url(wp_nonce_url(admin_url('admin.php?page=wpjobportal_salaryrangetype&task=remove&action=wpjobportaltask&wpjobportal-cb[]='.$row->id),'delete-salaryrangetype')); ?>" onclick='return confirmdelete("<?php echo __('Are you sure to delete', 'wp-job-portal') .' ?'; ?>");' title="<?php echo __('delete', 'wp-job-portal'); ?>">
            <img src="<?php echo WPJOBPORTAL_PLUGIN_URL; ?>includes/images/control_panel/dashboard/delete.png" alt="<?php echo __('delete', 'wp-job-portal'); ?>">
        </a>
    </td>
</tr>
