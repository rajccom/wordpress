<script >
    jQuery(document).ready(function ($) {
        //Token Input
        var multicities = <?php echo isset(wpjobportal::$_data['filter']['city']) ? wpjobportal::$_data['filter']['city'] : "''" ?>;
        getTokenInput(multicities);
         jQuery('a.sort-icon').click(function (e) {
            e.preventDefault();
            changeSortBy();
        });

    });
    //Token in put
    function getTokenInput(multicities) {
        var cityArray = '<?php echo admin_url("admin.php?page=wpjobportal_city&action=wpjobportaltask&task=getaddressdatabycityname"); ?>';
        jQuery("#city").tokenInput(cityArray, {
            theme: "wpjobportal",
            preventDuplicates: true,
            prePopulate: multicities,
            hintText: "<?php echo __('Type In A Search Term', 'wp-job-portal'); ?>",
            noResultsText: "<?php echo __('No Results', 'wp-job-portal'); ?>",
            searchingText: "<?php echo __('Searching', 'wp-job-portal'); ?>"
        });
        jQuery("#wpjobportal-input-city").attr("placeholder", "<?php echo __('Type city:', 'wp-job-portal'); ?>");
    }

    function closePopupJobManager() {
        closePopupForTemplate();
    }

    function closePopupJobHub() {
        closePopupForTemplate()
    }

    function closePopupForTemplate() {
        jQuery("div#"+common.theme_chk_prefix+"-popup").slideUp('slow');
        setTimeout(function () {
            jQuery("div#"+common.theme_chk_prefix+"-popup-background").hide();
            //jQuery("#"+common.theme_chk_prefix+"-modal-ar-title").html('');
            jQuery("div#"+common.theme_chk_prefix+"-popup").css("display", "none");
            /*jQuery("span#popup_coverletter_title.coverletter").html('');
            jQuery("span#popup_coverletter_desc.coverletter").html('');*/
        }, 700);

    }

    function changeSortBy() {
        var value = jQuery('a.sort-icon').attr('data-sortby');
        var img = '';
        if (value == 1) {
            value = 2;
            img = jQuery('a.sort-icon').attr('data-image2');
        } else {
            img = jQuery('a.sort-icon').attr('data-image1');
            value = 1;
        }
        jQuery("img#sortingimage").attr('src', img);
        jQuery('input#sortby').val(value);
        jQuery('form#resume_form').submit();
    }
    function changeCombo() {
        jQuery("input#sorton").val(jQuery('select#sorting').val());
        changeSortBy();
    }

</script>
