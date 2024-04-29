<?php
/**
* @param WP JOb Portal
* @param Conrtol Section 
*/
$class = 'wpjobportal-resume-act-btn';
?>
 <div id="item-actions" class="wpjobportal-resume-action-wrp">
 	<a id="view-resume" class="wpjobportal-resume-act-btn" href="<?php echo esc_url(admin_url('admin.php?page=wpjobportal_resume&wpjobportallt=formresume&wpjobportalid='.$data->appid)); ?>" title="<?php echo __('view profile', 'wp-job-portal'); ?>">
        <?php echo __('View Profile', 'wp-job-portal'); ?>
	</a>
	<?php 
	    do_action('wpjobportal_addons_resume_bottom_action_appliedresume',$data,$class);
	    do_action('wpjobportal_addons_resume_bottom_action_appliedresume_exc',wpjobportal::$_data['jobid'],$data);
    ?>
</div>