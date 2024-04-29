<?php
if (!defined('ABSPATH'))
    die('Restricted Access');

// show calender
wp_enqueue_script('jquery-ui-datepicker');
wp_enqueue_style('jquery-ui-css', WPJOBPORTAL_PLUGIN_URL . 'includes/css/jquery-ui-smoothness.css');
$config = wpjobportal::$_configuration;
if ($config['date_format'] == 'm/d/Y' || $config['date_format'] == 'd/m/y' || $config['date_format'] == 'm/d/y' || $config['date_format'] == 'd/m/Y') {
    $dash = '/';
} else {
    $dash = '-';
}
$dateformat = $config['date_format'];
$firstdash = wpjobportalphplib::wpJP_strpos($dateformat, $dash, 0);
$firstvalue = wpjobportalphplib::wpJP_substr($dateformat, 0, $firstdash);
$firstdash = $firstdash + 1;
$seconddash = wpjobportalphplib::wpJP_strpos($dateformat, $dash, $firstdash);
$secondvalue = wpjobportalphplib::wpJP_substr($dateformat, $firstdash, $seconddash - $firstdash);
$seconddash = $seconddash + 1;
$thirdvalue = wpjobportalphplib::wpJP_substr($dateformat, $seconddash, wpjobportalphplib::wpJP_strlen($dateformat) - $seconddash);
$js_dateformat = '%' . $firstvalue . $dash . '%' . $secondvalue . $dash . '%' . $thirdvalue;
$js_scriptdateformat = $firstvalue . $dash . $secondvalue . $dash . $thirdvalue;
$js_scriptdateformat = wpjobportalphplib::wpJP_str_replace('Y', 'yy', $js_scriptdateformat);
// 
$mapfield = null;
if(isset(wpjobportal::$_data[2]))
foreach(wpjobportal::$_data[2] AS $key => $value){
    $value = (array) $value;
    if(in_array('map', $value)){
        $mapfield = $key;
        break;
    }
}

?>
<style type="text/css">
.ui-datepicker{
    float: left;
}
</style>
<script >
    jQuery(document).ready(function (jQuery) {
        addDatePicker();
        jQuery(".wpjobportal-multiselect").chosen({
            placeholder_text_multiple: "<?php echo esc_html(__('Select some options', 'wp-job-portal')); ?>"
        });
        //Token Input
        var multicities = <?php echo isset(wpjobportal::$_data[0]->multicity) ? wpjobportal::$_data[0]->multicity : "''" ?>;
        getTokenInput(multicities);
        <?php if(in_array('tag',wpjobportal::$_active_addons)){?>
                getTokenInputtags();
       <?php } ?>
        <?php
        if(in_array('addressdata', wpjobportal::$_active_addons)){
            if(isset(wpjobportal::$_data[2][$mapfield]) && wpjobportal::$_data[2][$mapfield]->published == 1){ ?>
            loadMap();
            <?php
            }
        }?>
        //Validation
        jQuery.validate();
    });
    var ajaxurl = "<?php echo admin_url('admin-ajax.php') ?>";

    function addDatePicker(){
        jQuery('.custom_date').datepicker({dateFormat: '<?php echo $js_scriptdateformat; ?>'});
    }
</script>
<style>
    div#map{
        width: 100%;
        height: 100%;
    }
    div#map_container{
        height:<?php echo esc_attr(wpjobportal::$_configuration['mapheight']) . 'px'; ?>;
        width:100%;
    }
