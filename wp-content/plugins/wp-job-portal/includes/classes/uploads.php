<?php

if (!defined('ABSPATH'))
    die('Restricted Access');

class WPJOBPORTALuploads {

    private $uploadfor;
    private $companyid;
    private $resumeid;
    private $jobseekerid;
    private $userid;

    function wpjobportal_upload_dir( $dir ) {
        $form_request = WPJOBPORTALrequest::getVar('form_request');
        if($form_request == 'wpjobportal' || ($this->uploadfor == 'resumephoto' || $this->uploadfor == 'resumefiles'||$this->uploadfor=='profile')){ // Patch b/c of resume is ajax base
            $datadirectory = wpjobportal::$_config->getConfigurationByConfigName('data_directory');
            // test code
            $file = @fopen($dir['basedir'].'/'.$datadirectory."/index.html", 'w');
            if($file){
                fclose($file);
            }

            $path = $datadirectory . '/data';
            // // test code
            $file = @fopen($dir['basedir'].'/'.$path."/index.html", 'w');
            if($file){
                fclose($file);
            }
            //
            $apath = $path;

            if($this->uploadfor == 'company'){
                $path = $path . '/employer/comp_'.$this->companyid.'/logo';
            }elseif($this->uploadfor == 'resumephoto'){
                $path = $path . '/jobseeker/resume_'.$this->resumeid.'/photo';
            }elseif($this->uploadfor == 'resumefiles'){
                $path = $path . '/jobseeker/resume_'.$this->resumeid.'/resume';
            }
            elseif($this->uploadfor == 'profile'){
                $path = $path . '/profile/profile_'.$this->userid.'/profile';
            }else{

            }
            // // test code
            $file = @fopen($path."/index.html", 'w');
            if($file){
                fclose($file);
            }
            //

            $userpath = $path;
            $array = array(
                'path'   => $dir['basedir'] . '/' . $userpath,
                'url'    => $dir['baseurl'] . '/' . $userpath,
                'subdir' => '/'. $userpath,
            ) + $dir;
            return $array;
        }else{
            return $dir;
        }
    }

