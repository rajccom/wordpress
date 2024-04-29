<?php

if (!defined('ABSPATH'))
    die('Restricted Access');

class WPJOBPORTALCompanyModel {

    function getCompanies_Widget($companytype, $noofcompanies) {
        if ((!is_numeric($companytype)) || ( !is_numeric($noofcompanies)))
            return false;

        if ($companytype == 2) {
            $inquery = ' AND company.isfeaturedcompany = 1 AND DATE(company.endfeatureddate) >= CURDATE() ';
        } else {
            return '';
        }

        $query = "SELECT  company.*, CONCAT(company.alias,'-',company.id) AS companyaliasid ,company.id AS companyid,company.logofilename AS companylogo
            FROM `" . wpjobportal::$_db->prefix . "wj_portal_companies` AS company
            WHERE company.status = 1  ";
        $query .= $inquery . " ORDER BY company.created DESC ";
        if ($noofcompanies != -1)
            $query .=" LIMIT " . $noofcompanies;
        $results = wpjobportaldb::get_results($query);

        $results = wpjobportaldb::get_results($query);
        foreach ($results AS $d) {
            $d->location = WPJOBPORTALincluder::getJSModel('city')->getLocationDataForView($d->city);
        }
        wpjobportal::$_data['config'] = wpjobportal::$_config->getConfigByFor('company');
        return $results;
    }

    function getAllCompaniesForSearchForCombo() {
        $query = "SELECT id, name AS text FROM `" . wpjobportal::$_db->prefix . "wj_portal_companies` ORDER BY name ASC ";
        $rows = wpjobportaldb::get_results($query);
        return $rows;
    }

    function getCompanybyIdForView($companyid) {
        if (is_numeric($companyid) == false)
            return false;

        $query = "SELECT company.*,city.cityName AS cityname
                    FROM `" . wpjobportal::$_db->prefix . "wj_portal_companies` AS company
                    LEFT JOIN `" . wpjobportal::$_db->prefix . "wj_portal_cities` AS city ON company.city = city.id
                    WHERE  company.id = " . $companyid;
        wpjobportal::$_data[0] = wpjobportaldb::get_row($query);
        wpjobportal::$_data[0]->location = WPJOBPORTALincluder::getJSModel('city')->getLocationDataForView(wpjobportal::$_data[0]->city);
        wpjobportal::$_data[2] = wpjobportal::$_wpjpfieldordering->getFieldsOrderingforView(1);
        wpjobportal::$_data[3] = wpjobportal::$_data[0]->params;
        wpjobportal::$_data['companycontactdetail'] = true;
       // if user is guest or other then owner then make sure of contact detail on view company
        if (WPJOBPORTALincluder::getObjectClass('user')->isguest() || wpjobportal::$_data[0]->uid != WPJOBPORTALincluder::getObjectClass('user')->uid()) {
            if(in_array('credits',wpjobportal::$_active_addons)){
                $subType = wpjobportal::$_config->getConfigValue('submission_type');
                if($subType == 1){
                    wpjobportal::$_data['companycontactdetail'] = true;
                }elseif ($subType == 2 || $subType == 3) {
                    $contantdetail_paid = 1;
                    if($subType == 2){
                        if(!wpjobportal::$_config->getConfigValue('job_viewcompanycontact_price_perlisting') > 0){
                            $contantdetail_paid = 0;
                        }
                    }
                    if($contantdetail_paid == 1){
                        wpjobportal::$_data['companycontactdetail'] = $this->checkAlreadyViewCompanyContactDetail($companyid);
                    }else{
                        wpjobportal::$_data['companycontactdetail'] = true;
                    }
                }
            }else{
                wpjobportal::$_data['companycontactdetail'] = true;
            }
        }
        //update the company view counter
        //DB class limitations
        $query = "UPDATE `" . wpjobportal::$_db->prefix . "wj_portal_companies` SET hits = hits + 1 WHERE id = " . $companyid;
        wpjobportal::$_db->query($query);
        wpjobportal::$_data['config'] = wpjobportal::$_config->getConfigByFor('company');
        if(in_array('credits', wpjobportal::$_active_addons)){
            wpjobportal::$_data['paymentconfig'] = wpjobportal::$_wpjppaymentconfig->getPaymentConfigFor('paypal,stripe,woocommerce',true);
        }

        return;
    }

    public function checkAlreadyViewCompanyContactDetail($companyid,$data='') {
        $userobject = WPJOBPORTALincluder::getObjectClass('user');

        if($userobject->isguest() || !$userobject->isWPJOBPORTALuser())
            return false;
        if (!is_numeric($companyid))
            return false;

        if(current_user_can( 'manage_options' ) && !isset($data['uid'])){
            return true;
        }
        if(isset($data['uid'])){
           $uid = $data['uid'];
        }else{
            $uid = WPJOBPORTALincluder::getObjectClass('user')->uid();
        }
        if(!is_numeric($uid)) return false;
        $query = "SELECT COUNT(id) FROM `" . wpjobportal::$_db->prefix . "wj_portal_jobseeker_view_company` WHERE companyid = " . $companyid . " AND uid = " . $uid;
        $result = wpjobportal::$_db->get_var($query);
        if ($result > 0)
            return true;
        else
            return false;
    }

    function getCompanybyId($c_id) {

        if ($c_id)
            if (!is_numeric($c_id))
                return false;
        if ($c_id) {
            $query = "SELECT * FROM `" . wpjobportal::$_db->prefix . "wj_portal_companies` WHERE id =" . $c_id;
            wpjobportal::$_data[0] = wpjobportaldb::get_row($query);
            if(wpjobportal::$_data[0] != ''){
                wpjobportal::$_data[0]->multicity = wpjobportal::$_common->getMultiSelectEdit($c_id, 2);
            }
        }
        wpjobportal::$_data[2] = wpjobportal::$_wpjpfieldordering->getFieldsOrderingforForm(WPJOBPORTAL_COMPANY); // company fields
        return;
    }


