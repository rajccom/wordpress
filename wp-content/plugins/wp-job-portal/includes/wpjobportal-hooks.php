<?php
if (!defined('ABSPATH'))
    die('Restricted Access');


// Updates login failed to send user back to the custom form with a query var
add_action( 'wp_login_failed', 'wpjobportal_login_failed', 10, 2 );
// Updates authentication to return an error when one field or both are blank
add_filter( 'authenticate', 'wpjobportal_authenticate_username_password', 30, 3);

function wpjobportal_login_failed( $username ){
    $referrer = wp_get_referer();
    if ( $referrer && ! wpjobportalphplib::wpJP_strstr($referrer, 'wp-login') && ! wpjobportalphplib::wpJP_strstr($referrer, 'wp-admin') ){
        if (isset($_POST['wp-submit'])){
            $key = WPJOBPORTALincluder::getJSModel('user')->getMessagekey();
            WPJOBPORTALMessages::setLayoutMessage(__('Username / password is incorrect',"wp-job-portal"), 'error',$key);
            $referrer=wpjobportal::makeUrl(array('wpjobportalpageid'=>wpjobportal::getPageid(),'wpjobportalme'=>'wpjobportal','wpjobportallt'=>'login'));
            wp_redirect($referrer);
            exit;
        }else{
            return;
        }
    }
}

/**
* Commit For Zub
**/
function wpjobportal_authenticate_username_password( $user, $username, $password ){
    if ( is_a($user, 'WP_User') ) {
        return $user;
    }
    if (isset($_POST['wp-submit']) && (empty($_POST['pwd']) || empty($_POST['log']))){
        return false;
    }
    return $user;
}



add_action('admin_head', 'wpjobportal_custom_css_add');

function wpjobportal_custom_css_add() {
    echo wp_enqueue_style('wpjobportal-menu-style', WPJOBPORTAL_PLUGIN_URL . 'includes/css/adminmenu.css');
}

// --------------------------WP registration from fields --------
// 1. wp register form extra field
add_action('register_form', 'wpjobportal_add_registration_fields');

function wpjobportal_add_registration_fields() {
    //Get and set any values already sent
    if (isset($_SESSION['js_cpfrom'])) {
        ?>
        <div class="wjportal-form-title"><?php echo __('User role'); ?></div>
        <div class="wjportal-form-value">
            <div class="wjportal-form-text">
                <?php if ($_SESSION['js_cpfrom'] == 1) { ?>
                    <input type="hidden" name="jobs_role" value="1" />
                    <?php echo __('Employer', 'wp-job-portal'); ?>
                    <?php
                } elseif ($_SESSION['js_cpfrom'] == 2) {
                    ?>
                    <input type="hidden" name="jobs_role" value="2" />
                     <?php echo __('Job seeker', 'wp-job-portal'); ?>
               <?php } ?>
            </div>
        </div>
    <?php
    } else {
        ?>

            <div class="wjportal-form-title">
                <label for="jobs_role">
                    <?php _e('Jobs role', 'wp-job-portal') ?>
                </label>
            </div>
            <div class="wjportal-form-value">
                <select id="jobs_role" name="jobs_role" class="input form-control wjportal-form-select-field">
                    <option value="0"><?php echo __('Select job role', 'wp-job-portal'); ?></option>
                    <option value="1"><?php echo __('Employer', 'wp-job-portal'); ?></option>
                    <option value="2"><?php echo __('Job seeker', 'wp-job-portal'); ?></option>
                </select>
            </div>
            <input type="hidden" name="jobs_notfromourform" value="1" />

        <?php
    }
    if(isset($_SESSION['js_cpfrom']))
        unset($_SESSION['js_cpfrom']);
}

//2. Add validation. In this case, we make sure jobs_role is required
add_filter('registration_errors', 'wpjobportal_registration_errors', 10, 3);

function wpjobportal_registration_errors($errors, $sanitized_user_login, $user_email) {

    if (isset($_POST['jobs_role']) && $_POST['jobs_role'] == 0) {

        $errors->add('user_role_error','<strong>'.__("Error","wp-job-portal").'</strong>:'. __('You must set jobs user role', 'wp-job-portal').'.');
    }

    return $errors;
}

