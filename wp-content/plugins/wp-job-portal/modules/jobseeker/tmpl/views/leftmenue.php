<?php
/**
 * @param job      job object - optional
*/
?>
<?php
foreach ($layout as $key => $value) {
    switch ($value) {
        case 'jsregister':
            if(WPJOBPORTALincluder::getObjectClass('user')->isguest()){
                $print = jobseekercheckLinks($value);
                if ($print) {
                    $defaultUrl = wpjobportal::makeUrl(array('wpjobportalme'=>'user', 'wpjobportallt'=>'regjobseeker'));
                    $lrlink = WPJOBPORTALincluder::getJSModel('configuration')->getLoginRegisterRedirectLink($defaultUrl,'register');
                    echo '<div class="wjportal-cp-list">
                            <a class="wjportal-list-anchor" href='.$lrlink.' title="'. __('Register', 'wp-job-portal') .'">
                                <img src='. WPJOBPORTAL_PLUGIN_URL.'includes/images/control_panel/jobseeker/registers.png alt="'. __('register', 'wp-job-portal') .'">
                                <span class="wjportal-cp-link-text">'. __('Register', 'wp-job-portal') .'</span>
                            </a>
                    </div>';
                   
                } 
            }else{ 
           }
        break;
        case 'myappliedjobs':
            $print = jobseekercheckLinks($value);
            if ($print) {
                echo' <div class="wjportal-cp-list">
                        <a class="wjportal-list-anchor" href='. wpjobportal::makeUrl(array('wpjobportalme'=>'jobapply', 'wpjobportallt'=>$value)).' title="'. __('my applied jobs', 'wp-job-portal').'"> 
                            <img src='. WPJOBPORTAL_PLUGIN_URL.'includes/images/control_panel/jobseeker/applied-jobs.png alt="'. __('my applied jobs', 'wp-job-portal').'">
                            <span class="wjportal-cp-link-text">'. __('My Applied Jobs', 'wp-job-portal').'</span>
                        </a>
                    </div>';
            }
        break;
        case 'listjobshortlist':
            if(in_array('shortlist',wpjobportal::$_active_addons)){
                do_action('wpjobportal_addons_jobseeker_dashboard_bottom_btn_shortlist',$value);
            }
        break;
        case 'myresumes':
            $print = jobseekercheckLinks($value);
                if ($print && in_array('multiresume', wpjobportal::$_active_addons)) {
                    do_action('wpjobportal_addons_multiresume_myresume',$print);
                }else{
                    if($print){
                        echo '<div class="wjportal-cp-list">
                                <a class="wjportal-list-anchor" href='. wpjobportal::makeUrl(array('wpjobportalme'=>'resume', 'wpjobportallt'=>'myresumes')).'><img src='. WPJOBPORTAL_PLUGIN_URL.'includes/images/control_panel/jobseeker/resume.png><span class="wjportal-cp-link-text">'. __('My Resumes', 'wp-job-portal').'</span></a>
                            </div>';
                    }
                }
        break;
        case 'newestjobs':
            $print = jobseekercheckLinks('listnewestjobs');
            if ($print) {
                echo '<div class="wjportal-cp-list">
                        <a class="wjportal-list-anchor" href='. wpjobportal::makeUrl(array('wpjobportalme'=>'job', 'wpjobportallt'=>'newestjobs')).' title="'. __('newest jobs', 'wp-job-portal').'">
                            <img src='. WPJOBPORTAL_PLUGIN_URL.'includes/images/control_panel/jobseeker/add-job.png alt="'. __('newest jobs', 'wp-job-portal').'">
                            <span class="wjportal-cp-link-text">'. __('Newest Jobs', 'wp-job-portal').'</span>
                        </a>
                    </div>';
            }
        break;
        case 'jobsearch':
             $print = jobseekercheckLinks($value);
            if ($print) {
                echo '<div class="wjportal-cp-list">
                        <a class="wjportal-list-anchor" href='.wpjobportal::makeUrl(array('wpjobportalme'=>'jobsearch', 'wpjobportallt'=>$value)).' title="'. __('search job', 'wp-job-portal').'">
                            <img src='. WPJOBPORTAL_PLUGIN_URL.'includes/images/control_panel/jobseeker/search.png>
                            <span class="wjportal-cp-link-text">'. __('Search Job', 'wp-job-portal').'</span>
                        </a>
                </div>';
            }   
        break;
        case 'jsmessages':
            $print = jobseekercheckLinks('jsmessages');
           do_action('wpjobportal_addons_jobseeker_dashboard_bottom_btn',$print);
            break;
        case 'mycoverletter':
            //$print = jobseekercheckLinks('mycoverletter');
            do_action('wpjobportal_addons_jobseeker_dashboard_side_menue_coverletter');
            break;
        case 'empresume_rss':
            do_action('wpjobportal_addons_jobseeker_dashboard_bottom_btn_rss');
            break;
        case 'invoice':
            do_action('wpjobportal_addons_credit_cp_leftmenue_jobseeker');
            break;
        case 'jobcat':
            $print = jobseekercheckLinks($value);
                if ($print) {
                    echo '<div class="wjportal-cp-list">
                            <a class="wjportal-list-anchor" href='. wpjobportal::makeUrl(array('wpjobportalme'=>'job', 'wpjobportallt'=>'jobsbycategories')).' title="'. __('jobs by categories', 'wp-job-portal').'">
                                <img class="wjportal-img" src='. WPJOBPORTAL_PLUGIN_URL.'includes/images/control_panel/jobseeker/job-category.png alt="'. __('jobs by categories', 'wp-job-portal').'">
                                <span class="wjportal-cp-link-text">'. __('Jobs By Categories', 'wp-job-portal').'</span>
                            </a>
                    </div>';
               }
        break;
        case 'listjobbytype':
            $print = jobseekercheckLinks($value);
            if ($print) {
            echo '<div class="wjportal-cp-list">
                    <a class="wjportal-list-anchor" href='. wpjobportal::makeUrl(array('wpjobportalme'=>'job', 'wpjobportallt'=>'jobsbytypes')).' title="'. __('jobs by types', 'wp-job-portal').'">
                    <img class="wjportal-img" src='. WPJOBPORTAL_PLUGIN_URL.'includes/images/control_panel/jobseeker/job-type.png alt="'. __('jobs by types', 'wp-job-portal').'">
                    <span class="wjportal-cp-link-text">'. __('Jobs By Types', 'wp-job-portal').'</span></a>
                </div>';
            }
        break;
        case 'listallcompanies':
            $print = jobseekercheckLinks($value);
            if ($print) {
            echo '<div class="wjportal-cp-list">
                    <a class="wjportal-list-anchor" href='. wpjobportal::makeUrl(array('wpjobportalme'=>'multicompany', 'wpjobportallt'=>'companies')).' title="'. __('Companies', 'wp-job-portal').'">
                    <img class="wjportal-img" src='. WPJOBPORTAL_PLUGIN_URL.'includes/images/control_panel/jobseeker/companies.png alt="'. __('Companies', 'wp-job-portal').'">
                    <span class="wjportal-cp-link-text">'. __('Companies', 'wp-job-portal').'</span></a>
                </div>';
            }
        break;
        case 'jobsbycities':
            $print = jobseekercheckLinks($value);
            if ($print) {
            echo '<div class="wjportal-cp-list">
                    <a class="wjportal-list-anchor" href='. wpjobportal::makeUrl(array('wpjobportalme'=>'job', 'wpjobportallt'=>'jobsbycities')).' title="'. __('jobs by cities', 'wp-job-portal').'">
                    <img class="wjportal-img" src='. WPJOBPORTAL_PLUGIN_URL.'includes/images/control_panel/jobseeker/job-city.png alt="'. __('jobs by cities', 'wp-job-portal').'">
                    <span class="wjportal-cp-link-text">'. __('Jobs By Cities', 'wp-job-portal').'</span></a>
                </div>';
            }
        break;

        case 'formresume':
        $count = '';
        if(!empty(wpjobportal::$_data[0]['resume']['info']) && wpjobportal::$_data[0]['resume']['info']!=NULL){
           $resumeid =  wpjobportal::$_data[0]['resume']['info'][0]->resumeid;
           $count =wpjobportal::$_data[0]['resume']['info'][0]->resumeno;
        }   
            if(in_array('multiresume', wpjobportal::$_active_addons)){
                do_action('wpjobportal_addons_multiresume_addresume',$value);
            }else{
                $print = jobseekercheckLinks($value);
                    if ($print) {
                        if($count>0){
                            echo '<div class="wjportal-cp-list">
                                    <a class="wjportal-list-anchor" href='. wpjobportal::makeUrl(array('wpjobportalme'=>'resume', 'wpjobportallt'=>'addresume','wpjobportalid' => $resumeid)).' title="'. __('edit resume', 'wp-job-portal').'">
                                        <img class="wjportal-img" src='.WPJOBPORTAL_PLUGIN_URL.'includes/images/control_panel/jobseeker/add-resume.png alt="'. __('edit resume', 'wp-job-portal').'">
                                        <span class="wjportal-cp-link-text">'. __('Edit Resume', 'wp-job-portal').'</span>
                                    </a>
                            </div>';
                        }
                        else{
                            $print = jobseekercheckLinks($value);
                            if ($print) {
                                   echo '<div class="wjportal-cp-list">
                                            <a class="wjportal-list-anchor" href='. wpjobportal::makeUrl(array('wpjobportalme'=>'resume', 'wpjobportallt'=>'addresume')).' title="'. __('add resume', 'wp-job-portal').'">
                                                <img class="wjportal-img" src='. WPJOBPORTAL_PLUGIN_URL.'includes/images/control_panel/jobseeker/add-resume.png alt="'. __('add resume', 'wp-job-portal').'">
                                                <span class="wjportal-cp-link-text">'. __('Add Resume', 'wp-job-portal').'</span>
                                            </a>
                                    </div>';
                                }
                           
                        }
                    }
            }
            
        break;
        case 'jobsloginlogout':
            if (jobseekercheckLinks($value) ) {
                if (WPJOBPORTALincluder::getObjectClass('user')->isguest() && (!isset($_COOKIE['wpjobportal-socialmedia']) && empty($_COOKIE['wpjobportal-socialmedia']))) {
                        $thiscpurl = wpjobportal::makeUrl(array('wpjobportalme'=>'jobseeker', 'wpjobportallt'=>'controlpanel', 'wpjobportalpageid'=>wpjobportal::getPageid()));
                        $thiscpurl = wpjobportalphplib::wpJP_safe_encoding($thiscpurl);
                        $defaultUrl = wpjobportal::makeUrl(array('wpjobportalme'=>'wpjobportal', 'wpjobportallt'=>'login', 'wpjobportalredirecturl'=>$thiscpurl, 'wpjobportalpageid'=>wpjobportal::getPageid()));
                        $lrlink = WPJOBPORTALincluder::getJSModel('configuration')->getLoginRegisterRedirectLink($defaultUrl,'login');
                    echo '<div class="wjportal-cp-list">
                            <a class="wjportal-list-anchor" href='.$lrlink.' title="'.__('login', 'wp-job-portal').'">
                                <img class="wjportal-img" src='. WPJOBPORTAL_PLUGIN_URL.'includes/images/control_panel/jobseeker/login.png alt="'.__('login', 'wp-job-portal').'">
                                <span class="wjportal-cp-link-text">'.__('Login', 'wp-job-portal').'</span>
                            </a>
                        </div>';
                } else {
                    if(isset($_COOKIE['wpjobportal-socialmedia']) && !empty($_COOKIE['wpjobportal-socialmedia'])){
                        do_action('wpjobportal_addons_social_logout');
                    } else{
                    echo '<div class="wjportal-cp-list">
                            <a class="wjportal-list-anchor" href='. wp_logout_url(get_permalink()).' title="'. __('logout', 'wp-job-portal').'">
                                <img class="wjportal-img" src='.WPJOBPORTAL_PLUGIN_URL.'includes/images/control_panel/jobseeker/logout.png alt="'. __('logout', 'wp-job-portal').'">
                                <span class="wjportal-cp-link-text">'. __('Logout', 'wp-job-portal').'</span>
                            </a>
                        </div>';
                    }
                }
            }
        break;
        }
}