    function getMyCompanies($uid) {
        if (!is_numeric($uid)) return false;
        //Filters
        $searchcompany = isset(wpjobportal::$_search['search_filter']['searchcompany']) ? wpjobportal::$_search['search_filter']['searchcompany'] : '';

        //Front end search var
        $wpjobportal_city = isset(wpjobportal::$_search['search_filter']['wpjobportal_city']) ? wpjobportal::$_search['search_filter']['wpjobportal_city'] : '';

        $inquery = '';
        if ($searchcompany) {
            $inquery = " AND LOWER(company.name) LIKE '%$searchcompany%'";
        }
        if ($wpjobportal_city) {
            if(is_numeric($wpjobportal_city)){
                $inquery .= " AND LOWER(company.city) LIKE '%$wpjobportal_city%'";
            }else{
                $arr = wpjobportalphplib::wpJP_explode( ',' , $wpjobportal_city);
                $cityQuery = false;
                foreach($arr as $i){
                    if($cityQuery){
                        $cityQuery .= " OR LOWER(company.city) LIKE '%$i%' ";
                    }else{
                        $cityQuery = " LOWER(company.city) LIKE '%$i%' ";
                    }
                }
                $inquery .= " AND ( $cityQuery ) ";
            }
        }


        wpjobportal::$_data['filter']['wpjobportal-city'] = wpjobportal::$_common->getCitiesForFilter($wpjobportal_city);
        wpjobportal::$_data['filter']['searchcompany'] = $searchcompany;


        //Pagination
        $query = "SELECT COUNT(id) FROM " . wpjobportal::$_db->prefix . "wj_portal_companies AS company WHERE uid = " . $uid;
        $query .=$inquery;

        $total = wpjobportaldb::get_var($query);
        wpjobportal::$_data['total'] = $total;
        wpjobportal::$_data[1] = WPJOBPORTALpagination::getPagination($total,'mycompany');
        //Data
        $query = "SELECT company.id,company.name,company.logofilename,CONCAT(company.alias,'-',company.id) AS aliasid,company.created,company.serverid,company.city,company.status,company.isfeaturedcompany
                 ,company.endfeatureddate,company.params,company.url
                FROM " . wpjobportal::$_db->prefix . "wj_portal_companies AS company
                WHERE company.uid = " . $uid;
        $query .= $inquery;
        if(in_array('multicompany', wpjobportal::$_active_addons)){
            $query .= " ORDER BY company.created DESC LIMIT " . WPJOBPORTALpagination::$_offset . "," . WPJOBPORTALpagination::$_limit;
        }else{
            $query .= " ORDER BY company.id ASC LIMIT 0,1";
        }
        wpjobportal::$_data[0] = wpjobportaldb::get_results($query);
        $data = array();
        foreach (wpjobportal::$_data[0] AS $d) {
            $d->location = WPJOBPORTALincluder::getJSModel('city')->getLocationDataForView($d->city);
            $data[] = $d;
        }
        wpjobportal::$_data[0] = $data;
        wpjobportal::$_data['fields'] = wpjobportal::$_wpjpfieldordering->getFieldsOrderingforView(1);
        wpjobportal::$_data['config'] = wpjobportal::$_config->getConfigByFor('company');
        return;
    }

    function sorting() {
        $pagenum = WPJOBPORTALrequest::getVar('pagenum');
        wpjobportal::$_data['sorton'] = wpjobportal::$_search['search_filter']['sorton'] != '' ? wpjobportal::$_search['search_filter']['sorton']: 3;
        wpjobportal::$_data['sortby'] = wpjobportal::$_search['search_filter']['sortby'] != '' ? wpjobportal::$_search['search_filter']['sortby']: 2;

        switch (wpjobportal::$_data['sorton']) {
            case 3: // created
                wpjobportal::$_data['sorting'] = ' company.created ';
                break;
            case 1: // company title
                wpjobportal::$_data['sorting'] = ' company.name ';
                break;
            case 2: // category
                wpjobportal::$_data['sorting'] = ' cat.cat_title ';
                break;
            case 4: // location
                wpjobportal::$_data['sorting'] = ' city.cityName ';
                break;
            case 5: // status
                wpjobportal::$_data['sorting'] = ' company.status ';
                break;
            default:
                //wpjobportal::$_data['sorting'] = ' company.created ';
            break;
        }
        if (wpjobportal::$_data['sortby'] == 1) {
            wpjobportal::$_data['sorting'] .= ' ASC ';
        } else {
            wpjobportal::$_data['sorting'] .= ' DESC ';
        }
        wpjobportal::$_data['combosort'] = wpjobportal::$_data['sorton'];
    }

    function getAllCompanies() {
        if(wpjobportal::$_common->wpjp_isadmin()){
            $this->sorting();
        }else{
            $this->getOrdering();
        }

        //Filters
        $searchcompany = wpjobportal::$_search['search_filter']['searchcompany'];
        $searchjobcategory = wpjobportal::$_search['search_filter']['searchjobcategory'];
        $status = wpjobportal::$_search['search_filter']['status'];
        $datestart = wpjobportal::$_search['search_filter']['datestart'];
        $dateend = wpjobportal::$_search['search_filter']['dateend'];
        $featured = wpjobportal::$_search['search_filter']['featured'];
        //Front end search var
        $wpjobportal_company = wpjobportal::$_search['search_filter']['wpjobportal_company'];
        $wpjobportal_city = wpjobportal::$_search['search_filter']['wpjobportal_city'];
        if ($searchjobcategory)
            if (is_numeric($searchjobcategory) == false)
                return false;
        $inquery = '';
        if ($searchcompany) {
            $inquery = " AND LOWER(company.name) LIKE '%$searchcompany%'";
        }
        if ($wpjobportal_company) {
            $inquery = " AND LOWER(company.name) LIKE '%$wpjobportal_company%'";
        }
        if ($wpjobportal_city) {
			if(is_numeric($wpjobportal_city)){
				$inquery .= " AND company.city = $wpjobportal_city ";
			}else{
				$arr = wpjobportalphplib::wpJP_explode( ',' , $wpjobportal_city);
				$cityQuery = false;
				foreach($arr as $i){
					if($cityQuery){
						$cityQuery .= " OR company.city = $i ";
					}else{
						$cityQuery = " company.city = $i ";
					}
				}
				$inquery .= " AND ( $cityQuery ) ";
			}
        }

        if (is_numeric($status)) {
            $inquery .= " AND company.status = " . $status;
        }

        if ($datestart != null) {
            $datestart = date('Y-m-d',strtotime($datestart));
            $inquery .= " AND DATE(company.created) >= '" . $datestart . "'";
        }

        if ($dateend != null) {
            $dateend = date('Y-m-d',strtotime($dateend));
            $inquery .= " AND DATE(company.created) <= '" . $dateend . "'";
        }
        $curdate = date('Y-m-d');
        if ($featured != null) {
           $inquery .= apply_filters('wpjobportal_addons_search_feature_query',false);
        }

        wpjobportal::$_data['filter']['wpjobportal-company'] = $wpjobportal_company;
        wpjobportal::$_data['filter']['wpjobportal-city'] = wpjobportal::$_common->getCitiesForFilter($wpjobportal_city);
        wpjobportal::$_data['filter']['searchcompany'] = $searchcompany;
        wpjobportal::$_data['filter']['searchjobcategory'] = $searchjobcategory;
        wpjobportal::$_data['filter']['status'] = $status;
        wpjobportal::$_data['filter']['datestart'] = $datestart;
        wpjobportal::$_data['filter']['dateend'] = $dateend;
        wpjobportal::$_data['filter']['featured'] = $featured;
        //Pagination
        $query = "SELECT COUNT(id) FROM " . wpjobportal::$_db->prefix . "wj_portal_companies AS company WHERE company.status != 0";
        $query .=$inquery;

        $total = wpjobportaldb::get_var($query);
        wpjobportal::$_data['total'] = $total;
        wpjobportal::$_data[1] = WPJOBPORTALpagination::getPagination($total);

        //Data
        $query = "SELECT company.uid,company.name,CONCAT(company.alias,'-',company.id) AS aliasid,
                company.city, company.created,company.logofilename,
                company.status,company.url,company.id,company.params,company.isfeaturedcompany,company.endfeatureddate,company.description
                FROM " . wpjobportal::$_db->prefix . "wj_portal_companies AS company
                LEFT JOIN `" . wpjobportal::$_db->prefix . "wj_portal_cities` AS city ON city.id = (SELECT cityid FROM `" . wpjobportal::$_db->prefix . "wj_portal_companycities` WHERE companyid = company.id ORDER BY id DESC LIMIT 1)
                WHERE company.status != 0";

        $query .= $inquery;
        if(wpjobportal::$_common->wpjp_isadmin()){
            $query .= " ORDER BY " . wpjobportal::$_data['sorting'];
        }else{
            $query.= " ORDER BY " . wpjobportal::$_ordering;
        }
        $query .= " LIMIT " . WPJOBPORTALpagination::$_offset . "," . WPJOBPORTALpagination::$_limit;
        $results = wpjobportaldb::get_results($query);
        $data = array();
        foreach ($results AS $d) {
            $d->location = WPJOBPORTALincluder::getJSModel('city')->getLocationDataForView($d->city);
            $data[] = $d;
        }
        wpjobportal::$_data[0] = $data;
        if(wpjobportal::$theme_chk == 1 && wpjobportal::$_data != '' && isset($wpjobportal_city) && $wpjobportal_city != ''){
                wpjobportal::$_data['multicity'] = $this->getCitySelected($wpjobportal_city);
            }
        wpjobportal::$_data['fields'] = wpjobportal::$_wpjpfieldordering->getFieldsOrderingforView(1);
        wpjobportal::$_data['config'] = wpjobportal::$_config->getConfigByFor('company');
        return;
    }

