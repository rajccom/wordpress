<?php
if (!defined('ABSPATH'))
    die('Restricted Access');
?>
<div class="wjportal-main-up-wrapper">
<?php

if (wpjobportal::$_error_flag == null) {
    ?>
    <div class="wjportal-main-wrapper wjportal-clearfix">
        <div class="wjportal-page-header">
            <?php
                WPJOBPORTALincluder::getTemplate('templates/pagetitle',array('module' => 'login' , 'layout' => 'login'));
            ?>
            <?php
                if(!WPJOBPORTALincluder::getTemplate('templates/header',array('module'=>'user'))){
                    return;
                }
            ?>
        </div>
        <div class="wjportal-form-wrp wjportal-login-form">
            <div class="wjportal-form-sec-heading">
                <?php echo __('Login into your account', 'wp-job-portal'); ?>
            </div>
            <?php
                if (!is_user_logged_in()) { // Display WordPress login form:
                    $args = array(
                        'redirect' => wpjobportal::$_data[0]['redirect_url'],
                        'form_id' => 'loginform-custom',
                        'label_username' => __('Username', 'wp-job-portal'),
                        'label_password' => __('Password', 'wp-job-portal'),
                        'label_remember' => __('keep me login', 'wp-job-portal'),
                        'label_log_in' => __('Login', 'wp-job-portal'),
                        'remember' => true
                    );
                    wp_login_form($args);
                } /* else { // If logged in:
                  wp_loginout( home_url() ); // Display "Log Out" link.
                  echo " | ";
                  wp_register('', ''); // Display "Site Admin" link.
                  } */
                    if(class_exists('wpjobportal')){ ?>
                        <?php
                            $defaultUrl = wpjobportal::makeUrl(array('wpjobportalpageid'=>wpjobportal::getPageid(), 'wpjobportalme'=>'user', 'wpjobportallt'=>'userregister'));
                            $lrlink = WPJOBPORTALincluder::getJSModel('configuration')->getLoginRegisterRedirectLink($defaultUrl,'register');
                        ?>
                            <a class="wjportal-form-reg-btn" title="<?php echo esc_attr(__('register','wp-job-portal')); ?>" href="<?php echo esc_url($lrlink); ?>" href="<?php echo esc_html__('register an account', 'wp-job-portal'); ?>">
                                <?php echo esc_html__('Register an account', 'wp-job-portal'); ?>
                            </a>
                        <?php 
                        }       
                 ?>

            <?php do_action('wpjobportal_addons_social_login') ?>
        </div>
    </div>
<?php 
} ?>
</div>
