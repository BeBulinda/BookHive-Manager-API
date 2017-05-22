<?php
require_once WPATH . "modules/classes/Users.php";
$users = new Users();

if (!empty($_POST)) {
    $success = $users->execute();
    if (is_bool($success) && $success == true) {
        $user_details = $users->fetchLoggedInUserDetails($_SESSION['userid']);
        if ($user_details['status'] == 1) {
            $_SESSION['account_blocked'] = true;
        }
        if ($user_details['password_new'] == 0) {
            App::redirectTo("?update_password");
        }
        App::redirectTo("?dashboard");
    }
}
?>

<div class="background-image"></div>


<div class="templatemo-content-widget templatemo-login-widget white-bg">
    <header class="text-center">
        <h1><a href="?dashboard" class="logo"><img style="margin-bottom: 30px;" src="img/branding/logo-innovators.png" width="160"></a></h1>
        <h5>Welcome to the future of African crowd-funding/financing!</h5>
    </header>
    
     <?php if (isset($_SESSION['login_error'])) { ?>
            <div class="alert alert-error">
                <h4>Login Error:</h4>
                <p>Wrong username/password combination</p>
            </div>
            <?php
            unset($_SESSION['login_error']);
        }
        if (isset($_SESSION['account_blocked'])) {
            ?>
            <div class="alert alert-error">
                <h4>Login Error</h4>
                <p>Your Account Has been Deactivated please contact <a href="mailto:info@reflexconcepts.com">info@reflexconcepts.co.ke</a></p>
            </div>
            <?php
            unset($_SESSION['account_blocked']);
        }
        ?>     
    
    <form class="templatemo-login-form" method="POST">
        <input type="hidden" name="action" value="login">
        <div class="form-group">
            <div class="input-group">
                <div class="input-group-addon"><i class="fa fa-user fa-fw"></i></div>	        		
                <input type="text" class="form-control" placeholder="rc@staqpesa.com" name="username" required/>           
            </div>	
        </div>
        <div class="form-group">
            <div class="input-group">
                <div class="input-group-addon"><i class="fa fa-key fa-fw"></i></div>	        		
                <input type="password" class="form-control" name="password" placeholder="******" required/>           
            </div>	
        </div>	          	
        <div class="form-group">
            <div class="checkbox squaredTwo">
                <input type="checkbox" id="c1" name="cc" />
                <label for="c1"><span></span>Remember me</label>
            </div>				    
        </div>
        <div class="form-group">
            <button type="submit" class="templatemo-blue-button width-100">Login</button>
        </div>
    </form>
</div>
<div class="templatemo-content-widget templatemo-login-widget templatemo-register-widget white-bg">
    <p>Not a registered user yet? <strong><a href="#" class="blue-text">Sign up now!</a></strong></p>
</div>  


        <!--            
                    <p style="margin-top: 40px;">Powered by: <a href="http://reflexconcepts.co.ke" target="_blank">
                            <img style="vertical-align: -8px;" src="web/images/reflex_logo.png" width="70"></a></p>-->