</style>
<?php
if(isset(wpjobportal::$_data[2][$mapfield]) && wpjobportal::$_data[2][$mapfield]->published == 1){ ?>
<?php $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://"; ?>
<?php
        $mappingservice = wpjobportal::$_config->getConfigValue('mappingservice');
        if($mappingservice == 'gmap'){
            wp_register_script ( 'wpjp-google-map-api', $protocol . 'maps.googleapis.com/maps/api/js?key=' . wpjobportal::$_config->getConfigValue('google_map_api_key') );
            wp_enqueue_script ( 'wpjp-google-map-api' );
        }elseif($mappingservice == 'osm'){
            wp_register_script ( 'wpjp-osm-map-js', WPJOBPORTAL_PLUGIN_URL.'/includes/js/ol.min.js' );
            wp_enqueue_script( 'wpjp-osm-map-js' );
            wp_enqueue_style( 'wpjp-osm-map-css', WPJOBPORTAL_PLUGIN_URL.'/includes/css/ol.min.css' );
        } ?>
<script >

    var lmap = {
        map:null,
        marker:null,
        init: function(){
            this.toggleMap();
            jQuery("#showmap1").bind('change',lmap.toggleMap);
        },
        toggleMap: function(){
            if(!jQuery("#showmap1").length || jQuery("#showmap1:checked").val()){
                lmap.showMap();
            }else{
                lmap.hideMap();
            }
        },
        showMap: function(){
            jQuery("#map-latlng-wrap").show();
            if(!this.map){
                this.loadMap();
            }
        },
        hideMap: function(){
            jQuery("#map-latlng-wrap").hide();
        },
        loadMap: function(){
        <?php if($mappingservice == 'osm'){ ?>
            var default_latitude = parseFloat(document.getElementById('default_latitude').value);
            var default_longitude = parseFloat(document.getElementById('default_longitude').value);

            var latitude = document.getElementById('latitude').value;
            var longitude = document.getElementById('longitude').value;

            if (latitude != '' && longitude != '') {
                default_latitude = latitude;
                default_longitude = longitude;
            }
            lmap.map = new ol.Map({
                target: 'map_container',
                controls: ol.control.defaults().extend([new ol.control.FullScreen()]),
                layers: [
                    new ol.layer.Tile({
                        source: new ol.source.OSM()
                    })
                ],
                view: new ol.View({
                    center: ol.proj.fromLonLat([default_longitude,default_latitude]),
                    zoom: 14,
                }),
            });
            lmap.map.addEventListener('click',function(event){
                lmap.addMarker(ol.proj.transform(event.coordinate, 'EPSG:3857', 'EPSG:4326'));
            });
            <?php } ?>
        },
        addMarker: function(latlang){
            if(!lmap.map){
                return false;
            }
            <?php if($mappingservice == 'osm'){ ?>
            if(lmap.marker){
                lmap.map.removeLayer(lmap.marker);
            }
            lmap.marker = osmAddMarker(lmap.map, latlang);
            lmap.map.getView().setCenter(ol.proj.transform(latlang, 'EPSG:4326', 'EPSG:3857'));
            document.getElementById('latitude').value = latlang[1];
            document.getElementById('longitude').value = latlang[0];
            <?php } ?>
        }
    };


    function loadMap() {
        var default_latitude = document.getElementById('default_latitude').value;
        var default_longitude = document.getElementById('default_longitude').value;

        var latitude = document.getElementById('latitude').value;
        var longitude = document.getElementById('longitude').value;
        var latitude1 = "";
        var longitude1 = "";
        if (latitude) {
            latitude1 = latitude;            
        }
        if (longitude) {
            longitude1 = longitude;            
        }

        if (latitude != '' && longitude != '') {
            default_latitude = latitude;
            default_longitude = longitude;
        }
        <?php  if($mappingservice == "gmap"){ ?>
        var latlng = new google.maps.LatLng(default_latitude, default_longitude);
        zoom = 10;
        var myOptions = {
            zoom: zoom,
            center: latlng,
            scrollwheel: false,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        };
        var map = new google.maps.Map(document.getElementById("map_container"), myOptions);
        var lastmarker = new google.maps.Marker({
            postiion: latlng,
            map: map,
        });
        google.maps.event.addListener(map, "click", function (e) {
            var latLng = new google.maps.LatLng(e.latLng.lat(), e.latLng.lng());
            geocoder = new google.maps.Geocoder();
            geocoder.geocode({'latLng': latLng}, function (results, status) {
                if (status == google.maps.GeocoderStatus.OK) {
                    if (lastmarker != '')
                        lastmarker.setMap(null);
                    var marker = new google.maps.Marker({
                        position: results[0].geometry.location,
                        map: map,
                    });
                    lastmarker = marker;
                    document.getElementById('longitude').value = marker.position.lng();
                    document.getElementById('latitude').value = marker.position.lat();
                } else {
                    alert("<?php echo __("Geocode was not successful for the following reason", "wp-job-portal"); ?>:" + status);
                }
            });
        });
    <?php }elseif ($mappingservice == "osm") {?>
        ///alert('abc');
   <?php } ?>
    }
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
</script>
<?php } ?>
<script >
    //Token in put
    function getTokenInput(multicities) {
       var cityArray = '<?php echo admin_url("admin.php?page=wpjobportal_city&action=wpjobportaltask&task=getaddressdatabycityname"); ?>';

        jQuery("#city").tokenInput(cityArray, {
            theme: "wpjobportal",
            preventDuplicates: true,
            hintText: "<?php echo __('Type In A Search Term', 'wp-job-portal'); ?>",
            noResultsText: "<?php echo __('No Results', 'wp-job-portal'); ?>",
            searchingText: "<?php echo __('Searching', 'wp-job-portal'); ?>"
        });
    }

    function getTokenInputtags() {
        var tagarray = '<?php echo admin_url("admin.php?page=wpjobportal_tag&tagfor=1&action=wpjobportaltask&task=gettagsbytagname"); ?>';
        jQuery("#tags").tokenInput(tagarray, {
            theme: "wpjobportal",
            preventDuplicates: true,
            tokenLimit: 5,
            hintText: "<?php echo __('Type In A Search Term', 'wp-job-portal'); ?>",
            noResultsText: "<?php echo __('No Results', 'wp-job-portal'); ?>",
            searchingText: "<?php echo __('Searching', 'wp-job-portal'); ?>"
        });
    }
     jQuery(document).ready(function ($) {
        lmap.init();
     });
</script>
