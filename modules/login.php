<?php
require_once WPATH . "modules/classes/Users.php";
$users = new Users();

if (!empty($_POST)) {
    $success = $users->execute();
    if (is_bool($success) && $success == true) {
        if ($_SESSION['logged_in_user_details']['status'] == 1) {
            $_SESSION['account_blocked'] = true;
        }
        if ($_SESSION['logged_in_user_details']['password_new'] == 0) {
            App::redirectTo("?update_password");
        }
        App::redirectTo("?dashboard");
    }
}

if (isset($_SESSION['update_pass_forgot']) AND ($_SESSION['update_pass_forgot'] == true)) {
    ?>
    <div class="alert alert-block alert-error fade in">
        <button type="button" class="close" data-dismiss="alert">×</button>
        <strong>Password successfully updated. Please check your email for the updated login credentials.</strong>
    </div>
    <?php
    unset($_SESSION['update_pass_forgot']);
} 

if (isset($_SESSION['login_error'])) {
    ?>
    <div class="alert alert-block alert-error fade in">
        <button type="button" class="close" data-dismiss="alert">×</button>
        <strong>Login Error : Wrong username/password combination</strong>
    </div>
    <?php
    unset($_SESSION['login_error']);
}
if (isset($_SESSION['account_blocked'])) {
    ?>
    <div class="alert alert-block alert-error fade in">
        <button type="button" class="close" data-dismiss="alert">×</button>
        <strong>Login Error : Your Account Has been Deactivated please contact <a href="mailto:hello@bookhivekenya.com">hello@bookhivekenya.com</a></strong>
    </div>
    <?php
    unset($_SESSION['account_blocked']);
}
?> 

<div id="content">
    <div class="content-page">
        <div class="container">
            <div class="contact-form-page">
                <div class="form-contact">
                    <div class="col-md-6">
                        <h2>SIGN IN</h2>
                        <form method="post">
                            <input type="hidden" name="action" value="login"/>
                            <div class="row">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="controls">
                                        <input  type="text" name="username"  placeholder="Email">
                                    </div>
                                </div>
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <input type="password" name="password" placeholder="Password">
                                </div>                                
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <input type="submit" value="Sign In" />
                                </div>
                            </div>
                        </form>
                        <h5><a href="?forgot_password">Forgot Password?</a></h5>
                    </div>
                </div>
            </div>
            <?php // require_once 'modules/inc/contact-details.php';  ?>
        </div>
    </div>
</div>
<!-- End Content -->
