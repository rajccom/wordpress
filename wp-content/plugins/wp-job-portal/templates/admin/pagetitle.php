<?php
/**
 * @param module 		module name - optional
 * module => id
 *layouts => from which layouts
 */
?>
<?php
$html ='';
if ($module) {
	$html.= '<div id="wpjobportal-head">';
		switch ($layouts) {
			case 'controlpanel':
				$html.='<h1 class="wpjobportal-head-text">'. __('Dashboard', 'wp-job-portal').'</h1>
	        			<a class="wpjobportal-add-link orange-bg button" href="admin.php?page=wpjobportal_job&wpjobportallt=formjob" title="'. __('add job','wp-job-portal').'">
	        				<img src="'.WPJOBPORTAL_PLUGIN_URL.'includes/images/control_panel/dashboard/plus-icon.png" alt="'. __('plus icon','wp-job-portal').'" />
	        				'. __('Add Job','wp-job-portal').'
	        			</a>
	        			<a class="wpjobportal-add-link button" href="admin.php?page=wpjobportal_job" title="'. __('all jobs','wp-job-portal').'">
	        				<img src="'.WPJOBPORTAL_PLUGIN_URL.'includes/images/control_panel/dashboard/all-jobs.png" alt="'. __('all jobs','wp-job-portal').'" />
	        				'. __('All Jobs','wp-job-portal').'
	        			</a>';
			break;
			case 'shortcodes':
				$html.='<h1 class="wpjobportal-head-text">'. __('Short Codes', 'wp-job-portal').'</h1>';
			break;
			case 'help':
				$html.='<h1 class="wpjobportal-head-text">'. __('Help', 'wp-job-portal').'</h1>';
			break;
			case 'jobtype':
				$html.='<h1 class="wpjobportal-head-text">'. __('Job Types', 'wp-job-portal').'</h1>
	        			<a class="wpjobportal-add-link button" href='.admin_url('admin.php?page=wpjobportal_jobtype&wpjobportallt=formjobtype').' title="'. __('add new job type','wp-job-portal').'">
	        				<img src="'.WPJOBPORTAL_PLUGIN_URL.'includes/images/control_panel/dashboard/plus-icon.png" alt="'. __('plus icon','wp-job-portal').'" />
	        				'. __('Add New Job Type','wp-job-portal').'
	        			</a>';
			break;
			case 'slug':
				$html.='<h1 class="wpjobportal-head-text">'. __('Slug', 'wp-job-portal').'</h1>
	        			<a class="wpjobportal-add-link button" href='.admin_url('admin.php?page=wpjobportal_slug&task=resetallslugs&action=wpjobportaltask').' title="'. __('reset all','wp-job-portal').'">
	        				'. __('Reset All','wp-job-portal').'
	        			</a>';
			break;
			case 'stats':
				$html.='<h1 class="wpjobportal-head-text">'. __('Stats', 'wp-job-portal').'</h1>';
			break;
			case 'translations':
				$html.='<h1 class="wpjobportal-head-text">'. __('Translations', 'wp-job-portal').'</h1>';
			break;
			case 'systemerror':
				$html.='<h1 class="wpjobportal-head-text">'. __('Error Log', 'wp-job-portal').'</h1>';
			break;
			case 'shift':
				$html.='<h1 class="wpjobportal-head-text">'. __('Shifts', 'wp-job-portal').'</h1>
	        			<a class="wpjobportal-add-link button" href='.admin_url('admin.php?page=wpjobportal_shift&wpjobportallt=formshift').' title="'. __('add new shift','wp-job-portal').'">
	        				<img src="'.WPJOBPORTAL_PLUGIN_URL.'includes/images/control_panel/dashboard/plus-icon.png" alt="'. __('plus icon','wp-job-portal').'" />
	        				'. __('Add New Shift','wp-job-portal').'
	        			</a>';
			break;
			case 'age':
				$html.='<h1 class="wpjobportal-head-text">'. __('Age', 'wp-job-portal').'</h1>
	        			<a class="wpjobportal-add-link button" href='.admin_url('admin.php?page=wpjobportal_age&wpjobportallt=formages').' title="'. __('add new age','wp-job-portal').'">
	        				<img src="'.WPJOBPORTAL_PLUGIN_URL.'includes/images/control_panel/dashboard/plus-icon.png" alt="'. __('plus icon','wp-job-portal').'" />
	        				'. __('Add New Age','wp-job-portal').'
	        			</a>';
			break;
			case 'experience':
				$html.='<h1 class="wpjobportal-head-text">'. __('Experiences', 'wp-job-portal').'</h1>
	        			<a class="wpjobportal-add-link button" href='. admin_url('admin.php?page=wpjobportal_experience&wpjobportallt=formexperience').' title="'. __('add new experience','wp-job-portal').'">
	        				<img src="'.WPJOBPORTAL_PLUGIN_URL.'includes/images/control_panel/dashboard/plus-icon.png" alt="'. __('plus icon','wp-job-portal').'" />
	        				'. __('Add New Experience','wp-job-portal').'
	        			</a>';
			break;
			case 'currency':
				$html.='<h1 class="wpjobportal-head-text">'. __('Currency', 'wp-job-portal').'</h1>
	        			<a class="wpjobportal-add-link button" href='. admin_url('admin.php?page=wpjobportal_currency&wpjobportallt=formcurrency').' title="'. __('add new currency','wp-job-portal').'">
	        				<img src="'.WPJOBPORTAL_PLUGIN_URL.'includes/images/control_panel/dashboard/plus-icon.png" alt="'. __('plus icon','wp-job-portal').'" />
	        				'. __('Add New Currency','wp-job-portal').'
	        			</a>';
			break;
			case 'jobalert':
				$html.='<h1 class="wpjobportal-head-text">'. __('Job Alert', 'wp-job-portal').'</h1>
	        			<a class="wpjobportal-add-link button" href='. admin_url('admin.php?page=wpjobportal_jobalert&wpjobportallt=formjobalert').' title="'. __('add new job alert','wp-job-portal').'">
	        				<img src="'.WPJOBPORTAL_PLUGIN_URL.'includes/images/control_panel/dashboard/plus-icon.png" alt="'. __('plus icon','wp-job-portal').'" />
	        				'. __('Add New Job Alert','wp-job-portal').'
	        			</a>';
			break;
			case 'departmentque':
				$html.='<h1 class="wpjobportal-head-text">'. __('Departments Approval Queue', 'wp-job-portal') .'</h1>';
			break;
			case 'department':
				$html.='<h1 class="wpjobportal-head-text">'. __('Departments', 'wp-job-portal') .'</h1>
			        	<a class="wpjobportal-add-link button" href='. admin_url('admin.php?page=wpjobportal_departments&wpjobportallt=formdepartment').' title="'. __('add new department','wp-job-portal').'">
			        		<img src="'.WPJOBPORTAL_PLUGIN_URL.'includes/images/control_panel/dashboard/plus-icon.png" alt="'. __('plus icon','wp-job-portal').'" />
			        		'. __('Add New Department','wp-job-portal').'
		        		</a>';
			break;
			case 'company':
				$html.='<h1 class="wpjobportal-head-text">'.__('Companies', 'wp-job-portal').'</h1>
	    				<a class="wpjobportal-add-link button" href='. admin_url('admin.php?page=wpjobportal_company&wpjobportallt=formcompany').' title="'. __('add new company','wp-job-portal').'">
	    					<img src="'.WPJOBPORTAL_PLUGIN_URL.'includes/images/control_panel/dashboard/plus-icon.png" alt="'. __('plus icon','wp-job-portal').'" />
	    					'. __('Add New Company','wp-job-portal').'
						</a>';
			break;
			case 'companyque':
				$html.='<h1 class="wpjobportal-head-text">'. __('Companies Approval Queue', 'wp-job-portal').'</h1>';
			break;
			case 'joblist':
				$html.='<h1 class="wpjobportal-head-text">'. __('Jobs', 'wp-job-portal') .'</h1>
	        			<a class="wpjobportal-add-link button" href='. admin_url('admin.php?page=wpjobportal_job&wpjobportallt=formjob').' title="'.__('add new job','wp-job-portal').'">
	        				<img src="'.WPJOBPORTAL_PLUGIN_URL.'includes/images/control_panel/dashboard/plus-icon.png" alt="'. __('plus icon','wp-job-portal').'" />
	        				'.__('Add New Job','wp-job-portal').'
	    				</a>';
			break;
			case 'jobapply':
				$html.='<h1 class="wpjobportal-head-text">'. __('Job Applied Resume', 'wp-job-portal').'</h1>';
			break;
			case 'resume':
				$html.='<h1 class="wpjobportal-head-text">'. __('Resume', 'wp-job-portal').'</h1>';
			break;
			case 'resumeque':
				$html.='<h1 class="wpjobportal-head-text">'. __('Resume Approval Queue', 'wp-job-portal') .'</h1>';
			break;
			case 'jobapprovalque':
			 	$html.='<h1 class="wpjobportal-head-text">'. __('Jobs Approval Queue', 'wp-job-portal') .'</h1>';
			break;
			case 'age':
				$html.='<h1 class="wpjobportal-head-text">'.__('Ages', 'wp-job-portal').'</h1>
	        			<a class="wpjobportal-add-link button" href='.admin_url('admin.php?page=wpjobportal_age&wpjobportallt=formages').' title="'. __('add new age','wp-job-portal').'">
	        				<img src="'.WPJOBPORTAL_PLUGIN_URL.'includes/images/control_panel/dashboard/plus-icon.png" alt="'. __('plus icon','wp-job-portal').'" />
	        				'. __('Add New Age','wp-job-portal').'
	    				</a>';
			break;
			case 'addnewage':
				$msg= isset(wpjobportal::$_data[0]) ? __('Edit', 'wp-job-portal') : __('Add New','wp-job-portal');
	    		$html.='<h1 class="wpjobportal-head-text">'. $msg . ' ' . __('Age', 'wp-job-portal').'</h1>';
			break;
			case 'careerlevel':
				$html.= '<h1 class="wpjobportal-head-text">'.__('Career Levels', 'wp-job-portal').'</h1>';
	            $html.='<a class="wpjobportal-add-link button" href='.admin_url('admin.php?page=wpjobportal_careerlevel&wpjobportallt=formcareerlevels').' title="'. __('add new career level','wp-job-portal').'">
	            			<img src="'.WPJOBPORTAL_PLUGIN_URL.'includes/images/control_panel/dashboard/plus-icon.png" alt="'. __('plus icon','wp-job-portal').'" />
	            			'. __('Add New Career Level','wp-job-portal').'
	        			</a>';
			break;
			case 'addnew':
				$heading = isset(wpjobportal::$_data[0]) ? __('Edit', 'wp-job-portal') : __('Add New','wp-job-portal');
	    		$html.='<h1 class="wpjobportal-head-text">'. $heading . ' ' . __('Career Levels', 'wp-job-portal').'</h1>';
			break;
	    	case 'categories':
	    	 	$html.='<h1 class="wpjobportal-head-text">'. __('Categories', 'wp-job-portal').'</h1>';
	        	$html.='<a class="wpjobportal-add-link button" href='. admin_url('admin.php?page=wpjobportal_category&wpjobportallt=formcategory').' title="'. __('add new category','wp-job-portal').'">
	        				<img src="'.WPJOBPORTAL_PLUGIN_URL.'includes/images/control_panel/dashboard/plus-icon.png" alt="'. __('plus icon','wp-job-portal').'" />
	        				'. __('Add New Category','wp-job-portal').'
	    				</a>';
			break;
			case 'addcategories':
	    	 	$heading = isset(wpjobportal::$_data[0]) ? __('Edit', 'wp-job-portal') : __('Add New', 'wp-job-portal');
	        	$html.='<h1 class="wpjobportal-head-text">'. $heading . ' ' . __('Category', 'wp-job-portal').'</h1>';
			break;
			case 'city':
				$html.= '<h1 class="wpjobportal-head-text">'.__('Cities', 'wp-job-portal').'</h1>';
				$html.='<a class="wpjobportal-add-link button" href='.admin_url('admin.php?page=wpjobportal_city&wpjobportallt=formcity').' title="'. __('add new city','wp-job-portal').'">
							<img src="'.WPJOBPORTAL_PLUGIN_URL.'includes/images/control_panel/dashboard/plus-icon.png" alt="'. __('plus icon','wp-job-portal').'" />
							'. __('Add New City','wp-job-portal').'
						</a>';
			break;
			case 'cityadd':
				$heading = isset(wpjobportal::$_data[0]) ? __('Edit', 'wp-job-portal') : __('Add New', 'wp-job-portal');
		        $html.='<h1 class="wpjobportal-head-text">'. $heading . ' ' . __('City', 'wp-job-portal').'</h1>';
			break;
			case 'countries':
	            $html.='<h1 class="wpjobportal-head-text">'.__('Countries', 'wp-job-portal').'</h1>';
	         	$html.='<a class="wpjobportal-add-link button" href='.admin_url('admin.php?page=wpjobportal_country&wpjobportallt=formcountry').' title="'. __('add new country','wp-job-portal').'">
	         				<img src="'.WPJOBPORTAL_PLUGIN_URL.'includes/images/control_panel/dashboard/plus-icon.png" alt="'. __('plus icon','wp-job-portal').'" />
	         				'. __('Add New Country','wp-job-portal').'
	     				</a>';
			break;
			case 'newcountry':
				$heading = isset(wpjobportal::$_data[0]) ? __('Edit', 'wp-job-portal') : __('Add New', 'wp-job-portal');
		        $html.='<h1 class="wpjobportal-head-text">'. $heading . ' ' . __('Country', 'wp-job-portal').'</h1>';
			break;
			case 'highesteducation':
				$html.='<h1 class="wpjobportal-head-text">'. __('Educations', 'wp-job-portal').'</h1>';
	            $html.='<a class="wpjobportal-add-link button" href='. admin_url('admin.php?page=wpjobportal_highesteducation&wpjobportallt=formhighesteducation').' title="'. __('add new education','wp-job-portal').'">
	            			<img src="'.WPJOBPORTAL_PLUGIN_URL.'includes/images/control_panel/dashboard/plus-icon.png" alt="'. __('plus icon','wp-job-portal').'" />
	            			'. __('Add New Education','wp-job-portal').'
	        			</a>';
			break;
			case 'educationsts':
				$heading = isset(wpjobportal::$_data[0]) ? __('Edit', 'wp-job-portal') : __('Add New', 'wp-job-portal');
		        $html.='<h1 class="wpjobportal-head-text">'. $heading . ' ' . __('Education', 'wp-job-portal').'</h1>';
			break;
			case 'jobstatus':
				$html.='<h1 class="wpjobportal-head-text">'. __('Job Status', 'wp-job-portal').'</h1>
	        			<a class="wpjobportal-add-link button" href="?page=wpjobportal_jobstatus&wpjobportallt=formjobstatus" title="'. __('add new job status','wp-job-portal').'">
	        				<img src="'.WPJOBPORTAL_PLUGIN_URL.'includes/images/control_panel/dashboard/plus-icon.png" alt="'. __('plus icon','wp-job-portal').'" />
	        				'. __('Add New Job Status','wp-job-portal').'
	        			</a>';
			break;
			case 'jobstatusadd':
				$heading = isset(wpjobportal::$_data[0]) ? __('Edit', 'wp-job-portal') : __('Add New', 'wp-job-portal');
		        $html.='<h1 class="wpjobportal-head-text">'.$heading . ' ' . __('Job Status', 'wp-job-portal').'</h1>';
			break;
			case 'salaryrangetype':
				$html.='<h1 class="wpjobportal-head-text">'. __('Salary Range Type', 'wp-job-portal').'</h1>';
	        	$html.='<a class="wpjobportal-add-link button" href='. admin_url('admin.php?page=wpjobportal_salaryrangetype&wpjobportallt=formsalaryrangetype').' title="'. __('add new salary range type','wp-job-portal').'">
	        				<img src="'.WPJOBPORTAL_PLUGIN_URL.'includes/images/control_panel/dashboard/plus-icon.png" alt="'. __('plus icon','wp-job-portal').'" />
	        				'. __('Add New Salary Range Type','wp-job-portal').'
	    				</a>';
			break;
			case 'rangetypeadd':
				$heading = isset(wpjobportal::$_data[0]) ? __('Edit', 'wp-job-portal') : __('Add New', 'wp-job-portal');
	        	$html.='<h1 class="wpjobportal-head-text">'. $heading . ' ' . __('Salary Range Type', 'wp-job-portal').'</h1>';
			break;
			case 'state':
				$html.='<h1 class="wpjobportal-head-text">'. __('States', 'wp-job-portal').'</h1>';
	    		$html.='<a class="wpjobportal-add-link button" href='.admin_url('admin.php?page=wpjobportal_state&wpjobportallt=formstate').' title="'. __('add new state','wp-job-portal').'">
	    					<img src="'.WPJOBPORTAL_PLUGIN_URL.'includes/images/control_panel/dashboard/plus-icon.png" alt="'. __('plus icon','wp-job-portal').'" />
	    					'. __('Add New State','wp-job-portal').'
						</a>';
			break;
			case 'jobs':
				$html.='<h1 class="wpjobportal-head-text">'. ($job ? __('Edit', 'wp-job-portal') : __('Add New', 'wp-job-portal')) . ' ' . __('Job', 'wp-job-portal').'</h1>';
			break;
			case 'activitylog':
				$html.='<h1 class="wpjobportal-head-text">'. __('Activity Log', 'wp-job-portal') .'</h1>';
			break;
			case 'addcompany':
				$html.='<h1 class="wpjobportal-head-text">'. __('Companies', 'wp-job-portal').'</h1>
	    				<a class="wpjobportal-add-link button" href='. admin_url('admin.php?page=wpjobportal_company&wpjobportallt=formcompany').' title="'. __('add new company','wp-job-portal').'">
	    					<img src="'.WPJOBPORTAL_PLUGIN_URL.'includes/images/control_panel/dashboard/plus-icon.png" alt="'. __('plus icon','wp-job-portal').'" />
	    					'. __('Add New Company','wp-job-portal').'
						</a>';
			break;
			case 'comp':
				$html.='<h1 class="wpjobportal-head-text">'.($company ? __('Edit', 'wp-job-portal') : __('Add New', 'wp-job-portal')) . ' ' . __('Company', 'wp-job-portal').'</h1>';
	        break;
			case 'viewresume':
				$html.='<h1 class="wpjobportal-head-text">'. __('View Resume', 'wp-job-portal') .'</h1>';
			break;
			case 'formresume':
				$html.='<h1 class="wpjobportal-head-text">'. __('Resume', 'wp-job-portal') .'</h1>';
			break;
			case 'users':
				$html.= '<h1 class="wpjobportal-head-text">'. __('Users', 'wp-job-portal') .'</h1>
					    <a class="wpjobportal-add-link button" href='. admin_url('admin.php?page=wpjobportal_user&wpjobportallt=assignrole').' title="'. __('assign role', 'wp-job-portal') .'">
					    	<img src="'.WPJOBPORTAL_PLUGIN_URL.'includes/images/control_panel/dashboard/plus-icon.png" alt="'. __('plus icon','wp-job-portal').'" />
					    	'. __('Assign role', 'wp-job-portal') .'
				    	</a>';
			break;
			case 'assignrole':
				$html .='<h1 class="wpjobportal-head-text">'. __('Assign Role', 'wp-job-portal').'</h1>';
	        break;
			case 'userform':
				$html.='<h1 class="wpjobportal-head-text">'. __('Change Role', 'wp-job-portal').'</h1>';
	    	break;
			case 'folder':
				$html.='<h1 class="wpjobportal-head-text">'. __('Folders', 'wp-job-portal').'</h1>';
				$html.='<a class="wpjobportal-add-link button" href='. admin_url('admin.php?page=wpjobportal_folder&wpjobportallt=formfolder').' title="'. __('add new folder','wp-job-portal').'">
							<img src="'.WPJOBPORTAL_PLUGIN_URL.'includes/images/control_panel/dashboard/plus-icon.png" alt="'. __('plus icon','wp-job-portal').'" />
							'. __('Add New Folder','wp-job-portal').'
						</a>';
	    	break;
			case 'folderstat':
				$heading = (isset($data) && !empty($data)) ? __('Edit', 'wp-job-portal') : __('Add New', 'wp-job-portal');
				$html.='<h1 class="wpjobportal-head-text">'. $heading. ' ' . __('Folder', 'wp-job-portal').'</h1>';
			break;
			case 'folder-que':
				$html .='<h1 class="wpjobportal-head-text">'. __('Folders Approval Queue', 'wp-job-portal').'</h1>';
	        break;
			case 'tag':
				$html .='<h1 class="wpjobportal-head-text">'. $heading . ' ' . __('Tag', 'wp-job-portal').'</h1>';
			break;
			case 'tags':
				$html .= '<h1 class="wpjobportal-head-text">'.__('Tags', 'wp-job-portal') .'</h1>
	        			<a class="wpjobportal-add-link button" href='. admin_url('admin.php?page=wpjobportal_tag&wpjobportallt=formtag') .' title="'. __('add new tag','wp-job-portal').'">
	        				<img src="'.WPJOBPORTAL_PLUGIN_URL.'includes/images/control_panel/dashboard/plus-icon.png" alt="'. __('plus icon','wp-job-portal').'" />
	        				'. __('Add New Tag','wp-job-portal').'
	    				</a>';
			break;
			case 'message':
				$html .='<h1 class="wpjobportal-head-text">'. __('Messages', 'wp-job-portal').'</h1>';
			break;
			case 'messageque':
				$html .='<h1 class="wpjobportal-head-text">'. __('Messages Approval Queue', 'wp-job-portal').'</h1>';
			break;
			case 'messagedetail':
				$html .='<h1 class="wpjobportal-head-text">'. __('Messages', 'wp-job-portal').'</h1>';
	        break;
			case 'package':
				$html .='<h1 class="wpjobportal-head-text">'. __('Package','wp-job-portal').'</h1>';
				$html .= '<a class="wpjobportal-add-link" href='.admin_url('admin.php?page=wpjobportal_package&wpjobportallt=formpackage').' title="'. __('add new package','wp-job-portal').'">
							<img src="'.WPJOBPORTAL_PLUGIN_URL.'includes/images/control_panel/dashboard/plus-icon.png" alt="'. __('plus icon','wp-job-portal').'" />
							'. __('Add New Package','wp-job-portal').'
						</a>';
			break;
			case 'formpackage':
				$html .='<h1 class="wpjobportal-head-text">'.__($package ? __('Edit Package', 'wp-job-portal') : __('Add New Package', 'wp-job-portal'), 'wp-job-portal').'</h1>';
			break;
			case 'customfield':
				$heading = isset(wpjobportal::$_data[0]['fieldvalues']) ? __('Edit', 'wp-job-portal') : __('Add', 'wp-job-portal');
        		$html .= '<h1 class="wpjobportal-head-text">'. $heading . ' ' . __('User Field', 'wp-job-portal').'</h1>';
				break;
			case 'coverletter':
					$html .='<h1 class="wpjobportal-head-text">'. __('Cover Letters', 'wp-job-portal').'</h1>';
			break;
			case 'coverletterque':
					$html .='<h1 class="wpjobportal-head-text">'. __('Cover Letter Approval Queue', 'wp-job-portal').'</h1>';
			break;
		}
	$html.=  '</div>';
	echo wp_kses($html, WPJOBPORTAL_ALLOWED_TAGS);
}
?>

