<?php
/**
 * @param WP JOB PORTAL 
 * @param Control 
 */
$html = '';

switch ($control) {
	case 'myresumes':
        if ($myresume->status == 1 || $myresume->status == 3) {
            $config_array_res = wpjobportal::$_data['config'];
            if(in_array('multiresume', wpjobportal::$_active_addons)){
                $mod = "multiresume";
            }else{
                $mod = "resume";
            }
            ?>
            <div class="wjportal-resume-list-btm-wrp">
                <div class="wjportal-resume-action-wrp">
                    <a class="wjportal-resume-act-btn" href="<?php echo esc_url(wpjobportal::makeUrl(array('wpjobportalme'=>$mod, 'wpjobportallt'=>'addresume', 'wpjobportalid'=>$myresume->id, 'wpjobportalpageid'=>wpjobportal::getPageid()))); ?>">
                        <?php echo __('Edit Resume', 'wp-job-portal'); ?>
                    </a>
                    <?php if ($myresume->status != 3){ ?>
                            <?php if(in_array('multiresume', wpjobportal::$_active_addons)){ ?>
                                <a class="wjportal-resume-act-btn" href="<?php echo esc_url( wpjobportal::makeUrl(array('wpjobportalme'=>'resume', 'wpjobportallt'=>'viewresume', 'wpjobportalid'=>$myresume->id, 'wpjobportalpageid'=>wpjobportal::getPageid()))); ?>">
                            <?php echo __('View Resume', 'wp-job-portal'); ?>
                        </a>
                        <?php    } 
                    }
                    if ($config_array_res['system_have_featured_resume'] == 1 && $featuredflag == true && $myresume->status !=3) {
                        do_action('wpjobportal_addons_feature_multiresume',$myresume);
                     } 
                    if($myresume->status == 3){
                        do_action('wpjobportal_addons_makePayment_for_department',$myresume,"payresume");
                    }
                    ?>  
                    <a class="wjportal-resume-act-btn" href="<?php echo esc_url(wp_nonce_url(wpjobportal::makeUrl(array('wpjobportalme'=>'resume', 'task'=>'removeresume', 'action'=>'wpjobportaltask', 'wpjobportal-cb[]'=>$myresume->id, 'wpjobportalpageid'=>wpjobportal::getPageid())),'delete-resume')); ?>"onclick='return confirmdelete("<?php echo __('Are you sure to delete','wp-job-portal').' ?'; ?>");'>
                        <?php echo __('Delete Resume', 'wp-job-portal'); ?> 
                    </a>
                </div>
            </div>
        <?php } elseif ($myresume->status == 0) { ?>
            <div class="wjportal-resume-list-btm-wrp">
                <span class="wjportal-item-act-status wjportal-waiting">
                    <?php echo __('Waiting For Approval', 'wp-job-portal'); ?>
                </span>
            </div>
        <?php } elseif ($myresume->status == -1){ ?>
            <div class="wjportal-resume-list-btm-wrp">
                <span class="wjportal-item-act-status wjportal-rejected">
                    <?php echo __('Rejected', 'wp-job-portal'); ?>
                </span>
            </div>
          <?php
              } 
         break;
     case 'folderresume':
            do_action('wpjobportal_addons_folderresume_control',$myresume);
         break;
         case 'jobapply': ?>
         <div class="wjportal-resume-list-btm-wrp">
        <div class="wjportal-resume-action-wrp">
            <?php
                $class = 'action-links';
                do_action('wpjobportal_addons_resume_bottom_action_appliedresume',$myresume,$class);  
                echo '
                <a class="wjportal-resume-act-btn" href='. esc_url(wpjobportal::makeUrl(array('wpjobportalme'=>'resume', 'wpjobportallt'=>'viewresume', 'jobid'=>$myresume->id, 'wpjobportalid'=>$myresume->resumealiasid, 'wpjobportalpageid'=>wpjobportal::getPageid()))).' title='. __('view profile', 'wp-job-portal') .'>
                    '. __('View Profile', 'wp-job-portal') .'
                </a>';
            ?>
        </div>
    </div>
        <?php
        break;
    case 'payresume':
    case 'payfeaturedresume':
        do_action('wpjobportal_addons_proceedPayment_PerListing',$myresume->resumealiasid,'resume','myresumes');
        break;


}
?>
