<?php if (!defined('ABSPATH')) die('Restricted Access'); ?>
<script >
    function resetFrom() {
        document.getElementById('searchname').value = '';
        document.getElementById('searchusername').value = '';
        document.getElementById('wpjobportalform').submit();
    }
</script>
<div id="wpjobportaladmin-wrapper">
	<div id="wpjobportaladmin-leftmenu">
        <?php  WPJOBPORTALincluder::getClassesInclude('wpjobportaladminsidemenu'); ?>
    </div>
    <div id="wpjobportaladmin-data">
    <?php wpjobportal::$_data['filter']['categoryid'] = 0; ?>
    <span class="js-admin-title">
        <a href="<?php echo admin_url('admin.php?page=wpjobportal'); ?>"><img src="<?php echo WPJOBPORTAL_PLUGIN_URL; ?>includes/images/back-icon.png" /></a>
        <?php echo __('User Stats', 'wp-job-portal') ?>
    </span>
    <form class="js-filter-form" name="wpjobportalform" id="wpjobportalform" method="post" action="<?php echo admin_url("admin.php?page=wpjobportal_user&wpjobportallt=userstats"); ?>">
        <?php echo wp_kses(WPJOBPORTALformfield::text('searchname', wpjobportal::$_data['filter']['searchname'], array('class' => 'inputbox', 'placeholder' => __('Name', 'wp-job-portal'))),WPJOBPORTAL_ALLOWED_TAGS); ?>
        <?php echo wp_kses(WPJOBPORTALformfield::text('searchusername', wpjobportal::$_data['filter']['searchusername'], array('class' => 'inputbox', 'placeholder' => __('Word Press user login', 'wp-job-portal'))),WPJOBPORTAL_ALLOWED_TAGS); ?>
        <?php echo wp_kses(WPJOBPORTALformfield::hidden('WPJOBPORTAL_form_search', 'WPJOBPORTAL_SEARCH'),WPJOBPORTAL_ALLOWED_TAGS); ?>
        <?php echo wp_kses(WPJOBPORTALformfield::submitbutton('btnsubmit', __('Search', 'wp-job-portal'), array('class' => 'button')),WPJOBPORTAL_ALLOWED_TAGS); ?>
        <?php echo wp_kses(WPJOBPORTALformfield::button('reset', __('Reset', 'wp-job-portal'), array('class' => 'button', 'onclick' => 'resetFrom();')),WPJOBPORTAL_ALLOWED_TAGS); ?>
    </form>
    <?php
    if (!empty(wpjobportal::$_data[0])) {
        ?>
        <table id="js-table">
            <thead>
                <tr>
                    <th class="left-row"><?php echo __('Name', 'wp-job-portal'); ?></th>
                    <th><?php echo __('Username', 'wp-job-portal'); ?></th>
                    <th><?php echo __('Company', 'wp-job-portal'); ?></th>
                    <th><?php echo __('Resume', 'wp-job-portal'); ?></th>
                    <th><?php echo __('Companies', 'wp-job-portal'); ?></th>
                    <th><?php echo __('Jobs', 'wp-job-portal'); ?></th>
                    <th><?php echo __('Resume', 'wp-job-portal'); ?></th>
                </tr>
            </thead>
            <tbody>
                <?php
                $k = 0;
                for ($i = 0, $n = count(wpjobportal::$_data[0]); $i < $n; $i++) {
                    $row = wpjobportal::$_data[0][$i];
                    ?>
                    <tr>
                        <td><?php echo esc_html($row->name); ?></td>
                        <td><?php echo esc_html($row->username); ?>	</td>
                        <td><?php echo esc_html($row->companyname); ?>	</td>
                        <td><?php echo esc_html($row->resumename); ?>	</td>

                        <?php if ($row->rolefor == 1) { // employer ?>
                            <td><a href="<?php echo admin_url('admin.php?page=wpjobportal_user&wpjobportallt=userstate_companies&md='.$row->id); ?>"><strong><?php echo esc_html($row->companies); ?></strong></a></td>
                            <td><a href="<?php echo admin_url('admin.php?page=wpjobportal_user&wpjobportallt=userstate_jobs&bd='.$row->id); ?>"><strong><?php echo esc_html($row->jobs); ?></a></strong></td>
                            <td><strong>-</strong></td>
                        <?php } elseif ($row->rolefor == 2) { //jobseeker ?>
                            <td><strong>-</strong></td>
                            <td><strong>-</strong></td>
                            <td><a href="<?php echo admin_url('admin.php?page=wpjobportal_user&wpjobportallt=userstate_resumes&ruid='.$row->id); ?>"><strong><?php echo esc_html($row->resumes); ?></a></strong></td>
                        <?php } else { ?>
                            <td><strong>-</strong></td>
                            <td><strong>-</strong></td>
                            <td><strong>-</strong></td>
                        <?php } ?>
                    </tr>
                    <?php
                }
                ?>
            </tbody>
        </table>
        <?php
        if (wpjobportal::$_data[1]) {
            echo '<div class="tablenav"><div class="tablenav-pages">' . wp_kses_post(wpjobportal::$_data[1]) . '</div></div>';
        }
    } else {
        $msg = __('No record found','wp-job-portal');
        WPJOBPORTALlayout::getNoRecordFound($msg);
    }
    ?>
    </div>
</div>
