<?php
if (!defined('ABSPATH'))
    die('Restricted Access');

class WPJOBPORTALcustomfields {
    public $class_prefix = '';

    function __construct(){
        if(wpjobportal::$theme_chk == 1){
            $this->class_prefix = 'jsjb-jm';
        }elseif(wpjobportal::$theme_chk == 2){
            $this->class_prefix = 'jsjb-jh';
        }
    }

    function formCustomFieldsResume($field , $obj_id, $obj_params ,$resumeform=null,  $section = null, $sectionid = null, $ishidden = null,$themecall=null){
        //had to do this so that there are minimum changes in resume code
        $field = $this->userFieldData($field->field, 5, $section);
        //$field = $this->userFieldData($field, 5, $section);
        if (empty($field)) {
            return '';
        }
        //if(!in_array('customfield', wpjobportal::$_active_addons)){
        //    if($field->userfieldtype != 'text' && $field->userfieldtype != 'email'){
        //        return '';
        //    }
        //}
        $themebfclass = " ".$this->class_prefix."-bigfont ";
        if(null != $themecall){
            $div1 = 'resume-row-wrapper form wjportal-form-row';
            $div2 = 'row-title wjportal-form-title';
            $div3 = 'row-value wjportal-form-value';
        }else{
            $div1 = 'resume-row-wrapper form wjportal-form-row';
            $div2 = 'row-title wjportal-form-title';
            $div3 = 'row-value wjportal-form-value';

        }
        $cssclass = "";
        $required = $field->required;
        $html = '<div class="' . $div1 . '">
               <div class="' . $div2 . '">';
        if ($required == 1) {
            $html .= __($field->fieldtitle,'wp-job-portal') . ' <font color="red"> *</font>';
            // if ($field->userfieldtype == 'email'){
            //     //$cssclass = "required validate-email";
            //     if($section AND $section == null){ // too handle bug related to sub section email field
            //         $cssclass = "required email";
            //     }
            // }else{
                $cssclass = "required";
            // }
        }else {
            $html .= __($field->fieldtitle,'wp-job-portal');
            // if ($field->userfieldtype == 'email'){
            //     if($section AND $section == null){ // too handle bug related to sub section email field
            //         //$cssclass = "validate-email";
            //         $cssclass = "required email";
            //     }
            // }else{
                $cssclass = "";
            // }
        }
        $html .= ' </div><div class="' . $div3 . '">';

        $resumeTitle = __($field->fieldtitle,'wp-job-portal');

        $size = '';
        $maxlength = '';
        if(isset($field->size) && 0!=$field->size){
            $size = $field->size;
        }
        if(isset($field->maxlength) && 0!=$field->maxlength){
            $maxlength = $field->maxlength;
        }

        $fvalue = "";
        $value = "";
        $userdataid = "";
        $value = $obj_params;

        if($value){ // data has been stored
            $userfielddataarray = json_decode($value);
            $valuearray = json_decode($value,true);
        }else{
            $valuearray = array();
        }
        if(array_key_exists($field->field, $valuearray)){
            $value = $valuearray[$field->field];
        }else{
            $value = '';
        }
        $user_field = '';
        if($themecall != null){
            $theme_string = ', '. $themecall;
        }else{
            $theme_string = '';
        }
        switch ($field->userfieldtype) {
            case 'text':
                if(wpjobportal::$theme_chk == 1){
                    $themeclass = getJobManagerThemeClass('text');
                }elseif(wpjobportal::$theme_chk == 2){
                    $themeclass = getJobHubThemeClass('text');
                }else{
                    $themeclass = '';
                }
                $extraattr = array('class' => "inputbox one $cssclass $themeclass wjportal-form-input-field", 'data-validation' => $cssclass, 'size' => $size, 'maxlength' => $maxlength, 'placeholder'=>$field->placeholder);
                // handleformresume
                if($section AND $section != 1){
                    if($ishidden){
                        if ($required == 1) {
                            $extraattr['data-validation'] = '';
                            $extraattr['data-myrequired'] = $cssclass;
                            $extraattr['class'] = "inputbox one $themeclass wjportal-form-input-field";
                        }
                    }
                }
                //END handleformresume
                $user_field .= $this->textResume($field->field, $value, $extraattr, $section , $sectionid);
            break;
            case 'email':
                if(wpjobportal::$theme_chk == 1){
                    $themeclass = getJobManagerThemeClass('text');
                }elseif(wpjobportal::$theme_chk == 2){
                    $themeclass = getJobHubThemeClass('text');
                }else{
                    $themeclass = '';
                }
                $extraattr = array('class' => "inputbox one $cssclass $themeclass wjportal-form-input-field", 'data-validation' => $cssclass, 'size' => $size, 'maxlength' => $maxlength, 'placeholder'=>$field->placeholder);
                // handleformresume
                if($section AND $section != 1){
                    if($ishidden){
                        if ($required == 1) {
                            $extraattr['data-validation'] = '';
                            $extraattr['data-myrequired'] = $cssclass;
                            $extraattr['class'] = "inputbox one $themeclass wjportal-form-input-field";
                        }
                    }
                }
                //END handleformresume
                $user_field .= $this->emailResume($field->field, $value, $extraattr, $section , $sectionid);
            break;
            case 'date':
                    if(wpjobportal::$theme_chk == 1){
                        $themeclass = getJobManagerThemeClass('text');
                    }elseif(wpjobportal::$theme_chk == 2){
                        $themeclass = getJobHubThemeClass('text');
                    }else{
                        $themeclass = '';
                    }
                    $req=($field->required==1)?"required":"";
                    $extraattr = array('class' => 'inputbox wjportal-form-date-field custom_date cal_userfield  '.$themeclass.' '.$cssclass, 'size' => '10', 'maxlength' => '19','data-validation'=>$req,'autocomplete'=>'off', 'placeholder'=>$field->placeholder);
                    // handleformresume
                    if($section AND $section != 1){
                        if($ishidden){
                            if ($required == 1) {
                                $extraattr['data-validation'] = '';
                                $extraattr['data-myrequired'] = $cssclass;
                                $extraattr['class'] = "inputbox wjportal-form-date-field custom_date cal_userfield  ".$themeclass." ".$cssclass;
                            }
                        }
                    }
                    //END handleformresume
                    $user_field .= $this->dateResume($field->field, $value, $extraattr, $section , $sectionid);
            break;
            /*case 'textarea':
                $rows = '';
                $cols = '';
                if(isset($field->rows)){
                    $rows = $field->rows;
                }
                if(isset($field->cols)){
                    $cols = $field->cols;
                }
                if(wpjobportal::$theme_chk == 1){
                    $themeclass = getJobManagerThemeClass('textarea');
                }elseif(wpjobportal::$theme_chk == 2){
                    $themeclass = getJobHubThemeClass('textarea');
                }else{
                    $themeclass = '';
                }

                $extraattr = array('class' => "inputbox one $cssclass $themeclass", 'data-validation' => $cssclass, 'rows' => $rows, 'cols' => $cols);
                // handleformresume
                if($section AND $section != 1){
                    if($ishidden){
                        if ($required == 1) {
                            $extraattr['data-validation'] = '';
                            $extraattr['data-myrequired'] = $cssclass;
                            $extraattr['class'] = "inputbox one";
                        }
                    }
                }
                //END handleformresume

                $user_field .= $this->textareaResume($field->field, $value, $extraattr , $section , $sectionid);
            break;*/
            case 'checkbox':
                if (!empty($field->userfieldparams)) {
                    $comboOptions = array();
                    $obj_option = json_decode($field->userfieldparams);
                    $i = 0;
                    $valuearray = wpjobportalphplib::wpJP_explode(', ',$value);
                    $name = $field->field;
                    if (wpjobportalphplib::wpJP_strpos($name, '[]') !== false) {
                        $id = wpjobportalphplib::wpJP_str_replace('[]', '', $name);
                    }else{
                        $id = $name;
                    }
                    $data_required = '';
                    if($section){
                        if($section != 1){
                            if($ishidden){
                                if($required == 1){
                                    $data_required = 'data-myrequired="required"';
                                    $cssclass = '';
                                }
                            }
                            $name = 'sec_'.$section.'['.$name.']['.$sectionid.']';
                            $id .=$sectionid;
                        }else{
                            $name = 'sec_'.$section.'['.$name.']';
                        }
                    }

                    $jsFunction = '';
                    if ($required == 1) {
                        $jsFunction = "deRequireUfCheckbox('" . $field->field . "');";
                    }
                    foreach ($obj_option AS $option) {
                        $check = '';
                        if(in_array($option, $valuearray)){
                            $check = 'checked';
                        }
                        $user_field .= '<span class="uf_checkbox_wrp">';
                        $user_field .= '<input type="checkbox" ' . $check . ' '.$data_required.' class="'. $field->field .' radiobutton uf_of_type_ckbox '.$cssclass.'" value="' . $option . '" id="' . $id . '_' . $i . '" name="' . $name . '[]" data-validation="'.$cssclass.'" onclick = "' . $jsFunction . '" ckbox-group-name="' . $field->field . '">';
                        $user_field .= '<label class="cf_chkbox" for="' . $id . '_' . $i . '" id="foruf_checkbox1">' . $option . '</label>';
                        $user_field .= '</span>';
                        $i++;
                    }
                } else {
                    $comboOptions = array('1' => __($field->fieldtitle,'wp-job-portal'));
                    $extraattr = array('class' => "radiobutton $cssclass");
                    // handleformresume
                    if($section AND $section != 1){
                        if($ishidden){
                            if ($required == 1) {
                                $extraattr['data-validation'] = '';
                                $extraattr['data-myrequired'] = $cssclass;
                                $extraattr['class'] = "radiobutton";
                            }
                        }
                    }
                    //END handleformresume
                    $user_field .= $this->checkboxResume($field->field, $comboOptions, $value, array('class' => "radiobutton $cssclass") , $section , $sectionid);
                }
            break;
            case 'radio':
                $comboOptions = array();
                if (!empty($field->userfieldparams)) {
                    $obj_option = json_decode($field->userfieldparams);
                    for ($i = 0; $i < count($obj_option); $i++) {
                        $comboOptions[$obj_option[$i]] = __($obj_option[$i],'wp-job-portal');
                    }
                }
                $jsFunction = '';
                if ($field->depandant_field != null) {
                    $jsFunction = "getDataForDepandantFieldResume('" . $field->field . "','" . $field->depandant_field . "',2,'".$section."','".$sectionid."'". $theme_string.");";
                }
                $extraattr = array('class' => "cf_radio radiobutton $cssclass" , 'data-validation' => $cssclass, 'onclick' => $jsFunction);
                // handleformresume
                if($section AND $section != 1){
                    if($ishidden){
                        if ($required == 1) {
                            $extraattr['data-validation'] = '';
                            $extraattr['data-myrequired'] = $cssclass;
                            $extraattr['class'] = "cf_radio radiobutton";
                        }
                    }
                }
                //END handleformresume

                $user_field .= $this->radiobuttonResume($field->field, $comboOptions, $value, $extraattr , $section , $sectionid);
            break;
            case 'combo':
                if(wpjobportal::$theme_chk == 1){
                    $themeclass = getJobManagerThemeClass('select');
                }elseif(wpjobportal::$theme_chk == 2){
                    $themeclass = getJobHubThemeClass('select');
                }else{
                    $themeclass = '';
                }
                $comboOptions = array();
                if (!empty($field->userfieldparams)) {
                    $obj_option = json_decode($field->userfieldparams);
                    foreach ($obj_option as $opt) {
                        $comboOptions[] = (object) array('id' => $opt, 'text' => __($opt,'wp-job-portal'));
                    }
                }
                //code for handling dependent field
                $jsFunction = '';
                if ($field->depandant_field != null) {
                    $jsFunction = "getDataForDepandantFieldResume('" . $field->field . "','" . $field->depandant_field . "',1,'".$section."','".$sectionid."'". $theme_string.");";
                }
                if ($field->placeholder != '') {
                    $placeholder = $field->placeholder;
                } else {
                    $placeholder = __('Select', 'wp-job-portal') . ' ' . $field->fieldtitle;
                }
                //end
                $extraattr = array('data-validation' => $cssclass, 'onchange' => $jsFunction, 'class' => "inputbox wjportal-form-select-field one $cssclass $themeclass");
                // handleformresume
                if($section AND $section != 1){
                    if($ishidden){
                        if ($required == 1) {
                            $extraattr['data-validation'] = '';
                            $extraattr['data-myrequired'] = $cssclass;
                            $extraattr['class'] = "inputbox wjportal-form-select-field one";
                        }
                    }
                }
                //END handleformresume

                $user_field .= $this->selectResume($field->field, $comboOptions, $value, $placeholder, $extraattr , null,$section , $sectionid);
            break;
            /*case 'depandant_field':
                if(wpjobportal::$theme_chk == 1){
                    $themeclass = getJobManagerThemeClass('select');
                }elseif(wpjobportal::$theme_chk == 2){
                    $themeclass = getJobHubThemeClass('select');
                }else{
                    $themeclass = '';
                }
                $comboOptions = array();
                if ($value != null) {
                    if (!empty($field->userfieldparams)) {
                        $obj_option = $this->getDataForDepandantFieldByParentField($field->field, $userfielddataarray);
                        foreach ($obj_option as $opt) {
                            $comboOptions[] = (object) array('id' => $opt, 'text' => __($opt,'wp-job-portal'));
                        }
                    }
                }
                //code for handling dependent field
                $jsFunction = '';
                if ($field->depandant_field != null) {
                    $jsFunction = "getDataForDepandantFieldResume('" . $field->field . "','" . $field->depandant_field . "','".$section."','".$sectionid."'". $theme_string.");";
                }
                //end
                $extraattr = array('data-validation' => $cssclass, 'class' => "inputbox one $cssclass $themeclass");
                if(""!=$jsFunction){
                    $extraattr['onchange']=$jsFunction;
                }
                // handleformresume
                if($section AND $section != 1){
                    if($ishidden){
                        if ($required == 1) {
                            $extraattr['data-validation'] = '';
                            $extraattr['data-myrequired'] = $cssclass;
                            $extraattr['class'] = "inputbox one";
                        }
                    }
                }
                //END handleformresume
                $user_field .= $this->selectResume($field->field, $comboOptions, $value, __('Select','wp-job-portal') . ' ' . $field->fieldtitle, $extraattr , null, $section , $sectionid);
            break;
            case 'multiple':
                if(wpjobportal::$theme_chk == 1){
                    $themeclass = getJobManagerThemeClass('select');
                }elseif(wpjobportal::$theme_chk == 2){
                    $themeclass = getJobHubThemeClass('select');
                }else{
                    $themeclass = '';
                }
                $comboOptions = array();
                if (!empty($field->userfieldparams)) {
                    $obj_option = json_decode($field->userfieldparams);
                    foreach ($obj_option as $opt) {
                        $comboOptions[] = (object) array('id' => $opt, 'text' => __($opt,'wp-job-portal'));
                    }
                }
                $name = $field->field;
                $name .= '[]';
                $valuearray = wpjobportalphplib::wpJP_explode(', ', $value);
                $ismultiple = 1;
                $extraattr = array('data-validation' => $cssclass, 'multiple' => 'multiple', 'class' => "inputbox one $cssclass $themeclass");
                // handleformresume
                if($section AND $section != 1){
                    if($ishidden){
                        if ($required == 1) {
                            $extraattr['data-validation'] = '';
                            $extraattr['data-myrequired'] = $cssclass;
                            $extraattr['class'] = "inputbox one";
                        }
                    }
                }
                //END handleformresume
                $user_field .= $this->selectResume($name, $comboOptions, $valuearray, '', $extraattr , null ,$section , $sectionid , $ismultiple);
            break;
            case 'file':
                if($value != null){ // since file already uploaded so we reglect the required
                    $cssclass = wpjobportalphplib::wpJP_str_replace('required', '', $cssclass);
                }

                $name = $field->field;
                $data_required = '';
                if($section){
                    if($section != 1){
                        if($ishidden){
                            if($required == 1){
                                $data_required = 'data-myrequired="required"';
                                $cssclass = '';
                            }
                        }
                        $name = 'sec_'.$section.'['.$name.']['.$sectionid.']';
                    }else{
                        $name = 'sec_'.$section.'['.$name.']';
                    }
                }

                $user_field .= '<input type="file" class="'.$cssclass.' cf_uploadfile" '.$data_required.' name="'.$name.'" id="'.$field->field.'"/>';
                if(JFactory::getApplication()->isAdmin()){
                    $this->_config = JSModel::getJSModel('configuration')->getConfig();
                }else{
                    $this->_config = JSModel::getJSModel('configurations')->getConfig('');
                }
                $fileext  = '';
                foreach ($this->_config as $conf) {
                    if ($conf->configname == 'image_file_type'){
                        if($fileext)
                            $fileext .= ',';
                        $fileext .= $conf->configvalue;
                    }
                    if ($conf->configname == 'document_file_type'){
                        if($fileext)
                            $fileext .= ',';
                        $fileext .= $conf->configvalue;
                    }
                    if ($conf->configname == 'document_file_size')
                        $maxFileSize = $conf->configvalue;
                }

                $fileext = wpjobportalphplib::wpJP_explode(',', $fileext);
                $fileext = array_unique($fileext);
                $fileext = implode(',', $fileext);
                $user_field .= '<div id="js_cust_file_ext">'.__('Files','wp-job-portal').' ('.$fileext.')<br> '.__('Maximum Size','wp-job-portal').' '.$maxFileSize.'(kb)</div>';
                if($value != null){
                    $user_field .= $this->hidden($field->field.'_1', 0 , array(), $section , $sectionid);
                    $user_field .= $this->hidden($field->field.'_2',$value, array(), $section , $sectionid);
                    $jsFunction = "deleteCutomUploadedFile('".$field->field."','".$field->required."')";
                    $value = wpjobportalphplib::wpJP_explode('_', $value , 2);
                    $value = $value[1];
                    $user_field .='<span class='.$field->field.'_1>'.$value.'( ';
                    $user_field .= "<a href='javascript:void(0)' onClick=".$jsFunction." >". __('Delete','wp-job-portal')."</a>";
                    $user_field .= ' )</span>';
                }
            break;*/
        }
        $html .= $user_field;
        if (isset($field->description) && !empty($field->description)) {
            $html .= '<div class="wjportal-form-help-txt">'.$field->description.'</div>';
        }
        $html .= '</div></div>';
        if ($resumeform === 1) {
            return array('title' => $resumeTitle , 'value' => $user_field);
        }elseif($resumeform == 'admin'){
            return array('title' => $resumeTitle , 'value' => $user_field , 'lable' => $field->field);
        }elseif($resumeform == 'f_company'){
            return array('title' => $resumeTitle , 'value' => $user_field , 'lable' => $field->field);
        }else {
            return $html;
        }

    }

