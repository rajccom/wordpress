<?php

/**
 * @package WP JOB PORTAL
 * @author Ahmad Bilal
 * @version 2.0.1
 */
/*
  * Plugin Name: WP Job Portal
  * Plugin URI: https://wpjobportal.com/
  * Description: WP JOB PORTAL is Word Press best job board plugin. It is easy to use and highly configurable. It fully accommodates job seekers and employers.
  * Author: WP Job Portal
  * Version: 2.0.1
  * Text Domain: wp-job-portal
  * Domain Path: /languages
  * Author URI: https://wpjobportal.com/
 */

if (!defined('ABSPATH'))
    die('Restricted Access');

class wpjobportal {

    public static $_path;
    public static $_pluginpath;
    public static $_data; /* data[0] for list , data[1] for total paginition ,data[2] fieldsorderring , data[3] userfield for form , data[4] for reply , data[5] for ticket history  , data[6] for internal notes  , data[7] for ban email  , data['ticket_attachment'] for attachment */
    public static $_pageid;
    public static $_db;
    public static $_configuration;
    public static $_sorton;
    public static $_sortorder;
    public static $_ordering;
    public static $_sortlinks;
    public static $_msg;
    public static $_error_flag;
    public static $_error_flag_message;
    public static $_currentversion;
    public static $_active_addons;
    public static $_addon_query;
    public static $_error_flag_message_for;
    public static $_error_flag_message_for_link;
    public static $_error_flag_message_for_link_text;
    public static $_error_flag_message_register_for;
    public static $theme_chk;
    public static $theme_chk_flag;
    public static $_common;
    public static $_config;
    public static $_wpjppurchasehistory;
    public static $_wpjppaymentconfig;
    public static $_wpjpfieldordering;
    public static $_wpjpcustomfield;
    public static $_wpjpcompany;
    //public static $_wpjpmodalpath;
    public static $_wpprefixforuser;
    public static $_iswpjobportalplugin;
    public static $_search;
    public static $_captcha;
    public static $_jsjpsession;

    function __construct() {
        self::includes();
        $plugin_array = get_option('active_plugins');
        $addon_array = array();
        foreach ($plugin_array as $key => $value) {
            $plugin_name = pathinfo($value, PATHINFO_FILENAME);
            if(wpjobportalphplib::wpJP_strstr($plugin_name, 'wp-job-portal-')){
                $addon_array[] = wpjobportalphplib::wpJP_str_replace('wp-job-portal-', '', $plugin_name);
            }
        }
        self::$_active_addons = $addon_array;
        self::$_wpjpcustomfield = WPJOBPORTALincluder::getObjectClass('customfields');
        //  self::registeractions();
        self::$_path = plugin_dir_path(__FILE__);
        self::$_pluginpath = plugins_url('/', __FILE__);
        self::$_data = array();
        self::$_error_flag = null;
        self::$_error_flag_message = null;
        self::$_currentversion = '201';
        self::$_addon_query = array('select'=>'','join'=>'','where'=>'');
        self::$_common = WPJOBPORTALincluder::getJSModel('common');
        self::$_config = WPJOBPORTALincluder::getJSModel('configuration');
        self::$_wpjpfieldordering = WPJOBPORTALincluder::getJSModel('fieldordering');
        self::$_iswpjobportalplugin = true;
        self::$_jsjpsession = WPJOBPORTALincluder::getObjectClass('wpjpsession');
        if(in_array('credits', wpjobportal::$_active_addons)){
            self::$_wpjppurchasehistory = WPJOBPORTALincluder::getJSModel('purchasehistory');
            self::$_wpjppaymentconfig = WPJOBPORTALincluder::getJSModel('paymentmethodconfiguration');
        }
        if(in_array('multicompany', wpjobportal::$_active_addons)){
            self::$_wpjpcompany = WPJOBPORTALincluder::getJSModel('multicompany');
        }else{
            self::$_wpjpcompany = WPJOBPORTALincluder::getJSModel('company');
        }
        global $wpdb;
        self::$_db = $wpdb;
        if(is_multisite()) {
            self::$_wpprefixforuser = $wpdb->base_prefix;
        }else{
            self::$_wpprefixforuser = self::$_db->prefix;
        }
        WPJOBPORTALincluder::getJSModel('configuration')->getConfiguration();
        register_activation_hook(__FILE__, array($this, 'wpjobportal_activate'));
        register_deactivation_hook(__FILE__, array($this, 'wpjobportal_deactivate'));
        if(version_compare(get_bloginfo('version'),'5.1', '>=')){ //for wp version >= 5.1
            add_action('wp_insert_site', array($this, 'wpjobportal_new_site')); //when new site is added in multisite
        }else{ //for wp version < 5.1
            add_action('wpmu_new_blog', array($this, 'wpjobportal_new_blog'), 10, 6);
        }
        add_filter('wpmu_drop_tables', array($this, 'wpjobportal_delete_site'));
        add_action('plugins_loaded', array($this, 'load_plugin_textdomain'));
        //PDF Change
        //add_action('template_redirect', array($this, 'pdf'), 5); // Only for the pdf in wordpress
        add_action('admin_init', array($this, 'wpjobportal_activation_redirect'));//for post installation screens
        add_action('wpjobportal_cronjobs_action', array($this,'wpjobportal_cronjobs'));
        add_action('reset_wpjobportal_aadon_query', array($this,'reset_wpjobportal_aadon_query') );
        $theme_chk = 0;
        $theme_chk_flag = 0;
        $theme = get_option( 'template' );
        if($theme == 'job-portal'){
            $theme_chk_flag = 1;
            $theme_chk = 1;
        }
        define( 'WPJOBPORTAL_IMAGE', self::$_pluginpath . 'includes/images' );
        self::$theme_chk = $theme_chk;
        self::$theme_chk_flag = $theme_chk_flag;

        add_action('admin_init', array($this,'jsjp_handle_search_form_data'));
        add_action('admin_init', array($this,'jsjp_handle_delete_cookies'));
        add_action('init', array($this,'jsjp_handle_search_form_data'));
        add_action( 'jsjp_delete_expire_session_data', array($this , 'jsjp_delete_expire_session_data') );
        if( !wp_next_scheduled( 'jsjp_delete_expire_session_data' ) ) {
            // Schedule the event
            wp_schedule_event( time(), 'daily', 'jsjp_delete_expire_session_data' );
        }
        add_filter('safe_style_css', array($this,'jsjp_safe_style_css'));
        add_action( 'upgrader_process_complete', array($this , 'jsjp_upgrade_completed'), 10, 2 );
        // code from advance custom fields addone
        add_filter('wpjobportal_addons_get_custom_field',array($this,'wpjobportal_addons_get_activeField'),10,4);
        add_filter('wpjobportal_addons_show_customfields_params',array($this,'wpjobportal_addons_paramsfields'),10,4);
        // job_manager_options global varible is intlized at the bottom of this file.
        // If seo plugin is activated
        if (is_plugin_active( 'all-in-one-seo-pack/all_in_one_seo_pack.php' ) ){
            add_filter( 'aioseo_disable_shortcode_parsing', '__return_true' );
        }
        // deactivate new block editor
        add_action( 'after_setup_theme', array($this , 'phi_theme_support'), 10, 2 );
    }
    // functions from advance custom fields addone
    function wpjobportal_addons_get_activeField($default_val,$id,$id1='',$id2=''){
        if($id1 == '' && $id2 == ''){
            return wpjobportal::$_wpjpcustomfield->userFieldsData($id);
        }elseif ($id1 != '' && $id2 == '') {
            return wpjobportal::$_wpjpcustomfield->userFieldsData($id,$id1);
        }elseif ($id1 != '' && $id2 != '') {
            return wpjobportal::$_wpjpcustomfield->userFieldsData($id,$id1,$id2);
        }
    }

