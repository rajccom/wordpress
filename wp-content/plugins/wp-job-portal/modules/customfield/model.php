<?php

if (!defined('ABSPATH'))
    die('Restricted Access');

class WPJOBPORTALCustomFieldModel {

    function __construct() {

    }

    function fieldsRequiredOrNot($ids, $value) {
        if (empty($ids))
            return false;
        if (!is_numeric($value))
            return false;
        //Db class limitations
        $total = 0;
        foreach ($ids as $id) {
            if(is_numeric($id) && is_numeric($value)){
                $query = "UPDATE " . wpjobportal::$_db->prefix . "wj_portal_fieldsordering SET required = " . $value . " WHERE id = " . $id . " AND sys=0";
                if (false === wpjobportaldb::query($query)) {
                    $total += 1;
                }
            }else{
                $total += 1;
            }
        }
        if ($total == 0) {
            WPJOBPORTALMessages::$counter = false;
            if ($value == 1)
                return WPJOBPORTAL_REQUIRED;
            else
                return WPJOBPORTAL_NOT_REQUIRED;
        }else {
            WPJOBPORTALMessages::$counter = $total;
            if ($value == 1)
                return WPJOBPORTAL_REQUIRED_ERROR;
            else
                return WPJOBPORTAL_NOT_REQUIRED_ERROR;
        }
    }

    function getFieldsOrdering($fieldfor) {
        if (is_numeric($fieldfor) == false)
            return false;
        // $title = WPJOBPORTALrequest::getVar('title');
        // $ustatus = WPJOBPORTALrequest::getVar('ustatus');
        // $vstatus = WPJOBPORTALrequest::getVar('vstatus');
        // $required = WPJOBPORTALrequest::getVar('required');
        // $formsearch = WPJOBPORTALrequest::getVar('WPJOBPORTAL_form_search', 'post');
        // if ($formsearch == 'WPJOBPORTAL_SEARCH') {
        //     $_SESSION['WPJOBPORTAL_SEARCH']['title'] = $title;
        //     $_SESSION['WPJOBPORTAL_SEARCH']['ustatus'] = $ustatus;
        //     $_SESSION['WPJOBPORTAL_SEARCH']['vstatus'] = $vstatus;
        //     $_SESSION['WPJOBPORTAL_SEARCH']['required'] = $required;
        // }
        // if (WPJOBPORTALrequest::getVar('pagenum', 'get', null) != null) {
        //     $title = (isset($_SESSION['WPJOBPORTAL_SEARCH']['title']) && $_SESSION['WPJOBPORTAL_SEARCH']['title'] != '') ? sanitize_key($_SESSION['WPJOBPORTAL_SEARCH']['title']) : null;
        //     $ustatus = (isset($_SESSION['WPJOBPORTAL_SEARCH']['ustatus']) && $_SESSION['WPJOBPORTAL_SEARCH']['ustatus'] != '') ? sanitize_key($_SESSION['WPJOBPORTAL_SEARCH']['ustatus']) : null;
        //     $vstatus = (isset($_SESSION['WPJOBPORTAL_SEARCH']['vstatus']) && $_SESSION['WPJOBPORTAL_SEARCH']['vstatus'] != '') ? sanitize_key($_SESSION['WPJOBPORTAL_SEARCH']['vstatus']) : null;
        //     $required = (isset($_SESSION['WPJOBPORTAL_SEARCH']['required']) && $_SESSION['WPJOBPORTAL_SEARCH']['required'] != '') ? sanitize_key($_SESSION['WPJOBPORTAL_SEARCH']['required']) : null;
        // } else if ($formsearch !== 'WPJOBPORTAL_SEARCH') {
        //     unset($_SESSION['WPJOBPORTAL_SEARCH']);
        // }



        $title = wpjobportal::$_search['search_filter']['title'];
        $ustatus = wpjobportal::$_search['search_filter']['ustatus'];
        $vstatus = wpjobportal::$_search['search_filter']['vstatus'];
        $required = wpjobportal::$_search['search_filter']['required'];

        $inquery = '';
        if ($title != null)
            $inquery .= " AND field.fieldtitle LIKE '%$title%'";
        if (is_numeric($ustatus))
            $inquery .= " AND field.published = $ustatus";
        if (is_numeric($vstatus))
            $inquery .= " AND field.isvisitorpublished = $vstatus";
        if (is_numeric($required))
            $inquery .= " AND field.required = $required";

        wpjobportal::$_data['filter']['title'] = $title;
        wpjobportal::$_data['filter']['ustatus'] = $ustatus;
        wpjobportal::$_data['filter']['vstatus'] = $vstatus;
        wpjobportal::$_data['filter']['required'] = $required;

        //Pagination
        $query = "SELECT COUNT(field.id) FROM " . wpjobportal::$_db->prefix . "wj_portal_fieldsordering AS field WHERE field.fieldfor = " . $fieldfor;
        $query .= $inquery;
        $total = wpjobportaldb::get_var($query);
        wpjobportal::$_data['total'] = $total;
        wpjobportal::$_data[1] = WPJOBPORTALpagination::getPagination($total);

        //Data
        $query = "SELECT field.*
                    FROM " . wpjobportal::$_db->prefix . "wj_portal_fieldsordering AS field
                    WHERE field.fieldfor = " . $fieldfor;
        $query .= $inquery;
        $query .= ' ORDER BY';
        $query .= ' field.ordering';
        if ($fieldfor == 3)
            $query .=' ,field.section';
        $query .=" LIMIT " . WPJOBPORTALpagination::$_offset . "," . WPJOBPORTALpagination::$_limit;
        wpjobportal::$_data[0] = wpjobportaldb::get_results($query);
        return;
    }