    static function selectResume($name, $list, $defaultvalue, $title = '', $extraattr = array() , $disabled = '',  $resume_section_id = null , $sectionid = null , $ismultiple = false) {
        if (wpjobportalphplib::wpJP_strpos($name, '[]') !== false) {
            $id = wpjobportalphplib::wpJP_str_replace('[]', '', $name);
        }else{
            $id = $name;
        }

        // handleformresume
        if($resume_section_id){
            if($resume_section_id != 1){
                if($ismultiple){
                    $name = wpjobportalphplib::wpJP_str_replace('[]', '', $name);
                    $name = 'sec_'.$resume_section_id.'['.$name.']['.$sectionid.'][]';
                    $id .=$sectionid;
                }else{
                    $name = 'sec_'.$resume_section_id.'['.$name.']['.$sectionid.']';
                    $id .=$sectionid;
                }
            }else{
                if($ismultiple){
                    $name = wpjobportalphplib::wpJP_str_replace('[]', '', $name);
                    $name = 'sec_'.$resume_section_id.'['.$name.'][]';
                }else{
                    $name = 'sec_'.$resume_section_id.'['.$name.']';
                }
            }
        }
        //END handleformresume

        $selectfield = '<select name="' . $name . '" id="' . $id . '" ';
        if (!empty($extraattr))
            foreach ($extraattr AS $key => $val) {
                $selectfield .= ' ' . $key . '="' . $val . '"';
            }
        if($disabled)
            $selectfield .= ' disabled>';
        else
            $selectfield .= ' >';
        if ($title != '') {
            $selectfield .= '<option value="">' . $title . '</option>';
        }
        if (!empty($list))
            foreach ($list AS $record) {
                if ((is_array($defaultvalue) && in_array($record->id, $defaultvalue)) || $defaultvalue == $record->id)
                    $selectfield .= '<option selected="selected" value="' . $record->id . '">' . __($record->text,'wp-job-portal') . '</option>';
                else
                    $selectfield .= '<option value="' . $record->id . '">' . __($record->text,'wp-job-portal') . '</option>';
            }

        $selectfield .= '</select>';
        return $selectfield;
    }



