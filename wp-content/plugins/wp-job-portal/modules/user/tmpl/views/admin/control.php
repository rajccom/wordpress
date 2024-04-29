<?php
/**
* @param js-job Controll
*/
?>
<?php
$html = '';
switch ($layout) {
	case 'usercontrol':
		?>
		<div class="wpjobportal-user-action-wrp">
		    <a class="wpjobportal-user-act-btn" href="<?php echo admin_url('admin.php?page=wpjobportal_user&action=wpjobportaltask&task=enforcedeleteuser&wpjobportalid='.$user->id); ?>" onclick='return confirm("<?php echo __('This will delete every thing about this record','wp-job-portal').'. '.__('Are you sure to delete','wp-job-portal').'?'; ?>");' title="<?php echo __('enforce delete', 'wp-job-portal') ?>">
		    	<?php echo __('Enforce Delete', 'wp-job-portal') ?>
		    </a>
		    <a class="wpjobportal-user-act-btn" href="<?php echo admin_url('admin.php?page=wpjobportal_user&action=wpjobportaltask&task=deleteuser&wpjobportalid='.$user->id); ?>" onclick='return confirm("<?php echo __('Are you sure to delete', 'wp-job-portal').' ?'; ?>");' title="<?php echo __('delete', 'wp-job-portal') ?>">
		    	<?php echo __('Delete', 'wp-job-portal') ?>
		    </a>
		    <a class="wpjobportal-user-act-btn" href="<?php echo admin_url('admin.php?page=wpjobportal_user&action=wpjobportaltask&task=changeuserstatus&wpjobportalid='.$user->id); ?>" title="<?php echo ($user->status == 1) ? __('Disable', 'wp-job-portal') : __('Enable', 'wp-job-portal'); ?>">
		    	<?php echo ($user->status == 1) ? __('Disable', 'wp-job-portal') : __('Enable', 'wp-job-portal'); ?>
		    </a>
		    <a class="wpjobportal-user-act-btn" href="<?php echo admin_url('admin.php?page=wpjobportal_user&wpjobportallt=changerole&wpjobportalid='.$user->id); ?>" title="<?php echo __('change role', 'wp-job-portal') ?>">
		    	<?php echo __('Change Role', 'wp-job-portal') ?>
		    </a>
		</div>

<?php
		break;
	case 'userdetailcontrol':
		?>
		<div class="wpjobportal-user-action-wrp">
            <a class="wpjobportal-user-act-btn" href="<?php echo admin_url('admin.php?page=wpjobportal_user&action=wpjobportaltask&task=enforcedeleteuser&wpjobportalid='.$user->id); ?>" onclick='return confirm("<?php echo __('This will delete every thing about this record','wp-job-portal').'. '.__('Are you sure to delete','wp-job-portal').'?'; ?>");' title="<?php echo __('enforce delete', 'wp-job-portal') ?>">
            	<?php echo __('Enforce Delete', 'wp-job-portal') ?>
            </a>
            <a class="wpjobportal-user-act-btn" href="<?php echo admin_url('admin.php?page=wpjobportal_user&action=wpjobportaltask&task=deleteuser&wpjobportalid='.$user->id); ?>" onclick='return confirm("<?php echo __('Are you sure to delete', 'wp-job-portal').' ?'; ?>");' title="<?php echo __('delete', 'wp-job-portal') ?>">
            	<?php echo __('Delete', 'wp-job-portal') ?>
            </a>
            <a class="wpjobportal-user-act-btn" href="<?php echo admin_url('admin.php?page=wpjobportal_user&action=wpjobportaltask&task=changeuserstatus&wpjobportalid='.$user->id); ?>&detail=1" title="<?php echo ($user->status == 1) ? __('Disable', 'wp-job-portal') : __('Enable', 'wp-job-portal'); ?>">
            	<?php echo ($user->status == 1) ? __('Disable', 'wp-job-portal') : __('Enable', 'wp-job-portal'); ?>
            </a>
            <a class="wpjobportal-user-act-btn" href="<?php echo admin_url('admin.php?page=wpjobportal_user&wpjobportallt=changerole&wpjobportalid='.$user->id); ?>" title="<?php echo __('change role', 'wp-job-portal') ?>">
            	<?php echo __('Change Role', 'wp-job-portal') ?>
            </a>
        </div>

		<?php
		break;
	
	default:
		# code...
		break;
}
?>