    function getSearchFieldsOrdering($fieldfor) {
        if (is_numeric($fieldfor) == false)
            return false;
        $search = WPJOBPORTALrequest::getVar('search','',0);
        $inquery = '';
            $inquery .= " AND field.cannotsearch = 0";
        if ($search == 0){
            $inquery .= " AND (field.search_user  = 1 OR field.search_visitor = 1 ) ";
        }
        wpjobportal::$_data['filter']['search'] = $search;
        //Data
        $query = "SELECT field.fieldtitle,field.id,field.search_user,field.search_visitor,field.ordering
                    FROM " . wpjobportal::$_db->prefix . "wj_portal_fieldsordering AS field
                    WHERE field.fieldfor = " . $fieldfor;
        $query .= $inquery;
        $query .= ' ORDER BY';
        $query .= ' field.ordering';

        wpjobportal::$_data[0] = wpjobportaldb::get_results($query);
        return;
    }

    function getFieldsOrderingforForm($fieldfor) {
        if (is_numeric($fieldfor) == false){
            return false;
        }
        $published = (WPJOBPORTALincluder::getObjectClass('user')->isguest()) ? "isvisitorpublished" : "published";
        $query = "SELECT * FROM `" . wpjobportal::$_db->prefix . "wj_portal_fieldsordering`
        WHERE $published = 1 AND fieldfor = " . $fieldfor . " ORDER BY";
        if ($fieldfor == 3) // for resume it must be order by section and ordering
            $query.=" section , ";
        $query.=" ordering";
        $fields = array();
       // var_dump($query);
        foreach(wpjobportaldb::get_results($query) as $field){
            $field->validation = $field->required == 1 ? 'required' : '';
            $fields[$field->field] = $field;
        }
        return $fields;
    }

    function getFieldsOrderingforSearch($fieldfor) {
        if (is_numeric($fieldfor) == false)
            return false;
        if (WPJOBPORTALincluder::getObjectClass('user')->isguest()) {
            $published = ' AND search_visitor = 1 ';
        } else {
            $published = ' AND search_user = 1 ';
        }
        $query = "SELECT * FROM `" . wpjobportal::$_db->prefix . "wj_portal_fieldsordering`
                 WHERE cannotsearch = 0 AND  fieldfor = " . $fieldfor . $published . " ORDER BY ordering";
        $rows = wpjobportaldb::get_results($query);
        return $rows;
    }

    function getFieldsOrderingforView($fieldfor) {
        if (is_numeric($fieldfor) == false)
            return false;
        $published = (WPJOBPORTALincluder::getObjectClass('user')->isguest()) ? "isvisitorpublished" : "published";
        $query = "SELECT field,fieldtitle FROM `" . wpjobportal::$_db->prefix . "wj_portal_fieldsordering`
                WHERE $published = 1 AND fieldfor =  " . $fieldfor . " ORDER BY";
        if ($fieldfor == 3) // fields for resume
            $query.=" section ,";
        $query.=" ordering";
        $rows = wpjobportaldb::get_results($query);
        $return = array();

//had make changes impliment fieldtitle in view compnay
        // if($fieldfor == 3){
        //     foreach ($rows AS $row) {
        //         $return[$row->field] = $row->required;
        //     }
        // }else{
            foreach ($rows AS $row) {
                $return[$row->field] = $row->fieldtitle;
            }
        // }

        return $return;
    }

    function fieldsPublishedOrNot($ids, $value) {
        if (empty($ids))
            return false;
        if (!is_numeric($value))
            return false;

        $total = 0;
        foreach ($ids as $id) {
            if(is_numeric($id) && is_numeric($value)){
                $query = "UPDATE " . wpjobportal::$_db->prefix . "wj_portal_fieldsordering SET published = " . $value . " WHERE id = " . $id . " AND cannotunpublish=0";
                if (false === wpjobportaldb::query($query)) {
                    $total += 1;
                }
            }else{
                $total += 1;
            }
        }
        if ($total == 0) {
            WPJOBPORTALMessages::$counter = false;
            if ($value == 1)
                return WPJOBPORTAL_PUBLISHED;
            else
                return WPJOBPORTAL_UN_PUBLISHED;
        }else {
            WPJOBPORTALMessages::$counter = $total;
            if ($value == 1)
                return WPJOBPORTAL_PUBLISH_ERROR;
            else
                return WPJOBPORTAL_UN_PUBLISH_ERROR;
        }
    }

