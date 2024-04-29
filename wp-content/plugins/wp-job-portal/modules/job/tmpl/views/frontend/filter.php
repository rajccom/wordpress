<?php
/**
* @param js-job optional
* Filter's FrontEnd
*/
?>
<?php
$html = '';
switch ($layout) {
	case 'myjobfilter':
	    $html.= __("",'wp-job-portal').'';
        $html.= '<div class="wjportal-filter-wrp">';
        $html.= '   <div class="wjportal-filter">';
        $html.=         WPJOBPORTALformfield::select('sorting', $sortbylist, isset(wpjobportal::$_data['combosort']) ? wpjobportal::$_data['combosort'] : null,__("Default",'wp-job-portal'),array('onchange'=>'changeCombo()'));
        $html.='    </div>';
        $html.= '   <div class="wjportal-filter-image">';
        $html .= '<a class="sort-icon" href="#" data-image1='. $image1.' data-image2='. $image2.' data-sortby='.wpjobportal::$_data['sortby'].'><img id="sortingimage" src='.  $image.'></a>';
        // $html .= '</div>';
        // $html.= '   <div class="wjportal-filter-image">';
        // $html.= '       <a href='. wpjobportal::makeUrl(array('wpjobportalme'=>'job', 'wpjobportallt'=>'myjobs','sortby' => wpjobportal::$_sortlinks['newest'], 'wpjobportalpageid'=>wpjobportal::getPageid())) .' >';
        // $html.= '           <img  src='.WPJOBPORTAL_PLUGIN_URL . "includes/images/" . $img .'>';
        // $html.= '       </a>
        //             </div>';
        $html.= ' </div>
                </div>';
        $html.= '<div class="wjportal-act-btn-wrp">';
        $html.= '    <a class="wjportal-act-btn" href='. wpjobportal::makeUrl(array('wpjobportalme'=>'job', 'wpjobportallt'=>'addjob')).'> <i class="fa fa-plus"></i>'. __('Add New Job', 'wp-job-portal').'</a>
                </div>';

		break;


	case 'newestjobsfilter':
        $html.='<div class="wjportal-filter-search-wrp">
                    <div class="wjportal-filter-search-field-wrp">
                        '. WPJOBPORTALformfield::text('jobtitle',isset(wpjobportal::$_data['filter']['jobtitle']) ? wpjobportal::$_data['filter']['jobtitle'] : '',array('placeholder'=>__('Title','wp-job-portal'), 'class'=>__('wjportal-filter-search-input-field'))).'
                    </div>
                    <div class="wjportal-filter-search-field-wrp">
                        '. WPJOBPORTALformfield::text('city',isset(wpjobportal::$_data['filter']['city_ids']) ? wpjobportal::$_data['filter']['city_ids'] : '',array('placeholder'=>__("City",'wp-job-portal'))).'
                    </div>
                    <div class="wjportal-filter-search-btn-wrp">
                        <button type="submit" class="wjportal-filter-search-btn">
                            <i class="fa fa-search"></i>
                        </button>
                        <button id="reset-newest-jobfilter" type="reset" class="wjportal-filter-reset-btn">
                            <i class="fa fa-refresh"></i>
                        </button>
                    </div>
            </div>';
        $html .= WPJOBPORTALformfield::hidden('wpjobportallay' , 'jobs');
        $html .= WPJOBPORTALformfield::hidden('WPJOBPORTAL_form_search' , 'WPJOBPORTAL_SEARCH');
		break;
}
echo wp_kses($html, WPJOBPORTAL_ALLOWED_TAGS);

?>