    function uploadCompanyLogo($id){
        $file_size = wpjobportal::$_config->getConfigurationByConfigName('company_logofilezize');
        if (!function_exists('wp_handle_upload')) {
            require_once( ABSPATH . 'wp-admin/includes/file.php' );
        }
        $this->companyid = $id;
        $this->uploadfor = 'company';
        // Register our path override.
        add_filter( 'upload_dir', array($this,'wpjobportal_upload_dir'));
        // Do our thing. WordPress will move the file to 'uploads/mycustomdir'.
        $result = array();
        $filename = '';
        $return = 1;
        $file = array(
                'name'     => sanitize_file_name($_FILES['logo']['name']),
                'type'     => wpjobportal::sanitizeData($_FILES['logo']['type']),
                'tmp_name' => wpjobportal::sanitizeData($_FILES['logo']['tmp_name']),
                'error'    => wpjobportal::sanitizeData($_FILES['logo']['error']),
                'size'     => wpjobportal::sanitizeData($_FILES['logo']['size'])
                );
        $uploadfilesize = $file['size'] / 1024; //kb
        $key = WPJOBPORTALincluder::getJSModel('company')->getMessagekey();
        if($uploadfilesize > $file_size){
            WPJOBPORTALMessages::setLayoutMessage(__('File size is greater then allowed file size', 'wp-job-portal'), 'error',$key);
            $return = 5;
        }else{
            $filetyperesult = wp_check_filetype(sanitize_file_name($_FILES['logo']['name']));
            if(!empty($filetyperesult['ext']) && !empty($filetyperesult['type'])){
                $image_file_types = wpjobportal::$_config->getConfigurationByConfigName('image_file_type');
                if(wpjobportalphplib::wpJP_strstr($image_file_types, $filetyperesult['ext'])){
                    $result = wp_handle_upload($file, array('test_form' => false));
                    if ( $result && ! isset( $result['error'] ) ) {
                        $filename = wpjobportalphplib::wpJP_basename( $result['file'] );
                        $imageresult[0] = $result['file'];
                        $imageresult[1] = $result['url'];
                    } else {
                        /**
                         * Error generated by _wp_handle_upload()
                         * @see _wp_handle_upload() in wp-admin/includes/file.php
                         */
						WPJOBPORTALMessages::setLayoutMessage($result['error'], 'error','company');
                    }
                }else{
                    $return = 5;
                }
            }else{
                $return = 6;
            }

        }
        // Set everything back to normal.
        remove_filter( 'upload_dir', array($this,'wpjobportal_upload_dir'));
        if($return == 1){
            $query = "UPDATE `".wpjobportal::$_db->prefix."wj_portal_companies` SET logofilename = '".$filename."', logoisfile = 1 WHERE id = ".$id;
            wpjobportal::$_db->query($query);

            // index code
            $datadirectory = wpjobportal::$_config->getConfigurationByConfigName('data_directory');
            $dir = wp_upload_dir();

            $file = @fopen($dir['basedir'].'/'.$datadirectory."/index.html", 'w');
            if($file){
                fclose($file);
            }
            $path = $datadirectory . '/data';
            $file = @fopen($dir['basedir'].'/'.$path."/index.html", 'w');
            if($file){
                fclose($file);
            }
            $file = @fopen($dir['basedir'].'/'.$path."/employer/index.html", 'w');
            if($file){
                fclose($file);
            }
            $file = @fopen($dir['basedir'].'/'.$path."/employer/comp_".$this->companyid."/index.html", 'w');
            if($file){
                fclose($file);
            }
            $file = @fopen($dir['basedir'].'/'.$path."/employer/comp_".$this->companyid."/logo/index.html", 'w');
            if($file){
                fclose($file);
            }
        }else{
            $query = "UPDATE `".wpjobportal::$_db->prefix."wj_portal_companies` SET logofilename = '', logoisfile = -1 WHERE id = ".$id;
            wpjobportal::$_db->query($query);
        }

/*
        // cropingg and resizzing images
        $wpdir = wp_upload_dir();
        $data_directory = wpjobportal::$_config->getConfigurationByConfigName('data_directory');
        $path = $wpdir['basedir'] . '/' . $data_directory . '/data/employer/comp_' .$id.'/logo' ;

        if(is_array($imageresult) && !empty($imageresult)){
            $file_size = filesize($imageresult[0]);
            $temp_file_name = wpjobportalphplib::wpJP_basename( $imageresult[0] );
            $imageresult[1] = wpjobportalphplib::wpJP_str_replace($temp_file_name, '', $imageresult[1]);
           // to add sufix of image s m l ms
            $file_name = 'jsjb-logo_'.$temp_file_name;
            $this->createThumbnail($file_name,322,291,$imageresult[0],$path);
            // need to store image name in above code.
        }
  */


        return $return;
    }

    function createThumbnail($filename,$width,$height,$file = null,$path='',$crop_flag = 0) {
        $handle = new WPJOBPORTALupload($file);
        $parts = wpjobportalphplib::wpJP_explode(".",$filename);
        $extension = end($parts);
        $filename = wpjobportalphplib::wpJP_str_replace("." . $extension,"",$filename);
        if ($handle->uploaded) {
            if($crop_flag != 3){
                $handle->file_new_name_body   = $filename;
                $handle->image_resize         = true;
                $handle->image_x              = $width;
                $handle->image_y              = $height;
                $handle->image_ratio_fill     = true;
                $handle->image_ratio          = true;
            }else{
                $handle->file_auto_rename = false;
                $handle->file_overwrite = true;
            }

            $handle->process($path);
            @$handle->processed;
            // uncomment this code to check for error.
            // if ($handle->processed) {
            //     // opration successful
            // } else {
            //     echo 'error : ' . $handle->error;
            //     return false;
            // }
        }else{
            echo 'error : ' . $handle->error;
        }
    }


