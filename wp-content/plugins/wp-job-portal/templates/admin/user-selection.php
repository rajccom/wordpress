<?php
/**
* user selection popup
* @param label 		name/title/label to show
* @param show_username_on_selection 	(bool) to show user display name upon user selection
* @param selectors 		array() of selectors to fill data of input fields on selection in the form 'id' => '#uid'
*                       valid values 'id','name','email'
*/
$args = array(
	'label' => __('Select','wp-job-portal') .' '. __('User', 'wp-job-portal'),
    'show_username_on_selection' => true,
    'selectors' => array('id' => '#uid')
);
if (isset($label)) {
	$args['label'] = $label;
}
if (isset($show_username_on_selection)) {
	$args['show_username_on_selection'] = $show_username_on_selection;
}
if (isset($selectors)) {
	$args['selectors'] = $selectors;
}
?>

<?php if($args['show_username_on_selection']): ?>
<span id="username-div"></span>
<?php endif; ?>
<a href="#" id="userpopup"><?php echo esc_html($args['label']); ?></a>

<!-- popup code -->
<div id="full_background" style="display:none;"></div>
<div id="popup_main" style="display:none;">
    <span class="popup-top">
    	<span id="popup_title" ></span>
    	<img id="popup_cross" alt="<?php echo __('popup cross','wp-job-portal'); ?>" src="<?php echo WPJOBPORTAL_PLUGIN_URL; ?>includes/images/popup-close.png">
    </span>
    <div class="popup-search">
        <div id="userpopupsearch">
            <div class="popup-form-fields-wrp">
                <div class="popup-form-field search-value">
                    <input type="text" name="uname" id="uname" placeholder="<?php echo __('Username', "wp-job-portal");?>" />
                </div>
                <div class="popup-form-field search-value">
                    <input type="text" name="name" id="name" placeholder="<?php echo __('Name', 'wp-job-portal');?>" />
                </div>
                <div class="popup-form-field search-value">
                    <input type="text" name="email" id="email" placeholder="<?php echo __('Email Address', 'wp-job-portal');?>"/>
                </div>
                <div class="popup-form-btn-wrp">
                    <input type="submit" class="popup-search-btn" onclick="getUserListAfterSearch()" value="<?php echo __('Search', 'wp-job-portal');?>" />
                    <input type="submit" class="popup-reset-btn" onclick="document.getElementById('name').value = '';document.getElementById('uname').value = ''; document.getElementById('email').value = '';getUserListAfterSearch()" value="<?php echo __('Reset', 'wp-job-portal');?>" />
                </div>
            </div>
        </div>
    </div>            
    <div id="popup-record-data"></div>
</div>
<!-- popup code end -->

<script type="text/javascript">
function updateuserlist(pagenum) {
    var username = jQuery("input#uname").val();
        var name = jQuery("input#name").val();
        var emailaddress = jQuery("input#email").val();
        var ajaxurl = "<?php echo admin_url('admin-ajax.php') ?>";
        jQuery.post(ajaxurl, {action: 'wpjobportal_ajax', wpjobportalme: 'user', task: 'getuserlistajax',name: name, uname: username, email: emailaddress,userlimit: pagenum, listfor: 1}, function (data) {
        if (data) {
            jQuery("div#popup-record-data").html("");
            jQuery("span#popup_title").html(jQuery("input#user-popup-title-text").val());
            jQuery("div#popup-record-data").html(data);
            setUserLink();
        }
    });
}

function getUserListAfterSearch() {
    var username = jQuery("input#uname").val();
    var name = jQuery("input#name").val();
    var emailaddress = jQuery("input#email").val();
    var ajaxurl = "<?php echo admin_url('admin-ajax.php') ?>";
    jQuery.post(ajaxurl, {action: 'wpjobportal_ajax', wpjobportalme: 'user', task: 'getuserlistajax', name: name, uname: username, email: emailaddress}, function (data) {
        if (data) {
            jQuery("span#popup_title").html(jQuery("input#user-popup-title-text").val());
            jQuery("div#popup-record-data").html(data);
            setUserLink();
        }
    });//jquery closed
}

function setUserLink() {
    jQuery("a.userpopup-link").each(function () {
        var anchor = jQuery(this);
        jQuery(anchor).click(function (e) {
        	
            var id = jQuery(this).attr('data-id');
            var name = jQuery(this).attr('data-name');
            var email = jQuery(this).attr('data-email');
            jQuery("#username-div").html(name);
            jQuery("#contactemail").val(email);

            <?php if(isset($args['selectors']['id'])): ?>
            jQuery("<?php echo esc_js($args['selectors']['id']); ?>").val(id);
            <?php endif; ?>

            <?php if(isset($args['selectors']['name'])): ?>
            jQuery("<?php echo esc_js($args['selectors']['name']); ?>").val(name);
            <?php endif; ?>

            <?php if(isset($args['selectors']['email'])): ?>
            jQuery("<?php echo esc_js($args['selectors']['email']); ?>").val(email);
            <?php endif; ?>
            <?php if(in_array('credits', wpjobportal::$_active_addons)): ?>
                jQuery('input.wpjobportal-form-save-btn').attr('credit_userid',id);
            <?php endif; ?>

            jQuery("div#popup_main").slideUp('slow', function () {
                jQuery("div#full_background").hide();
            });
        });
    });
}
jQuery(document).ready(function () {
    jQuery("a#userpopup").click(function (e) {
        e.preventDefault();
        jQuery("div#popup-new-company").css("display", "none");
        jQuery("img.icon").css("display", "none");
        jQuery("div#popup-record-data").css("display", "block");
        jQuery("div#full_background").show();
        var username = jQuery("input#uname").val();
        var name = jQuery("input#name").val();
        var emailaddress = jQuery("input#email").val();
        var ajaxurl = "<?php echo admin_url('admin-ajax.php') ?>";
        jQuery.post(ajaxurl, {action: 'wpjobportal_ajax', wpjobportalme: 'user', task: 'getuserlistajax', name: name, uname: username, email: emailaddress}, function (data) {
            if (data) {
                jQuery("div#popup-record-data").html("");
                jQuery("span#popup_title").html(jQuery("input#user-popup-title-text").val());
                jQuery("div#popup-record-data").html(data);
                setUserLink();
            }
        });
        jQuery("div#popup_main").slideDown('slow');
    });
    //jQuery("form#userpopupsearch").submit(function (e) {
    jQuery(document).delegate('form#userpopupsearch', 'submit', function (e) {
        e.preventDefault();
        e.preventDefault();
        var username = jQuery("input#uname").val();
        var name = jQuery("input#name").val();
        var emailaddress = jQuery("input#email").val();
        var ajaxurl = "<?php echo admin_url('admin-ajax.php') ?>";
        jQuery.post(ajaxurl, {action: 'wpjobportal_ajax', wpjobportalme: 'user', task: 'getuserlistajax', name: name, uname: username, email: emailaddress}, function (data) {
            if (data) {
                console.log(data);
                jQuery("span#popup_title").html(jQuery("input#user-popup-title-text").val());
                jQuery("div#popup-record-data").html(data);
                setUserLink();
            }
        });//jquery closed
    });
    jQuery("span.close, div#full_background,img#popup_cross").click(function (e) {
        jQuery("div#popup_main").slideUp('slow', function () {
            jQuery("div#full_background").hide();
        });

    });

});

</script>
