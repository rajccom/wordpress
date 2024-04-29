<?php

if (!defined('ABSPATH'))
    die('Restricted Access');

class WPJOBPORTALwpjpnotification {

    function __construct( ) {

    }

    public function addSessionNotificationDataToTable($message, $msgtype, $sessiondatafor = 'notification',$msgkey = 'captcha'){
        /*$message belows to repsonse message
        $msgtyp belongs to reponse type eg error or success
        $sessiondatafor belong to any random thing or reponse notification after saving some data
        $msgkey belong to module
        */
        if($message == ''){
            if(!is_numeric($message))
                return false;
        }
        global $wpdb;
        $data = array();
        $update = false;
        if(isset($_COOKIE['_wpjsjp_session_']) && isset(wpjobportal::$_jsjpsession->sessionid)){
            if($sessiondatafor == 'notification'){
                $data = $this->getNotificationDatabySessionId($sessiondatafor);
                if(empty($data)){
                    $data['msg'][0] = $message;
                    $data['type'][0] = $msgtype;
                }else{
                    $update = true;
                    $count = count($data['msg']);
                    $data['msg'][$count] = $message;
                    $data['type'][$count] = $msgtype;
                }
            }

            if($sessiondatafor == 'wpjobportal_spamcheckid'){
                $msgkey = 'captcha';
                $data = $this->getNotificationDatabySessionId($sessiondatafor,$msgkey);
                if($data != ""){
                    $update = true;
                    $data = $message;
                }else{
                    $data = $message;
                }
            }
            if($sessiondatafor == 'wpjobportal_rot13'){
                $msgkey = 'captcha';
                $data = $this->getNotificationDatabySessionId($sessiondatafor,$msgkey);
                if($data != ""){
                    $update = true;
                    $data = $message;
                }else{
                    $data = $message;
                }
            }
            if($sessiondatafor == 'wpjobportal_spamcheckresult'){
                $msgkey = 'captcha';
                $data = $this->getNotificationDatabySessionId($sessiondatafor,$msgkey);
                if($data != ""){
                    $update = true;
                    $data = $message;
                }else{
                    $data = $message;
                }
            }


            $data = json_encode($data , true);
            $sessionmsg = wpjobportalphplib::wpJP_safe_encoding($data);
            if(!$update){
                $wpdb->insert( "{$wpdb->prefix}wj_portal_jswjsessiondata", array("usersessionid" => wpjobportal::$_jsjpsession->sessionid, "sessionmsg" => $sessionmsg, "sessionexpire" => wpjobportal::$_jsjpsession->sessionexpire, "sessionfor" => $sessiondatafor , "msgkey" => $msgkey) );
            }else{
                $wpdb->update( "{$wpdb->prefix}wj_portal_jswjsessiondata", array("sessionmsg" => $sessionmsg), array("usersessionid" => wpjobportal::$_jsjpsession->sessionid , 'sessionfor' => $sessiondatafor) );
            }
        }
        return false;
    }

    public function getNotificationDatabySessionId($sessionfor , $msgkey = null, $deldata = false){
        if(wpjobportal::$_jsjpsession->sessionid == '')
            return false;
        global $wpdb;
        $data = $wpdb->get_var( "SELECT sessionmsg FROM {$wpdb->prefix}wj_portal_jswjsessiondata WHERE usersessionid = '" . wpjobportal::$_jsjpsession->sessionid . "' AND sessionfor = '" . $sessionfor . "' AND sessionexpire > '" . time() . "'");
        if(!empty($data)){
            $data = wpjobportalphplib::wpJP_safe_decoding($data);
            $data = json_decode( $data , true);
            //$deldata = true; // to remove notices once shown
        }
        if($deldata){
            $wpdb->delete( "{$wpdb->prefix}wj_portal_jswjsessiondata", array( 'usersessionid' => wpjobportal::$_jsjpsession->sessionid , 'sessionfor' => $sessionfor , 'msgkey' => $msgkey) );
        }
        return $data;
    }

}

?>