    static function radiobuttonResume($name, $list, $defaultvalue, $extraattr = array() , $resume_section_id = null , $sectionid = null) {
        if (wpjobportalphplib::wpJP_strpos($name, '[]') !== false) {
            $id = wpjobportalphplib::wpJP_str_replace('[]', '', $name);
        }else{
            $id = $name;
        }

        $radiobutton = '';
        $count = 1;
        $match = false;
        $firstvalue = '';
        foreach($list AS $value => $label){
            if($firstvalue == '')
                $firstvalue = $value;
            if($defaultvalue == $value){
                $match = true;
                break;
            }
        }
        if($match == false){
            //$defaultvalue = $firstvalue;
        }

        // handleformresume
        if($resume_section_id){
            if($resume_section_id != 1){
                $name = 'sec_'.$resume_section_id.'['.$name.']['.$sectionid.']';
                $id .=$sectionid;
            }else{
                $name = 'sec_'.$resume_section_id.'['.$name.']';
            }
        }
        //END handleformresume

        foreach ($list AS $value => $label) {
            $radiobutton .= '<span class="uf_radiobtn_wrp">';
            $radiobutton .= '<input type="radio" name="' . $name . '" id="' . $id . $count . '" value="' . $value . '"';
            if ($defaultvalue == $value){
                $radiobutton .= ' checked="checked"';
            }
            if (!empty($extraattr))
                foreach ($extraattr AS $key => $val) {
                    $radiobutton .= ' ' . $key . '="' . $val . '"';
                }
            $radiobutton .= '/><label id="for' . $id . '" class="cf_radiobtn" for="' . $id . $count . '">' . $label . '</label>';
            $radiobutton .= '</span>';
            $count++;
        }
        return $radiobutton;
    }



