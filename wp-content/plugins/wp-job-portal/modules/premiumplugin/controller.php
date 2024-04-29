<?php

class WPJOBPORTALpremiumpluginController {

    function __construct() {
        self::handleRequest();
    }

    function handleRequest() {
        $module = "premiumplugin";
        if ($this->canAddLayout()) {
            $layout = WPJOBPORTALrequest::getLayout('wpjobportallt', null, 'step1');
            switch ($layout) {
                case 'admin_step1':
                    wpjobportal::$_data['versioncode'] = WPJOBPORTALincluder::getJSModel('configuration')->getConfigurationByConfigName('versioncode');
                    wpjobportal::$_data['productcode'] = WPJOBPORTALincluder::getJSModel('configuration')->getConfigurationByConfigName('productcode');
                    wpjobportal::$_data['producttype'] = WPJOBPORTALincluder::getJSModel('configuration')->getConfigurationByConfigName('producttype');
                break;
            }
            $module =  'premiumplugin';
            WPJOBPORTALincluder::include_file($layout, $module);
        }
    }

    function canAddLayout() {
        if (isset($_POST['form_request']) && $_POST['form_request'] == 'wpjobportal')
            return false;
        elseif (isset($_GET['action']) && $_GET['action'] == 'wpjobportaltask')
            return false;
        else
            return true;
    }

    function verifytransactionkey(){

        $post_data['transactionkey'] = WPJOBPORTALrequest::getVar('transactionkey','','');
        if($post_data['transactionkey'] != ''){


            $post_data['domain'] = site_url();
            $post_data['step'] = 'one';
            $post_data['myown'] = 1;

            $url = 'https://wpjobportal.com/setup/index.php';

            $response = wp_remote_post( $url, array('body' => $post_data,'timeout'=>7,'sslverify'=>false));
            if( !is_wp_error($response) && $response['response']['code'] == 200 && isset($response['body']) ){
                $result = $response['body'];
                $result = json_decode($result,true);

            }else{
                $result = false;
                if(!is_wp_error($response)){
                   $error = $response['response']['message'];
               }else{
                    $error = $response->get_error_message();
               }
            }

            if(is_array($result) && isset($result['status']) && $result['status'] == 1 ){ // means everthing ok
                $installdata = $result;
                $installdata['actual_transaction_key'] = $post_data['transactionkey'];
                $result['actual_transaction_key'] = $post_data['transactionkey'];
                // in case of session not working
                add_option('wpjobportal_addon_install_data',json_encode($result));
                $url = admin_url("admin.php?page=wpjobportal_premiumplugin&wpjobportallt=step2");
                wp_redirect($url);
                return;
            }else{
                if(isset($result[0]) && $result[0] == 0){
                    $error = $result[1];
                }elseif(isset($result['error']) && $result['error'] != ''){
                    $error = $result['error'];
                }
            }
        }else{
            $error = __('Please insert activation key to proceed','wp-job-portal').'!';
        }
        $wpjobportal_addon_return_data = array();
        $wpjobportal_addon_return_data['status'] = 0;
        $wpjobportal_addon_return_data['message'] = $error;
        $wpjobportal_addon_return_data['transactionkey'] = $post_data['transactionkey'];
        update_option( 'wpjobportal_addon_return_data', json_encode($wpjobportal_addon_return_data) );
        $url = admin_url("admin.php?page=wpjobportal_premiumplugin&wpjobportallt=step1");
        wp_redirect($url);
        return;
    }