    /*function visitorFieldsPublishedOrNot($ids, $value) {
        if (empty($ids))
            return false;
        if (!is_numeric($value))
            return false;
        $total = 0;
        foreach ($ids as $id) {
            if(is_numeric($id) && is_numeric($value)){
                $query = "UPDATE " . wpjobportal::$_db->prefix . "wj_portal_fieldsordering SET isvisitorpublished = " . $value . " WHERE id = " . $id . " AND cannotunpublish=0";
                if (false === wpjobportaldb::query($query)) {
                    $total += 1;
                }
            }else{
                $total += 1;
            }
        }
        if ($total == 0) {
            WPJOBPORTALMessages::$counter = false;
            if ($value == 1)
                return WPJOBPORTAL_PUBLISHED;
            else
                return WPJOBPORTAL_UN_PUBLISHED;
        }else {
            WPJOBPORTALMessages::$counter = $total;
            if ($value == 1)
                return WPJOBPORTAL_PUBLISH_ERROR;
            else
                return WPJOBPORTAL_UN_PUBLISH_ERROR;
        }
    }*/

    /*function fieldOrderingUp($field_id) {
        if (is_numeric($field_id) == false)
            return false;
        $query = "UPDATE " . wpjobportal::$_db->prefix . "wj_portal_fieldsordering AS f1, " . wpjobportal::$_db->prefix . "wj_portal_fieldsordering AS f2
                SET f1.ordering = f1.ordering + 1
                WHERE f1.ordering = f2.ordering - 1
                AND f1.fieldfor = f2.fieldfor
                AND f2.id = " . $field_id;

        if (false == wpjobportaldb::query($query)) {
            return WPJOBPORTAL_ORDER_UP_ERROR;
        }

        $query = " UPDATE " . wpjobportal::$_db->prefix . "wj_portal_fieldsordering
                    SET ordering = ordering - 1
                    WHERE id = " . $field_id;

        if (false == wpjobportaldb::query($query)) {
            return WPJOBPORTAL_ORDER_UP_ERROR;
        }
        return WPJOBPORTAL_ORDER_UP;
    }

    function fieldOrderingDown($field_id) {
        if (is_numeric($field_id) == false)
            return false;

        $query = "UPDATE " . wpjobportal::$_db->prefix . "wj_portal_fieldsordering AS f1, " . wpjobportal::$_db->prefix . "wj_portal_fieldsordering AS f2
                    SET f1.ordering = f1.ordering - 1
                    WHERE f1.ordering = f2.ordering + 1
                    AND f1.fieldfor = f2.fieldfor
                    AND f2.id = " . $field_id;

        if (false == wpjobportaldb::query($query)) {
            return WPJOBPORTAL_ORDER_DOWN_ERROR;
        }

        $query = " UPDATE " . wpjobportal::$_db->prefix . "wj_portal_fieldsordering
                    SET ordering = ordering + 1
                    WHERE id = " . $field_id;

        if (false == wpjobportaldb::query($query)) {
            return WPJOBPORTAL_ORDER_DOWN_ERROR;
        }
        return WPJOBPORTAL_ORDER_DOWN;
    }*/

    function storeUserField($data) {
        if (empty($data)) {
            return false;
        }
        echo '<pre>';

        $row = WPJOBPORTALincluder::getJSTable('fieldsordering');
        if ($data['isuserfield'] == 1) {
            // value to add as field ordering
            if ($data['id'] == '') { // only for new
                $query = "SELECT max(ordering) FROM " . wpjobportal::$_db->prefix . "wj_portal_fieldsordering WHERE fieldfor = " . $data['fieldfor'];
                $var = wpjobportaldb::get_var($query);
                $data['ordering'] = $var + 1;
                // search ordering code //
                $query = "SELECT max(ordering) FROM " . wpjobportal::$_db->prefix . "wj_portal_fieldsordering WHERE fieldfor = " . $data['fieldfor'];
                $var = wpjobportaldb::get_var($query);
                $data['search_ordering'] = $var + 1;

                $data['cannotsearch'] = 0;
                $query = "SELECT max(id) FROM `".wpjobportal::$_db->prefix."wj_portal_fieldsordering` ";
                $maxid = wpjobportaldb::get_var($query);
                $maxid++;
                $data['field'] = 'ufield_'.$maxid;
            }
            $data['isvisitorpublished'] = $data['published'];
            $data['search_visitor'] = $data['search_user'];
            $params = array();
            //code for depandetn field
            /*if (isset($data['userfieldtype']) && $data['userfieldtype'] == 'depandant_field') {
                if ($data['id'] != '') {
                    //to handle edit case of depandat field
                    $data['arraynames'] = $data['arraynames2'];
                }
                $flagvar = $this->updateParentField($data['parentfield'], $data['field'], $data['fieldfor']);
                if ($flagvar == false) {
                    return WPJOBPORTAL_SAVE_ERROR;
                }
                if (!empty($data['arraynames'])) {
                    $valarrays = wpjobportalphplib::wpJP_explode(',', $data['arraynames']);
                    foreach ($valarrays as $key => $value) {
                        $keyvalue = $value;
                        $value = wpjobportalphplib::wpJP_str_replace(' ','__',$value);
                        $value = wpjobportalphplib::wpJP_str_replace('.','___',$value);
                        if ( isset($data[$value]) && $data[$value] != null) {
                            $params[$keyvalue] = array_filter($data[$value]);
                        }
                    }
                }
            }*/

            /*if (!empty($data['values'])) {
                foreach ($data['values'] as $key => $value) {
                    if ($value != null) {
                        $params[] = wpjobportalphplib::wpJP_trim($value);
                    }
                }
            }*/
            $options = wpjobportalphplib::wpJP_trim($data['options']);
            if(!empty($options)){
                $options = wpjobportalphplib::wpJP_preg_split('/\s*(\r\n|\n|\r)\s*/', $options);
                foreach($options as $value){
                    $params[] = $value;
                }
            }
            $params_string = json_encode($params);
            $data['userfieldparams'] = $params_string;

        }
        if($data['fieldfor'] == 3 && $data['section'] != 1){
            $data['cannotshowonlisting'] = 1;
        }
        $data = WPJOBPORTALincluder::getJSmodel('common')->stripslashesFull($data);// remove slashes with quotes.
        if (!$row->bind($data)) {
            return WPJOBPORTAL_SAVE_ERROR;
        }

        if (!$row->store()) {
            return WPJOBPORTAL_SAVE_ERROR;
        }

        $stored_id = $row->id;
        return WPJOBPORTAL_SAVED;
    }



