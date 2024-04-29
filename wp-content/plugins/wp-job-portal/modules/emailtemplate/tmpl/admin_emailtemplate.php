<?php if (!defined('ABSPATH')) die('Restricted Access'); ?>
<!-- main wrapper -->
<div id="wpjobportaladmin-wrapper">
    <!-- left menu -->
	<div id="wpjobportaladmin-leftmenu">
        <?php  WPJOBPORTALincluder::getClassesInclude('wpjobportaladminsidemenu'); ?>
    </div>
    <div id="wpjobportaladmin-data">
        <?php 
            $msgkey = WPJOBPORTALincluder::getJSModel('emailtemplate')->getMessagekey();
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
                        <li><?php echo __('Email Templates','wp-job-portal'); ?></li>
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
            <h1 class="wpjobportal-head-text">
                <?php echo __('Email Templates', 'wp-job-portal'); ?>
            </h1>
        </div>
        <!-- page content -->
        <div id="wpjobportal-admin-wrapper" class="p0 bg-n bs-n">
            <form method="post" class="emailtemplateform" action="<?php echo esc_url(admin_url("?page=wpjobportal_emailtemplate&task=saveemailtemplate")); ?>">
                <div class="wpjobportal-email-menu">
                    <span class="wpjobportal-email-menu-link <?php if (wpjobportal::$_data[1] == 'ew-cm') echo 'selected'; ?>">
                        <a class="wpjobportal-email-link" href="<?php echo esc_url(admin_url('admin.php?page=wpjobportal_emailtemplate&for=ew-cm')); ?>" title="<?php echo __('new company', 'wp-job-portal'); ?>">
                            <?php echo __('New Company', 'wp-job-portal'); ?>
                        </a>
                    </span>
                    <span class="wpjobportal-email-menu-link <?php if (wpjobportal::$_data[1] == 'd-cm') echo 'selected'; ?>">
                        <a class="wpjobportal-email-link" href="<?php echo esc_url(admin_url('admin.php?page=wpjobportal_emailtemplate&for=d-cm')); ?>" title="<?php echo __('delete company', 'wp-job-portal'); ?>">
                            <?php echo __('Delete Company', 'wp-job-portal'); ?>
                        </a>
                    </span>
                    <span class="wpjobportal-email-menu-link <?php if (wpjobportal::$_data[1] == 'cm-sts') echo 'selected'; ?>">
                        <a class="wpjobportal-email-link" href="<?php echo esc_url(admin_url('admin.php?page=wpjobportal_emailtemplate&for=cm-sts')); ?>" title="<?php echo __('company status', 'wp-job-portal'); ?>">
                            <?php echo __('Company Status', 'wp-job-portal'); ?>
                        </a>
                    </span>
                    <span class="wpjobportal-email-menu-link <?php if (wpjobportal::$_data[1] == 'ew-ob') echo 'selected'; ?>">
                        <a class="wpjobportal-email-link" href="<?php echo esc_url(admin_url('admin.php?page=wpjobportal_emailtemplate&for=ew-ob')); ?>" title="<?php echo __('new job', 'wp-job-portal'); ?>">
                            <?php echo __('New Job', 'wp-job-portal'); ?>
                        </a>
                    </span>
                    <?php if(in_array('visitorcanaddjob', wpjobportal::$_active_addons)){ ?>
                                <span class="wpjobportal-email-menu-link <?php if (wpjobportal::$_data[1] == 'ew-obv') echo 'selected'; ?>">
                                    <a class="wpjobportal-email-link" href="<?php echo esc_url(admin_url('admin.php?page=wpjobportal_emailtemplate&for=ew-obv')); ?>" title="<?php echo __('new visitor job', 'wp-job-portal'); ?>">
                                        <?php echo __('New Visitor Job', 'wp-job-portal'); ?>
                                        
                                    </a>
                                </span>
                        <?php } ?>
                    <span class="wpjobportal-email-menu-link <?php if (wpjobportal::$_data[1] == 'ob-sts') echo 'selected'; ?>">
                        <a class="wpjobportal-email-link" href="<?php echo esc_url(admin_url('admin.php?page=wpjobportal_emailtemplate&for=ob-sts')); ?>" title="<?php echo __('job status', 'wp-job-portal'); ?>">
                            <?php echo __('Job Status', 'wp-job-portal'); ?>
                        </a>
                    </span>
                    <span class="wpjobportal-email-menu-link <?php if (wpjobportal::$_data[1] == 'ob-d') echo 'selected'; ?>">
                        <a class="wpjobportal-email-link" href="<?php echo esc_url(admin_url('admin.php?page=wpjobportal_emailtemplate&for=ob-d')); ?>" title="<?php echo __('job delete', 'wp-job-portal'); ?>">
                            <?php echo __('Job Delete', 'wp-job-portal'); ?>
                        </a>
                    </span>
                    <span class="wpjobportal-email-menu-link <?php if (wpjobportal::$_data[1] == 'ew-rm') echo 'selected'; ?>">
                        <a class="wpjobportal-email-link" href="<?php echo esc_url(admin_url('admin.php?page=wpjobportal_emailtemplate&for=ew-rm')); ?>" title="<?php echo __('new resume', 'wp-job-portal'); ?>">
                            <?php echo __('New Resume', 'wp-job-portal'); ?>
                        </a>
                    </span>
                    <span class="wpjobportal-email-menu-link <?php if (wpjobportal::$_data[1] == 'ew-rmv') echo 'selected'; ?>">
                        <a class="wpjobportal-email-link" href="<?php echo esc_url(admin_url('admin.php?page=wpjobportal_emailtemplate&for=ew-rmv')); ?>" title="<?php echo __('new visitor resume', 'wp-job-portal'); ?>">
                            <?php echo __('New Visitor Resume', 'wp-job-portal'); ?>
                        </a>
                    </span>
                    <span class="wpjobportal-email-menu-link <?php if (wpjobportal::$_data[1] == 'rm-sts') echo 'selected'; ?>">
                        <a class="wpjobportal-email-link" href="<?php echo esc_url(admin_url('admin.php?page=wpjobportal_emailtemplate&for=rm-sts')); ?>" title="<?php echo __('resume status', 'wp-job-portal'); ?>">
                            <?php echo __('Resume Status', 'wp-job-portal'); ?>
                        </a>
                    </span>
                    <span class="wpjobportal-email-menu-link <?php if (wpjobportal::$_data[1] == 'd-rs') echo 'selected'; ?>">
                        <a class="wpjobportal-email-link" href="<?php echo esc_url(admin_url('admin.php?page=wpjobportal_emailtemplate&for=d-rs')); ?>" title="<?php echo __('delete resume', 'wp-job-portal'); ?>">
                            <?php echo __('Delete Resume', 'wp-job-portal'); ?>
                        </a>
                    </span>
                    <span class="wpjobportal-email-menu-link <?php if (wpjobportal::$_data[1] == 'em-n') echo 'selected'; ?>">
                        <a class="wpjobportal-email-link" href="<?php echo esc_url(admin_url('admin.php?page=wpjobportal_emailtemplate&for=em-n')); ?>" title="<?php echo __('new employer', 'wp-job-portal'); ?>">
                            <?php echo __('New Employer', 'wp-job-portal'); ?>
                        </a>
                    </span>
                    <span class="wpjobportal-email-menu-link <?php if (wpjobportal::$_data[1] == 'obs-n') echo 'selected'; ?>">
                        <a class="wpjobportal-email-link" href="<?php echo esc_url(admin_url('admin.php?page=wpjobportal_emailtemplate&for=obs-n')); ?>" title="<?php echo __('new job seeker', 'wp-job-portal'); ?>">
                            <?php echo __('New Job Seeker', 'wp-job-portal'); ?>
                        </a>
                    </span>
                    <span class="wpjobportal-email-menu-link <?php if (wpjobportal::$_data[1] == 'ad-jap') echo 'selected'; ?>">
                        <a class="wpjobportal-email-link" href="<?php echo esc_url(admin_url('admin.php?page=wpjobportal_emailtemplate&for=ad-jap')); ?>" title="<?php echo __('job apply admin', 'wp-job-portal'); ?>">
                            <?php echo __('Job Apply Admin', 'wp-job-portal'); ?>
                        </a>
                    </span>
                    <span class="wpjobportal-email-menu-link <?php if (wpjobportal::$_data[1] == 'em-jap') echo 'selected'; ?>">
                        <a class="wpjobportal-email-link" href="<?php echo esc_url(admin_url('admin.php?page=wpjobportal_emailtemplate&for=em-jap')); ?>" title="<?php echo __('job apply employer', 'wp-job-portal'); ?>">
                            <?php echo __('Job Apply Employer', 'wp-job-portal'); ?>
                        </a>
                    </span>
                    <span class="wpjobportal-email-menu-link <?php if (wpjobportal::$_data[1] == 'js-jap') echo 'selected'; ?>">
                        <a class="wpjobportal-email-link" href="<?php echo esc_url(admin_url('admin.php?page=wpjobportal_emailtemplate&for=js-jap')); ?>" title="<?php echo __('job apply job seeker', 'wp-job-portal'); ?>">
                            <?php echo __('Job Apply Job Seeker', 'wp-job-portal'); ?>
                        </a>
                    </span>
                    <?php if(in_array('resumeaction', wpjobportal::$_active_addons)){ ?>
                        <span class="wpjobportal-email-menu-link <?php if (wpjobportal::$_data[1] == 'ap-jap') echo 'selected'; ?>">
                            <a class="wpjobportal-email-link" href="<?php echo esc_url(admin_url('admin.php?page=wpjobportal_emailtemplate&for=ap-jap')); ?>" title="<?php echo __('applied resume status change', 'wp-job-portal'); ?>">
                                <?php echo __('Applied Resume Status Change', 'wp-job-portal'); ?>
                                
                            </a>
                        </span>
                    <?php } ?>
                     <?php if(in_array('resumeaction', wpjobportal::$_active_addons)){ ?>
                        <span class="wpjobportal-email-menu-link <?php if (wpjobportal::$_data[1] == 'jb-at') echo 'selected'; ?>">
                            <a class="wpjobportal-email-link" href="<?php echo esc_url(admin_url('admin.php?page=wpjobportal_emailtemplate&for=jb-at')); ?>" title="<?php echo __('job alert', 'wp-job-portal'); ?>">
                                <?php echo __('Job Alert', 'wp-job-portal'); ?>
                                
                            </a>
                        </span>
                    <?php } ?>
                     <?php if(in_array('tellfriend', wpjobportal::$_active_addons)){ ?>
                        <span class="wpjobportal-email-menu-link <?php if (wpjobportal::$_data[1] == 'jb-to-fri') echo 'selected'; ?>">
                            <a class="wpjobportal-email-link" href="<?php echo esc_url(admin_url('admin.php?page=wpjobportal_emailtemplate&for=jb-to-fri')); ?>" title="<?php echo __('tell to friend', 'wp-job-portal'); ?>">
                                <?php echo __('Tell To Friend', 'wp-job-portal'); ?>
                                
                            </a>
                        </span>
                        <?php } ?>
                   <?php if(in_array('credits', wpjobportal::$_active_addons)){ ?>
                    <span class="wpjobportal-email-menu-link <?php if (wpjobportal::$_data[1] == 'ew-pk-ad') echo 'selected'; ?>">
                        <a class="wpjobportal-email-link" href="<?php echo esc_url(admin_url('admin.php?page=wpjobportal_emailtemplate&for=ew-pk-ad')); ?>" title="<?php echo __('Purchase Package', 'wp-job-portal').' '.__(' Admin', 'wp-job-portal'); ?>">
                            <?php echo __('Purchase Package', 'wp-job-portal').' '.__('Admin', 'wp-job-portal'); ?>
                            
                        </a>
                    </span>
                    <span class="wpjobportal-email-menu-link <?php if (wpjobportal::$_data[1] == 'ew-pk') echo 'selected'; ?>">
                        <a class="wpjobportal-email-link" href="<?php echo esc_url(admin_url('admin.php?page=wpjobportal_emailtemplate&for=ew-pk')); ?>" title="<?php echo __('Purchase Package', 'wp-job-portal'); ?>">
                            <?php echo __('Purchase Package', 'wp-job-portal'); ?>
                            
                        </a>
                    </span>
                    <span class="wpjobportal-email-menu-link <?php if (wpjobportal::$_data[1] == 'st-pk') echo 'selected'; ?>">
                        <a class="wpjobportal-email-link" href="<?php echo esc_url(admin_url('admin.php?page=wpjobportal_emailtemplate&for=st-pk')); ?>" title="<?php echo __('Purchase Status', 'wp-job-portal'); ?>">
                            <?php echo __('Purchase Status', 'wp-job-portal'); ?>
                        </a>
                    </span>
                    <?php } ?>
                </div>
                <div class="wpjobportal-email-body">
                    <div class="wpjobportal-email-form-wrapper">
                        <div class="wpjobportal-email-form-title">
                            <?php echo __('Subject', 'wp-job-portal'); ?>
                        </div>
                        <div class="wpjobportal-email-form-field">
                            <?php echo wp_kses(WPJOBPORTALformfield::text('subject', wpjobportal::$_data[0]->subject, array('class' => 'inputbox', 'style' => 'width:100%;')),WPJOBPORTAL_ALLOWED_TAGS) ?>
                        </div>
                    </div>
                    <div class="wpjobportal-email-form-wrapper">
                        <div class="wpjobportal-email-form-title">
                            <?php echo __('Body', 'wp-job-portal'); ?>
                        </div>
                        <div class="wpjobportal-email-form-field">
                            <?php wp_editor(wpjobportal::$_data[0]->body, 'body', array('media_buttons' => false)); ?>
                        </div>
                    </div>
                    <div class="wpjobportal-email-parameters">
                        <div class="wpjobportal-email-parameter-heading"><?php echo __('Parameters', 'wp-job-portal') ?></div>
                        <?php if (wpjobportal::$_data[1] == 'ew-cm') { ?>
                            <span class="wpjobportal-email-paramater">{COMPANY_NAME}:  <?php echo __('Company name', 'wp-job-portal'); ?></span>
                            <span class="wpjobportal-email-paramater">{EMPLOYER_NAME}:  <?php echo __('Employer name', 'wp-job-portal'); ?></span>
                            <span class="wpjobportal-email-paramater">{COMPANY_LINK}:  <?php echo __('View company', 'wp-job-portal'); ?></span>
                            
                            <span class="wpjobportal-email-paramater">{COMPANY_STATUS}:  <?php echo __('Company status for approve,reject,pending', 'wp-job-portal'); ?></span>
                        <?php } elseif (wpjobportal::$_data[1] == 'cm-sts') { ?>
                            <span class="wpjobportal-email-paramater">{COMPANY_NAME}:  <?php echo __('Company name', 'wp-job-portal'); ?></span>
                            <span class="wpjobportal-email-paramater">{EMPLOYER_NAME}:  <?php echo __('Employer Name', 'wp-job-portal'); ?></span>
                            <span class="wpjobportal-email-paramater">{COMPANY_LINK}:  <?php echo __('View company', 'wp-job-portal'); ?></span>
                            <span class="wpjobportal-email-paramater">{COMPANY_STATUS}:  <?php echo __('Company approve or reject', 'wp-job-portal').'('.__('Gold','wp-job-portal') .','.__('Featured','wp-job-portal') . ')'; ?></span>
                            
                        <?php } elseif (wpjobportal::$_data[1] == 'd-cm') { ?>
                            <span class="wpjobportal-email-paramater">{COMPANY_NAME}:  <?php echo __('Company Name', 'wp-job-portal'); ?></span>
                            <span class="wpjobportal-email-paramater">{COMPANY_OWNER_NAME}:  <?php echo __('Company Owner Name', 'wp-job-portal'); ?></span>
                        <?php } elseif (wpjobportal::$_data[1] == 'd-rs') { ?>
                            <span class="wpjobportal-email-paramater">{RESUME_TITLE}:  <?php echo __('Resume title', 'wp-job-portal'); ?></span>
                            <span class="wpjobportal-email-paramater">{JOBSEEKER_NAME}:  <?php echo __('Job seeker name', 'wp-job-portal'); ?></span>
                        <?php } elseif (wpjobportal::$_data[1] == 'ew-ob') { ?>
                            <span class="wpjobportal-email-paramater">{JOB_TITLE}:  <?php echo __('Job title', 'wp-job-portal'); ?></span>
                            <span class="wpjobportal-email-paramater">{EMPLOYER_NAME}:  <?php echo __('Employer name', 'wp-job-portal'); ?></span>
                            <span class="wpjobportal-email-paramater">{JOB_LINK}:  <?php echo __('Job link', 'wp-job-portal'); ?></span>
                            
                            <span class="wpjobportal-email-paramater">{COMPANY_NAME}:  <?php echo __('Company name', 'wp-job-portal'); ?></span>
                        <?php } elseif (wpjobportal::$_data[1] == 'ob-sts') { ?>
                            <span class="wpjobportal-email-paramater">{JOB_TITLE}:  <?php echo __('Job title', 'wp-job-portal'); ?></span>
                            <span class="wpjobportal-email-paramater">{EMPLOYER_NAME}:  <?php echo __('Employer name', 'wp-job-portal'); ?></span>
                            <span class="wpjobportal-email-paramater">{JOB_LINK}:  <?php echo __('Job link', 'wp-job-portal'); ?></span>
                            <span class="wpjobportal-email-paramater">{JOB_STATUS}:  <?php echo __('Job  approve or reject', 'wp-job-portal').'('.__('Gold','wp-job-portal') .','.__('Featured','wp-job-portal') . ')'; ?></span>
                            
                        <?php } elseif (wpjobportal::$_data[1] == 'em-n') { ?>
                            <span class="wpjobportal-email-paramater">{USER_ROLE}:  <?php echo __('Role for employer', 'wp-job-portal'); ?></span>
                            <span class="wpjobportal-email-paramater">{USER_NAME}:  <?php echo __('Employer name', 'wp-job-portal'); ?></span>
                            <span class="wpjobportal-email-paramater">{CONTROL_PANEL_LINK}:  <?php echo __('Employer control panel link', 'wp-job-portal'); ?></span>
                        <?php } elseif (wpjobportal::$_data[1] == 'obs-n') { ?>
                            <span class="wpjobportal-email-paramater">{USER_ROLE}:  <?php echo __('Role for job seeker', 'wp-job-portal'); ?></span>
                            <span class="wpjobportal-email-paramater">{USER_NAME}:  <?php echo __('Job seeker name', 'wp-job-portal'); ?></span>
                            <span class="wpjobportal-email-paramater">{CONTROL_PANEL_LINK}:  <?php echo __('Job seeker control panel link', 'wp-job-portal'); ?></span>
                        <?php } elseif (wpjobportal::$_data[1] == 'ew-obv') { ?>
                            <span class="wpjobportal-email-paramater">{JOB_TITLE}:  <?php echo __('Job title', 'wp-job-portal'); ?></span>
                            <span class="wpjobportal-email-paramater">{EMPLOYER_NAME}:  <?php echo __('Employer name', 'wp-job-portal'); ?></span>
                            <span class="wpjobportal-email-paramater">{JOB_LINK}:  <?php echo __('Job link', 'wp-job-portal'); ?></span>
                            <span class="wpjobportal-email-paramater">{COMPANY_NAME}:  <?php echo __('Company name', 'wp-job-portal'); ?></span>    
                        <?php } elseif (wpjobportal::$_data[1] == 'ob-d') { ?>
                            <span class="wpjobportal-email-paramater">{JOB_TITLE}:  <?php echo __('Job title', 'wp-job-portal'); ?></span>
                            <span class="wpjobportal-email-paramater">{EMPLOYER_NAME}:  <?php echo __('Employer name', 'wp-job-portal'); ?></span>
                            <span class="wpjobportal-email-paramater">{COMPANY_NAME}:  <?php echo __('Company name', 'wp-job-portal'); ?></span>
                        <?php } elseif (wpjobportal::$_data[1] == 'em-jap') { ?>
                            <span class="wpjobportal-email-paramater">{JOB_TITLE}:  <?php echo __('Job title', 'wp-job-portal'); ?></span>
                            <span class="wpjobportal-email-paramater">{EMPLOYER_NAME}:  <?php echo __('Employer name', 'wp-job-portal'); ?></span>
                            <span class="wpjobportal-email-paramater">{RESUME_TITLE}:  <?php echo __('Resume title', 'wp-job-portal'); ?></span>
                            <span class="wpjobportal-email-paramater">{JOBSEEKER_NAME}:  <?php echo __('Job seeker name', 'wp-job-portal'); ?></span>
                            <span class="wpjobportal-email-paramater">{RESUME_DATA}:  <?php echo __('Resume data', 'wp-job-portal'); ?></span>
                            <span class="wpjobportal-email-paramater">{RESUME_APPLIED_STATUS}:  <?php echo __('Resume curent status', 'wp-job-portal'); ?></span>
                            <span class="wpjobportal-email-paramater">{COVER_LETTER_TITLE}:  <?php echo __('Cover letter title', 'wp-job-portal'); ?></span>
                            <span class="wpjobportal-email-paramater">{COVER_LETTER_DESCRIPTION}:  <?php echo __('Cover letter description', 'wp-job-portal'); ?></span>
                        <?php } elseif (wpjobportal::$_data[1] == 'js-jap') { ?>
                            <span class="wpjobportal-email-paramater">{JOB_TITLE}:  <?php echo __('Job title', 'wp-job-portal'); ?></span>
                            <span class="wpjobportal-email-paramater">{COMPANY_NAME}:  <?php echo __('Company name', 'wp-job-portal'); ?></span>
                            <span class="wpjobportal-email-paramater">{RESUME_TITLE}:  <?php echo __('Resume title', 'wp-job-portal'); ?></span>
                            <span class="wpjobportal-email-paramater">{JOBSEEKER_NAME}:  <?php echo __('Job seeker name', 'wp-job-portal'); ?></span>
                            <span class="wpjobportal-email-paramater">{RESUME_APPLIED_STATUS}:  <?php echo __('Resume curent status', 'wp-job-portal'); ?></span>
                        <?php } elseif (wpjobportal::$_data[1] == 'ew-rm') { ?>
                            <span class="wpjobportal-email-paramater">{RESUME_TITLE}:  <?php echo __('Resume title', 'wp-job-portal'); ?></span>
                            <span class="wpjobportal-email-paramater">{JOBSEEKER_NAME}:  <?php echo __('Job seeker name', 'wp-job-portal'); ?></span>
                            <span class="wpjobportal-email-paramater">{RESUME_LINK}:  <?php echo __('Resume link', 'wp-job-portal'); ?></span>
                            <span class="wpjobportal-email-paramater">{RESUME_STATUS}:  <?php echo __('Resume  approve or reject', 'wp-job-portal').'('.__('Gold','wp-job-portal') .','.__('Featured','wp-job-portal') . ')'; ?></span>
                        <?php } elseif (wpjobportal::$_data[1] == 'ew-rmv') { ?>
                            <span class="wpjobportal-email-paramater">{RESUME_TITLE}:  <?php echo __('Resume title', 'wp-job-portal'); ?></span>
                            <span class="wpjobportal-email-paramater">{JOBSEEKER_NAME}:  <?php echo __('Job seeker name', 'wp-job-portal'); ?></span>
                            <span class="wpjobportal-email-paramater">{RESUME_LINK}:  <?php echo __('Resume link', 'wp-job-portal'); ?></span>
                            <span class="wpjobportal-email-paramater">{RESUME_STATUS}:  <?php echo __('Resume  approve or reject', 'wp-job-portal').'('.__('Gold','wp-job-portal') .','.__('Featured','wp-job-portal') . ')'; ?></span>
                        <?php } elseif (wpjobportal::$_data[1] == 'rm-sts') { ?>
                            <span class="wpjobportal-email-paramater">{RESUME_TITLE}:  <?php echo __('Resume title', 'wp-job-portal'); ?></span>
                            <span class="wpjobportal-email-paramater">{JOBSEEKER_NAME}:  <?php echo __('Job seeker name', 'wp-job-portal'); ?></span>
                            <span class="wpjobportal-email-paramater">{RESUME_LINK}:  <?php echo __('Resume link', 'wp-job-portal'); ?></span>
                            <span class="wpjobportal-email-paramater">{RESUME_STATUS}:  <?php echo __('Resume  approve or reject', 'wp-job-portal').'('.__('Gold','wp-job-portal') .','.__('Featured','wp-job-portal') . ')'; ?></span>
                        <?php } elseif (wpjobportal::$_data[1] == 'ew-ms') { ?>
                            <span class="wpjobportal-email-paramater">{RESUME_TITLE}:  <?php echo __('Resume title', 'wp-job-portal'); ?></span>
                            <span class="wpjobportal-email-paramater">{JOBSEEKER_NAME}:  <?php echo __('Job seeker name', 'wp-job-portal'); ?></span>
                        <?php } elseif (wpjobportal::$_data[1] == 'ad-jap') { ?>
                            <span class="wpjobportal-email-paramater">{EMPLOYER_NAME}:  <?php echo __('Employer name', 'wp-job-portal'); ?></span>
                            <span class="wpjobportal-email-paramater">{JOBSEEKER_NAME}:  <?php echo __('Job seeker name', 'wp-job-portal'); ?></span>
                            <span class="wpjobportal-email-paramater">{JOB_TITLE}:  <?php echo __('Job Title', 'wp-job-portal'); ?></span>
                            <span class="wpjobportal-email-paramater">{RESUME_LINK}:  <?php echo __('Resume link', 'wp-job-portal'); ?></span>
                            <span class="wpjobportal-email-paramater">{RESUME_DATA}:  <?php echo __('Resume data', 'wp-job-portal'); ?></span>
                            <span class="wpjobportal-email-paramater">{COVER_LETTER_TITLE}:  <?php echo __('Cover letter title', 'wp-job-portal'); ?></span>
                            <span class="wpjobportal-email-paramater">{COVER_LETTER_DESCRIPTION}:  <?php echo __('Cover letter description', 'wp-job-portal'); ?></span>
                        <?php } elseif (wpjobportal::$_data[1] == 'ap-jap') { ?>
                            <span class="wpjobportal-email-paramater">{JOB_TITLE}:  <?php echo __('Job title', 'wp-job-portal'); ?></span>
                            <span class="wpjobportal-email-paramater">{JOBSEEKER_NAME}:  <?php echo __('Job seeker name', 'wp-job-portal'); ?></span>
                            <span class="wpjobportal-email-paramater">{RESUME_STATUS}:  <?php echo __('Applied resume status', 'wp-job-portal'); ?></span>
                            <span class="wpjobportal-email-paramater">{RESUME_LINK}:  <?php echo __('Resume link', 'wp-job-portal'); ?></span>
                        <?php }elseif(wpjobportal::$_data[1] == 'ew-pk-ad' || wpjobportal::$_data[1] == 'ew-pk' || wpjobportal::$_data[1] == 'st-pk') { ?>
                                    <span class="wpjobportal-email-paramater">{USER_NAME}:  <?php echo __('User name', 'wp-job-portal'); ?>/<?php echo __("Agency name",'wp-job-portal'); ?></span>
                                    <span class="wpjobportal-email-paramater">{PACKAGE_TITLE}:  <?php echo __('Package title', 'wp-job-portal'); ?></span>
                                    <span class="wpjobportal-email-paramater">{PACKAGE_PRICE}:  <?php echo __('Package price', 'wp-job-portal'); ?></span>
                                    <span class="wpjobportal-email-paramater">{PACKAGE_LINK}:  <?php echo __('View package', 'wp-job-portal'); ?></span>
                                    <span class="wpjobportal-email-paramater">{PUBLISH_STATUS}:  <?php echo __('Publish status', 'wp-job-portal'); ?></span>
                                    <?php 
                                    } ?>
                    </div>
                    <div class="wpjobportal-config-btn">
                        <?php echo wp_kses(WPJOBPORTALformfield::submitbutton('save', __('Save','wp-job-portal') .' '. __('Email Template', 'wp-job-portal'), array('class' => 'button wpjobportal-config-save-btn')),WPJOBPORTAL_ALLOWED_TAGS); ?>
                    </div>          
                </div>
                <?php echo wp_kses(WPJOBPORTALformfield::hidden('id', wpjobportal::$_data[0]->id),WPJOBPORTAL_ALLOWED_TAGS); ?>
                <?php echo wp_kses(WPJOBPORTALformfield::hidden('created', wpjobportal::$_data[0]->created),WPJOBPORTAL_ALLOWED_TAGS); ?>
                <?php echo wp_kses(WPJOBPORTALformfield::hidden('templatefor', wpjobportal::$_data[0]->templatefor),WPJOBPORTAL_ALLOWED_TAGS); ?>
                <?php echo wp_kses(WPJOBPORTALformfield::hidden('for', wpjobportal::$_data[1]),WPJOBPORTAL_ALLOWED_TAGS); ?>
                <?php echo wp_kses(WPJOBPORTALformfield::hidden('action', 'emailtemplate_saveemailtemplate'),WPJOBPORTAL_ALLOWED_TAGS); ?>
                <?php echo wp_kses(WPJOBPORTALformfield::hidden('form_request', 'wpjobportal'),WPJOBPORTAL_ALLOWED_TAGS); ?>
            </form>
        </div>
    </div>
</div>
