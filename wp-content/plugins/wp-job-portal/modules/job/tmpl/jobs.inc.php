<?php
if (!defined('ABSPATH'))
    die('Restricted Access');

wp_enqueue_style('wpjobportal-ratingstyle', WPJOBPORTAL_PLUGIN_URL . 'includes/css/wpjobportalrating.css');
$protocol = wpjobportal::$_common->getServerProtocol();
$default_longitude = wpjobportal::$_configuration['default_longitude'];
$default_latitude = wpjobportal::$_configuration['default_latitude'];
$mapfield = null;
$mapfield2 = null;

if(isset(wpjobportal::$_data[2]))
foreach(wpjobportal::$_data[2] AS $key => $value){
    $value = (array) $value;
    if(in_array('map', $value)){
        $mapfield = $key;
        break;
    }
}

if(isset(wpjobportal::$_data['fields']))
foreach(wpjobportal::$_data['fields'] AS $key => $value){
    $value = (array) $value;
    if(in_array('map', $value)){
        $mapfield2 = $key;
        break;
    }
}
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
if(isset(wpjobportal::$_data[2][$mapfield]) && wpjobportal::$_data[2][$mapfield]->published == 1){
   wp_enqueue_script( 'mapAPI',$protocol.'maps.googleapis.com/maps/api/js?key='.wpjobportal::$_configuration['google_map_api_key']);
}elseif($mapfield2 != null) {
   wp_enqueue_script( 'mapAPI',$protocol.'maps.googleapis.com/maps/api/js?key='.wpjobportal::$_configuration['google_map_api_key']);
}
   wp_enqueue_script( 'mapAPI',$protocol.'maps.googleapis.com/maps/api/js?key='.wpjobportal::$_configuration['google_map_api_key']);
