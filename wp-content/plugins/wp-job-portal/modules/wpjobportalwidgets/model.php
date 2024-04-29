<?php

if (!defined('ABSPATH'))
    die('Restricted Access');

class WPJOBPORTALwpjobportalwidgetsModel {

    function __construct() {

    }

    function listModuleJobs($layoutName, $jobs, $location, $showtitle, $title, $listtype, $noofjobs, $category, $subcategory, $company, $jobtype, $posteddate, $theme, $separator, $moduleheight, $jobsinrow, $jobsinrowtab, $jobmargintop, $jobmarginleft, $companylogo, $logodatarow, $sliding, $datacolumn, $speedTest, $slidingdirection, $consecutivesliding, $jobheight, $companylogowidth, $companylogoheight) {
        $speed = 50;
        if ($speedTest < 5) {
            for ($i = 5; $i > $speedTest; $i--)
                $speed += 10;
            if ($speed > 100)
                $speed = 100;
        }elseif ($speedTest > 5) {
            for ($i = 5; $i < $speedTest; $i++)
                $speed -= 10;
            if ($speed < 10)
                $speed = 10;
        }
        $dateformat = wpjobportal::$_configuration['date_format'];

        $moduleName = $layoutName;

        $contentswrapperstart = '';
        $contents = '';
        if ($jobs) {
            if ($listtype == 0) { //list style
                $contentswrapperstart .= '<div id="wpjobportal_module_wrapper" class="' . $moduleName . '" style="height:' . $moduleheight . 'px;" >';
                if ($showtitle == 1) {

                    $contentswrapperstart .= '
                        <div id="tp_heading" class="wjportal-mod-heading">
                            ' . $title . '
                        </div>
                    ';
                }
                $contentswrapperstart .= '<div id="wpjobportal_modulelist_titlebar" class="' . $moduleName . '" ><span id="whiteback"></span>';
                //For desktop
                $desktop_w = 1;
                if (($company == 1 || $company == 2 || $company == 4 || $company == 6) || ($companylogo == 1 || $companylogo == 2 || $companylogo == 4 || $companylogo == 6)) {
                    $desktop_w++;
                }
                if ($category == 1 || $category == 2 || $category == 3 || $category == 5) {
                    $desktop_w++;
                }
                if ($jobtype == 1 || $jobtype == 2 || $jobtype == 3 || $jobtype == 5) {
                    $desktop_w++;
                }
                if ($posteddate == 1 || $posteddate == 2 || $posteddate == 3 || $posteddate == 5) {
                    $desktop_w++;
                }
                if ($location == 1 || $location == 2 || $location == 3 || $location == 5) {
                    $desktop_w++;
                }
                //For tablet
                $tablet_w = 1;
                if (($company == 1 || $company == 2 || $company == 4 || $company == 6) || ($companylogo == 1 || $companylogo == 2 || $companylogo == 4 || $companylogo == 6)) {
                    $tablet_w++;
                }
                if ($category == 1 || $category == 2 || $category == 4 || $category == 6) {
                    $tablet_w++;
                }
                if ($jobtype == 1 || $jobtype == 2 || $jobtype == 4 || $jobtype == 6) {
                    $tablet_w++;
                }
                if ($posteddate == 1 || $posteddate == 2 || $posteddate == 4 || $posteddate == 6) {
                    $tablet_w++;
                }
                if ($location == 1 || $location == 2 || $location == 4 || $location == 6) {
                    $tablet_w++;
                }
                //For mobile
                $mobile_w = 1;
                if (($company == 1 || $company == 2 || $company == 4 || $company == 6) || ($companylogo == 1 || $companylogo == 2 || $companylogo == 4 || $companylogo == 6)) {
                    $mobile_w++;
                }
                if ($category == 1 || $category == 3 || $category == 4 || $category == 7) {
                    $mobile_w++;
                }
                if ($jobtype == 1 || $jobtype == 3 || $jobtype == 4 || $jobtype == 7) {
                    $mobile_w++;
                }
                if ($posteddate == 1 || $posteddate == 3 || $posteddate == 4 || $posteddate == 7) {
                    $mobile_w++;
                }
                if ($location == 1 || $location == 3 || $location == 4 || $location == 7) {
                    $mobile_w++;
                }

                if ($company != 0 || $companylogo != 0) {
                    $class = $this->getClasses($companylogo);
                    $class .= $this->getClasses($company);
                    $contentswrapperstart .= '<span id="wpjobportal_modulelist_titlebar" class="desktop_w-' . $desktop_w . ' tablet_w-' . $tablet_w . ' mobile_w-' . $mobile_w . ' ' . $class . '">' . __('Company', 'wp-job-portal') . '</span>';
                }
                $contentswrapperstart .= '<span id="wpjobportal_modulelist_titlebar" class="desktop_w-' . $desktop_w . ' tablet_w-' . $tablet_w . ' mobile_w-' . $mobile_w . ' visible-all">' . __('Title', 'wp-job-portal') . '</span>';
                if ($category != 0) {
                    $class = $this->getClasses($category);
                    $contentswrapperstart .= '<span id="wpjobportal_modulelist_titlebar" class="desktop_w-' . $desktop_w . ' tablet_w-' . $tablet_w . ' mobile_w-' . $mobile_w . ' ' . $class . '">' . __('Category', 'wp-job-portal') . '</span>';
                }
                if ($jobtype == 1) {
                    $class = $this->getClasses($jobtype);
                    $contentswrapperstart .= '<span id="wpjobportal_modulelist_titlebar" class="desktop_w-' . $desktop_w . ' tablet_w-' . $tablet_w . ' mobile_w-' . $mobile_w . ' ' . $class . '">' . __('Type', 'wp-job-portal') . '</span>';
                }
                if ($location == 1) {
                    $class = $this->getClasses($location);
                    $contentswrapperstart .= '<span id="wpjobportal_modulelist_titlebar" class="desktop_w-' . $desktop_w . ' tablet_w-' . $tablet_w . ' mobile_w-' . $mobile_w . ' ' . $class . '">' . __('Location', 'wp-job-portal') . '</span>';
                }
                if ($posteddate == 1) {
                    $class = $this->getClasses($posteddate);
                    $contentswrapperstart .= '<span id="wpjobportal_modulelist_titlebar" class="desktop_w-' . $desktop_w . ' tablet_w-' . $tablet_w . ' mobile_w-' . $mobile_w . ' ' . $class . '">' . __('Posted', 'wp-job-portal') . '</span>';
                }
                $contentswrapperstart .= '</div>';
                $wpdir = wp_upload_dir();
                if (isset($jobs)) {
                    foreach ($jobs as $job) {
                        $contents .= '<div id="wpjobportal_modulelist_databar"><span id="whiteback"></span>';
                        if ($company != 0 || $companylogo != 0) {
                            $class = $this->getClasses($company);
                            $class .= $this->getClasses($companylogo);
                            $contents .= '<span id="wpjobportal_modulelist_databar" class="desktop_w-' . $desktop_w . ' tablet_w-' . $tablet_w . ' mobile_w-' . $mobile_w . ' ' . $class . '">';
                            if ($companylogo != 0) {
                                $class = $this->getClasses($companylogo);

                                $c_l = wpjobportal::makeUrl(array('wpjobportalme'=>'company', 'wpjobportallt'=>'viewcompany', 'wpjobportalid'=>$job->companyaliasid, 'wpjobportalpageid'=>wpjobportal::getPageid()));

                                if($job->logofilename == ''){
                                    $logo = WPJOBPORTAL_PLUGIN_URL . '/includes/images/default_logo.png';
                                }else{
                                    $data_directory = wpjobportal::$_config->getConfigurationByConfigName('data_directory');
                                    $logo = $wpdir['baseurl'] . '/' . $data_directory . '/data/employer/comp_' . $job->companyid . '/logo/' . $job->logofilename;
                                }
                                $contents .= '<a href=' . $c_l . '><img  src="' . $logo . '"  /></a>';
                            }
                            if ($company != 0) {
                                $c_l = wpjobportal::makeUrl(array('wpjobportalme'=>'company', 'wpjobportallt'=>'viewcompany', 'wpjobportalid'=>$job->companyaliasid, 'wpjobportalpageid'=>wpjobportal::getPageid()));
                                $contents .= '<span id="themeanchor"><a class="anchor" href=' . $c_l . '>' . $job->companyname . '</a></span>';
                            }
                            $contents .= '</span>';
                        }
                        $an_link = wpjobportal::makeUrl(array('wpjobportalme'=>'job', 'wpjobportallt'=>'viewjob', 'wpjobportalid'=>$job->jobaliasid, 'wpjobportalpageid'=>wpjobportal::getPageid()));
                        $contents .= '<span id="wpjobportal_modulelist_databar" class="desktop_w-' . $desktop_w . ' tablet_w-' . $tablet_w . ' mobile_w-' . $mobile_w . ' visible-all">
                                        <span id="themeanchor">
                                            <a class="anchor" href="' . $an_link . '">
                                                ' . $job->title . '
                                            </a>
                                        </span>
                                        </span>';
                        if ($category != 0) {
                            $class = $this->getClasses($category);
                            $contents .= '<span id="wpjobportal_modulelist_databar" class="desktop_w-' . $desktop_w . ' tablet_w-' . $tablet_w . ' mobile_w-' . $mobile_w . ' ' . $class . '">' . $job->cat_title . '</span>';
                        }
                        if ($jobtype != 0) {
                            $class = $this->getClasses($jobtype);
                            $contents .= '<span id="wpjobportal_modulelist_databar" class="desktop_w-' . $desktop_w . ' tablet_w-' . $tablet_w . ' mobile_w-' . $mobile_w . ' ' . $class . '">' . $job->jobtypetitle . '</span>';
                        }
                        if ($location != 0) {
                            $class = $this->getClasses($location);
                            $contents .= '<span id="wpjobportal_modulelist_databar" class="desktop_w-' . $desktop_w . ' tablet_w-' . $tablet_w . ' mobile_w-' . $mobile_w . ' ' . $class . '">' . $job->location . '</span>';
                        }
                        if ($posteddate != 0) {
                            $class = $this->getClasses($posteddate);
                            $contents .= '<span id="wpjobportal_modulelist_databar" class="desktop_w-' . $desktop_w . ' tablet_w-' . $tablet_w . ' mobile_w-' . $mobile_w . ' ' . $class . '">' . date_i18n($dateformat, strtotime($job->created)) . '</span>';
                        }
                        $contents .= '</div>';
                    }
                }

                if ($sliding == 1) { // Sliding is enable
                    $consectivecontent = '';
                    for ($i = 0; $i < $consecutivesliding; $i++) {
                        $consectivecontent .= $contents;
                    }

                    if ($slidingdirection == 1) { // UP
                        $contents = '<marquee id="mod_hotwpjobportal"  style="height:' . $moduleheight . 'px;" direction="up" scrolldelay="' . $speed . '" scrollamount="1" onmouseover="this.stop();" onmouseout="this.start()";>' . $consectivecontent . '</marquee>';
                    }
                }
                $contentswrapperend = '</div>';
            } else { //box style
                $jobwidthclass = "modjob" . $jobsinrow;
                $jobtabwidthclass = "modjobtab" . $jobsinrowtab;
                $contentswrapperstart .= '<div id="wpjobportal_module_wrapper" class="' . $moduleName . '" >';
                if ($showtitle == 1) {
                    $contentswrapperstart .= '
                        <div id="tp_heading" class="wjportal-mod-heading">
                            ' . $title . '
                        </div>
                    ';
                }
                $inlineCSS = 'margin-top:' . $jobmargintop . 'px;margin-left:' . $jobmarginleft . 'px;';
                $wpdir = wp_upload_dir();
                if (isset($jobs)) {
                    foreach ($jobs as $job) {
                        $contents .= '<div id="wpjobportal_module_wrap" class="' . $jobwidthclass . ' ' . $jobtabwidthclass . ' wjportal-job-mod">
                                      <div id="wpjobportal_module">';
                        $an_link = wpjobportal::makeUrl(array('wpjobportalme'=>'job', 'wpjobportallt'=>'viewjob', 'wpjobportalid'=>$job->jobaliasid, 'wpjobportalpageid'=>wpjobportal::getPageid()));
                        $dataclass = 'data100';
                        if ($companylogo != 0) {
                            $c_l = wpjobportal::makeUrl(array('wpjobportalme'=>'company', 'wpjobportallt'=>'viewcompany', 'wpjobportalid'=>$job->companyaliasid, 'wpjobportalpageid'=>wpjobportal::getPageid()));
                            if ($logodatarow == 1) { // Combine
                                $logoclass = "comp40";
                                $dataclass = "data60";
                                $logocss = 'width:' . $companylogowidth . 'px;';
                            } else {
                                $logoclass = "comp100";
                                $dataclass = "data100";
                                $logocss = 'height:' . $companylogoheight . 'px;';
                            }

                            if($job->logofilename == ''){
                                $logo = WPJOBPORTAL_PLUGIN_URL . '/includes/images/default_logo.png';
                            }else{
                                $data_directory = wpjobportal::$_config->getConfigurationByConfigName('data_directory');
                                $logo = $wpdir['baseurl'] . '/' . $data_directory . '/data/employer/comp_' . $job->companyid . '/logo/' . $job->logofilename;
                            }

                            /*$logoclass .= $this->getClasses($companylogo);
                            $contents .= '
                                                <div id="wpjobportal_module_data_fieldwrapper" class="' . $logoclass . ' wjportal-job-logo" >
                                                    <a href=' . $c_l . '><img  src="' . $logo . '" /></a>
                                                </div>
                                              ';*/
                        }
                        $contents .= '<div class="wjportal-job-cont">';
                        $contents .= '<div id="wpjobportal_module_heading" class="wjportal-job-data wjportal-job-title">
                                        <a class="wjportal-jobname" href="' . $an_link . '">
                                            ' . $job->title . '
                                        </a>
                                      </div>';
                        $contents .= '<div id="wpjobportal_module_data_fieldwrapper" class="' . $dataclass . ' visible-all">';
                        $colwidthclass = 'modcolwidth' . $datacolumn;
                        if ($company != 0) {
                            $class = $this->getClasses($company);
                            $c_l = wpjobportal::makeUrl(array('wpjobportalme'=>'company', 'wpjobportallt'=>'viewcompany', 'wpjobportalid'=>$job->companyaliasid, 'wpjobportalpageid'=>wpjobportal::getPageid()));
                            $contents .= '
                                                <div id="wpjobportal_module_data_fieldwrapper" class="' . $colwidthclass . $class . ' wjportal-job-data">
                                                    <span id="wpjobportal_module_data_fieldtitle" class="wjportal-job-data-tit">' . __('Company', 'wp-job-portal') . ' : </span>
                                                    <span id="wpjobportal_module_data_fieldvalue" class="wjportal-job-data-val">
                                                        <a class="wjportal-compname" href=' . $c_l . '>' . $job->companyname . '</a>
                                                    </span>
                                                </div>
                                              ';
                        }
                        if ($category != 0) {
                            $class = $this->getClasses($category);
                            $contents .= '
                                                <div id="wpjobportal_module_data_fieldwrapper" class="' . $colwidthclass . $class . ' wjportal-job-data">
                                                    <span id="wpjobportal_module_data_fieldtitle" class="wjportal-job-data-tit">' . __('Category', 'wp-job-portal') . ' : </span>
                                                    <span id="wpjobportal_module_data_fieldvalue" class="wjportal-job-data-val">' . $job->cat_title . '</span>
                                                </div>
                                              ';
                        }
                        if ($jobtype != 0) {
                            $class = $this->getClasses($jobtype);
                            $contents .= '
                                                <div id="wpjobportal_module_data_fieldwrapper" class="' . $colwidthclass . $class . ' wjportal-job-data">
                                                    <span id="wpjobportal_module_data_fieldtitle" class="wjportal-job-data-tit">' . __('Type', 'wp-job-portal') . ' : </span>
                                                    <span id="wpjobportal_module_data_fieldvalue" class="wjportal-job-data-val">' . $job->jobtypetitle . '</span>
                                                </div>
                                              ';
                        }
                        if ($location != 0) {
                            $contents .= '
                                                <div id="wpjobportal_module_data_fieldwrapper" class="' . $colwidthclass . $class . ' wjportal-job-data">
                                                    <span id="wpjobportal_module_data_fieldtitle" class="wjportal-job-data-tit">' . __('Location', 'wp-job-portal') . ' : </span>
                                                    <span id="wpjobportal_module_data_fieldvalue" class="wjportal-job-data-val">' . $job->location . '</span>
                                                </div>
                                              ';
                        }
                        if ($posteddate != 0) {
                            $class = $this->getClasses($posteddate);
                            $contents .= '
                                                <div id="wpjobportal_module_data_fieldwrapper" class="' . $colwidthclass . $class . ' wjportal-job-data">
                                                    <span id="wpjobportal_module_data_fieldtitle" class="wjportal-job-data-tit">' . __('Posted', 'wp-job-portal') . ' : </span>
                                                    <span id="wpjobportal_module_data_fieldvalue" class="wjportal-job-data-val">' . date_i18n($dateformat, strtotime($job->created)) . '</span>
                                                </div>
                                              ';
                        }
                        $contents .= '</div>
                                </div>
                            </div>
                            </div>';
                    }
                }
                $contentswrapperend = '</div>';
            }
            return $contentswrapperstart . $contents . $contentswrapperend;
        }
    }