    static function checkboxResume($name, $list, $defaultvalue, $extraattr = array() , $resume_section_id = null , $sectionid = null) {

        if (wpjobportalphplib::wpJP_strpos($name, '[]') !== false) {
            $id = wpjobportalphplib::wpJP_str_replace('[]', '', $name);
        }else{
            $id = $name;
        }

        $checkbox = '';
        $count = 1;

        // handleformresume
        if($resume_section_id){
            if($resume_section_id != 1){
                $name = 'sec_'.$resume_section_id.'['.$name.']['.$sectionid.'][]';
                $id .=$sectionid;
            }else{
                $name = 'sec_'.$resume_section_id.'['.$name.'][]';
            }
        }
        //END handleformresume

        foreach ($list AS $value => $label) {
            $checkbox .= '<input type="checkbox" name="' . $name . '" id="' . $id . $count . '" value="' . $value . '"';
            if ($defaultvalue == $value)
                $checkbox .= ' checked="checked"';
            if (!empty($extraattr))
                foreach ($extraattr AS $key => $val) {
                    $checkbox .= ' ' . $key . '="' . $val . '"';
                }
            $checkbox .= '/><label id="for' . $id . '" for="' . $id . $count . '">' . $label . '</label>';
            $count++;
        }
        return $checkbox;
    }


    static function textareaResume($name, $value, $extraattr = array() , $resume_section_id = null , $sectionid = null) {
            if (wpjobportalphplib::wpJP_strpos($name, '[]') !== false) {
                $id = wpjobportalphplib::wpJP_str_replace('[]', '', $name);
            }else{
                $id = $name;
            }
        // handleformresume
        if($resume_section_id){
            if($resume_section_id != 1){
                $name = 'sec_'.$resume_section_id.'['.$name.']['.$sectionid.']';
                $id .=$sectionid;
            }else{
                $name = 'sec_'.$resume_section_id.'['.$name.']';
            }
        }
        //END handleformresume

        $textarea = '<textarea name="' . $name . '" id="' . $id . '" ';
        if (!empty($extraattr))
            foreach ($extraattr AS $key => $val)
                $textarea .= ' ' . $key . '="' . $val . '"';
        $textarea .= ' >' . $value . '</textarea>';
        return $textarea;
    }


    static function dateResume($name, $value, $extraattr = array() , $resume_section_id = null , $sectionid = null) {
        if (wpjobportalphplib::wpJP_strpos($name, '[]') !== false) {
            $id = wpjobportalphplib::wpJP_str_replace('[]', '', $name);
        }else{
            $id = $name;
        }

        // handleformresume
        if($resume_section_id){
            if($resume_section_id != 1){
                $name = 'sec_'.$resume_section_id.'['.$name.']['.$sectionid.']';
                $id .=$sectionid;
            }else{
                $name = 'sec_'.$resume_section_id.'['.$name.']';
            }
        }
        //END handleformresume

        $textfield = '<input type="text" name="' . $name . '" id="' . $id . '" value="' . $value . '" ';
        if (!empty($extraattr))
            foreach ($extraattr AS $key => $val)
                $textfield .= ' ' . $key . '="' . $val . '"';
        $textfield .= ' />';
        return $textfield;
    }

    static function textResume($name, $value, $extraattr = array() , $resume_section_id = null , $sectionid = null) {


        if (wpjobportalphplib::wpJP_strpos($name, '[]') !== false) {
            $id = wpjobportalphplib::wpJP_str_replace('[]', '', $name);
        }else{
            $id = $name;
        }

        // handleformresume
        if($resume_section_id){
            if($resume_section_id != 1){
                $name = 'sec_'.$resume_section_id.'['.$name.']['.$sectionid.']';
                $id .=$sectionid;
            }else{
                $name = 'sec_'.$resume_section_id.'['.$name.']';
            }
        }
        //END handleformresume

        $textfield = '<input type="text" name="' . $name . '" id="' . $id . '" value="' . $value . '" ';
        if (!empty($extraattr))
            foreach ($extraattr AS $key => $val)
                $textfield .= ' ' . $key . '="' . $val . '"';
        $textfield .= ' />';
        return $textfield;
    }

    static function emailResume($name, $value, $extraattr = array() , $resume_section_id = null , $sectionid = null) {
        if (wpjobportalphplib::wpJP_strpos($name, '[]') !== false) {
            $id = wpjobportalphplib::wpJP_str_replace('[]', '', $name);
        }else{
            $id = $name;
        }

        // handleformresume
        if($resume_section_id){
            if($resume_section_id != 1){
                $name = 'sec_'.$resume_section_id.'['.$name.']['.$sectionid.']';
                $id .=$sectionid;
            }else{
                $name = 'sec_'.$resume_section_id.'['.$name.']';
            }
        }
        //END handleformresume

        $textfield = '<input type="email" name="' . $name . '" id="' . $id . '" value="' . $value . '" ';
        if (!empty($extraattr))
            foreach ($extraattr AS $key => $val)
                $textfield .= ' ' . $key . '="' . $val . '"';
        $textfield .= ' />';
        return $textfield;
    }