// 3. wp register form extra field get and set to user meta
add_action('user_register', 'wpjobportal_registration_save', 10, 1);

function wpjobportal_registration_save($user_id) {
    //if (isset($_POST['jobs_role'])) {
    if (isset($_POST['jobs_role']) && !isset($_POST['wpjobportal_jobs_register_nonce']) && !wp_verify_nonce($_POST['wpjobportal_jobs_register_nonce'], 'wpjobportal-jobs-register-nonce') ) {
        $role = wpjobportal::sanitizeData($_POST['jobs_role']);
        $user_email = sanitize_email($_POST['wpjobportal_user_email']);
        if (is_numeric($role)) {
            if ($role == 1) {
                update_user_meta($user_id, 'jobs_role', 'employer');
                $employer_defaultgroup = wpjobportal::$_config->getConfigurationByConfigName('employer_defaultgroup');
                wp_update_user(array('ID' => $user_id, 'role' => $employer_defaultgroup));
            } elseif ($role == 2) {
                update_user_meta($user_id, 'jobs_role', 'jobseeker');
                $jobseeker_defaultgroup = wpjobportal::$_config->getConfigurationByConfigName('jobseeker_defaultgroup');
                wp_update_user(array('ID' => $user_id, 'role' => $jobseeker_defaultgroup));
            }

            if (isset($_POST['jobs_notfromourform']) AND $_POST['jobs_notfromourform'] == 1) {
                $nickname = get_user_meta($user_id, 'nickname', true);

                $row = WPJOBPORTALincluder::getJSTable('users');
                $data['uid'] = $user_id;
                $data['roleid'] = $role;
                $data['first_name'] = $nickname;
                $data['emailaddress'] = $user_email;
                $data['status'] = 1;
                $data['created'] = date_i18n('Y-m-d H:i:s');

                if (!$row->bind($data)) {
                    echo WPJOBPORTAL_SAVE_ERROR;
                }
                if (!$row->store()) {
                    echo WPJOBPORTAL_SAVE_ERROR;
                }
                WPJOBPORTALincluder::getJSModel('emailtemplate')->sendMail(6,$role,$row->id); // 6 for regesitration $role for role jobseeker and employer
            }
        }
    }
}

