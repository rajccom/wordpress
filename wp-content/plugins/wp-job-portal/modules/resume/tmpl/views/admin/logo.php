<?php
/**
 * @param job      job object - optional
*/
?>
<?php
	$data_directory = WPJOBPORTALincluder::getJSModel('configuration')->getConfigurationByConfigName('data_directory');
	if (isset($resume->photo) && $resume->photo != '') {
	    $wpdir = wp_upload_dir();
	    $photo = $wpdir['baseurl'] . '/' . $data_directory . '/data/jobseeker/resume_' . $resume->id. '/photo/' . $resume->photo;
	} else {
	    $photo = WPJOBPORTAL_PLUGIN_URL . '/includes/images/users.png';
	}
?>

<?php echo wp_kses($resumeque, WPJOBPORTAL_ALLOWED_TAGS) ?>
    
		<a href="<?php echo esc_url(admin_url('admin.php?page=wpjobportal_resume&wpjobportallt=formresume&wpjobportalid='.$resume->id)); ?>">
			<img src="<?php echo esc_url($photo); ?>" alt="<?php echo __('logo','wp-job-portal'); ?>" />
		</a>
		<div class="wpjobportal-resume-crt-date">
			<?php echo esc_html(date_i18n(wpjobportal::$_configuration['date_format'], strtotime($resume->created))); ?>
		</div>
	</div>
