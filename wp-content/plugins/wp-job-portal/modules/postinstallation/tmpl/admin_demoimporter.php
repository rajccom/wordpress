<div id="wpjobportaladmin-wrapper">
	<div id="wpjobportaladmin-data">
		<?php
			$over_write = array(
							(object) array('id'=>0,'text'=>'Ignore and insert'),
							(object) array('id'=>1,'text'=>'Remove and insert')
			);
		$demo_flag = get_option('job_manager_demno_id');
		//$demo_flag = false;
		if(!$demo_flag){
			$demo_flag = -1;
		}
		if(get_option( 'wpjobportal_jobs_sample_data' , '') == 1){ ?>
			<div class="frontend updated"><p><?php echo __("Jobs data has been successfully imported","wp-job-portal"); ?></p></div>
			<?php
			delete_option( 'wpjobportal_jobs_sample_data' );
		}
		?>
		<div class="wpjobportal-temp-sample-data-wrapper" >
			<div class="wpjobportal-temp-sample-data-content" >
				<form method="post" action="<?php echo admin_url("admin.php?page=wpjobportal_postinstallation&task=getdemocode&action=wpjobportaltask"); ?>" id="sample_data_form" >
					<div class="wpjobportal-temp-sample-data-content-left" >
						<div class="wpjobportal-temp-sample-data-content-demo-title" >
							<?php echo __('Select the demo data to import','wp-job-portal').' !';?>
						</div>
						<div class="wpjobportal-temp-sample-data-content-demo-combo" ><?php
							if(isset(wpjobportal::$_data[0]) && !empty(wpjobportal::$_data[0])){
								echo wp_kses(WPJOBPORTALformfield::select('demoid', wpjobportal::$_data[0], $demo_flag, __('Select demo', 'wp-job-portal'), array('class' => 'wpjobportal_inputbox', 'data-validation' => 'required', 'onchange' => 'demoChanged(this.options[this.selectedIndex].value);')),WPJOBPORTAL_ALLOWED_TAGS);
							}?>
						</div>
						<div class="wpjobportal-temp-sample-data-content-demo-desc" id="demo_desc" >
							 
						</div>
						<div class="wpjobportal-temp-sample-data-content-demo-overwrite" id="demo_overwrite_wrap" style="display: none;">
							<label for="demo_overwrite"><?php echo __('What to do with previous demo data','wp-job-portal');?></label>
							<?php echo wp_kses(WPJOBPORTALformfield::select('demo_overwrite', $over_write, 1, '', array('class' => 'wpjobportal_inputbox', 'onchange' => 'showMessage(this.options[this.selectedIndex].value);')),WPJOBPORTAL_ALLOWED_TAGS); ?>
							<div id="demo_warning">
								 
							</div>
						</div>
						<div class="wpjobportal-temp-sample-data-content-demo-button">
							<input type="submit" name="submitbutton" value="Get Demo" id="submit_button">
						</div>
					</div>
					<div class="wpjobportal-temp-sample-data-content-right" >
						<div class="wpjobportal-temp-sample-data-content-image-wrapper" id="demo_section" style="display: none;">
							<img id="demo_image"  src="<?php //echo esc_url(wpjobportal::$_data[1][0]['imagepath']) ;?>">
						</div>
					</div>
					<input type="hidden" name="foldername" value="" id="demo_foldername">
				</form>
			</div>
		</div>
		<div class="wpjobportal-sample-data-loading" id="wpjobportal_sample_loading" style="display: none;" >
			<img src="<?php echo WPJOBPORTAL_PLUGIN_URL.'includes/images/loading.gif';?>">
		</div>
	</div>
</div>
<script>
	var images = new Array();
	var names = new Array();
	var descs = new Array();
	var folders = new Array();
	var demo_flag_js = <?php echo $demo_flag ;?>;
	<?php
		foreach (wpjobportal::$_data[1] as $key => $value) {
			echo 'images['.$key.'] = "'.$value['imagepath'].'";';
			echo 'names['.$key.'] = "'.$value['name'].'";';
			echo 'descs['.$key.'] = "'.$value['desc'].'";';
			echo 'folders['.$key.'] = "'.$value['foldername'].'";';
		}
	?>
	if(demo_flag_js != -1){
		jQuery( document ).ready(function() {
		    demoChanged(demo_flag_js);
		});
	}
	function demoChanged(demoid){
		if(demoid == ''){
			jQuery('#submit_button').prop('disabled', true);
			return;
		}
		jQuery('#demo_image').attr('src',"<?php echo WPJOBPORTAL_PLUGIN_URL.'includes/images/loading.gif'; ?>");
		// image loading
		var $image = jQuery("#demo_image");
		var $downloadingImage = jQuery("<img>");
		$downloadingImage.load(function(){
			$image.attr("src", jQuery(this).attr("src"));
		});
		$downloadingImage.attr("src",images[demoid]);
		jQuery('#demo_name').html(names[demoid]);
		jQuery('#demo_desc').html(descs[demoid]);
		jQuery('input#demo_foldername').val(folders[demoid]);
		jQuery('#demo_section').show();
		if(demo_flag_js != -1){
			if(demo_flag_js != demoid){
				jQuery('#demo_overwrite_wrap').show();
				jQuery('#submit_button').prop('disabled', false);
			}else{
				jQuery('#demo_overwrite_wrap').hide();
				jQuery('#submit_button').prop('disabled', true);
			}
		}
	}

	function showMessage(optionid){
		if(optionid == 1){
			jQuery('#demo_warning').html("<?php echo __('All the content of previus demo data will be deleted.','wp-job-portal');?>");
		}else{
			jQuery('#demo_warning').html(' ');
		}
	}

jQuery(document).ready(function() {
	if(demo_flag_js != -1){
		jQuery('#submit_button').prop('disabled', true);
	}
	 jQuery("form#sample_data_form").on("submit", function(){
	   jQuery("#wpjobportal_sample_loading").show();
	   return true;
   	});
});
</script>