     function uploadUserPhoto($id){
        if(!is_numeric($id)){
            return false;
        }
        // Register our path override.
        $this->uploadfor = 'profile';
        $this->userid = $id;
        $array = add_filter( 'upload_dir', array($this,'wpjobportal_upload_dir'));
        $return = true;
        $result = $this->uploadImage(filter_var_array($_FILES['photo']));
        $profilepath = wpjobportalphplib::wpJP_explode($result['filename'], $result['url']);
        if( !isset($result['error']) ){
            $query = "UPDATE `" . wpjobportal::$_db->prefix . "wj_portal_users` SET photo = '".$result['filename']."' WHERE uid = ".$id;
            wpjobportal::$_db->query($query);

            //crop and store images
            $filename = wpjobportalphplib::wpJP_basename($result['file']);
            $file_name = 'm_'.$filename;
            $this->createThumbnail($file_name,400,302,$result['file'],$profilepath[0]);
            $file_name = 's_'.$filename;
            $this->createThumbnail($file_name,150,150,$result['file'],$profilepath[0]);

        }else{
            WPJOBPORTALmessages::setLayoutMessage($result['error'],'error',WPJOBPORTALincluder::getJSModel('user')->getMessagekey());
            $return = false;
        }

        // Set everything back to normal.
        remove_filter( 'upload_dir', array($this,'wpjobportal_upload_dir'));

        return $return;
    }

    function uploadImage($file){
        $allowed_types = WPJOBPORTALincluder::getJSModel('configuration')->getConfigValue('image_file_type');
        $allowed_size = WPJOBPORTALincluder::getJSModel('configuration')->getConfigValue('image_file_size');
        return $this->uploadFile($file, $allowed_types, $allowed_size);
    }

    function removeUserPhoto($uid){
        if(!is_numeric($uid)){
            return false;
        }
        $user = WPJOBPORTALincluder::getJSTable('users');

        $user->load(WPJOBPORTALincluder::getObjectClass('user')->uid());
        $filename = $user->photo;
        if(!empty($filename)){
            $wpdir = wp_upload_dir();
            $data_directory = wpjobportal::$_config->getConfigValue('data_directory');
            $filepath = $wpdir['basedir'] . '/' . $data_directory . '/data/profile/profile_' . $uid.'/profile/';
            $path = $filepath.$filename;
            @unlink($path);
            $path = $filepath.'m_'.$filename;
            @unlink($path);
            $path = $filepath.'s_'.$filename;
            @unlink($path);
            $query = "UPDATE `" . wpjobportal::$_db->prefix . "wj_portal_users` SET photo = '' WHERE uid = ".$uid;
            wpjobportal::$_db->query($query);
        }
        return true;
    }