    function getCitySelected($city){

        $query = "SELECT id, name FROM " . wpjobportal::$_db->prefix . "wj_portal_cities WHERE id IN (".$city.")";
        $results = wpjobportaldb::get_results($query);
        return $json_response = json_encode($results);
    }

    function getAllUnapprovedCompanies() {
        $this->sorting();
        //Filters
        $searchcompany = wpjobportal::$_search['search_filter']['searchcompany'];
        // $categoryid = wpjobportal::$_search['search_filter']['searchjobcategory'];
        $datestart = wpjobportal::$_search['search_filter']['datestart'];
        $dateend = wpjobportal::$_search['search_filter']['dateend'];

        wpjobportal::$_data['filter']['searchcompany'] = $searchcompany;
        // wpjobportal::$_data['filter']['searchjobcategory'] = $categoryid;
        wpjobportal::$_data['filter']['datestart'] = $datestart;
        wpjobportal::$_data['filter']['dateend'] = $dateend;

        $inquery = '';
        if ($searchcompany)
            $inquery = " AND LOWER(company.name) LIKE '%$searchcompany%'";

        if ($datestart != null) {
            $datestart = date('Y-m-d',strtotime($datestart));
            $inquery .= " AND DATE(company.created) >= '" . $datestart . "'";
        }

        if ($dateend != null) {
            $dateend = date('Y-m-d',strtotime($dateend));
            $inquery .= " AND DATE(company.created) <= '" . $dateend . "'";
        }

        //Pagination
        $query = "SELECT COUNT(company.id)
                    FROM " . wpjobportal::$_db->prefix . "wj_portal_companies AS company
                    WHERE (company.status = 0 )";
        $query .=$inquery;

        $total = wpjobportaldb::get_var($query);
        wpjobportal::$_data['total'] = $total;
        wpjobportal::$_data[1] = WPJOBPORTALpagination::getPagination($total);

        //Data
        $query = "SELECT company.*
                FROM " . wpjobportal::$_db->prefix . "wj_portal_companies AS company
                LEFT JOIN `" . wpjobportal::$_db->prefix . "wj_portal_cities` AS city ON city.id = (SELECT cityid FROM `" . wpjobportal::$_db->prefix . "wj_portal_companycities` WHERE companyid = company.id ORDER BY id DESC LIMIT 1)
                WHERE (company.status = 0 OR company.isfeaturedcompany = 0)";
        $query .=$inquery;
        $query .= " ORDER BY " . wpjobportal::$_data['sorting'] . " LIMIT " . WPJOBPORTALpagination::$_offset . "," . WPJOBPORTALpagination::$_limit;

        wpjobportal::$_data[0] = wpjobportaldb::get_results($query);
        wpjobportal::$_data['fields'] = wpjobportal::$_wpjpfieldordering->getFieldsOrderingforView(1);
        // print_r(wpjobportal::$_data[0]);
        return;
    }

