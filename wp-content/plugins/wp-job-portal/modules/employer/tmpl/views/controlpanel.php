<?php
switch ($layouts) {
	case 'logo':

		$profile=isset(wpjobportal::$_data[0]['company']['emp_profile']) ? wpjobportal::$_data
			[0]['company']['emp_profile'] : null;
		$comp_name=isset(wpjobportal::$_data[0]['companies'][0]) ? wpjobportal::$_data[0]['companies'][0] : null;
		if (isset($profile) && $profile->photo != '' ) {
			$wpdir = wp_upload_dir();
			
			$data_directory = wpjobportal::$_config->getConfigurationByConfigName('data_directory');
			$img = $wpdir['baseurl'] . '/' . $data_directory . '/data/profile/profile_' . wpjobportal::$_data[0]['company']['emp_profile']->uid . '/profile/' . wpjobportal::$_data[0]['company']['emp_profile']->photo;
		} else {
			$img = WPJOBPORTAL_PLUGIN_URL . 'includes/images/users-b.png';
		}
		echo '
			<div class="wjportal-user-logo">
        	 	<img src='. esc_url($img) .' alt="'.__("User image","wp-job-portal").'" title="'.__("User image","wp-job-portal").'" class="wjportal-user-logo-image" />
        	</div> 
        ';
        if(isset($profile->first_name) && $profile->first_name != ''){
			echo '<div class="wjportal-user-name">
					'.  esc_html(__($profile->first_name,'wp-job-portal')).' '.esc_html(__($profile->last_name,'wp-job-portal')) .'
				</div>';
           	echo '<div class="wjportal-user-tagline">
           		'. esc_html(__($profile->emailaddress,'wp-job-portal')).'
           		</div>
        	';
        }
	break;
}
?>