    function getClasses($for) {
        $class = '';
        switch ($for) {
            case 1: // Show all
                $class = ' visible-all ';
                break;
            case 2: // Show desktop and tablet
                $class = ' visible-desktop visible-tablet ';
                break;
            case 3: // Show desktop and mobile
                $class = ' visible-desktop visible-mobile ';
                break;
            case 4: // Show tablet and mobile
                $class = ' visible-tablet visible-mobile ';
                break;
            case 5: // Show desktop
                $class = ' visible-desktop ';
                break;
            case 6: // Show tablet
                $class = ' visible-tablet ';
                break;
            case 7: // Show mobile
                $class = ' visible-mobile ';
                break;
        }
        return $class;
    }

    function listModuleCompanies($layoutName, $companies, $noofcompanies, $category, $posteddate, $listtype, $theme, $location, $moduleheight, $jobwidth, $jobheight, $jobfloat, $jobmargintop, $jobmarginleft, $companylogo, $companylogowidth, $companylogoheight, $datacolumn, $listtype_extra, $title, $showtitle, $speedTest, $sliding, $slidingdirection, $consecutivesliding, $resumesinrow, $resumesinrowtab, $logodatarow) {

        $speed = 50;
        if ($speedTest < 5) {
            for ($i = 5; $i > $speedTest; $i--)
                $speed += 10;
            if ($speed > 100)
                $speed = 100;
        }elseif ($speedTest > 5) {
            for ($i = 5; $i < $speedTest; $i++)
                $speed -= 10;
            if ($speed < 10)
                $speed = 10;
        }
        $moduleName = $layoutName;
        $contentswrapperstart = '';
        $contents = '';

        $dateformat = wpjobportal::$_configuration['date_format'];
        $data_directory = wpjobportal::$_config->getConfigurationByConfigName('data_directory');
        if ($companies) {
            if ($listtype == 0) { //list style
                $contentswrapperstart .= '<div id="wpjobportal_module_wrapper" class="' . $moduleName . '" style="height:' . $moduleheight . 'px;" >';
                if ($showtitle == 1) {

                    $contentswrapperstart .= '
                        <div id="tp_heading" class="wjportal-mod-heading">
                            ' . $title . '
                        </div>
                    ';
                }
                $contentswrapperstart .= '<div id="wpjobportal_modulelist_titlebar" class="' . $moduleName . '" ><span id="whiteback"></span>';
                //For desktop
                $desktop_w = 1;
                if ($noofcompanies == 1 || $noofcompanies == 2 || $noofcompanies == 4 || $noofcompanies == 6) {
                    $desktop_w++;
                }
                if ($category == 1 || $category == 2 || $category == 4 || $category == 6) {
                    $desktop_w++;
                }
                if ($title == 1 || $title == 2 || $title == 3 || $title == 5) {
                    $desktop_w++;
                }
                if ($location == 1 || $location == 2 || $location == 3 || $location == 5) {
                    $desktop_w++;
                }
                if ($posteddate == 1 || $posteddate == 2 || $posteddate == 3 || $posteddate == 5) {
                    $desktop_w++;
                }
                //For tablet
                $tablet_w = 1;
                if ($noofcompanies == 1 || $noofcompanies == 2 || $noofcompanies == 4 || $noofcompanies == 6) {
                    $tablet_w++;
                }
                if ($category == 1 || $category == 2 || $category == 4 || $category == 6) {
                    $tablet_w++;
                }
                if ($title == 1 || $title == 2 || $title == 3 || $title == 5) {
                    $tablet_w++;
                }
                if ($location == 1 || $location == 2 || $location == 3 || $location == 5) {
                    $tablet_w++;
                }
                if ($posteddate == 1 || $posteddate == 2 || $posteddate == 3 || $posteddate == 5) {
                    $tablet_w++;
                }
                //For mobile
                $mobile_w = 1;
                if ($noofcompanies == 1 || $noofcompanies == 2 || $noofcompanies == 4 || $noofcompanies == 6) {
                    $mobile_w++;
                }
                if ($category == 1 || $category == 2 || $category == 4 || $category == 6) {
                    $mobile_w++;
                }
                if ($title == 1 || $title == 2 || $title == 3 || $title == 5) {
                    $mobile_w++;
                }
                if ($location == 1 || $location == 2 || $location == 3 || $location == 5) {
                    $mobile_w++;
                }
                if ($posteddate == 1 || $posteddate == 2 || $posteddate == 3 || $posteddate == 5) {
                    $mobile_w++;
                }

                if ($noofcompanies != 0) {
                    $class = $this->getClasses($noofcompanies);
                    $contentswrapperstart .= '<span id="wpjobportal_modulelist_titlebar" class="desktop_w-' . $desktop_w . ' tablet_w-' . $tablet_w . ' mobile_w-' . $mobile_w . ' ' . $class . '">' . __('Photo', 'wp-job-portal') . '</span>';
                }
                if ($category != 0) {
                    $class = $this->getClasses($category);
                    $contentswrapperstart .= '<span id="wpjobportal_modulelist_titlebar" class="desktop_w-' . $desktop_w . ' tablet_w-' . $tablet_w . ' mobile_w-' . $mobile_w . ' ' . $class . '">' . __('Category', 'wp-job-portal') . '</span>';
                }
                if ($location != 0) {
                    $class = $this->getClasses($location);
                    $contentswrapperstart .= '<span id="wpjobportal_modulelist_titlebar" class="desktop_w-' . $desktop_w . ' tablet_w-' . $tablet_w . ' mobile_w-' . $mobile_w . ' ' . $class . '">' . __('Location', 'wp-job-portal') . '</span>';
                }
                if ($posteddate != 0) {
                    $class = $this->getClasses($posteddate);
                    $contentswrapperstart .= '<span id="wpjobportal_modulelist_titlebar" class="desktop_w-' . $desktop_w . ' tablet_w-' . $tablet_w . ' mobile_w-' . $mobile_w . ' ' . $class . '">' . __('Posted', 'wp-job-portal') . '</span>';
                }
                $contentswrapperstart .= '</div>';
                $wpdir = wp_upload_dir();
                if (isset($companies)) {
                    foreach ($companies as $company) {
                        $contents .= '<div id="wpjobportal_modulelist_databar"><span id="whiteback"></span>';
                        if ($companylogo != 0) {
                            $class = $this->getClasses($companylogo);
                            $contents .= '<span id="wpjobportal_modulelist_databar" class="desktop_w-' . $desktop_w . ' tablet_w-' . $tablet_w . ' mobile_w-' . $mobile_w . ' ' . $class . '">';
                            $c_l = wpjobportal::makeUrl(array('wpjobportalme'=>'company', 'wpjobportallt'=>'viewcompany', 'wpjobportalid'=>$company->companyaliasid, 'wpjobportalpageid'=>wpjobportal::getPageid()));

                            if($company->logofilename == ''){
                                $logo = WPJOBPORTAL_PLUGIN_URL . '/includes/images/default_logo.png';
                            }else{
                                $logo = $wpdir['baseurl'] . '/' . $data_directory . '/data/employer/comp_' . $company->id . '/logo/' . $company->logofilename;
                            }

                            $contents .= '<a href=' . $c_l . '><img  src="' . $logo . '"  /></a>';
                            $contents .= '</span>';
                        }
                        if ($title != 0) {
                            $class = $this->getClasses($title);
                           $an_link = wpjobportal::makeUrl(array('wpjobportalme'=>'company', 'wpjobportallt'=>'viewcompany', 'wpjobportalid'=>$company->companyaliasid, 'wpjobportalpageid'=>wpjobportal::getPageid()));
                            $contents .= '<span id="wpjobportal_modulelist_databar" class="desktop_w-' . $desktop_w . ' tablet_w-' . $tablet_w . ' mobile_w-' . $mobile_w . ' ' . $class . '">
                                            <span id="themeanchor">
                                                <a class="anchor" href="' . $an_link . '">
                                                    ' . $company->title . '
                                                </a>
                                            </span>
                                            </span>';
                        }
                        if ($category != 0) {
                            $class = $this->getClasses($category);
                            $contents .= '<span id="wpjobportal_modulelist_databar" class="desktop_w-' . $desktop_w . ' tablet_w-' . $tablet_w . ' mobile_w-' . $mobile_w . ' ' . $class . '">' . $company->cat_title . '</span>';
                        }
                        if ($location != 0) {
                            $class = $this->getClasses($location);
                            $contents .= '<span id="wpjobportal_modulelist_databar" class="desktop_w-' . $desktop_w . ' tablet_w-' . $tablet_w . ' mobile_w-' . $mobile_w . ' ' . $class . '">' . $company->location . '</span>';
                        }
                        if ($posteddate != 0) {
                            $class = $this->getClasses($posteddate);
                            $contents .= '<span id="wpjobportal_modulelist_databar" class="desktop_w-' . $desktop_w . ' tablet_w-' . $tablet_w . ' mobile_w-' . $mobile_w . ' ' . $class . '">' . date_i18n($dateformat, strtotime($company->created)) . '</span>';
                        }
                        $contents .= '</div>';
                    }
                }

                $contentswrapperend = '</div>';
            } else { //box style
                $jobwidthclass = "modjob" . $resumesinrow;
                $jobtabwidthclass = "modjobtab" . $resumesinrowtab;
                //$contentswrapperstart .= '<div id="wpjobportal_module_wrapper" class="' . $moduleName . '" style="height:' . $moduleheight . 'px;overflow:hidden;">';
                $contentswrapperstart .= '<div id="wpjobportal_module_wrapper" class="' . $moduleName . '" >';
                if ($showtitle == 1) {
                    $contentswrapperstart .= '
                                <div id="tp_heading" class="wjportal-mod-heading">
                                    ' . $title . '
                                </div>
                    ';
                }
                $inlineCSS = 'margin-top:' . $jobmargintop . 'px;margin-left:' . $jobmarginleft . 'px;';
                if (isset($companies)) {
                    foreach ($companies as $company) {
                        $contents .= '<div id="wpjobportal_module_wrap" class="' . $jobwidthclass . ' ' . $jobtabwidthclass . ' wjportal-comp-mod ">
                                      <div id="wpjobportal_module">';
                        $an_link = wpjobportal::makeUrl(array('wpjobportalme'=>'company', 'wpjobportallt'=>'viewcompany', 'wpjobportalid'=>$company->companyaliasid, 'wpjobportalpageid'=>wpjobportal::getPageid()));
                        $dataclass = 'data100';
                        if ($companylogo != 0) {
                            $c_l = wpjobportal::makeUrl(array('wpjobportalme'=>'company', 'wpjobportallt'=>'viewcompany', 'wpjobportalid'=>$company->companyaliasid, 'wpjobportalpageid'=>wpjobportal::getPageid()));
                            if ($logodatarow == 1) { // Combine
                                $logoclass = "comp40";
                                $dataclass = "data60";
                                $logocss = 'width:' . $companylogowidth . 'px;';
                            } else {
                                $logoclass = "comp100";
                                $dataclass = "data100";
                                $logocss = 'height:' . $companylogoheight . 'px;';
                            }
                            if($company->logofilename == ''){
                                $logo = WPJOBPORTAL_PLUGIN_URL . '/includes/images/default_logo.png';
                            }else{
                                $wpdir = wp_upload_dir();
                                $logo = $wpdir['baseurl'] . '/' . $data_directory . '/data/employer/comp_' . $company->id . '/logo/' . $company->logofilename;
                            }

                            /*$logoclass .= $this->getClasses($companylogo);
                            $contents .= '
                                                <div id="wpjobportal_module_data_fieldwrapper" class="' . $logoclass . ' wjportal-comp-logo" >
                                                    <a href=' . $c_l . '><img  src="' . $logo . '" style="' . $logocss . 'display:block;margin:auto;" /></a>
                                                </div>
                                              ';*/
                        }
                        $contents .= '<div class="wjportal-comp-cont">';
                        $contents .= '<div id="wpjobportal_module_heading" class="wjportal-company-data wjportal-company-title">
                                        <a class="wjportal-companyname" href="' . $an_link . '">
                                            ' . $company->name . '
                                        </a>
                                      </div>';
                        $contents .= '<div id="wpjobportal_module_data_fieldwrapper" class="' . $dataclass . ' visible-all ">';
                        $colwidthclass = 'modcolwidth' . $datacolumn;
                        if ($category != 0) {
                            $class = $this->getClasses($category);
                            $contents .= '
                                                <div id="wpjobportal_module_data_fieldwrapper" class="' . $colwidthclass . $class . ' wjportal-company-data wjportal-company-catg">
                                                </div>
                                              ';
                        }
                        if ($location != 0) {
                            $class = $this->getClasses($location);
                            $contents .= '
                                                <div id="wpjobportal_module_data_fieldwrapper" class="' . $colwidthclass . $class . ' wjportal-company-data wjportal-company-loc">
                                                    <span id="wpjobportal_module_data_fieldtitle" class="wjportal-company-data-tit">' . __('Location', 'wp-job-portal') . ' : </span>
                                                    <span id="wpjobportal_module_data_fieldvalue" class="wjportal-company-data-val">' . $company->location . '</span>
                                                </div>
                                              ';
                        }
                        if ($posteddate != 0) {
                            $class = $this->getClasses($posteddate);
                            $contents .= '
                                                <div id="wpjobportal_module_data_fieldwrapper" class="' . $colwidthclass . $class . ' wjportal-company-data ">
                                                    <span id="wpjobportal_module_data_fieldtitle" class="wjportal-company-data-tit">' . __('Posted', 'wp-job-portal') . ' : </span>
                                                    <span id="wpjobportal_module_data_fieldvalue" class="wjportal-company-data-val">' . date_i18n($dateformat, strtotime($company->created)) . '</span>
                                                </div>
                                              ';
                        }
                        $contents .= '</div>
                                </div>
                            </div>
                        </div>';
                    }
                }
                $contentswrapperend = '</div>';
            }

            return $contentswrapperstart . $contents . $contentswrapperend;
        }
    }