    function storeCompany($data){
        if(empty($data)){
            return false;
        }
        # request parameters
            $cuser = WPJOBPORTALincluder::getObjectClass('user');
            $id = (int) $data['id'];
            $isnew = !$id;

        # prepare data + business logic
            if($isnew){
                $data['created'] = current_time('mysql');
                $submissionType = wpjobportal::$_config->getConfigValue('submission_type');
                if(!wpjobportal::$_common->wpjp_isadmin()){
                    $data['uid'] = $cuser->uid();
                    if(in_array('credits', wpjobportal::$_active_addons)){
                        # prepare data + credits
                        if($submissionType == 1){
                            $data['status'] = wpjobportal::$_config->getConfigValue('companyautoapprove');
                        }elseif ($submissionType == 2) {
                            $data['status'] = 3;
                        }elseif ($submissionType == 3) {
                           $upakid = WPJOBPORTALrequest::getVar('upakid',null,0);
                            /*Getting Package filter for All Module*/
                            $package = apply_filters('wpjobportal_addons_userpackages_permodule',false,$upakid,$cuser->uid(),'remcompany');
                            if( !$package ){
                                return WPJOBPORTAL_SAVE_ERROR;
                            }
                            if( $package->expired ){
                                return WPJOBPORTAL_SAVE_ERROR;
                            }
                            //if Department are not unlimited & there is no remaining left
                            if( $package->companies!=-1 && !$package->remcompany ){ //-1 = unlimited
                                return WPJOBPORTAL_SAVE_ERROR;
                            }
                            #user packae id--
                            $data['status'] = wpjobportal::$_config->getConfigValue('companyautoapprove');
                            $data['userpackageid'] = $upakid;
                        }
                    }else{
                        $data['status'] = wpjobportal::$_config->getConfigValue('companyautoapprove');
                    }
                }else{
                    if(wpjobportal::$_common->wpjp_isadmin()){
                        if ($submissionType == 3) {
                            if ($data['payment'] == 0) {
                                $upakid = WPJOBPORTALrequest::getVar('upakid',null,0);
                                $data['userpackageid'] = $upakid;
                            } else {
                                $upakid = WPJOBPORTALrequest::getVar('upakid',null,0);
                                /*Getting Package filter for All Module*/
                                $package = apply_filters('wpjobportal_addons_userpackages_permodule',false,$upakid,$data['uid'],'remcompany');
                                if( !$package ){
                                    return WPJOBPORTAL_SAVE_ERROR;
                                }
                                if( $package->expired ){
                                    return WPJOBPORTAL_SAVE_ERROR;
                                }
                                //if Department are not unlimited & there is no remaining left
                                if( $package->companies!=-1 && !$package->remcompany ){ //-1 = unlimited
                                    return WPJOBPORTAL_SAVE_ERROR;
                                }
                                #user packae id--
                                $data['userpackageid'] = $upakid;
                            }
                        }
                    }
                }
            }
            $data['alias'] = wpjobportal::$_common->stringToAlias(empty($data['alias']) ? $data['name'] : $data['alias']);
        # sanitize data
            $tempdesc = $data['description'];
            $data = wpjobportal::sanitizeData($data);
            $data['description'] = wpautop(wptexturize(wpjobportalphplib::wpJP_stripslashes($tempdesc)));
            $data = wpjobportal::$_common->stripslashesFull($data);

        # store in db
            $row = WPJOBPORTALincluder::getJSTable('company');
            if(!($row->bind($data) && $row->check() && $row->store())){
                return false;
            }
            $companyid = $row->id;
            wpjobportal::$_data['id'] = $companyid;
        #store custom fields
        wpjobportal::$_wpjpcustomfield->storeCustomFields(WPJOBPORTAL_COMPANY,$companyid,$data);
        if(in_array('credits', wpjobportal::$_active_addons)){
            if($isnew && $submissionType == 3){
                $trans = WPJOBPORTALincluder::getJSTable('transactionlog');
                $arr = array();
                if (!wpjobportal::$_common->wpjp_isadmin()) {
                    $arr['uid'] = $cuser->uid();
                }elseif (wpjobportal::$_common->wpjp_isadmin()) {
                    $arr['uid'] = $data['uid'];
                }
                $arr['userpackageid'] = $upakid;
                $arr['recordid'] = $row->id;
                $arr['type'] = 'company';
                $arr['created'] = current_time('mysql');
                $arr['status'] = 1;
                $trans->bind($arr);
                $trans->store();
            }
        }

        # store multiple cities with company
            if(isset($data['city'])){
                $this->storeMultiCitiesCompany($data['city'], $companyid);
            }

        # save company logo
            if(isset($data['company_logo_deleted'])){
                $this->deleteCompanyLogo($companyid);
            }
            if ($_FILES['logo']['size'] > 0) {
                if(!isset($data['company_logo_deleted'])){
                    $this->deleteCompanyLogo($companyid);
                }
                $res = $this->uploadFile($companyid);
                if ($res == 6){
                    $msg = WPJOBPORTALMessages::getMessage(WPJOBPORTAL_FILE_TYPE_ERROR, '');
                    WPJOBPORTALMessages::setLayoutMessage($msg['message'], $msg['status'],$this->getMessagekey());
                }
                if($res == 5){
                    $msg = WPJOBPORTALMessages::getMessage(WPJOBPORTAL_FILE_SIZE_ERROR, '');
                    WPJOBPORTALMessages::setLayoutMessage($msg['message'], $msg['status'],$this->getMessagekey());
                }
            }

        # send new company email
            if($isnew){
                WPJOBPORTALincluder::getJSModel('emailtemplate')->sendMail(1, 1, $companyid);
            }

        return $companyid;
    }

    function storeMultiCitiesCompany($city_id, $companyid) { // city id comma seprated
        if (!is_numeric($companyid)){
            return false;
        }


        $query = "SELECT cityid FROM " . wpjobportal::$_db->prefix . "wj_portal_companycities WHERE companyid = " . $companyid;
        $old_cities = wpjobportaldb::get_results($query);

        $id_array = wpjobportalphplib::wpJP_explode(",", $city_id);
        $row = WPJOBPORTALincluder::getJSTable('companycities');
        $error = array();

        foreach ($old_cities AS $oldcityid) {
            $match = false;
            foreach ($id_array AS $cityid) {
                if ($oldcityid->cityid == $cityid) {
                    $match = true;
                    break;
                }
            }
            if ($match == false) {
                $query = "DELETE FROM " . wpjobportal::$_db->prefix . "wj_portal_companycities WHERE companyid = " . $companyid . " AND cityid=" . $oldcityid->cityid;

                if (!wpjobportaldb::query($query)) {
                    $err = wpjobportal::$_db->last_error;
                    $error[] = $err;
                }
            }
        }
        foreach ($id_array AS $cityid) {
            $insert = true;
            foreach ($old_cities AS $oldcityid) {
                if ($oldcityid->cityid == $cityid) {
                    $insert = false;
                    break;
                }
            }
            if ($insert) {
                $cols = array();
                $cols['id'] = "";
                $cols['companyid'] = $companyid;
                $cols['cityid'] = $cityid;
                if (!$row->bind($cols)) {
                    $err = wpjobportal::$_db->last_error;
                    $error[] = $err;
                }
                if (!$row->store()) {
                    $err = wpjobportal::$_db->last_error;
                    $error[] = $err;
                }
            }
        }
        if (empty($error)){
            return true;
        }
        return false;
    }

    function getUidByCompanyId($companyid) {
        if (!is_numeric($companyid))
            return false;
        $query = "SELECT uid FROM `" . wpjobportal::$_db->prefix . "wj_portal_companies` WHERE id = " . $companyid;
        $uid = wpjobportaldb::get_var($query);
        // var_dump($query);
        // die();
        return $uid;
    }

    function deleteCompanies($ids) {
        if (empty($ids))
            return false;
        $row = WPJOBPORTALincluder::getJSTable('company');
        $notdeleted = 0;
        $mailextradata = array();
        foreach ($ids as $id) {
            $query = "SELECT company.name,company.contactemail AS contactemail FROM `" . wpjobportal::$_db->prefix . "wj_portal_companies` AS company  WHERE company.id = " . $id;
            $companyinfo = wpjobportaldb::get_row($query);
            if(empty($companyinfo)){
                continue;
            }
            $mailextradata['companyname'] = $companyinfo->name;
            /*$mailextradata['contactname'] = $companyinfo->contactname;*/
            $mailextradata['contactemail'] = $companyinfo->contactemail;
            if ($this->companyCanDelete($id) == true) {
                if (!$row->delete($id)) {
                    $notdeleted += 1;
                } else {
                    $query = "DELETE FROM `" . wpjobportal::$_db->prefix . "wj_portal_companycities` WHERE companyid = " . $id;
                    wpjobportaldb::query($query);
                    WPJOBPORTALincluder::getJSModel('emailtemplate')->sendMail(1, 2, $id,$mailextradata); // 1 for company,2 for delete company

                    $data_directory = wpjobportal::$_config->getConfigurationByConfigName('data_directory');
                    $wpdir = wp_upload_dir();
                    array_map('unlink', glob($wpdir['basedir'] . '/' . $data_directory . "/data/employer/comp_".$id."/logo/*.*"));//deleting files
                    if(is_dir($wpdir['basedir'] . '/' . $data_directory . "/data/employer/comp_".$id."/logo")){
                        @rmdir($wpdir['basedir'] . '/' . $data_directory . "/data/employer/comp_".$id."/logo");
                    }
                    array_map('unlink', glob($wpdir['basedir'] . '/' . $data_directory . "/data/employer/comp_".$id."/*.*"));//deleting files
                    if (file_exists($wpdir['basedir'] . '/' . $data_directory . "/data/employer/comp_".$id)) {
                        @rmdir($wpdir['basedir'] . '/' . $data_directory . "/data/employer/comp_".$id);
                    }
                }
            } else {
                $notdeleted += 1;
            }
        }
        if ($notdeleted == 0) {
            WPJOBPORTALMessages::$counter = false;
            return WPJOBPORTAL_DELETED;
        } else {
            WPJOBPORTALMessages::$counter = $notdeleted;
            return WPJOBPORTAL_DELETE_ERROR;
        }
    }

