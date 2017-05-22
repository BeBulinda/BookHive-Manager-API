<div class="wrapper row-offcanvas row-offcanvas-left">
    <?php require_once('modules/menus/main_sidebar.php'); ?>

    <aside class="right-side">

        <!-- Main content -->
        <section class="content">
            <?php require_once('modules/menus/sub_menu_settings.php'); ?>
            <?php require_once('modules/sub_modules/overview.php'); ?>
            <!-- Main row -->
            <div class="row">
                <?php require_once('modules/sub_modules/graph.php'); ?>
                <?php require_once('modules/sub_modules/notifications.php'); ?>
            </div>

            <div class="row">
                <?php require_once('modules/sub_modules/working_progress.php'); ?>
                <?php require_once('modules/sub_modules/team_mates.php'); ?>
            </div>

            <div class="row">
                <?php require_once('modules/sub_modules/new.php'); ?>
                <?php require_once('modules/sub_modules/new2.php'); ?>
            </div>
            <div class="row">
                <?php require_once('modules/sub_modules/privileges.php'); ?>
                <?php require_once('modules/sub_modules/system_components.php'); ?>
            </div>

            <!-- row end -->

        </section><!-- /.content -->

    </aside><!-- /.right-side -->
</div>