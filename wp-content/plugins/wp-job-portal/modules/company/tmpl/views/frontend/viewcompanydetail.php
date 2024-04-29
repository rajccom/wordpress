<?php
/**
 * @param wp job portal      job object - optional
 * & section wise Company Detail
*/
?>
<?php
     /**
     * @param Upper Section
     * Company Contact Detail
     **/
    WPJOBPORTALincluder::getTemplate('company/views/frontend/title',array(
        'layouts' => 'viewcomp_uppersection',
        'config_array' => $config_array,
        'data_class' => $data_class,
        'module' => $module
    ));
?>
<div class="wjportal-company-wrp">
    <?php if (isset(wpjobportal::$_data[2]['logo'])) { ?>
            <?php
                $html='<div class="wjportal-company-logo">';
                    WPJOBPORTALincluder::getTemplate('company/views/frontend/logo',array(
                        'layout' => 'complogo',
                        'html' => $html,
                        'classname' => 'wjportal-company-logo-image',
                        'module' => $module
                ));
            } ?>
</div>
<?php
    /**
     * @param Middle Section 
     * Company Contact Body Detail
     **/
    WPJOBPORTALincluder::getTemplate('company/views/frontend/detail',array(
        'layout' => 'companydetail',
        'data_class' => $data_class,
        'config_array' => $config_array,
        'module' => $module
    ));
?>
<?php
    /**
     * @param Button Section
     * To view All job's Related Companies
     **/
    WPJOBPORTALincluder::getTemplate('company/views/frontend/control',array(
        'config_array' => $config_array,
        'layout' => 'showalljobs',
        'module' => $module
    ));
?>    
