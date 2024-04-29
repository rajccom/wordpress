<?php
if (!defined('ABSPATH'))
    die('Restricted Access');
?>
<div class="wjportal-main-up-wrapper">
<?php
wp_enqueue_style('status-graph', WPJOBPORTAL_PLUGIN_URL . 'includes/css/status_graph.css');
if(!WPJOBPORTALincluder::getTemplate('templates/header',array('module'=>'resume'))){
    return;
}
if (wpjobportal::$_error_flag == null) {
    $subtype = wpjobportal::$_config->getConfigValue('submission_type');
    ?>

    <div id="wpjobportal-wrapper">
        <?php
        WPJOBPORTALincluder::getTemplate('templates/pagetitle',array(
            'module' => 'multiresume',
            'layout' => 'multiresumeadd'
        ));

        WPJOBPORTALincluder::getTemplate('resume/views/frontend/filter',array('filter'=>'myresume'));
            $dateformat = wpjobportal::$_configuration['date_format'];
            if (!empty(wpjobportal::$_data[0])) {
                foreach (wpjobportal::$_data[0] AS $myresume) {
                    $status_array = WPJOBPORTALincluder::getJSModel('resume')->getResumePercentage($myresume->id);
                    $percentage = $status_array['percentage'];
                     WPJOBPORTALincluder::getTemplate('resume/views/frontend/resumelist',array(
                        'myresume' => $myresume,
                        'percentage' => $percentage,
                        'control' => 'myresumes',
                        'model'=> 'myresume'
                     ));
            }

        if (wpjobportal::$_data[1]) {
            WPJOBPORTALincluder::getTemplate('templates/pagination',array('module' => 'resume','pagination' => wpjobportal::$_data[1]));
        }
        echo wp_kses(WPJOBPORTALformfield::hidden('sortby', wpjobportal::$_data['sortby']),WPJOBPORTAL_ALLOWED_TAGS);
        echo wp_kses(WPJOBPORTALformfield::hidden('sorton', wpjobportal::$_data['sorton']),WPJOBPORTAL_ALLOWED_TAGS);

    } else {
        $msg = __('No record found','wp-job-portal');
        $links[] = array(
                    'link' => wpjobportal::makeUrl(array('wpjobportalme'=>'resume', 'wpjobportallt'=>'addresume', 'wpjobportalpageid'=>wpjobportal::getPageid())),
                    'text' => __('Add New','wp-job-portal') .' '. __('Resume', 'wp-job-portal')
                );
        WPJOBPORTALlayout::getNoRecordFound($msg,$links);
    }
?>
    </div>
<?php
}else{
    echo wp_kses_post(wpjobportal::$_error_flag_message);
}
?>
</div>
