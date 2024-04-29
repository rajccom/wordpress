
<div id="wp-job-portal-wrapper">
    <div class="js-toprow">
        <div class="js-image">
            <a href="<?php echo esc_url(wpjobportal::makeUrl(array('wpjobportalme'=>'company', 'wpjobportallt'=>'viewcompany', 'wpjobportalid'=>$job->companyaliasid))); ?>">
                <img src="<?php echo esc_url(WPJOBPORTALincluder::getJSModel('company')->getLogoUrl($job->companyid,$job->logofilename)); ?>">
            </a>
        </div>
        <div class="js-data">
            <div class="left">
                <?php if(wpjobportal::$_config->getConfigValue('comp_name') == 1){ ?>
                <div class="js-col-xs-12 js-col-sm-12 js-col-md-12 js-midrow">
                    <a class="js-companyname" href="<?php echo esc_url(wpjobportal::makeUrl(array('wpjobportalme'=>'company', 'wpjobportallt'=>'viewcompany', 'wpjobportalid'=>$job->companyaliasid))); ?>"><?php echo esc_html($job->companyname); ?></a>
                </div>
                <?php } ?>
                <div class="js-first-row">
                    <span class="js-col-xs-12 js-col-sm-8 js-col-md-8 js-title joblist-jobtitle">
                        <a href="<?php echo esc_url(wpjobportal::makeUrl(array('wpjobportalme'=>'job', 'wpjobportallt'=>'viewjob', 'wpjobportalid'=>$job->jobaliasid))); ?>"><?php echo esc_html($job->title); ?></a>
                    </span>

                </div>
                <div class="js-dash-fields">
                <?php if($jobfields['jobcategory']->showonlisting == 1){ ?>
                    <span class="get-text"><?php echo  __(esc_html($job->cat_title),'wp-job-portal'); ?></span>
                <?php } ?>
                <?php if($jobfields['city']->showonlisting == 1){ ?>
                    <span class="get-text"><?php echo esc_html($job->location); ?></span>
                <?php } ?>
                </div>
            </div>
            <div class="right">
                <div class="js-col-xs-12 js-col-sm-12 js-col-md-12 js-fields for-rtl joblist-datafields">
                    <span class="js-type" style="color:#fff;padding:3px;background:<?php echo esc_attr($job->jobtypecolor); ?>;"><?php echo __(esc_html($job->jobtypetitle),'wp-job-portal'); ?></span>
                </div>
                <?php if($jobfields['jobsalaryrange']->showonlisting == 1){ ?>
                <div class="js-col-xs-12 js-col-sm-12 js-col-md-12 js-fields for-rtl joblist-datafields">
                    <span class="get-text"><b><?php echo esc_html($job->salary); ?></b></span>
                </div>
                <?php } ?>
                <div class="js-col-xs-12 js-col-sm-12 js-col-md-12 js-fields for-rtl joblist-datafields">
                    <?php echo esc_html(human_time_diff(strtotime($job->created))).' '.__("Ago",'wp-job-portal'); ?>
                </div>
            </div>


            <div class="js-second-row">


                <?php
                // custom fields
                /*foreach ($customfields as $field) {
                    echo WPJOBPORTALincluder::getObjectClass('customfields')->showCustomFields($field,JOB,$job->params);
                }*/
                //end
                ?>
            </div>
        </div>
    </div>
</div>