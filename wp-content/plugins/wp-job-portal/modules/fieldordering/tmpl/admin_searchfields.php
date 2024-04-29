<?php
    if(!defined('ABSPATH'))
     die('Restricted Access');
    wp_enqueue_script('wpjobportal-res-tables', WPJOBPORTAL_PLUGIN_URL . 'includes/js/responsivetable.js');
    wp_enqueue_script('jquery-ui-sortable');
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
    wp_enqueue_style('jquery-ui-css', WPJOBPORTAL_PLUGIN_URL . 'includes/css/jquery-ui-smoothness.css');
    $searchable_combo = array(
         (object) array('id' => 1, 'text' => __('Enabled', 'wp-job-portal')),
         (object) array('id' => 0, 'text' => __('Disabled', 'wp-job-portal')));
?>
<!-- main wrapper -->
<div id="wpjobportaladmin-wrapper">
    <!-- left menu -->
    <div id="wpjobportaladmin-leftmenu">
        <?php  WPJOBPORTALincluder::getClassesInclude('wpjobportaladminsidemenu'); ?>
    </div>
    <div id="wpjobportaladmin-data">
        <div id="full_background" style="display:none;"></div>
        <div id="popup_main" style="display:none;">
            <span class="popup-top">
                <span id="popup_title" ></span>
                <img id="popup_cross" alt="popup cross" onClick="closePopup();" src="<?php echo  WPJOBPORTAL_PLUGIN_URL;?>includes/images/popup-close.png">
            </span>
            <?php $ff = wpjobportal::$_data["fieldfor"]; ?>
            <form id="wpjobportal-form" class="popup-field-from" method="post" action="<?php echo esc_url(admin_url("admin.php?page=wpjobportal_fieldordering&task=savesearchfieldordering&action=wpjobportaltask&fieldfor=$ff&ff=$ff"));?>">
                <div class="popup-field-wrapper">
                    <div class="popup-field-title"><?php echo  __('User Search', 'wp-job-portal');?></div>
                    <div class="popup-field-obj"><?php echo  wp_kses(WPJOBPORTALformfield::select('search_user', $searchable_combo, 0, '', array('class' => 'inputbox one')),WPJOBPORTAL_ALLOWED_TAGS);?></div>
                </div>
                <div class="popup-field-wrapper">
                    <div class="popup-field-title"><?php echo  __('Visitor Search', 'wp-job-portal');?></div>
                    <div class="popup-field-obj"><?php echo  wp_kses(WPJOBPORTALformfield::select('search_visitor', $searchable_combo, 0, '', array('class' => 'inputbox one')),WPJOBPORTAL_ALLOWED_TAGS);?></div>
                </div>
                <?php echo wp_kses(WPJOBPORTALformfield::hidden('form_request', 'wpjobportal'),WPJOBPORTAL_ALLOWED_TAGS); ?>
                <?php echo wp_kses(WPJOBPORTALformfield::hidden('id',''),WPJOBPORTAL_ALLOWED_TAGS); ?>
                <?php echo wp_kses(WPJOBPORTALformfield::hidden('fieldfor',wpjobportal::$_data['fieldfor']),WPJOBPORTAL_ALLOWED_TAGS); ?>
                <div class="popup-act-btn-wrp">
                    <?php echo  wp_kses(WPJOBPORTALformfield::submitbutton('save', __('Save', 'wp-job-portal'), array('class' => 'button popup-act-btn')),WPJOBPORTAL_ALLOWED_TAGS); ?>
                </div>
            </form>
        </div>
        <script >
            jQuery(document).ready(function () {
                jQuery("div#full_background").click(function () {
                    closePopup();
                });
                jQuery('table#wpjobportal-table tbody').sortable({
                    handle : ".grid-rows , .wpjobportal-text-left",
                    update  : function () {
                        var abc =  jQuery('table#wpjobportal-table tbody').sortable('serialize');
                        jQuery('input#fields_ordering_new').val(abc);
                    }

                });
            });

            function showPopupAndSetValues(id,title_string, search_user, search_visitor) {
                jQuery("select#search_user").val(search_user);
                jQuery("select#search_visitor").val(search_visitor);
                jQuery("input#id").val(id);
                jQuery("span#popup_title").html(title_string);
                jQuery("div#full_background").css("display", "block");
                jQuery("div#popup_main").slideDown('slow');
            }

            function closePopup() {
                jQuery("div#popup_main").slideUp('slow');
                setTimeout(function () {
                    jQuery("div#full_background").hide();
                }, 700);
            }
        </script>
        <?php
            $msgkey = WPJOBPORTALincluder::getJSModel('fieldordering')->getMessagekey();
            WPJOBPORTALMessages::getLayoutMessage($msgkey);
            $search_combo = array(
                (object) array('id' => 0, 'text' => __('Search Fields', 'wp-job-portal')),
                (object) array('id' => 1, 'text' => __('All Fields', 'wp-job-portal')));
        ?>
        <!-- top bar -->
        <div id="wpjobportal-wrapper-top">
            <div id="wpjobportal-wrapper-top-left">
                <div id="wpjobportal-breadcrumbs">
                    <ul>
                        <li>
                            <a href="<?php echo esc_url(admin_url('admin.php?page=wpjobportal')); ?>" title="<?php echo __('dashboard','wp-job-portal'); ?>">
                                <?php echo __('Dashboard','wp-job-portal'); ?>
                            </a>
                        </li>
                        <li><?php echo __('Search Fields','wp-job-portal'); ?></li>
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
                    }elseif(wpjobportal::$_data['fieldfor'] == 2){
                        echo __('Job','wp-job-portal');
                    }elseif(wpjobportal::$_data['fieldfor'] == 3){
                        echo __('Resume','wp-job-portal');
                    }
                    echo ' '.__('Search Fields', 'wp-job-portal');
                ?>
            </h1>
        </div>
        <!-- page content -->
        <div id="wpjobportal-admin-wrapper" class="p0 bg-n bs-n">
            <!-- filter form -->
            <?php $ff = wpjobportal::$_data["fieldfor"]; ?>
            <form class="wpjobportal-filter-form" name="wpjobportalform" id="wpjobportalform" method="post" action="<?php echo admin_url("admin.php?page=wpjobportal_fieldordering&wpjobportallt=searchfields&ff=$ff"); ?>">
                <?php echo wp_kses(WPJOBPORTALformfield::select('search', $search_combo, wpjobportal::$_data['filter']['search'], '', array('class' => 'inputbox wpjobportal-form-select-field')),WPJOBPORTAL_ALLOWED_TAGS); ?>
                <?php echo wp_kses(WPJOBPORTALformfield::submitbutton('btnsubmit', __('Go', 'wp-job-portal'), array('class' => 'button wpjobportal-form-search-btn')),WPJOBPORTAL_ALLOWED_TAGS); ?>
                <?php echo wp_kses(WPJOBPORTALformfield::hidden('fieldfor', wpjobportal::$_data['fieldfor']),WPJOBPORTAL_ALLOWED_TAGS); ?>
            </form>
            <?php
                if (!empty(wpjobportal::$_data[0])) {
                    ?>
                    <form  id="wpjobportal-form" class="search-fields-form" method="post" action="<?php echo esc_url(admin_url("admin.php?page=wpjobportal_fieldordering&action=wpjobportaltask&task=savesearchfieldorderingFromForm&fieldfor=$ff&ff=$ff")); ?>">
                        <table id="wpjobportal-table" class="wpjobportal-table">
                            <thead>
                                <tr>
                                    <th class="wpjobportal-text-left">
                                        <?php echo __('Title', 'wp-job-portal'); ?>
                                    </th>
                                    <th class="search_combo">
                                        <?php echo __('User Search', 'wp-job-portal'); ?>
                                    </th>
                                    <th class="search_combo">
                                        <?php echo __('Visitor Search', 'wp-job-portal'); ?>
                                    </th>
                                    <th>
                                        <?php echo __('Edit', 'wp-job-portal'); ?>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    for ($i = 0, $n = count(wpjobportal::$_data[0]); $i < $n; $i++) {
                                        $row = wpjobportal::$_data[0][$i];
                                        ?>
                                        <tr id="id_<?php echo esc_attr($row->id); ?>" >
                                            <td class="wpjobportal-text-left" style="cursor:grab;">
                                                <?php echo esc_html(__($row->fieldtitle,'wp-job-portal')); ?>
                                            </td>
                                            <td>
                                                <?php if($row->search_user == 1){ ?>
                                                    <img src="<?php echo WPJOBPORTAL_PLUGIN_URL; ?>includes/images/control_panel/dashboard/good.png" alt="<?php echo __('published', 'wp-job-portal'); ?>" />
                                                <?php } else { ?>
                                                    <img src="<?php echo WPJOBPORTAL_PLUGIN_URL; ?>includes/images/control_panel/dashboard/close.png" alt="<?php echo __('unpublished', 'wp-job-portal'); ?>" />
                                                <?php } ?>
                                            </td>
                                            <td>
                                                <?php if($row->search_visitor == 1){ ?>
                                                    <img src="<?php echo WPJOBPORTAL_PLUGIN_URL; ?>includes/images/control_panel/dashboard/good.png" alt="<?php echo __('published', 'wp-job-portal'); ?>" />
                                                <?php } else { ?>
                                                    <img src="<?php echo WPJOBPORTAL_PLUGIN_URL; ?>includes/images/control_panel/dashboard/close.png" alt="<?php echo __('unpublished', 'wp-job-portal'); ?>" />
                                                <?php } ?>
                                            </td>
                                            <td>
                                                <a class="wpjobportal-table-act-btn" href="#" onclick="showPopupAndSetValues(<?php echo esc_js($row->id); ?>,'<?php echo esc_js(__($row->fieldtitle,'wp-job-portal'));?>', <?php echo esc_js($row->search_user);?>, <?php echo esc_js($row->search_visitor);?>)" title="<?php echo __('edit', 'wp-job-portal'); ?>">
                                                    <img src="<?php echo WPJOBPORTAL_PLUGIN_URL; ?>includes/images/control_panel/dashboard/edit.png" alt="<?php echo __('edit', 'wp-job-portal'); ?>">
                                                </a>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                ?>
                            </tbody>
                        </table>
                        <?php echo wp_kses(WPJOBPORTALformfield::hidden('form_request', 'wpjobportal'),WPJOBPORTAL_ALLOWED_TAGS); ?>
                        <?php echo wp_kses(WPJOBPORTALformfield::hidden('fieldfor', wpjobportal::$_data['fieldfor']),WPJOBPORTAL_ALLOWED_TAGS); ?>
                        <?php echo wp_kses(WPJOBPORTALformfield::hidden('fields_ordering_new',''),WPJOBPORTAL_ALLOWED_TAGS); ?>
                        <div class="wpjobportal-filter-form-action-wrp">
                            <a class="wpjobportal-form-canc-btn" id="form-cancel-button" href="<?php echo esc_url(admin_url('admin.php?page=wpjobportal_fieldordering&ff='.wpjobportal::$_data['fieldfor'])); ?>" title="<?php echo __('cancel', 'wp-job-portal'); ?>">
                                <?php echo __('Cancel', 'wp-job-portal'); ?>
                            </a>
                            <?php echo wp_kses(WPJOBPORTALformfield::submitbutton('save', __('Save','wp-job-portal') .' '. __('Ordering', 'wp-job-portal'), array('class' => 'button wpjobportal-form-act-btn')),WPJOBPORTAL_ALLOWED_TAGS); ?>
                        </div>
                    </form>
                    <?php
                }
            ?>
        </div>
    </div>
</div>