    function formCustomFields($field,$resumeform = null, $section = null, $refid = null,$themecall=null) {
        //patch to saolve notices on resume form but it may causse problems like showing disabled fiedls
        if ($resumeform != 1) {
            if ($field->isuserfield != 1) {
                return;
            }
        }

        if(null != $themecall){
            $div1 = 'resume-row-wrapper form';
            $div2 = 'row-title';
            $div3 = 'row-value';
        }else{
            $div1 = 'resume-row-wrapper form';
            $div2 = 'row-title';
            $div3 = 'row-value';

        }

        $cssclass = "";
        $html = '';
        $themebfclass = " ".$this->class_prefix."-bigfont ";
        $required = $field->required;
        if ($required == 1) {
            $html .= __($field->fieldtitle,'wp-job-portal') . '<font color="red"> *</font>';
            $cssclass = "required";
        }else {
            $html .= __($field->fieldtitle,'wp-job-portal');
            $cssclass = "";
        }
        //$readonly = $field->readonly ? "'readonly => 'readonly'" : "";
        //$maxlength = $field->maxlength ? "'maxlength' => '" . $field->maxlength : "";
        $fvalue = "";
        $value = "";
        $userdataid = "";
        if ($resumeform == 1) {
            if($section == 1 || $section == 5 || $section == 6){ // personal section
                if(isset(wpjobportal::$_data[0]['personal_section'])){
                    $value = wpjobportal::$_data[0]['personal_section']->params;
                }
            }elseif($section == 2){
                if(isset(wpjobportal::$_data[0]['address_section'])){
                    $value = wpjobportal::$_data[0]['address_section']->params;
                }
            }elseif($section == 3){
                if(isset(wpjobportal::$_data[0]['institute_section'])){
                    $value = wpjobportal::$_data[0]['institute_section']->params;
                }
            }elseif($section == 4){
                if(isset(wpjobportal::$_data[0]['employer_section'])){
                    $value = wpjobportal::$_data[0]['employer_section']->params;
                }
            }elseif($section == 7){
                if(isset(wpjobportal::$_data[0]['reference_section'])){
                    $value = wpjobportal::$_data[0]['reference_section']->params;
                }
            }elseif($section == 8){
                if(isset(wpjobportal::$_data[0]['language_section'])){
                    $value = wpjobportal::$_data[0]['language_section']->params;
                }
            }
            if($value){ // data has been stored
                $userfielddataarray = json_decode($value);
                $valuearray = json_decode($value,true);
            }else{
                $valuearray = array();
            }
            if(array_key_exists($field->field, $valuearray)){
                $value = $valuearray[$field->field];
            }else{
                $value = '';
            }
        } elseif (isset(wpjobportal::$_data[0]->id)) {
            $userfielddataarray = json_decode(wpjobportal::$_data[0]->params);
            $uffield = $field->field;
            if (isset($userfielddataarray->$uffield) || !empty($userfielddataarray->$uffield)) {
                $value = $userfielddataarray->$uffield;
            } else {
                $value = '';
            }
        }
        $html = '<div class="' . $div1 . '">
               <div class="' . $div2 . '">';

        $theme_string = '';
        $html = '';
        switch ($field->userfieldtype) {
            case 'text':
                if(wpjobportal::$theme_chk == 1){
                    $themeclass = getJobManagerThemeClass('text');
                }elseif(wpjobportal::$theme_chk == 2){
                    $themeclass = getJobHubThemeClass('text');
                }else{
                    $themeclass = '';
                }
                $html .= WPJOBPORTALformfield::text($field->field, $value, array('class' => ' inputbox one wjportal-form-input-field '. $themeclass, 'data-validation' => $cssclass,'placeholder'=>$field->placeholder));
                break;
            case 'email':
                if(wpjobportal::$theme_chk == 1){
                    $themeclass = getJobManagerThemeClass('text');
                }elseif(wpjobportal::$theme_chk == 2){
                    $themeclass = getJobHubThemeClass('text');
                }else{
                    $themeclass = '';
                }
                $html .= WPJOBPORTALformfield::email($field->field, $value, array('class' => ' inputbox one wjportal-form-input-field '. $themeclass, 'data-validation' => $cssclass,'placeholder'=>$field->placeholder));
                break;
            case 'date':
                if(wpjobportal::$theme_chk == 1){
                    $themeclass = getJobManagerThemeClass('text');
                }elseif(wpjobportal::$theme_chk == 2){
                    $themeclass = getJobHubThemeClass('text');
                }else{
                    $themeclass = '';
                }
                $html .= WPJOBPORTALformfield::text($field->field, $value, array('class' => 'custom_date one wjportal-form-date-field '. $themeclass, 'data-validation' => $cssclass,'placeholder'=>$field->placeholder,'autocomplete'=>'off'));
            case 'checkbox':
                if (!empty($field->userfieldparams)) {
                    $comboOptions = array();
                    $obj_option = json_decode($field->userfieldparams);
                    $i = 0;
                    $valuearray = wpjobportalphplib::wpJP_explode(', ',$value);
                    $jsFunction = '';
                    if ($required == 1) {
                        $jsFunction = "deRequireUfCheckbox('" . $field->field . "');";
                    }
                    foreach ($obj_option AS $option) {
                        $check = '';
                        if(in_array($option, $valuearray)){
                            $check = 'checked';
                        }
                        $html .= '<input type="checkbox" ' . $check . ' class="uf_of_type_ckbox radiobutton ' . $field->field . '" value="' . $option . '" id="' . $field->field . '_' . $i . '" name="' . $field->field . '[]" data-validation="'.$cssclass.'" onclick = "' . $jsFunction . '" ckbox-group-name="' . $field->field . '">';
                        $html .= '<label for="' . $field->field . '_' . $i . '" id="foruf_checkbox1">' . $option . '</label>';
                        $i++;
                    }
                } else {
                    $comboOptions = array('1' => $field->fieldtitle);
                    $html .= WPJOBPORTALformfield::checkbox($field->field, $comboOptions, $value, array('class' => 'radiobutton wjportal-form-checkbox-field'));
                }
                break;
            case 'radio':
                $comboOptions = array();
                if (!empty($field->userfieldparams)) {
                    $obj_option = json_decode($field->userfieldparams);
                    for ($i = 0; $i < count($obj_option); $i++) {
                        $comboOptions[$obj_option[$i]] = "$obj_option[$i]";
                    }
                }
                $jsFunction = '';
                $dependentclass = '';
                if ($field->depandant_field != null) {
                    $jsFunction = "getDataForDepandantField('" . $field->field . "','" . $field->depandant_field . "',2,'',''". $theme_string.");";
                    $dependentclass = 'dependent wjportal-form-radio-field';
                }
                $html .= WPJOBPORTALformfield::radiobutton($field->field, $comboOptions, $value, array('data-validation' => $cssclass , 'class' =>  $dependentclass, 'onclick' => $jsFunction));
                break;
            case 'combo':
                if(wpjobportal::$theme_chk == 1){
                    $themeclass = getJobManagerThemeClass('select');
                }elseif(wpjobportal::$theme_chk == 2){
                    $themeclass = getJobHubThemeClass('select');
                }else{
                    $themeclass = '';
                }
                $comboOptions = array();
                if (!empty($field->userfieldparams)) {
                    $obj_option = json_decode($field->userfieldparams);
                    foreach ($obj_option as $opt) {
                        $comboOptions[] = (object) array('id' => $opt, 'text' => $opt);
                    }
                }
                //code for handling dependent field
                $jsFunction = '';
                if ($field->depandant_field != null) {
                    $jsFunction = "getDataForDepandantField('" . $field->field . "','" . $field->depandant_field . "',1,'',''". $theme_string. ");";
                }
                if ($field->placeholder != '') {
                    $placeholder = $field->placeholder;
                } else {
                    $placeholder = __('Select', 'wp-job-portal') . ' ' . $field->fieldtitle;
                }
                //end
                $html .= WPJOBPORTALformfield::select($field->field, $comboOptions, $value, $placeholder, array('data-validation' => $cssclass, 'onchange' => $jsFunction, 'class' => 'inputbox one wjportal-form-select-field'. $themeclass));
                break;
        }
        return $html;
    }

