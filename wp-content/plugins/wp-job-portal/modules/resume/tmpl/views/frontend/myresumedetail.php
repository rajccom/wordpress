<?php
/**
 * @param job      job object - optional
*/
?>
<div class="wjportal-resume-cnt-wrp">
    <div class="wjportal-resume-middle-wrp">
        <div class="wpjp-resume-name padding">
            <a href="<?php echo esc_url(wpjobportal::makeUrl(array('wpjobportalme'=>'resume', 'wpjobportallt'=>'viewresume', 'wpjobportalid'=>$myresume->aliasid, 'wpjobportalpageid'=>wpjobportal::getPageid()))); ?>">
                    <?php echo esc_html($myresume->first_name) . ' ' . esc_html($myresume->last_name); ?>
            </a>
        </div>
        <?php
	        $dateformat = wpjobportal::$_configuration['date_format'];
	        $curdate = date_i18n($dateformat);
            do_action('wpjobportal_addons_feature_resume_label',$myresume);
        ?>
        <div class="wpjp-job-resume-title-wrp padding">
            <?php if($myresume->application_title != ''){ ?>
                <span class="wpjp-resume-title">
                    <?php echo '(' . esc_html($myresume->application_title) . ')'; ?>
                </span>
            <?php } ?>
        </div>
        <div class="wpjp-resume-info-wrp padding">
            <div class="wpjp-resume-info">
               <!-- <span class="js-bold"><?php //echo __('Category', 'wp-job-portal') . ': '; ?></span>
               <span class="get-text"><?php //echo __($myresume->cat_title,'wp-job-portal'); ?></span>
           </div>  -->
            <div class="wpjp-resume-info">
                <span class="wpjp-text">
                    <?php echo __('Desired Salary', 'wp-job-portal') . ': '; ?>
                </span>
                <span class="wpjp-value">
                    <?php echo esc_html($myresume->salary); ?>
                </span>
            </div>
            <div class="wpjp-resume-info">
                <span class="wpjp-text">
                    <?php echo __('Total Experience', 'wp-job-portal') . ': '; ?>
                </span>
                <span class="wpjp-value">
                    <?php echo __(esc_html(WPJOBPORTALincluder::getJSModel('common')->getTotalExp($myresume->id)),'wp-job-portal');?>
                </span>
            </div>
            <div class="wpjp-resume-info">
                <span class="wpjp-text">
                    <?php echo __('Location', 'wp-job-portal') . ': '; ?>
                </span>
                 <?php if ($myresume->location != '') { ?>
                    <span class="wpjp-value">
                        <?php echo esc_html($myresume->location); ?>
                    </span>
                <?php } ?>
            </div>
            <?php
                // custom fiedls
                $customfields = apply_filters('wpjobportal_addons_get_custom_field',false,3,1,1);
                // if(in_array('customfield', wpjobportal::$_active_addons)){
                    foreach ($customfields as $field) {
                        $showCustom =  apply_filters('wpjobportal_addons_show_customfields_params',false,$field,10,$myresume->params);
                        echo esc_attr($showCustom);
                    }
                // }
            ?>
        </div>
    </div>
    <?php if($myresume->status != 3 && $myresume->isfeaturedresume = NULL ){ ?>
    	<div class="wpjp-resume-right padding">
            <div class="wpjp-view-resume-button">
                <a href="<?php echo esc_url(wpjobportal::makeUrl(array('wpjobportalme'=>'resume', 'wpjobportallt'=>'viewresume', 'wpjobportalid'=>$myresume->aliasid, 'wpjobportalpageid'=>wpjobportal::getPageid()))); ?>">
                    <?php echo __('View Resume', 'wp-job-portal'); ?>
                </a>
            </div>
        </div>
    <?php } ?>
    <?php if (($myresume->status == 3 || $myresume->isfeaturedresume == NULL) && in_array('credits',wpjobportal::$_active_addons) && !isset(wpjobportal::$_data['isdata'])) {
              do_action('wpjobportal_addons_makePayment_for_department',$myresume,'payresume');
        } elseif (($myresume->status == 3 || $myresume->isfeaturedresume == NULL ) && isset(wpjobportal::$_data['isdata'])) {
            if(in_array('multiresume', wpjobportal::$_active_addons)){
                $link = wpjobportal::makeUrl(array('wpjobportalme'=>'multiresume', 'wpjobportallt'=>'myresumes','wpjobportalpageid' =>wpjobportal::getPageid()));
            }else{
                $link = wpjobportal::makeUrl(array('wpjobportalme'=>'resume', 'wpjobportallt'=>'myresumes','wpjobportalpageid' =>wpjobportal::getPageid()));
            }
            ?>
            <div class="wpjp-bottom-action-link">
                <a class="wpjp-action-link" href="<?php echo esc_url($link); ?>">
                    <?php echo __('Cancel Payment', 'wp-job-portal'); ?>
                </a>
                <button type="button" class="wpjobportal-property-list-fw-action-btn-link wpjobportal-prop-view-btn" id="proceedPaymentBtn">
                    <?php echo esc_html(__('Proceed To Payment','wp-job-portal')); ?>
                </button>
            </div>
        <?php
         }
        ?>
</div>