    function wpjobportal_addons_paramsfields($default_val,$field,$id,$params){
        return wpjobportal::$_wpjpcustomfield->showCustomFields($field,$id,$params);
    }

    function phi_theme_support() {
        remove_theme_support( 'widgets-block-editor' );
    }

    function jsjp_upgrade_completed( $upgrader_object, $options ) {
        // The path to our plugin's main file
        $our_plugin = plugin_basename( __FILE__ );
        // If an update has taken place and the updated type is plugins and the plugins element exists
        if( $options['action'] == 'update' && $options['type'] == 'plugin' && isset( $options['plugins'] ) ) {
            // Iterate through the plugins being updated and check if ours is there
            foreach( $options['plugins'] as $plugin ) {
                if( $plugin == $our_plugin ) {
                	// restore colors data
                	$filepath = WPJOBPORTAL_PLUGIN_PATH . 'includes/css/style_color.php';
			        $filestring = file_get_contents($filepath);
			        $themedata = $this->getWPJPCurrentTheme();
			        if (!empty($themedata)) {
			            $this->WPJPreplaceString($filestring, 1, $themedata);
			            $this->WPJPreplaceString($filestring, 2, $themedata);
			            $this->WPJPreplaceString($filestring, 3, $themedata);
			            file_put_contents($filepath, $filestring);
						$color = require(WPJOBPORTAL_PLUGIN_PATH . 'includes/css/style_color.php');
						$file = fopen(WPJOBPORTAL_PLUGIN_PATH . 'includes/css/color.css','w');
						fwrite($file,$color);  
						fclose($file);
			        }
			        // restore colors data end
                    update_option('wpjp_currentversion', self::$_currentversion);
                    include_once WPJOBPORTAL_PLUGIN_PATH . 'includes/updates/updates.php';
                    WPJOBPORTALupdates::checkUpdates('201');
                }
            }
        }
    }

    function WPJPreplaceString(&$filestring, $colorNo, $data) {
        if (wpjobportalphplib::wpJP_strstr($filestring, '$color' . $colorNo)) {
            $path1 = wpjobportalphplib::wpJP_strpos($filestring, '$color' . $colorNo);
            $path2 = wpjobportalphplib::wpJP_strpos($filestring, ';', $path1);
            $filestring = substr_replace($filestring, '$color' . $colorNo . ' = "' . $data['color' . $colorNo] . '";', $path1, $path2 - $path1 + 1);
        }
    }

    function getWPJPCurrentTheme() {
        $optiondata = get_option('wpjp_set_theme_colors');
        $theme = array();
        if (!empty($optiondata)) {
            $filestring = json_decode($optiondata, true);
            $theme['color1'] = $filestring['color1'];
            $theme['color2'] = $filestring['color2'];
            $theme['color3'] = $filestring['color3'];
        }                                                    
        return $theme;
    }

    function wpjobportal_activation_redirect(){
        if (get_option('wpjobportal_do_activation_redirect') == true) {
            update_option('wpjobportal_do_activation_redirect',false);
            exit(wp_redirect(admin_url('admin.php?page=wpjobportal_postinstallation&wpjobportallt=stepone')));
        }
    }

    function wpjobportal_activate() {
        include_once 'includes/activation.php';
        WPJOBPORTALactivation::wpjobportal_activate();
		add_option('wpjobportal_do_activation_redirect', true);
    }

    function wpjobportal_deactivate() {
        include_once 'includes/deactivation.php';
        WPJOBPORTALdeactivation::wpjobportal_deactivate();
    }

    /*
     * Include the required files
     */

    function includes() {
        // php 8.1 issues
        require_once 'includes/wpjobportalphplib.php';
        if (is_admin()) {
            include_once 'includes/wpjobportaladmin.php';
        }
        include_once 'includes/wpjobportal-hooks.php';
        include_once 'includes/captcha.php';
        include_once 'includes/recaptchalib.php';
        include_once 'includes/layout.php';
        include_once 'includes/pagination.php';
        include_once 'includes/includer.php';
        include_once 'includes/formfield.php';
        include_once 'includes/request.php';
        include_once 'includes/wpjobportal-wc.php';
        include_once 'includes/formhandler.php';
        include_once 'includes/ajax.php';
        require_once 'includes/constants.php';
        require_once 'includes/messages.php';
        require_once 'includes/classes/class.upload.php';
        require_once 'includes/wpjobportaldb.php';
        include_once 'includes/shortcodes.php';
        include_once 'includes/paramregister.php';
        include_once 'includes/breadcrumbs.php';
        include_once 'includes/dashboardapi.php';
        //Widgets TO include
        include_once 'includes/widgets/searchjobs.php';
        // include_once 'includes/addon-updater/wpjobportalupdater.php';
        }

    /*
     * Localization
     */

    public function load_plugin_textdomain() {
        if(!load_plugin_textdomain('wp-job-portal')){
            load_plugin_textdomain('wp-job-portal', false, wpjobportalphplib::wpJP_dirname(plugin_basename(__FILE__)) . '/languages/');
        }else{
            load_plugin_textdomain('wp-job-portal');
        }
    }

    /*
     * function for the Style Sheets
     */

    static function addStyleSheets() {
        wp_enqueue_script('jquery');
        wp_enqueue_script('wpjobportal-commonjs', WPJOBPORTAL_PLUGIN_URL . 'includes/js/common.js');
        wp_enqueue_script('wpjobportal-res-tables', WPJOBPORTAL_PLUGIN_URL . 'includes/js/responsivetable.js');
        wp_enqueue_script('jquery-ui-accordion');
         wp_enqueue_style('wpjobportal-tokeninput', WPJOBPORTAL_PLUGIN_URL . 'includes/css/tokeninput.css');
        wp_enqueue_style('wpjobportal-fontawesome', 'https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');
        if(wpjobportal::$theme_chk == 1){
            $class_prefix = 'wpj-jp';
        }else{
            $class_prefix = 'wjportal';
        }
        wp_localize_script('wpjobportal-commonjs', 'common', array('ajaxurl' => admin_url('admin-ajax.php'),'insufficient_credits' => __('You have insufficient credits, you can not perform this action','wp-job-portal'),'theme_chk_prefix'=> $class_prefix,'theme_chk_number'=>wpjobportal::$theme_chk,'theme_chk_flag'=>wpjobportal::$theme_chk_flag, 'theme_image' => WPJOBPORTAL_IMAGE,'terms_conditions' => __('Please Accept Terms And Conditions So You Can Proceed','wp-job-portal')));

        wp_enqueue_script('wpjobportal-formvalidator', WPJOBPORTAL_PLUGIN_URL . 'includes/js/jquery.form-validator.js');
        if(wpjobportal::$theme_chk == 0 || wpjobportal::$_common->wpjp_isadmin()){
            wp_enqueue_script('wpjobportal-tokeninput', WPJOBPORTAL_PLUGIN_URL . 'includes/js/jquery.tokeninput.js');
        }else{
            # token  input For admin side
         wp_enqueue_script('wpjobportal-tokeninput', WPJOBPORTAL_PLUGIN_URL . 'includes/js/jquery.tokeninput.js');
        }
        wp_enqueue_script('chosen', WPJOBPORTAL_PLUGIN_URL . 'includes/js/chosen/chosen.jquery.min.js');
        // wp_enqueue_script('bootstrap-min', 'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js');
    }

