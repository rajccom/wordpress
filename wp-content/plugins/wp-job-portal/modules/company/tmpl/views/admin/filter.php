<?php
    /**
    * @param form-filters to be uses
    */
    ?>
<?php
    $html = '';
    switch ($layouts) {
        case 'compfilter':
            $html.='<div id="wpjobportal-page-quick-actions">
                        <label class="wpjobportal-page-quick-act-btn" onclick="return highlightAll();" for="selectall"><input type="checkbox" name="selectall" id="selectall" value="">'. __('Select All', 'wp-job-portal') .'</label>
                        <a class="wpjobportal-page-quick-act-btn multioperation" message="'. WPJOBPORTALMessages::getMSelectionEMessage().'" confirmmessage="'. __('Are you sure to delete', 'wp-job-portal') .' ?'.'" data-for="remove" href="#">
                            <img src='. WPJOBPORTAL_PLUGIN_URL.'includes/images/control_panel/dashboard/forced-delete.png alt="'. __('delete', 'wp-job-portal') .'">'. __('Delete', 'wp-job-portal') .'
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
                                            '. __('Sort by', 'wp-job-portal').':
                                        </span>
                                        <span class="wpjobportal-sort-field">
                                            '. WPJOBPORTALformfield::select('sorting', $categoryarray, wpjobportal::$_data['combosort'], '', array('class' => 'inputbox', 'onchange' => 'changeCombo();')).'
                                        </span>
                                        <a class="wpjobportal-sort-icon sort-icon" href="#" data-image1='. $image1.' data-image2='.$image2.' data-sortby='. wpjobportal::$_data['sortby'].'>
                                            <img id="sortingimage" src='. $image.' alt="'.__('sort','wp-job-portal').'">
                                        </a>
                                    </div>
                    </div>';
        break;
        case 'comp-filter':
            $html.= WPJOBPORTALformfield::text('searchcompany', wpjobportal::$_data['filter']['searchcompany'], array('class' => 'inputbox wpjobportal-form-input-field', 'placeholder' => __('Company Name', 'wp-job-portal')));
            $html.= WPJOBPORTALformfield::text('datestart', wpjobportal::$_data['filter']['datestart'], array('class' => 'custom_date wpjobportal-form-input-field', 'placeholder' => __('Date Start', 'wp-job-portal'), 'autocomplete' => 'off'));
            $html.= WPJOBPORTALformfield::text('dateend', wpjobportal::$_data['filter']['dateend'], array('class' => 'custom_date wpjobportal-form-input-field', 'placeholder' => __('Date End', 'wp-job-portal'), 'autocomplete' => 'off'));
            $html.= WPJOBPORTALformfield::select('status', WPJOBPORTALincluder::getJSModel('common')->getListingStatus(), wpjobportal::$_data['filter']['status'], __('Select Status', 'wp-job-portal'), array('class' => 'inputbox wpjobportal-form-select-field'));
            if(in_array('featuredcompany', wpjobportal::$_active_addons)){
                $html .= '<div class="wpjobportal-form-checkbox-field">';
                $html.=  WPJOBPORTALformfield::checkbox('featured', array('1' => __('Featured', 'wp-job-portal')), isset(wpjobportal::$_data['filter']['featured']) ? wpjobportal::$_data['filter']['featured'] : 0, array('class ' => 'checkbox'));
                $html .= '</div>';
             }
            $html.=WPJOBPORTALformfield::hidden('WPJOBPORTAL_form_search', 'WPJOBPORTAL_SEARCH');
            $html.= WPJOBPORTALformfield::submitbutton('btnsubmit', __('Search', 'wp-job-portal'), array('class' => 'button wpjobportal-form-search-btn'));
            $html.= WPJOBPORTALformfield::button('reset', __('Reset', 'wp-job-portal'), array('class' => 'button wpjobportal-form-reset-btn', 'onclick' => 'resetFrom();'));
            $html.= WPJOBPORTALformfield::hidden('sortby', wpjobportal::$_data['sortby']);
            $html.= WPJOBPORTALformfield::hidden('sorton', wpjobportal::$_data['sorton']);
            //$html.='<span id="showhidefilter"><img src='. WPJOBPORTAL_PLUGIN_URL.'includes/images/filter-down.png></span>';
        break;
        case 'que-filter':
            $html.= WPJOBPORTALformfield::text('searchcompany', wpjobportal::$_data['filter']['searchcompany'], array('class' => 'inputbox wpjobportal-form-input-field', 'placeholder' => __('Company Name', 'wp-job-portal')));
            // this filter is not valid
            //$html.= WPJOBPORTALformfield::select('searchjobcategory', WPJOBPORTALincluder::getJSModel('category')->getCategoriesForCombo(), wpjobportal::$_data['filter']['searchjobcategory'], __('Select','wp-job-portal') .' '. __('Category', 'wp-job-portal'), array('class' => 'inputbox wpjobportal-form-select-field'));
            $html.= WPJOBPORTALformfield::text('datestart', wpjobportal::$_data['filter']['datestart'], array('class' => 'custom_date wpjobportal-form-input-field', 'placeholder' => __('Date Start', 'wp-job-portal'), 'autocomplete' => 'off'));
            $html.= WPJOBPORTALformfield::text('dateend', wpjobportal::$_data['filter']['dateend'], array('class' => 'custom_date wpjobportal-form-input-field', 'placeholder' => __('Date End', 'wp-job-portal'), 'autocomplete' => 'off'));
            $html.= WPJOBPORTALformfield::hidden('WPJOBPORTAL_form_search', 'WPJOBPORTAL_SEARCH');
            $html.= WPJOBPORTALformfield::submitbutton('btnsubmit', __('Search', 'wp-job-portal'), array('class' => 'button wpjobportal-form-search-btn'));
            $html.= WPJOBPORTALformfield::button('reset', __('Reset', 'wp-job-portal'), array('class' => 'button wpjobportal-form-reset-btn', 'onclick' => 'resetFrom();'));
            $html.= WPJOBPORTALformfield::hidden('sortby', wpjobportal::$_data['sortby']);
            $html.= WPJOBPORTALformfield::hidden('sorton', wpjobportal::$_data['sorton']);
            //$html.='<span id="showhidefilter"><img src='. WPJOBPORTAL_PLUGIN_URL.'includes/images/filter-down.png></span>';
        break;
    }
    echo wp_kses($html, WPJOBPORTAL_ALLOWED_TAGS);
?>