    function uploadFile($file, $allowed_types, $allowed_size){
        $filetyperesult = wp_check_filetype($file['name']);
        $allowed_types  = array_map('strtolower', wpjobportalphplib::wpJP_explode(',', $allowed_types));
        if( !in_array(wpjobportalphplib::wpJP_strtolower($filetyperesult['ext']), $allowed_types) ){
            return array('error'=>__('File ext. is mismatched', 'js-real-estate'));
        }
        $filesize = $file['size'] / 1024;
        if( $filesize > $allowed_size ){
            return array('error'=>__('File size is greater then allowed file size', 'js-real-estate'));
        }
        if (!function_exists('wp_handle_upload')) {
            require_once( ABSPATH . 'wp-admin/includes/file.php' );
        }
        $result = wp_handle_upload($file, array('test_form' => false));
        if(!($result && !isset($result['error']))) {
            return $result;
        }
        $result['filename'] = wpjobportalphplib::wpJP_basename($result['file']);
        $result['ischanged'] = $result['filename'] == $file['name'] ? 0 : 1;

        //creating index.html files in directories
        /*
        --------Working-----------
        let $dir['basedir'] = /realestate/wp-admin/uploads
        let $result['file'] = /realestate/wp-admin/uploads/data/property/images/filename.png
        ---$dirstr = wpjobportalphplib::wpJP_str_replace('/'.$result['filename'], '', $result['file']);
        after above line $dirstr = /realestate/wp-admin/uploads/data/property/images
        loop 1st Iteration:
            create index.html file in /realestate/wp-admin/uploads/data/property/images
            and changes $dirstr = /realestate/wp-admin/uploads/data/property
        loop 2nd iteration:
            create index.html file in /realestate/wp-admin/uploads/data/property
            and changes $dirstr = /realestate/wp-admin/uploads/data
        loop 3rd iteration:
            create index.html file in /realestate/wp-admin/uploads/data
            and changes $dirstr = /realestate/wp-admin/uploads
        now $dirstr == $dir['basedie'], so loop exists
        */
        $dir = wp_upload_dir();
        $dirstr = wpjobportalphplib::wpJP_str_replace('/'.$result['filename'], '', $result['file']);
        $i=0;
        do{
            $file = @fopen($dirstr."/index.html", 'w');
            if($file){
                fclose($file);
            }
            $dirstr = wpjobportalphplib::wpJP_preg_replace('/\/[^\/]+$/', '', $dirstr);
            $i++;
        }while( $dirstr !== $dir['basedir'] && $i<20);

        return $result;
    }


    function uploadResumePhoto($id){
        if(!is_numeric($id)) return false;
        $this->resumeid = $id;
        $this->uploadfor = 'resumephoto';

        if (!function_exists('wp_handle_upload')) {
            require_once( ABSPATH . 'wp-admin/includes/file.php' );
        }
        $this->companyid = $id;
        $this->uploadfor = 'resumephoto';
        // Register our path override.
        add_filter( 'upload_dir', array($this,'wpjobportal_upload_dir'));
        // Do our thing. WordPress will move the file to 'uploads/mycustomdir'.
        $result = array();
        $filename = '';
        $return = true;
        $file = array(
                'name'     => sanitize_file_name($_FILES['photo']['name']),
                'type'     => wpjobportal::sanitizeData($_FILES['photo']['type']),
                'tmp_name' => wpjobportal::sanitizeData($_FILES['photo']['tmp_name']),
                'error'    => wpjobportal::sanitizeData($_FILES['photo']['error']),
                'size'     => wpjobportal::sanitizeData($_FILES['photo']['size'])
                );
        $filetyperesult = wp_check_filetype(sanitize_file_name($_FILES['photo']['name']));
        if(!empty($filetyperesult['ext']) && !empty($filetyperesult['type'])){
            $image_file_types = wpjobportal::$_config->getConfigurationByConfigName('image_file_type');
            if(wpjobportalphplib::wpJP_strstr($image_file_types, $filetyperesult['ext'])){
                $result = wp_handle_upload($file, array('test_form' => false));
                if ( $result && ! isset( $result['error'] ) ) {
                    $filename = wpjobportalphplib::wpJP_basename( $result['file'] );
                } else {
                    /**
                     * Error generated by _wp_handle_upload()
                     * @see _wp_handle_upload() in wp-admin/includes/file.php
                     */
					WPJOBPORTALMessages::setLayoutMessage($result['error'], 'error','resume');
                }
            }else{
                $return = null;
            }
        }else{
            $return = 6;
        }
        // Set everything back to normal.
        remove_filter( 'upload_dir', array($this,'wpjobportal_upload_dir'));
        if($return == true){
            $query = "UPDATE `".wpjobportal::$_db->prefix."wj_portal_resume` SET photo = '".$filename."' WHERE id = ".$id;
            wpjobportal::$_db->query($query);

             // index code
            $datadirectory = wpjobportal::$_config->getConfigurationByConfigName('data_directory');
            $dir = wp_upload_dir();

            $file = @fopen($dir['basedir'].'/'.$datadirectory."/index.html", 'w');
            if($file){
                fclose($file);
            }
            $path = $datadirectory . '/data';
            $file = @fopen($dir['basedir'].'/'.$path."/index.html", 'w');
            if($file){
                fclose($file);
            }
            $file = @fopen($dir['basedir'].'/'.$path."/jobseeker/index.html", 'w');
            if($file){
                fclose($file);
            }
            $file = @fopen($dir['basedir'].'/'.$path."/jobseeker/resume_".$id."/index.html", 'w');
            if($file){
                fclose($file);
            }
            $file = @fopen($dir['basedir'].'/'.$path."/jobseeker/resume_".$id."/photo/index.html", 'w');
            if($file){
                fclose($file);
            }
        }
        return $return;
    }