    /*
     * function to get the pageid from the wpoptions
     */

    public static function getPageid() {
        if(wpjobportal::$_pageid != ''){
            return wpjobportal::$_pageid;
        }else{
            $pageid = WPJOBPORTALrequest::getVar('page_id','GET');
            if($pageid){
                return $pageid;
            }else{ // in case of categories popup
                $module = WPJOBPORTALrequest::getVar('wpjobportalme');
                if($module == 'category'){
                    $pageid = WPJOBPORTALrequest::getVar('page_id','POST');
                    if($pageid)
                        return $pageid;
                }
            }
            $id = 0;
            $pageid = wpjobportal::$_db->get_var("SELECT configvalue FROM `".wpjobportal::$_db->prefix."wj_portal_config` WHERE configname = 'default_pageid'");
            if ($pageid)
                $id = $pageid;
            return $id;
        }
    }

    public static function setPageID($id) {
        wpjobportal::$_pageid = $id;
    }

     function reset_wpjobportal_aadon_query(){
        wpjobportal::$_addon_query = array('select'=>'','join'=>'','where'=>'');
    }


    /*
     * function to parse the spaces in given string
     */

    public static function parseSpaces($string) {
        // php 8 issue for str_replce
        if($string == ''){
            return $string;
        }
        return wpjobportalphplib::wpJP_str_replace('%20', ' ', $string);
    }

    public static function tagfillin($string) {
        // php 8 issue for str_replce
        if($string == ''){
            return $string;
        }

        return wpjobportalphplib::wpJP_str_replace(' ', '_', $string);
    }

    public static function tagfillout($string) {
        // php 8 issue for str_replce
        if($string == ''){
            return $string;
        }
        return wpjobportalphplib::wpJP_str_replace('_', ' ', $string);
    }

    static function sanitizeData($data){
        if($data == null){
            return $data;
        }
        if(is_array($data)){
            return map_deep( $data, 'sanitize_text_field' );
        }else{
            return sanitize_text_field( $data );
        }
    }

    static function makeUrl($args = array()){
        global $wp_rewrite;
        $pageid = WPJOBPORTALrequest::getVar('wpjobportalpageid');

        if(is_numeric($pageid)){
            $permalink = get_the_permalink($pageid);
        }else{
            if(isset($args['wpjobportalpageid']) && is_numeric($args['wpjobportalpageid'])){
                $permalink = get_the_permalink($args['wpjobportalpageid']);
            }else{
                $permalink = get_the_permalink();
            }
        }
        if (!$wp_rewrite->using_permalinks()){
            if(!wpjobportalphplib::wpJP_strstr($permalink, 'page_id') && !wpjobportalphplib::wpJP_strstr($permalink, '?p=')) {
                //$page['page_id'] = get_option('page_on_front');
				$page['page_id'] = wpjobportal::$_db->get_var("SELECT configvalue FROM `".wpjobportal::$_db->prefix."wj_portal_config` WHERE configname = 'default_pageid'");
                $args = $page + $args;
            }
            $redirect_url = add_query_arg($args,$permalink);
            return $redirect_url;
        }

        if(isset($args['wpjobportalme']) && isset($args['wpjobportallt'])){
            // Get the original query parts
            $redirect = @parse_url($permalink);
            if (!isset($redirect['query']))
                $redirect['query'] = '';

            if(wpjobportalphplib::wpJP_strstr($permalink, '?')){ // if variable exist
                $redirect_array = wpjobportalphplib::wpJP_explode('?', $permalink);
                $_redirect = $redirect_array[0];
            }else{
                $_redirect = $permalink;
            }
            if($_redirect != ''){
                if($_redirect[wpjobportalphplib::wpJP_strlen($_redirect) - 1] == '/'){
                    $_redirect = wpjobportalphplib::wpJP_substr($_redirect, 0, wpjobportalphplib::wpJP_strlen($_redirect) - 1);
                }
            }
            // If is layout
            $changename = false;
            if(file_exists(WP_PLUGIN_DIR.'/js-vehicle-manager/js-vehicle-manager.php')){
                $changename = true;
            }
            if(file_exists(WP_PLUGIN_DIR.'/js-support-ticket/js-support-ticket.php')){
                $changename = true;
            }

            if(file_exists(WP_PLUGIN_DIR.'/js-jobs/js-jobs.php')){
                $changename = true;
            }

            if (isset($args['wpjobportallt'])) {
                $layout = '';
                ///echo $args['wpjobportallt'].'-';
                $layout = WPJOBPORTALincluder::getJSModel('slug')->getSlugFromFileName($args['wpjobportallt'],$args['wpjobportalme']);
                global $wp_rewrite;
                $slug_prefix = WPJOBPORTALincluder::getJSModel('configuration')->getConfigValue('home_slug_prefix');
                if($_redirect == site_url()){
                    $layout = $slug_prefix.$layout;
                }

                $_redirect .= '/' . $layout;
            }
            // If is jobid
            if (isset($args['jobid'])) {
                $_redirect .= '/' . $args['jobid'];
            }
            // If is list
            if (isset($args['list'])) {
                $_redirect .= '/' . $args['list'];
            }
            // If is wpjobportal_id
            if (isset($args['wpjobportalid'])) {
                $wpjobportal_id = $args['wpjobportalid'];
                //$layout = wpjobportalphplib::wpJP_str_replace('jm-', '', $layout);
                if($args['wpjobportallt'] == 'viewjob'){
                    $job_seo = WPJOBPORTALincluder::getJSModel('configuration')->getConfigValue('job_seo');
                    if(!empty($job_seo)){
                        $job_seo = WPJOBPORTALincluder::getJSModel('job')->makeJobSeo($job_seo , $wpjobportal_id);
                        if($job_seo != ''){
                            $id = WPJOBPORTALincluder::getJSModel('common')->parseID($wpjobportal_id);
                            $wpjobportal_id = $job_seo.'-'.$id;
                        }
                    }
                }elseif($args['wpjobportallt'] == 'viewcompany'){
                    $company_seo = WPJOBPORTALincluder::getJSModel('configuration')->getConfigValue('company_seo');
                    if(!empty($company_seo)){
                        $company_seo = WPJOBPORTALincluder::getJSModel('company')->makeCompanySeo($company_seo , $wpjobportal_id);
                        if($company_seo != ''){
                            $id = WPJOBPORTALincluder::getJSModel('common')->parseID($wpjobportal_id);
                            $wpjobportal_id = $company_seo.'-'.$id;
                        }
                    }
                }elseif($args['wpjobportallt'] == 'viewresume'){
                    $resume_seo = WPJOBPORTALincluder::getJSModel('configuration')->getConfigValue('resume_seo');
                    if(!empty($resume_seo)){
                        $resume_seo = WPJOBPORTALincluder::getJSModel('resume')->makeResumeSeo($resume_seo , $wpjobportal_id);
                        if($resume_seo != ''){
                            $id = WPJOBPORTALincluder::getJSModel('common')->parseID($wpjobportal_id);
                            $wpjobportal_id = $resume_seo.'-'.$id;
                        }
                    }
                }

                $_redirect .= '/' . $wpjobportal_id;
            }

            // If is ta
            if (isset($args['ta'])) {
                $_redirect .= '/' . $args['ta'];
            }
            // If is ta
            if (isset($args['viewtype'])) { // resume list or grid view
                $_redirect .= '/vt-' . $args['viewtype'];
            }
            // If is jsscid
            if (isset($args['jsscid'])) {
                $_redirect .= '/sc-' . $args['jsscid'];
            }
            // If is category
            if (isset($args['category'])) {
                $category = $args['category'];
                $array = wpjobportalphplib::wpJP_explode('-', $category);
                $count = count($array);
                $id = $array[$count - 1];
                unset($array[$count - 1]);
                $string = implode("-", $array);
                $finalstring = $string . '_10' . $id;
                $_redirect .= '/' . $finalstring;
            }
            // If is tags
            if (isset($args['tags'])) {
                $tags = $args['tags'];
                $finalstring = 'tags' . '_' . $tags;
                $_redirect .= '/' . $finalstring;
            }
            // If is jobtype
            if (isset($args['jobtype'])) {
                $jobtype = $args['jobtype'];
                $array = wpjobportalphplib::wpJP_explode('-', $jobtype);
                $count = count($array);
                $id = $array[$count - 1];
                unset($array[$count - 1]);
                $string = implode("-", $array);
                $finalstring = $string . '_11' . $id;
                $_redirect .= '/' . $finalstring;
            }
            // If is company
            if (isset($args['company'])) {
                $company = $args['company'];
                $array = wpjobportalphplib::wpJP_explode('-', $company);
                $count = count($array);
                $id = $array[$count - 1];
                unset($array[$count - 1]);
                $string = implode("-", $array);
                $finalstring = $string . '_12' . $id;
                $_redirect .='/' . $finalstring;
            }
            // If is search
            if (isset($args['search'])) {
                $search = $args['search'];
                $array = wpjobportalphplib::wpJP_explode('-', $search);
                $count = count($array);
                $id = $array[$count - 1];
                unset($array[$count - 1]);
                $string = implode("-", $array);
                $finalstring = $string . '_13' . $id;
                $_redirect .='/' . $finalstring;
            }
            // If is city
            if (isset($args['city'])) {
                $alias = WPJOBPORTALincluder::getJSModel('city')->getCityNamebyId($args['city']);
                $alias = WPJOBPORTALincluder::getJSModel('common')->removeSpecialCharacter($alias);
                $_redirect .= '/'.$alias.'_14' . $args['city'];
            }

            // If is sortby
            if (isset($args['sortby'])) {
                //$_redirect .= '/sortby-' . $args['sortby'];
                $_redirect .= '/' . $args['sortby'];
            }

            if(isset($args['userpackageid'])) {
                $_redirect .= '/package-' . $args['userpackageid'];
            }

            // login redirect
            if (isset($args['wpjobportalredirecturl'])) {
                //$_redirect .= '/sortby-' . $args['sortby'];
                $_redirect .= '/' . $args['wpjobportalredirecturl'];
            }
           return $_redirect;
        }else{ // incase of form
            $redirect_url = add_query_arg($args,$permalink);
            return $redirect_url;
        }

    }

