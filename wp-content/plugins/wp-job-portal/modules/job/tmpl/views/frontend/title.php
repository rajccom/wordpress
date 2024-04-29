<?php
/**
 * @param job      job object - optional
 */
$uid = WPJOBPORTALincluder::getObjectClass('user')->uid();
$html = '';
switch ($layout) {
    case 'job':
    if(in_array('multicompany', wpjobportal::$_active_addons)){
        $url = wpjobportal::makeUrl(array('wpjobportalme'=>'company', 'wpjobportallt'=>'viewcompany', 'wpjobportalid'=>$job->companyid));
    }else{
        $url = $url = wpjobportal::makeUrl(array('wpjobportalme'=>'company', 'wpjobportallt'=>'viewcompany', 'wpjobportalid'=>$job->companyid));
    } ?>
    <div class="wjportal-jobs-middle-wrp">
        <div class="wjportal-jobs-data">
            <a class="wjportal-companyname" href="<?php echo esc_url($url) ; ?>"><?php echo esc_html($job->companyname); ?></a><?php ?>
        </div>
        <div class="wjportal-jobs-data">
            <span class="wjportal-job-title">
                <a href="<?php echo esc_url(wpjobportal::makeUrl(array('wpjobportalme'=>'job', 'wpjobportallt'=>'viewjob', 'wpjobportalid'=>$job->jobaliasid))); ?>">
                    <?php echo esc_html($job->title); ?>
                </a>
            </span>
            <?php
                $featuredexpiry = date_i18n('Y-m-d', strtotime($job->endfeatureddate));
                $startdate = date_i18n('Y-m-d',strtotime($job->startpublishing));
                $enddate = date_i18n('Y-m-d',strtotime($job->stoppublishing));
                $curdate = date_i18n('Y-m-d');
                if($startdate > $curdate){
                    $publishstatus = __('Not publish','wp-job-portal');
                    $publishstyle = 'background:#fea702;';
                }elseif($startdate <= $curdate && $enddate >= $curdate){
                    $publishstatus = __('Publish','wp-job-portal');
                    $publishstyle = 'background:#00a859;';
                }else{
                    $publishstatus = __('Expired','wp-job-portal');
                    $publishstyle = 'background:#ed3237;';
                }
            ?>
            <?php if($job->status == 1 && WPJOBPORTALrequest::getVar('wpjobportallt') == "myjobs"){ ?>
                    <span class="wjportal-item-status" style="<?php echo esc_attr($publishstyle); ?>"><?php echo esc_html($publishstatus); ?></span>
            <?php } ?>
            <?php do_action('wpjobportal_credit_addons_feature_job_popup_for_emp',$job); ?>
        </div>
        <div class="wjportal-jobs-data">
            <?php if(isset($job) && !empty($job->cat_title)){ ?>
                <span class="wjportal-jobs-data-text">
                    <?php echo esc_html(__($job->cat_title,'wp-job-portal')); ?> 
                </span>
            <?php } ?>
            <?php  $print = WPJOBPORTALincluder::getJSModel('job')->checkLinks('city'); ?>
            <?php if(isset($job) && !empty($job->location)){ ?>
                <span class="wjportal-jobs-data-text">
                    <?php
                       if ($print) {
                            echo esc_html($job->location);
                        } 
                    ?>
                </span>
            <?php } ?>
        </div>
        <?php
            if(isset($control) && $control == "shortlistjob"){
                do_action('wpjobportal_addons_shortlist_comments',$job);
            }
        ?>
        <!-- custom fields -->
        <div class="wjportal-custom-field-wrp">
            <?php
                // custom fiedls 
                    $customfields = wpjobportal::$_wpjpcustomfield->userFieldsData(2,1);
                    foreach ($customfields as $field) {
                       $showCustom = wpjobportal::$_wpjpcustomfield->showCustomFields($field,7,$job->params);
                       echo wp_kses($showCustom, WPJOBPORTAL_ALLOWED_TAGS);
                    }
              /*  }*/
            ?>
        </div>
    </div>
    <div class="wjportal-jobs-right-wrp">
        <div class="wjportal-jobs-info">
            <?php $print = WPJOBPORTALincluder::getJSModel('job')->checkLinks('jobtype'); ?>
            <?php if ($print[0] == 1) { ?>
                <span class="wjportal-job-type" style="background:<?php echo esc_attr($job->jobtypecolor); ?>">
                    <?php echo esc_html(__($job->jobtypetitle,'wp-job-portal')); ?>
                </span>
            <?php } ?>
        </div>
        <?php
            $print = WPJOBPORTALincluder::getJSModel('job')->checkLinks('company');
            if ($print[0] == 1) {
                $print = WPJOBPORTALincluder::getJSModel('job')->checkLinks('jobsalaryrange');
                if ($print[0] == 1) {  ?>
                    <div class="wjportal-jobs-info">
                        <div class="wjportal-jobs-salary">
                            <?php echo esc_html(wpjobportal::$_common->getSalaryRangeView($job->salarytype, $job->salarymin, $job->salarymax,$job->currency)); ?>
                            <?php if($job->salarytype==3 || $job->salarytype==2) { ?>
                                <span class="wjportal-salary-type"> <?php echo ' / ' .__(esc_html($job->srangetypetitle), 'wp-job-portal') ?></span>
                            <?php }?>
                        </div>
                    </div>
                    <div class="wjportal-jobs-info">
                        <?php 
                            $dateformat = wpjobportal::$_configuration['date_format'];
                            echo esc_html(human_time_diff(strtotime($job->created)).' '.__("Ago",'wp-job-portal'));
                            $print = WPJOBPORTALincluder::getJSModel('job')->checkLinks('jobtype');
                        ?>
                    </div>
                    <?php     
                }
                $print = WPJOBPORTALincluder::getJSModel('job')->checkLinks('jobcategory');
                ?>
                <div class="wjportal-jobs-status">
                    <?php
                        $color = ($job->status == 1) ? "green" : "red";
                        if ($job->status == 1) {
                            $statusCheck = __('Approved', 'wp-job-portal');
                        } elseif ($job->status == 0) {
                            $statusCheck = __('Waiting for approval', 'wp-job-portal');
                        } else {
                            $statusCheck = __('Rejected', 'wp-job-portal');
                        }
                    ?>
                     <span class="wjportal-jobs-status-text <?php //echo esc_attr($color); ?>"><?php //echo esc_html($statusCheck); ?></span>  
                </div>
                <?php
                } 
            ?>
    </div>
    <?php
        break;
        case 'detailbody':
        echo' <div class="wjportal-job-sec-title">'.  __("Job Info",'wp-job-portal') .'</div>';
            $dateformat = wpjobportal::$_configuration['date_format'];
            $html ='<div class="wpjp-jobtype-info">';
                        foreach ($jobfields AS $key => $fields) {
                            switch ($fields->field) { 
                                case 'department':
                                    if(in_array('departments', wpjobportal::$_active_addons)){
                                        echo wp_kses(getDataRow(__($fields->fieldtitle, 'wp-job-portal'), $job->departmentname), WPJOBPORTAL_ALLOWED_TAGS);
                                    }
                                break;
                                case 'jobstatus':
                                    echo wp_kses(getDataRow(__($fields->fieldtitle, 'wp-job-portal'), __($job->jobstatustitle,'wp-job-portal')), WPJOBPORTAL_ALLOWED_TAGS);
                                break;
                                case 'noofjobs':
                                    echo wp_kses(getDataRow(__($fields->fieldtitle, 'wp-job-portal'), $job->noofjobs), WPJOBPORTAL_ALLOWED_TAGS);
                                break;
                                case 'duration':
                                    echo wp_kses(getDataRow(__($fields->fieldtitle, 'wp-job-portal'), $job->duration), WPJOBPORTAL_ALLOWED_TAGS);
                                break;
                                case 'careerlevel':
                                    echo wp_kses(getDataRow(__($fields->fieldtitle, 'wp-job-portal'), $job->careerleveltitle), WPJOBPORTAL_ALLOWED_TAGS);
                                break;
                                case 'experience':
                                    $experience = !empty($job->experience) ? $job->experience.' '.__("Years",'wp-job-portal') : '';
                                    echo wp_kses(getDataRow(__($fields->fieldtitle, 'wp-job-portal'), $experience), WPJOBPORTAL_ALLOWED_TAGS);
                                break;
                                case 'heighesteducation':
                                    echo wp_kses(getDataRow(__($fields->fieldtitle, 'wp-job-portal'), $job->educationtitle), WPJOBPORTAL_ALLOWED_TAGS);
                                    echo wp_kses(getDataRow(__('Degree Title', 'wp-job-portal'), $job->degreetitle), WPJOBPORTAL_ALLOWED_TAGS);
                                break;
                                case 'startpublishing':
                                    echo wp_kses(getDataRow(__('Posted', 'wp-job-portal'), date_i18n($dateformat, strtotime($job->startpublishing))), WPJOBPORTAL_ALLOWED_TAGS);
                                break;
                                case 'stoppublishing':
                                    echo wp_kses(getDataRow(__('Apply Before', 'wp-job-portal'), date_i18n($dateformat, strtotime($job->stoppublishing))), WPJOBPORTAL_ALLOWED_TAGS);

                                break;
                                default:
                                    if($fields->isuserfield == 1){
                                        // if(!in_array('customfield', wpjobportal::$_active_addons)){
                                        //     if($fields->userfieldtype == 'text' || $fields->userfieldtype == 'email'){
                                                $showCustom = wpjobportal::$_wpjpcustomfield->showCustomFields($fields,7,$job->params);
                                                echo wp_kses($showCustom, WPJOBPORTAL_ALLOWED_TAGS);
                                        //     }
                                        // }else{
                                        //     $showCustom = wpjobportal::$_wpjpcustomfield->showCustomFields($fields,7,$job->params);
                                        //     echo wp_kses($showCustom, WPJOBPORTAL_ALLOWED_TAGS);
                                        // }
                                    }
                                break;
                                }
                            }
                    echo '</div>
                        <div class="wjportal-job-data-wrp">
                            <div class="wjportal-job-desc">
                                <div class="wjportal-job-sec-title">'. __("Description",'wp-job-portal') .'</div>
                                '. wp_kses($job->description, WPJOBPORTAL_ALLOWED_TAGS) .'
                            </div>';
                    # Map 
                    do_action('wpjobportal_addons_addressdata_jobview',$job);
                    # Tags 
                    do_action('wpjobportal_credit_addons_search_job_ref_tags',$job);

            break;
        case 'job_seeker':
            echo ' <div class="wjportal-jobinfo-wrp">';
                    if(isset($job) && !empty($job->jobtypetitle)){
                        echo'<div class="wjportal-jobinfo">
                               <span class="wjportal-jobtype" style="background:'.esc_attr($job->jobtypecolor).'">'.esc_html($job->jobtypetitle).'</span>
                            </div>';
                    }
                   if(isset($job) && !empty($job->salarytype)){
                     echo '<div class="wjportal-jobinfo">
                            <span class="wjportal-jobinfo-data">
                                <img src="' . WPJOBPORTAL_PLUGIN_URL . 'includes/images/salary.png" alt="'.__("salary","wp-job-portal").'" title="'.__("salary","wp-job-portal").'" />
                                '.wp_kses(wpjobportal::$_common->getSalaryRangeView($job->salarytype, $job->salarymin, $job->salarymax, $job->currency), WPJOBPORTAL_ALLOWED_TAGS).'
                             </span>';if($job->salarytype==3 || $job->salarytype==2) { ?>
                                <span class="wjportal-salary-type"> <?php  echo ' / ' .__(esc_html($job->srangetypetitle), 'wp-job-portal'); ?></span>
                            <?php }
                     echo '</div>';
                    }
                    if(isset($job) && !empty($job->cat_title)){
                        echo '<div class="wjportal-jobinfo">
                                <span class="wjportal-jobinfo-data">
                                    <img src="' . WPJOBPORTAL_PLUGIN_URL . 'includes/images/category.png" alt="'.__("category","wp-job-portal").'" title="'.__("category","wp-job-portal").'" />
                                    '. esc_html($job->cat_title) .'
                                 </span>
                                </div>';
                    }
                    if(isset($job) && $job->created){
                        echo ' <div class="wjportal-jobinfo">
                                    <span class="wjportal-jobinfo-data">
                                        <img src="' . WPJOBPORTAL_PLUGIN_URL . 'includes/images/calander.png" alt="'.__("created","wp-job-portal").'" title="'.__("created","wp-job-portal").'" />
                                        '.esc_html(date_i18n(wpjobportal::$_configuration['date_format'],strtotime($job->created))).'
                                     </span>
                                </div>';
                    }
                   if(isset($job) && $job->stoppublishing){
                        echo '<div class="wjportal-jobinfo">
                                    <span class="wjportal-jobinfo-data wjportal-job-close-date">
                                        <img src="' . WPJOBPORTAL_PLUGIN_URL . 'includes/images/end-date.png" alt="'.__("end date","wp-job-portal").'" title="'.__("end date","wp-job-portal").'" />'.__('Closes','wp-job-portal').':
                                        '.esc_html(date_i18n(wpjobportal::$_configuration['date_format'],strtotime($job->stoppublishing))) .'
                                     </span>
                                </div>';
                   }
                   if(isset($job) && !empty($job->multicity)){
                        echo '<div class="wjportal-jobinfo">
                                <span class="wjportal-jobinfo-data">
                                    <img src="' . WPJOBPORTAL_PLUGIN_URL . 'includes/images/locationn.png" alt="'.__("location","wp-job-portal").'" title="'.__("location","wp-job-portal").'"/>
                                    '. esc_html($job->multicity) .'
                                 </span>
                                </div>';
                    }
            echo '</div>';                
        break;
    case 'apply1':
        $html = '';
        if(!WPJOBPORTALincluder::getObjectClass('user')->isguest()){
            $applied = WPJOBPORTALincluder::getJSModel('job')->checkAlreadyAppliedJob($job->id,$uid);
            if(wpjobportal::$_config->getConfigValue('showapplybutton') == 1){
                if(in_array('credits', wpjobportal::$_active_addons)){
                    $submission_Type = wpjobportal::$_data['submission_type'];
                    do_action('wpjobportal_addons_addressdata_job_apply_btn',$submission_Type,$applied,$job);
                }else{
                    if(isset($applied) && !empty($applied)){
                        if($applied->no == 1){
                            echo'<span class="wjportal-job-company-apply-status" onclick="getApplyNowByJobid('.esc_js($job->id).')">'. __("You Already Applied to this job ",'wp-job-portal') .' </span>';
                        }elseif ($applied->no == 0) {
                            echo '<a class="wjportal-job-company-btn" onclick="getApplyNowByJobid('.esc_js($job->id).')">' . __('Apply On This Job', 'wp-job-portal').'</a>';
                        }
                    }else{
                        echo '<a class="wjportal-job-company-btn" onclick="getApplyNowByJobid('.esc_js($job->id).')">' . __('Apply On This Job', 'wp-job-portal').'</a>';
                    }
                }
            }
        }else{
            $visitorcanapply = wpjobportal::$_config->getConfigurationByConfigName('visitor_can_apply_to_job');
            if(in_array('credits', wpjobportal::$_active_addons) && $visitorcanapply != 1){
                $finalurl = wpjobportal::makeUrl(array('wpjobportalme'=>'wpjobportal', 'wpjobportallt'=>'login'));
                echo '<a href="'.$finalurl.'" class="wjportal-job-company-btn" title="' . __('Login to Apply On This Job', 'wp-job-portal') . '">' . __('Login to Apply On This Job', 'wp-job-portal') . '</a>';
            } else {
                $visitor_show_login_message = wpjobportal::$_config->getConfigurationByConfigName('visitor_show_login_message');
                if ($visitor_show_login_message == 1) {
                    echo '<a class="wjportal-job-company-btn" onclick="getApplyNowByJobid('.esc_js($job->id).')">' . __('Apply On This Job', 'wp-job-portal').'</a>';
                } else {
                    echo '<a class="wjportal-job-company-btn" href="' . wpjobportal::makeUrl(array('wpjobportalme'=>'jobapply', 'action'=>'wpjobportaltask', 'task'=>'jobapplyasvisitor', 'wpjobportalid-jobid'=>$job->id, 'wpjobportalpageid'=>wpjobportal::getPageid())) . '">' . __('Apply On This Job', 'wp-job-portal').'</a>';
                }
            }
        }
        
        $allow_tellafriend  = wpjobportal::$_config->getConfigurationByConfigName('allow_tellafriend');
        if($allow_tellafriend == 1 ){
            # Apply shortlist,Alertjob..
            do_action('wpjobportal_addons_newestjob_btm_btn_for_tellfriend',$job);
        }
        $allow_jobshortlist  = wpjobportal::$_config->getConfigurationByConfigName('allow_jobshortlist');
        if($allow_jobshortlist == 1 AND (! WPJOBPORTALincluder::getObjectClass('user')->isemployer())){
            if(!WPJOBPORTALincluder::getObjectClass('user')->isguest()){
                do_action('wpjobportal_addons_newestjob_btm_btn_for_shortlist',$job);
            }
        }
        break;

    case 'apply':
        $package = '';
        if(!WPJOBPORTALincluder::getObjectClass('user')->isguest()){
            $applied = WPJOBPORTALincluder::getJSModel('job')->checkAlreadyAppliedJob($job->id,$uid);
            if(in_array('credits', wpjobportal::$_active_addons)){
                do_action('wpjobportal_addons_job_apply_jobseeker',$job,$package,$applied);
            }else{
                if(wpjobportal::$_config->getConfigValue('showapplybutton') == 1){
                    if(isset($applied) && !empty($applied)){
                        if($applied->no != 1){
                            echo '<a class="wjportal-job-act-btn" onclick="getApplyNowByJobid('.esc_js($job->id).','.esc_js($package).')">' . __('Apply On This Job', 'wp-job-portal').'</a>';
                        }
                    }
                }
            }
        }else{
            $visitorcanapply = wpjobportal::$_config->getConfigurationByConfigName('visitor_can_apply_to_job');
            if(in_array('credits', wpjobportal::$_active_addons) && $visitorcanapply != 1){
                $finalurl = wpjobportal::makeUrl(array('wpjobportalme'=>'wpjobportal', 'wpjobportallt'=>'login'));
                echo '<a href="'.$finalurl.'" class="wjportal-job-act-btn" title="' . __('Login to Apply On This Job', 'wp-job-portal') . '">' . __('Login to Apply On This Job', 'wp-job-portal') . '</a>';
            } else {
                $visitor_show_login_message = wpjobportal::$_config->getConfigurationByConfigName('visitor_show_login_message');
                if ($visitor_show_login_message == 1) {
                    echo '<a class="wjportal-job-act-btn" onclick="getApplyNowByJobid('.esc_js($job->id).')">' . __('Apply On This Job', 'wp-job-portal').'</a>';
                } else {
                    echo '<a class="wjportal-job-act-btn" href="' . wpjobportal::makeUrl(array('wpjobportalme'=>'jobapply', 'action'=>'wpjobportaltask', 'task'=>'jobapplyasvisitor', 'wpjobportalid-jobid'=>$job->id, 'wpjobportalpageid'=>wpjobportal::getPageid())) . '">' . __('Apply On This Job', 'wp-job-portal').'</a>';
                }
            }
        }
         # Social Share
         do_action('wpjobportal_credit_addons_social_share_links_job',$job);
         # Social Comment's
         do_action('wpjobportal_credit_social_comments_for_jobs');
       break;
    }
?>
