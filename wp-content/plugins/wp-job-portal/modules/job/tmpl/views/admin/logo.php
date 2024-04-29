<?php
/**
* @param logo wp-job-portal
*/
$data_directory = WPJOBPORTALincluder::getJSModel('configuration')->getConfigurationByConfigName('data_directory');
?>
<?php
$html = '';
switch ($layout) {
	case 'logo':
		if (isset($job->logo) && $job->logo != '') {
	        $wpdir = wp_upload_dir();
	        $logo = $wpdir['baseurl'] . '/' . $data_directory.'/data/employer/comp_'.$job->companyid.'/logo/'. $job->logo;
	    } else {
	        $logo = WPJOBPORTAL_PLUGIN_URL . '/includes/images/default_logo.png';
	    }
		$html.= '<div class="wpjobportal-jobs-logo">
					<a href='. admin_url('admin.php?page=wpjobportal_job&wpjobportallt=formjob&wpjobportalid='.$job->id).'>
						<img src='.$logo.' alt='.__("logo","wp-job-portal").'>
					</a>
				</div>';
		break;
	case 'que-logo':
	 if ($job->logofilename != "") {
                    $data_directory = WPJOBPORTALincluder::getJSModel('configuration')->getConfigurationByConfigName('data_directory');
                    $wpdir = wp_upload_dir();
                    $path = $wpdir['baseurl'] . '/' . $data_directory . '/data/employer/comp_' . $job->companyid . '/logo/' . $job->logofilename;
                } else {
                    $path = WPJOBPORTAL_PLUGIN_URL . '/includes/images/default_logo.png';
                }
		$html.='<div class="wpjobportal-jobs-logo">
                    <a href='. admin_url('admin.php?page=wpjobportal_job&wpjobportallt=formjob&wpjobportalid='.$job->id.'&isqueue=1').'>
                    	<img src='.$path.' alt='.__("logo","wp-job-portal").'>
                    </a>
                </div>';
		break;

	default:

		break;
}
echo wp_kses($html, WPJOBPORTAL_ALLOWED_TAGS);

?>