    function updateParentField($parentfield, $field, $fieldfor) {
        if(!is_numeric($parentfield)) return false;
        if(!is_numeric($fieldfor)) return false;
        $query = "UPDATE `".wpjobportal::$_db->prefix."wj_portal_fieldsordering` SET depandant_field = '' WHERE fieldfor = ".$fieldfor." AND depandant_field = '".$parentfield."'";
        wpjobportal::$_db->query($query);
        $row = WPJOBPORTALincluder::getJSTable('fieldsordering');
        $row->update(array('id' => $parentfield, 'depandant_field' => $field));
        return true;
    }

    function storeSearchFieldOrdering($data) {//
        if (empty($data)) {
            return false;
        }
        $row = WPJOBPORTALincluder::getJSTable('fieldsordering');
        if (!$row->bind($data)) {
            return WPJOBPORTAL_SAVE_ERROR;
        }

        if (!$row->store()) {
            return WPJOBPORTAL_SAVE_ERROR;
        }

        $stored_id = $row->id;
        return WPJOBPORTAL_SAVED;
    }

    function storeSearchFieldOrderingByForm($data) {//
        if (empty($data)) {
            return false;
        }
        wpjobportalphplib::wpJP_parse_str($data['fields_ordering_new'],$sorted_array);
        $sorted_array = reset($sorted_array);
        if(!empty($sorted_array)){
            $row = WPJOBPORTALincluder::getJSTable('fieldsordering');
            for ($i=0; $i < count($sorted_array) ; $i++) {
                $row->update(array('id' => $sorted_array[$i], 'ordering' => 1 + $i));
                //$row->update(array('id' => $sorted_array[$i], 'search_ordering' => 1 + $i));
            }
        }
        return WPJOBPORTAL_SAVED;
    }

    function getFieldsForComboByFieldFor() {
        $fieldfor = WPJOBPORTALrequest::getVar('fieldfor');
        $parentfield = WPJOBPORTALrequest::getVar('parentfield');
        if(!is_numeric($fieldfor)) return false;
        $wherequery = '';
        if($parentfield){
            $query = "SELECT id FROM " . wpjobportal::$_db->prefix . "wj_portal_fieldsordering WHERE fieldfor = $fieldfor AND (userfieldtype = 'radio' OR userfieldtype = 'combo' OR userfieldtype = 'depandant_field') AND depandant_field = '" . $parentfield . "' ";
            $parent = wpjobportaldb::get_var($query);
            $wherequery = ' OR id = '.$parent;
        }else{
            $parent = '';
        }
        $query = "SELECT fieldtitle AS text ,id FROM " . wpjobportal::$_db->prefix . "wj_portal_fieldsordering WHERE fieldfor = " . $fieldfor . " AND (userfieldtype = 'radio' OR userfieldtype = 'combo' OR userfieldtype = 'depandant_field') && ( depandant_field = '' ".$wherequery." ) ";
        $data = wpjobportaldb::get_results($query);
        $jsFunction = 'getDataOfSelectedField();';
        $html = WPJOBPORTALformfield::select('parentfield', $data, $parent, __('Select','wp-job-portal') .' '. __('Parent Field', 'wp-job-portal'), array('onchange' => $jsFunction, 'class' => 'inputbox one'));
        $data = json_encode($html);
        return $data;
    }

