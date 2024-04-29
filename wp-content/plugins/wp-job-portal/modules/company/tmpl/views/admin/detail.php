<?php
/**
* @param Detail Body
* wpjobportalPopupAdmin
*/
?>
<div class="wpjobportal-company-cnt-wrp">
    <div class="wpjobportal-company-middle-wrp">
        <div class="wpjobportal-company-data">
           <a class="wpjobportal-company-name" href="<?php echo esc_url(admin_url('admin.php?page=wpjobportal_company&wpjobportallt=formcompany&wpjobportalid='.$company->id)); ?>">
                <?php echo esc_html($company->name); ?>
            </a> 
        </div>
        <div class="wpjobportal-company-data wpjobportal-company-desc">
            <?php echo isset($company->description) ? wp_kses($company->description, WPJOBPORTAL_ALLOWED_TAGS) : ''; ?>
        </div>
        <div class="wpjobportal-company-data">
            <div class="wpjobportal-company-data-text">
                <span class="wpjobportal-company-data-title">
                    <?php echo __('Location','wp-job-portal'). ' : '; ?>
                </span>
                <span class="wpjobportal-company-data-value">
                    <?php echo esc_html(WPJOBPORTALincluder::getJSModel('city')->getLocationDataForView($company->city)); ?>
                </span>
            </div>
        </div>
    </div>
    <div class="wpjobportal-company-right-wrp">
        <div class="wpjobportal-company-status">
            <?php
                if ($company->status == 0) {
                    echo '<span class="wpjobportal-company-status-txt pending">' . __('Pending', 'wp-job-portal') . '</span>';
                } elseif ($company->status == 1) {
                    echo '<span class="wpjobportal-company-status-txt approved">' . __('Approved', 'wp-job-portal') . '</span>';
                } elseif ($company->status == -1) {
                    echo '<span class="wpjobportal-company-status-txt rejected">' . __('Rejected', 'wp-job-portal') . '</span>';
                }elseif ($company->status == 3) {
                    echo '<span class="wpjobportal-company-status-txt pending-payment">' . __('Pending Payment', 'wp-job-portal') . '</span>';
                }
            ?> 
        </div>
    </div>
</div>

                    
                        