    function wpjobportal_new_site($new_site){
        $pluginname = plugin_basename(__FILE__);
        if(is_plugin_active_for_network($pluginname)){
            include_once 'includes/activation.php';
            switch_to_blog($new_site->blog_id);
            WPJOBPORTALactivation::wpjobportal_activate();
            restore_current_blog();
        }
    }

    function wpjobportal_new_blog($blog_id, $user_id, $domain, $path, $site_id, $meta){
        $pluginname = plugin_basename(__FILE__);
        if(is_plugin_active_for_network($pluginname)){
            include_once 'includes/activation.php';
            switch_to_blog($blog_id);
            WPJOBPORTALactivation::wpjobportal_activate();
            restore_current_blog();
        }
    }

    function wpjobportal_delete_site($tables){
        include_once 'includes/deactivation.php';
        $tablestodrop = WPJOBPORTALdeactivation::wpjobportal_tables_to_drop();
        foreach($tablestodrop as $tablename){
            $tables[] = $tablename;
        }
        return $tables;
    }

    static function checkAddonActiveOrNot($for){
        if(in_array($for, wpjobportal::$_active_addons)){
            return true;
        }
        return false;
    }

    static function bjencode($array){
        return base64_encode(json_encode($array));
    }

    static function bjdecode($array){
        return json_decode(base64_decode($array));
    }

    static function redirectUrl($entityaction,$id=0){
        $isadmin = wpjobportal::$_common->wpjp_isadmin();
        if(wpjobportal::$_common->wpjp_isadmin()){
            switch($entityaction){
                case 'job.success':
                    $url = admin_url("admin.php?page=wpjobportal_job&wpjobportallt=jobs");
                break;
                case 'job.fail':
                    $url = admin_url("admin.php?page=wpjobportal_job&wpjobportallt=formjob");
                break;
                case 'company.success':
                    $url = admin_url("admin.php?page=wpjobportal_company");
                break;
                case 'company.fail':
                    $url = admin_url("admin.php?page=wpjobportal_company&wpjobportallt=formcompany");
                break;
                case 'resume.success':
                    $url = admin_url("admin.php?page=wpjobportal_resume");
                break;
                case 'resume.fail':
                    $url = admin_url("admin.php?page=wpjobportal_resume");
                break;
                default:
                    $url = null;
                break;
            }
        }else{
            switch($entityaction){
                case 'job.success':
                    if(WPJOBPORTALincluder::getObjectClass('user')->isguest()){
                        $pageid = WPJOBPORTALincluder::getJSModel('configuration')->getConfigValue('visitor_add_job_redirect_page');
                        $url = get_the_permalink($pageid);
                    }else{
                        $url = wpjobportal::makeUrl(array('wpjobportalme'=>'job', 'wpjobportallt'=>'myjobs'));
                    }
                break;
                case 'job.fail':
                    $url = wpjobportal::makeUrl(array('wpjobportalme'=>'job', 'wpjobportallt'=>'addjob'));
                break;
                case 'company.success':
                    if(in_array('credits', wpjobportal::$_active_addons)){
                        if(wpjobportal::$_config->getConfigValue('submission_type') == 2){
                            $url = apply_filters('wpjobportal_addons_credit_save_perlisting',false,wpjobportal::$_data['id'],'paycompany');
                        }else{
                            $url = wpjobportal::makeUrl(array('wpjobportalme'=>'company', 'wpjobportallt'=>'mycompanies'));
                        }
                    }else{
                        $url = wpjobportal::makeUrl(array('wpjobportalme'=>'company', 'wpjobportallt'=>'mycompanies'));
                    }
                break;
                case 'company.fail':
                    $url = wpjobportal::makeUrl(array('wpjobportalme'=>'company', 'wpjobportallt'=>'mycompanies'));
                break;
                case 'resume.success':
                    if(in_array('credits', wpjobportal::$_active_addons)){
                        if($submission_type == 2){
                            # perlisting Type
                            $url = apply_filters('wpjobportal_addons_credit_save_perlisting',false,wpjobportal::$_data['id'],'payresume');
                        }else{
                            $url = wpjobportal::makeUrl(array('wpjobportalme'=>'resume', 'wpjobportallt'=>'myresumes'));
                        }
                    }else{
                        $url = wpjobportal::makeUrl(array('wpjobportalme'=>'resume', 'wpjobportallt'=>'myresumes'));
                    }
                break;
                case 'resume.fail':
                    $url = wpjobportal::makeUrl(array('wpjobportalme'=>'resume', 'wpjobportallt'=>'addresume'));
                break;
                default:
                    $url = null;
                break;
            }
        }
        return $url;
    }

