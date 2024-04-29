<?php
/**
* @param wp-job-portal Optional Form=>Field
*/
?>
<div class="wpjobportal-form-wrapper">
    <div class="wpjobportal-form-title">
        <?php echo __('Name', 'wp-job-portal'); ?>
    </div>
    <div class="wpjobportal-form-value">
        <div class="wpjobportal-form-plain-text">
            <?php echo esc_html($role->first_name) . ' ' . esc_html($role->last_name); ?>
        </div>
    </div>
</div>
<div class="wpjobportal-form-wrapper">
    <div class="wpjobportal-form-title">
        <?php echo __('Username', 'wp-job-portal'); ?>
    </div>
    <div class="wpjobportal-form-value">
        <div class="wpjobportal-form-plain-text">
            <?php echo esc_html($role->user_login); ?>
        </div>
    </div>
</div>
<div class="wpjobportal-form-wrapper">
    <div class="wpjobportal-form-title">
        <?php echo __('Group', 'wp-job-portal'); ?>
    </div>
    <div class="wpjobportal-form-value">
        <div class="wpjobportal-form-plain-text">
            <?php echo esc_html(WPJOBPORTALincluder::getJSModel('user')->getWPRoleNameById($role->wpuid)); ?>
        </div>
    </div>
</div>
<div class="wpjobportal-form-wrapper">
    <div class="wpjobportal-form-title">
        <?php echo __('ID', 'wp-job-portal'); ?>
    </div>
    <div class="wpjobportal-form-value">
        <div class="wpjobportal-form-plain-text">
            <?php echo esc_html($role->id); ?>
        </div>
    </div>
</div>
<div class="wpjobportal-form-wrapper">
    <div class="wpjobportal-form-title">
        <?php echo __('Role', 'wp-job-portal'); ?>
    </div>
    <div class="wpjobportal-form-value">
        <?php echo wp_kses(WPJOBPORTALformfield::select('roleid', WPJOBPORTALincluder::getJSModel('common')->getRolesForCombo(), isset(wpjobportal::$_data[0]->roleid) ? wpjobportal::$_data[0]->roleid : '', '', array('class' => 'inputbox wpjobportal-form-select-field')),WPJOBPORTAL_ALLOWED_TAGS); ?>
    </div>
</div>
<?php
if ($role) {
    if (($role->dated == '0000-00-00 00:00:00') || ($role->dated == ''))
        $curdate = date_i18n('Y-m-d H:i:s');
    else
        $curdate = $role->dated;
}else {
    $curdate = date_i18n('Y-m-d H:i:s');
}
?>
<?php echo wp_kses(WPJOBPORTALformfield::hidden('id', $role->id),WPJOBPORTAL_ALLOWED_TAGS); ?>
<?php echo wp_kses(WPJOBPORTALformfield::hidden('created', $curdate),WPJOBPORTAL_ALLOWED_TAGS); ?>
<?php echo wp_kses(WPJOBPORTALformfield::hidden('action', 'user_saveuserrole'),WPJOBPORTAL_ALLOWED_TAGS); ?>
<?php echo wp_kses(WPJOBPORTALformfield::hidden('form_request', 'wpjobportal'),WPJOBPORTAL_ALLOWED_TAGS); ?>
<div class="wpjobportal-form-button">
    <a id="form-cancel-button" class="wpjobportal-form-cancel-btn" href="<?php echo admin_url('admin.php?page=wpjobportal_user'); ?>" title="<?php echo __('cancel', 'wp-job-portal'); ?>">
        <?php echo __('Cancel', 'wp-job-portal'); ?>
    </a>
    <?php echo wp_kses(WPJOBPORTALformfield::submitbutton('save', __('Change Role', 'wp-job-portal'), array('class' => 'button wpjobportal-form-save-btn')),WPJOBPORTAL_ALLOWED_TAGS); ?>
</div>