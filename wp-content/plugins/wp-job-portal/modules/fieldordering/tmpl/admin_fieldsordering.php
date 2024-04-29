<?php
if (!defined('ABSPATH'))
    die('Restricted Access');
wp_enqueue_script('wpjobportal-res-tables', WPJOBPORTAL_PLUGIN_URL . 'includes/js/responsivetable.js');
wp_enqueue_script('jquery-ui-sortable');
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
wp_enqueue_style('jquery-ui-css', WPJOBPORTAL_PLUGIN_URL . 'includes/css/jquery-ui-smoothness.css');
wp_enqueue_script('jquery-multisortable',WPJOBPORTAL_PLUGIN_URL.'/includes/js/jquery.multisortable.js');
?>
<!-- main wrapper -->
<div id="wpjobportaladmin-wrapper">
     <!-- left menu -->
    <div id="wpjobportaladmin-leftmenu">
        <?php  WPJOBPORTALincluder::getClassesInclude('wpjobportaladminsidemenu'); ?>
    </div>
    <div id="wpjobportaladmin-data">
        <div id="full_background" style="display:none;"></div>
        <div id="popup_main" style="display:none;"></div>
        <?php
            $msgkey = WPJOBPORTALincluder::getJSModel('fieldordering')->getMessagekey();
            WPJOBPORTALMessages::getLayoutMessage($msgkey);
        ?>
        <!-- top bar -->
        <div id="wpjobportal-wrapper-top">
            <div id="wpjobportal-wrapper-top-left">
                <div id="wpjobportal-breadcrumbs">
                    <ul>
                        <li>
                            <a href="<?php echo admin_url('admin.php?page=wpjobportal'); ?>" title="<?php echo __('dashboard','wp-job-portal'); ?>">
                                <?php echo __('Dashboard','wp-job-portal'); ?>
                            </a>
                        </li>
                        <li><?php echo __('Custom Fields','wp-job-portal'); ?></li>
                    </ul>
                </div>
            </div>
            <div id="wpjobportal-wrapper-top-right">
                <div id="wpjobportal-config-btn">
                    <a href="admin.php?page=wpjobportal_configuration" title="<?php echo __('configuration','wp-job-portal'); ?>">
                        <img src="<?php echo WPJOBPORTAL_PLUGIN_URL; ?>includes/images/control_panel/dashboard/config.png">
                   </a>
                </div>
                <div id="wpjobportal-help-btn" class="wpjobportal-help-btn">
                    <a href="admin.php?page=wpjobportal&wpjobportallt=help" title="<?php echo __('help','wp-job-portal'); ?>">
                        <img src="<?php echo WPJOBPORTAL_PLUGIN_URL; ?>includes/images/control_panel/dashboard/help.png">
                   </a>
                </div>
                <div id="wpjobportal-vers-txt">
                    <?php echo __('Version','wp-job-portal').': '; ?>
                    <span class="wpjobportal-ver"><?php echo esc_html(WPJOBPORTALincluder::getJSModel('configuration')->getConfigValue('versioncode')); ?></span>
                </div>
            </div>
        </div>
        <!-- top head -->
        <div id="wpjobportal-head">
            <h1 class="wpjobportal-head-text">
                <?php
                    if(wpjobportal::$_data['fieldfor'] == 1){
                        echo __('Company','wp-job-portal');
                    } elseif (wpjobportal::$_data['fieldfor'] == 2){
                        echo __('Job','wp-job-portal');
                    } elseif (wpjobportal::$_data['fieldfor'] == 3){
                        echo __('Resume','wp-job-portal');
                    }
                    echo ' '.__('Fields', 'wp-job-portal');
                ?>
            </h1>
            <?php
                if(in_array('customfield', wpjobportal::$_active_addons)){
                    do_action('wpjobportal_addons_customFields_addUser',wpjobportal::$_data['fieldfor']);
                }else{
                    echo '<a class="wpjobportal-add-link button" href="?page=wpjobportal_customfield&wpjobportallt=formuserfield&ff='.wpjobportal::$_data['fieldfor'].'" title='. __('add user fields','wp-job-portal').'>
                            <img src='.WPJOBPORTAL_PLUGIN_URL.'includes/images/control_panel/dashboard/plus-icon.png>
                            '. __('Add User Field','wp-job-portal').'
                        </a>';
                }
            ?>
        </div>
        <!-- page content -->
        <div id="wpjobportal-admin-wrapper" class="p0 bg-n bs-n">
            <!-- quick actions -->
            <div id="wpjobportal-page-quick-actions">
                <a class="wpjobportal-page-quick-act-btn multioperation" message="<?php echo esc_attr(WPJOBPORTALMessages::getMSelectionEMessage()); ?>" data-for="fieldpublished" href="#" title="<?php echo __('user publish', 'wp-job-portal') ?>">
                    <img src="<?php echo WPJOBPORTAL_PLUGIN_URL; ?>includes/images/control_panel/dashboard/good.png" alt="<?php echo __('user publish', 'wp-job-portal') ?>" />
                    <?php echo __('User Publish', 'wp-job-portal'); ?>
                </a>
                <a class="wpjobportal-page-quick-act-btn multioperation" message="<?php echo esc_attr(WPJOBPORTALMessages::getMSelectionEMessage()); ?>" data-for="fieldunpublished" href="#" title="<?php echo __('user unpublish', 'wp-job-portal') ?>">
                    <img src="<?php echo WPJOBPORTAL_PLUGIN_URL; ?>includes/images/control_panel/dashboard/close.png" alt="<?php echo __('user unpublish', 'wp-job-portal') ?>" />
                    <?php echo __('User Unpublished', 'wp-job-portal'); ?>
                </a>
                <a class="wpjobportal-page-quick-act-btn multioperation" message="<?php echo esc_attr(WPJOBPORTALMessages::getMSelectionEMessage()); ?>" data-for="visitorfieldpublished" href="#" title="<?php echo __('visitor publish', 'wp-job-portal') ?>">
                    <img src="<?php echo WPJOBPORTAL_PLUGIN_URL; ?>includes/images/control_panel/dashboard/good.png" alt="<?php echo __('visitor publish', 'wp-job-portal') ?>" />
                    <?php echo __('Visitor Publish', 'wp-job-portal'); ?>
                </a>
                <a class="wpjobportal-page-quick-act-btn multioperation" message="<?php echo esc_attr(WPJOBPORTALMessages::getMSelectionEMessage()); ?>" data-for="visitorfieldunpublished" href="#" title="<?php echo __('visitor unpublish', 'wp-job-portal') ?>">
                    <img src="<?php echo WPJOBPORTAL_PLUGIN_URL; ?>includes/images/control_panel/dashboard/close.png" alt="<?php echo __('visitor unpublish', 'wp-job-portal') ?>" />
                    <?php echo __('Visitor Unpublished', 'wp-job-portal'); ?>
                </a>
                <a class="wpjobportal-page-quick-act-btn multioperation" message="<?php echo esc_attr(WPJOBPORTALMessages::getMSelectionEMessage()); ?>" data-for="fieldrequired" href="#" title="<?php echo __('required', 'wp-job-portal') ?>">
                    <img src="<?php echo WPJOBPORTAL_PLUGIN_URL; ?>includes/images/control_panel/dashboard/good.png" alt="<?php echo __('required', 'wp-job-portal') ?>" />
                    <?php echo __('Required', 'wp-job-portal') ?>
                </a>
                <a class="wpjobportal-page-quick-act-btn multioperation" message="<?php echo esc_attr(WPJOBPORTALMessages::getMSelectionEMessage()); ?>" data-for="fieldnotrequired" href="#" title="<?php echo __('not required', 'wp-job-portal') ?>">
                    <img src="<?php echo WPJOBPORTAL_PLUGIN_URL; ?>includes/images/control_panel/dashboard/close.png" alt="<?php echo __('not required', 'wp-job-portal') ?>" />
                    <?php echo __('Not Required', 'wp-job-portal') ?>
                </a>
            </div>
            <script>
                jQuery(document).ready(function () {
                    jQuery("div#full_background").click(function () {
                        closePopup();
                    });

                    jQuery('#wpjobportal-table tbody').multisortable({
                        items: '.sortable',
                        selectedClass: "selected",
                        stop: function(e,ui){
                            jQuery('.js-form-button').slideDown('slow');
                            var abc =  jQuery('table#wpjobportal-table tbody').sortable('serialize');
                            jQuery('input#fields_ordering_new').val(abc);
                        }
                    });

                    jQuery("#saveordering").click(function(){
                        jQuery("#wpjobportal-list-form").attr('action','<?php echo admin_url("admin.php?page=wpjobportal&task=saveordering"); ?>');
                        return true;
                    });

                });

                function resetFrom() {
                    jQuery("input#title").val('');
                    jQuery("select#ustatus").val('');
                    jQuery("select#vstatus").val('');
                    jQuery("select#required").val('');
                    jQuery("form#wpjobportalform").submit();
                }

                <?php
                    /*function showPopupAndSetValues(id) {
                        jQuery.post(ajaxurl, {action: 'wpjobportal_ajax', wpjobportalme: 'fieldordering', task: 'getOptionsForFieldEdit', field: id}, function (data) {
                            if (data) {
                                var d = jQuery.parseJSON(data);
                                jQuery("div#full_background").css("display", "block");
                                jQuery("div#popup_main").html(d);
                                jQuery("div#popup_main").slideDown('slow');
                            }
                        });
                    }*/
                    ?>

                function closePopup() {
                    jQuery("div#popup_main").slideUp('slow');
                    setTimeout(function () {
                        jQuery("div#full_background").hide();
                        jQuery("div#popup_main").html('');
                    }, 700);
                }
            </script>
            <!-- filter form -->
            <form class="wpjobportal-filter-form" name="wpjobportalform" id="wpjobportalform" method="post" action="<?php echo esc_url(admin_url("admin.php?page=wpjobportal_fieldordering&ff=" . wpjobportal::$_data['fieldfor'])); ?>">
                <?php echo wp_kses(WPJOBPORTALformfield::text('title', wpjobportal::$_data['filter']['title'], array('class' => 'inputbox wpjobportal-form-input-field', 'placeholder' => __('Title', 'wp-job-portal'))),WPJOBPORTAL_ALLOWED_TAGS); ?>
                <?php echo wp_kses(WPJOBPORTALformfield::select('ustatus', WPJOBPORTALincluder::getJSModel('common')->getStatus(), is_numeric(wpjobportal::$_data['filter']['ustatus']) ? wpjobportal::$_data['filter']['ustatus'] : '', __('Select status', 'wp-job-portal')/*__('Select user status', 'wp-job-portal')*/, array('class' => 'inputbox wpjobportal-form-select-field')),WPJOBPORTAL_ALLOWED_TAGS); ?>
                <?php echo wp_kses(WPJOBPORTALformfield::select('required', WPJOBPORTALincluder::getJSModel('common')->getYesNo(), is_numeric(wpjobportal::$_data['filter']['required']) ? wpjobportal::$_data['filter']['required'] : '', __('Required', 'wp-job-portal'), array('class' => 'inputbox wpjobportal-form-select-field')),WPJOBPORTAL_ALLOWED_TAGS); ?>
                <?php echo wp_kses(WPJOBPORTALformfield::hidden('WPJOBPORTAL_form_search', 'WPJOBPORTAL_SEARCH'),WPJOBPORTAL_ALLOWED_TAGS); ?>
                <?php echo wp_kses(WPJOBPORTALformfield::submitbutton('btnsubmit', __('Search', 'wp-job-portal'), array('class' => 'button wpjobportal-form-search-btn')),WPJOBPORTAL_ALLOWED_TAGS); ?>
                <?php echo wp_kses(WPJOBPORTALformfield::button('reset', __('Reset', 'wp-job-portal'), array('class' => 'button wpjobportal-form-reset-btn', 'onclick' => 'resetFrom();')),WPJOBPORTAL_ALLOWED_TAGS); ?>
            </form>
            <?php
                if (!empty(wpjobportal::$_data[0])) {
                    ?>
                    <form id="wpjobportal-list-form" method="post" class="wpjobportal-form" action="<?php echo esc_url(admin_url("admin.php?page=wpjobportal_fieldordering")); ?>">
                        <table id="wpjobportal-table" class="wpjobportal-table">
                            <thead>
                                <tr>
                                    <th>
                                        <input type="checkbox" name="selectall" id="selectall" value="">
                                    </th>
                                    <th class="wpjobportal-text-left">
                                        <?php echo __('Field Title', 'wp-job-portal'); ?>
                                    </th>
                                    <th>
                                        <?php echo __('User Published', 'wp-job-portal'); ?>
                                    </th>
                                    <th>
                                        <?php echo __('Visitor Published', 'wp-job-portal'); ?>
                                    </th>
                                    <th>
                                        <?php echo __('Required', 'wp-job-portal'); ?>
                                    </th>
                                    <th>
                                        <?php echo __('Action', 'wp-job-portal'); ?>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $pagenum = WPJOBPORTALrequest::getVar('pagenum', 'get', 1);
                                    $pageid = ($pagenum > 1) ? '&pagenum=' . $pagenum : '';
                                    $islastordershow = WPJOBPORTALpagination::isLastOrdering(wpjobportal::$_data['total'], $pagenum);
                                    for ($i = 0, $n = count(wpjobportal::$_data[0]); $i < $n; $i++) {
                                        $row = wpjobportal::$_data[0][$i];
                                        if (isset(wpjobportal::$_data[0][$i + 1]))
                                            $row1 = wpjobportal::$_data[0][$i + 1];
                                        else
                                            $row1 = wpjobportal::$_data[0][$i];
                                        $uptask = 'fieldorderingup';
                                        $downtask = 'fieldorderingdown';
                                        $upimg = 'uparrow.png';
                                        $downimg = 'downarrow.png';
                                        $pubtask = $row->published ? 'fieldunpublished' : 'fieldpublished';
                                        $pubimg = $row->published ? 'tick.png' : 'publish_x.png';
                                        $alt = $row->published ? __('Published', 'wp-job-portal') : __('Unpublished', 'wp-job-portal');
                                        $visitorpubtask = $row->isvisitorpublished ? 'visitorfieldunpublished' : 'visitorfieldpublished';
                                        $visitorpubimg = $row->isvisitorpublished ? 'tick.png' : 'publish_x.png';
                                        $visitoralt = $row->isvisitorpublished ? __('Published', 'wp-job-portal') : __('Unpublished', 'wp-job-portal');
                                        $requiredtask = $row->required ? 'fieldnotrequired' : 'fieldrequired';
                                        $requiredpubimg = $row->required ? 'tick.png' : 'publish_x.png';
                                        $requiredalt = $row->required ? __('Required', 'wp-job-portal') : __('Not Required', 'wp-job-portal');
                                        $sec = wpjobportalphplib::wpJP_substr($row->field, 0, 8); //get section_
                                        $newsection = 0;
                                        ?>
                                        <tr class="<?php if($sec != 'section_') echo 'sortable'; ?>" id="id_<?php echo esc_attr($row->id); ?>">
                                            <td>
                                                <input type="checkbox" class="wpjobportal-cb" id="wpjobportal-cb" name="wpjobportal-cb[]" value="<?php echo esc_attr($row->id); ?>" />
                                            </td>
                                            <?php

                                                // $sec = wpjobportalphplib::wpJP_substr($row->field, 0, 8); //get section_
                                                // $newsection = 0;
                                                if ($sec == 'section_') {
                                                    $newsection = 1;
                                                    $subsec = wpjobportalphplib::wpJP_substr($row->field, 0, 12);
                                                    if ($subsec == 'section_sub_') {
                                                        ?>
                                                        <td class="wpjobportal-text-left">
                                                            <?php echo esc_html(__($row->fieldtitle,'wp-job-portal')); ?>
                                                        </td>
                                                    <?php } else { ?>
                                                        <td class="wpjobportal-text-left">
                                                            <?php echo esc_html(__($row->fieldtitle,'wp-job-portal')); ?>
                                                        </td>
                                                    <?php } ?>
                                                    <td>
                                                        <?php if ($row->cannotunpublish == 1) { ?>
                                                            <img src="<?php echo WPJOBPORTAL_PLUGIN_URL; ?>includes/images/control_panel/dashboard/good.png" alt="<?php echo __('published', 'wp-job-portal'); ?>" />
                                                        <?php
                                                            } else {
                                                                $icon_name = "close.png";
                                                                $task = "fieldpublished";
                                                                if ($row->published == 1) {
                                                                    $task = "fieldunpublished";
                                                                    $icon_name = "good.png";
                                                                }
                                                            ?>
                                                        <a href="<?php echo esc_url(admin_url('admin.php?page=wpjobportal_fieldordering&task='.$task.'&action=wpjobportaltask&wpjobportal-cb[]='.$row->id.$pageid.'&ff='.wpjobportal::$_data['fieldfor'])); ?>" title="<?php echo esc_attr($alt); ?>">
                                                            <img src="<?php echo WPJOBPORTAL_PLUGIN_URL; ?>includes/images/control_panel/dashboard/<?php echo $icon_name; ?>" alt="<?php echo esc_attr($alt); ?>" />
                                                        </a>
                                                        <?php } ?>
                                                    </td>
                                                    <td>
                                                        <?php if ($row->cannotunpublish == 1) { ?>
                                                            <img src="<?php echo WPJOBPORTAL_PLUGIN_URL; ?>includes/images/control_panel/dashboard/good.png" alt="<?php echo __('published', 'wp-job-portal'); ?>" />
                                                        <?php
                                                            } else {
                                                                $icon_name = "close.png";
                                                                $task = "visitorfieldpublished";
                                                                if ($row->isvisitorpublished == 1) {
                                                                    $task = "visitorfieldunpublished";
                                                                    $icon_name = "good.png";
                                                                }
                                                            ?>
                                                            <a href="<?php echo esc_url(admin_url('admin.php?page=wpjobportal_fieldordering&task='.$task.'&action=wpjobportaltask&wpjobportal-cb[]'.$row->id.$pageid.'&ff='.wpjobportal::$_data['fieldfor'])); ?>" title="<?php echo esc_attr($visitoralt); ?>">
                                                                <img src="<?php echo WPJOBPORTAL_PLUGIN_URL; ?>includes/images/control_panel/dashboard/<?php echo $icon_name; ?>" alt="<?php echo esc_attr($visitoralt); ?>" />
                                                            </a>
                                                        <?php } ?>
                                                    </td>
                                                    <td>
                                                        <?php if ($row->cannotunpublish == 1) { ?>
                                                            <img src="<?php echo WPJOBPORTAL_PLUGIN_URL; ?>includes/images/control_panel/dashboard/good.png" alt="<?php echo __('published', 'wp-job-portal'); ?>" />
                                                        <?php
                                                            } else {
                                                                $icon_name = "close.png";
                                                                $task = "visitorfieldpublished";
                                                                if ($row->isvisitorpublished == 1) {
                                                                    $task = "visitorfieldunpublished";
                                                                    $icon_name = "good.png";
                                                                }
                                                            ?>
                                                            <a href="<?php echo esc_url(admin_url('admin.php?page=wpjobportal_fieldordering&task='.$task.'&action=wpjobportaltask&wpjobportal-cb[]'.$row->id.$pageid.'&ff='.wpjobportal::$_data['fieldfor'])); ?>" title="<?php echo esc_attr($visitoralt); ?>">
                                                                <img src="<?php echo WPJOBPORTAL_PLUGIN_URL; ?>includes/images/control_panel/dashboard/<?php echo $icon_name; ?>" alt="<?php echo esc_attr($visitoralt); ?>" />
                                                            </a>
                                                        <?php } ?>
                                                    </td>
                                                    <td>--</td>
                                            <?php } else { ?>
                                                <td class="wpjobportal-text-left">
                                                    <?php echo esc_html(__($row->fieldtitle,'wp-job-portal')); ?>
                                                </td>
                                                <td>
                                                    <?php if ($row->cannotunpublish == 1) { ?>
                                                        <img src="<?php echo WPJOBPORTAL_PLUGIN_URL; ?>includes/images/control_panel/dashboard/good.png" title="<?php echo __('published', 'wp-job-portal'); ?>" />
                                                    <?php
                                                        } else {
                                                            $icon_name = "close.png";
                                                            $task = "fieldpublished";
                                                            if ($row->published == 1) {
                                                                $task = "fieldunpublished";
                                                                $icon_name = "good.png";
                                                            }
                                                            ?>
                                                        <a href="<?php echo esc_url(admin_url('admin.php?page=wpjobportal_fieldordering&task='.$task.'&action=wpjobportaltask&wpjobportal-cb[]='.$row->id.$pageid.'&ff='.wpjobportal::$_data['fieldfor'])); ?>" title="<?php echo esc_attr($alt); ?>">
                                                            <img src="<?php echo WPJOBPORTAL_PLUGIN_URL; ?>includes/images/control_panel/dashboard/<?php echo $icon_name; ?>" alt="<?php echo esc_attr($alt); ?>" />
                                                        </a>
                                                    <?php } ?>
                                                </td>
                                                <td>
                                                    <?php if ($row->cannotunpublish == 1) { ?>
                                                        <img src="<?php echo WPJOBPORTAL_PLUGIN_URL; ?>includes/images/control_panel/dashboard/good.png" title="<?php echo __('Un published', 'wp-job-portal'); ?>" />
                                                    <?php
                                                        } else {
                                                            $icon_name = "close.png";
                                                            $task = "visitorfieldpublished";
                                                            if ($row->isvisitorpublished == 1) {
                                                                $task = "visitorfieldunpublished";
                                                                $icon_name = "good.png";
                                                            }
                                                            ?>
                                                        <a href="<?php echo esc_url(admin_url('admin.php?page=wpjobportal_fieldordering&task='.$task.'&action=wpjobportaltask&wpjobportal-cb[]='.$row->id.$pageid.'&ff='.wpjobportal::$_data['fieldfor'])); ?>" title="<?php echo esc_attr($alt); ?>">
                                                            <img src="<?php echo WPJOBPORTAL_PLUGIN_URL; ?>includes/images/control_panel/dashboard/<?php echo $icon_name; ?>" alt="<?php echo esc_attr($alt); ?>" />
                                                        </a>
                                                    <?php } ?>
                                                </td>
                                                <td>
                                                    <?php if ($row->sys == 1 || $row->field == 'termsandconditions') { ?>
                                                        <img src="<?php echo WPJOBPORTAL_PLUGIN_URL; ?>includes/images/control_panel/dashboard/good.png" title="<?php echo __('required', 'wp-job-portal'); ?>" />
                                                        <?php
                                                    } else {
                                                        $icon_name = "close.png";
                                                        $task = "fieldrequired";
                                                        if ($row->required == 1) {
                                                            $task = "fieldnotrequired";
                                                            $icon_name = "good.png";
                                                        }
                                                    ?>
                                                    <a href="<?php echo esc_url(admin_url('admin.php?page=wpjobportal_fieldordering&task='.$task.'&action=wpjobportaltask&wpjobportal-cb[]='.$row->id.$pageid.'&ff='.wpjobportal::$_data['fieldfor'])); ?>" title="<?php echo esc_attr($requiredalt); ?>">
                                                        <img src="<?php echo WPJOBPORTAL_PLUGIN_URL; ?>includes/images/control_panel/dashboard/<?php echo $icon_name; ?>" alt="<?php echo esc_attr($requiredalt); ?>" />
                                                    </a>
                                                    <?php } ?>
                                                </td>
                                                <td>
                                                    <a class="wpjobportal-table-act-btn" href="<?php echo esc_url(admin_url("admin.php?page=wpjobportal_fieldordering&wpjobportallt=formuserfield&ff=".wpjobportal::$_data['fieldfor']."&wpjobportalid=".$row->id)); ?>" title="<?php echo __('edit', 'wp-job-portal'); ?>">
                                                        <img src="<?php echo WPJOBPORTAL_PLUGIN_URL; ?>includes/images/control_panel/dashboard/edit.png" alt="<?php echo __('edit', 'wp-job-portal'); ?>">
                                                    </a>
                                                    <?php if ($row->isuserfield == 1) { ?>
                                                        <a class="wpjobportal-table-act-btn" href="<?php echo esc_url(wp_nonce_url(admin_url('admin.php?page=wpjobportal_fieldordering&task=remove&action=wpjobportaltask&fieldid='.$row->id.'&ff='.wpjobportal::$_data['fieldfor']),'delete-fieldordering')); ?>" onclick='return confirmdelete("<?php echo __('Are you sure to delete', 'wp-job-portal').' ?'; ?>");' title="<?php echo __('delete', 'wp-job-portal'); ?>">
                                                            <img src="<?php echo WPJOBPORTAL_PLUGIN_URL; ?>includes/images/control_panel/dashboard/delete.png" alt="<?php echo __('delete', 'wp-job-portal'); ?>">
                                                        </a>
                                                    <?php } ?>
                                                </td>
                                            <?php
                                                $newsection = 0;
                                                }
                                            ?>
                                        </tr>
                                    <?php
                                    }
                                ?>
                            </tbody>
                        </table>
                        <?php echo wp_kses(WPJOBPORTALformfield::hidden('task', ''),WPJOBPORTAL_ALLOWED_TAGS); ?>
                        <?php echo wp_kses(WPJOBPORTALformfield::hidden('pagenum', ($pagenum > 1) ? $pagenum : ''),WPJOBPORTAL_ALLOWED_TAGS); ?>
                        <?php echo wp_kses(WPJOBPORTALformfield::hidden('form_request', 'wpjobportal'),WPJOBPORTAL_ALLOWED_TAGS); ?>
                        <?php echo wp_kses(WPJOBPORTALformfield::hidden('fieldfor',wpjobportal::$_data['fieldfor']),WPJOBPORTAL_ALLOWED_TAGS); ?>
                        <?php echo wp_kses(WPJOBPORTALformfield::hidden('ff',wpjobportal::$_data['fieldfor']),WPJOBPORTAL_ALLOWED_TAGS); ?>
                        <?php echo wp_kses(WPJOBPORTALformfield::hidden('fields_ordering_new', ''),WPJOBPORTAL_ALLOWED_TAGS); ?>
                        <?php echo wp_kses(WPJOBPORTALformfield::hidden('ordering_for', 'fieldordering'),WPJOBPORTAL_ALLOWED_TAGS); ?>
                        <?php echo wp_kses(WPJOBPORTALformfield::hidden('pagenum_for_ordering', WPJOBPORTALrequest::getVar('pagenum', 'get', 1)),WPJOBPORTAL_ALLOWED_TAGS); ?>
                        <?php echo wp_kses(WPJOBPORTALformfield::hidden('_wpnonce', wp_create_nonce('delete-fieldordering')),WPJOBPORTAL_ALLOWED_TAGS); ?>
                        <div class="js-form-button wpjobportal-form-button" style="display: none;">
                            <?php echo wp_kses(WPJOBPORTALformfield::submitbutton('saveordering', __('Save Ordering', 'wp-job-portal'), array('class' => 'button js-form-save wpjobportal-form-save-btn')),WPJOBPORTAL_ALLOWED_TAGS); ?>
                        </div>
                    </form>
            <?php
                if (wpjobportal::$_data[1]) {
                    echo '<div class="tablenav">
                        <div class="tablenav-pages">' . wp_kses_post(wpjobportal::$_data[1]) . '</div>
                    </div>';
                }
                } else {
                    $msg = __('No record found','wp-job-portal');
                    $link[] = array(
                        'link' => 'admin.php?page=wpjobportal_customfield&wpjobportallt=formuserfield&ff='.wpjobportal::$_data['fieldfor'],
                        'text' => __('Add New','wp-job-portal') .' '. __('User Field','wp-job-portal')
                    );
                    WPJOBPORTALlayout::getNoRecordFound($msg,$link);
                }
            ?>
        </div>
    </div>
</div>
