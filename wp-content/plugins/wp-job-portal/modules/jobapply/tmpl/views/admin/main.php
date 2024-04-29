<?php
/**
* @param Object--refrence
*/
?>
<?php
	switch ($layout) {
		case 'logo':
			$photo = '';
			if (isset($data->photo) && $data->photo != '') {
				$data_directory = WPJOBPORTALincluder::getJSModel('configuration')->getConfigurationByConfigName('data_directory');
				$wpdir = wp_upload_dir();
				$photo = $wpdir['baseurl'] . '/' . $data_directory . '/data/jobseeker/resume_' . $data->resumeid . '/photo/' . $data->photo;
				$padding = "";
			} else {
				$photo = WPJOBPORTAL_PLUGIN_URL . '/includes/images/users.png';
				$padding = ' style="padding:15px;" ';
			}
			?>
			<div class="wpjobportal-resume-logo">
            	<img src="<?php echo esc_url($photo); ?>" alt="<?php echo __('logo','wp-job-portal'); ?>" />
                <div class="wpjobportal-resume-crt-date">
                    <?php echo esc_html(date_i18n(wpjobportal::$_configuration['date_format'], strtotime($data->apply_date))); ?>
                </div>
            </div>
            <?php
		break;
    	case 'detail':
    	    if(isset($data->socialprofile)){
                $socialprofile = json_decode($data->socialprofile); 
            }
            if(isset($socialprofile)){
                $data->first_name = isset($data->first_name) ? $data->first_name : $socialprofile->first_name; 
                $data->last_name = isset($data->last_name) ? $data->last_name : $socialprofile->last_name;
                $data->applicationtitle = isset($data->applicationtitle) ? $data->applicationtitle : $socialprofile->email;
            }
    		?>
			<div class="wpjobportal-resume-cnt-wrp">
                <div class="wpjobportal-resume-middle-wrp">
                    <div class="wpjobportal-resume-data">
                        <span class="wpjobportal-resume-job-type" style="background: <?php echo esc_attr($data->jobtypecolor); ?>;">
                            <?php echo __(esc_html($data->jobtypetitle),'wp-job-portal'); ?>
                        </span>
                    </div>    
                    <div class="wpjobportal-resume-data">
                        <span class="wpjobportal-resume-name">
                            <?php echo esc_html($data->first_name) . " " . esc_html($data->last_name) ?>
                        </span>
                    </div>
                    <div class="wpjobportal-resume-data">
                        <span class="wpjobportal-resume-title">
                            <?php echo esc_html($data->applicationtitle); ?>
                        </span>
                    </div>
                    <div class="wpjobportal-resume-data">
                        <div class="wpjobportal-resume-data-text">
                            <span class="wpjobportal-resume-data-title">
                                <?php echo __('Desired Salary').' : '; ?>
                            </span>
                            <span class="wpjobportal-resume-data-value">
                                <?php echo esc_html($data->salary); ?>
                            </span>
                        </div>
                        <?php if(in_array('advanceresumebuilder', wpjobportal::$_active_addons)){ ?>
                            <div class="wpjobportal-resume-data-text">
                                <span class="wpjobportal-resume-data-title">
                                    <?php echo __('Total Experience', 'wp-job-portal') . ' :'; ?>
                                </span>
                                <span class="wpjobportal-resume-data-value">
                                    <?php echo esc_html(wpjobportal::$_common->getTotalExp($data->resumeid)); ?>
                                </span>
                            </div>
                            <div class="wpjobportal-resume-data-text">
                                <span class="wpjobportal-resume-data-title">
                                    <?php echo __('Location', 'wp-job-portal') . ' : '; ?>
                                </span>
                                <span class="wpjobportal-resume-data-value">
                                    <?php echo esc_html($data->location); ?>
                                </span>
                            </div>
                        <?php } else {?>
                            <div class="wpjobportal-resume-data-text">
                                <span class="wpjobportal-resume-data-title">
                                    <?php echo __('Category', 'wp-job-portal') . ' : '; ?>
                                </span>
                                <span class="wpjobportal-resume-data-value">
                                    <?php echo esc_html($data->cat_title); ?>
                                </span>
                            </div>
                            <div class="wpjobportal-resume-data-text">
                                <span class="wpjobportal-resume-data-title">
                                    <?php echo __('Type', 'wp-job-portal') . ' : '; ?>
                                </span>
                                <span class="wpjobportal-resume-data-value">
                                    <?php echo esc_html($data->jobtypetitle); ?>
                                </span>
                            </div>
                        <?php } ?>
                    </div>
                    <?php do_action('wpjobportal_addon_search_applied_resume'); ?>
                </div>
                <div class="wpjobportal-resume-right-wrp">
                    <?php do_action('wpjobportal_addons_rating_resume_applied',$data); ?>
                    <?php  do_action('wpjobportal_addons_credit_applied_resume_ratting_admin',$data); ?>
                    <?php
                        if(in_array('coverletter', wpjobportal::$_active_addons)){
                                 $cover_letter_title = '';
                                 $cover_letter_desc = '';
                                 if( isset($data->coverletterdata) && !empty($data->coverletterdata) ){

                                     $cover_letter_title = $data->coverletterdata->title;
                                     $cover_letter_desc = $data->coverletterdata->description;
                                 }
                                if(isset($data->coverletterid) && is_numeric($data->coverletterid) && $data->coverletterid > 0){
                                     echo '<div id="cover_letter_data_title_'.$data->coverletterid.'" style="display:none;" >'.$cover_letter_title.'</div>';
                                     echo '<div id="cover_letter_data_desc_'.$data->coverletterid.'" style="display:none;" >'.$cover_letter_desc.'</div>';

                                     echo '
                                     <a class="wpjobportal-viewcover-act-btn" href="#" onClick="showCoverLetterData('.$data->coverletterid.')" title='. __('view coverletter', 'wp-job-portal') .'>
                                         '. __('View Cover Letter', 'wp-job-portal') .'
                                     </a>';
                                }else{
                                    echo '
                                    <span class="wjportal-no-coverletter-btn">
                                        '. __('No Cover Letter', 'wp-job-portal') .'
                                    </span>';
                                }
                           }?>
                </div>
            </div>
            <div id="<?php echo esc_attr($data->appid); ?>" ></div>
            <div id="comments" class="wpjobportal-applied-job-actions-popup <?php echo esc_attr($data->appid); ?>" ></div>
            <?php
		break;
    }
?>
