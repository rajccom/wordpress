<?php
/**
* @param wp-job-portal Action
*/

switch ($control) {
	case 'control': ?>
		<div id="item-actions" class="wpjobportal-company-action-wrp">
			<?php
				/**
				* @param Feature Company Admin 
				*/
				do_action('wpjobportal_addons_control_company_admin',$company);
			?>
		    <a class="wpjobportal-company-act-btn" href="<?php echo esc_url(admin_url('admin.php?page=wpjobportal_company&wpjobportallt=formcompany&wpjobportalid='.$company->id)); ?>" title="<?php echo __('Edit', 'wp-job-portal') ?>">
		    	<?php echo __('Edit', 'wp-job-portal') ?>
		    </a>
		    <a class="wpjobportal-company-act-btn" href="<?php echo esc_url(wp_nonce_url(admin_url('admin.php?page=wpjobportal_company&task=remove&action=wpjobportaltask&&callfrom=1&wpjobportal-cb[]='.$company->id),'delete-company')); ?>" onclick='return confirm("<?php echo __('Are you sure to delete','wp-job-portal').' ?'; ?>");' title="<?php echo __('delete', 'wp-job-portal'); ?>">
		    	<?php echo __('Delete', 'wp-job-portal'); ?>
		    </a>
		    <a class="wpjobportal-company-act-btn" href="<?php echo esc_url(wp_nonce_url(admin_url('admin.php?page=wpjobportal_company&task=enforcedelete&action=wpjobportaltask&callfrom=1&id='.$company->id),'delete-company')); ?>"onclick='return confirmdelete("<?php echo __('This will delete every thing about this record','wp-job-portal').'. '.__('Are you sure to delete','wp-job-portal').' ?'; ?>");' title="<?php echo __('enforce delete', 'wp-job-portal') ?>">
		    	<?php echo __('Enforce Delete', 'wp-job-portal') ?>
		    </a>
		    <?php if(in_array('departments', wpjobportal::$_active_addons)): ?>
			    <a class="wpjobportal-company-act-btn" href="<?php echo esc_url(admin_url('admin.php?page=wpjobportal_departments&wpjobportallt=departments&companyid='.$company->id)); ?>" title="<?php echo __('departments', 'wp-job-portal') ?>">
			    	<?php echo __('Departments', 'wp-job-portal') ?>
			    </a>
		    <?php  endif ;?>
		</div>
		<?php	break;
		case 'que-control': ?>
			<div class="wpjobportal-company-action-wrp">
				<a class="wpjobportal-company-act-btn" href="<?php echo esc_url(admin_url('admin.php?page=wpjobportal_company&wpjobportallt=formcompany&wpjobportalid='.$company->id)); ?>" title="<?php echo __('Edit', 'wp-job-portal') ?>">
			    	<?php echo __('Edit', 'wp-job-portal') ?>
			    </a>
			    <?php
			        /*$total = count($arr);
			        if ($total == 3) {
			            $objid = 4; //for all
			        } elseif ($total != 1) {
			        }
			        if ($total == 1) {*/
			            if (isset($arr['self'])) {
			                ?>
			                <a class="wpjobportal-company-act-btn" href="admin.php?page=wpjobportal_company&task=approveQueueCompany&id=<?php echo esc_attr($company->id); ?>&action=wpjobportaltask" title="<?php echo __('approve', 'wp-job-portal'); ?>">
			                	<?php echo __('Company Approve', 'wp-job-portal'); ?>
			                </a>
			            <?php
			            } if (isset($arr['feature']) && in_array('featuredcompany', wpjobportal::$_active_addons)) { ?>
			                <a class="wpjobportal-company-act-btn" href="admin.php?page=wpjobportal_company&task=approveQueueFeaturedCompany&id=<?php echo esc_attr($company->id); ?>&action=wpjobportaltask" title="<?php echo __('approve', 'wp-job-portal'); ?>">
			                	<?php echo __('Feature Approve', 'wp-job-portal'); ?>
			                </a>
		                <?php
                        }
			        /*}
			         else {
			            ?>
			            <div class="js-bottomspan jobsqueue-approvalqueue" onmouseout="hideThis(this);" onmouseover="approveActionPopup('<?php echo esc_js($company->id); ?>');"><img src="<?php echo WPJOBPORTAL_PLUGIN_URL; ?>includes/images/publish-icon.png">  <?php echo __('Approve', 'wp-job-portal'); ?>
			                <div id="wpjobportal-queue-actionsbtn" class="jobsqueueapprove_<?php echo esc_attr($company->id); ?>">
			                    <?php if (isset($arr['self'])) { ?>
			                        <a id="wpjobportal-act-row" class="wpjobportal-act-row" href="admin.php?page=wpjobportal_company&task=approveQueueCompany&id=<?php echo esc_attr($company->id); ?>&action=wpjobportaltask">
			                        	<img class="jobs-action-image" src="<?php echo WPJOBPORTAL_PLUGIN_URL; ?>includes/images/comapny-logo.png">
			                        	<?php echo __("Company Approve", 'wp-job-portal'); ?>
			                        </a>
			                    <?php
			                    } ?>
			                </div>
						</div>
				    	<?php
					}
					//END APPROVE SECTION
					if ($total == 1) {*/
					    if (isset($arr['self'])) {
					        ?>
					        <a class="wpjobportal-company-act-btn" href="admin.php?page=wpjobportal_company&task=rejectQueueCompany&id=<?php echo esc_attr($company->id); ?>&action=wpjobportaltask" title="<?php echo __('reject', 'wp-job-portal'); ?>">
					        	<?php echo __('Company Reject', 'wp-job-portal'); ?>
					        </a>
					    <?php
					    } if (isset($arr['feature']) && in_array('featuredcompany', wpjobportal::$_active_addons)) {
					        ?>
					        <a class="wpjobportal-company-act-btn" href="admin.php?page=wpjobportal_company&task=rejectQueueFeatureCompany&id=<?php echo esc_attr($company->id); ?>&action=wpjobportaltask" title="<?php echo __('reject', 'wp-job-portal'); ?>">
					        	<?php echo __('Feature Reject', 'wp-job-portal'); ?>
					        </a>
					    <?php
					    }
					/*} else {
					    ?>
					    <div class="js-bottomspan jobsqueue-approvalqueue" onmouseout="hideThis(this);" onmouseover="rejectActionPopup('<?php echo esc_js($company->id); ?>');">
					    	<img src="<?php echo WPJOBPORTAL_PLUGIN_URL; ?>includes/images/reject-s.png">
					    	<?php echo __('Reject', 'wp-job-portal'); ?>
					        <div id="wpjobportal-queue-actionsbtn" class="jobsqueuereject_<?php echo esc_attr($company->id); ?>">
					            <?php if (isset($arr['self'])) { ?>
					                <a id="wpjobportal-act-row" class="wpjobportal-act-row" href="admin.php?page=wpjobportal_company&task=rejectQueueCompany&id=<?php echo esc_attr($company->id); ?>&action=wpjobportaltask" title="<?php echo __("company reject", 'wp-job-portal'); ?>">
					                	<img class="jobs-action-image" src="<?php echo WPJOBPORTAL_PLUGIN_URL; ?>includes/images/comapny-logo.png">
					                	<?php echo __("Company Reject", 'wp-job-portal'); ?>
					                </a>
					            <?php
					            }
								?>
					            <a id="wpjobportal-act-row-all" class="wpjobportal-act-row-all" href="admin.php?page=wpjobportal_company&task=rejectQueueAllCompanies&objid=<?php echo esc_attr($objid); ?>&id=<?php echo esc_attr($company->id); ?>&action=wpjobportaltask" title="<?php echo __("all reject", 'wp-job-portal'); ?>">
					            	<img class="jobs-action-image" src="<?php echo WPJOBPORTAL_PLUGIN_URL; ?>includes/images/select-all.png">
					            	<?php echo __("All Reject", 'wp-job-portal'); ?>
					            </a>
					        </div>
					    </div>
						<?php                         
					}*/
		    	?>
				<a class="wpjobportal-company-act-btn" href="<?php echo esc_url(wp_nonce_url(admin_url('admin.php?page=wpjobportal_company&task=remove&action=wpjobportaltask&wpjobportal-cb[]='.$company->id),'delete-company')); ?>&callfrom=2" onclick='return confirm("<?php echo __('Are you sure to delete','wp-job-portal').' ?'; ?>");' title="<?php echo __('delete', 'wp-job-portal'); ?>">
		            <?php echo __('Delete', 'wp-job-portal'); ?>
		        </a>
		        <a class="wpjobportal-company-act-btn" href="<?php echo esc_url(wp_nonce_url(admin_url('admin.php?page=wpjobportal_company&task=enforcedelete&action=wpjobportaltask&id='.$company->id),'delete-company')); ?>&callfrom=2" onclick='return confirmdelete("<?php echo __('This will delete every thing about this record','wp-job-portal').'. '.__('Are you sure to delete','wp-job-portal').' ?'; ?>");' title="<?php echo __('force delete', 'wp-job-portal'); ?>">
		            <?php echo __('Force Delete', 'wp-job-portal'); ?>
		        </a>
			</div>
			<?php
		break;
}
?>

	
