<?php
/**
 * @param wpjob portal      job object - optional
*/
?>
<!-- Popup Loading For Job Apply -->
<div id="wjportal-popup-background"></div>
<div id="wjportal-listpopup" class="wjportal-popup-wrp">
    <div class="wjportal-popup-cnt">
        <img id="wjportal-popup-close-btn" alt="popup cross" src="<?php echo WPJOBPORTAL_PLUGIN_URL; ?>includes/images/popup-close.png">
        <div class="wjportal-popup-title">
            <span class="wjportal-popup-title2"></span>
        </div>
        <div class="wjportal-popup-contentarea"></div>
    </div>
</div>
<!-- Popup Ends there -->
<!-- Page Title View Job  -->
<div class="wjportal-page-header">
    <?php WPJOBPORTALincluder::getTemplate('templates/pagetitle',array(
        'module' => 'job'
        ,'layout' => 'jobdetail',
        'jobtitle' => $job->title
    )); ?>
</div>
<!-- Page Title Ends there -->

<div class="wjportal-jobdetail-wrapper">
    <?php
    /**
    * @param template redirection 
    * Frontend => detail with icon
    * # case Upper detail =>job_seeker
    **/
        WPJOBPORTALincluder::getTemplate('job/views/frontend/title',array(
            'job' => $job,
            'layout' =>'job_seeker'
        ));
    ?>
    <div class="wjportal-job-company-wrp">
        <?php
        /**
        * @param template redirection 
        * Frontend => file logo
        * # case logo
        **/
            WPJOBPORTALincluder::getTemplate('job/views/frontend/logo',array(
                'job' => $job,
                'layout' => 'logo'
            ));
        ?>
        <div class="wjportal-job-company-cnt">
            <div class="wjportal-job-company-info">
                <?php 
                if(in_array('multicompany', wpjobportal::$_active_addons)){
                    $url = wpjobportal::makeUrl(array('wpjobportalme'=>'multicompany', 'wpjobportallt'=>'viewcompany', 'wpjobportalid'=>$job->companyid));
                }else{
                    $url = wpjobportal::makeUrl(array('wpjobportalme'=>'company', 'wpjobportallt'=>'viewcompany', 'wpjobportalid'=>$job->companyid));
                }
                ?>
                <a class="wjportal-job-company-name" href="<?php echo esc_url($url);?>">
                    <?php echo esc_html($job->companyname); ?>
                </a>
            </div>
            <?php if(isset($job) && !empty($job->companyemail)) :
                $config_array = wpjobportal::$_data['config'];
                if ($config_array['comp_email_address'] == 1) :
            ?>
                    <div class="wjportal-job-company-info">
                        <span class="wjportal-job-company-info-tit"><?php echo __("Email",'wp-job-portal') ?>:</span>
                        <span class="wjportal-job-company-info-val"><?php echo esc_html($job->companyemail); ?></span>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
            <?php if(isset($job) && !empty($job->url)) :?>
                    <div class="wjportal-job-company-info">
                        <span class="wjportal-job-company-info-tit"><?php echo __("Website",'wp-job-portal') ?>:</span>
                        <span class="wjportal-job-company-info-val"><?php echo esc_html($job->companyurl); ?></span>
                    </div>
            <?php endif; ?>
            
            <div class="wjportal-job-company-btn-wrp">
                <?php
                /**
                * @param template redirection 
                * Frontend => View Body Data 
                * # case apply lower btn
                **/
   	                WPJOBPORTALincluder::getTemplate('job/views/frontend/title',array(
                        'job' => $job,
                        'layout' => 'apply1'
                    ));
			    ?>
            </div>
        </div>
    </div>
    <div class="wjportal-job-data-wrp">
        <?php
        /**
        * @param template redirection 
        * Frontend => View Body Data 
        * # case detail body
        **/
            WPJOBPORTALincluder::getTemplate('job/views/frontend/title',array(
                'job' => $job,
                'jobfields' => $jobfields,
                'layout' => 'detailbody'
            ));
        ?> 
    </div>
    <div class="wjportal-job-btn-wrp">
        <?php
        /**
        * @param template redirection 
        * Frontend => View btn Job View 
        * # case apply
        **/
            WPJOBPORTALincluder::getTemplate('job/views/frontend/title',array(
                'job' => $job,
                'layout' => 'apply'
            ));
        ?>
    </div>
</div>
