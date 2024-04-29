<?php
if (!defined('ABSPATH'))
    die('Restricted Access');

// Creating the widget
class WPJOBPORTALjobssearchjobs_widget extends WP_Widget {

    function __construct() {
        parent::__construct(
                // Base ID of your widget
                'WPJOBPORTALjobssearchjobs_widget',
                // Widget name will appear in UI
                __('Job Search', 'wp-job-portal'),
                // Widget description
                array('description' => __('Search jobs form WP Job Portal database', 'wp-job-portal'),)
        );
    }

    // Creating widget front-end
    // This is where the action happens
    public function widget($args, $instance) {

        $jobtitle = apply_filters('widget_jobtitle', $instance['jobtitle']);
        $title = apply_filters('widget_title', $instance['title']);
        $showtitle = apply_filters('widget_showtitle', $instance['showtitle']);
        $category = apply_filters('widget_category', $instance['category']);
        $jobtype = apply_filters('widget_jobtype', $instance['jobtype']);
        $jobstatus = apply_filters('widget_jobstatus', $instance['jobstatus']);
        $salaryrange = apply_filters('widget_salaryrange', $instance['salaryrange']);
        $shift = apply_filters('widget_shift', $instance['shift']);
        $duration = apply_filters('widget_duration', $instance['duration']);
        $startpublishing = 0;
        $stoppublishing = 0;
        $company = apply_filters('widget_company', $instance['company']);
        $address = apply_filters('widget_address', $instance['address']);
        $columnperrow = apply_filters('widget_columnperrow', $instance['columnperrow']);

        // before and after widget arguments are defined by themes
        echo wp_kses($args['before_widget'], WPJOBPORTAL_ALLOWED_TAGS);
        if (!empty($title))
            echo wp_kses($args['before_title'], WPJOBPORTAL_ALLOWED_TAGS) . wp_kses($title, WPJOBPORTAL_ALLOWED_TAGS) . wp_kses($args['after_title'], WPJOBPORTAL_ALLOWED_TAGS);

        // This is where you run the code and display the output
        //Frontend HTML starts

        if (locate_template('wp-job-portal/widget-searchjobs.php', 1, 0)) {
            $defaulthtml = false;
        }else{
            wpjobportal::addStyleSheets();
            $modules_html = WPJOBPORTALincluder::getJSModel('jobsearch')->getSearchJobs_Widget($title, $showtitle, $jobtitle, $category, $jobtype, $jobstatus, $salaryrange, $shift, $duration, $startpublishing, $stoppublishing, $company, $address, $columnperrow);
            echo wp_kses($modules_html, WPJOBPORTAL_ALLOWED_TAGS);
        }

        //Frontend HTML ends -------------
        // before and after widget arguments are defined by themes
        echo wp_kses($args['after_widget'], WPJOBPORTAL_ALLOWED_TAGS);
    }
    // Widget Backend
    public function form($instance) {
        $title = (isset($instance['title'])) ? $instance['title'] : __('Search Job', 'wp-job-portal');
        $showtitle = (isset($instance['showtitle'])) ? $instance['showtitle'] : 1;
        $jobtitle = (isset($instance['jobtitle'])) ? $instance['jobtitle'] : 1;
        $category = (isset($instance['category'])) ? $instance['category'] : 1;

        $jobtype = (isset($instance['jobtype'])) ? $instance['jobtype'] : 1;
        $jobstatus = (isset($instance['jobstatus'])) ? $instance['jobstatus'] : 1;
        $salaryrange = (isset($instance['salaryrange'])) ? $instance['salaryrange'] : 1;
        $shift = (isset($instance['shift'])) ? $instance['shift'] : 1;
        $duration = (isset($instance['duration'])) ? $instance['duration'] : 1;
        $company = (isset($instance['company'])) ? $instance['company'] : 1;
        $address = (isset($instance['address'])) ? $instance['address'] : 1;
        $columnperrow = (isset($instance['columnperrow'])) ? $instance['columnperrow'] : 1;
        ?>
        <!-- widgets admin form options -->
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php echo __('Title', 'wp-job-portal'); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('showtitle')); ?>"><?php echo __('Show Title', 'wp-job-portal'); ?></label>
            <select class="widefat" id="<?php echo esc_attr($this->get_field_id('showtitle')); ?>" name="<?php echo esc_attr($this->get_field_name('showtitle')); ?>">
                <option value="0" <?php if (esc_attr($showtitle) == 0) echo "selected"; ?>><?php echo __('Hide', 'wp-job-portal'); ?></option>
                <option value="1" <?php if (esc_attr($showtitle) == 1) echo "selected"; ?>><?php echo __('Show', 'wp-job-portal'); ?></option>
            </select>
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('jobtitle')); ?>"><?php echo __('Title', 'wp-job-portal'); ?></label>
            <select class="widefat" id="<?php echo esc_attr($this->get_field_id('jobtitle')); ?>" name="<?php echo esc_attr($this->get_field_name('jobtitle')); ?>">
                <option value="0" <?php if (esc_attr($jobtitle) == 0) echo "selected"; ?>><?php echo __('Hide', 'wp-job-portal'); ?></option>
                <option value="1" <?php if (esc_attr($jobtitle) == 1) echo "selected"; ?>><?php echo __('Show', 'wp-job-portal'); ?></option>
            </select>
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('category')); ?>"><?php echo __('Category', 'wp-job-portal'); ?></label>
            <select class="widefat" id="<?php echo esc_attr($this->get_field_id('category')); ?>" name="<?php echo esc_attr($this->get_field_name('category')); ?>">
                <option value="0" <?php if (esc_attr($category) == 0) echo "selected"; ?>><?php echo __('Hide', 'wp-job-portal'); ?></option>
                <option value="1" <?php if (esc_attr($category) == 1) echo "selected"; ?>><?php echo __('Show', 'wp-job-portal'); ?></option>
            </select>
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('jobtype')); ?>"><?php echo __('Job type', 'wp-job-portal'); ?></label>
            <select class="widefat" id="<?php echo esc_attr($this->get_field_id('jobtype')); ?>" name="<?php echo esc_attr($this->get_field_name('jobtype')); ?>">
                <option value="0" <?php if (esc_attr($jobtype) == 0) echo "selected"; ?>><?php echo __('Hide', 'wp-job-portal'); ?></option>
                <option value="1" <?php if (esc_attr($jobtype) == 1) echo "selected"; ?>><?php echo __('Show', 'wp-job-portal'); ?></option>
            </select>
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('jobstatus')); ?>"><?php echo __('Job Status', 'wp-job-portal'); ?></label>
            <select class="widefat" id="<?php echo esc_attr($this->get_field_id('jobstatus')); ?>" name="<?php echo esc_attr($this->get_field_name('jobstatus')); ?>">
                <option value="0" <?php if (esc_attr($jobstatus) == 0) echo "selected"; ?>><?php echo __('Hide', 'wp-job-portal'); ?></option>
                <option value="1" <?php if (esc_attr($jobstatus) == 1) echo "selected"; ?>><?php echo __('Show', 'wp-job-portal'); ?></option>
            </select>
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('salaryrange')); ?>"><?php echo __('Salary Range', 'wp-job-portal'); ?></label>
            <select class="widefat" id="<?php echo esc_attr($this->get_field_id('salaryrange')); ?>" name="<?php echo esc_attr($this->get_field_name('salaryrange')); ?>">
                <option value="0" <?php if (esc_attr($salaryrange) == 0) echo "selected"; ?>><?php echo __('Hide', 'wp-job-portal'); ?></option>
                <option value="1" <?php if (esc_attr($salaryrange) == 1) echo "selected"; ?>><?php echo __('Show', 'wp-job-portal'); ?></option>
            </select>
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('shift')); ?>"><?php echo __('Shift', 'wp-job-portal'); ?></label>
            <select class="widefat" id="<?php echo esc_attr($this->get_field_id('shift')); ?>" name="<?php echo esc_attr($this->get_field_name('shift')); ?>">
                <option value="0" <?php if (esc_attr($shift) == 0) echo "selected"; ?>><?php echo __('Hide', 'wp-job-portal'); ?></option>
                <option value="1" <?php if (esc_attr($shift) == 1) echo "selected"; ?>><?php echo __('Show', 'wp-job-portal'); ?></option>
            </select>
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('duration')); ?>"><?php echo __('Duration', 'wp-job-portal'); ?></label>
            <select class="widefat" id="<?php echo esc_attr($this->get_field_id('duration')); ?>" name="<?php echo esc_attr($this->get_field_name('duration')); ?>">
                <option value="0" <?php if (esc_attr($duration) == 0) echo "selected"; ?>><?php echo __('Hide', 'wp-job-portal'); ?></option>
                <option value="1" <?php if (esc_attr($duration) == 1) echo "selected"; ?>><?php echo __('Show', 'wp-job-portal'); ?></option>
            </select>
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('company')); ?>"><?php echo __('Company', 'wp-job-portal'); ?></label>
            <select class="widefat" id="<?php echo esc_attr($this->get_field_id('company')); ?>" name="<?php echo esc_attr($this->get_field_name('company')); ?>">
                <option value="0" <?php if (esc_attr($company) == 0) echo "selected"; ?>><?php echo __('Hide', 'wp-job-portal'); ?></option>
                <option value="1" <?php if (esc_attr($company) == 1) echo "selected"; ?>><?php echo __('Show', 'wp-job-portal'); ?></option>
            </select>
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('address')); ?>"><?php echo __('Address', 'wp-job-portal'); ?></label>
            <select class="widefat" id="<?php echo esc_attr($this->get_field_id('address')); ?>" name="<?php echo esc_attr($this->get_field_name('address')); ?>">
                <option value="0" <?php if (esc_attr($address) == 0) echo "selected"; ?>><?php echo __('Hide', 'wp-job-portal'); ?></option>
                <option value="1" <?php if (esc_attr($address) == 1) echo "selected"; ?>><?php echo __('Show', 'wp-job-portal'); ?></option>
            </select>
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('columnperrow')); ?>"><?php echo __('Column per row', 'wp-job-portal'); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('columnperrow')); ?>" name="<?php echo esc_attr($this->get_field_name('columnperrow')); ?>" type="text" value="<?php echo esc_attr($columnperrow); ?>" />
        </p>
        <?php
    }

    // Updating widget replacing old instances with new
    public function update($new_instance, $old_instance) {
        $instance = array();

        $instance['title'] = (!empty($new_instance['title'])) ? esc_attr(strip_tags($new_instance['title'])) : '';
        $instance['showtitle'] = (!empty($new_instance['showtitle'])) ? esc_attr(strip_tags($new_instance['showtitle'])) : '';
        $instance['jobtitle'] = (!empty($new_instance['jobtitle'])) ? esc_attr(strip_tags($new_instance['jobtitle'])) : '';
        $instance['category'] = (!empty($new_instance['category'])) ? esc_attr(strip_tags($new_instance['category'])) : '';

        $instance['jobtype'] = (!empty($new_instance['jobtype'])) ? esc_attr(strip_tags($new_instance['jobtype'])) : '';
        $instance['jobstatus'] = (!empty($new_instance['jobstatus'])) ? esc_attr(strip_tags($new_instance['jobstatus'])) : '';
        $instance['salaryrange'] = (!empty($new_instance['salaryrange'])) ? esc_attr(strip_tags($new_instance['salaryrange'])) : '';
        $instance['shift'] = (!empty($new_instance['shift'])) ? esc_attr(strip_tags($new_instance['shift'])) : '';
        $instance['duration'] = (!empty($new_instance['duration'])) ? esc_attr(strip_tags($new_instance['duration'])) : '';
        $instance['company'] = (!empty($new_instance['company'])) ? esc_attr(strip_tags($new_instance['company'])) : '';
        $instance['address'] = (!empty($new_instance['address'])) ? esc_attr(strip_tags($new_instance['address'])) : '';
        $instance['columnperrow'] = (!empty($new_instance['columnperrow'])) ? esc_attr(strip_tags($new_instance['columnperrow'])) : '';

        return $instance;
    }

}

// Class wpb_widget ends here
// Register and load the widget
function WPJOBPORTALjobssearchjobs_load_widget() {
    register_widget('WPJOBPORTALjobssearchjobs_widget');
}

add_action('widgets_init', 'WPJOBPORTALjobssearchjobs_load_widget');
?>