    function listModuleResumes($layoutName, $resumes, $noofresumes, $applicationtitle, $name, $experience, $available, $gender, $nationality, $location, $category, $subcategory, $jobtype, $posteddate, $separator, $moduleheight, $resumeheight, $resumemargintop, $resumemarginleft, $photowidth, $photoheight, $datacolumn, $listtype, $title, $showtitle, $speedTest, $sliding, $consecutivesliding, $slidingdirection, $resumephoto, $resumesinrow, $resumesinrowtab, $logodatarow) {
        $speed = 50;
        if ($speedTest < 5) {
            for ($i = 5; $i > $speedTest; $i--)
                $speed += 10;
            if ($speed > 100)
                $speed = 100;
        }elseif ($speedTest > 5) {
            for ($i = 5; $i < $speedTest; $i++)
                $speed -= 10;
            if ($speed < 10)
                $speed = 10;
        }

        $moduleName = $layoutName;

        $contentswrapperstart = '';
        $contents = '';

        $dateformat = wpjobportal::$_configuration['date_format'];
        $data_directory = wpjobportal::$_config->getConfigurationByConfigName('data_directory');


        if ($resumes) {
            if ($listtype == 0) { //list style
                $contentswrapperstart .= '<div id="wpjobportal_module_wrapper" class="' . $moduleName . '" style="height:' . $moduleheight . 'px;" >';
                if ($showtitle == 1) {
                    $contentswrapperstart .= '
                        <div id="tp_heading" class="wjportal-mod-heading">
                            ' . $title . '
                        </div>
                    ';
                }
                $contentswrapperstart .= '<div id="wpjobportal_modulelist_titlebar" class="' . $moduleName . '" ><span id="whiteback"></span>';
                //For desktop
                $desktop_w = 1;
                if ($resumephoto == 1 || $resumephoto == 2 || $resumephoto == 4 || $resumephoto == 6) {
                    $desktop_w++;
                }
                if ($applicationtitle == 1 || $applicationtitle == 2 || $applicationtitle == 4 || $applicationtitle == 6) {
                    $desktop_w++;
                }
                if ($name == 1 || $name == 2 || $name == 3 || $name == 5) {
                    $desktop_w++;
                }
                if ($category == 1 || $category == 2 || $category == 3 || $category == 5) {
                    $desktop_w++;
                }
                if ($jobtype == 1 || $jobtype == 2 || $jobtype == 3 || $jobtype == 5) {
                    $desktop_w++;
                }
                if ($experience == 1 || $experience == 2 || $experience == 3 || $experience == 5) {
                    $desktop_w++;
                }
                if ($available == 1 || $available == 2 || $available == 3 || $available == 5) {
                    $desktop_w++;
                }
                if ($gender == 1 || $gender == 2 || $gender == 3 || $gender == 5) {
                    $desktop_w++;
                }
                if ($nationality == 1 || $nationality == 2 || $nationality == 3 || $nationality == 5) {
                    $desktop_w++;
                }
                if ($location == 1 || $location == 2 || $location == 3 || $location == 5) {
                    $desktop_w++;
                }
                if ($posteddate == 1 || $posteddate == 2 || $posteddate == 3 || $posteddate == 5) {
                    $desktop_w++;
                }
                //For tablet
                $tablet_w = 1;
                if ($resumephoto == 1 || $resumephoto == 2 || $resumephoto == 4 || $resumephoto == 6) {
                    $tablet_w++;
                }
                if ($applicationtitle == 1 || $applicationtitle == 2 || $applicationtitle == 4 || $applicationtitle == 6) {
                    $tablet_w++;
                }
                if ($name == 1 || $name == 2 || $name == 3 || $name == 5) {
                    $tablet_w++;
                }
                if ($category == 1 || $category == 2 || $category == 3 || $category == 5) {
                    $tablet_w++;
                }
                if ($jobtype == 1 || $jobtype == 2 || $jobtype == 3 || $jobtype == 5) {
                    $tablet_w++;
                }
                if ($experience == 1 || $experience == 2 || $experience == 3 || $experience == 5) {
                    $tablet_w++;
                }
                if ($available == 1 || $available == 2 || $available == 3 || $available == 5) {
                    $tablet_w++;
                }
                if ($gender == 1 || $gender == 2 || $gender == 3 || $gender == 5) {
                    $tablet_w++;
                }
                if ($nationality == 1 || $nationality == 2 || $nationality == 3 || $nationality == 5) {
                    $tablet_w++;
                }
                if ($location == 1 || $location == 2 || $location == 3 || $location == 5) {
                    $tablet_w++;
                }
                if ($posteddate == 1 || $posteddate == 2 || $posteddate == 3 || $posteddate == 5) {
                    $tablet_w++;
                }
                //For mobile
                $mobile_w = 1;
                if ($resumephoto == 1 || $resumephoto == 2 || $resumephoto == 4 || $resumephoto == 6) {
                    $mobile_w++;
                }
                if ($applicationtitle == 1 || $applicationtitle == 2 || $applicationtitle == 4 || $applicationtitle == 6) {
                    $mobile_w++;
                }
                if ($name == 1 || $name == 2 || $name == 3 || $name == 5) {
                    $mobile_w++;
                }
                if ($category == 1 || $category == 2 || $category == 3 || $category == 5) {
                    $mobile_w++;
                }
                if ($jobtype == 1 || $jobtype == 2 || $jobtype == 3 || $jobtype == 5) {
                    $mobile_w++;
                }
                if ($experience == 1 || $experience == 2 || $experience == 3 || $experience == 5) {
                    $mobile_w++;
                }
                if ($available == 1 || $available == 2 || $available == 3 || $available == 5) {
                    $mobile_w++;
                }
                if ($gender == 1 || $gender == 2 || $gender == 3 || $gender == 5) {
                    $mobile_w++;
                }
                if ($nationality == 1 || $nationality == 2 || $nationality == 3 || $nationality == 5) {
                    $mobile_w++;
                }
                if ($location == 1 || $location == 2 || $location == 3 || $location == 5) {
                    $mobile_w++;
                }
                if ($posteddate == 1 || $posteddate == 2 || $posteddate == 3 || $posteddate == 5) {
                    $mobile_w++;
                }

                if ($resumephoto != 0) {
                    $class = $this->getClasses($resumephoto);
                    $contentswrapperstart .= '<span id="wpjobportal_modulelist_titlebar" class="desktop_w-' . $desktop_w . ' tablet_w-' . $tablet_w . ' mobile_w-' . $mobile_w . ' ' . $class . '">' . __('Photo', 'wp-job-portal') . '</span>';
                }
                if ($applicationtitle != 0) {
                    $contentswrapperstart .= '<span id="wpjobportal_modulelist_titlebar" class="desktop_w-' . $desktop_w . ' tablet_w-' . $tablet_w . ' mobile_w-' . $mobile_w . ' visible-all">' . __('Application title', 'wp-job-portal') . '</span>';
                }
                if ($name != 0) {
                    $class = $this->getClasses($name);
                    $contentswrapperstart .= '<span id="wpjobportal_modulelist_titlebar" class="desktop_w-' . $desktop_w . ' tablet_w-' . $tablet_w . ' mobile_w-' . $mobile_w . ' ' . $class . '">' . __('Name', 'wp-job-portal') . '</span>';
                }
                if ($category != 0) {
                    $class = $this->getClasses($category);
                    $contentswrapperstart .= '<span id="wpjobportal_modulelist_titlebar" class="desktop_w-' . $desktop_w . ' tablet_w-' . $tablet_w . ' mobile_w-' . $mobile_w . ' ' . $class . '">' . __('Category', 'wp-job-portal') . '</span>';
                }
                if ($jobtype != 0) {
                    $class = $this->getClasses($jobtype);
                    $contentswrapperstart .= '<span id="wpjobportal_modulelist_titlebar" class="desktop_w-' . $desktop_w . ' tablet_w-' . $tablet_w . ' mobile_w-' . $mobile_w . ' ' . $class . '">' . __('Work preference', 'wp-job-portal') . '</span>';
                }
                if ($experience != 0) {
                    $class = $this->getClasses($experience);
                    $contentswrapperstart .= '<span id="wpjobportal_modulelist_titlebar" class="desktop_w-' . $desktop_w . ' tablet_w-' . $tablet_w . ' mobile_w-' . $mobile_w . ' ' . $class . '">' . __('Experience', 'wp-job-portal') . '</span>';
                }
                if ($available != 0) {
                    $class = $this->getClasses($available);
                    $contentswrapperstart .= '<span id="wpjobportal_modulelist_titlebar" class="desktop_w-' . $desktop_w . ' tablet_w-' . $tablet_w . ' mobile_w-' . $mobile_w . ' ' . $class . '">' . __('Available', 'wp-job-portal') . '</span>';
                }
                if ($gender != 0) {
                    $class = $this->getClasses($gender);
                    $contentswrapperstart .= '<span id="wpjobportal_modulelist_titlebar" class="desktop_w-' . $desktop_w . ' tablet_w-' . $tablet_w . ' mobile_w-' . $mobile_w . ' ' . $class . '">' . __('Gender', 'wp-job-portal') . '</span>';
                }
                if ($nationality != 0) {
                    $class = $this->getClasses($nationality);
                    $contentswrapperstart .= '<span id="wpjobportal_modulelist_titlebar" class="desktop_w-' . $desktop_w . ' tablet_w-' . $tablet_w . ' mobile_w-' . $mobile_w . ' ' . $class . '">' . __('Nationality', 'wp-job-portal') . '</span>';
                }
                if ($location != 0) {
                    $class = $this->getClasses($location);
                    $contentswrapperstart .= '<span id="wpjobportal_modulelist_titlebar" class="desktop_w-' . $desktop_w . ' tablet_w-' . $tablet_w . ' mobile_w-' . $mobile_w . ' ' . $class . '">' . __('Location', 'wp-job-portal') . '</span>';
                }
                if ($posteddate != 0) {
                    $class = $this->getClasses($posteddate);
                    $contentswrapperstart .= '<span id="wpjobportal_modulelist_titlebar" class="desktop_w-' . $desktop_w . ' tablet_w-' . $tablet_w . ' mobile_w-' . $mobile_w . ' ' . $class . '">' . __('Posted', 'wp-job-portal') . '</span>';
                }
                $contentswrapperstart .= '</div>';
                $wpdir = wp_upload_dir();
                if (isset($resumes)) {
                    foreach ($resumes as $resume) {
                        $contents .= '<div id="wpjobportal_modulelist_databar"><span id="whiteback"></span>';
                        if ($resumephoto != 0) {
                            $class = $this->getClasses($resumephoto);
                            $contents .= '<span id="wpjobportal_modulelist_databar" class="desktop_w-' . $desktop_w . ' tablet_w-' . $tablet_w . ' mobile_w-' . $mobile_w . ' ' . $class . '">';

                            $c_l = wpjobportal::makeUrl(array('wpjobportalme'=>'resume', 'wpjobportallt'=>'viewresume', 'wpjobportalid'=>$resume->resumealiasid, 'wpjobportalpageid'=>wpjobportal::getPageid()));

                            if($resume->photo == ''){
                                $logo = WPJOBPORTAL_PLUGIN_URL . '/includes/images/users.png';
                            }else{
                                $logo = $wpdir['baseurl'] . '/' . $data_directory . '/data/jobseeker/resume_' . $resume->resumeid . '/photo/' . $resume->photo;
                            }

                            $contents .= '<a href=' . $c_l . '><img  src="' . $logo . '"  /></a>';
                            $contents .= '</span>';
                        }
                        if ($applicationtitle != 0) {
                            $class = $this->getClasses($applicationtitle);

                            $an_link = wpjobportal::makeUrl(array('wpjobportalme'=>'resume', 'wpjobportallt'=>'viewresume', 'wpjobportalid'=>$resume->resumealiasid, 'wpjobportalpageid'=>wpjobportal::getPageid()));
                            $contents .= '<span id="wpjobportal_modulelist_databar" class="desktop_w-' . $desktop_w . ' tablet_w-' . $tablet_w . ' mobile_w-' . $mobile_w . ' ' . $class . '">
                                            <span id="themeanchor">
                                                <a class="anchor" href="' . $an_link . '">
                                                    ' . $resume->applicationtitle . '
                                                </a>
                                            </span>
                                            </span>';
                        }
                        if ($name != 0) {
                            $class = $this->getClasses($name);
                            $contents .= '<span id="wpjobportal_modulelist_databar" class="desktop_w-' . $desktop_w . ' tablet_w-' . $tablet_w . ' mobile_w-' . $mobile_w . ' ' . $class . '">' . $resume->name . '</span>';
                        }
                        if ($category != 0) {
                            $class = $this->getClasses($category);
                            $contents .= '<span id="wpjobportal_modulelist_databar" class="desktop_w-' . $desktop_w . ' tablet_w-' . $tablet_w . ' mobile_w-' . $mobile_w . ' ' . $class . '">' . $resume->cat_title . '</span>';
                        }
                        if ($jobtype != 0) {
                            $class = $this->getClasses($jobtype);
                            $contents .= '<span id="wpjobportal_modulelist_databar" class="desktop_w-' . $desktop_w . ' tablet_w-' . $tablet_w . ' mobile_w-' . $mobile_w . ' ' . $class . '">' . $resume->jobtypetitle . '</span>';
                        }
                        if ($experience != 0) {
                            $class = $this->getClasses($experience);
                            $contents .= '<span id="wpjobportal_modulelist_databar" class="desktop_w-' . $desktop_w . ' tablet_w-' . $tablet_w . ' mobile_w-' . $mobile_w . ' ' . $class . '">' . $resume->experiencetitle . '</span>';
                        }
                        if ($available != 0) {
                            $class = $this->getClasses($available);
                            $resumeavail = ($resume->available == 1) ? __('Yes', 'wp-job-portal') : __('No', 'wp-job-portal');
                            $contents .= '<span id="wpjobportal_modulelist_databar" class="desktop_w-' . $desktop_w . ' tablet_w-' . $tablet_w . ' mobile_w-' . $mobile_w . ' ' . $class . '">' . $resumeavail . '</span>';
                        }
                        if ($gender != 0) {
                            $class = $this->getClasses($gender);
                            $resumegender = ($resume->gender == 1) ? __('Male', 'wp-job-portal') : __('Female', 'wp-job-portal');
                            $contents .= '<span id="wpjobportal_modulelist_databar" class="desktop_w-' . $desktop_w . ' tablet_w-' . $tablet_w . ' mobile_w-' . $mobile_w . ' ' . $class . '">' . $resumegender . '</span>';
                        }
                        if ($nationality != 0) {
                            $class = $this->getClasses($nationality);
                            $contents .= '<span id="wpjobportal_modulelist_databar" class="desktop_w-' . $desktop_w . ' tablet_w-' . $tablet_w . ' mobile_w-' . $mobile_w . ' ' . $class . '">' . $resume->nationalityname . '</span>';
                        }
                        if ($location != 0) {
                            $class = $this->getClasses($location);
                            $addlocation = JSModel::getJSModel('configurations')->getConfigValue('defaultaddressdisplaytype');
                            $joblocation = !empty($job->cityname) ? $job->cityname : ' ';
                            switch ($addlocation) {
                                case 'csc':
                                    $joblocation .=!empty($job->statename) ? ', ' . $job->statename : '';
                                    $joblocation .=!empty($job->countryname) ? ', ' . $job->countryname : '';
                                    break;
                                case 'cs':
                                    $joblocation .=!empty($job->statename) ? ', ' . $job->statename : '';
                                    break;
                                case 'cc':
                                    $joblocation .=!empty($job->countryname) ? ', ' . $job->countryname : '';
                                    break;
                            }
                            $contents .= '<span id="wpjobportal_modulelist_databar" class="desktop_w-' . $desktop_w . ' tablet_w-' . $tablet_w . ' mobile_w-' . $mobile_w . ' ' . $class . '">' . $joblocation . '</span>';
                        }
                        if ($posteddate != 0) {
                            $class = $this->getClasses($posteddate);
                            $contents .= '<span id="wpjobportal_modulelist_databar" class="desktop_w-' . $desktop_w . ' tablet_w-' . $tablet_w . ' mobile_w-' . $mobile_w . ' ' . $class . '">' . date($dateformat, strtotime($resume->created)) . '</span>';
                        }
                        $contents .= '</div>';
                    }
                }

                $contentswrapperend = '</div>';
            } else { //box style
                $jobwidthclass = "modjob" . $resumesinrow;
                $jobtabwidthclass = "modjobtab" . $resumesinrowtab;
                //$contentswrapperstart .= '<div id="wpjobportal_module_wrapper" class="' . $moduleName . '" style="height:' . $moduleheight . 'px;overflow:hidden;" >';
                $contentswrapperstart .= '<div id="wpjobportal_module_wrapper" class="' . $moduleName . '">';
                if ($showtitle == 1) {
                    $contentswrapperstart .= '
                        <div id="tp_heading" class="wjportal-mod-heading">
                            ' . $title . '
                        </div>
                    ';
                }
                $inlineCSS = 'margin-top:' . $resumemargintop . 'px;margin-left:' . $resumemarginleft . 'px;';
                if (isset($resumes)) {
                    foreach ($resumes as $resume) {
                        $contents .= '<div id="wpjobportal_module_wrap" class="' . $jobwidthclass . ' ' . $jobtabwidthclass . ' wjportal-resume-mod">
                                      <div id="wpjobportal_module">';

                        $an_link = wpjobportal::makeUrl(array('wpjobportalme'=>'resume', 'wpjobportallt'=>'viewresume', 'wpjobportalid'=>$resume->resumealiasid, 'wpjobportalpageid'=>wpjobportal::getPageid()));
                        $dataclass = 'data100';
                        if ($resumephoto != 0) {

                            $c_l = wpjobportal::makeUrl(array('wpjobportalme'=>'resume', 'wpjobportallt'=>'viewresume', 'wpjobportalid'=>$resume->resumealiasid, 'wpjobportalpageid'=>wpjobportal::getPageid()));
                            if ($logodatarow == 1) { // Combine
                                $logoclass = "comp40";
                                $dataclass = "data60";
                                $logocss = 'width:' . $photowidth . 'px;';
                            } else {
                                $logoclass = "comp100";
                                $dataclass = "data100";
                                $logocss = 'height:' . $photoheight . 'px;';
                            }
                            if($resume->photo == ''){
                                $logo = WPJOBPORTAL_PLUGIN_URL . '/includes/images/users.png';
                            }else{
                                $wpdir = wp_upload_dir();
                                $logo = $wpdir['baseurl'] . '/' . $data_directory . '/data/jobseeker/resume_' . $resume->resumeid . '/photo/' . $resume->photo;
                            }
                            $logoclass .= $this->getClasses($resumephoto);
                            /*$contents .= '
                                                <div id="wpjobportal_module_data_fieldwrapper" class="' . $logoclass . ' wjportal-res-logo" >
                                                    <a href=' . $c_l . '><img  src="' . $logo . '" /></a>
                                                </div>
                                              ';*/
                        }
                        $contents .= '<div class="wjportal-res-cont">';
                        $contents .= '<div id="wpjobportal_module_heading" class="wjportal-res-data wjportal-res-title">
                                        <a class="wjportal-res-name" href="' . $an_link . '">
                                            ' . $resume->name . '
                                        </a>
                                      </div>';
                        $contents .= '<div id="wpjobportal_module_data_fieldwrapper" class="' . $dataclass . ' visible-all">';
                        $colwidthclass = 'modcolwidth' . $datacolumn;
                        if ($applicationtitle != 0) {
                            $class = $this->getClasses($applicationtitle);

                            $an_link = wpjobportal::makeUrl(array('wpjobportalme'=>'resume', 'wpjobportallt'=>'viewresume', 'wpjobportalid'=>$resume->resumealiasid, 'wpjobportalpageid'=>wpjobportal::getPageid()));
                            $contents .= '
                                                <div id="wpjobportal_module_data_fieldwrapper" class="' . $colwidthclass . $class . ' wjportal-res-data">
                                                    <a class="wjportal-res-app" href=' . $an_link . '>' . $resume->applicationtitle . '</a>
                                                </div>
                                              ';
                        }
                        /*if ($name != 0) {
                            $class = $this->getClasses($name);

                            $c_l = wpjobportal::makeUrl(array('wpjobportalme'=>'resume', 'wpjobportallt'=>'viewresume', 'wpjobportalid'=>$resume->resumealiasid, 'wpjobportalpageid'=>wpjobportal::getPageid()));
                            $contents .= '
                                                <div id="wpjobportal_module_data_fieldwrapper" class="' . $colwidthclass . $class . ' wjportal-res-data">
                                                    <span id="wpjobportal_module_data_fieldtitle" class="wjportal-res-data-tit">' . __('Name', 'wp-job-portal') . ' : </span>
                                                    <span id="wpjobportal_module_data_fieldvalue" class="wjportal-res-data-val">
                                                        <a class="wjportal-res-name" href=' . $c_l . '>' . $resume->name . '</a></span>
                                                    </span>
                                                </div>
                                              ';
                        }*/
                        if ($category != 0) {
                            $class = $this->getClasses($category);
                            $contents .= '
                                                <div id="wpjobportal_module_data_fieldwrapper" class="' . $colwidthclass . $class . ' wjportal-res-data">
                                                    <span id="wpjobportal_module_data_fieldtitle" class="wjportal-res-data-tit">' . __('Category', 'wp-job-portal') . ' : </span>
                                                    <span id="wpjobportal_module_data_fieldvalue" class="wjportal-res-data-val">' . $resume->cat_title . '</span>
                                                </div>
                                              ';
                        }
                        if ($jobtype != 0) {
                            $class = $this->getClasses($jobtype);
                            $contents .= '
                                                <div id="wpjobportal_module_data_fieldwrapper" class="' . $colwidthclass . $class . ' wjportal-res-data">
                                                    <span id="wpjobportal_module_data_fieldtitle" class="wjportal-res-data-tit">' . __('Type', 'wp-job-portal') . ' : </span>
                                                    <span id="wpjobportal_module_data_fieldvalue" class="wjportal-res-data-val">' . $resume->jobtypetitle . '</span>
                                                </div>
                                              ';
                        }
                        /*if ($experience != 0) {
                            $class = $this->getClasses($experience);
                            $contents .= '
                                                <div id="wpjobportal_module_data_fieldwrapper" class="' . $colwidthclass . $class . ' wjportal-res-data">
                                                    <span id="wpjobportal_module_data_fieldtitle" class="wjportal-res-data-tit">' . __('Experience', 'wp-job-portal') . ' : </span>
                                                    <span id="wpjobportal_module_data_fieldvalue" class="wjportal-res-data-val">' . $resume->experiencetitle . '</span>
                                                </div>
                                              ';
                        }
                        if ($available != 0) {
                            $class = $this->getClasses($available);
                            $resume->available = __("No","wp-job-portal");
                            if($resume->available == 1){
                                $resume->available = __("Yes","wp-job-portal");
                            }
                            $contents .= '
                                                <div id="wpjobportal_module_data_fieldwrapper" class="' . $colwidthclass . $class . ' wjportal-res-data">
                                                    <span id="wpjobportal_module_data_fieldtitle" class="wjportal-res-data-tit">' . __('Available', 'wp-job-portal') . ' : </span>
                                                    <span id="wpjobportal_module_data_fieldvalue" class="wjportal-res-data-val">' . $resume->available . '</span>
                                                </div>
                                              ';
                        }
                        if ($gender != 0) {
                            $class = $this->getClasses($gender);
                            $resumegender = ($resume->gender == 1) ? __('Male', 'wp-job-portal') : __('Female', 'wp-job-portal');
                            $contents .= '
                                                <div id="wpjobportal_module_data_fieldwrapper" class="' . $colwidthclass . $class . ' wjportal-res-data">
                                                    <span id="wpjobportal_module_data_fieldtitle" class="wjportal-res-data-tit">' . __('Gender', 'wp-job-portal') . ' : </span>
                                                    <span id="wpjobportal_module_data_fieldvalue" class="wjportal-res-data-val">' . $resumegender . '</span>
                                                </div>
                                              ';
                        }*/
                        if ($nationality != 0) {
                            $class = $this->getClasses($nationality);
                            $contents .= '
                                                <div id="wpjobportal_module_data_fieldwrapper" class="' . $colwidthclass . $class . ' wjportal-res-data">
                                                    <span id="wpjobportal_module_data_fieldtitle" class="wjportal-res-data-tit">' . __('Nationality', 'wp-job-portal') . ' : </span>
                                                    <span id="wpjobportal_module_data_fieldvalue" class="wjportal-res-data-val">' . $resume->nationalityname . '</span>
                                                </div>
                                              ';
                        }
                        if ($location != 0) {
                            $contents .= '
                                                <div id="wpjobportal_module_data_fieldwrapper" class="' . $colwidthclass . $class . ' wjportal-res-data">
                                                    <span id="wpjobportal_module_data_fieldtitle" class="wjportal-res-data-tit">' . __('Location', 'wp-job-portal') . ' : </span>
                                                    <span id="wpjobportal_module_data_fieldvalue" class="wjportal-res-data-val">' . $resume->location . '</span>
                                                </div>
                                              ';
                        }
                        if ($posteddate != 0) {
                            $class = $this->getClasses($posteddate);
                            $contents .= '
                                                <div id="wpjobportal_module_data_fieldwrapper" class="' . $colwidthclass . $class . ' wjportal-res-data">
                                                    <span id="wpjobportal_module_data_fieldtitle" class="wjportal-res-data-tit">' . __('Posted', 'wp-job-portal') . ' : </span>
                                                    <span id="wpjobportal_module_data_fieldvalue" class="wjportal-res-data-val">' . date_i18n($dateformat, strtotime($resume->created)) . '</span>
                                                </div>
                                              ';
                        }
                        $contents .= '</div>
                                    </div>
                                </div>
                            </div>';
                    }
                }

                $contentswrapperend = '</div>';
            }

            return $contentswrapperstart . $contents . $contentswrapperend;
        }
    }

