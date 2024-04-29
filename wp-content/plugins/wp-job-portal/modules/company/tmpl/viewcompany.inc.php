<?php if (!defined('ABSPATH')) die('Restricted Access'); ?>
<script >
    var ajaxurl = "<?php echo admin_url('admin-ajax.php') ?>";

    function getPackagePopup(resumeid) {
        var ajaxurl = "<?php echo admin_url('admin-ajax.php') ?>";
        jQuery.post(ajaxurl, {action: 'wpjobportal_ajax', wpjobportalme: 'multicompany', task: 'getPackagePopupForCompanyContactDetail', wpjobportalid: resumeid}, function (data) {
            if (data) {
                if(jQuery("#package-popup").length)
                jQuery("#package-popup").remove();
                jQuery('body').append(data);
                jQuery("#wjportal-popup-background").show();
                jQuery("#package-popup").slideDown('slow');

            } else {
                jQuery("div.logo-container").append("<span style='color:Red;'><?php echo __('Error While Adding Feature job', 'wp-job-portal'); ?>");
            }
        });
    }


    function selectPackage(packageid){
        jQuery(".package-div").css('border','1px solid #ccc');
        jQuery(".wjportal-pkg-item, .wpj-jp-pkg-item").removeClass('wjportal-pkg-selected');
        jQuery("#package-div-"+packageid).addClass('wjportal-pkg-selected');
        jQuery("#wpjobportal_packageid").val(packageid);
        jQuery("#jsre_featured_button").removeAttr('disabled');
    }

    jQuery(document).ready(function(){

    jQuery("#proceedPaymentBtn").click(function(){
        jQuery("div#wjportal-popup-background").show();
        jQuery("#payment-popup").slideDown('slow');
    });

});
</script>
