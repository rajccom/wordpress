<?php
/**
 * @param job      job object - optional
 */
?>
<?php
	switch ($layout) {
		case 'toprowlogo':
		if ($job->logofilename != "") {
            $wpdir = wp_upload_dir();
            $data_directory = WPJOBPORTALincluder::getJSModel('configuration')->getConfigurationByConfigName('data_directory');
            $path = $wpdir['baseurl'] . '/' . $data_directory . '/data/employer/comp_' . $job->companyid . '/logo/' . $job->logofilename;
        } else {
            $path = WPJOBPORTAL_PLUGIN_URL . '/includes/images/default_logo.png';
        }
        if(in_array('multicompany', wpjobportal::$_active_addons)){
        	$url = "multicompany";
        }else{
        	$url = "company";
        }
			echo '<div class="wjportal-jobs-logo">
                    <a href='. esc_url(wpjobportal::makeUrl(array('wpjobportalme'=>$url, 'wpjobportallt'=>'viewcompany', 'wpjobportalid'=>$job->companyid))) .'>
                        <img src='. esc_url($path) .' alt="'.__('Company logo','wp-job-portal').'" />
                    </a>
                </div>
				';
			break;
		case 'logo':
			echo ' <div class="wjportal-job-company-logo">
	                    <img class="wjportal-job-company-logo-image" src='. esc_url(WPJOBPORTALincluder::getJSModel('company')->getLogoUrl($job->companyid,$job->logofilename)) .'  alt="'.__('Company logo','wp-job-portal').'">
	                </div>';
			break;
	}
?>

