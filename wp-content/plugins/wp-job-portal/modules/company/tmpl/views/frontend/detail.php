<?php
/**
* @param wp job portal 
* Company => Detail via Template 
* redirection's 
*/
$dateformat = wpjobportal::$_configuration['date_format'];

/**
* @param wp job portal
* # company list 
* generic module for cases
*/
 if(in_array('multicompany', wpjobportal::$_active_addons)){
    $mod = "multicompany";
}else{
    $mod = "company";
} 
?>
<?php
switch ($layout) {
    case 'companydetail':
        ?>
        <div class="wjportal-company-data-wrp">
            <?php if (wpjobportal::$_data['companycontactdetail'] == true){?>
                <div class="wjportal-company-sec-title">
                    <?php echo __('Company Info','wp-job-portal'); ?>
                </div>
            <?php } 
                $dateformat = wpjobportal::$_configuration['date_format'];
                foreach (wpjobportal::$_data[2] AS $key => $val) {
                    switch ($key) {
                        case 'contactemail':
                            if (wpjobportal::$_data['companycontactdetail'] == true)
                                if ($config_array['comp_email_address'] == 1)
                                    if(isset( wpjobportal::$_data[0]) && !empty( wpjobportal::$_data[0]->contactemail)){
                                        echo wp_kses(getDataRow(__($val, 'wp-job-portal'), wpjobportal::$_data[0]->contactemail), WPJOBPORTAL_ALLOWED_TAGS);
                                    }
                                    
                            break;
                        case 'address1':
                            if (wpjobportal::$_data['companycontactdetail'] == true)
                                if(isset( wpjobportal::$_data[0]) && !empty( wpjobportal::$_data[0]->address1)){
                                    echo wp_kses(getDataRow(__($val, 'wp-job-portal'), wpjobportal::$_data[0]->address1), WPJOBPORTAL_ALLOWED_TAGS);
                                }
                            break;
                        case 'address2':
                            if (wpjobportal::$_data['companycontactdetail'] == true)
                                if(isset( wpjobportal::$_data[0]) && !empty( wpjobportal::$_data[0]->address2)){
                                    echo wp_kses(getDataRow(__($val, 'wp-job-portal'), wpjobportal::$_data[0]->address2), WPJOBPORTAL_ALLOWED_TAGS);
                                }
                            break;
                        default: // handle the user fields data
                            $customfields = WPJOBPORTALincluder::getObjectClass('customfields')->userFieldsData(1);
                                foreach($customfields AS $field){
                                    if($key == $field->field){
                                        $showCustom =  wpjobportal::$_wpjpcustomfield->showCustomFields($field,5,wpjobportal::$_data[0]->params);
                                        echo wp_kses($showCustom, WPJOBPORTAL_ALLOWED_TAGS);
                                    }
                                }
                           
                        break;
                    }
                }
            ?>
        </div>
        <?php 
        $config_array = wpjobportal::$_data['config'];
        if( $config_array['comp_description'] == 1){
        ?>
            <div class="wjportal-company-data-wrp">
                <div class="wjportal-company-sec-title">
                    <?php echo __('Description','wp-job-portal'); ?>
                </div>
                <div class="wjportal-company-desc">
                    <?php echo wp_kses(wpjobportal::$_data[0]->description, WPJOBPORTAL_ALLOWED_TAGS); ?>
                </div>
            </div>
        <?php } ?>
        <?php
            do_action('wpjobportal_addons_company_contact_detail',wpjobportal::$_data[0],wpjobportal::$_data['companycontactdetail']);
        break;
    case 'detail':
     $config_array = wpjobportal::$_data['config']; ?>
        <div class="wjportal-company-cnt-wrp">
            <div class="wjportal-company-middle-wrp">
                <?php if( $config_array['comp_show_url'] == 1): ?>
                        <div class="wjportal-company-data">
                            <span class="wjportal-companyname">
                                <?php echo esc_html($company->url); ?>
                            </span>
                        </div> 
                <?php endif; ?>
                <div class="wjportal-company-data"> 
                    <?php if (wpjobportal::$_config->getConfigValue('comp_name')) { ?>
                        <span class="wjportal-company-title">
                            <a href="<?php echo esc_url(wpjobportal::makeUrl(array('wpjobportalme'=>$mod, 'wpjobportallt'=>'viewcompany', 'wpjobportalid'=>$company->aliasid))); ?>">
                                <?php echo esc_html($company->name); ?>
                            </a>
                        </span>
                        <?php }
                        if(WPJOBPORTALincluder::getObjectClass('user')->isemployer()){
                            do_action('wpjobportal_addons_lable_comp_feature',$company);
                        }
                    ?>
                </div>
                <div class="wjportal-company-data">
                    <?php if(!isset($showcreated) || $showcreated): ?>
                        <div class="wjportal-company-data-text">
                            <span class="wjportal-company-data-title">
                                <?php echo __('Created', 'wp-job-portal') . ':'; ?>
                            </span>
                            <span class="wjportal-company-data-value">
                                <?php echo esc_html(human_time_diff(strtotime($company->created))).' '.__("Ago",'wp-job-portal'); ?>
                            </span>
                        </div>
                    <?php endif; ?>

                    <?php if(WPJOBPORTALincluder::getObjectClass('user')->isjobseeker()){ ?>
                    <div class="wjportal-company-data-text">
                        <span class="wjportal-company-data-title">
                            <?php echo __('Status', 'wp-job-portal') . ':'; ?>
                        </span>
                        <?php
                            $color = ($company->status == 1) ? "green" : "red";
                            if ($company->status == 1) {
                                $statusCheck = __('Approved', 'wp-job-portal');
                            } elseif ($company->status == 0) {
                                $statusCheck = __('Waiting for approval', 'wp-job-portal');
                            }elseif($company->status == 2){
                                 $statusCheck = __('Pending For Approval of Payment', 'wp-job-portal');
                            }elseif ($company->status == 3) {
                                $statusCheck = __('Pending Due To Payment', 'wp-job-portal');
                            }else {
                                $statusCheck = __('Rejected', 'wp-job-portal');
                            }
                        ?>
                        <span class="wjportal-company-data-value <?php echo esc_attr($color); ?>">
                            <?php echo esc_html($statusCheck); ?>
                        </span>
                    </div>
                    <?php } ?>
                <?php if(isset($company) && !empty($company->location) && $config_array['comp_city'] == 1): ?>
                    <div class="wjportal-company-data-text">
                        <span class="wjportal-company-data-title">
                            <?php echo __('Location', 'wp-job-portal') . ':'; ?>
                        </span>
                        <span class="wjportal-company-data-value">
                            <?php echo esc_html($company->location); ?>
                        </span>
                    </div>
                <?php endif; ?>
                </div>
                <!-- custom fields -->
                <div class="wjportal-custom-field-wrp">
                    <?php
                        $customfields = WPJOBPORTALincluder::getObjectClass('customfields')->userFieldsData(1,1);
                            foreach ($customfields as $field) {
                                $showCustom =  wpjobportal::$_wpjpcustomfield->showCustomFields($field,8,$company->params);
                                echo wp_kses($showCustom, WPJOBPORTAL_ALLOWED_TAGS);
                            }
                    ?>
                </div>
            </div>
            <div class="wjportal-company-right-wrp">
                <div class="wjportal-company-action">
                    <a class="wjportal-company-act-btn" href="<?php echo esc_url(wpjobportal::makeUrl(array('wpjobportalme'=>$mod, 'wpjobportallt'=>'viewcompany', 'wpjobportalid'=>$company->aliasid))); ?>" title="<?php echo __('View company','wp-job-portal'); ?>">
                        <?php echo __('View Company','wp-job-portal'); ?>
                    </a>
                </div>
            </div>
        </div>
        <?php
    break;
   }
