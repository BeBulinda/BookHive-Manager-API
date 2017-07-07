<?php
if (!App::isLoggedIn()) App::redirectTo("?");
require_once WPATH . "modules/classes/Users.php";
require_once WPATH . "modules/classes/System_Administration.php";
$system_administration = new System_Administration();
$users = new Users();

if (!empty($_POST)) {
    $_SESSION['staff_firstname'] = $_POST['firstname'];
    $_SESSION['staff_lastname'] = $_POST['lastname'];
    $_SESSION['staff_gender'] = $_POST['gender'];
    $_SESSION['staff_idnumber'] = $_POST['idnumber'];
//    $_SESSION['staff_publisher'] = $_POST['publisher'];
//    $_SESSION['staff_role'] = $_POST['role'];
    $_SESSION['staff_position'] = $_POST['position'];
    $_SESSION['user_type'] = 'STAFF';

    if (isset($_SESSION['staff_firstname'])) {
        App::redirectTo("?add_contact&ref_type=" . $_SESSION['user_type']);
    }
}
?>

<div id="content">
    <div id="content-header">
        <div id="breadcrumb"> <a href="?home" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="?view_staff">Staff Members</a> <a href="?add_staff" class="current">Add Staff Member</a> </div>
        <h1>Add Staff Member</h1>
    </div>
    <div class="container-fluid"><hr>
        <div class="row-fluid">
            <div class="span12">
                <div class="widget-box">          
                    <div class="widget-content nopadding">
                        <form class="form-horizontal" method="post" name="basic_validate" id="basic_validate" novalidate="novalidate">
                            <input type="hidden" name="action" value="add_staff_member"/>
                            <input type="hidden" name="createdby" value="<?php echo 01; //  echo $_SESSION['userid'];     ?>"/>

                            <div class="control-group">
                                <label class="control-label">First Name</label>
                                <div class="controls">
                                    <input type="text" name="firstname" id="firstname">
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Last Name</label>
                                <div class="controls">
                                    <input type="text" name="lastname" id="lastname">
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Gender</label>
                                <div class="controls">
                                    <select name="gender" id="gender">
                                        <option>Male</option>
                                        <option>Female</option>
                                    </select>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">ID/Passport Number</label>
                                <div class="controls">
                                    <input type="text" name="idnumber" id="idnumber">
                                </div>
                            </div>
                            
<!--                            <div class="control-group">
                                <label class="control-label">Publisher</label>
                                <div class="controls">
                                    <select name="publisher" id="publisher">
                                        <?php // echo $users->getPublishers(); ?>
                                    </select>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Role</label>
                                <div class="controls">
                                    <select name="role" id="role">
                                        <?php // echo $system_administration->getRoles(); ?>
                                    </select>
                                </div>
                            </div>-->
                            
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