    function listModuleByJobcatOrType($jobs, $classname, $showtitle, $title, $columnperrow, $jobfor){

        if (!(is_numeric($columnperrow) || $columnperrow < 0)) {
            $columnperrow = 3;
        }
        $width = (int) 100 / $columnperrow;

        $html = '
            <div id="wpjobportal_mod_wrapper" class="wjportal-job-by-mod">';
                if ($showtitle == 1) {
                    $html .= '<div id="tp_heading" class="wjportal-mod-heading">'.$title.'</div>';
                }
                $html .= '<div id="wpjobportal-data-wrapper" class="'.$classname.' wjportal-job-by">';
                if (isset($jobs)) {
                    foreach ($jobs as $job) {
                        if($jobfor == 1) //Types
                            $anchor = wpjobportal::makeUrl(array('wpjobportalme'=>'job', 'wpjobportallt'=>'jobs', 'jobtype'=>$job->aliasid, 'wpjobportalpageid'=>wpjobportal::getPageid()));
                        if($jobfor == 2) //Categories
                            $anchor = wpjobportal::makeUrl(array('wpjobportalme'=>'job', 'wpjobportallt'=>'jobs', 'category'=>$job->aliasid, 'wpjobportalpageid'=>wpjobportal::getPageid()));
                        $html .='<div class="wjportal-job-by-item" style="width:'.$width.'%">
                                    <a href="'.$anchor.'" class="wjportal-job-by-item-cnt">
                                        ' . $job->objtitle . '<span class="wjportal-job-by-item-num"> (' . $job->totaljobs . ')</span>
                                    </a>
                                </div>';
                    }
                }
                $html .= '</div>
            </div>
        ';

        return $html;
    }

