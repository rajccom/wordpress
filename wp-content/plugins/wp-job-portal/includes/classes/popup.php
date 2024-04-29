<?php

if (!defined('ABSPATH'))
    die('Restricted Access');

class WPJOBPORTALPopup {
    public $class_prefix = '';
    function __construct(){
        if(wpjobportal::$theme_chk == 2){
            $this->class_prefix = 'jsjb-jh';
        }elseif(wpjobportal::$theme_chk == 1){
            $this->class_prefix = 'wpj-jp';
        }
    }

    function canAutoSubmit($result){
        return true;
        $totalcredits = 0;
        $i = 0;
        foreach ($result AS $value) {
            $totalcredits += $value->credits;
            $i++;
        }
        if($i > 1){ // show popup on multioption
            return false;
        }
        if($totalcredits == 0){
            return true;
        }else{
            return false;
        }
    }

     function getPopupForAdmin($actionname,$themecall=null,$wpjobportal_pageid=null) {
        $uid = WPJOBPORTALRequest::getVar('userid');
        $module = WPJOBPORTALRequest::getVar('module');
        if($wpjobportal_pageid == null){
            $wpjobportal_pageid = wpjobportal::getPageid();
        }
        $result = $this->getActionDetailForpopup($actionname,$wpjobportal_pageid);

        if ($result != false) {
            $html = null;
            if(in_array('credits', wpjobportal::$_active_addons) && wpjobportal::$_config->getConfigValue('submission_type')==3){
                $autosubmit = false ;
            }else{
                $autosubmit = true ;
            }
            $isadmin = WPJOBPORTALRequest::getVar('isadmin');
            if($isadmin){
                $wpjobportalPopupResumeFormProceeds = 'wpjobportalPopupResumeFormProceedsAdmin';
                $wpjobportalPopupFormProceeds = 'wpjobportalPopupFormProceedsAdmin';
                $wpjobportalPopupProceeds = 'wpjobportalPopupProceedsAdmin';
                $proceedlang = __('Proceed Without Paying','wp-job-portal');
            }else{
                $wpjobportalPopupResumeFormProceeds = 'wpjobportalPopupResumeFormProceeds';
                $wpjobportalPopupFormProceeds = 'wpjobportalPopupFormProceeds';
                $wpjobportalPopupProceeds = 'wpjobportalPopupProceeds';
                $proceedlang = __('Proceed','wp-job-portal');
            }
            if($autosubmit == true){
                $objectid = WPJOBPORTALRequest::getVar('id');
                $srcid = WPJOBPORTALRequest::getVar('srcid');
                $anchorid = WPJOBPORTALRequest::getVar('anchorid');
                $formid = WPJOBPORTALRequest::getVar('formid');
                $action = 0;
                if(wpjobportal::$_common->wpjp_isadmin()){
                    if(is_array($result['value'])){
                        foreach($result['value'] AS $value){
                            $action = $value->id;
                        }
                    }elseif(is_numeric($result['value'])){
                        $action = $result['value'];
                    }

                }
                $action = '';
                if ($formid) { // popup in case of form is opened
                    if ($formid == 'resumeform') {
                        $html .= '<script >
                                    '.$wpjobportalPopupResumeFormProceeds.'(\'' . $action . '\');
                                </script>';
                    } else {
                        $html .= '<script >
                                    '.$wpjobportalPopupFormProceeds.'(\'' . $formid . '\',\'' . $action . '\');
                                </script>';
                    }
                } elseif ($srcid && $anchorid) { // popup in case of add to gold and feature
                    $html .= '<script >
                                '.$wpjobportalPopupProceeds.'(\'' . $actionname . '\',' . $objectid . ',\'' . $srcid . '\',\'' . $anchorid . '\',\'' . $action . '\',\'' . $themecall . '\');
                            </script>';
                } elseif($actionname == 'job_apply') { // popup in case of view company, resume, job contact detail
                    if($themecall != null){
                        $html .= '<script >
                                getApplyNowByJobid('. $objectid . ',' . $wpjobportal_pageid .',1);
                            </script>';
                    }else{
                        $html .= '<script >
                                getApplyNowByJobid('. $objectid . ',' . $wpjobportal_pageid .');
                            </script>';
                    }
                }else { // popup in case of view company, resume, job contact detail
                    $html .= '<script >
                                location.href= "' . $result['link'] . '";
                            </script>';
                }
            }elseif($themecall!=null){
                $credit_small_flag=0;
                $font_aw_value="";
                $absolute_class="";
                $s_class="";

                        $credit_small_flag=1;
                        $font_aw_value="fa-database";
                        $absolute_class=" ".$this->class_prefix."-fa-absolute ";
                        $s_class=" ".$this->class_prefix."-fa-small ";

                $html .= '<div id="'.$this->class_prefix.'-popup-background"></div>';
                $html .= '<div id="'.$this->class_prefix.'-popup">';
                $html .='<div class="'.$this->class_prefix.'-modal-wrp">
                            <div class="'.$this->class_prefix.'-modal-left-image-wrp">';
                                if($credit_small_flag==1){
                                    $html .='<i class="fa '.$font_aw_value. $s_class .' " aria-hidden="true" ></i>';
                                }
                            $html .='<i class="fa '.$font_aw_value. $absolute_class .' '.$this->class_prefix.'-modal-left-image" aria-hidden="true" ></i>
                            </div>
                            <div class="'.$this->class_prefix.'-modal-header">
                                <a title="close" class="'.$this->class_prefix.'-modal-close-icon-wrap" >
                                    <i class="fa fa-times-circle-o '.$this->class_prefix.'-modal-close-icon" aria-hidden="true"></i>
                                </a>
                                <h2 class="'.$this->class_prefix.'-modal-title">'. $result['title-text'] .' '.$result['title'].' </h2>
                            </div>
                            <div class="col-md-12 '.$this->class_prefix.'-modal-credit-row-wrp">
                                <div class="'.$this->class_prefix.'-modal-credit-row color">
                                    <span class="tit">'. __("Total Credits", "wp-job-portal") .'</span>
                                    <span class="val">'.$result['totalcredits'] .'</span>
                                </div>';
                $totalcredituse = 0;
                $action = 0;
                foreach ($result['value'] AS $value) {
                    $html .='<div class="'.$this->class_prefix.'-modal-credit-row">';
                    $html .='<span class="tit">';
                    if (sizeof($result['value']) > 1) {
                        $html .= '<input name="credits" type="radio" class="checkboxes" data-credits="' . $value->credits . '" data-totalcredits="' . $result['totalcredits'] . '" value=' . $value->id . ' />';
                        $action = -1;
                    } else {
                        $action = $value->id;
                    }
                    $html .= __('Credit for action', 'wp-job-portal');
                    $expirydatearray = array('featured_job','gold_job','add_job','featured_company','gold_company','featured_resume','gold_resume','job_alert_time');
                    if(in_array($value->creditaction, $expirydatearray)){
                        $html .= '<span class="expiry"> (' . __('Expire in', 'wp-job-portal') . ' ' . $value->expiry . ' ' . __('Days', 'wp-job-portal') . ')</span>';
                    }elseif($value->creditaction == 'job_alert_lifetime'){
                        $html .= '<span class="expiry"> ('.__('Life time alerts','wp-job-portal').') </span>';
                    }
                    $html .= '</span>';
                    $html .= '<span class="val">' . $value->credits . '</span>';
                    $html .= '</div>';
                    $totalcredituse = $value->credits;
                }

                $html .='<div class="'.$this->class_prefix.'-modal-credit-row color">';
                    $html .='<span class="tit" >'. __('Credits remaining after proceed', 'wp-job-portal') .'</span>';
                    $html .='<span class="val" id="remaing-credits">'. ($result['totalcredits'] - $totalcredituse) .'</span>';
                $html .='</div>';
                $html .='</div>';

                if($actionname == 'job_apply') {
                    $html .= '<div class="wpjobportal-job-apply-meesage">';
                    $html .= __('Credits will only be deducted if you select a resume and click Apply Now on next popup.', 'wp-job-portal');
                    $html .= '</div>';
                }

                $html .='<div class="col-md-11 col-md-offset-1 '.$this->class_prefix.'-modal-data-wrp">
                        <div class="modal-body '.$this->class_prefix.'-modal-body">
                              <div class="'.$this->class_prefix.'-modal-credit-action-btn-wrp">
                                  <a title="cancel" href="#" class="'.$this->class_prefix.'-modal-credit-action-btn" onclick="wpjobportalClosePopup(\''.$themecall.'\');">
                                      ' . __('Cancel', 'wp-job-portal') . '
                                  </a>';
                $objectid = WPJOBPORTALRequest::getVar('id');
                $srcid = WPJOBPORTALRequest::getVar('srcid');
                $anchorid = WPJOBPORTALRequest::getVar('anchorid');
                $formid = WPJOBPORTALRequest::getVar('formid');
                if ($formid) { // popup in case of form is opened
                    if ($formid == 'resumeform') {
                        $html .= '<a href="#" class="'.$this->class_prefix.'-modal-credit-action-btn color" onclick="'.$wpjobportalPopupResumeFormProceeds.'(\'' . $action . '\');">' . $proceedlang . '</a>';
                    }else {
                        $html .= '<a href="#" class="'.$this->class_prefix.'-modal-credit-action-btn color" onclick="'.$wpjobportalPopupFormProceeds.'(\'' . $formid . '\',\'' . $action . '\');">' . $proceedlang . '</a>';
                    }
                } elseif ($srcid && $anchorid) { // popup in case of add to gold and feature
                    $html .= '<a href="#" class="'.$this->class_prefix.'-modal-credit-action-btn color" onclick="'.$wpjobportalPopupProceeds.'(\'' . $actionname . '\',' . $objectid . ',\'' . $srcid . '\',\'' . $anchorid . '\',\'' . $action . '\',\''.$themecall.'\');">' . $proceedlang . '</a>';
                } elseif($actionname == 'job_apply') {
                        $html .= '<a href="#" class="'.$this->class_prefix.'-modal-credit-action-btn color" onclick="getApplyNowByJobid('. $objectid . ',' . $wpjobportal_pageid .',1);">' . $proceedlang . '</a>';
                }else { // popup in case of view company, resume, job contact detail
                    $html .= '<a href="' . $result['link'] .'" class="'.$this->class_prefix.'-modal-credit-action-btn color" onclick="return validateRemaingCredits();" >' . __('Proceed', 'wp-job-portal') . '</a>';
                }
                $html .='</div>
                        </div>
                    </div>
                </div>';
                $html .= '</div>';
            }else{
                $objectid = WPJOBPORTALRequest::getVar('id');
                $srcid = WPJOBPORTALRequest::getVar('srcid');
                $anchorid = WPJOBPORTALRequest::getVar('anchorid');
                $formid = WPJOBPORTALRequest::getVar('formid');
                if(!isset($action)){
                    $action = 0;
                }
                $html .= apply_filters('wpjobportal_addons_popup_admin_credits',false,$module,$uid,$formid,$action,$srcid,$anchorid,$actionname,$objectid,$proceedlang);
            }
        } else {
            $html = $this->getErrorPopupFor($actionname,$wpjobportal_pageid=null,$themecall=null);
        }
        return $html;
    }

    function getPopupFor($actionname,$themecall=null,$wpjobportal_pageid=null) {

        if($wpjobportal_pageid == null){
            $wpjobportal_pageid = wpjobportal::getPageid();
        }

        $result = true/*$this->getActionDetailForpopup($actionname,$wpjobportal_pageid)*/;
        if ($result != false) {
            $html = null;
            $autosubmit = true;
            $isadmin = WPJOBPORTALRequest::getVar('isadmin');
            if($isadmin){
                $wpjobportalPopupResumeFormProceeds = 'wpjobportalPopupResumeFormProceedsAdmin';
                $wpjobportalPopupFormProceeds = 'wpjobportalPopupFormProceedsAdmin';
                $wpjobportalPopupProceeds = 'wpjobportalPopupProceedsAdmin';
                $proceedlang = __('Proceed Without Paying','wp-job-portal');
            }else{
                $wpjobportalPopupResumeFormProceeds = 'wpjobportalPopupResumeFormProceeds';
                $wpjobportalPopupFormProceeds = 'wpjobportalPopupFormProceeds';
                $wpjobportalPopupProceeds = 'wpjobportalPopupProceeds';
                $proceedlang = __('Proceed','wp-job-portal');
            }
            if($autosubmit == true){
                $objectid = WPJOBPORTALRequest::getVar('id');
                $srcid = WPJOBPORTALRequest::getVar('srcid');
                $anchorid = WPJOBPORTALRequest::getVar('anchorid');
                $formid = WPJOBPORTALRequest::getVar('formid');
                $action = 0;
               if(isset($result)){
                   /* foreach($result['value'] AS $value){
                        $action = $value->id;
                    }*/
                    $action = '';
                }
                if ($formid) { // popup in case of form is opened
                    if ($formid == 'resumeform') {
                        $html .= '<script >
                                    '.$wpjobportalPopupResumeFormProceeds.'(\'' . $action . '\');
                                </script>';
                    } else {
                        $html .= '<script >
                                    '.$wpjobportalPopupFormProceeds.'(\'' . $formid . '\',\'' . $action . '\');
                                </script>';
                    }
                } elseif ($srcid && $anchorid) { // popup in case of add to gold and feature
                    $html .= '<script >
                                '.$wpjobportalPopupProceeds.'(\'' . $actionname . '\',' . $objectid . ',\'' . $srcid . '\',\'' . $anchorid . '\',\'' . $action . '\',\'' . $themecall . '\');
                            </script>';
                } elseif($actionname == 'job_apply') { // popup in case of view company, resume, job contact detail
                    if($themecall != null){
                        $html .= '<script >
                                getApplyNowByJobid('. $objectid . ',' . $wpjobportal_pageid .',1);
                            </script>';
                    }else{
                        $html .= '<script >
                                getApplyNowByJobid('. $objectid . ',' . $wpjobportal_pageid .');
                            </script>';
                    }
                }else { // popup in case of view company, resume, job contact detail
                    $html .= '<script >
                                location.href= "' . $result['link'] . '";
                            </script>';
                }
            }elseif($themecall!=null){
                $credit_small_flag=0;
                $font_aw_value="";
                $absolute_class="";
                $s_class="";

                        $credit_small_flag=1;
                        $font_aw_value="fa-database";
                        $absolute_class=" ".$this->class_prefix."-fa-absolute ";
                        $s_class=" ".$this->class_prefix."-fa-small ";

                $html .= '<div id="'.$this->class_prefix.'-popup-background"></div>';
                $html .= '<div id="'.$this->class_prefix.'-popup">';
                $html .='<div class="'.$this->class_prefix.'-modal-wrp">
                            <div class="'.$this->class_prefix.'-modal-left-image-wrp">';
                                if($credit_small_flag==1){
                                    $html .='<i class="fa '.$font_aw_value. $s_class .' " aria-hidden="true" ></i>';
                                }
                            $html .='<i class="fa '.$font_aw_value. $absolute_class .' '.$this->class_prefix.'-modal-left-image" aria-hidden="true" ></i>
                            </div>
                            <div class="'.$this->class_prefix.'-modal-header">
                                <a title="close" class="'.$this->class_prefix.'-modal-close-icon-wrap" >
                                    <i class="fa fa-times-circle-o '.$this->class_prefix.'-modal-close-icon" aria-hidden="true"></i>
                                </a>
                                <h2 class="'.$this->class_prefix.'-modal-title">'. $result['title-text'] .' '.$result['title'].' </h2>
                            </div>
                            <div class="col-md-12 '.$this->class_prefix.'-modal-credit-row-wrp">
                                <div class="'.$this->class_prefix.'-modal-credit-row color">
                                    <span class="tit">'. __("Total Credits", "wp-job-portal") .'</span>
                                    <span class="val">'.$result['totalcredits'] .'</span>
                                </div>';
                $totalcredituse = 0;
                $action = 0;
                foreach ($result['value'] AS $value) {
                    $html .='<div class="'.$this->class_prefix.'-modal-credit-row">';
                    $html .='<span class="tit">';
                    if (sizeof($result['value']) > 1) {
                        $html .= '<input name="credits" type="radio" class="checkboxes" data-credits="' . $value->credits . '" data-totalcredits="' . $result['totalcredits'] . '" value=' . $value->id . ' />';
                        $action = -1;
                    } else {
                        $action = $value->id;
                    }
                    $html .= __('Credit for action', 'wp-job-portal');
                    $expirydatearray = array('featured_job','gold_job','add_job','featured_company','gold_company','featured_resume','gold_resume','job_alert_time');
                    if(in_array($value->creditaction, $expirydatearray)){
                        $html .= '<span class="expiry"> (' . __('Expire in', 'wp-job-portal') . ' ' . $value->expiry . ' ' . __('Days', 'wp-job-portal') . ')</span>';
                    }elseif($value->creditaction == 'job_alert_lifetime'){
                        $html .= '<span class="expiry"> ('.__('Life time alerts','wp-job-portal').') </span>';
                    }
                    $html .= '</span>';
                    $html .= '<span class="val">' . $value->credits . '</span>';
                    $html .= '</div>';
                    $totalcredituse = $value->credits;
                }

                $html .='<div class="'.$this->class_prefix.'-modal-credit-row color">';
                    $html .='<span class="tit" >'. __('Credits remaining after proceed', 'wp-job-portal') .'</span>';
                    $html .='<span class="val" id="remaing-credits">'. ($result['totalcredits'] - $totalcredituse) .'</span>';
                $html .='</div>';
                $html .='</div>';

                if($actionname == 'job_apply') {
                    $html .= '<div class="wpjobportal-job-apply-meesage">';
                    $html .= __('Credits will only be deducted if you select a resume and click Apply Now on next popup.', 'wp-job-portal');
                    $html .= '</div>';
                }

                $html .='<div class="col-md-11 col-md-offset-1 '.$this->class_prefix.'-modal-data-wrp">
                        <div class="modal-body '.$this->class_prefix.'-modal-body">
                              <div class="'.$this->class_prefix.'-modal-credit-action-btn-wrp">
                                  <a title="cancel" href="#" class="'.$this->class_prefix.'-modal-credit-action-btn" onclick="wpjobportalClosePopup(\''.$themecall.'\');">
                                      ' . __('Cancel', 'wp-job-portal') . '
                                  </a>';
                $objectid = WPJOBPORTALRequest::getVar('id');
                $srcid = WPJOBPORTALRequest::getVar('srcid');
                $anchorid = WPJOBPORTALRequest::getVar('anchorid');
                $formid = WPJOBPORTALRequest::getVar('formid');
                if ($formid) { // popup in case of form is opened
                    if ($formid == 'resumeform') {
                        $html .= '<a href="#" class="'.$this->class_prefix.'-modal-credit-action-btn color" onclick="'.$wpjobportalPopupResumeFormProceeds.'(\'' . $action . '\');">' . $proceedlang . '</a>';
                    }else {
                        $html .= '<a href="#" class="'.$this->class_prefix.'-modal-credit-action-btn color" onclick="'.$wpjobportalPopupFormProceeds.'(\'' . $formid . '\',\'' . $action . '\');">' . $proceedlang . '</a>';
                    }
                } elseif ($srcid && $anchorid) { // popup in case of add to gold and feature
                    $html .= '<a href="#" class="'.$this->class_prefix.'-modal-credit-action-btn color" onclick="'.$wpjobportalPopupProceeds.'(\'' . $actionname . '\',' . $objectid . ',\'' . $srcid . '\',\'' . $anchorid . '\',\'' . $action . '\',\''.$themecall.'\');">' . $proceedlang . '</a>';
                } elseif($actionname == 'job_apply') {
                        $html .= '<a href="#" class="'.$this->class_prefix.'-modal-credit-action-btn color" onclick="getApplyNowByJobid('. $objectid . ',' . $wpjobportal_pageid .',1);">' . $proceedlang . '</a>';
                }else { // popup in case of view company, resume, job contact detail
                    $html .= '<a href="' . $result['link'] .'" class="'.$this->class_prefix.'-modal-credit-action-btn color" onclick="return validateRemaingCredits();" >' . __('Proceed', 'wp-job-portal') . '</a>';
                }
                $html .='</div>
                        </div>
                    </div>
                </div>';
                $html .= '</div>';
            }else{
                $html .= '<div id="wpjobportal-popup-background"></div>';
                $html .= '<div id="wpjobportal-popup">';
                $html .= '<img class="jsicon" src="' . WPJOBPORTAL_PLUGIN_URL . 'includes/images/popup-coin-icon.png"/>';
                $html .= '<span class="popup-title">' . $result['popuptitle'] . '<img id="popup_cross" alt="popup cross"  src="' . WPJOBPORTAL_PLUGIN_URL . 'includes/images/popup-close.png"></span>';
                $html .= '<div class="popup-row name">';
                $html .= '<span class="title">' . $result['title-text'] . ' </span><span class="value">' . $result['title'] . '</span></div>';
                $html .= '<div class="popup-row name"><span class="title">' . __('Total Credits', 'wp-job-portal') . '</span>';
                $html .= '<span class="value">' . $result['totalcredits'] . '</span>';
                $html .= '</div>';
                $totalcredituse = 0;
                $action = 0;
                foreach ($result['value'] AS $value) {
                    $html .= '<div class="popup-row name">';
                    $html .= '<span class="title">';
                    if (sizeof($result['value']) > 1) {
                        $html .= '<input name="credits" type="radio" class="checkboxes" data-credits="' . $value->credits . '" data-totalcredits="' . $result['totalcredits'] . '" value=' . $value->id . ' />';
                        $action = -1;
                    } else {
                        $action = $value->id;
                    }
                    $html .= __('Credit for action', 'wp-job-portal');
                    $expirydatearray = array('featured_job','gold_job','add_job','featured_company','gold_company','featured_resume','gold_resume','job_alert_time');
                    if(in_array($value->creditaction, $expirydatearray)){
                        $html .= '<span class="expiry"> (' . __('Expire in', 'wp-job-portal') . ' ' . $value->expiry . ' ' . __('Days', 'wp-job-portal') . ')</span>';
                    }elseif($value->creditaction == 'job_alert_lifetime'){
                        $html .= '<span class="expiry"> ('.__('Life time alerts','wp-job-portal').') </span>';
                    }
                    $html .= '</span>';
                    $html .= '<span class="value">' . $value->credits . '</span>';
                    $html .= '</div>';
                    $totalcredituse = $value->credits;
                }
                $html .= '<div class="popup-row name">';
                $html .= '<span class="title">' . __('Credits remaining after proceed', 'wp-job-portal') . '</span>';
                $html .= '<span class="value" id="remaing-credits">' . ($result['totalcredits'] - $totalcredituse) . '</span>';
                $html .= '</div>';
                if($actionname == 'job_apply') {
                    $html .= '<div class="wpjobportal-job-apply-meesage">';
                    $html .= __('Credits will only be deducted if you select a resume and click Apply Now on next popup.', 'wp-job-portal');
                    $html .= '</div>';
                }

                $html .= '<div class="popup-row button">';
                $html .= '<a href="#" class="wpjobportal-popup cancel" onclick="wpjobportalClosePopup();">' . __('Cancel', 'wp-job-portal') . '</a>';
                $objectid = WPJOBPORTALRequest::getVar('id');
                $srcid = WPJOBPORTALRequest::getVar('srcid');
                $anchorid = WPJOBPORTALRequest::getVar('anchorid');
                $formid = WPJOBPORTALRequest::getVar('formid');
                if ($formid) { // popup in case of form is opened
                    if ($formid == 'resumeform') {
                        $html .= '<a href="#" class="wpjobportal-popup proceed" onclick="'.$wpjobportalPopupResumeFormProceeds.'(\'' . $action . '\');">' . $proceedlang . '</a>';
                        if($isadmin){
                            $html .= '<a href="#" class="wpjobportal-popup proceed" onclick="'.$wpjobportalPopupResumeFormProceeds.'(\'' . $action . '\',1);">' . __('Proceed With Paying', 'wp-job-portal') . '</a>';
                        }
                    } else {
                        $html .= '<a href="#" class="wpjobportal-popup proceed" onclick="'.$wpjobportalPopupFormProceeds.'(\'' . $formid . '\',\'' . $action . '\');">' . $proceedlang . '</a>';
                        if($isadmin){
                            $html .= '<a href="#" class="wpjobportal-popup proceed" onclick="'.$wpjobportalPopupFormProceeds.'(\'' . $formid . '\',\'' . $action . '\',1);">' . __('Proceed With Paying', 'wp-job-portal') . '</a>';
                        }
                    }
                     $html .= '<a href="#" class="wpjobportal-popup proceed" onclick="'.$wpjobportalPopupProceeds.'(\'' . $actionname . '\',' . $objectid . ',\'' . $srcid . '\',\'' . $anchorid . '\',\'' . $action . '\');">' . $proceedlang . '</a>';
                    if($isadmin){
                        $html .= '<a href="#" class="wpjobportal-popup proceed" onclick="'.$wpjobportalPopupProceeds.'(\'' . $actionname . '\',' . $objectid . ',\'' . $srcid . '\',\'' . $anchorid . '\',\'' . $action . '\',1);">' . __('Proceed With Paying', 'wp-job-portal') . '</a>';
                    }
                } elseif($actionname == 'job_apply') {
                        $html .= '<a href="#" class="wpjobportal-popup proceed" onclick="getApplyNowByJobid('. $objectid . ',' . $wpjobportal_pageid .');">' . $proceedlang . '</a>';
                } else { // popup in case of view company, resume, job contact detail
                    $html .= '<a href="' . $result['link'] . '" class="proceed" onclick="return validateRemaingCredits();" >' . __('Proceed', 'wp-job-portal') . '</a>';
                }
                $html .= '</div>';
                $html .= '</div>';
            }
        } else {
            $html = $this->getErrorPopupFor($actionname,$wpjobportal_pageid=null,$themecall=null);
        }
        return $html;
    }
    function getErrorPopupFor($actionname,$wpjobportal_pageid=null,$themecall=null,$result= false) {
        if(null != $themecall){
            $html = $this->getErrorPopupForJobManager($actionname,$result);
        }else{
            if($wpjobportal_pageid != null){
                $pageid = $wpjobportal_pageid;
            }else{
                $pageid = wpjobportal::getpageId();
            }
            $html = '<div id="wpjobportal-popup-background"></div>';
            $html .= '<div id="wpjobportal-popup">';
            if($result == false){
                $html .= '<span class="popup-title">' . __('Insufficient Credits', 'wp-job-portal') . '</span>';
                $actionfor = WPJOBPORTALincluder::getJSModel('credits')->getCreditsForByAction($actionname);
                if ($actionfor == 2) {
                    $link = wpjobportal::makeUrl(array('wpjobportalme'=>'credits', 'wpjobportallt'=>'jobseekercredits', 'wpjobportalpageid'=>$pageid));
                } else {
                    $link = wpjobportal::makeUrl(array('wpjobportalme'=>'credits', 'wpjobportallt'=>'employercredits', 'wpjobportalpageid'=>$pageid));
                }
                $linktext = __('Buy credits', 'wp-job-portal');
                $html .= WPJOBPORTALLayout::setMessageFor(4, $link, $linktext, 1);
            }else{
                $html .= '<span class="popup-title">' . __('Can Not Proceed', 'wp-job-portal') . '</span>';

                $html .= WPJOBPORTALLayout::setMessageFor(11,'','',1);
            }
            $html .= '</div>';
            $html .= '</div>';

        }
        return $html;
    }

    private function getActionDetailForpopup($actionname,$wpjobportal_pageid = '') {
        $return = false;
        $return['totalcredits'] = 12;
        if($actionname == 'copy_job'){
            $actionfor = 'add_job';
        }else{
            $actionfor = $actionname;
        }
        $creditsrequired = 4;

        switch ($actionname) {
            case 'featured_company':
                $return['popuptitle'] = __('Add to','wp-job-portal') .' '. __('featured','wp-job-portal') .' '. __('company', 'wp-job-portal');
                $id = WPJOBPORTALRequest::getVar('id');
                $companyname = WPJOBPORTALincluder::getJSModel('company')->getCompanynameById($id);
                $return['title-text'] = __('Company name', 'wp-job-portal');
                $return['title'] = $companyname;
                $return['value'] = $creditsrequired;
                break;
            case 'featured_job':
                $return['popuptitle'] = __('Add to','wp-job-portal') .' '. __('featured','wp-job-portal') .' '. __('job', 'wp-job-portal');
                $id = WPJOBPORTALRequest::getVar('id');
                $jobtile = WPJOBPORTALincluder::getJSModel('job')->getJobTitleById($id);
                $return['title-text'] = __('Job title', 'wp-job-portal');
                $return['title'] = $jobtile;
                $return['value'] = $creditsrequired;
                break;
            case 'featured_resume':
                $return['popuptitle'] = __('Add to','wp-job-portal') .' '. __('featured','wp-job-portal') .' '. __('resume', 'wp-job-portal');
                $id = WPJOBPORTALRequest::getVar('id');
                $resumetile = WPJOBPORTALincluder::getJSModel('resume')->getResumeTitleById($id);
                $return['title-text'] = __('Resume title', 'wp-job-portal');
                $return['title'] = $resumetile;
                $return['value'] = $creditsrequired;
                break;
            case 'add_department':
                $return['popuptitle'] = __('Add','wp-job-portal') .' '. __('Department', 'wp-job-portal');
                $return['title-text'] = __('Add','wp-job-portal') .' '. __('Department', 'wp-job-portal');
                $return['title'] = ' ';
                $return['value'] = $creditsrequired;
                break;
            case 'add_job':
                $return['popuptitle'] = __('Add','wp-job-portal') .' '. __('Job', 'wp-job-portal');
                $return['title-text'] = __('Add','wp-job-portal') .' '. __('job', 'wp-job-portal');
                $return['title'] = ' ';
                $return['value'] = $creditsrequired;
                break;
            case 'copy_job':
                $return['popuptitle'] = __('Copy','wp-job-portal') .' '. __('Job', 'wp-job-portal');
                $return['title-text'] = __('Copy','wp-job-portal') .' '. __('Job', 'wp-job-portal');
                $return['title'] = ' ';
                $return['value'] = $creditsrequired;
                break;
            case 'add_company':
                $return['popuptitle'] = __('Add','wp-job-portal') .' '. __('Company', 'wp-job-portal');
                $return['title-text'] = __('Add','wp-job-portal') .' '. __('Company', 'wp-job-portal');
                $return['title'] = ' ';
                $return['value'] = $creditsrequired;
                break;
            case 'add_resume':
                $return['popuptitle'] = __('Add','wp-job-portal') .' '. __('Resume', 'wp-job-portal');
                $return['title-text'] = __('Add','wp-job-portal') .' '. __('Resume', 'wp-job-portal');
                $return['title'] = ' ';
                $return['value'] = $creditsrequired;
                break;
            case 'add_job_alert':
                $return['popuptitle'] = __('Add','wp-job-portal') .' '. __('Alert', 'wp-job-portal');
                $return['title-text'] = __('Add','wp-job-portal') .' '. __('Alert', 'wp-job-portal');
                $return['title'] = ' ';
                $return['value'] = $creditsrequired;
                break;
            case 'view_company_contact_detail':
                $return['popuptitle'] = __('View company contact detail', 'wp-job-portal');
                $id = WPJOBPORTALRequest::getVar('id');
                $companyname = WPJOBPORTALincluder::getJSModel('company')->getCompanynameById($id);
                $return['title-text'] = __('View company contact detail', 'wp-job-portal');
                $return['title'] = $companyname;
                $return['value'] = $creditsrequired;
                $return['link'] = wpjobportal::makeUrl(array('wpjobportalme'=>'company', 'action'=>'wpjobportaltask', 'task'=>'addviewcontactdetail', 'companyid'=>$id, 'wpjobportalpageid'=>$wpjobportal_pageid));
                break;
            case 'view_resume_contact_detail':
                $return['popuptitle'] = __('View resume contact detail', 'wp-job-portal');
                $id = WPJOBPORTALRequest::getVar('id');
                $resumename = WPJOBPORTALincluder::getJSModel('resume')->getResumenameById($id);
                $return['title-text'] = __('View resume contact detail', 'wp-job-portal');
                $return['title'] = $resumename;
                $return['value'] = $creditsrequired;
                $return['link'] = wpjobportal::makeUrl(array('wpjobportalme'=>'resume', 'action'=>'wpjobportaltask', 'task'=>'addviewresumedetail', 'resumeid'=>$id, 'wpjobportalpageid'=>$wpjobportal_pageid));
                break;
            case 'resume_save_search':
                $return['popuptitle'] = __('Save','wp-job-portal') .' '. __('search', 'wp-job-portal');
                $return['title-text'] = __('Save','wp-job-portal') .' '. __('search', 'wp-job-portal');
                $return['title'] = ' ';
                $return['value'] = $creditsrequired;
                break;
            case 'job_apply':
                $return['popuptitle'] = __('Apply On Job');
                $id = WPJOBPORTALRequest::getVar('id');
                $jobtile = WPJOBPORTALincluder::getJSModel('job')->getJobTitleById($id);
                $return['title-text'] = __('Job title', 'wp-job-portal');
                $return['title'] = $jobtile;
                $return['value'] = $creditsrequired;
                break;
        }
        return $return;
    }
}