    function formCustomFieldsForSearch($field, &$i, $resumeform = null, $subrefid = null,$themecall=null,$themrefine=null) {
        if ($field->isuserfield != 1)
            return false;
        $cssclass = "";
        $html = '';
        $i++;
        if($resumeform != 3 && $resumeform != 'f_jobsearch'){// to handle top search case for job and resume listing.

            $themebfclass = " ".$this->class_prefix."-bigfont ";

            $themenopadmarclass = " ".$this->class_prefix."-nopad-nomar ";

            $required = $field->required;
            $div1 = 'wjportal-form-row '.$themenopadmarclass;
            $div2 = 'wjportal-form-title '.$themebfclass;
            $div3 = 'wjportal-form-value';

            $html = '<div class="' . $div1 . '" title="'. __($field->fieldtitle,'wp-job-portal') .'" >
                   <div class="' . $div2 . '">';
            $html .= __($field->fieldtitle,'wp-job-portal');
            $html .= ' </div><div class="' . $div3 . '">';
        }
        $readonly = ''; //$field->readonly ? "'readonly => 'readonly'" : "";
        $maxlength = ''; //$field->maxlength ? "'maxlength' => '".$field->maxlength : "";
        $fvalue = "";
        $value = null;
        $userdataid = "";
        $userfielddataarray = array();
        if (isset(wpjobportal::$_data['filter']['params'])) {
            $userfielddataarray = wpjobportal::$_data['filter']['params'];
            $uffield = $field->field;
            //had to user || oprator bcz of radio buttons

            if (isset($userfielddataarray[$uffield]) || !empty($userfielddataarray[$uffield])) {
                $value = $userfielddataarray[$uffield];
            } else {
                $value = '';
            }
        }
         if($themecall != null){
            $theme_string = ", '". $themecall ."'";
        }else{
            $theme_string = '';
        }
        switch ($field->userfieldtype) {
            case 'text':
                if(wpjobportal::$theme_chk == 1){
                    $themeclass = getJobManagerThemeClass('text');
                }elseif(wpjobportal::$theme_chk == 2){
                    $themeclass = getJobHubThemeClass('text');
                }else{
                    $themeclass = '';
                }
                $html .= WPJOBPORTALformfield::text($field->field, $value, array('class' => 'inputbox one form-control wjportal-form-input-field '.$this->class_prefix.'-input'.$themeclass, 'data-validation' => $cssclass, 'size' => $field->size, $maxlength, $readonly, 'placeholder' => __($field->fieldtitle, 'wp-job-portal')));
                break;
            case 'email':
                if(wpjobportal::$theme_chk == 1){
                    $themeclass = getJobManagerThemeClass('text');
                }elseif(wpjobportal::$theme_chk == 2){
                    $themeclass = getJobHubThemeClass('text');
                }else{
                    $themeclass = '';
                }
                $html .= WPJOBPORTALformfield::email($field->field, $value, array('class' => 'inputbox one form-control wjportal-form-input-field '.$this->class_prefix.'-input'.$themeclass, 'data-validation' => $cssclass, 'size' => $field->size, $maxlength, $readonly, 'placeholder' => __($field->fieldtitle, 'wp-job-portal')));
                break;
            case 'date':
                if(wpjobportal::$theme_chk == 1){
                    $themeclass = getJobManagerThemeClass('text');
                }elseif(wpjobportal::$theme_chk == 2){
                    $themeclass = getJobHubThemeClass('text');
                }else{
                    $themeclass = '';
                }
                $html .= WPJOBPORTALformfield::text($field->field, $value, array('class' => 'custom_date wjportal-form-date-field one '.$themeclass, 'data-validation' => $cssclass,'autocomplete'=>'off'));
                break;
            case 'checkbox':
                if (!empty($field->userfieldparams)) {
                    $comboOptions = array();
                    $obj_option = json_decode($field->userfieldparams);
                    if(empty($value) || $value == ''){
                        unset($value);
                        $value = array();
                    }
                    foreach ($obj_option AS $option) {
                        if(is_array($value)){
                            if( in_array($option, $value)){
                                $check = 'checked="true"';
                            }else{
                                $check = '';
                            }
                        }else{
                            $check = '';
                        }
                        $html .= '<input type="checkbox" ' . $check . ' class="radiobutton" value="' . $option . '" id="' . $field->field . '_' . $i . '" name="' . $field->field . '[]">';
                        $html .= '<label for="' . $field->field . '_' . $i . '" id="foruf_checkbox1">' . $option . '</label>';
                        $i++;
                    }
                } else {
                    $comboOptions = array('1' => $field->fieldtitle);
                    $html .= WPJOBPORTALformfield::checkbox($field->field, $comboOptions, $value, array('class' => 'radiobutton'));
                }
                break;
            case 'radio':
                $comboOptions = array();
                if (!empty($field->userfieldparams)) {
                    $obj_option = json_decode($field->userfieldparams);
                    for ($i = 0; $i < count($obj_option); $i++) {
                        $comboOptions[$obj_option[$i]] = "$obj_option[$i]";
                    }
                }
                $jsFunction = '';
                if ($field->depandant_field != null) {
                    $jsFunction = "getDataForDepandantField('" . $field->field . "','" . $field->depandant_field . "',2,'',''" . $theme_string . ");";
                }
                $html .= WPJOBPORTALformfield::radiobutton($field->field, $comboOptions, $value, array('data-validation' => $cssclass, "autocomplete" => "off", 'onclick' => $jsFunction));
                break;
            case 'combo':
                if(wpjobportal::$theme_chk == 1){
                    $themeclass = getJobManagerThemeClass('select');
                }elseif(wpjobportal::$theme_chk == 2){
                    $themeclass = getJobHubThemeClass('select');
                }else{
                    $themeclass = '';
                }
                $comboOptions = array();
                if (!empty($field->userfieldparams)) {
                    $obj_option = json_decode($field->userfieldparams);
                    foreach ($obj_option as $opt) {
                        $comboOptions[] = (object) array('id' => $opt, 'text' => $opt);
                    }
                }
                //code for handling dependent field
                $jsFunction = '';
                if ($field->depandant_field != null) {
                    $jsFunction = "getDataForDepandantField('" . $field->field . "','" . $field->depandant_field . "','1','',''" . $theme_string . ");";
                }
                //end
                if ($field->placeholder != '') {
                    $placeholder = $field->placeholder;
                } else {
                    $placeholder = __('Select', 'wp-job-portal') . ' ' . $field->fieldtitle;
                }
                $html .= WPJOBPORTALformfield::select($field->field, $comboOptions, $value, $placeholder, array('data-validation' => $cssclass, 'onchange' => $jsFunction, 'class' => 'inputbox wjportal-form-select-field one form-control  '.$this->class_prefix.'-select '.$themeclass));
                break;
        }
        if ($resumeform == 3) {// to handle top search case for job and resume listing.
            return $html;
        }
        if ($resumeform != 'f_jobsearch') {
            $html .= '</div></div>';
        }
        if ($resumeform == 1 || $resumeform == 'f_jobsearch') {
            return $html;
        } else {
            echo wp_kses($html, WPJOBPORTAL_ALLOWED_TAGS);
        }
    }