// ------------------- wpjobportal registrationFrom request handler--------
// register a new user
function wpjobportal_add_new_member() {
    if (isset($_POST["wpjobportal_user_login"]) && isset($_POST['wpjobportal_jobs_register_nonce']) && wp_verify_nonce($_POST['wpjobportal_jobs_register_nonce'], 'wpjobportal-jobs-register-nonce')) {
        $user_login = sanitize_user($_POST["wpjobportal_user_login"]);
        $user_email = sanitize_email($_POST['wpjobportal_user_email']);
        $user_first = sanitize_text_field($_POST["wpjobportal_user_first"]);
        $user_last = sanitize_text_field($_POST["wpjobportal_user_last"]);
        $user_pass = wpjobportal::sanitizeData($_POST["wpjobportal_user_pass"] );
        $photo = sanitize_file_name($_FILES['photo']['name']);
        $pass_confirm = wpjobportal::sanitizeData($_POST["wpjobportal_user_pass_confirm"] );

        // this is required for username checks
        // require_once(ABSPATH . WPINC . '/registration.php');
        $fieldslist = wpjobportal::$_wpjpfieldordering->getFieldsOrderingforForm(4);
        if ($user_login == '' && $fieldslist['wpjobportal_user_login']->required == 1) {
            // empty username
            wpjobportal_errors()->add('username_empty', __('Please enter a '.$fieldslist['wpjobportal_user_login']->fieldtitle, 'wp-job-portal'));
        } elseif ($user_login == '' && $fieldslist['wpjobportal_user_login']->required == 0) {
            $user_login = $user_email;
        }
        if (username_exists($user_login)) {
            // Username already registered
            wpjobportal_errors()->add('username_unavailable', __($fieldslist['wpjobportal_user_login']->fieldtitle.' already taken', 'wp-job-portal'));
        }
        if (!validate_username($user_login)) {
            // invalid username
            wpjobportal_errors()->add('username_invalid', __('Invalid '.$fieldslist['wpjobportal_user_login']->fieldtitle, 'wp-job-portal'));
        }

        if ($user_first == ''  && $fieldslist['wpjobportal_user_first']->required == 1) {
            // empty first name
            wpjobportal_errors()->add('firstname_empty', __('Please enter a '.$fieldslist['wpjobportal_user_first']->fieldtitle, 'wp-job-portal'));
        }

        if ($user_last == ''  && $fieldslist['wpjobportal_user_last']->required == 1) {
            // empty last name
            wpjobportal_errors()->add('lastname_empty', __('Please enter a '.$fieldslist['wpjobportal_user_last']->fieldtitle, 'wp-job-portal'));
        }
        if ($photo == ''  && $fieldslist['photo']->required == 1) {
            // empty last name
            wpjobportal_errors()->add('photo_empty', __('Please enter a '.$fieldslist['photo']->fieldtitle, 'wp-job-portal'));
        }
        if (!is_email($user_email)) {
            //invalid email
            wpjobportal_errors()->add('email_invalid', __('Invalid '.$fieldslist['wpjobportal_user_email']->fieldtitle, 'wp-job-portal'));
        }
        if (email_exists($user_email)) {
            //Email address already registered
            wpjobportal_errors()->add('email_used', __($fieldslist['wpjobportal_user_email']->fieldtitle.' already registered', 'wp-job-portal'));
        }
        if ($user_pass == '') {
            // passwords do not match
            wpjobportal_errors()->add('password_empty', __('Please enter a password', 'wp-job-portal'));
        }
        if ($user_pass != $pass_confirm) {
            // passwords do not match
            wpjobportal_errors()->add('password_mismatch', __('Passwords do not match', 'wp-job-portal'));
        }

        foreach ($fieldslist AS $field) {
            if($field->isuserfield == 1 && $field->required == 1) {
                if (isset($_POST[$field->field])) {
                    $cf_data = $_POST[$field->field];
                }
                if (empty($cf_data)) {
                    wpjobportal_errors()->add($field->fieldtitle.'_empty', __('Please enter a '.$field->fieldtitle, 'wp-job-portal'));
                }
            }
        }

        $config_array = wpjobportal::$_config->getConfigByFor('captcha');
        if ($config_array['cap_on_reg_form'] == 1) {
            if ($config_array['captcha_selection'] == 1) { // Google recaptcha

                $gresponse = wpjobportal::sanitizeData($_POST['g-recaptcha-response']);
                $resp = googleRecaptchaHTTPPost($config_array['recaptcha_privatekey'] , $gresponse);
                if (! $resp) {
                    wpjobportal_errors()->add('invalid_captcha', __('Invalid captcha', 'wp-job-portal'));
                }
            } else { // own captcha
                $captcha = new WPJOBPORTALcaptcha;
                $result = $captcha->checkCaptchaUserForm();
                if ($result != 1) {
                    wpjobportal_errors()->add('invalid_captcha', __('Invalid captcha', 'wp-job-portal'));
                }
            }
        }

        $errors = wpjobportal_errors()->get_error_messages();

        // only create the user in if there are no errors
        if (empty($errors)) {

            $wperrors = register_new_user(  $user_login,  $user_email );
            $new_user_id = "";
            if (!is_wp_error($wperrors)) {
                $new_user_id = $wperrors;
                if ( $user_first && $user_last ) {
                    $display_name = sprintf( _x( '%1$s %2$s', 'Display name based on first name and last name' ), $user_first, $user_last );
                } elseif ( $user_first ) {
                    $display_name = $user_first;
                } elseif ( $user_last ) {
                    $display_name = $user_last;
                } else {
                    $display_name = $user_login;
                }
                //update_user_option( $new_user_id, 'default_password_nag', false, true );
                wp_set_password( $user_pass, $new_user_id );
                update_user_option( $new_user_id, 'first_name', $user_first, true );
                update_user_option( $new_user_id, 'last_name', $user_last, true );
                wp_update_user( array ('ID' => $new_user_id,  'display_name' => $display_name) ) ;
            } else {
                wpjobportal_errors()->add('email_invalid', __($wperrors->get_error_message(), 'wp-job-portal'));
            }
            if ($new_user_id) {
                // send an email to the admin alerting them of the registration
                wp_new_user_notification($new_user_id);
                // log the new user in
                wp_set_current_user($new_user_id, $user_login);
                wp_set_auth_cookie($new_user_id);
                //do_action('wp_login', $user_login);

                $role = wpjobportal::sanitizeData($_POST['jobs_role'] );

                if (is_numeric($role)) {
                    if ($role == 1) {
                        update_user_meta($new_user_id, 'jobs_role', 'employer');
                        $employer_defaultgroup = wpjobportal::$_config->getConfigurationByConfigName('employer_defaultgroup');
                        wp_update_user(array('ID' => $new_user_id, 'role' => $employer_defaultgroup));
                    } elseif ($role == 2) {
                        update_user_meta($new_user_id, 'jobs_role', 'jobseeker');
                        $jobseeker_defaultgroup = wpjobportal::$_config->getConfigurationByConfigName('jobseeker_defaultgroup');
                        wp_update_user(array('ID' => $new_user_id, 'role' => $jobseeker_defaultgroup));
                    }
                }

                // insert entry into out db also
                $userrole = get_user_meta($new_user_id, 'jobs_role', true);
                $url = '';
                $msguserrole = $userrole;
                if ($userrole == 'employer') {
                    $userrole = 1;
                    $url = wpjobportal::makeUrl(array('wpjobportalme'=>'employer', 'wpjobportallt'=>'controlpanel',"wpjobportalpageid"=>wpjobportal::getPageid()));

                } elseif ($userrole == 'jobseeker') {
                    $userrole = 2;
                    $url = wpjobportal::makeUrl(array('wpjobportalme'=>'jobseeker', 'wpjobportallt'=>'controlpanel',"wpjobportalpageid"=>wpjobportal::getPageid()));
                }
                    $row = WPJOBPORTALincluder::getJSTable('users');
                    $data['uid'] = $new_user_id;
                    $data['roleid'] = $userrole;
                    $data['first_name'] = $user_first;
                    $data['last_name'] = $user_last;
                    $data['emailaddress'] = $user_email;
                    $data['photo'] = $photo;
                    $data['status'] = 1;
                    $data['created'] = date_i18n('Y-m-d H:i:s');
                    $key = WPJOBPORTALincluder::getJSModel($msguserrole)->getMessagekey();
                    if (!$row->bind($data)) {
                        WPJOBPORTALMessages::setLayoutMessage(__('Error Updating User', 'wp-job-portal'), 'error',$key);
                    }
                    if (!$row->store()) {
                        WPJOBPORTALMessages::setLayoutMessage(__('Error Updating User', 'wp-job-portal'), 'error',$key);
                    }else{
                        $data = WPJOBPORTALrequest::get('post');
                        WPJOBPORTALincluder::getObjectClass('customfields')->storeCustomFields(4,$row->id,$data);
                    }
                    ////Store Image In Folder Of jobeeseker
                    if (isset($_FILES['photo']['size']) && $_FILES['photo']['size'] > 0) {
                        $objectid = $row->uid;
                        uploadPhoto($objectid);
                    }
                    //Auto Assign User Package's
                    do_action('wpjobportal_addons_credit_auto_asign_pkg',$row);

                    WPJOBPORTALincluder::getJSModel('emailtemplate')->sendMail(6,$userrole,$row->id); // 6 for regesitration $role for role jobseeker and employer
                    $nickname = $user_first . ' ' . $user_last;

                    $pageid = wpjobportal::$_config->getConfigurationByConfigName('register_jobseeker_redirect_page');

                    if($userrole == 1){
                        $pageid = wpjobportal::$_config->getConfigurationByConfigName('register_employer_redirect_page');
                    }elseif($userrole == 2){
                        $pageid = wpjobportal::$_config->getConfigurationByConfigName('register_jobseeker_redirect_page');
                    }
                    WPJOBPORTALMessages::setLayoutMessage(__('User been successfully created', 'wp-job-portal'), 'updated',$key);
                    // $url = home_url();
                    if(is_numeric($pageid)){
                           if(get_post_status($pageid) == 'publish'){
                               if($userrole == 1){
								   $setRegisterLinkEmploye= wpjobportal::$_config->getConfigurationByConfigName('employe_set_register_link');
								   $customeRegisterLinkForEmploye= wpjobportal::$_config->getConfigurationByConfigName('employe_register_link');
								   if($setRegisterLinkEmploye == 2){
									   wp_redirect($customeRegisterLinkForEmploye);
									   exit;
								   }else{
									$url = get_the_permalink($pageid);
								   }
							   }elseif($userrole == 2){
								   $setRegisterLinkJobSeeker= wpjobportal::$_config->getConfigurationByConfigName('jobseeker_set_register_link');
								   $customeRegisterLinkForJobSeeker= wpjobportal::$_config->getConfigurationByConfigName('jobseeker_register_link');
								   if($setRegisterLinkJobSeeker == 2){
									  wp_redirect($customeRegisterLinkForJobSeeker);
									  exit;
								   }else{
									$url = get_the_permalink($pageid);
								   }
							   }
                         }
                     }
                    wp_redirect($url);
                    exit;


            }
        }
    }
}

