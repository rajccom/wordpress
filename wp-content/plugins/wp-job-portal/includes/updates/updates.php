<?php

if (!defined('ABSPATH'))
    die('Restricted Access');

class WPJOBPORTALupdates {

    static function checkUpdates($cversion=null) {
        if (is_null($cversion)) {
            $cversion = wpjobportal::$_currentversion;
        }
        $installedversion = WPJOBPORTALupdates::getInstalledVersion();
        if ($installedversion != $cversion) {
            $query = "REPLACE INTO `".wpjobportal::$_db->prefix."wj_portal_config` (`configname`, `configvalue`, `configfor`) VALUES ('last_version','','default');";
            wpjobportal::$_db->query($query); //old actual
            /*wpjobportal::$_db->show_errors(false);
            @wpjobportal::$_db->query($query);          */
            $query = "SELECT configvalue FROM `".wpjobportal::$_db->prefix."wj_portal_config` WHERE configname='versioncode'";
            $versioncode = wpjobportal::$_db->get_var($query);
            $versioncode = wpjobportalphplib::wpJP_str_replace('.','',$versioncode);
            $query = "UPDATE `".wpjobportal::$_db->prefix."wj_portal_config` SET configvalue = '".$versioncode."' WHERE configname = 'last_version';";
            wpjobportal::$_db->query($query);
            $from = $installedversion + 1;
            $to = $cversion;
            for ($i = $from; $i <= $to; $i++) {
                $installfile = WPJOBPORTAL_PLUGIN_PATH . 'includes/updates/sql/' . $i . '.sql';
                if (file_exists($installfile)) {
                    $delimiter = ';';
                    $file = fopen($installfile, 'r');
                    if (is_resource($file) === true) {
                        $query = array();
                        while (feof($file) === false) {
                            $query[] = fgets($file);
                            if (preg_match('~' . preg_quote($delimiter, '~') . '\s*$~iS', end($query)) === 1) {
                                $query = trim(implode('', $query));
                                $query = wpjobportalphplib::wpJP_str_replace("#__", wpjobportal::$_db->prefix, $query);
                                if (!empty($query)) {
                                    wpjobportal::$_db->query($query);
                                }
                            }
                            if (is_string($query) === true) {
                                $query = array();
                            }
                        }
                        fclose($file);
                    }
                }
            }
        }
    }

    static function getInstalledVersion() {
        $query = "SELECT configvalue FROM `" . wpjobportal::$_db->prefix . "wj_portal_config` WHERE configname = 'versioncode'";
        $version = wpjobportal::$_db->get_var($query);
        if (!$version)
            $version = '100';
        else
            $version = wpjobportalphplib::wpJP_str_replace('.', '', $version);
        return $version;
    }

}

?>