    public static function vueify($data){
        ?>
        <script id="wpjobportal-data" type="application/json"><?php echo json_encode(esc_html($data)); ?></script>
        <script type="text/javascript">
            var wpjobportaldata = {};
            try{
                var jsonString = document.getElementById("wpjobportal-data").innerHTML;
                wpjobportaldata = JSON.parse(jsonString);
            }catch(e){
                wpjobportaldata = {};
            }
        </script>
        <?php
    }

    function jsjp_handle_search_form_data(){
        WPJOBPORTALincluder::getObjectClass('handlesearchcookies');
    }

    function jsjp_safe_style_css(){
        $styles[] = 'display';
        $styles[] = 'color';
        $styles[] = 'width';
        $styles[] = 'max-width';
        $styles[] = 'min-width';
        $styles[] = 'height';
        $styles[] = 'min-height';
        $styles[] = 'max-height';
        $styles[] = 'background-color';
        $styles[] = 'border';
        $styles[] = 'border-bottom';
        $styles[] = 'border-top';
        $styles[] = 'border-left';
        $styles[] = 'border-right';
        $styles[] = 'border-color';
        $styles[] = 'padding';
        $styles[] = 'padding-top';
        $styles[] = 'padding-bottom';
        $styles[] = 'padding-left';
        $styles[] = 'padding-right';
        $styles[] = 'margin';
        $styles[] = 'margin-top';
        $styles[] = 'margin-bottom';
        $styles[] = 'margin-left';
        $styles[] = 'margin-right';
        $styles[] = 'background';
        $styles[] = 'font-weight';
        $styles[] = 'font-size';
        $styles[] = 'text-align';
        $styles[] = 'text-decoration';
        $styles[] = 'text-transform';
        $styles[] = 'line-height';
        $styles[] = 'visibility';
        $styles[] = 'cellspacing';
        $styles[] = 'data-id';
        $styles[] = 'cursor';
        $styles[] = 'vertical-align';
        $styles[] = 'float';
        $styles[] = 'position';
        $styles[] = 'left';
        $styles[] = 'right';
        $styles[] = 'bottom';
        $styles[] = 'top';
        $styles[] = 'z-index';
        $styles[] = 'overflow';
        return $styles;
    }

    function jsjp_handle_delete_cookies(){

        if(isset($_COOKIE['jsjp_addon_return_data'])){
            wpjobportalphplib::wpJP_setcookie('jsjp_addon_return_data' , '' , time() - 3600, COOKIEPATH);
            if ( SITECOOKIEPATH != COOKIEPATH ){
                wpjobportalphplib::wpJP_setcookie('jsjp_addon_return_data' , '' , time() - 3600, SITECOOKIEPATH);
            }
        }

        if(isset($_COOKIE['jsjp_addon_install_data'])){
            wpjobportalphplib::wpJP_setcookie('jsjp_addon_install_data' , '' , time() - 3600);
        }
    }

    public static function removeusersearchcookies(){
        if(isset($_COOKIE['jsjp_jobportal_search_data'])){
            wpjobportalphplib::wpJP_setcookie('jsjp_jobportal_search_data' , '' , time() - 3600 , COOKIEPATH);
            if ( SITECOOKIEPATH != COOKIEPATH ){
                wpjobportalphplib::wpJP_setcookie('jsjp_jobportal_search_data' , '' , time() - 3600 , SITECOOKIEPATH);
            }
        }
    }

    public static function setusersearchcookies($cookiesval , $jsjp_search_array){
        if(!$cookiesval)
            return false;
        $data = json_encode( $jsjp_search_array );
        $data = wpjobportalphplib::wpJP_safe_encoding($data);
        wpjobportalphplib::wpJP_setcookie('jsjp_jobportal_search_data' , $data , 0 , COOKIEPATH);
        if ( SITECOOKIEPATH != COOKIEPATH ){
            wpjobportalphplib::wpJP_setcookie('jsjp_jobportal_search_data' , $data , 0 , SITECOOKIEPATH);
        }
    }

    function jsjp_delete_expire_session_data(){
        global $wpdb;
        $wpdb->query('DELETE  FROM '.$wpdb->prefix.'wj_portal_jswjsessiondata WHERE sessionexpire < "'. time() .'"');
    }

}

$wpjobportal = new wpjobportal();
// lost your password link hook
add_action( 'login_form_bottom', 'wpjobportaladdLostPasswordLink' );
function wpjobportaladdLostPasswordLink() {
    if(wpjobportal::$theme_chk == 1){
        $class_prefix = 'wpj-jp-form';
    }else{
        $class_prefix = 'wjportal-form';
    }
   return '<a class="'.$class_prefix.'-lost-password" href="'.site_url().'/wp-login.php?action=lostpassword">'. __('Lost your password','wp-job-portal') .'?</a>';
}

add_action('init', 'wpjobportal_custom_init_session', 1);

function wpjobportal_custom_init_session() {
    if(isset($_COOKIE['wpjobportal_apply_visitor'])){
        $layout = WPJOBPORTALrequest::getVar('wpjobportallt');
        if($layout != null && $layout != 'addresume'){ // reset the session id
            wpjobportalphplib::wpJP_setcookie('wpjobportal_apply_visitor' , '' , time() - 3600 , COOKIEPATH);
            if ( SITECOOKIEPATH != COOKIEPATH ){
                wpjobportalphplib::wpJP_setcookie('wpjobportal_apply_visitor' , '' , time() - 3600 , SITECOOKIEPATH);
            }
        }
    }
    if(isset($_SESSION['wp-wpjobportal']) && isset($_SESSION['wp-wpjobportal']['resumeid'])){
       $layout = WPJOBPORTALrequest::getVar('wpjobportallt');
       if($layout != null && $layout != 'addresume'){ // reset the session id
           unset($_SESSION['wp-wpjobportal']);
       }
    }
}

