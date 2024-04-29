<?php
if (!defined('ABSPATH'))
    die('Restricted Access');
?>
<div class="wjportal-main-up-wrapper">
<?php
if(!WPJOBPORTALincluder::getTemplate('templates/header',array('module' => 'resume'))){
    return;
}
if (wpjobportal::$_error_flag == null) { ?>
    <div class="wjportal-main-wrapper wjportal-clearfix">
        <div class="wjportal-page-header">
            <div class="wjportal-page-header-cnt">
                <?php
                    WPJOBPORTALincluder::getTemplate('templates/pagetitle',array('module' => 'resumesearch','layout'=>'resumelist'));
                ?>
            </div>
            <div class="wjportal-header-actions">
            <?php
                $image1 = WPJOBPORTAL_PLUGIN_URL . "includes/images/sort-up.png";
                $image2 = WPJOBPORTAL_PLUGIN_URL . "includes/images/sort-down.png";
                if (wpjobportal::$_data['sortby'] == 1) {
                    $image = $image1;
                } else {
                    $image = $image2;
                }
                $categoryarray = array(
                    (object) array('id' => 1, 'text' => __('Application title', 'wp-job-portal')),
                    (object) array('id' => 2, 'text' => __('First name', 'wp-job-portal')),
                    (object) array('id' => 3, 'text' => __('Category', 'wp-job-portal')),
                    (object) array('id' => 4, 'text' => __('Job type', 'wp-job-portal')),
                    (object) array('id' => 5, 'text' => __('Location', 'wp-job-portal')),
                    (object) array('id' => 6, 'text' => __('Created', 'wp-job-portal'))
                );
            // resume filters
                WPJOBPORTALincluder::getTemplate('resume/views/frontend/filter',array(
                    'sortbylist' => $categoryarray,
                    'filter' => 'resume',
                    'image' => $image,
                    'image1' => $image1,
                    'image2' => $image2
                ));
            ?>
            </div>
        </div>
        <?php
            if (isset(wpjobportal::$_data['fromtags'])) {
                $heading = __('Resumes By Tag', 'wp-job-portal') . ' [' . wpjobportal::$_data['fromtags'] . ']';
            }else {
                $heading = __('Resumes', 'wp-job-portal');
            }
        ?>
        <div class="wjportal-resume-list-wrp">
        <?php
            //Resume Search Save addons
            if(in_array('resumesearch', wpjobportal::$_active_addons)){
                do_action('wpjobportal_addons_resume_search_save_form');
            }
            if (isset(wpjobportal::$_data[0]) && !empty(wpjobportal::$_data[0])) {?>
                <form id="resume_form" method="post" action="<?php echo esc_url(wpjobportal::makeUrl(array('wpjobportalme'=>'resume','wpjobportallt'=>'resumes','wpjobportalpageid' =>wpjobportal::getPageid()))); ?>">
                <?php
                foreach (wpjobportal::$_data[0] AS $myresume) {
                    //Load Template View Resume
                    WPJOBPORTALincluder::getTemplate('resume/views/frontend/resumelist',array(
                        'module' => 'resume',
                        'myresume' => $myresume,
                        'percentage' => '',
                        'control' => ''
                    ));
                }
                if (wpjobportal::$_data[1]) {
                    WPJOBPORTALincluder::getTemplate('templates/pagination',array('module' => 'resume','pagination' => wpjobportal::$_data[1]));
                }
                echo wp_kses(WPJOBPORTALformfield::hidden('sortby', wpjobportal::$_data['sortby']),WPJOBPORTAL_ALLOWED_TAGS);
                echo wp_kses(WPJOBPORTALformfield::hidden('sorton', wpjobportal::$_data['sorton']),WPJOBPORTAL_ALLOWED_TAGS);
                echo wp_kses(WPJOBPORTALformfield::hidden('WPJOBPORTAL_form_search', 'WPJOBPORTAL_SEARCH'),WPJOBPORTAL_ALLOWED_TAGS);
                echo wp_kses(WPJOBPORTALformfield::hidden('wpjobportallay', 'resumes'),WPJOBPORTAL_ALLOWED_TAGS);
                echo wp_kses(WPJOBPORTALformfield::hidden('resume_filter', isset(wpjobportal::$_data['filter']) ? wpjobportalphplib::wpJP_safe_encoding(json_encode(wpjobportal::$_data['filter'])) : ''),WPJOBPORTAL_ALLOWED_TAGS);

                ?>
                </form>
                <?php
            } else {
                WPJOBPORTALlayout::getNoRecordFound();
            }
        }
    ?>
</div>
</div>


