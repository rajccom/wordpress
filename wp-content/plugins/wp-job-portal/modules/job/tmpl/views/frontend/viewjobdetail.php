<?php
/**
 * @param job      job object - optional
*/
?>
<div class="wjportal-main-wrapper wjportal-clearfix">
    <?php
    	WPJOBPORTALincluder::getTemplate('job/views/frontend/jobtitle', array(
            'job'       =>  $job ,
            'jobfields'  =>  $jobfields
        ));
    ?>
</div>