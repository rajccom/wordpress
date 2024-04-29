<?php
/**
 * @param job      job object - optional
*/
?>
<?php
foreach ($layout as $key => $value) {
    switch ($value) {
        case 'mycompanies':
        if(in_array('multicompany', wpjobportal::$_active_addons)){
            do_action('wpjobportal_addons_mystuff_dashboard_employer_upper_mycomp','mycompanies');
        }else{
            $print = employerchecklinks($value);
            if ($print) {
            echo'<div class="wjportal-cp-list">
                    <a class="wjportal-list-anchor" href='.esc_url(wpjobportal::makeUrl(array('wpjobportalme'=>'company', 'wpjobportallt'=>$value))).' title='.__('My companies','wp-job-portal').'>
                            <img class="js-img" src='. WPJOBPORTAL_PLUGIN_URL.'includes/images/control_panel/employer/companies.png alt='.__("My companies","wp-job-portal").'>
                            <span class="wjportal-cp-link-text">'. __('My Companies', 'wp-job-portal').'</span>
                    </a>
                </div>';
            }
        }
        break;
        case 'formcompany':
            if(in_array('multicompany', wpjobportal::$_active_addons)){
                $print = employerchecklinks($value);
                do_action('wpjobportal_addons_mystuff_employer_dashboard_addcomp',$print);
            }else{
                $print = employerchecklinks($value);
                if ($print) {
                    $company = isset(wpjobportal::$_data[0]['companies']) ? wpjobportal::$_data[0]['companies'] : '';
                    if(isset($company) && !empty($company)){
                        $desc = $company[0]->record > 0 ? 'Edit Company' : 'Add Company';
                        echo '<div class="wjportal-cp-list">
                                <a class="wjportal-list-anchor" href='. esc_url(wpjobportal::makeUrl(array('wpjobportalme'=>'company', 'wpjobportallt'=>'addcompany','wpjobportalid'=>$company[0]->id))) .' title="'.__('Edit company','wp-job-portal').'">
                                    <img src='. WPJOBPORTAL_PLUGIN_URL .'includes/images/control_panel/employer/add-company.png>
                                    <span class="wjportal-cp-link-text">'.esc_html(__($desc,'wp-job-portal')).'</span>
                                </a>
                            </div>';
                    }else{
                        echo '<div class="wjportal-cp-list">
                                <a class="wjportal-list-anchor" href='. esc_url(wpjobportal::makeUrl(array('wpjobportalme'=>'company', 'wpjobportallt'=>'addcompany'))) .' title="'.__('Edit company','wp-job-portal').'">
                                    <img src='. WPJOBPORTAL_PLUGIN_URL .'includes/images/control_panel/employer/add-company.png>
                                    <span class="wjportal-cp-link-text">'.__('Add Company','wp-job-portal').'</span>
                                </a>
                            </div>';
                    }
                }
            }
            break;
        case 'empmessages':
           do_action('wpjobportal_addons_mystuff_employer_dashboard_msg',$print);
        break;
        case 'myjobs':
            $print = employerchecklinks('myjobs');
                if ($print) {
                    ?>
                    <div class="wjportal-cp-list">
                        <a class="wjportal-list-anchor" href="<?php echo esc_url(wpjobportal::makeUrl(array('wpjobportalme'=>'job', 'wpjobportallt'=>'myjobs'))); ?>" title="<?php echo __('My jobs', 'wp-job-portal'); ?>">
                            <img src="<?php echo WPJOBPORTAL_PLUGIN_URL; ?>includes/images/control_panel/employer/my-job.png" alt="<?php echo __('My jobs', 'wp-job-portal'); ?>">
                            <span class="wjportal-cp-link-text"><?php echo __('My Jobs', 'wp-job-portal'); ?></span>
                        </a>
                    </div>
                    <?php
                }
        break;
        case 'formjob':
            $print = employerchecklinks('formjob');
                if ($print) {
                    ?>
                    <div class="wjportal-cp-list">
                        <a class="wjportal-list-anchor" href="<?php echo esc_url(wpjobportal::makeUrl(array('wpjobportalme'=>'job', 'wpjobportallt'=>'addjob'))); ?>" title="<?php echo __('Add job', 'wp-job-portal'); ?>">
                            <img src="<?php echo WPJOBPORTAL_PLUGIN_URL; ?>includes/images/control_panel/employer/add-job.png" alt="<?php echo __('Add job', 'wp-job-portal'); ?>">
                            <span class="wjportal-cp-link-text"><?php echo __('Add Job', 'wp-job-portal'); ?></span>
                        </a>
                    </div>
                <?php
                }
        break;
        case 'invoice':
            do_action('wpjobportal_addons_credit_cp_leftmenue_employeer');
        break;
        case 'formdepartment':
            do_action('wpjobportal_addons_mystuff_employer_dashboard_side_menue_dept');
        break;
        case 'resumesearch':
            if(in_array('resumesearch', wpjobportal::$_active_addons)){
                $print = employerchecklinks('resumesearch');
                if ($print) { ?>
                    <div class="wjportal-cp-list">
                        <?php
                            do_action('wpjobportal_addons_mystuff_dashboard_employer_upper',$print);
                        ?>
                    </div>
                <?php
                }
            }
        break;
        case 'empresume_rss':
            $print = employerchecklinks('empresume_rss');
            if(in_array('rssfeedback', wpjobportal::$_active_addons)){
                do_action('wpjobportal_addons_mystuff_employer_dashboard_side_menue',$print);
            }
        break;
        case 'newfolders':
           do_action('wpjobportal_addons_mystuff_employer_dashboard');
        break;
        case 'emresumebycategory':
            $print = employerchecklinks('emresumebycategory');
                if ($print) {
                    ?>
                    <div class="wjportal-cp-list">
                        <a class="wjportal-list-anchor" href="<?php echo esc_url(wpjobportal::makeUrl(array('wpjobportalme'=>'resume', 'wpjobportallt'=>'resumebycategory'))); ?>" title="<?php echo __('Resume by categories', 'wp-job-portal'); ?>">
                            <img src="<?php echo WPJOBPORTAL_PLUGIN_URL; ?>includes/images/control_panel/employer/resume-categories.png">
                            <span class="wjportal-cp-link-text"><?php echo __('Resume By Categories', 'wp-job-portal'); ?></span>
                        </a>
                    </div>
                <?php }
        break;
        case 'my_resumesearches':
           do_action('wpjobportal_addons_mystuff_dashboard_employer_search');
        break;
        case 'emploginlogout':
            if (employerchecklinks('emploginlogout')) {
                if (WPJOBPORTALincluder::getObjectClass('user')->isguest() && (!isset($_SESSION['wpjobportal-socialmedia']) && empty($_SESSION['wpjobportal-socialmedia']))) {
                    ?>
                    <div class="wjportal-cp-list">
                        <?php
                            $thiscpurl = wpjobportal::makeUrl(array('wpjobportalme'=>'employer', 'wpjobportallt'=>'controlpanel'));
                            $thiscpurl = wpjobportalphplib::wpJP_safe_encoding($thiscpurl);
                            $defaultUrl = wpjobportal::makeUrl(array('wpjobportalme'=>'wpjobportal', 'wpjobportallt'=>'login', 'wpjobportalredirecturl'=>$thiscpurl));
                            $lrlink = WPJOBPORTALincluder::getJSModel('configuration')->getLoginRegisterRedirectLink($defaultUrl,'login');
                        ?>
                        <a class="wjportal-list-anchor" href="<?php echo esc_url($lrlink);?>" title="<?php echo __('Login', 'wp-job-portal'); ?>">
                            <img src="<?php echo WPJOBPORTAL_PLUGIN_URL; ?>includes/images/control_panel/jobseeker/login.png" alt="<?php echo __('Login', 'wp-job-portal'); ?>">
                            <span class="wjportal-cp-link-text"><?php echo __('Login', 'wp-job-portal'); ?></span>
                        </a>
                    </div>
                    <?php
                } else {
                    if(isset($_COOKIE['wpjobportal-socialmedia']) && !empty($_COOKIE['wpjobportal-socialmedia'])){
                        do_action('wpjobportal_addons_social_logout');
                    } else{
                        ?>
                    <div class="wjportal-cp-list">
                            <a class="wjportal-list-anchor" href="<?php echo wp_logout_url(get_permalink()); ?>" title="<?php echo __('Logout', 'wp-job-portal'); ?>">
                                <img src="<?php echo WPJOBPORTAL_PLUGIN_URL; ?>includes/images/control_panel/employer/logout.png" alt="<?php echo __('Logout', 'wp-job-portal'); ?>">
                                <span class="wjportal-cp-link-text"><?php echo __('Logout', 'wp-job-portal'); ?></span>
                            </a>
                        </div>
                <?php
                }
            }
        }
        break;
        case 'emresumebycategory':
           $print = employerchecklinks('emresumebycategory');
                if ($print) {
                    ?>
                    <div class="wjportal-cp-list">
                        <a class="wjportal-list-anchor" href="<?php echo esc_url(wpjobportal::makeUrl(array('wpjobportalme'=>'resume', 'wpjobportallt'=>'resumebycategory'))); ?>" title="<?php echo __('Resumes by categories', 'wp-job-portal'); ?>">
                            <img src="<?php echo WPJOBPORTAL_PLUGIN_URL; ?>includes/images/control_panel/employer/resume-by-categories.png" alt="<?php echo __('Resumes by categories', 'wp-job-portal'); ?>">
                            <span class="wjportal-cp-link-text"><?php echo __('Resumes By Categories', 'wp-job-portal'); ?></span>
                        </a>
                    </div>
                <?php }
        break;
        case 'empregister':
            if(WPJOBPORTALincluder::getObjectClass('user')->isguest()){
                $print = employerchecklinks('empregister');
                    if ($print) {
                        $defaultUrl = wpjobportal::makeUrl(array('wpjobportalme'=>'user', 'wpjobportallt'=>'regemployer'));
                        $lrlink = WPJOBPORTALincluder::getJSModel('configuration')->getLoginRegisterRedirectLink($defaultUrl,'register');
                        ?>
                        <div class="wjportal-cp-list">
                            <a class="wjportal-list-anchor" href="<?php echo esc_url($lrlink); ?>" title="<?php echo __('Register', 'wp-job-portal'); ?>">
                                <img src="<?php echo WPJOBPORTAL_PLUGIN_URL; ?>includes/images/control_panel/jobseeker/registers.png" alt="<?php echo __('Register', 'wp-job-portal'); ?>">
                                <span class="wjportal-cp-link-text"><?php echo __('Register', 'wp-job-portal'); ?></span>
                            </a>
                        </div>
                        <?php
                    }
            }
        break;
    }
}