    function listModuleLocation($jobs, $classname, $showtitle, $title, $columnperrow, $locationfor){

        if (!(is_numeric($columnperrow) || $columnperrow < 0)) {
            $columnperrow = 3;
        }
        $width = (int) 100 / $columnperrow;

        $html = '
            <div id="wpjobportal_mod_wrapper" class="wjportal-job-by-location-mod">';
                if ($showtitle == 1) {
                    $html .= '<div id="tp_heading" class="wjportal-mod-heading">'.$title.'</div>';
                }
                $html .= '<div id="wpjobportal-data-wrapper" class="'.$classname.' wjportal-job-by-loc">';
                if (isset($jobs)) {
                    foreach ($jobs as $job) {
                        if($locationfor == 1)
                            $anchor = wpjobportal::makeUrl(array('wpjobportalme'=>'job', 'wpjobportallt'=>'jobs', 'city'=>$job->locationid, 'wpjobportalpageid'=>wpjobportal::getPageid()));
                        if($locationfor == 2)
                            $anchor = wpjobportal::makeUrl(array('wpjobportalme'=>'job', 'wpjobportallt'=>'jobs', 'state'=>$job->locationid, 'wpjobportalpageid'=>wpjobportal::getPageid()));
                        if($locationfor == 3)
                            $anchor = wpjobportal::makeUrl(array('wpjobportalme'=>'job', 'wpjobportallt'=>'jobs', 'country'=>$job->locationid, 'wpjobportalpageid'=>wpjobportal::getPageid()));
                        $html .='<div class="wjportal-job-by-loc-item" style="width:'.$width.'%">
                                    <a class="wjportal-job-by-loc-item-cnt" href="'.$anchor.'">
                                        ' . $job->locationname . ' <span class="wjportal-job-by-item-num">(' . $job->totaljobs . ')</span>
                                    </a>
                                </div>';
                    }
                }
                $html .= '</div>
            </div>
        ';

        return $html;
    }

    function prepareStyleForStats($classname, $color1, $color2, $color3){

        $style = '<style type="text/css">';
            if (!empty($color1)) {
                $style .='  div.'.$classname.' div.wpjobportal-value{color: '.$color1.' !important;}';
            }
            if (!empty($color2)) {
                $style .='  div.'.$classname.' div.wpjobportal-value{background: '.$color2.' !important;}';
            }
            if (!empty($color3)) {
                $style .='  div.'.$classname.' div.wpjobportal-value{border: 1px solid '.$color3.' !important;}';
            }
        $style .='</style>';

        return $style;
    }

    function prepareStyleForBlocks($classname, $color1, $color2, $color3){
        $style = '<style type="text/css">';
            if (!empty($color1)) {
                $style .='  div.'.$classname.' div.anchor a.anchor{color: '.$color1.' !important;}';
            }
            if (!empty($color2)) {
                $style .='  div.'.$classname.' div.anchor a.anchor{background: '.$color2.' !important;}';
            }
            if (!empty($color3)) {
                $style .='  div.'.$classname.' div.anchor a.anchor{border: 1px solid '.$color3.' !important;}';
            }
        $style .='</style>';

        return $style;
    }