    function getUserFieldByField($field){
        $query = "SELECT * FROM `".wpjobportal::$_db->prefix."wj_portal_fieldsordering` WHERE field = '".$field."' AND isuserfield = 1 ";
        $field = wpjobportal::$_db->get_row($query);
        return $field;
    }

    function getSearchUserFieldByFieldFor($fieldfor){
        if(!is_numeric($fieldfor)){
            return;
        }
        $query = "SELECT * FROM `".wpjobportal::$_db->prefix."wj_portal_fieldsordering` WHERE fieldfor = '".$fieldfor."' AND isuserfield = 1 AND (search_user  = 1 OR search_visitor = 1 ) ";
        $fields = wpjobportal::$_db->get_results($query);
        return $fields;
    }

    function showCustomFields($field, $fieldfor, $params) {
        $html = '';
        $fvalue = '';
        $labelflag = wpjobportal::$_configuration['labelinlisting'];
        if($fieldfor == 11){
            $field = $this->getUserFieldByField($field);
            if(empty($field)){
                return false;
            }
            //if(!in_array('customfield', wpjobportal::$_active_addons)){
            //    if($field->userfieldtype != 'text' && $field->userfieldtype != 'email'){
            //        return '';
            //    }
            //}
        }
        if(!empty($params)){
            $params = wpjobportalphplib::wpJP_stripslashes($params);
            $params = html_entity_decode($params, ENT_QUOTES);
            $data = json_decode($params,true);
            if(isset($data) && !empty($data)){
                if(array_key_exists($field->field, $data)){
                    $fvalue = $data[$field->field];
                }
            }
        }
        if ($field->userfieldtype == 'date' && $fvalue != '') {
            $fvalue = date_i18n(wpjobportal::$_configuration['date_format'],strtotime($fvalue));
        }

        if($fieldfor == 1){ // jobs listing
            $html = '<div class="wjportal-custom-field">';
            if (wpjobportal::$theme_chk == 1) {
                if ($labelflag == 1) {
                    $html .= '<span class="wjportal-custom-field-tit">' . $field->fieldtitle . ': </span>';
                }
                $html .= '<span class="wjportal-custom-field-val">' . $fvalue . '</span>
                             </div>';
            } else {
                if ($labelflag == 1) {
                    $html .= '<span class="wjportal-custom-field-tit">' . $field->fieldtitle . ': </span>';
                }
                $html .= '<span class="wjportal-custom-field-val">' . $fvalue . '</span>
                             </div>';
            }
        }elseif($fieldfor == 2){ // job view
            if (wpjobportal::$theme_chk == 1) {
                $html = '<div class="wpj-jp-cf"  >
                    <span class="wpj-jp-cf-tit">' . $field->fieldtitle . ':&nbsp;</span>
                    <span class="wpj-jp-cf-val">' . $fvalue . '</span>
		</div>';
            } else {
                $html = '<div class="wjportal-custom-field"  >
                    <span class="wjportal-custom-field-tit">' . $field->fieldtitle . ': </span>
                    <span class="wjportal-custom-field-val">' . $fvalue . '</span>
                </div>';
            }
        }elseif($fieldfor == 7 || $fieldfor == 9 || $fieldfor == 10){ // myjobs, myresume, resume listing
            if (wpjobportal::$theme_chk == 1) {
                $html = '<div class="wpj-jp-cf">';
                $html .= '<span class="wpj-jp-cf-tit">'.$field->fieldtitle.':</span>';
                $html .= '<span class="wpj-jp-cf-val">'.$fvalue.'</span>';
                $html .= '</div>';
            } else {
                $html = '<div class="wjportal-custom-field">';
                $html .= '<span class="wjportal-custom-field-tit">'.$field->fieldtitle.': </span>';
                $html .= '<span class="wjportal-custom-field-val">'.$fvalue.'</span>';
                $html .= '</div>';
            }
        }elseif($fieldfor == 4){ // company listing
            if (wpjobportal::$theme_chk == 1) {
                $html = '<div class="wpj-jp-cf">';
                $html .= '<span class="wpj-jp-cf-tit">'.$field->fieldtitle.': </span>';
                $html .= '<span class="wpj-jp-cf-val">'.$fvalue.'</span>';
                $html .= '</div>';
            } else {
                $html = '<div class="wjportal-custom-field">';
                $html .= '<span class="wjportal-custom-field-tit">'.$field->fieldtitle.': </span>';
                $html .= '<span class="wjportal-custom-field-val">'.$fvalue.'</span>';
                $html .= '</div>';
            }
        }elseif($fieldfor == 5){ // company view
            if (wpjobportal::$theme_chk == 1) {
                $html = '<div class="wpj-jp-cf">';
                $html .= '<span class="wpj-jp-cf-tit">'.$field->fieldtitle.': </span>';
                $html .= '<span class="wpj-jp-cf-val">'.$fvalue.'</span>';
                $html .= '</div>';
            } else {
                $html = '<div class="wjportal-custom-field">';
                $html .= '<span class="wjportal-custom-field-tit">'.$field->fieldtitle.': </span>';
                $html .= '<span class="wjportal-custom-field-val">'.$fvalue.'</span>';
                $html .= '</div>';
            }
        }elseif($fieldfor == 8){ // mycompanies
            if (wpjobportal::$theme_chk == 1) {
                $html = '<div class="wpj-jp-cf">';
                $html .= '<span class="wpj-jp-cf-tit">'.$field->fieldtitle.': </span>';
                $html .= '<span class="wpj-jp-cf-val">'.$fvalue.'</span>';
                $html .= '</div>';
            } else {
                $html = '<div class="wjportal-custom-field">';
                $html .= '<span class="wjportal-custom-field-tit">'.$field->fieldtitle.': </span>';
                $html .= '<span class="wjportal-custom-field-val">'.$fvalue.'</span>';
                $html .= '</div>';
            }
        }elseif($fieldfor == 11 || $fieldfor == 6){ // view resume
            return array('title' => $field->fieldtitle, 'value' => $fvalue);
        }elseif($fieldfor == 12){ // user detail
            $html = '<div class="wpjobportal-user-data-text">';
            $html .= '<span class="wpjobportal-user-data-title">'.$field->fieldtitle.': </span>';
            $html .= '<span class="wpjobportal-user-data-value">'.$fvalue.'</span>';
            $html .= '</div>';
        }

        return $html;
    }