    function companyCanDelete($companyid) {
        if (!is_numeric($companyid))
            return false;
        if(!wpjobportal::$_common->wpjp_isadmin()){
            if(!$this->getIfCompanyOwner($companyid)){
                return false;
            }
        }
        $query = "SELECT
                    ( SELECT COUNT(id) FROM `" . wpjobportal::$_db->prefix . "wj_portal_jobs` WHERE companyid = " . $companyid . ")";
                    if(in_array('departments', wpjobportal::$_active_addons)){
                        $query .= " + ( SELECT COUNT(id) FROM `" . wpjobportal::$_db->prefix . "wj_portal_departments` WHERE companyid = " . $companyid . ")";
                    }
                    $query .= " AS total ";
        $total = wpjobportaldb::get_var($query);
        wpjobportal::$_data['total'] = $total;
        wpjobportal::$_data[1] = WPJOBPORTALpagination::getPagination($total);
        if ($total > 0)
            return false;
        else
            return true;
    }

    function companyEnforceDeletes($companyid) {
        if (empty($companyid))
            return false;
        $row = WPJOBPORTALincluder::getJSTable('company');
        $mailextradata = array();
        $query1 = "SELECT company.name,company.contactemail AS contactemail FROM `" . wpjobportal::$_db->prefix . "wj_portal_companies` AS company  WHERE company.id = " . $companyid;
        $companyinfo = wpjobportaldb::get_row($query1);
        $mailextradata['companyname'] = $companyinfo->name;
        /* $mailextradata['contactname'] = $companyinfo->contactname;*/
        $mailextradata['contactemail'] = $companyinfo->contactemail;
        $query = "DELETE  company,job,companycity";
        if(in_array('department', wpjobportal::$_active_addons)){
            $query .= " ,department ";
        }
        $query .= " , apply, jobcity
                    FROM `" . wpjobportal::$_db->prefix . "wj_portal_companies` AS company
                    LEFT JOIN `" . wpjobportal::$_db->prefix . "wj_portal_companycities` AS companycity ON company.id=companycity.companyid ";
                    if(in_array('departments', wpjobportal::$_active_addons)){
                        $query .= " LEFT JOIN `" . wpjobportal::$_db->prefix . "wj_portal_departments` AS department ON company.id=department.companyid";
                    }
        $query .= " LEFT JOIN `" . wpjobportal::$_db->prefix . "wj_portal_jobs` AS job ON company.id=job.companyid
                    LEFT JOIN `" . wpjobportal::$_db->prefix . "wj_portal_jobapply` AS apply ON job.id=apply.jobid
                    LEFT JOIN `" . wpjobportal::$_db->prefix . "wj_portal_jobcities` AS jobcity ON job.id=jobcity.jobid
                    WHERE company.id =" . $companyid;
        if (!wpjobportaldb::query($query)) {
            return WPJOBPORTAL_DELETE_ERROR;
        }
        WPJOBPORTALincluder::getJSModel('emailtemplate')->sendMail(1, 2, $companyid,$mailextradata); // 1 for company,2 for delete company

        $data_directory = wpjobportal::$_config->getConfigurationByConfigName('data_directory');
        $wpdir = wp_upload_dir();
        $file = $wpdir['basedir'] . '/' . $data_directory . "/data/employer/comp_".$companyid."/logo/*.*";
        $files = glob($file);
        array_map('unlink', $files);//deleting files
        if(file_exists($wpdir['basedir'] . '/' . $data_directory . "/data/employer/comp_".$companyid."/logo")) {
            rmdir($wpdir['basedir'] . '/' . $data_directory . "/data/employer/comp_".$companyid."/logo");
        }
        if(file_exists($wpdir['basedir'] . '/' . $data_directory . "/data/employer/comp_".$companyid)) {
            rmdir($wpdir['basedir'] . '/' . $data_directory . "/data/employer/comp_".$companyid);
        }

        return WPJOBPORTAL_DELETED;
    }

    function getCompanyForDept() {
        $uid = WPJOBPORTALincluder::getObjectClass('user')->uid();
        $query = "SELECT id  FROM `" . wpjobportal::$_db->prefix . "wj_portal_companies` WHERE status = 1 ";
        if ($uid != null) {
            if (!is_numeric($uid))
                return false;
            $query .= " AND uid = " . $uid;
        }
        $query .= " ORDER BY id ASC LIMIT 0,1";
        $companies = wpjobportaldb::get_var($query);
        if (wpjobportal::$_db->last_error != null) {
            return false;
        }
        return $companies;
    }

    function getCompanyForCombo($uid = null) {
        $query = "SELECT id, name AS text FROM `" . wpjobportal::$_db->prefix . "wj_portal_companies` WHERE status = 1 ";
        if ($uid != null) {
            if (!is_numeric($uid))
                return false;
            $query .= " AND uid = " . $uid;
        }
        $query .= " ORDER BY id ASC ";
        $companies = wpjobportaldb::get_results($query);
        if (wpjobportal::$_db->last_error != null) {
            return false;
        }
        return $companies;
    }

    function deleteCompanyLogo($companyid = 0){
        if($companyid == 0){
            $companyid = WPJOBPORTALrequest::getVar('companyid');
        }
        if(!is_numeric($companyid)){
            return false;
        }
        $row = WPJOBPORTALincluder::getJSTable('company');
        $data_directory = wpjobportal::$_config->getConfigValue('data_directory');
        $wpdir = wp_upload_dir();
        $path = $wpdir['basedir'] . '/' . $data_directory . '/data/employer/comp_' . $companyid . '/logo';
        $files = glob($path . '/*.*');
        array_map('unlink', $files);    // delete all file in the direcoty
        $query = "UPDATE `".wpjobportal::$_db->prefix."wj_portal_companies` SET logofilename = '', logoisfile = -1 WHERE id = ".$companyid;
        wpjobportal::$_db->query($query);
        return true;
    }

    function uploadFile($id) {
        $result =  WPJOBPORTALincluder::getObjectClass('uploads')->uploadCompanyLogo($id);
        return $result;
    }

    function approveQueueCompanyModel($id) {
        if (is_numeric($id) == false)
            return false;
        $row = WPJOBPORTALincluder::getJSTable('company');
        if($row->load($id)){
            $row->columns['status'] = 1;
            if(!$row->store()){
                return WPJOBPORTAL_APPROVE_ERROR;
            }
        }else{
            return WPJOBPORTAL_APPROVE_ERROR;
        }
        //send email
        $company_queue_approve_email = WPJOBPORTALincluder::getJSModel('emailtemplate')->sendMail(1, 3, $id); // 1 for company, 3 for company approve
        return WPJOBPORTAL_APPROVED;
    }