function wpjobportal_register_plugin_styles(){
    wp_enqueue_script('jquery');
    if(wpjobportal::$theme_chk == 1){
        $class_prefix = 'wpj-jp';
    } else {
        $class_prefix = 'wjportal';
    }
    // vars are defined to support job hub and job manager with minimum changes to plugin code.
    wp_localize_script('wpjobportal-commonjs', 'common', array('ajaxurl' => admin_url('admin-ajax.php'),'insufficient_credits' => __('You have insufficient credits, you can not perform this action','wp-job-portal'),'theme_chk_prefix'=> $class_prefix,'theme_chk_number'=>wpjobportal::$theme_chk,'pluginurl'=>WPJOBPORTAL_PLUGIN_URL,'cityajaxurl' => admin_url("admin.php?page=wpjobportal_city&action=wpjobportaltask&task=getaddressdatabycityname"),'theme_chk_flag'=>wpjobportal::$theme_chk_flag, 'theme_image' => WPJOBPORTAL_IMAGE,'terms_conditions' => __('Please Accept Terms And Conditions So You Can Proceed','wp-job-portal') ));
    //include_once 'includes/css/style_color.php';
    wp_enqueue_style('wpjobportal-jobseeker-style', WPJOBPORTAL_PLUGIN_URL . 'includes/css/jobseekercp.css');
    wp_enqueue_style('wpjobportal-employer-style', WPJOBPORTAL_PLUGIN_URL . 'includes/css/employercp.css');
    wp_enqueue_style('wpjobportal-style', WPJOBPORTAL_PLUGIN_URL . 'includes/css/style.css');
    wp_enqueue_style('wpjobportal-color', WPJOBPORTAL_PLUGIN_URL . 'includes/css/color.css');
    wp_enqueue_style('wpjobportal-star-rating', WPJOBPORTAL_PLUGIN_URL . 'includes/css/wpjobportalrating.css');
    wp_enqueue_style('wpjobportal-style-tablet', WPJOBPORTAL_PLUGIN_URL . 'includes/css/style_tablet.css',array(),'','(max-width: 782px)');
    wp_enqueue_style('wpjobportal-style-mobile-landscape', WPJOBPORTAL_PLUGIN_URL . 'includes/css/style_mobile_landscape.css',array(),'','(max-width: 650px)');
    wp_enqueue_style('wpjobportal-style-mobile', WPJOBPORTAL_PLUGIN_URL . 'includes/css/style_mobile.css',array(),'','(max-width: 480px)');
    wp_enqueue_style('wpjobportal-chosen-style', WPJOBPORTAL_PLUGIN_URL . 'includes/js/chosen/chosen.min.css');
    if (is_rtl()) {
        wp_register_style('wpjobportal-style-rtl', WPJOBPORTAL_PLUGIN_URL . 'includes/css/stylertl.css');
        wp_enqueue_style('wpjobportal-style-rtl');
    }
    wp_enqueue_style('wpjobportal-css-ie', WPJOBPORTAL_PLUGIN_URL . 'includes/css/wpjobportal-ie.css');
    wp_style_add_data( 'wpjobportal-css-ie', 'conditional', 'IE' );
    //wp_enqueue_script('wpjobportal-vue.js','https://cdn.jsdelivr.net/npm/vue/dist/vue.js',array(),false,1);
    //wp_enqueue_script('wpjobportal-vue-components', WPJOBPORTALincluder::getComponentJsUrl('common'),array(),false,1);
}

add_action( 'wp_enqueue_scripts', 'wpjobportal_register_plugin_styles' );

function wpjobportal_admin_register_plugin_styles() {
    wp_enqueue_style('wpjobportal-admin-desktop-css', WPJOBPORTAL_PLUGIN_URL . 'includes/css/wpjobportaladmin_desktop.css',array(),'','all');
    wp_enqueue_style('wpjobportal-admin-tablet-css', WPJOBPORTAL_PLUGIN_URL . 'includes/css/wpjobportaladmin_tablet.css',array(),'','(min-width: 651px) and (max-width: 782px)');
    wp_enqueue_style('wpjobportal-admin-mobile-css', WPJOBPORTAL_PLUGIN_URL . 'includes/css/wpjobportaladmin_mobile.css',array(),'','(min-width: 481px) and (max-width: 650px)');
    wp_enqueue_style('wpjobportal-admin-oldmobile-css', WPJOBPORTAL_PLUGIN_URL . 'includes/css/wpjobportaladmin_oldmobile.css',array(),'','(max-width: 480px)');
    if (is_rtl()) {
        wp_register_style('wpjobportal-admincss-rtl', WPJOBPORTAL_PLUGIN_URL . 'includes/css/wpjobportaladmin_rtl.css');
        wp_enqueue_style('wpjobportal-admincss-rtl');
    }
}
add_action( 'admin_enqueue_scripts', 'wpjobportal_admin_register_plugin_styles' );

add_action( 'wp_head', 'add_wpjobportal_meta_tags' , 10 );
function add_wpjobportal_meta_tags(){

    $layout = WPJOBPORTALrequest::getVar('wpjobportallt');
    if($layout == 'viewjob' || $layout == 'viewresume'){
        $upid = WPJOBPORTALrequest::getVar('wpjobportalid');
        $id  = WPJOBPORTALincluder::getJSModel('common')->parseID($upid);
        if(is_numeric($id) && $id > 0){
            if($layout == 'viewjob'){
                $query = "SELECT job.tags,job.metakeywords
                    FROM `" . wpjobportal::$_db->prefix . "wj_portal_jobs` AS job
                    WHERE job.id = " . $id;
                $data = wpjobportaldb::get_row($query);
                if($data != ''){
                    if($data->metakeywords != ''){
                        echo '<meta name="keywords"  content="'.esc_html($data->metakeywords).'">';
                    }
                    if($data->tags != ''){
                        echo '<meta name="tags"  content="'.esc_html($data->tags).'">';
                    }
                }
            }else{
                $query = "SELECT resume.tags,resume.keywords
                    FROM `" . wpjobportal::$_db->prefix . "wj_portal_resume` AS resume
                    WHERE resume.id = " . $id;
                $data = wpjobportaldb::get_row($query);
                if($data != ''){
                    if($data->keywords != ''){
                        echo '<meta name="keywords"  content="'.esc_html($data->keywords).'">';
                    }
                    if($data->tags != ''){
                        echo '<meta name="tags"  content="'.esc_html($data->tags).'">';
                    }
                }
            }

        }
    }

    return;
}


