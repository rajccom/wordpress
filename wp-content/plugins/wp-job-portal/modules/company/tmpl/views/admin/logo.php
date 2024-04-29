<?php
/**
* @param WP JOB PORTAL
*/
?>
<?php
switch ($layout) {
	case 'que-logo':
		if ($company->logofilename != "") {
		    $data_directory = WPJOBPORTALincluder::getJSModel('configuration')->getConfigurationByConfigName('data_directory');
		    $wpdir = wp_upload_dir();
		    $path = $wpdir['baseurl'] .'/'. $data_directory . '/data/employer/comp_' . $company->id . '/logo/' . $company->logofilename;
		} else {
		    $path = WPJOBPORTAL_PLUGIN_URL . '/includes/images/default_logo.png';
		}
		echo '<div class="wpjobportal-company-logo">';
		echo '	<a href='.admin_url('admin.php?page=wpjobportal_company&wpjobportallt=formcompany&wpjobportalid='.$company->id).'&isqueue=1 title='.__("logo","wp-job-portal").'>
					<img src='. esc_url($path).' alt='.__("logo","wp-job-portal").'>
				</a>
				<div class="wpjobportal-company-crt-date">
					'.esc_html(date_i18n(wpjobportal::$_configuration['date_format'], strtotime($company->created))).'
				</div>
			</div>';
		
		break;
	case 'comp-logo':
		$wpdir = wp_upload_dir();
			if ($company->logofilename != "") {
	            $data_directory = WPJOBPORTALincluder::getJSModel('configuration')->getConfigurationByConfigName('data_directory');
            $path = $wpdir['baseurl'] . '/' . $data_directory . '/data/employer/comp_' . $company->id . '/logo/' . $company->logofilename;
        } else {
            $path = WPJOBPORTAL_PLUGIN_URL . '/includes/images/default_logo.png';
        }
        echo '<div class="wpjobportal-company-logo">
                	<a href='.admin_url('admin.php?page=wpjobportal_company&wpjobportallt=formcompany&wpjobportalid='.$company->id).' title='.__("logo","wp-job-portal").'>
                		<img src='.esc_url($path).' alt='.__("logo","wp-job-portal").'>
                	</a>
                	<div class="wpjobportal-company-crt-date">
                		'.esc_html(date_i18n(wpjobportal::$_configuration['date_format'], strtotime($company->created))).'
                	</div>
                </div>';
		break;
}


