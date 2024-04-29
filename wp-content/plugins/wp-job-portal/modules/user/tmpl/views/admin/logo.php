<?php
/**
* @param wp job portal Logo
*/
?>
<?php
$html = '';
switch ($layout) {
	case 'userlogo':
		$photo = '';
		if (isset($user->photo) && $user->photo != '') {
		    $wpdir = wp_upload_dir();
		    $data_directory = WPJOBPORTALincluder::getJSModel('configuration')->getConfigurationByConfigName('data_directory');
		    $photo = $wpdir['baseurl'] . '/' . $data_directory . '/data/profile/profile_' . $user->uid . '/profile/' . $user->photo;
		    $padding = "";
		} else {
		    $photo = WPJOBPORTAL_PLUGIN_URL . '/includes/images/users.png';
		    $padding = '';
		}
		$html.= '<div class="wpjobportal-user-logo">
                    <a href='. admin_url('admin.php?page=wpjobportal_user&wpjobportallt=userdetail&id='.$user->id).'>
                    	<img src='. $photo .' '. $padding .' alt='.__("logo","wp-job-portal").'>
                    </a>
                </div>';
		break;
}
echo wp_kses($html, WPJOBPORTAL_ALLOWED_TAGS);
