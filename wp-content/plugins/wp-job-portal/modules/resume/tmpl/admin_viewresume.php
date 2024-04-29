<?php
if (!defined('ABSPATH'))
    die('Restricted Access');
?>
<?php
$filekey = WPJOBPORTALincluder::getJSModel('common')->getGoogleMapApiAddress();
echo $filekey;
?>
<script type="text/javascript">
    var ajaxurl = "<?php echo admin_url('admin-ajax.php') ?>";
    function makeExpiry() {
        jQuery(".goldnew").hover(function () {
            jQuery(this).find(".goldnew-onhover").show();
        }, function () {
            jQuery(this).find('span.goldnew-onhover').fadeOut("slow");
        });
        jQuery(".featurednew").hover(function () {
            jQuery(this).find("span.featurednew-onhover").show();
        }, function () {
            jQuery(this).find('.featurednew-onhover').fadeOut("slow");
        });
    }

    jQuery(document).ready(function(){
        var print_link = document.getElementById('print-link');
        if (print_link) {
            var href = "<?php echo wpjobportal::makeUrl(array('wpjobportalme'=>'resume', 'wpjobportallt'=>'printresume', 'wpjobportalid'=>wpjobportal::$_data[0]['personal_section']->id, 'wpjobportalpageid'=>wpjobportal::getPageid())) ?>";
            print_link.addEventListener('click', function (event) {
                print = window.open(href, 'print_win', 'width=1024, height=800, scrollbars=yes');
                event.preventDefault();
            }, false);
        }
    });
    function showPopupAndSetValues() {
        jQuery("div#full_background").show();
        jQuery("div#popup-main-outer.coverletter").show();
        jQuery("div#popup-main.coverletter").slideDown('slow');
        jQuery("div#full_background").click(function () {
            closePopup();
        });
        jQuery("img#popup_cross").click(function () {
            closePopup();
        });
    }
    function closePopup() {
        jQuery("div#popup-main-outer").slideUp('slow');
        setTimeout(function () {
            jQuery("div#full_background").hide();
            jQuery("div#popup-main").hide();
        }, 700);
    }

    function initialize(lat, lang, div) {
        var myLatlng = new google.maps.LatLng(lat, lang);
        var myOptions = {
            zoom: 8,
            center: myLatlng,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        }
        var map = new google.maps.Map(document.getElementById(div), myOptions);
        var marker = new google.maps.Marker({
            map: map,
            position: myLatlng
        });
    }
    jQuery(document).ready(function () {
        jQuery('div.resume-map div.row-title').click(function (e) {
            e.preventDefault();
            var img1 = '<?php echo WPJOBPORTAL_PLUGIN_URL . 'includes/images/resume/show-map.png'; ?>';
            var img2 = '<?php echo WPJOBPORTAL_PLUGIN_URL . 'includes/images/resume/hide-map.png'; ?>';
            var pdiv = jQuery(this).parent();
            var mdiv = jQuery(pdiv).find('div.row-value');
            if (jQuery(mdiv).css('display') == 'none') {
                jQuery(mdiv).show();
                jQuery(this).find('img').attr('src', img2);
            } else {
                jQuery(mdiv).hide();
                jQuery(this).find('img').attr('src', img1);
            }
        });
    });
    function sendMessageJobseeker() {
        jQuery("div#full_background").show();
        jQuery("div#popup-main-outer.sendmessage").show();
        jQuery("div#popup-main.sendmessage").slideDown('slow');
        jQuery("div#full_background").click(function () {
            closePopup();
        });
        jQuery("img#popup_cross").click(function () {
            closePopup();
        });
    }
    function sendMessage() {
        var subject = jQuery('input#subject').val();
        if (subject == '') {
            alert("<?php echo __("Please fill the subject", "wp-job-portal"); ?>");
            return false;
        }
        var message = tinyMCE.get('jobseekermessage').getContent();
        if (message == '') {
            alert("<?php echo __("Please fill the message", "wp-job-portal"); ?>");
            return false;
        }
        var resumeid = "<?php echo wpjobportal::$_data[0]['personal_section']->id; ?>";
        var uid = "<?php echo wpjobportal::$_data[0]['personal_section']->uid; ?>";
        jQuery.post(ajaxurl, {action: "wpjobportal_ajax", wpjobportalme: "message", task: "sendmessageresume", subject: subject, message: message, resumeid: resumeid, uid: uid}, function (data) {
            if (data) {
                alert("<?php echo __("Message sent", "wp-job-portal"); ?>");
                closePopup();
            }else{
                alert("<?php echo __("Message not sent", "wp-job-portal"); ?>");
            }

        });
    }