    function userFieldData($field, $fieldfor, $section = null) {

        if (WPJOBPORTALincluder::getObjectClass('user')->isguest()) {
            $published = ' isvisitorpublished = 1 ';
        } else {
            $published = ' published = 1 ';
        }
        $ff = '';
        if ($fieldfor == 2 || $fieldfor == 3) {
            $ff = " AND fieldfor = 2 ";
        } elseif ($fieldfor == 1 || $fieldfor == 4) {
            $ff = "AND fieldfor = 1 ";
        } elseif ($fieldfor == 5) {
            $ff = "AND fieldfor = 3 ";
        } elseif ($fieldfor == 6) {
            //form resume
            $ff = "AND fieldfor = 3 AND section = $section ";
        }
        $query = "SELECT field,fieldtitle,required,isuserfield,userfieldtype,readonly,maxlength,depandant_field,userfieldparams,description,placeholder  from " . wpjobportal::$_db->prefix . "wj_portal_fieldsordering WHERE isuserfield = 1 AND " . $published . " AND field ='" . $field . "'" . $ff;
        $data = wpjobportaldb::get_row($query);
        return $data;
    }

    function userFieldsData($fieldfor, $listing = null,$getpersonal = null) {
        if (WPJOBPORTALincluder::getObjectClass('user')->isguest()) {
            $published = ' isvisitorpublished = 1 ';
        } else {
            $published = ' published = 1 ';
        }
        $inquery = '';
        if ($listing == 1) {
            $inquery = ' AND showonlisting = 1 ';
        }
        if( $getpersonal == 1){
            $inquery .= ' AND section = 1 ';
        }
        //$inquery .= " AND (userfieldtype = 'text' OR userfieldtype = 'email')";
        $query = "SELECT field,fieldtitle,isuserfield,userfieldtype,userfieldparams  FROM " . wpjobportal::$_db->prefix . "wj_portal_fieldsordering WHERE isuserfield = 1 AND " . $published . " AND fieldfor =" . $fieldfor . $inquery;
        $data = wpjobportaldb::get_results($query);
        return $data;
    }

    function getDataForDepandantFieldByParentField($fieldfor, $data) {
        if (WPJOBPORTALincluder::getObjectClass('user')->isguest()) {
            $published = ' isvisitorpublished = 1 ';
        } else {
            $published = ' published = 1 ';
        }
        $value = '';
        $returnarray = array();
        $query = "SELECT field from " . wpjobportal::$_db->prefix . "wj_portal_fieldsordering WHERE isuserfield = 1 AND " . $published . " AND depandant_field ='" . $fieldfor . "'";
        $field = wpjobportaldb::get_var($query);
        if ($data != null) {
            foreach ($data as $key => $val) {
                if ($key == $field) {
                    $value = $val;
                }
            }
        }
        $query = "SELECT userfieldparams from " . wpjobportal::$_db->prefix . "wj_portal_fieldsordering WHERE isuserfield = 1 AND " . $published . " AND field ='" . $fieldfor . "'";
        $field = wpjobportaldb::get_var($query);
        $fieldarray = json_decode($field);
        if(!empty($fieldarray)){
            foreach ($fieldarray as $key => $val) {
                if ($value == $key)
                    $returnarray = $val;
            }
        }
        return $returnarray;
    }

    function storeCustomFields($entity,$id,$data){
        $customfields = WPJOBPORTALincluder::getJSModel('fieldordering')->getUserfieldsfor($entity);
        $params = array();
        $filelistadd = array();
        $filelistdelete = array();
        foreach($customfields AS $field){
            $vardata = '';
            $vardata = isset($data[$field->field]) ? $data[$field->field] : '';
            if(!empty($vardata)){
                if(is_array($vardata)){
                    $vardata = implode(', ', $vardata);
                }
                $params[$field->field] = wpjobportalphplib::wpJP_htmlspecialchars($vardata);
            }
        }
        // code for unpublished fields to be written later as in wp jobs by shees
        $params = wpjobportal::sanitizeData($params);
        $params = WPJOBPORTALincluder::getJSModel('common')->stripslashesFull($params);// remove slashes with quotes.
        $params = json_encode($params);

        if($entity == WPJOBPORTAL_COMPANY){
            //$row->update(array('id' => $id, 'status' => -1))
            $row = WPJOBPORTALincluder::getJSTable('company');
            $row->update(array('id' => $id, 'params' => $params));
            //$query = "UPDATE `".wpjobportal::$_db->prefix."wj_portal_companies` SET `params`='$params' WHERE `id` = $id";
            //wpjobportal::$_db->query($query);
        }else if($entity == WPJOBPORTAL_JOB){
            $row = WPJOBPORTALincluder::getJSTable('job');
            $row->update(array('id' => $id, 'params' => $params));
            // $query = "UPDATE `".wpjobportal::$_db->prefix."wj_portal_jobs` SET `params`='$params' WHERE `id` = $id";
            // wpjobportal::$_db->query($query);
        }else if($entity == WPJOBPORTAL_RESUME){
            $row = WPJOBPORTALincluder::getJSTable('resume');
            $row->update(array('id' => $id, 'params' => $params));
            // $query = "UPDATE `".wpjobportal::$_db->prefix."wj_portal_resume` SET `params`='$params' WHERE `id` = $id";
            // wpjobportal::$_db->query($query);
        }elseif ($entity == 4) {
            $row = WPJOBPORTALincluder::getJSTable('users');
            $row->update(array('id' => $id, 'params' => $params));
            // $query = "UPDATE `".wpjobportal::$_db->prefix."wj_portal_users` SET `params`='$params' WHERE `id` = $id";
            // wpjobportal::$_db->query($query);
        }
    }

}

?>