    //////////**********To Add Job Seeker PROFILE PHOTO*******///////////////
    function uploadJobSeekerPhoto($id){
        if(!is_numeric($id)) return false;
        $this->userid = $id;
        $this->uploadfor = 'profile';

        if (!function_exists('wp_handle_upload')) {
            require_once( ABSPATH . 'wp-admin/includes/file.php' );
        }
        $this->companyid = $id;
        $this->uploadfor = 'profile';
        if (!function_exists('wp_handle_upload')) {
            require_once( ABSPATH . 'wp-admin/includes/file.php' );
         }
        // Register our path override.
        add_filter( 'upload_dir', array($this,'wpjobportal_upload_dir'));
        // Do our thing. WordPress will move the file to 'uploads/mycustomdir'.
        $result = array();
        $filename = '';
        $return = true;
        $file = array(
                'name'     => sanitize_file_name($_FILES['photo']['name']),
                'type'     => wpjobportal::sanitizeData($_FILES['photo']['type']),
                'tmp_name' => wpjobportal::sanitizeData($_FILES['photo']['tmp_name']),
                'error'    => wpjobportal::sanitizeData($_FILES['photo']['error']),
                'size'     => wpjobportal::sanitizeData($_FILES['photo']['size'])
                );
        $filetyperesult = wp_check_filetype(sanitize_file_name($_FILES['photo']['name']));
        if(!empty($filetyperesult['ext']) && !empty($filetyperesult['type'])){
            $image_file_types = wpjobportal::$_config->getConfigurationByConfigName('image_file_type');
            if(wpjobportalphplib::wpJP_strstr($image_file_types, $filetyperesult['ext'])){
                $result = wp_handle_upload($file, array('test_form' => false));
                if ( $result && ! isset( $result['error'] ) ) {
                    $filename = wpjobportalphplib::wpJP_basename( $result['file'] );
                } else {
                    /**
                     * Error generated by _wp_handle_upload()
                     * @see _wp_handle_upload() in wp-admin/includes/file.php
                     */
                    WPJOBPORTALMessages::setLayoutMessage($result['error'], 'error','user');
                }
            }else{
                $return = null;
            }
        }else{
            $return = 6;
        }
        // Set everything back to normal.
        remove_filter( 'upload_dir', array($this,'wpjobportal_upload_dir'));
        if($return == true){
            $query = "UPDATE `".wpjobportal::$_db->prefix."wj_portal_users` SET photo = '".$filename."' WHERE id = ".$id;
            wpjobportal::$_db->query($query);

             // index code
            $datadirectory = wpjobportal::$_config->getConfigurationByConfigName('data_directory');
            $dir = wp_upload_dir();

            $file = @fopen($dir['basedir'].'/'.$datadirectory."/index.html", 'w');
            if($file){
                fclose($file);
            }
            $path = $datadirectory . '/data';
            $file = @fopen($dir['basedir'].'/'.$path."/index.html", 'w');
            if($file){
                fclose($file);
            }
            $file = @fopen($dir['basedir'].'/'.$path."/profile/index.html", 'w');
            if($file){
                fclose($file);
            }
            $file = @fopen($dir['basedir'].'/'.$path."/profile/profile_".$id."/index.html", 'w');
            if($file){
                fclose($file);
            }
            $file = @fopen($dir['basedir'].'/'.$path."/profile/profile_".$id."/photo/index.html", 'w');
            if($file){
                fclose($file);
            }
        }
        return $return;
    }