</script>

<?php
    // css front end
    wpjobportal::addStyleSheets();
    //include_once WPJOBPORTAL_PLUGIN_PATH. 'includes/css/style_color.php';
    wp_enqueue_style('wpjobportal-color', WPJOBPORTAL_PLUGIN_URL . 'includes/css/color.css');
    wp_enqueue_style('wpjobportal-jobseeker-style', WPJOBPORTAL_PLUGIN_URL . 'includes/css/jobseekercp.css');
    wp_enqueue_style('wpjobportal-employer-style', WPJOBPORTAL_PLUGIN_URL . 'includes/css/employercp.css');
    wp_enqueue_style('wpjobportal-style', WPJOBPORTAL_PLUGIN_URL . 'includes/css/style.css');
    wp_enqueue_style('wpjobportal-style-tablet', WPJOBPORTAL_PLUGIN_URL . 'includes/css/style_tablet.css',array(),'','(min-width: 481px) and (max-width: 780px)');
    wp_enqueue_style('wpjobportal-style-mobile-landscape', WPJOBPORTAL_PLUGIN_URL . 'includes/css/style_mobile_landscape.css',array(),'','(min-width: 481px) and (max-width: 650px)');
    wp_enqueue_style('wpjobportal-style-mobile', WPJOBPORTAL_PLUGIN_URL . 'includes/css/style_mobile.css',array(),'','(max-width: 480px)');
    wp_enqueue_style('wpjobportal-chosen-style', WPJOBPORTAL_PLUGIN_URL . 'includes/js/chosen/chosen.min.css');
    wp_enqueue_style('wpjobportal-normal-style', WPJOBPORTAL_PLUGIN_URL . 'includes/css/wpjobportal_normlize.css');
    if (is_rtl()) {
        wp_register_style('wpjobportal-style-rtl', WPJOBPORTAL_PLUGIN_URL . 'includes/css/stylertl.css');
        wp_enqueue_style('wpjobportal-style-rtl');
    }
    $msgkey = WPJOBPORTALincluder::getJSModel('resume')->getMessagekey();
    WPJOBPORTALMessages::getLayoutMessage($msgkey);
    if(! wpjobportal::$_common->wpjp_isadmin()){
        WPJOBPORTALbreadcrumbs::getBreadcrumbs();
        include_once(WPJOBPORTAL_PLUGIN_PATH . 'includes/header.php');
    }
if (wpjobportal::$_error_flag == null) {
    $resumeviewlayout = WPJOBPORTALincluder::getObjectClass('resumeviewlayout');
    ?>
    <!-- main wrapper -->
    <div id="wpjobportaladmin-wrapper">
        <!-- left menu -->
        <div id="wpjobportaladmin-leftmenu">
            <?php WPJOBPORTALincluder::getTemplate('templates/admin/leftmenue',array('module' => 'resume')); ?>
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
                            <li><?php echo __('View Resume','wp-job-portal'); ?></li>
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
            <?php
                WPJOBPORTALincluder::getTemplate('templates/admin/pagetitle',array('module' => 'resume' ,'layouts' => 'viewresume'));
                WPJOBPORTALincluder::getTemplate('templates/admin/leftmenue',array('module' => 'resume'));
            ?>
            <!-- page content -->
            <div id="wpjobportal-admin-wrapper">
                <?php
                    $html = '<div id="resume-wrapper">';
                    $isowner = (WPJOBPORTALincluder::getObjectClass('user')->uid() == wpjobportal::$_data[0]['personal_section']->uid) ? 1 : 0;
                    $html .= $resumeviewlayout->getPersonalTopSection($isowner, 1);
                    $html .= '<div class="resume-section-title">
                                    <img class="heading-img" src="' . WPJOBPORTAL_PLUGIN_URL . 'includes/images/personal-info.png" />
                                    ' . __('Personal information', 'wp-job-portal') . '
                                </div>';
                    $html .= $resumeviewlayout->getPersonalSection(0, 1);
                    $show_section_that_have_value = wpjobportal::$_config->getConfigValue('show_only_section_that_have_value');
                    $showflag = 1;
                    WPJOBPORTALincluder::getTemplate('resume/views/admin/viewresume',array(
                        'showflag' => $showflag,
                        'show_section_that_have_value' =>$show_section_that_have_value,
                        'html' => $html,
                        'resumeviewlayout' => $resumeviewlayout
                    ));
                ?>
            </div>
        </div>
    </div>
<?php
}else{
    echo wp_kses_post(wpjobportal::$_error_flag_message);
} ?>
