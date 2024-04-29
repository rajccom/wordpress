<?php
if (!defined('ABSPATH'))
die('Restricted Access');
wp_enqueue_script('wpjobportal-res-tables', WPJOBPORTAL_PLUGIN_URL . 'includes/js/responsivetable.js');
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
        <?php  WPJOBPORTALincluder::getClassesInclude('wpjobportaladminsidemenu'); ?>
    </div>
    <div id="wpjobportaladmin-data">
        <?php
            $msgkey = WPJOBPORTALincluder::getJSModel('currency')->getMessagekey();
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
                        <li><?php echo __('Currency','wp-job-portal'); ?></li>
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
        <?php WPJOBPORTALincluder::getTemplate('templates/admin/pagetitle',array('module' => 'currency' , 'layouts' => 'currency')) ?>
        <!-- page content -->
        <div id="wpjobportal-admin-wrapper" class="p0 bg-n bs-n">
            <!-- quick actions -->
            <div id="wpjobportal-page-quick-actions">
                <a class="wpjobportal-page-quick-act-btn multioperation" message="<?php echo esc_attr(WPJOBPORTALMessages::getMSelectionEMessage()); ?>" data-for="publish" href="#" title="<?php echo __('publish', 'wp-job-portal') ?>">
                    <img src="<?php echo WPJOBPORTAL_PLUGIN_URL; ?>includes/images/control_panel/dashboard/good.png" alt="<?php echo __('publish', 'wp-job-portal') ?>" />
                    <?php echo __('Publish', 'wp-job-portal') ?>
                </a>
                <a class="wpjobportal-page-quick-act-btn multioperation" message="<?php echo esc_attr(WPJOBPORTALMessages::getMSelectionEMessage()); ?>" data-for="unpublish" href="#" title="<?php echo __('unpublish', 'wp-job-portal') ?>">
                    <img src="<?php echo WPJOBPORTAL_PLUGIN_URL; ?>includes/images/control_panel/dashboard/close.png" alt="<?php echo __('unpublish', 'wp-job-portal') ?>" />
                    <?php echo __('Unpublish', 'wp-job-portal') ?>
                </a>
                <a class="wpjobportal-page-quick-act-btn multioperation" message="<?php echo esc_attr(WPJOBPORTALMessages::getMSelectionEMessage()); ?>" confirmmessage="<?php echo __('Are you sure to delete','wp-job-portal') . ' ?'; ?>" data-for="remove" href="#" title="<?php echo __('delete', 'wp-job-portal') ?>">
                    <img src="<?php echo WPJOBPORTAL_PLUGIN_URL; ?>includes/images/control_panel/dashboard/forced-delete.png" alt="<?php echo __('delete', 'wp-job-portal') ?>" />
                    <?php echo __('Delete', 'wp-job-portal') ?>
                </a>
            </div>
            <script>
                function resetFrom() {
                    jQuery("input#title").val('');
                    jQuery("input#code").val('');
                    jQuery("select#status").val('');
                    jQuery("form#wpjobportalform").submit();
                }
            </script>
            <!-- filter form -->
            <form class="wpjobportal-filter-form" name="wpjobportalform" id="wpjobportalform" method="post" action="<?php echo admin_url("admin.php?page=wpjobportal_currency"); ?>">
                <?php echo wp_kses(WPJOBPORTALformfield::text('title', wpjobportal::$_data['filter']['title'], array('class' => 'inputbox wpjobportal-form-input-field', 'placeholder' => __('Title', 'wp-job-portal'))),WPJOBPORTAL_ALLOWED_TAGS); ?>
                <?php echo wp_kses(WPJOBPORTALformfield::text('code', wpjobportal::$_data['filter']['code'], array('class' => 'inputbox wpjobportal-form-input-field', 'placeholder' => __('Currency Code', 'wp-job-portal'))),WPJOBPORTAL_ALLOWED_TAGS); ?>
                <?php echo wp_kses(WPJOBPORTALformfield::select('status', WPJOBPORTALincluder::getJSModel('common')->getstatus(), is_numeric(wpjobportal::$_data['filter']['status']) ? wpjobportal::$_data['filter']['status'] : '', __('Select Status', 'wp-job-portal'), array('class' => 'inputbox wpjobportal-form-select-field')),WPJOBPORTAL_ALLOWED_TAGS); ?>
                <?php echo wp_kses(WPJOBPORTALformfield::hidden('WPJOBPORTAL_form_search', 'WPJOBPORTAL_SEARCH'),WPJOBPORTAL_ALLOWED_TAGS); ?>
                <?php echo wp_kses(WPJOBPORTALformfield::submitbutton('btnsubmit', __('Search', 'wp-job-portal'), array('class' => 'button wpjobportal-form-search-btn')),WPJOBPORTAL_ALLOWED_TAGS); ?>
                <?php echo wp_kses(WPJOBPORTALformfield::button('reset', __('Reset', 'wp-job-portal'), array('class' => 'button wpjobportal-form-reset-btn', 'onclick' => 'resetFrom();')),WPJOBPORTAL_ALLOWED_TAGS); ?>

                <?php echo wp_kses(WPJOBPORTALformfield::select('pagesize', array((object) array('id'=>20,'text'=>20), (object) array('id'=>50,'text'=>50), (object) array('id'=>100,'text'=>100)), wpjobportal::$_data['filter']['pagesize'],__("Records per page",'wp-job-portal'), array('class' => ' wpjobportal-form-select-field wpjobportal-right','onchange'=>'document.wpjobportalform.submit();')),WPJOBPORTAL_ALLOWED_TAGS);?>

            </form>
            <?php
                if (!empty(wpjobportal::$_data[0])) {
                    ?>
                    <form id="wpjobportal-list-form" method="post" action="<?php echo admin_url("admin.php?page=wpjobportal_currency&task=saveordering"); ?>">
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
                                        <?php echo __('Title', 'wp-job-portal'); ?>
                                    </th>
                                    <th>
                                        <?php echo __('Currency', 'wp-job-portal'); ?>
                                    </th>
                                    <th>
                                        <?php echo __('Code', 'wp-job-portal'); ?>
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
                                    $islastordershow = WPJOBPORTALpagination::isLastOrdering(wpjobportal::$_data['total'], $pagenum);
                                    for ($i = 0, $n = count(wpjobportal::$_data[0]); $i < $n; $i++) {
                                        $row = wpjobportal::$_data[0][$i];
                                        $upimg = 'uparrow.png';
                                        $downimg = 'downarrow.png';
                                        ?>
                                        <tr id="id_<?php echo esc_attr($row->id);?>">
                                            <td>
                                                <input type="checkbox" class="wpjobportal-cb" id="wpjobportal-cb" name="wpjobportal-cb[]" value="<?php echo esc_attr($row->id); ?>" />
                                            </td>

                                            <td class="wpjobportal-order-grab-column">
                                                  <img alt="<?php echo __('grab','wp-job-portal'); ?>" src="<?php echo WPJOBPORTAL_PLUGIN_URL . 'includes/images/list-full.png'?>"/>
                                            </td>

                                            <td class="wpjobportal-text-left">
                                                <a href="<?php echo esc_url(admin_url('admin.php?page=wpjobportal_currency&wpjobportallt=formcurrency&wpjobportalid='.$row->id)); ?>" title="<?php echo __('title', 'wp-job-portal'); ?>">
                                                    <?php echo esc_html(__($row->title,'wp-job-portal')); ?>
                                                </a>
                                            </td>
                                            <td>
                                                <?php echo esc_html($row->symbol); ?>
                                            </td>
                                            <td>
                                                <?php echo esc_html($row->code); ?>
                                            </td>
                                            <td>
                                                <?php if ($row->default == 1) { ?>
                                                    <img src="<?php echo WPJOBPORTAL_PLUGIN_URL; ?>includes/images/default.png" alt="Default" border="0" alt="<?php echo __('default', 'wp-job-portal'); ?>" />
                                                <?php } else { ?>
                                                    <a href="<?php echo esc_url(admin_url('admin.php?page=wpjobportal_common&task=makedefault&action=wpjobportaltask&for=currencies&id='.$row->id.$pageid)); ?>" title="<?php echo __('not default', 'wp-job-portal'); ?>">
                                                        <img src="<?php echo WPJOBPORTAL_PLUGIN_URL; ?>includes/images/notdefault.png" border="0" alt="<?php echo __('not default', 'wp-job-portal'); ?>" />
                                                    </a>
                                                <?php } ?>
                                            </td>
                                            <td>
                                                <?php if ($row->status == 1) { ?>
                                                    <a href="<?php echo esc_url(admin_url('admin.php?page=wpjobportal_currency&task=unpublish&action=wpjobportaltask&wpjobportal-cb[]='.$row->id.$pageid)); ?>" title="<?php echo __('published', 'wp-job-portal'); ?>">
                                                        <img src="<?php echo WPJOBPORTAL_PLUGIN_URL; ?>includes/images/control_panel/dashboard/good.png" border="0" alt="<?php echo __('published', 'wp-job-portal'); ?>" />
                                                    </a>
                                                <?php } else { ?>
                                                    <a href="<?php echo esc_url(admin_url('admin.php?page=wpjobportal_currency&task=publish&action=wpjobportaltask&wpjobportal-cb[]='.$row->id.$pageid)); ?>" title="<?php echo __('not published', 'wp-job-portal'); ?>">
                                                        <img src="<?php echo WPJOBPORTAL_PLUGIN_URL; ?>includes/images/control_panel/dashboard/close.png" border="0" alt="<?php echo __('not published', 'wp-job-portal'); ?>" />
                                                    </a>
                                                <?php } ?>
                                            </td>
                                            <td>
                                                <a class="wpjobportal-table-act-btn" href="<?php echo esc_url(admin_url('admin.php?page=wpjobportal_currency&wpjobportallt=formcurrency&wpjobportalid='.$row->id)); ?>" title="<?php echo __('edit', 'wp-job-portal'); ?>">
                                                    <img src="<?php echo WPJOBPORTAL_PLUGIN_URL; ?>includes/images/control_panel/dashboard/edit.png" alt="<?php echo __('edit', 'wp-job-portal'); ?>">
                                                </a>
                                                <a class="wpjobportal-table-act-btn" href="<?php echo esc_url(wp_nonce_url(admin_url('admin.php?page=wpjobportal_currency&task=remove&action=wpjobportaltask&wpjobportal-cb[]='.$row->id),'delete-currency')); ?>" onclick='return confirmdelete("<?php echo __('Are you sure to delete', 'wp-job-portal').' ?'; ?>");' title="<?php echo __('delete', 'wp-job-portal'); ?>">
                                                    <img src="<?php echo WPJOBPORTAL_PLUGIN_URL; ?>includes/images/control_panel/dashboard/delete.png" alt="<?php echo __('delete', 'wp-job-portal'); ?>">
                                                </a>
                                            </td>
                                        </tr>
                                    <?php
                                    }
                                ?>
                            </tbody>
                        </table>
                        <?php echo wp_kses(WPJOBPORTALformfield::hidden('action', 'currency_remove'),WPJOBPORTAL_ALLOWED_TAGS); ?>
                        <?php echo wp_kses(WPJOBPORTALformfield::hidden('pagenum', ($pagenum > 1) ? $pagenum : ''),WPJOBPORTAL_ALLOWED_TAGS); ?>
                        <?php echo wp_kses(WPJOBPORTALformfield::hidden('task', ''),WPJOBPORTAL_ALLOWED_TAGS); ?>
                        <?php echo wp_kses(WPJOBPORTALformfield::hidden('form_request', 'wpjobportal'),WPJOBPORTAL_ALLOWED_TAGS); ?>
                        <?php echo wp_kses(WPJOBPORTALformfield::hidden('_wpnonce', wp_create_nonce('delete-currency')),WPJOBPORTAL_ALLOWED_TAGS); ?>
                        <?php echo wp_kses(WPJOBPORTALformfield::hidden('fields_ordering_new', '123'),WPJOBPORTAL_ALLOWED_TAGS); ?>

                        <div class="wpjobportal-saveorder-wrp" style="display: none;">
                        <?php echo wp_kses(WPJOBPORTALformfield::submitbutton('save', __('Save Ordering', 'wp-job-portal'), array('class' => 'button wpjobportal-form-act-btn')),WPJOBPORTAL_ALLOWED_TAGS); ?>
                        </div>

                    </form>
                <?php
                    if (wpjobportal::$_data[1]) {
                        echo '<div class="tablenav"><div class="tablenav-pages">' . wp_kses_post(wpjobportal::$_data[1]) . '</div></div>';
                    }
                    } else {
                $msg = __('No record found','wp-job-portal');
                $link[] = array(
                            'link' => 'admin.php?page=wpjobportal_currency&wpjobportallt=formcurrency',
                            'text' => __('Add New','wp-job-portal') .' '. __('Currency','wp-job-portal')
                        );
                WPJOBPORTALlayout::getNoRecordFound($msg,$link);
                }
            ?>
        </div>
    </div>
</div>
