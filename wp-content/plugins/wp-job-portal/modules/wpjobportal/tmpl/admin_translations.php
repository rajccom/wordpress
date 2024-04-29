<?php
if(!defined('ABSPATH'))
 die('Restricted Access');
?>
<!-- main wrapper -->
<div id="wpjobportaladmin-wrapper">
    <!-- left menu -->
    <div id="wpjobportaladmin-leftmenu">
        <?php  WPJOBPORTALincluder::getClassesInclude('wpjobportaladminsidemenu'); ?>
    </div>
    <div id="wpjobportaladmin-data">
        <?php
            $msgkey = WPJOBPORTALincluder::getJSModel('wpjobportal')->getMessagekey();
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
                        <li><?php echo __('Translations','wp-job-portal'); ?></li>
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
        <?php WPJOBPORTALincluder::getTemplate('templates/admin/pagetitle',array('module' => 'wpjobportal' , 'layouts' => 'translations')); ?>
        <!-- page content -->
        <div id="wpjobportal-admin-wrapper" class="p0">
            <div id="black_wrapper_translation"></div>
            <div id="jstran_loading">
                <img src="<?php echo WPJOBPORTAL_PLUGIN_URL; ?>includes/images/spinning-wheel.gif" />
            </div>
            <div id="js-language-wrapper">
                <div class="jstopheading">
                    <?php echo __('Get WP Job Portal Translations','wp-job-portal');?>
                </div>
                <div id="gettranslation" class="gettranslation">
                    <img style="width:18px; height:auto;" src="<?php echo WPJOBPORTAL_PLUGIN_URL; ?>includes/images/download-icon.png" />
                    <?php echo __('Get Translations','wp-job-portal');?>
                </div>
                <div id="js_ddl">
                    <span class="title">
                        <?php echo __('Select Translation','wp-job-portal');?>:
                    </span>
                    <span class="combo" id="js_combo"></span>
                    <span class="button" id="jsdownloadbutton">
                        <img style="width:14px; height:auto;" src="<?php echo WPJOBPORTAL_PLUGIN_URL; ?>includes/images/download-icon.png" />
                        <?php echo __('Download','wp-job-portal');?>
                    </span>
                    <div id="jscodeinputbox" class="js-some-disc"></div>
                    <div class="js-some-disc">
                        <img style="width:18px; height:auto;" src="<?php echo WPJOBPORTAL_PLUGIN_URL; ?>includes/images/info-icon.png" />
                        <?php echo __('When WordPress language change to ro, WP Job Portal language will auto change to ro','wp-job-portal');?>
                    </div>
                </div>
                <div id="js-emessage-wrapper">
                    <img src="<?php echo WPJOBPORTAL_PLUGIN_URL; ?>includes/images/c_error.png" />
                    <div id="jslang_em_text"></div>
                </div>
                <div id="js-emessage-wrapper_ok">
                    <img src="<?php echo WPJOBPORTAL_PLUGIN_URL; ?>includes/images/saved.png" />
                    <div id="jslang_em_text_ok"></div>
                </div>
            </div>
            <div id="js-lang-toserver">
                <div class="col">
                    <a class="anc one" href="https://www.transifex.com/joom-sky/wp_job_portal" target="_blank">
                        <img src="<?php echo WPJOBPORTAL_PLUGIN_URL; ?>includes/images/translation-icon.png" />
                        <?php echo __('Contribute In Translation','wp-job-portal');?>
                    </a>
                </div>
                <div class="col">
                    <a class="anc two" href="http://www.joomsky.com/translations.html" target="_blank">
                        <img src="<?php echo WPJOBPORTAL_PLUGIN_URL; ?>includes/images/manual-download.png" />
                        <?php echo __('Manual Download','wp-job-portal');?>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<script >
    var ajaxurl = "<?php echo admin_url('admin-ajax.php') ?>";
    jQuery(document).ready(function(){
        jQuery('#gettranslation').click(function(){
            jsShowLoading();
            jQuery.post(ajaxurl, {action: 'wpjobportal_ajax', wpjobportalme: 'wpjobportal', task: 'getListTranslations'}, function (data) {
                if (data) {
                    jsHideLoading();
                    data = JSON.parse(data);
                    if(data['error']){
                        jQuery('#js-emessage-wrapper div').html(data['error']);
                        jQuery('#js-emessage-wrapper').show();
                    }else{
                        jQuery('#js-emessage-wrapper').hide();
                        jQuery('#gettranslation').hide();
                        jQuery('div#js_ddl').show();
                        jQuery('span#js_combo').html('<?php echo __("'+data['data']+'", "wp-job-portal") ?>');
                    }
                }
            });
        });

        jQuery(document).on('change', 'select#translations' ,function() {
            var lang_name = jQuery( this ).val();
            if(lang_name != ''){
                jQuery('#js-emessage-wrapper_ok').hide();
                jsShowLoading();
                jQuery.post(ajaxurl, {action: 'wpjobportal_ajax', wpjobportalme: 'wpjobportal', task: 'validateandshowdownloadfilename',langname:lang_name}, function (data) {
                    if (data) {
                        jsHideLoading();
                        data = JSON.parse(data);
                        if(data['error']){
                            jQuery('#js-emessage-wrapper div').html(data['error']);
                            jQuery('#js-emessage-wrapper').show();
                            jQuery('#jscodeinputbox').slideUp('400' , 'swing' , function(){
                                jQuery('input#languagecode').val("");
                            });
                        }else{
                            jQuery('#js-emessage-wrapper').hide();
                            jQuery('#jscodeinputbox').html(data['path']+': '+data['input']);
                            jQuery('#jscodeinputbox').slideDown();
                        }
                    }
                });
            }
        });

        jQuery('#jsdownloadbutton').click(function(){
            jQuery('#js-emessage-wrapper_ok').hide();
            var lang_name = jQuery('#translations').val();
            var file_name = jQuery('#languagecode').val();
            if(lang_name != '' && file_name != ''){
                jsShowLoading();
                jQuery.post(ajaxurl, {action: 'wpjobportal_ajax', wpjobportalme: 'wpjobportal', task: 'getlanguagetranslation',langname:lang_name , filename: file_name}, function (data) {
                    if (data) {
                        jsHideLoading();
                        data = JSON.parse(data);
                        if(data['error']){
                            jQuery('#js-emessage-wrapper div').html(data['error']);
                            jQuery('#js-emessage-wrapper').show();
                        }else{
                            jQuery('#js-emessage-wrapper').hide();
                            jQuery('#js-emessage-wrapper_ok div').html(data['data']);
                            jQuery('#js-emessage-wrapper_ok').slideDown();
                        }
                    }
                });
            }
        });
    });

    function jsShowLoading(){
        jQuery('div#black_wrapper_translation').show();
        jQuery('div#jstran_loading').show();
    }

    function jsHideLoading(){
        jQuery('div#black_wrapper_translation').hide();
        jQuery('div#jstran_loading').hide();
    }
</script>
