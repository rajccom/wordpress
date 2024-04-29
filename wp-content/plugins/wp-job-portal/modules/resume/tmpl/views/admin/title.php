<?php
/**
* @param WP JOB PORTAL
* @param Resume Detail
*/
?>
<div class="wpjobportal-resume-cnt-wrp">
    <div class="wpjobportal-resume-middle-wrp">
        <div class="wpjobportal-resume-data">
            <span class="wpjobportal-resume-job-type" style="background-color: <?php echo esc_attr($resume->color); ?>" >
                <?php echo __(esc_html($resume->jobtypetitle),'wp-job-portal'); ?>
            </span>
        </div>
        <div class="wpjobportal-resume-data">
            <span class="wpjobportal-resume-name">
                <a href="<?php echo esc_url(admin_url("admin.php?page=wpjobportal_resume&wpjobportallt=formresume&wpjobportalid=".$resume->id));?>"> 
                    <?php echo esc_html($resume->application_title); ?> 
                </a>
            </span>
            <?php
                if ($resume->status == 0) {
                    echo '<span class="wpjobportal-item-status pending">' . __('Pending', 'wp-job-portal') . '</span>';
                } elseif ($resume->status == 1) {
                    echo '<span class="wpjobportal-item-status approved">' . __('Approved', 'wp-job-portal') . '</span>';
                } elseif ($resume->status == -1) {
                    echo '<span class="wpjobportal-item-status rejected">' . __('Rejected', 'wp-job-portal') . '</span>';
                } elseif ($resume->status == 3) {
                    echo '<span class="wpjobportal-item-status rejected">' . __('Pending Payment', 'wp-job-portal') . '</span>';
                }
            ?>
        </div>
        <div class="wpjobportal-resume-data wpjobportal-resume-catgry">
            <?php echo __(esc_html($resume->cat_title),'wp-job-portal'); ?>
        </div>
        <div class="wpjobportal-resume-data">
            <div class="wpjobportal-resume-data-text">
                <span class="wpjobportal-resume-data-title">
                    <?php 
                        if(!isset(wpjobportal::$_data['fields']['salaryfixed'])){
                            wpjobportal::$_data['fields']['salaryfixed'] = WPJOBPORTALincluder::getJSModel('fieldordering')->getFieldTitleByFieldAndFieldfor('salaryfixed',3);
                        }                                    
                        echo __(esc_html(wpjobportal::$_data['fields']['salaryfixed']), 'wp-job-portal') . ': '; 
                    ?>
                </span>
                <span class="wpjobportal-resume-data-value">
                    <?php
                        echo __(esc_html($resume->salaryfixed),'wp-job-portal');
                    ?>
                </span>
            </div>
            <?php if(in_array('advanceresumebuilder', wpjobportal::$_active_addons)){ ?>
                <div class="wpjobportal-resume-data-text">
                    <span class="wpjobportal-resume-data-title">
                        <?php echo __('Total Experience', 'wp-job-portal') . ' : '; ?>
                    </span>
                    <span class="wpjobportal-resume-data-value">
                        <?php echo esc_html(wpjobportal::$_common->getTotalExp($resume->resumeid)); ?>
                    </span>
                </div>            
                <div class="wpjobportal-resume-data-text">
                    <span class="wpjobportal-resume-data-title">
                        <?php echo __('Location', 'wp-job-portal') . ' : '; ?>
                    </span>
                    <span class="wpjobportal-resume-data-value">
                        <?php echo esc_html(WPJOBPORTALincluder::getJSModel('city')->getLocationDataForView($resume->city)); ?>
                    </span>
                </div>
            <?php } else { ?>
                <div class="wpjobportal-resume-data-text">
                    <span class="wpjobportal-resume-data-title">
                        <?php echo __('Category', 'wp-job-portal') . ' : '; ?>
                    </span>
                    <span class="wpjobportal-resume-data-value">
                        <?php echo __(esc_html($resume->cat_title), 'wp-job-portal'); ?>
                    </span>
                </div>
            <?php } ?>
        </div>
    </div>
</div>