    function perpareStyleSheet($classname , $color1 , $color2 , $color3 , $color4 , $color5 , $color6 ){

        $style = '<style type="text/css">';
            if (!empty($color1)) {
                $style .='  div#wpjobportal_module_wrapper.'.$classname.' a{color:'.$color1.';}';
            }
            if (!empty($color3)) {
                $style .='  div.'.$classname.' div#wpjobportal_module{background: '.$color3.';}
                            div.'.$classname.' div#wpjobportal_modulelist_databar{background: '.$color3.';}
                            div.'.$classname.' div#wpjobportal_modulelist_titlebar{background: '.$color3.';}
                        ';
            }
            if (!empty($color4)) {
                $style .='  div.'.$classname.' div#wpjobportal_module{border: 1px solid '.$color4.';}
                            div.'.$classname.' div#wpjobportal_modulelist_titlebar{border: 1px solid '.$color4.';}
                            div.'.$classname.' div#wpjobportal_modulelist_databar{border: 1px solid '.$color4.';}
                        ';
            }
            if (!empty($color5)) {
                $style .='  div#wpjobportal_module_wrapper.'.$classname.' div#wpjobportal_module_wrap div#wpjobportal_module_data_fieldwrapper span#wpjobportal_module_data_fieldtitle{color: '.$color5.';}
                            div.'.$classname.' div#wpjobportal_modulelist_databar{color: '.$color5.';}
                            div.'.$classname.' div#wpjobportal_modulelist_titlebar span#wpjobportal_modulelist_titlebar{color: '.$color5.';}
                        ';
            }
            if (!empty($color6)) {
                $style .='  div#wpjobportal_module_wrapper.'.$classname.' div#wpjobportal_module_wrap div#wpjobportal_module_data_fieldwrapper span#wpjobportal_module_data_fieldvalue{color: '.$color6.';}';
            }
            if (!empty($color2)) {
                $style .='  div.'.$classname.' div#wpjobportal_module span#wpjobportal_module_heading {border-bottom: 1px solid '.$color2.';}';
            }
        $style .='</style>';
        return $style;
    }

    function listModuleJobsForMap($jobs, $title, $showtitle, $company, $category, $moduleheight, $mapzoom){
        $mappingservice = wpjobportal::$_config->getConfigValue('mappingservice');
        $data_directory = wpjobportal::$_config->getConfigurationByConfigName('data_directory');
        $wpdir = wp_upload_dir();
        $logopath = $wpdir['baseurl'] . '/' . $data_directory . '/data/employer/comp_'/* . $comp->id . '/logo/' . $comp->logofilename*/;
        $default_logoPath = WPJOBPORTAL_PLUGIN_URL . '/includes/images/default_logo.png';;


        if($mappingservice == "gmap"){
            $filekey = WPJOBPORTALincluder::getJSModel('common')->getGoogleMapApiAddress();
            $html = $filekey;

        }elseif ($mappingservice == "osm") {
            $html = ''; 
            wp_enqueue_script('wpjobportal-ol-script', WPJOBPORTAL_PLUGIN_URL . 'includes/js/ol.min.js');
            wp_enqueue_style('wpjobportal-ol-style', WPJOBPORTAL_PLUGIN_URL . 'includes/css/ol.min.css');
        }
        $default_longitude = wpjobportal::$_config->getConfigurationByConfigName('default_longitude');
        $default_latitude = wpjobportal::$_config->getConfigurationByConfigName('default_latitude');
        if($showtitle == 1){
            $html .= '
            <div id="tp_heading" class="wjportal-mod-heading">
                '.$title.'
            </div>';
        }
            if ($jobs) {
                $html .= '<div id="map-canvas" class="map-canvas-module" style="height:'.$moduleheight.'px;width:100%;"></div>';
                if($mappingservice == "gmap"){
                  $html .= '<script type="text/javascript">
                    var jobsarray = '.json_encode($jobs).';
                    var showCategory = '.$category.';
                    var showCompany = '.$company.';

                    var map = new google.maps.Map(document.getElementById("map-canvas"), {
                      zoom: '.$mapzoom.',
                      center: new google.maps.LatLng('.$default_latitude.','.$default_longitude.'),
                    });
                    var markers = [];
                    for(i = 0; i < jobsarray.length; i++){
                      var geocoder =  new google.maps.Geocoder();
                      if(jobsarray[i].multicity !== undefined){
                        var job = jobsarray[i];
                        for(k = 0; k < jobsarray[i].multicity.length; k++){
                          geocoder.geocode( { "address": jobsarray[i].multicity[k].cityname + \',\' + jobsarray[i].multicity[k].countryname}, function(results, status) {
                            if (status == google.maps.GeocoderStatus.OK) {
                              latitude = results[0].geometry.location.lat();
                              longitude = results[0].geometry.location.lng();
                              setMarker(map,job,latitude,longitude);
                            } else {
                              latitude = 0;
                              longitude = 0;
                            }
                          });
                        }
                      }else{
                        if(jobsarray[i].latitude.indexOf(",") > -1){ // multi location
                            var latarray = jobsarray[i].latitude.split(",");
                            var longarray = jobsarray[i].longitude.split(",");
                            for(l = 0; l < latarray.length; l++){
                                var latitudemap = latarray[l];
                                var longitudemap = longarray[l];
                                var marker = setMarker(map,jobsarray[i],latitudemap,longitudemap);
                                markers.push(marker);
                            }
                        }else{
                            var marker = setMarker(map,jobsarray[i],jobsarray[i].latitude,jobsarray[i].longitude);
                            markers.push(marker);
                        }
                      }
                    }

                    function setMarker(map,jobObject,latitude,longitude){
                      marker = new google.maps.Marker({
                        position: new google.maps.LatLng(latitude, longitude),
                        map: map
                      });
                      var infowindow = new google.maps.InfoWindow();
                      google.maps.event.addListener(marker, "click", (function(marker) {
                        return function() {
                          var markerContent = "<div class=\'wjportal-jobs-list-map\'><div class=\'wjportal-jobs-list\'>";
                          if(jobObject.companylogo != ""){
                            markerContent += "<div class=\'wjportal-jobs-logo\'><img src=\''.$logopath.'"+jobObject.companyid+"/logo/"+jobObject.companylogo+"\' ></div>";
                          }else{
                            markerContent += "<div class=\'wjportal-jobs-logo\'><img src=\''.$default_logoPath.'\' ></div>";
                          }
                          markerContent += "<div class=\'wjportal-jobs-cnt\'>";
                          if(showCompany == 1){
                           markerContent += "<div class=\'wjportal-jobs-data\'><a href=\'#\' class=\'wjportal-companyname\'>" + jobObject.companyname + "</a></div>";
                          }
                          if(showCategory == 1){
                            markerContent += "<div class=\'wjportal-jobs-data\'><a href=\'#\' class=\'wjportal-job-title\'>"+jobObject.title+"</a></div><div class=\'wjportal-jobs-data\'><span class=\'wjportal-jobs-data-txt\'>"+jobObject.cat_title+"</span></div></div></div></div>";
                          }
                          infowindow.setContent(markerContent);
                          infowindow.open(map, marker);
                        }
                      })(marker));
                      return marker;
                    }
                    /*
                    function autoCenter() {
                      //  Create a new viewpoint bound
                      var bounds = new google.maps.LatLngBounds();
                      //  Go through each...
                      jQuery.each(markers, function (index, marker) {
                        bounds.extend(marker.position);
                      });
                      //  Fit these bounds to the map
                      map.fitBounds(bounds);
                    }
                    autoCenter();
                    */
                  </script>';
                  return $html;
            }elseif ($mappingservice == "osm") {
                $html .= '
                         <script type="text/javascript">
                            osmMap = null;
                            var showCategory = '.$category.';
                            var showCompany = '.$company.';
                            var default_latitude = parseFloat('.$default_latitude.');
                            var default_longitude = parseFloat('.$default_latitude.');;
                            var coordinate = [default_longitude,default_latitude];
                            if(!osmMap){
                                osmMap = new ol.Map({
                                    target: "map-canvas",
                                    layers: [
                                        new ol.layer.Tile({
                                            source: new ol.source.OSM()
                                        })
                                    ],
                                });
                            }
                            osmMap.setView(new ol.View({
                                center: ol.proj.fromLonLat(coordinate),
                                zoom: '.$mapzoom.'
                            }));
                            // For showing multiple marker on map
                            var jobsarray = '.json_encode($jobs).';
                            for(i = 0; i < jobsarray.length; i++){
                                var latarray = jobsarray[i].latitude.split(",");
                                var longarray = jobsarray[i].longitude.split(",");
                                for(l = 0; l < latarray.length; l++){
                                    var latitudemap = parseFloat(latarray[l]);
                                    var longitudemap = parseFloat(longarray[l]);
                                }
                                coordinate = [longitudemap,latitudemap];
                                osmAddMarker(osmMap, coordinate);
                                osmMap.addEventListener("click",function(event){
                                    osmMap.forEachFeatureAtPixel(event.pixel, function (feature, layer) {
                                        var index = ol.coordinate.toStringXY(feature.getGeometry().getCoordinates());
                                        var box = document.getElementById("osmmappopup");
                                        if(!box){
                                            box = document.createElement("div");
                                            box.id = "osmmappopup";
                                        }
                                        var html = "<div class=\'wjportal-jobs-list-map\'><div class=\'wjportal-jobs-list\'><div class=\'wjportal-jobs-logo\'><img src=\''. WPJOBPORTAL_PLUGIN_URL .'/includes/images/default_logo.png\' ></div><div class=\'wjportal-jobs-cnt\'><div class=\'wjportal-jobs-data\'><a href=\'#\' class=\'wjportal-companyname\'>Company Name</a></div><div class=\'wjportal-jobs-data\'><a href=\'#\' class=\'wjportal-job-title\'>Job Title</a></div><div class=\'wjportal-jobs-data\'><span class=\'wjportal-jobs-data-txt\'>Category</span></div></div></div></div>";
                                        box.innerHTML = html;
                                        var prev_infowindow = new ol.Overlay({
                                            element: box,
                                            offset: [-140,-35]
                                        });
                                        prev_infowindow.setPosition(event.coordinate);
                                        osmMap.addOverlay(prev_infowindow);
                                    });
                                });
                            }

                        function osmAddMarker(osmMap, coordinate, icon) {
                            if(osmMap && ol){
                                if(!icon){
                                    icon = "http://maps.gstatic.com/mapfiles/api-3/images/spotlight-poi2.png";
                                }
                                var vectorLayer = new ol.layer.Vector({
                                    source: new ol.source.Vector({
                                        features: [
                                            new ol.Feature({
                                                geometry: new ol.geom.Point(ol.proj.transform(coordinate, "EPSG:4326", "EPSG:3857")),
                                            })
                                        ]
                                    }),
                                    style: new ol.style.Style({
                                        image: new ol.style.Icon({
                                            src: icon
                                        })
                                    })
                                });
                                osmMap.addLayer(vectorLayer);
                                return vectorLayer;
                            }
                            return false;
                        }
                     </script>';
             return $html;
          }
        }
    }

