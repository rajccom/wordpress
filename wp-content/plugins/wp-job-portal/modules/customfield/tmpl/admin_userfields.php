<?php
if (!defined('ABSPATH'))
    die('Restricted Access');
wp_enqueue_script('wpjobportal-res-tables', WPJOBPORTAL_PLUGIN_URL . 'includes/js/responsivetable.js');
?>
<div id="wpjobportaladmin-wrapper">
	<div id="wpjobportaladmin-leftmenu">
        <?php  WPJOBPORTALincluder::getClassesInclude('wpjobportaladminsidemenu'); ?>
    </div>
    <div id="wpjobportaladmin-data">
    <?php

    $msgkey = WPJOBPORTALincluder::getJSModel('customfield')->getMessagekey();
    WPJOBPORTALMessages::getLayoutMessage($msgkey);

    ?>
    <span class="js-admin-title">
        <a href="<?php echo esc_url(admin_url('admin.php?page=wpjobportal')); ?>"><img src="<?php echo WPJOBPORTAL_PLUGIN_URL; ?>includes/images/back-icon.png" /></a>
        <?php echo __('User Fields', 'wp-job-portal') ?>
        <a class="js-button-link button" href="<?php echo esc_url(admin_url('admin.php?page=wpjobportal_fieldordering&wpjobportallt=formuserfield')); ?>"><img src="<?php echo WPJOBPORTAL_PLUGIN_URL; ?>includes/images/add_icon.png" /><?php echo __('Add User Field', 'wp-job-portal') ?></a>
    </span>
    <div class="page-actions js-row no-margin">
        <a class="js-bulk-link button multioperation" message="<?php echo esc_attr(WPJOBPORTALMessages::getMSelectionEMessage()); ?>" data-for="remove" confirmmessage="<?php echo __('Are you sure to delete', 'wp-job-portal') .' ?'; ?>"  href="#"><img src="<?php echo WPJOBPORTAL_PLUGIN_URL; ?>includes/images/delete-icon.png" /><?php echo __('Delete', 'wp-job-portal') ?></a>
    </div>
    <script >
        function resetFrom() {
            jQuery("input#title").val('');
            jQuery("select#type").val('');
            jQuery("select#required").val('');
            jQuery("form#wpjobportalform").submit();
        }
    </script>
    <form class="js-filter-form" name="wpjobportalform" id="wpjobportalform" method="post" action="<?php echo esc_url(admin_url("admin.php?page=wpjobportal_customfield&ff=" . wpjobportal::$_data['fieldfor'])); ?>">
        <?php echo wp_kses(WPJOBPORTALformfield::text('title', wpjobportal::$_data['filter']['title'], array('class' => 'inputbox', 'placeholder' => __('Title', 'wp-job-portal'))),WPJOBPORTAL_ALLOWED_TAGS); ?>
        <?php echo wp_kses(WPJOBPORTALformfield::select('type', WPJOBPORTALincluder::getJSModel('common')->getFeilds(), is_numeric(wpjobportal::$_data['filter']['type']) ? wpjobportal::$_data['filter']['type'] : '', __('Select','wp-job-portal') .' '. __('Field Type', 'wp-job-portal'), array('class' => 'inputbox')),WPJOBPORTAL_ALLOWED_TAGS); ?>
        <?php echo wp_kses(WPJOBPORTALformfield::select('required', WPJOBPORTALincluder::getJSModel('common')->getYesNo(), is_numeric(wpjobportal::$_data['filter']['required']) ? wpjobportal::$_data['filter']['required'] : '', __('Required', 'wp-job-portal'), array('class' => 'inputbox')),WPJOBPORTAL_ALLOWED_TAGS); ?>
        <?php echo wp_kses(WPJOBPORTALformfield::hidden('WPJOBPORTAL_form_search', 'WPJOBPORTAL_SEARCH'),WPJOBPORTAL_ALLOWED_TAGS); ?>
        <div class="filter-bottom-button">
            <?php echo wp_kses(WPJOBPORTALformfield::submitbutton('btnsubmit', __('Search', 'wp-job-portal'), array('class' => 'button')),WPJOBPORTAL_ALLOWED_TAGS); ?>
            <?php echo wp_kses(WPJOBPORTALformfield::button('reset', __('Reset', 'wp-job-portal'), array('class' => 'button', 'onclick' => 'resetFrom();')),WPJOBPORTAL_ALLOWED_TAGS); ?>
        </div>
    </form>
    <?php
    if (!empty(wpjobportal::$_data[0])) {
        ?>
        <form id="wpjobportal-list-form" method="post" action="<?php echo esc_url(admin_url("admin.php?page=wpjobportal_customfield")); ?>">
            <table id="js-table">
                <thead>
                    <tr>
                        <th class="grid"><input type="checkbox" name="selectall" id="selectall" value=""></th>
                        <th class="left-row"><?php echo __('Field Name', 'wp-job-portal'); ?></th>
                        <th><?php echo __('Field Title', 'wp-job-portal'); ?></th>
                        <th><?php echo __('Field Type', 'wp-job-portal'); ?></th>
                        <th><?php echo __('Required', 'wp-job-portal'); ?></th>
                        <th><?php echo __('Read Only', 'wp-job-portal'); ?></th>
                        <th class="action"><?php echo __('Action', 'wp-job-portal'); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $k = 0;
                    for ($i = 0, $n = count(wpjobportal::$_data[0]); $i < $n; $i++) {
                        $row = wpjobportal::$_data[0][$i];
                        $required = ($row->required == 1) ? 'yes' : 'no';
                        $requiredalt = ($row->required == 1) ? __('Required', 'wp-job-portal') : __('Not Required', 'wp-job-portal');
                        $readonly = ($row->readonly == 1) ? 'yes' : 'no';
                        $readonlyalt = ($row->readonly == 1) ? __('Required', 'wp-job-portal') : __('Not Required', 'wp-job-portal');
                        ?>
                        <tr valign="top">
                            <td class="grid-rows">
                                <input type="checkbox" class="wpjobportal-cb" id="wpjobportal-cb" name="wpjobportal-cb[]" value="<?php echo esc_attr($row->id); ?>" />
                            </td>
                            <td class="left-row"><a href="<?php echo esc_url(admin_url('admin.php?page=wpjobportal_customfield&wpjobportallt=formuserfield&wpjobportalid='.$row->id)); ?>" title="<?php echo __('user','wp-job-portal'); ?>"><?php echo esc_html($row->name); ?></a></td>
                            <td><?php echo esc_html($row->title); ?></td>
                            <td><?php echo esc_html($row->type); ?></td>
                            <td><img src="<?php echo WPJOBPORTAL_PLUGIN_URL; ?>includes/images/<?php echo $required; ?>.png" alt="<?php echo esc_attr($requiredalt); ?>" title="<?php echo $requiredalt; ?>" /></td>
                            <td><img src="<?php echo WPJOBPORTAL_PLUGIN_URL; ?>includes/images/<?php echo $readonly; ?>.png" alt="<?php echo esc_attr($readonlyalt); ?>" title="<?php echo esc_attr($readonlyalt); ?>" /></td>
                            <td class="action">
                                <a href="<?php echo esc_url(admin_url('admin.php?page=wpjobportal_customfield&wpjobportallt=formuserfield&wpjobportalid='.$row->id)); ?>" title="<?php echo __('Edit', 'wp-job-portal'); ?>"><img src="<?php echo WPJOBPORTAL_PLUGIN_URL; ?>includes/images/edit.png" alt="<?php echo __('Edit', 'wp-job-portal'); ?>" title="<?php echo __('Edit', 'wp-job-portal'); ?>"></a>
                                <a href="<?php echo esc_url(wp_nonce_url(admin_url('admin.php?page=wpjobportal_customfield&task=remove&action=wpjobportaltask&wpjobportal-cb[]='.$row->id),'delete-customfield')); ?>" onclick='return confirmdelete("<?php echo __('Are you sure to delete', 'wp-job-portal').' ?'; ?>");' title="<?php echo __('Delete', 'wp-job-portal'); ?>"><img src="<?php echo WPJOBPORTAL_PLUGIN_URL; ?>includes/images/remove.png" alt="<?php echo __('Delete', 'wp-job-portal'); ?>" title="<?php echo __('Delete', 'wp-job-portal'); ?>"></a>
                            </td>
                        </tr>
                        <?php
                        $k = 1 - $k;
                    }
                    ?>
                </tbody>
            </table>
            <?php echo wp_kses(WPJOBPORTALformfield::hidden('action', 'customfield_remove'),WPJOBPORTAL_ALLOWED_TAGS); ?>
            <?php echo wp_kses(WPJOBPORTALformfield::hidden('task', ''),WPJOBPORTAL_ALLOWED_TAGS); ?>
            <?php echo wp_kses(WPJOBPORTALformfield::hidden('form_request', 'wpjobportal'),WPJOBPORTAL_ALLOWED_TAGS); ?>
            <?php echo wp_kses(WPJOBPORTALformfield::hidden('_wpnonce', wp_create_nonce('delete-customfield')),WPJOBPORTAL_ALLOWED_TAGS); ?>
        </form>
        <?php
        if (wpjobportal::$_data[1]) {
            echo '<div class="tablenav"><div class="tablenav-pages">' . wp_kses_post(wpjobportal::$_data[1]) . '</div></div>';
        }
    } else {
        WPJOBPORTALlayout::getNoRecordFound();
    }
    ?>
</div>
</div>
