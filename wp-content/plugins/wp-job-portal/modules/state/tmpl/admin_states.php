<?php if (!defined('ABSPATH')) die('Restricted Access'); ?>
<script >
    function confirmdelete() {
        if (confirm("<?php echo __('Are you sure to delete','wp-job-portal') . ' ?'; ?>") == true) {
            return false;
        } else {
            event.preventDefualt();
            return false;
        }
        return false;
    }

    function resetFrom() {
        jQuery("input#searchname").val('');
        jQuery("select#status").val('');
        jQuery("#city1").prop('checked', false);
        jQuery("form#wpjobportalform").submit();
    }

</script>
<?php
    wp_enqueue_script('wpjobportal-res-tables', WPJOBPORTAL_PLUGIN_URL . 'includes/js/responsivetable.js');
    if (!WPJOBPORTALincluder::getTemplate('templates/admin/header',array('module' => 'state'))){
        return;
    }
?>
<!-- main wrapper -->
<div id="wpjobportaladmin-wrapper">
    <!-- left menu -->
    <div id="wpjobportaladmin-leftmenu">
        <?php  WPJOBPORTALincluder::getTemplate('templates/admin/leftmenue',array('module' => 'state')); ?>
    </div>
    <div id="wpjobportaladmin-data">
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
                        <li><?php echo __('States','wp-job-portal'); ?></li>
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
        <?php  WPJOBPORTALincluder::getTemplate('templates/admin/pagetitle',array('module' => 'state','layouts' => 'state')); ?>
        <!-- page content -->
        <div id="wpjobportal-admin-wrapper" class="p0 bg-n bs-n">
            <!-- quick actions -->
            <?php WPJOBPORTALincluder::getTemplate('state/views/multioperation'); ?>
            <!-- filter form -->
            <form class="wpjobportal-filter-form" name="wpjobportalform" id="wpjobportalform" method="post" action="<?php echo admin_url("admin.php?page=wpjobportal_state&wpjobportallt=states"); ?>">
                <?php WPJOBPORTALincluder::getTemplate('state/views/filter'); ?>
            </form>
            <?php
                if (!empty(wpjobportal::$_data[0])) {
                    ?>
                    <form id="wpjobportal-list-form" method="post" action="<?php echo admin_url("admin.php?page=wpjobportal_state"); ?>">
                        <table id="wpjobportal-table" class="wpjobportal-table">
                            <thead>
                                <tr>
                                    <th>
                                        <input type="checkbox" name="selectall" id="selectall" value="">
                                    </th>
                                    <th>
                                        <?php echo __('Name', 'wp-job-portal'); ?>
                                    </th>
                                    <th>
                                        <?php echo __('Published', 'wp-job-portal'); ?>
                                    </th>
                                    <th>
                                        <?php echo __('Cities', 'wp-job-portal'); ?>
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
                                        $link = admin_url('admin.php?page=wpjobportal_state&wpjobportallt=formstate&wpjobportalid=' . $row->id);
                                        WPJOBPORTALincluder::getTemplate('state/views/main',array('row' => $row,'i' => $i ,'pagenum' => $pagenum ,'n' => $n ,'pageid' => $pageid ,'link' => $link));
                                    }
                                ?>
                            </tbody>
                        </table>
                        <?php echo wp_kses(WPJOBPORTALformfield::hidden('action', 'state_remove'),WPJOBPORTAL_ALLOWED_TAGS); ?>
                        <?php echo wp_kses(WPJOBPORTALformfield::hidden('pagenum', ($pagenum > 1) ? $pagenum : ''),WPJOBPORTAL_ALLOWED_TAGS); ?>
                        <?php echo wp_kses(WPJOBPORTALformfield::hidden('task', ''),WPJOBPORTAL_ALLOWED_TAGS); ?>
                        <?php echo wp_kses(WPJOBPORTALformfield::hidden('form_request', 'wpjobportal'),WPJOBPORTAL_ALLOWED_TAGS); ?>
                        <?php echo wp_kses(WPJOBPORTALformfield::hidden('_wpnonce', wp_create_nonce('delete-state')),WPJOBPORTAL_ALLOWED_TAGS); ?>
                    </form>
                    <?php
                        if (wpjobportal::$_data[1]) {
                            WPJOBPORTALincluder::getTemplate('templates/admin/pagination',array('module' => 'state' , 'pagination' => wpjobportal::$_data[1]));
                        }
                } else {
                    $msg = __('No record found','wp-job-portal');
                    $link[] = array(
                            'link' => 'admin.php?page=wpjobportal_state&wpjobportallt=formstate',
                            'text' => __('Add New','wp-job-portal') .' '. __('State','wp-job-portal')
                        );
                    WPJOBPORTALlayout::getNoRecordFound();
                }
            ?>
        </div>
    </div>
</div>
