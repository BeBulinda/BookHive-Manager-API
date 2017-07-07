<?php
// Before anything is sent, set the appropriate header
header('Content-Type: text/html; charset=UTF-8');
date_default_timezone_set("Africa/Nairobi");
?>
<?php
require_once("dbcontroller.php");
$db_handle = new DBController();
$query = "SELECT * FROM counties";
$results = $db_handle->runQuery($query);
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="stylesheet" href="web/css/bootstrap.min.css" />
        <link rel="stylesheet" href="web/css/bootstrap-responsive.min.css" />
        <link rel="stylesheet" href="web/css/uniform.css" />
        <link rel="stylesheet" href="web/css/select2.css" />
        <link rel="stylesheet" href="web/css/fullcalendar.css" />
        <link rel="stylesheet" href="web/css/matrix-style.css" />
        <link rel="stylesheet" href="web/css/matrix-media.css" />
        <link href="web/web/font-awesome/css/font-awesome.css" rel="stylesheet" />
        <link rel="stylesheet" href="css/jquery.gritter.css" />
        <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700,800' rel='stylesheet' type='text/css'>
        <!--Show Hide fields-->
        <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
        <script src="web/js/filters.js"></script>
        <!--Show Hide fields END-->
        <!--Listing FILTER-->
        <script src="https://code.jquery.com/jquery-2.1.1.min.js" type="text/javascript"></script>
        <script>
            function getState(val) {
                $.ajax({
                    type: "POST",
                    url: "http://localhost/bookhive_ui/core/template/get_state.php",
                    data: 'county_id=' + val,
                    success: function (data) {
                        $("#county-list").html(data);
                    }
                });
            }
            function getLocation(val) {
                $.ajax({
                    type: "POST",
                    url: "http://localhost/bookhive_ui/core/template/get_location.php",
                    data: 'location_id=' + val,
                    success: function (data) {
                        $("#location-list").html(data);
                    }
                });
            }
        </script>
        <!--Listing FILTER END-->
        <?php
        /*         * *
         * This section specifies the page header
         */

        // The page title
        if ($templateResource = TemplateResource::getResource('title')) {
            ?>
            <title><?php echo $templateResource; ?></title>
        <?php } ?>	
        <!-- Basic CSS -->
        <!-- End of basic CSS -->
        <?php
        // The CSS included
        if ($templateResource = TemplateResource::getResource('css')) {
            ?>
            <!-- Additional CSS -->
            <?php
            foreach ($templateResource as $style) {
                $style = "web/$style";
                ?>
                <link rel="stylesheet" href="<?php echo $style; ?>" />
                <?php
            }
            ?>
            <!-- Additional CSS end -->
            <?php
        }
        ?>

        <!-- Favicon and touch icons -->


    </head>
    <!--    <body>-->

    <body class="skin-black">

        <?php
        if (App::isLoggedIn()) {
            require_once "header.php";
            require_once "modules/menus/main_sidebar.php";
        }
        require_once $currentPage;
        if (App::isLoggedIn()) {
            require_once "footer.php";
        }
        ?>

        <!-- Basic scripts -->  
        <script src="web/js/excanvas.min.js"></script> 
        <script src="web/js/jquery.min.js"></script> 
        <script src="web/js/jquery.ui.custom.js"></script> 
        <script src="web/js/bootstrap.min.js"></script> 
        <script src="web/js/jquery.flot.min.js"></script> 
        <script src="web/js/jquery.flot.resize.min.js"></script> 
        <script src="web/js/jquery.peity.min.js"></script> 
        <script src="web/js/fullcalendar.min.js"></script> 
        <script src="web/js/matrix.js"></script> 
        <script src="web/js/matrix.dashboard.js"></script> 
        <script src="web/js/jquery.gritter.min.js"></script> 
        <script src="web/js/matrix.interface.js"></script> 
        <script src="web/js/matrix.chat.js"></script> 
        <script src="web/js/jquery.validate.js"></script> 
        <script src="web/js/matrix.form_validation.js"></script> 
        <script src="web/js/jquery.wizard.js"></script> 
        <script src="web/js/jquery.uniform.js"></script> 
        <script src="web/js/select2.min.js"></script> 
        <script src="web/js/matrix.popover.js"></script> 
        <script src="web/js/jquery.dataTables.min.js"></script> 
        <script src="web/js/matrix.tables.js"></script>

        <script type="text/javascript">
            // This function is called from the pop-up menus to transfer to
            // a different page. Ignore if the value returned is a null string:
            function goPage(newURL) {

                // if url is empty, skip the menu dividers and reset the menu selection to default
                if (newURL != "") {

                    // if url is "-", it is this page -- reset the menu:
                    if (newURL == "-") {
                        resetMenu();
                    }
                    // else, send page to designated URL            
                    else {
                        document.location.href = newURL;
                    }
                }
            }

            // resets the menu selection upon entry to this page:
            function resetMenu() {
                document.gomenu.selector.selectedIndex = 2;
            }
        </script>
        <!-- End of basic scripts -->



        <?php
        /*         * *
         * Specify the scripts that are to be added.
         */
        if ($templateResource = TemplateResource::getResource('js')) {
            ?>
            <!-- Additional Scripts -->
            <?php
            foreach ($templateResource as $js) {
                $js = "web/$js";
                ?>
                <script src="<?php echo $js; ?>"></script>
                <?php
            }
            ?>
            <?php
        }
        ?>
        <?php if (!App::isLoggedIn()) { ?>
            <script>
                jQuery(document).ready(function () {
                    App.initLogin();
                });
            </script>
        <?php } else { ?>
            <script>
                jQuery(document).ready(function () {
                    // initiate layout and plugins
                    App.init();
                    //App.setMainPage(true);

                });
            </script>
            <?php
        }
        ?>
    </body>
</html>