    function approveQueueFeaturedCompanyModel($id) {
        if (is_numeric($id) == false)
            return false;
        $row = WPJOBPORTALincluder::getJSTable('company');
        if($row->load($id)){
            $row->columns['isfeaturedcompany'] = 1;
            $startfeatureddate = strtotime($row->startfeatureddate);
            $endfeatureddate = strtotime($row->endfeatureddate);
            $datediff = $endfeatureddate - $startfeatureddate;
            $diff_days = floor($datediff/(60*60*24));
            $row->columns['startfeatureddate'] = date('Y-m-d H:i:s');
            $row->columns['endfeatureddate'] = date('Y-m-d H:i:s',strtotime(" +$diff_days days"));
            if(!$row->store()){
                return WPJOBPORTAL_APPROVE_ERROR;
            }
        }else{
            return WPJOBPORTAL_APPROVE_ERROR;
        }
        //send email
        $company_queue_approve_email = WPJOBPORTALincluder::getJSModel('emailtemplate')->sendMail(1, 5, $id); // 1 for company, 5 for company featured approve
        return WPJOBPORTAL_APPROVED;
    }

    function rejectQueueCompanyModel($id) {
        if (is_numeric($id) == false)
            return false;
        $row = WPJOBPORTALincluder::getJSTable('company');
        if (!$row->update(array('id' => $id, 'status' => -1))) {
            return WPJOBPORTAL_REJECT_ERROR;
        }
        //send email
        $company_approve_email = WPJOBPORTALincluder::getJSModel('emailtemplate')->sendMail(1, 3, $id); // 1 for company, 3 for company reject
        return WPJOBPORTAL_REJECTED;
    }

    function rejectQueueFeatureCompanyModel($id) {
        if (is_numeric($id) == false)
            return false;
        $row = WPJOBPORTALincluder::getJSTable('company');
        if (!$row->update(array('id' => $id, 'isfeaturedcompany' => -1))) {
            return WPJOBPORTAL_REJECT_ERROR;
        }
        //send email
        $company_queue_approve_email = WPJOBPORTALincluder::getJSModel('emailtemplate')->sendMail(1, 5, $id); // 1 for company, 5 for company featured approve
        return WPJOBPORTAL_REJECTED;
    }


    function approveQueueAllCompaniesModel($id, $actionid) {
        /*
         * *  4 for All
         */
        if (!is_numeric($id))
            return false;

        $result = $this->approveQueueCompanyModel($id);
        return $result;
    }

    function rejectQueueAllCompaniesModel($id, $actionid) {
        /*
         * *  4 for All
         */
        if (!is_numeric($id))
            return false;

        $result = $this->rejectQueueCompanyModel($id);
        return $result;
    }

    function getCompaniesForCombo() {
        $query = "SELECT id, name AS text FROM `" . wpjobportal::$_db->prefix . "wj_portal_companies` WHERE status = 1 ORDER BY name ASC ";
        $rows = wpjobportaldb::get_results($query);
        return $rows;
    }

    function getUserCompaniesForCombo() {
        $uid = WPJOBPORTALincluder::getObjectClass('user')->uid();
        if(!is_numeric($uid)) return false;
        $query = "SELECT id, name AS text FROM `" . wpjobportal::$_db->prefix . "wj_portal_companies` WHERE uid = " . $uid . " AND status = 1 ORDER BY name ASC ";
        if(!wpjobportal::$_common->wpjp_isadmin()){
            if(!in_array('multicompany', wpjobportal::$_active_addons)){
                $query .= "LIMIT 1";
            }
        }
        $rows = wpjobportaldb::get_results($query);
        return $rows;
    }

    function getCompanynameById($id) {
        if (!is_numeric($id))
            return false;
        $query = "SELECT company.name FROM `" . wpjobportal::$_db->prefix . "wj_portal_companies` AS company WHERE company.id = " . $id;
        $companyname = wpjobportal::$_db->get_var($query);
        return $companyname;
    }

    function addViewContactDetail($companyid, $uid) {
        if (!is_numeric($companyid))
            return false;
        if (!is_numeric($uid))
            return false;

        $data = array();
        $data['uid'] = $uid;
        $data['companyid'] = $companyid;
        $data['status'] = 1;
        $data['created'] = $curdate;

        $row = WPJOBPORTALincluder::getJSTable('jobseekerviewcompany');
        if (!$row->bind($data)) {
            return false;
        }

        if ($row->store()) {
            return true;
        }else{
            return false;
        }
    }

    function canAddCompany($uid,$actionname='') {
        if (!is_numeric($uid))
            return false;
        if(in_array('credits', wpjobportal::$_active_addons)){
            $credits = apply_filters('wpjobportal_addons_userpackages_module_wise',false,$uid,$actionname);
            return $credits;
        }else{

            return $this->userCanAddCompany($uid);
        }

    }

    function employerHaveCompany($uid) {
        if (!is_numeric($uid))
            return false;
        $query = "SELECT COUNT(id) FROM `" . wpjobportal::$_db->prefix . "wj_portal_companies` WHERE uid = " . $uid;
        $result = wpjobportal::$_db->get_var($query);
        if ($result == 0) {
            return false;
        } else {
            return true;
        }
    }

    function makeCompanySeo($company_seo , $wpjobportalid){
        //Fareed
        if(empty($company_seo))
            return '';

        $common = wpjobportal::$_common;
        $id = $common->parseID($wpjobportalid);
        if(! is_numeric($id))
            return '';
        $result = '';
        $company_seo = wpjobportalphplib::wpJP_str_replace( ' ', '', $company_seo);
        $company_seo = wpjobportalphplib::wpJP_str_replace( '[', '', $company_seo);
        $array = wpjobportalphplib::wpJP_explode(']', $company_seo);

        $total = count($array);
        if($total > 3)
            $total = 3;

        for ($i=0; $i < $total; $i++) {
            $query = '';
            switch ($array[$i]) {
                case 'name':
                    $query = "SELECT name AS col FROM `" . wpjobportal::$_db->prefix . "wj_portal_companies` WHERE id = " . $id;
                break;
                case 'category':
                    $query = "SELECT category.cat_title AS col
                        FROM `" . wpjobportal::$_db->prefix . "wj_portal_companies` AS company
                        WHERE company.id = " . $id;
                break;
                case 'location':
                    $query = "SELECT company.city AS col
                        FROM `" . wpjobportal::$_db->prefix . "wj_portal_companies` AS company WHERE company.id = " . $id;
                break;
            }
            if($query){
                $data = wpjobportaldb::get_row($query);
                if(isset($data->col)){
                    if($array[$i] == 'location'){
                        $cityids = wpjobportalphplib::wpJP_explode(',', $data->col);
                        $location = '';
                        for ($j=0; $j < count($cityids); $j++) {
                            if(is_numeric($cityids[$j])){
                                $query = "SELECT name FROM `" . wpjobportal::$_db->prefix . "wj_portal_cities` WHERE id = ". $cityids[$j];
                                $cityname = wpjobportaldb::get_row($query);
                                if(isset($cityname->name)){
                                    if($location == '')
                                        $location .= $cityname->name;
                                    else
                                        $location .= ' '.$cityname->name;

                                }
                            }
                        }
                        $location = $common->removeSpecialCharacter($location);
                        if($location != ''){
                            if($result == '')
                                $result .= wpjobportalphplib::wpJP_str_replace(' ', '-', $location);
                            else
                                $result .= '-'.wpjobportalphplib::wpJP_str_replace(' ', '-', $location);
                        }
                    }else{
                        $val = $common->removeSpecialCharacter($data->col);
                        if($result == '')
                            $result .= wpjobportalphplib::wpJP_str_replace(' ', '-', $val);
                        else
                            $result .= '-'.wpjobportalphplib::wpJP_str_replace(' ', '-', $val);
                    }
                }
            }
        }
        return $result;
    }

