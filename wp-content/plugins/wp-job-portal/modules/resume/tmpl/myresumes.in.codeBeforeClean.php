<?php
if (!defined('ABSPATH')) die('Restricted Access');

?>
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

        jQuery(".myresume-complete-status").each(function(){
            var per = jQuery( this ).attr("data-per");
            jQuery(this).find(".js-mr-rp").attr("data-progress", per);
        });

    });

     function getPackagePopup(resumeid) {
        var ajaxurl = "<?php echo admin_url('admin-ajax.php') ?>";
        jQuery.post(ajaxurl, {action: 'wpjobportal_ajax', wpjobportalme: 'multiresume', task: 'getPackagePopupForFeaturedResume', wpjobportalid: resumeid}, function (data) {
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


    function addBadgeToObject(cid, specialtype, object,themecall) {
        var themecall = arguments.length > 3 && arguments[3] !== undefined ? arguments[3] : null;
        var html = '';
        if(1 ==common.theme_chk_number){
            html +='<img alt="featured" title="'+ object.expiry+'" class="jsjb-jm-myresume-list-featured" src="<?php if(defined('JOB_PORTAL_IMAGE')) echo JOB_PORTAL_IMAGE.'/featured-icon.png'; ?>" />';
            if(jQuery('div.object_' + cid).find('div.jsjb-jm-myresume-list-top-wrap img.jsjb-jm-myresume-list-featured').length){
                jQuery('div.object_' + cid).find('div.jsjb-jm-myresume-list-top-wrap img.jsjb-jm-myresume-list-featured').remove();
            }
            jQuery('div.object_' + cid).find('div.jsjb-jm-myresume-list-data-top-title').append(html);
        }else if(2 ==common.theme_chk_number){
            html +='<div class="jsjb-jh-featured-icon"><i class="fa fa-star" aria-hidden="true"></i></div>';
            // if(jQuery('div.object_' + cid).find('div.jsjb-jh-myresume-list-top-wrap img.jsjb-jh-myresume-list-featured').length){
            //     jQuery('div.object_' + cid).find('div.jsjb-jh-myresume-list-top-wrap img.jsjb-jh-myresume-list-featured').remove();
            // }
            jQuery('div.object_' + cid).find('div.jsjb-jh-myresume-list-img-wrap').append(html);
        }else{
            html = '<span class="featurednew" data-id="' + cid + '">';
            html += '<span class="title-featured">'+object.label+'</span>';
            html += '<span class="featurednew-onhover" id="gold' + cid + '" style="display: none;">';
            html += object.expiry;
            html += '<img src="<?php echo WPJOBPORTAL_PLUGIN_URL; ?>includes/images/bottom-tool-tip.png" alt="downhover-part">';
            html += '</span>';
            html += '</span>';
            jQuery('div.object_' + cid).find('div.item-title').append(html);
        }
    }

</script>
