<?php
/**
 * @param module 		module name - optional
 * module => id
 *layouts => from which layouts
 *div uses for all is the same calling templates
 */
//Configuration
?>
<?php
	if ($module) {
		echo '<div class="wjportal-page-heading">';
			switch ($layout) {
				case 'company':
					if (isset($data->name) && $config_array['comp_name'] == 1) {
				 		echo __(esc_html($data->name), 'wp-job-portal');
				 		echo '<span class="wjportal-company-salogon">
		  							-'.esc_html($data->tagline).'
		                	</span>';
		            }
		        break;
				case 'mycompany':
			 		echo __('My Companies', 'wp-job-portal');
			 		/*if(in_array('multicompany',wpjobportal::$_active_addons)){
			 			echo '<a class="wjportal-header-btn" href='.wpjobportal::makeUrl(array('wpjobportalme'=>'multicompany', 'wpjobportallt'=>'addcompany')).'>'.__('Add New','wp-job-portal') .' '. __('Company', 'wp-job-portal') .'</a> ';
			 		}*/
				break;
				case 'companies':
			 		echo __('Companies', 'wp-job-portal');
				break;
				case 'myjob':
					echo __('My Jobs', 'wp-job-portal');
					//echo '<a class="wjportal-header-btn" href='. wpjobportal::makeUrl(array('wpjobportalme'=>'job', 'wpjobportallt'=>'addjob')).'>'. __('Post a Job', 'wp-job-portal').'</a>';
				break;
				case 'appliedres':
				 	echo __('Job Applied Resume', 'wp-job-portal');
				break;
				case 'jobdetail':
					echo __(esc_html($jobtitle),'wp-job-portal');
				break;
				case 'myapplied':
					echo __('My Applied Jobs','wp-job-portal');
				break;
				case 'newestjob':
					echo __('Newest Jobs', 'wp-job-portal');
				break;
				case 'jobsearch':
					echo __('Search Job', 'wp-job-portal');
				break;
				case 'companyinfo':
					echo __($company ? __('Edit Company', 'wp-job-portal') : __('Add Company', 'wp-job-portal'), 'wp-job-portal');
					break;
				case 'comp':
					echo __('Companies', 'wp-job-portal');
				break;
				case 'addcompany':
					echo __("Company Information",'wp-job-portal');
				break;
				case 'addcomp':
					echo __($job ? __('Edit Job', 'wp-job-portal') : __('Post a Job', 'wp-job-portal'), 'wp-job-portal');
				break;
				case 'folder':
					echo esc_html($msg).' '. __("Folder", 'wp-job-portal');
				break;
				case 'myfolder':
				 	echo __('My Folders', 'wp-job-portal');
		        break;
				case 'viewfolder':
					echo __('View Folder', 'wp-job-portal');
				break;
				case 'mydepartments':
					echo __('My Departments', 'wp-job-portal');
		            /*echo ' <a class="wjportal-header-btn" href='. wpjobportal::makeUrl(array('wpjobportalme'=>'departments', 'wpjobportallt'=>'adddepartment')) .'>'.  __('Add New','wp-job-portal') .' '. __('Department', 'wp-job-portal') .'</a> ';*/
				break;
				case 'viewcoverletter':
					echo __('Cover Letter Detail', 'wp-job-portal');
				break;
				case 'mycoverletters':
					echo __('My Cover Letters', 'wp-job-portal');
				break;
				case 'coverletter':
					$msg = isset($coverletter) ? __('Edit', 'wp-job-portal') : __('Add New', 'wp-job-portal');
					echo esc_html($msg) . ' ' . __('Cover Letter', 'wp-job-portal');
				break;
				case 'addjob':
					$msg = isset($job) ? __('Edit', 'wp-job-portal') : __('Add New', 'wp-job-portal');
					echo esc_html($msg) . ' ' . __('Job', 'wp-job-portal');
				break;
				case 'login':
					$msg = __('Login ', 'wp-job-portal');
					echo __(esc_html($msg), 'wp-job-portal');
				break;
				case 'departments':
					$msg = isset($departments) ? __('Edit', 'wp-job-portal') : __('Add New', 'wp-job-portal');
					echo esc_html($msg) . ' ' . __('Department', 'wp-job-portal');
				break;
				case 'viewdepartment':
					echo __('Department Detail', 'wp-job-portal');
				break;
				case 'mydepartment':
					echo __('Departments', 'wp-job-portal');
				break;
				case 'jobbycatagory':
					echo __('Jobs By Catagories', 'wp-job-portal');
					break;
				case 'reg':
					echo __('Register Your Account', 'wp-job-portal');
					break;
				case 'resumesearch':
					echo __('Resume Search', 'wp-job-portal');
					break;
				case 'resumelist':
					echo __('Resume List', 'wp-job-portal');
					break;
				case 'resumebycatagory':
					echo __('Resume By Category', 'wp-job-portal');
					break;
				case 'departmentperlisting':
					echo __('Pay per listing price to publish your '. esc_html($name) .' '.' : '.esc_html($priceDepartmentlist), 'wp-job-portal');
					break;
				case 'viewresume':
					echo __(esc_html($name),'wp-job-portal');
					break;
				case 'myresume':
					echo __(esc_html($msg),'wp-job-portal');
					break;
				case 'multiresumeadd':
				 	echo __('My Resumes', 'wp-job-portal');
					//do_action('wpjobportal_addon_resume_action_addResume');
	            	break;
	            case 'sendmessage':
				  echo __('Send Message','wp-job-portal');
					break;
				case 'message':
					echo __('Messages','wp-job-portal');
					break;
				case 'sendmessagejob':
					echo __('Job Messages','wp-job-portal');
					break;
				case 'visitorcanaddjob':
					echo esc_html($data) .' '. __("Job", 'wp-job-portal');
					break;
				case 'jobalert':
					echo __('Job Alert Info', 'wp-job-portal');
					break;
				case 'resumesearch':
					echo __('Resume Search', 'wp-job-portal');
					break;

				case 'resumesearchlist':
					echo __('Resume Saved Searches', 'wp-job-portal');
					break;
				case 'purchasehistory':
					 echo __('My Packages', 'wp-job-portal');
					break;
				case 'mysubscriptions':
					  echo __('My Subscription', 'wp-job-portal');
					break;
				case 'mypackage':
					echo __(' Packages', 'wp-job-portal');
					break;
				case 'invoice':
					echo __('My Invoices', 'wp-job-portal');
					break;
				case 'shortListedJob':
					echo __('Short Listed Jobs', 'wp-job-portal');
					break;
				case 'jobtype':
					echo __('Job By Types', 'wp-job-portal');
					break;
				case 'employer_cp':
					echo __('Dashboard','wp-job-portal');
					break;
				case 'update':
					echo __('Edit Profile', 'wp-job-portal');
					break;
				case 'folderressume':
					echo __('Folder Resume', 'wp-job-portal');
					break;
				case 'jobcities':
					echo __('Jobs By Cities', 'wp-job-portal');
					break;
			}
		echo '</div>';
		WPJOBPORTALbreadcrumbs::getBreadcrumbs();
	}
?>
