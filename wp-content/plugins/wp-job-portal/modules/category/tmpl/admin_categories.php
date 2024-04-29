<?php if (!defined('ABSPATH')) die('Restricted Access'); ?>
<script >
    function resetFrom() {
        document.getElementById('searchname').value = '';
        document.getElementById('status').value = '';
        document.getElementById('wpjobportalform').submit();
    }
</script>
<?php
    wp_enqueue_script('wpjobportal-res-tables', WPJOBPORTAL_PLUGIN_URL . 'includes/js/responsivetable.js');
    if (!WPJOBPORTALincluder::getTemplate('templates/admin/header',array('module' => 'category'))){
        return;
    }
?>
<?php 
wp_enqueue_script('jquery-ui-sortable');
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
 wp_enqueue_style('jquery-ui-css', $protocol.'ajax.googleapis.com/ajax/libs/jqueryui/1.8.2/themes/smoothness/jquery-ui.css');
?>
<script type="text/javascript">
 jQuery(document).ready(function () {
        jQuery('table#wpjobportal-table tbody').sortable({ 
            handle : ".wpjobportal-order-grab-column",
            update  : function () {
                jQuery('.wpjobportal-saveorder-wrp').slideDown('slow');
                var abc =  jQuery('table#wpjobportal-table tbody').sortable('serialize');
                jQuery('input#fields_ordering_new').val(abc);
            }
        });
    });
</script>
<!-- main wrapper -->
<div id="wpjobportaladmin-wrapper">
    <!-- left menu -->
    <div id="wpjobportaladmin-leftmenu">
        <?php  WPJOBPORTALincluder::getTemplate('templates/admin/leftmenue',array('module' => 'categories')); ?>
    </div>
    <div id="wpjobportaladmin-data">
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
                        <li><?php echo __('Categories','wp-job-portal'); ?></li>
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
        <?php  WPJOBPORTALincluder::getTemplate('templates/admin/pagetitle',array('module' => 'categories','layouts' => 'categories')); ?>
        <!-- page content -->
        <div id="wpjobportal-admin-wrapper" class="p0 bg-n bs-n">
            <!-- quick actions -->
            <?php  WPJOBPORTALincluder::getTemplate('category/views/multioperation');?>
            <!-- filter form -->
            <form class="wpjobportal-filter-form" name="wpjobportalform" id="wpjobportalform" method="post" action="<?php echo esc_url(admin_url("admin.php?page=wpjobportal_category")); ?>">
                <?php WPJOBPORTALincluder::getTemplate('category/views/filter'); ?>
            </form>
            <?php
                if (!empty(wpjobportal::$_data[0])) {
                    ?>
                    <form id="wpjobportal-list-form" method="post" action="<?php echo esc_url(admin_url("admin.php?page=wpjobportal_category&task=saveordering")); ?>">
                        <table id="wpjobportal-table" class="wpjobportal-table">
                            <thead>
                                <tr>
                                    <th>
                                        <input type="checkbox" name="selectall" id="selectall" value="">
                                    </th>
                                    <th>
                                        <?php echo __('Ordering', 'wp-job-portal'); ?>
                                    </th>
                                    <th class="wpjobportal-text-left">
                                        <?php echo __('Category Title', 'wp-job-portal'); ?>
                                    </th>
                                    <th>
                                        <?php echo __('Default', 'wp-job-portal'); ?>
                                    </th>
                                    <th>
                                        <?php echo __('Published', 'wp-job-portal'); ?>
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
                                    for ($i = 0, $n = count(wpjobportal::$_data[0]); $i < $n; $i++) {
                                        $row = wpjobportal::$_data[0][$i];
                                        $upimg = 'uparrow.png';
                                        $downimg = 'downarrow.png';
                                        WPJOBPORTALincluder::getTemplate('category/views/main',array('row' => $row,'i' => $i ,'pagenum' => $pagenum ,'n' => $n ,'pageid' => $pageid ));
                                    }?>
                            </tbody>
                        </table>
                        <?php echo wp_kses(WPJOBPORTALformfield::hidden('action', 'category_remove'),WPJOBPORTAL_ALLOWED_TAGS); ?>
                        <?php echo wp_kses(WPJOBPORTALformfield::hidden('pagenum', ($pagenum > 1) ? $pagenum : ''),WPJOBPORTAL_ALLOWED_TAGS); ?>
                        <?php echo wp_kses(WPJOBPORTALformfield::hidden('task', ''),WPJOBPORTAL_ALLOWED_TAGS); ?>
                        <?php echo wp_kses(WPJOBPORTALformfield::hidden('form_request', 'wpjobportal'),WPJOBPORTAL_ALLOWED_TAGS); ?>
                        <?php echo wp_kses(WPJOBPORTALformfield::hidden('_wpnonce', wp_create_nonce('delete-category')),WPJOBPORTAL_ALLOWED_TAGS); ?>
                        <?php echo wp_kses(WPJOBPORTALformfield::hidden('fields_ordering_new', '123'),WPJOBPORTAL_ALLOWED_TAGS); ?>

                   <div class="wpjobportal-saveorder-wrp" style="display: none;">
                    <?php echo wp_kses(WPJOBPORTALformfield::submitbutton('save', __('Save Ordering', 'wp-job-portal'), array('class' => 'button wpjobportal-form-act-btn')),WPJOBPORTAL_ALLOWED_TAGS); ?>
                    </div>
                    </form>
                    <?php
                    if (wpjobportal::$_data[1]) {
                        WPJOBPORTALincluder::getTemplate('templates/admin/pagination',array('module' => 'category' , 'pagination' => wpjobportal::$_data[1]));
                    }
                } else {
                    $msg = __('No record found','wp-job-portal');
                    $link[] = array(
                                'link' => 'admin.php?page=wpjobportal_category&wpjobportallt=formcategory',
                                'text' => __('Add New','wp-job-portal') .' '. __('Category','wp-job-portal')
                            );
                    WPJOBPORTALlayout::getNoRecordFound($msg,$link);
                }
            ?>
        </div>
    </div>
</div>
