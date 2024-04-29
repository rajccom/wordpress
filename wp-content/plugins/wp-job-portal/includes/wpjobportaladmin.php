<?php

if (!defined('ABSPATH'))
    die('Restricted Access');

class wpjobportaladmin {

    function __construct() {
        add_action('admin_menu', array($this, 'mainmenu'));
    }

    function mainmenu() {
        add_menu_page(__('Control Panel', 'wp-job-portal'), // Page title
                __('WP Job Portal', 'wp-job-portal'), // menu title
                'wpjobportal', // capability
                'wpjobportal', //menu slug
                array($this, 'showAdminPage'), // function name
                plugins_url('wp-job-portal/includes/images/admin_wpjobportal1.png'),26
        );
        add_submenu_page('wpjobportal', // parent slug
                __('Companies', 'wp-job-portal'), // Page title
                __('Companies', 'wp-job-portal'), // menu title
                'wpjobportal', // capability
                'wpjobportal_company', //menu slug
                array($this, 'showAdminPage') // function name
        );
        add_submenu_page('wpjobportal', // parent slug
                __('Theme', 'wp-job-portal'), // Page title
                __('Theme', 'wp-job-portal'), // menu title
                'wpjobportal', // capability
                'wpjobportal_theme', //menu slug
                array($this, 'showAdminPage') // function name
        );
        add_submenu_page('wpjobportal_hide', // parent slug
                __('pdf', 'wp-job-portal'), // Page title
                __('pdf', 'wp-job-portal'), // menu title
                'wpjobportal', // capability
                'wpjobportal_pdf', //menu slug
                array($this, 'showAdminPage') // function name
        );

        add_submenu_page('wpjobportal', // parent slug
                __('Jobs', 'wp-job-portal'), // Page title
                __('Jobs', 'wp-job-portal'), // menu title
                'wpjobportal', // capability
                'wpjobportal_job', //menu slug
                array($this, 'showAdminPage') // function name
        );
        add_submenu_page('wpjobportal', // parent slug
                __('Resume', 'wp-job-portal'), // Page title
                __('Resume', 'wp-job-portal'), // menu title
                'wpjobportal', // capability
                'wpjobportal_resume', //menu slug
                array($this, 'showAdminPage') // function name
        );
        add_submenu_page('wpjobportal', // parent slug
                __('Configurations', 'wp-job-portal'), // Page title
                __('Configurations', 'wp-job-portal'), // menu title
                'wpjobportal', // capability
                'wpjobportal_configuration', //menu slug
                array($this, 'showAdminPage') // function name
        );

        if(in_array('cronjob', wpjobportal::$_active_addons)){
            add_submenu_page('wpjobportal_hide', // parent slug
                __('Cron Job', 'wp-job-portal'), // Page title
                __('Cron Job', 'wp-job-portal'), // menu title
                'wpjobportal', // capability
                'wpjobportal_cronjob', //menu slug
                array($this, 'showAdminPage') // function name
            );
        }else{
            $this->addMissingAddonPage('cronjob');
        }


        add_submenu_page('wpjobportal_hide', // parent slug
                __('Departments', 'wp-job-portal'), // Page title
                __('Departments', 'wp-job-portal'), // menu title
                'wpjobportal', // capability
                'wpjobportal_departments', //menu slug
                array($this, 'showAdminPage') // function name
        );

        add_submenu_page('wpjobportal_hide', // parent slug
                __('Cover Letters', 'wp-job-portal'), // Page title
                __('Cover Letters', 'wp-job-portal'), // menu title
                'wpjobportal', // capability
                'wpjobportal_coverletter', //menu slug
                array($this, 'showAdminPage') // function name
        );

        if(in_array('credits',wpjobportal::$_active_addons)){
            add_submenu_page('wpjobportal_hide', // parent slug
                    __('Packages', 'wp-job-portal'), // Page title
                    __('Packages', 'wp-job-portal'), // menu title
                    'wpjobportal', // capability
                    'wpjobportal_package', //menu slug
                    array($this, 'showAdminPage') // function name
            );
        }else{
            $this->addMissingAddonPage('credits');
        }

        add_submenu_page('wpjobportal_hide', // parent slug
                __('Reports', 'wp-job-portal'), // Page title
                __('Reports', 'wp-job-portal'), // menu title
                'wpjobportal', // capability
                'wpjobportal_report', //menu slug
                array($this, 'showAdminPage') // function name
        );
        # Reports Addon
    if(in_array('reports', wpjobportal::$_active_addons)){
        add_submenu_page('wpjobportal_hide', // parent slug
                __('Jobseeker/Employer Reports', 'wp-job-portal'), // Page title
                __('Jobseeker/Employer Reports', 'wp-job-portal'), // menu title
                'wpjobportal', // capability
                'wpjobportal_reports', //menu slug
                array($this, 'showAdminPage') // function name
        );
    }else{
     $this->addMissingAddonPage('reports');
    }

        if(in_array('message', wpjobportal::$_active_addons)){
            add_submenu_page('wpjobportal_hide', // parent slug
                    __('Messages', 'wp-job-portal'), // Page title
                    __('Message', 'wp-job-portal'), // menu title
                    'wpjobportal', // capability
                    'wpjobportal_message', //menu slug
                    array($this, 'showAdminPage') // function name
            );
        }else{
            $this->addMissingAddonPage('message');
        }
        if(in_array('folder', wpjobportal::$_active_addons)){
            add_submenu_page('wpjobportal_hide', // parent slug
                __('Folder', 'wp-job-portal'), // Page title
                __('Folder', 'wp-job-portal'), // menu title
                'wpjobportal', // capability
                'wpjobportal_folder', //menu slug
                array($this, 'showAdminPage') // function name
            );
        }else{
            $this->addMissingAddonPage('folder');
        }
        add_submenu_page('wpjobportal_hide', // parent slug
                __('Categories', 'wp-job-portal'), // Page title
                __('Categories', 'wp-job-portal'), // menu title
                'wpjobportal', // capability
                'wpjobportal_category', //menu slug
                array($this, 'showAdminPage') // function name
        );
        add_submenu_page('wpjobportal_hide', // parent slug
                __('Salary Range', 'wp-job-portal'), // Page title
                __('Salary Range', 'wp-job-portal'), // menu title
                'wpjobportal', // capability
                'wpjobportal_salaryrange', //menu slug
                array($this, 'showAdminPage') // function name
        );
        add_submenu_page('wpjobportal_hide', // parent slug
                __('Users', 'wp-job-portal'), // Page title
                __('Users', 'wp-job-portal'), // menu title
                'wpjobportal', // capability
                'wpjobportal_user', //menu slug
                array($this, 'showAdminPage') // function name
        );
        add_submenu_page('wpjobportal_hide', // parent slug
                __('Email Templates', 'wp-job-portal'), // Page title
                __('Email Templates', 'wp-job-portal'), // menu title
                'wpjobportal', // capability
                'wpjobportal_emailtemplate', //menu slug
                array($this, 'showAdminPage') // function name
        );
        add_submenu_page('wpjobportal_hide', // parent slug
                __('Pro Installer', 'wp-job-portal'), // Page title
                __('Pro Installer', 'wp-job-portal'), // menu title
                'wpjobportal', // capability
                'wpjobportal_proinstaller', //menu slug
                array($this, 'showAdminPage') // function name
        );
        add_submenu_page('wpjobportal_hide', // parent slug
                __('Email Templates Options', 'wp-job-portal'), // Page title
                __('Email Templates Options', 'wp-job-portal'), // menu title
                'wpjobportal', // capability
                'wpjobportal_emailtemplatestatus', //menu slug
                array($this, 'showAdminPage') // function name
        );
        add_submenu_page('wpjobportal_hide', // parent slug
                __('Countries', 'wp-job-portal'), // Page title
                __('Countries', 'wp-job-portal'), // menu title
                'wpjobportal', // capability
                'wpjobportal_country', //menu slug
                array($this, 'showAdminPage') // function name
        );
        add_submenu_page('wpjobportal_hide', // parent slug
                __('Career Level', 'wp-job-portal'), // Page title
                __('Career Levels', 'wp-job-portal'), // menu title
                'wpjobportal', // capability
                'wpjobportal_careerlevel', //menu slug
                array($this, 'showAdminPage') // function name
        );
        add_submenu_page('wpjobportal_hide', // parent slug
                __('Cities', 'wp-job-portal'), // Page title
                __('Cities', 'wp-job-portal'), // menu title
                'wpjobportal', // capability
                'wpjobportal_city', //menu slug
                array($this, 'showAdminPage') // function name
        );
        add_submenu_page('wpjobportal_hide', // parent slug
                __('Companies', 'wp-job-portal'), // Page title
                __('Companies', 'wp-job-portal'), // menu title
                'wpjobportal', // capability
                'wpjobportal_company', //menu slug
                array($this, 'showAdminPage') // function name
        );
        add_submenu_page('wpjobportal_hide', // parent slug
                __('Currency', 'wp-job-portal'), // Page title
                __('Currency', 'wp-job-portal'), // menu title
                'wpjobportal', // capability
                'wpjobportal_currency', //menu slug
                array($this, 'showAdminPage') // function name
        );
        add_submenu_page('wpjobportal_hide', // parent slug
                __('Custom Fields', 'wp-job-portal'), // Page title
                __('Custom Fields', 'wp-job-portal'), // menu title
                'wpjobportal', // capability
                'wpjobportal_customfield', //menu slug
                array($this, 'showAdminPage') // function name
        );
        add_submenu_page('wpjobportal_hide', // parent slug
                __('Employer Packages', 'wp-job-portal'), // Page title
                __('Employer Packages', 'wp-job-portal'), // menu title
                'wpjobportal', // capability
                'wpjobportal&wpjobportallt=profeatures', //menu slug
                array($this, 'showAdminPage') // function name
        );
        add_submenu_page('wpjobportal_hide', // parent slug
                __('Experience', 'wp-job-portal'), // Page title
                __('Experience', 'wp-job-portal'), // menu title
                'wpjobportal', // capability
                'wpjobportal_experience', //menu slug
                array($this, 'showAdminPage') // function name
        );
        add_submenu_page('wpjobportal_hide', // parent slug
                __('Field Ordering', 'wp-job-portal'), // Page title
                __('Field Ordering', 'wp-job-portal'), // menu title
                'wpjobportal', // capability
                'wpjobportal_fieldordering', //menu slug
                array($this, 'showAdminPage') // function name
        );
        add_submenu_page('wpjobportal_hide', // parent slug
                __('Highest Education', 'wp-job-portal'), // Page title
                __('Highest Education', 'wp-job-portal'), // menu title
                'wpjobportal', // capability
                'wpjobportal_highesteducation', //menu slug
                array($this, 'showAdminPage') // function name
        );
        add_submenu_page('wpjobportal_hide', // parent slug
                __('Job Alert', 'wp-job-portal'), // Page title
                __('Job Alert', 'wp-job-portal'), // menu title
                'wpjobportal', // capability
                'wpjobportal&wpjobportallt=profeatures', //menu slug
                array($this, 'showAdminPage') // function name
        );
        add_submenu_page('wpjobportal_hide', // parent slug
                __('Job Apply', 'wp-job-portal'), // Page title
                __('Job Apply', 'wp-job-portal'), // menu title
                'wpjobportal', // capability
                'wpjobportal_jobapply', //menu slug
                array($this, 'showAdminPage') // function name
        );
        add_submenu_page('wpjobportal_hide', // parent slug
                __('Job Seeker Packages', 'wp-job-portal'), // Page title
                __('Job Seeker Packages', 'wp-job-portal'), // menu title
                'wpjobportal', // capability
                'wpjobportal&wpjobportallt=profeatures', //menu slug
                array($this, 'showAdminPage') // function name
        );
        add_submenu_page('wpjobportal_hide', // parent slug
                __('Job Status', 'wp-job-portal'), // Page title
                __('Job Status', 'wp-job-portal'), // menu title
                'wpjobportal', // capability
                'wpjobportal_jobstatus', //menu slug
                array($this, 'showAdminPage') // function name
        );

       if(in_array('jobalert', wpjobportal::$_active_addons)){
            add_submenu_page('wpjobportal_hide', // parent slug
                    __('WP Job Alert', 'wp-job-portal'), // Page title
                    __('WP Job Alert', 'wp-job-portal'), // menu title
                    'wpjobportal', // capability
                    'wpjobportal_jobalert', //menu slug
                    array($this, 'showAdminPage') // function name
            );
       }else{
        $this->addMissingAddonPage('jobalert');
       }

        add_submenu_page('wpjobportal_hide', // parent slug
                __('Job Types', 'wp-job-portal'), // Page title
                __('Job Types', 'wp-job-portal'), // menu title
                'wpjobportal', // capability
                'wpjobportal_jobtype', //menu slug
                array($this, 'showAdminPage') // function name
        );
        add_submenu_page('wpjobportal_hide', // parent slug
                __('Messages', 'wp-job-portal'), // Page title
                __('Messages', 'wp-job-portal'), // menu title
                'wpjobportal', // capability
                'wpjobportal&wpjobportallt=profeatures', //menu slug
                array($this, 'showAdminPage') // function name
        );
        add_submenu_page('wpjobportal_hide', // parent slug
                __('Payment History', 'wp-job-portal'), // Page title
                __('Payment History', 'wp-job-portal'), // menu title
                'wpjobportal', // capability
                'wpjobportal_paymenthistory', //menu slug
                array($this, 'showAdminPage') // function name
        );
        add_submenu_page('wpjobportal_hide', // parent slug
                __('Payment Method Configuration', 'wp-job-portal'), // Page title
                __('Payment Method Configuration', 'wp-job-portal'), // menu title
                'wpjobportal', // capability
                'wpjobportal_paymenthistorymethodconfiguration', //menu slug
                array($this, 'showAdminPage') // function name
        );
        add_submenu_page('wpjobportal_hide', // parent slug
                __('Payment Method Configuration', 'wp-job-portal'), // Page title
                __('Payment Method Configuration', 'wp-job-portal'), // menu title
                'wpjobportal', // capability
                'wpjobportal_paymentmethodconfiguration', //menu slug
                array($this, 'showAdminPage') // function name
        );

        add_submenu_page('wpjobportal_hide', // parent slug
                __('Invoices', 'wp-job-portal'), // Page title
                __('Invoices', 'wp-job-portal'), // menu title
                'wpjobportal', // capability
                'wpjobportal_invoice', //menu slug
                array($this, 'showAdminPage') // function name
        );

        add_submenu_page('wpjobportal_hide', // parent slug
                __('Salary Range Types', 'wp-job-portal'), // Page title
                __('Salary Range Types', 'wp-job-portal'), // menu title
                'wpjobportal', // capability
                'wpjobportal_salaryrangetype', //menu slug
                array($this, 'showAdminPage') // function name
        );
        add_submenu_page('wpjobportal_hide', // parent slug
                __('States', 'wp-job-portal'), // Page title
                __('States', 'wp-job-portal'), // menu title
                'wpjobportal', // capability
                'wpjobportal_state', //menu slug
                array($this, 'showAdminPage') // function name
        );
        add_submenu_page('wpjobportal_hide', // parent slug
                __('System Errors', 'wp-job-portal'), // Page title
                __('System Errors', 'wp-job-portal'), // menu title
                'wpjobportal', // capability
                'wpjobportal_systemerror', //menu slug
                array($this, 'showAdminPage') // function name
        );
        // add_submenu_page('wpjobportal_hide', // parent slug
        //         __('Cover letter', 'wp-job-portal'), // Page title
        //         __('Cover letter', 'wp-job-portal'), // menu title
        //         'wpjobportal', // capability
        //         'wpjobportal_coverletter', //menu slug
        //         array($this, 'showAdminPage') // function name
        // );
        add_submenu_page('wpjobportal_hide', // parent slug
                __('Users', 'wp-job-portal'), // Page title
                __('Users', 'wp-job-portal'), // menu title
                'wpjobportal', // capability
                'wpjobportal_user', //menu slug
                array($this, 'showAdminPage') // function name
        );

       if(in_array('addressdata',wpjobportal::$_active_addons)){
            add_submenu_page('wpjobportal_hide', // parent slug
                __('Address Data', 'wp-job-portal'), // Page title
                __('Address Data', 'wp-job-portal'), // menu title
                'wpjobportal', // capability
                'wpjobportal_addressdata', //menu slug
                array($this, 'showAdminPage') // function name
        );
       }else{
        $this->addMissingAddonPage('addressdata');
       }

        add_submenu_page('wpjobportal', // parent slug
                __('Activity Log', 'wp-job-portal'), // Page title
                __('Activity Log', 'wp-job-portal'), // menu title
                'wpjobportal', // capability
                'wpjobportal_activitylog', //menu slug
                array($this, 'showAdminPage') // function name
        );
        add_submenu_page('wpjobportal_hide', // parent slug
                __('WP Job Portal', 'wp-job-portal'), // Page title
                __('WP Job Portal', 'wp-job-portal'), // menu title
                'wpjobportal', // capability
                'wpjobportal_common', //menu slug
                array($this, 'showAdminPage') // function name
        );
        if(in_array('credits', wpjobportal::$_active_addons)){
            add_submenu_page('wpjobportal_hide', // parent slug
                    __('Purchase History', 'wp-job-portal'), // Page title
                    __('Purchase History', 'wp-job-portal'), // menu title
                    'wpjobportal', // capability
                    'wpjobportal_purchasehistory', //menu slug
                    array($this, 'showAdminPage') // function name
            );
        }else{
            $this->addMissingAddonPage('credits');
        }
        /* add_submenu_page('wpjobportal', // parent slug
                __('Translations', 'wp-job-portal'), // Page title
                __('Translations', 'wp-job-portal'), // menu title
                'wpjobportal', // capability
                'wpjobportal&wpjobportallt=translations', //menu slug
                array($this, 'showAdminPage') // function name
        ); */
        add_submenu_page('wpjobportal', // parent slug
               __('Shortcodes', 'wp-job-portal'), // Page title
               __('Shortcodes', 'wp-job-portal'), // menu title
               'wpjobportal', // capability
               'wpjobportal&wpjobportallt=shortcodes', //menu slug
               array($this, 'showAdminPage') // function name
       );
        add_submenu_page('wpjobportal_hide', // parent slug
                __('System Errors', 'wp-job-portal'), // Page title
                __('System Errors', 'wp-job-portal'), // menu title
                'wpjobportal', // capability
                'wpjobportal_systemerror', //menu slug
                array($this, 'showAdminPage') // function name
        );
//Specifying Addons
        if(in_array('tag', wpjobportal::$_active_addons)){
            add_submenu_page('wpjobportal_hide', // parent slug
                    __('Tags', 'wp-job-portal'), // Page title
                    __('Tags', 'wp-job-portal'), // menu title
                    'wpjobportal', // capability
                    'wpjobportal_tag', //menu slug
                    array($this, 'showAdminPage') // function name
            );
         }else{
            $this->addMissingAddonPage('tags');
        }
        add_submenu_page('wpjobportal_hide', // parent slug
                __('WP Job Portal Settings', 'wp-job-portal'), // Page title
                __('WP Job Portal Settings', 'wp-job-portal'), // menu title
                'wpjobportal', // capability
                'wpjobportal_postinstallation', //menu slug
                array($this, 'showAdminPage') // function name
        );
        add_submenu_page('wpjobportal_hide', // parent slug
                __('WP Job Portal Slug', 'wp-job-portal'), // Page title
                __('WP Job Portal Slug', 'wp-job-portal'), // menu title
                'wpjobportal', // capability
                'wpjobportal_slug', //menu slug
                array($this, 'showAdminPage') // function name
        );
        add_submenu_page('wpjobportal', // parent slug
                __('Premium Plugin', 'wp-job-portal'), // Page title
                __('Premium Plugin', 'wp-job-portal'), // menu title
                'wpjobportal', // capability
                'wpjobportal_premiumplugin', //menu slug
                array($this, 'showAdminPage') // function name
        );
    }

  static  function showAdminPage() {
        wpjobportal::addStyleSheets();
        $page = WPJOBPORTALrequest::getVar('page');
        $page = wpjobportalphplib::wpJP_str_replace('wpjobportal_', '', $page);
        WPJOBPORTALincluder::include_file($page);
    }

    function addMissingAddonPage($module_name){
        add_submenu_page('wpjobportal_hide', // parent slug
                __('Premium Addon', 'wp-job-portal'), // Page title
                __('Premium Addon', 'wp-job-portal'), // menu title
                'wpjobportal', // capability
                $module_name, //menu slug
                array($this, 'showMissingAddonPage') // function name
        );
    }

}

$wpjobportalAdmin = new wpjobportaladmin();
?>