add_action('init', 'wpjobportal_add_new_member');
// Store Photo For Job seekser
    function uploadPhoto($id) {
        WPJOBPORTALincluder::getObjectClass('uploads')->uploadJobSeekerPhoto($id);
        return;
    }
// used for tracking error messages
function wpjobportal_errors() {
    static $wp_error; // Will hold global variable safely
    return isset($wp_error) ? $wp_error : ($wp_error = new WP_Error(null, null, null));
}

// displays error messages from form submissions
function wpjobportal_show_error_messages() {
    if ($codes = wpjobportal_errors()->get_error_codes()) {
        echo '<div class="wpjobportal_errors">';
        // Loop error codes and display errors
        $alert_class = 'danger';
        $img_name = 'job-alert-unsuccessful.png';
        foreach ($codes as $code) {
            $message = wpjobportal_errors()->get_error_message($code);
            if(wpjobportal::$theme_chk  != 0){
                echo '<div class="alert alert-' . esc_attr($alert_class) . '" role="alert" id="autohidealert">
                    <img class="leftimg" src="'.WPJOBPORTAL_PLUGIN_URL.'includes/images/'.esc_attr($img_name).'" />
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    '. esc_html($message) . '
                </div>';
            }else{
                echo '<div class="frontend error"><p>' . esc_html($message) . '</p></div>';
            }

        }
        echo '</div>';
    }
}

