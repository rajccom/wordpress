<div id="wpjobportaladmin-wrapper">

	<div class="wpjobportal-temp-sample-data-wrapper" >
		<div class="wpjobportal-temp-sample-data-heading" >
			<h1> <?php
					if(wpjobportal::$_data['flag'] == 1){
						echo __('Demo data has been successfully imported','wp-job-portal').' .';
					}else{
						echo __('Please select the right demo data to import','wp-job-portal').' !';
					}
				?>
			</h1>
		</div>
		<div class="wpjobportal-temp-sample-data-links" >
			<div class="wpjobportal-temp-sample-data-top-links" >
				<?php if(wpjobportal::$_data['flag'] != 1){ ?>

						<div class="wpjobportal-temp-sample-link-wrap" >
							<img src="<?php echo WPJOBPORTAL_PLUGIN_URL; ?>includes/images/postinstallation/free.png" />
							<div class="wpjobportal-temp-sample-link-bottom-portion" >
								<span class="wpjobportal-temp-sample-text" >
									<?php echo __('Free Version','wp-job-portal'); ?>
								</span>
								<a href="<?php echo admin_url('admin.php?page=wpjobportal_postinstallation&action=wpjobportaltask&task=savetemplatesampledata&flag=f');?>" >
									<?php echo __('Import Data','wp-job-portal'); ?>
								</a>
							</div>
						</div>
						<div class="wpjobportal-temp-sample-link-wrap" >
							<img src="<?php echo WPJOBPORTAL_PLUGIN_URL; ?>includes/images/postinstallation/pro.png" />
							<div class="wpjobportal-temp-sample-link-bottom-portion" >
								<span class="wpjobportal-temp-sample-text" >
									<?php echo __('Pro Version','wp-job-portal'); ?>
								</span>
								<a href="<?php echo admin_url('admin.php?page=wpjobportal_postinstallation&action=wpjobportaltask&task=savetemplatesampledata&flag=p');?>" >
									<?php echo __('Import Data','wp-job-portal'); ?>
								</a>
							</div>
						</div>
						<div class="wpjobportal-temp-sample-link-wrap" >
							<img src="<?php echo WPJOBPORTAL_PLUGIN_URL; ?>includes/images/postinstallation/freetopro.png" />
							<div class="wpjobportal-temp-sample-link-bottom-portion" >
								<span class="wpjobportal-temp-sample-text" >
									<?php echo __('Free To Pro Updated','wp-job-portal'); ?>
								</span>
								<a href="<?php echo admin_url('admin.php?page=wpjobportal_postinstallation&action=wpjobportaltask&task=savetemplatesampledata&flag=ftp');?>" >
									<?php echo __('Import Data','wp-job-portal'); ?>
								</a>
							</div>
						</div>
				<?php } ?>
			</div>
			<div class="wpjobportal-temp-sample-data-bottom-links" >
				<a href="?page=wpjobportal" >
					<?php echo __('Click Here To Go Control Panel','wp-job-portal'); ?>
				</a>
				<?php if(wpjobportal::$theme_chk == 1){
					$url = "?page=job_manager_options";
				}else{
					$url = "?page=job_hub_options";
				}
				?>
				<a href="<?php echo esc_url($url);;?>" >
					<?php echo __('Click Here To Go Template Options','wp-job-portal'); ?>
				</a>
			</div>
		</div>
	</div>

</div>