add_action("wp_head","wpjobportal_socialmedia_metatags");
function wpjobportal_socialmedia_metatags(){
    $defaultDescriptionMeta = 1;
    $layout = WPJOBPORTALrequest::getVar('wpjobportallt');
    if($layout == 'viewjob'){
        $jobid = WPJOBPORTALrequest::getVar('wpjobportalid');
        $job = WPJOBPORTALincluder::getJSTable('job');
        $job->load($jobid);
        if( $job->id ){
            $title = $job->title;
            $description = $job->metadescription;
            if(empty($description)){
                $description = wpjobportalphplib::wpJP_strip_tags($job->description);
            }
            echo '<meta name= "twitter:card" content="summary" />'."\n";
            echo '<meta job="og:type" content="place" />'."\n";
            echo '<meta name="twitter:title" job="og:title" content="'.esc_html($title).'" />'."\n";
            echo '<meta name="twitter:description" job="og:description" content="'.esc_html($description).'" />'."\n";
            if(!empty($job->metakeywords)){
                echo '<meta name="keywords" content="'.esc_html($job->metakeywords).'"/>'."\n";
            }
            if(!empty($description)){
                $defaultDescriptionMeta = 0;
                echo '<meta name="description" content="'.esc_html($description).'"/>'."\n";
            }
            if(!empty($job->latitude) && !empty($job->longitude)){
                echo '<meta job="place:location:latitude" content="'.esc_html($job->latitude).'">'."\n";
                echo '<meta job="place:location:longitude" content="'.esc_html($job->longitude).'">'."\n";
            }
        }
    }

    if( $defaultDescriptionMeta ){
        echo '<meta name="description" content="';
        bloginfo('description');
        echo '" />';
    }
}



add_action( 'wp_head', 'job_posting_structured');
function job_posting_structured(){
    $layout = WPJOBPORTALrequest::getVar('wpjobportallt');
    if($layout == 'viewjob'){
        $jobid = WPJOBPORTALrequest::getVar('wpjobportalid');
        $jobid = wpjobportal::$_common->parseID($jobid);
        $job = WPJOBPORTALincluder::getJSModel('job')->jobDataStructuredPost($jobid);
        if(isset($job->title) && isset($job->id)){
            $wpdir = wp_upload_dir();
            $data_directory = WPJOBPORTALincluder::getJSModel('configuration')->getConfigurationByConfigName('data_directory');
            $path = $wpdir['baseurl'] . '/' . $data_directory . '/data/employer/comp_' . $job->companyid . '/logo/' . $job->logofilename;
            echo '<script type="application/ld+json">
            {
              "@context" : "https://schema.org/",
              "@type" : "JobPosting",
              "title" : "'. $job->title .'",
              "description" : "'. $job->description .'",
              "identifier": {
                "@type": "PropertyValue",
                "name": "'. $job->companyname .'",
                "value": "'. $job->jobid .'"
              },
              "datePosted" : "'. $job->created .'",
              "validThrough" : "'. $job->stoppublishing .'",
              "employmentType" : "'. $job->jobtypetitle .'",
              "hiringOrganization" : {
                "@type" : "Organization",
                "name" : "'. $job->companyname .'",
                "sameAs" : "https://www.facebook.com",
                "logo" : "'. $path .'"
              },
              "jobLocation": {
              "@type": "Place",
                "address": [{
                "@type": "PostalAddress",
                "streetAddress": "'. $job->multicity .'"
                },{
                "@type": "PostalAddress",
                "streetAddress": "'. $job->multicity .'"
                }]
              },
             "baseSalary": {
                "@type": "MonetaryAmount",
                "currency": "'.$job->currency.'",
                "value": {
                  "@type": "QuantitativeValue",
                  "value": "'.$job->salary.'",
                  "unitText": "'.$job->srangetypetitle.'"
                }
              }
            }
            </script>';
        }
    }
}

add_action( 'admin_enqueue_scripts', 'wpjobportal_admin_register_plugin_styles' );
add_filter('style_loader_tag', 'wpjobportalW3cValidation', 10, 2);
add_filter('script_loader_tag', 'wpjobportalW3cValidation', 10, 2);
function wpjobportalW3cValidation($tag, $handle) {
    return wpjobportalphplib::wpJP_preg_replace( "/type=['\"]text\/(javascript|css)['\"]/", '', $tag );
}

function checkWPJPPluginInfo($slug){
    if(file_exists(WP_PLUGIN_DIR . '/'.$slug) && is_plugin_active($slug)){
        $text = __("Activated","wp-job-portal");
        $disabled = "disabled";
        $class = "js-btn-activated";
        $availability = "-1";
    }else if(file_exists(WP_PLUGIN_DIR . '/'.$slug) && !is_plugin_active($slug)){
        $text = __("Active Now","wp-job-portal");
        $disabled = "";
        $class = "js-btn-green js-btn-active-now";
        $availability = "1";
    }else if(!file_exists(WP_PLUGIN_DIR . '/'.$slug)){
        $text = __("Install Now","wp-job-portal");
        $disabled = "";
        $class = "js-btn-install-now";
        $availability = "0";
    }

    return array("text" => $text, "disabled" => $disabled, "class" => $class, "availability" => $availability);
}

function employercheckLinks($name) {
    $print = false;
    switch ($name) {
        case 'formcompany': $visname = 'vis_emformcompany';
        break;
        case 'alljobsappliedapplications': $visname = 'vis_emalljobsappliedapplications';
        break;
        case 'mycompanies': $visname = 'vis_emmycompanies';
        break;
        case 'resumesearch': $visname = 'vis_emresumesearch';
        break;
        case 'formjob': $visname = 'vis_emformjob';
        break;
        case 'my_resumesearches': $visname = 'vis_emmy_resumesearches';
        break;
        case 'myjobs': $visname = 'vis_emmyjobs';
        break;
        case 'formdepartment': $visname = 'vis_emformdepartment';
        break;
        case 'my_stats': $visname = 'vis_emmy_stats';
        break;
        case 'empresume_rss': $visname = 'vis_resume_rss';
        break;
        case 'newfolders': $visname = 'vis_emnewfolders';
        break;
        case 'empregister': $visname = 'vis_emempregister';
        break;
        case 'empcredits': $visname = 'vis_empcredits';
        break;
        case 'empcreditlog': $visname = 'vis_empcreditlog';
        break;
        case 'emppurchasehistory': $visname = 'vis_emppurchasehistory';
        break;
        case 'empmessages': $visname = 'vis_emmessages';
        break;
        case 'empregister': $visname = 'vis_emregister';
        break;
        case 'empratelist': $visname = 'vis_empratelist';
        break;
        case 'jobs_graph': $visname = 'vis_jobs_graph';
        break;
        case 'resume_graph': $visname = 'vis_resume_graph';
        break;
        case 'box_newestresume': $visname = 'vis_box_newestresume';
        break;
        case 'box_appliedresume': $visname = 'vis_box_appliedresume';
        break;
        case 'emploginlogout': $visname = 'emploginlogout';
        break;
        case 'empmystats': $visname = 'vis_empmystats';
        break;
        case 'emresumebycategory': $visname = 'vis_emresumebycategory';
        break;
        case 'temp_employer_dashboard_stats_graph': $visname = 'vis_temp_employer_dashboard_stats_graph';
        break;
        case 'temp_employer_dashboard_useful_links': $visname = 'vis_temp_employer_dashboard_useful_links';
        break;
        case 'temp_employer_dashboard_applied_resume': $visname = 'vis_temp_employer_dashboard_applied_resume';
        break;
        case 'temp_employer_dashboard_saved_search': $visname = 'vis_temp_employer_dashboard_saved_search';
        break;
        case 'temp_employer_dashboard_credits_log': $visname = 'vis_temp_employer_dashboard_credits_log';
        break;
        case 'temp_employer_dashboard_purchase_history': $visname = 'vis_temp_employer_dashboard_purchase_history';
        break;
        case 'temp_employer_dashboard_newest_resume': $visname = 'vis_temp_employer_dashboard_newest_resume';
        break;
        default:$visname = 'vis_em' . $name;
        break;
    }

    $isouruser = WPJOBPORTALincluder::getObjectClass('user')->isWPJOBPortalUser();
    $isguest = WPJOBPORTALincluder::getObjectClass('user')->isguest();

    $guest = false;

    if($isguest == true){
        $guest = true;
    }
    if($isguest == false && $isouruser == false){
        $guest = true;
    }
    
    $config_array = WPJOBPORTALincluder::getJSModel('configuration')->getConfigByFor('emcontrolpanel');

    if ($guest == false) {
        if (WPJOBPORTALincluder::getObjectClass('user')->isemployer()) {
            if ($config_array[$name] == 1){
                $print = true;
            }
        }elseif (WPJOBPORTALincluder::getObjectClass('user')->isjobseeker()) {
            if ($config_array["$visname"] == 1) {
                $print = true;
            }
        }
    } else {
        if ($config_array["$visname"] == 1)
            $print = true;
    }
    return $print;
}