// ---------------Remove wp user ---------------

function wpjobportal_remove_jobs_user($user_id) {
    //$userrole = get_user_meta( $new_user_id, 'jobs_role', true );

    $js_model = WPJOBPORTALincluder::getJSModel('user');
    $userrole = $js_model->getUserRoleByWPUid($user_id);
    $userid = $js_model->getUserIDByWPUid($user_id);

    if (isset($_POST['delete_option']) AND $_POST['delete_option'] == 'delete') {
        $result = $js_model->enforceDeleteOurUser($userid, $userrole);
        if ($result) {

        } else {

        }
    }
}

add_action('delete_user', 'wpjobportal_remove_jobs_user');

// visual composer hooks

add_action( 'vc_before_init', 'wp_job_portalvcSetAsTheme' );
function wp_job_portalvcSetAsTheme() {
    if(wpjobportal::$theme_chk == 0){
        vc_set_as_theme();

        vc_map( array(
              "name" => __( "Employer Control Panel", "job-hub" ),
              "base" => "wpjobportal_employer_controlpanel",
              "class" => "",
              "category" => __( "WP JOB PORTAL Pages", "job-hub"),
              "icon" => WPJOBPORTAL_PLUGIN_URL . 'includes/images/vc-icons/dashboard.png',
              "show_settings_on_create" => false,
            )
        );

        vc_map( array(
              "name" => __( "Jobseeker Control Panel", "job-hub" ),
              "base" => "wpjobportal_jobseeker_controlpanel",
              "class" => "",
              "category" => __( "WP JOB PORTAL Pages", "job-hub"),
              "icon" => WPJOBPORTAL_PLUGIN_URL . 'includes/images/vc-icons/dashboard.png',
              "show_settings_on_create" => false,
            )
        );

        vc_map( array(
              "name" => __( "Login", "job-hub" ),
              "base" => "wpjobportal_login_page",
              "class" => "",
              "category" => __( "WP JOB PORTAL Pages", "job-hub"),
              "icon" => WPJOBPORTAL_PLUGIN_URL . 'includes/images/vc-icons/login.png',
              "show_settings_on_create" => false,
            )
        );

        vc_map( array(
              "name" => __( "Job Search", "job-hub" ),
              "base" => "wpjobportal_job_search",
              "class" => "",
              "category" => __( "WP JOB PORTAL Pages", "job-hub"),
              "icon" => WPJOBPORTAL_PLUGIN_URL . 'includes/images/vc-icons/job-search.png',
              "show_settings_on_create" => false,
            )
        );

        vc_map( array(
              "name" => __( "Job Listing", "job-hub" ),
              "base" => "wpjobportal_job",
              "class" => "",
              "category" => __( "WP JOB PORTAL Pages", "job-hub"),
              "icon" => WPJOBPORTAL_PLUGIN_URL . 'includes/images/vc-icons/job-list.png',
              "show_settings_on_create" => false,
            )
        );

        vc_map( array(
              "name" => __( "Jobs By Catergories", "job-hub" ),
              "base" => "wpjobportal_job_categories",
              "class" => "",
              "category" => __( "WP JOB PORTAL Pages", "job-hub"),
              "icon" => WPJOBPORTAL_PLUGIN_URL . 'includes/images/vc-icons/job-category.png',
              "show_settings_on_create" => false,
            )
        );

        vc_map( array(
              "name" => __( "Jobs By Types", "job-hub" ),
              "base" => "wpjobportal_job_types",
              "class" => "",
              "category" => __( "WP JOB PORTAL Pages", "job-hub"),
              "icon" => WPJOBPORTAL_PLUGIN_URL . 'includes/images/vc-icons/job-type.png',
              "show_settings_on_create" => false,
            )
        );

        vc_map( array(
              "name" => __( "My Applied Jobs", "job-hub" ),
              "base" => "wpjobportal_my_appliedjobs",
              "class" => "",
              "category" => __( "WP JOB PORTAL Pages", "job-hub"),
              "icon" => WPJOBPORTAL_PLUGIN_URL . 'includes/images/vc-icons/my-applied-job.png',
              "show_settings_on_create" => false,
            )
        );

        vc_map( array(
              "name" => __( "My Companies", "job-hub" ),
              "base" => "wpjobportal_my_companies",
              "class" => "",
              "category" => __( "WP JOB PORTAL Pages", "job-hub"),
              "icon" => WPJOBPORTAL_PLUGIN_URL . 'includes/images/vc-icons/companies.png',
              "show_settings_on_create" => false,
            )
        );


        vc_map( array(
              "name" => __( "My Jobs", "job-hub" ),
              "base" => "wpjobportal_my_jobs",
              "class" => "",
              "category" => __( "WP JOB PORTAL Pages", "job-hub"),
              "icon" => WPJOBPORTAL_PLUGIN_URL . 'includes/images/vc-icons/jobs.png',
              "show_settings_on_create" => false,
            )
        );

        vc_map( array(
              "name" => __( "My Resumes", "job-hub" ),
              "base" => "wpjobportal_my_resumes",
              "class" => "",
              "category" => __( "WP JOB PORTAL Pages", "job-hub"),
              "icon" => WPJOBPORTAL_PLUGIN_URL . 'includes/images/vc-icons/resume.png',
              "show_settings_on_create" => false,
            )
        );

        vc_map( array(
              "name" => __( "Add Company", "job-hub" ),
              "base" => "wpjobportal_add_company",
              "class" => "",
              "category" => __( "WP JOB PORTAL Pages", "job-hub"),
              "icon" => WPJOBPORTAL_PLUGIN_URL . 'includes/images/vc-icons/ad-company.png',
              "show_settings_on_create" => false,
            )
        );


        vc_map( array(
              "name" => __( "Add Job", "job-hub" ),
              "base" => "wpjobportal_add_job",
              "class" => "",
              "category" => __( "WP JOB PORTAL Pages", "job-hub"),
              "icon" => WPJOBPORTAL_PLUGIN_URL . 'includes/images/vc-icons/ad-job.png',
              "show_settings_on_create" => false,
            )
        );

        vc_map( array(
              "name" => __( "Add Resume", "job-hub" ),
              "base" => "wpjobportal_add_resume",
              "class" => "",
              "category" => __( "WP JOB PORTAL Pages", "job-hub"),
              "icon" => WPJOBPORTAL_PLUGIN_URL . 'includes/images/vc-icons/ad-resume.png',
              "show_settings_on_create" => false,
            )
        );

        vc_map( array(
              "name" => __( "Resume Search", "job-hub" ),
              "base" => "wpjobportal_resume_search",
              "class" => "",
              "category" => __( "WP JOB PORTAL Pages", "job-hub"),
              "icon" => WPJOBPORTAL_PLUGIN_URL . 'includes/images/vc-icons/resume-search.png',
              "show_settings_on_create" => false,
            )
        );

        vc_map( array(
              "name" => __( "Employer Registration", "job-hub" ),
              "base" => "wpjobportal_employer_registration",
              "class" => "",
              "category" => __( "WP JOB PORTAL Pages", "job-hub"),
              "icon" => WPJOBPORTAL_PLUGIN_URL . 'includes/images/vc-icons/employer-register.png',
              "show_settings_on_create" => false,
            )
        );

        vc_map( array(
              "name" => __( "Jobseeker Registration", "job-hub" ),
              "base" => "wpjobportal_jobseeker_registration",
              "class" => "",
              "category" => __( "WP JOB PORTAL Pages", "job-hub"),
              "icon" => WPJOBPORTAL_PLUGIN_URL . 'includes/images/vc-icons/jobseeker-register.png',
              "show_settings_on_create" => false,
            )
        );

        vc_map( array(
              "name" => __( "All Companies", "job-hub" ),
              "base" => "wpjobportal_all_companies",
              "class" => "",
              "category" => __( "WP JOB PORTAL Pages", "job-hub"),
              "icon" => WPJOBPORTAL_PLUGIN_URL . 'includes/images/vc-icons/all-companies.png',
              "show_settings_on_create" => false,
            )
        );


        vc_map( array(
              "name" => __( "My Cover Letters", "job-hub" ),
              "base" => "wpjobportal_my_coverletter",
              "class" => "",
              "category" => __( "WP JOB PORTAL Pages", "job-hub"),
              "icon" => WPJOBPORTAL_PLUGIN_URL . 'includes/images/vc-icons/cover-letter.png',
              "show_settings_on_create" => false,
            )
        );

        vc_map( array(
              "name" => __( "My Departments", "job-hub" ),
              "base" => "wpjobportal_my_departments",
              "class" => "",
              "category" => __( "WP JOB PORTAL Pages", "job-hub"),
              "icon" => WPJOBPORTAL_PLUGIN_URL . 'includes/images/vc-icons/department.png',
              "show_settings_on_create" => false,
            )
        );


        vc_map( array(
              "name" => __( "Add Cover Letter", "job-hub" ),
              "base" => "wpjobportal_add_coverletter",
              "class" => "",
              "category" => __( "WP JOB PORTAL Pages", "job-hub"),
              "icon" => WPJOBPORTAL_PLUGIN_URL . 'includes/images/vc-icons/ad-cover-letter.png',
              "show_settings_on_create" => false,
            )
        );

        vc_map( array(
              "name" => __( "Add Department", "job-hub" ),
              "base" => "wpjobportal_add_department",
              "class" => "",
              "category" => __( "WP JOB PORTAL Pages", "job-hub"),
              "icon" => WPJOBPORTAL_PLUGIN_URL . 'includes/images/vc-icons/ad-department.png',
              "show_settings_on_create" => false,
            )
        );
        vc_map( array(
              "name" => __( "Employer My Stats", "job-hub" ),
              "base" => "wpjobportal_employer_my_stats",
              "class" => "",
              "category" => __( "WP JOB PORTAL Pages", "job-hub"),
              "icon" => WPJOBPORTAL_PLUGIN_URL . 'includes/images/vc-icons/employer-stats.png',
              "show_settings_on_create" => false,
            )
        );

        vc_map( array(
              "name" => __( "Jobseeker My Stats", "job-hub" ),
              "base" => "wpjobportal_jobseeker_my_stats",
              "class" => "",
              "category" => __( "WP JOB PORTAL Pages", "job-hub"),
              "icon" => WPJOBPORTAL_PLUGIN_URL . 'includes/images/vc-icons/jobseeker-stats.png',
              "show_settings_on_create" => false,
            )
        );
    }
}
?>
