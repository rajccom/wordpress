<?php
/**
* @param WP JOB PORTAL --Packages
* @param Current Package Detail's
*/
?>
<?php if(isset($package)){ 
     if (wpjobportal::$theme_chk == 1) { ?>
    <div class="wpj-jp-pkg-list">
        <div class="wpj-jp-pkg-list-top">
            <div class="wpj-jp-pkg-list-title">
                <h4 class="wpj-jp-pkg-list-title-txt">
                    <?php echo sprintf(__('%s','job-portal'), $package->title); ?>
                </h4>
            </div>
        </div>
        <div class="wpj-jp-pkg-list-mid">
            <?php if(isset($package)){?>
                <div class="wpj-jp-pkg-list-data">
                    <span class="wpj-jp-pkg-list-laebl">
                        <?php echo esc_html__("Total Resume","job-portal")." : "; ?>
                    </span>
                    <?php echo $package->resume==-1 ? esc_html__('Unlimited','wp-job-portal') : sprintf(__('%s','wp-job-portal'), $package->resume); ?>
                </div>
                <div class="wpj-jp-pkg-list-data">
                    <span class="wpj-jp-pkg-list-laebl">
                        <?php echo esc_html__("Remaining Resume","job-portal")." : "; ?>
                    </span>
                    <?php echo $package->resume==-1 ? esc_html__('Unlimited','wp-job-portal') : sprintf(__('%s','wp-job-portal'), $package->remresume); ?>
                </div>
            <?php } ?>
        </div>
        <div class="wpj-jp-pkg-list-btm">
            <div class="wpj-jp-pkg-list-action-wrp">
                <a class="wpj-jp-outline-btn" title="<?php echo esc_attr__('change package', "job-portal"); ?>" href="<?php echo esc_url(wpjobportal::makeUrl(array('wpjobportalme'=>'multiresume','wpjobportallt'=>'addresume'))); ?>">
                    <?php echo esc_html__("Change Package", "job-portal") ?>
                </a>
            </div>
            <div class="wpj-jp-pkg-list-exp-date">
                <?php echo esc_html__('Ends On','job-portal').': '.date_i18n(wpjobportal::$_configuration['date_format'],strtotime($package->enddate)); ?> 
            </div>        
        </div>
    </div>
<?php } else { ?>
    <div class="wjportal-packages-list">
        <div class="wjportal-pkg-list-item">
            <div class="wjportal-pkg-list-item-top">
                <div class="wjportal-pkg-list-item-title">
                    <div class="wjportal-pkg-list-item-title-txt">
                        <?php echo __(esc_html($package->title),'wp-job-portal'); ?>
                    </div>
                </div>
            </div>
            <div class="wjportal-pkg-list-item-mid">
                <?php if(isset($package)){?>
                    <div class="wjportal-pkg-list-item-data">
                        <div class="wjportal-pkg-list-item-row">
                            <span class="wjportal-pkg-list-item-row-tit">
                                <?php echo esc_html(__('Total Resume','wp-job-portal')). ' : '; ?>
                            </span>
                            <span class="wjportal-pkg-list-item-row-val">
                                <?php echo ($package->resume==-1 ? esc_html(__('Unlimited','wp-job-portal')) : __($package->resume,'wp-job-portal')); ?>
                            </span>
                        </div>
                        <div class="wjportal-pkg-list-item-row">
                            <span class="wjportal-pkg-list-item-row-tit">
                                <?php echo esc_html(__('Remaining Resume','wp-job-portal')). ' : '; ?>
                            </span>
                            <span class="wjportal-pkg-list-item-row-val">
                                <?php echo ($package->resume==-1 ? esc_html(__('Unlimited','wp-job-portal')) : __($package->remresume,'wp-job-portal')); ?>
                            </span>
                        </div>
                    </div>
                <?php } ?>
            </div>
            <div class="wjportal-pkg-list-item-btm">
                <div class="wjportal-pkg-list-item-action-wrp">
                    <a href="<?php echo esc_url(wpjobportal::makeUrl(array('wpjobportalme'=>'multiresume','wpjobportallt'=>'addresume'))); ?>" class="wjportal-pkg-list-item-act-btn" title="<?php echo esc_attr(__('Change package','wp-job-portal')); ?>">
                        <?php echo esc_html(__('Change Package','wp-job-portal')); ?>
                    </a>
                </div>
                <div class="wjportal-pkg-list-item-exp-date">
                    <?php echo esc_html(__('Ends On','wp-job-portal')).': '.date_i18n(wpjobportal::$_configuration['date_format'],strtotime($package->enddate)); ?>
                </div>
            </div>
        </div>
    </div>
<?php }
} ?>