    function getSectionToFillValues() {
        $field = WPJOBPORTALrequest::getVar('pfield');
        $query = "SELECT userfieldparams FROM " . wpjobportal::$_db->prefix . "wj_portal_fieldsordering WHERE id=$field";
        $data = wpjobportaldb::get_var($query);
        $datas = json_decode($data);
        $html = '';
        $fieldsvar = '';
        $comma = '';
        foreach ($datas as $data) {
            if(is_array($data)){
                for ($i = 0; $i < count($data); $i++) {
                    $fieldsvar .= $comma . "$data[$i]";
                    $textvar = $data[$i];
                    $textvar = wpjobportalphplib::wpJP_str_replace(' ','__',$textvar);
                    $textvar = wpjobportalphplib::wpJP_str_replace('.','___',$textvar);
                    $divid = $textvar;
                    $textvar = $textvar."[]";
                    $html .= "<div class='js-field-wrapper js-row no-margin'>";
                    $html .= "<div class='js-field-title js-col-lg-3 js-col-md-3 no-padding'>" . $data[$i] . "</div>";
                    $html .= "<div class='js-col-lg-9 js-col-md-9 no-padding combo-options-fields' id='" . $divid . "'>
                                    <span class='input-field-wrapper'>
                                        " . WPJOBPORTALformfield::text($textvar, '', array('class' => 'inputbox one user-field')) . "
                                        <img class='input-field-remove-img' src='" . WPJOBPORTAL_PLUGIN_URL . "includes/images/remove.png' />
                                    </span>
                                    <input type='button' id='depandant-field-button' onClick='getNextField(\"" . $divid . "\",this);'  value='Add More' />
                                </div>";
                    $html .= "</div>";
                    $comma = ',';
                }
            }else{
                $fieldsvar .= $comma . $data;
                $textvar = $data;
                $textvar = wpjobportalphplib::wpJP_str_replace(' ','__',$data);
                $textvar = wpjobportalphplib::wpJP_str_replace('.','___',$data);
                $divid = $textvar;
                $textvar = $textvar."[]";
                $html .= "<div class='js-field-wrapper js-row no-margin'>";
                $html .= "<div class='js-field-title js-col-lg-3 js-col-md-3 no-padding'>" . $data . "</div>";
                $html .= "<div class='js-col-lg-9 js-col-md-9 no-padding combo-options-fields' id='" . $divid . "'>
                                <span class='input-field-wrapper'>
                                    " . WPJOBPORTALformfield::text($textvar, '', array('class' => 'inputbox one user-field')) . "
                                    <img class='input-field-remove-img' src='" . WPJOBPORTAL_PLUGIN_URL . "includes/images/remove.png' />
                                </span>
                                <input type='button' id='depandant-field-button' onClick='getNextField(\"" . $divid . "\",this);'  value='Add More' />
                            </div>";
                $html .= "</div>";
                $comma = ',';
            }
        }
        $html .= " <input type='hidden' name='arraynames' value='" . $fieldsvar . "' />";
        $html = json_encode($html);
        return $html;
    }

