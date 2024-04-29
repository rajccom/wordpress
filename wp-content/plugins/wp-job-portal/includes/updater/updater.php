<?php

if (!defined('ABSPATH'))
    die('Restricted Access');

include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
// check for plugin using plugin name
if (is_plugin_active('wp-job-portal/wp-job-portal.php')) {
	$query = "SELECT * FROM `".wpjobportal::$_db->prefix."wj_portal_config` WHERE configname = 'versioncode' OR configname = 'last_version' OR configname = 'last_step_updater'";
	$result = wpjobportal::$_db->get_results($query);
	$config = array();
	foreach($result AS $rs){
		$config[$rs->configname] = $rs->configvalue;
	}
	$config['versioncode'] = wpjobportalphplib::wpJP_str_replace('.', '', $config['versioncode']);
	if(!empty($config['last_version']) && $config['last_version'] != '' && $config['last_version'] < $config['versioncode']){
		$last_version = $config['last_version'] + 1; // files execute from the next version
		$currentversion = $config['versioncode'];
		for($i = $last_version; $i <= $currentversion; $i++){
			$path = WPJOBPORTAL_PLUGIN_PATH.'includes/updater/files/'.$i.'.php';
			if(file_exists($path)){
				include_once($path);
			}
		}
	}
	$mainfile = WPJOBPORTAL_PLUGIN_PATH.'wp-job-portal.php';
	$contents = file_get_contents($mainfile);
	$contents = wpjobportalphplib::wpJP_str_replace("include_once 'includes/updater/updater.php';", '', $contents);
	file_put_contents($mainfile, $contents);

	function recursiveremove($dir) {
		$structure = glob(rtrim($dir, "/").'/*');
		if (is_array($structure)) {
			foreach($structure as $file) {
				if (is_dir($file)) recursiveremove($file);
				elseif (is_file($file)) unlink($file);
			}
		}
		rmdir($dir);
	}            	
	$dir = WPJOBPORTAL_PLUGIN_PATH.'includes/updater';
	recursiveremove($dir);

}



?>
