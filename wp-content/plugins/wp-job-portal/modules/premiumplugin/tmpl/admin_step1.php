<?php
delete_option( 'wpjobportal_addon_install_data' );
?>
    <div id="wpjobportaladmin-wrapper">
        <div id="wpjobportaladmin-leftmenu">
            <?php  WPJOBPORTALincluder::getClassesInclude('wpjobportaladminsidemenu'); ?>
        </div>
        <div id="wpjobportaladmin-data">
            <div id="wpjobportal-wrapper-top">
                <div id="wpjobportal-wrapper-top-left">
                    <div id="wpjobportal-breadcrumbs">
                        <ul>
                            <li>
                                <a href="<?php echo admin_url('admin.php?page=wpjobportal'); ?>" title="<?php echo __('Dashboard','wp-job-portal'); ?>">
                                    <?php echo __('Dashboard','wp-job-portal'); ?>
                                </a>
                            </li>
                            <li><?php echo __('Install Addons','wp-job-portal'); ?></li>
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
                <h1 class="wpjobportal-head-text"><?php echo __('WP Job Portal Addon Installer','wp-job-portal'); ?></h1>
            </div>
            <div id="wpjobportal-admin-wrapper" class="p0 bg-n bs-n">
                <div id="wpjobportal-content">
                    <div id="black_wrapper_translation"></div>
                    <div id="jstran_loading">
                        <img alt="image" src="<?php echo WPJOBPORTAL_PLUGIN_URL; ?>includes/images/spinning-wheel.gif" />
                    </div>
                    <div id="wpjobportal-lower-wrapper">
                        <div class="wpjobportal-addon-installer-wrapper" >
                            <form id="wpjobportalfrom" action="<?php echo admin_url('admin.php?page=wpjobportal_premiumplugin&task=verifytransactionkey&action=wpjobportaltask'); ?>" method="post">
                                <div class="wpjobportal-addon-installer-left-section-wrap" >
                                    <div class="wpjobportal-addon-installer-left-image-wrap" >
                                        <img class="wpjobportal-addon-installer-left-image" src="<?php echo WPJOBPORTAL_PLUGIN_URL; ?>includes/images/addon-images/addon-installer-logo.png" />
                                    </div>
                                    <div class="wpjobportal-addon-installer-left-heading" >
                                        <?php echo __("WP Job Portal","wp-job-portal"); ?>
                                    </div>
                                    <div class="wpjobportal-addon-installer-left-title" >
                                        <?php echo __("Wordpress Plugin","wp-job-portal"); ?>
                                    </div>
                                    <div class="wpjobportal-addon-installer-left-description" >
                                        <?php echo __("WP Job Portal is an open-source job board plugin for WordPress that provides advanced features to help you create a successful job board. In addition, we offer trusted WP Job Portal add-ons that can further enhance your job board's functionality in a fast, safe, and easy manner. Our add-ons have been designed to integrate seamlessly with our job board plugin, ensuring you can expand your job board's capabilities without any complications.","wp-job-portal"); ?>
                                    </div>
                                </div>
                                <div class="wpjobportal-addon-installer-right-section-wrap" >
                                    <div class="wpjobportal-addon-installer-right-heading" >
                                        <?php echo __("WP Job Portal Addon Installer","wp-job-portal"); ?>
                                    </div>
                                    <div class="wpjobportal-addon-installer-right-description" >
                                        >> <a class="wpjobportal-addon-installer-install-btn" href="?page=wpjobportal_premiumplugin&wpjobportallt=addonfeatures" class="wpjobportal-addon-installer-addon-list-link" >
                                            <?php echo __("Add on list","wp-job-portal"); ?>
                                        </a> <<
                                    </div>
                                    <div class="wpjobportal-addon-installer-right-key-section" >
                                        <div class="wpjobportal-addon-installer-right-key-label" >
                                            <?php echo __("Please Insert Your Activation key","wp-job-portal"); ?>.
                                        </div>

                                        <?php
                                        $error_message = '';
                                        $transactionkey = '';
                                        if(get_option( 'wpjobportal_addon_return_data', '' ) != ''){
                                            $wpjobportal_addon_return_data = json_decode(get_option( 'wpjobportal_addon_return_data' ),true);
                                            if(isset($wpjobportal_addon_return_data['status']) && $wpjobportal_addon_return_data['status'] == 0){
                                                $error_message = $wpjobportal_addon_return_data['message'];
                                                $transactionkey = $wpjobportal_addon_return_data['transactionkey'];
                                            }
                                            delete_option( 'wpjobportal_addon_return_data' );
                                        }

                                        ?>
                                        <div class="wpjobportal-addon-installer-right-key-field" >
                                            <input type="text" name="transactionkey" id="transactionkey" class="wpjobportal_key_field" value="<?php echo esc_attr($transactionkey);?>" placeholder="<?php echo __('Activation key','wp-job-portal'); ?>"/>
                                            <?php if($error_message != '' ){ ?>
                                                <div class="wpjobportal-addon-installer-right-key-field-message" > <img alt="image" src="<?php echo WPJOBPORTAL_PLUGIN_URL; ?>includes/images/icon.png" /> <?php echo esc_html($error_message) ;?></div>
                                            <?php } ?>
                                        </div>
                                        <div class="wpjobportal-addon-installer-right-key-button" >
                                            <button type="submit" class="wpjobportal_btn" role="submit" onclick="jsShowLoading();"><?php echo __("Proceed","wp-job-portal"); ?></button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


<script>
    jQuery(document).ready(function(){
        jQuery('#wpjobportalfrom').on('submit', function() {
            jsShowLoading();
        });
    });

    function jsShowLoading(){
        jQuery('div#black_wrapper_translation').show();
        jQuery('div#jstran_loading').show();
    }
</script>