if(!empty(wpjobportal::$_active_addons)){
    require_once 'includes/addon-updater/wpjobportalupdater.php';
    $WP_JOBPORTALUpdater  = new WP_JOBPORTALUpdater();
}

if(is_file('includes/updater/updater.php')){
    include_once 'includes/updater/updater.php';
}

function jobseekercheckLinks($name) {

    $print = false;
    switch ($name) {
        case 'formresume': $visname = 'vis_jsformresume';
            break;
        case 'jobcat': $visname = 'vis_wpjobportalcat';
            break;
        case 'myresumes': $visname = 'vis_jsmyresumes';
            break;
        case 'listnewestjobs': $visname = 'vis_jslistnewestjobs';
            break;
        case 'listallcompanies': $visname = 'vis_jslistallcompanies';
            break;
        case 'listjobbytype': $visname = 'vis_jslistjobbytype';
            break;
        case 'myappliedjobs': $visname = 'vis_jsmyappliedjobs';
            break;
        case 'jobsearch': $visname = 'vis_wpjobportalearch';
            break;
        case 'my_jobsearches': $visname = 'vis_jsmy_jobsearches';
            break;
       case 'jscredits': $visname = 'vis_jscredits';
            break;
        case 'jscreditlog': $visname = 'vis_jscreditlog';
            break;
        case 'jspurchasehistory': $visname = 'vis_jspurchasehistory';
            break;
        case 'jsratelist': $visname = 'vis_jsratelist';
            break;
        case 'jsmy_stats': $visname = 'vis_jsmy_stats';
            break;
        case 'jobalertsetting': $visname = 'vis_wpjobportalalertsetting';
            break;
        case 'jsmessages': $visname = 'vis_jsmessages';
            break;
        case 'wpjobportal_rss': $visname = 'vis_job_rss';
            break;
        case 'jsregister': $visname = 'vis_jsregister';
            break;
        case 'jsactivejobs_graph': $visname = 'vis_jsactivejobs_graph';
            break;
        case 'jssuggestedjobs_box': $visname = 'vis_jssuggestedjobs_box';
            break;
        case 'jsappliedresume_box': $visname = 'vis_jsappliedresume_box';
            break;
        case 'listjobshortlist': $visname = 'vis_jslistjobshortlist';
            break;
        case 'jsmystats': $visname = 'vis_jsmystats';
            break;
        case 'jobsloginlogout': $visname = 'jobsloginlogout';
            break;
        case 'temp_jobseeker_dashboard_jobs_graph': $visname = 'vis_temp_jobseeker_dashboard_jobs_graph';
            break;
        case 'temp_jobseeker_dashboard_useful_links': $visname = 'vis_temp_jobseeker_dashboard_useful_links';
            break;
        case 'temp_jobseeker_dashboard_apllied_jobs': $visname = 'vis_temp_jobseeker_dashboard_apllied_jobs';
            break;
        case 'temp_jobseeker_dashboard_shortlisted_jobs': $visname = 'vis_temp_jobseeker_dashboard_shortlisted_jobs';
            break;
        case 'temp_jobseeker_dashboard_credits_log': $visname = 'vis_temp_jobseeker_dashboard_credits_log';
            break;
        case 'temp_jobseeker_dashboard_purchase_history': $visname = 'vis_temp_jobseeker_dashboard_purchase_history';
            break;
        case 'temp_jobseeker_dashboard_newest_jobs': $visname = 'vis_temp_jobseeker_dashboard_newest_jobs';
            break;
        case 'jobsbycities': $visname = 'vis_jobsbycities';
            break;
        case 'mycoverletter': $visname = 'vis_jsmycoverletter';
            break;
        case 'formcoverletter': $visname = 'vis_jsformcoverletter';
            break;

        default:$visname = 'vis_js' . $name;
            break;
    }
    $isouruser = WPJOBPORTALincluder::getObjectClass('user')->isisWPJobportalUser();
    $isguest = WPJOBPORTALincluder::getObjectClass('user')->isguest();

    $guest = false;

    if($isguest == true){
        $guest = true;
    }
    if($isguest == false && $isouruser == false){
        $guest = true;
    }
    WPJOBPORTALincluder::getJSModel('jobseeker')->getConfigurationForControlPanel();
    $config_array = wpjobportal::$_data['configs'];
    if ($guest == false) {
        if (WPJOBPORTALincluder::getObjectClass('user')->isjobseeker()) {
            if (isset($config_array[$name]) && $config_array[$name] == 1)
               $print = true;
        }elseif (WPJOBPORTALincluder::getObjectClass('user')->isemployer()) {
            if ($config_array['employerview_js_controlpanel'] == 1)
                if (isset($config_array["$visname"]) && $config_array["$visname"] == 1) {
                    $print = true;
                }
        }
    } else {
        if (isset($config_array["$visname"]) && $config_array["$visname"] == 1)
            $print = true;
        }

    return $print;
}
add_filter( 'login_redirect', 'wpjobportal_login_redirect', 10, 3 );
function wpjobportal_login_redirect($redirect_to, $request, $user){
   //is there a user to check?
   global $user;
   if ( isset( $user->roles ) && is_array( $user->roles ) ) {
       //check for admins
       if ( in_array( 'administrator', $user->roles ) ) {
           return $redirect_to;
       } else {
           $query = "SELECT roleid FROM `".wpjobportal::$_db->prefix."wj_portal_users` WHERE uid = " . $user->id;
           $roleid = wpjobportaldb::get_var($query);
           $url = '/';
           if($roleid == 2){
               $url = wpjobportal::makeUrl(array('wpjobportalpageid'=>wpjobportal::getPageid(),'wpjobportalme'=>'jobseeker','wpjobportallt'=>'controlpanel'));
           }elseif($roleid == 1){
               $url = wpjobportal::makeUrl(array('wpjobportalpageid'=>wpjobportal::getPageid(),'wpjobportalme'=>'employer','wpjobportallt'=>'controlpanel'));
           }
           return $url;
       }
   } else {
       return $redirect_to;
   }

}


?>