    /*function getOptionsForFieldEdit() {
        $field = WPJOBPORTALrequest::getVar('field');
        $yesno = array(
            (object) array('id' => 1, 'text' => __('Yes', 'wp-job-portal')),
            (object) array('id' => 0, 'text' => __('No', 'wp-job-portal')));

        if(!is_numeric($field)) return false;
        $query = "SELECT * FROM " . wpjobportal::$_db->prefix . "wj_portal_fieldsordering WHERE id=" . $field;
        $data = wpjobportaldb::get_row($query);

        $html = '<span class="popup-top">
                    <span id="popup_title" >
                    ' . __("Edit Field", "wp-job-portal") . '
                    </span>
                    <img id="popup_cross" alt="'.__('popup close','wp-job-portal').'" title="'.__('popup close','wp-job-portal').'" onClick="closePopup();" src="' . WPJOBPORTAL_PLUGIN_URL . 'includes/images/popup-close.png">
                </span>';
        $html .= '<form id="wpjobportal-form" class="popup-field-from" method="post" action="' . admin_url("admin.php?page=wpjobportal_fieldordering&task=saveuserfield") . '">';
        $html .= '<div class="popup-field-wrapper">
                    <div class="popup-field-title">' . __('Field Title', 'wp-job-portal') . '<font class="required-notifier">*</font></div>
                    <div class="popup-field-obj">' . WPJOBPORTALformfield::text('fieldtitle', isset($data->fieldtitle) ? $data->fieldtitle : 'text', '', array('class' => 'inputbox one', 'data-validation' => 'required')) . '</div>
                </div>';
        if ($data->cannotunpublish == 0) {
            $html .= '<div class="popup-field-wrapper">
                        <div class="popup-field-title">' . __('User Published', 'wp-job-portal') . '</div>
                        <div class="popup-field-obj">' . WPJOBPORTALformfield::select('published', $yesno, isset($data->published) ? $data->published : 0, '', array('class' => 'inputbox one', 'data-validation' => 'required')) . '</div>
                    </div>';
            $html .= '<div class="popup-field-wrapper">
                        <div class="popup-field-title">' . __('Visitor published', 'wp-job-portal') . '</div>
                        <div class="popup-field-obj">' . WPJOBPORTALformfield::select('isvisitorpublished', $yesno, isset($data->isvisitorpublished) ? $data->isvisitorpublished : 0, '', array('class' => 'inputbox one', 'data-validation' => 'required')) . '</div>
                    </div>';

            $html .= '<div class="popup-field-wrapper">
                    <div class="popup-field-title">' . __('Required', 'wp-job-portal') . '</div>
                    <div class="popup-field-obj">' . WPJOBPORTALformfield::select('required', $yesno, isset($data->required) ? $data->required : 0, '', array('class' => 'inputbox one', 'data-validation' => 'required')) . '</div>
                </div>';
        }

        if ($data->cannotsearch == 0) {
            $html .= '<div class="popup-field-wrapper">
                        <div class="popup-field-title">' . __('User Search', 'wp-job-portal') . '</div>
                        <div class="popup-field-obj">' . WPJOBPORTALformfield::select('search_user', $yesno, isset($data->search_user) ? $data->search_user : 0, '', array('class' => 'inputbox one', 'data-validation' => 'required')) . '</div>
                    </div>';
            $html .= '<div class="popup-field-wrapper">
                        <div class="popup-field-title">' . __('Visitor Search', 'wp-job-portal') . '</div>
                        <div class="popup-field-obj">' . WPJOBPORTALformfield::select('search_visitor', $yesno, isset($data->search_visitor) ? $data->search_visitor : 0, '', array('class' => 'inputbox one', 'data-validation' => 'required')) . '</div>
                    </div>';
        }
        $showonlisting = true;
        if($data->fieldfor == 3 && $data->section != 1 ){
            $showonlisting = false;
        }
        if (($data->isuserfield == 1 || $data->cannotshowonlisting == 0) && $showonlisting == true) {
            $html .= '<div class="popup-field-wrapper">
                        <div class="popup-field-title">' . __('Show On Listing', 'wp-job-portal') . '</div>
                        <div class="popup-field-obj">' . WPJOBPORTALformfield::select('showonlisting', $yesno, isset($data->showonlisting) ? $data->showonlisting : 0, '', array('class' => 'inputbox one', 'data-validation' => 'required')) . '</div>
                    </div>';
        }
        $html .= WPJOBPORTALformfield::hidden('form_request', 'wpjobportal');
        $html .= WPJOBPORTALformfield::hidden('id', $data->id);
        $html .= WPJOBPORTALformfield::hidden('isuserfield', $data->isuserfield);
        $html .= WPJOBPORTALformfield::hidden('fieldfor', $data->fieldfor);
        $html .='<div class="js-submit-container js-col-lg-10 js-col-md-10 js-col-md-offset-1 js-col-md-offset-1">
                    ' . WPJOBPORTALformfield::submitbutton('save', __('Save', 'wp-job-portal'), array('class' => 'button'));
        if ($data->isuserfield == 1) {
            $html .= '<a id="user-field-anchor" href="'.admin_url('admin.php?page=wpjobportal_fieldordering&wpjobportallt=formuserfield&wpjobportalid=' . $data->id . '&ff='.$data->fieldfor).'"> ' . __('Advanced', 'wp-job-portal') . ' </a>';
        }

        $html .='</div>
            </form>';
        return json_encode($html);
    }*/

    function deleteUserField($id){
        if (!is_numeric($id))
           return false;
        $query = "SELECT field,fieldfor FROM `".wpjobportal::$_db->prefix."wj_portal_fieldsordering` WHERE id = " . $id;
        $result = wpjobportaldb::get_row($query);
        $row = WPJOBPORTALincluder::getJSTable('fieldsordering');
        if ($this->userFieldCanDelete($result) == true) {
            if (!$row->delete($id)) {
                return WPJOBPORTAL_DELETE_ERROR;
            }else{
                return WPJOBPORTAL_DELETED;
            }
        }
        return WPJOBPORTAL_IN_USE;
    }

    function enforceDeleteUserField($id){
        if (is_numeric($id) == false)
           return false;
        $query = "SELECT field,fieldfor FROM `".wpjobportal::$_db->prefix."wj_portal_fieldsordering` WHERE id = " . $id;
        $result = wpjobportaldb::get_row($query);
        $row = WPJOBPORTALincluder::getJSTable('fieldsordering');
        if ($this->userFieldCanDelete($result) == true) {
            if (!$row->delete($id)) {
                return WPJOBPORTAL_DELETE_ERROR;
            }else{
                return WPJOBPORTAL_DELETED;
            }
        }
        return WPJOBPORTAL_IN_USE;
    }

    function userFieldCanDelete($field) {
        $fieldname = $field->field;
        $fieldfor = $field->fieldfor;

        if($fieldfor == 1){//for deleting a company field
            $table = "companies";
        }elseif($fieldfor == 2){//for deleting a job field
            $table = "jobs";
        }elseif($fieldfor == 3){//for deleting a resume field
            $table = "resume";
        }
        $query = ' SELECT
                    ( SELECT COUNT(id) FROM `' . wpjobportal::$_db->prefix . 'wj_portal_'.$table.'` WHERE
                        params LIKE \'%"' . $fieldname . '":%\'
                    )
                    AS total';
        $total = wpjobportaldb::get_var($query);
        if ($total > 0)
            return false;
        else
            return true;
    }

