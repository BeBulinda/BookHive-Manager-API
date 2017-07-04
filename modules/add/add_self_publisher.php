<?php
if (!App::isLoggedIn()) App::redirectTo("?");
require_once WPATH . "modules/classes/Users.php";
$users = new Users();
if (!empty($_POST)) {
    $success = $users->execute();
    if (is_bool($success) && $success == true) {
        $_SESSION['add_success'] = true;
    }
    App::redirectTo("?view_self_publishers");
}
?>

<div id="content">
    <div id="content-header">
        <div id="breadcrumb"> <a href="?home" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="?view_self_publishers">Publishers</a> <a href="?add_self_publisher" class="current">Add Self Publisher</a> </div>
        <h1>Add Self Publisher</h1>
    </div>
    <div class="container-fluid"><hr>
        <div class="row-fluid">
            <div class="span12">
                <div class="widget-box">          
                    <div class="widget-content nopadding">
                        <form class="form-horizontal" method="post" name="basic_validate" id="basic_validate" novalidate="novalidate">
                            <input type="hidden" name="action" value="add_self_publisher"/>
                            <input type="hidden" name="createdby" value="<?php echo 01; //  echo $_SESSION['userid'];     ?>"/>
                            <div class="control-group">
                                <label class="control-label">Firstname</label>
                                <div class="controls">
                                    <input type="text" name="firstname" id="firstname">
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Lastname</label>
                                <div class="controls">
                                    <input type="text" name="lastname" id="lastname">
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">ID/Passport Number</label>
                                <div class="controls">
                                    <input type="text" name="idnumber" id="idnumber">
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Gender</label>
                                <div class="controls">
                                    <select name="gender">
                                        <option value="male">Male</option>
                                        <option value="female">Female</option>
                                    </select>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Phone Number</label>
                                <div class="controls">
                                    <input type="text" name="phone_number" id="phone_number">
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Email Address</label>
                                <div class="controls">
                                    <input type="text" name="email" id="email">
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Description</label>
                                <div class="controls">
                                    <textarea class="span11" name="description" id="description"></textarea>
                                </div>
                            </div>
                            <div class="form-actions">
                                <input type="submit" value="Save" class="btn btn-success">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>    
    </div>
</div>