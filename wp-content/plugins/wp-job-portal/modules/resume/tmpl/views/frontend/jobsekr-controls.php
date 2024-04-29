<?php
/**
 * @param job      job object - optional
*/
?>
	<div class="data-big-lower">
        <span class="big-lower-left">
            <img class="big-lower-img" src="<?php echo WPJOBPORTAL_PLUGIN_URL; ?>includes/images/location.png"><?php echo esc_html($myresume->location); ?>
        </span>
        <?php if ($myresume->status == 1) {
            $config_array_res = wpjobportal::$_data['config'];
         ?>
        <div class="big-lower-data-icons">
            <a href="<?php echo esc_url(wpjobportal::makeUrl(array('wpjobportalme'=>'resume', 'wpjobportallt'=>'addresume', 'wpjobportalid'=>$myresume->id, 'wpjobportalpageid'=>wpjobportal::getPageid()))); ?>"><img class="icon-img" src="<?php echo WPJOBPORTAL_PLUGIN_URL; ?>includes/images/fe-edit.png" alt="<?php echo __('Edit', 'wp-job-portal'); ?>" title="<?php echo __('Edit', 'wp-job-portal'); ?>"/></a>
            <a href="<?php echo esc_url(wpjobportal::makeUrl(array('wpjobportalme'=>'resume', 'wpjobportallt'=>'viewresume', 'wpjobportalid'=>$myresume->id, 'wpjobportalpageid'=>wpjobportal::getPageid()))); ?>"><img class="icon-img" src="<?php echo WPJOBPORTAL_PLUGIN_URL; ?>includes/images/fe-view.png" alt="<?php echo __('View', 'wp-job-portal'); ?>" title="<?php echo __('View', 'wp-job-portal'); ?>"/></a>
            <a href="<?php echo esc_url(wp_nonce_url(wpjobportal::makeUrl(array('wpjobportalme'=>'resume', 'task'=>'removeresume', 'action'=>'wpjobportaltask', 'wpjobportal-cb[]'=>$myresume->id, 'wpjobportalpageid'=>wpjobportal::getPageid())),'delete-resume')); ?>"onclick="return confirmdelete('<?php echo __('Are you sure to delete','wp-job-portal').' ?'; ?>');"><img class="icon-img" src="<?php echo WPJOBPORTAL_PLUGIN_URL; ?>includes/images/fe-force-delete.png" alt="<?php echo __('Delete', 'wp-job-portal'); ?>" title="<?php echo __('Delete', 'wp-job-portal'); ?>"/></a>
        </div>
		<?php } elseif ($myresume->status == 0) { ?>
		            <div class="big-lower-data-text"><img id="pending-img"  src="<?php echo WPJOBPORTAL_PLUGIN_URL; ?>includes/images/pending-corner.png"/><?php echo __('Waiting for approval', 'wp-job-portal'); ?></div>
		<?php }elseif ($myresume->status == -1){ ?>
		            <div class="big-lower-data-text rjctd"><img id="pending-img"  src="<?php echo WPJOBPORTAL_PLUGIN_URL; ?>includes/images/reject-cornor.png"/><?php echo __('Rejected', 'wp-job-portal'); ?></div>
		<?php
		} ?>
    </div>