    function getJOBSWidgetHTML($jobs,$pageid,$title,$no_of_columns,$layoutName,$listtype,$typetag){
        $dateformat = wpjobportal::$_configuration['date_format'];

        $moduleName = $layoutName;
        $moduleheight = '500';
        $contentswrapperstart = '';
        $contents = '';
        $class = ' visible-all';

        if ($jobs) {
            /*if ($listtype == 1) {*/ //list style
                $contentswrapperstart .= '<div id="wpjobportal_module_wrapper" class="' . $moduleName . '" >';
                    $contentswrapperstart .= '
                                        <div id="tp_heading">
                                            <span id="tp_headingtext">
                                                <span id="tp_headingtext_center">' . $title . '</span>
                                            </span>
                                        </div>
                                    ';
                $wpdir = wp_upload_dir();
                if (isset($jobs)) {
                    foreach ($jobs as $job) {
                        $contents .= '<div id="wpjobportal-module-datalist" class="wjportal-jobs-list">';
                            $contents .= '<div class="wjportal-jobs-list-top-wrp">';
                                $contents .= '<div class="wjportal-jobs-logo">';
                                    $c_l = wpjobportal::makeUrl(array('wpjobportalme'=>'company', 'wpjobportallt'=>'viewcompany', 'wpjobportalid'=>$job->companyaliasid, 'wpjobportalpageid'=>wpjobportal::getPageid()));
                                    if($job->logofilename == ''){
                                        $logo = WPJOBPORTAL_PLUGIN_URL . '/includes/images/default_logo.png';
                                    }else{
                                        $data_directory = WPJOBPORTALincluder::getJSModel('configuration')->getConfigurationByConfigName('data_directory');
                                        $logo = $wpdir['baseurl'] . '/' . $data_directory . '/data/employer/comp_' . $job->companyid . '/logo/' . $job->logofilename;
                                    }
                                    $contents .= '<a href=' . $c_l . '><img src="' . $logo . '"  /></a>';
                                $contents .= '</div>';
                                $an_link = wpjobportal::makeUrl(array('wpjobportalme'=>'job', 'wpjobportallt'=>'viewjob', 'wpjobportalid'=>$job->jobaliasid, 'wpjobportalpageid'=>wpjobportal::getPageid()));
                                $contents .= '<div class="wjportal-jobs-cnt-wrp">
                                                <div class="wjportal-jobs-middle-wrp">
                                                    <div class="wjportal-jobs-data">
                                                        <a href="#" class="wjportal-companyname" title="'. __("Company Name","wp-job-portal") .'">
                                                            '. __("Company Name","wp-job-portal") .'
                                                        </a>
                                                    </div>
                                                    <div class="wjportal-jobs-data">
                                                        <span class="wjportal-job-title">
                                                            <a href="' . $an_link . '">
                                                                ' . $job->title . '
                                                            </a>
                                                        </span>
                                                    </div>
                                                    <div class="wjportal-jobs-data">
                                                        <span class="wjportal-jobs-data-text">
                                                            '. $job->cat_title .'
                                                        </span>
                                                        <span class="wjportal-jobs-data-text">
                                                            '. $job->location .'
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="wjportal-jobs-right-wrp">
                                                    <div class="wjportal-jobs-info">';
                                                        $tagname = 'New';
                                                        $tagcolor = '#00A859';
                                                        $textcolor = '#fff';
                                                        if ($typetag == 1) {
                                                            $tagname = 'New';
                                                            $tagcolor = '#00A859';
                                                            $textcolor = '#fff';
                                                        } elseif ($typetag == 2) {
                                                            $tagname = 'Top';
                                                            $tagcolor = '#EFCEC5';
                                                            $textcolor = '#0085BA';
                                                        } elseif ($typetag == 3) {
                                                            $tagname = 'Hot';
                                                            $tagcolor = '#DC143C';
                                                            $textcolor = '#fff';
                                                        } elseif ($typetag == 4) {
                                                            $tagname = 'Gold';
                                                            $tagcolor = '#D6B043';
                                                            $textcolor = '#fff';
                                                        } elseif ($typetag == 5) {
                                                            $tagname = 'Featured';
                                                            $tagcolor = '#378AD8';
                                                            $textcolor = '#fff';
                                                        }
                                                        $contents .= '<span class="wjportal-job-type" style="background:'.$tagcolor.';color:'.$textcolor.';">'. $tagname .'</span>
                                                    </div>

                                                    <div class="wjportal-jobs-info">
                                                        <div class="wjportal-jobs-salary">
                                                            '. __("0 $","wp-job-portal") .'
                                                            <span class="wjportal-salary-type">
                                                                '. __(" / Per Month", "wp-job-portal") .'
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <div class="wjportal-jobs-info">
                                                        '.human_time_diff(strtotime($job->created)).' '.__("Ago",'wp-job-portal')  .'
                                                    </div>
                                                </div>
                                            </div>';
                            $contents .= '</div>';
                        $contents .= '</div>';
                    }
                }

                $contentswrapperend = '</div>';
            /*}*/
            return $contentswrapperstart . $contents . $contentswrapperend;
        }
    }

      function getCompanies_WidgetHtml($title,$layoutName, $companies, $noofcompanies, $listingstyle,$companytype,$no_of_columns){
        $dateformat = wpjobportal::$_configuration['date_format'];

        $moduleName = $layoutName;
        $moduleheight = '500';
        $contentswrapperstart = '';
        $contents = '';
        $class = ' visible-all';
        if ($companies) {
            /*if ($listingstyle == 1) {*/ //list style
                $contentswrapperstart .= '<div id="wpjobportal_module_wrapper" class="' . $moduleName . '" >';
                    $contentswrapperstart .= '
                                        <div id="tp_heading">
                                            <span id="tp_headingtext">
                                                <span id="tp_headingtext_center">' . $title . '</span>
                                            </span>
                                        </div>
                                    ';
                $wpdir = wp_upload_dir();
                if (isset($companies)) {
                    foreach ($companies as $company) {
                        $color = ($company->status == 1) ? "green" : "red";
                        if ($company->status == 1) {
                            $statusCheck = __('Approved', 'wp-job-portal');
                        } elseif ($company->status == 0) {
                            $statusCheck = __('Waiting for approval', 'wp-job-portal');
                        }elseif($company->status == 2){
                             $statusCheck = __('Pending For Approval of Payment', 'wp-job-portal');
                        }elseif ($company->status == 3) {
                            $statusCheck = __('Pending Due To Payment', 'wp-job-portal');
                        }else {
                            $statusCheck = __('Rejected', 'wp-job-portal');
                        }
                         if(in_array('multicompany', wpjobportal::$_active_addons)){
                            $mod = "multicompany";
                        }else{
                            $mod = "company";
                        }
                        $contents .= '<div id="wpjobportal-module-datalist" class="wjportal-company-list">';
                            $contents .= '<div class="wjportal-company-list-top-wrp">';
                                $contents .= '<div class="wjportal-company-logo">';
                                    $c_l = wpjobportal::makeUrl(array('wpjobportalme'=>'company', 'wpjobportallt'=>'viewcompany', 'wpjobportalid'=>$company->alias, 'wpjobportalpageid'=>wpjobportal::getPageid()));
                                    if($company->logofilename == ''){
                                        $logo = WPJOBPORTAL_PLUGIN_URL . '/includes/images/default_logo.png';
                                    }else{
                                        $data_directory = WPJOBPORTALincluder::getJSModel('configuration')->getConfigurationByConfigName('data_directory');
                                        $logo = $wpdir['baseurl'] . '/' . $data_directory . '/data/employer/comp_' . $company->id . '/logo/' . $company->logofilename;
                                    }
                                    $contents .= '<a href=' . $c_l . '><img src="' . $logo . '"  /></a>';
                                $contents .= '</div>';
                                $contents .= '<div class="wjportal-company-cnt-wrp">';
                                    $contents .= '<div class="wjportal-company-middle-wrp">
                                                    <div class="wjportal-company-data">
                                                        <a class="wjportal-companyname" href="' . $company->url . '">
                                                            ' . $company->url . '
                                                        </a>
                                                    </div>
                                                    <div class="wjportal-company-data">
                                                        <span class="wjportal-company-title">
                                                            <a href="' . $c_l . '">
                                                                ' . $company->name . '
                                                            </a>
                                                        </span>
                                                    </div>
                                                    <div class="wjportal-company-data">
                                                        <div class="wjportal-company-data-text">
                                                            <span class="wjportal-company-data-title">'. __("Created","wp-job-portal") .':</span>
                                                            <span class="wjportal-company-data-value">'. human_time_diff(strtotime($company->created)).' '.__("Ago",'wp-job-portal') .':</span>
                                                        </div>
                                                        <div class="wjportal-company-data-text">
                                                            <span class="wjportal-company-data-title">'. __("Status","wp-job-portal") .':</span>
                                                            <span class="wjportal-company-data-value '.$color.' ">'. __($statusCheck,"wp-job-portal") .'</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="wjportal-company-right-wrp">
                                                    <div class="wjportal-company-action">
                                                        <a href="'.wpjobportal::makeUrl(array('wpjobportalme'=>$mod, 'wpjobportallt'=>'viewcompany','wpjobportalpageid'=>wpjobportal::getPageid() ,'wpjobportalid'=>$company->companyaliasid)).'" class="wjportal-company-act-btn" title="'. __("View Company","wp-job-portal") .'">
                                                            '. __("View Company","wp-job-portal") .'
                                                        </a>
                                                    </div>
                                                </div>
                                                ';
                                    $contents .= '</div>';
                                $contents .= '</div>';
                            $contents .= '</div>';
                        $contents .= '</div>';
                    }
                }

                $contentswrapperend = '</div>';
            /*} */
            return $contentswrapperstart . $contents . $contentswrapperend;
        }else{
            $html = '<div id="tp_heading">
                        <span id="tp_headingtext">
                                <span id="tp_headingtext_left"></span>
                                <span id="tp_headingtext_center">' . __("No Record Found","wp-job-portal") . '</span>
                                <span id="tp_headingtext_right"></span>
                        </span>
                    </div>';
            return $html;
        }
    }

    function getResume_WidgetHtml($title,$layoutName, $resumes, $noofresumes, $listingstyle,$resumetype,$no_of_columns){
        $dateformat = wpjobportal::$_configuration['date_format'];

        $moduleName = $layoutName;
        $moduleheight = '500';
        $contentswrapperstart = '';
        $contents = '';
        $class = ' visible-all';
        $data_directory = WPJOBPORTALincluder::getJSModel('configuration')->getConfigurationByConfigName('data_directory');
        if ($resumes) {
            /*if ($listingstyle == 1) {*/ //list style
                $contentswrapperstart .= '<div id="wpjobportal_module_wrapper" class="' . $moduleName . '" >';
                    $contentswrapperstart .= '
                                        <div id="tp_heading">
                                            <span id="tp_headingtext">
                                                    <span id="tp_headingtext_center">' . $title . '</span>
                                            </span>
                                        </div>
                                    ';
                $wpdir = wp_upload_dir();
                if (isset($resumes)) {
                    foreach ($resumes as $resume) {
                        $contents .= '<div id="wpjobportal-module-datalist" class="wjportal-resume-list">';
                            $contents .= '<div class="wjportal-resume-list-top-wrp">';
                                $contents .= '<div class="wjportal-resume-logo">';
                                    $c_l = wpjobportal::makeUrl(array('wpjobportalme'=>'resume', 'wpjobportallt'=>'viewresume', 'wpjobportalid'=>$resume->resumealiasid, 'wpjobportalpageid'=>wpjobportal::getPageid()));
                                    if($resume->photo == ''){
                                        $logo = WPJOBPORTAL_PLUGIN_URL . '/includes/images/users.png';
                                    }else{
                                        $logo = $wpdir['baseurl'] . '/' . $data_directory . '/data/jobseeker/resume_' . $resume->resumeid . '/photo/' . $resume->photo;
                                    }
                                    $contents .= '<a href=' . $c_l . '><img class="wpjobportal-module-datalist-img" src="' . $logo . '"  /></a>';
                                $contents .= '</div>';
                                $contents .= '<div class="wjportal-resume-cnt-wrp">
                                                <div class="wjportal-resume-middle-wrp">
                                                    <div class="wjportal-resume-data">
                                                        <span class="wjportal-resume-job-type" style="background:'.$resume->jobtypecolor.'">
                                                            ' . $resume->jobtypetitle . '
                                                        </span>
                                                    </div>
                                                    <div class="wjportal-resume-data">
                                                        <a class="wpjobportal-module-datalist-anchor" href="' . $c_l . '">
                                                            <span class="wjportal-resume-name">
                                                                ' . $resume->name . '
                                                            </span>
                                                        </a>
                                                    </div>
                                                    <div class="wjportal-resume-data">
                                                        <span class="wjportal-resume-title">
                                                            '. $resume->applicationtitle .'
                                                        </span>
                                                    </div>
                                                    <div class="wjportal-resume-data">';
                                                        if(isset($resume->location) && !empty($resume->location)){
                                                            $contents .= '<div class="wjportal-resume-data-text">
                                                                        <span class="wjportal-resume-data-title">'. __("Location","wp-job-portal") .':</span>
                                                                        <span class="wjportal-resume-data-value">'. $resume->location .'</span>
                                                                    </div>';
                                                       }
                                                    $contents .='    <div class="wjportal-resume-data-text">
                                                            <span class="wjportal-resume-data-title">'. __("Experience","wp-job-portal") .':</span>
                                                            <span class="wjportal-resume-data-value">'.wpjobportal::$_common->getTotalExp($resume->resumeid).'</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="wjportal-resume-right-wrp">
                                                    <div class="wjportal-resume-action">
                                                        <a href="#" class="wjportal-resume-act-btn" title="' . __("View Profile","wp-job-portal") . '">
                                                            ' . __("View Profile","wp-job-portal") . '
                                                        </a>
                                                    </div>
                                                </div>
                                        ';
                                $contents .= '</div>';
                            $contents .= '</div>';
                        $contents .= '</div>';
                    }
                }
                 $contentswrapperend = '</div>';
            /*}*/
            return $contentswrapperstart . $contents . $contentswrapperend;
        }else{
            $html = '<div id="tp_heading">
                        <span id="tp_headingtext">
                                <span id="tp_headingtext_left"></span>
                                <span id="tp_headingtext_center">' . __("No Record Found","wp-job-portal") . '</span>
                                <span id="tp_headingtext_right"></span>
                        </span>
                    </div>';
            return $html;
        }
    }

