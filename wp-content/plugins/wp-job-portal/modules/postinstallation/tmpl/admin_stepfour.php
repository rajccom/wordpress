<script src='<?php echo WPJOBPORTAL_PLUGIN_URL ?>includes/js/jquery.tokeninput.js'></script>
<script src='<?php echo WPJOBPORTAL_PLUGIN_URL ?>includes/js/chosen/chosen.jquery.min.js'></script>
<link rel='stylesheet' href='<?php echo WPJOBPORTAL_PLUGIN_URL ?>includes/js/chosen/chosen.min.css'/>
<script type="text/javascript">
    jQuery(document).ready(function() {
      jQuery('.wpjobportal-userselect').chosen({
        placeholder_text_single: "Select User",
        no_results_text: "Oops, nothing found!"
      });
      jQuery("#jobseeker_list").val(0).trigger('chosen:updated')  
      jQuery("#employer_list").val(0).trigger('chosen:updated')  
    });
    function refreshList() {
        location.reload();
    }
    function showHideUserForm() {
        var sampledata = jQuery('#sampledata').val();
        if (sampledata == 0) {
            jQuery('.wpjobportal-post-show-default-user-form').addClass('wpjobportal-post-hide-default-user-form');
        } else {
            jQuery('.wpjobportal-post-show-default-user-form').removeClass('wpjobportal-post-hide-default-user-form');
        }
    }
    function checkForEmpAndJSId() {
        var jobseeker_id = jQuery('#jobseeker_id').val();
        var employer_id = jQuery('#employer_id').val();
        if (employer_id != 0 && employer_id == jobseeker_id) {
            alert('Jobseeker And Employer Cannot Be Same');
        } else {
            document.getElementById('wpjobportal-form-ins').submit();
        }
    }
    function setValueForJobSeeker() {
        var option = jQuery('#jobseeker_list').val();
        var myOption = option.split("-");
        var id =  Number(myOption[myOption.length - 1]);
        jQuery("#jobseeker_id").val(id);
    }
    function setValueForEmployer() {
        var option = jQuery('#employer_list').val();
        var myOption = option.split("-");
        var id =  Number(myOption[myOption.length - 1]);
        jQuery("#employer_id").val(id);
    }
</script>
<?php $searchjobtag = array((object) array('id' => 1, 'text' => __('Top left', 'wp-job-portal'))
                    , (object) array('id' => 2, 'text' => __('Top right', 'wp-job-portal'))
                    , (object) array('id' => 3, 'text' => __('Middle left', 'wp-job-portal'))
                    , (object) array('id' => 4, 'text' => __('Middle right', 'wp-job-portal'))
                    , (object) array('id' => 5, 'text' => __('Bottom left', 'wp-job-portal'))
                    , (object) array('id' => 6, 'text' => __('Bottom right', 'wp-job-portal')));
$yesno = array((object) array('id' => 1, 'text' => __('Yes', 'wp-job-portal'))
                    , (object) array('id' => 0, 'text' => __('No', 'wp-job-portal')));
