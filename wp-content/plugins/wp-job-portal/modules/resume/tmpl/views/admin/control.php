<?php
/**
 * @param job      job object - optional
 */
?>
<?php

switch ($control) {
    case 'resume':
        $featuredflag = true;
        $dateformat = wpjobportal::$_configuration['date_format'];
        $curdate = date_i18n('Y-m-d');
        $featuredexpiry = date_i18n('Y-m-d', strtotime($resume->endfeatureddate));
        if ($resume->isfeaturedresume == 1 && $featuredexpiry >= $curdate) {
            $featuredflag = false;
        }
        ?>

        <div id="item-actions" class="wpjobportal-resume-action-wrp">
            <?php 
                $config_array = wpjobportal::$_data['config'];
             ?>
            <a class="wpjobportal-resume-act-btn" href="<?php echo esc_url(wp_nonce_url(admin_url('admin.php?page=wpjobportal_resume&task=removeresume&wpjobportal-cb[]='.$resume->id.'&action=wpjobportaltask&callfrom=1'),'delete-resume')) ;?>" onclick='return confirm("<?php echo __('Are you sure to delete','wp-job-portal').' ?'; ?>");' title="<?php echo __('delete', 'wp-job-portal'); ?>">
                <?php echo __('Delete', 'wp-job-portal'); ?>
            </a>
            <a class="wpjobportal-resume-act-btn" href="<?php echo esc_url(wp_nonce_url(admin_url('admin.php?page=wpjobportal_resume&task=resumeEnforceDelete&action=wpjobportaltask&resumeid='.$resume->id.'&callfrom=1'),'delete-resume')) ;?>" onclick='return confirmdelete("<?php echo __('Are you sure to force delete', 'wp-job-portal').' ?'; ?>");' title="<?php echo __('enforce delete', 'wp-job-portal') ?>">
                <?php echo __('Enforce Delete', 'wp-job-portal') ?>
            </a>
            <?php do_action('wpjobportal_addons_feature_for_resume',$config_array,$resume,$featuredflag); ?>
            <a class="wpjobportal-resume-act-btn" href="admin.php?page=wpjobportal_resume&wpjobportallt=formresume&wpjobportalid=<?php echo esc_attr($resume->id); ?>" title="<?php echo __('edit', 'wp-job-portal'); ?>">
                <?php echo __('Edit', 'wp-job-portal'); ?>
            </a>
            <a class="wpjobportal-resume-act-btn" href="admin.php?page=wpjobportal_resume&wpjobportallt=viewresume&wpjobportalid=<?php echo esc_attr($resume->id); ?>" title="<?php echo __('view', 'wp-job-portal'); ?>">
                <?php echo __('View', 'wp-job-portal'); ?>
            </a>
        </div>
        <?php
    break;
    case 'resumeque':
        $dateformat = wpjobportal::$_configuration['date_format'];
        ?>
        <div class="wpjobportal-resume-action-wrp">
            <a class="wpjobportal-resume-act-btn" href="admin.php?page=wpjobportal_resume&wpjobportallt=viewresume&wpjobportalid=<?php echo esc_attr($resume->id); ?>" title="<?php echo __('view', 'wp-job-portal'); ?>">
                <?php echo __('View', 'wp-job-portal'); ?>
            </a>                  
            <a class="wpjobportal-resume-act-btn" href="admin.php?page=wpjobportal_resume&wpjobportallt=formresume&wpjobportalid=<?php echo esc_attr($resume->id); ?>" title="<?php echo __('edit', 'wp-job-portal'); ?>">
                <?php echo __('Edit', 'wp-job-portal'); ?>
            </a>
            <?php
                $total = count($arr);
                if ($total == 3) {
                    $objid = 4; //for all
                } elseif ($total != 1) {
                }
                if ($total == 1) {
                    if (isset($arr['self'])) {
                        ?>
                        <a class="wpjobportal-resume-act-btn" href="admin.php?page=wpjobportal_resume&task=approveQueueResume&id=<?php echo esc_attr($resume->id); ?>&action=wpjobportaltask" title="<?php echo __('approve', 'wp-job-portal'); ?>">
                            <?php echo __('Approve', 'wp-job-portal'); ?>
                        </a>
                    <?php
                    }
                    if (isset($arr['feature']) && in_array('featureresume', wpjobportal::$_active_addons)) {
                        ?>
                        <a class="wpjobportal-resume-act-btn" href="admin.php?page=wpjobportal_resume&task=approveQueueFeatureResume&id=<?php echo esc_attr($resume->id); ?>&action=wpjobportaltask" title="<?php echo __('feature approve', 'wp-job-portal'); ?>">
                            <?php echo __('Feature Approve', 'wp-job-portal'); ?>
                        </a>
                    <?php
                    }
                } /*else {
                    ?>
                    <div class="wpjobportal-resume-act-btn jobsqueue-approvalqueue" onmouseout="hideThis(this);" onmouseover='approveActionPopup("<?php echo esc_js($resume->id); ?>");'>
                        <img src="<?php echo WPJOBPORTAL_PLUGIN_URL; ?>includes/images/publish-icon.png">
                        <?php echo __('Approve', 'wp-job-portal'); ?>
                        <div id="wpjobportal-queue-actionsbtn" class="jobsqueueapprove_<?php echo esc_attr($resume->id); ?>">
                            <?php if (isset($arr['self'])) { ?>
                                <a id="wpjobportal-act-row" class="wpjobportal-act-row" href="admin.php?page=wpjobportal_resume&task=approveQueueResume&id=<?php echo esc_attr($resume->id); ?>&action=wpjobportaltask"><img class="jobs-action-image" src="<?php echo WPJOBPORTAL_PLUGIN_URL; ?>includes/images/comapny-logo.png"><?php echo __("Resume Approve", 'wp-job-portal'); ?></a>
                            <?php } ?>
                            <a id="wpjobportal-act-row-all" class="wpjobportal-act-row-all" href="admin.php?page=wpjobportal_resume&task=approveQueueAllResumes&objid=<?php echo $objid; ?>&id=<?php echo $resume->id; ?>&action=wpjobportaltask">
                                <img class="jobs-action-image" src="<?php echo WPJOBPORTAL_PLUGIN_URL; ?>includes/images/select-all.png">
                                <?php echo __("All Approve", 'wp-job-portal'); ?>
                            </a>
                        </div>
                    </div>
                    <?php
                } // End approve */
                if ($total == 1) {
                    if (isset($arr['self'])) {
                        ?>
                        <a class="wpjobportal-resume-act-btn" href="admin.php?page=wpjobportal_resume&task=rejectQueueResume&id=<?php echo esc_attr($resume->id); ?>&action=wpjobportaltask" title="<?php echo __('reject', 'wp-job-portal'); ?>">
                            <?php echo __('Reject', 'wp-job-portal'); ?>
                        </a>
                    <?php
                    }
                    if (isset($arr['feature']) && in_array('featureresume', wpjobportal::$_active_addons)) {
                        ?>
                        <a class="wpjobportal-resume-act-btn" href="admin.php?page=wpjobportal_resume&task=rejectQueueFeatureResume&id=<?php echo esc_attr($resume->id); ?>&action=wpjobportaltask" title="<?php echo __('feature reject', 'wp-job-portal'); ?>">
                            <?php echo __('Feature Reject', 'wp-job-portal'); ?>
                        </a>
                    <?php
                    }
                } /*else {
                    ?>
                    <div class="wpjobportal-resume-act-btn jobsqueue-approvalqueue" onmouseout="hideThis(this);" onmouseover='rejectActionPopup("<?php echo $resume->id; ?>");'><img src="<?php echo WPJOBPORTAL_PLUGIN_URL; ?>includes/images/reject-s.png">  <?php echo __('Reject', 'wp-job-portal'); ?>
                        <div id="wpjobportal-queue-actionsbtn" class="jobsqueuereject_<?php echo $resume->id; ?>">
                            <?php if (isset($arr['self'])) { ?>
                                <a id="wpjobportal-act-row" class="wpjobportal-act-row" href="admin.php?page=wpjobportal_resume&task=rejectQueueResume&id=<?php echo $resume->id; ?>&action=wpjobportaltask">
                                    <img class="jobs-action-image" src="<?php echo WPJOBPORTAL_PLUGIN_URL; ?>includes/images/comapny-logo.png">
                                    <?php echo __("Resume Reject", 'wp-job-portal'); ?>
                                </a>
                            <?php
                            } ?>
                            <a id="wpjobportal-act-row-all" class="wpjobportal-act-row-all" href="admin.php?page=resume&task=rejectQueueAllResumes&objid=<?php echo $objid; ?>&id=<?php echo $resume->id; ?>&action=wpjobportaltask">
                                <img class="jobs-action-image" src="<?php echo WPJOBPORTAL_PLUGIN_URL; ?>includes/images/select-all.png">
                                <?php echo __("All Reject", 'wp-job-portal'); ?>
                            </a>
                        </div>
                    </div>
            <?php }//End Reject */ ?>
            <a class="wpjobportal-resume-act-btn" href="<?php echo esc_url(wp_nonce_url(admin_url('admin.php?page=wpjobportal_resume&task=removeresume&wpjobportal-cb[]='.$resume->id),'delete-resume')); ?>&action=wpjobportaltask&callfrom=2" onclick='return confirm("<?php echo __('Are you sure to delete','wp-job-portal').' ?'; ?>");' title="<?php echo __('delete', 'wp-job-portal'); ?>">
                <?php echo __('Delete', 'wp-job-portal'); ?>
            </a>
            <a class="wpjobportal-resume-act-btn" href="<?php echo esc_attr(wp_nonce_url(admin_url('admin.php?page=wpjobportal_resume&task=resumeEnforceDelete&resumeid='.$resume->id),'delete-resume')); ?>&action=wpjobportaltask&callfrom=2" onclick='return confirmdelete("<?php echo __('This will delete every thing about this record','wp-job-portal').'. '.__('Are you sure to delete','wp-job-portal').'?'; ?>");'  title="<?php echo __('force delete', 'wp-job-portal'); ?>">
                <?php echo __('Force Delete', 'wp-job-portal'); ?>
            </a>
        </div>
        <?php
    break;
    case 'jobapply':
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
        <?php
        break;
}
