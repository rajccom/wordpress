<?php if (!defined('ABSPATH')) die('Restricted Access'); ?>
<script >
    var ajaxurl = "<?php echo admin_url('admin-ajax.php') ?>";

    function makeExpiry() {
        jQuery(".goldnew").hover(function () {
            jQuery(this).find(".goldnew-onhover").show();
        }, function () {
            jQuery(this).find('span.goldnew-onhover').fadeOut("slow");
        });
        jQuery("span.wjportal-featured-tag-icon-wrp, span.wpj-jp-featured-tag-icon-wrp").hover(function () {
            jQuery(this).find("span.featurednew-onhover").show();
        }, function () {
            jQuery(this).find('.featurednew-onhover').fadeOut("slow");
        });
    }

    jQuery(document).ready(function () {
        makeExpiry();
    });

    function getPackagePopup(companyid) {
        var ajaxurl = "<?php echo admin_url('admin-ajax.php') ?>";
        jQuery.post(ajaxurl, {action: 'wpjobportal_ajax', wpjobportalme: 'featuredcompany', task: 'getPackagePopupForFeaturedCompany', wpjobportalid: companyid}, function (data) {
            if (data) {
                if(jQuery("#package-popup").length)
                jQuery("#package-popup").remove();
                jQuery('body').append(data);
                jQuery("#wjportal-popup-background").show();
                jQuery("#package-popup").slideDown('slow');

            } else {
                jQuery("div.logo-container").append("<span style='color:Red;'><?php echo __('Error Deleting Logo', 'wp-job-portal'); ?>");
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


    function addBadgeToObject(cid, specialtype, object,themecall) {
        var themecall = arguments.length > 3 && arguments[3] !== undefined ? arguments[3] : null;
        var html = '';
        if(1 == common.theme_chk_number){
            html += '<span class="wpj-jp-featured-tag-icon-wrp">';
                html += '<span class="wpj-jp-featured-tag-icon">';
                html += '<i class="fa fa-star"></i>';
                html += '</span>';
                html += '<span class="featurednew-onhover wpj-jp-featured-hover-wrp" id="gold' + cid + '" style="display: none;">';
                html += object.expiry;
                html += '</span>';
                html += '</span>';
            jQuery('div.object_' + cid).append(html);
            jQuery('div.wpj-jp-cp-data').prepend('<div class="frontend updated"><p><?php echo esc_html__("Company Has Been Feature SuccesFully", "job-portal"); ?></p></div>');
        }else{
            
                html += '<span class="wjportal-featured-tag-icon-wrp">';
                html += '<span class="wjportal-featured-tag-icon">';
                html += '<i class="fa fa-star"></i>';
                html += '</span>';
                html += '<span class="featurednew-onhover wjportal-featured-hover-wrp" id="gold' + cid + '" style="display: none;">';
                html += object.expiry;
                html += '</span>';
                html += '</span>';

            
            jQuery('div.object_' + cid).append(html);
            jQuery('div.wjportal-page-header').append("<div class='  frontend updated'><p><?php echo __("Company Has Been Feature SuccesFully", "wp-job-portal"); ?></p></div>");
        }
    }

</script>
