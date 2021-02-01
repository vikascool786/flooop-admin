<?php
defined('BASEPATH') OR exit('No direct script access allowed');

?>

            <footer class="main-footer">
                <div class="pull-right hidden-xs">
                    <b><?php echo lang('footer_version'); ?></b> Development
                </div>
                <strong><?php echo lang('footer_copyright'); ?> &copy; <?php echo date('Y'); ?> Proudly created with <i class="fa fa-heart red"></i> by <a href="https://www.answebtechnologies.in" target="_blank">ANS Web Technologies</a>.</strong> <?php echo lang('footer_all_rights_reserved'); ?>.
            </footer>
        </div>

        <script src="<?php echo base_url($frameworks_dir . '/bootstrap/js/bootstrap.min.js'); ?>"></script>
        <script src="<?php echo base_url($plugins_dir . '/slimscroll/slimscroll.min.js'); ?>"></script>
<?php if ($mobile == TRUE): ?>
        <script src="<?php echo base_url($plugins_dir . '/fastclick/fastclick.min.js'); ?>"></script>
<?php endif; ?>
<?php if ($admin_prefs['transition_page'] == TRUE): ?>
        <script src="<?php echo base_url($plugins_dir . '/animsition/animsition.min.js'); ?>"></script>
<?php endif; ?>
<?php if ($this->router->fetch_class() == 'users' && ($this->router->fetch_method() == 'create' OR $this->router->fetch_method() == 'edit')): ?>
        <script src="<?php echo base_url($plugins_dir . '/pwstrength/pwstrength.min.js'); ?>"></script>
<?php endif; ?>
<?php if ($this->router->fetch_class() == 'groups' && ($this->router->fetch_method() == 'create' OR $this->router->fetch_method() == 'edit')): ?>
        <script src="<?php echo base_url($plugins_dir . '/tinycolor/tinycolor.min.js'); ?>"></script>
        <script src="<?php echo base_url($plugins_dir . '/colorpickersliders/colorpickersliders.min.js'); ?>"></script>
<?php endif; ?>
        <script src="<?php echo base_url($frameworks_dir . '/adminlte/js/adminlte.min.js'); ?>"></script>
        <script src="<?php echo base_url($frameworks_dir . '/domprojects/js/dp.min.js'); ?>"></script>
        <script src="<?php echo base_url($frameworks_dir . '/datatables/datatables.min.js'); ?>"></script>
        <script src="<?php echo base_url($frameworks_dir . '/uploadifive/jquery.uploadifive.min.js'); ?>"></script>
        <script src="<?php echo base_url($frameworks_dir . '/toast/toastr.min.js'); ?>"></script>
    </body>
</html>