    function downloadandinstalladdons(){
        $post_data = WPJOBPORTALrequest::get('post');

        $addons_array = $post_data;
        if(isset($addons_array['token'])){
            unset($addons_array['token']);
        }
        $addon_json_array = array();

        foreach ($addons_array as $key => $value) {
            $addon_json_array[] = wpjobportalphplib::wpJP_str_replace('wp-job-portal-', '', $key);
        }

        $token = $post_data['token'];
        if($token == ''){
            $wpjobportal_addon_return_data = array();
            $wpjobportal_addon_return_data['status'] = 0;
            $wpjobportal_addon_return_data['message'] = __('Addon Installation Failed','wp-job-portal').'!';
            $wpjobportal_addon_return_data['transactionkey'] = '';
            update_option( 'wpjobportal_addon_return_data', json_encode($wpjobportal_addon_return_data) );
            $url = admin_url("admin.php?page=wpjobportal_premiumplugin&wpjobportallt=step1");
            wp_redirect($url);
            exit;
        }
        $site_url = site_url();
        $site_url = wpjobportalphplib::wpJP_str_replace("https://","",$site_url);
        $site_url = wpjobportalphplib::wpJP_str_replace("http://","",$site_url);
        $url = 'https://wpjobportal.com/setup/index.php?token='.$token.'&productcode='. json_encode($addon_json_array).'&domain='. $site_url;

        $install_count = 0;

        $installed = $this->install_plugin($url);
        if ( !is_wp_error( $installed ) && $installed ) {
            // had to run two seprate loops to save token for all the addons even if some error is triggered by activation.
            foreach ($post_data as $key => $value) {
                if(wpjobportalphplib::wpJP_strstr($key, 'wp-job-portal-')){
                    update_option('transaction_key_for_'.$key,$token);
                }
            }

            foreach ($post_data as $key => $value) {
                if(wpjobportalphplib::wpJP_strstr($key, 'wp-job-portal-')){
                    $activate = activate_plugin( $key.'/'.$key.'.php' );
                    $install_count++;
                }
            }

        }else{
            $wpjobportal_addon_return_data = array();
            $wpjobportal_addon_return_data['status'] = 0;
            $wpjobportal_addon_return_data['message'] = __('Addon Installation Failed','wp-job-portal').'!';
            $wpjobportal_addon_return_data['transactionkey'] = '';
            update_option( 'wpjobportal_addon_return_data', json_encode($wpjobportal_addon_return_data) );
            $url = admin_url("admin.php?page=wpjobportal_premiumplugin&wpjobportallt=step1");
            wp_redirect($url);
            exit;
        }
        $url = admin_url("admin.php?page=wpjobportal_premiumplugin&wpjobportallt=step3");
        wp_redirect($url);
    }

    function install_plugin( $plugin_zip ) {

        include(ABSPATH . "wp-admin/includes/admin.php");
        WP_Filesystem();
        $tmpfile = download_url( $plugin_zip);

        if ( !is_wp_error( $tmpfile ) && $tmpfile ) {
            $plugin_path = WP_CONTENT_DIR;
            $plugin_path = $plugin_path.'/plugins/';
            $path =WPJOBPORTAL_PLUGIN_PATH.'addon.zip';

            copy( $tmpfile, $path );


            $unzipfile = unzip_file( $path, $plugin_path);
            @unlink( $path ); // must unlink afterwards
            @unlink( $tmpfile ); // must unlink afterwards

            if ( is_wp_error( $unzipfile ) ) {
                $wpjobportal_addon_return_data = array();
                $wpjobportal_addon_return_data['status'] = 0;
                $wpjobportal_addon_return_data['message'] = __('Addon installation failed, Directory permission error','wp-job-portal').'!';
                $wpjobportal_addon_return_data['transactionkey'] = '';
                update_option( 'wpjobportal_addon_return_data', json_encode($wpjobportal_addon_return_data) );
                $url = admin_url("admin.php?page=wpjobportal_premiumplugin&wpjobportallt=step1");
                wp_redirect($url);
                exit;
            } else {
                return true;
            }
        }else{
            $wpjobportal_addon_return_data = array();
            $wpjobportal_addon_return_data['status'] = 0;
            $wpjobportal_addon_return_data['message'] = __('Addon Installation Failed, File download error','wp-job-portal').'!';
            $wpjobportal_addon_return_data['transactionkey'] = '';
            update_option( 'wpjobportal_addon_return_data', json_encode($wpjobportal_addon_return_data) );
            $url = admin_url("admin.php?page=wpjobportal_premiumplugin&wpjobportallt=step1");
            wp_redirect($url);
            exit;
        }
    }
}
$WPJOBPORTALpremiumpluginController = new WPJOBPORTALpremiumpluginController();
?>