wp_enqueue_script('wpjobportal-commonjs', WPJOBPORTAL_PLUGIN_URL . 'includes/js/radio.js');
if (!defined('ABSPATH')) die('Restricted Access'); ?>
<div id="wpjobportaladmin-wrapper" class="wpjobportal-post-installation-wrp">
    <!-- top bar -->
    <div id="wpjobportal-wrapper-top">
        <div id="wpjobportal-wrapper-top-left">
            <a href="admin.php?page=wpjobportal" class="wpjobportaladmin-anchor">
                <img src="<?php echo WPJOBPORTAL_PLUGIN_URL.'includes/images/control_panel/dashboard/logo.png'; ?>"/>
            </a>
        </div>
        <div id="wpjobportal-wrapper-top-right">
            <div id="wpjobportal-vers-txt">
                <?php echo __('Version','wp-job-portal').': '; ?>
                <span class="wpjobportal-ver"><?php echo esc_html(WPJOBPORTALincluder::getJSModel('configuration')->getConfigValue('versioncode')); ?></span>
            </div>
        </div>
    </div>
    <!-- top head -->
    <div id="wpjobportal-head">
        <h1 class="wpjobportal-head-text">
            <?php echo __('Import Sample Data', 'wp-job-portal'); ?>
        </h1>
    </div>
    <!-- content -->
    <div class="wpjobportal-post-installation">
        <div class="wpjobportal-post-menu">
            <ul class="step-4">
                <li class="first-part">
                    <a href="<?php echo admin_url("admin.php?page=wpjobportal_postinstallation&wpjobportallt=stepone"); ?>" class="tab_icon">
                        <img src="<?php echo WPJOBPORTAL_PLUGIN_URL; ?>includes/images/postinstallation/general-settings.png" />
                        <?php echo __('General','wp-job-portal'); ?>
                    </a>
                </li>
                <li class="second-part">
                    <a href="<?php echo admin_url("admin.php?page=wpjobportal_postinstallation&wpjobportallt=steptwo"); ?>" class="tab_icon">
                        <img src="<?php echo WPJOBPORTAL_PLUGIN_URL; ?>includes/images/postinstallation/employers.png" />
                        <?php echo __('Employer','wp-job-portal'); ?>
                    </a>
                </li>
                <li class="third-part">
                    <a href="<?php echo admin_url("admin.php?page=wpjobportal_postinstallation&wpjobportallt=stepthree"); ?>" class="tab_icon">
                        <img src="<?php echo WPJOBPORTAL_PLUGIN_URL; ?>includes/images/postinstallation/jobseeker.png" />
                        <?php echo __('Job Seeker','wp-job-portal'); ?>
                    </a>
                </li>
                <li class="fourth-part active">
                    <a href="<?php echo admin_url("admin.php?page=wpjobportal_postinstallation&wpjobportallt=stepfour"); ?>" class="tab_icon">
                        <img src="<?php echo WPJOBPORTAL_PLUGIN_URL; ?>includes/images/postinstallation/sample-data.png" />
                        <?php echo __('Sample Data','wp-job-portal'); ?>
                    </a>
                </li>
            </ul>
        </div>
        <div class="wpjobportal-post-data">
            <div class="wpjobportal-post-heading">
                <?php echo __('Sample Data','wp-job-portal');?>
            </div>
            <form id="wpjobportal-form-ins" class="wpjobportal-form" method="post" action="<?php echo admin_url("admin.php?page=wpjobportal_postinstallation&task=savesampledata"); ?>">
                <div class="wpjobportal-post-data-row">
                    <div class="wpjobportal-post-tit">
                        <?php echo __('Insert Sample Data','wp-job-portal'); ?>
                    </div>
                    <div class="wpjobportal-post-val">
                        <?php echo wp_kses(WPJOBPORTALformfield::select('sampledata', $yesno,1,'',array('class' => 'inputbox','onchange' => 'showHideUserForm()')),WPJOBPORTAL_ALLOWED_TAGS); ?>
                    </div>
                </div>
                <div class="wpjobportal-post-show-default-user-form">
                    <div class="wpjobportal-post-heading">
                        <?php echo __('jobseeker','wp-job-portal');?>
                    </div>
                    <div class="wpjobportal-post-data-row">
                        <div class="wpjobportal-post-tit">
                            <?php echo __('Select Jobseeker','wp-job-portal'); ?>
                        </div>
                        <div class="wpjobportal-post-val wpjobportal-post-val-user-list">
                            <?php echo wp_kses(WPJOBPORTALformfield::select('jobseeker_list', WPJOBPORTALincluder::getJSModel('postinstallation')->getWpUsersList(),1,'',array('class' => 'inputbox wpjobportal-userselect' , 'onchange' => 'setValueForJobSeeker()')),WPJOBPORTAL_ALLOWED_TAGS); ?>
                        </div>
                        <span class="wpjobportal-post-refresh-btn" onclick="refreshList()" title="<?php echo __('refresh','wp-job-portal');?>"><?php echo __('Refresh','wp-job-portal'); ?></span>
                        <a target="_blank" class="wpjobportal-post-create-user-btn" href="<?php echo esc_url( admin_url( 'user-new.php' ) ); ?>" title="<?php echo __('create user','wp-job-portal');?>"><?php echo __('Create user','wp-job-portal'); ?></a>
                    </div>
                    <div class="wpjobportal-post-heading">
                        <?php echo __('Employer','wp-job-portal');?>
                    </div>
                    <div class="wpjobportal-post-data-row">
                        <div class="wpjobportal-post-tit">
                            <?php echo __('Select Employer','wp-job-portal'); ?>
                        </div>
                        <div class="wpjobportal-post-val wpjobportal-post-val-user-list">
                            <?php echo wp_kses(WPJOBPORTALformfield::select('employer_list', WPJOBPORTALincluder::getJSModel('postinstallation')->getWpUsersList(),1,'',array('class' => 'inputbox wpjobportal-userselect' , 'onchange' => 'setValueForEmployer()')),WPJOBPORTAL_ALLOWED_TAGS); ?>
                        </div>
                        <span class="wpjobportal-post-refresh-btn" onclick="refreshList()" title="<?php echo __('refresh','wp-job-portal');?>"><?php echo __('Refresh','wp-job-portal'); ?></span>
                        <a target="_blank" class="wpjobportal-post-create-user-btn" href="<?php echo esc_url( admin_url( 'user-new.php' ) ); ?>" title="<?php echo __('create user','wp-job-portal');?>"><?php echo __('Create user','wp-job-portal'); ?></a>
                    </div>
                </div>
                <?php if(wpjobportal::$theme_chk == 0){ ?>
                    <div class="wpjobportal-post-heading">
                        <?php echo __('Menu','wp-job-portal');?>
                    </div>
                    <div class="wpjobportal-post-data-row">
                        <div class="wpjobportal-post-tit">
                            <?php echo __('Job Seeker Menu','wp-job-portal'); ?>
                        </div>
                        <div class="wpjobportal-post-val">
                            <?php echo wp_kses(WPJOBPORTALformfield::select('jsmenu', $yesno,1,'',array('class' => 'inputbox')),WPJOBPORTAL_ALLOWED_TAGS); ?>
                        </div>
                    </div>
                    <div class="wpjobportal-post-data-row">
                        <div class="wpjobportal-post-tit">
                            <?php echo __('Employer Menu','wp-job-portal'); ?>
                        </div>
                        <div class="wpjobportal-post-val">
                            <?php echo wp_kses(WPJOBPORTALformfield::select('empmenu', $yesno,1,'',array('class' => 'inputbox')),WPJOBPORTAL_ALLOWED_TAGS); ?>
                        </div>
                    </div>
                <?php  } elseif(wpjobportal::$theme_chk != 1){ ?>
                        <div class="pic-config temp-demo-data">
                            <div class="wpjobportal-post-tit">
                                <?php     echo __('Job Hub Sample Data','wp-job-portal'); ?>
                            </div>
                            <div class="wpjobportal-post-val">
                                <?php echo wp_kses(WPJOBPORTALformfield::select('temp_data', $yesno,1,'',array('class' => 'inputbox')),WPJOBPORTAL_ALLOWED_TAGS); ?>
                            </div>
                            <div class="desc"><?php echo __('if yes is selected then pages and menus of job manager template will be cretaed and published.','wp-job-portal');?>. </div>
                        </div>
                <?php } ?>
                <div class="wpjobportal-post-action-btn">
                    <a class="back-step wpjobportal-post-act-btn" href="<?php echo admin_url('admin.php?page=wpjobportal_postinstallation&wpjobportallt=stepthree'); ?>" title="<?php echo __('back','wp-job-portal'); ?>">
                        <?php echo __('Back','wp-job-portal'); ?>
                    </a>
                    <a class="next-step wpjobportal-post-act-btn" href="#" onclick="checkForEmpAndJSId();" title="<?php echo __('finish','wp-job-portal'); ?>">
                        <?php echo __('Finish','wp-job-portal'); ?>
                    </a>
                </div>
                <?php echo wp_kses(WPJOBPORTALformfield::hidden('jobseeker_id', '0'),WPJOBPORTAL_ALLOWED_TAGS); ?>
                <?php echo wp_kses(WPJOBPORTALformfield::hidden('employer_id', '0'),WPJOBPORTAL_ALLOWED_TAGS); ?>
                <?php echo wp_kses(WPJOBPORTALformfield::hidden('form_request', 'wpjobportal'),WPJOBPORTAL_ALLOWED_TAGS); ?>
                <?php echo wp_kses(WPJOBPORTALformfield::hidden('step', 3),WPJOBPORTAL_ALLOWED_TAGS); ?>
            </form>
        </div>
    </div>
</div>