    function getCompanyExpiryStatus($id) {
        if (!is_numeric($id))
            return false;
        $query = "SELECT company.id
        FROM `" . wpjobportal::$_db->prefix . "wj_portal_companies` AS company
        WHERE company.status = 1
        AND company.id =" . $id;
        $result = wpjobportal::$_db->get_var($query);
        if ($result == null) {
            return false;
        } else {
            return true;
        }
    }

    function getIfCompanyOwner($id) {
        if (!is_numeric($id))
            return false;
        $uid = WPJOBPORTALincluder::getObjectClass('user')->uid();
        $query = "SELECT company.id
        FROM `" . wpjobportal::$_db->prefix . "wj_portal_companies` AS company
        WHERE company.uid = " . $uid . "
        AND company.id =" . $id;
        $result = wpjobportal::$_db->get_var($query);
        if ($result == null) {
            return false;
        } else {
            return true;
        }
    }
    function getMessagekey(){
        $key = 'company';if(wpjobportal::$_common->wpjp_isadmin()){$key = 'admin_'.$key;}return $key;
    }


    function getOrdering() {
        $sort = WPJOBPORTALrequest::getVar('sortby', '', 'posteddesc');
        $this->getListOrdering($sort);
        $this->getListSorting($sort);
    }

    function getListOrdering($sort) {
        switch ($sort) {
            case "namedesc":
                wpjobportal::$_ordering = "company.name DESC";
                wpjobportal::$_sorton = "name";
                wpjobportal::$_sortorder = "DESC";
                break;
            case "nameasc":
                wpjobportal::$_ordering = "company.name ASC";
                wpjobportal::$_sorton = "name";
                wpjobportal::$_sortorder = "ASC";
                break;
            case "categorydesc":
                wpjobportal::$_ordering = "cat.cat_title DESC";
                wpjobportal::$_sorton = "category";
                wpjobportal::$_sortorder = "DESC";
                break;
            case "categoryasc":
                wpjobportal::$_ordering = "cat.cat_title ASC";
                wpjobportal::$_sorton = "category";
                wpjobportal::$_sortorder = "ASC";
                break;
            case "locationdesc":
                wpjobportal::$_ordering = "city.cityName DESC";
                wpjobportal::$_sorton = "location";
                wpjobportal::$_sortorder = "DESC";
                break;
            case "locationasc":
                wpjobportal::$_ordering = "city.cityName ASC";
                wpjobportal::$_sorton = "location";
                wpjobportal::$_sortorder = "ASC";
                break;
            case "posteddesc":
                wpjobportal::$_ordering = "company.created DESC";
                wpjobportal::$_sorton = "posted";
                wpjobportal::$_sortorder = "DESC";
                break;
            case "postedasc":
                wpjobportal::$_ordering = "company.created ASC";
                wpjobportal::$_sorton = "posted";
                wpjobportal::$_sortorder = "ASC";
                break;
            default: wpjobportal::$_ordering = "company.created DESC";
        }
        return;
    }

    function getSortArg($type, $sort) {
        $mat = array();
        if (wpjobportalphplib::wpJP_preg_match("/(\w+)(asc|desc)/i", $sort, $mat)) {
            if ($type == $mat[1]) {
                return ( $mat[2] == "asc" ) ? "{$type}desc" : "{$type}asc";
            } else {
                return $type . $mat[2];
            }
        }
        return "iddesc";
    }

    function getListSorting($sort) {
        wpjobportal::$_sortlinks['name'] = $this->getSortArg("name", $sort);
        wpjobportal::$_sortlinks['category'] = $this->getSortArg("category", $sort);
        wpjobportal::$_sortlinks['location'] = $this->getSortArg("location", $sort);
        wpjobportal::$_sortlinks['posted'] = $this->getSortArg("posted", $sort);
        return;
    }

    function validateUserCompany($companyid,$uid){
        if(!is_numeric($companyid) || !is_numeric($uid)){
            return false;
        }
        $query = "SELECT id FROM `".wpjobportal::$_db->prefix."wj_portal_companies` WHERE uid = ".$uid." AND id = ".$companyid;
        $result = wpjobportal::$_db->get_var($query);
        if($result){
            return true;
        }
        return false;
    }

    function getSingleCompanyByUid($uid){
        if(!is_numeric($uid)){
            return false;
        }
        $query = "SELECT * FROM `" . wpjobportal::$_db->prefix . "wj_portal_companies` WHERE uid =" . $uid." AND status =1 LIMIT 1";
        $company = wpjobportaldb::get_row($query);
        if($company){
            $company->location = WPJOBPORTALincluder::getJSModel('city')->getLocationDataForView($company->city);
        }
        return $company;
    }

    function userCanAddCompany($uid){
        # Check Whether Not More than one
        if(!is_numeric($uid)){
            return false;
        }
        $query = "SELECT COUNT(id) FROM `" . wpjobportal::$_db->prefix . "wj_portal_companies` WHERE uid =" . $uid;
        $company = wpjobportaldb::get_var($query);
        if($company > 0){
            return false;
        }
        return true;
    }

    function getLogoUrl($companyid,$logofilename){
        $logourl = WPJOBPORTAL_PLUGIN_URL.'/includes/images/default_logo.png';
        if(is_numeric($companyid) && !empty($logofilename)){
            $wpdir = wp_upload_dir();
            $dir = wpjobportal::$_config->getConfigValue('data_directory');
            $logourl = $wpdir['baseurl'].'/'.$dir.'/data/employer/comp_'.$companyid.'/logo/'.$logofilename;
        }
        return $logourl;
    }

     function getCompanyDataFromJobForm($jobformdata){
        $companydata = array();
        if(is_array($jobformdata)){
            $companycustomfields = array();
            foreach(wpjobportal::$_wpjpfieldordering->getUserfieldsfor(WPJOBPORTAL_COMPANY) as $field){
                $companycustomfields[] = $field->field;
            }
            foreach($jobformdata as $name => $value){
                if(wpjobportalphplib::wpJP_stristr($name, 'company_')){
                    $companydata[wpjobportalphplib::wpJP_str_replace('company_', '', $name)] = $value;
                }elseif(in_array($name, $companycustomfields)){
                    $companydata[$name] = $value;
                }
            }
        }
        return $companydata;
    }

