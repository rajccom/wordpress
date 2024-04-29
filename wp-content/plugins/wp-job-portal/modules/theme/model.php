<?php

if (!defined('ABSPATH'))
    die('Restricted Access');

class WPJOBPORTALthemeModel {
    function getCurrentTheme() {
        $filepath = WPJOBPORTAL_PLUGIN_PATH . 'includes/css/style_color.php';
        $filestring = file_get_contents($filepath);
        $theme['color1'] = $this->getColorCode($filestring, 1);
        $theme['color2'] = $this->getColorCode($filestring, 2);
        $theme['color3'] = $this->getColorCode($filestring, 3);
        $theme['color4'] = $this->getColorCode($filestring, 4);
        $theme['color5'] = $this->getColorCode($filestring, 5);
        $theme['color6'] = $this->getColorCode($filestring, 6);
        $theme['color7'] = $this->getColorCode($filestring, 7);
        $theme['color8'] = $this->getColorCode($filestring, 8);
        wpjobportal::$_data[0] = $theme;
        return $theme;
    }

    function storeTheme($data) {

        if (empty($data))
            return false;
        $filepath = WPJOBPORTAL_PLUGIN_PATH . 'includes/css/style_color.php';
        $filestring = file_get_contents($filepath);
        $this->replaceString($filestring, 1, $data);
        $this->replaceString($filestring, 2, $data);
        $this->replaceString($filestring, 3, $data);
        /*$this->replaceString($filestring, 4, $data);
        $this->replaceString($filestring, 5, $data);
        $this->replaceString($filestring, 6, $data);
        $this->replaceString($filestring, 7, $data);
        $this->replaceString($filestring, 8, $data);*/
        if (file_put_contents($filepath, $filestring)) {
            update_option('wpjp_set_theme_colors', json_encode($data));
            $color = require(WPJOBPORTAL_PLUGIN_PATH . 'includes/css/style_color.php');
            $file = fopen(WPJOBPORTAL_PLUGIN_PATH . 'includes/css/color.css','w');
            fwrite($file,$color);  
            fclose($file);
            
            return WPJOBPORTAL_SAVED;
        } else {
            return WPJOBPORTAL_SAVE_ERROR;
        }
    }

    function getColorCode($filestring, $colorNo) {
        if (wpjobportalphplib::wpJP_strstr($filestring, '$color' . $colorNo)) {
            $path1 = wpjobportalphplib::wpJP_strpos($filestring, '$color' . $colorNo);
            $path1 = wpjobportalphplib::wpJP_strpos($filestring, '#', $path1);
            $path2 = wpjobportalphplib::wpJP_strpos($filestring, ';', $path1);
            $colorcode = wpjobportalphplib::wpJP_substr($filestring, $path1, $path2 - $path1 - 1);
            return $colorcode;
        }
    }

      function replaceString(&$filestring, $colorNo, $data) {
        if (wpjobportalphplib::wpJP_strstr($filestring, '$color' . $colorNo)) {
            $path1 = wpjobportalphplib::wpJP_strpos($filestring, '$color' . $colorNo);
            $path2 = wpjobportalphplib::wpJP_strpos($filestring, ';', $path1);
            $filestring = substr_replace($filestring, '$color' . $colorNo . ' = "' . $data['color' . $colorNo] . '";', $path1, $path2 - $path1 + 1);
        }
    }

}

?>
