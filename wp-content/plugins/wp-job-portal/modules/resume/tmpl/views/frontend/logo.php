<?php
/**
 * @param WPJOB PORTAL
 * @param Logo 
 */
?>

<?php
$wpdir = wp_upload_dir();
if (isset($myresume->photo) && $myresume->photo != "") {
    $data_directory = wpjobportal::$_config->getConfigurationByConfigName('data_directory');
    $photourl = $wpdir['baseurl'] . '/' . $data_directory . '/data/jobseeker/resume_' . $myresume->id . '/photo/' . $myresume->photo;
} else {
    $photourl = WPJOBPORTAL_PLUGIN_URL . '/includes/images/users.png';
}

    $url = wpjobportal::makeUrl(array('wpjobportalme'=>'resume', 'wpjobportallt'=>'viewresume', 'wpjobportalid'=>$myresume->id, 'wpjobportalpageid'=>wpjobportal::getPageid()));
?>
    <div class="wjportal-resume-logo">
        <span class="fir">
            <a href="<?php echo esc_url($url); ?>">
                <img  src="<?php echo esc_url($photourl); ?>" />
            </a>
        </span>
    </div>