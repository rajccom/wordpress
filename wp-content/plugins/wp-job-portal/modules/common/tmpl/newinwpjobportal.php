<?php
if (!defined('ABSPATH'))
    die('Restricted Access');
?>
<div class="wjportal-main-up-wrapper">
<?php
   if(!WPJOBPORTALincluder::getTemplate('templates/header',array('module'=>'common'))){
        return;
   }
if (wpjobportal::$_error_flag == null) {
    $module = WPJOBPORTALrequest::getVar('wpjobportalme');
    $layout = WPJOBPORTALrequest::getVar('wpjobportallt');
    $currentuser = get_userdata(get_current_user_id());
    $uid = '';
    if($currentuser){
    $uid = $currentuser->ID ? $currentuser->ID : "";
    }
    $email = "";
    if(isset($_COOKIE['email'])){
        $email = sanitize_key($_COOKIE['email']);
    }
    $title = wpjobportal::$_config->getConfigurationByConfigName('title');?>
    <div class="wjportal-main-wrapper wjportal-clearfix">
        <div class="wjportal-page-header">
            <div class="wjportal-page-heading">
                <?php echo esc_html(__( $title , 'wp-job-portal')); ?>
            </div>
        </div>
        <div class="wjportal-form-wrp wjportal-new-login-form">
            <form class="wjportal-form" id="coverletter_form" method="post" action="<?php echo esc_url(wpjobportal::makeUrl(array('wpjobportalme'=>'common', 'task'=>'savenewinwpjobportal'))); ?>">
                <div class="wjportal-form-sec-heading"><?php echo __('Are you new in', 'wp-job-portal').' '.__( $title,'wp-job-portal'); ?></div>
                <div class="wjportal-form-row">                
                    <div class="wjportal-form-title"><?php echo __('Please select your role', 'wp-job-portal'); ?> <font >*</font></div>
                    <div class="wjportal-form-value">
                        <?php echo wp_kses(WPJOBPORTALformfield::select('roleid', WPJOBPORTALincluder::getJSModel('common')->getRolesForCombo(''), '', __('Select Role'), array('class' => 'inputbox wjportal-form-select-field', 'data-validation' => 'required')),WPJOBPORTAL_ALLOWED_TAGS); ?>
                    </div>
                </div>
                <?php echo wp_kses(WPJOBPORTALformfield::hidden('desired_module', $module),WPJOBPORTAL_ALLOWED_TAGS); ?>
                <?php echo wp_kses(WPJOBPORTALformfield::hidden('desired_layout', $layout),WPJOBPORTAL_ALLOWED_TAGS); ?>
                <?php echo wp_kses(WPJOBPORTALformfield::hidden('id', ''),WPJOBPORTAL_ALLOWED_TAGS); ?>
                <?php echo wp_kses(WPJOBPORTALformfield::hidden('uid', $uid),WPJOBPORTAL_ALLOWED_TAGS); ?>
                <?php echo wp_kses(WPJOBPORTALformfield::hidden('action', 'common_savenewinwpjobportal'),WPJOBPORTAL_ALLOWED_TAGS); ?>
                <?php echo wp_kses(WPJOBPORTALformfield::hidden('wpjobportalpageid', get_the_ID()),WPJOBPORTAL_ALLOWED_TAGS); ?>
                <?php echo wp_kses(WPJOBPORTALformfield::hidden('form_request', 'wpjobportal'),WPJOBPORTAL_ALLOWED_TAGS); ?>
                <?php
                    if(isset($_COOKIE['wpjobportal-socialmedia']) && !empty($_COOKIE['wpjobportal-socialid'])){
                        echo wp_kses(WPJOBPORTALformfield::hidden('emailaddress', $email),WPJOBPORTAL_ALLOWED_TAGS); 
                        echo wp_kses(WPJOBPORTALformfield::hidden('first_name', sanitize_key($_COOKIE['first_name'])),WPJOBPORTAL_ALLOWED_TAGS); 
                        echo wp_kses(WPJOBPORTALformfield::hidden('socialid', sanitize_key($_COOKIE['wpjobportal-socialid'])),WPJOBPORTAL_ALLOWED_TAGS); 
                        echo wp_kses(WPJOBPORTALformfield::hidden('socialmedia', sanitize_key($_COOKIE['wpjobportal-socialmedia'])),WPJOBPORTAL_ALLOWED_TAGS); 
                        echo wp_kses(WPJOBPORTALformfield::hidden('last_name', sanitize_key($_COOKIE['last_name'])),WPJOBPORTAL_ALLOWED_TAGS);
                    }
                ?>
                <div class="wjportal-form-btn-wrp">
                    <?php echo wp_kses(WPJOBPORTALformfield::submitbutton('save', __('Submit', 'wp-job-portal'), array('class' => 'button wjportal-form-btn wjportal-save-btn')),WPJOBPORTAL_ALLOWED_TAGS); ?>
                </div>
            </form>
        </div>
    </div><?php 
}else{
    echo wp_kses_post(wpjobportal::$_error_flag_message);
}
?>
</div>