?>
<script >
    var ajaxurl = "<?php echo admin_url('admin-ajax.php'); ?>";
    jQuery(document).ready(function ($) {
        $("div#wpjobportal-popup-background,img#popup_cross").click(function () {
            closePopup();
        });
       /*Indendation Code to clear Job Search*/
        jQuery("#reset-newest-jobfilter").click(function(){
            jQuery('#jobtitle').removeAttr('value');
            jQuery("#city").tokenInput("clear",{focus:false});
            jQuery('#job_form').submit();
        });
    });

    function closePopup() {
        jQuery("div#wpjobportal-search-popup,div#wpjobportal-listpopup").slideUp('slow');
        setTimeout(function () {
            jQuery("div#wpjobportal-popup-background").hide();
        }, 700);
    }

    function showPopup() {
        jQuery("div#wpjobportal-popup-background").show();
        jQuery("div#wpjobportal-search-popup").slideDown('slow');
    }

    // function loadMap1() {
    //     var default_latitude = document.getElementById('latitude1').value;
    //     var default_longitude = document.getElementById('longitude1').value;
    //     default_latitude = default_latitude.split(',');
    //     if(default_latitude instanceof Array){
    //         default_longitude = default_longitude.split(',');
    //         var latlng = new google.maps.LatLng(default_latitude[0], default_longitude[0]);
    //         zoom = 4;
    //         var myOptions = {
    //             zoom: zoom,
    //             center: latlng,
    //             scrollwheel: false,
    //             mapTypeId: google.maps.MapTypeId.ROADMAP
    //         };
    //         map = new google.maps.Map(document.getElementById("map_container1"), myOptions);
    //         for (i = 0; i < default_latitude.length; i++) {
    //             var latlng = new google.maps.LatLng(default_latitude[i], default_longitude[i]);
    //             addMarker(latlng);
    //         }
    //     }else{
    //         var latlng = new google.maps.LatLng(default_latitude, default_longitude);
    //         zoom = 10;
    //         var myOptions = {
    //             zoom: zoom,
    //             center: latlng,
    //             scrollwheel: false,
    //             mapTypeId: google.maps.MapTypeId.ROADMAP
    //         };
    //         map = new google.maps.Map(document.getElementById("map_container"), myOptions);
    //         addMarker(latlng);
    //     }

    // }

    // function addMarker(latlang){
    //     var marker = new google.maps.Marker({
    //         position: latlang,
    //         map: map,
    //         draggable: false,
    //     });
    //     marker.setMap(map);
    // }



    // function loadMap() {
    //     var default_latitude = '<?php echo $default_latitude; ?>';
    //     var default_longitude = '<?php echo $default_longitude; ?>';

    //     var latitude = document.getElementById('latitude').value;
    //     var longitude = document.getElementById('longitude').value;

    //     if (latitude != '' && longitude != '') {
    //         default_latitude = latitude;
    //         default_longitude = longitude;
    //     }
    //     var latlng = new google.maps.LatLng(default_latitude, default_longitude);
    //     zoom = 10;
    //     var myOptions = {
    //         zoom: zoom,
    //         center: latlng,
    //         scrollwheel: false,
    //         mapTypeId: google.maps.MapTypeId.ROADMAP
    //     };
    //     var map = new google.maps.Map(document.getElementById("map_container"), myOptions);
    //     var lastmarker = new google.maps.Marker({
    //         postiion: latlng,
    //         map: map,
    //     });

    //     google.maps.event.addListener(map, "click", function (e) {
    //         var latLng = new google.maps.LatLng(e.latLng.lat(), e.latLng.lng());
    //         geocoder = new google.maps.Geocoder();
    //         geocoder.geocode({'latLng': latLng}, function (results, status) {
    //             if (status == google.maps.GeocoderStatus.OK) {
    //                 if (lastmarker != '')
    //                     lastmarker.setMap(null);
    //                 var marker = new google.maps.Marker({
    //                     position: results[0].geometry.location,
    //                     map: map,
    //                 });
    //                 marker.setMap(map);
    //                 lastmarker = marker;
    //                 document.getElementById('latitude').value = marker.position.lat();
    //                 document.getElementById('longitude').value = marker.position.lng();

    //             } else {
    //                 alert("<?php echo __("Geocode was not successful for the following reason", "wp-job-portal"); ?>"+": " + status);
    //             }
    //         });
    //     });
    // }

    function getPackagePopupJobView(jobid) {
        var ajaxurl = "<?php echo admin_url('admin-ajax.php') ?>";
        jQuery.post(ajaxurl, {action: 'wpjobportal_ajax', wpjobportalme: 'job', task: 'getPackagePopupJobView', wpjobportalid: jobid}, function (data) {
            if (data) {
                if(jQuery("#package-popup").length)
                jQuery("#package-popup").remove();
                jQuery('body').append(data);
                jQuery("#package-popup").modal();

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

</script>
<style>
    div#wpjobportal-hide{display: none;width: 100%;}
    div#map{width: 100%;height: 100%;}
    div#map_container,div#map_container1{
        height:<?php echo wpjobportal::$_configuration['mapheight'].'px'; ?>;
        width:100%;
    }
</style>
<script >
    jQuery(document).ready(function ($) {
        jQuery(".wpjobportal-multiselect").chosen({
            placeholder_text_multiple: "<?php echo __('Select some options', 'wp-job-portal'); ?>"
        });

        //Token Input
        var multicities = <?php echo isset(wpjobportal::$_data['filter']['city']) ? wpjobportal::$_data['filter']['city'] : "''" ?>;
        getTokenInput(multicities);

        //Validation
        jQuery.validate();
    });
    function checkmapcooridnate() {
        var latitude = document.getElementById('latitude').value;
        var longitude = document.getElementById('longitude').value;
        var radius = document.getElementById('radius').value;
        if (latitude != '' && longitude != '') {
            if (radius != '') {
                this.form.submit();
            } else {
                alert("<?php echo __("Please enter the coordinate radius", "wp-job-portal"); ?>");
                return false;
            }
        }
    }
    //Token in put
    function getTokenInput(multicities) {
        //var cityArray = '<?php echo admin_url("admin.php?page=wpjobportal_city&action=wpjobportaltask&task=getaddressdatabycityname"); ?>';
        var cityArray = '<?php echo admin_url("admin-ajax.php?page=wpjobportal_city&action=wpjobportaltask&task=getaddressdatabycityname"); ?>';
        jQuery("#city").tokenInput(cityArray, {
            theme: "wpjobportal",
            preventDuplicates: true,
            prePopulate: multicities,
            hintText: "<?php echo __('Type in city name', 'wp-job-portal'); ?>",
            noResultsText: "<?php echo __('No Results', 'wp-job-portal'); ?>",
            searchingText: "<?php echo __('Searching', 'wp-job-portal'); ?>..."
        });
        jQuery("#wpjobportal-input-city").attr("placeholder", "<?php echo __('Type city:', 'wp-job-portal'); ?>");
    }
</script>