    function uploadResumeFiles($id){
        if(!is_numeric($id)) return false;
        $return = true;
        if (!function_exists('wp_handle_upload')) {
            require_once( ABSPATH . 'wp-admin/includes/file.php' );
        }
        $this->resumeid = $id;
        $this->uploadfor = 'resumefiles';
        // Register our path override.
        add_filter( 'upload_dir', array($this,'wpjobportal_upload_dir'));
        // Do our thing. WordPress will move the file to 'uploads/mycustomdir'.
        $result = array();
        $filename = '';
        $return = true;
        $maxfiles = wpjobportal::$_config->getConfigurationByConfigName('document_max_files');
        $query = "SELECT COUNT(id) FROM `" . wpjobportal::$_db->prefix . "wj_portal_resumefiles` WHERE resumeid = $id";
        $totalfiles = wpjobportal::$_db->get_var($query);
        foreach($_FILES['resumefiles']['name'] AS $key => $value){
            if ($maxfiles > $totalfiles) {
                if($_FILES['resumefiles']['size'][$key] > 0){
                    $file = array(
                            'name'     => sanitize_file_name($_FILES['resumefiles']['name'][$key]),
                            'type'     => wpjobportal::sanitizeData($_FILES['resumefiles']['type'][$key]),
                            'tmp_name' => wpjobportal::sanitizeData($_FILES['resumefiles']['tmp_name'][$key]),
                            'error'    => wpjobportal::sanitizeData($_FILES['resumefiles']['error'][$key]),
                            'size'     => wpjobportal::sanitizeData($_FILES['resumefiles']['size'][$key])
                            );
                    $filetyperesult = wp_check_filetype(sanitize_file_name($_FILES['resumefiles']['name'][$key]));
                    if(!empty($filetyperesult['ext']) && !empty($filetyperesult['type'])){
                        $document_file_types = wpjobportal::$_config->getConfigurationByConfigName('document_file_type');
                        if(wpjobportalphplib::wpJP_strstr($document_file_types, $filetyperesult['ext'])){
                            $result = wp_handle_upload($file, array('test_form' => false));
                            if ( $result && ! isset( $result['error'] ) ) {
                                $filename = wpjobportalphplib::wpJP_basename( $result['file'] );
                                $row = WPJOBPORTALincluder::getJSTable('resumefile');
                                $cols = array();
                                $cols['id'] = '';
                                $cols['resumeid'] = $id;
                                $cols['filename'] = $filename;
                                $cols['filetype'] = $file['type'];
                                $cols['filesize'] = $file['size'];
                                $cols['created'] = date('Y-m-d H:i:s');
                                $row->bind($cols);
                                $row->store();
                                $totalfiles++; //increment file has been uploaded
                            } else {
                                /**
                                 * Error generated by _wp_handle_upload()
                                 * @see _wp_handle_upload() in wp-admin/includes/file.php
                                 */
								WPJOBPORTALMessages::setLayoutMessage($result['error'], 'error','resume');
                            }
                        }
                    }else{
                        $return = 6;
                    }
                }
            }
        }

             // index code
            $datadirectory = wpjobportal::$_config->getConfigurationByConfigName('data_directory');
            $dir = wp_upload_dir();
            $file = @fopen($dir['basedir'].'/'.$path."/jobseeker/resume_".$id."/photo/index.html", 'w');
            if($file){
                fclose($file);
            }
        // Set everything back to normal.
        remove_filter( 'upload_dir', array($this,'wpjobportal_upload_dir'));
        return $return;
    }

}

?>