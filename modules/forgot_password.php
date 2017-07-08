<?php
require_once WPATH . "modules/classes/Users.php";
$users = new Users();

if (!empty($_POST)) {
    $success = $users->execute();
    if (is_bool($success) && $success == true) {
        $_SESSION['update_pass_forgot'] = true;
    } else {
        $_SESSION['update_pass_forgot'] = false;
    }
}

if (isset($_SESSION['update_pass_forgot']) AND ($_SESSION['update_pass_forgot'] == false)) {
    ?>
    <div class="alert alert-block alert-error fade in">
        <button type="button" class="close" data-dismiss="alert">×</button>
        <strong>Sorry, there was an error updating your password. Please confirm your email address and try the update process again.</strong>
    </div>
    <?php
    unset($_SESSION['update_pass_forgot']);
} else if (isset($_SESSION['update_pass_forgot']) AND ($_SESSION['update_pass_forgot'] == true)) {
     App::redirectTo("?login");
}

?> 

<div id="content">
    <div class="content-page">
        <div class="container">
            <div class="contact-form-page">
                <div class="form-contact">
                    <div class="col-md-6">
                        <h4>BOOKHIVE PASSWORD | <b>RECOVERY</h4>
                        <form method="post">
                            <input type="hidden" name="action" value="forgot_password"/>
                            <div class="row">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="controls">
                                        <input  type="email" name="email"  placeholder="Email">
                                    </div>
                                </div>                         
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <input type="submit" value="Reset Password" />
                                </div>
                            </div>
                        </form>
                        <h5><a href="?login">Just Login!</a></h5>
                    </div>
                </div>
            </div>
            <?php // require_once 'modules/inc/contact-details.php';  ?>
        </div>
    </div>
</div>
<!-- End Content -->
