<?php
    /**
    *
    */
    ?>
<?php
    $html = '';
    switch ($layout) {
    	case 'comp-sort':
    		$html.='<div id="wpjobportal-page-quick-actions">
    			        <label class="wpjobportal-page-quick-act-btn" onclick="return highlightAll();" for="selectall">
    			        	<input type="checkbox" name="selectall" id="selectall" value="">
			        		'. __('Select All', 'wp-job-portal') .'
		        		</label>
    			        <a class="wpjobportal-page-quick-act-btn multioperation" message="'. WPJOBPORTALMessages::getMSelectionEMessage().'" confirmmessage="'. __('Are you sure to delete','wp-job-portal').' ?'.'" data-for="remove" href="#" title="'.__('delete', 'wp-job-portal').'">
    			        	<img src='. WPJOBPORTAL_PLUGIN_URL.'includes/images/control_panel/dashboard/forced-delete.png alt="'.__('delete', 'wp-job-portal').'">
    			        	'. __('Delete', 'wp-job-portal') .'
			        	</a>';
    			        $image1 = WPJOBPORTAL_PLUGIN_URL . "includes/images/control_panel/dashboard/sorting-white-1.png";
    			        $image2 = WPJOBPORTAL_PLUGIN_URL . "includes/images/control_panel/dashboard/sorting-white-2.png";
    			        if (wpjobportal::$_data['sortby'] == 1) {
    			            $image = $image1;
    			        } else {
    			            $image = $image2;
    			        }
    			        $html.='<div class="wpjobportal-sorting-wrp">
    			            	<span class="wpjobportal-sort-text">
    			            		'.__('Sort by', 'wp-job-portal').':
			            		</span>
    			            	<span class="wpjobportal-sort-field">
    			            		'.WPJOBPORTALformfield::select('sorting', $categoryarray, wpjobportal::$_data['combosort'], '', array('class' => 'inputbox', 'onchange' => 'changeCombo();')).'
			            		</span>
    			            	<a class="wpjobportal-sort-icon sort-icon" href="#" data-image1='.$image1.' data-image2='. $image2.' data-sortby='. wpjobportal::$_data['sortby'].'>
    			            		<img id="sortingimage" src='. $image.' alt="'.__('sort','wp-job-portal').'">
			            		</a>
    			        	</div>
    			    </div>';
		break;
	}
    echo wp_kses($html, WPJOBPORTAL_ALLOWED_TAGS);
?>