    function getSearchJobs_WidgetHTML($title, $showtitle, $fieldtitle, $category, $jobtype, $jobstatus, $salaryrange, $shift, $duration, $startpublishing, $stoppublishing, $company, $address, $columnperrow) {

        if ($columnperrow <= 0)
            $columnperrow = 1;
        $width = round(100 / $columnperrow);
        $style = "style='width:" . $width . "%'";

        $html = '
                <div id="wpjobportal_module_wrapper">';
        if ($showtitle == 1) {
            $html .= '<div id="tp_heading" class="">
                        <span id="tp_headingtext">
                            <span id="tp_headingtext_center">' . $title . '</span>
                        </span>
                    </div>';
        }
        $html .='<div class="wjportal-form-wrp wjportal-search-job-form">';
        $html .='<form class="job_form wjportal-form" id="job_form" method="post" action="' . wpjobportal::makeUrl(array('wpjobportalme'=>'job', 'wpjobportallt'=>'jobs', 'wpjobportalpageid'=>wpjobportal::getPageid())) . '">';

        if ($fieldtitle == 1) {
            $title = __('Title', 'wp-job-portal');
            $value = WPJOBPORTALformfield::text('jobtitle', '', array('class' => 'inputbox wjportal-form-input-field'));
            $html .= '<div class="wjportal-form-row" ' . $style . '>
                <div class="wjportal-form-title">' . $title . '</div>
                <div class="wjportal-form-value">' . $value . '</div>
            </div>';
        }

        if ($category == 1) {
            $title = __('Category', 'wp-job-portal');
            $value = WPJOBPORTALformfield::select('category[]', WPJOBPORTALincluder::getJSModel('category')->getCategoriesForCombo(), isset(wpjobportal::$_data[0]['filter']->category) ? wpjobportal::$_data[0]['filter']->category : '', __('Select','wp-job-portal') .' '. __('Category', 'wp-job-portal'), array('class' => 'inputbox wjportal-form-select-field'));
            $html .= '<div class="wjportal-form-row" ' . $style . '>
                <div class="wjportal-form-title">' . $title . '</div>
                <div class="wjportal-form-value">' . $value . '</div>
            </div>';
        }

        if ($jobtype == 1) {
            $title = __('Job Type', 'wp-job-portal');
            $value = WPJOBPORTALformfield::select('jobtype[]', WPJOBPORTALincluder::getJSModel('jobtype')->getJobTypeForCombo(), isset(wpjobportal::$_data[0]['filter']->jobtype) ? wpjobportal::$_data[0]['filter']->jobtype : '', __('Select','wp-job-portal') .' '. __('Job Type', 'wp-job-portal'), array('class' => 'inputbox wjportal-form-select-field'));
            $html .= '<div class="wjportal-form-row" ' . $style . '>
                <div class="wjportal-form-title">' . $title . '</div>
                <div class="wjportal-form-value">' . $value . '</div>
            </div>';
        }
        if ($jobstatus == 1) {
            $title = __('Job Status', 'wp-job-portal');
            $value = WPJOBPORTALformfield::select('jobstatus[]', WPJOBPORTALincluder::getJSModel('jobstatus')->getJobStatusForCombo(), isset(wpjobportal::$_data[0]['filter']->jobstatus) ? wpjobportal::$_data[0]['filter']->jobstatus : '', __('Select','wp-job-portal') .' '. __('Job Status', 'wp-job-portal'), array('class' => 'inputbox wjportal-form-select-field'));
            $html .= '<div class="wjportal-form-row" ' . $style . '>
                <div class="wjportal-form-title">' . $title . '</div>
                <div class="wjportal-form-value">' . $value . '</div>
            </div>';
        }
        if ($salaryrange == 1) {
            $salarytypelist = array(
                (object) array('id'=>WPJOBPORTAL_SALARY_NEGOTIABLE,'text'=>__("Negotiable",'wp-job-portal')),
                (object) array('id'=>WPJOBPORTAL_SALARY_FIXED,'text'=>__("Fixed",'wp-job-portal')),
                (object) array('id'=>WPJOBPORTAL_SALARY_RANGE,'text'=>__("Range",'wp-job-portal')),
            );
            $title = __('Salary Range', 'wp-job-portal');
            $value = WPJOBPORTALformfield::select('salarytype', $salarytypelist,'', __("Select",'wp-job-portal').' '.__("Salary Type",'wp-job-portal'), array('class' => 'inputbox sal wjportal-form-select-field'));
            $value .= WPJOBPORTALformfield::text('salaryfixed','', array('class' => 'inputbox sal wjportal-form-input-field','placeholder'=> __('e.g 45000','wp-job-portal')));
            $value .=  WPJOBPORTALformfield::text('salarymin', '', array('class' => 'inputbox sal wjportal-form-input-field','placeholder'=> __('e.g 3000','wp-job-portal')));
            $value .=  WPJOBPORTALformfield::text('salarymax', '', array('class' => 'inputbox sal wjportal-form-input-field','placeholder'=> __('e.g 6000','wp-job-portal')));
            $value .= WPJOBPORTALformfield::select('salaryduration', WPJOBPORTALincluder::getJSModel('salaryrangetype')->getSalaryRangeTypesForCombo(), WPJOBPORTALincluder::getJSModel('salaryrangetype')->getDefaultSalaryRangeTypeId(), __('Select','wp-job-portal'), array('class' => 'inputbox sal wjportal-form-select-field'));
            $html .= '<div class="wjportal-form-row" ' . $style . '>
                        <div class="wjportal-form-title">' . $title . '</div>
                        <div class="wjportal-form-value">
                                <div class="wjportal-form-5-fields">
                                    <div class="wjportal-form-inner-fields">
                                        '.WPJOBPORTALformfield::select('salarytype', $salarytypelist,'', __("Select",'wp-job-portal').' '.__("Salary Type",'wp-job-portal'), array('class' => 'inputbox sal wjportal-form-select-field')).'
                                    </div>
                                    <div class="wjportal-form-inner-fields">
                                        '.WPJOBPORTALformfield::text('salaryfixed','', array('class' => 'inputbox sal wjportal-form-input-field','placeholder'=> __('e.g 45000','wp-job-portal'))).'
                                    </div>
                                    <div class="wjportal-form-inner-fields">
                                        '.WPJOBPORTALformfield::text('salarymin', '', array('class' => 'inputbox sal wjportal-form-input-field','placeholder'=> __('e.g 3000','wp-job-portal'))).'
                                    </div>
                                    <div class="wjportal-form-inner-fields">
                                        '.WPJOBPORTALformfield::text('salarymax', '', array('class' => 'inputbox sal wjportal-form-input-field','placeholder'=> __('e.g 6000','wp-job-portal'))).'
                                    </div>
                                    <div class="wjportal-form-inner-fields">
                                        '.WPJOBPORTALformfield::select('salaryduration', WPJOBPORTALincluder::getJSModel('salaryrangetype')->getSalaryRangeTypesForCombo(), WPJOBPORTALincluder::getJSModel('salaryrangetype')->getDefaultSalaryRangeTypeId(), __('Select','wp-job-portal'), array('class' => 'inputbox sal wjportal-form-select-field')).'
                                    </div>
                                </div>
                        </div>
            </div>';
        }
        if ($duration == 1) {
            $title = __('Duration', 'wp-job-portal');
            $value = WPJOBPORTALformfield::text('duration', isset(wpjobportal::$_data[0]['filter']->duration) ? wpjobportal::$_data[0]['filter']->duration : '', array('class' => 'inputbox wjportal-form-input-field'));
            $html .= '<div class="wjportal-form-row" ' . $style . '>
                <div class="wjportal-form-title">' . $title . '</div>
                <div class="wjportal-form-value">' . $value . '</div>
            </div>';
        }
        if ($startpublishing == 1) {

        }
        if ($stoppublishing == 1) {

        }
        if ($company == 1) {
            $title = __('Company', 'wp-job-portal');
            $value = WPJOBPORTALformfield::select('company[]', WPJOBPORTALincluder::getJSModel('company')->getCompaniesForCombo(), isset(wpjobportal::$_data[0]['filter']->company) ? wpjobportal::$_data[0]['filter']->company : '', __('Select','wp-job-portal') .' '. __('Company', 'wp-job-portal'), array('class' => 'inputbox wjportal-form-select-field'));
            $html .= '<div class="wjportal-form-row" ' . $style . '>
                <div class="wjportal-form-title">' . $title . '</div>
                <div class="wjportal-form-value">' . $value . '</div>
            </div>';
        }
        if ($address == 1) {
            $title = __('City', 'wp-job-portal');
            $value = WPJOBPORTALformfield::text('city', isset(wpjobportal::$_data[0]['filter']->city) ? wpjobportal::$_data[0]['filter']->city : '', array('class' => 'inputbox wjportal-form-input-field'));
            $html .= '<div class="wjportal-form-row" ' . $style . '>
                <div class="wjportal-form-title">' . $title . '</div>
                <div class="wjportal-form-value">' . $value . '</div>
            </div>';
        }

        $html .= '<div class="wjportal-form-btn-wrp">
                        <div class="wjportal-form-2-btn">
                            ' . WPJOBPORTALformfield::submitbutton('save', __('Search Job', 'wp-job-portal'), array('class' => 'button wjportal-form-btn wjportal-form-srch-btn')) . '
                        </div>
                        <div class="wjportal-form-2-btn">
                            <a class="anchor wjportal-form-btn wjportal-form-cancel-btn" href="' . wpjobportal::makeUrl(array('wpjobportalme'=>'jobsearch', 'wpjobportallt'=>'jobsearch', 'wpjobportalpageid'=>wpjobportal::getPageid())) . '">
                            ' . __('Advance Search', 'wp-job-portal') . '
                            </a>
                        </div>
                    </div>
                    <input type="hidden" id="issearchform" name="issearchform" value="1"/>
                    <input type="hidden" id="WPJOBPORTAL_form_search" name="WPJOBPORTAL_form_search" value="WPJOBPORTAL_SEARCH"/>
                    <input type="hidden" id="wpjobportallay" name="wpjobportallay" value="jobs"/>
                </form>
            </div>

            <script >
                function getTokenInput() {
                    var cityArray = "' . admin_url("admin.php?page=wpjobportal_city&action=wpjobportaltask&task=getaddressdatabycityname") . '";
                    jQuery("#city").tokenInput(cityArray, {
                        theme: "wpjobportal",
                        preventDuplicates: true,
                        hintText: "' . __('Type In A Search Term', 'wp-job-portal') . '",
                        noResultsText: "' . __('No Results', 'wp-job-portal') . '",
                        searchingText: "' . __('Searching', 'wp-job-portal') . '"
                    });
                }
                jQuery(document).ready(function(){
                    getTokenInput();
                });
                jQuery(document).delegate("#salarytype", "change", function(){
                    var salarytype = jQuery(this).val();
                    if(salarytype == 1){ //negotiable
                        jQuery("#salaryfixed").hide();
                        jQuery("#salarymin").hide();
                        jQuery("#salarymax").hide();
                        jQuery("#salaryduration").hide();
                        jQuery(".wjportal-form-symbol").hide();
                    }else if(salarytype == 2){ //fixed
                        jQuery("#salaryfixed").show();
                        jQuery("#salarymin").hide();
                        jQuery("#salarymax").hide();
                        jQuery("#salaryduration").show();
                        jQuery(".wjportal-form-symbol").show();
                    }else if(salarytype == 3){ //range
                        jQuery("#salaryfixed").hide();
                        jQuery("#salarymin").show();
                        jQuery("#salarymax").show();
                        jQuery("#salaryduration").show();
                        jQuery(".wjportal-form-symbol").show();
                    }else{ //not selected
                        jQuery("#salaryfixed").hide();
                        jQuery("#salarymin").hide();
                        jQuery("#salarymax").hide();
                        jQuery("#salaryduration").hide();
                        jQuery(".wjportal-form-symbol").hide();
                    }
                });

                jQuery("#salarytype").change();
            </script>
            ';




        return $html;
    }
    function getMessagekey(){
        $key = 'wpjobportalwidgets';if(wpjobportal::$_common->wpjp_isadmin()){$key = 'admin_'.$key;}return $key;
    }


}
?>