    // front end coookies search form data
    function getSearchFormDataMyCompany(){
        $jsjp_search_array = array();
        $jsjp_search_array['searchcompany'] = WPJOBPORTALrequest::getVar('searchcompany');
        $jsjp_search_array['wpjobportal-city'] = WPJOBPORTALrequest::getVar('wpjobportal-city');
        $jsjp_search_array['search_from_myapply_mycompanies'] = 1;
        return $jsjp_search_array;
    }

    function getCookiesSavedMyCompany(){
        $jsjp_search_array = array();
        $wpjp_search_cookie_data = '';
        if(isset($_COOKIE['jsjp_jobportal_search_data'])){
            $wpjp_search_cookie_data = wpjobportal::sanitizeData($_COOKIE['jsjp_jobportal_search_data']);
            $wpjp_search_cookie_data = wpjobportalphplib::wpJP_safe_decoding($wpjp_search_cookie_data);
            $wpjp_search_cookie_data = json_decode( $wpjp_search_cookie_data , true );
        }
        if($wpjp_search_cookie_data != '' && isset($wpjp_search_cookie_data['search_from_myapply_mycompanies']) && $wpjp_search_cookie_data['search_from_myapply_mycompanies'] == 1){
            $jsjp_search_array['searchcompany'] = $wpjp_search_cookie_data['searchcompany'];
            $jsjp_search_array['wpjobportal-city'] = $wpjp_search_cookie_data['wpjobportal-city'];
        }
        return $jsjp_search_array;
    }

    function setSearchVariableMyCompany($jsjp_search_array){
        wpjobportal::$_search['mycompany']['searchcompany'] = isset($jsjp_search_array['searchcompany']) ? $jsjp_search_array['searchcompany'] : null;
        wpjobportal::$_search['mycompany']['wpjobportal-city'] = isset($jsjp_search_array['wpjobportal-city']) ? $jsjp_search_array['wpjobportal-city'] : null;
    }

    // Admin search cookies form data
    function getSearchFormAdminCompanyData(){
        $jsjp_search_array = array();
        $jsjp_search_array['sorton'] = WPJOBPORTALrequest::getVar('sorton', 'post', 3);
        $jsjp_search_array['sortby'] = WPJOBPORTALrequest::getVar('sortby', 'post', 2);
        //Filters
        $jsjp_search_array['searchcompany'] = WPJOBPORTALrequest::getVar('searchcompany');
        $jsjp_search_array['searchjobcategory'] = WPJOBPORTALrequest::getVar('searchjobcategory');
        $jsjp_search_array['status'] = WPJOBPORTALrequest::getVar('status');
        $jsjp_search_array['datestart'] = WPJOBPORTALrequest::getVar('datestart');
        $jsjp_search_array['dateend'] = WPJOBPORTALrequest::getVar('dateend');
         $jsjp_search_array['featured'] = WPJOBPORTALrequest::getVar('featured');
        //Front end search var
        $wpjobportal_company = WPJOBPORTALrequest::getVar('wpjobportal-company');
        $jsjp_search_array['wpjobportal_company'] = wpjobportal::parseSpaces($wpjobportal_company);
        $jsjp_search_array['wpjobportal_city'] = WPJOBPORTALrequest::getVar('wpjobportal-city');
        $jsjp_search_array['search_from_admin_company'] = 1;
        return $jsjp_search_array;
    }

    function getAdminCompanySavedCookies(){
        $jsjp_search_array = array();
        $wpjp_search_cookie_data = '';
        if(isset($_COOKIE['jsjp_jobportal_search_data'])){
            $wpjp_search_cookie_data = wpjobportal::sanitizeData($_COOKIE['jsjp_jobportal_search_data']);
            $wpjp_search_cookie_data = wpjobportalphplib::wpJP_safe_decoding($wpjp_search_cookie_data);
            $wpjp_search_cookie_data = json_decode( $wpjp_search_cookie_data , true );
        }
        if($wpjp_search_cookie_data != '' && isset($wpjp_search_cookie_data['search_from_admin_company']) && $wpjp_search_cookie_data['search_from_admin_company'] == 1){
            $jsjp_search_array['sorton'] = $wpjp_search_cookie_data['sorton'];
            $jsjp_search_array['sortby'] = $wpjp_search_cookie_data['sortby'];
            $jsjp_search_array['searchcompany'] = $wpjp_search_cookie_data['searchcompany'];
            $jsjp_search_array['searchjobcategory'] = $wpjp_search_cookie_data['searchjobcategory'];
            $jsjp_search_array['status'] = $wpjp_search_cookie_data['status'];
            $jsjp_search_array['datestart'] = $wpjp_search_cookie_data['datestart'];
            $jsjp_search_array['dateend'] = $wpjp_search_cookie_data['dateend'];
            $jsjp_search_array['featured'] = $wpjp_search_cookie_data['featured'];
            $jsjp_search_array['wpjobportal_company'] = $wpjp_search_cookie_data['wpjobportal_company'];
            $jsjp_search_array['wpjobportal_company'] = $wpjp_search_cookie_data['wpjobportal_company'];
            $jsjp_search_array['wpjobportal_city'] = $wpjp_search_cookie_data['wpjobportal_city'];
        }
        return $jsjp_search_array;
    }

    function setAdminCompanySearchVariable($jsjp_search_array){
        wpjobportal::$_search['company']['sorton'] = isset($jsjp_search_array['sorton']) ? $jsjp_search_array['sorton'] : 3;
        wpjobportal::$_search['company']['sortby'] = isset($jsjp_search_array['sortby']) ? $jsjp_search_array['sortby'] : 2;
        wpjobportal::$_search['company']['searchcompany'] = isset($jsjp_search_array['searchcompany']) ? $jsjp_search_array['searchcompany'] : '';
        wpjobportal::$_search['company']['searchjobcategory'] = isset($jsjp_search_array['searchjobcategory']) ? $jsjp_search_array['searchjobcategory'] : '';
        wpjobportal::$_search['company']['status'] = isset($jsjp_search_array['status']) ? $jsjp_search_array['status'] : '';
        wpjobportal::$_search['company']['datestart'] = isset($jsjp_search_array['datestart']) ? $jsjp_search_array['datestart'] : '';
        wpjobportal::$_search['company']['dateend'] = isset($jsjp_search_array['dateend']) ? $jsjp_search_array['dateend'] : '';
        wpjobportal::$_search['company']['featured'] = isset($jsjp_search_array['featured']) ? $jsjp_search_array['featured'] : '';
        wpjobportal::$_search['company']['wpjobportal_company'] = isset($jsjp_search_array['wpjobportal_company']) ? $jsjp_search_array['wpjobportal_company'] : '';
        wpjobportal::$_search['company']['wpjobportal_city'] = isset($jsjp_search_array['wpjobportal_city']) ? $jsjp_search_array['wpjobportal_city'] : '';
    }
}
?>