    function getUserfieldsfor($fieldfor, $resumesection = null) {
        if (!is_numeric($fieldfor))
            return false;
        if (WPJOBPORTALincluder::getObjectClass('user')->isguest()) {
            $published = ' isvisitorpublished = 1 ';
        } else {
            $published = ' published = 1 ';
        }
        if ($resumesection != null) {
            $published .= " AND section = $resumesection ";
        }
        $query = "SELECT field,userfieldparams,userfieldtype FROM `" . wpjobportal::$_db->prefix . "wj_portal_fieldsordering` WHERE fieldfor = " . $fieldfor . " AND isuserfield = 1 AND " . $published;
        $fields = wpjobportaldb::get_results($query);
        return $fields;
    }

    function getUserFieldbyId($id, $fieldfor) {
        if ($id) {
            if (is_numeric($id) == false)
                return false;
            $query = "SELECT * FROM " . wpjobportal::$_db->prefix . "wj_portal_fieldsordering WHERE id = " . $id;
            wpjobportal::$_data[0]['userfield'] = wpjobportaldb::get_row($query);
            $params = wpjobportal::$_data[0]['userfield']->userfieldparams;
            wpjobportal::$_data[0]['userfieldparams'] = !empty($params) ? json_decode($params, True) : '';
        }
        wpjobportal::$_data[0]['fieldfor'] = $fieldfor;
        return;
    }
    function makeDependentComboFiledForResume($val,$childfield,$type,$section,$sectionid,$themecall){

        $query = "SELECT field,depandant_field,userfieldparams,fieldtitle, required FROM `".wpjobportal::$_db->prefix."wj_portal_fieldsordering` WHERE field = '".$childfield."'";
        $data = wpjobportal::$_db->get_row($query);
        $decoded_data = json_decode($data->userfieldparams);
        $comboOptions = array();
        $themeclass=($themecall)?getJobManagerThemeClass('select'):"";

        $flag = 0;
        foreach ($decoded_data as $key => $value) {
            if($key==$val){
               for ($i=0; $i <count($value) ; $i++) {
                   $comboOptions[] = (object)array('id' => $value[$i], 'text' => $value[$i]);
                   $flag = 1;
               }
            }
        }
        if($themecall == 1){
            $theme_string = ' ,'.$themecall;
        }else{
            $theme_string = '';
        }

        $jsFunction = '';
        if ($data->depandant_field != null) {
            $jsFunction = "getDataForDepandantFieldResume('" . $data->field . "','" . $data->depandant_field . "','" . $type . "','" . $section . "','" . $sectionid . "'".$theme_string.");";
        }
        $cssclass="";
        if($data->required == 1){
            $cssclass = 'required';
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
                    $extraattr['data-myrequired'] = $cssclass;
                    $extraattr['class'] = "inputbox one";
                }
            }
        }
        $textvar =  ($flag == 1) ?  __('Select', 'wp-job-portal').' '.$data->fieldtitle : '';
        $html =WPJOBPORTALincluder::getObjectClass('customfields')->selectResume($childfield, $comboOptions, '', $textvar, $extraattr , null,$section , $sectionid);
        $phtml = json_encode($html);
        return $phtml;
    }
    function DataForDepandantFieldResume(){
        $val = WPJOBPORTALrequest::getVar('fvalue');
        $childfield = WPJOBPORTALrequest::getVar('child');
        $section = WPJOBPORTALrequest::getVar('section');
        $sectionid = WPJOBPORTALrequest::getVar('sectionid');
        $type = WPJOBPORTALrequest::getVar('type');
        $themecall = WPJOBPORTALrequest::getVar('themecall');
        switch ($type) {
            case 1: //select type dependent combo
            case 2: //radio type dependent combo
                return $this->makeDependentComboFiledForResume($val,$childfield,$type,$section,$sectionid,$themecall);
            break;
        }
        return;
    }

    function DataForDepandantField(){
        $val = WPJOBPORTALrequest::getVar('fvalue');
        $childfield = WPJOBPORTALrequest::getVar('child');
        $themecall = WPJOBPORTALrequest::getVar('themecall');
        $themeclass="";
        if($themecall){
            $theme_string = ','. $themecall ;
            if(function_exists("getJobManagerThemeClass")){
                $themeclass=getJobManagerThemeClass("select");
            }
        }else{
            $theme_string = '';
        }
        $query = "SELECT userfieldparams, fieldtitle, required, depandant_field,field  FROM `".wpjobportal::$_db->prefix."wj_portal_fieldsordering` WHERE field = '".$childfield."'";
        $data = wpjobportal::$_db->get_row($query);
        $decoded_data = json_decode($data->userfieldparams);
        $comboOptions = array();
        $flag = 0;
        if(!empty($decoded_data) && $decoded_data != ''){
            foreach ($decoded_data as $key => $value) {
                if($key==$val){
                   for ($i=0; $i <count($value) ; $i++) {
                       $comboOptions[] = (object)array('id' => $value[$i], 'text' => $value[$i]);
                       $flag = 1;
                   }
                }
            }
        }
        $textvar =  ($flag == 1) ?  __('Select', 'wp-job-portal').' '.$data->fieldtitle : '';
        $required = '';
        if($data->required == 1){
            $required = 'required';
        }
        $jsFunction = '';
        if ($data->depandant_field != null) {
            $jsFunction = " getDataForDepandantField('" . $data->field . "','" . $data->depandant_field . "','1','',''". $theme_string.");";
        }
        $html = WPJOBPORTALformfield::select($childfield, $comboOptions, '',$textvar, array('data-validation' => $required,'class' => 'inputbox one '.$themeclass, 'onchange' => $jsFunction));
        $phtml = json_encode($html);
        return $phtml;
    }

    function getFieldTitleByFieldAndFieldfor($field,$fieldfor){
        if(!is_numeric($fieldfor)) return false;
        $query = "SELECT fieldtitle FROM `".wpjobportal::$_db->prefix."wj_portal_fieldsordering` WHERE field = '".$field."' AND fieldfor = ".$fieldfor;
        $title = wpjobportal::$_db->get_var($query);
        return $title;
    }



    function getFieldsForListing($fieldfor){
        if (WPJOBPORTALincluder::getObjectClass('user')->isguest()) {
            $published = ' isvisitorpublished = 1 ';
        } else {
            $published = ' published = 1 ';
        }

        $query = "SELECT field  FROM " . wpjobportal::$_db->prefix . "wj_portal_fieldsordering WHERE showonlisting = 1 AND " . $published . " AND fieldfor =" . $fieldfor ;
        $data = wpjobportaldb::get_results($query);
        $return_array = array();
        foreach ($data as $field) {
            $return_array[$field->field] = 1;
        }

        return $return_array;
    }

     function getUnpublishedFieldsFor($fieldfor,$section = null){
        if(!is_numeric($fieldfor)) return false;
        if($section != null)
            if(!is_numeric($section)) return false;

        $uid = WPJOBPORTALincluder::getObjectClass('user')->uid();
        if ($uid != "" AND $uid != 0){ // is admin Or is logged in
            $published = "published = 0";
        }else{
            $published = "isvisitorpublished = 0";
        }
        if($section != null){
            $published .= ' AND section = '.$section;
        }

        $query = "SELECT field FROM `". wpjobportal::$_db->prefix ."wj_portal_fieldsordering` WHERE fieldfor = ".$fieldfor." AND ".$published;
        $fields = wpjobportaldb::get_results($query);
        return $fields;
    }


    function getResumeFieldsOrderingBySection($section) {
        if(!is_numeric($section))  return false;

        $uid = WPJOBPORTALincluder::getObjectClass('user')->uid();
        $is_visitor = '';
        if ($uid != "" AND $uid != 0){ // is admin Or is logged in
            $published = "published = 1";
        }else{
            $published = "isvisitorpublished = 1";
            $is_visitor = ' , fields.isvisitorpublished AS published ';
        }

        $query = "SELECT fields.* ".$is_visitor." FROM `". wpjobportal::$_db->prefix ."wj_portal_fieldsordering` AS fields
            WHERE ".$published." AND fieldfor = 3 AND section = ".$section;
        $query .= " ORDER BY section,ordering ASC";
        $fieldsOrdering = wpjobportaldb::get_results($query);
        return $fieldsOrdering;
    }

    function getResumeFieldsOrderingBySection1($section) { // created and used by muhiaudin for resume view 'formresume'
        $uid = WPJOBPORTALincluder::getObjectClass('user')->uid();
        if (empty($section)) {
            return false;
        }
        if ($uid != "" AND $uid != 0) {
            $fieldfor = 3;
        } else {
            $fieldfor = 16;
        }

        if ($fieldfor == 16) { // resume visitor case
            $fieldfor = 3;
            $query = "SELECT  id,field,fieldtitle,ordering,section,fieldfor,isvisitorpublished AS published,sys,cannotunpublish,required
                        FROM `" . wpjobportal::$_db->prefix . "wj_portal_fieldsordering`
                        WHERE isvisitorpublished = 1 AND fieldfor =  " . $fieldfor . " AND section = " . $section
                    . " ORDER BY section,ordering";
        } else {
            $published_field = "published = 1";
            if (is_user_logged_in() == false) {
                $published_field = "isvisitorpublished = 1";
            }
            $query = "SELECT  * FROM `" . wpjobportal::$_db->prefix . "wj_portal_fieldsordering`
                        WHERE " . $published_field . " AND fieldfor =  " . $fieldfor . " AND section = " . $section
                    . " ORDER BY section,ordering ";
        }
        $fieldsOrdering = wpjobportaldb::get_results($query);
        return $fieldsOrdering;
    }


    function getMessagekey(){
        $key = 'fieldordering';if(wpjobportal::$_common->wpjp_isadmin()){$key = 'admin_'.$key;}return $key;
    }

}
?>
