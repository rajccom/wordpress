<?php
/**
* @param WP JOB PORTAL
* @param WP Control My Jobs
* @param Feature Job - Copy Job
*/
?>
<?php
switch ($control) {
    case 'myjobs':
        $featuredexpiry = date_i18n('Y-m-d', strtotime($job->endfeatureddate));
        $print = WPJOBPORTALincluder::getJSModel('job')->checkLinks('noofjobs'); 
        $startdate = date_i18n('Y-m-d',strtotime($job->startpublishing));
        $enddate = date_i18n('Y-m-d',strtotime($job->stoppublishing));
        $curdate = date_i18n('Y-m-d');
        echo '<div class="wjportal-jobs-list-btm-wrp">
                <div class="wjportal-jobs-action-wrp">';
                    if($job->status == 1 || $job->status == 3){
                        echo '<a class="wjportal-jobs-act-btn" title ='.__('Edit Job','wp-job-portal').' href='. esc_url(wpjobportal::makeUrl(array('wpjobportalme'=>'job', 'wpjobportallt'=>'addjob', 'wpjobportalid'=>$job->id))).'>'. __('Edit Job', 'wp-job-portal').'</a>';
                    }
                    $config_array = wpjobportal::$_data['config'];
                    if($job->status != 3 && $job->status != 4){
                        #Feature Job--
                        do_action('wpjobportal_credit_addons_feature_job_popup',$config_array,$job,$featuredexpiry);
                    }
                    if($job->status != 4){ ?>
                    <a class="wjportal-jobs-act-btn" href="<?php echo esc_url(wp_nonce_url(wpjobportal::makeUrl(array('wpjobportalme'=>'job', 'task'=>'remove', 'action'=>'wpjobportaltask', 'wpjobportal-cb[]'=>$job->id,'wpjobportalpageid'=>wpjobportal::getPageid())),'delete-job')); ?>" onclick='return confirmdelete("<?php echo __('Are you sure to delete','wp-job-portal').' ?'; ?>");'><?php echo __('Delete Job', 'wp-job-portal'); ?></a>
                    <?php }
                    # Copy Job --
                    do_action('wpjobportal_addons_credit_popup_copy_job',$job);
                    if($job->status != 3 && $job->status != 4 ){
                       echo '<a class="wjportal-jobs-act-btn wjportal-jobs-apply-res" title = '.__('Resume','wp-job-portal').' href='. esc_url(wpjobportal::makeUrl(array('wpjobportalme'=>'jobapply', 'wpjobportallt'=>'jobappliedresume', 'jobid'=>$job->id))).'>'. __('Resume', 'wp-job-portal') . " (" . esc_html($job->resumeapplied) . ")".'</a>';    
                    }
                   if($job->status == 0){
                        echo '
                                <span class="wjportal-item-act-status wjportal-waiting">'. __('Waiting For Approval', 'wp-job-portal').'</span>
                            ';
                    }elseif($job->status == -1){
                        #Rejected Job
                        echo '
                                <span class="wjportal-item-act-status wjportal-rejected">'.__('Rejected', 'wp-job-portal').'</span>
                            ';
                 }elseif ($job->status == 3) {
                    # job perlisting --payment
                    do_action('wpjobportal_addons_makePayment_for_department',$job,'payjob'); 
                }  
                // close action wrp
        echo '</div> 
            </div>'; /* close bottom wrp */
        break;
        case 'resumetitle':
         ?><div class="wjportal-jobs-list-btm-wrp" id="full-width-top">
            <div class="wjportal-jobs-list-resume-wrp">
                <?php
                   if(in_array('credits', wpjobportal::$_active_addons) && $job->applystatus == 3){
                       do_action('wpjobportal_addons_makePayment_for_department',$job,'payjobapply');
                   } 
                ?>
                <div class="wjportal-jobs-list-resume-data">
                    <span class="wjportal-jobs-list-resume-tit">
                        <?php echo __('Resume Title', 'wp-job-portal').' : '; ?>
                    </span>
                    <span class="wjportal-jobs-list-resume-val">
                        <?php 
                            echo esc_html($job->first_name);
                            echo ' '.esc_html($job->last_name);
                            if($job->application_title != '') {
                                echo ' ('.esc_html($job->application_title).')';
                            }
                        ?>
                    </span> 
                </div>
                <!-- applied job resume status -->

                <?php do_action('wpjobportal_addons_resume_action_jobapplied_status',$job);

                if(in_array('coverletter', wpjobportal::$_active_addons) ){ ?>
                        <div class="wjportal-jobs-list-resume-data">
                            <span class="wjportal-jobs-list-resume-tit">
                                <?php echo __('Cover Letter Title', 'wp-job-portal').' : '; ?>
                            </span>
                            <span class="wjportal-jobs-list-resume-val">
                                <?php
                                    echo esc_html($job->coverlettertitle);
                                ?>
                            </span>
                        </div>
                    <?php } ?>
                </div>
            </div>
            <?php
        break;
    case 'shortlistjob': ?>
        <?php
            $applied =  WPJOBPORTALincluder::getJSmodel('jobapply')->checkAlreadyAppliedJob($job->jobid,WPJOBPORTALincluder::getObjectClass('user')->uid());
            if ($applied == true) {
                $desc = "You have Already Applied";
            }else{
                $desc = "Apply Now";
            }
        ?>
        <div class="wjportal-jobs-list-btm-wrp">
            <div class="wjportal-jobs-action-wrp">
                <?php $allow_tellafriend  = wpjobportal::$_config->getConfigurationByConfigName('allow_tellafriend');
                if($allow_tellafriend == 1){
                   do_action('wpjobportal_addons_tellfriend_shorlist',$job->jobid);
                 } ?>
               <a class="wjportal-jobs-act-btn" href="<?php echo  esc_url(wp_nonce_url(wpjobportal::makeUrl(array('wpjobportalpageid'=>wpjobportal::getPageid(),'wpjobportalme'=>'shortlist', 'action'=>'wpjobportaltask', 'task'=>'removeshortlist', 'wpjobportalid'=>$job->slid)),'delete-shortlisted-job')); ?>"><?php echo __('Delete Job', 'wp-job-portal'); ?></a><?php 
                $config_array = wpjobportal::$_data['config'];
                if($config_array['showapplybutton'] == 1){  
                    if($job->jobapplylink == 1 && !empty($job->joblink)){
                        if(!wpjobportalphplib::wpJP_strstr('http',$job->joblink)){
                            $job->joblink = 'http://'.$job->joblink;
                        } ?>
                        <a class="wjportal-jobs-act-btn" href= "<?php echo $job->joblink ;?>" target="_blank" ><?php echo __('Apply Now','wp-job-portal'); ?></a><?php 
                    }elseif(!empty($config_array['applybuttonredirecturl'])){ 
                        if(!wpjobportalphplib::wpJP_strstr('http',$config_array['applybuttonredirecturl'])){
                            $joblink = 'http://'.$config_array['applybuttonredirecturl'];
                        }else{
                            $joblink = $config_array['applybuttonredirecturl'];
                        } ?>
                        <a class="wjportal-jobs-act-btn" href= "<?php echo esc_url($joblink); ?>" target="_blank" ><?php echo __('Apply Now','wp-job-portal'); ?></a><?php 
                    }else{ 
                        if(WPJOBPORTALincluder::getObjectClass('user')->isjobseeker()){
                            if(in_array('credits', wpjobportal::$_active_addons)){ ?>
                                <?php 
                                    //if($applied == true){
                                    $submission_type = wpjobportal::$_config->getConfigValue('submission_type');
                                    if($submission_type == 1){ ?>
                                        <?php if($applied == true){?>
                                            <a class="wjportal-jobs-act-btn" href="#" onclick="wpjobportalPopup('job_apply', '<?php echo esc_js($job->jobid); ?>')"><?php echo __('Apply Now', 'wp-job-portal') ?></a>
                                    <?php }else{  
                                            echo'<a class="wjportal-job-jobapply-btn wjportal-jobs-act-btn" href="#" onclick="getApplyNowByJobid('. esc_js($job->jobid) .')">'. __("You have Already Applied",'wp-job-portal') .' </a>';
                                        } ?>

                                   <?php }elseif ($submission_type == 2) { 
                                        $payment = WPJOBPORTALincluder::getJSmodel('jobapply')->checkjobappllystats($job->jobid,WPJOBPORTALincluder::getObjectClass('user')->uid());
                                       // echo $payment;
                                        echo $applied;
                                        if($payment == true && $payment == false){ ?>
                                            <a class="wjportal-jobs-act-btn" href="#" onclick="wpjobportalPopup('job_apply', '<?php echo esc_js($job->jobid); ?>')"><?php echo __('Apply Now', 'wp-job-portal') ?></a>
                                     <?php }
                                if($payment == false && $applied != true){ 
                                        $arr = array('wpjobportalme'=>'purchasehistory','wpjobportallt'=>'payjobapply','wpjobportalid'=>$job->jobid);
                                        echo '<a class="wjportal-job-act-btn" href='. esc_url(wpjobportal::makeUrl($arr)).' title='. esc_attr(__('make payment','wp-job-portal')).'>
                                         '. esc_html(__('Make Payment To Apply', 'wp-job-portal')).'
                                         </a>'; 
                                   }else{
                                        echo'<a class="wjportal-job-jobapply-btn wjportal-jobs-act-btn" href="#" onclick="getPackagePopupJobView('. esc_js($job->jobid) .')">'. __("You have Already Applied",'wp-job-portal') .' </a>';  
                                     }
                            }elseif ($submission_type == 3) {
                                if($applied == true){

                                 echo'<a class="wjportal-job-jobapply-btn wjportal-jobs-act-btn" href="#" onclick="getPackagePopupJobView('. esc_js($job->jobid) .')">'. __("Apply On This Job",'wp-job-portal') .' </a>';
                                }else{
                                    echo'<a class="wjportal-job-jobapply-btn wjportal-jobs-act-btn" href="#" onclick="getPackagePopupJobView('. esc_js($job->jobid) .')">'. __("You have Already Applied",'wp-job-portal') .' </a>'; 
                                }
                            } 
                            }else{?>
                                    <a class="wjportal-jobs-act-btn" href="#" onclick="getApplyNowByJobid('<?php echo esc_js($job->jobid); ?>')"><?php echo __('Apply Now', 'wp-job-portal') ?></a>
                        <?php } ?>
                            
                        <?php }else{ ?>
                            <a class="wjportal-jobs-act-btn" href="#" onclick="getApplyNowByJobid('<?php echo esc_js($job->jobid); ?>',<?php echo esc_js(wpjobportal::getPageid());?>);"><?php echo __(esc_html($desc), 'wp-job-portal') ?></a>
                        <?php } 
                    }
                } ?>
                <div class="wjportal-shortlist-stars">
                    <?php
                        if(isset($control)){
                            if($control == "shortlistjob"){
                                do_action('wpjobportal_addons_upper_lable_shortlist_rating',$job);
                            }
                        }
                    ?>
                </div>
            </div>
        </div>
    <?php   break;
    case 'payjob':
        do_action('wpjobportal_addons_proceedPayment_PerListing',$job->jobid,'job','myjob');
        break;
    case 'payjobapply':
        do_action('wpjobportal_addons_proceedPayment_PerListing',$job->jobaliasid,'job','viewjob');
        break;
}

       
